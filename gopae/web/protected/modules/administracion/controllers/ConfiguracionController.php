<?php

class ConfiguracionController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';


    static $_permissionControl = array(
        'read' => 'Consulta de Configuraciones y Parámetros del Sistema',
        'write' => 'Registrar de Configuraciones y Parámetros del Sistema',
        'admin' => 'Administrarción de Configuraciones y Parámetros del Sistema',
        'label' => 'Módulo de Configuraciones y Parámetros del Sistema'
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
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'admin', 'create', 'activar', 'formularios', 'upload', 'view', 'guardarArchivo', 'exportar', 'update', 'tipo'),
                'pbac' => array('read', 'write','admin',),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id) {
        $idDecoded = base64_decode($id);
        $model = $this->loadModel($idDecoded);
        $this->renderPartial('view', array(
            'model' => $model,));
    }

    public function actionIndex() {

        $groupId = Yii::app()->user->group;
        $model = new Configuracion('search');
        if (isset($_GET['Configuracion']))
            $model->attributes = $_GET['Configuracion'];

        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('Configuracion');

        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));
    }

    public function fechaIni($data) {
        $fecha_Ini = $data["valor_date"];
        if (empty($fecha_Ini)) {
            $fecha_Ini = "";
        } else {
            $fecha_Ini = date("d-m-Y", strtotime($fecha_Ini));
        }
        return $fecha_Ini;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        var_dump("Este boton esta en mentanimiento");
        die();
    }

    public function actionUpdate($id) {
        $cod_tipo_dato = $_REQUEST['cod_tipo_dato'];
        $nombre = $_REQUEST['nombre'];
        $id = $_REQUEST['id'];
        $id = base64_decode($id);
        $model = $this->loadModel($id);
        if (isset($_POST['Configuracion'])) {
            if ((Yii::app()->getSession()->get('tipo') == 'date')) {
                $fecha_ini = $model->valor_date;
                $model->valor_date = $_POST['Configuracion']['valor_date'];
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_act = date("Y-m-d H:i:s");
            } elseif ((Yii::app()->getSession()->get('tipo') == 'bool')) {
                $model->valor_bool = $_POST['Configuracion']['valor_bool'];
                $model->usuario_act_id = Yii::app()->user->id;
                $model->fecha_act = date("Y-m-d H:i:s");
            }
            if (Yii::app()->getSession()->get('nombre') == 'FECHA_FIN_ASIG_TITU') {
                $resultado = Configuracion::model()->getFechaIniSolicitudTitulo();
                $fecha_ini = strtotime(date($model->valor_date, time()));
                $fecha_fin = strtotime(date($resultado, time()));
                //
                if ($fecha_ini > $fecha_fin) {
                    if ($model->validate()) {
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model = $this->loadModel($id);
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El valor ' . Yii::app()->getSession()->get('nombre') . ' no puede ser menor '));
                }
            } else if (Yii::app()->getSession()->get('nombre') == 'FECHA_INI_ASIG_TITU') {
                $resultado = Configuracion::model()->getFechaFinAsignacionTitulo();
                $fecha_ini = strtotime(date($model->valor_date, time()));
                $fecha_fin = strtotime(date($resultado, time()));
                if ($fecha_ini < $fecha_fin) {
                    if ($model->validate()) {
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model = $this->loadModel($id);
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El valor ' . Yii::app()->getSession()->get('nombre') . ' no puede ser mayor'));
                }
            } else if (Yii::app()->getSession()->get('nombre') == 'FECHA_INI_SOL_TIT') {
                $resultado = Configuracion::model()->getFechaFinSolicitudTitulo();
                $fecha_ini = strtotime(date($model->valor_date, time()));
                $fecha_fin = strtotime(date($resultado, time()));
                if ($fecha_ini < $fecha_fin) {
                    if ($model->validate()) {
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model = $this->loadModel($id);
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El nombre ' . Yii::app()->getSession()->get('nombre') . ' no puede ser mayor'));
                }
            } else if (Yii::app()->getSession()->get('nombre') == 'FECHA_FIN_SOLI_TIT') {
                $resultado = Configuracion::model()->getFechaIniSolicitudTitulo();
                $fecha_ini = strtotime(date($model->valor_date, time()));
                $fecha_fin = strtotime(date($resultado, time()));
                if ($fecha_ini > $fecha_fin) {
                    if ($model->validate()) {
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model = $this->loadModel($id);
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El nombre ' . Yii::app()->getSession()->get('nombre') . ' no puede ser menor'));
                }
            } else if (Yii::app()->getSession()->get('nombre') == 'FECHA_INI_REVISION') {
                $resultado = Configuracion::model()->getFechaFinSolicitudTitulo();
                $fecha_ini = strtotime(date($model->valor_date, time()));
                $fecha_fin = strtotime(date($resultado, time()));
                if ($fecha_ini < $fecha_fin) {
                    if ($model->validate()) {
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model = $this->loadModel($id);
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El nombre ' . Yii::app()->getSession()->get('nombre') . ' no puede ser mayor'));
                }
            } else if (Yii::app()->getSession()->get('nombre') == 'FECHA_FIN_REVISION') {
                $resultado = Configuracion::model()->getFechaIniRevision();
                $fecha_ini = strtotime(date($model->valor_date, time()));
                $fecha_fin = strtotime(date($resultado, time()));
                if ($fecha_ini > $fecha_fin) {
                    if ($model->validate()) {
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model = $this->loadModel($id);
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El nombre ' . Yii::app()->getSession()->get('nombre') . ' no puede ser menor'));
                }
            }else if(Yii::app()->getSession()->get('nombre') == 'FECHA_FIN_INSCRIP'){
              $resultado = Configuracion::model()->getFechaIniInscripc();
                $fecha_ini = strtotime(date($model->valor_date, time()));
                $fecha_fin = strtotime(date($resultado, time()));
                if ($fecha_ini > $fecha_fin) {
                    if ($model->validate()) {
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model = $this->loadModel($id);
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El nombre ' . Yii::app()->getSession()->get('nombre') . ' no puede ser menor'));
                }
             } else if (Yii::app()->getSession()->get('nombre') == 'FECHA_INI_INSCRIP') {
                $resultado = Configuracion::model()->getFechaFinInscripc();
                $fecha_ini = strtotime(date($model->valor_date, time()));
                $fecha_fin = strtotime(date($resultado, time()));
                if ($fecha_ini < $fecha_fin) {
                    if ($model->validate()) {
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model = $this->loadModel($id);
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El nombre ' . Yii::app()->getSession()->get('nombre') . ' no puede ser mayor'));
                }


                } else if (Yii::app()->getSession()->get('nombre') == 'FECHA_INI_USERS') {
                $resultado = Configuracion::model()->getFechaFinUsuarios();
                $fecha_ini = strtotime(date($model->valor_date, time()));
                $fecha_fin = strtotime(date($resultado, time()));
                if ($fecha_ini < $fecha_fin) {
                    if ($model->validate()) {
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model = $this->loadModel($id);
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El nombre ' . Yii::app()->getSession()->get('nombre') . ' no puede ser mayor'));
                }


                } else if (Yii::app()->getSession()->get('nombre') == 'FECHA_FIN_USERS') {
                $resultado = Configuracion::model()->getFechaIniUsuarios();
                $fecha_ini = strtotime(date($model->valor_date, time()));
                $fecha_fin = strtotime(date($resultado, time()));
                if ($fecha_ini > $fecha_fin) {
                    if ($model->validate()) {
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                            $model = $this->loadModel($id);
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El nombre ' . Yii::app()->getSession()->get('nombre') . ' no puede ser mayor'));
                }

                } else {
                if ($model->validate()) {
                    if ($model->save()) {
                        $this->registerLog('ESCRITURA', 'configuracion.extructura.update', 'EXITOSO', 'Se ha creado una configuración con exito');
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                        $model = $this->loadModel($id);
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
            }
        }

        if ($cod_tipo_dato == "date") {
            Yii::app()->getSession()->add('nombre', $nombre);
            Yii::app()->getSession()->add('tipo', $cod_tipo_dato);
            $this->renderPartial('tipo_dato_date', array(
                'model' => $model
            ));
        } else if ($cod_tipo_dato == "bool") {
            Yii::app()->getSession()->add('tipo', $cod_tipo_dato);
            $this->renderPartial('tipo_dato_bool', array(
                'model' => $model, false, true
            ));
        } else if ($cod_tipo_dato == "int") {
            Yii::app()->getSession()->add('tipo', $cod_tipo_dato);
            $this->renderPartial('tipo_dato_int', array(
                'model' => $model,
            ));
        } else if ($cod_tipo_dato == "str") {
            Yii::app()->getSession()->add('tipo', $cod_tipo_dato);
            $this->renderPartial('tipo_dato_str', array(
                'model' => $model,
            ));
        } else if ($cod_tipo_dato == "txt") {
            Yii::app()->getSession()->add('tipo', $cod_tipo_dato);
            $this->renderPartial('tipo_dato_txt', array(
                'model' => $model,
            ));
        } else if ($cod_tipo_dato == "") {
            Yii::app()->getSession()->add('tipo', $cod_tipo_dato);
            $this->renderPartial('tipo_dato_vacio', array(
                'model' => $model,
            ));
        }
    }

    public function estatus($datos) {
        $columna = '';
        $estatus = $datos['estatus'];
        if ($estatus == 'A') {
            $columna = 'Activo';
        }
        if ($estatus == 'E') {
            $columna = 'Eliminado';
        }
        return $columna;
    }

    public function tipoDato($tipo_dato) {
        $columna = '';
        $valor = $tipo_dato['cod_tipo_dato'];
        if ($valor == 'date') {
            $columna = 'Fecha';
        } elseif ($valor == 'bool') {
            $columna = 'Bool';
        } elseif ($valor == 'str') {
            $columna = 'Agrandar';
        } elseif ($valor == 'str') {
            $columna = 'Atring';
        } elseif ($valor == 'txt') {
            $columna = 'Texto';
        } elseif ($valor == 'int') {
            $columna = 'Entero';
        }
        return $columna;
    }

    public function columnaAcciones($datas) {
        $model = new Configuracion();
        $cod_tipo_dato = $datas['cod_tipo_dato'];
        $nombre = $datas['nombre'];
        $id_encoded = $datas["id"];
        $id = base64_encode($id_encoded);
        $usuario_ini_id = $datas["usuario_ini_id"];
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in", "title" => "Ver datos de la configuracion", "onClick" => "VentanaDialog('$id','/configuracion/configuracion/view','Configuracion','view')")) . '&nbsp;&nbsp;';
        $columna .= CHtml::link("", "", array("class" => "fa fa-pencil green", "title" => "Editar configuración", "onClick" => "VentanaDialog('$id','/configuracion/configuracion/update','Atender Ticket','update','$cod_tipo_dato','$nombre')")) . '&nbsp;&nbsp;';
        return $columna;
    }

    public function loadModel($id) {
        $model = Configuracion::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'configuracion') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
