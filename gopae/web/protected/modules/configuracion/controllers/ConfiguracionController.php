<?php

class ConfiguracionController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
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
                'actions' => array('index', 'admin', 'create', 'activar', 'formularios', 'upload', 'view', 'guardarArchivo', 'exportar', 'update', 'tipo'),
            //'pbac' => array('read', 'write',),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('update'),
            //'pbac' => array('admin',),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id) {
        $idDecoded = base64_decode($id);
        $model = $this->loadModel($idDecoded);
        $this->renderPartial('view', array(
            'model' => $model,));
    }

    public function actionIndex() {

        $groupId = Yii::app()->user->group;
        $model = new Configuracion('search');
        if (isset($_GET['Configuracion']))
            $model->attributes = $_GET['Configuracion'];

        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('Configuracion');

        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));
    }

      public function fechaIni($data) {
        $fecha_Ini = $data["valor_date"];
        if (empty($fecha_Ini)) {
            $fecha_Ini = "";
        } else {
            $fecha_Ini = date("d-m-Y", strtotime($fecha_Ini));
        }
        return $fecha_Ini;
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        var_dump("Este boton esta en mentanimiento");
        die();
        $id = $_GET['id'];
        $model = new Ticket;
        $modelArchivo = new ArchivoFundamentoJuridico;
        //Funcion para solicitud de nuevo usuario
        $solicitudNuevoUsuario = $this->solicitudNuevoUsuario();
        //Funcion registro de nuevo plantel
        $registroPlantel = $this->solicitudResgistroPlantel();
        //Funcion reseteo de clave
        $solicitudReseteoClave = $this->SolicitudReseteoClave();
        //Funcion error en el sistema
        $errorSistema = $this->errorSistema();

        $OtraSolicitud = $this->OtraSolicitud();
    }

    public function actionUpdate() {
        $id = $_REQUEST['id'];
        $cod_tipo_dato = $_REQUEST['cod_tipo_dato'];
        $id = base64_decode($id);
        $model = $this->loadModel($id);
        if (isset($_POST['valor_date'])) {
           $model->valor_date=$_POST['valor_date'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
           if($model->validate()){
                if($model->valor_date==""){
              $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Fecha No Puede Ser Vacia.'));
                }else if($model->valor_date!=""){
            if ($model->save()) {
                $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                $model = $this->loadModel($id);
            }else if(!$model->save()) {
              throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
}
          
            }else{
             $this->renderPartial('//errorSumMsg', array('model' => $model));
            }
                
           }
            
            
        } else if (isset($_POST['valor_bool'])){
            $model->valor_bool = trim($_POST['valor_bool']);
            if($model->validate()){
                if($model->valor_bool==""){
                 $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Fecha No Puede Ser Vacia.'));
                }else if($model->valor_bool!=""){
            if ($model->save()) {
                $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                $model = $this->loadModel($id);
            } else {
                throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
            }
        }else {
           $this->renderPartial('//errorSumMsg', array('model' => $model));
        }
            }
        }
    

        if ($cod_tipo_dato == "date") {
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            $this->renderPartial('tipo_dato_date', array(
                'model' => $model, false, true
            ));
        } else if ($cod_tipo_dato == "bool") {
            $this->renderPartial('tipo_dato_bool', array(
                'model' => $model,
            ));
        } else if ($cod_tipo_dato == "int") {
            $this->renderPartial('tipo_dato_int', array(
                'model' => $model,
            ));
        } else if ($cod_tipo_dato == "str") {
            $this->renderPartial('tipo_dato_str', array(
                'model' => $model,
            ));
        } else if ($cod_tipo_dato == "txt") {
            $this->renderPartial('tipo_dato_txt', array(
                'model' => $model,
            ));
        } else if ($cod_tipo_dato == "") {
            $this->renderPartial('tipo_dato_vacio', array(
                'model' => $model,
            ));
        }
    
}

public function tipoDato($tipo){
    $valor='';
    $valor=$tipo['valor_bool'];
    if($valor=='0'){
        $columna='Si';
    }else if($valor==''){
         $columna='no posee';
     }
     if($valor==1){
        $columna='No';
     }
     
     
    return $columna;
}

public function valorDate($date){
    $valor='';
    $columna='';
    $valor=$date['valor_date'];
    if($valor==''){
        $columna='No Posee';
    }
    if($valor){
    $columna=$valor;

    }
    return $columna;
}



public function valorInt($date){
    $valor='';
    $columna='';
    $valor=$date['valor_date'];
    if($valor==''){
        $columna='No Posee';
    }
    if($valor){
    $columna=$valor;

    }
    return $columna;
}

    public function actionUpload() {
//        $options = null, $initialize = true, $error_messages = null, $filename=null, $id_model=''
        $upload_handler = new UploadHandler(null, true, null, date('YmdHis') . 'AT', "/public/uploads/ticket/");
    }

    public function estatus($data) {
        $id = $data["estatus"];
        if ($id == "A") {
            $estatus = 'Activo';
        }

        return $estatus;
    }

    public function columnaAcciones($datas) {

        $model = new Configuracion();
        $cod_tipo_dato = $datas['cod_tipo_dato'];
        $id_encoded = $datas["id"];
        $id = base64_encode($id_encoded);
        $usuario_ini_id = $datas["usuario_ini_id"];

        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in", "title" => "Ver datos de la configuracion", "onClick" => "VentanaDialog('$id','/configuracion/configuracion/view','Configuracion','view')")) . '&nbsp;&nbsp;';
        $columna .= CHtml::link("", "", array("class" => "fa fa-pencil green", "title" => "Editar configuración", "onClick" => "VentanaDialog('$id','/configuracion/configuracion/update','Atender Ticket','update','$cod_tipo_dato')")) . '&nbsp;&nbsp;';
        return $columna;
    }

    public function loadModel($id) {
        $model = Configuracion::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'configuracion') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
