<?php

class CargoController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    static $_permissionControl = array(
        'read' => 'Consulta de Cargos',
        'write' => 'Consulta de Cargos',
        'label' => 'Consulta de Cargos'
    );

    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
//'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {

// en este array colocar solo los action de consulta
        return array(
            array('allow',
                'actions' => array('index', 'view', 'admin'),
                'pbac' => array('read', 'write'),
            ),
            // en este array sólo van los action de actualizacion a BD
            array('allow',
                'actions' => array('create', 'update', 'borrar', 'habilitar', 'activar'),
                'pbac' => array('write'),
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
    public function actionView($id) {
        $id = base64_decode($id);
        if (isset($id)) {
            $this->renderPartial('view', array(
                'model' => $this->loadModel($id),
            ));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Cargo;

        if ($model) {

            if (isset($_POST['Cargo'])) {
                $model->attributes = $_POST['Cargo'];
                $nombre = trim($_POST['Cargo']['nombre']);
                $nombre = strtoupper($nombre);
                $model->nombre = $nombre;
                $model->usuario_ini_id = Yii::app()->user->id;
                $model->fecha_ini = date("Y-m-d H:i:s");
                $model->fecha_act = date("Y-m-d H:i:s");
                $model->estatus = "A";

                if ($model->validate()) {
                    if ($model->save()) {
                        $this->registerLog(
                                "ESCRITURA", "create", "Exitoso", "Se creo un Cargo"
                        );
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Exito! ya puede realizar otro registro.'));
                        $model = new Cargo;
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                }
            }
        } else {

            throw new CHttpException(404, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
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
        $id = $_REQUEST['id'];
        $id = base64_decode($id);
        $model = $this->loadModel($id);

        if (isset($_POST['Cargo'])) {
            $model->attributes = $_POST['Cargo'];
            $nombre = trim($_POST['Cargo']['nombre']);
            $nombre = strtoupper($nombre);
            $model->nombre = $nombre;
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            $model->estatus = "A";

            if ($model->validate()) {
                if ($model->save()) {
                    $this->registerLog(
                            "ACTUALIZACION", "update", "Exitoso", "actualizo un Cargo"
                    );
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            }
        }

        $this->renderPartial('update', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $groupId = Yii::app()->user->group;

        $model = new Cargo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Cargo']))
            $model->attributes = $_GET['Cargo'];

        $usuarioId = Yii::app()->user->id;
        $this->registerLog(
                "LECTURA", "index", "Exitoso", "Ingreso a Cargo"
        );
        $dataProvider = new CActiveDataProvider('Cargo');
        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Cargo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Cargo']))
            $model->attributes = $_GET['Cargo'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Cargo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Cargo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Inactiva una modalidad en particular.
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
                if ($model->save()) {
                    $this->registerLog(
                            "INACTIVAR", "borrar", "Exitoso", "Inactivo un Cargo"
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

    /**
     * Reactiva una modalidad en particular
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
                            "ACTIVAR", "activar", "Exitoso", "activo un Cargo"
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
     * Devuelve las columnas con las acciones posibles
     * @param type $data
     * @return string
     */
    public function columnaAcciones($data) {
        $id = $data["id"];
        $id = base64_encode($id);
        if ($data->estatus == "E") {
            $columna = CHtml::link("", "", array("class" => "fa fa-search", "title" => "Buscar este Cargo", "onClick" => "VentanaDialog('$id','/catalogo/cargo/view','Cargo','view')")) . '&nbsp;&nbsp;';

            if (Yii::app()->user->group == 1) {
                $columna .= CHtml::link("", "", array("class" => "fa fa-check green", "title" => "Activar este Cargo", "onClick" => "VentanaDialog('$id','/catalogo/cargo/activar','Activar Cargo','activar')")) . '&nbsp;&nbsp;';
            }
        } else {

            $columna = CHtml::link("", "", array("class" => "fa fa-search", "title" => "Buscar este Cargo", "onClick" => "VentanaDialog('$id','/catalogo/cargo/view','Cargo','view')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa fa-pencil green", "title" => "Modificar este Cargo", "onClick" => "VentanaDialog('$id','/catalogo/cargo/update','Modificar Cargo','update')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa fa-trash-o red", "title" => "Inhabilitar este Cargo", "onClick" => "VentanaDialog('$id','/catalogo/cargo/borrar','Inactivar Cargo','borrar')")) . '&nbsp;&nbsp;';
        }
        return $columna;
    }

    /**
     *  funcion para devolver el esatatus segun las iniciales A y E
     * @param type $data registro del modelo
     * @return string el estatus del registro
     */
    public function estatus($data) {
        $columna='';
        $estatus = $data["estatus"];

        if ($estatus == "E") {
            $columna = "Inactivo";
        } else if ($estatus == "A") {
            $columna = "Activo";
        }
        return $columna;
    }

    /**
     * Performs the AJAX validation.
     * @param Cargo $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cargo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
