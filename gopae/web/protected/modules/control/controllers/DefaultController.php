<?php

class DefaultController extends Controller {

    //despues de la declaración de la clase va el siguiente codigo
    public $layout = '//layouts/main';
    static $_permissionControl = array(
        'read'  => 'Default Controller Control de Carga de Datos',
        'write' => 'Default Controller Control de Carga de Datos',
        'label' => 'Default Controller Control de Carga de Datos'
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
                'actions' => array('index',),
                'pbac' => array('read', 'write'),
            ),
            array('allow',
                'actions' => array('index',),
                'pbac' => array('read',),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

}
