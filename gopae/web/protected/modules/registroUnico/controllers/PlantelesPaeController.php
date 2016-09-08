<?php
// clearstatcache();
/**
 * Clase Controladora de Peticiones del Módulo de Gestión de registro único y actualización de datos de Planteles Beneficiados por el PAE.
 *
 * @author José Gabriel González <jgonzalezp@me.gob.ve>
 * @createAt 2014-10-29
 * @updateAt 2014-10-29
 */
class PlantelesPaeController extends Controller {

    const MODULO = 'RegistroUnico.PlantelesPae';

    private $indexPlantel; // Indice de Cache que aloja el model de un Plantel
    private $indexPlantelPae; // Indice de Cache que aloja el model de los datos PAE de un plantel
    private $indexPlatelSinPaeInfoForm;
    private $indexPlantelPaeInfoForm;
    private $indexComprobantePae;
    private $indexPlantelAutoridades;

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'lista';

    /**
     * @return array action filters
     */
    public static $_permissionControl = array(
        'read' => 'Consulta de Registro Único de Planteles Beneficiarios del CNAE',
        'write' => 'Creación y Modificación de Planteles CNAE',
        'admin' => 'Administración Completa de Planteles CNAE',
        'label' => 'Módulo de Datos CNAE de Planteles'
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
        // en este array colocar solo los action de consulta
        return array(
            array('allow',
                'actions' => array('lista', 'consulta', 'nuevoRegistro', 'edicion', 'municipiosStandAlone', 'parroquiasStandAlone', 'seleccionarUrbanizacion', 'seleccionarPoblacion', 'activarPae', 'registroIngesta', 'eliminarIngesta', 'guardarNuevaAutoridad', 'buscarCedula', 'agregarAutoridad', 'buscarAutoridad', 'actualizarDatosAutoridad', 'getAutoridadPlantel', 'eliminarAutoridad', 'comprobante', 'tomarFotografiaAutoridad', 'registroFotografiaAutoridad', 'datosComprobante'),
                'pbac' => array('write', 'admin'),
            ),
            array('allow',
                'actions' => array('lista', 'consulta', 'municipiosStandAlone', 'parroquiasStandAlone', 'seleccionarUrbanizacion', 'seleccionarPoblacion', 'buscarCedula', 'getAutoridadPlantel', 'comprobante', 'datosComprobante'),
                'pbac' => array('read'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Manages all models.
     */
    public function actionLista() {

        $model = new Plantel('search');
        $model->unsetAttributes();  // clear any default values
        $plantelRequest = $this->getQuery('Plantel');

        $dataProvider = new CArrayDataProvider(array(),array(
                    'pagination' => array(
                        'pageSize' => 5,
                    ),
                ));

        if ($plantelRequest){
            $model->attributes = $this->getQuery('Plantel');
            if(isset($_GET['Plantel']['pae_activo'])){$model->pae_activo = $_GET['Plantel']['pae_activo'];}
            if(isset($_GET['Plantel']['tiene_director_registrado'])){$model->tiene_director_registrado = $_GET['Plantel']['tiene_director_registrado'];}
            $dataProvider = $model->search();
            // var_dump($model->attributes);
            // var_dump($dataProvider);
        }

        $groupId = Yii::app()->user->group;
        $usuarioId = Yii::app()->user->id;
        $groupName = Yii::app()->user->groupname;

        /* OBTENGO EL ESTADO_ID DEL USUARIO */
        if ($groupId == 25) {
            $estadoId = $model->estadoId($usuarioId);
        } else {
            $estadoId = '';
        }

        $this->render('index', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'estadoId' => $estadoId,
            'groupName' => $groupName,
            'dataProviderPlanteles' => $dataProvider,
        ));

    }

    /**
     * Displays the data model.
     * @param string $id the ID on base64_enconde of the model to be displayed
     */
    public function actionConsulta($id) {

        $idDecoded = base64_decode($id);

        $this->setCacheIndexes($idDecoded);

        $model = $this->loadModel($idDecoded);

        $estados = CEstado::getData();
        $municipios = CMunicipio::getData('estado_id', $model->estado_id);
        $municipios = (!$municipios)? array(): $municipios;
        $parroquias = CParroquia::getData('municipio_id', $model->municipio_id);
        $parroquias = (!$parroquias)? array(): $parroquias;

        $this->render('view', array(
            'model' => $model,
            'estados' => $estados,
            'municipios' => $municipios,
            'parroquias' => $parroquias,
            'bancos' => CBanco::getData(),
            'tiposDeCuenta' => CTipoCuenta::getData(),
            'misiones' => CMision::getData(),
            'gradosInstruccion' => CGradoInstruccion::getData(),
            'origenes' => COrigen::getData(),
            'generos' => CGenero::getData(),
            'formType' => 'view'
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionNuevoRegistro($mensaje=null) {

        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id);

        $csrfToken = $this->getCsrfToken('ChavezVive-PlantelesUnicosPAE', 'csrfTokenRegPlantelesPae');
        $model = new Plantel('createFromCnae');
        
        // Valores por defecto
        $model->estatus_plantel_id = 1;
        $model->genero_id = 3;
        $model->turno_id = 7;
        $model->modalidad_id = 1;
        $model->es_beneficiario_pae = 'SI';
        $this->setCacheIndexes($model->id);

        $usuario = Yii::app()->user->id;

        // Datos para creación de los select inputs o comboboxes en el formulario de registro de Planteles
        $estados = CEstado::getData(); $municipios = array(); $parroquias = array();  $urbanizaciones = array(); $poblaciones = array();
        $denominaciones = CDenominacion::getData(); $dependencias = CTipoDependencia::getData(); $estatusPlantel = CEstatusPlantel::getData();
        $tiposDeVias = CTipoVia::getData(); $zonasUbicacion = CZonaUbicacion::getData(); $turnos = CTurno::getData();
        $modalidades = CModalidad::getData(); $tiposDeMatricula = CGenero::getData(); $zonasEducativas = CZonaEducativa::getData();
        $mensajeExitoso = null;
        $cargoSelect = CCargo::getData('ente_id', 1);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if ($this->hasPost('Plantel')) {
            $formData = $this->getPost('Plantel');
            $model->attributes = $this->getPost('Plantel');
            $model->beforeSave();
            $model->registro_cnae = 'S';
          
            if(!(strlen($model->cod_plantel)>3) || $model->cod_plantel=='SIN-CODIGO'){
                $model->cod_plantel = '';
                if(isset($formData['cod_plantelNer']) && strlen($formData['cod_plantelNer'])>0){
                    $model->cod_plantel = $formData['cod_plantelNer'];
                }
                else{
                    $model->sin_codigo_dea = 'S';
                }
            }
            if(!(is_numeric($model->cod_estadistico))){ $model->cod_estadistico = null; }
            if(!is_numeric($model->annio_fundado)){ $model->annio_fundado = null; }
            
            $municipios = CMunicipio::getData('estado_id', $model->estado_id);
            $municipios = (!$municipios)? array(): $municipios;
            $parroquias = CParroquia::getData('municipio_id', $model->municipio_id);
            $parroquias = (!$parroquias)? array(): $parroquias;
            $poblaciones = Plantel::model()->obtenerPoblacion($model->parroquia_id);
            $poblaciones = (!$poblaciones)? array(): $poblaciones;
            $urbanizaciones = Plantel::model()->obtenerUrbanizacion($model->parroquia);
            $urbanizaciones = (!$urbanizaciones)? array(): $urbanizaciones;
            
            if($model->validate()){
                try {
                    if($model->save()){
                        Yii::app()->user->setFlash('mensajeExitosoPlantelPae', 'Se ha efectuado exitosamente el registro de la Institución Educativa '.$model->nombre);
                        $this->registerLog('ESCRITURA', 'registroUnico.PlantelesPae.nuevoRegistro', 'SUCCESS', 'Se ha efectuado exitosamente el registro de una Institución Educativa. Data: '.json_encode($model->attributes));
                        if(Yii::app()->request->isAjaxRequest){
                            $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'Los Datos se han registrado de forma exitosa.'));
                            Yii::app()->end();
                        }
                        $this->redirect('/registroUnico/PlantelesPae/edicion/id/'.base64_encode($model->id).'/isnew/true');
                    }
                    else{

                        if(Yii::app()->request->isAjaxRequest){
                            $this->renderPartial('//errorSumMsg', array('model'=>$model));
                            Yii::app()->end();
                        }
                        $this->render('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema. Error: <pre>'.$exc->getTraceAsString().'</pre>'));
                        Yii::app()->end();
                    }
                } catch (Exception $exc) {
                    
                    if(Yii::app()->request->isAjaxRequest){
                        $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema. Error: <pre>'.$exc->getTraceAsString().'</pre>'));
                        Yii::app()->end();
                    }
                    $this->render('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema.<br/><br/> '.$exc->getMessage().' Error: <pre>'.$exc->getTraceAsString().'</pre>'));
                    //var_dump($model->attributes);
                    //die();
                    //var_dump($exc);
                    Yii::app()->end();
                }
            }
            else{
                if(Yii::app()->request->isAjaxRequest){
                    $this->renderPartial('//errorSumMsg', array('model'=>$model));
                    Yii::app()->end();
                }
            }
            
        }
        else{
            $this->registerLog('LECTURA', self::MODULO . '.nuevoRegistro', 'EXITOSO', 'El Usuario Ingresó al Modulo de Registro Único de Planteles del PAE');
        }

        $renderType = 'render';
        if(Yii::app()->request->isAjaxRequest){
            $renderType = 'renderPartial';
        }

        $submitHide = false;

        // ld($municipios);
        // ld($parroquias);
        // ld($poblaciones);
        // ld($urbanizaciones);
        $autoridadUsuario = new UserGroupsUser('nuevoUsuario');

        $this->$renderType('create', array(
            'id' => null,
            'usuario' => $usuario,
            'model' => $model,
            'modelPae' => null,
            'denominaciones' => $denominaciones,
            'dependencias' => $dependencias,
            'zonasEducativas' => $zonasEducativas,
            'estatusPlantel' => $estatusPlantel,
            'estados' => $estados,
            'municipios' => $municipios,
            'parroquias' => $parroquias,
            'poblaciones' => $poblaciones,
            'urbanizaciones' => $urbanizaciones,
            'tiposDeVias' => $tiposDeVias,
            'zonasUbicacion' => $zonasUbicacion,
            'turnos' => $turnos,
            'modalidades' => $modalidades,
            'tiposDeMatricula' => $tiposDeMatricula,
            'mensajeExitoso' => $mensajeExitoso,
            'submitHide' => $submitHide,
            'mensaje' => $mensaje,
            'csrfToken' => $csrfToken,
            'autoridadesPlantel' => null,
            'dataProviderAutoridades' => null,
            'cargoSelect' => $cargoSelect,
            'autoridadUsuario' => $autoridadUsuario,
            'ingestas' => null
        ));

    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdicion($id, $isnew=null, $mensaje=null, $submitHide=false, $error=null) {

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $idDecoded = $this->getIdDecoded($id);

        $this->setCacheIndexes($idDecoded);
        
        // Yii::app()->cache->delete($this->indexPlantel);
        
        $model = $this->loadModel($idDecoded);
        $model->cod_cnae = $model->getCodCnaeByPlantelId($model->id);
        $model->scenario = 'createFromCnae';

        $csrfToken = $this->getCsrfToken('ChavezVive-Planteles', 'csrfTokenEditPlanteles');
        $csrfTokenPae = $this->getCsrfToken('ChavezVive-PlantelesPae', 'csrfTokenPlantelPae');
        $redireccionadoSaime = false;
        $usuario = Yii::app()->user->id;

        $modelPae = $this->loadModelPae($model->id);

        if($modelPae){
            $isnew = false;
        }
        if($isnew || !$modelPae){
            $modelPae = new PlantelPae();
            $modelPae->plantel_id = $model->id;
        }
        
        // ldd($modelPae);
        
        $ingestas = array();
        $autoridadesPlantel = array();
        $dataProviderAutoridades = array();
        $cargoSelect = CCargo::getData('ente_id', 1);
        if(!$isnew){
            $ingestas = PlantelIngesta::model()->obtenerTipoMenu($model->id);
            $autoridadesPlantel = AutoridadPlantel::model()->buscarAutoridadesPlantel($model->id);
            $dataProviderAutoridades = $this->dataProviderAutoridades($autoridadesPlantel);
        }

        // Datos para creación de los select inputs o comboboxes en el formulario de registro de Planteles
        $estados = CEstado::getData();
        $municipios = CMunicipio::getData('estado_id', $model->estado_id);$municipios = (!$municipios)? array(): $municipios;
        $parroquias = CParroquia::getData('municipio_id', $model->municipio_id);$parroquias = (!$parroquias)? array(): $parroquias;
        $poblaciones = Plantel::model()->obtenerPoblacion($model->parroquia_id);$poblaciones = (!$poblaciones)? array(): $poblaciones;
        $urbanizaciones = Plantel::model()->obtenerUrbanizacion($model->parroquia);$urbanizaciones = (!$urbanizaciones)? array(): $urbanizaciones;

        $denominaciones = CDenominacion::getData(); $dependencias = CTipoDependencia::getData(); $estatusPlantel = CEstatusPlantel::getData();
        $tiposDeVias = CTipoVia::getData(); $zonasUbicacion = CZonaUbicacion::getData(); $turnos = CTurno::getData();
        $modalidades = CModalidad::getData(); $tiposDeMatricula = CGenero::getData(); $zonasEducativas = CZonaEducativa::getData();

        $mensajeExitoso = (Yii::app()->user->hasFlash('mensajeExitosoPlantelPae'))?Yii::app()->user->getFlash('mensajeExitosoPlantelPae'):$mensaje;

        Yii::app()->cache->delete('INGST:'.$model->id);

        if ($this->hasPost('Plantel')) {
            $model->attributes = $this->getPost('Plantel');
            $model->beforeUpdate();
            $model->registro_cnae = 'S';
            if(!(strlen($model->cod_plantel)>5)){ $model->cod_plantel = $model->cod_cnae; $model->sin_codigo_dea = 'S'; }
            if(!(is_numeric($model->cod_estadistico))){ $model->cod_estadistico = null; }
            if(!is_numeric($model->annio_fundado)){ $model->annio_fundado = null; }
            if($model->validate()){
                try {
                    if($model->save()){
                        Yii::app()->cache->delete($this->indexComprobantePae);
                        Yii::app()->cache->delete($this->indexPlantelPaeInfoForm);
                        Yii::app()->cache->delete($this->indexPlantel);
                        Yii::app()->cache->set($this->indexPlantel, $model, 36800);
                        
                        $model->cod_cnae = $model->getCodCnaeByPlantelId($model->id);
                        
                        $mensajeExitoso = 'Los datos se han actualizado de forma exitosa.';
                        Yii::app()->user->setFlash('mensajeExitosoPlantelPae', 'Se ha efectuado exitosamente el registro de la Institución Educativa '.$model->nombre);
                        $this->registerLog('ESCRITURA', 'registroUnico.PlantelesPae.edicion', 'SUCCESS', 'Se ha efectuado exitosamente la edición de los datos de la Institución Educativa '.$model->nombre);
                        if(Yii::app()->request->isAjaxRequest){
                            echo '<script>$(document).ready(function(){ console.log(("'.$model->cod_cnae.'")); if($("#Plantel_cod_cnae").val()==""){$("#Plantel_cod_cnae").val("'.$model->cod_cnae.'");}});</script>';
                            $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La actualización de los Datos se ha efectuado de forma exitosa.'));
                            Yii::app()->end();
                        }
                    }else{
                        if(Yii::app()->request->isAjaxRequest){
                            $this->renderPartial('//errorSumMsg', array('model'=>$model));
                            Yii::app()->end();
                        }
                    }
                } catch (Exception $exc) {
                    if(Yii::app()->request->isAjaxRequest){
                        $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema. Error: '.$exc->getMessage().' <br/><br/> <pre>'.$exc->getTraceAsString().'</pre>'));
                        Yii::app()->end();
                    }
                    $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema.<br/><br/> '.$exc->getMessage().' Error: <pre>'.$exc->getTraceAsString().'</pre>'));
                }
            }else{
                if(Yii::app()->request->isAjaxRequest){
                    $this->renderPartial('//errorSumMsg', array('model'=>$model));
                    Yii::app()->end();
                }
            }
        }
        elseif($this->hasPost('PlantelPae')) {
            $modelPae->attributes = $this->getPost('PlantelPae');
            if($modelPae->validate()){
                try {
                    if($modelPae->save()){
                        Yii::app()->cache->delete($this->indexComprobantePae);
                        Yii::app()->cache->set($this->indexPlantelPae, $modelPae, 36800);
                        $mensajeExitoso = 'Los datos se han actualizado de forma exitosa.';
                        $this->registerLog('ESCRITURA', 'registroUnico.PlantelesPae.edicionPae', 'SUCCESS', 'Se ha efectuado exitosamente el registro de los datos PAE de la Institución Educativa '.$model->nombre);
                        if(Yii::app()->request->isAjaxRequest){
                            $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La actualización de los datos del plantel '.$model->nombre.' se ha efectuado de forma exitosa.'));
                            Yii::app()->end();
                        }
                    }else{
                        if(Yii::app()->request->isAjaxRequest){
                            $this->renderPartial('//errorSumMsg', array('model'=>$model));
                            Yii::app()->end();
                        }
                    }
                } catch (Exception $exc) {
                    if(Yii::app()->request->isAjaxRequest){
                        $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema. Error: '.$exc->getTraceAsString()));
                        Yii::app()->end();
                    }
                    $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema.<br/><br/> '.$exc->getMessage().' Error: <pre>'.$exc->getTraceAsString().'</pre>'));
                }
            }else{
                if(Yii::app()->request->isAjaxRequest){
                    $this->renderPartial('//errorSumMsg', array('model'=>$model));
                    Yii::app()->end();
                }
            }
        }
        else{
            $this->registerLog('LECTURA', self::MODULO . '.edicion', 'EXITOSO', 'El Usuario Ingresó a la actualización de datos del Registro Único de Planteles del PAE. Edición de Datos PAE, Autoridades e Ingestas');
        }

        $renderType = 'render';
        if(Yii::app()->request->isAjaxRequest){
            $renderType = 'renderPartial';
        }

        $autoridadUsuario = new UserGroupsUser('nuevoUsuario');

        $this->$renderType('update', array(
            'id' => $model->id,
            'usuario' => $usuario,
            'model' => $model,
            'modelPae' => $modelPae,
            'denominaciones' => $denominaciones,
            'dependencias' => $dependencias,
            'zonasEducativas' => $zonasEducativas,
            'estatusPlantel' => $estatusPlantel,
            'estados' => $estados,
            'municipios' => $municipios,
            'parroquias' => $parroquias,
            'poblaciones' => $poblaciones,
            'urbanizaciones' => $urbanizaciones,
            'tiposDeVias' => $tiposDeVias,
            'zonasUbicacion' => $zonasUbicacion,
            'turnos' => $turnos,
            'modalidades' => $modalidades,
            'tiposDeMatricula' => $tiposDeMatricula,
            'mensajeExitoso' => $mensajeExitoso,
            'submitHide' => $submitHide,
            'mensaje' => $mensaje,
            'csrfToken' => $csrfToken,
            'csrfTokenPae' => $csrfTokenPae,
            'autoridadesPlantel' => $autoridadesPlantel,
            'dataProviderAutoridades' => $dataProviderAutoridades,
            'cargoSelect' => $cargoSelect,
            'ingestas' => $ingestas,
            'autoridadUsuario' => $autoridadUsuario,
            'isnew' => $isnew,
            'error' => $error,
        ));
    }

    /**
     * @param $id integer Id del Plantel
     */
    public function actionActivarPae($id){

        $idDecoded = $this->getIdDecoded($id);

        $this->setCacheIndexes($idDecoded);

        $model = $this->loadModel($idDecoded);
        $plantelesPae = $this->loadModelPae($idDecoded);

        $resultado = array(
            'error'=>true,
            'status'=>200,
            'mensaje'=>'La institución educativa indicada no se ha encontrado en nuestra base de datos. Intente registrar los datos generales de esta institución y luego realice la activación del Servicio PAE en el mismo.',
            'data'=>null
        );

        if($model){

            $modelPae = (count($plantelesPae)>0)?$plantelesPae:new PlantelPae();

            if($this->hasPost('PlantelPae')) {

                $modelPae->attributes = $this->getPost('PlantelPae');
                $modelPae->beforeActivate();

                if ($modelPae->validate()) {

                    // try {
                        if ($modelPae->save()) {

                            Yii::app()->cache->delete($this->indexComprobantePae);
                            Yii::app()->cache->delete($this->indexPlantelPaeInfoForm);
                            Yii::app()->cache->delete($this->indexPlatelSinPaeInfoForm);

                            Yii::app()->cache->set($this->indexPlantelPae, $modelPae, 36800);

                            $mensaje = 'Se ha efectuado exitosamente el registro de los Datos PAE de la Institución Educativa.';

                            $this->registerLog(
                                'ESCRITURA',
                                'registroUnico.PlantelesPae.activarPae',
                                'SUCCESS',
                                $mensaje .' ('. $model->cod_plantel.') '. $model->nombre
                            );

                            $resultado['error'] = false;
                            $resultado['mensaje'] = $mensaje;
                            $resultado['data'] = $modelPae->attributes;
                            $resultado['data']['cod_plantel'] = $model->cod_plantel;
                            $resultado['data']['cod_cnae'] = $model->cod_cnae;
                            $resultado['data']['cod_estadistico'] = $model->cod_estadistico;
                            $resultado['data']['nombre'] = $model->nombre;

                        } else {
                            $resultado['mensaje'] = 'Ha ocurrido un error en el proceso. Error: ' . CHtml::errorSummary($modelPae);
                            $resultado['status'] = 500;
                        }
                    // } catch (Exception $exc) {
                    //    $resultado['mensaje'] = 'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema. Error: ' . $exc->getTraceAsString();
                    //    $resultado['status'] = 500;
                    // }
                } else {
                    $resultado['mensaje'] = CHtml::errorSummary($modelPae);
                }
            }
            else{
                $resultado['mensaje'] = 'No se han proveido los datos necesarios para completar la operación.';
                $resultado['status'] = 401;
            }
        }

        // var_dump($resultado);

        $this->jsonResponse($resultado);

    }

    /**
     * @param $id Id del Plantel
     */
    public function actionRegistroIngesta($id){

        $mensaje = 'La institución educativa indicada no se ha encontrado en nuestra base de datos. Intente registrar los datos generales de esta institución y luego realice la activación del Servicio PAE en el mismo.';

        $resultado = array(
            'error'=>true,
            'status'=>400,
            'mensaje'=>$mensaje,
            'data'=>null
        );

        $idDecoded = $this->getIdDecoded($id);

        $this->setCacheIndexes($idDecoded);

        $model = $this->loadModel($idDecoded);

        // var_dump($model); die();

        if($model){
            if($this->hasPost('PlantelIngesta')){
                $ingestaText = $this->getPost('ingestaText');
                $ingesta = new PlantelIngesta();
                $ingesta->attributes = $this->getPost('PlantelIngesta');
                $ingesta->beforeInsert();
                if($ingesta->validate()){
                    if($ingesta->save()){
                        Yii::app()->cache->delete($this->indexComprobantePae);
                        $resultado['status'] = 200;
                        $mensaje = 'El tipo de ingesta <b>'.ucwords(strtolower($ingestaText)).'</b> se ha registrado exitosamente, con la cantidad de '.$ingesta->cantidad_comensales.' comensales.';
                        $this->registerLog('ESCRITURA', 'registroUnico.PlantelesPae.registroIngesta', 'SUCCESS', $mensaje .' ('. $model->cod_plantel.') '. $model->nombre);
                        Yii::app()->cache->delete('INGST:'.$model->id);
                        $resultado['mensaje']=$mensaje;
                        $resultado['data'] = $ingesta->attributes;
                    }
                    else{
                        $resultado['mensaje'] = 'Ha ocurrido un error en el proceso. Error: ' . CHtml::errorSummary($ingesta);
                        $resultado['status'] = 500;
                    }
                }else{
                    $resultado['mensaje'] = CHtml::errorSummary($ingesta);
                }
            }
            else{
                $resultado['mensaje'] = 'No se han proporcionado los datos necesarios para efectuar esta operación';
            }
        }

        $this->jsonResponse($resultado);

    }

    /**
     * @param $id Id del Plantel
     */
    public function actionEliminarIngesta($id){
        $mensaje = 'La institución educativa indicada no se ha encontrado en nuestra base de datos. Intente registrar los datos generales de esta institución y luego realice la activación del Servicio PAE en el mismo.';

        $resultado = array(
            'error'=>true,
            'status'=>400,
            'mensaje'=>$mensaje,
            'data'=>null
        );

        $idDecoded = $this->getIdDecoded($id);

        $this->setCacheIndexes($idDecoded);

        $model = $this->loadModel($idDecoded);

        if($model) {

            if ($this->hasPost('plantelIngestaid') && $this->hasPost('ingesta')) {

                $plantelIngestaId = $this->getPost('plantelIngestaid');
                $ingesta = $this->getPost('ingesta');

                if (is_numeric($plantelIngestaId)) {

                    $plantelIngesta = PlantelIngesta::model()->findByPk($plantelIngestaId, 'plantel_id = :plantel', array(':plantel' => $idDecoded));

                    if ($plantelIngesta) {
                        if ($plantelIngesta->delete()) {
                            Yii::app()->cache->delete($this->indexComprobantePae);
                            $mensaje = 'El tipo de ingesta ' . $ingesta . ' ha sido desvinculada de la Institucion Educativa.';
                            $this->registerLog('ELIMINACION', 'registroUnico.PlantelesPae.eliminarIngesta', 'SUCCESS', $mensaje . ' (' . $model->cod_plantel . ') ' . $model->nombre);
                            Yii::app()->cache->delete('INGST:'.$model->id);
                            $resultado['error'] = false;
                            $resultado['status'] = 200;
                            $resultado['mensaje'] = $mensaje;
                            $resultado['data'] = $plantelIngesta->attributes;
                        } else {
                            $resultado['mensaje'] = 'Ha ocurrido un error en el momento de eliminar la ingesta de la institución educativa. Comuniquese con el administrador.';
                        }
                    } else {
                        $resultado['status'] = 404;
                        $resultado['mensaje'] = 'La ingesta indicada no ha sido registrada a esta Institución Educativa.';
                    }

                } else {
                    $resultado['mensaje'] = 'No se han proporcionado los datos correctos para efectuar esta operación';
                }

            } else {
                $resultado['mensaje'] = 'No se han proporcionado los datos necesarios para efectuar esta operación';
            }
        }

        $this->jsonResponse($resultado);
    }

    /**
     *
     * @param integer $id Id del Plantel en base64
     * @throws CHttpException
     */
    public function actionGuardarNuevaAutoridad($id) {
        if ($this->hasPost('UserGroupsUser')) {

            $idDecoded = $this->getIdDecoded($id);

            $this->setCacheIndexes($idDecoded);

            $existe = false;
            $usuarioForm = $_POST['UserGroupsUser'];
            $cedula = $_POST['UserGroupsUser']['cedula'];
            $presentoDocumentoDeIdentidad = $_POST['UserGroupsUser']['presento_documento_identidad'];
            $plantel = $this->loadModel($idDecoded);

            $this->setCacheIndexes($idDecoded);

            if($presentoDocumentoDeIdentidad=='SI'){

                if (strpos($cedula, "-")) {
                    $cedulaArrayDecoded = explode("-", $cedula);
                    if (count($cedulaArrayDecoded) == 2) {
                        $origen = $cedulaArrayDecoded[0];
                        $cedulaDecoded = $cedulaArrayDecoded[1];
                        if (!(is_string($origen) && strlen($origen) == 1 && is_numeric($cedulaDecoded) && strlen($cedulaDecoded) > 1 && strlen($cedulaDecoded) <= 8)) {
                            // MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                            $mensaje = "La Cédula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
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
                    $mensaje = "La Cédula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
                    Yii::app()->end();
                }

            }
            else{
                $mensaje = "Para poder registrar la autoridad la misma debe presentar su documento de identidad.";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
                Yii::app()->end();
            }

            $autoridadPlantel = new AutoridadPlantel;
            $usuario = array(
                'origen' => $origen,
                'cedula' => $cedulaDecoded,
                'username' => $_REQUEST['UserGroupsUser']['username'],
                'nombre' => $_REQUEST['UserGroupsUser']['nombre'],
                'apellido' => $_REQUEST['UserGroupsUser']['apellido'],
                'email' => $_REQUEST['UserGroupsUser']['email'],
                'telefono' => $_REQUEST['UserGroupsUser']['telefono'],
                'telefono_celular' => $_REQUEST['UserGroupsUser']['telefono_celular'],
                'presento_documento_identidad' => $_POST['UserGroupsUser']['presento_documento_identidad'],
                'cargo' => $_REQUEST['cargo'],
                'plantel_id' => $idDecoded
            );


            $validacionResult = $this->validarUsuarioNuevo($usuario);
            if ($validacionResult == NULL) {
                if ($autoridadPlantel->guardarUsuario($usuario) != array()) {
                    Yii::app()->cache->delete($this->indexComprobantePae);
                    $this->registerLog('ESCRITURA','registroUnico.plantelesPae.guardarNuevaAutoridad', 'EXITOSO',  'Se Han Guardado Exitósamente la datos de la Nueva Autoridad. Los datos de la autoridad: '.  json_encode($usuario));
                    $selectCargo = CCargo::getData('ente_id', 1);
                    $autoridades = $autoridadPlantel->buscarAutoridadesPlantel($usuario['plantel_id']);
                    $dataProvider = $this->dataProviderAutoridades($autoridades);
                    Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                    //$this->renderPartial('_formAutoridades', array('mensaje' => $mensaje), false, true);
                    $this->renderPartial('_formAutoridades', array('autoridadPlantel' => $autoridadPlantel, 'cargoSelect' => $selectCargo, 'plantel_id' => $usuario['plantel_id'], 'dataProvider' => $dataProvider, 'plantel'=>$plantel), false, true);
                    Yii::app()->end();
                    //$mensaje = "Usuario Registrado exitosamente, esta en la cola para su activaci&oacute;n";
                    //echo json_encode(array('statusCode' => 'success', 'mensaje' => $mensaje));
                } else {
                    $mensaje = "Registro inválido, por favor intente nuevamente";
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

    public function actionGetAutoridadPlantel() {
        if (Yii::app()->request->isAjaxRequest) {
            $plantelIdDecoded = (int) ($this->getQuery('plantel_id'));
            $this->setCacheIndexes($plantelIdDecoded);
            if (is_numeric($plantelIdDecoded)) {
                $plantel = $this->loadModel($plantelIdDecoded);
                $autoridadPlantel = new AutoridadPlantel;
                $selectCargo = CCargo::getData('ente_id', 1);
                $autoridades = AutoridadPlantel::model()->buscarAutoridadesPlantel($plantel_idDecoded);
                $dataProvider = $this->dataProviderAutoridades($autoridades);
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                // $this->renderPartial('_formAutoridades', array('mensaje' => $mensaje), false, true);
                $this->renderPartial('_formAutoridades', array(
                    'autoridadPlantel' => $autoridadPlantel,
                    'cargoSelect' => $selectCargo,
                    'plantel_id' => $plantelIdDecoded,
                    'dataProvider' => $dataProvider,
                    'plantel'=>$plantel),
                    false, true);
            } else
                throw new CHttpException(403, 'No se ha encontrado el recurso solicitado. Recargue la página e intentelo de nuevo.');
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

    /**
     *
     * @param type $id
     * @throws CHttpException
     */
    public function actionAgregarAutoridad($id) {

        $idDecoded = base64_decode($id);

        $plantel = $this->loadModel($idDecoded);

        $this->setCacheIndexes($idDecoded);

        if (isset($_REQUEST['cedula']) && isset($_REQUEST['cargo']) && isset($_REQUEST['plantel_id'])) {
            $autoridadPlantel = new AutoridadPlantel;
            $cargoModel = new Cargo;
            $rawData = array();
            $cedula = $_REQUEST['cedula'];
            $cargo = $_REQUEST['cargo'];
            $presento_documento_identidad = $_REQUEST['presento_documento_identidad'];
            $plantel_id = $_REQUEST['plantel_id'];
            $usuario_id = Yii::app()->user->id;
            $autoridades = $autoridadPlantel->buscarAutoridadesPlantel($plantel_id);
            if($presento_documento_identidad=='SI'){
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
            } else {
                // MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                $mensaje = "Para poder registrar la autoridad la misma debe presentar su documento de identidad.";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                Yii::app()->end();
            }


            if ($autoridades == array()) {
                $resultadoValidacionCargo = $autoridadPlantel->validarExisteCargo($cargo, $plantel_id);
                if ($resultadoValidacionCargo != $cargo) {
                    $datosUsuario = $autoridadPlantel->buscarUsuarioId($cedulaDecoded);
                    $autoridadPlantel->agregarAutoridad($plantel_id, $cargo, $datosUsuario, $cedulaDecoded, $presento_documento_identidad);
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
                    $autoridadPlantel->agregarAutoridad($plantel_id, $cargo, $datosUsuario, $cedulaDecoded, $presento_documento_identidad);
                    Yii::app()->cache->delete($this->indexComprobantePae);
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
            $selectCargo = Cargo::model()->getCargoAutoridad($usuario_id);
            $autoridades = $autoridadPlantel->buscarAutoridadesPlantel($plantel_id);
            $dataProvider = $this->dataProviderAutoridades($autoridades);
            $cargoSelect = $cargoModel->getCargoAutoridad($usuario_id);

            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            //$this->renderPartial('_formAutoridades', array('mensaje' => $mensaje), false, true);
            $this->renderPartial('_formAutoridades', array('autoridadPlantel' => $autoridadPlantel, 'cargoSelect' => $cargoSelect, 'plantel_id' => $plantel_id, 'dataProvider' => $dataProvider, 'plantel'=>$plantel));
            Yii::app()->end();
        } else {
            throw new CHttpException(404, 'No se han especificado los datos necesarios para agregar el Cargo. Recargue la página e intentelo de nuevo.'); // esta vacio el request
        }
    }

    public function actionBuscarAutoridad($plantelId) {

        if (Yii::app()->request->isAjaxRequest OR true) {

            if (is_numeric($this->getQuery('usuario_id')) && is_numeric($this->getQuery('plantel_id'))) {

                $usuario_id = $this->getQuery('usuario_id');
                $plantel_id = $this->getIdDecoded($plantelId);

                $this->setCacheIndexes($plantel_id);

                $autoridad = new AutoridadPlantel();
                $autoridadPlantel = $autoridad->getAutoridadPlantel($plantel_id, $usuario_id);
                if ($autoridadPlantel) {
                    $this->renderPartial('_datosAutoridades', array('modelAutoridad' => $autoridadPlantel), false, true);
                } else {

                    $this->renderPartial('//msgBox', array('class' => 'alertDialogBox', 'message' => 'No se ha podido recopilar los datos de la Autoridad, intente nuevamente.'), false, true);
                }
            } else {
                throw new CHttpException(404, 'Recurso no encontrado. Datos incompletos.');
            }
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

    public function actionActualizarDatosAutoridad() {

        if (Yii::app()->request->isAjaxRequest) {

            //var_dump($this->getPost('estado_id') && is_numeric($this->getPost('estado_id')) && strlen($this->getPost('control_zona_observacion')));

            $usuario_idDecoded = (int) base64_decode($this->getPost('usuario_id'));
            $plantel_idDecoded = (int) base64_decode($this->getPost('plantel_id'));

            $this->setCacheIndexes($plantel_idDecoded);

            $email = $this->getPost('email');
            $emailBackup = $this->getPost('emailBackup');

            $telf_cel = (int) $this->getPost('telf_cel');
            $telf_celBackup = (int) $this->getPost('telf_celBackup');

            $telf_fijo = (int) $this->getPost('telf_fijo');
            $telf_fijoBackup = (int) $this->getPost('telf_fijoBackup');

            $presento_documento_identidad = $this->getPost('presento_documento_identidad');

            $validacionDatos = $this->validarActualizacionAutoridad($telf_fijo, $telf_cel, $usuario_idDecoded, $email);

            if ($validacionDatos !== null) {

                $model = $this->loadUserModel($usuario_idDecoded, 'contacto');

                if ($model) {

                    $model->email = $email;
                    $model->telefono = $telf_fijo;
                    $model->telefono_celular = $telf_cel;
                    $model->date_act = date('Y-m-d H:i:s');
                    $model->user_act_id = Yii::app()->user->id;
                    $model->presento_documento_identidad = $presento_documento_identidad;

                    if ($model->save()) {

                        Yii::app()->cache->delete($this->indexPlantelAutoridades);
                        Yii::app()->cache->delete($this->indexComprobantePae);

                        $this->registerLog('ESCRITURA', self::MODULO . '.actualizarDatosAutoridad', 'EXITOSO', 'El uario con el id=' . Yii::app()->user->id . ''
                            . ' ha cambiado los datos de una Autoridad Plantel '
                            . 'Email :<' . $emailBackup . '> a <' . $email . '>, Teléfono Fijo :<' . $telf_fijoBackup . '> a <' . $telf_fijo . '>'
                            . ', Teléfono Celular :<' . $telf_celBackup . '> a <' . $telf_cel . '>');
                            $this->renderPartial('//msgBox', array('class' => 'successDialogBox', 'message' => 'Los datos del usuario han sido actualizados exitosamente.'), false, true);
                    } else {

                        $this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => CHtml::errorSummary($model)), false, true);
                    }
                } else {

                    $this->renderPartial('//msgBox', array('class' => 'alertDialogBox', 'message' => 'La persona a la que desea actualizar los datos no se encuentra registrada. Recargue la página e intentelo de nuevo.'), false, true);
                }
            } else {
                $this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => $validacionDatos), false, true);
            }
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

    public function actionComprobante($id){

        $idDecoded = $this->getIdDecoded($id);

        $this->setCacheIndexes($idDecoded);

        if(Yii::app()->request->isAjaxRequest || in_array(Yii::app()->user->group, array(UserGroups::DESARROLLADOR, UserGroups::ROOT))){

            if(is_numeric($idDecoded)){

                $model = $this->loadModel($idDecoded);

                if($model){

                    $modulo = 'registroUnico.plantelesPae.comprobante';
                    $result = PlantelPae::model()->puedeObtenerComprobantePae($model->id, $modulo);

                    if(is_array($result) && array_key_exists('codigo', $result) && $result['codigo']=='EXITO'){

                        $codigo_seguridad = $result['codigo_seguridad'];
                        $archivo_pdf = $result['archivo_pdf'];
                        $fecha_vencimiento = $result['fecha_vencimiento'];

                        $filePath = str_replace('//', '/', str_replace('//', '/', Yii::app()->params['downloadDirectoryPath'].'/comprobantesPae/').'/'.$archivo_pdf);
                        // $barCodePath = str_replace('//', '/', realpath(str_replace('//', '/', Yii::app()->basePath.'/../public/downloads/comprobantesPae/bc/')).'/'.$codigo_seguridad.'.png');
                        $qrCodePath = str_replace('//', '/', Yii::app()->params['downloadDirectoryPath'].'/comprobantesPae/qr/'.$codigo_seguridad.'.png');

                        if(!file_exists($filePath) || in_array(Yii::app()->user->group, array(UserGroups::DESARROLLADOR, UserGroups::ROOT))){

                            $plantel = PlantelPae::model()->getDataParaComprobante(true, $model->id);
                            $proveedor = (in_array($plantel['siglas_proveedor_actual'], array('PDVAL', 'MERCAL')))?htmlentities($plantel['siglas_proveedor_actual']):htmlentities($plantel['razon_social_proveedor_actual']);

                            // ld($result, $model, $plantel, Yii::app()->user->group);

                            //  if(!file_exists($barCodePath)){
                            //      Utiles::generateBarcodeInFile($barCodePath, $codigo_seguridad);
                            //  }

                            $content = "";
                            if($plantel){
                                $codPlantel = (strpos($plantel['cod_plantel'], 'CNAE')===false)?htmlentities($plantel['cod_plantel']):'Sin Código DEA';
                                $content = "---\n".'Código CNAE: '.$plantel['cod_cnae'].".\n".'Código DEA: '.$codPlantel.".\n".'Nombre de la Institución Educativa: '.$plantel['nombre_plantel'].".\n".'Cédula del Director: '.$plantel['origen_director'].'-'.$plantel['cedula_director'].".\n".'Nombre del Director: '.$plantel['nombre_director']." ".$plantel['apellido_director'].".\n".'Proveedor Actual: '.$proveedor.".\n".'Fecha de Vencimiento: '.$fecha_vencimiento.".\n".'Código de Seguridad: '.$codigo_seguridad."\n---";
                            }

                            if(!file_exists($qrCodePath)){
                                // var_dump($qrCodePath);
                                Utiles::generateQrCodeInFile($qrCodePath, $content);
                            }

                            $mPDF = Yii::app()->ePdf->mpdf('', 'A4', 0, '', 13, 13, 13, 13, 9, 9, 'M');
                            $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
                            $mPDF->WriteHTML($this->renderPartial('_viewPdfComprobante', array('plantel'=>$plantel, 'codigo_seguridad'=>$codigo_seguridad, 'fecha_vencimiento'=>$fecha_vencimiento), true, false));
                            $mPDF->Output($filePath, EYiiPdf::OUTPUT_TO_FILE);
                            $command = 'chmod 777 -R '.$filePath;
                            exec($command);

                            if(!Yii::app()->request->isAjaxRequest && in_array(Yii::app()->user->group, array(UserGroups::DESARROLLADOR, UserGroups::ROOT))){
                                $this->renderPartial('_viewPdfComprobante', array('plantel'=>$plantel, 'codigo_seguridad'=>$codigo_seguridad, 'fecha_vencimiento'=>$fecha_vencimiento));
                            }

                        }

                    }
                    else{
                        if(isset($result['mensaje'])){
                            Yii::app()->user->setFlash('errorComprobante', $result['mensaje']);
                        }
                        else{
                            $result['mensaje'] = 'Ha ocurrido un error en el sistema. Comuniquese con el administrador.';
                            Yii::app()->user->setFlash('errorComprobante', 'Ha ocurrido un error en el sistema. Comuniquese con el administrador.');
                        }
                        // $this->redirect(array('/registroUnico/plantelesPae/edicion/id/'.$id.'/error/comprobante'));
                    }

                    $this->jsonResponse($result);

                }
                else{
                    throw new CHttpException(404, 'No se ha encontrado la institución educativa indicada.');
                }

            }
            else{
                throw new CHttpException(401, 'No se han proporcionado los datos necesarios para completar la operación.');
            }

        }
        else{
            throw new CHttpException(403, 'No está permitido realizar esta operación mediante esta vía, active el javascript de su navegador.');
        }

    }
        
    public function actionDatosComprobante($id){

        $idDecoded = $this->getIdDecoded($id);

        $this->setCacheIndexes($idDecoded);

        if(Yii::app()->request->isAjaxRequest || in_array(Yii::app()->user->group, array(UserGroups::DESARROLLADOR, UserGroups::ROOT))){

            if(is_numeric($idDecoded)){

                $model = $this->loadModel($idDecoded);

                if($model){

                    $modulo = 'registroUnico.plantelesPae.comprobante';
                    $result = PlantelPae::model()->puedeObtenerComprobantePae($model->id, $modulo);

                    if(is_array($result) && array_key_exists('codigo', $result) && $result['codigo']=='EXITO'){

                        $codigo_seguridad = $result['codigo_seguridad'];
                        $archivo_pdf = $result['archivo_pdf'];
                        $fecha_vencimiento = $result['fecha_vencimiento'];

                        $plantel = PlantelPae::model()->getDataParaComprobante(true, $model->id);
                        $proveedor = (in_array($plantel['siglas_proveedor_actual'], array('PDVAL', 'MERCAL')))?htmlentities($plantel['siglas_proveedor_actual']):htmlentities($plantel['razon_social_proveedor_actual']);

                            $content = "";
                            if($plantel){
                                $codPlantel = (strpos($plantel['cod_plantel'], 'CNAE')===false)?htmlentities($plantel['cod_plantel']):'Sin Código DEA';
                                $content = "---\n".'Código CNAE: '.$plantel['cod_cnae'].".\n".'Código DEA: '.$codPlantel.".\n".'Nombre de la Institución Educativa: '.$plantel['nombre_plantel'].".\n".'Cédula del Director: '.$plantel['origen_director'].'-'.$plantel['cedula_director'].".\n".'Nombre del Director: '.$plantel['nombre_director']." ".$plantel['apellido_director'].".\n".'Proveedor Actual: '.$proveedor.".\n".'Fecha de Vencimiento: '.$fecha_vencimiento.".\n".'Código de Seguridad: '.$codigo_seguridad."\n---";
                            }

                    }
                    else{
                        if(isset($result['mensaje'])){
                            Yii::app()->user->setFlash('errorComprobante', $result['mensaje']);
                        }
                        else{
                            $result['mensaje'] = 'Ha ocurrido un error en el sistema. Comuniquese con el administrador.';
                            Yii::app()->user->setFlash('errorComprobante', 'Ha ocurrido un error en el sistema. Comuniquese con el administrador.');
                        }
                        // $this->redirect(array('/registroUnico/plantelesPae/edicion/id/'.$id.'/error/comprobante'));
                    }

                    $this->jsonResponse($result);

                }
                else{
                    throw new CHttpException(404, 'No se ha encontrado la institución educativa indicada.');
                }

            }
            else{
                throw new CHttpException(401, 'No se han proporcionado los datos necesarios para completar la operación.');
            }

        }
        else{
            throw new CHttpException(403, 'No está permitido realizar esta operación mediante esta vía, active el javascript de su navegador.');
        }

    }

    /**
     *
     * @param integer $plantelId
     * @throws CHttpException
     */
    public function actionEliminarAutoridad($plantelId) {
        //ld(base64_decode($this->getPost('plantel_id')), $plantelId);
        if ($this->hasPost('id') && $this->hasPost('plantel_id')) {
            $id = $this->getPost('id');
            $plantel_id = $this->getPost('plantel_id');
            $this->setCacheIndexes($plantel_id);
            $plantel = $this->loadModel($this->getIdDecoded($plantelId));
            $autoridadPlantel = new AutoridadPlantel;
            $autoridadPlantel->eliminarAutoridad($id, $plantel_id);
            $cargoSelect = CCargo::getData('ente_id', 1);
            $autoridades = $autoridadPlantel->buscarAutoridadesPlantel($plantel_id);
            $dataProviderAutoridades = $this->dataProviderAutoridades($autoridades);
            Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
            $this->renderPartial('_formAutoridades', array('autoridadPlantel' => $autoridadPlantel, 'cargoSelect' => $cargoSelect, 'plantel_id' => $plantel_id, 'dataProvider' => $dataProviderAutoridades, 'plantel'=>$plantel));
            Yii::app()->end();
        } else {
            throw new CHttpException(404, 'No se ha especificado la autoridad a eliminar. Recargue la página e intentelo de nuevo.'); // esta vacio el request
        }
    }
    
    public function actionTomarFotografiaAutoridad($id){
        $idDescoded = $this->getIdDecoded($id);
        if(is_numeric($idDescoded)){
            $model = $this->loadUserModel($idDescoded, 'contacto');
            if($model){
                // var_dump($model);
                $this->renderPartial('_formAutoridadesFotografia', array('model'=>$model));
            }
            else{
                $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'El registro seleccionado no coincide con ninguna persona registrada en el sistema. recargue la página e intentelo de nuevo.'));
            }
        }
        else {
            throw new CHttpException(404, 'No se ha especificado la autoridad a la cual tomar la fotografía. Recargue la página e intentelo de nuevo.'); // esta vacio el request
        }
    }
    
    public function actionRegistroFotografiaAutoridad($id){
        $idDecoded = $this->getIdDecoded($id);
        if(is_numeric($idDecoded)){
            $model = $this->loadUserModel($idDecoded, 'contacto');
            if($model){
                $fotoBase64 = $this->getPost('fotoImgBase64');
                if(strpos($fotoBase64, 'data:image/png;base64')!==false){
                    $rutaFotografia = '';
                    $urlDownloadFotografia = '';

                    list($rutaFotografia, $urlDownloadFotografia) = $this->guardarFotografia($fotoBase64, $idDecoded);

                    $model->foto = $urlDownloadFotografia;
                    
                    $cacheIndex = 'USR:'.$idDecoded;
                    Yii::app()->cache->delete($cacheIndex);
                    
                    if($model->validate()){
                        try{
                            $model->save();
                            $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La fotografía de la Autoridad del Plantel ha sido Registrada Correctamente.'));
                        } catch (Exception $ex) {
                            $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el sistema. ERROR: '.$ex->getMessage()));
                        }
                    }else{
                        $this->renderPartial('//errorSumMsg', array('model'=>$model));
                    }
                }
                else{
                    $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'No se ha recibido la fotografía de la Autoridad del Plantel.'));
                }
            }
            else{
                $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'El registro seleccionado no coincide con ninguna persona registrada en el sistema. recargue la página e intentelo de nuevo.'));
            }
        }
        else {
            throw new CHttpException(404, 'No se ha especificado la autoridad a la cual tomar la fotografía. Recargue la página e intentelo de nuevo.'); // esta vacio el request
        }
    }
    
    public function guardarFotografia($fotoBase64, $idCocin){
        // Remove the headers (data:,) part.
        $filteredData=substr($fotoBase64, strpos($fotoBase64, ",")+1);

        // Need to decode before saving since the data we received is already base64 encoded
        $decodedData=base64_decode($filteredData);
        
        $nombreArchivoFoto = date('YmdHis').'-'.$idCocin.'.png';
        $rutaArchivoFoto = Yii::app()->params['uploadFotoAutoridadPlantelDirectoryPath'].$nombreArchivoFoto;
        $downloadArchivoFoto = Yii::app()->params['urlDownloadFotoAutoridadPlantel'].$nombreArchivoFoto;
        
        $fp = fopen($rutaArchivoFoto, 'wb');
        fwrite( $fp, $decodedData);
        fclose( $fp );
        
        return array($rutaArchivoFoto, $downloadArchivoFoto);
    }

    public function dataProviderAutoridades($autoridades) {
        $rawData = array();
        $boton = '';
        $usuario_id_signed = Yii::app()->user->id;
        if ($autoridades != array() && is_array($autoridades) && count($autoridades)>0) {

            foreach ($autoridades as $key => $value) {
                $boton = '';
                $id = $value['id'];
                $usuario_id = $value['usuario_id'];
                if ($usuario_id_signed != $usuario_id) {
                    $boton = "<div class='action-buttons center'>" .
                            CHtml::link("", "", array("class" => "icon-pencil green change-data", 'data-id' => $usuario_id, "title" => "Modificar Datos de Autoridad")) . '&nbsp;&nbsp;' .
                            CHtml::link("", "", array("class" => "icon-camera blue picture-data", 'data-id' => $usuario_id, 'data-url'=>'/registroUnico/plantelesPae/tomarFotografiaAutoridad/id/'.base64_encode($usuario_id), "title" => "Tomar Fotografía")) . '&nbsp;&nbsp;' .
                            CHtml::link("", "", array("class" => "icon-trash red remove-data", 'onClick' => "eliminarAutoridad($id)", "title" => "Eliminar Autoridad")) .
                            "</div>";
                }
                $nombre = "<div class='center'>" . Utiles::strtoupper_utf8($value['nombre'] . ' ' . $value['apellido']) . "</div>";
                $cedula = "<div class='center'>" . $value['cedula'] . "</div>";
                $cargo = "<div class='center'>" . $value['nombre_cargo'] . "</div>";

                $telefono_fijo = "<div id='telefono_fijo_$usuario_id' class='center'>" . str_pad($value['telefono_fijo'], 11, '0', STR_PAD_LEFT) . "</div>";
                $telefono_celular = "<div id='telefono_celular_$usuario_id' class='center'>" . str_pad($value['telefono_celular'], 11, '0', STR_PAD_LEFT) . "</div>";
                $correo = "<div id='correo_$usuario_id' class='center'>" . strtolower($value['email']) . "</div>";
                $presento_documento_identidad = "<div id='ci_$usuario_id' title='Presentó su Documento de Identidad' class='center'>" . ucfirst(strtolower($value['presento_documento_identidad'])) . "</div>";
                $foto = (strlen($value['foto'])>0)?"<div id='foto_$usuario_id' title='Fotografía Guardada' class='center'>Si</div>":"<div title='Fotografía No Guardada' id='foto_$usuario_id' class='center'>No</div>";
                $rawData [] = array(
                    'id' => $key,
                    'cargo' => $cargo,
                    'nombre' => $nombre,
                    'cedula' => $cedula,
                    'correo' => $correo,
                    'telefono_fijo' => $telefono_fijo,
                    'telefono_celular' => $telefono_celular,
                    'presento_documento_identidad' => $presento_documento_identidad,
                    'foto' => $foto,
                    'boton' => $boton
                );
            }
            return new CArrayDataProvider($rawData, array(
                'pagination' => array(
                    'pageSize' => 5,
                ),
            ));
        } else
            return new CArrayDataProvider($rawData, array(
                'pagination' => array(
                    'pageSize' => 5,
                ),
            ));
    }

    public function getFechasCantMatricula(){
        $modelConfiguracion = Configuracion::model()->getFechasCantMatricula();

        $fechaIniMatricula = $modelConfiguracion[0]['valor_date'];
        $fechaFinMatricula = $modelConfiguracion[1]['valor_date'];

        return array($fechaIniMatricula, $fechaFinMatricula);
    }

    public function actionMunicipiosStandAlone(){

        if($this->hasPost('Plantel') ){
            $model = new Plantel();
            $model->attributes = $this->getPost('Plantel');
            $this->forward($this->createUrl('/ayuda/selectCatastro/municipiosStandalone/estadoId/'.$model->estado_id.'/municipioId/'.$model->municipio_id));
        }
        else{
            throw new CHttpException(400, 'Bad Request');
        }

    }

    public function actionParroquiasStandAlone(){

        if($this->hasPost('Plantel')){
            $model = new Plantel();
            $model->attributes = $this->getPost('Plantel');
            $this->forward($this->createUrl('/ayuda/selectCatastro/parroquiasStandalone/municipioId/'.$model->municipio_id.'/parroquiaId/'.$model->parroquia_id));
        }
        else{
            throw new CHttpException(400, 'Bad Request');
        }

    }

    public function actionSeleccionarPoblacion() {
        $item = $_REQUEST['parroquia_id'];

        if ($item == '' || $item == NULL) {
            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }
        else {
            $lista = Plantel::model()->obtenerPoblacion($item);
            if(count($lista)>0){
                $lista = CHtml::listData($lista, 'id', 'nombre');
            }
            //$data = CJSON::encode(Plantel::model()->obtenerPoblacion($item)); echo "$data";

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);
            
            if(count($lista)>0){
                if(count($lista)){
                    foreach ($lista as $valor => $descripcion) {
                        echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                    }
                }
            }
        }
    }

    public function actionSeleccionarUrbanizacion() {
        $item = $_REQUEST['Plantel']['parroquia_id'];
        //$item=$_REQUEST['parroquia_id'];

        if ($item == '' || $item == NULL) {
            $lista = array('empty' => '-SELECCIONE-');
            if(count($lista)>0){
                foreach ($lista as $valor => $descripcion) {
                    echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                }
            }
        } else {
            $lista = Plantel::model()->obtenerUrbanizacion($item);
            if(count($lista)>0){
                $lista = CHtml::listData($lista, 'id', 'nombre');
            }
            //$data = CJSON::encode(Plantel::model()->obtenerPoblacion($item)); echo "$data";

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

            if(count($lista)>0){
                foreach ($lista as $valor => $descripcion) {
                    echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                }
            }
        }
    }

    public function actionSeleccionarTipoVia(){

        $item = $_REQUEST['Plantel']['parroquia_id'];

        if ($item == '' || $item == NULL) {
            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion){
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $lista = Plantel::model()->obtenerTipoVia($item);
            $lista = CHtml::listData($lista, 'id', 'nombre');
            //$data = CJSON::encode(Plantel::model()->obtenerPoblacion($item)); echo "$data";

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

            foreach ($lista as $valor => $descripcion){
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }

    }

    /**
     *
     * @param integer $id Id del Plantel
     */
    public function actionBuscarCedula($id){

        // var_dump(Yii::app()->request->isAjaxRequest, $this->hasQuery('cedula'), is_numeric(base64_decode($id)));
        if(Yii::app()->request->isAjaxRequest && $this->hasQuery('cedula') && is_numeric(base64_decode($id))){
        //if(true){
            $cedula = $this->getQuery('cedula');
            $plantel_id = (int) base64_decode($id);
            $plantel = $this->loadModel($plantel_id);
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
                        $mensaje = "La Cédula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        $this->jsonResponse(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                        Yii::app()->end();
                    }
                } else {
                    // MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                    $mensaje = "La Cédula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    $this->jsonResponse(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                    Yii::app()->end();
                }
            } else {
                // MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
                $mensaje = "La Cédula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $this->jsonResponse(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                Yii::app()->end();
            }

            $autoridades = AutoridadPlantel::model()->buscarAutoridadesPlantel($plantel_id);

            if ($autoridades == array()) {
                /*
                 * Es la primera vez que entra en este ciclo por lo tanto solo resta buscar la cedula en la base de datos
                 * Si es distinto de un array() es porque anteriormente ya habia agregado una autoridad al plantel,
                 * en ese caso hay que validar si la cedula no esta primero en este arreglo
                 */
                $this->validarUsuario($origen, $cedulaDecoded, $autoridades, $plantel_id, $plantel);
            } else {

                foreach ($autoridades as $key => $value) {
                    if ($value['cedula'] == $cedulaDecoded) {
                        $existe = true;
                        $mensaje = "La Cédula de Identidad de esta persona tiene un cargo asignado.";
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        $this->jsonResponse(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                        //$this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                        Yii::app()->end();
                    }
                }
                if (!$existe) {
                    $this->validarUsuario($origen, $cedulaDecoded, $autoridades, $plantel_id, $plantel);
                }
            }

        }
        else {
            throw new CHttpException(404, 'No se han especificado los datos necesarios. Recargue la página e intentelo de nuevo.'); // esta vacio el request
        }

    }

    public function validarUsuario($origen, $cedula, $autoridades, $plantel_id, $plantel) {
        $existe_usuario_autoridad = "";
        $autoridadPlantel = new AutoridadPlantel();

        $busquedaCedula = $autoridadPlantel->busquedaSaime($origen, $cedula); // valida si existe la cedula en la tabla saime
        if (!$busquedaCedula) {
            $mensaje = "Esta Cedula de Identidad no se encuentra registrada en nuestro sistema, "
                    . "por favor contacte al personal de soporte mediante "
                    . "<a href='mailto:soporte_gescolar@me.gob.ve'>soporte_gescolar@me.gob.ve</a>";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje)); // NO EXISTE EN SAIME
            // $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
            Yii::app()->end();
        } else {

            $existeEnNominaMppe = (int)NominaMppe::model()->existe($origen, $cedula);

            // Las dependencias 6, 7 y 8 indicas que la institución es privada.
            if($existeEnNominaMppe==1 && is_object($plantel) && !in_array($plantel->tipo_dependencia_id*1, array(6,7,8)) || true){

                $busquedaCedulaUG = $autoridadPlantel->busquedaUserGroups($origen, $cedula);
                if ($busquedaCedulaUG == null) {
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo json_encode(array('statusCode' => 'successU', 'nombre' => $busquedaCedula['nombre'], 'apellido' => $busquedaCedula['apellido'], 'usuario' => $busquedaCedula['cedula'] . Utiles::generarLetraFromCedula($cedula)));
                    Yii::app()->end();
                } else {
                    $tipo_dependencia = $this->loadModel($plantel_id);
                    $existe_usuario_autoridad = Plantel::model()->validarAutoridad($tipo_dependencia, $busquedaCedulaUG, $plantel_id);
                    if ($existe_usuario_autoridad != array()) {
                        // ya tiene un cargo en ese plantel
                        $mensaje = "El Usuario ya posee un cargo como Autoridad en el MPPE. <br>"
                                . " Si cree que esto puede ser una excepción comuniquelo al correo "
                                . "<a href='mailto:soporte_gescolar@me.gob.ve'>soporte_gescolar@me.gob.ve</a>";
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                        //$this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                        $this->registerLog('ILEGAL', 'Planteles.Modificar.BuscarCedula', 'NO EXITOSO', 'El Usuario ha intentado registrar una autoridad (C.I: ' . $origen . '-' . $cedula . ') que ya posee un cargo en el MPPE');
                        Yii::app()->end();
                    } else {
                        $usuarioUGU = UserGroupsUser::model()->findByPk($busquedaCedulaUG);
                        $group_id_usuario = (isset($usuarioUGU) && $usuarioUGU->group_id !== null) ? $usuarioUGU->group_id : null;
                        $grupoUsuario = (isset($usuarioUGU) && is_object($usuarioUGU->relUserGroupsGroup) !== null) ? $usuarioUGU->relUserGroupsGroup->description : null;

                        // if ($group_id_usuario !== null && $group_id_usuario == UserGroups::DIRECTOR) {
                        if ($group_id_usuario !== null) {
                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                            echo json_encode(
                                    array(
                                        'statusCode' => 'successC',
                                        'cedula' => $cedula,
                                        'nombre' => $usuarioUGU->nombre,
                                        'apellido' => $usuarioUGU->apellido,
                                        'autoridades' => $autoridades,
                                    )
                                ); // debe asignar un cargo
                            // $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                            Yii::app()->end();
                        } else {
                            $mensaje = "El Usuario esta asignado al grupo <strong>'$grupoUsuario'</strong> en el sistema, debe solicitar acceso a la <strong>'Dirección de Registro y Control de Estudios y Evaluación'</strong>";
                            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                            echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                            //$this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                            $this->registerLog('ILEGAL', 'Planteles.Modificar.BuscarCedula', 'NO EXITOSO', 'El Usuario ha intentado registrar una autoridad (C.I: ' . $origen . '-' . $cedula . ') y dicho usuario no esta en el grupo DIRECTOR');
                            Yii::app()->end();
                        }
                    }
                }
            }
            else{
                $mensaje = "El Usuario con la Cédula de Identidad $origen-$cedula no se encuentra presente en la nómina del Ministerio del Poder Popular para La Educación.";
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                        //$this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                        $this->registerLog('ILEGAL', 'Planteles.Modificar.BuscarCedula', 'NO EXITOSO', 'El Usuario ha intentado registrar una autoridad (C.I: ' . $origen . '-' . $cedula . ') y dicho usuario no esta en la nómina del MPPE');
                        Yii::app()->end();
            }
        }
    }

    public function validarUsuarioNuevo($usuario) {
        $mensaje = "";
        $cod_area_movil = array('0416', '0426', '0412', '0414', '0424');
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
        if ($usuario['telefono'] != null && $usuario['telefono'] != '')
            if (strlen($usuario['telefono']) < 11) {
                $mensaje .= "El campo Telefono Fijo debe poseer 11 Dígitos <br>";
            } else if (substr($usuario['telefono'], 0, 2) != '02') {
                $mensaje .= "El campo Telefono Fijo no posee el formato correcto <br>";
            }

        if ($usuario['telefono_celular'] == null || $usuario['telefono_celular'] == '') {
            $mensaje .= "El campo Telefono Celular no puede estar vacio <br>";
        } elseif (strlen($usuario['telefono_celular']) < 11) {
            $mensaje .= "El campo Telefono Celular debe poseer 11 Dígitos <br>";
        } else if (!in_array(substr($usuario['telefono_celular'], 0, 4), $cod_area_movil, false)) {
            $mensaje .= "El campo Telefono Celular no posee el formato correcto <br> ";
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

    public function validarActualizacionAutoridad($telf_fijo, $telf_cel, $usuario_id, $email) {
        $mensaje = "";
        if ($telf_fijo == null || $telf_fijo == '') {
            $mensaje .= "El campo Teléfono Fijo no puede estar vacio <br>";
        } elseif (strlen($telf_fijo) < 11)
            $mensaje .= "El campo Teléfono Fijo debe poseer 11 Dígitos <br>";

        if ($telf_cel == null || $telf_cel == '') {
            $mensaje .= "El campo Teléfono Celular no puede estar vacio <br>";
        } elseif (strlen($telf_cel) < 11)
            $mensaje .= "El campo Teléfono Celular debe poseer 11 Dígitos <br>";

        if ($email == null || $email == '') {
            $mensaje .= "El campo Correo Eletrónico no puede estar vacio <br>";
        }
        elseif (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $mensaje .= "El campo Correo Eletrónico no posee el formato correcto <br>";
        }
        elseif ($email == AutoridadPlantel::model()->validarUniqueEmail($email, $usuario_id)) {
            $mensaje .= "Este Correo Eletrónico ya esta registrado <br>";
        }

//        if ($cargo_id == null || $cargo_id == '') {
//            $mensaje .= "El campo Cargo no puede estar vacio <br>";
//        } elseif ($cargo_id == AutoridadPlantel::model()->validarExisteCargo($cargo_id, $plantel_id, $usuario_id)) {
//            $mensaje .= "Este Cargo ya esta asignado. <br>";
//        }

        if ($mensaje == "") {
            return null;
        } else
            return $mensaje;
    }

    public function columnaAcciones($data, $estatusAutoridadPlantel=null) {

        $id = $data["id"];

        $estatus = (is_object($data->estatusPlantel) && isset($data->estatusPlantel->nombre)) ? $data->estatusPlantel->nombre : "";

        $estatus = strtoupper($estatus);

        $groupId = Yii::app()->user->group;
        $usuarioId = Yii::app()->user->id;

        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';
        // if (Yii::app()->user->pbac('planteles.consultar.read'))
        //    $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Consultar Datos</span>", Yii::app()->createUrl("/planteles/consultar/informacion/id/" . base64_encode($data->id)), array("class" => "fa fa-search-plus", "title" => "Consultar Datos del Plantel")) . '</li>';
        if (Yii::app()->user->pbac('planteles.modificar.read') || Yii::app()->user->pbac('registroUnico.plantelesPae.write') || Yii::app()->user->pbac('registroUnico.plantelesPae.admin')){
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Editar Datos</span>", Yii::app()->createUrl("/registroUnico/plantelesPae/edicion/id/" . base64_encode($data->id)), array("class" => "fa fa-pencil green", "title" => "Editar Datos del Plantel")) . '</li>';
            if(is_array($data->plantelPae) && count($data->plantelPae)>0 && is_object($data->plantelPae[0])){
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Asignar Cocineras Escolares</span>", Yii::app()->createUrl("/registroUnico/madresCocineras/asignadas/id/" . base64_encode($data->id)), array("class" => "fa fa-female purple", "title" => "Gesti&oacute;n de Madres Cocineras")) . '</li>';
            }
       }
        // $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Imprimir Datos</span>", "/planteles/consultar/reporte/id/" . base64_encode($data->id), array("class" => "fa fa-print blue", "title" => "Imprimir Datos del Plantel")) . '</li>';

        $columna .= '</ul></div>';

        return $columna;
    }

    public static function hasPermissionToAsignPlanteles($estatusAutoridadPlantel){
        return true;
        // return ($estatusAutoridadPlantel == 'A' && Yii::app()->user->pbac('servicio.Planteles.write')) || Yii::app()->user->pbac('servicio.Planteles.admin');
    }

    public function getIdDecoded($id){
        if(is_numeric($id)){
            return $id;
        }
        else{
            $idDecodedb64 = base64_decode($id);
            if(is_numeric($idDecodedb64)){
                return $idDecodedb64;
            }
        }
        return null;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Plantel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $planteles=null, $estatusAutoridadPlantel=null) {
        $model = null;
        if(!Yii::app()->user->pbac('admin')){ //El permiso Write se debe dar a las autoridades de Zona Educativa
            if(Yii::app()->user->pbac('write') && $estatusAutoridadPlantel=='A'){
                $plantelesArr = Utiles::toArrayUnidimensional($planteles, 'plantel_id');
                if(is_array($plantelesArr) && count($plantelesArr)>0){
                    $model = Plantel::model()->find(array('condition' => 't.id = :id AND t.plantel_actual_id IN ('.implode(',',$plantelesArr).')', 'params'=>array('id'=>$id)));
                }else{
                    throw new CHttpException(403, 'Usted no posee los permisos necesarios para efectuar esta acción.');
                }
            }
        }else{
            // ld($this->indexPlantel);
            // Yii::app()->cache->delete($this->indexPlantel);
            $model = Yii::app()->cache->get($this->indexPlantel);
            if(!$model){
                $model = Plantel::model()->find(array('condition' => 't.id = :id', 'params'=>array('id'=>$id)));
                if($model){
                    Yii::app()->cache->set($this->indexPlantel, $model, 36800);
                }
            }
        }
        if ($model === null)
            throw new CHttpException(404, 'El registro indicado no ha sido encontrado, o puede que no esté autorizado para efectuar esta acción.');
        return $model;
    }

    public function loadModelPae($id, $by = 'plantel'){
        
        //Yii::app()->cache->delete($this->indexPlantelPae);
        $model = Yii::app()->cache->get($this->indexPlantelPae);
        
        if(!$model){
            if($by=='plantel'){
                $model = PlantelPae::model()->find('plantel_id = :plantel', array(':plantel'=>$id));
            }else{
                $model = PlantelPae::model()->findByPk($id);
            }
            if($model){
                Yii::app()->cache->set($this->indexPlantelPae, $model, 36800);
            }
        }

        return $model;

    }

    public function loadUserModel($id, $scenario = false) {

        $cacheIndex = 'USR:'.$id;

        $model = Yii::app()->cache->get($cacheIndex);

        if(!$model){
            $model = UserGroupsUser::model()->findByPk((int) $id);

            if ($model === null || ($model->relUserGroupsGroup->level > Yii::app()->user->level))
                throw new CHttpException(403, 'El recurso solicitado no se ha encontrado o puede que su perfil de usuario no posea acceso a este recurso.');
            if ($scenario)
                $model->setScenario($scenario);

            if($model){
                Yii::app()->cache->set($cacheIndex, $model, 36800);
            }
        }
        return $model;
    }

    private function setCacheIndexes($plantelId){
        $this->indexPlantel = "PL:$plantelId";
        $this->indexPlantelPae = "PLPAE:$plantelId";
        $this->indexPlantelPaeInfoForm = "plantelPaeId$plantelId";
        $this->indexPlatelSinPaeInfoForm = "plantelIdSinPae$plantelId";
        $this->indexComprobantePae = "ComprobanteCnae:$plantelId";
        $this->indexPlantelAutoridades = 'AUTR:'.$plantelId;
    }

}
