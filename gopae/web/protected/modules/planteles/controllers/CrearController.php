<?php

class CrearController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    const MODULO = "Planteles.Crear";

    static $_permissionControl = array(
        'read' => 'Creación de Planteles',
        'write' => 'Creación de Planteles',
        'label' => 'Creación de Planteles'
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
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                /*                 * ********ALEXIS*********** */
                'actions' => array(
                    'quitarProyecto',
                    'agregarProyecto',
                    'seleccionDistrito',
                    'asignacionTurno',
                    'actualizarServicios',
                    'quitarServicio',
                    'registrosAutoridad',
                    'agregarAutoridad',
                    'buscarCedula',
                    'eliminarAutoridad',
                    'seleccionarMunicipio',
                    'seleccionarParroquia',
                    'seleccionarLocalidad',
                    'agregarServicio',
                    'seleccionarPoblacion',
                    'seleccionarUrbanizacion',
                    'seleccionarTipoVia',
                    'agregarServicio',
                    'viaAutoComplete',
                    'informacionAula'
                ),
                'pbac' => array('read', 'write'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'index',
                    'registrosAutoridad',
                    'guardarAutoridad',
                    'guardarNuevaAutoridad',
                    'guardarEndogeno',
                    'guardarServicio',
                    'modificarAula',
                    'procesarCambioAula',
                    'registrarAula',
                    'crearAula',
                    'eliminarAula',
                    'upload'),
                'pbac' => array('write'),
            ),
            /*
              array('allow', // allow admin user to perform 'admin' and 'delete' actions
              'actions' => array('admin', 'delete'),
              'users' => array('@'),
              ), */
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionSeleccionarMunicipio() {
        $item = $_REQUEST['Plantel']['estado_id'];


        if ($item == '' || $item == NULL) {
            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $lista = Municipio::model()->findAll(array('condition' => 'estado_id =' . $item, 'order' => 'nombre ASC'));
            $lista = CHtml::listData($lista, 'id', 'nombre');

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }
    }

    public function actionSeleccionarParroquia() {
        $item = $_REQUEST['Plantel']['municipio_id'];

        if ($item == '' || $item == NULL) {
            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $lista = Parroquia::model()->findAll(array('condition' => 'municipio_id =' . $item, 'order' => 'nombre ASC'));
            $lista = CHtml::listData($lista, 'id', 'nombre');

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }
    }

    /*     * *********************ALEXIS EDITANDO *********************************************** */

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
        $item = $_REQUEST['Plantel']['parroquia_id'];
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

    public function actionSeleccionarTipoVia() {
        $item = $_REQUEST['Plantel']['parroquia_id'];


        if ($item == '' || $item == NULL) {
            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $lista = Plantel::model()->obtenerTipoVia($item);
            $lista = CHtml::listData($lista, 'id', 'nombre');
//$data = CJSON::encode(Plantel::model()->obtenerPoblacion($item)); echo "$data";

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }
    }

