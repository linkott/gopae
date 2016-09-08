<?php

class ProveedorController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    static $_permissionControl = array(
        'read' => 'Consulta de Proveedores',
        'write' => 'Creación y Modificación de Proveedores',
        'label' => 'Gestión de Proveedores'
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
                'actions' => array(
                    'index',
                    'view',
                    'admin',
                    'listarArchivo',
                    'seleccionarMunicipio',
                    'seleccionarParroquia',
                    'seleccionarPoblacion',
                    'seleccionarUrbanizacion',
                    'informacionSocio'
                ),
                'pbac' => array('read', 'write'),
            ),
            // en este array sólo van los action de actualizacion a BD
            array('allow',
                'actions' => array('create',
                    'registrar',
                    'crear',
                    'update',
                    'borrar',
                    'activar',
                    'upload',
                    'guardarArchivo',
                    'Descargar',
                    'modificarSocio',
                    'procesarCambioSocio',
                    'eliminarSocio',
                    'activarSocio'
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
    public function actionView() {
        $id_encoded = $_GET["id"];
        $id = base64_decode($id_encoded);
        $modelSocio = new Socio;
        $modelZona = new ZonaProveedor;
        $modelDocumentos = new DocumentoProveedor;
        $this->render('_view', array(
            'model' => $this->loadModel($id),
            'modelSocio' => $modelSocio,
            'modelZona' => $modelZona,
            'modelDocumentos' => $modelDocumentos,
            'proveedor_id' => $id,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Proveedor;
        $estatus = false;
        $estatusMod = false;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Proveedor'])) {
            $model->attributes = $_POST['Proveedor'];
            $model->razon_social = strtoupper($_POST['Proveedor']['razon_social']);
            $model->email = trim(strtoupper($_POST['Proveedor']['email']));
            $model->email_otro = trim(strtoupper($_POST['Proveedor']['email_otro']));
            $model->direccion = trim(strtoupper($_POST['Proveedor']['direccion']));
            $model->titular_cuenta = trim(strtoupper($_POST['Proveedor']['titular_cuenta']));

            $model->urbanizacion_id = $_POST['Proveedor']['urbanizacion_id'];
            $model->poblacion_id = $_POST['Proveedor']['poblacion_id'];
            $model->telefono_local = Utiles::onlyNumericString($_REQUEST['Proveedor']['telefono_local']);
            $model->telefono_celular = Utiles::onlyNumericString($_REQUEST['Proveedor']['telefono_celular']);
            $model->capital_social = (real) $_POST['Proveedor']['capital_social'];
            $model->vinculo_funcionario = (int) $_POST['Proveedor']['vinculo_funcionario'];

            if ($_POST['Proveedor']['ivss']) {
                $model->ivss = $_POST['Proveedor']['ivss'];
            } else {
                $model->ivss = "NO TIENE";
            }

            if ($_POST['Proveedor']['nil']) {
                $model->nil = $_POST['Proveedor']['nil'];
            } else {
                $model->nil = "NO TIENE";
            }

            if ($_POST['Proveedor']['inces']) {
                $model->inces = $_POST['Proveedor']['inces'];
            } else {
                $model->inces = "NO TIENE";
            }

            if ($_POST['Proveedor']['banavih']) {
                $model->banavih = $_POST['Proveedor']['banavih'];
            } else {
                $model->banavih = "NO TIENE";
            }

            if ($_POST['Proveedor']['snc']) {
                $model->snc = $_POST['Proveedor']['snc'];
            } else {
                $model->snc = "NO TIENE";
            }

            if ($_POST['Proveedor']['solvencia_laboral']) {
                $model->solvencia_laboral = $_POST['Proveedor']['solvencia_laboral'];
            } else {
                $model->solvencia_laboral = "NO TIENE";
            }

            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = "A";
            if ($model->save()) {
                $id_proveedor = $model->id;
                $model = new Proveedor;
                $estatus = true;

                $log = "creo un proveedor con el id " . $id_proveedor;
                $this->registerLog(
                        "ESCRITURA", "create", "Exitoso", $log
                );
                $this->redirect(array('proveedor/update/id/' . base64_encode($id_proveedor)));
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
    public function actionUpdate() {
        $id = base64_decode($_GET["id"]);
        $model = $this->loadModel($id);
        $estatusMod = false;
        $estatus = false;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Proveedor'])) {
            $rif = $model->rif;
            $model->attributes = $_POST['Proveedor'];
            $model->rif = $rif;
            $model->razon_social = strtoupper($_POST['Proveedor']['razon_social']);
            $model->email = strtoupper($_POST['Proveedor']['email']);
            $model->email_otro = strtoupper($_POST['Proveedor']['email_otro']);
            $model->direccion = strtoupper($_POST['Proveedor']['direccion']);
            $model->titular_cuenta = strtoupper($_POST['Proveedor']['titular_cuenta']);

            $model->urbanizacion_id = $_POST['Proveedor']['urbanizacion_id'];
            $model->poblacion_id = $_POST['Proveedor']['poblacion_id'];
            $model->telefono_local = Utiles::onlyNumericString($_REQUEST['Proveedor']['telefono_local']);
            $model->telefono_celular = Utiles::onlyNumericString($_REQUEST['Proveedor']['telefono_celular']);
            $model->capital_social = (real) $_POST['Proveedor']['capital_social'];
            $model->vinculo_funcionario = (int) $_POST['Proveedor']['vinculo_funcionario'];
            if ($_POST['Proveedor']['ivss']) {
                $model->ivss = $_POST['Proveedor']['ivss'];
            } else {
                $model->ivss = "NO TIENE";
            }

            if ($_POST['Proveedor']['nil']) {
                $model->nil = $_POST['Proveedor']['nil'];
            } else {
                $model->nil = "NO TIENE";
            }

            if ($_POST['Proveedor']['inces']) {
                $model->inces = $_POST['Proveedor']['inces'];
            } else {
                $model->inces = "NO TIENE";
            }

            if ($_POST['Proveedor']['banavih']) {
                $model->banavih = $_POST['Proveedor']['banavih'];
            } else {
                $model->banavih = "NO TIENE";
            }

            if ($_POST['Proveedor']['snc']) {
                $model->snc = $_POST['Proveedor']['snc'];
            } else {
                $model->snc = "NO TIENE";
            }

            if ($_POST['Proveedor']['solvencia_laboral']) {
                $model->solvencia_laboral = $_POST['Proveedor']['solvencia_laboral'];
            } else {
                $model->solvencia_laboral = "NO TIENE";
            }


            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = "A";
            if ($model->save()) {
                $estatusMod = true;
            }
        }


        $modelSocio = new Socio;
        $modelDocumento = new DocumentoProveedor;
        $modelZona = new ZonaProveedor;
        $this->render('update', array(
            'model' => $model,
            'modelSocio' => $modelSocio,
            'modelZona' => $modelZona,
            'modelDocumento' => $modelDocumento,
            'proveedor_id' => $id,
            'estatus' => $estatus,
            'estatusMod' => $estatusMod,
        ));
    }

    public function actionRegistrar() {
        $modelSocio = new Socio;
        $this->renderPartial('_formRegistrarSocio', array('model' => $modelSocio));
    }

    public function actionInformacionSocio($id) {
        $this->renderPartial('informacionSocio', array('model' => Socio::model()->findByPk($id)));
    }

    public function actionModificarSocio($id) {
//        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $model = Socio::model()->findByPk($id);
//            $proveedor_id = 0;
        if (isset($_REQUEST['Socio'])) {
            $proveedor_id = base64_decode($_REQUEST['Socio']['proveedor_id']);
        }
//        $modelSocio = new Socio;
//        $proveedor_id['Socio']['proveedor_id'] = $id;
        $this->renderPartial('_formRegistrarSocio', array('model' => $model, 'proveedor_id' => $proveedor_id));
    }

    public function actionEliminarSocio($id) {
        $model = Socio::model()->findByPk($id);

        if ($model != null) {
            $articulo_id = $model->id;
            $resultadoEliminar = Socio::model()->eliminarSocio($id);
            //var_dump($resultadoActivar);die();
            if ($resultadoEliminar == 1) {
                $this->registerLog('ESCRITURA', 'proveedores.eliminarSocio', 'EXITOSO', 'Se inactivo un socio: ' . $id);
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con éxito.'));
            } else {
                throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
            }
        } else {
            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
        }
    }

    public function actionActivarSocio($id) {
        // $model = new Nivel;
        $model = Socio::model()->findByPk($id);

        if ($model != null) {
            $id = $model->id;

            $resultadoActivar = Socio::model()->activarSocio($id);
            if ($resultadoActivar == 1) {
                $this->registerLog('ESCRITURA', 'proveedor.activarSocio', 'EXITOSO', 'Se activo un socio: ' . $id);
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Activación con exito.'));
            } else {
                throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
            }
        } else {
            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
        }
    }

    public function actionProcesarCambioSocio() {
        $modelSocio = new Socio;
        if (isset($_POST['Socio'])) {
            $id = (int) $_POST['Socio']['id'];
            $modelSocio = Socio::model()->findByPk($id);

            if (isset($_POST['Socio'])) {
                $modelSocio->rif = $_POST['Socio']['rif'];
                $modelSocio->nombres = $_POST['Socio']['nombres'];
                $modelSocio->apellidos = $_POST['Socio']['apellidos'];
                $modelSocio->telefono_celular = Utiles::onlyNumericString($_POST['Socio']['telefono_celular']);
                $modelSocio->correo = $_POST['Socio']['correo'];
                $modelSocio->certificado_salud = $_POST['Socio']['certificado_salud'];
                $modelSocio->proveedor_id = $_POST['Socio']['proveedor_id'];
                $modelSocio->tipo_socio = 0;
                $modelSocio->usuario_ini_id = Yii::app()->user->id;
                $modelSocio->fecha_ini = date("Y-m-d H:i:s");
                $modelSocio->estatus = 'A';
            }
            if ($modelSocio->validate()) {
                if ($modelSocio->save()) {
                    $this->registerLog('ESCRITURA', 'proveedor.procesarCambioSocio', 'EXITOSO', 'Se modifico un socio: ' . $id);
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Registro Exitoso.'));
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $modelSocio));
                }
            } else {
                $this->renderPartial('//errorSumMsg', array('model' => $modelSocio));
            }
            $this->renderPartial('_formRegistrarSocio', array('model' => $modelSocio));
        }
    }

    public function actionCrear() {
        $modelSocio = new Socio;
        if (isset($_POST['Socio'])) {
            $modelSocio->rif = $_POST['Socio']['rif'];
            $modelSocio->nombres = $_POST['Socio']['nombres'];
            $modelSocio->apellidos = $_POST['Socio']['apellidos'];
            $modelSocio->telefono_celular = Utiles::onlyNumericString($_POST['Socio']['telefono_celular']);
            $modelSocio->correo = $_POST['Socio']['correo'];
            $modelSocio->certificado_salud = $_POST['Socio']['certificado_salud'];
            $modelSocio->proveedor_id = $_POST['Socio']['proveedor_id'];
            $modelSocio->tipo_socio = 0;
            $modelSocio->usuario_ini_id = Yii::app()->user->id;
            $modelSocio->fecha_ini = date("Y-m-d H:i:s");
            $modelSocio->estatus = 'A';
        }
        if ($modelSocio->validate()) {
            if ($modelSocio->save()) {
                $this->registerLog('ESCRITURA', 'proveedor.crear', 'EXITOSO', 'Se creo un nuevo socio: RIF = (' . $modelSocio->rif . ')');
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Registro Exitoso.'));
                $modelSocio = new Socio;
            } else {
                $this->renderPartial('//errorSumMsg', array('model' => $modelSocio));
            }
        } else {
            $this->renderPartial('//errorSumMsg', array('model' => $modelSocio));
        }
        $this->renderPartial('_formRegistrarSocio', array('model' => $modelSocio));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Proveedor');
        $model = new Proveedor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Proveedor']))
            $model->attributes = $_GET['Proveedor'];
        $this->render('admin', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    public function actionModificar($id) {
        $model = $this->loadModel($id);
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $proveedor_id = 0;
        if (isset($_REQUEST['id'])) {
            $proveedor_id = base64_decode($_REQUEST['id']);
        }
        $this->renderPartial('_formSocio', array(
            'model' => $model,
            'proveedor_id' => $proveedor_id));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Proveedor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Proveedor']))
            $model->attributes = $_GET['Proveedor'];

        $this->render('admin', array(
            'model' => $model,
        ));
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

    public function columnaEstatus($data) {
        $estatus = $data['estatus'];
        if (($estatus == 'A') || ($estatus == '')) {
            return 'Activo';
        } else if ($estatus == 'E') {
            return 'Inactivo';
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Proveedor the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Proveedor::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionSeleccionarMunicipio() {
        $item = $_REQUEST['Proveedor']['estado_id'];

        if ($item == '' || $item == NULL) {
            $lista = array('' => '-Seleccione-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $lista = CMunicipio::getData('estado_id', $item);
            $lista = CHtml::listData($lista, 'id', 'nombre');

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Seleccione-'), true);

            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }
    }

    public function actionSeleccionarParroquia() {
        $item = $_REQUEST['Proveedor']['municipio_id'];

        if ($item == '' || $item == NULL) {
            $lista = array('' => '-Seleccione-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $lista = CParroquia::getData('municipio_id', $item);
            $lista = CHtml::listData($lista, 'id', 'nombre');

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Seleccione-'), true);

            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }
    }

    public function actionSeleccionarPoblacion() {
        $item = $_REQUEST['parroquia_id'];


        if ($item == '' || $item == NULL) {
            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $lista = Plantel::model()->obtenerPoblacion($item);
            $lista = CHtml::listData($lista, 'id', 'nombre');
//$data = CJSON::encode(Plantel::model()->obtenerPoblacion($item)); echo "$data";

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }
    }

    public function actionSeleccionarUrbanizacion() {
        $item = $_REQUEST['Proveedor']['parroquia_id'];
//$item=$_REQUEST['parroquia_id'];

        if ($item == '' || $item == NULL) {
            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $lista = Plantel::model()->obtenerUrbanizacion($item);
            $lista = CHtml::listData($lista, 'id', 'nombre');
//$data = CJSON::encode(Plantel::model()->obtenerPoblacion($item)); echo "$data";

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }
    }

    public function estatus($data) {
        $estatus = $data['estatus'];
        if (($estatus == 'A') || ($estatus == '')) {
            return 'Activo';
        } else if ($estatus == 'E') {
            return 'Inactivo';
        }
        return $columna;
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
            if (Yii::app()->user->pbac('proveedor.proveedor.read'))
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "/proveedor/proveedor/view/id/" . $id, array("class" => "fa fa-search blue", "title" => "Visualizar este Proveedor")) . '</li>';
            if (Yii::app()->user->pbac('proveedor.proveedor.write'))
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar</span>", "/proveedor/proveedor/update/id/" . $id, array("class" => "fa fa-pencil green", "title" => "Modificar Datos de este Proveedor")) . '</li>';
            if (Yii::app()->user->pbac('proveedor.notaEntrega.read') || (Yii::app()->user->pbac('proveedor.notaEntrega.write')) || (Yii::app()->user->pbac('proveedor.notaEntrega.admin')))
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Notas de Entrega </span>", "/proveedor/notaEntrega/index/id/" . $id, array("class" => "fa fa-file orange", "title" => "Administrar Notas de Entrega")) . '</li>';
            if (Yii::app()->user->pbac('proveedor.proveedor.write'))
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar</span>", "#", array("class" => "fa fa-trash-o red", "title" => "Inactivar este Proveedor", "onClick" => "VentanaDialog('$id','/proveedor/proveedor/borrar','Inhabilitar Modalidad','borrar')")) . '</li>';
        }

        $columna .= '</ul></div>';
        return $columna;
    }

    public function columnaAccionesSocio($data) {

        $id = $data["id"];
        $proveedor_id = $data["proveedor_id"];
//      $id = base64_encode($id);
        $url = $_SERVER['REQUEST_URI'];
        $separarUrl = explode('/', $url);
        $separarUrl = $separarUrl[count($separarUrl) - 3];

        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';


        if ($data->estatus == "E") {
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "", array("class" => "fa fa-search blue", "title" => "Visualizar este Socio", "onClick" => "consultarSocio(" . $id . ")")) . '</li>';
            if (Yii::app()->user->group == 1) {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Activar </span>", "", array("class" => "fa fa-check green", "title" => "Activar este Socio", "onClick" => "activarSocio('$id')")) . '</li>';
            }
        } else {

            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "", array("class" => "fa fa-search blue", "title" => "Visualizar este Socio", "onClick" => "consultarSocio(" . $id . ")")) . '</li>';
            if ($separarUrl != 'view') {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar</span>", "", array("class" => "fa fa-pencil green", "title" => "Modificar este Socio", "onClick" => "modificarSocio(" . $id . ", " . $proveedor_id . ")")) . '</li>';
                //$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Representante</span>", "", array("class" => "fa fa-male blue", "title" => "Asignar este Socio como Representante", "onClick" => "modificarSocio(" . $id . ", " . $proveedor_id . ")")) . '</li>';
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar</span>", "", array("class" => "fa fa-trash-o red", "title" => "Inactivar este Socio", "onClick" => "eliminarSocio('$id')")) . '</li>';
            }
        }

        $columna .= '</ul></div>';
        return $columna;
    }

    public function columnaAccionesZonas($data) {

        $id = $data["id"];
        $proveedor_id = $data["proveedor_id"];

        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';


        if ($data->estatus == "E") {
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "", array("class" => "fa fa-search blue", "title" => "Visualizar este Socio", "onClick" => "consultarSocio(" . $id . ")")) . '</li>';
            if (Yii::app()->user->group == 1) {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Activar </span>", "", array("class" => "fa fa-check green", "title" => "Activar este Socio", "onClick" => "activarSocio('$id')")) . '</li>';
            }
        } else {

            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "", array("class" => "fa fa-search blue", "title" => "Visualizar este Socio", "onClick" => "consultarSocio(" . $id . ")")) . '</li>';

            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar</span>", "", array("class" => "fa fa-pencil green", "title" => "Modificar este Socio", "onClick" => "modificarSocio(" . $id . ", " . $proveedor_id . ")")) . '</li>';

            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar</span>", "", array("class" => "fa fa-trash-o red", "title" => "Inactivar este Socio", "onClick" => "eliminarSocio('$id')")) . '</li>';
        }

        $columna .= '</ul></div>';
        return $columna;
    }

    public function columnaAccionesDocumentos($data) {
        $id = $data["id"];


        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';


        if ($data->estatus == "E") {
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "", array("class" => "fa fa-search blue", "title" => "Visualizar este Socio", "onClick" => "consultarDocumento(" . $id . ")")) . '</li>';
            if (Yii::app()->user->group == UserGroups::ADMIN_0) {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Activar </span>", "", array("class" => "fa fa-check green", "title" => "Activar este Socio", "onClick" => "activarDocumento('$id')")) . '</li>';
            }
        } else {

            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar</span>", "", array("class" => "fa fa-trash-o red", "title" => "Inactivar este Documentos", "onClick" => "eliminarDocumento('$id')")) . '</li>';
        }

        $columna .= '</ul></div>';
        return $columna;
    }

    public function actionUpload() {
        //$options = null, $initialize = true, $error_messages = null, $filename=null, $id_model=''
        $upload_handler = new UploadHandler(null, true, null, date('YmdHis') . 'DP', "/public/uploads/documentoProveedor/");
    }

    public function actionGuardarArchivo() {
        $id = $_POST["id"];
        $model = new DocumentoProveedor;
        $model->ruta = "/public/uploads/documentoProveedor/" . $id;
        $model->nombre = $_POST["nombreBD"];
        $model->proveedor_id = base64_decode($_POST["proveedor_id"]);
        $model->tipo_documento_id = $_POST["tipo_documento"];
        $model->usuario_ini_id = Yii::app()->user->id;
        $model->fecha_ini = date("Y-m-d H:i:s");
        $model->estatus = "A";
        if ($model->save()) {
            $this->registerLog(
                    "ESCRITURA", "guardarArchivo", "Exitoso", "Se cargo un archivo relacionado a un proveedor con el id" . $id, Yii::app()->request->userHostAddress, Yii::app()->user->id, date("Y-m-d H:i:s")
            );
            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Exito! ya puede subir otro archivo'));
        } else {
            $this->renderPartial('//errorSumMsg', array('model' => $model, false, true));
        }
    }

    public function actionDescargar() {
        if (isset($_GET["id"])) {

            $ruta = dirname(Yii::app()->basePath . '../');
            $id = base64_decode($_GET["id"]);
            $nombre = explode("/", $id, 5);

            $archivo = $ruta . $id;
            header("Content-disposition: attachment;filename=$nombre[4]");
            header("Content-type: application/octet-stream");
            readfile($archivo);
        }
    }

    /**
     * Performs the AJAX validation.
     * @param Proveedor $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'proveedor-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
