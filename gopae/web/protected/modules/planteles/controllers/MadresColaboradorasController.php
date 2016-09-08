<?php

/**
 * Clase Controladora de Peticiones del Módulo de Asignación a Planteles de Padres y Madres Colaboradores y otras operaciones.
 *
 * @author José Gabriel González <jgonzalezp@me.gob.ve>
 * @createAt 2014-08-25
 * @updateAt 2014-08-25
 */
class MadresColaboradorasController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'asignadas';

    /**
     * @return array action filters
     */
    public static $_permissionControl = array(
        'read' => 'Consulta de Madres Colaboradoras del Plantel',
        'write' => 'Asignación de Colaboradoras a Plantel',
        'admin' => 'Administración Completa de Madres Colaboradoras del Plantel',
        'label' => 'Módulo de Asignación de Madres Colaboradoras a Planteles'
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
                'actions' => array('asignadas', 'lista', 'consulta', 'asignacion', 'asistenciaMensual', 'verificacion', 'getFormAsignacion', 'validarAsignacion', 'registroAsignacion', 'asistencia', 'desvincularMadreColaboradora', 'registrarAsistencia'),
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

        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $idDecoded);

        $periodoEscolarActivo = PeriodoEscolar::model()->getPeriodoActivo();
        $plantel = PlantelPae::model()->getDataPlantelPae($idDecoded);
        $mesEscolarPae = CMesEscolarPae::getData();
        $modelMesEscolarPae = new MesEscolarPae;

        $modelMadresColaboradorasPlantel=new ColaboradorPlantel('search');
        $modelMadresColaboradorasPlantel->unsetAttributes();  // clear any default values
        if($this->hasQuery('ColaboradorPlantel')){
            $modelMadresColaboradorasPlantel->attributes=$this->getQuery('ColaboradorPlantel');
        }
        $dataProviderMadresColaboradorasPlantel = $modelMadresColaboradorasPlantel->search();

        if($plantel){
            $this->render('asignadas', array(
                'modelMadresColaboradorasPlantel' => $modelMadresColaboradorasPlantel,
                'dataProviderMadresColaboradorasPlantel' => $dataProviderMadresColaboradorasPlantel,
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
     * Valida la asignación de una madre colaboradora, y dependiendo de la respuesta muestra el formulario de registro o asignación de Madres Colaboradoras
     *
     * @param string $id Plantel ID en base64
     */
    public function actionValidarAsignacion($id){

        $idDecoded = $this->getIdDecoded($id);

        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $idDecoded);

        $modulo = 'planteles.madresColaboradoras.validarAsignacion';

        if($this->hasPermissionToAsignColaboradoras($estatusAutoridadPlantel)){

            if(Yii::app()->request->isAjaxRequest){

                $origen = $this->getPost('origen');
                $cedula = $this->getPost('cedula');

                if($this->isValidOrigenCedula($origen, $cedula)){

                    $resultado = Colaborador::model()->isValidToAsign($origen, $cedula, $idDecoded, $modulo);
                    if(is_array($resultado) && count($resultado)>=3){

                        if($resultado['codigo']=='S0000'){ // La madre colaboradora cumple con todo lo necesario para ser asignada al plantel indicado
                            $idColaboradora = Colaborador::model()->getIdByOrigenYCedula($origen, $cedula);
                            $this->forward('/servicio/colaboradoras/edicion/id/'.$idColaboradora.'/submitHide/true/mensaje/'.$resultado['mensaje']);
                        }
                        elseif($resultado['codigo']=='W0002'){ // La Cédula no está Registrada como madre colaboradora
                            $this->forward('/servicio/colaboradoras/creacion/origen/'.$origen.'/cedula/'.$cedula.'/mensaje/'.$resultado['mensaje']);
                        }
                        elseif($resultado['codigo']=='W0001'){ // Ya está asignada a otro plantel en el periodo activo
                            $this->renderPartial('//msgBox', array('classname'=>'alertDialogBox', 'message'=>$resultado['mensaje']));
                        }
                        else{ // Se han incumplido los parámetros mínimos de validación
                            $this->renderPartial('//msgBox', array('classname'=>'errorDialogBox', 'message'=>$resultado['mensaje']));
                        }

                    }
                    else{
                        $this->renderPartial('//msgBox', array('classname'=>'errorDialogBox', 'message'=>"Ha ocurrido un error en el sistema, comuniquese con el administrador del sistema. Datos del Error: Modulo(planteles.madresColaboradoras.validarAsignacion), Request($origen, $cedula, $idDecoded)."));
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
     *
     * @param int $id Id del Plantel
     *
     * @throws CHttpException
     */
    public function actionRegistroAsignacion($id, $idColab) {

        $idDecoded = $this->getIdDecoded($id);
        $idColabDecoded = $this->getIdDecoded($idColab);

        if(Yii::app()->request->isAjaxRequest){

            $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $idDecoded);

            if($this->hasPost('csrfTokenRegColaboradoras') && $this->validateCsrfToken(false, 'csrfTokenRegColaboradoras')){

                if(is_numeric($idDecoded) && (is_numeric($idColabDecoded) || strlen($idColabDecoded)==0) && $this->hasPost('Colaborador')){

                    if($this->hasPermissionToAsignColaboradoras($estatusAutoridadPlantel)){

                        $colaboradora = null;

                        if(is_numeric($idColabDecoded)){
                            $colaboradora = Colaborador::model()->findByPk($idColabDecoded);
                        }

                        if(!$colaboradora){
                            $colaboradora = new Colaborador();
                        }

                        $colaboradora->attributes = $this->getPost('Colaborador');

                        if($colaboradora->isNewRecord){
                            $colaboradora->beforeSave();
                        }else{
                            $colaboradora->beforeUpdate();
                        }

                        if($colaboradora->validate()){

                            try {

                                $periodoActual = PeriodoEscolar::model()->getPeriodoActivo();

                                if($colaboradora->validate() && $colaboradora->save()){
                                    Yii::app()->user->setFlash('mensajeExitoso', 'Se han registrado exitosamente los datos de la Madre o Padre Colaborador con la C.I. '.$colaboradora->origen.'-'.$colaboradora->cedula.'. Nombre: '.$colaboradora->nombre.' '.$colaboradora->apellido.'. El Número de Documento de Identidad, Nombre, Apellido y Fecha de Nacimiento son datos que no pueden ser editados.');
                                    $ColaboradorPlantel = new ColaboradorPlantel();
                                    $ColaboradorPlantel->colaborador_id = $colaboradora['id'];
                                    $ColaboradorPlantel->periodo_id = $periodoActual['id'];
                                    $ColaboradorPlantel->plantel_id = $idDecoded;
                                    $ColaboradorPlantel->beforeSave();
                                    if($ColaboradorPlantel->validate()){
                                        $modulo = 'planteles.madresColaboradoras.registroAsignacion';
                                        $colaboradorId = $ColaboradorPlantel->colaborador_id;
                                        $plantelId = $ColaboradorPlantel->plantel_id;
                                        $resultado = $ColaboradorPlantel->registrarAsignacion($colaboradorId, $plantelId, $modulo);
                                        // $this->registerLog('ESCRITURA', 'planteles.madresColaboradoras.registroAsignacion', 'SUCCESS', 'Se ha registrado una Madre o Padre Colaborador con la C.I. '.$colaboradora->origen.'-'.$colaboradora->cedula.'. Nombre: '.$colaboradora->nombre.' '.$colaboradora->apellido.'. Banco ID: '.$colaboradora->banco_id.'. Nro. de Cuenta: '.$colaboradora->numero_cuenta.' Al Plantel con el ID:'.$idDecoded.'. En el Periodo: '.$periodoActual['periodo']);
                                        if(is_array($resultado) && count($resultado)>=3){

                                            if($resultado['codigo']=='S0000' || $resultado['codigo']=='S0001'){ // La madre colaboradora cumple con todo lo necesario para ser asignada al plantel indicado
                                                $this->renderPartial('//msgBox', array('classname'=>'successDialogBox', 'message'=>$resultado['mensaje']." Período Escolar {$periodoActual['periodo']}"));
                                            }
                                            else{ // Se han incumplido los parámetros mínimos de validación
                                                $this->renderPartial('//msgBox', array('classname'=>'errorDialogBox', 'message'=>$resultado['mensaje']));
                                            }

                                        }
                                        else{
                                            $this->renderPartial('//msgBox', array('classname'=>'errorDialogBox', 'message'=>"Ha ocurrido un error en el sistema, comuniquese con el administrador del sistema. Datos del Error: Modulo(planteles.madresColaboradoras.registrarAsignacion), Request($idColab, $idDecoded)."));
                                        }
                                    }else{
                                        $this->renderPartial('//errorSumMsg', array('model'=>$ColaboradorPlantel));
                                    }
                                }
                                else{
                                    $this->renderPartial('//errorSumMsg', array('model'=>$colaboradora));
                                    Yii::app()->end();
                                }
                            } catch (Exception $exc) {
                                $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema. Error: <pre>'.$exc->getTraceAsString().'</pre>'));
                                Yii::app()->end();
                            }
                        }
                        else{
                            $this->renderPartial('//errorSumMsg', array('model'=>$colaboradora));
                        }
                    }
                    else{
                        $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Usted no posee permisos para efectuar esta acción en este plantel.'));
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
                $colaboradoras = ColaboradorPlantel::model()->getListaColaboradoresPlantel($idDecoded, $periodoEscolarId);
                if(Yii::app()->request->isAjaxRequest){
                    $this->renderPartial('lista', array('colaboradoras'=>$colaboradoras));
                }
                else{
                    $this->render('lista', array('colaboradoras'=>$colaboradoras));
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

    public function actionDesvincularMadreColaboradora(){

        $plantelId = $this->getPost('pid');
        $colaboradorPlantelId = $this->getPost('id');

        $plantelIdDecoded = $this->getIdDecoded($plantelId);
        $colaboradorPlantelIdDecoded = $this->getIdDecoded($colaboradorPlantelId);

        if(Yii::app()->request->isAjaxRequest){

            if(is_numeric($colaboradorPlantelIdDecoded) && is_numeric($plantelIdDecoded)){

                $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $plantelIdDecoded);

                if($this->hasPermissionToAsignColaboradoras($estatusAutoridadPlantel) && $this->hasPermissionToUnAsignColaboradoras($colaboradorPlantelIdDecoded, $plantelIdDecoded)){

                    $colaboradorPlantel = ColaboradorPlantel::model()->findByPk($colaboradorPlantelIdDecoded);

                    if($colaboradorPlantel){

                        $colaboradorPlantel->estatus = 'E';
                        $colaboradorPlantel->beforeUpdate();

                        if(ColaboradorPlantel::model()->desvincular($colaboradorPlantelIdDecoded, $plantelIdDecoded)){
                            $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La desvinculaci&oacute;n de la Madre Colaboradora se ha efecutuado de forma exitosa.'));
                        }

                    }else{
                        $this->renderPartial('//msgBox', array('class'=>'alertDialogBox', 'message'=>'El colaborador indicado no se ha encontrado en la base de datos. Por favor recargue la p&aacute;gina e intentelo de nuevo.'));
                    }

                }else{
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

            $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $idDecoded);

            if($this->hasPermissionToAsignColaboradoras($estatusAutoridadPlantel)){

                $mes = $this->getPost('mes');
                $anio = $this->getPost('anio');

                if($this->isValidMesAnioAsistencia($mes, $anio)){

                    $diasPlanificados = (int)$this->getCantidadDiasPlanificados($mes, $anio);

                    if($diasPlanificados>0){

                        $periodoEscolar = PeriodoEscolar::model()->getPeriodoActivo();

                        $periodoEscolarId = $periodoEscolar['id'];
                        $plantelId = $idDecoded;

                        $asistenaciaColaboradoras = ColaboradorPlantelAsistencia::model()->getListaColaboradoresPlantelAsistencia($plantelId, $periodoEscolarId, $mes, $anio);

                        if(count($asistenaciaColaboradoras)==0){

                            $colaboradoras = ColaboradorPlantel::model()->getListaColaboradoresPlantel($plantelId, $periodoEscolarId);
                            
                            if(count($colaboradoras)){
                                $this->renderPartial('_listaAsistenciaColaboradoras', array('colaboradoras'=>$colaboradoras, 'mes'=>$mes, 'anio'=>$anio, 'periodoEscolar'=>$periodoEscolar, 'diasPlanificados'=>$diasPlanificados));
                            }
                            else{
                                $this->renderPartial('//msgBox', array('class'=>'alertDialogBox', 'message'=>'No existen colaboradores asignados a este plantel en el período actual.'));
                            }

                        }else{

                            $this->renderPartial('_listaConsultaAsistenciaColaboradoras',  array('colaboradoras'=>$asistenaciaColaboradoras, 'mes'=>$mes, 'anio'=>$anio, 'periodoEscolar'=>$periodoEscolar, 'diasPlanificados'=>$diasPlanificados));

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

        $modulo = 'planteles.madresColaboradoras.registrarAsistencia';

        $idDecoded = $this->getIdDecoded($id); // Plantel ID
        $plantelId = $idDecoded;
        
        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $plantelId);

        if($this->hasPermissionToAsignColaboradoras($estatusAutoridadPlantel)){

            if($this->hasPost('ColaboradorPlantelAsistencia') && is_numeric($plantelId) && $this->hasPost('mes') && $this->hasPost('anio')){
                
                $mes = $this->getPost('mes');
                $anio = $this->getPost('anio');

                if($this->isValidMesAnioAsistencia($mes, $anio)){

                    $diasPlanificados = (int)$this->getCantidadDiasPlanificados($mes, $anio);

                    if($diasPlanificados>0){
                        
                        $periodoEscolar = PeriodoEscolar::model()->getPeriodoActivo();

                        $periodoEscolarId = $periodoEscolar['id'];
                        $periodo = $periodoEscolar['periodo'];
                        $plantelId = $idDecoded;

                        $asistenaciaColaboradoras = ColaboradorPlantelAsistencia::model()->getListaColaboradoresPlantelAsistencia($plantelId, $periodoEscolarId, $mes, $anio);

                        if(count($asistenaciaColaboradoras)==0){

                            $colaboradoras = ColaboradorPlantel::model()->getListaColaboradoresPlantel($plantelId, $periodoEscolarId);
                            
                            if(count($colaboradoras)){
                                
                                $colaborador = $this->getRequest('ColaboradorPlantelAsistencia');
                                
                                foreach ($colaborador AS $c){
                                    if(array_key_exists('colaborador_plantel_id', $c) && array_key_exists('cant_asistencia', $c)){
                                        if(strlen($c['colaborador_plantel_id'])>0 && strlen($c['cant_asistencia'])>0 && is_numeric($c['colaborador_plantel_id']) && is_numeric($c['cant_asistencia'])){
                                            $colaboradorasPlantelId[] = (int)$c['colaborador_plantel_id'];
                                            $cantAsistencias[] = (int)$c['cant_asistencia'];
                                        }
                                    }
                                }

                                if(count($colaboradoras)==count($cantAsistencias)){

                                    $usuarioId = Yii::app()->user->id;
                                    $username = Yii::app()->user->name;
                                    $ip = Utiles::getRealIP();
                                    
                                    list($result, $mensaje, $response) = ColaboradorPlantelAsistencia::model()->registroAsistenciaMadresColaboradoras(
                                            $colaboradorasPlantelId, 
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
                                        $mensaje = "El Registro de Asistencias de Madres y Padres Colaboradores del mes $mesFormat/$anio del Período Escolar $periodo se ha efectuado de forma exitosa.";
                                        $asistenaciaColaboradoras = ColaboradorPlantelAsistencia::model()->getListaColaboradoresPlantelAsistencia($plantelId, $periodoEscolarId, $mes, $anio);
                                        $this->renderPartial('_listaConsultaAsistenciaColaboradoras',  array('colaboradoras'=>$asistenaciaColaboradoras, 'mes'=>$mes, 'anio'=>$anio, 'periodoEscolar'=>$periodoEscolar, 'diasPlanificados'=>$diasPlanificados,'mensaje'=>$mensaje,));
                                    
                                    }
                                    else{
                                        
                                        $exitosos = $response->stats['exitos'];
                                        $observaciones = $response->stats['alertas'];
                                        $errores = $response->stats['errores'];
                                        $mensaje = "No se ha podido realizar por completo el Registro de Asistencia. Existen algunos registros con errores u observaciones. Exitoso: $exitosos. Con Observaciones: $observaciones. Con Errores: $errores.";
                                        $this->renderPartial('_resultRegistroAsistenciaColaboradorasConErrores',  array('colaboradoras'=>$asistenaciaColaboradoras, 'mes'=>$mes, 'anio'=>$anio, 'periodoEscolar'=>$periodoEscolar, 'diasPlanificados'=>$diasPlanificados,'mensaje'=>$mensaje,));
                                        
                                    }
                                                                        
                                }
                                else{
                                    $this->renderPartial('//msgBox', array('class'=>'alertDialogBox', 'message'=>'La cantidad Colaboradoras no Coinciden con la Cantidad de Asistencias a Registrar. Recargue la P&aacute;gina e intentelo de nuevo.'));
                                }
                            }
                            else{
                                $this->renderPartial('//msgBox', array('class'=>'alertDialogBox', 'message'=>'No existen colaboradores asignados a este plantel en el período actual.'));
                            }
                        }else{
                            $this->renderPartial('_listaConsultaAsistenciaColaboradoras',  array('colaboradoras'=>$asistenaciaColaboradoras, 'mes'=>$mes, 'anio'=>$anio, 'periodoEscolar'=>$periodoEscolar, 'diasPlanificados'=>$diasPlanificados));
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
    public function inputAsistenciaMadresColaboradoras($data, $diasPlanificados){
        $columna = '<input type="hidden" value="' . $data['colaborador_plantel_id'] . '" name="ColaboradorPlantelAsistencia[' . $this->contador . '][colaborador_plantel_id]" required="required" />
                    <input type="number" min="0" max="'.$diasPlanificados.'" class="cantAsistenciaColaboradoras" name="ColaboradorPlantelAsistencia[' . $this->contador . '][cant_asistencia]" required="required" />';
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

    public function hasPermissionToAsignColaboradoras($estatusAutoridadPlantel){
        return ($estatusAutoridadPlantel == 'A' && Yii::app()->user->pbac('planteles.madresColaboradoras.write')) || Yii::app()->user->pbac('planteles.madresColaboradoras.admin');
    }

    public function hasPermissionToUnAsignColaboradoras($colaboradorPlantelId, $plantelId){
        $resultado = ColaboradorPlantel::model()->getColaboradorPlantelByPlantel($colaboradorPlantelId, $plantelId);
        return $resultado;
    }

    public function columnaAcciones($data) {

        $colaboradorId = $data["colaborador_id"];
        $colaboradorPlantelId = $data["colaborador_plantel_id"];
        $colaboradorIdEnc = base64_encode($colaboradorId);
        $colaboradorPlantelIdEnc = base64_encode($colaboradorPlantelId);
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in", "title" => "Ver datos", 'href' => '/servicio/colaboradoras/consulta/id/'.$colaboradorIdEnc)) . '&nbsp;&nbsp;';
        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id, $data["plantel_id"]);
        if($this->hasPermissionToAsignColaboradoras($estatusAutoridadPlantel)){
            $columna .= CHtml::link("", "", array("class" => "fa icon-pencil green", "title" => "Editar datos", 'href' => '/servicio/colaboradoras/edicion/id/'.$colaboradorIdEnc)) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", "", array("class" => "fa icon-trash red", "title" => "Desvincular", 'onClick' => 'desvincularMadreColaboradora("'.$colaboradorPlantelIdEnc.'")')) . '&nbsp;&nbsp;';
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

    public function loadModelColaborador($id) {
        $model = Colaborador::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
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
