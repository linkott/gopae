<?php

class UsuarioController extends Controller
{
    //public $layout='//layouts/cuerpo';   // DEFINICIÒN DEL LAYOUT

    public $defaultAction = 'admin';
    // PARTE I
    static $_permissionControl = array(
        'read' => 'Consulta de Usuarios',
        'write' => 'Administración de Usuarios',
        'admin' => 'Jefe de Administración de Usuarios',
        'label' => 'Administración de Usuarios del Sistema'
    );

    /**
     * 
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

        //en esta seccion colocar los action de solo lectura o consulta
       return array(
            array('allow',
                'actions' => array('index', 'admin', 'create', 'update', 'view', 'delete', 'nuevo', 'edicion', 'CambiarEstatus', 'buscarCedula'),
                'pbac' => array('admin', 'admin.admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
        
    }

    public function actionAdmin() {

        $confDataProvider = new CActiveDataProvider('UserGroupsConfiguration', array(
                'pagination' => array('pageSize' => 20),
                'sort' => array(
                    'defaultOrder' => 'date_act DESC, date_ini DESC',
                ),
            )
        );
        $userModel = new UserGroupsUser('search');
        $userModel->unsetAttributes();

        // load the filtering data to the user model
        if (isset($_GET['UserGroupsUser'])) {
            $userModel->attributes = $_GET['UserGroupsUser'];
            $userModel->last_login = $_GET['UserGroupsUser']['last_login'];
            $userModel->status = $_GET['UserGroupsUser']['status'];
            //var_dump($userModel);
        }
        
        // checks if the page was loaded as ajax
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('admin', array('confDataProvider' => $confDataProvider, 'userModel' => $userModel), false, false);
        } else {
            $this->render('admin', array('confDataProvider' => $confDataProvider, 'userModel' => $userModel,));
        }
    }

    public function actionView($id) {

        if (Yii::app()->request->isAjaxRequest) {

            $idDecoded = base64_decode($id);

            $model = $this->loadModel($idDecoded, 'changeMisc');

            if (is_numeric($idDecoded) && $model) {

                $dataProvider = array();
                
                $dataProvider = UserGroupsAccess::controllerList($model->group_id, $idDecoded);

                $this->renderPartial('view', array('model' => $model, 'dataProvider' => $dataProvider, 'id' => $id));
            } else {

                throw new CHttpException(404, 'No se ha encontrado el Centro que ha solicitado. Recargue la página e intentelo de nuevo.');
            }
        } else {

            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción mediante esta vía.');
        }
    }

    public function actionNuevo() {

        if (Yii::app()->user->pbac('admin')) {
            
            $this->csrfTokenName = 'userAdminToken';
            
            $model = new UserGroupsUser('create');
            $dataProvider = UserGroupsAccess::controllerList('new');

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            
            $grupos = UserGroupsGroup::groupList();
            $estados = Estado::estadosList();
            $home_lists = UserGroupsAccess::homeList();
            $status = UserGroupsLookup::statusList();
            
            if (isset($_POST['UserGroupsAccess'])) {
                //var_dump($_POST['UserGroupsAccess']);
                //die();
                $model->attributes = $_POST['UserGroupsAccess'][1];
                $model->user_ini_id = Yii::app()->user->id;
                if($this->validateCsrfToken()){
                    if($model->validate()){
                        if ($model->save()) {

                            $this->registerLog('ESCRITURA', 'userGroups.usuario.nuevo', 'EXITOSO', 'Creación de un Nuevo Usuario con la cedula '.$model->cedula);

                            Yii::app()->user->setFlash('user', "El Usuario <b>{$model->username}</b> ha sido creado exitosamente.");
                            if (isset($_POST['UserGroupsAccess']) && !isset($_POST['UserGroupsAccess']['delete']) && $model->validate()) {
                                $this->accessPermissionSave($_POST['UserGroupsAccess'], $model->id);
                                $this->redirect(Yii::app()->baseUrl . '/userGroups/usuario');
                            }
                        } else {
                            Yii::app()->user->setFlash('error', "No se ha podido completar la operación. Intentelo de nuevo más tarde.");
                        }
                    }
                }
                else{
                    $model->addError('userAdminToken', 'El token de Seguridad es inválido. Recargue la página e intentelo nuevamente.');
                }
            }
            if (Yii::app()->request->isAjaxRequest) {
                throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción mediante esta vía.');
            } else {
                $token = $this->getCsrfToken('Chávez Vive! MPPE y MPPCTI');
                $this->render('create', array(
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'data' => $model,
                    'estados' => $estados,
                    'grupos' => $grupos,
                    'home_lists' => $home_lists,
                    'status' => $status,
                    'token' => $token,
                    'id' => 'new',
                ));
            }
        } else {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }
    }

    public function actionEdicion($id) {
        
        if (Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción mediante esta vía.');
        } else {
            
            $this->csrfTokenName = 'userAdminToken';
            
            if (Yii::app()->user->pbac('admin')) {

                $idDecoded = base64_decode($id);
                
                if (is_numeric($idDecoded)) {

                    $model = UserGroupsUser::model()->findByPk($idDecoded);
                    
                    if ($model) {
                    
                        $model->setScenario('update');
                        $dataProvider = UserGroupsAccess::controllerList($model->group_id, $idDecoded);

                        $grupos = UserGroupsGroup::groupList();
                        $estados = Estado::estadosList();
                        $home_lists = UserGroupsAccess::homeList();
                        $status = UserGroupsLookup::statusList();

                        // Uncomment the following line if AJAX validation is needed
                        // $this->performAjaxValidation($model);

                        if (isset($_POST['UserGroupsAccess'])) {

                            $backupPassword = $model->password;

                            $model->attributes = $_POST['UserGroupsAccess'][1];
                            $model->password_confirm = $_POST['UserGroupsAccess'][1]['password_confirm'];
                            $model->user_act_id = Yii::app()->user->id;
                            $model->date_act = date('Y-m-d H:i:s');

                            if(strlen(trim($model->password))==0){
                                $model->password = $backupPassword;
                            }else{
                                $model->cambio_clave = false;
                            }
                            
                            if($this->validateCsrfToken()){
                                
                                if($idDecoded==$this->getPost('id')){
                                
                                    if($model->validate()){

                                        if($model->password==$model->password_confirm || $model->password == $backupPassword){

                                            if($model->password != $backupPassword && strlen($model->password)>0){
                                                //b6c2171710a705cb27f0d8f47ceff177 (admin)
                                                $salt = $model->getSalt();
                                                $model->password = md5($model->password . $model->getSalt());
                                            }

                                            if ($model->save()) {

                                                $this->registerLog('ESCRITURA', 'userGroups.usuario.edicion', 'EXITOSO', 'Edición de Datos de un Usuario');

                                                Yii::app()->user->setFlash('user', "Los Datos del Usuario <b>{$model->username}</b> han sido actualizados exitosamente.");
                                                if (isset($_POST['UserGroupsAccess']) && !isset($_POST['UserGroupsAccess']['delete']) && $model->validate()) {
                                                    $this->accessPermissionSave($_POST['UserGroupsAccess'], $model->id);
                                                    $this->redirect(Yii::app()->baseUrl . '/userGroups/usuario');
                                                }
                                            } else {
                                                Yii::app()->user->setFlash('error', "No se ha podido completar la última operación.");
                                            }
                                        }
                                        else{
                                            $model->addError('password', '(239) La Clave de Confirmación no coincide con la Clave Nueva Ingresada.');
                                        }
                                    }
                                }
                                else{
                                    $model->addError('id', 'Ha ocurrido un error. vuelva a la página de lista de usuarios e intentelo de nuevo.');
                                }
                                
                            }
                            else{
                                $model->addError('userAdminToken', 'El token de Seguridad es inválido. Recargue la página e intentelo nuevamente.');
                            }

                        }
                        
                        $token = $this->getCsrfToken('Chávez Vive! MPPE y MPPCTI');
                        $this->render('edit', array(
                            'model' => $model,
                            'dataProvider' => $dataProvider,
                            'data' => $model,
                            'estados' => $estados,
                            'grupos' => $grupos,
                            'home_lists' => $home_lists,
                            'status' => $status,
                            'token' => $token,
                            'id' => $idDecoded,
                        ));
                        
                    } else {

                        throw new CHttpException(404, 'No se ha encontrado el Usuario que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
                    }
                } else {

                    throw new CHttpException(404, 'No se ha encontrado el Usuario que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
                }
            } else {
                throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
            }
        }
    }

    public function actionCambiarEstatus($id) {

        if (!Yii::app()->user->pbac('admin')) {
            
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
            
        } else {
            
            $accion = $this->getPost('accion');

            if(in_array($accion, array('E','A'))){

                $idDecoded = base64_decode($id);

                $user = new UserGroupsUser();

                if (is_numeric($idDecoded)) {

                    $model = UserGroupsUser::model()->findByPk($idDecoded);

                    if ($model) {

                        $result = $user->changeStatusGroup($idDecoded, $accion);

                        if ($result->isSuccess) {
                            
                            if($accion=='E'){
                                $this->registerLog('ELIMINACION', 'userGroups.usuario.cambiarEstatus', 'EXITOSO', 'Se ha Inactivado el Usuario ' . $model->username);
                            }
                            else{
                                $this->registerLog('ESCRITURA', 'userGroups.usuario.cambiarEstatus', 'EXITOSO', 'Se ha Activado el Usuario ' . $model->username);
                            }

                            $class = 'successDialogBox';
                            $message = $result->message;

                            $this->renderPartial('//msgBox', array(
                                'class' => $class,
                                'message' => $message,
                            ));
                            
                        } else {
                            throw new CHttpException(500, 'Error: No se ha podido completar la operación, comuniquelo al administrador del sistema para su corrección.');
                        }
                    } else {
                        throw new CHttpException(404, 'No se ha encontrado el Usuario que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
                    }
                } else {
                    throw new CHttpException(404, 'No se ha encontrado el Usuario que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
                }
                
            }
            else{
                
                $class = 'errorDialogBox';
                $message = 'No se ha especificado la acción a tomar sobre el usuario, recargue la página e intentelo de nuevo.';

                $this->renderPartial('//msgBox', array(
                    'class' => $class,
                    'message' => $message,
                ));
                
            }
        }
    }

    /**
     * save the access permission data for both user and users
     * @param Array $formData
     */
    private function accessPermissionSave($formData, $element_id) {

        if ((int) $formData['id'] === UserGroupsUser::ROOT) {
            Yii::app()->user->setFlash('error', Yii::t('userGroupsModule.admin', 'You cannot change the Access Permission of the Root User'));
        } else if ($formData['id'] === 'new' && !Yii::app()->user->pbac('admin')) {
            Yii::app()->user->setFlash('error', Yii::t('userGroupsModule.admin', 'You cannot create a new user or user'));
        } else if ($formData['id'] !== 'new' && !is_numeric($formData['id'])) {
            Yii::app()->user->setFlash('error', Yii::t('userGroupsModule.admin', 'You didn\'t supply a valid id'));
        } else {

            if (!isset($element_id) && is_numeric($formData['id'])) { // fix for users with no admin permissions
                if ((int) $formData['what'] === UserGroupsAccess::GROUP) {
                    $element_id = UserGroupsUser::model()->findByPk((int) $formData['id'])->id;
                }
            }

            if (isset($formData['access'])) {
                // initialize the array containing the existing permissions records
                $ex_array = array();
                // load the existing permissions for the element
                $existing = UserGroupsAccess::model()->findAllByAttributes(array('element' => (int) $formData['what'], 'element_id' => $element_id));
                // iterate the existing permission
                if ($existing) {
                    foreach ($existing as $e) {
                        $ex_array[$e->id] = $e->module . '.' . $e->controller . '.' . $e->permission;
                    }
                }

                // iterate the submitted permissions
                foreach ($formData['access'] as $key => $val) {
                    // check if the permission already exist otherwise creates it
                    if (array_search($key, $ex_array) === false) {
                        // extract the permission data
                        $k = explode('.', $key);
                        // create the new permission
                        $new_permission = new UserGroupsAccess;
                        $new_permission->element = (int) $formData['what'];
                        $new_permission->element_id = (int) $element_id;
                        $new_permission->module = $k[0];
                        $new_permission->controller = $k[1];
                        $new_permission->permission = $k[2];
                        $new_permission->user_ini_id = Yii::app()->user->id;
                        $new_permission->save();
                    } else {
                        // find and delete the key from the ex_array
                        unset($ex_array[array_search($key, $ex_array)]);
                    }
                }


                // delete from the database the records corresponding to those still inside the ex_array
                if (count($ex_array)) {
                    UserGroupsAccess::model()->deleteAll('id IN (' . implode(', ', array_flip($ex_array)) . ')');
                }
            } else { // clear permissions
                UserGroupsAccess::model()->deleteAllByAttributes(array('element' => (int) $formData['what'], 'element_id' => $element_id));
            }

            if ($formData['id'] === 'new') {
                Yii::app()->user->setFlash('user', Yii::t('userGroupsModule.admin', 'New user Created.', array('{what}' => $formData['what'])));
            } else {
                Yii::app()->user->setFlash('user', Yii::t('userGroupsModule.admin', 'Data and Access Permission of <i>{displayname} user</i> changed', array('{displayname}' => $formData['displayname'])));
            }
        }
    }
    
