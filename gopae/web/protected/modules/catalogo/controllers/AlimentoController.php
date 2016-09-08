<?php

class AlimentoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        static $_permissionControl = array(
            'read' => 'Gestion de Alimento',
            'write' => 'Gestion de Alimento',
            'label' => 'Gestion de Alimento'
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
        public function accessRules() {
            return array(
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array('index', 'registrar', 'crear', 'informacion', 'modificar', 'procesarCambio', 'eliminarArticulo', 'activarArticulo', 'precioRegion', 'modificarPrecioRegion', 'procesarCambioMonetario', '_precioRegionLoad'),
                    'users' => array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                    'actions' => array('create', 'update'),
                    'users' => array('@'),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions' => array('admin', 'delete'),
                    'users' => array('admin'),
                ),
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $model = new Articulo('search');
            $precio_monetario = UnidadMonetaria::model()->findAll(array("condition" => "estatus = 'A'"));
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Articulo']) || isset($_GET['ajax'])) {
//                $precioMaxComas = substr_count($_GET['Articulo']['precio_regulado'], ',');
                $precioMaxPuntos = null;
                if (isset($_GET['Articulo'])) {
                    $_GET['Articulo']['precio_regulado'] = str_replace(',', '.', $_GET['Articulo']['precio_regulado']);
                    $precioMaxPuntos = substr_count($_GET['Articulo']['precio_regulado'], '.');
                    if($precioMaxPuntos <= 1) {
                        if(strlen($_GET['Articulo']['precio_regulado']) <= 1 && $_GET['Articulo']['precio_regulado'] == '.') {
                            $_GET['Articulo']['precio_regulado'] = '';
                        }
                    }
                }
                else {
                    $_GET['Articulo']['precio_regulado'] = '';
                }
                if (isset($_GET['Articulo']))
                    $model->attributes = $_GET['Articulo'];
                $this->render('index', array(
                    'model' => $model,
                ));
            } else {
                $url = $_SERVER['REQUEST_URI']; // validar que la url sea la correcta
                $validaUrl = '/catalogo/alimento/';
                if ($url != $validaUrl) {
                    $this->redirect('../catalogo');
                    //throw new CHttpException(404, "Dirección inválida.");
                } else {
                    $this->render('index', array(
                        'model' => $model,
                    ));
                }
            }
	}
        
    public function actionRegistrar() {
        $model = new Articulo;
        //Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $unidadMedida = UnidadMedida::model()->findAll();
        $unidadMonetaria = UnidadMonetaria::model()->findAll(array("condition" => "estatus = 'A'"));
        $tipoArticulo = TipoArticulo::model()->findAll();
        $unidadMedidaUtencilio = UnidadMedida::model()->findAll(array('condition' => "nombre ILIKE 'PIEZA'"));
        $this->renderPartial('_form', array(
            'model' => $model,
            'unidadMedida' => $unidadMedida,
            'unidadMonetaria' => $unidadMonetaria,
            'tipoArticulo' => $tipoArticulo,
            'unidadMedidaUtencilio' => $unidadMedidaUtencilio
        ));
    }

    public function actionCrear() {
        $model = new Articulo;
        $unidadMedida = UnidadMedida::model()->findAll();
        $unidadMonetaria = UnidadMonetaria::model()->findAll(array("condition" => "estatus = 'A'"));
        $tipoArticulo = TipoArticulo::model()->findAll();
        $unidadMedidaUtencilio = UnidadMedida::model()->findAll(array('condition' => "nombre ILIKE 'PIEZA'"));
        
        if (isset($_POST['Articulo'])) {
            if($_POST['Articulo']['franja_id'] == 'false') {
                $model->setScenario('validarAlimento');
                $model->franja_id = null;
//                var_dump(1);die();
            }
            if($_POST['Articulo']['franja_id'] != null || $_POST['Articulo']['franja_id'] != '' || $_POST['Articulo']['franja_id'] != 'false') {
                $model->setScenario('validarAlimento');
                $model->franja_id = $_POST['Articulo']['franja_id'];
            }
            else {
//                var_dump(1);die();
                $model->franja_id = null;
            }
            $precioMaxPuntos = null;
            if (isset($_POST['Articulo'])) {
                $_POST['Articulo']['precio_regulado'] = str_replace(',', '.', $_POST['Articulo']['precio_regulado']);
                $precioMaxPuntos = substr_count($_POST['Articulo']['precio_regulado'], '.');
                if($precioMaxPuntos <= 1) {
                    if(strlen($_POST['Articulo']['precio_regulado']) <= 1 && $_POST['Articulo']['precio_regulado'] == '.') {
                        $model->precio_regulado = '';
                    }
                }
                if($precioMaxPuntos == 1 || $precioMaxPuntos == 0) {
                    $model->precio_regulado = $_POST['Articulo']['precio_regulado'];
                }
            }
            
            $precioMaxPuntosBaremo = null;
            if (isset($_POST['Articulo'])) {
                $_POST['Articulo']['precio_baremo'] = str_replace(',', '.', $_POST['Articulo']['precio_baremo']);
                $precioMaxPuntosBaremo = substr_count($_POST['Articulo']['precio_baremo'], '.');
                if($precioMaxPuntosBaremo <= 1) {
                    if(strlen($_POST['Articulo']['precio_baremo']) <= 1 && $_POST['Articulo']['precio_baremo'] == '.') {
                        $model->precio_baremo = '';
                    }
                }
                if($precioMaxPuntosBaremo == 1 || $precioMaxPuntosBaremo == 0) {
                    $model->precio_baremo = $_POST['Articulo']['precio_baremo'];
                }
            }
            
            $model->nombre = $_POST['Articulo']['nombre'];
            $model->unidad_medida_id = $_POST['Articulo']['unidad_medida_id'];
            $model->unidad_monetaria_id = $unidadMonetaria[0]['id'];
            $model->tipo_articulo_id = $_POST['Articulo']['tipo_articulo_id'];
//            $model->usuario_act_id = Yii::app()->user->id;
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
//            $model->fecha_act = date("Y-m-d H:i:s");
            $model->estatus = 'A';
//            var_dump($model);die();

            if ($model->validate()) {
                if ($model->save()) {
                    $this->registerLog('ESCRITURA', 'articulo.crear', 'EXITOSO', 'Se creo un nuevo alimento');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Registro Exitoso.'));
                    //$this->registrarTraza('Registro un nivel ' . $plantel_id, 'CrearNivel');
                }
            } else { // si ingresa datos erroneos muestra mensaje de error.
                $this->renderPartial('//errorSumMsg', array('model' => $model));
                //Yii::app()->end();
            }
        }

        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $this->renderPartial('_form', array(
            'model' => $model,
            'unidadMedida' => $unidadMedida,
            'unidadMonetaria' => $unidadMonetaria,
            'tipoArticulo' => $tipoArticulo,
            'unidadMedidaUtencilio' => $unidadMedidaUtencilio
        ));
    }
    
    public function actionProcesarCambioMonetario() {
        $model = new PrecioRegion;
        $unidadMonetaria = UnidadMonetaria::model()->findAll(array("condition" => "estatus = 'A'"));
        if (isset($_POST['Articulo'])) {
            $id = (int) $_POST['Articulo']['id'];
            $model = PrecioRegion::model()->findByPk($id);
            
            if($model !=  null) {
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_act = date("Y-m-d H:i:s");
            } else {
                $modelPrecioRegion = Articulo::model()->precioRegionEstado($_POST['Articulo']['estado_id'], $_POST['Articulo']['articulo_model_id']);
                if($modelPrecioRegion[0]['articulo_id'] == null) {
                    $model = new PrecioRegion;
                    $model->usuario_ini_id = Yii::app()->user->id;
                    $model->fecha_ini = date("Y-m-d H:i:s");
                }
                else {
                    $model = PrecioRegion::model()->findByPk($modelPrecioRegion[0]['precio_region_id']);
                    $model->usuario_act_id = Yii::app()->user->id;
                    $model->fecha_act = date("Y-m-d H:i:s");
                }
            }
            $precioMaxPuntos = null;
            if (isset($_POST['Articulo'])) {
                $_POST['Articulo']['precio_regulado'] = str_replace(',', '.', $_POST['Articulo']['precio_regulado']);
                $precioMaxPuntos = substr_count($_POST['Articulo']['precio_regulado'], '.');
                if($precioMaxPuntos <= 1) {
                    if(strlen($_POST['Articulo']['precio_regulado']) <= 1 && $_POST['Articulo']['precio_regulado'] == '.') {
                        $model->precio_regulado = '';
                    }
                }
                if($precioMaxPuntos == 1 || $precioMaxPuntos == 0) {
                    $model->precio_regulado = $_POST['Articulo']['precio_regulado'];
                }
            }
            $model->articulo_id = $_POST['Articulo']['articulo_model_id'];
            $model->unidad_monetaria_id = $unidadMonetaria[0]['id'];
            $model->estado_id = $_POST['Articulo']['estado_id'];
            $model->estatus = 'A';
//            var_dump($model);
            if($model->validate()) {
                if($model->save()) {
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Precio cambiado con éxito.'));
                    $this->registerLog('ESCRITURA', 'articulo.procesarCambioMonetario', 'EXITOSO', 'Modifico el precio del estado');
                }
            }
            else {
                $this->renderPartial('//errorSumMsg', array('model' => $model));
            }

        }

    }
    
    public function actionProcesarCambio() {
        $model = new Articulo;
        if (isset($_POST['Articulo'])) {
            $id = (int) $_POST['Articulo']['id'];
            $model = $this->loadModel($id);
            $precioMaxPuntos = null;
            if (isset($_POST['Articulo'])) {
                if($_POST['Articulo']['franja_id'] == 'false') {
                    $model->setScenario('validarAlimento');
                    $model->franja_id = null;
    //                var_dump(1);die();
                }
                if($_POST['Articulo']['franja_id'] != null || $_POST['Articulo']['franja_id'] != '' || $_POST['Articulo']['franja_id'] != 'false') {
                    $model->setScenario('validarAlimento');
                    $model->franja_id = $_POST['Articulo']['franja_id'];
                }
                else {
    //                var_dump(1);die();
                    $model->franja_id = null;
                }
                $_POST['Articulo']['precio_regulado'] = str_replace(',', '.', $_POST['Articulo']['precio_regulado']);
                $precioMaxPuntos = substr_count($_POST['Articulo']['precio_regulado'], '.');
                if($precioMaxPuntos <= 1) {
                    if(strlen($_POST['Articulo']['precio_regulado']) <= 1 && $_POST['Articulo']['precio_regulado'] == '.') {
                        $model->precio_regulado = '';
                    }
                }
                if($precioMaxPuntos == 1 || $precioMaxPuntos == 0) {
                    $model->precio_regulado = $_POST['Articulo']['precio_regulado'];
                }
            }
            
            $precioMaxPuntosBaremo = null;
            if (isset($_POST['Articulo'])) {
                $_POST['Articulo']['precio_baremo'] = str_replace(',', '.', $_POST['Articulo']['precio_baremo']);
                $precioMaxPuntosBaremo = substr_count($_POST['Articulo']['precio_baremo'], '.');
                if($precioMaxPuntosBaremo <= 1) {
                    if(strlen($_POST['Articulo']['precio_baremo']) <= 1 && $_POST['Articulo']['precio_baremo'] == '.') {
                        $model->precio_baremo = '';
                    }
                }
                if($precioMaxPuntosBaremo == 1 || $precioMaxPuntosBaremo == 0) {
                    $model->precio_baremo = $_POST['Articulo']['precio_baremo'];
                }
            }
            
            $model->nombre = $_POST['Articulo']['nombre'];
            $model->unidad_medida_id = $_POST['Articulo']['unidad_medida_id'];
            $model->tipo_articulo_id = $_POST['Articulo']['tipo_articulo_id'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            $model->estatus = 'A';

            $nombre = $model->nombre;
            $nombre = trim(strtoupper($nombre));
            $model->nombre = $nombre;
            //var_dump(trim(strtoupper($nombre)));die();
            if ($model->validate()) {
                if ($model->save()) {
                    $this->registerLog('ESCRITURA', 'articulo.procesarCambio', 'EXITOSO', 'Se modifico un alimento: ' . $id);
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con &eacute;xito.'));
                    //$this->registrarTraza('Eliminó un servicio al Plantel ' . $plantel_id, 'EliminarServicio');
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else { // si ingresa datos erroneos muestra mensaje de error.
                $this->renderPartial('//errorSumMsg', array('model' => $model));
                //Yii::app()->end();
            }
        } else {
            Yii::app()->user->setFlash('error', "No se ha podido completar la última operación, ID invalido.");
        }
        
        $unidadMedida = UnidadMedida::model()->findAll();
        $unidadMonetaria = UnidadMonetaria::model()->findAll(array("condition" => "estatus = 'A'"));
        $tipoArticulo = TipoArticulo::model()->findAll();
        $unidadMedidaUtencilio = UnidadMedida::model()->findAll(array('condition' => "nombre ILIKE 'PIEZA'"));
        $this->renderPartial('_form', array(
            'model' => $model,
            'unidadMedida' => $unidadMedida,
            'tipoArticulo' => $tipoArticulo,
            'unidadMedidaUtencilio' => $unidadMedidaUtencilio,
            'unidadMonetaria' => $unidadMonetaria
        ));
    }

    public function action_precioRegionLoad($id, $precio_region_id, $estado_id, $articulo_id) {
        $id = base64_decode($id);
        $nombreArticulo = Articulo::model()->findAll(array('condition' => 'id = ' . $id));
        $nombreArticulo = $nombreArticulo[0]['nombre'];
        $modelArticulo = Articulo::model()->findByPk($id);
        $precioRegion = Articulo::model()->precioRegion($id);
//        var_dump($nombreArticulo);die();
        if($precio_region_id != null) {
            $model = $this->loadModelPrecioRegion($precio_region_id);
        }
        else {
            $model = new PrecioRegion;
        }
        $this->renderPartial('_precioRegion', array(
            'model' => $model,
            'nombreArticulo' => $nombreArticulo,
            'modelArticulo' => $modelArticulo,
            'precioRegion' => $precioRegion,
            'estado_id' => $estado_id,
            'articulo_id' => $articulo_id,
            'articulo_model_id' => $id,
            'precio_region_id' => $precio_region_id));
    }

    public function actionInformacion($id) {
        $this->renderPartial('informacion', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionModificarPrecioRegion($id, $precio_region_id, $estado_id, $articulo_id) { /*ID ES EL ID DEL ARTICULO*/
        $nombreArticulo = Articulo::model()->findAll(array('condition' => 'id = ' . $id));
        $nombreArticulo = $nombreArticulo[0]['nombre'];
        if($precio_region_id != null) {
            $model = $this->loadModelPrecioRegion($precio_region_id);
        }
        else {
            $model = new PrecioRegion;
        }
        $this->renderPartial('_formPrecioRegion', array(
            'model' => $model,
            'nombreArticulo' => $nombreArticulo,
            'estado_id' => $estado_id,
            'articulo_id' => $articulo_id,
            'articulo_model_id' => $id,
            'precio_region_id' => $precio_region_id));
    }
    public function actionModificar($id) {
        $model = $this->loadModel($id);
        $unidadMedida = UnidadMedida::model()->findAll();
        $unidadMonetaria = UnidadMonetaria::model()->findAll(array("condition" => "estatus = 'A'"));
        $tipoArticulo = TipoArticulo::model()->findAll();
        $unidadMedidaUtencilio = UnidadMedida::model()->findAll(array('condition' => "nombre ILIKE 'PIEZA'"));
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $this->renderPartial('_form', array(
            'model' => $model,
            'unidadMedida' => $unidadMedida,
            'unidadMonetaria' => $unidadMonetaria,
            'tipoArticulo' => $tipoArticulo,
            'unidadMedidaUtencilio' => $unidadMedidaUtencilio,
            'tipoArticulo' => $tipoArticulo,
            'unidadMedidaUtencilio' => $unidadMedidaUtencilio
         ), FALSE, TRUE);
    }

    public function actionEliminarArticulo($id) {

        $model = Articulo::model()->findByPk($id);

        if ($model != null) {
            $articulo_id = $model->id;
            $resultadoEliminar = Articulo::model()->eliminarArticulo($articulo_id);
            //var_dump($resultadoActivar);die();
            if ($resultadoEliminar == 1) {
                $this->registerLog('ESCRITURA', 'articulo.eliminarArticulo', 'EXITOSO', 'Se inactivo un alimento: ' . $id);
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con exito.'));
            } else {
                throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
            }
        } else {
            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
        }
    }

    public function actionActivarArticulo($id) {
        // $model = new Nivel;
        $model = Articulo::model()->findByPk($id);

        if ($model != null) {
            $articulo_id = $model->id;

            $resultadoActivar = Articulo::model()->activarArticulo($articulo_id);
            if ($resultadoActivar == 1) {
                $this->registerLog('ESCRITURA', 'articulo.activarArticulo', 'EXITOSO', 'Se activo un alimento: ' . $id);
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Activación con exito.'));
            } else {
                throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
            }
        } else {
            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
        }
    }

    public function actionPrecioRegion($id) {
        $model = new Articulo;
        $id = base64_decode($id);
        $modelArticulo = Articulo::model()->findByPk($id);
        $precioRegion = $model->precioRegion($id);
        $this->render('precioRegion', array(
            'id'=> $id,
            'modelArticulo' => $modelArticulo,
            'precioRegion' => $precioRegion
        ));
    }

    public function columnaEstatus($data) {
        $estatus = $data['estatus'];
        if (($estatus == 'A') || ($estatus == '')) {
            return 'Activo';
        } else if ($estatus == 'E') {
            return 'Inactivo';
        }
    }

    public function columnaAcciones($data)
    /*
     * Botones del accion (crear, consultar)
     */ {
        $id = $data["id"];
        $estatus = $data["estatus"];
        
        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';
        
        if (($estatus == 'A') || ($estatus == '')) {
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Consultar Alimento</span>", '', array("class" => "fa fa-search-plus", "title" => "Consultar Alimento", "onClick" => "consultarArticulo($id)")) . '</li>';
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar Alimento</span>", '', array("class" => "fa fa-pencil green", "title" => "Modificar Alimento", "onClick" => "modificarArticulo($id)")) . '</li>';
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Precios Región</span>", "/catalogo/articulo/PrecioRegion?id=" . base64_encode($id), array("class" => "fa fa-money pink", "title" => "Precios de la región")) . '</li>';
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Inactivar Alimento</span>", '', array("class" => "fa fa-trash-o red", "title" => "Inactivar Alimento", "onClick" => "eliminarArticulo($id)")) . '</li>';
        } else if ($estatus == 'E') {
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Consultar Alimento</span>", '', array("class" => "fa fa-search-plus", "title" => "Consultar Alimento", "onClick" => "consultarArticulo($id)")) . '</li>';
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Activar Alimento</span>", '', array("class" => "fa fa icon-ok green", "title" => "Activar Alimento", "onClick" => "activarArticulo($id)")) . '</li>';
//            $columna = CHtml::link("", "", array("class" => "fa fa-search", "onClick" => "consultarArticulo($id)", "title" => "Consultar este articulo")) . '&nbsp;&nbsp;';
//            $columna .= CHtml::link("", "", array('onClick' => "activarArticulo($id)", "class" => "fa icon-ok green", "title" => "Activar este articulo")) . '&nbsp;&nbsp;';
        }
        $columna .= '</ul></div>';

        return $columna;
    }
    
    public function columnaPrecioRegulado($data) {
        $unidad_monetaria = UnidadMonetaria::model()->findAll(array('condition' => 'id = ' . $data['unidad_monetaria_id']));
        $columna = $data['precio_regulado']. ' ' .$unidad_monetaria[0]['abreviatura'];
        return $columna;
    }
    public function columnaPrecioReguladoBaremo($data) {
        $unidad_monetaria = UnidadMonetaria::model()->findAll(array('condition' => 'id = ' . $data['unidad_monetaria_id']));
        $columna = $data['precio_baremo']. ' ' .$unidad_monetaria[0]['abreviatura'];
        return $columna;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Articulo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Articulo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function loadModelPrecioRegion($id)
	{
		$model=PrecioRegion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Articulo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='articulo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
