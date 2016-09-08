<?php

class GrupoController extends Controller {

    //public $layout='//layouts/cuerpo';   // DEFINICIÒN DEL LAYOUT

    public $defaultAction = 'admin';
    // PARTE I
    static $_permissionControl = array(
        'read' => 'Consulta de Grupos de Usuarios',
        'write' => 'Administración de Grupos de Usuarios',
        'admin' => 'Jefe de Administración de Grupos de Usuarios',
        'label' => 'Grupos de Usuarios'
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
                'actions' => array('index', 'admin', 'create', 'update', 'view', 'delete', 'nuevo', 'edicion', 'cambiarEstatus'),
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
                'defaultOrder' => 'fecha_act DESC, fecha_ini DESC',
            ),
                )
        );
        $groupModel = new UserGroupsGroup('search');
        $groupModel->unsetAttributes();

        // load the filtering data to the group model
        if (isset($_GET['UserGroupsGroup'])) {
            $groupModel->attributes = $_GET['UserGroupsGroup'];
            $groupModel->estatus = $_GET['UserGroupsGroup']['estatus'];
            //var_dump($groupModel);
        }

        // checks if the page was loaded as ajax
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('admin', array('confDataProvider' => $confDataProvider, 'groupModel' => $groupModel), false, false);
        } else {
            $this->render('admin', array('confDataProvider' => $confDataProvider, 'groupModel' => $groupModel,));
        }
    }

    public function actionView($id) {

        if (Yii::app()->request->isAjaxRequest) {

            $idDecoded = base64_decode($id);

            $model = UserGroupsGroup::model()->viewGroup($idDecoded);

            if (is_numeric($idDecoded) && $model) {

                $additionalData = new UserGroupsGroup();

                $additionalData = $additionalData->findByPk((int) $idDecoded);

                $dataProvider = array();

                if (Yii::app()->user->level > $additionalData->level) { // check if the user/group level is inferior to the user who is checking the permissions
                    // load the controllerlist of user or groups
                    $dataProvider = UserGroupsAccess::controllerList($idDecoded);
                }

                $this->renderPartial('view', array('model' => $model, 'dataProvider' => $dataProvider, 'data' => $additionalData, 'id' => $id));
            } else {

                throw new CHttpException(404, 'No se ha encontrado el Centro que ha solicitado. Recargue la página e intentelo de nuevo.');
            }
        } else {

            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción mediante esta vía.');
        }
    }

    public function actionNuevo() {

        if (Yii::app()->user->pbac('admin')) {

            $model = new UserGroupsGroup('create');
            $dataProvider = UserGroupsAccess::controllerList('new');

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['UserGroupsGroup'])) {
                $model->attributes = $_POST['UserGroupsGroup'];
                $model->user_ini_id = Yii::app()->user->id;
                if ($model->save()) {

                    $this->registerLog('ESCRITURA', 'userGroups.grupo.nuevo', 'EXITOSO', 'Creación de un Nuevo Grupo de Usuarios');

                    Yii::app()->user->setFlash('group', "El Grupo <b>{$model->groupname}</b> ha sido creado exitosamente.");
                    if (isset($_POST['UserGroupsAccess']) && !isset($_POST['UserGroupsAccess']['delete']) && $model->validate()) {
                        $this->accessPermissionSave($_POST['UserGroupsAccess'], $model->id);
                        $this->redirect(Yii::app()->baseUrl . '/userGroups/grupo');
                    }
                } else {
                    Yii::app()->user->setFlash('error', "No se ha podido completar la operación. Intentelo de nuevo más tarde.");
                }
            }
            if (Yii::app()->request->isAjaxRequest) {
                throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción mediante esta vía.');
            } else {
                $this->render('create', array(
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'data' => $model,
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

            if (Yii::app()->user->pbac('admin')) {

                $idDecoded = base64_decode($id);

                if (is_numeric($idDecoded)) {

                    $model = UserGroupsGroup::model()->findByPk($idDecoded);

                    if ($model) {

                        if ($model->estatus == 'A') {

                            $model->setScenario('update');
                            $dataProvider = UserGroupsAccess::controllerList($idDecoded);

                            // Uncomment the following line if AJAX validation is needed
                            // $this->performAjaxValidation($model);

                            if (isset($_POST['UserGroupsGroup'])) {

                                $model->attributes = $_POST['UserGroupsGroup'];
                                $model->user_act_id = Yii::app()->user->id;
                                $model->date_act = date('Y-m-d H:i:s');


                                if ($model->validate() && $model->save()) {

                                    $this->registerLog('ESCRITURA', 'userGroups.grupo.edicion', 'EXITOSO', 'Edición de Datos de un Grupo de Usuarios');

                                    Yii::app()->user->setFlash('group', "Los Datos del Grupo <b>{$model->groupname}</b> ha sido actualizado exitosamente.");
                                    if (isset($_POST['UserGroupsAccess']) && !isset($_POST['UserGroupsAccess']['delete']) && $model->validate()) {
                                        $this->accessPermissionSave($_POST['UserGroupsAccess'], $model->id);
                                        $this->redirect(Yii::app()->baseUrl . '/userGroups/grupo');
                                    }
                                } else {
                                    Yii::app()->user->setFlash('error', "No se ha podido completar la última operación.");
                                }
                            }

                            $this->render('edit', array(
                                'model' => $model,
                                'dataProvider' => $dataProvider,
                                'data' => $model,
                                'id' => $idDecoded,
                            ));
                        } else {

                            throw new CHttpException(404, 'No se ha encontrado el Grupo que ha solicitado. Puede que el grupo no se encuentre activo. Vuelva a la página anterior e intentelo de nuevo.');
                        }
                    } else {

                        throw new CHttpException(404, 'No se ha encontrado el Grupo que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
                    }
                } else {

                    throw new CHttpException(404, 'No se ha encontrado el Grupo que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
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

            if (in_array($accion, array('E', 'A'))) {

                $idDecoded = base64_decode($id);

                $group = new UserGroupsGroup();

                if (is_numeric($idDecoded)) {

                    $model = UserGroupsGroup::model()->findByPk($idDecoded);

                    if ($model) {

                        $result = $group->changeStatusGroup($idDecoded, $accion);

                        if ($result->isSuccess) {

                            if ($accion == 'E') {
                                $this->registerLog('ELIMINACION', 'userGroups.grupo.cambiarEstatus', 'EXITOSO', 'Se ha Inactivado el Grupo de Usuarios ' . $model->groupname);
                            } else {
                                $this->registerLog('ESCRITURA', 'userGroups.grupo.cambiarEstatus', 'EXITOSO', 'Se ha Activado el Grupo de Usuarios ' . $model->groupname);
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
                        throw new CHttpException(404, 'No se ha encontrado el Grupo que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
                    }
                } else {
                    throw new CHttpException(404, 'No se ha encontrado el Grupo que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
                }
            } else {

                $class = 'errorDialogBox';
                $message = 'No se ha especificado la acción a tomar sobre el grupo, recargue la página e intentelo de nuevo.';

                $this->renderPartial('//msgBox', array(
                    'class' => $class,
                    'message' => $message,
                ));
            }
        }
    }

    /**
     * save the access permission data for both user and groups
     * @param Array $formData
     */
    private function accessPermissionSave($formData, $element_id) {

        if ((int) $formData['id'] === UserGroupsUser::ROOT) {
            Yii::app()->user->setFlash('error', Yii::t('userGroupsModule.admin', 'You cannot change the Access Permission of the Root User'));
        } else if ($formData['id'] === 'new' && !Yii::app()->user->pbac('admin')) {
            Yii::app()->user->setFlash('error', Yii::t('userGroupsModule.admin', 'You cannot create a new user or group'));
        } else if ($formData['id'] !== 'new' && !is_numeric($formData['id'])) {
            Yii::app()->user->setFlash('error', Yii::t('userGroupsModule.admin', 'You didn\'t supply a valid id'));
        } else {

            if (!isset($element_id) && is_numeric($formData['id'])) { // fix for users with no admin permissions
                if ((int) $formData['what'] === UserGroupsAccess::GROUP) {
                    $element_id = UserGroupsGroup::model()->findByPk((int) $formData['id'])->id;
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
                Yii::app()->user->setFlash('group', Yii::t('userGroupsModule.admin', 'New group Created.', array('{what}' => $formData['what'])));
            } else {
                Yii::app()->user->setFlash('group', Yii::t('userGroupsModule.admin', 'Data and Access Permission of <i>{displayname} group</i> changed', array('{displayname}' => $formData['displayname'])));
            }
        }
    }

    /**
     * 
     * @param array $data
     * @return string
     */
    public function columnaAcciones($data) {
        $columna = '<div class="action-buttons">';

        if (Yii::app()->user->pbac('userGroups.admin.admin')) {
            $id = $data["id"];
            $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in look-data", "data-id" => base64_encode($data->id), "title" => "Consultar Grupo")) . '&nbsp;&nbsp;';
            if ($data->estatus == 'A') {
                $columna .= CHtml::link("", '/userGroups/grupo/edicion/id/' . base64_encode($data->id), array("class" => "fa fa-pencil green edit-data", "data-id" => base64_encode($data->id), "title" => "Editar Datos del Grupo")) . '&nbsp;&nbsp;';
                $columna .= CHtml::link("", "", array("class" => 'fa icon-trash red change-status', 'data-action' => 'E', 'data-id' => base64_encode($data->id), 'data-description' => $data->description, 'title' => 'Inactivar Grupo'));
            } else {
                $columna .= CHtml::link("", "", array("class" => 'fa fa-check change-status', 'data-action' => 'A', 'data-id' => base64_encode($data->id), 'data-description' => $data->description, 'title' => 'Activar Grupo'));
            }
        }

        $columna .= '</div>';

        return $columna;
    }

}