///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////Registrar plantel//////////////////////////////////////

    public function actionIndex() {

        $url = $_SERVER['REQUEST_URI'];
        $separarUrl = explode('/', $url);
        $separarUrl = $separarUrl[count($separarUrl) - 1];
//var_dump($separarUrl);
        if (($url[strlen($url) - 1] != '/') && ($separarUrl == '')) {
            $this->redirect('crear/');
// throw new CHttpException(404, "Dirección inválida.");
        }

        $model = new Plantel;
        $servicio = new Servicio;
        $tipoUbicacionPlantel = new TipoUbicacionPlantel;
        $tipoUbicacion = new TipoUbicacion;
        $usuario = new UserGroupsUser('nuevoUsuario');
        $fronteriza = null;
        $dificil_acceso = null;
        $indigena = null;
        $resultEstadistico = "";
        $resultadoCodigoP = "";
        $resultadoCodigoPN = "";
//    $usuario= Yii::app()->getSession()->get('cedula');
//  var_dump($usuario); die();
        $autoridadPlantel = new AutoridadPlantel;
        $proyectoEndo = new ProyectosEndogenosPlantel;
        $listaServicio = Yii::app()->getSession()->get('listaServicio') !== null ? Yii::app()->getSession()->get('listaServicio') : array();
        $listaProyecto = Yii::app()->getSession()->get('listaProyecto') !== null ? Yii::app()->getSession()->get('listaProyecto') : array();

        $nerV = (array_key_exists('ner', $_REQUEST) && $_REQUEST['ner'] === '') ? true : false;

        if ($nerV == true)
            $model->setScenario('crearDatosGeneralesNer');
        if ($nerV == false)
            $model->setScenario('crearDatosGeneralesSNer');


        if (isset($_POST['Plantel'])) {
            $model->attributes = $_REQUEST['Plantel']; // obtengo los atributos del modelo Plantel
            $model->nombre = strtoupper(trim($_REQUEST['Plantel']['nombre']));
            $model->direccion = strtoupper(trim($_REQUEST['Plantel']['direccion']));
            $cod_plantel = $model->cod_plantel = strtoupper(trim($_REQUEST['Plantel']['cod_plantel']));
            $model->correo = trim($_REQUEST['Plantel']['correo']);
            $cod_estadistico = $model->cod_estadistico = $_REQUEST['Plantel']['cod_estadistico'];
            $cod_plantelNer = strtoupper(trim($_REQUEST['Plantel']['cod_plantelNer']));
            $model->telefono_fijo = Utiles::onlyNumericString($_REQUEST['Plantel']['telefono_fijo']);
            $model->telefono_otro = Utiles::onlyNumericString($_REQUEST['Plantel']['telefono_otro']);
            $model->nfax = Utiles::onlyNumericString($_REQUEST['Plantel']['nfax']);
//            var_dump($model->telefono_fijo);
//            var_dump($model->telefono_otro);
//            var_dump($model->nfax);
// $codigo_ner = array_key_exists('codigo_ner', $_REQUEST['Plantel']) ? strtoupper(trim($_REQUEST['Plantel']['codigo_ner'])) : null;
            $ner = array_key_exists('ner', $_REQUEST) ? $_REQUEST['ner'] : null;
//  $nerV = false;
//   var_dump($cod_plantelNer);
            if (isset($_REQUEST['fronteriza']))
                $fronteriza = $_REQUEST['fronteriza'];
            if (isset($_REQUEST['indigena']))
                $indigena = $_REQUEST['indigena'];
            if (isset($_REQUEST['dificil_acceso']))
                $dificil_acceso = $_REQUEST['dificil_acceso'];

            if (isset($_REQUEST['Plantel']['cod_plantelNer'])) {
                if ($cod_plantelNer != '') {
                    $model->cod_plantel = $cod_plantelNer;
// var_dump($model->cod_plantel);
                    $ner = TRUE;
                }
            }


            if ($model->validate()) { //valido por yii los campos.
//    var_dump($dificil_acceso); die();
                $mensajeError = "";

                /*  if ($nerV) {
                  if ($nerV && $codigo_ner == '') {
                  $mensajeError .="El campo código ner no puede estar vacio. <br>";
                  }
                  if ($nerV && $cod_plantelNer == '') {
                  $mensajeError .="El campo código plantel ner no puede estar vacio. <br>";
                  }
                  } else {
                  if ($nerV == false && $cod_plantel == '') {
                  $mensajeError .="El campo código plantel no puede estar vacio. <br>";
                  }
                  } */

                if ($cod_estadistico != null || $cod_plantel != null || $cod_plantelNer != null) {//valido en bd que el codigo estadisco y el codigo de plantel no este registrado.
                    if ($cod_estadistico != null) {
                        if ($resultEstadistico = $model->validarCodEstadisticoRegistrar($cod_estadistico)) {
                            $mensajeError .="El codigo estadistico ingresado ya existe, intente nuevamente <br>";
                        }
                    }
                    if ($cod_plantel != null) {
                        if ($resultadoCodigoP = $model->validarCodPlantelRegistrar($cod_plantel)) {
                            $mensajeError .="El codigo plantel ingresado ya existe, intente nuevamente <br>";
                        }
                    }
                    if ($cod_plantelNer != null) {
                        if ($resultadoCodigoPN = $model->validarCodPlantelRegistrar($cod_plantelNer)) {
                            $mensajeError .="El codigo plantel Ner ingresado ya existe, intente nuevamente <br>";
                        }
                    }
                }
                $denominacion_id = $model->denominacion_id;
                $zona_educativa_id = $model->zona_educativa_id;
                $tipo_dependencia_id = $model->tipo_dependencia_id;
                $distrito_id = $model->distrito_id;
                $estatus_plantel_id = $model->estatus_plantel_id;
                $estado_id = $model->estado_id;
                $municipio_id = $model->municipio_id;
                $parroquia_id = $model->parroquia_id;
                /*                 * ********************ALEXIS********************* */
                $poblacion_id = $model->poblacion_id;
                $urbanizacion_id = $model->urbanizacion_id;
                $tipo_via_id = $model->tipo_via_id;
                $via = $model->via;
                /*                 * *********************************************** */
                $zona_ubicacion_id = $model->zona_ubicacion_id;
                $clase_plantel_id = $model->clase_plantel_id;
                $categoria_id = $model->categoria_id;
                $condicion_estudio_id = $model->condicion_estudio_id;
                $genero_id = $model->genero_id;
                $turno_id = $model->turno_id;
                $modalidad_id = $model->modalidad_id;

                if (is_numeric($model->denominacion_id)) {
                    $resultadoDenominacion = $model->validarExistenciaDenominacion($denominacion_id);
                    if ($resultadoDenominacion == 0) {
                        $mensajeError .="La denominación no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->zona_educativa_id)) {
                    $resultadoZonaEducativa = $model->validarExistenciaZonaEducativa($zona_educativa_id);
                    if ($resultadoZonaEducativa == 0) {
                        $mensajeError .="La zona educativa no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->tipo_dependencia_id)) {
                    $resultadoDependencia = $model->validarExistenciaTipoDependencia($tipo_dependencia_id);
                    if ($resultadoDependencia == 0) {
                        $mensajeError .="El tipo dependencia no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

// if (is_numeric($model->distrito_id)) {
// $resultadoDistrito=$model->validarExistenciaDistrito($distrito_id);
// if($resultadoDistrito == 0){
//    $mensajeError .="El distrito no se encuentra, Por favor intente nuevamente <br>";
//  }
// }

                if (is_numeric($model->estatus_plantel_id)) {
                    if ($estatus_plantel_id != 1) {
                        $mensajeError .="El estatus plantel no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->estado_id)) {
                    $resultadoEstado = $model->validarExistenciaEstado($estado_id);
                    if ($resultadoEstado == 0) {
                        $mensajeError .="El estado no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->municipio_id)) {
                    $resultadoMunicipio = $model->validarExistenciaMunicipio($municipio_id);
                    if ($resultadoMunicipio == 0) {
                        $mensajeError .="El municipio no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->parroquia_id)) {
                    $resultadoParroquia = $model->validarExistenciaParroquia($parroquia_id);
                    if ($resultadoParroquia == 0) {
                        $mensajeError .="La parroquia no se encuentra, Por favor intente nuevamente <br>";
                    }
                }
                /*                 * ****************************ALEXIS*************************************** */
                if (is_numeric($model->poblacion_id)) {
                    $resultadoPoblacion = $model->validarExistenciaPoblacion($poblacion_id);

                    if ($resultadoPoblacion == 0) {
                        $mensajeError .="La poblacion no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->urbanizacion_id)) {
                    $resultadoUrbanizacion = $model->validarExistenciaUrbanizacion($urbanizacion_id);
                    if ($resultadoUrbanizacion == 0) {
                        $mensajeError .="La urbanizacion no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->tipo_via_id)) {
                    $resultadoTipoVia = $model->validarExistenciaTipoVia($tipo_via_id);
                    if ($resultadoTipoVia == 0) {
                        $mensajeError .="El tipo de via no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                /*                 * ************************************************************************* */

                if (is_numeric($model->zona_ubicacion_id)) {
                    $resultadoZonaUbicacion = $model->validarExistenciaZonaUbicacion($zona_ubicacion_id);
                    if ($resultadoZonaUbicacion == 0) {
                        $mensajeError .="La zona ubicación no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->clase_plantel_id)) {
                    $resultadoClasePlantel = $model->validarExistenciaClasePlantel($clase_plantel_id);
                    if ($resultadoClasePlantel == 0) {
                        $mensajeError .="La clase plantel no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->categoria_id)) {
                    $resultadoCategoria = $model->validarExistenciaCategoria($categoria_id);
                    if ($resultadoCategoria == 0) {
                        $mensajeError .="La categoria no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->condicion_estudio_id)) {
                    $resultadoCondicionEstudio = $model->validarExistenciaCondicionEstudio($condicion_estudio_id);
                    if ($resultadoCondicionEstudio == 0) {
                        $mensajeError .="La condición estudio no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->genero_id)) {
                    $resultadoGenero = $model->validarExistenciaGenero($genero_id);
                    if ($resultadoGenero == 0) {
                        $mensajeError .="El tipo de matricula no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->turno_id)) {
                    $resultadoTurno = $model->validarExistenciaTurno($turno_id);
                    if ($resultadoTurno == 0) {
                        $mensajeError .="El turno no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if (is_numeric($model->modalidad_id)) {
                    $resultadoModalidad = $model->validarExistenciaModalidad($modalidad_id);
                    if ($resultadoModalidad == 0) {
                        $mensajeError .="La modalidad no se encuentra, Por favor intente nuevamente <br>";
                    }
                }

                if ($model->codigo_ner != '') {
                    $codigo_ner = explode(' ', $model->codigo_ner);

                    if ($codigo_ner[0] != 'NER')
                        $mensajeError .="El campo codigo ner debe tener la palabra NER al inicio seguido de un espacio, Por favor intente nuevamente <br>";
                    else if (!isset($codigo_ner[1]))
                        $mensajeError .="El campo codigo ner debe tener el código despues de la palabra ner, Por favor intente nuevamente <br>";
                }

                if ($mensajeError !== '') {
                    Yii::app()->user->setFlash('mensajeError', $mensajeError);
                    $this->renderPartial('//flashMsgv2');
                    Yii::app()->end();
                }


                /*    if ($ner == TRUE && strlen($cod_plantelNer) != 4) {
                  Yii::app()->user->setFlash('mensajeError', "El Código de Plantel debe poseer 4 caracteres<br>");
                  $this->renderPartial('//flashMsgv2');
                  Yii::app()->end();
                  } else
                  if ($ner == null && strlen($model->cod_plantel) != 10) {
                  Yii::app()->user->setFlash('mensajeError', "El Código de Plantel debe poseer 10 caracteres<br>");
                  $this->renderPartial('//flashMsgv2');
                  Yii::app()->end();
                  } */
                if (($resultEstadistico == 0 && $resultadoCodigoP == 0) || ($resultadoCodigoPN == 0 && $resultEstadistico == 0 )) {

//   var_dump($model); die();
                    if ($cod_plantel != null && $ner == null) {
                        $model->codigo_ner = null;
                        if ($model->save()) { //guardo con save que genera yii cuando genero el crud.
                            $idd = Yii::app()->getSession()->add('plantel_id', $model->id);
                            $plantel_id = $model->id; //obtengo id de plantel del registro que acabo de guardar.
                            $tipoUbicacionPlantel->guardarTipoUbicacion($plantel_id, $fronteriza, $indigena, $dificil_acceso);
                            $this->registerLog('GUARDAR', self::MODULO . '.Index', 'EXITOSO', 'Guardo Plantel');
                            $mensaje = "$idd";
                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                            $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                            Yii::app()->end();
                        } else { // error que no guardo
                            Yii::app()->user->setFlash('mensajeError', "Registro invalido, por favor intente nuevamente");
                            $this->renderPartial('//flashMsgv2');
                            Yii::app()->end();
                        }
                    }
                    if ($cod_plantelNer != null && $ner == TRUE) {
                        $model->cod_plantel = $cod_plantelNer;
                        if ($model->save()) { //guardo con save que genera yii cuando genero el crud.
                            $idd = Yii::app()->getSession()->add('plantel_id', $model->id);
                            $plantel_id = $model->id; //obtengo id de plantel del registro que acabo de guardar.
                            $tipoUbicacionPlantel->guardarTipoUbicacion($plantel_id, $fronteriza, $indigena, $dificil_acceso);
                            $this->registerLog('GUARDAR', self::MODULO . '.Index', 'EXITOSO', 'Guardo Plantel Ner' . $plantel_id);

                            $mensaje = "$idd";
                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                            $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                            Yii::app()->end();
                        } else { // error que no guardo
                            Yii::app()->user->setFlash('mensajeError', "Registro invalido, por favor intente nuevamente");
                            $this->renderPartial('//flashMsgv2');
                            Yii::app()->end();
                        }
                    }
                }
            } else { // si ingresa datos erroneos muestra mensaje de error.
                $this->renderPartial('//errorSumMsg', array('model' => $model));
                Yii::app()->end();
            }
        }

        $plantelId = Yii::app()->getSession()->get('plantel_id'); //obtengo el id del plantel que se creo.
        //   if ($plantelId != '') {

        /*  valido los id de la lista de servicios */
        $serviciosBD = ServicioPlantel::model()->getServiciosBD($plantelId, $listaServicio);
        Yii::app()->getSession()->add('listaServicio', $serviciosBD);
        $listaServicio = Yii::app()->getSession()->get('listaServicio');

        $models = Servicio::model()->getServicios($listaServicio);
        $list = CHtml::listData($models, 'id', 'nombre');
        /*  Fin */

        /*  valido los id de la lista de Proyectos Endogenos */
        $proyectosEndogenosBD = ProyectosEndogenosPlantel::model()->getProyectoBD($plantelId, $listaProyecto);
        Yii::app()->getSession()->add('listaProyecto', $proyectosEndogenosBD);
        $listaProyecto = Yii::app()->getSession()->get('listaProyecto');

        $proyectosEndoDisp = ProyectosEndogenos::model()->getProyectosEndogenos($listaProyecto);
        $listProyectosEndo = CHtml::listData($proyectosEndoDisp, 'id', 'nombre');
        /*  Fin */
        // }
        $distrito = Distrito::model()->findAll(array('order' => 'nombre ASC'));
        $denominacion = Denominacion::model()->findAll(array('order' => 'nombre ASC'));
        $estatusPlantel = EstatusPlantel::model()->findAll(array('order' => 'nombre ASC', 'condition' => 'id=1'));
        $tipoDependencia = TipoDependencia::model()->findAll(array('order' => 'nombre ASC'));
        $zonaEducativa = ZonaEducativa::model()->findAll(array('order' => 'nombre ASC'));
        $clasePlantel = ClasePlantel::model()->findAll(array('order' => 'nombre ASC'));
        $categoria = Categoria::model()->findAll(array('order' => 'nombre ASC'));
        $condicionEstudio = CondicionEstudio::model()->findAll(array('order' => 'nombre ASC'));
        $modalidadEstudio = Modalidad::model()->findAll(array('order' => 'nombre ASC'));
        $genero = Genero::model()->findAll(array('order' => 'nombre ASC'));
        $estado = Estado::model()->findAll(array('order' => 'nombre ASC'));
        $municipio = Municipio::model()->findAll(array('order' => 'nombre ASC'));
        $parroquia = Parroquia::model()->findAll(array('order' => 'nombre ASC'));
        /*         * *********************************ALEXIS***************************************** */
        $poblacion = Poblacion::model()->findAll(array('order' => 'nombre ASC'));
        $urbanizacion = Urbanizacion::model()->findAll(array('order' => 'nombre ASC'));
        /*         * ****************************************************************************** */
        $turno = Turno::model()->findAll(array('order' => 'nombre ASC'));
        $zona_ubicacion = ZonaUbicacion::model()->findAll(array('order' => 'nombre ASC'));
        $proyectosEndogenos = ProyectosEndogenos::model()->findAll(array('order' => 'nombre ASC'));
        $cargoSelect = Cargo::model()->findAll(array('order' => 'nombre ASC', 'condition' => 'id=3'));

        $modelAula = new Aula;

        $this->render('_form', array(
            'model' => $model,
            /*             * ******************ENRIQUE******************* */
            'modelAula' => $modelAula,
            /*             * ******************************************** */
            'tipoUbicacion' => $tipoUbicacion,
            'proyectoEndo' => $proyectoEndo,
            'autoridadPlantel' => $autoridadPlantel,
            'distrito' => $distrito,
            'denominacion' => $denominacion,
            'tipoDependencia' => $tipoDependencia,
            'zonaEducativa' => $zonaEducativa,
            'estatusPlantel' => $estatusPlantel,
            'clasePlantel' => $clasePlantel,
            'categoria' => $categoria,
            'condicionEstudio' => $condicionEstudio,
            'modalidadEstudio' => $modalidadEstudio,
            'genero' => $genero,
            'estado' => $estado,
            'municipio' => $municipio,
            'parroquia' => $parroquia,
            /*             * ******************ALEXIS******************** */
            'poblacion' => $poblacion,
            'urbanizacion' => $urbanizacion,
            /*             * ******************************************** */
            'turno' => $turno,
            'models' => $models,
            'list' => $list,
            'zona_ubicacion' => $zona_ubicacion,
            'proyectosEndogenos' => $proyectosEndogenos,
            'cargoSelect' => $cargoSelect,
            'dataProviderAutoridades' => array(),
            'autoridades' => array(),
            'usuario' => $usuario,
            'listProyectosEndo' => $listProyectosEndo
        ));

//        $plantel_id = Yii::app()->getSession()->add('plantel_id', 12842);/*NO VA CREAR SI NO OBTENER GET SESSION*/
        if ((isset($_REQUEST['Aula'])) || (isset($_REQUEST['ajax']))) {
            $modelAula = new Aula('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Aula']['plantel_id'])) {
                $model->attributes = $_GET['Aula'];
                $model->plantel_id = $plantel_id;
            }
            if (isset($_GET['plantel_id'])) {
                $model->plantel_id = $plantel_id;
            }
//            var_dump($model->plantel_id);die();
            $this->render('_formAula', array(
                'model' => $model,
                'modelAula' => $modelAula,
                'plantel_id' => $plantel_id,
            ));
        }
        $this->registerLog('LECTURA', self::MODULO . '.Index', 'EXITOSO', 'Entro al Registro del Plantel ');
    }

/////////////////////////////Fin del registro/////////////////////////////////////


    public function actionAsignacionTurno() {
        $model = new Plantel;
        $condicion_estudio_id = $model->condicion_estudio_id = $_REQUEST['Plantel']['condicion_estudio_id'];
//     var_dump($condicion_estudio_id); die();

        if ($condicion_estudio_id == '' || $condicion_estudio_id == NULL) {

            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
// var_dump($lista);die();
            }
        } else {
            if ($condicion_estudio_id == 1) {
                $listaTurno = Turno::model()->findAll(array('condition' => 'id= 4'));
                $listaInternado = CHtml::listData($listaTurno, 'id', 'nombre');
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

                foreach ($listaInternado as $valor => $descripcion) {
                    echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                }
            }
            if ($condicion_estudio_id == 2) {
                $listaTurno = Turno::model()->findAll(array('condition' => 'id= 5'));
                $listaSemi = CHtml::listData($listaTurno, 'id', 'nombre');
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

                foreach ($listaSemi as $valor => $descripcion) {
                    echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                }
// var_dump($lista); die();
            }
            if ($condicion_estudio_id == 3) {
                $listaTurno = Turno::model()->findAll(array('order' => 'nombre ASC'));
                $listaExterna = CHtml::listData($listaTurno, 'id', 'nombre');
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

                foreach ($listaExterna as $valor => $descripcion) {
                    echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                }
// var_dump($listaSemi); die();
            }
        }
    }

    /* ESTE CODIGO ES DESARROLLADO POR ENRIQUEX00 */

    public function actionInformacionAula($id) {
        $this->renderPartial('informacionAula', array(
            'model' => $this->loadAula($id),
        ));
    }

    public function actionRegistrarAula($id) {
        $model = new Aula;
        $loadModelPlantel = $this->loadModel($id);
        $condicionInfraestructura = CondicionInfraestructura::model()->findAll(array('order' => 'id ASC'));
        $tipoAula = TipoAula::model()->findAll(array('order' => 'id ASC'));
        $this->renderPartial('_formRegistrarAula', array(
            'model' => $model,
            'modelPlantel' => $loadModelPlantel,
            'modalidad_id' => $this->loadModalidad($loadModelPlantel['modalidad_id']),
            'condicionInfraestructura' => $condicionInfraestructura,
            'tipoAula' => $tipoAula,
                ), FALSE, TRUE);
    }

    public function actionCrearAula() {
        $model = new Aula;

        if (isset($_POST['Aula'])) {
            $id = $_POST['Aula']['plantel_id'];
            $loadModelPlantel = $this->loadModel($id);
            $condicionInfraestructura = CondicionInfraestructura::model()->findAll(array('order' => 'id ASC'));
            $tipoAula = TipoAula::model()->findAll(array('order' => 'id ASC'));

            $model->attributes = $_POST['Aula'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->fecha_act = date("Y-m-d H:i:s");
            $model->estatus = 'A';

            $capacidad = $model->capacidad;
            if ($capacidad > 50) {
                $model->capacidad = 50;
            }

            /* VALIDO LOS SCRIPTS O ETIQUETAS */
            $model->nombre = str_replace('<', '< ', $model->nombre);
            $model->observacion = str_replace('<', '< ', $model->observacion);

            if ($model->validate()) {

                $nombre = $model->nombre;
                $nombre = trim(strtoupper($nombre));
                $model->nombre = $nombre;

                $observacion = $model->observacion;
                $observacion = trim(strtoupper($observacion));
                $model->observacion = $observacion;

                if ($model->save()) {
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Registro Exitoso.'));
                    $this->registerLog('ESCRITURA', self::MODULO . '.CrearAula', 'EXITOSO', 'Registro un aula en el plantel' . $id);
                }
            } else { // si ingresa datos erroneos muestra mensaje de error.
                $this->renderPartial('//errorSumMsg', array('model' => $model));
//Yii::app()->end();
            }
        }
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $this->renderPartial('_formRegistrarAula', array(
            'model' => $model,
            'modelPlantel' => $loadModelPlantel,
            'modalidad_id' => $this->loadModalidad($loadModelPlantel['modalidad_id']),
            'condicionInfraestructura' => $condicionInfraestructura,
            'tipoAula' => $tipoAula,
        ));
    }

    public function actionModificarAula($id) {
        $model = $this->loadAula($id);
        $loadModelPlantel = $this->loadModel($model['plantel_id']);
        $condicionInfraestructura = CondicionInfraestructura::model()->findAll(array('order' => 'id ASC'));
        $tipoAula = TipoAula::model()->findAll(array('order' => 'id ASC'));
        $this->renderPartial('_formRegistrarAula', array(
            'model' => $model,
            'modelPlantel' => $loadModelPlantel,
            'modalidad_id' => $this->loadModalidad($loadModelPlantel['modalidad_id']),
            'condicionInfraestructura' => $condicionInfraestructura,
            'tipoAula' => $tipoAula,
                ), FALSE, TRUE);
    }

    public function actionProcesarCambioAula() {

        $model = new Aula;

        if (isset($_POST['Aula'])) {
            $id = $_POST['Aula']['plantel_id'];
            $aula_id = $_POST['Aula']['id'];
            $loadModelPlantel = $this->loadModel($id);
            $model = Aula::model()->findByPk($aula_id);
            $condicionInfraestructura = CondicionInfraestructura::model()->findAll(array('order' => 'id ASC'));
            $tipoAula = TipoAula::model()->findAll(array('order' => 'id ASC'));
            $model->attributes = $_POST['Aula'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");

            $capacidad = $model->capacidad;
            if ($capacidad > 50) {
                $model->capacidad = 50;
            }

            /* VALIDO LOS SCRIPTS O ETIQUETAS */
            $model->nombre = str_replace('<', '< ', $model->nombre);
            $model->observacion = str_replace('<', '< ', $model->observacion);

            $nombre = $model->nombre;
            $nombre = trim(strtoupper($nombre));
            $model->nombre = $nombre;

            $observacion = $model->observacion;
            $observacion = trim(strtoupper($observacion));
            $model->observacion = $observacion;

            if ($model->validate()) {

                if ($model->save()) {

                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                    $this->registerLog('MODIFICAR', self::MODULO . '.ProcesarCambioAula', 'EXITOSO', 'Modifico el Aula' . $aula_id . ' al plantel ' . $id);
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

        $this->renderPartial('_formRegistrarAula', array(
            'model' => $model,
            'modelPlantel' => $loadModelPlantel,
            'modalidad_id' => $this->loadModalidad($loadModelPlantel['modalidad_id']),
            'condicionInfraestructura' => $condicionInfraestructura,
            'tipoAula' => $tipoAula,
        ));
    }

    public function actionEliminarAula($id) {
//$model = $this->loadModel($id);
        $model = Aula::model()->findByPk($id);
        $model->fecha_elim = date("Y-m-d H:i:s");
        $model->estatus = 'E';

        if ($model->validate()) {

            if ($model->save()) {

                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con exito.'));
                $this->registerLog('ELIMINAR', self::MODULO . '.EliminarAula', 'EXITOSO', 'Elimino el Aula' . $id);
            } else {
                throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
            }
        }
    }

    /* FIN DEL CODIGO DESARROLLADO POR ENRIQUEX00 */

    public function actionSeleccionDistrito() {
        $model = new Plantel;
        $zona_educacion_id = $model->zona_educativa_id = $_REQUEST['Plantel']['zona_educativa_id'];
        $estado_id = $model->buscarEstado($zona_educacion_id);
//  var_dump($estado_id); die();

        if ($estado_id == '' || $estado_id == NULL) {

            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
// var_dump($lista);die();
            }
        } else {
            if ($estado_id != null) {
                $listaDistrito = Distrito::model()->findAll(array('condition' => 'estado_id=' . $estado_id . ''));
                $listaDistritoFinal = CHtml::listData($listaDistrito, 'id', 'nombre');
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

                foreach ($listaDistritoFinal as $valor => $descripcion) {
                    echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                }
            }
        }
    }

    public function actionAgregarProyecto() {

        if (isset($_REQUEST['proyecto_endogeno_id'])) {
            $listaProyecto = Yii::app()->getSession()->get('listaProyecto') !== null ? Yii::app()->getSession()->get('listaProyecto') : array();
            $proyecto = Yii::app()->getSession()->get('proyecto') !== null ? Yii::app()->getSession()->get('proyecto') : array();

            $rawData = array();
            $proyecto_endogeno_id = $_REQUEST['proyecto_endogeno_id'];
            $plantel_id = $_REQUEST['plantel_id'];
            $listadoProyectosEndogenos = ProyectosEndogenos::model()->getProyectosEndogenos(); //obtengo id y nombre
            $proyecto[] = array(
                'proyecto_endogeno_id' => $proyecto_endogeno_id,
                'plantel_id' => $plantel_id
            );
            $proyecto = array_unique($proyecto);

            $listaProyecto[] = $proyecto_endogeno_id;

// armado del dataProvider
            foreach ($proyecto as $key => $value) {
                $id = $value['proyecto_endogeno_id'];
                $listado = $listadoProyectosEndogenos[$value['proyecto_endogeno_id']];
                $nombre = $listado['nombre'];
                $boton = "<div class='center'>" .
                        CHtml::link("", "", array("class" => "icon-trash red remove-data", 'onClick' => "eliminarProyecto('$key', '$plantel_id')", "title" => "Eliminar Proyecto Endogeno")) .
                        "</div>";
                $rawData[] = array(
                    'id' => $key,
                    'nombre' => "<div class='center'>" . $nombre . "</div>",
                    'boton' => $boton
                );
            }
//      var_dump($rawData); die();
            $dataProviderPE = new CArrayDataProvider($rawData, array(
                'pagination' => false,
                    /*  'pagination' => array(
                      'pageSize' => 2,
                      ), */
                    )
            );
//  $id_proyecto[]=$id_proyecto;
// var_dump($id_proyecto);
            $proyectosEndoDisp = ProyectosEndogenos::model()->getProyectosEndogenos($listaProyecto);
            $listProyectosEndo = CHtml::listData($proyectosEndoDisp, 'id', 'nombre');
// var_dump($dataProviderPE); die();
// array_push($lista, $listaServicio);

            Yii::app()->getSession()->add('proyecto', $proyecto);
            Yii::app()->getSession()->add('listaProyecto', $listaProyecto);
// Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            $this->renderPartial('_formEndogeno', array(
                'listProyectosEndo' => $listProyectosEndo,
                'plantel_id' => $plantel_id,
                'dataProvider' => $dataProviderPE), false, true);
// Yii::app()->end();
        }
    }

    public function actionEliminarProyecto($listaProyectos, $fila) {
        for ($i = $fila; $i < count($listaProyectos); $i++) {
            if (isset($listaProyectos[$i + 1])) {
                $listaProyectos[$i] = $listaProyectos[$i + 1];
            } else
                unset($listaProyectos[$i]);
        }
        return $listaProyectos;
    }

    public function dataProviderProyectos($nombre, $rawData, $listadoProyectosEndogenos, $value, $key, $plantel_id) {
// var_dump($listadoProyectosEndogenos); die();
        $boton = "<div class='center'>" .
                CHtml::link("", "", array("class" => "icon-trash red remove-data", 'onClick' => "eliminarProyecto('$key', '$plantel_id')", "title" => "Eliminar Proyecto Endogeno")) .
                "</div>";
        $nombre = "<div class='center'>" . $nombre . "</div>";
        $rawData[] = array(
            'id' => $key,
            'nombre' => $nombre,
            'boton' => $boton
        );

        return $rawData;
    }

    public function actionQuitarProyecto() {

        $id = $_REQUEST['id'];
        $plantel_id = $_REQUEST['plantel_id'];
        $listaProyecto = Yii::app()->getSession()->get('proyecto');
//  var_dump($listaServicios); die();
        for ($i = $id; $i < count($listaProyecto); $i++) {
            if (isset($listaProyecto[$i + 1])) {
// echo 'me consigio';
                $listaProyecto[$i] = $listaProyecto[$i + 1];
//  var_dump($listaServicios[$i]); die();
            } else {
// echo 'no me consigio';
                unset($listaProyecto[$i]);
            }
        }

        $resultadoDataProvider = $this->actualizarProyecto($listaProyecto, $plantel_id);
//var_dump($listaServicios);
//   return $listaServicios;
    }

///////////////////////////////////////fin///////////////////////////////////////////


    public function actualizarProyecto($listaProyecto, $plantel_id) {

        $rawData = array();
        $idsProyecto = array();

        $listadoProyectosEndogenos = ProyectosEndogenos::model()->getProyectosEndogenos(); //obtengo id y nombre

        foreach ($listaProyecto as $key => $value) {
            $idsProyecto[] = $value['proyecto_endogeno_id'];
            $listado = $listadoProyectosEndogenos[$value['proyecto_endogeno_id']];
            $nombre = $listado['nombre'];
            $rawData = $this->dataProviderProyectos($nombre, $rawData, $listadoProyectosEndogenos, $value, $key, $plantel_id);
        }
//  var_dump($rawData); die();
        $dataProviderPE = new CArrayDataProvider($rawData, array(
            'pagination' => false,
                /* 'pagination' => array(
                  'pageSize' => 5,
                  ), */
        ));
//     var_dump($dataProvider); die();

        $proyectosEndoDisp = ProyectosEndogenos::model()->getProyectosEndogenos($idsProyecto);
        $listProyectosEndo = CHtml::listData($proyectosEndoDisp, 'id', 'nombre');
// var_dump($dataProviderPE); die();
// array_push($lista, $listaServicio);

        Yii::app()->getSession()->add('proyecto', $listaProyecto);
        Yii::app()->getSession()->add('listaProyecto', $idsProyecto);
        $this->renderPartial('_formEndogeno', array('dataProvider' => $dataProviderPE, 'listProyectosEndo' => $listProyectosEndo, 'plantel_id' => $plantel_id));
        Yii::app()->end();
    }

//////////////////////////Guardar proyectos endogenos/////////////////

    public function actionGuardarEndogeno() {

        $proyectoEndo = new ProyectosEndogenosPlantel;
        $idEndogeno = '';

        if (isset($_REQUEST['id'])) {
            $plantel_id = $_REQUEST['id'];
            $proyectosAgregados = Yii::app()->getSession()->get('proyecto');
//   var_dump($proyectosAgregados);
            if ($proyectosAgregados != NULL) {

                $existenciaRegistro = $proyectoEndo->verificacionExistencia($plantel_id, $proyectosAgregados); //verifico si existe un proyecto endogeno asociado al plantel
// var_dump($existenciaRegistro);
                if (sizeof($existenciaRegistro) > 0) {
                    if ($idEndogeno = $proyectoEndo->guardarProyectosEndogenos($plantel_id, $existenciaRegistro)) {
//   var_dump($idEndogeno); die();
                        $this->registerLog('GUARDAR', self::MODULO . '.GuardarEndogeno', 'EXITOSO', 'Guardo Proyectos Endogenos');

                        $_SESSION['proyecto'] = null;

                        $mensaje = $idEndogeno;
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                        Yii::app()->end();
                    } else {

                        Yii::app()->user->setFlash('mensajeError', "Registro invalido, por favor intente nuevamente");
                        $this->renderPartial('//flashMsgv2');
                        Yii::app()->end();
                    }
                } else {
                    Yii::app()->user->setFlash('mensajeError', "Por favor revise los registro que desea guardar, ya existe un proyecto endógeno asociado a este plantel");
                    $this->renderPartial('//flashMsgv2');
                    Yii::app()->end();
                }
            } else {

                Yii::app()->user->setFlash('mensajeError', "Por favor seleccione al menos un proyecto endógeno, para guardar");
                $this->renderPartial('//flashMsgv2');
                Yii::app()->end();
            }
        }

        Yii::app()->user->setFlash('mensajeError', "Error, intente nuevamente");
        $this->renderPartial('//flashMsgv2');
        Yii::app()->end();
    }

//////////////////////////////Fin del registro///////////////////////////////////////////
/////////////////////////////Agregar Servicio////////////////////////////////////////////
    public function actionAgregarServicio() {

        if (isset($_REQUEST['id']) && isset($_REQUEST['calidad'])) {

            $servicios = array();
            $listaServicio = Yii::app()->getSession()->get('listaServicio') !== null ? Yii::app()->getSession()->get('listaServicio') : array();
            $servicios = Yii::app()->getSession()->get('servicios') !== null ? Yii::app()->getSession()->get('servicios') : array();
// var_dump($servicios);
            $rawData = array();

            $nombres_servicios = Servicio::model()->getServicios();
            $condicion_infra = CondicionServicio::model()->getCondServ();
            $servicio_id = $_REQUEST['id'];
            $calidad = $_REQUEST['calidad'];
            $plantel_id = $_REQUEST['plantel_id'];
            $fecha_desde = $_REQUEST['fecha_desde'];
// var_dump($servicios);
//            if ($servicios != array()) {
//                echo 'pase pr aqui';
//
//                foreach ($servicios as $key => $value) {
//                    $servicio_id = $value['servicio_id'];
//                    var_dump($servicio_id . ' $key');
//
//                    $servicios[] = array(
//                        'servicio_id' => $servicio_ids,
//                        'calidad' => $calidad,
//                        'plantel_id' => $plantel_id,
//                        'fecha_desde' => $fecha_desde
//                    );
//                    //  var_dump($key . ' total');
//                    //    die();
//                    for ($x = 1; $x < count($servicios); $x++) {
//
//                        $servicio_id_nuevo = $servicios[$x]['servicio_id'];
//                        var_dump($servicio_id_nuevo . ' for');
//                        //   die();
//                        if ($servicio_id != $servicio_id_nuevo) {
//                            echo "entro";
//                            $servicios[] = array(
//                                'servicio_id' => $servicio_ids,
//                                'calidad' => $calidad,
//                                'plantel_id' => $plantel_id,
//                                'fecha_desde' => $fecha_desde
//                            );
//                            //   die();
//                        } else {
//                            echo "array vacio";
//                            $servicios[] = array(
//                                'servicio_id' => $servicio_id,
//                                'calidad' => $calidad,
//                                'plantel_id' => $plantel_id,
//                                'fecha_desde' => $fecha_desde
//                            );
//                        }
//                    }
//                }
//            } else {
//                $servicios[] = array(
//                    'servicio_id' => $servicio_ids,
//                    'calidad' => $calidad,
//                    'plantel_id' => $plantel_id,
//                    'fecha_desde' => $fecha_desde
//                );
//            }



            $servicios[] = array(
                'servicio_id' => $servicio_id,
                'calidad' => $calidad,
                'plantel_id' => $plantel_id,
                'fecha_desde' => $fecha_desde
            );
            $incrementar = 0;

            foreach ($servicios as $key => $value) {
                $servicio_ids = $value['servicio_id'];

                //  var_dump($servicio_ids . ' $servicio_ids');

                if (isset($servicios[$key + 1])) {

                    $incrementar = ++$incrementar;
                    //    var_dump($incrementar);
                    $contar = count($servicios);
                    //  var_dump(count($contar) . ' total');

                    for ($x = $incrementar; $x < $contar; $x++) {

                        if (isset($servicios[$x]['servicio_id']))
                            $servicio_id_nuevo = $servicios[$x]['servicio_id'];
                        else
                            break;
                        //    var_dump($servicio_id_nuevo . ' $servicio_id_nuevo');

                        if ($servicio_ids == $servicio_id_nuevo) {
                            //    echo "entro cuando son iguales";
                            unset($servicios[$x]);
                            $servicios = array_values($servicios);
//        var_dump($servicio);
                        }
                    }
                } else {
                    //    echo 'no existo';
                    break;
                }
            }
//       }
            //     var_dump($servicios);

            $listaServicio[] = $servicio_id;


            foreach ($servicios as $key => $value) {
//                $value = array_unique($value);
//                var_dump($value);
                $id = $value['servicio_id'];
                $fecha_desde = $value['fecha_desde'];
                $boton = "<div class='center'>" .
                        CHtml::link("", "", array("class" => "icon-trash red remove-data", 'onClick' => "eliminarServicio('$key', '$plantel_id')", "title" => "Eliminar Servicio")) .
                        "</div>";
                $rawData[] = array(
                    'id' => $key,
                    'servicio' => "<div class='center'>" . $nombres_servicios[$value['servicio_id']]['nombre'] . "</div>",
                    'calidad' => "<div class='center'>" . $condicion_infra[$value['calidad']]['nombre'] . "</div>",
                    'fecha_desde' => "<div class='center'>" . $fecha_desde . "</div>",
                    'boton' => $boton
                );
            }
//  var_dump($rawData); die();
            $dataProvider = new CArrayDataProvider($rawData, array(
                'pagination' => false,
                    /* 'pagination' => array(
                      'pageSize' => 5,
                      ), */
                    )
            );
//     var_dump($dataProvider); die();
            $models = Servicio::model()->getServicios($listaServicio);
            $list = CHtml::listData($models, 'id', 'nombre');

// array_push($lista, $listaServicio);

            Yii::app()->getSession()->add('servicios', $servicios);
            Yii::app()->getSession()->add('listaServicio', $listaServicio);
// Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            $this->renderPartial('_formServicio', array('dataProvider' => $dataProvider,
                'list' => $list,
                'plantel_id' => $plantel_id), false, true);
// Yii::app()->end();
        } else {

        }
    }

////////////////////////////fin/////////////////////////////////////////////////////
/////////////////////////////eliminar servicio//////////////////////////////////////
    public function actionQuitarServicio() {

        $id = $_REQUEST['id'];
        $plantel_id = $_REQUEST['plantel_id'];
        $listaServicios = Yii::app()->getSession()->get('servicios');
//  var_dump($listaServicios); die();
        for ($i = $id; $i < count($listaServicios); $i++) {
            if (isset($listaServicios[$i + 1])) {
// echo 'me consigio';
                $listaServicios[$i] = $listaServicios[$i + 1];
//  var_dump($listaServicios[$i]); die();
            } else {
// echo 'no me consigio';
                unset($listaServicios[$i]);
            }
        }

        $resultadoDataProvider = $this->actualizarServicio($listaServicios, $plantel_id);
//var_dump($listaServicios);
//   return $listaServicios;
    }

///////////////////////////////////////fin///////////////////////////////////////////


    public function actualizarServicio($listaServicios, $plantel_id) {

        $rawData = array();
        $idsServicios = array();

        $nombres_servicios = Servicio::model()->getServicios();
        $condicion_infra = CondicionServicio::model()->getCondServ();

        foreach ($listaServicios as $key => $value) {
            $idsServicios[] = $value['servicio_id'];
            $fecha_desde = $value['fecha_desde'];
            $boton = "<div class='center'>" .
                    CHtml::link("", "", array("class" => "icon-trash red remove-data", 'onClick' => "eliminarServicio('$key', '$plantel_id')", "title" => "Eliminar Servicio")) .
                    "</div>";
            $rawData[] = array(
                'id' => $key,
                'servicio' => "<div class='center'>" . $nombres_servicios[$value['servicio_id']]['nombre'] . "</div>",
                'calidad' => "<div class='center'>" . $condicion_infra[$value['calidad']]['nombre'] . "</div>",
                'fecha_desde' => "<div class='center'>" . $fecha_desde . "</div>",
                'boton' => $boton
            );
        }
//  var_dump($rawData); die();
        $dataProvider = new CArrayDataProvider($rawData, array(
            'pagination' => false,
                /* 'pagination' => array(
                  'pageSize' => 5,
                  ), */
        ));
//     var_dump($dataProvider); die();
        $models = Servicio::model()->getServicios($idsServicios);
        $list = CHtml::listData($models, 'id', 'nombre');

// array_push($lista, $listaServicio);

        Yii::app()->getSession()->add('servicios', $listaServicios);
        Yii::app()->getSession()->add('listaServicio', $idsServicios);
        $this->renderPartial('_formServicio', array('dataProvider' => $dataProvider, 'list' => $list, 'plantel_id' => $plantel_id));
        Yii::app()->end();
    }

///////////////////////////////////Guardar Servicio////////////////////////////////////////////

    public function actionGuardarServicio() {


        $plantel_id = $_REQUEST['plantel_id'];
        $servicios = Yii::app()->getSession()->get('servicios');
        $resultadoSP = ServicioPlantel::model()->buscarServicioPlantel($plantel_id, $servicios);
        if ($resultadoSP == array()) {
//            var_dump($servicios);
//            die();
            if ($servicios != array()) {
                $existenciaRegistro = ServicioPlantel::model()->verificacionExistencia($plantel_id, $servicios); //verifico si existe un servicio asociado al plantel
                //    var_dump($existenciaRegistro);

                if (sizeof($existenciaRegistro[1]) > 0 && sizeof($existenciaRegistro[0]) > 0) {
                    //   echo "entro";
                    if ($idServicioPlantel = ServicioPlantel::model()->guardarServicios($plantel_id, $existenciaRegistro)) {
//                        var_dump($idServicioPlantel);
//                        die();
                        $this->registerLog('GUARDAR', self::MODULO . '.GuardarServicio', 'EXITOSO', 'Guardo Servicios');
                        $_SESSION['servicios'] = null;

                        $mensaje = $idServicioPlantel;
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                        Yii::app()->end();
                    } else {

                        Yii::app()->user->setFlash('mensajeError', "Registro invalido, por favor intente nuevamente");
                        $this->renderPartial('//flashMsgv2');
                        Yii::app()->end();
                    }
                } else {
                    Yii::app()->user->setFlash('mensajeError', "Por favor revise los registro que desea guardar, ya existe este servicio asociado a este plantel");
                    $this->renderPartial('//flashMsgv2');
                    Yii::app()->end();
                }
            } else {
                Yii::app()->user->setFlash('mensajeError', "Por favor seleccione al menos un servicio, para guardar");
                $this->renderPartial('//flashMsgv2');
                Yii::app()->end();
            }
        } else {
            Yii::app()->user->setFlash('mensajeError', "Por favor seleccione datos correctos, el servicio ya esta registrado para este plantel");
            $this->renderPartial('//flashMsgv2');
            Yii::app()->end();
        }
// } echo 'error';
    }

////////////////////////////////////////////////fin//////////////////////////////////////////////////////
///////////////////////////////Buscar cedula en la tabla usergroups_user//////////////////////
    public function actionBuscarCedula() {
        if (isset($_REQUEST['cedula']) && isset($_REQUEST['plantel_id'])) {
            $cedula = $_REQUEST['cedula'];
            $plantel_id = (int) $_REQUEST['plantel_id'];
            $existe = false;
            $cedulaArrayDecoded = array();
            $cedulaDecoded = "";
            if (strpos($cedula, "-")) {
                $cedulaArrayDecoded = explode("-", $cedula);
                if (count($cedulaArrayDecoded) == 2) {
                    $origen = $cedulaArrayDecoded[0];
                    $cedulaDecoded = $cedulaArrayDecoded[1];
                    if (!(is_string($origen) && strlen($origen) == 1 && is_numeric($cedulaDecoded) && strlen($cedulaDecoded) > 1 && strlen($cedulaDecoded) <= 8)) {
// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                        $mensaje = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                        Yii::app()->end();
                    }
                } else {
// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                    $mensaje = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                    Yii::app()->end();
                }
            } else {
// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                $mensaje = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                Yii::app()->end();
            }

            $autoridades = AutoridadPlantel::model()->buscarAutoridadesPlantel($plantel_id);

            if ($autoridades == array()) {
                /*
                 * Es la primera vez que entra en este ciclo por lo tanto solo resta buscar la cedula en la base de datos
                 * Si es distinto de un array() es porque anteriormente ya habia agregado una autoridad al plantel,
                 * en ese caso hay que validar si la cedula no esta primero en este arreglo
                 */
                $this->validarUsuario($origen, $cedulaDecoded, $autoridades, $plantel_id);
            } else {

                foreach ($autoridades as $key => $value) {
                    if ($value['cedula'] == $cedulaDecoded) {
                        $existe = true;
                        $mensaje = "Esta cedula posee un cargo asignado.";
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
//$this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                        Yii::app()->end();
                    }
                }
                if (!$existe) {
                    $this->validarUsuario($origen, $cedulaDecoded, $autoridades, $plantel_id);
                }
            }
        } else {
            throw new CHttpException(404, 'No se han especificado los datos necesarios. Recargue la página e intentelo de nuevo.'); // esta vacio el request
        }
    }

///////////////////////////////////////fin////////////////////////////////////////////////
//
//
////////////////////////////////Agregar Autoridad///////////////////////////////////////////
    public function actionAgregarAutoridad() {

        if (isset($_REQUEST['cedula']) && isset($_REQUEST['cargo']) && isset($_REQUEST['plantel_id'])) {
            $autoridadPlantel = new AutoridadPlantel;
            $cargoModel = new Cargo;
            $rawData = array();
            $cedula = $_REQUEST['cedula'];
            $cargo = $_REQUEST['cargo'];
            $plantel_id = $_REQUEST['plantel_id'];
            $autoridades = $autoridadPlantel->buscarAutoridadesPlantel($plantel_id);
            if (strpos($cedula, "-")) {
                $cedulaArrayDecoded = explode("-", $cedula);
                if (count($cedulaArrayDecoded) == 2) {
                    $origen = $cedulaArrayDecoded[0];
                    $cedulaDecoded = $cedulaArrayDecoded[1];
                    if (!(is_string($origen) && strlen($origen) == 1 && is_numeric($cedulaDecoded) && strlen($cedulaDecoded) > 1 && strlen($cedulaDecoded) <= 8)) {
// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                        $mensaje = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                        Yii::app()->end();
                    }
                } else {
// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                    $mensaje = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                    Yii::app()->end();
                }
            } else {
// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                $mensaje = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                Yii::app()->end();
            }


            if ($autoridades == array()) {
                $resultadoValidacionCargo = $autoridadPlantel->validarExisteCargo($cargo, $plantel_id);
                if ($resultadoValidacionCargo != $cargo) {
                    $datosUsuario = $autoridadPlantel->buscarUsuarioId($cedulaDecoded); // devuelve el id, nombre, apellido, email de la tabla seguridad.usergroups_user donde la cedula sea igual a $cedulaDecoded
                    $autoridadPlantel->agregarAutoridad($plantel_id, $cargo, $datosUsuario, $cedulaDecoded); // Construyo un array con todos los datos que envio y guardo
                } else {
                    $mensaje = "Este cargo ya esta asignado a otra persona";
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                    Yii::app()->end();
                }
            } else {
                /*
                 *  validamos que en el plantel no haya otro usuario con ese cargo
                 */
                $resultadoValidacionCargo = AutoridadPlantel ::model()->validarExisteCargo($cargo, $plantel_id);
                if ($resultadoValidacionCargo == false) {
                    /*
                     * No hay otro usuario con este cargo_id, entonces lo verificamos que no este en el array autoridades
                     */
                    foreach ($autoridades as $key => $value) {
                        if ($value['cargo_id'] == $cargo) {
                            $mensaje = "Esta cargo ya esta asignado a otro usuario.";
                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                            echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
//$this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                            Yii::app()->end();
                        }
                    }
                    $datosUsuario = $autoridadPlantel->buscarUsuarioId($cedulaDecoded);
                    $autoridadPlantel->agregarAutoridad($plantel_id, $cargo, $datosUsuario, $cedulaDecoded);
                } else {
                    $mensaje = "Este cargo ya esta asignado a otra persona";
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                    Yii::app()->end();
                }
            }


            /*
             * Armado del provider
             */
            $selectCargo = Cargo::model()->getCargoAutoridad();
            $autoridades = $autoridadPlantel->buscarAutoridadesPlantel($plantel_id);
            $dataProvider = $this->dataProviderAutoridades($autoridades);
            $cargoSelect = $cargoModel->getCargoAutoridad();

            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//$this->renderPartial('_formAutoridades', array('mensaje' => $mensaje), false, true);
            $this->renderPartial('_formAutoridades', array('autoridadPlantel' => $autoridadPlantel, 'cargoSelect' => $cargoSelect, 'plantel_id' => $plantel_id, 'dataProvider' => $dataProvider));
            Yii::app()->end();
        } else {
            throw new CHttpException(404, 'No se han especificado los datos necesarios para agregar el Cargo. Recargue la página e intentelo de nuevo.'); // esta vacio el request
        }
    }

//////////////////////////////////////////////fin/////////////////////////////////////////////
//
/////////////////////////////////////////Guardar Autoridad//////////////////////////////////

    public function actionGuardarAutoridad() {
        if (isset($_REQUEST['plantel_id']) && isset($_REQUEST['autoridades'])) {
            $autoridadPlantel = new AutoridadPlantel;
            $dataProvider = array();
            $plantel_id = $_REQUEST['plantel_id'];
            $autoridades = $_REQUEST['autoridades'];

            $resultadoInsert = $autoridadPlantel->guardarAutoridadPlantel($plantel_id, $autoridades);
            $this->registerLog('GUARDAR', self::MODULO . '.GuardarAutoridad', 'EXITOSO', 'Guardo Autoridad');
            if ($resultadoInsert !== array()) {
                $autoridades = array();
                $cargoSelect = Cargo::model()->getCargoAutoridad();
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $this->renderPartial('_formAutoridades', array('autoridadPlantel' => $autoridadPlantel, 'cargoSelect' => $cargoSelect, 'plantel_id' => $plantel_id, 'dataProvider' => $dataProvider, 'autoridades' => $autoridades));
                Yii::app()->end();
            } else {
                $mensaje = "Registro invalido, por favor intente nuevamente";
                echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
                Yii::app()->end();
            }
        }
    }

/////////////////////////////////fin///////////////////////////////////////////////////////
/////////////////////////////////Guardar nuevo usuario(autoridad)////////////////////////////////
    public function actionGuardarNuevaAutoridad() {

        if (isset($_REQUEST['UserGroupsUser'])) {
            $existe = false;
            $cedula = array_key_exists('cedula', $_REQUEST['UserGroupsUser']) ? $_REQUEST['UserGroupsUser']['cedula'] : null;
            if (strpos($cedula, "-")) {
                $cedulaArrayDecoded = explode("-", $cedula);
                if (count($cedulaArrayDecoded) == 2) {
                    $origen = $cedulaArrayDecoded[0];
                    $cedulaDecoded = $cedulaArrayDecoded[1];
                    if (!(is_string($origen) && strlen($origen) == 1 && is_numeric($cedulaDecoded) && strlen($cedulaDecoded) > 1 && strlen($cedulaDecoded) <= 8)) {
// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                        $mensaje = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
                        Yii::app()->end();
                    }
                } else {
// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                    $mensaje = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
                    Yii::app()->end();
                }
            } else {
// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                $mensaje = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
                Yii::app()->end();
            }

            $autoridadPlantel = new AutoridadPlantel;
            $usuario = array(
                'origen' => $origen,
                'cedula' => $cedulaDecoded,
                'username' => $cedulaDecoded,
                'nombre' => $_REQUEST['UserGroupsUser']['nombre'],
                'apellido' => $_REQUEST['UserGroupsUser']['apellido'],
                'email' => $_REQUEST['UserGroupsUser']['email'],
                'telefono' => $_REQUEST['UserGroupsUser']['telefono'],
                'cargo' => $_REQUEST['cargo'],
                'plantel_id' => $_REQUEST['plantel_id']
            );


            $validacionResult = $this->validarUsuarioNuevo($usuario);
            if ($validacionResult == NULL) {
                if ($autoridadPlantel->guardarUsuario($usuario) != array()) {
                    $this->registerLog('GUARDAR', self::MODULO . '.GuardarNuevaAutoridad', 'EXITOSO', 'Guardo Nueva Autoridad');

                    $selectCargo = Cargo::model()->getCargoAutoridad();
                    $autoridades = $autoridadPlantel->buscarAutoridadesPlantel($usuario['plantel_id']);
                    $dataProvider = $this->dataProviderAutoridades($autoridades);
                    Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

//$this->renderPartial('_formAutoridades', array('mensaje' => $mensaje), false, true);

                    $this->renderPartial('_formAutoridades', array('autoridadPlantel' => $autoridadPlantel, 'cargoSelect' => $selectCargo, 'plantel_id' => $usuario['plantel_id'], 'dataProvider' => $dataProvider), false, true);
                    Yii::app()->end();
//$mensaje = "Usuario Registrado exitosamente, esta en la cola para su activaci&oacute;n";
//echo json_encode(array('statusCode' => 'success', 'mensaje' => $mensaje));
                } else {
                    $mensaje = "Registro invalido, por favor intente nuevamente";
                    echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
                    Yii::app()->end();
                }
            } else {
                echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $validacionResult));
                Yii::app()->end();
            }
        } else {
            throw new CHttpException(404, 'No se han especificado los datos necesarios de la autoridad que desea registrar. Recargue la página e intentelo de nuevo.'); // esta vacio el request
        }
    }

    public function actionEliminarAutoridad() {
        if (isset($_REQUEST['id']) && isset($_REQUEST['plantel_id'])) {
            $id = $_REQUEST['id'];
            $plantel_id = $_REQUEST['plantel_id'];
            $autoridadPlantel = new AutoridadPlantel;
            $autoridadPlantel->eliminarAutoridad($id, $plantel_id);
            $selectCargo = Cargo::model()->getCargoAutoridad();
            $autoridades = $autoridadPlantel->buscarAutoridadesPlantel($plantel_id);
            $dataProviderAutoridades = $this->dataProviderAutoridades($autoridades);

            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            $this->renderPartial('_formAutoridades', array('autoridadPlantel' => $autoridadPlantel, 'cargoSelect' => $selectCargo, 'plantel_id' => $plantel_id, 'dataProvider' => $dataProviderAutoridades));
            Yii::app()->end();
        } else {
            throw new CHttpException(404, 'No se ha especificado la autoridad a eliminar. Recargue la página e intentelo de nuevo.'); // esta vacio el request
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Plantel'])) {
            $model->attributes = $_POST['Plantel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
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

    public function validarUsuario($origen, $cedula, $autoridades, $plantel_id) {
        $existe_usuario_autoridad = "";
        $autoridadPlantel = new AutoridadPlantel();

        $busquedaCedula = $autoridadPlantel->busquedaSaime($origen, $cedula); // valida si existe la cedula en la tabla saime
        if (!$busquedaCedula) {
            $mensaje = "Esta Cedula de Identidad no se encuentra registrada en nuestro sistema, "
                    . "por favor contacte al personal de soporte mediante "
                    . "<a href='mailto:soporte.gescolar@me.gob.ve'>soporte.gescolar@me.gob.ve</a>";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje)); // NO EXISTE EN SAIME
// $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
            Yii::app()->end();
        } else {
            $busquedaCedulaUG = $autoridadPlantel->busquedaUserGroups($origen, $cedula);
            if ($busquedaCedulaUG == null) {
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                echo json_encode(array('statusCode' => 'successU', 'nombre' => $busquedaCedula['nombre'], 'apellido' => $busquedaCedula['apellido'], 'usuario' => $busquedaCedula['cedula'] . $this->generarLetra()));
                Yii::app()->end();
            } else {
                $existe_usuario_autoridad = $autoridadPlantel->validarUsuarioEnPlantel($busquedaCedulaUG, $plantel_id);
                if ($existe_usuario_autoridad) {
// ya tiene un cargo en ese plantel
                    $mensaje = "Esta cedula posee un cargo en dicho plantel.";
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
//$this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                    Yii::app()->end();
                } else {
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo json_encode(array('statusCode' => 'successC', 'cedula' => $cedula, 'autoridades' => $autoridades)); // debe asignar un cargo
// $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                    Yii::app()->end();
                }
            }
        }
    }

    public function validarUsuarioNuevo($usuario) {
        $mensaje = "";

        /*
         * Validar Cedula
         */
        if ($usuario['cedula'] == null || $usuario['cedula'] == '') {
            $mensaje .= "El campo Cedula no puede estar vacio <br>";
        }
        if ($usuario['nombre'] == null || $usuario['nombre'] == '') {
            $mensaje .= "El campo Nombre no puede estar vacio <br>";
        }
        if ($usuario['apellido'] == null || $usuario['apellido'] == '') {
            $mensaje .= "El campo Apellido no puede estar vacio <br>";
        }
        if ($usuario['telefono'] == null || $usuario['telefono'] == '') {
            $mensaje .= "El campo Telefono no puede estar vacio <br>";
        }
        if ($usuario['email'] == null || $usuario['email'] == '') {
            $mensaje .= "El campo Email no puede estar vacio <br>";
        } elseif (!(filter_var($usuario['email'], FILTER_VALIDATE_EMAIL))) {
            $mensaje .= "El campo Email no posee el formato correcto <br>";
        } elseif ($usuario['email'] == AutoridadPlantel::model()->validarUniqueEmail($usuario['email'])) {
            $mensaje .= "Este email ya esta registrado <br>";
        }
        if ($usuario['cargo'] == null || $usuario['cargo'] == '') {
            $mensaje .= "El campo Cargo no puede estar vacio <br>";
        } elseif ($usuario['cargo'] == AutoridadPlantel::model()->validarExisteCargo($usuario['cargo'], $usuario['plantel_id'])) {
            $mensaje .= "Este cargo ya fue asignado. <br>";
        }
        if ($usuario['cedula'] == AutoridadPlantel::model()->validarUniqueUsuario($usuario['cedula'])) {
            $mensaje .= "Este Usuario esta registrado. <br>";
        }

        if ($mensaje == "") {

            return null;
        } else
            return $mensaje;
    }

    public function dataProviderAutoridades($autoridades) {
        $rawData = array();
        if ($autoridades != array()) {

            foreach ($autoridades as $key => $value) {
                $id = $value['id'];
                $boton = "<div class='center'>" .
                        CHtml::link("", "", array("class" => "icon-trash red remove-data", 'onClick' => "eliminarAutoridad($id)", "title" => "Eliminar Autoridad")) .
                        "</div>";
                $nombre = "<div class='center'>" . $value['nombre'] . ' ' . $value['apellido'] . "</div>";
                $cedula = "<div class='center'>" . $value['cedula'] . "</div>";
                $cargo = "<div class='center'>" . $value['nombre_cargo'] . "</div>";
                $telefono = "<div class='center'>" . $value['telefono'] . "</div>";
                $correo = "<div class='center'>" . $value['email'] . "</div>";
                $rawData [] = array(
                    'id' => $key,
                    'cargo' => $cargo,
                    'nombre' => $nombre,
                    'cedula' => $cedula,
                    'correo' => $correo,
                    'telefono' => $telefono,
                    'boton' => $boton
                );
            }
            return new CArrayDataProvider($rawData, array(
// 'pagination' => false,
                'pagination' => array(
                    'pageSize' => 5,
                ),
            ));
        } else
            return new CArrayDataProvider($rawData, array(
                'pagination' => false,
                    /* 'pagination' => array(
                      'pageSize' => 5,
                      ), */
            ));
    }

    /**
     * Lists all models.

      public function actionIndex() {
      $dataProvider = new CActiveDataProvider('Plantel');
      $data = new plantel;
      $this->render('index', array(
      'dataProvider' => $dataProvider, 'data' => $data,
      ));
      } */
    public function columnaAcciones($data)
    /*
     * Botones del accion (crear, consultar)
     */ {
        $id = $data["id"];
        $estatus = $data["estatus"];
        if (($estatus == 'A') || ($estatus == '')) {
            $columna = CHtml::link("", "#", array("class" => "fa fa-search", "onClick" => "consultarAula($id,'')", "title" => "Consultar este aula")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "#", array("class" => "fa fa-pencil green", "onClick" => "modificarAula($id)", "title" => "Modificar aula")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "#", array("class" => "fa fa-times red remove-data", "onClick" => "eliminarAula($id)", "title" => "Eliminar aula")) . '&nbsp;&nbsp;';
        } else if ($estatus == 'E') {
            $columna = CHtml::link("", "#", array("class" => "fa fa-search", "onClick" => "consultarAula($id,'')", "title" => "Consultar este aula")) . '&nbsp;&nbsp;';
        }

        return $columna;
    }

    public function columnaEstatus($data) {
        $estatus = $data['estatus'];
        if (($estatus == 'A') || ($estatus == '')) {
            return 'Activo';
        } else if ($estatus == 'E') {
            return 'Inactivo';
        }
        return $columna;
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Plantel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Plantel']))
            $model->attributes = $_GET['Plantel'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*     * **************************************************ALEXIS*********************** */

    public function actionViaAutoComplete() {
        $id = $_GET["id"];

        $_GET['term'] = strtoupper($_GET['term']);
        $res = array();

        if (isset($_GET['term']) && !empty($id)) {
            $res = Plantel::obtenerVia($id, $_GET['term']);
        }

        echo CJSON::encode($res);
    }

    /*     * ************************************************************************************************************* */

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Plantel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Plantel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModalidad($id) {
        $model = Modalidad::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'No se ha encontrado el Plantel que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
        return $model;
    }

    public function loadAula($id) {
        $model = Aula::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'No se ha encontrado el Aula que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
        return $model;
    }

    static function generarLetra() {
//Se define una cadena de caractares. Te recomiendo que uses esta.
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
//Obtenemos la longitud de la cadena de caracteres
        $longitudCadena = strlen($cadena);

//Se define la variable que va a contener la contraseña
        $pass = "";
//Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
        $longitudPass = 1;

//Creamos la contraseña
        for ($i = 1; $i <= $longitudPass; $i++) {
//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos = rand(0, $longitudCadena - 1);

//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
            $pass .= substr($cadena, $pos, 1);
        }
        return $pass;
    }

    /**
     * Performs the AJAX validation.
     * @param Plantel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'plantel-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
       public function actionUpload() {
        
        $upload_handler = new UploadHandler(null, true, null, date('YmdHis') . 'MP', "/public/uploads/LogoPlanteles/");
        
    } 

}
