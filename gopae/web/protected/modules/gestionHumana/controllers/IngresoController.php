<?php

/**
 * Clase Controladora de Peticiones del Módulo de Gestión Humana que permite dar ingreso a la corporación a un talento humano.
 *
 * @author José Gabriel González <jgonzalezp@me.gob.ve>
 * @createAt 2015-02-06
 * @updateAt 2015-02-06
 */
class IngresoController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'lista';

    /**
     * @return array action filters
     */
    public static $_permissionControl = array(
        'read' => 'Consulta de Ingresos de Talento Humano',
        'write' => 'Registro de Ingresos del Talento Humano',
        'admin' => 'Administración Completa de los Ingresos de Talento Humano',
        'label' => 'Módulo de Ingresos de Talento Humano'
    );

    /**
     * @return array action filters
     */
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
        // en este array colocar solo los action de consulta
        return array(
            array('allow',
                'actions' => array('lista', 'consulta', 'registro', 'edicion', 'eliminacion', 'activacion', 'admin', 'registroIngresoEmpleado'),
                'pbac' => array('admin'),
            ),
            array('allow',
                'actions' => array('lista', 'consulta', 'registro', 'edicion', 'admin', 'registroIngresoEmpleado'),
                'pbac' => array('write'),
            ),
            array('allow',
                'actions' => array('lista', 'consulta', 'admin', 'registroIngresoEmpleado'),
                'pbac' => array('read'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionLista()
    {
        $model=new IngresoEmpleado('search');
        $model->unsetAttributes();  // clear any default values
        if($this->hasQuery('IngresoEmpleado')){
            $model->attributes=$this->getQuery('IngresoEmpleado');
        }
        $dataProvider = $model->search();
        $this->render('admin',array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
        ));
    }
    
    /**
     * Manages all models.
     */
    public function actionAdmin($id)
    {
        $idDecoded = $this->getIdDecoded($id);
        $model = $this->loadModel($idDecoded);
        $this->renderPartial('_datosLaboralesView',array(
                'model'=>$model,

        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionConsulta($id)
    {
        $idDecoded = $this->getIdDecoded($id);
        $model = $this->loadModel($idDecoded);
        $this->render('view',array(
            'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    
   public function actionRegistroIngresoEmpleado($id){
        if(Yii::app()->request->isAjaxRequest){
            
            $idDecoded = $this->getIdDecoded($id);
            $model = $this->loadModel($idDecoded);
                
            
            $talentoHumanoId = $this->getPost('IngresoEmpleado')['talento_humano_id'];
            $poseeNumeroContrato = $this->getPost('IngresoEmpleado')['posee_numero_contrato'];
            $nroContrato = $this->getPost('IngresoEmpleado')['nro_contrato'];
            $fechaIngreso = $this->getPost('IngresoEmpleado')['fecha_ingreso'];
            $categoriaIngresoId=$this->getPost('IngresoEmpleado')['categoria_ingreso_id'];
            $tipoCargoNominalId=$this->getPost('IngresoEmpleado')['tipo_cargo_nominal_id'];
            $cargoNominalId=$this->getPost('IngresoEmpleado')['cargo_nominal_id'];
            $estructuraOrganizativaId=$this->getPost('IngresoEmpleado')['estructura_organizativa_id'];
            $condicionNominalId=$this->getPost('IngresoEmpleado')['condicion_nominal_id'];
            $tipoNominaId=$this->getPost('IngresoEmpleado')['tipo_nomina_id'];
            $plantelId=$this->getPost('IngresoEmpleado')['plantel_id'];
            $observacion=$this->getPost('IngresoEmpleado')['observaciones'];
            $idUsuario=Yii::app()->user->id;
            

            $statusResponse = 400;
            $mensaje = 'No se han proporcionado los datos necesarios para efectruar esta operación.';
            //Recordar cambiar el == a !=
            if($model->estatus != 'A'){
                if($this->hasPost('IngresoEmpleado')){
                    $ingresoEmpleadoFormData = $this->getPost('IngresoEmpleado'); 
                    $model->attributes=$ingresoEmpleadoFormData; 
                    $model->beforeInsert();
                    if($model->validate()){
                        
                        // llamo al procedimiento de almacenado.
                        $mensaje_pro = IngresoEmpleado::model()->ingresoMadreTrabajadora(
                            is_numeric($talentoHumanoId)?$talentoHumanoId:NULL,
                            $poseeNumeroContrato,
                            $nroContrato,
                            $fechaIngreso,
                            //EN CASO DE QUE NO SE ASIGNE VALOR, LIMPIA EL CAMPO QUE CONTIENE '' POR NULL. 
                            is_numeric($categoriaIngresoId)?$categoriaIngresoId:NULL,
                            is_numeric($tipoCargoNominalId)?$tipoCargoNominalId:NULL,
                            is_numeric($cargoNominalId)?$cargoNominalId:NULL,
                            is_numeric($estructuraOrganizativaId)?$estructuraOrganizativaId:NULL,
                            is_numeric($condicionNominalId)?$condicionNominalId:NULL,
                            is_numeric($tipoNominaId)?$tipoNominaId:NULL,
                            is_numeric($plantelId)?$plantelId:NULL,
                            $observacion,
                            $idUsuario
                        );
                        
                        $statusResponse = 200;
                        $this->registerLog('ESCRITURA', 'modulo.IngresoEmpleado.registro', 'EXITOSO', 'El Registro de los datos de IngresoEmpleado se ha efectuado exitósamente. Data-> '.json_encode($model->attributes));
                        $mensaje =   $mensaje_pro;       
                    }
                    else{
                        $mensaje = CHtml::errorSummary($model);
                    }
                }
            }ELSE {
                $mensaje = 'Ya se encuentra activo en al empresa';
            }
            $response=array('status'=>$statusResponse, 'mensaje'=>$mensaje,  'idIngreso'=>$model->id);
            $this->jsonResponse($response);

        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta operación mediante esta vía');
        }
    }
    
    public function actionRegistro($id)
    {
            $idDecoded = $this->getIdDecoded($id);
            $model = $this->loadModel($idDecoded);
            
             

        $this->renderPartial('_datosLaboralesForm',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdicion($id)
    {
            $idDecoded = $this->getIdDecoded($id);
            $model = $this->loadModel($idDecoded);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if($this->hasPost('IngresoEmpleado'))
            {
                $model->attributes=$this->getPost('IngresoEmpleado');
                $model->beforeUpdate();
                if($model->save()){
                    $this->registerLog('ACTUALIZACION', 'modulo.IngresoEmpleado.edicion', 'EXITOSO', 'La Actualización de los datos de IngresoEmpleado se ha efectuado exitósamente. Data-> '.json_encode($model->attributes));
                    if(Yii::app()->request->isAjaxRequest){
                        $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La actualización de los Datos se ha efectuado de forma exitosa.'));
                        Yii::app()->end();
                    }
                }
            }

            $this->render('update',array(
                    'model'=>$model,
            ));
    }

    /**
     * Logical Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionEliminacion($id)
    {
        $idDecoded = $this->getIdDecoded($id);
        $model = $this->loadModel($idDecoded);
        
        if($model){
            $model->beforeDelete();
            if($model->save()){
                $this->registerLog('ELIMINACION', 'modulo.IngresoEmpleado.eliminacion', 'EXITOSO', 'La Eliminación de los datos de IngresoEmpleado se ha efectuado exitósamente. Data-> '.json_encode($model->attributes));
                if(Yii::app()->request->isAjaxRequest){
                    $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La eliminación del registro se ha efectuado de forma exitosa.'));
                    Yii::app()->end();
                }
            }
        }

        $this->redirect($this->hasPost('returnUrl') ? $this->getPost('returnUrl') : array('lista'));
    }
    
    /**
     * Activation of a particular model Logicaly Deleted.
     * If activation is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be activated
     */

    
    public function loadModel($id)
    {
        if(is_numeric($id)){
            $model=IngresoEmpleado::model()->findByPk($id);
            if($model===null){
                throw new CHttpException(404,'The requested page does not exist.');
            }
            return $model;
        }
        else{
            return null;
        }
    }
    
    
    protected function performAjaxValidation($model)
    {
        if($this->hasPost('ajax') && $this->getPost('ajax')==='ingreso-empleado-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
     public function getActionButtons($data) {
        $id_encoded = $data["id"];
        $id = base64_encode($id_encoded);
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in", "title" => "Ver datos", 'href' => '/ingresoEmpleado/consulta/id/'.$id)) . '&nbsp;&nbsp;';
        $columna .= CHtml::link("", "", array("class" => "fa icon-pencil green", "title" => "Editar datos", 'href' => '/ingresoEmpleado/edicion/id/'.$id)) . '&nbsp;&nbsp;';
        if($data->estatus=='A'){
            $columna .= CHtml::link("", "", array("class" => "fa icon-trash red", "title" => "Eliminar", 'href' => '/ingresoEmpleado/eliminacion/id/'.$id)) . '&nbsp;&nbsp;';
        }else{
            $columna .= CHtml::link("", "", array("class" => "fa fa-check green", "title" => "Activar", 'href' => '/ingresoEmpleado/activacion/id/'.$id)) . '&nbsp;&nbsp;';
        }
        $columna .= '</div>';
        return $columna;
    }
    
     public function getIdDecoded($id){
        if(is_numeric($id)){
            return $id;
        }
        else{
            $idDecodedb64 = base64_decode($id);
            if(is_numeric($idDecodedb64)){
                return $idDecodedb64;
            }
        }
        return null;
    }
    
    public function actionActivacion($id){
        $idDecoded = $this->getIdDecoded($id);
        $model = $this->loadModel($idDecoded);
        if($model){
            $model->beforeActivate();
            if($model->save()){
                $this->registerLog('ACTIVACION', 'modulo.IngresoEmpleado.activacion', 'EXITOSO', 'La Activación de los datos de IngresoEmpleado se ha efectuado exitósamente. Data-> '.json_encode($model->attributes));
                if(Yii::app()->request->isAjaxRequest){
                    $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La activación de este registro se ha efectuado de forma exitosa.'));
                    Yii::app()->end();
                }
            }
        }
        $this->redirect($this->hasPost('returnUrl') ? $this->getPost('returnUrl') : array('lista'));
    }

}
