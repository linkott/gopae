<?php

class CondicionServicioController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
     public $layout = '//layouts/main';
    static $_permissionControl = array(
        'read' => 'Agregar Condición de Servicio',
        'write' => 'Agregar Condición de Servicio',
        'label' => 'Agregar Condición de Servicio'
    );
        public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
//'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {

//en esta seccion colocar los action de solo lectura o consulta
        return array(
            array('allow',
                'actions' => array(
                    'index',
                    'view',
                    'estatus',
                    'ConsultarCondicionDeServicio',
                    ),
                'pbac' => array('read','write'),
            ),
            //en esta seccion colocar todos los action del modulo
            array('allow',
                'actions' => array(
                    'delete', 'actualizar', 'create'
                ),
                'pbac' => array('write'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */


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
        $model = new CondicionServicio;
        $model->attributes = $_POST['CondicionServicio'];
//        var_dump($model['nombre']);
//        die();
        $model->usuario_ini_id = Yii::app()->user->id;
        $model->fecha_ini = date("Y-m-d H:i:s");
        $model->estatus = "A";
        if ($model->validate()) {
            if ($model->save()) {
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Exito! ya puede realizar otro registro.'));
                $model = new CondicionServicio;
                $this->registerLog('ESCRITURA', 'catalogo.condicionServicio.Create', 'EXITOSO', 'Permite guardar los datos de Condicion de servicio');
            } else {
                throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
            }
        }
        $this->renderPartial('create', array(
            'model' => $model,));
    }

        /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionActualizar() {
    if(Yii::app()->request->isAjaxRequest){
        //if($this->getPost('id') && $this->getPost('identificador')){
        //$activar=$this->getPost('identificador');
            if (isset($_POST['CondicionServicio'])) {

                $id=$_POST['CondicionServicio']['id'];
                $model = $this->loadModel($id);
                $model->attributes = $_POST['CondicionServicio'];


                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_act = date("Y-m-d H:i:s");
                $model->estatus = "A";
                if ($model->validate()) {
                    if ($model->save()) {

                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Exito! al realizar la acción.'));
                        $this->registerLog('ACTUALIZACION', 'catalogo.condicionServicio.Actualizar', 'EXITOSO', 'Permite Actualizar los datos de Condicion de servicio');
                        $model = $this->loadModel($id);
                        $this->renderPartial('update', array(
                            'model' => $model,
                        ));
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                }
            }
        }
    else{

         throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }



    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
            $model = $this->loadModel($id);
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_elim = date("Y-m-d H:i:s");
            $model->estatus = "E";

            if ($model->save()) {
                Yii::app()->user->setFlash('mensajeExitoso', "Inactivación Exitosa");
                $this->renderPartial('//flashMsg');
                $this->registerLog('INACTIVAR', 'catalogo.condicionServicio.Delete', 'EXITOSO', 'Permite inactivar la Condicion de servicio');
        }
    }

    /**
     * Lists all models.
     */
    /* public function actionIndex()
      {
      $dataProvider=new CActiveDataProvider('CondicionServicio');
      $this->render('index',array(
      'dataProvider'=>$dataProvider,
      ));
      } */

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $model = new CondicionServicio('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CondicionServicio']))
            $model->attributes = $_GET['CondicionServicio'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CondicionServicio the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CondicionServicio::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not existdnlkgnfdlkgnlkfdsnlkgsdlkn.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CondicionServicio $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'condicion-servicio-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     * Aqui estara los botenes del action
     * Los numero donde se encuentra el onclick es para identificar si es crear, actualizar ,consultar ,eliminar
     */

    public function columnaAcciones($data) {
        $id = $data["id"];
        $condicion = $data["estatus"];
        $columna = "<div class='action-buttons'>  ";
        if($condicion=='A'){
            $columna .= CHtml::link("", "#", array("class" => "fa icon-zoom-in", "onClick" => "condicionDeServicio($id,'1')", "title" => "Consultar Condiciones de Servicio")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa fa-pencil green", "onClick" => "condicionDeServicio($id,'2')", "title" => "Modifica condiciones de Servicio")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("","",array("class"=>"icon-trash red remove-data","title"=>"Inactivar condicion de servicio","onClick" => "condicionDeServicio($id,'4')"));

        }
        else{

            $columna = CHtml::link("", "#", array("class" => "fa fa-search", "onClick" => "condicionDeServicio($id,'1')", "title" => "Consultar Condiciones de Servicio")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "#", array("class" => "fa fa-check", "onClick" => "condicionDeServicio($id,'5')", "title" => "Activar Condiciones de Servicio")) . '&nbsp;&nbsp;';

        }

        $columna .="</div>";
        return $columna;
    }

    public function actionConsultarCondicionDeServicio() {
        $id = null;
        $identificador = null;

        if(array_key_exists('id', $_POST)){
            $id=$_POST['id'];
        }
        if(array_key_exists('identificador',$_POST)){
            $identificador=$_POST['identificador'];
        }

        if(!is_null($identificador) && !is_null($id)){

            if ($identificador == '1') {
                $this->renderPartial('consultarCondicionDeServicio', array(
                    'model' => $this->loadModel($id),
                ));
            }
            if ($identificador == '2') {
                $this->renderPartial('update', array(
                    'model' => $this->loadModel($id),
                ));
            }

            if ($identificador == '3') {
                $model = new CondicionServicio;
                $this->renderPartial('create', array(
                    'model' => $model,
                ));
            }
            if ($identificador=='4'){
                    $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => '¿Esta seguro que desea Elimniar esta condición de servicio?'));

            }

            if($identificador=='6'){
                $this->actionDelete($id);
            }
            if($identificador=='5'){
                  $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => '¿Esta seguro que desea Activar esta condición de servicio?'));
            }
            if($identificador=='7'){
                //var_dump($identificador);
                $this->actionsActivar($id);
            }
        }
        else{
            throw new CHttpException(404, 'Recurso no encontrado :/');
        }
    }

    public function Estatus($dato){
        $id=$dato['estatus'];
        if($id== 'A'){

            $columna= 'Activo';
        }
        else {
            $columna ='Inactivo';
        }
        return $columna;

    }

    public function actionsActivar ($id){
            $model = $this->loadModel($id);
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_elim = date("Y-m-d H:i:s");
            $model->estatus = "A";

            if ($model->save()) {
            Yii::app()->user->setFlash('mensajeExitoso', "Activación Exitosa");
                $this->renderPartial('//flashMsg');

            $this->registerLog('INACTIVAR', 'catalogo.condicionServicio.Activar', 'EXITOSO', 'Permite Activar la Condicion de servicio');
        }


    }

}
