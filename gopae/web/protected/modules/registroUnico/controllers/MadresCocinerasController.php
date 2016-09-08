<?php

/**
 * Clase Controladora de Peticiones del Módulo de Asignación a Planteles de Padres y Madres Cocineras y otras operaciones.
 *
 * @author José Gabriel González <jgonzalezp@me.gob.ve>
 * @createAt 2014-08-25
 * @updateAt 2014-08-25
 */
class MadresCocinerasController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'asignadas';

    /**
     * @return array action filters
     */
    public static $_permissionControl = array(
        'read' => 'Consulta de Madres Cocineras del Plantel',
        'write' => 'Asignación de Cocineras a Plantel',
        'admin' => 'Administración Completa de Madres Cocineras del Plantel',
        'label' => 'Módulo de Asignación de Madres Cocineras a Planteles'
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
                'actions' => array('asignadas', 'lista', 'consulta', 'asignacion', 'asistenciaMensual', 'verificacion', 'getFormAsignacion', 'validarAsignacion', 'asignacion', 'registroAsignacion', 'asistencia', 'desvincularMadreCocinera', 'registrarAsistencia'),
                'pbac' => array('write', 'admin',),
            ),
            array('allow',
                'actions' => array('asignadas', 'lista', 'consulta',),
                'pbac' => array('read',),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     *
     * @param mixed $id Id del Plantel
     */
    public function actionAsignadas($id) {

        $idDecoded = $this->getIdDecoded($id);

        // $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $idDecoded);
        $estatusAutoridadPlantel = 'A';
        $periodoEscolarActivo = PeriodoEscolar::model()->getPeriodoActivo();
        $plantel = PlantelPae::model()->getDataPlantelPae($idDecoded);
        $mesEscolarPae = CMesEscolarPae::getData();
        $modelMesEscolarPae = new MesEscolarPae();

        $modelMadresCocinerasPlantel=new CocineraPlantel('search');
        $modelMadresCocinerasPlantel->unsetAttributes();  // clear any default values
        if($this->hasQuery('CocineraPlantel')){
            $modelMadresCocinerasPlantel->attributes=$this->getQuery('CocineraPlantel');
        }
        $dataProviderMadresCocinerasPlantel = $modelMadresCocinerasPlantel->search();

        if($plantel){
            $this->render('asignadas', array(
                'modelMadresCocinerasPlantel' => $modelMadresCocinerasPlantel,
                'dataProviderMadresCocinerasPlantel' => $dataProviderMadresCocinerasPlantel,
                'plantel' => $plantel,
                'periodoEscolarActivo' => $periodoEscolarActivo,
                'estatusAutoridadPlantel' => $estatusAutoridadPlantel,
                'mesEscolarPae' => $mesEscolarPae,
                'modelMesEscolarPae' => $modelMesEscolarPae
            ));
        }else{
            $plantel = PlantelPae::model()->getDataPlantelSinPae($idDecoded);
            $this->render('infoNoActivoPae', array(
                'plantel' => $plantel,
                'periodoEscolarActivo' => $periodoEscolarActivo,
                'mesEscolarPae' => $mesEscolarPae,
                'modelMesEscolarPae' => $modelMesEscolarPae
            ));
        }
    }

    /**
     * Valida la asignación de una madre cocinera, y dependiendo de la respuesta muestra el formulario de registro o asignación de Madres Cocineras
     *
     * @param string $id Plantel ID en base64
     */
    public function actionValidarAsignacion($id){

        $idDecoded = $this->getIdDecoded($id);

        // $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $idDecoded);
        $estatusAutoridadPlantel = 'A';
        
        $modulo = 'registroUnico.madresCocineras.validarAsignacion';

        if($this->hasPermissionToAsignCocineras($estatusAutoridadPlantel)){

            if(Yii::app()->request->isAjaxRequest){

                $origen = $this->getPost('origen');
                $cedula = $this->getPost('cedula');

                if($this->isValidOrigenCedula($origen, $cedula)){

                    $resultado = TalentoHumano::model()->isValidToAsign($origen, $cedula, $idDecoded, $modulo);
                    if(is_array($resultado) && count($resultado)>=3){

                        if($resultado['codigo']=='S0000'){ // La madre cocinera cumple con todo lo necesario para ser asignada al plantel indicado
                            $idCocinera = TalentoHumano::model()->getIdByOrigenYCedula($origen, $cedula);
                            $this->forward('/registroUnico/madresCocineras/asignacion/id/'.$idCocinera.'/submitHide/true/mensaje/'.$resultado['mensaje']);
                        }
                        elseif($resultado['codigo']=='W0001' || $resultado['codigo']=='W0002'){ // Ya está asignada a otro plantel en el periodo activo
                            $this->renderPartial('//msgBox', array('classname'=>'alertDialogBox', 'message'=>$resultado['mensaje']));
                        }
                        else{ // Se han incumplido los parámetros mínimos de validación
                            $this->renderPartial('//msgBox', array('classname'=>'errorDialogBox', 'message'=>$resultado['mensaje']));
                        }

                    }
                    else{
                        $this->renderPartial('//msgBox', array('classname'=>'errorDialogBox', 'message'=>"Ha ocurrido un error en el sistema, comuniquese con el administrador del sistema. Datos del Error: Modulo(planteles.Cocineras.validarAsignacion), Request($origen, $cedula, $idDecoded)."));
                    }
                }
                else{
                    $this->renderPartial('//msgBox', array('classname'=>'errorDialogBox', 'message'=>'Los datos suministrados no son válidos. Seleccione un Origen válido e Ingrese una Cédula que contenga solo caracteres numéricos'));
                }
            }
            else{
                throw new CHttpException(403, 'No está permitido efectuar esta acción por esta vía');
            }
        }
        else{
            throw new CHttpException(403, 'Usted no está autorizado para efectuar esta acción.');
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionAsignacion($id, $submitHide=false, $mensaje=null) {

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $this->csrfTokenName = 'csrfTokenRegCocineras';
        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id);
        $csrfToken = $this->getCsrfToken('ChavezVive-MadresColaboradoras', $this->csrfTokenName);
        $redireccionadoSaime = false;

        if(self::hasPermissionToAsignCocineras($estatusAutoridadPlantel)){

            $planteles = AutoridadPlantel::model()->buscarPlantelAutoridadByUser(Yii::app()->user->id);

            $idDecoded = $this->getIdDecoded($id);
            $model = $this->loadModelCocinera($idDecoded, $planteles, $estatusAutoridadPlantel);

            $mensajeExitoso = (Yii::app()->user->hasFlash('mensajeExitoso'))?Yii::app()->user->getFlash('mensajeExitoso'):null;

            $renderType = 'render';
            if(Yii::app()->request->isAjaxRequest){
                $renderType = 'renderPartial';
            }

            $this->$renderType('_formConfirmacionAsignacion', array(
                'model' => $model,
                'formType' => 'edit',
                'origenes' => COrigen::getData(),
                'generos' => CGenero::getData(),
                'submitHide' => $submitHide,
                'mensaje' => $mensaje,
                'csrfToken' => $csrfToken,
            ));
        }
        else{
            throw new CHttpException(403,'Usted no posee permiso para efectuar esta acción.');
        }
    }

    /**
     *
     * @param int $id Id del Plantel
     *
     * @throws CHttpException
     */
    public function actionRegistroAsignacion($id, $idCocin) {

        $idDecoded = $this->getIdDecoded($id);
        $idCocinDecoded = $this->getIdDecoded($idCocin);
        
        if(Yii::app()->request->isAjaxRequest){
            
            $this->csrfTokenName = 'csrfTokenRegCocineras';
            $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $idDecoded);

            if($this->hasPost($this->csrfTokenName) && $this->validateCsrfToken(false, $this->csrfTokenName)){

                if(is_numeric($idDecoded) && (is_numeric($idCocinDecoded) || strlen($idCocinDecoded)==0) && $this->hasPost('TalentoHumano') && $this->hasPost('fotoImgBase64') && $this->hasPost('entregada_tarjeta_alimentacion')){
                    
                    $fotoBase64 = $this->getPost('fotoImgBase64');

                    if(strpos($fotoBase64, 'data:image/png;base64')!==false){
                    
                        if($this->hasPermissionToAsignCocineras($estatusAutoridadPlantel)){

                            $cocinera = null;

                            if(is_numeric($idCocinDecoded)){
                                $cocinera = TalentoHumano::model()->findByPk($idCocinDecoded);
                            }

                            if(!$cocinera){
                                $cocinera = new TalentoHumano();
                            }

                            $dataTalentoHumano = $this->getPost('TalentoHumano');
                            /**
                             * @var $cocinera TalentoHumano
                             */
                            $cocinera->email_personal = $dataTalentoHumano['email_personal'];
                            $cocinera->telefono_fijo = $dataTalentoHumano['telefono_fijo'];
                            $cocinera->telefono_celular = $dataTalentoHumano['telefono_celular'];
                            
                            // Debido a la validación
                            $cocinera->municipio_id = 129;
                            $cocinera->hijo_en_plantel = 'No';
                            
                            if($this->getPost('entregada_tarjeta_alimentacion')=='Si'){
                                $cocinera->fecha_entrega_tarjeta_alimentacion = date('Y-m-d');
                            }

                            if($cocinera->isNewRecord){
                                $cocinera->beforeSave();
                            }else{
                                $cocinera->beforeUpdate();
                            }

                            if($cocinera->validate()){

                                try {

                                    $periodoActual = PeriodoEscolar::model()->getPeriodoActivo();

                                    $rutaFotografia = '';
                                    $urlDownloadFotografia = '';

                                    list($rutaFotografia, $urlDownloadFotografia) = $this->guardarFotografia($fotoBase64, $idCocinDecoded);
                                    
                                    $cocinera->foto = $urlDownloadFotografia;
                                    
                                    if($cocinera->validate() && $cocinera->update()){
                                        Yii::app()->user->setFlash('mensajeExitoso', 'Se han registrado exitosamente los datos de la Madre o Padre Cocinera con la C.I. '.$cocinera->origen.'-'.$cocinera->cedula.'. Nombre: '.$cocinera->nombre.' '.$cocinera->apellido.'. El Número de Documento de Identidad, Nombre, Apellido y Fecha de Nacimiento son datos que no pueden ser editados.');
                                        $CocineraPlantel = new CocineraPlantel();
                                        $CocineraPlantel->talento_humano_id = $cocinera['id'];
                                        $CocineraPlantel->plantel_id = $idDecoded;
                                        $CocineraPlantel->beforeSave();
                                        if($CocineraPlantel->validate()){
                                            $modulo = 'planteles.Cocineras.registroAsignacion';
                                            $colaboradorId = $CocineraPlantel->talento_humano_id;
                                            $plantelId = $CocineraPlantel->plantel_id;
                                            $resultado = $CocineraPlantel->registrarAsignacion($colaboradorId, $plantelId, $modulo);
                                            // $this->registerLog('ESCRITURA', 'planteles.Cocineras.registroAsignacion', 'SUCCESS', 'Se ha registrado una Madre o Padre Cocinera con la C.I. '.$cocinera->origen.'-'.$cocinera->cedula.'. Nombre: '.$cocinera->nombre.' '.$cocinera->apellido.'. Banco ID: '.$cocinera->banco_id.'. Nro. de Cuenta: '.$cocinera->numero_cuenta.' Al Plantel con el ID:'.$idDecoded.'. En el Periodo: '.$periodoActual['periodo']);
                                            if(is_array($resultado) && count($resultado)>=3){

                                                if($resultado['codigo']=='S0000' || $resultado['codigo']=='S0001'){ // La madre cocinera cumple con todo lo necesario para ser asignada al plantel indicado
                                                    $this->renderPartial('//msgBox', array('classname'=>'successDialogBox', 'message'=>$resultado['mensaje']));
                                                }
                                                else{ // Se han incumplido los parámetros mínimos de validación
                                                    $this->renderPartial('//msgBox', array('classname'=>'errorDialogBox', 'message'=>$resultado['mensaje']));
                                                }

                                            }
                                            else{
                                                $this->renderPartial('//msgBox', array('classname'=>'errorDialogBox', 'message'=>"Ha ocurrido un error en el sistema, comuniquese con el administrador del sistema. Datos del Error: Modulo(planteles.Cocineras.registrarAsignacion), Request($idCocin, $idDecoded)."));
                                            }
                                        }else{
                                            $this->renderPartial('//errorSumMsg', array('model'=>$CocineraPlantel));
                                        }
                                    }
                                    else{
                                        $this->renderPartial('//errorSumMsg', array('model'=>$cocinera));
                                        Yii::app()->end();
                                    }
                                } catch (Exception $exc) {
                                    $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema. Error: <pre>'.$exc->getTraceAsString().'</pre>'));
                                    Yii::app()->end();
                                }
                            }
                            else{
                                $this->renderPartial('//errorSumMsg', array('model'=>$cocinera));
                            }
                        }
                        else{
                            $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Usted no posee permisos para efectuar esta acción en este plantel.'));
                        }
                    }
                    else{
                        $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'No se ha recibido la foto del Talento Humano.'));
                    }
                }
                else{
                    throw new CHttpException(401, 'No se han proveido los datos necesarios para efectuar esta accion.');
                }
            }
            else{
                $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Error CSRF: No se ha podido verificar el origen de los datos. Recargue la p&aacute;gina e intentelo de nuevo.'));
            }
        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta operacion mediante esta via.');
        }

    }

    public function actionLista($id) {
        $idDecoded = $this->getIdDecoded($id);
        if(is_numeric($idDecoded)){
            $periodo = PeriodoEscolar::model()->getPeriodoActivo();
            if(count($periodo)>0){
                $periodoEscolarId = $periodo['id'];
                $cocineras = CocineraPlantel::model()->getListaCocinerasPlantel($idDecoded);
                if(Yii::app()->request->isAjaxRequest){
                    $this->renderPartial('lista', array('cocineras'=>$cocineras));
                }
                else{
                    $this->render('lista', array('cocineras'=>$cocineras));
                }
            }
            else{
                $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'No existe un periodo escolar activo en el sistema, comuniquese con el administrador del sistema. Puede que el sistema se encuentre en mantenimiento.'));
            }
        }
        else{
            throw new CHttpException(401, 'No se han proveido los datos necesarios para efectuar esta accion.');
        }
    }

    public function actionDesvincularMadreCocinera(){

        $plantelId = $this->getPost('pid');
        $colaboradorPlantelId = $this->getPost('id');

        $plantelIdDecoded = $this->getIdDecoded($plantelId);
        $colaboradorPlantelIdDecoded = $this->getIdDecoded($colaboradorPlantelId);

        if(Yii::app()->request->isAjaxRequest){

            if(is_numeric($colaboradorPlantelIdDecoded) && is_numeric($plantelIdDecoded)){

                // $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $plantelIdDecoded);
                $estatusAutoridadPlantel = 'A';

                if($this->hasPermissionToAsignCocineras($estatusAutoridadPlantel) && $this->hasPermissionToUnasignCocineras($colaboradorPlantelIdDecoded, $plantelIdDecoded)){

                    $colaboradorPlantel = CocineraPlantel::model()->findByPk($colaboradorPlantelIdDecoded);

                    if($colaboradorPlantel){

                        $colaboradorPlantel->estatus = 'E';
                        $colaboradorPlantel->beforeUpdate();
                        $colaboradorId = $colaboradorPlantel->talento_humano_id;
                        if(CocineraPlantel::model()->desvincular($colaboradorPlantelIdDecoded, $plantelIdDecoded, $colaboradorId)){
                            $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La desvinculaci&oacute;n de la Madre Cocinera se ha efecutuado de forma exitosa.'));
                        }

                    }else{
                        $this->renderPartial('//msgBox', array('class'=>'alertDialogBox', 'message'=>'El colaborador indicado no se ha encontrado en la base de datos. Por favor recargue la p&aacute;gina e intentelo de nuevo.'));
                    }

                }else{
                    CocineraPlantel::model()->deleteCacheListaCocineras($plantelIdDecoded);
                    $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Usted no posee permisos para efectuar esta acción en este plantel.'));
                }
            }else{
                throw new CHttpException(401, 'No se han proveido los datos necesarios para efectuar esta accion.');
            }
        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta operacion mediante esta via.');
        }
    }

    public function actionAsistencia($id){

        $idDecoded = $this->getIdDecoded($id);

        if(is_numeric($idDecoded) && $this->hasPost('mes') && $this->hasPost('anio')){

            // $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $idDecoded);
            $estatusAutoridadPlantel = 'A';
            
            if($this->hasPermissionToAsignCocineras($estatusAutoridadPlantel)){

                $mes = $this->getPost('mes');
                $anio = $this->getPost('anio');

                if($this->isValidMesAnioAsistencia($mes, $anio)){

                    $diasPlanificados = (int)$this->getCantidadDiasPlanificados($mes, $anio);

                    if($diasPlanificados>0){

                        $periodoEscolar = PeriodoEscolar::model()->getPeriodoActivo();

                        $periodoEscolarId = $periodoEscolar['id'];
                        $plantelId = $idDecoded;

                        $asistenaciaCocineras = CocineraPlantelAsistencia::model()->getListaCocinerasPlantelAsistencia($plantelId, $periodoEscolarId, $mes, $anio);

                        if(count($asistenaciaCocineras)==0){

                            $cocineras = CocineraPlantel::model()->getListaCocinerasPlantel($plantelId, $periodoEscolarId);

                            if(count($cocineras)){
                                $this->renderPartial('_listaAsistenciaCocineras', array('cocineras'=>$cocineras, 'mes'=>$mes, 'anio'=>$anio, 'periodoEscolar'=>$periodoEscolar, 'diasPlanificados'=>$diasPlanificados));
                            }
                            else{
                                $this->renderPartial('//msgBox', array('class'=>'alertDialogBox', 'message'=>'No existen colaboradores asignados a este plantel en el período actual.'));
                            }

                        }else{

                            $this->renderPartial('_listaConsultaAsistenciaCocineras',  array('cocineras'=>$asistenaciaCocineras, 'mes'=>$mes, 'anio'=>$anio, 'periodoEscolar'=>$periodoEscolar, 'diasPlanificados'=>$diasPlanificados));

                        }

                    }
                    else{
                        $this->renderPartial('//msgBox', array('class'=>'alertDialogBox', 'message'=>'No existen días planificados para el mes seleccionado, por lo que no se puede efectuar registro de asistencia en este mes.'));
                    }

                }
                else{
                   $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Los datos suministrados no son válidos para efectuar esta acción, solo puede realizar registros de . Recargue la página e intentelo de nuevo.'));
                }

            }
            else{
                throw new CHttpException(403, 'Usted no está autorizado para efectuar esta acción.');
            }

        }
        else{
            throw new CHttpException(401, 'No se han proveido los datos necesarios para efectuar esta accion.');
        }

    }

    public function actionRegistrarAsistencia($id){

        $modulo = 'planteles.Cocineras.registrarAsistencia';

        $idDecoded = $this->getIdDecoded($id); // Plantel ID
        $plantelId = $idDecoded;

        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $plantelId);

        if($this->hasPermissionToAsignCocineras($estatusAutoridadPlantel)){

            if($this->hasPost('CocineraPlantelAsistencia') && is_numeric($plantelId) && $this->hasPost('mes') && $this->hasPost('anio')){

                $mes = $this->getPost('mes');
                $anio = $this->getPost('anio');

                if($this->isValidMesAnioAsistencia($mes, $anio)){

                    $diasPlanificados = (int)$this->getCantidadDiasPlanificados($mes, $anio);

                    if($diasPlanificados>0){

                        $periodoEscolar = PeriodoEscolar::model()->getPeriodoActivo();

                        $periodoEscolarId = $periodoEscolar['id'];
                        $periodo = $periodoEscolar['periodo'];
                        $plantelId = $idDecoded;

                        $asistenaciaCocineras = CocineraPlantelAsistencia::model()->getListaCocinerasPlantelAsistencia($plantelId, $periodoEscolarId, $mes, $anio);

                        if(count($asistenaciaCocineras)==0){

                            $cocineras = CocineraPlantel::model()->getListaCocinerasPlantel($plantelId, $periodoEscolarId);

                            if(count($cocineras)){

                                $colaborador = $this->getRequest('CocineraPlantelAsistencia');

                                foreach ($colaborador AS $c){
                                    if(array_key_exists('colaborador_plantel_id', $c) && array_key_exists('cant_asistencia', $c)){
                                        if(strlen($c['colaborador_plantel_id'])>0 && strlen($c['cant_asistencia'])>0 && is_numeric($c['colaborador_plantel_id']) && is_numeric($c['cant_asistencia'])){
                                            $cocinerasPlantelId[] = (int)$c['colaborador_plantel_id'];
                                            $cantAsistencias[] = (int)$c['cant_asistencia'];
                                        }
                                    }
                                }

                                if(count($cocineras)==count($cantAsistencias)){

                                    $usuarioId = Yii::app()->user->id;
                                    $username = Yii::app()->user->name;
                                    $ip = Utiles::getRealIP();

                                    list($result, $mensaje, $response) = CocineraPlantelAsistencia::model()->registroAsistenciaMadresCocineras(
                                            $cocinerasPlantelId,
                                            $cantAsistencias,
                                            $mes,
                                            $anio,
                                            $diasPlanificados,
                                            $modulo,
                                            $usuarioId,
                                            $username,
                                            $ip,
                                            $plantelId
                                    );

                                    if($result){

                                        $mesFormat = str_pad($mes, 2, '0', STR_PAD_LEFT);
                                        $mensaje = "El Registro de Asistencias de Madres y Padres Cocineras del mes $mesFormat/$anio del Período Escolar $periodo se ha efectuado de forma exitosa.";
                                        $asistenaciaCocineras = CocineraPlantelAsistencia::model()->getListaCocinerasPlantelAsistencia($plantelId, $periodoEscolarId, $mes, $anio);
                                        $this->renderPartial('_listaConsultaAsistenciaCocineras',  array('cocineras'=>$asistenaciaCocineras, 'mes'=>$mes, 'anio'=>$anio, 'periodoEscolar'=>$periodoEscolar, 'diasPlanificados'=>$diasPlanificados,'mensaje'=>$mensaje,));

                                    }
                                    else{

                                        $exitosos = $response->stats['exitos'];
                                        $observaciones = $response->stats['alertas'];
                                        $errores = $response->stats['errores'];
                                        $mensaje = "No se ha podido realizar por completo el Registro de Asistencia. Existen algunos registros con errores u observaciones. Exitoso: $exitosos. Con Observaciones: $observaciones. Con Errores: $errores.";
                                        $this->renderPartial('_resultRegistroAsistenciaCocinerasConErrores',  array('cocineras'=>$asistenaciaCocineras, 'mes'=>$mes, 'anio'=>$anio, 'periodoEscolar'=>$periodoEscolar, 'diasPlanificados'=>$diasPlanificados,'mensaje'=>$mensaje,));

                                    }

                                }
                                else{
                                    $this->renderPartial('//msgBox', array('class'=>'alertDialogBox', 'message'=>'La cantidad Cocineras no Coinciden con la Cantidad de Asistencias a Registrar. Recargue la P&aacute;gina e intentelo de nuevo.'));
                                }
                            }
                            else{
                                $this->renderPartial('//msgBox', array('class'=>'alertDialogBox', 'message'=>'No existen colaboradores asignados a este plantel en el período actual.'));
                            }
                        }else{
                            $this->renderPartial('_listaConsultaAsistenciaCocineras',  array('cocineras'=>$asistenaciaCocineras, 'mes'=>$mes, 'anio'=>$anio, 'periodoEscolar'=>$periodoEscolar, 'diasPlanificados'=>$diasPlanificados));
                        }
                    }
                    else{
                        $this->renderPartial('//msgBox', array('class'=>'alertDialogBox', 'message'=>'No existen días planificados para el mes seleccionado, por lo que no se puede efectuar registro de asistencia en este mes.'));
                    }
                }
                else{
                   $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Los datos suministrados no son válidos para efectuar esta acción, solo puede realizar registros de . Recargue la página e intentelo de nuevo.'));
                }
            }
            else{
                throw new CHttpException(401, 'Datos insuficientes para efectuar esta acción.');
            }
        }
        else{
            throw new CHttpException(403, 'Usted no está autorizado para efectuar esta acción.');
        }
    }


    public function getCantidadDiasPlanificados($mes=null, $anio=null){
        if(!$mes){
            $mes = $this->getPost('mes');
        }
        if(!$anio){
            $anio = $this->getPost('anio');
        }
        $diasPlanificados = Planificacion::model()->cantidadDiasPlanificados($mes, $anio);
        return $diasPlanificados;
    }

    public $contador = 0;
    public function inputAsistenciaMadresCocineras($data, $diasPlanificados){
        $columna = '<input type="hidden" value="' . $data['colaborador_plantel_id'] . '" name="CocineraPlantelAsistencia[' . $this->contador . '][colaborador_plantel_id]" required="required" />
                    <input type="number" min="0" max="'.$diasPlanificados.'" class="cantAsistenciaCocineras" name="CocineraPlantelAsistencia[' . $this->contador . '][cant_asistencia]" required="required" />';
        $this->contador++;
        echo $columna;
    }

    private function isValidOrigenCedula($origen, $cedula){
        $result = false;
        if(COrigen::getData('abreviatura', $origen) && is_numeric($cedula) && strlen($origen)>0 && strlen($cedula)>0){
            $result = true;
        }
        return $result;
    }

    private function isValidMesAnioAsistencia($mes, $anio){
        $mesActual = 10;
        // $mesActual = date('m')*1;
        $periodoEscolar = PeriodoEscolar::model()->getPeriodoActivo();
        $anioInicio = $periodoEscolar['anio_inicio']*1;
        $anioFin = $periodoEscolar['anio_fin']*1;

        $mesNum = $mes*1;
        $anioNum = $anio*1;

        if($mesNum>8){
            $anioValido = $anioInicio;
        }else{
            $anioValido = $anioFin;
        }

        // var_dump($mesNum, $mesActual, $anioNum, $anioInicio, $anioFin, $anioValido);

        if($mesNum<$mesActual && $anioNum==$anioValido){
            return true;
        }
        return false;
    }

    public function hasPermissionToAsignCocineras($estatusAutoridadPlantel){
        return ($estatusAutoridadPlantel == 'A' && Yii::app()->user->pbac('registroUnico.madresCocineras.write')) || Yii::app()->user->pbac('registroUnico.madresCocineras.admin');
    }

    public function hasPermissionToUnasignCocineras($colaboradorPlantelId, $plantelId){
        $resultado = CocineraPlantel::model()->getCocineraPlantelByPlantel($colaboradorPlantelId, $plantelId);
        return $resultado;
    }

    public function columnaAcciones($data) {

        $colaboradorId = $data["talento_humano_id"];
        $colaboradorPlantelId = $data["cocinera_plantel_id"];
        $colaboradorIdEnc = base64_encode($colaboradorId);
        $colaboradorPlantelIdEnc = base64_encode($colaboradorPlantelId);
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in", "title" => "Ver datos", 'href' => '/gestionHumana/talentoHumano/consulta/id/'.$colaboradorIdEnc)) . '&nbsp;&nbsp;';
        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $data["plantel_id"]);
        if($this->hasPermissionToAsignCocineras($estatusAutoridadPlantel)){
            //$columna .= CHtml::link("", "", array("class" => "fa icon-pencil green", "title" => "Editar datos", 'href' => '/registroUnico/madresCocineras/edicion/id/'.$colaboradorIdEnc)) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa icon-trash red", "title" => "Desvincular", 'onClick' => 'desvincularMadreCocinera("'.$colaboradorPlantelIdEnc.'")')) . '&nbsp;&nbsp;';
        }
        $columna .= '</div>';
        return $columna;
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

    public function loadModelCocinera($id) {
        $model = TalentoHumano::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public function guardarFotografia($fotoBase64, $idCocin){
        // Remove the headers (data:,) part.
        $filteredData=substr($fotoBase64, strpos($fotoBase64, ",")+1);

        // Need to decode before saving since the data we received is already base64 encoded
        $decodedData=base64_decode($filteredData);
        
        $nombreArchivoFoto = date('YmdHis').'-'.$idCocin.'.png';
        $rutaArchivoFoto = Yii::app()->params['uploadFotoTalentoHumanoDirectoryPath'].$nombreArchivoFoto;
        $downloadArchivoFoto = Yii::app()->params['urlDownloadFotoTalentoHumano'].$nombreArchivoFoto;
        
        $fp = fopen($rutaArchivoFoto, 'wb');
        fwrite( $fp, $decodedData);
        fclose( $fp );
        
        return array($rutaArchivoFoto, $downloadArchivoFoto);
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
