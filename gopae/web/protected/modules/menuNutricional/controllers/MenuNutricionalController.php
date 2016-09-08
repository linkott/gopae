<?php

class MenuNutricionalController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Consulta de Menús Nutricionales',
        'write' => 'Creación y Modificación de Menús Nutricionales',
        'label' => 'Activación e Inactivación de Menús Nutricionales'
    );

    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

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
                    'activar',
                    'agregarAlimento',
                    'agregarSustituto',
                    'agregarAlimentoSustituto',
                    'quitarAlimentoSustituto',
                    'actualizarListado',
                    'ActualizarListadoDisponible',
                    'ObtenerUnidadMedida',
                    'BorrarMenuAlimento'
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
    public function actionView($id) {
        $id = base64_decode($id);
        $this->render('_view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new MenuNutricional;
        $estatus = false;
        $estatusMod = false;

        if (isset($_POST['MenuNutricional'])) {

            $model->attributes = $_POST['MenuNutricional'];
            $model->nombre = strtoupper($_POST['MenuNutricional']['nombre']);
            if (isset($model->descripcion)) {
                $filter = new InputFilter(array('em', 'i', 'br', 'b', 'strong', 'ol', 'ul', 'li', 'font', 'div', 'strike'));
                $model->descripcion = $filter->process($model->descripcion);
            }
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = "A";
            if ($model->save()) {
                $log = "creo un menú nutricional con el id " . $model->id;
                $this->registerLog(
                        "ESCRITURA", "create", "Exitoso", $log
                );
                $estatus = true;
                $this->redirect(array('update', 'id' => base64_encode($model->id), 'postAgregar' => base64_encode($model->id)  ));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'estatus' => $estatus,
            'estatusMod' => $estatusMod,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id, $postAgregar = null) {
        $id = base64_decode($id);
        $model = $this->loadModel($id);
        $modelAlimento = new Articulo;
        $estatusMod = false;
        $estatus = false;
        if($postAgregar != null){$estatus = true; }
        

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['MenuNutricional'])) {
            $model->attributes = $_POST['MenuNutricional'];
            $model->nombre = strtoupper($_POST['MenuNutricional']['nombre']);
            if (isset($model->descripcion)) {
                $filter = new InputFilter(array('em', 'i', 'br', 'b', 'strong', 'ol', 'ul', 'li', 'font', 'div', 'strike'));
                $model->descripcion = $filter->process($model->descripcion);
            }
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            $model->estatus = "A";

            if ($model->save()) {

                $log = "Modificó al menú nutricional con el id " . $model->id;
                $this->registerLog("ESCRITURA", "update", "Exitoso", $log);
                $estatusMod = true;
                $model = $this->loadModel($id);
            }
        }

        $this->render('update', array(
            'model' => $model,
            'estatus' => $estatus,
            'estatusMod' => $estatusMod,
            'modelAlimento' => $modelAlimento
        ));
    }

    public function actionAgregarAlimento() {
        $model = new MenuNutricionalAlimento;

        if (isset($_POST['MenuNutricionalAlimento'])) {

            $model->attributes = $_POST['MenuNutricionalAlimento'];
            $model->cantidad = $_POST['MenuNutricionalAlimento']['cantidad'];
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = "A";
            $modelAlimentoRepetido = MenuNutricionalAlimento::model()->findByAttributes(array('alimentos_id' => $model->alimentos_id, 'menu_nutricional_id' => $model->menu_nutricional_id));
            if ($modelAlimentoRepetido) {
                $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'El insumo : <b>' . $modelAlimentoRepetido->alimentos->nombre . '</b> ya ha sido registrado.'));
            } else {

                if ($model->save()) {
                    $log = "Agrego el Alimento con el id " . $model->id . " al menú nutricional con el id " . $_POST['MenuNutricionalAlimento']['menu_nutricional_id'];
                    $this->registerLog("ESCRITURA", "create", "Exitoso", $log);
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Registro Exitoso.'));
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
            }
        } else {
            throw new CHttpException(404, 'Error! Recurso no encontrado!');
        }
    }

    public function actionAgregarSustituto() {
        $idAlimento = $_POST["id"];
        $idMenu = $_POST["datos"];
        $modelMenu = $this->loadModel($idMenu);
        $model = new MenuNutricionalSustitutos;
        $modelMenuNutricional = MenuNutricionalAlimento::model()->findByPk($idAlimento);

        $modelAlimento = new Articulo;
        $estatus = false;
        $estatusMod = false;

        $this->renderPartial('_formAlimentoSustituto', array(
            'idAlimento' => $idAlimento,
            'modelMenu' => $idMenu,
            'model' => $model, //menu nutricional susutituto
            'modelAlimento' => $modelAlimento,
            'modelMenuNutricional' => $modelMenuNutricional,
            'estatus' => $estatus,
            'estatusMod' => $estatusMod,
        ));
    }

    public function actionAgregarAlimentoSustituto() {
        $arreglo = array();

        if (isset($_POST['id']) and isset($_POST['idAlimento'])) {
            $id = $_POST["id"];
            $idAlimento = $_POST['idAlimento'];
            $model = new MenuNutricionalSustitutos;
            $model->alimentos_id = $_POST['id'];
            $model->menu_nutricional_alimento_id = $_POST['idAlimento'];
            $model->cantidad = $_POST['cantidad'];
            $model->cantidad_mediana = $_POST['cantidad_mediana'];
            $model->cantidad_grande = $_POST['cantidad_grande'];
            
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = "A";
            $modelAlimentoRepetido = MenuNutricionalAlimento::model()->findByAttributes(array('alimentos_id' => $_POST['id'], 'menu_nutricional_id' => $_POST['idMenu']));
            $modelAlimentoSustitutoRepetido = MenuNutricionalSustitutos::model()->findByAttributes(array('alimentos_id' => $_POST['id'], 'menu_nutricional_alimento_id' => $_POST['idAlimento']));
            $modelAlimentoSustitutoRepetidoEnMenu = MenuNutricionalSustitutos::model()->AlimentoEnListaSustitutos($_POST['id'], $_POST['idMenu']);

            if ($modelAlimentoRepetido) {
                $arreglo["mensaje"] = $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'Ya el insumo: <b> ' . $modelAlimentoRepetido->alimentos->nombre . '</b>  se encuentra asignado al menú.'));
            } else if ($modelAlimentoSustitutoRepetido and $modelAlimentoSustitutoRepetido->menuNutricionalAlimento->menu_nutricional_id == $_POST['idMenu']) {
                $arreglo["mensaje"] = $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'Ya el insumo: <b> ' . $modelAlimentoSustitutoRepetido->alimentos->nombre . '</b>  se encuentra asignado.'));
            } else if ($modelAlimentoSustitutoRepetidoEnMenu) {
                $arreglo["mensaje"] = $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'Ya el insumo: <b> ' . $modelAlimentoSustitutoRepetidoEnMenu[0]["nombre"] . '</b>  se encuentra asignado como sustituto de otro alimento en este menú.'));
            } else {

                if($model->validate()){ 
                if ($model->save()) {
                    $log = "se agrego un sustituto con el id" . $model->id;
                    $this->registerLog("ESCRITURA", "create", "Exitoso", $log);
                    $arreglo["mensaje"] = $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Registro Exitoso.'));

//                  $arreglo["agregados"] = ;
//                  $arreglo["porAgregados"] = ;
                }
                
                }else {
            $arreglo["mensaje"] = $this->renderPartial('//errorSumMsg', array('model' => $model));
                      }
            }
        } else {
            throw new CHttpException(404, 'Error! Recurso no encontrado!');
        }
    }

    public function actionQuitarAlimentoSustituto() {


        if (isset($_POST['id'])) {
            $id = $_POST["id"];
            $idAlimento = $_POST['idAlimento'];
            $model = new MenuNutricionalSustitutos;
            $model = MenuNutricionalSustitutos::model()->findByPk($id);
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_elim = date("Y-m-d H:i:s");
            $model->estatus = "E";
            if ($model->delete()) {
                $log = "se Elimino un sustituto con el id" . $model->id;
                $this->registerLog(
                        "INACTIVAR", "QuitarAlimentoSustituto", "Exitoso", $log
                );
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con Exito.'));
            }
        } else {
            $this->renderPartial('//errorSumMsg', array('model' => $model));
        }
    }

    public function actionBorrarMenuAlimento($id) {
        $model = MenuNutricionalAlimento::model()->findByPk($id);

        if ($model) {
            $modeloSustitutos = MenuNutricionalSustitutos::model()->findByAttributes(array('menu_nutricional_alimento_id' => $id));


            if ($modeloSustitutos) {
                if ($modeloSustitutos->deleteAll("menu_nutricional_alimento_id = :mna", array(':mna' => $id))) {

                    if ($model->delete()) {
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con Exito.'));
                    } else {
                        $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Errores al eliminar el alimento.'));
                    }
                } else {
                    
                }
            } else {

                if ($model->delete()) {
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con Exito.'));
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Errores al eliminar el alimento.'));
                }
            }
        }
    }

    public function actionObtenerUnidadMedida() {
        $id = base64_decode($_POST['id']);
        $articulo = Articulo::model()->findByPk($id);
        //var_dump($articulo->unidadMedida->siglas);
        echo $articulo->unidadMedida->siglas;
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('MenuNutricional');
        $model = new MenuNutricional('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['MenuNutricional']))
            $model->attributes = $_GET['MenuNutricional'];


        $this->render('admin', array(
            'dataProvider' => $dataProvider,
            'model' => $model
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new MenuNutricional('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MenuNutricional']))
            $model->attributes = $_GET['MenuNutricional'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MenuNutricional the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MenuNutricional::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function columnaEstatusAlimento($data) {
        $estatus = $data['estatus'];
        if (($estatus == 'A') || ($estatus == '')) {
            return 'Activo';
        } else if ($estatus == 'E') {
            return 'Inactivo';
        }
    }

    public function columnaEstatus($data) {
        $estatus = $data['estatus'];
        if (($estatus == 'A') || ($estatus == '')) {
            return 'Activo';
        } else if ($estatus == 'E') {
            return 'Inactivo';
        }
    }

    public function estatus($data) {
        $estatus = $data['estatus'];
        if (($estatus == 'A') || ($estatus == '')) {
            return 'Activo';
        } else if ($estatus == 'E') {
            return 'Inactivo';
        }
    }

    public function actionBorrar() {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $id = base64_decode($id);

            $model = $this->loadModel($id);
            if ($model) {
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_elim = date("Y-m-d H:i:s");
                $model->estatus = "E";
                if ($model->save()) {
                    $this->registerLog(
                            "INACTIVAR", "borrar", "Exitoso", "Inactivo un Proveedor"
                    );
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Inactivado con exito.'));
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            } else {

                throw new CHttpException(404, 'Error! Recurso no encontrado!');
            }
        }
    }

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
                            "ACTIVAR", "activar", "Exitoso", "Activo un Proveedor"
                    );
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

    public function columnaAcciones($data) {
        $id = $data["id"];
        $id = base64_encode($id);

        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';


        if ($data->estatus == "E") {
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "/proveedor/proveedor/view/id/" . $id, array("class" => "fa fa-search blue", "title" => "Visualizar este Proveedor")) . '</li>';
            if (Yii::app()->user->group == 1) {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Activar </span>", "#", array("class" => "fa fa-check green", "title" => "Activar este Proveedor", "onClick" => "VentanaDialog('$id','/proveedor/proveedor/activar','Activar Proveedor','activar')")) . '</li>';
            }
        } else {

            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "/menuNutricional/menuNutricional/view/id/" . $id, array("class" => "fa fa-search blue", "title" => "Visualizar este Proveedor")) . '</li>';
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar</span>", "/menuNutricional/menuNutricional/update/id/" . $id, array("class" => "fa fa-pencil green", "title" => "Modificar este Proveedor")) . '</li>';
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar</span>", "#", array("class" => "fa fa-trash-o red", "title" => "Inactivar este Proveedor", "onClick" => "VentanaDialog('$id','/menuNutricional/menuNutricional/borrar','Inhabilitar Menú','borrar')")) . '</li>';
        }

        $columna .= '</ul></div>';
        return $columna;
    }

    public function columnaAccionesAlimentos($data) {
        $id = $data["id"];
        $idMenu = $data["menu_nutricional"];


        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';


        if ($data["estatus"] == "E") {
            if (Yii::app()->user->group == 1) {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Activar </span>", "#", array("class" => "fa fa-check green", "title" => "Activar este Proveedor", "onClick" => "VentanaDialog('$id','/proveedor/proveedor/activar','Activar Proveedor','activar')")) . '</li>';
            }
        } else {

            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Sustituto </span>", "", array("class" => "fa fa-plus blue", "title" => "Sustitutos de este alimento", "onClick" => "VentanaDialog('$id','/menuNutricional/menuNutricional/agregarSustituto','Sustitutos de Alimentos','agregarSustituto', '$idMenu')")) . '</li>';
            //$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar</span>", "/proveedor/proveedor/update/id/" . $id, array("class" => "fa fa-pencil green", "title" => "Modificar este Proveedor")) . '</li>';
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar</span>", "#", array("class" => "fa fa-trash-o red", "title" => "Eliminar alimento", "onClick" => "VentanaConfirm('$id','/menuNutricional/menuNutricional/borrarMenuAlimento','Eliminar Alimento','borrar')")) . '</li>';
        }

        $columna .= '</ul></div>';
        return $columna;
    }

    public function columnaAccionesAlimentosLista($data) {

        $id = $data["id"];

        $columna = CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Agregar </span>", "", array("class" => "fa fa-plus green", "title" => "Añadir como Sustituto", "onClick" => "agregarSustituto($id)"));

        return $columna;
    }

    public function columnaAccionesSustitutos($data) {

        $id = $data["id"];
        $columna = "";

        if ($data["estatus"] == "A") {

            $columna .= CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar </span>", "", array("class" => "fa fa-trash-o red", "title" => "Quitar Sustituto", "onClick" => "quitarSustituto($id)"));
        }


        return $columna;
    }

    public function columnaPrecioBaremo($data) {

        $val = $data["precio_baremo"];
        $columna = $val." Bs";

        return $columna;
    }
    
    public function columnaPrecioMercado($data) {

        $val = $data["precio_baremo"];
        $columna = $val." Bs";

        return $columna;
    }
    public function actionActualizarListado($id) {

        $model = new MenuNutricionalSustitutos;

        $this->widget('zii.widgets.grid.CGridView', array(
            'itemsCssClass' => 'table table-striped table-bordered table-hover',
            'id' => 'alimento-sustituto-grid',
            'dataProvider' => $model->searchAlimentoSustituto($id),
//                      'filter' => $model,
            'pager' => array('pageSize' => 1),
            'summaryText' => false,
            'pager' => array(
                'header' => '',
                'htmlOptions' => array('class' => 'pagination'),
                'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
            ),
            'columns' => array(
                array(
                    'header' => '<center title="nombre del Alimento Cargado"> Nombre </center>',
                    'name' => 'nombre',
                ),
                array(
                    'type' => 'raw',
                    'header' => '<center>Acciones</center>',
                    'value' => array($this, 'columnaAccionesSustitutos'),
                    'htmlOptions' => array('width' => '5%'),
                ),
            ),
        ));
    }

    public function actionActualizarListadoDisponible($id) {

        $modelAlimento = new Articulo;

        $this->widget('zii.widgets.grid.CGridView', array(
            'itemsCssClass' => 'table table-striped table-bordered table-hover',
            'id' => 'alimento-sustituto-sinAgregar-grid',
            'dataProvider' => $modelAlimento->searchAlimentoListado($id),
//                            'filter' => $model,
            'pager' => array('pageSize' => 1),
            'summaryText' => false,
            'pager' => array(
                'header' => '',
                'htmlOptions' => array('class' => 'pagination'),
                'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
            ),
            'columns' => array(
                array(
                    'header' => '<center title="nombre del Alimento Cargado"> Nombre </center>',
                    'name' => 'nombre',
                ),
                array(
                    'type' => 'raw',
                    'header' => '<center>Acciones</center>',
                    'value' => array($this, 'columnaAccionesAlimentosLista'),
                    'htmlOptions' => array('width' => '5%'),
                ),
            ),
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param MenuNutricional $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-nutricional-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
