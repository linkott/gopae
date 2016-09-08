<?php

/**
 * Description of AutoridadesZonaController
 *
 * @author ticme
 */
class AutoridadesZonaController extends Controller {
    
    //despues de la declaración de la clase va el siguiente codigo
    public $layout = '//layouts/main';
    static $_permissionControl = array(
        'read' => 'Consulta de Autoridades de Zona Educativa',
        'write' => 'Consulta de Autoridades de Zona Educativa',
        'label' => 'Consulta de Autoridades de Zona Educativa'
    );

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
                'actions' => array('index', 'getAutoridadZonaEstado', 'controlAutoridadZonaEstado', 'getRegistroControlAutoridadZona', 'cambiarCorreo', 'resetearClave'),
                'pbac' => array('read', 'write',),
            ),
            array('allow',
                'actions' => array('autoridadZonaEstado', 'controlAutoridadZonaEstado', 'getRegistroControlAutoridadZona', 'cambiarCorreo', 'resetearClave'),
                'pbac' => array('admin',),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    /**
     * Esta action permite obtener los datos de un líder de Zona y presentarlos
     * en un formulario para que un usuario autorizado pueda cambiar datos
     * selectivamente de Usuario o Cuenta del Jefe de Zona. Se pueden hacer
     * cambios de correo y reseteo de clave mediante el formulario que arroja
     * como respuesta esta action.
     *
     * @throws CHttpException
     */
    public function actionGetAutoridadZonaEstado(){

        if (Yii::app()->request->isAjaxRequest) {

            if ($this->getPost('estado_id') && is_numeric($this->getPost('estado_id'))) {

                $estado_id = $this->getPost('estado_id');

                $zona = new AutoridadZonaEducativa();
                $autoridadZona = $zona->getAutoridadZonaFromEstado($estado_id);

                if ($autoridadZona) {

                    $this->renderPartial('datosAutoridadZona', array('model' => $autoridadZona), false, true);

                } else {

                    $this->renderPartial('//msgBox', array('class' => 'alertDialogBox', 'message' => 'Esta Zona educativa no posee datos de Contacto.'), false, true);
                }
            } else {
                throw new CHttpException(404, 'Recurso no encontrado. Datos incompletos.');
            }
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }
    
    /**
     * Esta action permite a un usuario autorizado efectuar el registro de Control
     * de Carga de Datos por parte de las autoridades de las zonas educativas
     * indicando las respuestas que han obtenido cuando han efectuado el control
     * actividades de este tipo.
     *
     * @throws CHttpException
     */
    public function actionControlAutoridadZonaEstado(){
        
        if(Yii::app()->request->isAjaxRequest){
            
            //var_dump($this->getPost('estado_id') && is_numeric($this->getPost('estado_id')) && strlen($this->getPost('control_zona_observacion')));
            
            if($this->getPost('estado_id') && is_numeric($this->getPost('estado_id')) && strlen($this->getPost('control_zona_observacion'))){
                
                $observacion = $this->getPost('control_zona_observacion');
                
                $estado_id = $this->getPost('estado_id');
                $zona = new AutoridadZonaEducativa();
                $autoridadZona = $zona->getAutoridadZonaFromEstado($estado_id);
                
                if($autoridadZona){
                    
                    $control = new ControlZonaEducativa();
                    $control->actividad = "Registro de Directores de Planteles";
                    $control->zona_educativa_id = $autoridadZona["id"];
                    $control->observacion = $observacion;
                    $control->usuario_ini_id = Yii::app()->user->id;
                    $control->estatus = 'A';
                    $control->fecha_ini = date('Y-m-d H:i:s');
                                        
                    if($control->save()){
                        
                        $this->registerLog('ESCRITURA', 'Control.AutoridadesZona.ControlAutoridadZonaEstado', 'EXITOSO', 'El usuario con el id='.Yii::app()->user->id.' ha ingresado un Registro de Control de Actividades con Zonas Educativas.');
                        
                        $this->renderPartial('//msgBox', array('class'=>'successDialogBox','message'=>'Datos registrados exitosamente.'), false, true);
                        
                    }else{
                        
                        $this->renderPartial('//msgBox', array('class'=>'errorDialogBox','message'=>CHtml::errorSummary($control)), false, true);
                        
                    }
                    
                }else{
                    
                    $this->renderPartial('//msgBox', array('class'=>'alertDialogBox','message'=>'Esta Zona educativa no posee datos de Contacto.'), false, true);
                    
                }
                
            }else{
                throw new CHttpException(404, 'Recurso no encontrado. Datos incompletos.');
            }
            
        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
        
    }
    
    /**
     * Esta action le muestra al usuario autorizado el registro histórico de las
     * las actividades de control de Carga de Datos por parte de las autoridades de las zonas educativas
     *
     * @throws CHttpException
     */
    public function actionGetRegistroControlAutoridadZona(){
        
        if(Yii::app()->request->isAjaxRequest){
            
            //var_dump($this->getPost('estado_id') && is_numeric($this->getPost('estado_id')) && strlen($this->getPost('control_zona_observacion')));
            
            if($this->getPost('estado_id') && is_numeric($this->getPost('estado_id'))){
                
                $estado_id = $this->getPost('estado_id');
                $zona = new AutoridadZonaEducativa();
                $autoridadZona = $zona->getAutoridadZonaFromEstado($estado_id);
                
                if($autoridadZona){
                    
                    $control = new ControlZonaEducativa();
                    $control->zona_educativa_id = $autoridadZona["id"];
                    $control->estatus = 'A';
                    
                    $registroControl = $control->search();
                                        
                    if($registroControl){
                        
                        $this->renderPartial('repRegistroControl', array('dataProvider'=>$registroControl), false, true);
                        
                    }else{
                        
                        $this->renderPartial('//msgBox', array('class'=>'errorDialogBox','message'=>'No se han encontrado Registros de Control'), false, true);
                        
                    }
                    
                }else{
                    
                    $this->renderPartial('//msgBox', array('class'=>'alertDialogBox','message'=>'Esta Zona educativa no posee datos de Contacto ni Registros de Control.'), false, true);
                    
                }
                
            }else{
                throw new CHttpException(404, 'Recurso no encontrado. Datos incompletos.');
            }
            
        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
        
    }
    
    public function actionCambiarCorreo(){
            
        if (Yii::app()->request->isAjaxRequest) {

            //var_dump($this->getPost('estado_id') && is_numeric($this->getPost('estado_id')) && strlen($this->getPost('control_zona_observacion')));

            $idDecoded = (int) base64_decode($this->getPost('id'));

            if ($this->getPost('id') && is_numeric($idDecoded) && strlen($this->getPost('email')) > 0 && strlen($this->getPost('emailBackup')) > 0) {

                $email = $this->getPost('email');
                $emailBackup = $this->getPost('emailBackup');

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $user = new UserGroupsUser('update');

                    $model = $this->loadUserModel($idDecoded, 'contacto');
                    
                    $model->email = $this->getPost('email');
                    $model->date_act = date('Y-m-d H:i:s');
                    $model->user_act_id = Yii::app()->user->id;

                    if ($model) {

                        if ($model->save()) {

                            $this->registerLog('ESCRITURA', 'Control.AutoridadesZona.cambiarCorreo', 'EXITOSO', 'El usuario con el id=' . Yii::app()->user->id . ' ha cambiado el correo de un Representante de Zona Educativa de <' . $emailBackup . '> a <' . $email . '>.');
                            $this->renderPartial('//msgBox', array('class' => 'successDialogBox', 'message' => 'El Nuevo Correo Electrónico ha sido actualizado exitosamente.'), false, true);

                        } else {

                            $this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => CHtml::errorSummary($model)), false, true);
                        }
                    } else {

                        $this->renderPartial('//msgBox', array('class' => 'alertDialogBox', 'message' => 'La persona a la que desea modificar el correo no se encuentra registradas. Recargue la página e intentelo de nuevo.'), false, true);
                    }

                } else {

                    $this->renderPartial('//msgBox', array('class' => 'successDialogBox', 'message' => 'Este no parece ser un correo electrónico válido.'), false, true);
                }

            } else {
                throw new CHttpException(500, 'Recurso no encontrado. Datos incompletos.');
            }
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

    public function actionResetearClave(){
        
        if(Yii::app()->request->isAjaxRequest){
            
            //var_dump($this->getPost('estado_id') && is_numeric($this->getPost('estado_id')) && strlen($this->getPost('control_zona_observacion')));
            
            $idDecoded = base64_decode($this->getPost('id'));
            
            if($this->getPost('id') && is_numeric($idDecoded)){
                
                $model = $this->loadUserModel($idDecoded, 'update');
                
                $password = $model->getRandomPassword();
                $salt = $model->getSalt();
                $model->password = md5($password . $salt);

                $model->status = 4;
                $model->cambio_clave = false;
                $model->date_act = date('Y-m-d H:i:s');
                $model->user_act_id = Yii::app()->user->id;
                $model->activation_code = null;
                $model->activation_time = null;

                if($model){

                    if($model->save()){

                        $this->registerLog('ADMINISTRACION', 'Control.AutoridadesZona.resetearClave', 'EXITOSO', 'El usuario con el id='.Yii::app()->user->id.' ha reseteado el password del usuario con la C.I.: <'.$model->cedula.'>.');

                        $this->renderPartial('//msgBox', array('class'=>'successDialogBox','message'=>'Se ha reseteado la clave del usuario exitosamente. El Usuario: <b>'.$model->username.'</b> ahora posee la Clave: <b>'.$password.'</b>.'), false, true);

                    }else{

                        $this->renderPartial('//msgBox', array('class'=>'errorDialogBox','message'=>CHtml::errorSummary($model)), false, true);

                    }

                }else{

                    $this->renderPartial('//msgBox', array('class'=>'alertDialogBox','message'=>'La persona a la que desea modificar el correo no se encuentra registradas. Recargue la página e intentelo de nuevo.'), false, true);

                }
                
            }else{
                throw new CHttpException(404, 'Recurso no encontrado. Datos incompletos.');
            }
            
        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
        
    }
    
    public function loadUserModel($id, $scenario = false) {

        $model = UserGroupsUser::model()->findByPk((int) $id);

        if ($model === null || ($model->relUserGroupsGroup->level > Yii::app()->user->level))
            throw new CHttpException(403, 'El recurso solicitado no se ha encontrado o puede que su perfil de usuario no posea acceso a este recurso.');
        if ($scenario)
            $model->setScenario($scenario);
        return $model;
    }
    
    
}
