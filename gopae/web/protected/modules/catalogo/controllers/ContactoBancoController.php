<?php

class ContactoBancoController extends Controller
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
        'read' => 'Consulta de ContactoBancoController',
        'write' => 'Creación y Modificación de ContactoBancoController',
        'admin' => 'Administración Completa  de ContactoBancoController',
        'label' => 'Módulo de ContactoBancoController'
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
                'actions' => array('lista', 'consulta', 'registro', 'edicion', 'eliminacion', 'activacion', 'listaContactoBanco', 'registroContactoBanco', 'edicionContactoBanco'),
                'pbac' => array('admin'),
            ),
            array('allow',
                'actions' => array('lista', 'consulta', 'registro', 'edicion', 'registroContactoBanco', 'edicionContactoBanco',),
                'pbac' => array('write'),
            ),
            array('allow',
                'actions' => array('lista', 'consulta', 'listaContactoBanco',),
                'pbac' => array('read'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    
    public function actionRegistroContactoBanco(){
        if(Yii::app()->request->isAjaxRequest){
            $statusResponse = 400;
            $mensaje = 'No se han proporcionado los datos necesarios para efectruar esta operación.';
            if($this->hasPost('ContactoBanco')){
                $model = new ContactoBanco();
                $contactoBancoFormData = $this->getPost('ContactoBanco');
                $model->attributes=$contactoBancoFormData;
                $model->beforeInsert();
                if($model->validate()){
                    if($model->save()){
                        $model->deleteCacheContactoBanco($model->banco_id);
                        $statusResponse = 200;
                        $contacto = $contactoBancoFormData['nombre_apellido'];
                        $this->registerLog('ESCRITURA', 'catalogo.banco.registroContactoBanco', 'EXITOSO', 'Se ha registrado un nuevo Tipo de Cuenta '.$contacto.'. '.  json_encode($model->attributes));
                        $mensaje = 'El Registro del Tipo de Cuenta '.htmlentities(ucwords(strtolower($contacto))).' ha sido efectuado exitosamente.';
                    }
                }
                else{
                    $mensaje = CHtml::errorSummary($model);
                }
            }
            $response=array('status'=>$statusResponse, 'mensaje'=>$mensaje, 'bancoId'=>$model->banco_id,  );
            $this->jsonResponse($response);

        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta operación mediante esta vía');
        }
    }

    /**
     * Lists all models.
     * @param integer $id Id del Banco
     */
    public function actionLista($id)
    {
        $bancoIdDecoded = $this->getIdDecoded($id);
        if(Yii::app()->request->isAjaxRequest && is_numeric($bancoIdDecoded)){
            $model=new ContactoBanco('search');
            $model->unsetAttributes();  // clear any default values
            $model->banco_id = $bancoIdDecoded;
            if($this->hasQuery('ContactoBanco')){
                $model->attributes=$this->getQuery('ContactoBanco');
            }
            $model->estatus = 'A';
            $dataProvider = $model->search();
            $this->renderPartial('admin',array(
                'model'=>$model,
                'dataProvider'=>$dataProvider,
            ));
        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta acción por medio de esta vía.');
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new ContactoBanco('search');
        $model->unsetAttributes();  // clear any default values
        if($this->hasQuery('ContactoBanco')){
            $model->attributes=$this->getQuery('ContactoBanco');
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
        $this->renderPartial('_view',array(
            'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @param integer $id Id del Banco
     */
    public function actionRegistro($id)
    {
        $model=new ContactoBanco;
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if($this->hasPost('ContactoBanco'))
        {
           $model->attributes=$this->getPost('ContactoBanco');
           $model->beforeInsert();
           if($model->save()){
                $this->redirect(array('consulta','id'=>$model->id));
            }
            if($model->save()){
                $this->registerLog('ESCRITURA', 'modulo.ContactoBanco.registro', 'EXITOSO', 'El Registro de los datos de ContactoBanco se ha efectuado exitósamente. Data-> '.json_encode($model->attributes));
                Yii::app()->user->setFlash('success', 'El proceso de registro de los datos se ha efectuado exitosamente');
                $this->redirect(array('edicion','id'=>base64_encode($model->id),));
            }
        }

        $this->renderPartial('create',array(
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

            if($this->hasPost('ContactoBanco'))
            {
                $model->attributes=$this->getPost('ContactoBanco');
                $model->beforeUpdate();
                if($model->save()){
                    $this->registerLog('ACTUALIZACION', 'modulo.ContactoBanco.edicion', 'EXITOSO', 'La Actualización de los datos de ContactoBanco se ha efectuado exitósamente. Data-> '.json_encode($model->attributes));
                    if(Yii::app()->request->isAjaxRequest){
                        $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La actualización de los Datos se ha efectuado de forma exitosa.'));
                        Yii::app()->end();
                    }
                }
            }

            $this->renderPartial('update',array(
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
        if(Yii::app()->request->isAjaxRequest){
            $idDecoded = $this->getIdDecoded($id);
            $model = $this->loadModel($idDecoded);
            if($model){
                $model->beforeDelete();
                //meter en try y catch los saves siempre
                if($model->save()){
                    $this->registerLog('ELIMINACION', 'modulo.ContactoBanco.eliminacion', 'EXITOSO', 'La Eliminación de los datos de ContactoBanco se ha efectuado exitósamente. Data-> '.json_encode($model->attributes));
                }
            }
        }
        else
        {
            throw new CHttpException(403, 'No está permitido efectuar esta acción por medio de esta vía.');
        }
    }
    
    /**
     * Activation of a particular model Logicaly Deleted.
     * If activation is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be activated
     */
    public function actionActivacion($id){
        
        if(Yii::app()->request->isAjaxRequest){
            $idDecoded = $this->getIdDecoded($id);
            $model = $this->loadModel($idDecoded);
            if($model){
                            $model->beforeActivate();

                //meter en try y catch los saves siempre
                if($model->save()){
                    $this->registerLog('ELIMINACION', 'modulo.ContactoBanco.activacion', 'EXITOSO', 'La Eliminación de los datos de ContactoBanco se ha efectuado exitósamente. Data-> '.json_encode($model->attributes));
                }
            }
        }
        else

        {
            throw new CHttpException(403, 'No está permitido efectuar esta acción por medio de esta vía.');
        }
    }

    public function actionListaContactoBanco($id)
    {
        $idDecoded = $this->getIdDecoded($id);
        
        if(is_numeric($idDecoded))
            
        {
            $model = new ContactoBanco();
            $model->id = $idDecoded;

            $contactoBanco = new ContactoBanco();
            $contactoBanco->banco_id = $model->id;

            $dataProvider = $contactoBanco->search();

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            $this->renderPartial('_listaContactoBanco',array(
                'model' => $model,
                'dataProvider' => $dataProvider,
            )); 
        }
        else 
        {
            $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'No se han proporcionado los datos necesarios para ejecutar esta operación.'));
        }
    }
    
    public function actionEdicionContactoBanco($id){
        if(Yii::app()->request->isAjaxRequest){
            $idBanco = ContactoBanco::model()->findByPk($id)->banco_id;
            $idDecodedBanco = $this->getIdDecoded($idBanco);
            $statusResponse = 400;
            $mensaje = 'No se han proporcionado los datos necesarios para efectruar esta operación.';
            if($this->hasPost('ContactoBanco')){
                $model = ContactoBanco::model()->findByPk($id);
                $contactoBancoFormData = $this->getPost('ContactoBanco');
                $model->attributes=$contactoBancoFormData;
                $model->banco_id = $idDecodedBanco;
                $model->beforeUpdate();
                if($model->validate()){
                    if($model->save()){
                        $model->deleteCacheContactoBanco($model->banco_id);
                        $statusResponse = 200;
                        $contacto = $contactoBancoFormData['nombre_apellido'];
                        $this->registerLog('ESCRITURA', 'catalogo.banco.registroContactoBanco', 'EXITOSO', 'Se ha registrado un nuevo Tipo de Cuenta '.$contacto.'. '.  json_encode($model->attributes));
                        $mensaje = 'El Registro del Tipo de Cuenta '.htmlentities(ucwords(strtolower($contacto))).' ha sido efectuado exitosamente.';
                    }
                }
                else{
                    $mensaje = CHtml::errorSummary($model);
                }
            }
            $response=array('status'=>$statusResponse, 'mensaje'=>$mensaje, 'bancoId'=>$model->banco_id,  );
            $this->jsonResponse($response);

        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta operación mediante esta vía');
        }
    }
    
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ContactoBanco the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if(is_numeric($id)){
            $model=ContactoBanco::model()->findByPk($id);
            if($model===null){
                throw new CHttpException(404,'The requested page does not exist.');
            }
            return $model;
        }
        else{
            return null;
        }
    }

    /**
     * Performs the AJAX validation.
     * @param ContactoBanco $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if($this->hasPost('ajax') && $this->getPost('ajax')==='contacto-banco-form')
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
        $idBoton= $id_encoded;
        $id = base64_encode($id_encoded);
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in boton-ver", "title" => "Ver datos", 'id'=>$id)) . '&nbsp;&nbsp;';
        $columna .= CHtml::link("", "", array("class" => "fa icon-pencil green boton-editar", "title" => "Editar datos", 'id'=>$id ))  . '&nbsp;&nbsp;';
        if($data->estatus=='A'){
            $columna .= CHtml::link("", "", array("class" => "fa icon-trash red boton-eliminar", "title" => "Eliminar", 'id'=>$id)) . '&nbsp;&nbsp;';
        }else{
            $columna .= CHtml::link("", "", array("class" => "fa fa-check green boton-activar", "title" => "Activar", 'id'=>$id)) . '&nbsp;&nbsp;';
        }
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
}
