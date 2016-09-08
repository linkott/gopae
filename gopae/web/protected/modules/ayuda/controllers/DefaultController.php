<?php

class DefaultController extends Controller {


    static $_permissionControl = array(
        'read' => 'Consulta de Datos de Ayuda',
        'label' => 'Consulta de Datos de Ayuda'
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
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        throw new CHttpException(404, 'Página no encontrada.');
    }

}
