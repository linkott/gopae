<?php

class CargaExcelController extends Controller
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
        'read' => '',
        'write' => '',
        'admin' => '',
        'label' => ''
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
                'actions' => array('lista', 'admin', 'ver'),
                'pbac' => array('admin'),
            ),
            array('allow',
                'actions' => array('lista', 'admin', 'ver'),
                'pbac' => array('write'),
            ),
            array('allow',
                'actions' => array('lista', 'admin', 'ver'),
                'pbac' => array('read'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('lista'),
            ),
        );
    }
    
     /**
     * Lists all models.
     */
    public function actionLista()
    {   
        $this->render('admin',array(
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $this->render('admin',array(
        ));
    }
    
       public function actionVer() {
           fopen($filename, "r");
        $this->renderPartial('ver',array(
        ));
    }

}

