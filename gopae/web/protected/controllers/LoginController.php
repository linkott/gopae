<?php

class LoginController extends Controller {

    public $defaultAction = 'login';

    static $_permissionControl = array(
        'label' => 'Login de Usuarios'
    );

    public function actionLogin() {

        CController::forward('userGroups/');

    }

    public function actionRecuperarClave() {

        CController::forward('userGroups/user/passRequest');

    }

    public function actionCaptcha($sid) {
        $img = new Securimage();
        $img->image_signature = 'MPPE';
        $img->signature_color = new Securimage_Color('#777777');
        $img->charset = 'abcdefghjkmprtuvwxyzABCEFHJKMNPTUVWXYZ2346789';
        if (!empty($_GET['namespace'])){
            $img->setNamespace($_GET['namespace']);
        }
        $img->show();
    }

}
