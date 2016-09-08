<?php

class PartidaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

            static $_permissionControl = array(
        'read' => 'Consulta de Partidas',
        'write' => 'Creacion y Modificación de Partidas',
        'label' => 'Activación e Inactivación de Partidas'
    );

        
	/**
	 * @return array action filters
	 */

    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'view', 'admin'),
                'pbac' => array('read', 'write'),
            ),
            // en este array sólo van los action de actualizacion a BD
            array('allow',
                'actions' => array('create',
                    'update',
                    'borrar',
                    'activar'
                ),
                'pbac' => array('write'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		  $model = new Partida;
        $estatus = false;
        $estatusMod = false;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Partida'])) {
            $model->attributes = $_POST['Partida'];
//            $model->razon_social = strtoupper($_POST['Partida']['razon_social']);
//            $model->email =trim( strtoupper($_POST['Partida']['email']));
//            $model->email_otro =trim( strtoupper($_POST['Partida']['email_otro']));
//            $model->direccion = trim(strtoupper($_POST['Partida']['direccion']));
//            $model->titular_cuenta = trim(strtoupper($_POST['Partida']['titular_cuenta']));
//
//            $model->urbanizacion_id = $_POST['Partida']['urbanizacion_id'];
//            $model->poblacion_id = $_POST['Partida']['poblacion_id'];
//            $model->telefono_local = Utiles::onlyNumericString($_REQUEST['Partida']['telefono_local']);
//            $model->telefono_celular = Utiles::onlyNumericString($_REQUEST['Partida']['telefono_celular']);
//            $model->capital_social = (real) $_POST['Partida']['capital_social'];
//            $model->vinculo_funcionario = (int)$_POST['Partida']['vinculo_funcionario'];
//            
//            if($_POST['Partida']['ivss']){
//            $model->ivss = $_POST['Partida']['ivss'];
//            }else{
//                $model->ivss = "NO TIENE";
//            }
//            
//             if($_POST['Partida']['nil']){
//            $model->nil = $_POST['Partida']['nil'];
//            }else{
//                $model->nil = "NO TIENE";
//            }
//            
//            if($_POST['Partida']['inces']){
//            $model->inces = $_POST['Partida']['inces'];
//            }else{
//                $model->inces = "NO TIENE";
//            }
//            
//             if($_POST['Partida']['banavih']){
//            $model->banavih = $_POST['Partida']['banavih'];
//            }else{
//                $model->banavih = "NO TIENE";
//            }
//                
//            if($_POST['Partida']['snc']){
//            $model->snc = $_POST['Partida']['snc'];
//            }else{
//                $model->snc = "NO TIENE";
//            }
//            
//            if($_POST['Partida']['solvencia_laboral']){
//            $model->solvencia_laboral = $_POST['Partida']['solvencia_laboral'];
//            }else{
//                $model->solvencia_laboral = "NO TIENE";
//            }
            
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = "A";
            if ($model->save()) {
                $model = new Partida;
                $estatus = true;
                //$this->redirect(array('update','id'=>base64_encode($model->id)));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'estatus' => $estatus,
            'estatusMod'=>$estatusMod,
        ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Partida']))
		{
			$model->attributes=$_POST['Partida'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	$dataProvider = new CActiveDataProvider('Partida');
        $model = new Partida('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Partida']))
            $model->attributes = $_GET['Partida'];
        $this->render('admin', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            
        ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Partida('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Partida']))
			$model->attributes=$_GET['Partida'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Partida the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Partida::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Partida $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='partida-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
