<?php

class ProveedorAsignadoController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public $defaultAction = 'asignado';

    const MODULO = "Planteles.ProveedorAsignado";
    const REGISTRADO_ID = 2;

    static $_permissionControl = array(
        'read' => 'Permite consultar los proveedores asignados a este plantel',
        'write' => 'Permite asignar proveedores',
        'admin' => 'Permite asignar proveedores',
        'label' => 'Asignar Proveedores'
    );

    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {

        //en esta seccion colocar los action de solo lectura o consulta
        return array(
            array('allow',
                'actions' => array(
                    'index', 'consulta', 'create'
                ),
                'pbac' => array('read'),
            ),
            //en esta seccion colocar todos los action del modulo
            array('allow',
                'actions' => array(
                    'consulta',
                    'cambiarEstatus',
                    'agregarProveedor',
                    'eliminarProveedor',
                    'buscarProveedor'
                ),
                'pbac' => array('write', 'admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new PlantelProveedor;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['PlantelProveedor'])) {
            $model->attributes = $_POST['PlantelProveedor'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['PlantelProveedor'])) {
            $model->attributes = $_POST['PlantelProveedor'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new PlantelProveedor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PlantelProveedor']))
            $model->attributes = $_GET['PlantelProveedor'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function columnaAcciones($data) {
        $id = $data->id;

        $columna = CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar </span>", "", array("class" => "fa fa-trash-o red", "title" => "Eliminar este Proveedor", "onClick" => "eliminarProveedor($id)"));

        return $columna;
    }

    public function columnaAccionesProveedor($data) {

        $id = $data->id;

        $columna = CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Asignar </span>", "", array("class" => "fa fa-plus green", "title" => "Asignar como Proveedor", "onClick" => "asignarProveedor($id)"));

        return $columna;
    }

    public function actionCambiarEstatus() {

        $accion = $this->getPost('accion');
        $id = $this->getPost('id');
        $inscripcion_id = $this->getPost('inscripcion_id');

        if (in_array($accion, array('E', 'A'))) {

            $idDecoded = base64_decode($id);

            $estudiante = new Estudiante();

            if (is_numeric($idDecoded)) {

                $model = Estudiante::model()->findByPk($idDecoded);

                if ($model) {

                    $result = $estudiante->cambiarEstatusEstudiante($idDecoded, $accion, $inscripcion_id);

                    if ($result->isSuccess) {

                        if ($accion == 'E') {
                            $this->registerLog('ELIMINACION', 'planteles.matricula.CambiarEstatus', 'EXITOSO', 'Se ha Inactivado el Estudiante ' . $model->id);
                        } else {
                            $this->registerLog('ESCRITURA', 'planteles.matricula.CambiarEstatus', 'EXITOSO', 'Se ha Activado el Estudiante ' . $model->id);
                        }

                        $class = 'successDialogBox';
                        $message = $result->message;

                        $this->renderPartial('//msgBox', array(
                            'class' => $class,
                            'message' => $message,
                        ));
                    } else {
                        throw new CHttpException(500, 'Error: No se ha podido completar la operación, comuniquelo al administrador del sistema para su corrección.');
                    }
                } else {
                    throw new CHttpException(404, 'No se ha encontrado el Estudiante que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
                }
            } else {
                throw new CHttpException(404, 'No se ha encontrado el Estudiante que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
            }
        } else {
            $class = 'errorDialogBox';
            $message = 'No se ha especificado la acción a tomar sobre el estudiante, recargue la página e intentelo de nuevo.';

            $this->renderPartial('//msgBox', array(
                'class' => $class,
                'message' => $message,
            ));
        }
    }

    public function actionConsulta($id) {
        $idDecode = base64_decode($id);

        $dataProvider = new CActiveDataProvider('PlantelProveedor');
        $model = new PlantelProveedor('search');
        $modelProveedor = new Proveedor;
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['PlantelProveedor']))
            $model->attributes = $_GET['PlantelProveedor'];
        $data = Plantel::model()->obtenerDatosIdentificacion($idDecode);

        $this->render('admin', array(
            'dataProvider' => $dataProvider,
            'id' => $id,
            'model' => $model,
            'datosPlantel' => $data,
            'modelProveedor' => $modelProveedor
        ));
    }

    public function estatus($data) {
        $estatus = $data['estatus'];
        if (($estatus == 'A') || ($estatus == '')) {
            return 'Activo';
        } else if ($estatus == 'E') {
            return 'Inactivo';
        }
    }

    public function actionAgregarProveedor() {
        $model = new PlantelProveedor;

        $model->plantel_id = base64_decode($_POST['plantel_id']);
        $model->proveedor_id = base64_decode($_POST['proveedor_id']);
        $model->usuario_ini_id = Yii::app()->user->id;
        $model->fecha_ini = date("Y-m-d H:i:s");
        $model->estatus = "A";

        $modelProveedorRepetido = PlantelProveedor::model()->findByAttributes(array('plantel_id' => $model->plantel_id, 'proveedor_id' => $model->proveedor_id));
        $modelProveedorConProveedor = PlantelProveedor::model()->findByAttributes(array('plantel_id' => $model->plantel_id));
        if ($modelProveedorConProveedor) {
            $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Plantel ya posee un proveedor ( <b>' . $modelProveedorConProveedor->proveedor->razon_social . '</b> ) asignado.<br>Si desea asignar este proveedor, primero debe eliminar al proveedor que esta asignado.'));
        } else if ($modelProveedorRepetido) {
            $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'El Proveedor : <b>' . $modelProveedorRepetido->proveedor->razon_social . '</b> ya ha sido asignado.'));
        } else {

            if ($model->save()) {
                $log = "Agrego el proveedor con el id " . $model->id . " al plantel con el id " . $_POST['plantel_id'];
                $this->registerLog("ESCRITURA", "create", "Exitoso", $log);
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Asignación Exitosa.'));
            } else {
                $this->renderPartial('//errorSumMsg', array('model' => $model));
            }
        }
    }

    public function actionEliminarProveedor() {
        $model = PlantelProveedor::model()->findByPk(base64_decode($_POST['id']));
        if ($model) {
            $log = "Elimino el proveedor con el id " . $model->proveedor_id . " del plantel con el id " . $model->plantel_id;
            if ($model->delete()) {
                $this->registerLog("ESCRITURA", "create", "Exitoso", $log);
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminación Exitosa.'));
            } else {
                $this->renderPartial('//errorSumMsg', array('model' => $model));
            }
        }
    }

    public function actionBuscarProveedor() {


        if ($_POST["rif"]) {

            $rif = base64_decode($_POST["rif"]);
            //$razon_social = base64_decode($_POST["razon_social"]);
            //$estado_id = base64_decode($_POST["estado"]);
            //$tipo_empresa = base64_decode($_POST["tipo_empresa"]);

            $model = Proveedor::model()->findByAttributes(array('rif' => $rif,  'estatus' => 'A'));

            if ($model) {
                $data = new CActiveDataProvider($model, array(
                    'pagination' => array(
                        'pageSize' => 1,
                    ),
                        )
                );
                echo '<label><h5>Lista de Proveedores</h5></label>';
                $this->widget('zii.widgets.grid.CGridView', array(
                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                    'id' => 'proveedor-grid',
                    'dataProvider' => $data,
                    'summaryText' => false,
                    'pager' => array(
                        'header' => '',
                        'htmlOptions' => array('class' => 'pagination'),
                        'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                        'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                        'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                        'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                    ),
                    'columns' => array(
                        array(
                            'type' => 'raw',
                            'header' => '<center>rif</center>',
                            'value' => '$data->rif'
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>razon_social</center>',
                            'value' => '$data->razon_social'
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Tipo de Empresa</center>',
                            'value' => '$data->tipoEmpresa->nombre',
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>estado</center>',
                            'value' => '$data->estado->nombre',
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Acciones</center>',
                            'value' => array($this, 'columnaAccionesProveedor'),
                            'htmlOptions' => array('width' => '5%'),
                        )
                    ),
                ));
            } else {
                echo '<label><h5>Lista de Proveedores</h5></label>';
                echo '<br><br>';
                $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'No se encontro ningún proveedor con el rif :<b>'.$rif.'</b>'));
            }
        } else {
            echo '<label><h5>Lista de Proveedores</h5></label>';
            echo '<br><br>';
            $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => '<b>Error 404</b> No se encontro el recurso solicitado'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SeccionPlantel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PlantelProveedor::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SeccionPlantel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'seccion-plantel-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
