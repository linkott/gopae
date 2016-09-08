<?php

class TipoTicketController extends Controller {

    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    static $_permissionControl = array(
        'read' => 'Consulta de tipo de ticket',
        'write' => 'Gestion de tipo de ticket',
        'label' => 'Módulo de tipo de ticket'
    );

    /**
     * @return array action filters
      public function filters() {
      return array(
      'userGroupsAccessControl', // perform access control for CRUD operations
      'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'admin', 'create', 'activar', 'view'),
                'pbac' => array('read', 'write',),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('update'),
                'pbac' => array('admin',),
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
        $id = $_REQUEST['id'];
        $model = new TipoTicket;
      $unidades= UnidadRespTicket::model()->findAll(array('order' => "nombre ASC"));
       //$estado = Estado::model()->findAll(array('order' => "descripcion ASC"));
        if (isset($_POST['TipoTicket'])){
            //$model->estado_tipo_ticket_id=$_POST['estado_tipo_ticket_id'];
            
            $id = base64_decode($id);
            $model->attributes = $_POST['TipoTicket'];
            $model->usuario_ini_id = Yii::app()->user->name;
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = "A";
            if ($model->validate()) {
                if ($model->save()) {

                    $this->registerLog('ESCRITURA', 'catalogo.tipoTicket.create', 'EXITOSO', 'Se ha creado un tipo de ticket');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Exito! ya puede realizar otro registro.'));
                    $model = new TipoTicket;
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            }
        }
        $this->renderPartial('create', array(
            'model' => $model,'unidades'=>$unidades,
        ));
    }

    public function actionUpdate($id) {
        $id = $_REQUEST['id'];
        $id = base64_decode($id);
        $model = $this->loadModel($id);
        $unidad='unidad';
       $unidades= UnidadRespTicket::model()->findAll(array('order' => "nombre ASC"));
        if (isset($_POST['TipoTicket'])) {
            $model->attributes = $_POST['TipoTicket'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            if ($model->save())
                if ($model->validate()) {
                    if ($model->save()) {
                        $this->registerLog('ESCRITURA', 'catalogo.tipoTicket.create', 'EXITOSO', 'Se ha actualizado un ticket');
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                        $model = $this->loadModel($id);
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                }
        }

        $this->renderPartial('update', array(
            'model' => $model,'unidades'=>$unidades,'unidad'=>$unidad
        ));
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
                    $this->registerLog('ESCRITURA', 'catalogo.tipoTicket.borrar', 'EXITOSO', 'Se ha eliminado un tipo de ticket');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con exito.'));
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else {

                throw new CHttpException(404, 'Error! Recurso no encontrado!');
            }
        }
    }

    public function actionIndex() {

        $groupId = Yii::app()->user->group;

        $model = new TipoTicket('search');

        if (isset($_GET['TipoTicket']))
            $model->attributes = $_GET['TipoTicket'];

        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('TipoTicket');
        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $groupId = Yii::app()->user->group;
        $model = new TipoTicket('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TipoTicket']))
            $model->attributes = $_GET['TipoTicket'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function estatus($data) {
        $id = $data["estatus"];
        if ($id == 'A') {
            $columna = 'Activo';
        }

        if ($id == 'E') {
            $columna = 'Inactivo';
        }
        if ($id == 'R') {
            $columan = 'Resuelto';
        }

        return $columna;
    }

    public function columnaAcciones($datas) {

        $id = $datas["id"];
        $id2 = $datas["estatus"];
        $id = base64_encode($id);
        //if($id=="A"){
        if ($id2 == "E") {
            $columna = CHtml::link("", "#", array("class" => "fa fa-search", "title" => "Buscar TipoTicket", "onClick" => "VentanaDialog('$id','/catalogo/ticket/view','tipoTicket','view')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "#", array("class" => "fa fa-check", "title" => "Activar TipoTicket", "onClick" => "VentanaDialog('$id','/catalogo/ticket/activar','activar tipoTicket','activar')")) . '&nbsp;&nbsp;';
        } else if ($id2 == "A") {
            $columna = CHtml::link("", "#", array("class" => "fa fa-search", "title" => "Buscar TipoTicket", "onClick" => "VentanaDialog('$id','/catalogo/tipoTicket/view','Ticket','view')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "#", array("class" => "fa fa-pencil green", "title" => "Modificar TipoTicket", "onClick" => "VentanaDialog('$id','/catalogo/tipoTicket/update','Modificar tipoTicket','update')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "#", array("class" => "fa icon-trash red", "title" => "Eliminar TipoTicket", "onClick" => "VentanaDialog('$id','/catalogo/tipoTicket/borrar','Eliminar tipoTicket','borrar')")) . '&nbsp;&nbsp;';
        }

        return $columna;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TipoTicket the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = TipoTicket::model()->with('usuarioAct','usuarioIni')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TipoTicket $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tipo-ticket-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    static function registrarTraza($transaccion, $accion) {
        $Utiles = new Utiles();
        $modulo = "gmanual.TipoTicket" . $accion;
        $Utiles->traza($transaccion, $modulo, date('Y-m-d H:i:s'));
    }

}
