<?php

class UnidadRespTicketController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    static $_permissionControl = array(
        'read' => 'Consulta de Unidad Responsable de Ticket',
        'write' => 'Gestion de Unidad Responsable de Ticket',
        'label' => 'Módulo de Unidad Responsable de Ticket',
    );

    /**
     * @return array action filters
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
                'actions' => array('index', 'admin', 'create', 'activar', 'view', 'updateUnidad' ,'updateGrupo','crearDistribucion','DeleteGrupo'),
                'pbac' => array('read', 'write',),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('update'),
                'pbac' => array('admin',),
            ),
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
        $this->renderPartial('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCrearDistribucion(){
         $id = Yii::app()->getSession()->get('id');
         $idUnidad=Yii::app()->getSession()->get('id');
        $actualizar=false;
        $model = new DistribucionTicket;
        $estados = Estado::model()->findAll(array('order' => "nombre ASC"));
        $tipoTicket = TipoTicket::model()->findAll(array('order' => "nombre ASC"));
        $unidadResponsable = UnidadRespTicket::model()->findAll(array('order' => "nombre ASC"));
        if (isset($_POST['DistribucionTicket'])){  
        $tipoTicket = TipoTicket::model()->find(array('condition' => 'id = ' . $_REQUEST['tipo'], 'order' => "nombre ASC"));
        $estados = Estado::model()->find(array('condition' => 'id = ' . $_REQUEST['estado'],'order' => "nombre ASC"));
            $tipoSolicitud = ($tipoTicket['nombre']);
            $nombreEstado = ($estados['nombre']);
            $actualizar=true;
            $distribucionTicket = new DistribucionTicket;
            $distribucionTic = array(
                'id' =>Yii::app()->getSession()->get('id'),
                'estado' => $_REQUEST['estado'],
                'tipoTicket' => $_REQUEST['tipo'],
                'telefono' => $_REQUEST['DistribucionTicket']['telefono'],
                'correo' => $_REQUEST['DistribucionTicket']['correo_electronico'],
                'usuarioIni' => Yii::app()->user->id,
                 'fechaIni' => date("Y-m-d H:i:s"),
                 'estatus' => 'A',
            );
             $validacion=DistribucionTicket::model()->buscarDistribucionC($id);
             foreach ($validacion as $row){
                 if($row['estado_id']==$distribucionTic['estado'] and $row['tipo_ticket_id']==$distribucionTic['tipoTicket']){
                 $columna='existe';
             }else{
                $columna='noExiste';  
             }
    }
    if($columna=='existe'){
     $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => "Este tipo de solicitud:".$tipoSolicitud."  ya se encuentra registrado en el estado:".$nombreEstado.""));
    }else{
             
            $validacionDistribucion = $this->validarDistribucion($distribucionTic);
            if($validacionDistribucion==NULL){
               $guardarDistribucion = DistribucionTicket::model()->guardarDistribucion($distribucionTic);
                $this->registerLog('ESCRITURA', 'ayuda.UnidadGrupo.create', 'EXITOSO', 'Se ha creado un grupo de usuario, ahora puede crear otro');
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'El Registro de la distribucion se ha creado con exito'));
                $distribucion = DistribucionTicket::model()->buscarDistribucion($idUnidad);
                $dataProviderDistribucion = $this->dataProviderDistribucion($distribucion);
                //$this->renderPartial('_listadoDistribuciones', array('dataProviderDistribucion'=>$dataProviderDistribucion, 'id'=>$id),false, true);
            }else{
            $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => $validacionDistribucion));
        }
       
        }
            }
     $this->renderPartial('_formDistribucion', array(
            'model' => $model, 'estados' => $estados,
            'tipoTicket' => $tipoTicket, 'unidadResponsable' => $unidadResponsable,
            'actualizar'=>$actualizar
        ));
    
            }



    public function validarDistribucion($distribucionTicket) {
        $mensaje = "";
        if ($distribucionTicket['estado'] == null || trim($distribucionTicket['estado']) == '') {
            $mensaje .= "El campo estado no puede estar vacio <br>";
        }
        if ($distribucionTicket['tipoTicket'] == null || trim($distribucionTicket['tipoTicket']) == '') {
            $mensaje .= "El campo tipo de ticket no puede estar vacio <br>";
        }
        if ($distribucionTicket['telefono'] == null || trim($distribucionTicket['telefono']) == '') {
            $mensaje .= "El campo Telefono no puede estar vacio <br>";
        }
        if ($distribucionTicket['correo'] == null || trim($distribucionTicket['correo']) == '') {
            $mensaje .= "El campo Email no puede estar vacio <br>";
        }
        if ($mensaje == "") {
            return null;
        } else
            return $mensaje;
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new UnidadRespTicket;
        $mensaje = '';
        if (isset($_POST['UnidadRespTicket'])) {
            $model->nombre = $_POST['UnidadRespTicket']['nombre'];
            $model->correo_unidad = $_POST['UnidadRespTicket']['correo_unidad'];
            $model->telefono_unidad = $_POST['UnidadRespTicket']['telefono_unidad'];
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->fecha_ini = date("Y-m-d H:i:s");
            $model->estatus = 'A';
            if ($model->validate()) {
                if ($model->save()) {
                    $mensaje = 1;
                    $unidad_id = $model->id;
                    Yii::app()->getSession()->add('unidad', $model->nombre);
                    Yii::app()->getSession()->add('id', $model->id);
                    $model = $this->loadModel($unidad_id);
                    $id = base64_decode($unidad_id);
                    $this->registerLog('ESCRITURA', 'ayuda.UnidadRespTicket.create', 'EXITOSO', 'Se ha creado un responsable de ticket');
                    $id = base64_encode($model->id);
                    //$model = new UnidadRespTicket;
                    $this->redirect('/ayuda/unidadRespTicket/update/id/' . $id . '', array(
                        'model' => $model, 'mensaje' => $mensaje));
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            }
        }
        $this->render('_form', array(
            'model' => $model, 'mensaje' => $mensaje,

        ));
    }

    public function actionCrearGrupo($id) {
        $id = Yii::app()->getSession()->get('id');
        $columna = 5;
        $model = new UnidadGrupo;
        $grupos = UserGroupsGroup::model()->findAll(array('condition' => "estatus!='Eliminado'", 'order' => "groupname ASC, estatus ASC"));
        if (isset($_POST['grupo'])) {
            $grupo = $_POST['grupo'];
            $resultado = $model->validaGrupoExistenteV(Yii::app()->getSession()->get('id'));
            foreach ($resultado as $data) {
                if ($data['id'] == $_POST['grupo']) {
                    $columna = 0;
                }
            }
            if ($columna == 0) {
                $columna=1;
             $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Este grupo ya posee una unidad responsable'));
                //$this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Este grupo ya posee una unidad responsable'));
            } else {
                $columna=2;
                $guardar = $model->guardarGrupo($grupo, $id);
                $this->registerLog('ESCRITURA', 'ayuda.UnidadGrupo.create', 'EXITOSO', 'Se ha creado un grupo de usuario, ahora puede crear otro');
                $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'El Registro del unidadad responsable de ticket se ha creado con exito'));
                //$this->renderPartial('_listadoGrupos', array('dataProvider'=>$dataProvider, 'id'=>$id,'columna'=>$columna),false, true);
                //$this->renderPartial('_listadoGrupos', array('dataProvider'=>$dataProvider, 'id'=>$id),false, true);
            }
        }
        $this->renderPartial('_formGrupo', array(
            'model' => $model, 'grupos' => $grupos,'columna'=>$columna), false,true);
    }

    public function actionUpdate($id) {
        $mensaje = 1;
        $id = $_REQUEST['id'];
        $id = base64_decode($id);
        $model = $this->loadModel($id);
        $grupos = UnidadGrupo::model()->validaGrupoExistente($id);
        $dataProvider = $this->dataProvider($grupos);
        $distribucion = DistribucionTicket::model()->buscarDistribucion($id);
        $dataProviderDistribucion = $this->dataProviderDistribucion($distribucion);
        if (isset($_POST['UnidadRespTicket'])) {
            $model->attributes = $_POST['UnidadRespTicket'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            if ($model->validate()) {
                if ($model->save()) {
                    Yii::app()->getSession()->add('unidad', $model->nombre);
                    Yii::app()->getSession()->add('id', $model->id);
                    $mensaje = 2;
                    $model = $this->loadModel($id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            }
        }
        $this->render('_form', array(
            'model' => $model, 'mensaje' => $mensaje,'grupos' =>$grupos,
            'dataProvider' =>$dataProvider,'id'=>$id,'dataProviderDistribucion'=>$dataProviderDistribucion), false,true);
    }

    public function actionUpdateUnidad($id) {
        $mensaje = 3;
        $id = $_REQUEST['id'];

        $id = base64_decode($id);
        Yii::app()->getSession()->add('id',$id);
        $model = $this->loadModel($id);
        Yii::app()->getSession()->add('unidad', $model->nombre);
        $grupos = UnidadGrupo::model()->validaGrupoExistente($id);
        $dataProvider = $this->dataProvider($grupos);
        $distribucion = DistribucionTicket::model()->buscarDistribucion($id);
        $dataProviderDistribucion = $this->dataProviderDistribucion($distribucion);
        if (isset($_POST['UnidadRespTicket'])) {
            $model->attributes = $_POST['UnidadRespTicket'];
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            if ($model->validate()) {
                if ($model->save()) {
                    $mensaje = 2;
                    $model = $this->loadModel($id);
                    Yii::app()->getSession()->add('unidad', $model->nombre);
                    Yii::app()->getSession()->add('id', $model->id);
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }
            }
        }
        $this->render('_form', array(
            'model' => $model, 'mensaje' => $mensaje, 'id' => $id, 'dataProvider' => $dataProvider,
           'dataProviderDistribucion' =>$dataProviderDistribucion),false,true);
    }


    public function actionUpdateGrupo($id) {
        $idGrupo = $_REQUEST['id'];
        $id=Yii::app()->getSession()->get('id');
        //Yii::app()->Session()->set('id_grupo',$id);
        //$model = $this->loadModelGrupo($id);
          $model = $this->loadModelGrupo($id);
        $actualizar = 'actualizar';
         $grupos = UserGroupsGroup::model()->findAll(array('condition' => "estatus!='Eliminado'", 'order' => "groupname ASC, estatus ASC"));
       if (isset($_POST['grupo'])) {
            $model->usuario_act_id = Yii::app()->user->id;
            $model->fecha_act = date("Y-m-d H:i:s");
            if ($model->save())
                if ($model->validate()){
                    if ($model->save()){
                        $this->registerLog('ESCRITURA', 'ayuda.DistribucionTicket.create', 'EXITOSO', 'Se ha creado un Instructivo ahora puede crear otro');
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Actualizado con exito.'));
                        $model = $this->loadModel($id);
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }

                  } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
                }

         $this->renderPartial('_formGrupo', array(
            'model'=>$model,'grupos' => $grupos,'actualizar' => $actualizar),false,true);
    }

    public function dataProvider($grupos) {
        $rawData = array();
        $boton = '';
        $usuario_id_signed = Yii::app()->user->id;
        if ($grupos != array()) {
            foreach ($grupos as $key => $value) {
                $boton = '';
                $id = $value['grupo_id'];
                $boton = "<div class='action-buttons center'>" .
                CHtml::link("", "", array("class" => "fa icon-trash red", "title" => "Eliminar Grupo", "onClick" => "VentanaDialogG('$id','/ayuda/unidadRespTicket/deleteGrupo','Eliminar Grupo','borrar')")) . '&nbsp;&nbsp;';
                        "</div>";
                $groupname = "<div class='center'>" . $value['groupname'] . "</div>";
                $nombre = "<div class='center'>" . $value['nombre'] . "</div>";
                $description = "<div class='center'>" . $value['description'] . "</div>";
                $correo_unidad = "<div class='center'>" . $value['correo_unidad'] . "</div>";
                $rawData [] = array(
                    'id' => $key,
                    'groupname' => $groupname,
                    'nombre' => $nombre,
                    'description'=>$description,
                    'correo_unidad'=>$correo_unidad,
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
       public function dataProviderDistribucion($Distribucion) {
        $rawData = array();
        $boton = '';
        $usuario_id_signed = Yii::app()->user->id;
        if ($Distribucion != array()) {
            foreach ($Distribucion as $key => $value) {
                $boton = '';
                $distribucion_id = $value['distribucion_id'];
                $id = $value['id'];
                $boton = "<div class='action-buttons center'>" .
               CHtml::link("", "", array("class" => "fa icon-trash red", "title" => "Eliminar Distribucion", "onClick" => "VentanaDialogD('$distribucion_id','/ayuda/unidadRespTicket/delete','Eliminar Distribución de solicitud','borrar')")) . '&nbsp;&nbsp;';
                        "</div>";
                $telefono = "<div class='center'>" . $value['telefono'] . "</div>";
                $correo_electronico = "<div class='center'>" . $value['correo_electronico'] . "</div>";
                $tipo_ticket = "<div class='center'>" . $value['tipo_ticket'] . "</div>";
                $unidad = "<div class='center'>" . $value['unidad'] . "</div>";
                $estado = "<div class='center'>" . $value['estado'] . "</div>";
                $rawData [] = array(
                    'id' => $key,
                    'telefono' => $telefono,
                    'correo_electronico' => $correo_electronico,
                    'tipo_ticket' => $tipo_ticket,
                    'unidad' => $unidad,
                    'estado' => $estado,
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



    public function actionActivar() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $id = base64_decode($id);
            $model = $this->loadModel($id);
            if ($model) {
                $model->usuario_act_id = Yii::app()->user->id;
                $model->estatus = "A";
                if ($model->save()) {
                    $this->registerLog('ESCRITURA', 'catalogo.UnidadRespTicket.activar', 'EXITOSO', 'Se ha activado una unidad responsable de ticket');
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

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
         if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $model=DistribucionTicket::model()->eliminarDistribucion($id);
                if ($model) {
                    $this->registerLog('ESCRITURA', 'ayuda.UnidadRespTicket.eliminarDistribucion', 'EXITOSO', 'Se ha eliminado una unidad responsable de ticket');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con exito.'));
                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }

        }
    }


     public function actionDeleteGrupo($id) {
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
        $id_unidad = Yii::app()->getSession()->get('id');    
            $model=UnidadGrupo::model()->eliminarGrupo($id);
                if ($model) {
                    $this->registerLog('ESCRITURA', 'ayuda.UnidadRespTicket.borrar', 'EXITOSO', 'Se ha eliminado una unidad responsable de ticket');
                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Eliminado con exito.'));

                } else {
                    throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                }

        }
    }

    public function actionIndex() {
        $groupId = Yii::app()->user->group;
        $model = new UnidadRespTicket('search');
        if (isset($_GET['UnidadRespTicket']))
            $model->attributes = $_GET['UnidadRespTicket'];
        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('UnidadRespTicket');
        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));
    }

    public function columnaAcciones($datas) {
        $id = $datas["id"];
        $id = base64_encode($id);
        $estatus = $datas['estatus'];
        if ($estatus == 'E') {
            $columna = CHtml::link("", "", array("class" => "fa fa-check", "title" => "Activar Istructivo", "onClick" => "VentanaDialog('$id','/ayuda/unidadRespTicket/activar','activar Responsable De Ticket','activar')")) . '&nbsp;&nbsp;';
        } else {
            $columna = CHtml::link("", "", array("class" => "fa fa-search", "title" => "Buscar Responsable de Ticket", "onClick" => "VentanaDialog('$id','/ayuda/unidadRespTicket/view','Vista Responsable De Ticket','view')")) . '&nbsp;&nbsp;';
            $columna .= CHtml::link("", Yii::app()->createUrl("/ayuda/unidadRespTicket/updateUnidad/id/" . $id), array("class" => "fa fa-pencil green", "title" => "Modificar Unidad Responsable")) . '&nbsp;&nbsp;';
        }
        return $columna;
    }

    public function columnaObservacion($registro) {
        $resultado = '';
        $observacion = $registro['descripcion'];
        $resultado = substr($observacion, 0, 30) . '...';
        return $resultado;
    }

    public function estatus($data) {
        $estatus = '';
        $id = $data["estatus"];
        if ($id == 'A') {
            $estatus = 'Activo';
        }
        if ($id == 'E') {
            $estatus = 'Eliminado';
        }
        return $estatus;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UnidadRespTicket the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UnidadRespTicket::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

      public function loadModelGrupo($id) {
        $model = UnidadGrupo::model()->validaGrupoExistente($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UnidadRespTicket $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'unidad-resp-ticket-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}