<?php

/**
 * Clase Controladora de Peticiones del Módulo de Gestión de registro y actualización de datos generales de Padres y Madres Colaboradores.
 *
 * @author José Gabriel González <jgonzalezp@me.gob.ve>
 * @createAt 2014-08-05
 * @updateAt 2014-08-23
 */
class ColaboradorasController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'lista';

    /**
     * @return array action filters
     */
    public static $_permissionControl = array(
        'read' => 'Consulta de Colaboradoras',
        'write' => 'Creación y Modificación de Colaboradoras',
        'admin' => 'Administración Completa de Colaboradoras',
        'label' => 'Módulo de Madres Colaboradoras'
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
                'actions' => array('lista', 'consulta', 'creacion', 'edicion', 'municipiosStandAlone', 'parroquiasStandAlone',),
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

        $model = new Colaborador('search');
        $model->unsetAttributes();  // clear any default values
        if ($this->hasQuery('Colaborador')){
            $model->attributes = $this->getQuery('Colaborador');
        }

        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id);

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
            'dataProviderColaboradores' => $model->search(),
            'estatusAutoridadPlantel' => $estatusAutoridadPlantel
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
            'formType' => 'view'
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreacion($origen=null, $cedula=null, $mensaje=null) {

        $estatusAutoridadPlantel = AutoridadPlantel::model()->buscarAutoridad(Yii::app()->user->id);

        $csrfToken = $this->getCsrfToken('ChavezVive-MadresColaboradoras', 'csrfTokenRegColaboradoras');

        if(self::hasPermissionToAsignColaboradoras($estatusAutoridadPlantel)){

            $model = new Colaborador;

            $redireccionadoSaime = false;
            $submitHide = false;

            if(in_array($origen, array('V', 'E', 'P', 'T')) && is_numeric($cedula)){
                $persona = Saime::busquedaOrigenCedula($origen, $cedula);
                // var_dump($persona);die();
                if($persona){
                    $model->origen = $persona['origen'];
                    $model->origen_titular = $persona['origen'];
                    $model->cedula = $persona['cedula'];
                    $model->cedula_titular = $persona['cedula'];
                    $model->nombre = $persona['nombre'];
                    $model->apellido = $persona['apellido'];
                    $model->nombre_titular = $persona['nombre'].' '.$persona['apellido'];
                    $model->sexo = $persona['sexo'];
                    $model->fecha_nacimiento = $persona['fecha_nacimiento'];
                    $redireccionadoSaime = true;
                    $submitHide = true;
                }
            }

            $estados = CEstado::getData();
            $municipios = array();
            $parroquias = array();
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            $mensajeExitoso = null;

            if ($this->hasPost('Colaborador')) {
                $model->attributes = $this->getPost('Colaborador');
                $model->beforeSave();
                if($model->validate()){
                    try {
                        if($model->save()){
                            Yii::app()->user->setFlash('mensajeExitoso', 'Se ha registrado exitosamente la Madre o Padre Colaborador con la C.I. '.$model->origen.'-'.$model->cedula.'. Nombre: '.$model->nombre.' '.$model->apellido.'. El Número de Documento de Identidad, Nombre, Apellido y Fecha de Nacimiento son datos que no pueden ser editados.');
                            $this->registerLog('ESCRITURA', 'servicio.colaboradoras.creacion', 'SUCCESS', 'Se ha registrado una nueva Madre o Padre Colaborador con la C.I. '.$model->origen.'-'.$model->cedula.'. Nombre: '.$model->nombre.' '.$model->apellido.'. Banco ID: '.$model->banco_id.'. Nro. de Cuenta: '.$model->numero_cuenta);
                            if(Yii::app()->request->isAjaxRequest){
                                $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>'La actualización de los Datos se ha efectuado de forma exitosa.'));
                                Yii::app()->end();
                            }
                            $this->redirect('/servicio/colaboradoras/edicion/id/'.  base64_encode($model->id));
                        }
                        else{
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
                }
                $municipios = CMunicipio::getData('estado_id', $model->estado_id);
                $municipios = (!$municipios)? array(): $municipios;
                $parroquias = CParroquia::getData('municipio_id', $model->municipio_id);
                $parroquias = (!$parroquias)? array(): $parroquias;
            }
            else{
                $this->registerLog('ESCRITURA', 'servicio.colaboradoras.creacion', 'SUCCESS', 'El Usuario ha ingresado al Registro de Madres y Padres Colaboradores');
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
                'bancos' => CBanco::getData(),
                'tiposDeCuenta' => CTipoCuenta::getData(),
                'misiones' => CMision::getData(),
                'gradosInstruccion' => CGradoInstruccion::getData(),
                'origenes' => COrigen::getData(),
                'generos' => CGenero::getData(),
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
        $csrfToken = $this->getCsrfToken('ChavezVive-MadresColaboradoras', 'csrfTokenRegColaboradoras');
        $redireccionadoSaime = false;

        if(self::hasPermissionToAsignColaboradoras($estatusAutoridadPlantel)){

            $planteles = AutoridadPlantel::model()->buscarPlantelAutoridadByUser(Yii::app()->user->id);

            $idDecoded = $this->getIdDecoded($id);
            $model = $this->loadModel($idDecoded, $planteles, $estatusAutoridadPlantel);

            $estados = CEstado::getData();
            $municipios = CMunicipio::getData('estado_id', $model->estado_id);
            $municipios = (!$municipios)? array(): $municipios;
            $parroquias = CParroquia::getData('municipio_id', $model->municipio_id);
            $parroquias = (!$parroquias)? array(): $parroquias;

            $mensajeExitoso = (Yii::app()->user->hasFlash('mensajeExitoso'))?Yii::app()->user->getFlash('mensajeExitoso'):null;

            if ($this->hasPost('Colaborador')) {
                $model->attributes = $this->getPost('Colaborador');
                $model->beforeUpdate();
                if($model->validate()){
                    try {
                        if($model->save()){
                            $mensajeExitoso = 'Los datos se han actualizado de forma exitosa.';
                            $this->registerLog('ACTUALIZACION', 'servicio.colaboradoras.edicion', 'SUCCESS', 'Se han actualizado los datos de la Madre o Padre Colaborador con la C.I. '.$model->origen.'-'.$model->cedula.'. Nombre: '.$model->nombre.' '.$model->apellido.'. Banco ID: '.$model->banco_id.'. Nro. de Cuenta: '.$model->numero_cuenta);
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

            $this->$renderType('update', array(
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


    public function actionMunicipiosStandAlone(){

        if($this->hasPost('Colaborador')){
            $model = new Colaborador();
            $model->attributes = $this->getPost('Colaborador');
            $this->forward($this->createUrl('/ayuda/selectCatastro/municipiosStandalone/estadoId/'.$model->estado_id.'/municipioId/'.$model->municipio_id));
        }
        else{
            throw new CHttpException(400, 'Bad Request');
        }

    }

    public function actionParroquiasStandAlone(){

        if($this->hasPost('Colaborador')){
            $model = new Colaborador();
            $model->attributes = $this->getPost('Colaborador');
            $this->forward($this->createUrl('/ayuda/selectCatastro/parroquiasStandalone/municipioId/'.$model->municipio_id.'/parroquiaId/'.$model->parroquia_id));
        }
        else{
            throw new CHttpException(400, 'Bad Request');
        }

    }

    /**
     * Performs the AJAX validation.
     * @param Colaborador $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'colaborador-form') {
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
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in", "title" => "Ver datos", 'href' => '/servicio/colaboradoras/consulta/id/'.$id)) . '&nbsp;&nbsp;';
        if(self::hasPermissionToAsignColaboradoras($estatusAutoridadPlantel)){
            $columna .= CHtml::link("", "", array("class" => "fa icon-pencil green", "title" => "Editar datos", 'href' => '/servicio/colaboradoras/edicion/id/'.$id)) . '&nbsp;&nbsp;';
        }
        $columna .= '</div>';
        return $columna;
    }

    public static function hasPermissionToAsignColaboradoras($estatusAutoridadPlantel){
        return ($estatusAutoridadPlantel == 'A' && Yii::app()->user->pbac('servicio.colaboradoras.write')) || Yii::app()->user->pbac('servicio.colaboradoras.admin');
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
     * @return Colaborador the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $planteles=null, $estatusAutoridadPlantel=null) {
        $model = null;
        if(!Yii::app()->user->pbac('admin')){ //El permiso Write se debe dar a las autoridades de Zona Educativa
            if(Yii::app()->user->pbac('write') && $estatusAutoridadPlantel=='A'){
                $plantelesArr = Utiles::toArrayUnidimensional($planteles, 'plantel_id');
                if(is_array($plantelesArr) && count($plantelesArr)>0){
                    $model = Colaborador::model()->find(array('condition' => 't.id = :id AND t.plantel_actual_id IN ('.implode(',',$plantelesArr).')', 'params'=>array('id'=>$id)));
                }else{
                    throw new CHttpException(403, 'Usted no posee los permisos necesarios para efectuar esta acción.');
                }
            }
        }else{
            $model = Colaborador::model()->findByPk($id);
        }
        if ($model === null)
            throw new CHttpException(404, 'El registro indicado no ha sido encontrado, o puede que no esté autorizado para efectuar esta acción.');
        return $model;
    }


}
