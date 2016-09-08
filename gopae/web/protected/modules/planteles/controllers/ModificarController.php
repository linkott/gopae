<?php

class ModificarController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Modificación de Planteles (datos PAE)',
        'write' => 'Modificación de Planteles (datos PAE)', // no lleva etiqueta write
        'admin' => 'Modificación de Planteles (datos PAE)',
        'label' => 'Modificación de Planteles'
    );

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
                //'accessControl', // perform access control for CRUD operations
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
                'actions' => array('index', 'view', 'informacion', 'seleccionarMunicipio', 'seleccionarParroquia', 'reporte', '_reportePlantel', 'prueba', '_reportePlantelCE', 'informacionAula', 'insertarIngesta', 'eliminarIngesta', 'accionActivar', 'activarPae', 'modificarPae', 'insertarEquipo', 'eliminarArticulo', 'insertarUtensilio'),
                'pbac' => array('read', 'write'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('write'),
            ),
            /* array('allow', // allow admin user to perform 'admin' and 'delete' actions
              'actions'=>array('admin','delete'),
              'users'=>array('@'),
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

    /**
     * Este metodo es creado para mostrar la consulta
     * de un plantel en especifico.
     * Developed for: Luis Zambrano
     */
    public function action_reportePlantel($id) {
        #$model = new Plantel;
        $this->renderPartial('_reportePlantel', array('model' => $this->loadModel($id)));
    }

    public function action_reportePlantelCE($id) {
        #$model = new Plantel;
        $this->renderPartial('_reportePlantelCE', array('model' => $this->loadModel($id)));
    }

    public function actionInformacion($id) {

        $groupId = Yii::app()->user->group;
        $usuarioId = Yii::app()->user->id;
        $id = base64_decode($id);
        
        
//        var_dump($groupId);die();
        if($groupId == 29){
            $plantel_pae = AutoridadPlantel::model()->findAll(array('condition' => 'plantel_id = ' . $id . ' AND usuario_id = ' . $usuarioId));
            if(!$plantel_pae){
                throw new CHttpException(403, "Usted no tiene permiso para acceder a esta acción.");
            }
        }
        
        list($fechaIniMatricula, $fechaFinMatricula) = $this->getFechasCantMatricula();

        //$u = UserGroups::OPER_ZONA;
        //var_dump($groupId.'-'.UserGroups::COORD_ZONA);die();

        $plantel = new Plantel;

        /* SI ES UNA SECRETARIA */
        if ((UserGroups::OPER_PLANTEL == $groupId)) {
            $resultado = $plantel->identificacionUsuario($usuarioId, $id, 1);
            if ($resultado == 0) {
                throw new CHttpException(403, "Usted no tiene permiso para acceder a esta acción.");
            }
        }
        /* SI ES UN USUARIO DE OPERADOR DE ZONA EDUCATIVA */
        if ((UserGroups::COORD_ZONA == $groupId)) {
            $resultado = $plantel->identificacionUsuario($usuarioId, $id, 2);
            if ($resultado == 0) {
                throw new CHttpException(403, "Usted no tiene permiso para acceder a esta acción.");
            }
        }

        if ((isset($id)) && ($id != '') && (is_numeric($id))) {
            $model = $this->loadModel($id);
            //var_dump($model->modalidad_id);die();
            
            $plantelPae = PlantelPae::model()->findAll(array('condition' => 'plantel_id=' . $id));
//            var_dump($plantelPae);die();
            $modelPlantelPae = new PlantelPae('search');
            if($plantelPae != null){
                $plantel_pae_id = $plantelPae[0]['id'];
                $modelPlantelPae = PlantelPae::model()->findByPk($plantel_pae_id);
            }


            $modelIngesta = new PlantelIngesta('search');
            $modelArticulos = new PlantelPaeArticulo('search');
//            $modelPlantelPae = new PlantelPae('search');
            $modelIngesta->unsetAttributes();
            $modelArticulos->unsetAttributes();
//            $modelPlantelPae->unsetAttributes();

            if ($model) {
                $this->render('informacion', array(
                    'model' => $model,
                    'modelIngesta' => $modelIngesta,
                    'modelArticulos' => $modelArticulos,
                    'modelPlantelPae' => $modelPlantelPae,
                    'fechaIniMatricula' => $fechaIniMatricula,
                    'fechaFinMatricula' => $fechaFinMatricula,
                ));
            } else {
                throw new CHttpException(404, "Recurso no encontrado.");
            }
        } else if (!isset($_REQUEST['Aula']['plantel_id'])) {
            throw new CHttpException(404, "Recurso no encontrado.");
        }
        if ((isset($_REQUEST['Ingesta'])) || (isset($_REQUEST['ajax']))) {
            //$id = $_REQUEST['id'];
            //$plantel_id = base64_decode($id);
            $modelAula = new PlantelIngesta('search');
            $modelAula->unsetAttributes();  // clear any default values
            if (isset($_GET['Ingesta']['plantel_id'])) {
                $modelAula->attributes = $_GET['Aula'];
                $plantel_id = $_REQUEST['Aula']['plantel_id'];
                $modelAula->plantel_id = $plantel_id;
            }
            if (isset($_GET['plantel_id'])) {
                $plantel_id = $_REQUEST['plantel_id'];
                $modelAula->plantel_id = $plantel_id;
            }
            $model = Plantel::model()->findAll(array('condition' => 'id = ' . $plantel_id));
            $this->render('_formAula', array(
                'modelPlantel' => $model,
                'model' => $modelAula,
                'plantel_id' => $plantel_id,
            ));
        }
    }
    
    public function hasPermissionToEditMatricula($modelPlantelPae){
        $result = false;
        $editoMatricula = $modelPlantelPae->edito_matricula;
        list($fechaIniMatricula, $fechaFinMatricula) = $this->getFechasCantMatricula();
        $dateIniMatricula = new Datetime($fechaIniMatricula);
        $dateFinMatricula = new Datetime($fechaFinMatricula);
        $today = new Datetime('2014-09-20');
        
        if($editoMatricula == 'NO' && ($today >= $dateIniMatricula && $today <= $dateFinMatricula)){
            $result = true;
        }
        return $result;
    }
    
    public function getFechasCantMatricula(){
        $modelConfiguracion = Configuracion::model()->getFechasCantMatricula();
        
        $fechaIniMatricula = $modelConfiguracion[0]['valor_date'];
        $fechaFinMatricula = $modelConfiguracion[1]['valor_date'];
        
        return array($fechaIniMatricula, $fechaFinMatricula);
    }

    public function actionSeleccionarMunicipio() {
        $item = $_REQUEST['Plantel']['estado_id'];

        if ($item == '' || $item == NULL) {
            $lista = array('' => '-Seleccione-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $lista = Municipio::model()->findAll('estado_id = :item', array(':item' => $item), array('order' => 'nombre ASC'));
            $lista = CHtml::listData($lista, 'id', 'nombre');

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Seleccione-'), true);

            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }
    }

    public function actionSeleccionarParroquia() {
        $item = $_REQUEST['Plantel']['municipio_id'];

        if ($item == '' || $item == NULL) {
            $lista = array('' => '-Seleccione-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $lista = Parroquia::model()->findAll('municipio_id = :item', array(':item' => $item), array('order' => 'nombre ASC'));
            $lista = CHtml::listData($lista, 'id', 'nombre');

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Seleccione-'), true);

            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        }
    }

    /* FIN DEL MODULO */

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
     * Lists all models.
     */
    public function actionIndex() {

        $model = new Plantel('search');
        
        $groupId = Yii::app()->user->group;
        $usuarioId = Yii::app()->user->id;
        $groupName = Yii::app()->user->groupname;

        /* OBTENGO EL ESTADO_ID DEL USUARIO */
        if ($groupId == 25) {
            $estadoId = $model->estadoId($usuarioId);
        } else {
            $estadoId = '';
        }

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Plantel']))
            $model->attributes = $_GET['Plantel'];

        $this->render('index', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'estadoId' => $estadoId,
            'groupName' => $groupName,
        ));
    }

    public function actionInformacionAula($id) {
        $this->renderPartial('informacionAula', array(
            'model' => $this->loadAula($id),
        ));
    }
    
    public function actionInsertarIngesta(){
        $plantel_id = $_REQUEST['plantel_id'];
        $ingesta_id = $_REQUEST['ingesta_id'];
        $usuario_ini_id = Yii::app()->user->id;
        $fecha_ini = date("Y-m-d H:i:s");
        $estatus = 'A';
        
        $plantelIngesta = PlantelIngesta::model()->findAll(array('condition' => 'plantel_id=' . $plantel_id . ' AND tipo_ingesta_id=' . $ingesta_id));
        $count = count($plantelIngesta);
        
        if($count == 0){
        
            $modelPlantelIngesta = new PlantelIngesta;
            $modelPlantelIngesta->plantel_id = $plantel_id;
            $modelPlantelIngesta->tipo_ingesta_id = $ingesta_id;
            $modelPlantelIngesta->usuario_ini_id = $usuario_ini_id;
            $modelPlantelIngesta->fecha_ini = $fecha_ini;
            $modelPlantelIngesta->estatus = $estatus;
    //        var_dump($modelPlantelIngesta);
            if($modelPlantelIngesta->insert()){
                echo 1;
                $this->registerLog('ESCRITURA', 'modificar.insertarIngesta', 'EXITOSO', 'Inserto una ingesta: ' . $modelPlantelIngesta->tipo_ingesta_id . ' el plantel: ' . $modelPlantelIngesta->plantel_id);
            }
            else{
                echo 0;
            }
        }
        elseif($count > 0){
            echo 1;
        }
    }
    public function actionInsertarEquipo(){
        $plantel_id = $_REQUEST['plantel_id'];
        $articulo_id = $_REQUEST['equipo_id'];
        $usuario_ini_id = Yii::app()->user->id;
        $fecha_ini = date("Y-m-d H:i:s");
        $estatus = 'A';
        
        $plantelEquipo = PlantelPaeArticulo::model()->findAll(array('condition' => 'plantel_id=' . $plantel_id . ' AND articulo_id =' . $articulo_id));
        $count = count($plantelEquipo);
        
        if($count == 0){
        
            $modelPlantelPaeArticulo = new PlantelPaeArticulo;
            $modelPlantelPaeArticulo->plantel_id = $plantel_id;
            $modelPlantelPaeArticulo->articulo_id = $articulo_id;
            $modelPlantelPaeArticulo->tipo_articulo_id = 3;
            $modelPlantelPaeArticulo->usuario_ini_id = $usuario_ini_id;
            $modelPlantelPaeArticulo->fecha_ini = $fecha_ini;
            $modelPlantelPaeArticulo->estatus = $estatus;
    //        var_dump($modelPlantelIngesta);
            if($modelPlantelPaeArticulo->insert()){
                echo 1;
                $this->registerLog('ESCRITURA', 'modificar.insertarEquipo', 'EXITOSO', 'Inserto un equipo: ' . $modelPlantelPaeArticulo->articulo_id . ' el plantel: ' . $modelPlantelPaeArticulo->plantel_id);
            }
            else{
                echo 0;
            }
        }
        elseif($count > 0){
            echo 1;
        }
    }
    public function actionInsertarUtensilio(){
        $plantel_id = $_REQUEST['plantel_id'];
        $articulo_id = $_REQUEST['utensilio_id'];
        $usuario_ini_id = Yii::app()->user->id;
        $fecha_ini = date("Y-m-d H:i:s");
        $estatus = 'A';
        
        $plantelEquipo = PlantelPaeArticulo::model()->findAll(array('condition' => 'plantel_id=' . $plantel_id . ' AND articulo_id =' . $articulo_id));
        $count = count($plantelEquipo);
        
        if($count == 0){
        
            $modelPlantelPaeArticulo = new PlantelPaeArticulo;
            $modelPlantelPaeArticulo->plantel_id = $plantel_id;
            $modelPlantelPaeArticulo->articulo_id = $articulo_id;
            $modelPlantelPaeArticulo->tipo_articulo_id = 2;
            $modelPlantelPaeArticulo->usuario_ini_id = $usuario_ini_id;
            $modelPlantelPaeArticulo->fecha_ini = $fecha_ini;
            $modelPlantelPaeArticulo->estatus = $estatus;
    //        var_dump($modelPlantelIngesta);
            if($modelPlantelPaeArticulo->insert()){
                echo 1;
                $this->registerLog('ESCRITURA', 'modificar.insertarUtensilio', 'EXITOSO', 'Inserto un utensilio: ' . $modelPlantelPaeArticulo->articulo_id . ' el plantel: ' . $modelPlantelPaeArticulo->plantel_id);
            }
            else{
                echo 0;
            }
        }
        elseif($count > 0){
            echo 1;
        }
    }
    
    public function actionAccionActivar(){
        $cambio_pae_activo = 'NO';
        $plantel_id = $_REQUEST['plantel_id'];
        $plantel_pae_id = $_REQUEST['plantel_pae_id'];
        $observacion = $_REQUEST['observacion'];
        $pae_activo = $_REQUEST['cambio_pae_activo'];
        $motivo_inactividad = $_REQUEST['motivo_inactividad'];
        if($pae_activo == 'SI'){
            $pae_activo = 'NO';
            $cambio_pae_activo = 'INACTIVAR';
        }
        else if($pae_activo == 'NO'){
            $pae_activo = 'SI';
            $cambio_pae_activo = 'ACTIVAR';
        }
        $respuesta = PlantelPaeNotificacion::model()->agregarNotificacion($plantel_id, $plantel_pae_id, $observacion, $pae_activo, $cambio_pae_activo, $motivo_inactividad);
        $json['respuesta'] = $respuesta[0];
        $json['fecha_actualizacion'] = date_format(date_create($respuesta[1]), 'd-m-Y H:i:s');
        echo json_encode($json);
    }
    
    public function actionActivarPae(){
        $json = array();
        $plantel_id = $_POST['plantel_id'];
        $posee_simoncito = $_POST['posee_simoncito'];
        $tipo_servicio_pae = $_POST['servicio_pae'];
        $posee_area_cocina = $_POST['posee_area_cocina'];
        $condicion_servicio_id = $_POST['condicion_servicio'];
        $posee_area_produccion_agricola = $_POST['posee_area_produccion_agricola'];
        $hectareas_produccion = $_POST['hectareas_produccion'];
        $matricula_general = $_POST['matricula_general'];
        $matricula_simoncito = $_POST['matricula_simoncito'];
        $modelPlantelPae = PlantelPae::model()->activarPae($plantel_id, $posee_simoncito, $tipo_servicio_pae, $posee_area_cocina, $condicion_servicio_id, $posee_area_produccion_agricola, $hectareas_produccion, $matricula_general, $matricula_simoncito);
        $json['plantel_pae_id'] = $modelPlantelPae[0]['id'];
        $json['plantel_id'] = $modelPlantelPae[0]['plantel_id'];
        $json['pae_activo'] = $modelPlantelPae[0]['pae_activo'];
        $json['edito_matricula'] = $modelPlantelPae[0]['edito_matricula'];
        $json['tipo_servicio'] = $modelPlantelPae[0]['tipo_servicio_pae_id'];
        $json['posee_simoncito'] = $modelPlantelPae[0]['posee_simoncito'];
        $json['fecha_inicio'] = $modelPlantelPae[0]['fecha_inicio'];
        $json['fecha_ultima'] = $modelPlantelPae[0]['fecha_ultima_actualizacion'];
        $json['matricula_general'] = $modelPlantelPae[0]['matricula_general'];
        $json['posee_area_cocina'] = $modelPlantelPae[0]['posee_area_cocina'];
        $json['condicion_servicio'] = $modelPlantelPae[0]['condicion_servicio_id'];
        $json['posee_area_produccion_agricola'] = $modelPlantelPae[0]['posee_area_produccion_agricola'];
        $json['hectareas_produccion'] = $modelPlantelPae[0]['hectareas_produccion'];
        echo json_encode($json);
    }
    
    public function actionModificarPae(){
        $json = array();
        $id = $_POST['id'];
        $plantel_id = $_POST['plantel_id'];
        $edito_matricula = $_POST['edito_matricula'];
        $posee_simoncito = $_POST['posee_simoncito'];
        $tipo_servicio_pae = $_POST['servicio_pae'];
        $posee_area_cocina = $_POST['posee_area_cocina'];
        $condicion_servicio_id = $_POST['condicion_servicio'];
        $posee_area_produccion_agricola = $_POST['posee_area_produccion_agricola'];
        $hectareas_produccion = $_POST['hectareas_produccion'];
        $matricula_general = $_POST['matricula_general'];
        $matricula_simoncito = $_POST['matricula_simoncito'];
        $modelPlantelPae = PlantelPae::model()->modificarPae($id, $plantel_id, $posee_simoncito, $tipo_servicio_pae, $posee_area_cocina, $condicion_servicio_id, $posee_area_produccion_agricola, $hectareas_produccion, $matricula_general, $matricula_simoncito, $edito_matricula);
        $json['plantel_pae_id'] = $modelPlantelPae[0]['id'];
        $json['plantel_id'] = $modelPlantelPae[0]['plantel_id'];
        $json['edito_matricula'] = $modelPlantelPae[0]['edito_matricula'];
        $json['pae_activo'] = $modelPlantelPae[0]['pae_activo'];
        $json['tipo_servicio'] = $modelPlantelPae[0]['tipo_servicio_pae_id'];
//        $json['posee_simoncito'] = $modelPlantelPae[0]['posee_simoncito'];
        $json['fecha_inicio'] = $modelPlantelPae[0]['fecha_inicio'];
        $json['fecha_ultima'] = $modelPlantelPae[0]['fecha_ultima_actualizacion'];
        $json['matricula_general'] = $modelPlantelPae[0]['matricula_general'];
        $json['matricula_simoncito'] = $modelPlantelPae[0]['matricula_simoncito'];
        $json['posee_area_cocina'] = $modelPlantelPae[0]['posee_area_cocina'];
        $json['condicion_servicio'] = $modelPlantelPae[0]['condicion_servicio_id'];
        $json['posee_area_produccion_agricola'] = $modelPlantelPae[0]['posee_area_produccion_agricola'];
        $json['hectareas_produccion'] = $modelPlantelPae[0]['hectareas_produccion'];
        echo json_encode($json);
    }
    
    public function actionEliminarIngesta(){
        $id = $_REQUEST['id'];
        if(is_numeric($id)){
            $id = (int)$id;
            $resultado = PlantelIngesta::model()->eliminarIngesta($id);
            echo $resultado;
            $this->registerLog('ESCRITURA', 'modificar.eliminarIngesta', 'EXITOSO', 'Elimino una ingesta.');
        }
    }
    
    public function actionEliminarArticulo(){
        $id = $_REQUEST['id'];
        if(is_numeric($id)){
            $id = (int)$id;
            $resultado = PlantelPaeArticulo::model()->eliminarEquipo($id);
            echo $resultado;
            $this->registerLog('ESCRITURA', 'modificar.eliminarArticulo', 'EXITOSO', 'Se le elimino un articulo.');
        }
    }

    
    public function columnaAcciones($data) {

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
        if (Yii::app()->user->pbac('planteles.consultar.read'))
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Consultar Datos</span>", Yii::app()->createUrl("/planteles/consultar/informacion/id/" . base64_encode($data->id)), array("class" => "fa fa-search-plus", "title" => "Consultar Datos del Plantel")) . '</li>';
        if (Yii::app()->user->pbac('planteles.modificar.read') || Yii::app()->user->pbac('planteles.modificar.write'))
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Editar Datos</span>", Yii::app()->createUrl("/planteles/modificar/informacion/id/" . base64_encode($data->id)), array("class" => "fa fa-pencil green", "title" => "Editar Datos del Plantel")) . '</li>';
        if (Yii::app()->user->pbac('planificacion.planificacion.read') || (Yii::app()->user->pbac("planificacion.planificacion.write")) || (Yii::app()->user->pbac("planificacion.planificacion.admin")))
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Planificación de Ingestas</span>", Yii::app()->createUrl("/planificacion/planificacion/index/id/" . base64_encode($data->id)), array("class" => "fa fa-cutlery red", "title" => "Planificación de Ingestas")) . '</li>';
        if (Yii::app()->user->pbac('servicio.colaboradoras.read') || (Yii::app()->user->pbac("servicio.colaboradoras.write")) || (Yii::app()->user->pbac("servicio.colaboradoras.admin")))
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Madres Colaboradoras</span>", Yii::app()->createUrl("/planteles/madresColaboradoras/asignadas/id/" . base64_encode($data->id)), array("class" => "fa fa-female purple", "title" => "Colaboradoras")) . '</li>';
        if (Yii::app()->user->pbac('planteles.ordenCompra.read') || (Yii::app()->user->pbac("planteles.ordenCompra.write")) || (Yii::app()->user->pbac("planteles.ordenCompra.admin")))
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Órdenes de Compra</span>", Yii::app()->createUrl("/planteles/ordenCompra/index/id/" . base64_encode($data->id)), array("class" => "fa fa-shopping-cart orange", "title" => "Órdenes de Compra")) . '</li>';
        if (Yii::app()->user->pbac('planteles.proveedorAisgnado.read') || (Yii::app()->user->pbac("planteles.proveedorAisgnado.write")) || (Yii::app()->user->pbac("planteles.proveedorAisgnado.admin")))
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Asignar Proveedor</span>", Yii::app()->createUrl("/planteles/proveedorAsignado/consulta/id/" . base64_encode($data->id)), array("class" => "fa fa-truck red", "title" => "Proveedor Asignado")) . '</li>';
        /* IMPRIMIR DATOS */$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Imprimir Datos</span>", "/planteles/consultar/reporte/id/" . base64_encode($data->id), array("class" => "fa fa-print blue", "title" => "Imprimir Datos del Plantel")) . '</li>';


        $columna .= '</ul></div>';

        return $columna;
    }

    public function columnaAccionesAula($data)
    /*
     * Botones del accion (crear, consultar)
     */ {
        $id = $data["id"];
        $estatus = $data["estatus"];
        $columna = CHtml::link("", "#", array("class" => "fa fa-search", "onClick" => "consultarAula($id,'../')", "title" => "Consultar este aula")) . '&nbsp;&nbsp;';

        return $columna;
    }

    public function columnaAccionesIngesta($data)
    /*
     * Botones del accion (crear, consultar)
     */ {
        $id = $data["id"];
        $estatus = $data["estatus"];
        $columna = CHtml::link("", "", array("class" => "fa fa-trash-o red", "onClick" => "eliminarIngesta($id,'../')", "title" => "Eliminar esta Ingesta"));

        return $columna;
    }

    public function columnaAccionesEquipo($data)
    /*
     * Botones del accion (crear, consultar)
     */ {
        $id = $data["id"];
        $estatus = $data["estatus"];
        $columna = CHtml::link("", "", array("class" => "fa fa-trash-o red", "onClick" => "eliminarEquipo($id,'../')", "title" => "Eliminar este Equipo"));

        return $columna;
    }

    public function columnaAccionesUtensilio($data)
    /*
     * Botones del accion (crear, consultar)
     */ {
        $id = $data["id"];
        $estatus = $data["estatus"];
        $columna = CHtml::link("", "", array("class" => "fa fa-trash-o red", "onClick" => "eliminarUtensilio($id,'../')", "title" => "Eliminar este Utensilio"));

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

    //GENERAR REPORTES EN PDF
    public function actionReporte() {
        if (isset($_GET['id'])) {
            $idPlantel = base64_decode($_GET['id']);
            //var_dump((int)$idPlantel);die();
            if (is_numeric($idPlantel)) {

                $groupName = Yii::app()->user->groupname;
                if (($groupName == 'JCEE-PLANTEL' || $groupName == 'JEFE-DRCEE') || ($groupName == 'root')) {
                    $reporte = '_reportePlantel';
                }/* JEFE O ADMIN */ else if ($groupName == 'CCEE-PLANTEL') {
                    $reporte = '_reportePlantelCE';
                }/* COORDINADOR DE CONTROL DE ESTUDIOS DE PLANTEL */ else if ($groupName == 'COORD-ZONA' || $groupName == 'JEFE-ZONA') {
                    $reporte = '_reportePlantelCE';
                }/* COORDINADOR DE ZONA */ else if ($groupName == 'DIRECTOR') {
                    $reporte = '_reportePlantelD';
                }/* DIRECTOR */ else {
                    $reporte = '_reportePlantelD';
                }
                //var_dump($groupName);die();
                if (isset($idPlantel)) {
                    $plantel = Plantel::model()->findByPk($idPlantel);
                    if ($plantel) {
                        $mPDF = Yii::app()->ePdf->mpdf();
                        $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
                        $mPDF->WriteHTML($this->renderPartial($reporte, array('model' => $plantel), true));
                        $mPDF->Output($plantel->cod_plantel . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
                    }
                } else {
                    $this->redirect(array('consultar/index'));
                }
            } else {
                throw new CHttpException(404, "Recurso no encontrado.");
            }
        } else {
            throw new CHttpException(404, "Recurso no encontrado.");
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Plantel the loaded model
     * @throws CHttpException
     */
    public function loadAula($id) {
        $model = Aula::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'No se ha encontrado el Aula que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
        return $model;
    }

    public function loadModel($id) {
        $model = Plantel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
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

}
