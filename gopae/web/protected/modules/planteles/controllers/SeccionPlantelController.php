<?php

class SeccionPlantelController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Consulta de Secciones al Plantel',
        'write' => 'Asignación de Secciones al Plantel',
        'admin' => 'Asignación y Eliminación de Secciones al Plantel',
        'label' => 'Secciones del Plantel'
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
                'actions' => array('confirmarEliminacion', 'mostrarGrado', 'mostrarRegistrarSeccion', 'vizualizar', 'mostrarSeccion', 'admin', 'mostrarPlan', 'detallesSeccion'),
                'pbac' => array('read', 'write', 'admin'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('eliminarSeccion', 'modificarSeccion', 'guardarSeccion'),
                'pbac' => array('write', 'admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function columnaAcciones($data) {

        $id = $data->id;
        $estatus = $data->estatus;
        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';
        $capacidad = isset($data['capacidad']) ? $data['capacidad'] : null;
        $nivel_id = isset($data['nivel_id']) ? $data['nivel_id'] : null;
        $grado_id = isset($data['grado_id']) ? $data['grado_id'] : null;
        $data_description = is_object($data->seccion) ? $data->seccion->nombre : '';
        $ultimoGrado = Grado::model()->obtenerUltimoGradoNivel($nivel_id, $grado_id);


        if (($estatus == 'A') || ($estatus == '')) {
            // $columna .= CHtml::link("", "", array('onClick' => "vizualizar('" . base64_encode($id) . "')", "class" => "fa fa-search", "title" => "Consultar los Datos de la Sección")) . '&nbsp;&nbsp;';
            $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar</span>", "/planteles/seccionPlantel/detallesSeccion/id/" . base64_encode($id), array("class" => "fa fa-search blue", "title" => "Consultar Sección")) . '</li>';

            if (Yii::app()->user->pbac('planteles.seccionPlantel.write') or Yii::app()->user->pbac('planteles.seccionPlantel.admin')) {
                $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar</span>", "", array('onClick' => "mostrarSeccion('" . base64_encode($id) . "')", "class" => "fa fa-pencil green", "title" => "Modificar los Datos de la Sección")) . '</li>';
            }
            if (Yii::app()->user->pbac('planteles.matricula.read') && Yii::app()->user->pbac('planteles.matricula.write'))
                if ($grado_id == $ultimoGrado) {
                    if (($estatus == 'A')) {
                        $datosSeccion = SeccionPlantel::model()->existeEstudiantesInscritosEnSeccion($data->id);
                        if ($datosSeccion == 0)
                            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Inscripción Inicial</span>", "/planteles/matricula/inscripcion/id/" . base64_encode($data->id) . "/plantel/" . base64_encode($data->plantel_id), array("class" => "fa fa-users orange inscribir", 'data-id' => base64_encode($data->id), 'data-description' => $data_description, "title" => "Inscripción Inicial de Estudiantes")) . '</li>';
                        if ($datosSeccion < $capacidad && $datosSeccion > 0)
                            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Inscripción Individual</span>", "/planteles/matricula/inscripcionIndividual/id/" . base64_encode($data->id) . "/plantel/" . base64_encode($data->plantel_id) . "/key/" . base64_encode($data->plantel_id * 9), array("class" => "fa fa-user blue inscribir", 'data-id' => base64_encode($data->id), 'data-description' => $data_description, "title" => "Inscripción Individual de Estudiantes ")) . '</li>';
                    }
                }

            if (Yii::app()->user->id == '1' or Yii::app()->user->pbac('planteles.calificaciones.write')) {


                if (Yii::app()->user->group == UserGroups::DOCENTE) {
                    //$vista = "_regularMediaGeneral"; //regular basica pero no me muestra
                    $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Calificaciónes</span>", "/planteles/calificaciones/Docente/id/" . base64_encode($id) . "/plantel/" . base64_encode($data->plantel_id), array("class" => "fa fa-check-square orange", "title" => "Consultar calificaciones")) . '</li>';
                } else {
                    $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Calificaciónes</span>", "/planteles/calificaciones/index/id/" . base64_encode($id) . "/plantel/" . base64_encode($data->plantel_id), array("class" => "fa fa-check-square orange", "title" => "Consultar calificaciones")) . '</li>';
                }
            }

            if (Yii::app()->user->pbac('planteles.seccionPlantel.write') or Yii::app()->user->pbac('planteles.seccionPlantel.admin')) {
                $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Inactivar</span>", "", array('onClick' => "confirmarEliminacion('" . base64_encode($id) . "')", "class" => "fa fa-trash-o red", "title" => "Inactivar la Sección")) . '</li>';
            }
        } else if ($estatus == 'E') {
            $columna .='<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar</span>", "/planteles/seccionPlantel/detallesSeccion/id/" . base64_encode($id), array("class" => "fa fa-search blue", "title" => "Consultar Sección")) . '</li>';
        }

        $columna .= '</ul></div>';

        return $columna;
    }

    public function estatusSeccion($data) {
        $estatus = $data['estatus'];
        if (($estatus == 'A') || ($estatus == '')) {
            return 'Activo';
        } else if ($estatus == 'E') {
            return 'Inactivo';
        }
    }

    public function actionMostrarPlan() {

        if (is_numeric($_REQUEST['plantel_id'])) {
            $plantel_id = $_REQUEST['plantel_id'];
        }

        if (is_numeric($_REQUEST['nivel_id'])) {
            $nivel_dropDown_id = $_REQUEST['nivel_id'];
        } else {
            $nivel_dropDown_id = null;
        }

        $verificarExistenciaNivel = NivelPlantel::model()->verificarExistenciaNivelPlantel($plantel_id, $nivel_dropDown_id);

        if ($verificarExistenciaNivel == false) {
            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            $nivelPlan = NivelPlan::model()->getPlan($verificarExistenciaNivel, $plantel_id);

            if ($nivelPlan == false) {
                echo 'false';
            } else {
                for ($x = 0; $x < count($nivelPlan); $x++) {
                    if ($nivelPlan[$x]['nombre'] == null)
                        $nombre[] = array(
                            'nombre' => $nivelPlan[$x]['nombreplan'],
                            'plan_id' => $nivelPlan[$x]['plan_id']
                        );
                    if ($nivelPlan[$x]['nombre'] != null)
                        $nombre[] = array(
                            'nombre' => $nivelPlan[$x]['nombre'],
                            'plan_id' => $nivelPlan[$x]['plan_id']
                        );
                }

                if ($nombre != null) {
                    $listaNivelPlan = CHtml::listData($nombre, 'plan_id', 'nombre');
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);
                    foreach ($listaNivelPlan as $valor => $descripcion) {
                        echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                    }
                }
            }
        }
    }

    public function actionMostrarGrado() {

        if (is_numeric($_REQUEST['plan_id'])) {
            $plan_dropDown_id = $_REQUEST['plan_id'];
        } else {
            $plan_dropDown_id = null;
        }

        if (is_numeric($_REQUEST['nivel_id'])) {
            $nivel_dropDown_id = $_REQUEST['nivel_id'];
        } else {
            $nivel_dropDown_id = null;
        }

        $verificarExistenciaPlan = NivelPlan::model()->verificarExistenciaPlan($plan_dropDown_id, $nivel_dropDown_id);
        if ($verificarExistenciaPlan == false) {
            $lista = array('empty' => '-SELECCIONE-');
            foreach ($lista as $valor => $descripcion) {
                echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
            }
        } else {
            //var_dump($verificarExistenciaPlan); die();
            $planGrado = PlanesGradosAsignaturas::model()->getGrado($verificarExistenciaPlan);
            // var_dump($planGrado); die();
            if ($planGrado == false) {
                echo 'false';
            } else {
                $listaNivelPlan = CHtml::listData($planGrado, 'grado_id', 'nombre');
                //  var_dump($listaNivelPlan); die();
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);
                foreach ($listaNivelPlan as $valor => $descripcion) {
                    echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                }
            }
        }
    }

    public function actionEliminarSeccion($id) {

        $modelSeccion = new SeccionPlantel;
        $seccionId = base64_decode($id);
        if (!is_numeric($seccionId)) {
            // throw new CHttpException(404, 'No se ha encontrado la sección que ha solicitado para modificar. Vuelva a la página anterior e intentelo de nuevo.'); // es numerico
            $mensaje = "No se ha encontrado la sección que ha solicitado para Inactivar. Recargue la página e intentelo de nuevo.";
            Yii::app()->user->setFlash('mensajeError', "$mensaje");
            $this->renderPartial('//flashMsgv2');
            // Yii::app()->end();
        } else {
            $model = SeccionPlantel::model()->findByPk($seccionId);

            if ($model != null) {

                $eliminacion = $modelSeccion->eliminarSeccion($seccionId);
                $this->registerLog('INACTIVAR', 'planteles.seccionPlantel.EliminarSeccion', 'EXITOSO', 'Permite inactivar un registro de una sección que pertenece a un plantel en especifico');
                if ($eliminacion == 1) {
                    $nombre = $model->seccion->nombre;
                    $grado = $model->grado->nombre;

                    Yii::app()->user->setFlash('mensajeExitoso', "Inactivación Exitosa de la sección:" . '&nbsp;&nbsp;' . $nombre . '&nbsp;&nbsp;' . "y Grado" . '&nbsp;&nbsp;' . $grado);
                    $this->renderPartial('//flashMsg');
                } else {
                    Yii::app()->user->setFlash('mensajeError', "Inactivación invalida, por favor intente nuevamente");
                    $this->renderPartial('//flashMsgv2');
                    Yii::app()->end();
                }
            } else {
                Yii::app()->user->setFlash('mensajeError', "Por favor seleccione una opcion correcta para eliminar, intente nuevamente");
                $this->renderPartial('//flashMsgv2');
                Yii::app()->end();
            }
        }
    }

    public function actionVizualizar($id) {
        $seccionId = base64_decode($id);
        if (!is_numeric($seccionId)) {
            // throw new CHttpException(404, 'No se ha encontrado la sección que ha solicitado para modificar. Vuelva a la página anterior e intentelo de nuevo.'); // es numerico
            $mensaje = "<div class='errorDialogBox bigger-110' style='padding-left: 60px; padding-top: 45px'>" . "No se ha encontrado la sección que ha solicitado para consultar. Recargue la página e intentelo de nuevo." . "</div>";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
            // Yii::app()->end();
        } else {

            $existeSeccionPlantelPeriodo = SeccionPlantel::model()->existeEstudiantesInscriptosEnSeccion($seccionId);
            //  var_dump($existeSeccionPlantelPeriodo);
            if ($existeSeccionPlantelPeriodo !== array()) {
                //$fecha_nacimiento=$existeSeccionPlantelPeriodo[0]['fecha_nacimiento'];
                $model = SeccionPlantel::model()->findByPk($seccionId);
                //   $edad=  Estudiante::model()->calcularEdad($fecha_nacimiento);
                $mostrarInscriptos = true;

                $dataProviderResultados = $this->dataProviderEstudiantesInscriptos($existeSeccionPlantelPeriodo);

                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
                $this->renderPartial('vizualizar', array(
                    'model' => $model,
                    'mostrarInscriptos' => $mostrarInscriptos,
                    'dataProvider' => $dataProviderResultados
                        ), false, true);
            } else {
                $model = SeccionPlantel::model()->findByPk($seccionId);
                $mostrarInscriptos = false;
                //var_dump($model);
                $this->renderPartial('vizualizar', array(
                    'model' => $model,
                    'mostrarInscriptos' => $mostrarInscriptos
                ));
            }
        }
    }

    public function actionDetallesSeccion($id) {



        $seccionId = base64_decode($id);

        if (!is_numeric($seccionId)) {
            // throw new CHttpException(404, 'No se ha encontrado la sección que ha solicitado para modificar. Vuelva a la página anterior e intentelo de nuevo.'); // es numerico
            $mensaje = "<div class='errorDialogBox bigger-110' style='padding-left: 60px; padding-top: 45px'>" . "No se ha encontrado la sección que ha solicitado para consultar. Recargue la página e intentelo de nuevo." . "</div>";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
            // Yii::app()->end();
        } else {

            $existeSeccionPlantelPeriodo = SeccionPlantel::model()->existeEstudiantesInscriptosEnSeccion($seccionId);
            //  var_dump($existeSeccionPlantelPeriodo);
            if ($existeSeccionPlantelPeriodo !== array()) {
                //$fecha_nacimiento=$existeSeccionPlantelPeriodo[0]['fecha_nacimiento'];
                $model = SeccionPlantel::model()->findByPk($seccionId);
                //   $edad=  Estudiante::model()->calcularEdad($fecha_nacimiento);
                $plantel_id = $model->plantel_id;
                // $plantel_id = base64_decode($plantel_id);
                $mostrarInscriptos = true;
                $dataPlantel = Plantel::model()->obtenerDatosIdentificacion($plantel_id);
                //var_dump($dataPlantel);die();
                $dataProviderResultados = $existeSeccionPlantelPeriodo;
                $dataSeccion = seccionPlantel::model()->cargarDetallesSeccion($seccionId, $plantel_id);
                $totalInscritos = seccionPlantel::model()->calcularInscritosPorSeccion($seccionId);
                //var_dump($totalInscritos);die();
                //Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                //Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
                $this->render('detallesSeccion', array(
                    'model' => $model,
                    'totalInscritos' => $totalInscritos,
                    'plantel_id' => $plantel_id,
                    'datosPlantel' => $dataPlantel,
                    'mostrarInscriptos' => $mostrarInscriptos,
                    'dataProvider' => $dataProviderResultados,
                    'datosSeccion' => $dataSeccion,
                    'seccionId' => $seccionId
                ));
            } else {
                $model = SeccionPlantel::model()->findByPk($seccionId);
                $plantel_id = $model->plantel_id;
                $dataPlantel = Plantel::model()->obtenerDatosIdentificacion($plantel_id);
                $dataSeccion = seccionPlantel::model()->cargarDetallesSeccion($seccionId, $plantel_id);
                $totalInscritos = seccionPlantel::model()->calcularInscritosPorSeccion($seccionId);
                $mostrarInscriptos = false;
                //var_dump($model);
                $this->render('detallesSeccion', array(
                    'model' => $model,
                    'totalInscritos' => $totalInscritos,
                    'plantel_id' => $plantel_id,
                    'datosPlantel' => $dataPlantel,
                    'mostrarInscriptos' => $mostrarInscriptos,
                    //'dataProvider' => $dataProviderResultados,
                    'datosSeccion' => $dataSeccion,
                    'seccionId' => $seccionId
                ));
            }
        }
    }

    public function dataProviderEstudiantesInscriptos($existeSeccionPlantelPeriodo) {

        foreach ($existeSeccionPlantelPeriodo as $key => $value) {

            $cedula_escolar = $value['cedula_escolar'];
            $fecha_nacimiento = $value['fecha_nacimiento'];
            $nombresApellidos = $value['nomape'];
            $cedula_identidad = $value['cedula_identidad'];
            $edad = Estudiante::model()->calcularEdad($fecha_nacimiento);


            $rawData[] = array(
                'id' => $key,
                'cedula_escolar' => '<center>' . $cedula_escolar . '</center>',
                'edad' => '<center>' . $edad . '</center>',
                'nomape' => '<center>' . $nombresApellidos . '</center>',
                'cedula_identidad' => '<center>' . $cedula_identidad . '</center>'
            );
        }
//           var_dump($rawData);
//          die();
        return new CArrayDataProvider($rawData, array(
            //  'pagination' =>false,
            'pagination' => array(
                'pageSize' => 8,
            ),
                )
        );
    }

    public function actionMostrarRegistrarSeccion() {

        $model = new SeccionPlantel;
        // var_dump($_REQUEST['plantel_id']);
        if (isset($_REQUEST['plantel_id']) && !is_numeric($_REQUEST['plantel_id'])) {
            $mensaje = "<div class='errorDialogBox bigger-110' style='padding-left: 60px; padding-top: 25px'>" . "No se ha encontrado el plantel asociado para asignar una sección. Recargue la página e intentelo de nuevo." . "</div>";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
        } else {
            $plantel_id = $_REQUEST['plantel_id'];

            $plan = array();
            $grado = array();
            $turno = Turno::model()->findAll(array('order' => 'nombre ASC', 'condition' => "estatus='A'"));
            $nivel = NivelPlantel::model()->nivelPlantel($plantel_id);
            //$plan=$this->actionMostrarPlan($nivel);
            if ($nivel == false) {
                $mensaje = "<div class='errorDialogBox bigger-110' style='padding-left: 60px; padding-top: 25px'>" . "999: Estimado Usuario, debe asociar los niveles al plantel y despues asignar las secciones." . "</div>";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
            } else {
                //throw new CHttpException(999, 'Estimado Usuario, debe asociar los niveles al plantel y despues asignar las secciones.');
                // var_dump($nivel);
                // $periodo = PeriodoEscolar::model()->findAll(array('order' => 'periodo ASC', 'condition' => "estatus='A'"));
                $seccion = Seccion::model()->findAll(array('order' => 'nombre ASC', 'condition' => "estatus='A'"));
                $this->renderPartial('_formRegistrarSeccion', array('model' => $model,
                    'plantel_id' => $plantel_id,
                    'plan' => $plan,
                    'grado' => $grado,
                    'turno' => $turno,
                    'nivel' => $nivel,
                    'seccion' => $seccion));
            }
        }
    }

    public function actionMostrarSeccion($id) {

        // $id= $_REQUEST['id'];
        $model = new SeccionPlantel;
        $seccionId = base64_decode($id);
        if (!is_numeric($seccionId)) {
            // throw new CHttpException(404, 'No se ha encontrado la sección que ha solicitado para modificar. Vuelva a la página anterior e intentelo de nuevo.'); // es numerico
            $mensaje = "<div class='errorDialogBox bigger-110' style='padding-left: 60px; padding-top: 45px'>" . "No se ha encontrado la sección que ha solicitado para modificar. Recargue la página e intentelo de nuevo." . "</div>";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
            // Yii::app()->end();
        } else {
            $model = SeccionPlantel::model()->findByPk($seccionId);
            //   var_dump($model); die();
            if (is_numeric($_REQUEST['plantel_id']))
                $plantel_id = $_REQUEST['plantel_id'];

            $plan = array($model->plan_id => $model->plan->nombre);
            $grado = array($model->grado_id => $model->grado->nombre);
            //  var_dump($plan); die();
            $turno = Turno::model()->findAll(array('order' => 'nombre ASC', 'condition' => "estatus='A'"));
            $nivel = NivelPlantel::model()->nivelPlantel($plantel_id);
            //$plan=$this->actionMostrarPlan($nivel);
            if ($nivel == false) {
                $mensaje = "<div class='errorDialogBox bigger-110' style='padding-left: 60px; padding-top: 25px'>" . "999: Estimado Usuario, debe asociar los niveles al plantel y despues asignar las secciones." . "</div>";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
            } else {
                //throw new CHttpException(999, 'Estimado Usuario, debe asociar los niveles al plantel y despues asignar las secciones.');
                // var_dump($nivel);
                // $periodo = PeriodoEscolar::model()->findAll(array('order' => 'periodo ASC', 'condition' => "estatus='A'"));
                $seccion = Seccion::model()->findAll(array('order' => 'nombre ASC', 'condition' => "estatus='A'"));
                $this->renderPartial('_formRegistrarSeccion', array('model' => $model,
                    'plantel_id' => $plantel_id,
                    'plan' => $plan,
                    'grado' => $grado,
                    'turno' => $turno,
                    'nivel' => $nivel,
                    'seccion' => $seccion));
            }
        }
    }

    public function actionGuardarSeccion() {

        $model = new SeccionPlantel;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['plantel_id'])) {

            if (is_numeric($_REQUEST['plantel_id']))
                $plantel_id = $_REQUEST['plantel_id'];
            else
                $mensaje.= "Han sido alterado los datos del plantel ya que solo puede contener números, Por favor intente nuevamente <br>";

            $model->seccion_id = $_REQUEST['seccion_id'];
            $model->nivel_id = $_REQUEST['nivel_id'];
            $model->plan_id = $_REQUEST['plan_id'];
            $model->grado_id = $_REQUEST['grado_id'];
            $model->turno_id = $_REQUEST['turno_id'];
            $model->capacidad = $_REQUEST['capacidad'];
            $mensaje = "";

            if ($model->validate()) {

                if (is_numeric($_REQUEST['seccion_id'])) {

                    $resultadoSeccion = $model->validarSeccion($_REQUEST['seccion_id']);
                    if ($resultadoSeccion == 0) {
                        $mensaje.="La sección no se encuentra, Por favor intente nuevamente <br>";
                    } else {
                        $seccion_id = $_REQUEST['seccion_id'];
                    }
                } else {
                    $mensaje.= "El campo Sección solo puede contener números <br>";
                }

                if (is_numeric($_REQUEST['nivel_id'])) {

                    $nivel_id = $_REQUEST['nivel_id'];
                } else {
                    $mensaje.= "El campo Nivel solo puede contener números <br>";
                }


                if (is_numeric($_REQUEST['plan_id'])) {

                    $plan_id = $_REQUEST['plan_id'];
                } else {
                    $mensaje.= "El campo Plan solo puede contener números <br>";
                }

                if (is_numeric($_REQUEST['grado_id'])) {

                    $grado_id = $_REQUEST['grado_id'];
                } else {
                    $mensaje.= "El campo Grado solo puede contener números <br>";
                }

                if (is_numeric($_REQUEST['turno_id'])) {

                    $resultadoTurno = $model->validarTurno($_REQUEST['turno_id']);
                    if ($resultadoTurno == 0) {
                        $mensaje.="El turno no se encuentra, Por favor intente nuevamente <br>";
                    } else {
                        $turno_id = $_REQUEST['turno_id'];
                    }
                } else {
                    $mensaje.= "El campo Turno solo puede contener números <br>";
                }

                if (is_numeric($_REQUEST['capacidad'])) {

                    $capacidad_est = (int) $_REQUEST['capacidad'];

//                    if (strlen($capacidad_est) > 2) {
//                        $mensaje.= "El campo Capacidad solo puede contener 3 números <br>";
//                    }
                    if ($capacidad_est < 10) {
                        $mensaje.= "El campo Capacidad debe contener al menos 10 estudiante <br>";
                    }

                    if ($capacidad_est > 100) {
                        $mensaje.= "Una sección debe contener maximo 100 estudiante <br>";
                    }
                    $capacidad = $_REQUEST['capacidad'];
                } else {
                    $mensaje.= "El campo Capacidad solo puede contener números <br>";
                }

                if ($mensaje != null) {
                    Yii::app()->user->setFlash('mensajeError', "$mensaje");
                    $this->renderPartial('//flashMsgv2');
                    Yii::app()->end();
                }

                $secciones[] = array(
                    'plantel_id' => $plantel_id,
                    'seccion_id' => $seccion_id,
                    'nivel_id' => $nivel_id,
                    'plan_id' => $plan_id,
                    'grado_id' => $grado_id,
                    'turno_id' => $turno_id,
                    'capacidad' => $capacidad
                );

                if ($secciones != array()) {

                    $verificarNivelPlanGrado = $model->validarNivelPlanGrado($plantel_id, $nivel_id, $plan_id, $grado_id);
                    if ($verificarNivelPlanGrado != 0) {
                        // var_dump($verificarNivelPlanGrado); die();
                        $validacionSeccion = $model->validacionSeccion($secciones);
                        if ($validacionSeccion == array()) {

                            $validacion = $model->validacionUniqueGradoSeccionTurno($secciones);

                            if ($validacion == array()) {


                                $guardo = $model->guardarSeccion($secciones);
                                if ($guardo == 1) {
                                    $seccionn_id = $model->id; //obtengo id de la seccion del registro que acabo de guardar.
                                    // var_dump($seccionn_id);
                                    $this->registerLog('ESCRITURA', 'planteles.seccionPlantel.GuardarSeccion', 'EXITOSO', 'Permite guardar un registro de una sección que pertenece a un plantel en especifico');

                                    $mensaje = "$seccionn_id";
                                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                    $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                                    // Yii::app()->end();
                                } else { // error que no guardo
                                    Yii::app()->user->setFlash('mensajeError', "Registro invalido, por favor intente nuevamente");
                                    $this->renderPartial('//flashMsgv2');
                                    Yii::app()->end();
                                }
                            } else {
                                Yii::app()->user->setFlash('mensajeError', "Por favor ingrese los datos correctos ya existe la sección, el turno  y el grado asignado a este plantel");
                                $this->renderPartial('//flashMsgv2');
                                Yii::app()->end();
                            }
                        } else {
                            Yii::app()->user->setFlash('mensajeError', "Por favor ingrese los datos correctos ya existe esta sección agregada con los mismos datos");
                            $this->renderPartial('//flashMsgv2');
                            Yii::app()->end();
                        }
                    } else {
                        Yii::app()->user->setFlash('mensajeError', "Por favor ingrese los datos correctos el nivel esta relacionado a un plan y a los grados, estos valores fueron alterados, por favor intente nuevamente");
                        $this->renderPartial('//flashMsgv2');
                        Yii::app()->end();
                    }
                } else {
                    Yii::app()->user->setFlash('mensajeError', "Por favor ingrese al menos una sección para guardar");
                    $this->renderPartial('//flashMsgv2');
                    Yii::app()->end();
                }
            } else { // si ingresa datos erroneos muestra mensaje de error.
                $this->renderPartial('//errorSumMsg', array('model' => $model));
                Yii::app()->end();
            }
        } else {

            throw new CHttpException(404, 'No se ha especificado la sección que desea agregar. Recargue la página e intentelo de nuevo.'); // esta vacio el request
        }
    }

    public function actionModificarSeccion($id) {

        $modelSeccion = new SeccionPlantel;
        $seccionId = base64_decode($id);
        if (!is_numeric($seccionId)) {
            //throw new CHttpException(404, 'No se ha encontrado la sección que ha solicitado para modificar. Vuelva a la página anterior e intentelo de nuevo.'); // es numerico

            $mensaje = "<div class='errorDialogBox bigger-110' style='padding-left: 60px; padding-top: 45px'>" . "No se ha encontrado la sección que ha solicitado para modificar. Recargue la página e intentelo de nuevo." . "</div>";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
        } else {
            $model = SeccionPlantel::model()->findByPk($seccionId);

            if (isset($_POST['id'])) {

                $model->seccion_id = $_REQUEST['seccion_id'];
                $model->plan_id = $_REQUEST['plan_id'];
                $model->nivel_id = $_REQUEST['nivel_id'];
                $model->grado_id = $_REQUEST['grado_id'];
                $model->turno_id = $_REQUEST['turno_id'];
                $model->capacidad = $_REQUEST['capacidad'];
                $mensaje = "";

                if ($model->validate()) {

                    if (is_numeric($_REQUEST['seccion_id'])) {

                        $resultadoSeccion = $model->validarSeccion($_REQUEST['seccion_id']);
                        if ($resultadoSeccion == 0) {
                            $mensaje.="La sección no se encuentra, Por favor intente nuevamente <br>";
                        } else {
                            $seccion_id = $_REQUEST['seccion_id'];
                        }
                    } else {
                        $mensaje.= "El campo Sección solo puede contener números <br>";
                    }

                    if (is_numeric($_REQUEST['nivel_id'])) {

                        $nivel_id = $_REQUEST['nivel_id'];
                    } else {
                        $mensaje.= "El campo Nivel solo puede contener números <br>";
                    }


                    if (is_numeric($_REQUEST['plan_id'])) {

                        $plan_id = $_REQUEST['plan_id'];
                    } else {
                        $mensaje.= "El campo Plan solo puede contener números <br>";
                    }

                    if (is_numeric($_REQUEST['grado_id'])) {

                        $grado_id = $_REQUEST['grado_id'];
                    } else {
                        $mensaje.= "El campo Grado solo puede contener números <br>";
                    }

                    if (is_numeric($_REQUEST['turno_id'])) {

                        $resultadoTurno = $model->validarTurno($_REQUEST['turno_id']);
                        if ($resultadoTurno == 0) {
                            $mensaje.="El turno no se encuentra, Por favor intente nuevamente <br>";
                        } else {
                            $turno_id = $_REQUEST['turno_id'];
                        }
                    } else {
                        $mensaje.= "El campo Turno solo puede contener números <br>";
                    }

                    if (is_numeric($_REQUEST['capacidad'])) {

                        $capacidad_est = (int) $_REQUEST['capacidad'];
                        //   if (strlen($_REQUEST['capacidad']) > 3) {
                        //     $mensaje.= "El campo Capacidad solo puede contener 3 números <br>";
                        // }
                        if ($capacidad_est > 100) {
                            $mensaje.= "Una sección debe contener maximo 100 estudiante <br>";
                        }
                        if ($capacidad_est < 10) {
                            $mensaje.= "El campo Capacidad debe contener al menos 10 estudiante <br>";
                        }
                        $capacidad = $_REQUEST['capacidad'];
                    } else {
                        $mensaje.= "El campo Capacidad solo puede contener números <br>";
                    }

                    if (is_numeric($_REQUEST['plantel_id']))
                        $plantel_id = $_REQUEST['plantel_id'];
                    else
                        $mensaje.= "El plantel ha sido modificado, solo puede contener números <br>";

                    $secciones[] = array(
                        'id' => $seccionId,
                        'plantel_id' => $plantel_id,
                        'seccion_id' => $seccion_id,
                        'nivel_id' => $nivel_id,
                        'plan_id' => $plan_id,
                        'grado_id' => $grado_id,
                        'turno_id' => $turno_id,
                        'capacidad' => $capacidad
                    );



                    /*  VALIDA QUE EXISTA UN GRADO Y SECCION ASIGNADO POR PLANTEL   */
                    $validacionUnique = $model->validacionUniqueGradoSeccionTurno($secciones);

                    foreach ($validacionUnique as $value) {
                        $seccionId = $value["id"];
                    }

                    //   var_dump($seccionId);                    var_dump($model->id);
                    if ($seccionId != $model->id) {
                        $validacion = $model->validacionSeccion($secciones);
                        //     var_dump($validacion);
                        if ($validacion != array()) {
                            // var_dump($validacion);
                            $mensaje.="Por favor ingrese los datos correctos ya existe la sección, el turno  y el grado asignado a este plantel <br>";
                        }
                    }//else{
                    /*     FIN      */


                    if ($mensaje != null) {
                        Yii::app()->user->setFlash('mensajeError', "$mensaje");
                        $this->renderPartial('//flashMsgv2');
                        Yii::app()->end();
                    }



                    if ($model != null) {

                        $verificarNivelPlanGrado = $model->validarNivelPlanGrado($plantel_id, $nivel_id, $plan_id, $grado_id);
                        // var_dump($verificarNivelPlanGrado);
                        if ($verificarNivelPlanGrado != 0) {
                            //  $validacion= $model->validacionUniqueGradoSeccionTurno($secciones);
                            // if ($validacion == array()) {

                            $actualizo = $modelSeccion->actualizoSeccion($secciones);
                            if ($actualizo == 1) {
                                $seccionn_id = '1'; //obtengo id de la seccion del registro que acabo de guardar.
                                // var_dump($seccionn_id);
                                $this->registerLog('ACTUALIZACION', 'planteles.seccionPlantel.ModificarSeccion', 'EXITOSO', 'Permite modificar un registro de una sección que pertenece a un plantel en especifico');

                                $mensaje = "$seccionn_id";
                                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
                                // Yii::app()->end();
                            } else { // error que no guardo
                                Yii::app()->user->setFlash('mensajeError', "Registro invalido, por favor intente nuevamente");
                                $this->renderPartial('//flashMsgv2');
                                Yii::app()->end();
                            }
                            /*     } else {
                              Yii::app()->user->setFlash('mensajeError', "Por favor ingrese los datos correctos ya existe la sección, el turno  y el grado asignado a este plantel");
                              $this->renderPartial('//flashMsgv2');
                              Yii::app()->end();
                              } */
                        } else {
                            Yii::app()->user->setFlash('mensajeError', "Por favor ingrese los datos correctos el nivel esta relacionado a un plan y a los grados, estos valores fueron alterados, por favor intente nuevamente");
                            $this->renderPartial('//flashMsgv2');
                            Yii::app()->end();
                        }
                    } else {

                        Yii::app()->user->setFlash('mensajeError', "Por favor ingrese al menos una sección para guardar");
                        $this->renderPartial('//flashMsgv2');
                        Yii::app()->end();
                    }
                    //   }
                } else { // si ingresa datos erroneos muestra mensaje de error.
                    $this->renderPartial('//errorSumMsg', array('model' => $model));
                    Yii::app()->end();
                }
            } else {

                throw new CHttpException(404, 'No se ha especificado la sección que desea agregar. Recargue la página e intentelo de nuevo.'); // esta vacio el request
            }
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin($id) {

        $plantel_id = base64_decode($id);
        // var_dump($plantel_id);
        if (!is_numeric($plantel_id)) {
            throw new CHttpException(404, 'No se ha encontrado la sección que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // es numerico
        } else {

            if ($plantel_id != '') {
                $plantelPK = Plantel::model()->findByPk($plantel_id);

                if ($plantelPK == null) {
                    $this->redirect('../../../consultar');
                }
            } else {

                $this->redirect('../../../consultar');
            }

            //    var_dump($plantelPK); die();
            $model = new SeccionPlantel('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['SeccionPlantel']))
                $model->attributes = $_GET['SeccionPlantel'];
            //  var_dump($model->attributes);

            $grado = Grado::model()->findAll(array('order' => 'nombre ASC', 'condition' => "estatus='A'"));
            $turno = Turno::model()->findAll(array('order' => 'nombre ASC', 'condition' => "estatus='A'"));
            //   $periodo = PeriodoEscolar::model()->findAll(array('order' => 'periodo ASC', 'condition' => "estatus='A'"));
            $seccion = Seccion::model()->findAll(array('order' => 'nombre ASC', 'condition' => "estatus='A'"));

            //$totalInscritos = seccionPlantel::model()->calcularInscritosPorSeccion($seccionId);
            //     var_dump($seccion); die();
            $this->render('admin', array(
                'model' => $model,
                'plantel_id' => $plantel_id,
                'grado' => $grado,
                'turno' => $turno,
                //   'periodo' => $periodo,
                'seccion' => $seccion,
                'plantelPK' => $plantelPK
            ));
        }
    }

    public function dataProviderTotalEstudiantes($seccion) {


        $totalInscritos = seccionPlantel::model()->calcularInscritosPorSeccion($seccionId);
        $rawData = array();
        if ($totalInscritos != array()) {

            foreach ($estudiantes as $key => $value) {
                $total = '<div class="center">' . CHtml::textField('estudiantesIns[]', false, array('id' => 'estudiantesIns[]', 'value' => base64_encode($value['id']))) . "</div>";
                $cedula_escolar = "<div class='center'>" . $value['cedula_escolar'] . "</div>";
// $edad = "<div class='center'>" . $value[''] . "</div>";
                $nom_completo = '<div class="center">' . $value['nom_completo'] . '</div>';
                $rawData [] = array(
                    'id' => $key,
                    'nom_completo' => $nom_completo,
                    'cedula_escolar' => $cedula_escolar,
                    'boton' => $boton
                );
            }
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SeccionPlantel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SeccionPlantel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SeccionPlantel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'seccion-plantel-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
