<?php

/**
 * Clase Controladora de Peticiones del Módulo de Gestión de registro y actualización de datos generales de Padres y Madres TalentoHumanoes.
 *
 * @author José Gabriel González <jgonzalezp@me.gob.ve>
 * @createAt 2014-08-05
 * @updateAt 2014-08-23
 */
class TalentoHumanoController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'lista';

    /**
     * @return array action filters
     */
    public static $_permissionControl = array(
        'read' => 'Consulta de Datos del Talento Humano',
        'write' => 'Creación y Modificación de Datos del Talento Humano',
        'admin' => 'Administración Completa de Talento Humano',
        'label' => 'Módulo de Gestión del Talento Humano'
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
                'actions' => array('lista', 'consulta', 'creacion', 'edicion', 'municipiosStandAlone', 'parroquiasStandAlone', 'registroDatosGenerales', 'registroDatosBancarios'),
                'pbac' => array('write', 'admin'),
            ),
            array('allow',
                'actions' => array('lista', 'consulta',),
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

        $model = new TalentoHumano('search');
        $model->unsetAttributes();  // clear any default values
        if ($this->hasQuery('TalentoHumano')){
            $model->attributes = $this->getQuery('TalentoHumano');
            $model->fecha_nacimiento = Utiles::toServerDate($model->fecha_nacimiento);
        }

        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id);
        $tiposDeCargo = TipoCargoNominal::model()->getAllTiposDeCargos();

        if(!Yii::app()->user->pbac('admin')){ //El permiso Write se debe dar a las autoridades de Zona Educativa
            $model->estado_id = Yii::app()->user->estado;
            if(Yii::app()->user->pbac('write') && $estatusAutoridadPlantel=='A'){
                $planteles = AutoridadPlantel::model()->buscarPlantelAutoridadByUser(Yii::app()->user->id);
                $plantelesArr = Utiles::toArrayUnidimensional($planteles, 'plantel_id');
                $model->plantel_actual_id = $plantelesArr;
            }
        }

        $this->render('admin', array(
            'model' => $model,
            'dataProviderTalentoHumano' => $model->search(),
            'estatusAutoridadPlantel' => $estatusAutoridadPlantel,
            'tiposDeCargo' => $tiposDeCargo
        ));
    }

    /**
     * Displays the data model.
     * @param string $id the ID on base64_enconde of the model to be displayed
     */
    public function actionConsulta($id) {

        $idDecoded = base64_decode($id);

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
            'estatus' => CEstatus::getData(),
            'formType' => 'view'
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreacion($origen=null, $cedula=null, $mensaje=null) {

        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id);

        $csrfToken = $this->getCsrfToken('ChavezVive-MadresTalentoHumano', 'csrfTokenRegTalentoHumano');

        if(self::hasPermissionToAsignTalentoHumano($estatusAutoridadPlantel)){

            $model = new TalentoHumano();

            $redireccionadoSaime = false;
            $submitHide = false;

            if(in_array($origen, array('V', 'E', 'P',)) && is_numeric($cedula)){
                $persona = Saime::busquedaOrigenCedula($origen, $cedula);
                if($persona){
                    $model->origen = $persona['origen'];
                    $model->origen_titular = $persona['origen'];
                    $model->cedula = $persona['cedula'];
                    $model->cedula_titular = $persona['cedula'];
                    $model->nombre = $persona['nombre'];
                    $model->apellido = $persona['apellido'];
                    $model->nombre_titular = Utiles::strtoupper_utf8($persona['nombre'].' '.$persona['apellido']);
                    $model->sexo = $persona['sexo'];
                    $model->fecha_nacimiento = $persona['fecha_nacimiento'];
                    $redireccionadoSaime = true;
                    $submitHide = true;
                }
            }
            
            $tiposDeCargo = TipoCargoNominal::model()->findAll();
            $diversidadesFuncionales = CDiversidadFuncional::getData();
            $etnias = CEtnia::getData();
            
            $estados = CEstado::getData();
            $municipios = array();
            $parroquias = array();
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            $mensajeExitoso = null;
            
            if ($this->hasPost('TalentoHumano')) {
                $model->attributes = $this->getPost('TalentoHumano');
                $model->beforeSave();
                if($model->validate()){
                    try {
                        if($model->save()){
                            $mensajeExito = 'Se ha registrado exitosamente el nuevo Talento Humano con la C.I. '.$model->origen.'-'.$model->cedula.'. Nombre: '.$model->nombre.' '.$model->apellido.'. El Número de Documento de Identidad, Nombre, Apellido y Fecha de Nacimiento son datos que no pueden ser editados.';
                            Yii::app()->user->setFlash('mensajeExitoso', $mensajeExito);
                            $this->registerLog('ESCRITURA', 'gestionHumana.talentoHumano.creacion', 'SUCCESS', 'Se ha registrado un nuevo Talento Humano con la C.I. '.$model->origen.'-'.$model->cedula.'. Nombre: '.$model->nombre.' '.$model->apellido.'. '.  json_encode($model->attributes));
                            if(Yii::app()->request->isAjaxRequest){
                                $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>$mensajeExito));
                                Yii::app()->end();
                            }
                            $this->redirect('/gestionHumana/talentoHumano/edicion/id/'.  base64_encode($model->id));
                        }
                        else{
                            ld(CHtml::errorSummary($model));
                            $mensaje = CHtml::errorSummary($model);
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
                        else{
                            $mensaje = $exc->getMessage();
                        }
                    }
                }
                $municipios = CMunicipio::getData('estado_id', $model->estado_id);
                $municipios = (!$municipios)? array(): $municipios;
                $parroquias = CParroquia::getData('municipio_id', $model->municipio_id);
                $parroquias = (!$parroquias)? array(): $parroquias;
            }
            else{
                $mensaje = CHtml::errorSummary($model);
                $this->registerLog('ESCRITURA', 'gestionHumana.talentoHumano.creacion', 'SUCCESS', 'El Usuario ha ingresado al módulo de Registro de un nuevo Talento Humano.');
            }

            $renderType = 'render';
            if(Yii::app()->request->isAjaxRequest){
                $renderType = 'renderPartial';
            }

            $this->$renderType('create', array(
                'model' => $model,
                'estados' => $estados,
                'municipios' => $municipios,
                'parroquias' => $parroquias,
                'tiposDeCargo' => $tiposDeCargo,
                'diversidadesFuncionales' => $diversidadesFuncionales,
                'etnias' => $etnias,
                'bancos' => CBanco::getData(),
                'tiposDeCuenta' => CTipoCuenta::getData(),
                'misiones' => CMision::getData(),
                'gradosInstruccion' => CGradoInstruccion::getData(),
                'origenes' => COrigen::getData(),
                'generos' => CGenero::getData('estatus', 'A'),
                'estatus' => CEstatus::getData(),
                'mensajeExitoso' => $mensajeExitoso,
                'redireccionadoSaime' => $redireccionadoSaime,
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
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdicion($id, $submitHide=false, $mensaje=null) {

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        
        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id);
        $csrfToken = $this->getCsrfToken('ChavezVive-MadresTalentoHumano', 'csrfTokenRegTalentoHumano');
        $redireccionadoSaime = false;

        if(self::hasPermissionToAsignTalentoHumano($estatusAutoridadPlantel)){

            $planteles = AutoridadPlantel::model()->buscarPlantelAutoridadByUser(Yii::app()->user->id);

            $idDecoded = $this->getIdDecoded($id);
            $model = $this->loadModel($idDecoded, $planteles, $estatusAutoridadPlantel);
            $ingresoId = IngresoEmpleado::model()->find('talento_humano_id='.$model->id." ORDER BY id DESC");

            $estados = CEstado::getData();
            $municipios = CMunicipio::getData('estado_id', $model->estado_id);
            $municipios = (!$municipios)? array(): $municipios;
            $parroquias = CParroquia::getData('municipio_id', $model->municipio_id);
            $parroquias = (!$parroquias)? array(): $parroquias;
            
            $tiposDeCargo = TipoCargoNominal::model()->getAllTiposDeCargos();
            $diversidadesFuncionales = CDiversidadFuncional::getData();
            $etnias = CEtnia::getData();
            
            $mensajeExitoso = (Yii::app()->user->hasFlash('mensajeExitoso'))?Yii::app()->user->getFlash('mensajeExitoso'):null;

            if ($this->hasPost('TalentoHumano')) {
                
                $model->attributes = $this->getPost('TalentoHumano');
                $model->beforeUpdate();
                if($model->validate()){
                    try {
                        if($model->save()){
                            $mensajeExitoso = 'Los datos se han actualizado de forma exitosa.';
                            $this->registerLog('ACTUALIZACION', 'gestionHumana.talentoHumano.edicion', 'SUCCESS', 'Se han actualizado los datos de la Madre o Padre TalentoHumano con la C.I. '.$model->origen.'-'.$model->cedula.'. Nombre: '.$model->nombre.' '.$model->apellido.'. Banco ID: '.$model->banco_id.'. Nro. de Cuenta: '.$model->numero_cuenta);
                            if(Yii::app()->request->isAjaxRequest){
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
                            $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema. Error: '.$exc->getTraceAsString()));
                            Yii::app()->end();
                        }
                    }
                }else{
                    if(Yii::app()->request->isAjaxRequest){
                        $this->renderPartial('//errorSumMsg', array('model'=>$model));
                        Yii::app()->end();
                    }
                }
                $municipios = CMunicipio::getData('estado_id', $model->estado_id);
                $municipios = (!$municipios)? array(): $municipios;
                $parroquias = CParroquia::getData('municipio_id', $model->municipio_id);
                $parroquias = (!$parroquias)? array(): $parroquias;
            }

            $renderType = 'render';
            if(Yii::app()->request->isAjaxRequest){
                $renderType = 'renderPartial';
            }
            
            if(strlen($model->nombre_titular)==0){
                $model->nombre_titular = substr(Utiles::strtoupper_utf8($model->nombre.' '.$model->apellido), 0, 40);
            }
            
            $this->$renderType('update', array(
                'model' => $model,
                'ingresoId'=>$ingresoId,
                'estados' => $estados,
                'municipios' => $municipios,
                'parroquias' => $parroquias,
                'tiposDeCargo' => $tiposDeCargo,
                'diversidadesFuncionales' => $diversidadesFuncionales,
                'etnias' => $etnias,
                'bancos' => CBanco::getData(),
                'tiposCuenta' => CTipoCuenta::getData(),
                'misiones' => CMision::getData(),
                'gradosInstruccion' => CGradoInstruccion::getData(),
                'origenes' => COrigen::getData(),
                'generos' => CGenero::getData(),
                'estatus' => CEstatus::getData(),
                'mensajeExitoso' => $mensajeExitoso,
                'redireccionadoSaime' => $redireccionadoSaime,
                'submitHide' => $submitHide,
                'mensaje' => $mensaje,
                'csrfToken' => $csrfToken,
            ));
        }
        else{
            throw new CHttpException(403,'Usted no posee permiso para efectuar esta acción.');
        }
    }
    
    public function actionRegistroDatosGenerales($id){
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id);

        if(Yii::app()->request->isAjaxRequest){

            if(self::hasPermissionToAsignTalentoHumano($estatusAutoridadPlantel)){

                $idDecoded = $this->getIdDecoded($id);
                $model = $this->loadModel($idDecoded);
                
                // INI: Data que no debe ser modificada en la edición de los DATOS
                $nombre = $model->nombre;
                $apellido = $model->apellido;
                $fecha_nacimiento = $model->fecha_nacimiento;
                $sexo = $model->sexo;
                $cedula = $model->cedula;
                $origen = $model->origen;
                // FIN: Data que no debe ser modificada en la edición de los DATOS
                
                if ($this->hasPost('TalentoHumano')) {
                    $model->attributes = $this->getPost('TalentoHumano');

                    // INI: Data que no debe ser modificada en la edición de los DATOS
                    $model->nombre = $nombre;
                    $model->apellido = $apellido;
                    $model->fecha_nacimiento = $fecha_nacimiento;
                    $model->sexo = $sexo;
                    $model->cedula = $cedula;
                    $model->origen = $origen;
                    $model->beforeUpdate();
                    // FIN: Data que no debe ser modificada en la edición de los DATOS

                    if($model->validate()){
                        try {
                            if($model->save()){
                                $this->registerLog('ACTUALIZACION', 'gestionHumana.talentoHumano.regstroDatosGenerales', 'SUCCESS', 'Se han registrado/actualizado los Datos Generales del Talento Humano con la C.I. '.$model->origen.'-'.$model->cedula.'. Nombre: '.$model->nombre.' '.$model->apellido.'. DATA: '.  json_encode($model->attributes));
                                $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'Los Datos Generales del Talento Humano se han actualizado de forma exitosa.'));
                                Yii::app()->end();
                            }else{
                                if(Yii::app()->request->isAjaxRequest){
                                    $this->renderPartial('//errorSumMsg', array('model'=>$model));
                                    Yii::app()->end();
                                }
                            }
                        }
                        catch (Exception $exc) {
                            $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema. Error: '.$exc->getTraceAsString()));
                            Yii::app()->end();
                        }
                    }else{
                        $this->renderPartial('//errorSumMsg', array('model'=>$model));
                        Yii::app()->end();
                    }
                }
                else{
                    throw new CHttpException(401,'No se han proporcionado los datos necesarios para efectuar esta acción.');
                }
            }
            else{
                throw new CHttpException(403,'Usted no posee permiso para efectuar esta acción.');
            }
        }    
        else{
            throw new CHttpException(403,'No está permitido efectuar esta acción mediante esta vía.');
        }
    }
    
    public function actionRegistroDatosBancarios($id){
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id);

        if(Yii::app()->request->isAjaxRequest){

            if(self::hasPermissionToAsignTalentoHumano($estatusAutoridadPlantel)){

                $idDecoded = $this->getIdDecoded($id);
                $model = $this->loadModel($idDecoded);
                $model->scenario = 'formDatosBancarios';
                if ($this->hasPost('TalentoHumano')) {
                    $model->attributes = $this->getPost('TalentoHumano');
                    $model->beforeUpdate();
                    if($model->validate()){
                        try {
                            if($model->save()){
                                $mensajeExitoso = 'Los datos se han actualizado de forma exitosa.';
                                $this->registerLog('ACTUALIZACION', 'gestionHumana.talentoHumano.regstroDatosBancarios', 'SUCCESS', 'Se han registrado/actualizado los Datos Bancarios del Talento Humano con la C.I. '.$model->origen.'-'.$model->cedula.'. Nombre: '.$model->nombre.' '.$model->apellido.'. Banco ID: '.$model->banco_id.'. Nro. de Cuenta: '.$model->numero_cuenta.'. DATA: '.  json_encode($model->attributes));
                                $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'Los Datos Bancarios se han actualizado de forma exitosa.'));
                                Yii::app()->end();
                            }else{
                                if(Yii::app()->request->isAjaxRequest){
                                    $this->renderPartial('//errorSumMsg', array('model'=>$model));
                                    Yii::app()->end();
                                }
                            }
                        }
                        catch (Exception $exc) {
                            $this->renderPartial('//msgBox', array('class'=>'errorDialogBox', 'message'=>'Ha ocurrido un error en el proceso. Comuniquese con el administrador del sistema. Error: '.$exc->getTraceAsString()));
                            Yii::app()->end();
                        }
                    }else{
                        $this->renderPartial('//errorSumMsg', array('model'=>$model));
                        Yii::app()->end();
                    }
                }
                else{
                    throw new CHttpException(401,'No se han proporcionado los datos necesarios para efectuar esta acción.');
                }
            }
            else{
                throw new CHttpException(403,'Usted no posee permiso para efectuar esta acción.');
            }
        }    
        else{
            throw new CHttpException(403,'No está permitido efectuar esta acción mediante esta vía.');
        }
    }


    public function actionMunicipiosStandAlone(){

        if($this->hasPost('TalentoHumano')){
            $model = new TalentoHumano();
            $model->attributes = $this->getPost('TalentoHumano');
            $this->forward($this->createUrl('/ayuda/selectCatastro/municipiosStandalone/estadoId/'.$model->estado_id.'/municipioId/'.$model->municipio_id));
        }
        else{
            throw new CHttpException(400, 'Bad Request');
        }

    }

    public function actionParroquiasStandAlone(){

        if($this->hasPost('TalentoHumano')){
            $model = new TalentoHumano();
            $model->attributes = $this->getPost('TalentoHumano');
            $this->forward($this->createUrl('/ayuda/selectCatastro/parroquiasStandalone/municipioId/'.$model->municipio_id.'/parroquiaId/'.$model->parroquia_id));
        }
        else{
            throw new CHttpException(400, 'Bad Request');
        }

    }

    /**
     * Performs the AJAX validation.
     * @param TalentoHumano $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'talentoHumano-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function fechaNacimiento($data) {
        $fechaNac = trim($data["fecha_nacimiento"]);
        $fechaVacia = empty($fechaNac);
        if ($fechaVacia) {
            $fechaNac = "";
        } else {
            $fechaNac = date("d-m-Y", strtotime($fechaNac));
        }
        return $fechaNac;
    }

    public function sexo($data){
        $sexo = trim($data['sexo']);
        $sexoVacio = empty($sexo);
        if(!$sexoVacio){
            $sexo = strtr($sexo, array('F'=>'Femenino', 'M'=>'Masculino'));
        }
        return $sexo;
    }

    public function listaDeSexos() {
        $sexos = array();
        $sexos[] = array('id' => 'F', 'nombre' => 'Femenino');
        $sexos[] = array('id' => 'M', 'nombre' => 'Masculino');
        return $sexos;
    }

    public function columnaAcciones($data, $estatusAutoridadPlantel=null) {

        $id_encoded = $data["id"];
        $id = base64_encode($id_encoded);
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in", "title" => "Ver datos", 'href' => '/gestionHumana/talentoHumano/consulta/id/'.$id)) . '&nbsp;&nbsp;';
        if(self::hasPermissionToAsignTalentoHumano($estatusAutoridadPlantel)){
            $columna .= CHtml::link("", "", array("class" => "fa icon-pencil green", "title" => "Editar datos", 'href' => '/gestionHumana/talentoHumano/edicion/id/'.$id)) . '&nbsp;&nbsp;';
        }
        $columna .= '</div>';
        return $columna;
    }

    public static function hasPermissionToAsignTalentoHumano($estatusAutoridadPlantel){
        return ($estatusAutoridadPlantel == 'A' && Yii::app()->user->pbac('gestionHumana.talentoHumano.write')) || Yii::app()->user->pbac('gestionHumana.talentoHumano.admin');
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
     * @return TalentoHumano the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $planteles=null, $estatusAutoridadPlantel=null) {
        $model = null;
        if(!Yii::app()->user->pbac('admin')){ //El permiso Write se debe dar a las autoridades de Zona Educativa
            if(Yii::app()->user->pbac('write') && $estatusAutoridadPlantel=='A'){
                $plantelesArr = Utiles::toArrayUnidimensional($planteles, 'plantel_id');
                if(is_array($plantelesArr) && count($plantelesArr)>0){
                    $model = TalentoHumano::model()->find(array('condition' => 't.id = :id AND t.plantel_actual_id IN ('.implode(',',$plantelesArr).')', 'params'=>array('id'=>$id)));
                }
                else{
                    throw new CHttpException(403, 'Usted no posee los permisos necesarios para efectuar esta acción.');
                }
            }
        }else{
            $model = TalentoHumano::model()->findByPk($id);
        }
        if ($model === null)
            throw new CHttpException(404, 'El registro indicado no ha sido encontrado, o puede que no esté autorizado para efectuar esta acción.');
        return $model;
    }


}
