<?php

class EstatusPlantelController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	 static $_permissionControl = array(
        'read' => 'Consulta de Estatus de Planteles',
        'write' => 'Consulta de Estatus de Planteles',
        'label' => 'Consulta de Estatus de Planteles'
    );

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
                'actions' => array('index', 'view','admin'),
                'pbac' => array('read', 'write'),
            ),
            // en este array sólo van los action de actualizacion a BD
            array('allow',
                'actions' => array('create', 'update', 'borrar','activar'),
                'pbac' => array('write'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Inactiva un modelo en particular
     * @params integer $id
     * @throws CHttpException
     */
    public function actionBorrar()
	{
		
		if(isset($_POST['id']))
		{
		$id=$_POST['id'];
		$id=base64_decode($id);
	
		$model=$this->loadModel($id);
		if($model){
		$model->usuario_act_id=Yii::app()->user->id;
		$model->fecha_elim=date("Y-m-d H:i:s");
		$model->estatus="E";
		if($model->save()){
			$this->registerLog(
                            "INACTIVAR", "borrar", "Exitoso", "Inactivo un estatus de plantel"
                    );
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Inactivado con exito.'));
                    $model=$this->loadModel($id);

		}
		else{
					throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');

				}

		}
		else{

		throw new CHttpException(404, 'Error! Recurso no encontrado!');		
		}
		
		

		}

	}
    /**
     * Reactiva un estatus de plantel en particular
     * @params integer $id modelo que a reactivar
     * @throws CHttpException
     */
    public function actionActivar() {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $id = base64_decode($id);

            $model = $this->loadModel($id);
            if ($model) {
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_act = date("Y-m-d H:i:s");
                $model->estatus = "A";
                if ($model->save()) {
                     $this->registerLog(
                            "ACTIVAR", "update", "Exitoso", "activo un estatus de plantel"
                    );
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Habilitado con exito.'));
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else {

                throw new CHttpException(404, 'Error! Recurso no encontrado!');
            }
        }
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$id=base64_decode($id);
		if(isset($id)) {
		$this->renderPartial('view',array(
			'model'=>$this->loadModel($id),
		));
										   }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new EstatusPlantel;
if($model){  
if(isset($_POST['EstatusPlantel']))
		{
			$model->attributes=$_POST['EstatusPlantel'];
			$nombre=trim($_POST['EstatusPlantel']['nombre']);
			$nombre=strtoupper($nombre);
			$model->nombre=$nombre;
			$model->usuario_ini_id=Yii::app()->user->id;
			$model->fecha_ini=date("Y-m-d H:i:s");
			$model->estatus="A";

			if($model->validate()){
				if($model->save()){
					$this->registerLog(
                                "ESCRITURA", "create", "Exitoso", "creo un estatus de plantel"
                        );
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Exito! ya puede realizar otro registro.'));
                        $model=new EstatusPlantel;
					
				}
				else{
					throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');

				}
			}
			
				
		
	
		}

}
		$this->renderPartial('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{	
		$id=$_REQUEST['id'];
		$id=base64_decode($id);

		       
		$model=$this->loadModel($id);
		
		if($model)
		{ 

			if(isset($_POST['EstatusPlantel']))
			{
					$model->attributes=$_POST['EstatusPlantel'];
					$nombre=trim($_POST['EstatusPlantel']['nombre']);
					$nombre=strtoupper($nombre);
					$model->nombre=$nombre;
					$model->usuario_act_id=Yii::app()->user->id;
					$model->fecha_act=date("Y-m-d H:i:s");
					$model->estatus="A";

					if($model->save())
						if($model->validate()){
						if($model->save()){
							$this->registerLog(
                                    "ACTUALIZACION", "update", "Exitoso", "actualizo un estatus plantel"
                            );
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model=$this->loadModel($id);
							
						}
						else{
							throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');

						}
					}
						
			}

		}
	else{
			throw new CHttpException(403, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');

		}

			$this->renderPartial('update',array(
				'model'=>$model,
			));
		
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$groupId = Yii::app()->user->group;
		
		$model=new EstatusPlantel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EstatusPlantel']))
			$model->attributes=$_GET['EstatusPlantel'];
			
        $usuarioId = Yii::app()->user->id;
       $this->registerLog(
                "LECTURA", "Index", "Exitoso", "Ingreso a estatus plantel"
        );
        $dataProvider = new CActiveDataProvider('EstatusPlantel');
        $this->render('admin',array(
			'model'=>$model,
			'groupId'=>$groupId,
			'usuarioId'=>$usuarioId,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new EstatusPlantel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EstatusPlantel']))
			$model->attributes=$_GET['EstatusPlantel'];

		$this->render('admin',array(
			'model'=>$model,

		));
	}

    /**
     * Devuelve las columnas con las acciones posibles
     * @param type $data
     * @return string
     */
    public function columnaAcciones($data)
	{
		$id = $data["id"];
		$id = base64_encode($id);
		if($data->estatus=="E"){
		$columna = CHtml::link("","",array("class"=>"fa fa-search","title"=>"Buscar este Estatus de plantel" ,"onClick"=>"VentanaDialog('$id','/catalogo/estatusPlantel/view','Estatus de Plantel','view')")).'&nbsp;&nbsp;';
        if (Yii::app()->user->group == 1) {
                $columna .= CHtml::link("", "", array("class" => "fa fa-check green", "title" => "Activar este Estatus de plantel", "onClick" => "VentanaDialog('$id','/catalogo/estatusPlantel/activar','Activar Estatus','activar')")) . '&nbsp;&nbsp;';
            }
        }
		else{
		
		$columna = CHtml::link("","",array("class"=>"fa fa-search","title"=>"Buscar esta Estado de plantel" ,"onClick"=>"VentanaDialog('$id','/catalogo/estatusPlantel/view','Estatus de Plantel','view')")).'&nbsp;&nbsp;';
		$columna .= CHtml::link("","",array("class"=>"fa fa-pencil green","title"=>"Modificar este Estatus de plantel", "onClick"=>"VentanaDialog('$id','/catalogo/estatusPlantel/update','Modificar Estatus de Plantel','update')")).'&nbsp;&nbsp;';
		$columna .= CHtml::link("","",array("class"=>"fa fa-trash-o red","title"=>"Inhabilitar este Estatus de plantel", "onClick"=>"VentanaDialog('$id','/catalogo/estatusPlantel/borrar','Inactivar Estatus de Plantel','borrar')")).'&nbsp;&nbsp;';
			}
		return $columna;
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EstatusPlantel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EstatusPlantel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


 /**
     *  funcion para devolver el esatatus segun las iniciales A y E
     * @param type $data registro del modelo
     * @return string el estatus del registro
     */
    public function estatus($data)
	{
		$estatus = $data["estatus"];
		
		if($estatus=="E"){
			$columna="Inactivo";
		}
		else if($estatus=="A"){
			$columna="Activo";	
		}
		return $columna;
	}
	/**
	 * Performs the AJAX validation.
	 * @param EstatusPlantel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='estatus-plantel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