    public function actionBuscarCedula() {

        $cedula = $this->getPost('cedula');

        if ($cedula) {

            $autoridadPlantel = new AutoridadPlantel();

            $numeroCedula = substr($cedula, 2);

            $origen = substr($cedula, 0, 1);
            
            if(is_numeric($numeroCedula) && (int)$numeroCedula <= 2147483647){
                $busquedaCedula = $autoridadPlantel->busquedaSaime($origen, $numeroCedula); // valida si existe la cedula en la tabla saime
                if(!$busquedaCedula){
                    $origen = 'E';
                    $busquedaCedula = $autoridadPlantel->busquedaSaime($origen, $numeroCedula); // valida si existe la cedula en la tabla saime
                }
            }else{
                $busquedaCedula = null;
            }
            
            
            if (!$busquedaCedula) {
                $mensaje = "Esta Cedula de Identidad no se encuentra registrada en nuestro sistema, si cree que esto puede ser un error "
                        . "por favor contacte al personal de soporte mediante "
                        . "<a href='mailto:soporte.gescolar@me.gob.ve'>soporte.gescolar@me.gob.ve</a>";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje, 'usuario' => $cedula . $this->generarLetraFromCedula($numeroCedula))); // NO EXISTE EN SAIME
                Yii::app()->end();
            } else {
                echo json_encode(array('statusCode' => 'successU', 'nombre' => $busquedaCedula['nombre'], 'apellido' => $busquedaCedula['apellido'], 'usuario' => $busquedaCedula['cedula'] . $this->generarLetraFromCedula($cedula)));
            }
        } else {
            $mensaje = "No ha ingresado los parámetros necesarios para cumplir con la respuesta a su petición. La Cédula debe contener caracteres numéricos.";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje)); // NO EXISTE EN SAIME
        }
    }

    public static function generarLetraFromCedula($cedula){
        
        if(is_numeric($cedula)){
            $numero = $cedula;
        }
        else{
            $numero = substr($cedula, 2);
        }
        
        $letra = substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($numero, "XYZ", "012")%23, 1);
        
        return $letra;
        
    }
    
    public function loadModel($id, $scenario = false) {
        $model = UserGroupsUser::model()->findByPk((int) $id);
        if ($model === null || ($model->relUserGroupsGroup->level > Yii::app()->user->level && !UserGroupsConfiguration::findRule('public_profiles')))
            throw new CHttpException(404, Yii::t('userGroupsModule.general', 'The requested page does not exist.'));
        if ($scenario)
            $model->setScenario($scenario);
        return $model;
    }
    
    /**
     * 
     * @param array $data
     * @return string
     */
    public function columnaAcciones($data) {
        $columna = '<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">';

        if (Yii::app()->user->pbac('userGroups.admin.admin')) {
            $id = $data["id"];
            $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in look-data", "data-id" => base64_encode($data->id), "title" => "Consultar Usuario")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", '/userGroups/usuario/edicion/id/' . base64_encode($data->id), array("class" => "fa fa-pencil green edit-data", "data-id" => base64_encode($data->id), "title" => "Editar Datos del Usuario")) . '&nbsp;&nbsp;';
        }
        
        $columna .= '</div>';
        
        return $columna;
    }
}