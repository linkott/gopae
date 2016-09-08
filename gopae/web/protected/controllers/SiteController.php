<?php

class SiteController extends Controller {

    public $layout = '//layouts/main';
    public $aviso;
    //Parametros para la administracion de permisos con userGroups
    static $_permissionControl = array('label' => 'Pagina Inicio standard');

    // Uncomment the following methods and override them if needed
    public function filters() {
        // return the filter configuration for this controller, e.g.:
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
        );
    }

    protected function beforeAction($event) {
        if ($event->id == 'index') {
            // $user = new UserGroupsUser();
            //$usuario_id = Yii::app()->user->id;
            // $cambio_clave = $user->verificarCambioClave($usuario_id);
            $cambio_clave = Yii::app()->user->cambio_clave;
            if ($cambio_clave == 0) {
                $this->redirect('perfil');
                return true;
            } else
                return true;
        } else
            return true;
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', //Permite ejecutar la accion error a todos
                'actions' => array('error', 'browser', 'mantenimiento'),
                'users' => array('*'),
            ),
            array('allow', //Permite ejecutar la accion index a usuarios logeados
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $aviso = true;
        $this->aviso = $aviso;
        // var_dump(Yii::app()->params['adminEmailSend']);
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
        //CController::forward('comunicaciones/noticia/publicoNoticia');
    }

    public function actionBrowser() {
        $opt = $this->getRequest('opt');
        $opt_decoded = base64_decode($opt);
        if (is_numeric($opt_decoded)) {
            $this->layout = 'browser';
            $this->render('browser', array('opt' => $opt_decoded));
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->renderPartial('/site/error', $error);
        }
    }

    public function actionMantenimiento() {
        $this->renderPartial('//mantenimiento', array());
    }

}
