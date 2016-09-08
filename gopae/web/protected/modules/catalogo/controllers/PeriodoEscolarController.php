<?php

class PeriodoEscolarController extends Controller {

    /**
     * @ Var string el diseño predeterminado de las opiniones. Por defecto es '/ / layouts/column2', significado
     * Usando diseño de dos columnas. Ver 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Consulta de Periodo Escolar',
        'write' => 'Gestion de Periodo Escolar',
        'label' => 'Módulo de Periodo Escolar'
    );

    /**
     * @ Return array filtros de acción
     */
    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Especifica las reglas de control de acceso.
     * Este método es utilizado por el filtro 'AccessControl'.
     * Reglas de control de acceso a una matriz @ return
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view'),
                'pbac' => array('read', 'write'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'activar', 'delete'),
                'pbac' => array('write'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Muestra un modelo en particular.
     * @ Param entero $ id de la ID del modelo de que se muestre
     */
    public function actionView($id) {
        $id = base64_decode($id);
        $this->renderPartial('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Crea un nuevo modelo.
     * Si la creación se realiza correctamente, el sistema mostrara un mensaje de creacion con exito.
     */
    public function actionCreate() {
        $model = new PeriodoEscolar;
        if (isset($_POST['PeriodoEscolar'])) {
            $model->usuario_ini_id = Yii::app()->user->name;
            $model->attributes = $_POST['PeriodoEscolar'];
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = "A";
            $mes = '09';
            $mes2 = 12;
            $anio_inicio = date("Y") - 1;
            $anio_fin = date("Y");
            $concatenar = $anio_inicio . "-" . $anio_fin;
            $model->periodo = $concatenar;
            $model->anio_inicio = $anio_inicio;
            $model->anio_fin = $anio_fin;
            if (date('m') <= $mes) {
                $anio_inicio = date("Y") + 1;
                $anio_fin = date("Y");
                $concatenar = $anio_inicio . "-" . $anio_fin;
            }
            $c = strlen($model->anio_fin);
            if ($model->validate()) {
                if ($c > 5) {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'upps! no puede exceder el limite.'));
                    return 0;
                } else
                if ($model->save()) {
                    $resultado = PeriodoEscolar::model()->Inactivar_todo($model->id);
                    $this->registerLog('ESCRITURA', 'catalogo.periodoEscolar.create', 'EXITOSO', 'Se ha creado un Periodo Escolar');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Exito! ya puede realizar otro registro.'));
                    $model = new PeriodoEscolar;
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            }
        }

        $this->renderPartial('create', array(
            'model' => $model,
        ));
    }
    public function actionUpdate($id) {
        $id = $_REQUEST['id'];
        $id = base64_decode($id);
        $model = $this->loadModel($id);
        if (isset($_POST['PeriodoEscolar'])) {
            $model->attributes = $_POST['PeriodoEscolar'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            if ($model->save())
                if ($model->validate()) {
                    if ($model->save()) {
                        $this->registrarTraza('Se modifico un periodo escolar', 'modificado');
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                        $model = $this->loadModel($id);
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                }
        }
        $this->renderPartial('update', array(
            'model' => $model,
        ));
    }
    /**
     * Esta acción nos lleva a la pantalla admin.
     */
    public function actionIndex() {
        $groupId = Yii::app()->user->group;
        $model = new PeriodoEscolar('search');

        if (isset($_GET['PeriodoEscolar']))
        $model->attributes = $_GET['PeriodoEscolar'];
        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('PeriodoEscolar');
        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));
    }
/**
      * Devuelve el modelo de datos basado en la clave principal dado en la variable GET.
      * Si no se encuentra el modelo de datos, se generará una excepción HTTP.
      * @ Param entero $ id de la ID del modelo de que se cargue
      * @ Return PeriodoEscolar el modelo cargado
      * @ Throws CHttpException
      */
    public function loadModel($id) {
        $model = PeriodoEscolar::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
/**
     * funcion que muestra el estatus completo en la mención, es decir el estatus se encuentra guardado
       con una sola letra ejemplo si es activo se guarda A. De manera que la funcion permite visualizar
       de forma completa el estatus.
     * @ Param string $data donde se carga las propiedades del modelo
     * @ Return $columna string
     * @ Autor Richard Massri
     */
    public function estatus($data) {
        $id = $data["estatus"];
        if ($id == 'A') {
            $columna = 'Activo';
        }

        if ($id == 'I') {
            $columna = 'Inactivo';
        }

        return $columna;
    }
  /*
     *Funcion que muestra las acciones en este modulo solo se puede visualizar un periodo.
     * @ Param string $datas donde se carga un array de las propiedades del modelo
     * @ Return $columna string
     * @ Autor Richard Massri
     */
    public function columnaAcciones($datas) {
        $groupId = Yii::app()->user->group;

        $id = $datas["id"];
        $id2 = $datas["estatus"];
        $id = base64_encode($id);
        //if($id=="A"){

        $columna = CHtml::link("", "#", array("class" => "fa fa-search", "title" => "Buscar Este Periodo Escolar", "onClick" => "VentanaDialog('$id','/catalogo/periodoEscolar/view','Mencion','view')")) . '&nbsp;&nbsp;';

        if ($id2 == "A" and $groupId == 1) {
            $columna = CHtml::link("", "#", array("class" => "fa fa-search", "title" => "Buscar Este Periodo Escolar", "onClick" => "VentanaDialog('$id','/catalogo/periodoEscolar/view','Mencion','view')")) . '&nbsp;&nbsp;';
        }

        return $columna;
    }

  /**
      * Realiza la validación de AJAX.
      * @ Param $ PeriodoEscolar modelo el modelo a validar
      */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'periodo-escolar-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


}
