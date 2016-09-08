<?php

class CalificacionesController extends Controller {

    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Ver de Calificaciones',
        'write' => 'Agregar de Calificaciones',
        'admin' => 'Eliminar y Modificar de Calificaciones',
        'label' => 'Gestion de Calificaciones'
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
                'actions' => array('index', 'notas', 'cargarNotas'),
                'pbac' => array('read', 'write'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'notas', 'cargarNotas', 'confirmarUsuario', 'CargarNotasBasicas', 'docente', 'cargarTotalClases'),
                'pbac' => array('write'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($id, $plantel) {

        $seccionIdDecoded = base64_decode($id);
        $plantelIdDecoded = base64_decode($plantel);
        $dataPlantel = Plantel::model()->obtenerDatosIdentificacion($plantelIdDecoded);
        $datosSeccionInfo = SeccionPlantel::model()->cargarDetallesSeccion($seccionIdDecoded, $plantelIdDecoded);
        $dataSeccion = SeccionPlantel::obtenerDatosSeccion($seccionIdDecoded, $plantelIdDecoded);


        $this->render('index', array(
            'plantel_id' => $plantelIdDecoded,
            'seccion_plantel_id' => $seccionIdDecoded,
            'datosPlantel' => $dataPlantel,
            'datosSeccionInfo' => $datosSeccionInfo,
            'datosSeccion' => $dataSeccion,
        ));
    }

    public function actionDocente($id, $plantel) {
        $lapso = base64_encode(1);
        $seccionIdDecoded = base64_decode($id);
        $plantelIdDecoded = base64_decode($plantel);
        $dataPlantel = Plantel::model()->obtenerDatosIdentificacion($plantelIdDecoded);
        $datosSeccionInfo = SeccionPlantel::model()->cargarDetallesSeccion($seccionIdDecoded, $plantelIdDecoded);
        $dataSeccion = SeccionPlantel::obtenerDatosSeccion($seccionIdDecoded, $plantelIdDecoded);

        // $datos = InscripcionEstudiante::model()->buscarInscrito($id_inscripcion_estudiante_decoded);
        //$datosEstudiante = Estudiante::datosEstudianteInscrito($datos[0]['id']);
        //$asignaturaEstudiante = AsignaturaEstudiante::model()->obtenerAsignaturasEstudiante($id_inscripcion_estudiante_decoded);
        ///$datos = InscripcionEstudiante::model()->buscarInscrito($id_inscripcion_estudiante_decoded);

        $this->render('_regularMediaGeneralDocente', array(
            'plantel_id' => $plantelIdDecoded,
            'seccion_plantel_id' => $seccionIdDecoded,
            'datosPlantel' => $dataPlantel,
            'lapso' => $lapso,
            'seccion_id' => $seccionIdDecoded,
            'datosSeccionInfo' => $datosSeccionInfo,
            'datosSeccion' => $dataSeccion
        ));
    }

    public function loadModel($id) {
        $model = CalificacionAsignaturaEstudiante::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function columnaEdad($data) {
        $fecha_nacimiento = $data["fecha_nacimiento"];
        if (!empty($fecha_nacimiento)) {
            $edad = Estudiante::model()->calcularEdad($fecha_nacimiento);
        } else {
            $edad = 0;
        }
        $columna = '<center>' . $edad . '</center>';

        return $columna;
    }

    public function columnaAcciones($data) {

        $id_inscripcion_encoded = base64_encode($data['id_inscripcion']);

        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';

        /* SISTEMA REGULAR */
        if ($data['modalidad'] == 1) {

            $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;1 lapso</span>", "/planteles/calificaciones/notas/id/" . $id_inscripcion_encoded . "/item/" . base64_encode(1), array("class" => "fa fa-plus-square blue", "title" => "Consultar calificaciones 1er lapso")) . '</li>';
            $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;2 lapso</span>", "/planteles/calificaciones/notas/id/" . $id_inscripcion_encoded . "/item/" . base64_encode(2), array("class" => "fa fa-plus-square blue", "title" => "Consultar calificaciones 2do lapso")) . '</li>';
            $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;3 lapso</span>", "/planteles/calificaciones/notas/id/" . $id_inscripcion_encoded . "/item/" . base64_encode(3), array("class" => "fa fa-plus-square blue", "title" => "Consultar calificaciones 3er lapso")) . '</li>';

            if ($data["materia_pendiente"] != 0) {
                $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Materia Pendiente</span>", "/planteles/calificaciones/index/id/" . $id_inscripcion_encoded, array("class" => "fa fa-plus-square blue", "title" => "Consultar Materias Pendientes")) . '</li>';
            }
        }
        /* JOVENES ADULTOS Y ADULTAS */ else if ($data['modalidad'] == 2) {
            $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;1 Semestre</span>", "/planteles/calificaciones/notas/id/" . $id_inscripcion_encoded . "/item/" . base64_encode(1), array("class" => "fa fa-plus-square blue", "title" => "Consultar calificaciones 1er Semestre")) . '</li>';
            $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;2 Semestre</span>", "/planteles/calificaciones/notas/id/" . $id_inscripcion_encoded . "/item/" . base64_encode(2), array("class" => "fa fa-plus-square blue", "title" => "Consultar calificaciones 2do Semestre")) . '</li>';
        }
        $columna .= '</ul></div>';


        return $columna;
    }

    public function columnaAccionesCalificarAsignaturas($data) {
        /* indeca=input de calificacion */
        if ($data['calif_cuantitativa']) {
            $columnaAccion = $data['calif_cuantitativa'];
        } else {
            $columnaAccion = "<input type='hidden' name='asignatura[]' value='" . $data['id'] . "'/> <input type='text' id='CalificacionAsignaturaEstudiante_nota" . $data['id'] . "' class='indeca span-7'  name='nota[]' required='required'>";
        }
        return $columnaAccion;
    }

    public function columnaTotalClases($data) {
        /* indeas=input de asistencia */
        if ($data['total_clases'] == NULL) {
            $columnaAccion = "<input type='text' id='total_clases" . $data['id'] . "' class='indeas span-7'  name='totalClases[]' required='required'>";
            $columnaAccion .= "<input type='hidden' id='asignatura" . $data['id'] . "' name='asignatura[]' value='" . $data['asignatura_id'] . "' required='required'>";
        } else {
            $columnaAccion = $data['total_clases'];
        }
        return $columnaAccion;
    }

    public function columnaAccionesAsistencia($data) {
        /* indeca=input de asistencia */
        if ($data['asistencia']) {
            $columnaAccion = $data['asistencia'];
        } else {
            $columnaAccion = "<input type='text' id='CalificacionAsignaturaEstudiante_asistencia" . $data['id'] . "' class='indeas span-7'  name='asistencia[]' required='required'>";
        }
        return $columnaAccion;
    }

    public function columnaAccionesObservacion($data) {
        /* indeca=input de asistencia */
        if ($data['observacion'] or $data['calif_cuantitativa']) {
            $columnaAccion = $data['observacion'];
        } else {
            $columnaAccion = "<textarea id='CalificacionAsignaturaEstudiante_observacion" . $data['id'] . "' class='span-12'  name='observacion[]' style='resize: none;height:29px; ' ></textarea>";
        }
        return $columnaAccion;
    }

    public function actionCargarTotalClases() {


        /* confirmando posts */

        if (is_array($this->getPost('totalClases')) and
                is_array($this->getPost('asignatura')) and
                $this->getPost('periodo')and
                $this->getPost('plan_id')and
                $this->getPost('grado_id')and
                $this->getPost('seccionPlantel')
        ) {

            $arregloTotalClases = $this->getPost('totalClases');
            $arregloAsignatura = $this->getPost('asignatura');
            $periodo = $this->getPost('periodo');
            $plan_id = $this->getPost('plan_id');
            $grado_id = $this->getPost('grado_id');
            $seccionPlantel = $this->getPost('seccionPlantel');
            $arregloAsignaturaBD = PlanesGradosAsignaturas::model()->getAsignaturasAsistenciaArray($grado_id, $plan_id);


            foreach ($arregloAsignaturaBD as $key => $valor) {
                $arregloAsignaturasForm[] = (string) $valor['asignatura_id'];
            }


            /* comparando tamaños de arreglos */
            if (count($arregloAsignatura) == count($arregloTotalClases)and
                    count($arregloAsignatura) == count($arregloAsignaturasForm)) {

                if ($arregloAsignaturasForm === $arregloAsignatura) {

                    if (Utiles::isNumericArray($arregloAsignatura)) {
                        if (Utiles::isNumericArray($arregloTotalClases)) {
                            CalificacionAsignaturaEstudiante::model()->cargarTotalClasesAsignatura($arregloAsignatura, $arregloTotalClases, $seccionPlantel, $periodo);
                            $mensaje = "Exito! Finalizado el proceso de Calificación";
                            $respuesta = array('success' => true, 'error' => false, 'mensaje' => $mensaje); //en caso fallido
                            echo json_encode($respuesta);
                        } else {
                            $mensaje = "los totales de clases impartidas contienen valores no validos";
                            $respuesta = array('success' => false, 'error' => true, 'mensaje' => $mensaje); //en caso fallido
                            echo json_encode($respuesta);
                        }
                    } else {
                        $mensaje = " Las Asignaturas contienen valores no validos";
                        $respuesta = array('success' => false, 'error' => true, 'mensaje' => $mensaje); //en caso fallido
                        echo json_encode($respuesta);
                    }
                } else {
                    //no son iguales los arreglos de asignatura (fueron obscuramente modificados XD)
                    $mensaje = " No es valido el recurso solicitado (los arrays de asignaturas no son iguales)";
                    $respuesta = array('success' => false, 'error' => true, 'mensaje' => $mensaje); //en caso fallido
                    echo json_encode($respuesta);
                }
            } else {
                //los array no son del mismo tamaño (errores de carga o no se que verga)
                $mensaje = " No es valido el recurso solicitado los array no son del mismo tamaño";
                $respuesta = array('success' => false, 'error' => true, 'mensaje' => $mensaje); //en caso fallido
                echo json_encode($respuesta);
            }
        } else {
            $mensaje = " No es valido el recurso solicitado no recibi los post";
            $respuesta = array('success' => false, 'error' => true, 'mensaje' => $mensaje); //en caso fallido
            echo json_encode($respuesta);
            //mensaje de erro no es valido el recurso solicitado
        }
    }

    public function actionCargarNotas($id) {
        $id_inscripcion_estudiante_decoded = base64_decode($id);
        $asignaturaEstudiante = AsignaturaEstudiante::model()->obtenerAsignaturasEstudiante($id_inscripcion_estudiante_decoded);


        /* confirmando posts */
        if (is_array($this->getPost('nota')) and
                is_array($this->getPost('asistencia')) and
                is_array($this->getPost('observacion'))and
                is_array($this->getPost('asignatura'))
        ) {

            $arregloNota = $this->getPost('nota');
            $arregloAsistencia = $this->getPost('asistencia');
            $arregloObservacion = $this->getPost('observacion');
            $arregloAsignaturaForm = $this->getPost('asignatura');
            $grado_id = base64_decode($this->getPost('grado'));
            $plan_id = base64_decode($this->getPost('plan'));
            $periodo = base64_decode($this->getPost('lapso'));

            $total_clases = PlanesGradosAsignaturas::model()->getAsignaturasAsistenciaListado($grado_id, $plan_id, $periodo);

            foreach ($total_clases as $keyTotalAsistencia => $valorTotalAsistencia) {
                $arregloTotalClases[] = (string) $valorTotalAsistencia['total_clases'];
            }
            foreach ($total_clases as $keyAsignaturaNom => $valorAsignaturaNom) {
                $arregloAsignaturaNom[] = (string) $valorAsignaturaNom['asignaturas'];
            }

            foreach ($asignaturaEstudiante as $key => $valor) {
                $arregloAsignaturas[] = (string) $valor['id'];
            }
            /* comparando tamaños de arreglos */
            if (count($arregloAsistencia) == count($arregloNota) and
                    count($arregloAsistencia) == count($arregloAsignaturas) and
                    count($arregloAsistencia) == count($arregloAsignaturaForm) and
                    count($arregloAsistencia) == count($arregloTotalClases) and
                    count($arregloAsistencia) == count($arregloAsignaturaNom)
            ) {

                if ($arregloAsignaturaForm === $arregloAsignaturas) {

                    if (Utiles::isNumericArray($arregloAsistencia)) {

                        if (Utiles::isNumericArray($arregloNota)) {
//                            foreach($arregloTotalClases as $key=>$valor){
//                                if($valor['total']){
//                                    
//                                }
//                            }
                            $indice = count($arregloTotalClases);
                            $mensajeAsistencia = '';
                            $idField[]=array();
                            
                            for ($i = 0; $i < $indice; $i++) {

                                if ($arregloAsistencia[$i] <= $arregloTotalClases[$i] and $arregloAsistencia[$i] >= 0) {
                                    
                                } else {
                                    if ($arregloTotalClases[$i]) {
                                        $totalClasesNotificacion = $arregloTotalClases[$i];
                                        $mensajeAsistencia .= '<li>Error de Asistencia - en ' . $arregloAsignaturaNom[$i] . ' el total de clases es :' . $totalClasesNotificacion . ' y se ingreso ' . $arregloAsistencia[$i] . '</li>';
                                        $idField[$i]=$arregloAsignaturas[$i];
                                        
                                    } else {
                                        $totalClasesNotificacion = 0;
                                        $idField[$i]=$arregloAsignaturas[$i];
                                        $mensajeAsistencia .= '<li>Error de Asistencia - en ' . $arregloAsignaturaNom[$i] . ' el total de clases es :' . $totalClasesNotificacion . ' se debe cargar el total de clases durante este lapso </li>';
                                    }
                                }
                            }

                            if ($mensajeAsistencia != '') {                                                            /*Para confirmar el tipo de error*/
                                $respuesta = array('success' => false, 'error' => true,'detalle'=>true,'idField'=>$idField , 'mensaje' => $mensajeAsistencia); //en caso fallido
                                echo json_encode($respuesta);
                            } else {
                                CalificacionAsignaturaEstudiante::model()->cargarCalificacionRegularMediaGeneral($arregloAsignaturas, $arregloAsistencia, $arregloNota, $arregloObservacion, $this->getPost('lapso'));
                                $mensaje = "Exito! Finalizado el proceso de Calificación";
                                $respuesta = array('success' => true, 'error' => false, 'mensaje' => $mensaje); //en caso fallido
                                echo json_encode($respuesta);
                            }
                        } else {
                            $mensaje = " Las notas contienen valores no validos";
                            $respuesta = array('success' => false, 'error' => true, 'mensaje' => $mensaje); //en caso fallido
                            echo json_encode($respuesta);
                        }
                    } else {
                        $mensaje = " Las asistencia contienen valores no validos";
                        $respuesta = array('success' => false, 'error' => true, 'mensaje' => $mensaje); //en caso fallido
                        echo json_encode($respuesta);
                    }
                } else {
                    //no son iguales los arreglos de asignatura (fueron obscuramente modificados XD)
                    $mensaje = " No es valido el recurso solicitado";
                    $respuesta = array('success' => false, 'error' => true, 'mensaje' => $mensaje); //en caso fallido
                    echo json_encode($respuesta);
                }
            } else {
                //los array no son del mismo tamaño (errores de carga o no se que verga)
                $mensaje = " No es valido el recurso solicitado";
                $respuesta = array('success' => false, 'error' => true, 'mensaje' => $mensaje); //en caso fallido
                echo json_encode($respuesta);
            }
        } else {
            $mensaje = " No es valido el recurso solicitado";
            $respuesta = array('success' => false, 'error' => true, 'mensaje' => $mensaje); //en caso fallido
            echo json_encode($respuesta);
            //mensaje de erro no es valido el recurso solicitado
        }
    }

    public function actionCargarNotasBasicas() {

        $model = new CalificacionAsignaturaEstudiante;
        $califEstudiantes = $this->getPost('CalificacionAsignaturaEstudiante');
        $model->asistencia = $califEstudiantes['asistencia'];
        $model->resumen_evaluativo = $califEstudiantes['resumen_evaluativo'];
        $model->lapso = base64_decode($this->getPost('lapso'));
        $model->asignatura_estudiante_id = base64_decode($this->getPost('asignatura_id'));
        $model->usuario_ini_id = Yii::app()->user->id;
        $model->fecha_ini = date("Y-m-d H:i:s");
        $model->id_compuesta = base64_decode($this->getPost('asignatura_id')) . base64_decode($this->getPost('lapso'));

        if (base64_decode($this->getPost('lapso')) == "3") {
            $model->calif_nominal = $califEstudiantes['calif_nominal'];
            $model->scenario = 'regularBasica3lapso';
        } else {
            $model->scenario = 'regularBasica';
        }

        if ($model->validate()) {
            if ($model->save()) {
                $mensaje = '<div class = "successDialogBox" > Exito! proceso de calificacion finalizado.<br><br></div>';

                $respuesta = array('success' => true, 'error' => false, 'mensaje' => $mensaje); //en caso correcto
                echo json_encode($respuesta);
            }
        } else {
            $this->renderPartial('//errorSumMsg', array('model' => $model));
        }
    }

    public function actionNotas($id, $item) {

        $itemDecoded = base64_decode($item);
        if (empty($itemDecoded) and ! is_numeric($itemDecoded) and $itemDecoded == 0 and $itemDecoded > 6) {
            throw new CHttpException(403, "No se encontro el recurso solicitado");
        }
        $arregloAsignaturas = array();
        $model = new CalificacionAsignaturaEstudiante;
        $id_inscripcion_estudiante_decoded = base64_decode($id);
        $datos = InscripcionEstudiante::model()->buscarInscrito($id_inscripcion_estudiante_decoded);
        $datosEstudiante = Estudiante::datosEstudianteInscrito($datos[0]['id']);
        $asignaturaEstudiante = AsignaturaEstudiante::model()->obtenerAsignaturasEstudiante($id_inscripcion_estudiante_decoded);

        if ($asignaturaEstudiante) {

            if ($datos[0]['modalidad'] == 1) {

                if (in_array($datos[0]['grado_id'], array('2', '4', '6', '8', '10', '12', '14', '16', '18'))) {

                    $vista = "_regularBasica";
                    $modelTemp = new CalificacionAsignaturaEstudiante;

                    if ($modelTemp->findAllByAttributes(array('asignatura_estudiante_id' => $asignaturaEstudiante[0]['id'], 'lapso' => $itemDecoded)) != NULL) {
                        $modelTemp = $modelTemp->findAllByAttributes(array('asignatura_estudiante_id' => $asignaturaEstudiante[0]['id'], 'lapso' => $itemDecoded));
                        $model = $this->loadModel($modelTemp[0]['id']);
                    }
                } elseif (in_array($datos[0]['grado_id'], array('1', '5', '9', '13', '15', '17'))) {

                    if (Yii::app()->user->group == UserGroups::DOCENTE) {
                        $vista = '_regularMediaGeneralDocente';
                    } else {
                        $vista = "_regularMediaGeneral";
                    }
                } else {
                    throw new CHttpException(403, "Ud no tiene acceso a este nivel.");
                }
            } else if ($datos[0]['modalidad'] == 2) {
                $vista = "_adultos";
            } else {
                throw new CHttpException(500, "Ha ocurrido un error, pongase en contacto con el administrador del sistema");
            }


            $asignaturaEstudianteDataProvider = new CArrayDataProvider($asignaturaEstudiante, array('pagination' => array(
                    'pageSize' => 9999999999999999999999999999999,
                )
            ));
        } else {
            throw new CHttpException(500, "Ha ocurrido un error, pongase en contacto con el administrador del sistema");
        }

        $datosSeccionInfo = SeccionPlantel::model()->cargarDetallesSeccion($datos[0]['seccion'], $datos[0]['plantel']);

        $this->render($vista, array(
            'plantel_id' => $datos[0]['plantel'],
            'seccion_id' => $datos[0]['seccion'],
            'model' => $model,
            'datosEstudiante' => $datosEstudiante,
            'id' => $id_inscripcion_estudiante_decoded,
            'lapso' => $item,
            'datosSeccionInfo' => $datosSeccionInfo,
            'asignatura_id' => $asignaturaEstudiante[0]['id'],
            'asignaturaEstudiante' => $asignaturaEstudianteDataProvider
        ));
    }

    public function actionConfirmarUsuario() {

        $result = Utiles::confirmarUsuario($this->getPost('password'));
        echo $result;
    }

    public function estatus($data) {
        $estatus = $data["estatus"];

        if ($estatus == "E") {
            $columna = "Inactivo";
        } else if ($estatus == "A") {
            $columna = "Activo";
        }
        return $columna;
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
