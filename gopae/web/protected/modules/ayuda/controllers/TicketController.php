<?php

class TicketController extends Controller {

    const NUEVO_USUARIO = 1;
    const ERROR_SISTEMA = 2;
    const RESET_CLAVE = 3;
    CONST SOLICITUD_OTRA = 6;
    const NUEVO_PLANTEL = 5;
    const PLANTEL_INACTIVO = 7;
    const COCINERA_ESCOLAR_NO_PRESENTE=8;

    const ASIGNACION_NIVELES=9;
    const A_ACTIVO = 'A';
    const A_RESUELTO = 'S';
    const A_DEVUELTO = 'D';
    const A_REDIRECCIONADO = 'R';
    const A_ASIGNADO = 'P';
    const A_REVISION = 'C';

    static $_permissionControl = array(
        'read' => 'Consulta de Ticket',
        'write' => 'Registrar de Ticket',
        'admin' => 'Atender de Ticket',
        'label' => 'Módulo de Apertura de Ticket'
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
                'actions' => array('index', 'admin', 'create', 'activar', 'formularios', 'upload', 'view', 'guardarArchivo', 'exportar', 'exportarTodo','exportarFiltro'),
                'pbac' => array('read', 'write',),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'admin', 'create', 'activar', 'formularios', 'upload', 'view', 'guardarArchivo', 'exportar', 'exportarTodo','exportarFiltro'),
                'pbac' => array('admin',),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('update'),
                'pbac' => array('admin', 'write',),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id) {
        $idDecoded = base64_decode($id);
        if (is_numeric($idDecoded)) {
            $model = $this->loadModel($idDecoded);
            if ($model->tipo_ticket_id == self::NUEVO_USUARIO) {
                $this->renderPartial('view_solicitud_nuevo_usuario', array(
                    'model' => $model,
                ));
                return 0;
            } else if ($model->tipo_ticket_id == self::RESET_CLAVE) {
                $this->renderPartial('view_solicitud_reseteo_clave', array(
                    'model' => $model,
                ));
                return 0;
            } else if ($model->tipo_ticket_id == self::NUEVO_PLANTEL || $model->tipo_ticket_id == self::PLANTEL_INACTIVO) {
                $this->renderPartial('view_nuevo_plantel', array(
                    'model' => $model,
                ));
                return 0;
            } else if ($model->tipo_ticket_id == self::ERROR_SISTEMA) {
                $this->renderPartial('view_error_sistema', array(
                    'model' => $model,
                ));
                return 0;
            } else if ($model->tipo_ticket_id == self::SOLICITUD_OTRA) {
                $this->renderPartial('view_otra_solicitud', array(
                    'model' => $model,
                ));
                return 0;
            }else if($model->tipo_ticket_id==self::COCINERA_ESCOLAR_NO_PRESENTE){
                $this->renderPartial('view_cocinera_escolar_no_presente', array(
                    'model' => $model,
                ));
                return 0;
            }else if($model->tipo_ticket_id==self::ASIGNACION_NIVELES){
                $this->renderPartial('view_asignacion_niveles_plan', array(
                    'model' => $model,
                ));
                return 0;
            }
        } else {
            throw new CHttpException(404, 'Recurso no encontrado. Recargue la página e intentelo de nuevo.');
        }
    }

    public function actionIndex() {
        $groupId = Yii::app()->user->group;
        $model = new Ticket('search');
        if (!Yii::app()->user->pbac('admin')) {
            $model->usuario_ini_id = Yii::app()->user->id;
        }
        if (isset($_GET['Ticket'])) {
            $model->attributes = $_GET['Ticket'];
        } else {
            $model->estatus = '';
        }
        $usuarioId = Yii::app()->user->id;
        $dataProvider = new CActiveDataProvider('Ticket');

        // var_dump(Yii::app()->user->unidadesResp);
        // var_dump(Yii::app()->session->get('unidadesResp'));

        $this->render('admin', array(
            'model' => $model,
            'groupId' => $groupId,
            'usuarioId' => $usuarioId,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $id = $this->getQuery('id');
        if (is_null($id) or ! is_numeric($id) or strlen($id) == 0) {
            $model = new Ticket();
            $this->renderPartial('create', array(
                'model' => $model,
            ));
        }
        //Funcion para solicitud de nuevo usuario
        elseif ((int) $id == self::NUEVO_USUARIO) {
            $this->solicitudNuevoUsuario();
        }
        //Funcion registro de nuevo plantel
        elseif ((int) $id == self::NUEVO_PLANTEL || (int) $id == self::PLANTEL_INACTIVO) {
            $this->solicitudResgistroPlantel();
        }
        //Funcion reseteo de clave
        elseif ((int) $id == self::RESET_CLAVE) {
            $this->solicitudReseteoClave();
        }
        //Funcion error en el sistema
        elseif ((int) $id == self::ERROR_SISTEMA) {
            $this->errorSistema();
        }elseif((int) $id== self::COCINERA_ESCOLAR_NO_PRESENTE){
            $this->cocineraEscolarNoPresente();
        }elseif((int) $id==self::ASIGNACION_NIVELES){
            $this->asignacion_planes_niveles();
        }
        //Otra Solicitud
        else {
            $this->otraSolicitud();
            //$this->enviarMensaje();
        }
    }

    public function actionUpdate() {
        $groupId = Yii::app()->user->group;
        $id = base64_decode($this->getRequest('id'));
        $error = '';
         $model = $this->loadModel($id);
        // Validacion de grupos de usuarios ADMIN_REG_CONTROL y JEFE_DRCEE
        $unidades_responsables = UnidadRespTicket::model()->findAll('id != :id', array(':id' => $model->bandeja_actual_id));
        // no puede volver a colocar un ticket como activo cuando se supone que lo voy a atender.
        $estatusTicket = EstatusTicket::model()->findAll(array('condition' => "nombre!='Activo'", 'order' => "nombre ASC, estatus ASC"));
        if ($this->getPost('oper') == 'update'){
            if (isset($_POST['atencion']) && strlen($_POST['atencion']) > 5) {
                if (isset($_POST['estatus_ticket']) && in_array($_POST['estatus_ticket'], array(1, 2, 3, 4, 5, 6, 7, 8, 9))) {
                    $model->estatus_ticket_id = $_POST['estatus_ticket'];
                    $estatusTicket = EstatusTicket::model()->find(array('condition' => 'id = ' . $model->estatus_ticket_id));
                    $estatusDescripcion = ($estatusTicket['nombre']);
                    if ($estatusDescripcion == "Activo") {
                        $estatus = self::A_ASIGNADO;
                    } elseif ($estatusDescripcion == "Eliminado") {
                        $estatus = "E";
                    } elseif ($estatusDescripcion == "Resuelto") {
                        $estatus = self::A_RESUELTO;
                    } elseif ($estatusDescripcion == "Devuelto") {
                        $estatus = self::A_DEVUELTO;
                    } elseif ($estatusDescripcion == "Redireccionado") {
                        $estatus = self::A_REDIRECCIONADO;
                    } elseif ($estatusDescripcion == "Asignado") {
                        $estatus = self::A_ASIGNADO;
                    }
                    if (($estatus == self::A_REDIRECCIONADO && is_numeric($this->getPost('att_unidad_responsable'))) || ($estatus == self::A_ASIGNADO && is_numeric($this->getPost('att_responsable_asignado'))) || ($estatus != self::A_ASIGNADO && $estatus != self::A_REDIRECCIONADO)) {
                        $unidadRespObj = null;
                        $asignadoObj = null;
                        if ($estatus == self::A_REDIRECCIONADO && is_numeric($this->getPost('att_unidad_responsable'))) {
                            $unidadRespObj = UnidadRespTicket::model()->find(' id = :id', array(':id' => $this->getPost('att_unidad_responsable')));
                        }
                        if ($estatus == self::A_ASIGNADO && is_numeric($this->getPost('att_responsable_asignado'))) {
                            $asignadoObj = UserGroupsUser::model()->find(' id = :id', array(':id' => $this->getPost('att_responsable_asignado')));
                        }
                        if (($estatus == self::A_REDIRECCIONADO && is_object($unidadRespObj)) || ($estatus == self::A_ASIGNADO && is_object($asignadoObj)) || ($estatus != self::A_ASIGNADO && $estatus != self::A_REDIRECCIONADO)) {
                            if ($estatus == self::A_DEVUELTO) {
                                $model->responsable_asignado_id = $model->usuario_ini_id;
                            }
                            $bandejaActualId = $model->bandeja_actual_id;
                            $model->estatus = $estatus;
                            $observacion = trim($_POST['atencion']);
                            $model->usuario_act_id = Yii::app()->user->id;
                            //var_dump("voy por aqui".$model->usuarioAct->email); die();
                            $model->fecha_act = date("Y-m-d H:i:s");
                            $model->observacion .= date("d-m-Y H:i:s") . ' (' . $estatusDescripcion . ') | ' . $observacion . "\n";
                            if ($estatus == self::A_REDIRECCIONADO && $this->getPost('att_unidad_responsable') != $bandejaActualId) {
                                $model->bandeja_anterior_id = $bandejaActualId;
                                $model->bandeja_actual_id = $this->getPost('att_unidad_responsable');
                                $model->observacion .= date("d-m-Y H:i:s") . ' (' . $estatusDescripcion . ') (' . $unidadRespObj->nombre . ') | ' . $observacion . "\n";
                            }
                            if ($estatus == self::A_ASIGNADO && is_numeric($this->getPost('att_responsable_asignado'))) {
                                $model->responsable_asignado_id = $this->getPost('att_responsable_asignado');
                                $model->observacion .= date("d-m-Y H:i:s") . ' (' . $estatusDescripcion . ') (' . $model->bandejaActual->nombre . ') (' . $asignadoObj->cedula . ') | ' . $observacion . "\n";
                            }

                            $unidadesResp = $this->getIdsUnidadesResponsables();

                            if (!is_null($unidadesResp) && (in_array($model->bandeja_actual_id, $unidadesResp) or ( Yii::app()->user->id == $model->responsable_asignado_id) or in_array(Yii::app()->user->group, array(UserGroups::JEFE_DRCEE, UserGroups::ADMIN_DRCEE, UserGroups::COORD_ATENCIONTELEFONICA, UserGroups::DESARROLLADOR, UserGroups::root))) || in_array(Yii::app()->user->group, array(UserGroups::DESARROLLADOR, UserGroups::root, UserGroups::COORD_ATENCIONTELEFONICA))) {
                                if ($model->validate()) {
                                    if ($model->save()) {
                                        $enviarCorreo = $this->enviarMensaje();
                                        $this->registerLog('ESCRITURA', 'ayuda.Ticket.update', 'EXITOSO', 'Se ha atendió un ticket ID: ' . $id);
                                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'El Ticket Nro. ' . $model->codigo . ' ha cambiado de Estatus a ' . $estatusDescripcion . ' de forma exitosa.'));
                                        $model = $this->loadModel($id);
                                    } else {
                                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                                    }
                                } else {
                                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                                }
                            } else {
                                $this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => 'Uste no se encuentra autorizado para la atención de este ticket ya que el mismo se encuentra en la unidad de ' . $model->bandejaAnterior->nombre));
                            }
                        } else {
                            $this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => 'Parece que un dato seleccionado no se ha encontrado registrado en nuestra base de datos. Debe tener en cuenta que si está "Redireccionando" el ticket debe seleccionar el la Unidad a la que lo redirige y si está "Asignando" el ticket para su solución debe seleccionar a la persona asignada.'));
                        }
                    } else {
                        $this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para efectuar la operación. Debe tener en cuenta que si está "Redireccionando" el ticket debe seleccionar el la Unidad a la que lo redirige y si está "Asignando" el ticket para su solución debe seleccionar a la persona asignada.'));
                    }
                } else {
                    $this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => 'Debe seleccionar el estatus al que va cambiar la solicitud.'));
                }
            } else {
                $this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => 'Debe indicar de forma detallada la observación para atención del ticket. (Más de 5 Caracteres)'));
            }
        } else {
            if ($this->getPost('tipo-formulario') != 'atencion-ticket' || ($this->hasPost('atencion') && $this->getPost('atencion') === null)){
                $this->renderPartial('atender_ticket', array(
                    'model' => $model, 'estatusTicket' => $estatusTicket, 'error' => $error, 'unidad_responsables' => $unidades_responsables,
                ));
            }
        }
    }

    public function actionActivar() {
        if (isset($_POST['id'])) {
            if (isset($_POST['observacion']) && strlen($_POST['observacion']) >= 5) {
                $observacion = $_POST['observacion'];
                $id = $_POST['id'];
                $id = base64_decode($id);
                $model = $this->loadModel($id);
                if ($model) {
                    $usuario_ini_id = $model->usuario_ini_id;
                    if (Yii::app()->user->pbac('admin') || $usuario_ini_id == Yii::app()->user->id) {
                        $estatus = self::A_ACTIVO;
                        $model->estatus_ticket_id = 1;
                        $model->observacion .= date("d-m-Y H:i:s") . " (Reactivado) | " . $observacion . "\n";
                        $model->usuario_act_id = Yii::app()->user->id;
                        $model->fecha_elim = date("Y-m-d H:i:s");
                        $model->estatus = $estatus;
                        if ($model->save()) {
                            $this->registerLog('ESCRITURA', 'ayuda.ticket.activar', 'EXITOSO', 'Reactivación de Ticket' . '. Observación: ' . $observacion);
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Reactivado con éxito.'));
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        throw new CHttpException(403, 'Error! Usted no se encuentra autorizado para efectuar esta operación.');
                    }
                } else {
                    throw new CHttpException(404, 'Error! Recurso no encontrado.');
                }
            } else {
                $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Debe indicar el motivo de la reactivación del ticket. Al menos 5 carcateres.'));
            }
        }
    }

    public function actionUpload() {
//        $options = null, $initialize = true, $error_messages = null, $filename=null, $id_model=''
        $upload_handler = new UploadHandler(null, true, null, date('YmdHis') . 'AT', "/public/uploads/ticket/");
    }

    //funcion para guardar archivos
    public function actionGuardarArchivo() {
        $id = $_POST["id"];
        $model = new Ticket;
        $model->ruta = "/public/uploads/ticket/" . $id;
        $model->nombre = $_POST["nombreBD"];
        $model->fundamento_juridico_id = $_POST["fundamento_id"];
        $model->usuario_ini_id = Yii::app()->user->id;
        $model->fecha_ini = date("Y-m-d H:i:s");
        if ($model->save()) {
            $this->registerLog(
                    "ESCRITURA", "guardarArchivo", "Exitoso", "Se creo un archivo relacionado a un fundamento Juridico con el id" . $id, Yii::app()->request->userHostAddress, Yii::app()->user->id, date("Y-m-d H:i:s")
            );
            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Exito! ya puede subir otro archivo'));
        }
    }

    public function columnaObservacion($registro) {
        $resultado = '';
        $observacion = $registro['observacion'];
        $arrayObservacion = explode("\n", $observacion);
        if (isset($arrayObservacion[0])) {
            $primeraLinea = $arrayObservacion[0];
            $arrayPrimeraLinea = explode(' | ', $primeraLinea);
            if (isset($arrayPrimeraLinea[1])) {
                $resultado = substr($arrayPrimeraLinea[1], 0, 30) . '...';
            }
        }
        return $resultado;
    }

    public function fechaIni($data) {
        $fecha_Ini = $data["fecha_ini"];
        if (empty($fecha_Ini)) {
            $fecha_Ini = "";
        } else {
            $fecha_Ini = date("d-m-Y", strtotime($fecha_Ini));
        }
        return $fecha_Ini;
    }

    public function actionFormularios() {
        $model = new Ticket;
        $id = $_POST["id"];
        $modelArchivo = new ArchivoFundamentoJuridico;
        if ($id == self::NUEVO_USUARIO) {
            $grupos = UserGroupsGroup::model()->findAll(array('condition' => "estatus = 'A' AND groupname NOT IN ('ADMIN-USUARIOS', 'ADMIN-PLANTELES', 'ADMIN-CONFIG', 'root')", 'order' => "description ASC, groupname ASC"));
            $estados = Estado::model()->findAll(array('order' => "nombre ASC"));
            $this->renderPartial('form_solicitud_nuevo_usuario', array('estados' => $estados, 'model' => $model, 'grupos' => $grupos,));
        } else if ($id == self::ERROR_SISTEMA) {
            $this->renderPartial('form_error_sistema', array('model' => $model, 'modelArchivo' => $modelArchivo));
        } else if ($id == self:: RESET_CLAVE) {
            $this->renderPartial('form_reseteo_clave');
        } else if ($id == self::NUEVO_PLANTEL || $id == self::PLANTEL_INACTIVO) {
            $zonas_educativas = NULL;
            //$zonas_educativas = ZonaEducativa::model()->findAll(array('condition' => "estatus='A'", 'order' => "nombre ASC"));
            $dependencias = TipoDependencia::model()->findAll(array('condition' => "estatus='A'", 'order' => "nombre ASC"));
            $this->renderPartial('form_solicitud_registro_plantel', array('model' => $model, 'zonas_educativas' => $zonas_educativas, 'dependencias' => $dependencias,));
        } else if ($id == self::SOLICITUD_OTRA) {
            $this->renderPartial('form_otra_solicitud', array('model' => $model, 'modelArchivo' => $modelArchivo));
        }else if($id== self::COCINERA_ESCOLAR_NO_PRESENTE){
            $this->renderPartial('form_cocinera_escolar_no_presente', array('model' => $model, 'tipoTicketId'=>$id, 'accion'=>'create'));
        }else if($id==self::ASIGNACION_NIVELES){
           $this->renderPartial('form_asignacion_niveles_planes', array('model' => $model));
        } else {
            $this->renderPartial('form_asignacion_niveles_planes', array('model' => $model));
        }
    }

    public function actionExportar() {
        $id = $_GET['id'];
        $id = base64_decode($id);
        $ticket = $this->loadModel($id);
        $model = new TipoTicket;
        $resultado = $model->nombre($id);
        foreach ($resultado as $r) {
            if ($r['id'] == self::NUEVO_USUARIO) {
                $consulta = TipoTicket::model()->findByPk($id);
                $mPDF = Yii::app()->ePdf->mpdf('', 'A4', 0, '', 15, 15, 16, 16, 9, 9, 'M');
                $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
                $mPDF->WriteHTML($this->renderPartial('view_solicitud_nuevo_usuario', array('model' => $this->loadModel($id),), true));
                $mPDF->Output($ticket->codigo . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
                return 0;
            } elseif ($r['id'] == self::RESET_CLAVE) {
                $consulta = TipoTicket::model()->findByPk($id);
                $mPDF = Yii::app()->ePdf->mpdf();
                $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
                $mPDF->WriteHTML($this->renderPartial('view_solicitud_reseteo_clave', array('model' => $this->loadModel($id),), true));
                $mPDF->Output($ticket->codigo . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
                return 0;
            } elseif ($r['id'] == self::NUEVO_PLANTEL) {
                $consulta = TipoTicket::model()->findByPk($id);
                $mPDF = Yii::app()->ePdf->mpdf();
                $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
                $mPDF->WriteHTML($this->renderPartial('view_nuevo_plantel', array('model' => $this->loadModel($id),), true));
                $mPDF->Output($ticket->codigo . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
            } elseif ($r['id'] == self::PLANTEL_INACTIVO) {
                $consulta = TipoTicket::model()->findByPk($id);
                $mPDF = Yii::app()->ePdf->mpdf();
                $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
                $mPDF->WriteHTML($this->renderPartial('view_nuevo_plantel', array('model' => $this->loadModel($id),), true));
                $mPDF->Output($ticket->codigo . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
            } elseif ($r['id'] == self::ERROR_SISTEMA) {
                $consulta = TipoTicket::model()->findByPk($id);
                $mPDF = Yii::app()->ePdf->mpdf();
                $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
                $mPDF->WriteHTML($this->renderPartial('view_error_sistema', array('model' => $this->loadModel($id),), true));
                $mPDF->Output($ticket->codigo . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);

            }else if($r['id']==self::COCINERA_ESCOLAR_NO_PRESENTE){

                $consulta = TipoTicket::model()->findByPk($id);
                $mPDF = Yii::app()->ePdf->mpdf();
                $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
                $mPDF->WriteHTML($this->renderPartial('view_actualizacion_estudiantes', array('model' => $this->loadModel($id),), true));
                $mPDF->Output($ticket->codigo . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);

            }else if($r['id']==self::ASIGNACION_NIVELES){
                $consulta = TipoTicket::model()->findByPk($id);
                $mPDF = Yii::app()->ePdf->mpdf();
                $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
                $mPDF->WriteHTML($this->renderPartial('view_asignacion_niveles_plan', array('model' => $this->loadModel($id),), true));
                $mPDF->Output($ticket->codigo . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
            } else {
                $consulta = TipoTicket::model()->findByPk($id);
                $mPDF = Yii::app()->ePdf->mpdf();
                $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
                $mPDF->WriteHTML($this->renderPartial('view_otra_solicitud', array('model' => $this->loadModel($id),), true));
                $mPDF->Output($ticket->codigo . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
            }
        }
    }
    public function actionExportarTodo() {
        //$ticket = $this->loadModel();
        $mPDF = Yii::app()->ePdf->mpdf('', 'A4', 0, '', 15, 15, 16, 16, 9, 9, 'M');
        $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
        $mPDF->WriteHTML($this->renderPartial('view_pdf_generalizado', array(), true));
        //var_dump($mPDF); die();
        $mPDF->Output('Pdf' . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
    }


       public function actionExportarFiltro() {
        //$ticket = $this->loadModel();
        $model=Ticket::model()->findAll(Yii::app()->getSession()->get('filtro'));
        $mPDF = Yii::app()->ePdf->mpdf('', 'A4', 0, '', 15, 15, 16, 16, 9, 9, 'M');
        $mPDF->WriteHTML($this->renderPartial('_pdfHeader', array(), true));
        $mPDF->WriteHTML($this->renderPartial('view_pdf_filtro', array('model'=>$model), true));
        //var_dump($mPDF); die();
        $mPDF->Output('Pdf' . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
    }

    public function estatus($data) {
        $estatus = '';

        $groupId = Yii::app()->user->group;
        $id = $data["estatus"];
        if ($id == self::A_ACTIVO) {
            $estatus = 'Activo';
        }
        if ($id == 'E') {
            $estatus = 'Eliminado';
        }
        if ($id == self::A_RESUELTO) {
            $estatus = 'Resuelto';
        }
        if ($id == self::A_DEVUELTO) {
            $estatus = 'Devuelto';
        }
        if ($id == self::A_REDIRECCIONADO) {
            $estatus = 'Redireccionado';
        }
        if ($id == self::A_ASIGNADO) {
            $estatus = 'Asignado';
        }

        return $estatus;
    }

    public function estatus_asig() {
        $estatus = array();
        $groupId = Yii::app()->user->group;
        $estatus = array();
        $estatus[] = array('id' => self::A_ACTIVO, 'nombre' => 'Activo');
        $estatus[] = array('id' => self::A_RESUELTO, 'nombre' => 'Resuelto');
        $estatus[] = array('id' => self::A_DEVUELTO, 'nombre' => 'Devuelto');
        $estatus[] = array('id' => self::A_REDIRECCIONADO, 'nombre' => 'Redireccionado');
        $estatus[] = array('id' => self::A_ASIGNADO, 'nombre' => 'Asignado');
        return $estatus;
    }

    public function columnaAcciones($data) {
        $groupId = Yii::app()->user->group;
        $model = new Ticket();
        $id_encoded = $data["id"];
        $estatus = $data["estatus"];
        $id = base64_encode($id_encoded);
        $usuario_ini_id = $data["usuario_ini_id"];
        $tipo_ticket_id = $data['tipo_ticket_id'];
        $columna = '<div class="action-buttons">';
        $columna .= CHtml::link("", "", array("class" => "fa icon-zoom-in", "title" => "Ver datos de la Solicitud", "onClick" => "VentanaDialog('$id','/ayuda/ticket/view','Solicitud','view')")) . '&nbsp;&nbsp;';
        $unidadesResp = $this->getIdsUnidadesResponsables();

        if ((in_array($estatus, array(self::A_RESUELTO, self::A_DEVUELTO)) && $usuario_ini_id == Yii::app()->user->id) || (in_array($estatus, array(self::A_RESUELTO, self::A_DEVUELTO)) && Yii::app()->user->pbac('admin'))) { // Si el usuario es el que lo creó
            $columna .= CHtml::link("", "", array("class" => "fa fa-check red", "title" => "Reactivar Solicitud", "onClick" => "VentanaDialog('$id','/catalogo/mencion/activar','Reactivar Solicitud','activar')")) . '&nbsp;&nbsp;';
        } else {
            if (!is_null($unidadesResp) && (in_array($data->bandeja_actual_id, $unidadesResp) or ( Yii::app()->user->id == $data->responsable_asignado_id) || in_array(Yii::app()->user->group, array(UserGroups::JEFE_DRCEE, UserGroups::ADMIN_DRCEE, UserGroups::COORD_ATENCIONTELEFONICA,  UserGroups::DESARROLLADOR, UserGroups::root))) || in_array(Yii::app()->user->group, array(UserGroups::DESARROLLADOR, UserGroups::root, UserGroups::COORD_ATENCIONTELEFONICA))) {
                $columna .= CHtml::link("", "", array("class" => "fa icon-wrench green", "title" => "Atender Solicitud", "onClick" => "VentanaDialog('$id','/ayuda/ticket/update','Atender Solicitud','update')")) . '&nbsp;&nbsp;';
            }
        }

        return $columna;
    }

    public function loadModel($id) {
        $model = Ticket::model()->with('usuarioIni', 'usuarioAct', 'responsableAsignado', 'bandejaActual')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ticket-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function getCodigoTicket($tipoTicket = "") {

        $time = Utiles::microtimeString();
        $idUsuario = (string) Yii::app()->user->id;
        $tipoTicketStr = (string) $tipoTicket;

        if (strlen($idUsuario) < 4) {
            $idUsuario = str_pad($idUsuario, 4, "0", STR_PAD_LEFT);
        } elseif (strlen($idUsuario) > 4) {
            $idUsuario = substr($idUsuario, 0, 4);
        }

        if (strlen($tipoTicket) < 2) {
            $tipoTicketStr = str_pad($tipoTicket, 2, "0", STR_PAD_LEFT);
        } elseif (strlen($idUsuario) > 2) {
            $tipoTicketStr = substr($tipoTicket, 0, 2);
        }

        $preCodigo = $time . $tipoTicketStr . $idUsuario;

        if (strlen($idUsuario) > 30) {
            $codigo = substr($preCodigo, 0, 28);
        } else {
            $codigo = $preCodigo;
        }
        return $codigo;
    }

    protected function solicitudNuevoUsuario() {
        $id = $this->getQuery('id');
        $model = new Ticket;

        if (isset($_POST['correo']) && (strlen($id) != 0) && is_numeric($id)) { // Nuevo Usuario
            $tipoTicket = TipoTicket::model()->find('id = :id', array(':id' => $id));
            $unidadResponsableId = (is_object($tipoTicket)) ? $tipoTicket->unidad_resp_ticket_id : NULL;

            if (isset($_POST['Ticket']) && is_numeric($unidadResponsableId)) {

                $cedula = $_POST['cedula'];
                $nombre = strtoupper($_POST['nombre']);
                $apellido = strtoupper($_POST['apellido']);
                $celular = $_POST['celular'];
                $fijo = $_POST['fijo'];
                $correo = trim($_POST['correo']);
                $estado = $_POST['estado'];
                $grupo = $_POST['grupo'];
                $solicitante = $_POST['solicitante'];
                $observacion = trim($_POST['observacion']);
                $model->attributes = $_POST['Ticket'];
                $concatenacion = $cedula . ";" . $nombre . ";" . $apellido . ";"
                        . $celular . ";" . $fijo . ";" . $correo . ";"
                        . $estado . ";" . $grupo . ";" . $solicitante . ";" . $observacion;
                //$enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $mensaje.$model->observacion);
                $model->observacion = trim(date('d-m-Y H:i:s') . ' (' . 'Activo' . ') | ' . $observacion) . "\n";
                $model->descripcion = $concatenacion;
                $id = base64_decode($id);
                $model->usuario_ini_id = Yii::app()->user->id;
                $model->fecha_ini = date("Y-m-d H:i:s");
                $model->estatus = self::A_ACTIVO;
                $model->estatus_ticket_id = 1;
                $model->codigo = str_replace('-', '', date('Y-m-d')) . $this->getCodigoTicket($model->tipo_ticket_id);
                $model->estado_id = Yii::app()->user->estado;
                $model->bandeja_actual_id = $unidadResponsableId;

                if ($nombre == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Nombre No Debe Ser Vacio.'));
                } elseif ($apellido == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Apellido No Puede Ser Vacio.'));
                } elseif ($correo == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Correo No Puede Ser Vacio.'));
                } elseif ($estado == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Estado No Puede Ser Vacio.'));
                } elseif ($grupo == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Grupo No Puede Ser Vacio.'));
                } elseif ($solicitante == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Solicitante No Puede Ser Vacio.'));
                } elseif ($observacion == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'La Observacion No Puede Ser Vacia.'));
                } elseif (!preg_match("/^(?:[\w\d]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,4}$/", $_POST['correo'])) {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El correo es invalido.'));
                } elseif ($nombre != '' and $apellido != '' and $correo != '' and $estado != ''and $grupo != '' and $solicitante != '' and $observacion != '') {
                    //$etados = EstatusTicket::model()->find(array('condition' => 'id = '. $model->estatus_ticket_id));
                    //$estatusDescripcion = ($estatusTicket['nombre']);
                    if ($model->validate()) {
                        if ($model->save()) {
                             //$enviarCorreo = $this->enviarMensaje();
                            $this->registerLog('ESCRITURA', 'ayuda.ticket.create', 'EXITOSO', 'Se ha creado un ticket de tipo SOLICITUD DE NUEVO USUARIO. Cédula: ' . $cedula . '. Observación: ' . $observacion);
                            $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Se ha creado el tipo de notificacion: ' . $model->tipoTicket->nombre . ' numero ' . $model->codigo));
                            $model = new Ticket;
                        } else {
                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        }
                    } else {
                        $this->renderPartial('//errorSumMsg', array('model' => $model));
                    }
                }
            }
        }
    }

    protected function solicitudReseteoClave() {

        $id = $this->getQuery('id');
        $model = new Ticket;

        if (isset($_POST['cedula_res']) && (strlen($id) != 0) && is_numeric($id)) { // Reseteo de Clave
            $tipoTicket = TipoTicket::model()->find('id = :id', array(':id' => $id));
            $unidadResponsableId = (is_object($tipoTicket)) ? $tipoTicket->unidad_resp_ticket_id : NULL;

            if (isset($_POST['Ticket']) && is_numeric($unidadResponsableId)) {
                $model->attributes = $_POST['Ticket'];
                $cedula = $_POST['cedula_res'];
                $solicitante = $_POST['solicitante_res'];
                $correo = trim($_POST['correo_res']);
                $observacion = trim($_POST['observacion_res']);
                $concatenacion = $cedula . ";" . $solicitante . ";" . $correo . ";";
                $model->observacion = trim(date('d-m-Y H:i:s') . ' (' . 'Activo' . ') | ' . $observacion) . "\n";
                $model->descripcion = $concatenacion;
                $id = base64_decode($id);
                $model->usuario_ini_id = Yii::app()->user->id;
                $model->fecha_ini = date("Y-m-d H:i:s");
                $model->estatus = self::A_ACTIVO;
                $model->estatus_ticket_id = 1;
 $model->codigo = str_replace('-', '', date('Y-m-d')) . $this->getCodigoTicket($model->tipo_ticket_id);                $model->estado_id = Yii::app()->user->estado;
                $model->bandeja_actual_id = $unidadResponsableId;
                if ($cedula == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'La Cedula No Puede Ser Vacia.'));
                } elseif ($solicitante == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Solicitante No Debe Ser Vacio.'));
                } elseif ($correo == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Correo No Puede Ser Vacio.'));
                } elseif ($observacion == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'La Observacion No Puede Ser Vacia.'));
                } elseif ($solicitante == '') {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Solicitante No Puede Ser Vacio.'));
                } elseif ($correo == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El Correo No Puede Ser Vacio.'));
                } elseif ($observacion == "") {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'La Observacion No Puede Ser Vacia.'));
                } else if (!preg_match("/^(?:[\w\d]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,4}$/", $_POST['correo_res'])) {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'El correo es invalido.'));
                } elseif ($cedula != '' and $solicitante != '' and $correo != '' and $observacion != '') {
                    if ($model->save()) {
                         //$enviarCorreo = $this->enviarMensaje();
                        $this->registerLog('ESCRITURA', 'ayuda.ticket.create', 'EXITOSO', 'Se ha creado un ticket de tipo SOLICITUD DE RESETEO DE CLAVE DE USUARIO. Cédula: ' . $cedula . '. Observación: ' . $observacion);
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Se ha creado el tipo de notificacion: ' . $model->tipoTicket->nombre . ' numero ' . $model->codigo));
                        $model = new Ticket;
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (3)'));
                }
            } else {
                $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (2)'));
            }
        } else {
            $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (1)'));
        }
    }

    protected function solicitudResgistroPlantel() {

        $id = $this->getQuery('id');
        $model = new Ticket;

        if (isset($_POST['observacion_plantel']) && (strlen($id) != 0) && is_numeric($id)) { // Nuevo Plantel
            $tipoTicket = TipoTicket::model()->find('id = :id', array(':id' => $id));
            $unidadResponsableId = (is_object($tipoTicket)) ? $tipoTicket->unidad_resp_ticket_id : NULL;

            if (isset($_POST['Ticket']) && is_numeric($unidadResponsableId)) {
                $model->attributes = $_POST['Ticket'];
                $zona_educativa = $_POST['zona_educativa'];
                $dependencia = $_POST['dependencia'];
                $codigo = $_POST['codigo_plantel'];
                $nombre_plantel = $_POST['nombre_plantel'];
                $solicitante_plantel = $_POST['solicitante_plantel'];
                $observacion_plantel = trim($_POST['observacion_plantel']);
                $concatenacion_plantel = $zona_educativa . ";" . $dependencia . ";" . $codigo . ";" . $nombre_plantel . ";" . $solicitante_plantel . ";" . $observacion_plantel;
                $model->observacion = trim(date('d-m-Y H:i:s') . ' (' . 'Activo' . ') | ' . $observacion_plantel . "\n");
                $model->descripcion = $concatenacion_plantel;
                $id = base64_decode($id);
                $model->usuario_ini_id = Yii::app()->user->id;
                $model->fecha_ini = date("Y-m-d H:i:s");
                $model->estatus = self::A_ACTIVO;
                $model->estatus_ticket_id = 1;
 $model->codigo = str_replace('-', '', date('Y-m-d')) . $this->getCodigoTicket($model->tipo_ticket_id);                $model->estado_id = Yii::app()->user->estado;
                $model->bandeja_actual_id = $unidadResponsableId;
                if ($zona_educativa == '') {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Zona Educativa No Puede Ser Vacia.'));
                } else if ($dependencia == '') {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Dependencia No Puede Ser Vacia.'));
                } else if ($codigo == '') {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Codigo No Puede Ser Vacio.'));
                } else if ($nombre_plantel == '') {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Nombre No Puede Ser Vacio.'));
                } else if ($solicitante_plantel == '') {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Solicitante No Puede Ser Vacio.'));
                } else if ($observacion_plantel == '') {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Observacion No Puede Ser Vacio.'));
                }
                if ($zona_educativa != '' or $dependencia != '' or $codigo != '' or $nombre_plantel != '' or $solicitante_plantel != '' or $observacion_plantel) {
                    if ($model->save()) {
                        $this->registerLog('ESCRITURA', 'ayuda.ticket.create', 'EXITOSO', 'Se ha creado un ticket de tipo SOLICITUD DE REGISTRO DE NUEVO PLANTEL. Código: ' . $codigo . '. Zona Educ.:' . $zona_educativa . '. Observación: ' . $observacion_plantel);
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Se ha creado el tipo de notificacion: ' . $model->tipoTicket->nombre . ' numero ' . $model->codigo));
                        $model = new Ticket;
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                        //}
                    }
                } else {
                    $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (3)'));
                }
            } else {
                $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (2)'));
            }
        } else {
            $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (1)'));
        }
    }

    protected function otraSolicitud() {
         $id = $this->getQuery('id');
        $model = new Ticket;
        if (isset($_POST['solicitante_otra']) && (strlen($id) != 0) && is_numeric($id)) {
            $tipoTicket = TipoTicket::model()->find('id = :id', array(':id' => $id));
            $unidadResponsableId = (is_object($tipoTicket)) ? $tipoTicket->unidad_resp_ticket_id : NULL;

            if (isset($_POST['Ticket']) && is_numeric($unidadResponsableId)) {
                $model->attributes = $_POST['Ticket'];
                $observacion = trim($_POST['observacion_otra']);
                $solicitante_otra = trim($_POST['solicitante_otra']);
                $model->observacion = $solicitante_otra . ";" . trim(date('d-m-Y H:i:s') . ' (' . 'Activo' . ') | ' . $observacion) . "\n";
                $model->descripcion = $observacion;
                $model->usuario_ini_id = Yii::app()->user->id;
                $model->fecha_ini = date("Y-m-d H:i:s");
                $model->estatus = self::A_ACTIVO;
                $model->estatus_ticket_id = 1;
                //srand((double) microtime() * 1000000);
 $model->codigo = str_replace('-', '', date('Y-m-d')) . $this->getCodigoTicket($model->tipo_ticket_id);                $model->tipo_ticket_id = $_POST['Ticket']['tipo_ticket_id'];
                $model->url = (strlen(trim($_POST['nombreArchivo']))) ? "/public/uploads/ticket/" . $_POST['nombreArchivo'] : '';
                $model->nombre_archivo = (strlen(trim($_POST['nombreBD']))) ? $_POST['nombreBD'] : '';
                $model->estatus_ticket_id = 1; // 1 ID de Estatus del Ticket Activo
                $model->estado_id = Yii::app()->user->estado;
                $model->bandeja_actual_id = $unidadResponsableId;
                if ($model->validate()) {
                    if ($model->save()) {
                        $this->registerLog('ESCRITURA', 'ayuda.ticket.create', 'EXITOSO', 'Se ha creado un ticket de tipo REPORTE DE ERROR EN SISTEMA. ' . '. Observación: ' . $observacion);
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Se ha creado el tipo de notificacion: ' . $model->tipoTicket->nombre));
                        $model = new Ticket;
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
            } else {
                $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (2)'));
            }
        } else {
            $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (1)'));
        }
    }

    protected function errorSistema() {
        $id = $this->getQuery('id');
        $model = new Ticket;
        if (isset($_POST['observacion_error'])) { // Error en el Sistema
            $tipoTicket = TipoTicket::model()->find('id = :id', array(':id' => $id));
            $unidadResponsableId = (is_object($tipoTicket)) ? $tipoTicket->unidad_resp_ticket_id : NULL;
            if (isset($_POST['Ticket']) && is_numeric($unidadResponsableId)) {
                $model->attributes = $_POST['Ticket'];
                $observacion = trim($_POST['observacion_error']);
                $model->observacion = trim(date('d-m-Y H:i:s') . ' (' . 'Activo' . ') | ' . $observacion) . "\n";
                $model->descripcion = $observacion;
                $model->usuario_ini_id = Yii::app()->user->id;
                $model->fecha_ini = date("Y-m-d H:i:s");
                $model->estatus = self::A_ACTIVO;
                $model->estatus_ticket_id = 1;
                //srand((double) microtime() * 1000000);
 $model->codigo = str_replace('-', '', date('Y-m-d')) . $this->getCodigoTicket($model->tipo_ticket_id);                //var_dump($model->codigo); die();
                $model->tipo_ticket_id = $_POST['Ticket']['tipo_ticket_id'];
                $model->url = (strlen(trim($_POST['nombreArchivo']))) ? "/public/uploads/ticket/" . $_POST['nombreArchivo'] : '';
                $model->nombre_archivo = (strlen(trim($_POST['nombreBD']))) ? $_POST['nombreBD'] : '';
                $model->estado_id = Yii::app()->user->estado;
                $model->estatus_ticket_id = 1; // 1 ID de Estatus del Ticket Activo
                $model->bandeja_actual_id = $unidadResponsableId;
                if ($model->validate()) {
                    if ($model->save()) {
                        $this->registerLog('ESCRITURA', 'ayuda.ticket.create', 'EXITOSO', 'Se ha creado un ticket de tipo REPORTE DE ERROR EN SISTEMA. ' . '. Observación: ' . $observacion);
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Se ha creado el tipo de notificacion: ' . $model->tipoTicket->nombre));
                        $model = new Ticket;
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
            } else {
                $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (2)'));
            }
        } else {
            $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (1)'));
        }
    }



    protected function cocineraEscolarNoPresente() {
        $id = $this->getQuery('id');
        $model = new Ticket;
  
        if (isset($_POST['Cocinera'])) { // Error en el Sistema
            $tipoTicket = TipoTicket::model()->find('id = :id', array(':id' => $id));
            $unidadResponsableId = (is_object($tipoTicket)) ? $tipoTicket->unidad_resp_ticket_id : NULL;
            if (isset($_POST['Ticket']) && is_numeric($unidadResponsableId)) {
                $model->attributes = $_POST['Ticket'];
                $observacion = '';
                $model->observacion = trim(date('d-m-Y H:i:s') . ' (' . 'Activo' . ') | ' ) . "\n";
                $model->descripcion = json_encode($this->getPost('Cocinera'));
                $model->usuario_ini_id = Yii::app()->user->id;
                $model->fecha_ini = date("Y-m-d H:i:s");
                $model->estatus = self::A_ACTIVO;
                $model->estatus_ticket_id = 1;
                $model->codigo = str_replace('-', '', date('Y-m-d')) . $this->getCodigoTicket($model->tipo_ticket_id);
                $model->tipo_ticket_id = $_POST['Ticket']['tipo_ticket_id'];
                $model->estado_id = Yii::app()->user->estado;
                $model->estatus_ticket_id = 1; // 1 ID de Estatus del Ticket Activo
                $model->bandeja_actual_id = $unidadResponsableId;
                if ($model->validate()) {
                    if ($model->save()) {
                        $this->registerLog('ESCRITURA', 'ayuda.ticket.create', 'EXITOSO', 'Se ha creado un ticket de tipo "'.$model->tipoTicket->nombre.'"');
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Se ha creado el tipo de notificacion: ' . $model->tipoTicket->nombre));
                        $model = new Ticket;
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
            } else {
                $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (2)'));
            }
        } else {
            $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (1)'));
        }
    }
    protected function asignacion_planes_niveles() {
        $id = $this->getQuery('id');
        $model = new Ticket;
        if (isset($_POST['niveles'])) { // Error en el Sistema
            $tipoTicket = TipoTicket::model()->find('id = :id', array(':id' => $id));
            $unidadResponsableId = (is_object($tipoTicket)) ? $tipoTicket->unidad_resp_ticket_id : NULL;
            if (isset($_POST['Ticket']) && is_numeric($unidadResponsableId)) {
                $model->attributes = $_POST['Ticket'];
                $niveles = $_POST['niveles'];
                $planes = $_POST['planes'];
                $observacion_niveles = trim($_POST['observacion_niveles']);
                $concatenacion_asignacion_niveles = $niveles . ";".$planes;
                $model->observacion = trim(date('d-m-Y H:i:s') . ' (' . 'Activo' . ') | ' . $observacion_niveles) . "\n";
                $model->descripcion = $concatenacion_asignacion_niveles;
                $model->usuario_ini_id = Yii::app()->user->id;
                $model->fecha_ini = date("Y-m-d H:i:s");
                $model->estatus = self::A_ACTIVO;
                $model->estatus_ticket_id = 1;
 $model->codigo = str_replace('-', '', date('Y-m-d')) . $this->getCodigoTicket($model->tipo_ticket_id);                $model->tipo_ticket_id = $_POST['Ticket']['tipo_ticket_id'];
                $model->estado_id = Yii::app()->user->estado;
                $model->estatus_ticket_id = 1; // 1 ID de Estatus del Ticket Activo
                $model->bandeja_actual_id = $unidadResponsableId;
                if ($model->validate()) {
                    if ($model->save()) {
                        $this->registerLog('ESCRITURA', 'ayuda.ticket.create', 'EXITOSO', 'Se ha creado un ticket de tipo "'.$model->tipoTicket->nombre.'"' . '. Observación: ' . $observacion_niveles);
                        $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Se ha creado el tipo de notificacion: ' . $model->tipoTicket->nombre));
                        $model = new Ticket;
                    } else {
                        throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
                    }
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                }
            } else {
                $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (2)'));
            }
        } else {
            $this->renderPartial("//msgBox", array('class' => 'errorDialogBox', 'message' => 'Datos insuficientes para completar la operación. (1)'));
        }
    }


//mail('caffeinated@example.com', 'Mi título', $mensaje);
    public function enviarMensaje() {
        $id = $_GET['id'];
        $id = base64_decode($id);
        $model = $this->loadModel($id);
        $utiles = new Utiles();
        $arrayResponsables = Ticket::model()->getPosiblesResponsablesAsignados($model->id);
        $arrayCorreosDestino = Ticket::model()->getCorreosDestinos($model->id);
        //$correosDestino = '';
        foreach ($arrayCorreosDestino as $dataCorreo) {
            $correo = $dataCorreo['correo_electronico'];
            //$correosDestino .= $dataCorreo['correo_unidad'] . ';';
        }
        foreach ($arrayResponsables as $dataResponsable) {
            $correoResponsable = $dataResponsable['email'];
        }
        if (strlen($correo) > 1) {
            if ($model->tipo_ticket_id == self::NUEVO_PLANTEL) {
                $vista_nuevo_plantel = $this->renderPartial('view_nuevo_plantel', array('model' => $model), true);
                if ($model->estatus == self::A_DEVUELTO || $model->estatus == self::A_RESUELTO) {
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                } elseif ($model->estatus == self::A_ASIGNADO) {
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                    $enviarCorreo = $utiles->enviarCorreo($model->responsableAsignado->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                } else if ($model->estatus == self::A_ACTIVO){
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                    $enviarCorreo = $utiles->enviarCorreo($model->bandejaActual->correo_unidad, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                }else{
                $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                $enviarCorreo = $utiles->enviarCorreo($model->bandejaActual->correo_unidad, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                }
            } elseif ($model->tipo_ticket_id == self::NUEVO_USUARIO) {
                $vista_nuevo_usuario = $this->renderPartial('view_solicitud_nuevo_usuario', array('model' => $model), true);
                if ($model->estatus == self::A_DEVUELTO || $model->estatus == self::A_RESUELTO) {
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_usuario);
                } elseif ($model->estatus == self::A_ASIGNADO) {
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_error);
                    $enviarCorreo = $utiles->enviarCorreo($model->responsableAsignado->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_usuario);
                } else if ($model->estatus == self::A_ACTIVO){
                    
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                    $enviarCorreo = $utiles->enviarCorreo($model->bandejaActual->correo_unidad, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                }else{
                $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                $enviarCorreo = $utiles->enviarCorreo($model->bandejaActual->correo_unidad, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                }
            } else if ($model->tipo_ticket_id == self::ERROR_SISTEMA) {
                $vista_nuevo_error = $this->renderPartial('view_error_sistema', array('model' => $model), true);
                if ($model->estatus == self::A_DEVUELTO || $model->estatus == self::A_RESUELTO) {
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_error);
                } elseif ($model->estatus == self::A_ASIGNADO) {
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_error);
                    $enviarCorreo2 = $utiles->enviarCorreo($model->responsableAsignado->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_error);
                 } else if ($model->estatus == self::A_ACTIVO){
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                    $enviarCorreo2 = $utiles->enviarCorreo($model->bandejaActual->correo_unidad, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                }else{
                $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                $enviarCorreo2 = $utiles->enviarCorreo($model->bandejaActual->correo_unidad, 'Solicitud Nº ' . $model->id . '.', $vista_nuevo_plantel);
                }
            } elseif ($model->tipo_ticket_id == self::RESET_CLAVE) {
                $vista_reseteo_clave = $this->renderPartial('view_solicitud_reseteo_clave', array('model' => $model), true);
                if ($model->estatus == self::A_DEVUELTO || $model->estatus == self::A_RESUELTO) {
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_reseteo_clave);
                } elseif ($model->estatus == self::A_ASIGNADO){
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_reseteo_clave);
                    $enviarCorreo2 = $utiles->enviarCorreo($model->responsableAsignado->email, 'Solicitud Nº ' . $model->id . '.', $vista_reseteo_clave);
               } else if ($model->estatus == self::A_ACTIVO){
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_reseteo_clave);
                    $enviarCorreo2 = $utiles->enviarCorreo($model->bandejaActual->correo_unidad, 'Solicitud Nº ' . $model->id . '.', $vista_reseteo_clave);
                }else{
                 //var_dump($model->usuarioAct->email.$model->bandejaActual->correo_unidad); die();
                $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_reseteo_clave);
                $enviarCorreo2 = $utiles->enviarCorreo($model->bandejaActual->correo_unidad, 'Solicitud Nº ' . $model->id . '.', $vista_reseteo_clave);
                }
            } elseif ($model->tipo_ticket_id == self::SOLICITUD_OTRA) {
                $vista_otro_plantel = $this->renderPartial('view_otra_solicitud', array('model' => $model), true);
                if ($model->estatus == self::A_DEVUELTO || $model->estatus == self::A_RESUELTO) {
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_otro_plantel);
                } elseif ($model->estatus == self::A_ASIGNADO) {
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_otro_plantel);
                    $enviarCorreo2 = $utiles->enviarCorreo($model->responsableAsignado->email, 'Solicitud Nº ' . $model->id . '.', $vista_otro_plantel);
                } else if ($model->estatus == self::A_ACTIVO){
                    $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_otro_plantel);
                    $enviarCorreo2 = $utiles->enviarCorreo($model->bandejaActual->correo_unidad, 'Solicitud Nº ' . $model->id . '.', $vista_otro_plantel);
                }else{
                $enviarCorreo = $utiles->enviarCorreo($model->usuarioAct->email, 'Solicitud Nº ' . $model->id . '.', $vista_otro_plantel);
                $enviarCorreo2 = $utiles->enviarCorreo($model->bandejaActual->correo_unidad, 'Solicitud Nº ' . $model->id . '.', $vista_otro_plantel);
                }
            }
        }
    }

    protected function getIdsUnidadesResponsables() {

        $ids = null;

        $unidades = Yii::app()->session->get('unidadesResp');

        if (is_null($unidades)) {
            $unidades = UnidadRespTicket::getUnidadesResponsableUsuario(Yii::app()->user->id);
        }

        if (!is_null($unidades) && is_array($unidades)) {
            foreach ($unidades as $unidad) {
                $ids[] = $unidad['id'];
            }
        }

        return $ids;
    }
    

}
