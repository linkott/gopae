<?php

class NivelPlantelController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Consulta de Nivel en plantel',
        'write' => 'Asignación de Niveles en planteles',
        'admin' => 'Modificación y eliminación de niveles en planteles',
        'label' => 'Niveles del plantel'
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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'cargarNivel'),
                'pbac' => array('read', 'write','admin'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('write'),
            ),
            
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'eliminarNivel'),
                'users' => array('admin'),
            ),
            
            
            /* array('allow', // allow admin user to perform 'admin' and 'delete' actions
              'actions'=>array('admin','delete'),
              'users'=>array('@'),
              ), */
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        if (isset($_GET['id'])) {
            $plantel_id = base64_decode($_GET['id']);
        }
        if ((!isset($_GET['id'])) || ($_GET['id'] == '') || (!is_numeric($plantel_id))) {
            $this->redirect('../../');
        }

        if ($plantel_id != '') {
            $plantelPK = Plantel::model()->findByPk($plantel_id);

            if ($plantelPK == null) {
                $this->redirect('../../../consultar');
            }
        } else {

            $this->redirect('../../../consultar');
        }

        $model = new NivelPlantel('search');
        $modelNivel = new Nivel();
        $nivel = $model->getNivelesModalidad($_GET['id']);
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['NivelPlantel']))
            $model->attributes = $_GET['NivelPlantel'];
        $this->render('index', array(
            'model' => $model,
            'plantelPK' => $plantelPK,
            'modelNivel' => $modelNivel,
            'nivel' => $nivel
        ));
    }

    public function actionCargarNivel() {
        if (!empty($_GET['id']) && !empty($_GET['nivel_id'])) {

            $resultado = NivelPlantel::model()->registroNivel($_GET['id'], $_GET['nivel_id'], Yii::app()->user->id);
            if ($resultado != null) {
                $model = new NivelPlantel('search');
                $modelNivel = new Nivel();
                $nivel = $model->getNivelesModalidad($_GET['id']);
                $model->unsetAttributes();  // clear any default values
                if (isset($_GET['NivelPlantel']))
                    $model->attributes = $_GET['NivelPlantel'];
                $this->renderPartial('index', array(
                    'model' => $model,
                    'modelNivel' => $modelNivel,
                    'nivel' => $nivel
                ));
                $this->registerLog('ESCRITURA', 'planteles.nivel.cargarNivel', 'EXITOSO', 'Asigno un nivel al plantel');
            }
            else {
                $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Lo sentimos ocurrio un error al eliminar este nivel.'));
                $this->registerLog('ESCRITURA', 'planteles.nivel.eliminarNivel', 'FALLO', 'Elimino un nivel de plantel');
            }
        }
    }

    public function actionEliminarNivel() {

        if (!empty($_GET['nivel_id'])) {
            $resultado = NivelPlantel::model()->eliminarNivel($_GET['nivel_id']);
            if ($resultado != null) {
                $model = new NivelPlantel('search');
                $modelNivel = new Nivel();
                $nivel = $model->getNivelesModalidad($_GET['id']);
                $model->unsetAttributes();  // clear any default values
                if (isset($_GET['NivelPlantel']))
                    $model->attributes = $_GET['NivelPlantel'];
                $this->renderPartial('index', array(
                    'model' => $model,
                    'modelNivel' => $modelNivel,
                    'nivel' => $nivel
                ));
                $this->registerLog('ESCRITURA', 'planteles.nivel.eliminarNivel', 'EXITOSO', 'Elimino un nivel de plantel');
            }
            else {
                $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Lo sentimos ocurrio un error al eliminar este nivel.'));
                $this->registerLog('ESCRITURA', 'planteles.nivel.eliminarNivel', 'FALLO', 'Elimino un nivel de plantel');
            }
        }
    }

    public function columnaAcciones($data)
    /*
     * Botones del accion (crear, consultar)
     */ {
        
        $id = $data["id"];
        $estatus = $data["estatus"];
        if(Yii::app()->user->pbac('planteles.nivel.write') || Yii::app()->user->pbac('planteles.nivel.admin')){
        
        if (($estatus == 'A') || ($estatus == '')) {
            //$plantel_id = base64_encode($this->getQuery('plantel_id'));
            $plantel_id = base64_encode($data['plantel_id']);
            $columna = CHtml::link("", "", array("class" => "icon-trash red remove-data", "onClick" => "eliminarNivel($id, '" . $plantel_id . "')", "title" => "Inactivar nivel")) . '&nbsp;&nbsp;';
        } else if ($estatus == 'E') {
            $columna = CHtml::link("", "", array('onClick' => "activarNivel($id)", "class" => "fa icon-ok green", "title" => "Activar este nivel")) . '&nbsp;&nbsp;';
        }
        }else{
            $columna="";
        }
        return $columna;
    }

    public function columnaEstatus($data) {
        $estatus = $data['estatus'];
        if (($estatus == 'A') || ($estatus == '')) {
            return 'Activo';
        } else if ($estatus == 'E') {
            return 'Inactivo';
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return NivelPlantel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = NivelPlantel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param NivelPlantel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'nivel-plantel-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
