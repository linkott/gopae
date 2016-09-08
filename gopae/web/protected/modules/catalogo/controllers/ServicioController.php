<?php

class ServicioController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

    /**
      * @ Return array filtros de acción
      */
   static $_permissionControl = array(
        'read' => 'Consulta de Servicio',
        'write' => 'Gestion de Servicio',
        'label' => 'Módulo  de  Servicio',
        'admin' => 'Atender de Servivio',
    );

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
//	 public function accessRules() {
//        return array(
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('index', 'view'),
//                'pbac' => array('read', 'write'),
//            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create', 'update', 'activar', 'delete'),
//                'pbac' => array('write'),
//            ),
//            array('deny', // deny all users
//                'users' => array('*'),
//            ),
//        );
//    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
           $idDecode= base64_decode($id);
           if(is_numeric($idDecode)){
		$this->renderPartial('view',array(
			'model'=>$this->loadModel($idDecode),
		));
	}
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
	
	 public function actionCreate() {
        $id = $_GET['id'];
        $model = new Servicio;
        if (isset($_POST['Servicio'])) {
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->nombre=$_POST['Servicio']['nombre'];
            $model->estatus = 'A';
            if($model->nombre==''){
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Nombre no debe ser vacio'));
                }else{
            if ($model->validate()) {
                if ($model->save()) {
                    $this->registerLog('ESCRITURA', 'catalogo.servicio.create', 'EXITOSO', 'Se ha creado un servicio, ahora puede crear otro');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'El Registro del servicio se ha creado con exito'));
                    $model = new Servicio;
                     }else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
            } else {
                throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
            }

                }
        }
        $this->renderPartial('_form', array(
            'model' => $model
        ));
    }
	 public function actionUpdate($id) {
        $id = $_REQUEST['id'];
        $id = base64_decode($id);
        $model = $this->loadModel($id);
       if (isset($_POST['Servicio'])) {
           $model->attributes = $_POST['Servicio'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            if ($model->save())
                if ($model->validate()){
                    if ($model->save()){
                        $this->registerLog('ESCRITURA', 'catalogo.servicio.create', 'EXITOSO', 'Se ha creado un servicio');
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                        $model = $this->loadModel($id);
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }

                  } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
                }
         $this->renderPartial('_form', array(
            'model' => $model,
        ));
    }
	
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
                    $this->registerLog('ESCRITURA', 'catalogo.servicio.activar', 'EXITOSO', 'Se ha activado una Servicio');
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
                    $this->registerLog('ESCRITURA', 'catalogo.servicio.borrar', 'EXITOSO', 'Se ha eliminado un Servicio');
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
        $model = new Servicio('search');
        if (isset($_GET['Servicio']))
            $model->attributes = $_GET['Servicio'];
        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('Servicio');
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
            $columna = CHtml::link("", "", array("class" => "fa fa-check", "title" => "Activar Servicio", "onClick" => "VentanaDialog('$id','/catalogo/servicio/activar','Activar Servicio','activar')")) . '&nbsp;&nbsp;';
        } else {
            $columna = CHtml::link("", "", array("class" => "fa fa-search", "title" => "Buscar Servicio", "onClick" => "VentanaDialog('$id','/catalogo/servicio/view','Vista de Servicio','view')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa fa-pencil green", "title" => "Modificar Servicio", "onClick" => "VentanaDialog('$id','/catalogo/servicio/update','Modificar Servicio','update')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa icon-trash red", "title" => "Eliminar Servicio", "onClick" => "VentanaDialog('$id','/catalogo/servicio/borrar','Eliminar Servicio','borrar')")) . '&nbsp;&nbsp;';
        }
        return $columna;
    }
	public function loadModel($id)
	{
		$model=Servicio::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	 * Performs the AJAX validation.
	 * @param Servicio $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='servicio-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
