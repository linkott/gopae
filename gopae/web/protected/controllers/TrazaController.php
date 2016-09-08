<?php

class TrazaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
	
	//Parametros para la administracion de permisos con userGroups
	static $_permissionControl = array( 
		'read' => 'Permite ejecutar la consulta de las Trazas de Auditoria',
		'label' => 'Consulta de Trazas de Auditoria'
	);

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'userGroupsAccessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('view','index','admin','traza'),
				'pbac'=>array('read'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
			
		);
	}

	public function actionView($id)
		
	{
            $id=base64_decode($id);
		$this->renderPartial('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	
	
	public function actionIndex()
	{

              $groupId = Yii::app()->user->group;

        $model = new Traza('search');

        if (isset($_GET['Traza']))
            $model->attributes = $_GET['Traza'];
        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('Traza');
        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));
	}


         public function columnaAcciones($datas)
	{
		$id = $datas["id_traza"];
                $id_pkey=base64_encode($id);
                $columna = CHtml::link("","#",array("class"=>"fa fa-search","title"=>"Buscar Esta Traza" ,"onClick"=>"VentanaDialog('$id_pkey','/traza/view','Traza','view')")).'&nbsp;&nbsp;';
		return $columna;
        }
	public function actionAdmin()
	{
		$model=new Traza('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Traza']))
			$model->attributes=$_GET['Traza'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Traza::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


       public function fechaIni($data) {
        $fecha_Ini= $data["fecha_hora"];
        if (empty($fecha_Ini)) {
            $fecha_Ini = "";
        } else {
            $fecha_Ini = date("d-m-Y", strtotime($fecha_Ini));
        }
        return $fecha_Ini;
    }
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='traza-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * display the documentation
	 */
	public function actionTraza()
	{
		if (Yii::app()->request->isAjaxRequest){
			
			$this->renderPartial('traza', NULL, false, true);}
		else{

			$this->render('traza');}
	}
}
