<?php

class LogoutController extends Controller {

    public $defaultAction = 'logout';

    static $_permissionControl = array(
        'label' => 'Logout de Usuarios'
    );

    public function actionLogout() {

        CController::forward('userGroups/user/logout');

    }

}
