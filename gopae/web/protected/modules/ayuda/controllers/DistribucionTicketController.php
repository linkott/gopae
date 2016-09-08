<?php

class DistribucionTicketController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    static $_permissionControl = array(
        'read' => 'Consulta de Dsitribucion de Ticket',
        'write' => 'Gestion de Dsitribucion de Ticket',
        'label' => 'Módulo de Dsitribucion de Ticket'
    );

    /**
     * @Return array filtros de acción
     */
    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Especifica las reglas de control de acceso.
     * Este método es utilizado por el filtro 'AccessControl'.
     * Reglas de control de acceso a una matriz @ return
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view'),
                'pbac' => array('read', 'write'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'activar', 'delete'),
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

    public function estatus($data) {
        $estatus = '';
        $id = $data["estatus"];
        if ($id == 'A') {
            $estatus = 'Activo';
        }
        if ($id == 'E') {
            $estatus = 'Eliminado';
        }
        return $estatus;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $id = $_GET['id'];
        $actualizar=false;
        $model = new DistribucionTicket;
        $estados = Estado::model()->findAll(array('order' => "nombre ASC"));
        $tipoTicket = TipoTicket::model()->findAll(array('order' => "nombre ASC"));
        $unidadResponsable = UnidadRespTicket::model()->findAll(array('order' => "nombre ASC"));
        if (isset($_POST['DistribucionTicket'])) {
            $actualizar=true;
            //$model->attributes = $_POST['DistribucionTicket'];
            $model->estado_id = $_POST['estado'];
            $model->tipo_ticket_id = $_POST['tipo'];
            $model->unidad_resp_ticket_id=Yii::app()->getSession()->get('id');
            $model->telefono = $_POST['DistribucionTicket']['telefono'];
            $model->correo_electronico = $_POST['DistribucionTicket']['correo_electronico'];
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = 'A';
            //var_dump('estado'.$model->estado_id.'tipo'.$model->tipo_ticket_id.'unidaRes'.$model->unidad_resp_ticket_id.$model->telefono.$model->correo_electronico); die();
            if ($model->validate()) {
                if ($model->save()) {
                    $this->registerLog('ESCRITURA', 'ayuda.UnidadRespTicket.create', 'EXITOSO', 'Se ha creado un responsable de ticket, ahora puede crear otro');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'El Registro del unidadad responsable de ticket se ha creado con exito'));
                    $model = new DistribucionTicket;
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
            } else {
                throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
            }
        }
        $this->renderPartial('create', array(
            'model' => $model, 'estados' => $estados, 'tipoTicket' => $tipoTicket, 'unidadResponsable' => $unidadResponsable, 'actualizar'=>$actualizar

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
        $actualizar = 'actualizar';
        $estados = Estado::model()->findAll(array('order' => "nombre ASC"));
        $tipoTicket = TipoTicket::model()->findAll(array('order' => "nombre ASC"));
        $unidadResponsable = UnidadRespTicket::model()->findAll(array('order' => "nombre ASC"));
        if (isset($_POST['DistribucionTicket'])) {
            $model->attributes = $_POST['DistribucionTicket'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            if ($model->save())
                if ($model->validate()) {
                    if ($model->save()) {
                        $this->registerLog('ESCRITURA', 'ayuda.DistribucionTicket.create', 'EXITOSO', 'Se ha creado un Instructivo ahora puede crear otro');
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                        $model = $this->loadModel($id);
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                }
        }
         $this->renderPartial('create', array(
            'model' => $model, 'estados' => $estados, 'tipoTicket' => $tipoTicket, 'unidadResponsable' => $unidadResponsable, 'actualizar' => $actualizar,
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
        $groupId = Yii::app()->user->group;
        //var_dump($groupId); die();
        $model = new DistribucionTicket('search');
        if (!Yii::app()->user->pbac('admin')) {
            $model->usuario_ini_id = Yii::app()->user->id;
        }
        if (isset($_GET['DistribucionTicket']))
            $model->attributes = $_GET['DistribucionTicket'];
        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('DistribucionTicket');
        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));
    }

    public function columnaAccioness($datas) {
        $id = $datas["id"];
        $id2 = $datas["estatus"];
        $id = base64_encode($id);
        if ($id2 == "E") {
            $columna = CHtml::link("", "", array("class" => "fa fa-search", "title" => "Buscar Distribucion de Solicitud", "onClick" => "VentanaDialog('$id','/ayuda/distribucionTicket/view','Buscar Distribucion de Solicitud','view')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa fa-check", "title" => "Activar Distribucion de Solicitud", "onClick" => "VentanaDialog('$id','/ayuda/distribucionTicket/activar','Activar Distribucion de Solicitud','activar')")) . '&nbsp;&nbsp;';
        } else if ($id2 == "A") {
            $columna = CHtml::link("", "", array("class" => "fa fa-search", "title" => "Buscar Distribucion de Solicitud", "onClick" => "VentanaDialog('$id','/ayuda/distribucionTicket/view','Vista de Distribucion de Formulario','view')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa fa-pencil green", "title" => "Modificar Distribucion de Solicitud", "onClick" => "VentanaDialog('$id','/ayuda/distribucionTicket/update','Modificar Instructivo','update')")) . '&nbsp;&nbsp;';
        }

        return $columna;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DistribucionTicket the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DistribucionTicket::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DistribucionTicket $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'distribucion-ticket-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
