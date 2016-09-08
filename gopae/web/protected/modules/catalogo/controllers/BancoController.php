<?php

class BancoController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction='lista';

    /**
     * @return array action filters
     */
    public static $_permissionControl = array(
        'read' => 'Consulta de BancoController',
        'write' => 'Creación y Modificación de BancoController',
        'admin' => 'Administración Completa  de BancoController',
        'label' => 'Módulo de BancoController'
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
                'actions' => array('lista', 'consulta', 'registro', 'edicion', 'eliminacion', 'registroTipoCuentaBanco', 'listaTipoCuentaBanco', 'eliminaTipoCuentaBanco', 'registroTipoSerialCuentaBanco', 'listaTipoSerialCuentaBanco', 'eliminaTipoSerialCuentaBanco'),
                'pbac' => array('admin'),
            ),
            array('allow',
                'actions' => array('lista', 'consulta', 'registro', 'edicion', 'registroTipoCuentaBanco', 'listaTipoCuentaBanco', 'registroTipoSerialCuentaBanco', 'listaTipoSerialCuentaBanco',),
                'pbac' => array('write'),
            ),
            array('allow',
                'actions' => array('lista', 'consulta', 'listaTipoCuentaBanco', 'listaTipoSerialCuentaBanco',),
                'pbac' => array('read'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

//ACCIONES GENERALES
    /**
     * Lists all models.
     */
    public function actionLista()
    {
        $model=new Banco('search');
        $model->unsetAttributes();  // clear any default values
        if($this->hasQuery('Banco')){
            $model->attributes=$this->getQuery('Banco');
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
    public function actionAdmin()
    {
        $model=new Banco('search');
        $model->unsetAttributes();  // clear any default values
        if($this->hasQuery('Banco')){
            $model->attributes=$this->getQuery('Banco');
        }
        $dataProvider = $model->search();
        $this->render('admin',array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
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
    public function actionRegistro()
    {
        $model=new Banco;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if($this->hasPost('Banco'))
        {
            $model->attributes=$this->getPost('Banco');
            if($model->save()){
                $this->registerLog('ESCRITURA', 'catalogo.banco.registro', 'EXITOSO', 'Se ha registrado un nuevo banco. '.  json_encode($model->attributes));
                $this->redirect(array('consulta','id'=>$model->id));
            }
        }
        $this->render('create',array(
            'model'=>$model,
        ));
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdicion($id) //Es necesario capturar el id.
    {
            $idDecoded = $this->getIdDecoded($id); // el id capturado es necesario codificarlo
            $model = $this->loadModel($idDecoded); // carga el modelo luego de validar sus existencia
            
            //Tipo de Cuenta de Banco
            $tipoCuentaBanco = new TipoCuentaBanco();
            $tipoCuentaBanco->banco_id = $model->id;
            
            $tiposDeCuentaProvider = $tipoCuentaBanco->search();
            $tipoCuentaSelect = $tipoCuentaBanco->getTiposCuentaNoVinculadas($model->id);
            
            //Tipo de Serial de Cuenta de Banco
            $tipoSerialCuentaBanco = new TipoSerialCuentaBanco();
            $tipoSerialCuentaBanco->banco_id = $model->id;
            
            $tiposSerialDeCuentaProvider = $tipoSerialCuentaBanco->search();
            $tipoSerialCuentaSelect = $tipoSerialCuentaBanco->getTiposSerialCuentaNoVinculadas($model->id);
            
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if($this->hasPost('Banco'))
            {
                $model->attributes=$this->getPost('Banco');
                if($model->save()){
                    $this->registerLog('ACTUALIZACION', 'catalogo.banco.edicion', 'EXITOSO', 'Se han actualizado los datos del banco. '.  json_encode($model->attributes));
                    if(Yii::app()->request->isAjaxRequest){
                        $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La actualización de los Datos se ha efectuado de forma exitosa.'));
                        Yii::app()->end();
                    }
                }
            }

            $this->render('update',array(
                'model' => $model,
                //Tipo Cuenta Banco
                'tiposDeCuentaProvider' => $tiposDeCuentaProvider,
                'tipoCuentaSelect'=> $tipoCuentaSelect,
                //Tipo Serial Cuenta Banco
                'tiposSerialDeCuentaProvider'=>$tiposSerialDeCuentaProvider,
                'tipoSerialCuentaSelect'=>$tipoSerialCuentaSelect,
                
            ));
    }
    
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionEliminacion($id)
    {
        $idDecoded = $this->getIdDecoded($id);
        $model = $this->loadModel($idDecoded);
        // Descomenta este código para habilitar la eliminación física de registros.
        // $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!$this->hasQuery('ajax')){
            $this->redirect($this->hasPost('returnUrl') ? $this->getPost('returnUrl') : array('lista'));
        }
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Banco the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Banco::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Banco $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if($this->hasPost('ajax') && $this->getPost('ajax')==='banco-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Retorna los botones o íconos de administración del modelo
     *
     * @param mixed $data
     *
     */
    public function getActionButtons($data) {
        $id_encoded = $data["id"];
        $id = base64_encode($id_encoded);
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in", "title" => "Ver datos", 'href' => '/catalogo/banco/consulta/id/'.$id)) . '&nbsp;&nbsp;';
        $columna .= CHtml::link("", "", array("class" => "fa icon-pencil green", "title" => "Editar datos", 'href' => '/catalogo/banco/edicion/id/'.$id)) . '&nbsp;&nbsp;';
        $columna .= '</div>';
        return $columna;
    }
    
/**
     * Obtiene un id Decodificado si un Id es codificado en base64
     *
     * @param mixed $id
     *
     */
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
// FIN DE ACCIONES GENERALES
// 
// ACCIONES TIPO CUENTA BANCO
//
    public function actionRegistroTipoCuentaBanco(){
        if(Yii::app()->request->isAjaxRequest){
            $statusResponse = 400;
            $mensaje = 'No se han proporcionado los datos necesarios para efectruar esta operación.';
            $bancoNombre=null;
            $tipoCuenta=null;
            if($this->hasPost('TipoCuentaBanco')){
                $model = new TipoCuentaBanco();
                $tipoCuentaBancoFormData = $this->getPost('TipoCuentaBanco');
                $model->attributes=$tipoCuentaBancoFormData;
                $model->beforeInsert();
                if($model->validate()){
                    if($model->save()){
                        $model->deleteCacheTipoCuentaBanco($model->banco_id);
                        $statusResponse = 200;
                        $bancoNombre = $tipoCuentaBancoFormData['banco'];
                        $tipoCuenta = $tipoCuentaBancoFormData['tipo_cuenta'];
                        $this->registerLog('ESCRITURA', 'catalogo.banco.registroTipoCuentaBanco', 'EXITOSO', 'Se ha registrado un nuevo Tipo de Cuenta '.$tipoCuenta.' al banco '.$bancoNombre.'. '.  json_encode($model->attributes));
                        $mensaje = 'El Registro del Tipo de Cuenta '.htmlentities(ucwords(strtolower($tipoCuenta))).' en el Banco '.htmlentities($bancoNombre).' ha sido efectuado exitosamente.';
                    }
                }
                else{
                    $mensaje = CHtml::errorSummary($model);
                }
            }
            $response=array('status'=>$statusResponse, 'mensaje'=>$mensaje, 'bancoId'=>$model->banco_id, 'bancoNombre'=>$bancoNombre, 'tipoCuenta'=>$tipoCuenta);
            $this->jsonResponse($response);

        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta operación mediante esta vía');
        }
    }
    
    public function actionListaTipoCuentaBanco($id){
       
        $idDecoded = $this->getIdDecoded($id);
        
        if(is_numeric($idDecoded) and ($this->hasPost('nombre')))
            
        {
            $model = new Banco();
            $model->id = $idDecoded;
            $model->nombre = $this->getPost('nombre');

            $tipoCuentaBanco = new TipoCuentaBanco();
            $tipoCuentaBanco->banco_id = $model->id;

            $tiposDeCuentaProvider = $tipoCuentaBanco->search();
            $tipoCuentaSelect = $tipoCuentaBanco->getTiposCuentaNoVinculadas($model->id);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            $this->renderPartial('_formListaTipoCuentaBanco',array(
                'model' => $model,
                'tiposDeCuentaProvider' => $tiposDeCuentaProvider,
                'tipoCuentaSelect'=> $tipoCuentaSelect,
            )); 
        }
        else 
        {
            $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'No se han proporcionado los datos necesarios para ejecutar esta operación.'));
        }
    }
    
    public function actionEliminaTipoCuentaBanco($id){
        $idDecoded = $this->getIdDecoded($id); // Id del TipoCuentaBanco
        $statusResponse = 400;
        $mensaje = 'No se han proporcionado los datos necesarios para efectruar esta operación.';
        $bancoNombre=null;
        $bancoId=null;
        if(is_numeric($idDecoded) && $this->hasPost('bancoNombre') && $this->hasPost('bancoId')){
             $bancoId = base64_decode($this->getPost('bancoId'));
             $bancoNombre = $this->getPost('bancoNombre');
             $model = TipoCuentaBanco::model()->findByPk($idDecoded);
             if($model){
                try{
                    $model->delete();
                    $this->registerLog('ELIMINACION', 'catalogo.banco.eliminaTipoCuentaBanco', 'EXITOSO', 'Se ha eliminado el Tipo de Cuenta '.$model->id.' al banco '.$bancoNombre.'. '.  json_encode($model->attributes));
                    $statusResponse = 200;
                    $mensaje = 'La Eliminación del Tipo de Cuenta en el Banco '.htmlentities($bancoNombre).' ha sido efectuada exitosamente.';
                }
                catch(Exception $e){
                    $statusResponse = 500;
                    $mensaje = 'Se ha producido un error: '.$e->getMessage();
                }
             }
        }
        $response=array('status'=>$statusResponse, 'mensaje'=>$mensaje, 'bancoId'=>$bancoId, 'bancoNombre'=>$bancoNombre, 'tipoCuenta'=>$model->id);
        $this->jsonResponse($response);
    }
    
    public function getActionButtonsTiposCuentaBanco($data){
        $id_encoded = $data["id"];
        $id = base64_encode($id_encoded);
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa fa-trash red", "title" => "Eliminar Tipo de Cuenta de este Banco", 'onClick' => 'eliminarTipoCuentaBanco("'.$id.'");')) . '&nbsp;&nbsp;';
        $columna .= '</div>';
        return $columna;
    }
//FIN DE ACCIONES TIPO CUENTA BANCO
//
// ACCIONES DE TIPO SERIAL CUENTA BANCO
//
    public function actionRegistroTipoSerialCuentaBanco(){
        if(Yii::app()->request->isAjaxRequest){
            $statusResponse = 400;
            $mensaje = 'No se han proporcionado los datos necesarios para efectruar esta operación.';
            $bancoNombre=null;
            $tipoSerialCuenta=null;
            if($this->hasPost('TipoSerialCuentaBanco')){
                $model = new TipoSerialCuentaBanco();
                $tipoSerialCuentaBancoFormData = $this->getPost('TipoSerialCuentaBanco');
                $model->attributes=$tipoSerialCuentaBancoFormData;
                $model->beforeInsert();
                if($model->validate()){
                    if($model->save()){
                        $model->deleteCacheTipoSerialCuentaBanco($model->banco_id);
                        $statusResponse = 200;
                        $bancoNombre = $tipoSerialCuentaBancoFormData['banco'];
                        $tipoSerialCuenta = $tipoSerialCuentaBancoFormData['tipo_serial_cuenta'];
                        $this->registerLog('ESCRITURA', 'catalogo.banco.registroTipoSerialCuentaBanco', 'EXITOSO', 'Se ha registrado un nuevo serial de '.$tipoSerialCuenta.' al banco '.$bancoNombre.'. '.  json_encode($model->attributes));
                        $mensaje = 'El registro del Serial de '.htmlentities(ucwords(strtolower($tipoSerialCuenta))).' en el Banco '.htmlentities($bancoNombre).' ha sido efectuado exitosamente.';
                    }
                }
                else{
                    $mensaje = CHtml::errorSummary($model);
                }
            }
            $response=array('status'=>$statusResponse, 'mensaje'=>$mensaje, 'bancoId'=>$model->banco_id, 'bancoNombre'=>$bancoNombre, 'tipoSerialCuenta'=>$tipoSerialCuenta);
            $this->jsonResponse($response);

        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta operación mediante esta vía');
        }
    }
    
    public function actionListaTipoSerialCuentaBanco($id){
       
        $idDecoded = $this->getIdDecoded($id);
        
        if(is_numeric($idDecoded) and ($this->hasPost('nombre')))
            
        {
            $model = new Banco();
            $model->id = $idDecoded;
            $model->nombre = $this->getPost('nombre');

            $tipoSerialCuentaBanco = new TipoSerialCuentaBanco();
            $tipoSerialCuentaBanco->banco_id = $model->id;

            $tiposSerialDeCuentaProvider = $tipoSerialCuentaBanco->search();
            $tipoSerialCuentaSelect = $tipoSerialCuentaBanco->getTiposSerialCuentaNoVinculadas($model->id);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            $this->renderPartial('_formListaTipoSerialCuentaBanco',array(
                'model' => $model,
                'tiposSerialDeCuentaProvider' => $tiposSerialDeCuentaProvider,
                'tipoSerialCuentaSelect'=> $tipoSerialCuentaSelect,
            )); 
        }
        else 
        {
            $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'No se han proporcionado los datos necesarios para ejecutar esta operación.'));
        }
    }
    
    public function actionEliminaTipoSerialCuentaBanco($id){
        $idDecoded = $this->getIdDecoded($id); // Id del TipoSerialCuentaBanco
        $statusResponse = 400;
        $mensaje = 'No se han proporcionado los datos necesarios para efectruar esta operación.';
        $bancoNombre=null;
        $bancoId=null;
        if(is_numeric($idDecoded) && $this->hasPost('bancoNombre') && $this->hasPost('bancoId')){
             $bancoId = base64_decode($this->getPost('bancoId'));
             $bancoNombre = $this->getPost('bancoNombre');
             $model = TipoSerialCuentaBanco::model()->findByPk($idDecoded);
             if($model){
                try{
                    $model->delete();
                    $this->registerLog('ELIMINACION', 'catalogo.banco.eliminaTipoSerialCuentaBanco', 'EXITOSO', 'Se ha eliminado el Tipo de serial '.$model->id.' al banco '.$bancoNombre.'. '.  json_encode($model->attributes));
                    $statusResponse = 200;
                    $mensaje = 'La eliminación del Tipo de Serial en el Banco '.htmlentities($bancoNombre).' ha sido efectuada exitosamente.';
                }
                catch(Exception $e){
                    $statusResponse = 500;
                    $mensaje = 'Se ha producido un error: '.$e->getMessage();
                }
             }
        }
        $response=array('status'=>$statusResponse, 'mensaje'=>$mensaje, 'bancoId'=>$bancoId, 'bancoNombre'=>$bancoNombre, 'tipoCuenta'=>$model->id);
        $this->jsonResponse($response);
    }
    
    public function getActionButtonsTiposSerialCuentaBanco($data){
        $id_encoded = $data["id"];
        $id = base64_encode($id_encoded);
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa fa-trash red", "title" => "Eliminar Tipo de Serial de Cuenta de este Banco", 'onClick' => 'eliminarTipoSerialCuentaBanco("'.$id.'");')) . '&nbsp;&nbsp;';
        $columna .= '</div>';
        return $columna;
    }
//FIN DE ACCIONES TIPO SERIAL CUENTA BANCO   
//ACCIONES DE CONTACTO

    
    
//FIN DE ACCIONES DE CONTACTO
}