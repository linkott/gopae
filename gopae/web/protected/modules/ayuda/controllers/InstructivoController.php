<?php
class InstructivoController extends Controller {

    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Consulta de Instructivo',
        'write' => 'Creación y Modificacion de Instructivo',
        'admin' => 'Permite activar e inactivar un instructivo', // no lleva etiqueta write
        'label' => 'Consulta de Instructivo'
    );

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
                //'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view'),
                'pbac' => array('read'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'guardarArchivo', 'upload', 'activar', 'delete'),
                'pbac' => array('write'),
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
        $id = base64_decode($id);
        $this->renderPartial('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $id = $_GET['id'];
        $crear = 'crear';
        $model = new Instructivo;
        if (isset($_POST['Instructivo'])) {
            $model->descripcion = $_POST['Instructivo']['descripcion'];
            $descripcion = $model->descripcion;
            $model->attributes = $_POST['Instructivo'];
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = 'A';
            $model->url = (strlen(trim($_POST['nombreArchivo']))) ? "/public/uploads/instructivo/" . $_POST['nombreArchivo'] : '';
            //$model->url = 'http' ? $_POST['nombreArchivo']:'';
            if ($model->validate()) {
                if ($model->save()) {
                    $model->descripcion = $descripcion . ";" . trim(date('d-m-Y H:i:s')) . "/n";
                    $this->registerLog('ESCRITURA', 'ayuda.ticket.create', 'EXITOSO', 'Se ha creado un Instructivo. Nombre: '. $model->nombre . '. Descripción: ' . $model->descripcion.'. Archivo: '.$model->url.'.');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'El Registro del Ticket se ha completado satisfactoriamente.'));
                    $model = new Instructivo;
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else {
                $this->renderPartial('//errorSumMsg', array('model' => $model));
            }
        }
        $this->renderPartial('_form', array(
            'model' => $model, 'crear' => $crear,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $id = $_REQUEST['id'];
        $id = base64_decode($id);
        $model = $this->loadModel($id);
        if (isset($_POST['Instructivo'])) {
            $model->attributes = $_POST['Instructivo'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            if ($model->save())
                if ($model->validate()) {
                    if ($model->save()) {
                        $this->registerLog('ESCRITURA', 'ayuda.intructivo.create', 'EXITOSO', 'Se ha creado un Instructivo ahora puede crear otro');
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                        $model = $this->loadModel($id);
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                }
        }

        $this->renderPartial('_form', array(
            'model' => $model,
        ));
    }

    public function actionUpload() {
        // $options = null, $initialize = true, $error_messages = null, $filename=null, $id_model=''
        $upload_handler = new UploadHandler(null, true, null, date('YmdHis') . 'AT', "/public/uploads/instructivo/");
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $id = base64_decode($id);
            $model = $this->loadModel($id);
            if ($model) {
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_elim = date("Y-m-d H:i:s");
                $model->estatus = "E";
                if ($model->save()) {
                    $this->registrarTraza('Se Elimino Un Instructivo', 'Eliminado');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con exito.'));
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else {

                throw new CHttpException(404, 'Error! Recurso no encontrado!');
            }
        }
        //$this->render('borrar',array('model'=>$model,));
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        //if(!isset($_GET['ajax']))
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function columnaObservacion($registro) {
        $resultado = '';
        $descripcion = CHtml::encode($registro['descripcion']);
        $resultado = '<span title="'.$descripcion.'">'.substr($descripcion, 0, 70) . '...</span>';
        return $resultado;
    }

    public function columnaNombre($registro) {
        $resultado = '';
        $descripcion = CHtml::encode($registro['nombre']);
        $resultado = '<span title="'.$descripcion.'">'.substr($descripcion, 0, 70) . '...</span>';
        return $resultado;
    }

    public function actionIndex() {

        $groupId = Yii::app()->user->group;

        $model = new Instructivo('search');

        if (isset($_GET['Instructivo'])){
            $model->attributes = $_GET['Instructivo'];
        }

        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('Instructivo');
        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $groupId = Yii::app()->user->group;
        $model = new Instructivo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Instructivo']))
            $model->attributes = $_GET['Instructivo'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Mencion the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Instructivo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function estatus($data) {
        $id = $data["estatus"];
        if ($id == 'A') {
            $columna = 'Activo';
        }

        if ($id == 'E') {
            $columna = 'Inactivo';
        }

        return $columna;
    }

    public function columnaAcciones($data) {
        $columna = '';
        $id = $data["id"];
        $estatus = $data["estatus"];
        $id = base64_encode($id);
        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';
        if ($estatus == "E" and Yii::app()->user->pbac('admin')) {
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Consultar Datos</span>", "", array("class" => "fa fa-search blue", "title" => "Consultar Datos", "onClick" => "VentanaDialog('$id','/ayuda/instructivo/view','Instructivo','view')")) . '</li>';
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Reactivar Instructivo</span>", "", array("class" => "fa fa-check green", "title" => "Reactivar Instructivo", "onClick" => "VentanaDialog('$id','/ayuda/instructivo/activar','activar Instructivo','activar')")) . '</li>';
        } else if ($estatus == "A") {
            if (Yii::app()->user->pbac('admin')){
                if ($data['url'] and Yii::app()->user->pbac('admin')) {
                    $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Descargar Archivo</span>",  $data['url'],  array("target" => "_blank", "class" => "fa fa-cloud-download orange", "title" => "Descargar Archivo")) . '</li>';
                }
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Ver Instructivo</span>", "", array("class" => "fa fa-search blue", "title" => "Ver Instructivo", "onClick" => "VentanaDialog('$id','/ayuda/instructivo/view','Instructivo','view')")) . '</li>';
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar Instructivo</span>", "", array("class" => "fa fa-pencil green", "title" => "Modificar Instructivo", "onClick" => "VentanaDialog('$id','/ayuda/instructivo/update','Modificar Instructivo','update')"))  . '</li>';
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar Instructivo</span>", "", array("class" => "fa icon-trash red", "title" => "Eliminar Instructivo", "onClick" => "VentanaDialog('$id','/ayuda/instructivo/borrar','Eliminar Instructivo','borrar')"))  . '</li>';
            } else if (Yii::app()->user->pbac('write') || Yii::app()->user->pbac('read')) {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Descargar Archivo</span>", $data['url'], array("target" => "_blank", "class" => "fa fa-cloud-download orange", "title" => "Descargar Archivo")) . '</li>';
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Ver Instructivo</span>", "", array("class" => "fa fa-search blue", "title" => "Ver Instructivo", "onClick" => "VentanaDialog('$id','/ayuda/instructivo/view','Instructivo','view')")) . '</li>';
            }
            
        }
          
        $columna .= '</ul></div>';
        return $columna;
            
    }

    public function actionActivar() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $id = base64_decode($id);
            $model = $this->loadModel($id);
            if ($model) {
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_elim = date("Y-m-d H:i:s");
                $model->estatus = "A";
                if ($model->save()) {
                    $this->registrarTraza('Se Activo un Instructivo', 'Activado');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Activado con exito.'));
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else {

                throw new CHttpException(404, 'Error! Recurso no encontrado!');
            }
        }
//$this->render('borrar',array('model'=>$model,));
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        //if(!isset($_GET['ajax']))
        //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */

    /**
     * Performs the AJAX validation.
     * @param Instructivo $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'instructivo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    static function registrarTraza($transaccion, $accion) {
        $Utiles = new Utiles();
        $modulo = "gmanual.InstructivoController" . $accion;
        $Utiles->traza($transaccion, $modulo, date('Y-m-d H:i:s'));
    }

     public function fechaIni($data) {
        $fecha_Ini = $data["fecha_ini"];
        if (empty($fecha_Ini)) {
            $fecha_Ini = "";
        } else {
            $fecha_Ini = date("d-m-Y", strtotime($fecha_Ini));
        }
        return $fecha_Ini;
    }

}
