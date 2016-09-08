<?php

class PerfilController extends Controller{
    
    public $layout = '//layouts/main';
    //Parametros para la administracion de permisos con userGroups
    static $_permissionControl = array('label' => 'Perfil de Usuario Logueado');

    // Uncomment the following methods and override them if needed
    public function filters() {
        // return the filter configuration for this controller, e.g.:
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', //Permite ejecutar la accion index a usuarios logeados
                'actions' => array('index','contacto'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        
        $this->csrfTokenName = 'changePasswordToken';
        
        $id = Yii::app()->user->id;
        
        $miscModel = $this->loadModel($id, 'changeMisc');
        $passModel = clone $miscModel;
        $passModel->setScenario('changePassword');
        $passModel->password = NULL;

        // pass the models inside the array for ajax validation
        $ajax_validation = array($miscModel, $passModel);

        // load additional profile models
        $profile_models = array();
        $profiles = array();
        foreach ($profiles as $p) {
            $external_profile = new $p;
            // check if the loaded profile has an update view
            $external_profile_views = $external_profile->profileViews();
            if (array_key_exists(UserGroupsUser::EDIT, $external_profile_views)) {
                // load the model data
                $loaded_data = $external_profile->findByAttributes(array('ug_id' => $id));
                $external_profile = $loaded_data ? $loaded_data : $external_profile;
                // set the scenario
                $external_profile->setScenario('updateProfile');
                // load the models inside both the ajax validation array and the profile models
                // array to pass it to the view
                $profile_models[$p] = $external_profile;
                $ajax_validation[] = $external_profile;
            }
        }

        // perform ajax validation
        $this->performAjaxValidation($ajax_validation);

        // check if an additional profile model form was sent
        if ($form = array_intersect_key($_POST, array_flip($profiles))) {
            $model_name = key($form);
            $form_values = reset($form);
            // load the form values into the model
            $profile_models[$model_name]->attributes = $form_values;
            $profile_models[$model_name]->ug_id = $id;

            // save the model
            if ($profile_models[$model_name]->save()) {
                Yii::app()->user->setFlash('user', Yii::t('userGroupsModule.general', 'Data Updated Succefully'));
                $this->redirect(Yii::app()->baseUrl . '/userGroups?_isAjax=1&u=' . $passModel->username);
            } else
                Yii::app()->user->setFlash('user', Yii::t('userGroupsModule.general', 'An Error Occurred. Please try later.'));
        }

        if (isset($_POST['UserGroupsUser']) && isset($_POST['formID'])) {
            // pass the right model according to the sended form and load the permitted values
            if ($_POST['formID'] === 'user-groups-password-form') {
                $model = $passModel;
                $model->old_password = $_POST['UserGroupsUser']['old_password'];
                $model->password = $_POST['UserGroupsUser']['password'];
                $model->password_confirm = $_POST['UserGroupsUser']['password_confirm'];
                //$model->question = $_POST['UserGroupsUser']['question'];
                //$model->answer = $_POST['UserGroupsUser']['answer'];
            } else if ($_POST['formID'] === 'user-groups-misc-form') {
                $model = $miscModel;
                $model->email = $_POST['UserGroupsUser']['email'];
                $model->home = $_POST['UserGroupsUser']['home'];
            }
            
            $model->cambio_clave = true;
            $model->user_act_id = $id;
            $model->date_act = date("Y-m-d H:i:s");
                
            if($this->validateCsrfToken()){
                if($model->validate()){
                    if($model->save()){
                        $this->registerLog('ACTUALIZACION', 'Basic.Perfil.contacto', 'EXITOSO', 'El usuario con el id='.$id.' ha cambiado su Clave de Acceso');
                        $this->renderPartial('resultado', array('miscModel' => $miscModel, 'passModel' => $passModel, 'profiles' => $profile_models), false, true);
                        die();
                    } else {
                        Yii::app()->user->setFlash('user', Yii::t('userGroupsModule.general', 'An Error Occurred. Please try later.'));
                    }
                }
            }else{
                $this->renderPartial('/msgBox', array('class' => 'errorDialogBox', 'message' => 'El código de protección CSRF no pudo ser verificado',), false, true);
            }
        }
        
        if (Yii::app()->request->isAjaxRequest || isset($_GET['_isAjax'])) {
            if(isset($_POST['formID'])){
                $this->renderPartial('resultado', array('miscModel' => $miscModel, 'passModel' => $passModel, 'profiles' => $profile_models), false, true);
            }
            else{
                $token = $this->getCsrfToken('Chávez Vive! MPPE y MPPCTI');
                $this->renderPartial('update', array('miscModel' => $miscModel, 'passModel' => $passModel, 'profiles' => $profile_models, 'token'=>$token), false, true);
            }
        }else{
            $token = $this->getCsrfToken('Chávez Vive! MPPE y MPPCTI');
            $this->render('update', array('miscModel' => $miscModel, 'passModel' => $passModel, 'profiles' => $profile_models, 'token'=>$token), false, true);
        }
        
    }
    
    public function actionContacto(){
        
        $this->csrfTokenName = 'changePasswordToken';
        
        if($this->validateCsrfToken()){
            
            $id = Yii::app()->user->id;
            $model = $this->loadModel($id, 'contacto');
            $model->attributes = $_POST['UserGroupsUser'];
            
            if($model->validate()){
                
                $model->user_act_id = $id;
                $model->date_act = date("Y-m-d H:i:s");
                
                if($model->save()){
                    $this->registerLog('ACTUALIZACION', 'Basic.Perfil.contacto', 'EXITOSO', 'El usuario con el id='.$id.' ha cambiado sus datos de contacto');
                    $this->renderPartial('/msgBox', array('class' => 'successDialogBox', 'message' => 'Los datos han sido actualizados exitosamente.',), false, true);
                    die();
                }
                else {
                    $this->registerLog('ACTUALIZACION', 'Basic.Perfil.contacto', 'ERROR', 'El usuario con el id='.$id.' ha intentado cambiar sus datos de contacto. Ha ocurrido un error.');
                    $this->renderPartial('/msgBox', array('class' => 'errorDialogBox', 'message' => 'Ha ocurrido un error, intentelo de nuevo más tarde. Si sigue presentando el mismo error notifiquelo a los administradores del sistema para su solución.',), false, true);
                }
            }
            else{
                
                $this->registerLog('ACTUALIZACION', 'Basic.Perfil.contacto', 'NO EXITOSO', 'El usuario con el id='.$id.' ha intentado cambiar sus datos de contacto. Datos no válidos.');
                $this->renderPartial('/msgBox', array('class' => 'errorDialogBox', 'message' => CHtml::errorSummary($model),), false, true);
                
            }
            
        }
        else{
            $this->registerLog('ACTUALIZACION', 'Basic.Perfil.contacto', 'NO EXITOSO', 'El usuario con el id='.$id.' ha intentado cambiar sus datos de contacto. TOKEN CSRF no válido.');
            $this->renderPartial('/msgBox', array('class' => 'errorDialogBox', 'message' => 'El código de protección CSRF no pudo ser verificado. Recargue la página e intentelo de nuevo.',), false, true);
        }
        
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
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
}