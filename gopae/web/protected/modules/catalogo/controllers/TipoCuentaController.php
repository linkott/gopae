<?php

class TipoCuentaController extends Controller
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
        'read' => 'Consulta de TipoCuentaController',
        'write' => 'Creación y Modificación de TipoCuentaController',
        'admin' => 'Administración Completa  de TipoCuentaController',
        'label' => 'Módulo de TipoCuentaController'
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
                'actions' => array('lista', 'consulta', 'registro', 'edicion', 'eliminacion',),
                'pbac' => array('admin'),
            ),
            array('allow',
                'actions' => array('lista', 'consulta', 'registro', 'edicion',),
                'pbac' => array('write'),
            ),
            array('allow',
                'actions' => array('lista', 'consulta',),
                'pbac' => array('read'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    /**
     * Lists all models.
     */
    public function actionLista()
    {
        $model=new TipoCuenta('search');
        $model->unsetAttributes();  // clear any default values
        if($this->hasQuery('TipoCuenta')){
            $model->attributes=$this->getQuery('TipoCuenta');
        }
        $dataProvider = $model->search();
        $this->render('admin',array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new TipoCuenta('search');
        $model->unsetAttributes();  // clear any default values
        if($this->hasQuery('TipoCuenta')){
            $model->attributes=$this->getQuery('TipoCuenta');
        }
        $dataProvider = $model->search();
        $this->render('admin',array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionConsulta($id)
    {
        $idDecoded = $this->getIdDecoded($id);
        $model = $this->loadModel($idDecoded);
        $this->render('view',array(
            'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionRegistro()
    {
        $model=new TipoCuenta;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if($this->hasPost('TipoCuenta'))
        {
            $model->attributes=$this->getPost('TipoCuenta');
            if($model->save()){
                $this->redirect(array('consulta','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdicion($id)
    {
            $idDecoded = $this->getIdDecoded($id);
            $model = $this->loadModel($idDecoded);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if($this->hasPost('TipoCuenta'))
            {
                $model->attributes=$this->getPost('TipoCuenta');
                if($model->save()){
                    if(Yii::app()->request->isAjaxRequest){
                        $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La actualización de los Datos se ha efectuado de forma exitosa.'));
                        Yii::app()->end();
                    }
                }
            }

            $this->render('update',array(
                    'model'=>$model,
            ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionEliminacion($id)
    {
        $idDecoded = $this->getIdDecoded($id);
        $model = $this->loadModel($idDecoded);
        // Descomenta este código para habilitar la eliminación física de registros.
        // $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!$this->hasQuery('ajax')){
            $this->redirect($this->hasPost('returnUrl') ? $this->getPost('returnUrl') : array('lista'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TipoCuenta the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=TipoCuenta::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TipoCuenta $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if($this->hasPost('ajax') && $this->getPost('ajax')==='tipo-cuenta-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Retorna los botones o íconos de administración del modelo
     *
     * @param mixed $data
     *
     */
    public function getActionButtons($data) {
        $id_encoded = $data["id"];
        $id = base64_encode($id_encoded);
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in", "title" => "Ver datos", 'href' => '/catalogo/tipoCuenta/consulta/id/'.$id)) . '&nbsp;&nbsp;';
        $columna .= CHtml::link("", "", array("class" => "fa icon-pencil green", "title" => "Editar datos", 'href' => '/catalogo/tipoCuenta/edicion/id/'.$id)) . '&nbsp;&nbsp;';
        $columna .= '</div>';
        return $columna;
    }

    /**
     * Obtiene un id Decodificado si un Id es codificado en base64
     *
     * @param mixed $id
     *
     */
    public function getIdDecoded($id){
        if(is_numeric($id)){
            return $id;
        }
        else{
            $idDecodedb64 = base64_decode($id);
            if(is_numeric($idDecodedb64)){
                return $idDecodedb64;
            }
        }
        return null;
    }
}