<?php

class UnidadGrupoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','activar'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            $idDecode= base64_decode($id);
		$this->renderPartial('view',array(
			'model'=>$this->loadModel($idDecode),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	 public function actionCreate() {
        $id = $_GET['id'];
        $columna=1;
        $model = new UnidadGrupo;
        $grupos = UserGroupsGroup::model()->findAll(array('condition' => "estatus!='Eliminado'", 'order' => "groupname ASC, estatus ASC"));
        if (isset($_POST['grupo'])) {
            $model->unidad_resp_ticket_id=Yii::app()->getSession()->get('id');
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->group_id=$_POST['grupo'];
            $model->estatus = 'A';
            $resultado=$model->validaGrupoExistente(Yii::app()->getSession()->get('id'));
            foreach ($resultado as $data){
                if($data['id']==$_POST['grupo']){
               $columna=0;
                }
            }
            if($columna==0){
           $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Este grupo ya posee una unidad responsable'));
            }else{
            if ($model->validate()) {
                if ($model->save()) {
                    
                    $this->registerLog('ESCRITURA', 'ayuda.UnidadGrupo.create', 'EXITOSO', 'Se ha creado un grupo de usuario, ahora puede crear otro');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'El Registro del unidadad responsable de ticket se ha creado con exito'));
                    $model = new UnidadGrupo;
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
            } else {
                throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
            }
        }
        }
        $this->renderPartial('_form', array(
            'model' => $model,'grupos'=>$grupos,
        ));
    }
         

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */

	 public function actionUpdate($id) {
        $id = $_REQUEST['id'];
        $id = base64_decode($id);
        $model = $this->loadModel($id);
        $actualizar = 'actualizar';
         $grupos = UserGroupsGroup::model()->findAll(array('condition' => "estatus!='Eliminado'", 'order' => "groupname ASC, estatus ASC"));
       if (isset($_POST['grupo'])) {
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            if ($model->save())
                if ($model->validate()){
                    if ($model->save()){
                        $this->registerLog('ESCRITURA', 'ayuda.DistribucionTicket.create', 'EXITOSO', 'Se ha creado un Instructivo ahora puede crear otro');
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                        $model = $this->loadModel($id);
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }

                  } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
                }
        
         $this->renderPartial('create', array(
            'model' => $model, 'grupos' => $grupos,'actualizar' => $actualizar,
        ));
    }
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionActivar() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $id = base64_decode($id);
            $model = $this->loadModel($id);
            if ($model) {
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_elim = date("Y-m-d H:i:s");
                $model->estatus = "A";
                if ($model->save()) {
                    $this->registerLog('ESCRITURA', 'catalogo.unidadGrupo.activar', 'EXITOSO', 'Se ha activado una Unidad Grupo');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Activado con exito.'));
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else {

                throw new CHttpException(404, 'Error! Recurso no encontrado!');
            }
        }
    }
    public function actionDelete($id) {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $id = base64_decode($id);
            $model = $this->loadModel($id);
            if ($model) {
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_elim = date("Y-m-d H:i:s");
                $model->estatus = "E";
                if ($model->save()) {
                    $this->registerLog('ESCRITURA', 'ayuda.unidadGrupo.borrar', 'EXITOSO', 'Se ha eliminado una unidad de grupo');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con exito.'));
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else {

                throw new CHttpException(404, 'Error! Recurso no encontrado!');
            }
        }
    }

public function actionIndex() {
        $groupId = Yii::app()->user->group;
        $model = new UnidadGrupo('search');
        if (isset($_GET['UnidadGrupo']))
            $model->attributes = $_GET['UnidadGrupo'];
        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('UnidadGrupo');
        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));





    }
        
        public function columnaAcciones($datas) {
        $id = $datas["id"];
        $id = base64_encode($id);
        $estatus = $datas['estatus'];
        if ($estatus == 'E') {
            $columna = CHtml::link("", "", array("class" => "fa fa-check", "title" => "Activar Grupo", "onClick" => "VentanaDialog('$id','/ayuda/unidadRespTicket/activar','activar Grupo','activar')")) . '&nbsp;&nbsp;';
        } else {
            $columna = CHtml::link("", "", array("class" => "fa fa-search", "title" => "Buscar Unidad de Grupo", "onClick" => "VentanaDialog('$id','/ayuda/unidadGrupo/view','Vista Unidad Grupo','view')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa fa-pencil green", "title" => "Modificar Responsable de Ticket", "onClick" => "VentanaDialog('$id','/ayuda/unidadGrupo/update','Modificar Unidad','update')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa icon-trash red", "title" => "Eliminar Mención", "onClick" => "VentanaDialog('$id','/ayuda/unidadGrupo/borrar','Eliminar Grupo','borrar')")) . '&nbsp;&nbsp;';
        }
        return $columna;
    }
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new UnidadGrupo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UnidadGrupo']))
			$model->attributes=$_GET['UnidadGrupo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

            public function estatus($data) {
        $estatus = '';
        $id = $data["estatus"];
        if ($id == 'A') {
            $estatus = 'Activo';
        }
        if ($id == 'E') {
            $estatus = 'Eliminado';
        }
        return $estatus;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return UnidadGrupo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UnidadGrupo::model()->findByPk($id);
		if($model===null)
               throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UnidadGrupo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='unidad-grupo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
