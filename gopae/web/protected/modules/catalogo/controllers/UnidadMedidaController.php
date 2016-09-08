<?php

class UnidadMedidaController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    static $_permissionControl = array(
        'read' => 'Consulta de Unidad de Medida',
        'write' => 'Creacion y Modificacion de Unidad de Medida',
        'admin' => 'Eliminación y Activacion de Unidad de Medida',
        'label' => 'Consulta de Unidad de Medida'
    );

    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {

        // en este array colocar solo los action de consulta
        return array(
            array('allow',
                'actions' => array('index', 'view', 'admin'),
                'pbac' => array('read', 'write'),
            ),
            // en este array sólo van los action de actualizacion a BD
            array('allow',
                'actions' => array('create', 'update'),
                'pbac' => array('write'),
            ),
            array('allow',
                'actions' => array('borrar', 'activar'),
                'pbac' => array('admin'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView() {
        $id = base64_decode($_GET['id']);
        $this->renderPartial('_view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new UnidadMedida;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['UnidadMedida'])) {
            $model->attributes = $_POST['UnidadMedida'];
            
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = "A";

            if($model->validate()){
                if ($model->save()) {
                    $this->registerLog(
                            "ESCRITURA", "create", "Exitoso", "Se creo una unidad de medida"
                    );
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Exito! ya puede realizar otro registro.'));
                    $model = new UnidadMedida;
                }
            }

        }

        $this->renderPartial('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
       
        $id = base64_decode($_POST['id']);
        $model = $this->loadModel($id);
        
        if (isset($_POST['UnidadMedida'])) {
            $model->attributes = $_POST['UnidadMedida'];
            
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            
            if($model->validate()){
                if ($model->update()) {
                    $this->registerLog(
                            "ESCRITURA", "update", "Exitoso", "Se edito una unidad de medida"
                    );
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Modificado con Exito!.'));
                }
            }
        }  
        $this->renderPartial('update', array(
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
     * Lists all models.
     */
    public function actionIndex() {
        $model = new UnidadMedida('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UnidadMedida']))
            $model->attributes = $_GET['UnidadMedida'];

        $dataProvider = new CActiveDataProvider('UnidadMedida');

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new UnidadMedida('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UnidadMedida']))
            $model->attributes = $_GET['UnidadMedida'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UnidadMedida the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UnidadMedida::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UnidadMedida $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'unidad-medida-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     *  funcion para devolver el esatatus segun las iniciales A y E
     * @param type $data registro del modelo
     * @return string el estatus del registro
     */
    public function estatus($data) {
        $estatus = $data["estatus"];

        if ($estatus == "E") {
            $columna = "Inactivo";
        } else if ($estatus == "A") {
            $columna = "Activo";
        }
        return $columna;
    }

    /**
     * Devuelve las columnas con las acciones posibles
     * @param type $data
     * @return string
     */
    public function columnaAcciones($data) {
        $id = $data["id"];
        $id = base64_encode($id);

        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';


        if ($data->estatus == "E") {
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "#", array("class" => "fa fa-search blue", "title" => "Buscar esta Unidad Medida", "onClick" => "VentanaDialog('$id','/catalogo/unidadMedida/view','Unidad de Medida','view')")) . '</6i>';
            if (Yii::app()->user->group == 1) {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Activar </span>", "#", array("class" => "fa fa-check green", "title" => "Activar esta Unidad Medida", "onClick" => "VentanaDialog('$id','/catalogo/unidadMedida/activar','Activar Unidad de Medida','activar')")) . '</li>';
            }
        } else {

            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "#", array("class" => "fa fa-search blue", "title" => "Buscar esta Unidad de Medida", "onClick" => "VentanaDialog('$id','/catalogo/unidadMedida/view','Unidad de Medida','view')")) . '</li>';
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar</span>", "#", array("class" => "fa fa-pencil green", "title" => "Modificar esta Unidad de Medida", "onClick" => "VentanaDialog('$id','/catalogo/unidadMedida/update','Modificar Unidad de Medida','update')")) . '</li>';
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar</span>", "#", array("class" => "fa fa-trash-o red", "title" => "Inactivar esta Unidad de Medida", "onClick" => "VentanaDialog('$id','/catalogo/unidadMedida/borrar','Inhabilitar Unidad de Medida','borrar')")) . '</li>';
        }

        $columna .= '</ul></div>';
        return $columna;
    }

    /**
     * Reactiva una clase de plantel en particular
     * @params integer $id del modelo que se va a reactivar
     */
    public function actionActivar() {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $id = base64_decode($id);

            $model = $this->loadModel($id);
            if ($model) {
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_act = date("Y-m-d H:i:s");
                $model->estatus = "A";
                if ($model->save()) {
                    $this->registerLog(
                            "ACTIVAR", "Activar", "Exitoso", "Se reactivo una unidad de medida"
                    );
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Habilitado con exito.'));
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else {

                throw new CHttpException(404, 'Error! Recurso no encontrado!');
            }
        }
    }

    /**
     * Inactiva una unidad de medida en particular.
     * @param integer $id de la modalidad a inactivar
     */
    public function actionBorrar() {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $id = base64_decode($id);

            $model = $this->loadModel($id);
            if ($model) {
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_elim = date("Y-m-d H:i:s");
                $model->estatus = "E";

                if ($model->update()) {
                    $this->registerLog(
                            "INACTIVAR", "borrar", "Exitoso", "Inactivo una unidad de medida"
                    );
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Inactivado con exito.'));
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else {

                throw new CHttpException(404, 'Error! Recurso no encontrado!');
            }
        }
    }
  
}
