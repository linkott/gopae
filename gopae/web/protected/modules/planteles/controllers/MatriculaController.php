<?php

class MatriculaController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    const MODULO = "Planteles.Matricula";
    const REGISTRADO_ID = 2;

    static $_permissionControl = array(
        'read' => 'Permite consultar las secciones disponibles a matricular',
        'write' => 'Permite matricular una seccion',
        //'admin' => '',
        'label' => 'Matriculación'
    );

    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
//'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {

//en esta seccion colocar los action de solo lectura o consulta
        return array(
            array('allow',
                'actions' => array(
                    'consultar',
                    'buscarCedulaRepresentante',
                    'buscarCedulaEstudiante',
                    'dialogoRegistro',
                    'buscarEstudiante',
                    'incluirEstudiante',
                    'caracterizarInscripcionIndividual',
                    'reporte'),
                'pbac' => array('read'),
            ),
            //en esta seccion colocar todos los action del modulo
            array('allow',
                'actions' => array(
                    'consultar',
                    'inscripcion',
                    'incluirEstudiantesPorLotes',
                    'excluirEstudiantesPorLotes',
                    'preCaracterizarInscripcion',
                    'caracterizarInscripcion',
                    'inscribirEstudiantes',
                    'inscribirEstudiante',
                    'gridEstudiantesInscritosIndividual',
                    'inscribirEstudiantesIndividual',
                    'inscripcionIndividual',
                    'agregarEstudiante',
                    'agregarEstudianteInscribir',
                    'cambiarEstatus'
                ),
                'pbac' => array('write'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionConsultar() {
        if (Yii::app()->request->isAjaxRequest && isset($_REQUEST['ajax'])) {
            $model = new SeccionPlantel('search');
            $model->unsetAttributes();  // clear any default values
            $id = $_REQUEST['id'];
            $plantel_id = base64_decode($id);
            $model->plantel_id = $plantel_id;

            if (isset($_GET['SeccionPlantel'])) {
                $model->attributes = $_GET['SeccionPlantel'];
                $model->plantel_id = $_GET['SeccionPlantel']['plantel_id'];

//                $model->cod_plan = $_GET['SeccionPlantel']['cod_plan'];
//                $model->plan = $_GET['SeccionPlantel']['plan'];
//                $model->mencion = $_GET['SeccionPlantel']['mencion'];
//                $model->credencial = $_GET['SeccionPlantel']['credencial'];
//                $model->fund_juridico = $_GET['SeccionPlantel']['fund_juridico'];
            } elseif (isset($_GET['plantel_id']) && isset($_GET['cod_plan']) && isset($_GET['plan']) && isset($_GET['mencion']) && isset($_GET['credencial']) && isset($_GET['fund_juridico'])) {
                $model->plantel_id = $_GET['plantel_id'];
//                $model->cod_plan = $_GET['cod_plan'];
//                $model->plan = $_GET['plan'];
//                $model->mencion = $_GET['mencion'];
//                $model->credencial = $_GET['credencial'];
//                $model->fund_juridico = $_GET['fund_juridico'];
            }
            $data = Plantel::model()->obtenerDatosIdentificacion($plantel_id);
            $this->render('index', array(
                'model' => $model,
                'plantel_id' => base64_encode($plantel_id),
                'datosPlantel' => $data,
            ));
        } else
        if (array_key_exists('id', $_REQUEST) && $_REQUEST['id'] !== '') {
            $id = $_REQUEST['id'];
            $plantel_id = base64_decode($id);
            if (is_numeric($plantel_id)) {
                $model = new SeccionPlantel('search');
                $model->unsetAttributes();  // clear any default values
                $model->plantel_id = $plantel_id;
                $data = Plantel::model()->obtenerDatosIdentificacion($plantel_id);

                $this->registerLog('LECTURA', self::MODULO . '.Consultar', 'EXITOSO', 'Entró a consultar Matricula del plantel ' . $plantel_id);
                $this->render('index', array(
                    'model' => $model,
                    'plantel_id' => base64_encode($plantel_id),
                    'datosPlantel' => $data,
                ));
            } else
                throw new CHttpException(404, 'No se ha encontrado el recurso que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // no es numerico
        } else
            throw new CHttpException(404, 'No se ha especificado el Plantel al cual desea visualizar los Planes de Estudios. Vuelva a la página anterior e intentelo de nuevo.'); // esta vacio el request
    }

    public function actionInscripcion() {
        if (array_key_exists('id', $_REQUEST) && array_key_exists('plantel', $_REQUEST)) {
            $id = $_REQUEST['id'];
            $plantel_id = $_REQUEST['plantel'];
            $seccion_plantel_id = base64_decode($id);
            $plantel_id_decoded = base64_decode($plantel_id);
            if (is_numeric($seccion_plantel_id) && is_numeric($plantel_id_decoded)) {

                $periodo_actual = PeriodoEscolar ::model()->getPeriodoActivo();

                $estudiantes = Estudiante::model()->obtenerEstudiantesPorInscripccion($plantel_id_decoded, $periodo_actual, $seccion_plantel_id);

                $dataProvider = $this->dataProviderEstudiantesPorInscribir($estudiantes);

                $dataProviderIns = new CArrayDataProvider(array(), array(
                    'pagination' => array(
                        'pageSize' => 999999,
                    ),
                ));

                $dataSeccion = SeccionPlantel::obtenerDatosSeccion($seccion_plantel_id, $plantel_id_decoded);

                $dataPlantel = Plantel::model()->obtenerDatosIdentificacion($plantel_id_decoded);

                $this->registerLog('LECTURA', self::MODULO . 'Inscripcion', 'EXITOSO', 'Entró matricular la Seccion Plantel' . $seccion_plantel_id);
                $this->render('inscripcion', array(
                    'plantel_id' => $plantel_id_decoded,
                    'dataProviderPen' => $dataProvider,
                    'dataProviderIns' => $dataProviderIns,
                    'datosPlantel' => $dataPlantel,
                    'datosSeccion' => $dataSeccion,
                    'seccion_plantel_id' => $seccion_plantel_id,
                    'inscritos' => json_encode(array())
                ));
            } else
                throw new CHttpException(404, 'No se ha encontrado el recurso que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // no es numerico
        } else
            throw new CHttpException(404, 'No se ha especificado la Sección a la cual desea realizar la Inscripción. Vuelva a la página anterior e intentelo de nuevo.'); // esta vacio el request
    }

    public function columnaDocumentoIdentidad($value) {

        if ($value['cedula_identidad'] != NULL) {
            $identificacion = "C.I:" . $value['cedula_identidad'];
        } else if ($value['cedula_escolar'] != NULL) {

            $identificacion = "C.E:" . $value['cedula_escolar'];
        }
        return $identificacion;
    }

    public function actionIncluirEstudiantesPorLotes() {


        if (Yii::app()->request->isAjaxRequest) {
            $valido = true;
            if (array_key_exists('estudiantes', $_REQUEST)) {
                $estudiantes = $_REQUEST['estudiantes'];
                $result_decoded = $this->decodificarEstudiantes($estudiantes);
                $valido = $result_decoded[0];
                $estudiantes_decoded = $result_decoded[1];
                $nuevoRegistro = 'no';
            } else if (array_key_exists('id_incluir', $_REQUEST) && array_key_exists('nuevoRegistro', $_REQUEST)) { //Aqui entra jean
                $estudiantes_decoded = $_REQUEST['id_incluir'];
                $nuevoRegistro = $_REQUEST['nuevoRegistro'];
                //  var_dump("nuevo registro" . $nuevoRegistro);
                foreach ($estudiantes_decoded as $key => $value) {
                    if (!is_numeric($value)) {
                        $valido = false;
                    }
                }
            }

            $plantel_id = $_REQUEST['plantel_id'];
            $seccion_plantel_id = $_REQUEST['seccion_plantel_id'];
            $inscritos = json_decode($_REQUEST['inscritos'], true);

            $plantel_id_decoded = $plantel_id;

            if (is_numeric($plantel_id_decoded) && $valido) {
                //   var_dump($nuevoRegistro);
                //die();
                $estudiantes_a_incluir = Estudiante::model()->obtenerDatosEstudiantes($estudiantes_decoded, $nuevoRegistro);

                $estudiantes_inscritos = $this->combinarArreglosEstudiantes($inscritos, $estudiantes_a_incluir);

                $periodo_actual = PeriodoEscolar ::model()->getPeriodoActivo();

                $estudiantes = Estudiante::model()->obtenerEstudiantesPorInscripccion($plantel_id_decoded, $periodo_actual, $seccion_plantel_id);

                $estudiantes_pendientes = $this->filtrarEstudiantesPorInscribir($estudiantes, $estudiantes_inscritos);

                $dataProviderPen = $this->dataProviderEstudiantesPorInscribir($estudiantes_pendientes);
                $dataProviderIns = $this->dataProviderEstudiantesInscritos($estudiantes_inscritos);

                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;

                $this->registerLog('LECTURA', self::MODULO . 'IncluirEstudiantesPorLotes', 'EXITOSO', 'Incluyó estudiantes a la lista de matriculación de la Seccion Plantel' . $seccion_plantel_id);

                $this->renderPartial('_gridEstudiantes', array(
                    'dataProviderPen' => $dataProviderPen,
                    'dataProviderIns' => $dataProviderIns,
                    'inscritos' => json_encode($estudiantes_inscritos)
                        ), false, true);
            } else
                throw new CHttpException(404, 'No se ha encontrado el recurso que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // no es numerico
        } else
            throw new CHttpException(404, 'Estimado Usuario, usted no esta autorizado para acceder mediante esta via.');
    }

    public function actionExcluirEstudiantesPorLotes() {
        if (Yii::app()->request->isAjaxRequest) {
            $estudiantes = $_REQUEST['estudiantes'];
            $plantel_id = $_REQUEST['plantel_id'];
            $seccion_plantel_id = $_REQUEST['seccion_plantel_id'];
            $inscritos = json_decode($_REQUEST['inscritos'], true);
            $nuevoRegistro = 'no';

            $plantel_id_decoded = $plantel_id;

            $result_decoded = $this->decodificarEstudiantes($estudiantes);
            $valido = $result_decoded[0];
            $estudiantes_decoded = $result_decoded[1];

            if (is_numeric($plantel_id_decoded) && $valido) {

                $estudiantes_a_excluir = Estudiante::model()->obtenerDatosEstudiantes($estudiantes_decoded, $nuevoRegistro);
                $estudiantes_inscritos = $this->eliminarEstudiantesInscritos($inscritos, $estudiantes_a_excluir);

                $periodo_actual = PeriodoEscolar ::model()->getPeriodoActivo();

                $estudiantes = Estudiante::model()->obtenerEstudiantesPorInscripccion($plantel_id_decoded, $periodo_actual, $seccion_plantel_id);

                $estudiantes_pendientes = $this->filtrarEstudiantesPorInscribir($estudiantes, $estudiantes_inscritos);

                $dataProviderPen = $this->dataProviderEstudiantesPorInscribir($estudiantes_pendientes);
                $dataProviderIns = $this->dataProviderEstudiantesInscritos($estudiantes_inscritos);

                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;

                $this->registerLog('LECTURA', self::MODULO . 'ExcluirEstudiantesPorLotes', 'EXITOSO', 'Excluyó estudiantes de la lista de matriculación de la Seccion Plantel' . $seccion_plantel_id);

                $this->renderPartial('_gridEstudiantes', array(
                    'dataProviderPen' => $dataProviderPen,
                    'dataProviderIns' => $dataProviderIns,
                    'inscritos' => json_encode($estudiantes_inscritos)
                        ), false, true);
            } else
                throw new CHttpException(404, 'No se ha encontrado el recurso que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // no es numerico
        } else
            throw new CHttpException(404, 'Estimado Usuario, usted no esta autorizado para acceder mediante esta via.');
    }

    public function actionInscribirEstudiante() {
        if (Yii::app()->request->isAjaxRequest) {
            $estudiante_id = $this->getRequest('estudiante_id');
            $plantel_id = $this->getRequest('plantel_id');
            $seccion_plantel_id = $this->getRequest('seccion_plantel_id');
            $inscripcion_regular = $this->getRequest('inscripcion_regular');
            $materia_pendiente = $this->getRequest('materia_pendiente');
            $doble_inscripcion = $this->getRequest('doble_inscripcion');
            $repitiente = $this->getRequest('repitiente');
            $observacion = $this->getRequest('observacion');

            $observacion_decoded = base64_decode($observacion);

            $plantel_id_decoded = base64_decode($plantel_id);
            $seccion_plantel_id_decoded = base64_decode($seccion_plantel_id);
            $estudiante_id_decoded = base64_decode($estudiante_id);

            if (is_numeric($estudiante_id_decoded) AND is_numeric($seccion_plantel_id_decoded) AND is_numeric($plantel_id_decoded)) {
                if ($repitiente == '1') {
                    if ($observacion_decoded != '' AND $observacion_decoded != null) {
                        $periodo = PeriodoEscolar ::model()->getPeriodoActivo();
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            $estudiantes[] = $estudiante_id_decoded;
                            $repitiente_array [] = (int) $repitiente;
                            $inscripcion_regular_array[] = (int) $inscripcion_regular;
                            $doble_inscripcion_array[] = (int) $doble_inscripcion;

                            $estudiantes_pg_array = $this->to_pg_array($estudiantes);
                            $doble_inscripcion_pg_array = $this->to_pg_array($doble_inscripcion_array);
                            $inscripcion_regular_pg_array = $this->to_pg_array($inscripcion_regular_array);
                            $repitiente_pg_array = $this->to_pg_array($repitiente_array);

                            $modulo = self::MODULO . 'InscribirEstudiante';
                            $resultadoInscripcion = Estudiante::model()->inscribirEstudiante($estudiantes_pg_array, $plantel_id_decoded, $seccion_plantel_id_decoded, $periodo['id'], $modulo, $inscripcion_regular_pg_array, $doble_inscripcion_pg_array, $repitiente_pg_array, $observacion_decoded);
                            $transaction->commit();
                            $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiante', 'EXITOSO', 'Ha matriculado la Seccion Plantel ' . $seccion_plantel_id);
                            $respuesta['statusCode'] = 'success';
                            $respuesta['id'] = base64_encode($seccion_plantel_id_decoded);
                            $respuesta['plantel'] = base64_encode($plantel_id_decoded);
                            $respuesta['mensaje'] = 'Estimado Usuario, el proceso de inscripción se ha realizado exitosamente.';
                            echo json_encode($respuesta);
                        } catch (Exception $ex) {
                            $transaction->rollback();
//throw $ex;
                            $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiante', 'FALLIDO', 'Ha intentado matricular la Seccion Plantel ' . $seccion_plantel_id);
                            $respuesta['statusCode'] = 'error';
                            $respuesta['error'] = $ex;
                            $respuesta['mensaje'] = 'Estimado Usuario, ha ocurrido un error durante el proceso de inscripción. Intente nuevamente.';
                            echo json_encode($respuesta);
                        }
                    } else {
                        $mensaje = "Estimado Usuario, el campo Observación no puede estar vacio si la escolaridad es Repitiente.";
                        $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiante', 'FALLIDO', 'Ha intentado matricular la Seccion Plantel ' . $seccion_plantel_id);
                        $respuesta['statusCode'] = 'mensaje';
                        $respuesta['mensaje'] = $mensaje;
                        echo json_encode($respuesta);
                    }
                } else if ($inscripcion_regular == '1') {
                    $periodo = PeriodoEscolar ::model()->getPeriodoActivo();
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $estudiantes[] = $estudiante_id_decoded;
                        $inscripcion_regular_array[] = (int) $inscripcion_regular;
                        $doble_inscripcion_array[] = (int) $doble_inscripcion;
                        $estudiantes_pg_array = $this->to_pg_array($estudiantes);
                        $doble_inscripcion_pg_array = $this->to_pg_array($doble_inscripcion_array);
                        $inscripcion_regular_pg_array = $this->to_pg_array($inscripcion_regular_array);
                        $modulo = self::MODULO . 'InscribirEstudiante';
                        $resultadoInscripcion = Estudiante::model()->inscribirEstudiantes($estudiantes_pg_array, $plantel_id_decoded, $seccion_plantel_id_decoded, $periodo['id'], $modulo, $inscripcion_regular_pg_array, $doble_inscripcion_pg_array);

                        $transaction->commit();
                        $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiante', 'EXITOSO', 'Ha matriculado la Seccion Plantel ' . $seccion_plantel_id);
                        $respuesta['statusCode'] = 'success';
                        $respuesta['id'] = base64_encode($seccion_plantel_id_decoded);
                        $respuesta['plantel'] = base64_encode($plantel_id_decoded);
                        $respuesta['mensaje'] = 'Estimado Usuario, el proceso de inscripción se ha realizado exitosamente.';
                        echo json_encode($respuesta);
                    } catch (Exception $ex) {
                        $transaction->rollback();
//throw $ex;
                        $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiante', 'FALLIDO', 'Ha intentado matricular la Seccion Plantel ' . $seccion_plantel_id);
                        $respuesta['statusCode'] = 'error';
                        $respuesta['error'] = $ex;
                        $respuesta['mensaje'] = 'Estimado Usuario, ha ocurrido un error durante el proceso de inscripción. Intente nuevamente.';
                        echo json_encode($respuesta);
                    }
                } else if ($materia_pendiente == '1') {
                    if ($observacion_decoded != '' AND $observacion_decoded != null) {
                        $periodo = PeriodoEscolar ::model()->getPeriodoActivo();
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            $estudiantes[] = $estudiante_id_decoded;
                            $materia_pendiente_array [] = (int) $materia_pendiente;
                            $inscripcion_regular_array[] = (int) 0;
                            $doble_inscripcion_array[] = (int) $doble_inscripcion;
                            $observacion_array [] = $observacion_decoded;

                            $estudiantes_pg_array = $this->to_pg_array($estudiantes);
                            $doble_inscripcion_pg_array = $this->to_pg_array($doble_inscripcion_array);
                            $inscripcion_regular_pg_array = $this->to_pg_array($inscripcion_regular_array);
                            $materia_pendiente_pg_array = $this->to_pg_array($materia_pendiente_array);
                            $observacion_pg_array = $this->to_pg_array($observacion_array);

                            $modulo = self::MODULO . 'InscribirEstudiante';
                            $resultadoInscripcion = Estudiante::model()->inscribirEstudiantes($estudiantes_pg_array, $plantel_id_decoded, $seccion_plantel_id_decoded, $periodo['id'], $modulo, $inscripcion_regular_pg_array, $doble_inscripcion_pg_array, '{0}', $materia_pendiente_pg_array, $observacion_pg_array);
                            $transaction->commit();
                            $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiante', 'EXITOSO', 'Ha matriculado la Seccion Plantel ' . $seccion_plantel_id);
                            $respuesta['statusCode'] = 'success';
                            $respuesta['id'] = base64_encode($seccion_plantel_id_decoded);
                            $respuesta['plantel'] = base64_encode($plantel_id_decoded);
                            $respuesta['mensaje'] = 'Estimado Usuario, el proceso de inscripción se ha realizado exitosamente.';
                            echo json_encode($respuesta);
                        } catch (Exception $ex) {
                            $transaction->rollback();
//throw $ex;
                            $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiante', 'FALLIDO', 'Ha intentado matricular la Seccion Plantel ' . $seccion_plantel_id);
                            $respuesta['statusCode'] = 'error';
                            $respuesta['error'] = $ex;
                            $respuesta['mensaje'] = 'Estimado Usuario, ha ocurrido un error durante el proceso de inscripción. Intente nuevamente.';
                            echo json_encode($respuesta);
                        }
                    } else {
                        $mensaje = "Estimado Usuario, el campo Observación no puede estar vacio si la escolaridad es Materia Pendiente.";
                        $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiante', 'FALLIDO', 'Ha intentado matricular la Seccion Plantel ' . $seccion_plantel_id);
                        $respuesta['statusCode'] = 'mensaje';
                        $respuesta['mensaje'] = $mensaje;
                        echo json_encode($respuesta);
                    }
                } else {
                    $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiante', 'FALLIDO', 'Ha intentado matricular la Seccion Plantel ' . $seccion_plantel_id);
                    $respuesta['statusCode'] = 'mensaje';
                    $respuesta['mensaje'] = 'Estimado Usuario, debe seleccionar una opción.';
                    echo json_encode($respuesta);
                }
            }
        } else
            throw new CHttpException(404, 'Estimado Usuario, usted no esta autorizado para acceder mediante esta via.');
    }

    public function actionPreCaracterizarInscripcion() {
        if (Yii::app()->request->isAjaxRequest) {
            $plantel_id = $_REQUEST['plantel_id'];
            $seccion_plantel_id = $_REQUEST['seccion_plantel_id'];
            $inscritos = json_decode($_REQUEST['inscritos'], true);
            $plantel_id_decoded = $plantel_id;

            if (is_numeric($plantel_id_decoded) AND is_array($inscritos)) {

                $codigo = $this->generarLetra();

                Yii::app()->getSession()->add($codigo, $inscritos);
                Yii::app()->getSession()->add('seccion_plantel_id', $seccion_plantel_id);
                Yii::app()->getSession()->add('plantel_id', $plantel_id);

                echo json_encode(array('codigo' => base64_encode($codigo)));
                $this->registerLog('LECTURA', self::MODULO . 'PreCaracterizarInscripcion', 'EXITOSO', 'Entró a la acción pivote para transmitir los estudiantes a la ultima fase de Matriculación de la Seccion Plantel' . $seccion_plantel_id);
                Yii::app()->end();
            } else
                throw new CHttpException(404, 'No se ha encontrado el recurso que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // no es numerico
        } else
            throw new CHttpException(404, 'Estimado Usuario, usted no esta autorizado para acceder mediante esta via.');
    }

    public function actionCaracterizarInscripcionIndividual() {
        if (Yii::app()->request->isAjaxRequest) {

            $plantel_id = $this->getRequest('plantel_id');
            $seccion_plantel_id = $this->getRequest('seccion_plantel_id');
            $estudiante_id = $this->getRequest('estudiante_id');

            $plantel_id_decoded = base64_decode($plantel_id);
            $seccion_plantel_id_decoded = base64_decode($seccion_plantel_id);
            $estudiante_id_decoded = base64_decode($estudiante_id);
            if (is_numeric($plantel_id_decoded) AND is_numeric($seccion_plantel_id_decoded) AND is_numeric($estudiante_id_decoded)) {

                $estudiante = Estudiante::model()->getDatosEstudiante($estudiante_id_decoded);
                //  $asignaturas = Estudiante::model()->getDatosEstudiante($estudiante_id_decoded);
                if ($estudiante != null) {
                    Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                    $this->renderPartial('_caracterizarInscripcionIndividual', array(
                        'estudiante_id' => $estudiante_id,
                        'plantel_id' => $plantel_id,
                        'seccion_plantel_id' => $seccion_plantel_id,
                        'estudiante' => $estudiante), FALSE, TRUE);
                    Yii::app()->end();
                }


                $this->registerLog('LECTURA', self::MODULO . 'CaracterizarInscripcionIndividual', 'EXITOSO', 'Entró a la acción pivote para transmitir los estudiantes a la ultima fase de Matriculación de la Seccion Plantel' . $seccion_plantel_id);
                Yii::app()->end();
            } else
                throw new CHttpException(404, 'No se ha encontrado el recurso que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // no es numerico
        } else
            throw new CHttpException(404, 'Estimado Usuario, usted no esta autorizado para acceder mediante esta via.');
    }

    public function actionInscribirEstudiantes() {
        if (Yii::app()->request->isAjaxRequest) {
            $inscritos = json_decode($_REQUEST['inscritos'], true);
            $plantel_id = $_REQUEST['plantel_id'];
            $seccion_plantel_id = $_REQUEST['seccion_plantel_id'];
            //$inscripcionRegular = $_REQUEST['checkboxValuesRG'];
            $plantel_id_decoded = base64_decode($plantel_id);
            $seccion_plantel_id_decoded = base64_decode($seccion_plantel_id);
            $estudiantes = array();

            if (is_numeric($plantel_id_decoded) && is_array($inscritos) && count($inscritos) > 0 && is_numeric($seccion_plantel_id_decoded)) {

                $periodo = PeriodoEscolar ::model()->getPeriodoActivo();
//$seccion_plantel_periodo_id = SeccionPlantelPeriodo::model()->obtenerSeccionPeriodoId($seccion_plantel_id, $periodo['id']);
                $transaction = Yii::app()->db->beginTransaction();
                foreach ($inscritos as $key => $value) {
                    $estudiantes[] = $value['id'];
                }
                try {
                    $estudiantes_pg_array = $this->to_pg_array($estudiantes);
                    $modulo = self::MODULO . 'InscribirEstudiantes';
                    $resultadoInscripcion = Estudiante::model()->inscribirEstudiantes($estudiantes_pg_array, $plantel_id_decoded, $seccion_plantel_id_decoded, $periodo['id'], $modulo);
//                    $seccion_plantel_periodo_id = $modelSecccionPlantelPeriodo->crearSeccionPlantelPeriodo($seccion_plantel_id, $periodo['id']);
//
//                    foreach ($inscritos as $key => $value) {
//                        $model = new InscripcionEstudiante();
//                        $modelEstudiante = new Estudiante();
//                        $modelEstudiante->id = $value['id'];
//                        $modelEstudiante->fecha_act = $fecha_hora;
//                        $modelEstudiante->usuario_act_id = $usuario_act_id;
//                        $modelEstudiante->plantel_actual_id = $plantel_id;
//                        $resultadoActualizacionEstud = $modelEstudiante->actualizarDatosEstudiantes($modelEstudiante);
//                        if ($resultadoActualizacionEstud) {
//
//                            $modelAsignaturaEstudiante = new AsignaturaEstudiante();
//
//                            $model->seccion_plantel_periodo_id = $seccion_plantel_periodo_id;
//                            $model->estudiante_id = $value['id'];
//                            $model->estatus = 'A';
//                            $model->fecha_ini = $fecha_hora;
//                            $model->usuario_ini_id = $usuario_act_id;
//                            $model->inscripcion_regular = $inscripcionRegular[$key];
//                            if ($model->save()) {
//                                $asignaturas = PlanesGradosAsignaturas::model()->getGradoPlanSeccion($seccion_plantel_id);
//                                foreach ($asignaturas as $key => $asignatura_id) {
//                                    $modelAsignaturaEstudiante->unsetAttributes();
//                                    $modelAsignaturaEstudiante->inscripcion_id = $model->id;
//                                    $modelAsignaturaEstudiante->asignatura_id = $asignatura_id;
//                                    $modelAsignaturaEstudiante->estatus = 'A';
//                                    $modelAsignaturaEstudiante->fecha_ini = $fecha_hora;
//                                    $modelAsignaturaEstudiante->usuario_ini_id = $usuario_act_id;
//                                    $modelAsignaturaEstudiante->save();
//                                }
//                            }
//                        }
//                    }

                    $transaction->commit();
                    $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiantes', 'EXITOSO', 'Ha matriculado la Seccion Plantel ' . $seccion_plantel_id);
                    $respuesta['statusCode'] = 'success';
                    $respuesta['id'] = base64_encode($seccion_plantel_id_decoded);
                    $respuesta['plantel'] = base64_encode($plantel_id_decoded);
                    $respuesta['mensaje'] = 'Estimado Usuario, el proceso de inscripción se ha realizado exitosamente.';
                    echo json_encode($respuesta);
                } catch (Exception $ex) {
                    $transaction->rollback();
//throw $ex;
                    $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiantes', 'FALLIDO', 'Ha intentado matricular la Seccion Plantel ' . $seccion_plantel_id);
                    $respuesta['statusCode'] = 'error';
                    $respuesta['error'] = $ex;
                    $respuesta['mensaje'] = 'Estimado Usuario, ha ocurrido un error durante el proceso de inscripción. Intente nuevamente.';
                    echo json_encode($respuesta);
                }
            } else
                throw new CHttpException(404, 'No se ha encontrado el recurso que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
        } else
            throw new CHttpException(404, 'Estimado Usuario, usted no esta autorizado para acceder mediante esta via.');
    }

    public function actionInscribirEstudiantesIndividual() {

        if (!empty($_REQUEST['id_incluir'])) {
            $id_estudiante = $_REQUEST['id_incluir'];
            $periodo = PeriodoEscolar ::model()->getPeriodoActivo();

            $seccion_plantel_id = $_POST["seccion_plantel_id"];
            $seccion_plantel_periodo = SeccionPlantelPeriodo::model()->consultarSeccionPeriodoId($seccion_plantel_id, $periodo['id']);
            $modelEstudiante = Estudiante::model()->findByPk($id_estudiante);
            $modelEstudiante->usuario_act_id = Yii::app()->user->id;
            $modelEstudiante->fecha_act = date("Y-m-d H:i:s");
            $modelEstudiante->estatus = "A";
            $modelEstudiante->plantel_actual_id = $_POST["plantel_id"];
            $modelEstudiante->estatus_id = 1;


            $estudiantes_pg_array = $this->to_pg_array($id_estudiante);
            $modulo = self::MODULO . 'InscribirEstudiantesIndividual';
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $resultadoInscripcion = Estudiante::model()->inscribirEstudiantes($estudiantes_pg_array, (int) $_POST["plantel_id"], (int) $seccion_plantel_id, (int) $periodo['id'], $modulo);
                $transaction->commit();
                $this->registerLog('ESCRITURA', 'InscribirEstudiantesIndividual', 'EXITOSO', 'Ha matriculado la Seccion Plantel');
                $respuesta['statusCode'] = 'success';
                $respuesta['id'] = base64_encode($seccion_plantel_id);
                $respuesta['plantel'] = $_POST["plantel_id"];
                $respuesta['mensaje'] = 'Estimado Usuario, el proceso de inscripción se ha realizado exitosamente.';
                header('Cache-Control: no-cache, must-revalidate');
                header('Content-type: application/json');
                echo json_encode($respuesta);
            } catch (Exception $ex) {
                $transaction->rollback();
                //throw $ex;
                $this->registerLog('ESCRITURA', 'InscribirEstudiantesIndividual', 'FALLIDO', 'Ha intentado matricular la Seccion Plantel ');
                $respuesta['statusCode'] = 'error';
                $respuesta['error'] = $ex;
                $respuesta['mensaje'] = 'Estimado Usuario, ha ocurrido un error durante el proceso de inscripción. Intente nuevamente.';
                header('Cache-Control: no-cache, must-revalidate');
                header('Content-type: application/json');
                echo json_encode($respuesta);
            }
        }
    }

    public function gridEstudiantesInscritosIndividual($seccion) {
        if (empty($seccion)) {
            $seccion = "";
        }

        $existeSeccionPlantelPeriodo = SeccionPlantel::model()->existeEstudiantesInscriptosEnSeccion($seccion);
        $totalInscritos = seccionPlantel::model()->calcularInscritosPorSeccion($seccion);
        $dataProvider = $this->dataProviderEstudiantesInscriptos($existeSeccionPlantelPeriodo);
        return $dataProvider;
    }

    public function actionCaracterizarInscripcion() {
        if (array_key_exists('c', $_REQUEST)) {
            $codigo = $_REQUEST['c'];
            $codigo_dedoded = base64_decode($codigo);
            $inscritos = Yii::app()->getSession()->get($codigo_dedoded);
            $seccion_plantel_id = (int) Yii::app()->getSession()->get('seccion_plantel_id');
            $plantel_id = (int) Yii::app()->getSession()->get('plantel_id');

//            Yii::app()->getSession()->remove('inscritos');
//            Yii::app()->getSession()->remove('plantel_id');
//            Yii::app()->getSession()->remove('seccion_plantel_id');

            $dataSeccion = SeccionPlantel::obtenerDatosSeccion($seccion_plantel_id, $plantel_id);
            $dataPlantel = Plantel::model()->obtenerDatosIdentificacion($plantel_id);
            $resultDataProvider = $this->dataProviderEstudiantesPreInscritos($inscritos, $seccion_plantel_id, $plantel_id);
            $acciones = $resultDataProvider[0];
            $dataProvider = $resultDataProvider[1];
            $this->registerLog('LECTURA', self::MODULO . 'CaracterizarInscripcion', 'EXITOSO', 'Entró en la ultima fase de matriculación de la Seccion Plantel' . $seccion_plantel_id);
            $this->render('caracterizarInscripcion', array(
                'plantel_id' => base64_encode($plantel_id),
                'seccion_plantel_id' => base64_encode($seccion_plantel_id),
                'datosSeccion' => $dataSeccion,
                'datosPlantel' => $dataPlantel,
                'dataProvider' => $dataProvider,
                'acciones' => $acciones,
                'inscritos' => json_encode($inscritos)
            ));
        }
    }

    /* ------------------------------------------------- JEAN----------------------------------- */

    public function actionIncluirEstudiante() { // Muestro dialogo para realizar busqueda del estudiante
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Estudiante;
            $seccion_plantel_id = $_POST['seccion_plantel_id'];
            $plantel_id = $_POST['plantel_id'];
            $inscritos = $_POST['inscritos'];
            $individual = $this->getRequest('individual', false);
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                $this->renderPartial('incluirEstudiante', array('model' => $model,
                    'inscritos' => $inscritos,
                    'plantel_id' => $plantel_id,
                    'individual' => $individual,
                    'seccion_plantel_id' => $seccion_plantel_id), FALSE, TRUE);
                yii::app()->end();
            }
        } else
            throw new CHttpException(404, 'Estimado Usuario, usted no esta autorizado para acceder mediante esta via.');
    }

    public function actionBuscarEstudiante() { // Realizo la busqueda del estudiante
        if (Yii::app()->request->isAjaxRequest) {
            $modelEstuadiante = $_REQUEST;
            $individual = $this->getRequest('individual', false);
            $inscriptos = $modelEstuadiante['inscritos'];
            $probarIncriptos = json_decode($inscriptos, true);
            $busquedaCompleta = $modelEstuadiante['busquedaCompleta'];
            $seccion_plantel_id = $modelEstuadiante['seccion_plantel_id'];
            $plantel_id = $_REQUEST['plantel_id'];
            if ($busquedaCompleta == 0 || $busquedaCompleta == 1) {

                //      var_dump($modelEstuadiante);


                if ($inscriptos == '[]') { // Esta validación se produce cuando se comprueba que no exita el mismo estudiante incluido
                    $mensaje = '';

                    if ($modelEstuadiante['cedula_escolar'] == '' and $modelEstuadiante['cedula_identidad'] == '' and $modelEstuadiante['nombres'] == '' and $modelEstuadiante['apellidos'] == '' and $modelEstuadiante['ci_representante'] == '') {
                        $mensaje = 'Por favor ingrese algún dato para realizar la busqueda <br>';
                        echo json_encode(array('statusCode' => 'alert', 'mensaje' => $mensaje));
                    } else {


                        if (is_numeric($modelEstuadiante['cedula_escolar']) || $modelEstuadiante['cedula_escolar'] == '') {

                            $cedulaEscolar = $modelEstuadiante['cedula_escolar'];
                        } else {

                            $mensaje.='Por favor ingrese el dato correcto para el campo cedula escolar <br>';
                        }

                        if (is_numeric($modelEstuadiante['cedula_identidad']) || $modelEstuadiante['cedula_identidad'] == '') {
                            $cedulaIdentidad = $modelEstuadiante['cedula_identidad'];
                        } else {

                            $mensaje.='Por favor ingrese el dato correcto para el campo cedula identidad <br>';
                        }

                        if (!is_numeric($modelEstuadiante['nombres']) || $modelEstuadiante['nombres'] == '') {
                            $nombres = $modelEstuadiante['nombres'];
                            //  var_dump($nombres);
                            //compruebo que los caracteres sean los permitidos
                            if ($nombres != '') {
                                $permitidos = "ABCDEFGHIJKLMNOPQRSTUVWXYZÁÉÍÓÚ";
                                for ($i = 0; $i < strlen($nombres); $i++) {
                                    if (strpos($permitidos, substr($nombres, $i, 1)) === false) {
                                        //  echo $nombres . " no es válido<br>";
                                        $resultado = false;
                                    } else {
                                        //echo $nombres . " es válido<br>";
                                        $nombres = $nombres;
                                        $resultado = true;
                                    }
                                }
                                if ($resultado == false) {
                                    $mensaje.='Por favor ingrese los datos correctos para el campo nombres del estudiante debe contener solo letras<br>';
                                }
                            }
                        } else {

                            $mensaje.='Por favor ingrese el dato correcto para el campo nombre <br>';
                        }

                        if (!is_numeric($modelEstuadiante['apellidos']) || $modelEstuadiante['apellidos'] == '') {
                            $apellidos = $modelEstuadiante['apellidos'];
                            //compruebo que los caracteres sean los permitidos
                            // var_dump($apellidos);
                            if ($apellidos != '') {
                                $permitidos = "ABCDEFGHIJKLMNOPQRSTUVWXYZÁÉÍÓÚ";
                                for ($i = 0; $i < strlen($apellidos); $i++) {
                                    if (strpos($permitidos, substr($apellidos, $i, 1)) === false) {
                                        // echo $apellidos . " no es válido<br>";
                                        $resultado = false;
                                    } else {
                                        //echo $apellidos . " es válido<br>";
                                        $apellidos = $apellidos;
                                        $resultado = true;
                                    }
                                }
                                if ($resultado == false) {
                                    $mensaje.='Por favor ingrese los datos correctos para el campo apellidos del estudiante debe contener solo letras<br>';
                                }
                            }
                        } else {

                            $mensaje.='Por favor ingrese el dato correcto para el campo apellido <br>';
                        }

                        if (is_numeric($modelEstuadiante['ci_representante']) || $modelEstuadiante['ci_representante'] == '') {
                            $cedulaRepre = $modelEstuadiante['ci_representante'];
                        } else {
                            $mensaje.='Por favor ingrese el dato correcto para el campo cedula representante <br>';
                        }

                        if (($modelEstuadiante['nombres']) != '') {
                            if (($modelEstuadiante['apellidos']) == '') {
                                $mensaje.='Para ingresar una búsqueda por nombre debe ingresar el apellido del estudiante tambien, Por favor ingrese el dato requerido<br>';
                            }
                        } else {
                            if (($modelEstuadiante['apellidos']) != '') {
                                $mensaje.='Para ingresar una búsqueda por apellido debe ingresar el nombre del estudiante tambien, Por favor ingrese el dato requerido<br>';
                            }
                        }

                        if ($mensaje == '') {
                            $modelBuscar = '';
                            $verificacion = '';
                            list($modelBuscar, $verificacion) = Estudiante::model()->buscarEstudiante($cedulaEscolar, $cedulaIdentidad, $nombres, $apellidos, $cedulaRepre, $busquedaCompleta, $seccion_plantel_id, $plantel_id);

                            $this->registerLog('LECTURA', 'planteles.matricula.BuscarEstudiante', 'EXITOSO', 'Busqueda de los datos del estudiante y su respresentante');
                            //   var_dump($modelBuscar);
                            if ($verificacion == 0) {
                                if ($modelBuscar != '1' && $modelBuscar != false) {
                                    $dataObtenida = $this->dataProviderEstudiante($modelBuscar, $individual);
                                    $seccion_plantel_id = $modelEstuadiante['seccion_plantel_id'];
                                    $plantel_id = $_POST['plantel_id'];
                                    // var_dump($plantel_id);
                                    Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                                    $this->renderPartial('buscarEstudiante', array('dataProvider' => $dataObtenida,
                                        'inscriptos' => $inscriptos,
                                        'seccion_plantel_id' => $seccion_plantel_id,
                                        'plantel_id' => $plantel_id
                                            ), FALSE, TRUE);
                                } else {

                                    if ($modelBuscar == '1') {
                                        $mensaje = 'Ha ocurrido un error, por favor inicie sesión nuevamente';
                                        echo json_encode(array('statusCode' => 'alert', 'mensaje' => $mensaje));
                                    }
                                    if ($modelBuscar == false) {
                                        $mensaje = 'No se encontro el estudiante que desea buscar';
                                        $conseguido = 1;
                                        echo json_encode(array('statusCode' => 'alert', 'mensaje' => $mensaje, 'conseguido' => $conseguido));
                                    }
                                }
                            } else {
                                //        var_dump($modelBuscar);
//                                die();
                                $nombre = $modelBuscar[0]['nombre_estudiante'];
                                $apellido = $modelBuscar[0]['apellido_estudiante'];
                                $nombrePlantel = $modelBuscar[0]['nombre_plantel'];
                                $cod_estadistico = $modelBuscar[0]['codigo_estadistico'];
                                $seccion = $modelBuscar[0]['nombre_seccion'];
                                $grado = $modelBuscar[0]['nombre_grado'];
                                $mensaje = " El estudiante $nombre $apellido  ya se encuentra inscrito en el plantel $nombrePlantel con código estadistico $cod_estadistico en la sección y grado $seccion $grado";
                                echo json_encode(array('statusCode' => 'alert', 'mensaje' => $mensaje));
                            }
                        } else {
                            echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                        }
                    }
                } else { // entra aqui cuando busca un estudiante por segunda vez
                    $mensaje = '';
                    if ($modelEstuadiante['cedula_escolar'] == '' and $modelEstuadiante['cedula_identidad'] == '' and $modelEstuadiante['nombres'] == '' and $modelEstuadiante['apellidos'] == '' and $modelEstuadiante['ci_representante'] == '') {
                        $mensaje = 'Por favor ingrese algún dato para realizar la búsqueda <br>';
                        echo json_encode(array('statusCode' => 'alert', 'mensaje' => $mensaje));
                    } else {


                        if (is_numeric($modelEstuadiante['cedula_escolar']) || $modelEstuadiante['cedula_escolar'] == '') {

                            $cedulaEscolar = $modelEstuadiante['cedula_escolar'];
                        } else {

                            $mensaje.='Por favor ingrese el dato correcto para el campo cédula escolar <br>';
                        }

                        if (is_numeric($modelEstuadiante['cedula_identidad']) || $modelEstuadiante['cedula_identidad'] == '') {
                            $cedulaIdentidad = $modelEstuadiante['cedula_identidad'];
                        } else {

                            $mensaje.='Por favor ingrese el dato correcto para el campo cédula identidad <br>';
                        }

                        if (!is_numeric($modelEstuadiante['nombres']) || $modelEstuadiante['nombres'] == '') {
                            $nombres = $modelEstuadiante['nombres'];
                            //  var_dump($nombres);
                            //compruebo que los caracteres sean los permitidos
                            if ($nombres != '') {
                                $permitidos = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                                for ($i = 0; $i < strlen($nombres); $i++) {
                                    if (strpos($permitidos, substr($nombres, $i, 1)) === false) {
                                        //  echo $nombres . " no es válido<br>";
                                        $resultado = false;
                                    } else {
                                        //echo $nombres . " es válido<br>";
                                        $nombres = $nombres;
                                        $resultado = true;
                                    }
                                }
                                if ($resultado == false) {
                                    $mensaje.='Por favor ingrese los datos correctos para el campo nombres del estudiante debe contener solo letras<br>';
                                }
                            }
                        } else {

                            $mensaje.='Por favor ingrese el dato correcto para el campo nombre <br>';
                        }

                        if (!is_numeric($modelEstuadiante['apellidos']) || $modelEstuadiante['apellidos'] == '') {
                            $apellidos = $modelEstuadiante['apellidos'];
                            //compruebo que los caracteres sean los permitidos
                            // var_dump($apellidos);
                            if ($apellidos != '') {
                                $permitidos = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                                for ($i = 0; $i < strlen($apellidos); $i++) {
                                    if (strpos($permitidos, substr($apellidos, $i, 1)) === false) {
                                        // echo $apellidos . " no es válido<br>";
                                        $resultado = false;
                                    } else {
                                        //echo $apellidos . " es válido<br>";
                                        $apellidos = $apellidos;
                                        $resultado = true;
                                    }
                                }
                                if ($resultado == false) {
                                    $mensaje.='Por favor ingrese los datos correctos para el campo apellidos del estudiante debe contener solo letras<br>';
                                }
                            }
                        } else {

                            $mensaje.='Por favor ingrese el dato correcto para el campo apellido <br>';
                        }

                        if (is_numeric($modelEstuadiante['ci_representante']) || $modelEstuadiante['ci_representante'] == '') {
                            $cedulaRepre = $modelEstuadiante['ci_representante'];
                        } else {
                            $mensaje.='Por favor ingrese el dato correcto para el campo cédula representante <br>';
                        }

                        if (($modelEstuadiante['nombres']) != '') {
                            if (($modelEstuadiante['apellidos']) == '') {
                                $mensaje.='Para ingresar una búsqueda por nombre debe ingresar el apellido del estudiante tambien, Por favor ingrese el dato requerido<br>';
                            }
                        } else {
                            if (($modelEstuadiante['apellidos']) != '') {
                                $mensaje.='Para ingresar una búsqueda por apellido debe ingresar el nombre del estudiante tambien, Por favor ingrese el dato requerido<br>';
                            }
                        }

                        if ($mensaje == '') {
                            $modelBuscar = '';
                            $verificacion = '';
                            list($modelBuscar, $verificacion) = Estudiante::model()->buscarEstudiante($cedulaEscolar, $cedulaIdentidad, $nombres, $apellidos, $cedulaRepre, $busquedaCompleta, $seccion_plantel_id, $plantel_id);
                            $this->registerLog('LECTURA', 'planteles.matricula.BuscarEstudiante', 'EXITOSO', 'Busqueda de los datos del estudiante y su respresentante');
                            // var_dump($modelBuscar);
                            $existe = false;
                            if ($verificacion == 0) {
                                if ($modelBuscar != '1' && $modelBuscar != false) {
                                    $arregloEstudiantes = array();
                                    foreach ($probarIncriptos as $value) {
                                        $estudiant_id = $value['id'];

                                        foreach ($modelBuscar as $buscar) {
                                            $estudBusqueda = $buscar['id'];
                                            if ($estudiant_id == $estudBusqueda) {
                                                $existe = true;
                                                break;

//                                            var_dump($arregloEstudiantes);
//                                            die();
//                                            $arregloEstudiantes = array_unique($arregloEstudiantes);
                                            } else {
                                                $arregloEstudiantes = array();
                                            }
                                        }
                                    }

                                    if ($existe) {
                                        $arregloEstudiantes = array();
                                    } else {
                                        $arregloEstudiantes[] = array(
                                            'id' => $estudBusqueda,
                                            'cedula_escolar' => $modelBuscar[0]['cedula_escolar'],
                                            'cedula_identidad' => $modelBuscar[0]['cedula_identidad'],
                                            'nombres' => $modelBuscar[0]['nombres'],
                                            'apellidos' => $modelBuscar[0]['apellidos'],
                                            'plantel_nombre' => $modelBuscar[0]['plantel_nombre'],
                                            'cod_plantel' => $modelBuscar[0]['cod_plantel']
                                        );
                                    }

                                    //var_dump($arregloEstudiantes);

                                    if ($arregloEstudiantes == array()) { // Valida que el estudiante que busco no sea igual al que esta atras, para matricular
                                        $mensaje = '';
                                        $mensaje .='Este estudiante ya se encuentra incluído por favor intente con otro estudiante';
                                        echo json_encode(array('statusCode' => 'alert', 'mensaje' => $mensaje));
                                    } else {
                                        //   var_dump($arregloEstudiantes);
                                        //die();
                                        $dataObtenida = $this->dataProviderEstudiante($arregloEstudiantes, $individual); // Pinta el cuadro que muestro en el dialogo, con la busqueda del estudiante y sus datos
                                        $seccion_plantel_id = $modelEstuadiante['seccion_plantel_id'];
                                        $plantel_id = $_GET['plantel_id'];

                                        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                                        $this->renderPartial('buscarEstudiante', array('dataProvider' => $dataObtenida,
                                            'inscriptos' => $inscriptos,
                                            'seccion_plantel_id' => $seccion_plantel_id,
                                            'plantel_id' => $plantel_id
                                                ), FALSE, TRUE);
                                    }
                                } else {
                                    if ($modelBuscar == '1') {
                                        $mensaje = 'Ha ocurrido un error, por favor inicie sesión nuevamente';
                                        echo json_encode(array('statusCode' => 'alert', 'mensaje' => $mensaje));
                                    }
                                    if ($modelBuscar == false) {
                                        $mensaje = 'No se encontro el estudiante que desea buscar';
                                        echo json_encode(array('statusCode' => 'alert', 'mensaje' => $mensaje));
                                    }
                                }
                            } else {

                                $nombre = $modelBuscar['nombre_estudiante'];
                                $apellido = $modelBuscar['apellido_estudiante'];
                                $nombrePlantel == $modelBuscar['codigo_estadistico'];
                                $seccion = $modelBuscar['nombre_seccion'];
                                $grado = $modelBuscar['nombre_grado'];
                                $mensaje = " El estudiante $nombre $apellido  ya se encuentra inscrito en $nombrePlantel en la sección y grado $seccion $grado";
                                echo json_encode(array('statusCode' => 'alert', 'mensaje' => $mensaje));
                            }
                        } else {
                            echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
                        }
                    }
                }
            } else {
                $mensaje = 'Incorrecto dato de Búsqueda Completa, Intente nuevamente';
                echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
            }
        } else {
            throw new CHttpException(404, 'Estimado Usuario, usted no esta autorizado para acceder mediante esta via.');
        }
    }

    public function columnaAcciones($data) {
        $estatus = $data["estatus"];
        $capacidad = isset($data['capacidad']) ? $data['capacidad'] : null;
        $columna = '<div class="action-buttons">';
        $nivel_id = isset($data['nivel_id']) ? $data['nivel_id'] : null;
        $grado_id = isset($data['grado_id']) ? $data['grado_id'] : null;
        $data_description = is_object($data->seccion) ? $data->seccion->nombre : '';
        $ultimoGrado = Grado::model()->obtenerUltimoGradoNivel($nivel_id, $grado_id);
        if ($grado_id == $ultimoGrado) {
            if (($estatus == 'A')) {
                $datosSeccion = SeccionPlantel::model()->existeEstudiantesInscritosEnSeccion($data->id);
                $columna .= CHtml::link("", "/planteles/matricula/inscripcion/id/" . base64_encode($data->id) . "/plantel/" . base64_encode($data->plantel_id), array("class" => "fa fa-users orange inscribir", 'data-id' => base64_encode($data->id), 'data-description' => $data_description, "title" => "Inscripcion Inicial de Estudiantes")) . '&nbsp;&nbsp;';

                $columna .= CHtml::link("", "/planteles/matricula/inscripcionIndividual/id/" . base64_encode($data->id) . "/plantel/" . base64_encode($data->plantel_id) . "/key/" . base64_encode($data->plantel_id * 9), array("class" => "fa fa-user blue inscribir", 'data-id' => base64_encode($data->id), 'data-description' => $data_description, "title" => "Inscribir Estudiante")) . '&nbsp;&nbsp;';
            }
        }

        $columna .= '</div>';


        return $columna;
    }

    public function actionCambiarEstatus() {

        $accion = $this->getPost('accion');
        $id = $this->getPost('id');
        $inscripcion_id = $this->getPost('inscripcion_id');

        if (in_array($accion, array('E', 'A'))) {

            $idDecoded = base64_decode($id);

            $estudiante = new Estudiante();

            if (is_numeric($idDecoded)) {

                $model = Estudiante::model()->findByPk($idDecoded);

                if ($model) {

                    $result = $estudiante->cambiarEstatusEstudiante($idDecoded, $accion, $inscripcion_id);

                    if ($result->isSuccess) {

                        if ($accion == 'E') {
                            $this->registerLog('ELIMINACION', 'planteles.matricula.CambiarEstatus', 'EXITOSO', 'Se ha Inactivado el Estudiante ' . $model->id);
                        } else {
                            $this->registerLog('ESCRITURA', 'planteles.matricula.CambiarEstatus', 'EXITOSO', 'Se ha Activado el Estudiante ' . $model->id);
                        }

                        $class = 'successDialogBox';
                        $message = $result->message;

                        $this->renderPartial('//msgBox', array(
                            'class' => $class,
                            'message' => $message,
                        ));
                    } else {
                        throw new CHttpException(500, 'Error: No se ha podido completar la operación, comuniquelo al administrador del sistema para su corrección.');
                    }
                } else {
                    throw new CHttpException(404, 'No se ha encontrado el Estudiante que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
                }
            } else {
                throw new CHttpException(404, 'No se ha encontrado el Estudiante que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
            }
        } else {
            $class = 'errorDialogBox';
            $message = 'No se ha especificado la acción a tomar sobre el estudiante, recargue la página e intentelo de nuevo.';

            $this->renderPartial('//msgBox', array(
                'class' => $class,
                'message' => $message,
            ));
        }
    }

    public function columnaAccionesIndividual($data) {
        $estatus = $data["estatus"];
        $id = $data["id"];
        $columna = '<div class="action-buttons center">';


        if (Yii::app()->user->pbac('admin'))
            if (($estatus == 'A')) {
                $descripcion = '';
                $inscripcion_id = '';
                $nombre_apellido = (isset($data['nomape']) AND $data['nomape'] != '' AND $data['nomape'] != null ) ? $data['nomape'] : '';
                $cedula_escolar = (isset($data['cedula_escolar']) AND $data['cedula_escolar'] != '' AND $data['cedula_escolar'] != null ) ? $data['cedula_escolar'] : '';
                $cedula_identidad = (isset($data['cedula_identidad']) AND $data['cedula_identidad'] != '' ) ? $data['cedula_identidad'] : '';
                $inscripcion_id = (isset($data['inscripcion_id']) AND $data['inscripcion_id'] != '' ) ? $data['inscripcion_id'] : '';

                if ($cedula_identidad != '' AND $cedula_identidad != null) {
                    $descripcion = $nombre_apellido . ' - C.I: ' . $cedula_identidad;
                } else {
                    if ($cedula_escolar != '' AND $cedula_escolar != null) {
                        $descripcion = $nombre_apellido . ' - C.E: ' . $cedula_escolar;
                    }
                }
                $columna .= CHtml::link("", "", array("class" => "fa fa-trash-o red change-status", 'data-id' => base64_encode($id), 'data-action' => 'E', 'data-descripcion' => $descripcion, 'data-inscripcion_id' => $inscripcion_id, "title" => "Excluir Estudiante")) . '&nbsp;&nbsp;';
            }
//            else
//            if (($estatus == 'E')) {
//                $columna .= CHtml::link("", "", array("class" => "fa fa-check blue", 'data-id' => base64_encode($id), "title" => "Inscripcion Inicial de Estudiantes")) . '&nbsp;&nbsp;';
//            }

        $columna .= '</div>';

        return $columna;
    }

    public function filtrarEstudiantesPorInscribir($estudiantes, $estudiantes_a_incluir) {
        if (count($estudiantes_a_incluir) > 0) {
            $estudiantes_pendientes = array();
            $existe = false;
            $cant = count($estudiantes_a_incluir) - 1;
            foreach ($estudiantes as $key => $value) {
                foreach ($estudiantes_a_incluir as $key2 => $value2) {
                    if ($value['id'] == $value2['id']) {
                        $existe = true;
                        break;
                    } else {
                        $existe = false;
                    }
                    if ($existe == false && $key2 == $cant) {
                        $estudiantes_pendientes[$key] = $estudiantes[$key];
                    }
                }
            }

            return $estudiantes_pendientes;
        } else
            return $estudiantes;
    }

    public function combinarArreglosEstudiantes($inscritos, $estudiantes_a_incluir) {
        if (count($inscritos) > 0) {
            foreach ($estudiantes_a_incluir as $key => $value) {
                $inscritos[] = $value;
            }
            return $inscritos;
        } else
            return $estudiantes_a_incluir;
    }

    public function eliminarEstudiantesInscritos($inscritos, $estudiantes_a_excluir) {
        //var_dump($inscritos, $estudiantes_a_excluir);

        foreach ($estudiantes_a_excluir as $key => $value) {
            //var_dump($value);
            foreach ($inscritos as $key2 => $value2) {
                //var_dump($value2);
                if ($value['id'] == $value2['id']) {
                    unset($inscritos[$key2]);
                    break;
                }
            }
        }
        //var_dump($inscritos); echo "<br><br>";
        //var_dump($this->ordenarArreglo($inscritos));

        return $this->ordenarArreglo($inscritos);
    }

    public function ordenarArreglo($inscritos) {
        $inscritos_nuevo = array();
        foreach ($inscritos as $key => $value) {
            $inscritos_nuevo[] = $value;
        }
        return $inscritos_nuevo;
    }

    public function dataProviderEstudiantesPorInscribir($estudiantes) {
        $rawData = array();
        $identificacion = '';
        if ($estudiantes != array()) {
            foreach ($estudiantes as $key => $value) {
                $identificacion = '';
                $edad_calculada = Estudiante::model()->calcularEdad($value['fecha_nacimiento']);
                $boton = '<div class="center">' . CHtml::checkBox('estudiantes[]', false, array('id' => 'estudiantes[]', 'value' => base64_encode($value['id']))) . "</div>";
                //$cedula_escolar = "<div class='center'>" . $value['cedula_escolar'] . "</div>";
                $edad = "<div class='center'>" . $edad_calculada . "</div>";
// $edad = "<div class='center'>" . $value[''] . "</div>";
                $nom_completo = '<div class="center">' . $value['nom_completo'] . '</div>';
                //$cedula_identidad = "<div class='center'>" . $value['cedula_identidad'] . "</div>";

                if (isset($value['cedula_identidad']) AND $value['cedula_identidad'] != '') {
                    $identificacion = "<div class='center'>C.I: " . $value['cedula_identidad'] . "</div>";
                }
                if (isset($value['cedula_escolar']) AND $value['cedula_escolar'] != '') {
                    if ($identificacion != '')
                        $identificacion .= "<br><div class='center'>C.E: " . $value['cedula_escolar'] . "</div>";
                    else
                        $identificacion = "<div class='center'>C.E: " . $value['cedula_escolar'] . "</div>";
                }
                $rawData [] = array(
                    'id' => $key,
                    'nom_completo' => $nom_completo,
                    'edad' => $edad,
                    'identificacion' => $identificacion,
                    'boton' => $boton
                );
            }
        }

        return new CArrayDataProvider($rawData, array(
            'pagination' => array(
                'pageSize' => 999999,
            ),
        ));
    }

    public function dataProviderEstudiantesInscritos($estudiantes) {
        $rawData = array();
        $identificacion = '';
        if ($estudiantes != array()) {

            foreach ($estudiantes as $key => $value) {
                $identificacion = '';
                if ($value['nuevoregistro'] == 'si') {
                    $boton = '';
                } else {
                    $boton = '<div class="center">' . CHtml::checkBox('estudiantesIns[]', false, array('id' => 'estudiantesIns[]', 'value' => base64_encode($value['id']))) . "</div>";
                }
                if (isset($value['cedula_estudiante']) AND $value['cedula_estudiante'] != '') {
                    $identificacion = "<div class='center'>C.I:" . $value['cedula_estudiante'] . "</div>";
                }
                if (isset($value['cedula_escolar']) AND $value['cedula_escolar'] != '') {
                    if ($identificacion != '')
                        $identificacion .= "<br><div class='center'>C.E:" . $value['cedula_escolar'] . "</div>";
                    else
                        $identificacion = "<div class='center'>C.E:" . $value['cedula_escolar'] . "</div>";
                }
// $edad = "<div class='center'>" . $value[''] . "</div>";
                $nom_completo = '<div class="center">' . $value['nom_completo'] . '</div>';
                $rawData [] = array(
                    'id' => $key,
                    'nom_completo' => $nom_completo,
                    'identificacion' => $identificacion,
                    'boton' => $boton
                );
            }
        }

        return new CArrayDataProvider($rawData, array(
            'pagination' => array(
                'pageSize' => 9999999,
            ),
        ));
    }

    public function dataProviderEstudiantesPreInscritos($estudiantes_preincritos, $seccion_plantel_id, $plantel_id) {

        $rawData = array();
        $identificacion = '';

        $datos_plan = Plan::model()->getPlanSeccionPlantel($plantel_id, $seccion_plantel_id);
        $columna = '<div class="action-buttons center">';
        if ($datos_plan['permite_materia_pendiente'] == 0) {
            $acciones = "<center>Acciones</center>";
            $acciones .= '<div class="space-6"></div>';
            $acciones .= '<div class="center">';
            $acciones .= CHtml::label('RG', 'inscripcionRegular', array('title' => 'Inscripción Regular')) . '&nbsp;&nbsp;';
//            $acciones .= CHtml::label('RP', 'repitiente', array('title' => 'Repitiente')) . '&nbsp;&nbsp;';
//            $acciones .= CHtml::label('MP', 'materiaPendiente', array('title' => 'Materia Pendiente')) . '&nbsp;&nbsp;';
//            $acciones .= CHtml::label('DI', 'dobleInscripcion', array('title' => 'Doble Inscripción')) . '&nbsp;&nbsp;';
//            $acciones .= CHtml::label('RC', 'repitienteCompleto', array('title' => 'Repitiente Completo'));
            $acciones .= "</div>";
            $columna .= CHtml::checkBox('inscripcionRegular[]', true, array('id' => 'inscripcionRegular[]', 'checked' => 'checked', 'readOnly' => 'readOnly', 'title' => 'Inscripción Regular', 'readOnly' => 'readOnly')) . '&nbsp;&nbsp;&nbsp;';
        } else {
            $acciones = "<center>Acciones</center>";
            $acciones .= '<div class="space-6"></div>';
            $acciones .= '<div class="center">';
            $acciones .= CHtml::label('RG', 'inscripcionRegular', array('title' => 'Inscripción Regular')) . '&nbsp;&nbsp;';
            $acciones .= CHtml::label('RP', 'repitiente', array('title' => 'Repitiente')) . '&nbsp;&nbsp;';
            $acciones .= CHtml::label('MP', 'materiaPendiente', array('title' => 'Materia Pendiente')) . '&nbsp;&nbsp;';
            $acciones .= CHtml::label('DI', 'dobleInscripcion', array('title' => 'Doble Inscripción')) . '&nbsp;&nbsp;';
            $acciones .= CHtml::label('RC', 'repitienteCompleto', array('title' => 'Repitiente Completo'));
            $acciones .= "</div>";
            $columna .= CHtml::checkBox('inscripcionRegular[]', true, array('id' => 'inscripcionRegular[]', 'title' => 'Inscripción Regular')) . '&nbsp;&nbsp;&nbsp;';
            $columna .= CHtml::checkBox('repitiente[]', false, array('id' => 'repitiente[]', 'title' => 'Repitente')) . '&nbsp;&nbsp;&nbsp;';
            $columna .= CHtml::checkBox('materiaPendiente[]', false, array('id' => 'materiaPendiente[]', 'title' => 'Materia Pendiente')) . '&nbsp;&nbsp;&nbsp;';
            $columna .= CHtml::checkBox('dobleInscripcion[]', false, array('id' => 'dobleInscripcion[]', 'title' => 'Doble Inscripción')) . '&nbsp;&nbsp;&nbsp;';
            $columna .= CHtml::checkBox('repitienteCompleto[]', false, array('id' => 'repitienteCompleto[]', 'title' => 'Repitiente Completo'));
        }
        $columna .= '</div>';

        if ($estudiantes_preincritos != array()) {

            foreach ($estudiantes_preincritos as $key => $value) {
                $identificacion = '';
                $edad_calculada = Estudiante::model()->calcularEdad($value['fecha_nacimiento']);
                $cedula_escolar = "<div class='center'>" . $value['cedula_escolar'] . "</div>";
                $cedula_estudiante = "<div class='center'>" . $value['cedula_estudiante'] . "</div>";
                $edad = "<div class='center'>" . $edad_calculada . "</div>";
                $nom_completo = '<div class="center">' . $value['nom_completo'] . '</div>';
                if (isset($value['cedula_estudiante']) AND $value['cedula_estudiante'] != '') {
                    $identificacion = "<div class='center'>C.I:" . $value['cedula_estudiante'] . "</div>";
                }
                if (isset($value['cedula_escolar']) AND $value['cedula_escolar'] != '') {
                    if ($identificacion != '')
                        $identificacion .= "<br><div class='center'>C.E:" . $value['cedula_escolar'] . "</div>";
                    else
                        $identificacion = "<div class='center'>C.E:" . $value['cedula_escolar'] . "</div>";
                }
                $rawData [] = array(
                    'id' => $key,
                    'edad' => $edad,
                    'nom_completo' => $nom_completo,
                    'identificacion' => $identificacion,
                    'acciones' => $columna
                );
            }
        }

        return array($acciones, new CArrayDataProvider($rawData, array(
                'pagination' => array(
                    'pageSize' => 9999999,
                ),
        )));
    }

    public function dataProviderEstudiante($modelBuscar, $individual) {
        //var_dump($modelBuscar);
        foreach ($modelBuscar as $key => $value) {
            $cedula_escolar = $value['cedula_escolar'];
            $cedula_identidad = $value['cedula_identidad'];
            $nombres = $value['nombres'];
            $apellidos = $value['apellidos'];
            $cod_plantel = $value['cod_plantel'];
            $plantel_nombre = $value['plantel_nombre'];
//  $representante_id = $value['representante_id'];
            $id = $value['id'];
            $codplant_nombreplante = substr($cod_plantel . ' ' . $plantel_nombre, 0, 35);
            if ($individual) {
                $botones = "<div class='center'>" . CHtml::link("", "", array("class" => "fa fa-plus green add-estud-individual", "data" => $id,
                            //                   'onClick' => "Estudiante('')",
                            "title" => "Agregar Estudiante")
                        ) .
                        "</div>";
            } else {
                $botones = "<div class='center'>" . CHtml::link("", "", array("class" => "fa fa-plus green add-estud", "data" => $id,
                            //                   'onClick' => "Estudiante('')",
                            "title" => "Agregar Estudiante")
                        ) .
                        "</div>";
            }


            $rawData[] = array(
                'id' => $key,
                'cedula_escolar' => '<center>' . $cedula_escolar . '</center>',
                'cedula_identidad' => '<center>' . $cedula_identidad . '</center>',
                'nombres' => '<center>' . $nombres . '</center>',
                'apellidos' => '<center>' . $apellidos . '</center>',
                'codplant_nombreplante' => "<center><label title='$plantel_nombre'>" . $codplant_nombreplante . '</label></center>',
                'boton' => '<center>' . $botones . '</center>'
            );
        }
// var_dump($rawData);
//  die();
        return new CArrayDataProvider($rawData, array(
            'pagination' => false,
                //    'pagination' => array(
                //      'pageSize' => 5,
                //),
                )
        );
    }

    public function decodificarEstudiantes($estudiantes) {
        $estudiantes_decoded = array();
        $validacion = true;

        foreach ($estudiantes as $key => $value) {
            if (is_numeric(base64_decode($value))) {
                $estudiantes_decoded[] = base64_decode($value);
            } else {
                $validacion = false;
                return;
            }
        }
        return array($validacion, $estudiantes_decoded);
    }

    static function generarLetra() {
//Se define una cadena de caractares. Te recomiendo que uses esta.
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
//Obtenemos la longitud de la cadena de caracteres
        $longitudCadena = strlen($cadena);

//Se define la variable que va a contener la contraseña
        $pass = "";
//Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
        $longitudPass = 10;

//Creamos la contraseña
        for ($i = 1; $i <= $longitudPass; $i++) {
//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos = rand(0, $longitudCadena - 1);

//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
            $pass .= substr($cadena, $pos, 1);
        }
        return $pass;
    }

    /**
     * Acción que despliega pop-up con el formulario de registro parcial de representante y estudiante.
     * Activanda con el botón "Nuevo Registro" en la vista principal - Inscripcion.
     * @author Meylin y Alexis
     * @param int $cedula  Cédula de Identidad del estudiante ingresada por el usuario con la letra de origen
     * @param $mDatosAnt, $mEstudiante, $model   Modelos requeridos: DatosAntropometricos, Estudiante y Representante
     * @param $estudiante  Modelo Estudiante
     * @param int $cedulaEscolar Codigo unico para cada estudiante que se genera automaticamente basado en los parametros establecidos en Gaceta
     *
     */
    public function actionDialogoRegistro() {
        $mEstudiante = new Estudiante;
        $mDatosAnt = new DatosAntropometricos;

        if (!empty($_GET['key'])) {
            $key = $_GET['key'];
        } else {
            $key = "";
        }
        $cedulaEscolar = '';
        $model = new Representante;
        $modelAfinidad = new Afinidad;

        $this->renderPartial('nuevoRegistro', array(
            'mEstudiante' => $mEstudiante, 'mDatosAnt' => $mDatosAnt, 'cedulaEscolar' => $cedulaEscolar, 'model' => $model,
            'modelAfinidad' => $modelAfinidad,
            'key' => $key
                ), FALSE, TRUE);
    }

    /**
     * Acción que busca al estudiante en el registro de SAIME mediante la Cédula de Identidad y valida si existe o no.
     * @author Meylin
     * @param int $cedula  Cédula de Identidad del estudiante ingresada por el usuario con la letra de origen
     * @param int $numeroCedula   Cédula de Identidad filtrada a través de un substring para depurar el origen
     * @param $estudiante  Modelo Estudiante
     * @param string $origen Indica la nacionalidad ingresada con la CI desde un formulario (V ó E)
     *
     */
    public function actionBuscarCedulaEstudiante() {

        $cedula = $_REQUEST['cedula'];
        if ($cedula) {
            $estudiantes = new Estudiante;
            $numeroCedula = substr($cedula, 2);
            $origen = substr($cedula, 0, 1);

            if (is_numeric($numeroCedula)) {
                $busquedaCedula = $estudiantes->busquedaSaime($origen, $numeroCedula); // valida si existe la cedula en la tabla saime
                // var_dump($busquedaCedula);
            } else {
                $busquedaCedula = null;
            }
            if (!$busquedaCedula) {
                $mensaje = "Esta Cedula de Identidad no se encuentra registrada en nuestro sistema, si cree que esto puede ser un error "
                        . "por favor contacte al personal de soporte mediante "
                        . "<a href='mailto:soporte.gescolar@me.gob.ve'>soporte.gescolar@me.gob.ve</a>";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje)); // NO EXISTE EN SAIME
                Yii::app()->end();
            } else {

                $validaCedula = Estudiante::model()->findByAttributes(array('cedula_identidad' => $numeroCedula));

                if (isset($validaCedula)) {
                    $mensaje = "<p>El estudiante asociado a este número de cédula ya está registrado. Debe utilizar la opción <b>'Incluir Estudiante Existente'</b> en la página principal.";
                    $edad = Estudiante::model()->calcularEdad(date("Y-m-d", strtotime($busquedaCedula['fecha'])));
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    echo json_encode(array('statusCode' => 'mensaje', 'nombre' => $busquedaCedula['nombre'], 'apellido' => $busquedaCedula['apellido'], 'fecha' => date("d-m-Y", strtotime($busquedaCedula['fecha'])), 'edad' => $edad, 'mensaje' => $mensaje)); //'error' => true,
                    Yii::app()->end();
                } else {


                    $nombreEstudianteSaime = $busquedaCedula['nombre'];
                    $apellidoEstudianteSaime = $busquedaCedula['apellido'];
                    $nombreFiltrado = Utiles::onlyAlphaNumericWithSpace($nombreEstudianteSaime);
                    $apellidoFiltrado = Utiles::onlyAlphaNumericWithSpace($apellidoEstudianteSaime);

                    if ($nombreEstudianteSaime != $nombreFiltrado || $apellidoEstudianteSaime != $apellidoFiltrado) {

                        $edad = Estudiante::model()->calcularEdad(date("Y-m-d", strtotime($busquedaCedula['fecha'])));
                        echo json_encode(array('statusCode' => 'successU', 'nombre' => $busquedaCedula['nombre'], 'apellido' => $busquedaCedula['apellido'], 'edad' => $edad, 'fecha' => date("d-m-Y", strtotime($busquedaCedula['fecha']))));
                    } else {

                        $edad = Estudiante::model()->calcularEdad(date("Y-m-d", strtotime($busquedaCedula['fecha'])));
                        echo json_encode(array('statusCode' => 'successU', 'nombre' => $busquedaCedula['nombre'], 'apellido' => $busquedaCedula['apellido'], 'edad' => $edad, 'bloqueo' => true, 'fecha' => date("d-m-Y", strtotime($busquedaCedula['fecha']))));
                    }
                }
            }
        } else {
            $mensaje = "ERROR!!!!! No ha ingresado los parámetros necesarios para cumplir con la respuesta a su petición. La Cédula debe contener solo caracteres numéricos.";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje)); //
        }
    }

    public function actionBuscarCedulaRepresentante() {


        $cedulaRepresentante = $_REQUEST['cedula'];

        if ($cedulaRepresentante) {

            $representantes = new Representante;


            $numeroCedula = substr($cedulaRepresentante, 2);
//var_dump($numeroCedula);die();

            $origen = substr($cedulaRepresentante, 0, 1);

            if (is_numeric($numeroCedula)) {
                $busquedaCedula = AutoridadPlantel::model()->busquedaSaime($origen, $numeroCedula); // valida si existe la cedula en la tabla saime
                $representanteTemp = Representante::model()->findByAttributes(array('cedula_identidad' => $numeroCedula));
                if (isset($representanteTemp->id)) {
                    $exist = true;
                } else {
                    $exist = false;
                }
// var_dump($busquedaCedula);die();
            } else {
                $busquedaCedula = null;
            }
            if (!$busquedaCedula) {
                $mensaje = "Esta Cedula de Identidad no se encuentra registrada en nuestro sistema, si cree que esto puede ser un error "
                        . "por favor contacte al personal de soporte mediante "
                        . "<a href='mailto:soporte.gescolar@me.gob.ve'>soporte.gescolar@me.gob.ve</a>";
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje)); // NO EXISTE EN SAIME
                Yii::app()->end();
            } else {

                if ($exist == false) {

                    if (!empty($busquedaCedula['fecha_nacimiento'])) {
                        $fecha_nacimiento = date("d-m-Y", strtotime($busquedaCedula['fecha_nacimiento']));
                        $edad = Estudiante::model()->calcularEdad(date("Y-m-d", strtotime($busquedaCedula['fecha_nacimiento'])));
                    } else {
                        $fecha_nacimiento = "";
                        $edad = 0;
                    }


                    echo json_encode(array('statusCode' => 'successU', 'nombre' => strtoupper($busquedaCedula['nombre']), 'apellido' => $busquedaCedula['apellido'], 'fecha_nacimiento' => date("d-m-Y", strtotime($busquedaCedula['fecha_nacimiento'])), 'edad' => $edad, 'exist' => $exist));
                } else {

                    if (!empty($representanteTemp->fecha_nacimiento)) {
                        $fecha_nacimiento = date("d-m-Y", strtotime($representanteTemp->fecha_nacimiento));
                        $edad = Estudiante::model()->calcularEdad(date("Y-m-d", strtotime($representanteTemp->fecha_nacimiento)));
                    } else {
                        $fecha_nacimiento = "";
                        $edad = 0;
                    }
                    echo json_encode(array(
                        'statusCode' => 'successU',
                        'nombre' => $representanteTemp->nombres,
                        'apellido' => $representanteTemp->apellidos,
                        'exist' => $exist,
                        'telefonoMovil' => $representanteTemp->telefono_movil,
                        'telefonoLocal' => $representanteTemp->telefono_habitacion,
                        'email' => $representanteTemp->correo,
                        'afinidad' => $representanteTemp->afinidad_id,
                        'fecha_nacimiento' => $fecha_nacimiento,
                        'edad' => $edad,
                        'estado' => $representanteTemp->estado_id));
                }
            }
        } else {
            $mensaje = "ERROR!!!!! No ha ingresado los parámetros necesarios para cumplir con la respuesta a su petición. La Cédula debe contener caracteres numéricos.";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje)); // NO EXISTE EN SAIME
        }
    }

    /**
     * FUNCION QUE PROCESA LOS DATOS, VALIDA Y ALMACENA EN LOS MODELOS CORRESPONDIENTES
     * @author Meylin y Alexis
     * @param int $cedulaEstudiante , $cedulaRepresentante   Cédula de Identidad filtrada a través de un substring para depurar el origen ( V ó E)
     * @param $mDatosAnt, $mEstudiante, $modelRepresentante   Modelos requeridos: DatosAntropometricos, Estudiante y Representante
     * @param int $edad   Edad del estudiante calculada utilizando la fecha de nacimiento
     * @param int $estatura   Estatura del estudiante ingresada por el usuario.
     *
     */
    public function cargarEstudiante($mEstudiante, $estatura, $modelRepresentante, $edad) {

        $validacionExistencia = false;
        $mDatosAnt = new DatosAntropometricos;

        //en caso de que $mEstudiante->cedula_identidad sea FALSE o distinto de un numero se llama a la funcion que me compara los datos del representante con la fecha de nacimiento y los nombres del estudiante para poder saber si esta registrado o no,
        // ademas busca si existe la cedula escolar generada por los datos del representante

        if ($edad < 18) {
            $mEstudiante->setScenario('crearEstudiante');
        } else {
            $mEstudiante->setScenario('estudianteMayor');
        }


        if ($mEstudiante->validate()) {


            if (empty($mEstudiante->cedula_identidad)) {
                $logMensaje = "se registro un estudiante sin cédula";

                $existeEstudiante = Estudiante::model()->validarEstudiante($mEstudiante); // valida si existe el estudiante cuando no tiene C.I
                $valor = $existeEstudiante[0]['existe'];
//                var_dump($valor);
//                die();

                if ($valor == 'representante') {
                    $mensaje = 'El estudiante que intenta ingresar ya esta registrado. Pruebe la opcion "Incluir Estudiante"';
                    $validacionExistencia = false;
                } else if ($valor == 'cedula_escolar') {
                    $mensaje = 'El estudiante que intenta ingresar ya esta registrado. La Cédula Escolar del mismo ya existe. Pruebe la opcion de "Incluir Estudiante"';
                    $validacionExistencia = false;
                } else if ($valor == '') {
                    $validacionExistencia = true;
                }
            } else {
                $logMensaje = "se agrego un estudiante con cédula";
                $validacionExistencia = true;
            }


            if ($validacionExistencia == true) {

                if ($mDatosAnt->validate()) {

                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($modelRepresentante) {
                            $modelRepresentante->save();
                            $mEstudiante->representante_id = $modelRepresentante->id;
                        }

                        $mEstudiante->save();
                        if ($estatura != '') {
                            $mDatosAnt->estudiante_id = $mEstudiante->id;
                            $mDatosAnt->estatura = $estatura;
                            $mDatosAnt->save();
                        }


                        $transaction->commit();
                        $this->registerLog('ESCRITURA', 'plantel.matricula.agregarEstudiante', 'EXITOSO', $logMensaje);
                        $this->registerLog('ESCRITURA', 'plantel.matricula.agregarEstudiante', 'EXITOSO', "se agregaron datos antropometricos un estudiante");
                        $this->registerLog('ESCRITURA', 'InscribirEstudiantesIndividual', 'EXITOSO', 'Ha matriculado la Seccion Plantel');

                        $respuesta['statusCode'] = 'success';
                        $respuesta['idEstudiante'] = $mEstudiante->id;


                        $respuesta['mensaje'] = 'Estimado Usuario, el proceso de registro se ha realizado exitosamente.';
                        header('Cache-Control: no-cache, must-revalidate');
                        header('Content-type: application/json');
                        echo json_encode($respuesta);
                    } catch (Exception $ex) {
                        $transaction->rollback();

                        $respuesta['statusCode'] = 'error';
                        $respuesta['error'] = $ex;
                        $respuesta['mensaje'] = 'Estimado Usuario, ha ocurrido un error durante el proceso de de inscripcion. Intente nuevamente.';
                        header('Cache-Control: no-cache, must-revalidate');
                        header('Content-type: application/json');
                        echo json_encode($respuesta);
                    }
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $mDatosAnt));
                }
            } else {
                $respuesta['statusCode'] = 'error';
                $respuesta['mensaje'] = $mensaje;

                header('Cache-Control: no-cache, must-revalidate');
                header('Content-type: application/json');
                echo json_encode($respuesta);
            }
        } else {

            $this->renderPartial('//errorSumMsg', array('model' => $mEstudiante));
        }
    }

    /**
     * ACCION QUE CARGA LOS DATOS DEL NUEVO ESTUDIANTE Y DEL REPRESENTANTE INGRESADOS POR EL USUARIO. METODO: POST
     * Provenientes del formulario de registro parcial.
     * @author Meylin y Alexis
     * @param int $cedulaEstudiante , $cedulaRepresentante   Cédula de Identidad filtrada a través de un substring para depurar el origen ( V ó E)
     * @param $mDatosAnt, $mEstudiante, $mRepresentante   Modelos requeridos: DatosAntropometricos, Estudiante y Representante
     * @param int $usuario   ID del usuario que se encuentra logueado.
     * @param int $status_id   ID correspondiente al estado del estudiante, (REGISTRADO) según la tabla estatus_estudiante.
     *
     */
    public function actionAgregarEstudiante() {

        //var_dump($_POST);die();
        $mEstudiante = new Estudiante;
        $mRepresentante = new Representante;
        $mDatosAnt = New DatosAntropometricos;
        $usuario = Yii::app()->user->id;
        $estatus_id = self::REGISTRADO_ID; // REGISTRADO
        $estatus = 'A';

        if (isset($_POST['DatosGenerales']) && isset($_POST['DatosGenerales']['cedulaRepresentante'])) {

            $cedulaRepresentante = substr($_POST['DatosGenerales']['cedulaRepresentante'], 2);

            if ($_POST['DatosGenerales']['cedula'] != '' || $_POST['DatosGenerales']['cedula'] < 0) {
                $cedulaEstudiante = substr($_POST['DatosGenerales']['cedula'], 2);
            } else {

                $cedulaEstudiante = NULL;
            }

            if (isset($_POST['DatosGenerales']['fechaNacimiento'])) {

                if ($_POST['DatosGenerales']['fechaNacimiento'] == "") {
                    $fecha = "";
                    $edad = 0;
                } else {
                    $fecha = date("Y-m-d", strtotime($_POST['DatosGenerales']['fechaNacimiento']));
                    $edad = $mEstudiante->calcularEdad($fecha);
                }
                //var_dump($edad);die();
            }

            if ($edad > 18) {

                if ($_POST['DatosGenerales']['cedulaEscolar'] != $cedulaEstudiante) {

                    $mEstudiante->cedula_escolar = $cedulaEstudiante;
                }

                //--------DATOS DEL ESTUDIANTE--

                $nombres = $mEstudiante->nombres = strtoupper(trim($_POST['DatosGenerales']['nombreEstudiante']));
                $mEstudiante->cedula_identidad = $cedulaEstudiante;
                $apellidos = $mEstudiante->apellidos = strtoupper(trim($_POST['DatosGenerales']['apellidoEstudiante']));
                $cedula_escolar = $mEstudiante->cedula_escolar = $_POST['DatosGenerales']['cedulaEscolar'];

                $fecha_nacimiento = $mEstudiante->fecha_nacimiento = $fecha;


                $mEstudiante->usuario_ini_id = Yii::app()->user->id;
                $mEstudiante->lateralidad_mano = strtoupper($_POST['DatosGenerales']['lateralidad']);
                $mEstudiante->estatus = $estatus;
                $mEstudiante->afinidad_id = $_POST['DatosGenerales']['afinidad'];
                $mEstudiante->estatus_id = $estatus_id;
                $mEstudiante->plantel_actual_id = (int) $_POST['DatosGenerales']['plantel_id'];
                $mEstudiante->plantel_anterior_id = (int) $_POST['DatosGenerales']['plantel_id'];

                $estatura = $_POST['DatosGenerales']['estatura'];
                $registraEstudiante = $this->cargarEstudiante($mEstudiante, $estatura, $mRepresentante, $edad);
                //var_dump($mEstudiante);die();
            } else {

                //   $cedulaEscolar = $cedulaRepresentante . str_replace('-', '', $fecha);
                //---------DATOS DEL REPRESENTANTE--

                if ($_POST['DatosGenerales']['nombreRepresentante']) {
                    $mRepresentante->nombres = strtoupper(trim($_POST['DatosGenerales']['nombreRepresentante']));
                } else {
                    $mRepresentante->nombres = "";
                }
                if ($_POST['DatosGenerales']['cedulaRepresentante']) {
                    $mRepresentante->cedula_identidad = substr($_POST['DatosGenerales']['cedulaRepresentante'], 2);
                } else {
                    $mRepresentante->cedula_identidad = "";
                }
                if ($_POST['DatosGenerales']['apellidoRepresentante']) {
                    $mRepresentante->apellidos = strtoupper(trim($_POST['DatosGenerales']['apellidoRepresentante']));
                } else {
                    $mRepresentante->apellidos = "";
                }
                if ($_POST['DatosGenerales']['emailRepresentante']) {
                    $mRepresentante->correo = strtoupper($_POST['DatosGenerales']['emailRepresentante']);
                } else {
                    $mRepresentante->correo = "";
                }
                if ($_POST['DatosGenerales']['fecha_nacimiento']) {
                    $mRepresentante->fecha_nacimiento = date("Y-m-d", strtotime($_POST['DatosGenerales']['fecha_nacimiento']));
                } else {
                    $mRepresentante->fecha_nacimiento = "";
                }
                if ($_POST['DatosGenerales']['estado']) {
                    $mRepresentante->estado_id = $_POST['DatosGenerales']['estado'];
                } else {
                    $mRepresentante->estado_id = "";
                }
                if ($_POST['DatosGenerales']['telefonoMovil']) {
                    $mRepresentante->telefono_movil = Utiles::onlyNumericString($_POST['DatosGenerales']['telefonoMovil']);
                } else {
                    $mRepresentante->telefono_movil = "";
                }
                if ($_POST['DatosGenerales']['telefonoLocal']) {
                    $mRepresentante->telefono_habitacion = Utiles::onlyNumericString($_POST['DatosGenerales']['telefonoLocal']);
                } else {
                    $mRepresentante->telefono_habitacion = "";
                }
                $mRepresentante->usuario_ini_id = $usuario;
                $mRepresentante->estatus = $estatus;
                $mRepresentante->setScenario('crearRepresentante');


                $nombres = $mEstudiante->nombres = strtoupper(trim($_POST['DatosGenerales']['nombreEstudiante']));
                $mEstudiante->cedula_identidad = $cedulaEstudiante;
                $apellidos = $mEstudiante->apellidos = strtoupper(trim($_POST['DatosGenerales']['apellidoEstudiante']));
                $cedula_escolar = $mEstudiante->cedula_escolar = $_POST['DatosGenerales']['cedulaEscolar'];
                $fecha_nacimiento = $mEstudiante->fecha_nacimiento = $fecha;
                $mEstudiante->usuario_ini_id = $usuario;
                $mEstudiante->lateralidad_mano = strtoupper($_POST['DatosGenerales']['lateralidad']);
                $mEstudiante->estatus = $estatus;
                $mEstudiante->afinidad_id = $_POST['DatosGenerales']['afinidad'];
                $mEstudiante->estatus_id = $estatus_id;
                $mEstudiante->plantel_actual_id = $_POST['DatosGenerales']['plantel_id'];
                $mEstudiante->plantel_anterior_id = $_POST['DatosGenerales']['plantel_id'];
                $mEstudiante->estado_id = $_POST['DatosGenerales']['estadoEstudiante'];
                $estatura = $_POST['DatosGenerales']['estatura'];

                if ($mRepresentante->validate()) {

                    $representanteTemp = Representante::model()->findByAttributes(array('cedula_identidad' => $mRepresentante->cedula_identidad));

                    if (isset($representanteTemp->id)) {


                        $representanteTemp = Representante::model()->findByPk($representanteTemp->id);
                        $representante_id = $mEstudiante->representante_id = $mRepresentante->id;

                        $representanteTemp->apellidos = $mRepresentante->apellidos;
                        $representanteTemp->nombres = $mRepresentante->nombres;
                        $representanteTemp->correo = $mRepresentante->correo;
                        $representanteTemp->fecha_nacimiento = $mRepresentante->fecha_nacimiento;
                        $representanteTemp->telefono_movil = $mRepresentante->telefono_movil;
                        $representanteTemp->telefono_habitacion = $mRepresentante->telefono_habitacion;
                        $representanteTemp->estado_id = $mRepresentante->estado_id;
                        $representanteTemp->usuario_act_id = Yii::app()->user->id;
                        $representanteTemp->fecha_act = date("Y-m-d H:i:s");
                        $representanteTemp->setScenario('crearRepresentante');
                        if ($representanteTemp->validate()) {
                            $registraEstudiante = $this->cargarEstudiante($mEstudiante, $estatura, $representanteTemp, $edad);

//                            if ($representanteTemp->save()) {
//                                //echo 'actualizo representante ';
//                                $this->registerLog('ESCRITURA', 'plantel.matricula.agregarEstudiante', 'EXITOSO', 'Se ha modificado un representante');
//                                $mEstudiante->representante_id = $representanteTemp->id;
//                                // var_dump($mEstudiante);die();
//                                $registraEstudiante = $this->cargarEstudiante($mEstudiante, $estatura);
//                                //var_dump($registraEstudiante);die();
//                            } else {
//
//                                throw new CHttpException(500, 'Error! No se ha registrado el representante.');
//                            }
                        } else {
                            $this->renderPartial('//errorSumMsg', array('model' => $mRepresentante));
                        }
                    } else {

                        $registraEstudiante = $this->cargarEstudiante($mEstudiante, $estatura, $mRepresentante, $edad);

//                        if ($mRepresentante->save()) {
//                            // echo 'guardo representante ';
//                            $this->registerLog('ACTUALIZACION', 'plantel.matricula.agregarEstudiante', 'EXITOSO', 'Se ha creado un representante');
//                            $mEstudiante->representante_id = $mRepresentante->id;
//
//                            $registraEstudiante = $this->cargarEstudiante($mEstudiante, $estatura);
//                        } else {
//                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
//                        }
                    }
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $mRepresentante));
                }
            }
        }
    }

    public function actionReporte() {
        // if (Yii::app()->request->isAjaxRequest) {
        $plantel_id = $this->getRequest('id');
        $seccion_plantel_id = $this->getRequest('seccion');
        $plantel_id_decoded = base64_decode($plantel_id);
        $seccion_plantel_id_decoded = base64_decode($seccion_plantel_id);

        if (is_numeric($seccion_plantel_id_decoded) AND is_numeric($plantel_id_decoded)) {
            $periodo = PeriodoEscolar::model()->getPeriodoActivo();
            $dataSeccion = SeccionPlantel::obtenerDatosSeccion($seccion_plantel_id_decoded, $plantel_id_decoded);
            $dataPlantel = Plantel::model()->obtenerDatosIdentificacion($plantel_id_decoded);
            $estudiantes_matriculados = Estudiante::model()->estudiantesMatriculadosSeccion($seccion_plantel_id_decoded);
            $datos_autoridades = Plantel::model()->getDatosAutoridadReporte($plantel_id_decoded);
            $nombre_pdf = (isset($dataPlantel['cod_plantel']) AND $dataPlantel['cod_plantel'] != '') ? $dataPlantel['cod_plantel'] . '-Matricula' : '-Matricula';
            $mpdf = new mpdf('', 'LEGAL', 0, '', 15, 15, 69.1, 50);            //$mpdf->SetMargins(3,69.1,70);
            $header = $this->renderPartial('_headerReporteMatriculaInicial', array('datosPlantel' => $dataPlantel, 'datosSeccion' => $dataSeccion, 'periodo' => $periodo), true);
            $footer = $this->renderPartial('_footerReporteMatriculaInicial', array('datosAutoridades' => $datos_autoridades), true);
            $body = $this->renderPartial('_bodyReporteMatriculaInicial', array('datosPlantel' => $dataPlantel, 'datosSeccion' => $dataSeccion, 'periodo' => $periodo, 'estudiantes' => $estudiantes_matriculados), true);
            $mpdf->SetFont('sans-serif');
            $mpdf->SetHTMLHeader($header);
            $mpdf->setHTMLFooter($footer . '<br>' . '<p style="text-align:center;"> {PAGENO} / {nb}</p>');
            $mpdf->WriteHTML($body);

            $this->registerLog('LECTURA', self::MODULO . 'Reporte', 'EXITOSO', 'Entró matricular la Seccion Plantel' . $seccion_plantel_id);

            $mpdf->Output($nombre_pdf . '.pdf', 'D');
        } else
            throw new CHttpException(404, 'Estimado Usuario, no se ha encontrado el recurso solicitado. Vuelva a la página anterior e intente de nuevo');
        // } else
        //  throw new CHttpException(404, 'Estimado Usuario, usted no esta autorizado para acceder mediante esta via.');
    }

    /*     * *************************************************************************************************** */

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

    public function loadModelEstudiante($id) {
        $model = Estudiante::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelIncluirEstudiante($id) {
        $model = Estudiante::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not existdnlkgnfdlkgnlkfdsnlkgsdlkn.');
        return $model;
    }

    public function to_pg_array($set) {
        settype($set, 'array'); // can be called with a scalar or array
        $result = array();
        foreach ($set as $t) {
            if (is_array($t)) {
                $result[] = to_pg_array($t);
            } else {
                $t = str_replace('"', '\\"', $t); // escape double quote
                if (!is_numeric($t)) // quote only non-numeric values
                    $t = '"' . $t . '"';
                $result[] = $t;
            }
        }
        return '{' . implode(",", $result) . '}'; // format
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
        return new CArrayDataProvider($rawData, array(
            'pagination' => array(
                'pageSize' => 3,
            ),
                )
        );
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

    public function actionInscripcionIndividual() {
        if (array_key_exists('id', $_REQUEST) && array_key_exists('plantel', $_REQUEST)) {
            $id = $_REQUEST['id'];
            $plantel_id = $_REQUEST['plantel'];
            $seccion_plantel_id = base64_decode($id);
            $plantel_id_decoded = base64_decode($plantel_id);
            if (is_numeric($seccion_plantel_id) && is_numeric($plantel_id_decoded)) {
                $individual = true;
                $periodo_actual = PeriodoEscolar ::model()->getPeriodoActivo();
                $dataSeccion = SeccionPlantel::obtenerDatosSeccion($seccion_plantel_id, $plantel_id_decoded);
                $dataPlantel = Plantel::model()->obtenerDatosIdentificacion($plantel_id_decoded);
                $datosSeccion = seccionPlantel::model()->cargarDetallesSeccion($seccion_plantel_id, $plantel_id_decoded);
                $totalInscritos = seccionPlantel::model()->calcularInscritosPorSeccion($seccion_plantel_id);
                $this->registerLog('LECTURA', self::MODULO . 'Inscripcion', 'EXITOSO', 'Entró matricular la Seccion Plantel' . $seccion_plantel_id);
                $this->render('inscripcionIndividual', array(
                    'plantel_id' => $plantel_id_decoded,
                    // 'dataProvider' => $dataproviderEstudiantes,
                    'datosPlantel' => $dataPlantel,
                    'seccion_plantel_id' => $seccion_plantel_id,
                    'datosSeccion' => $dataSeccion,
                    'totalInscritos' => $totalInscritos,
                    'datosSeccionInfo' => $datosSeccion,
                    'individual' => $individual,
                    'inscritos' => json_encode(array())
                ));
            } else
                throw new CHttpException(404, 'No se ha encontrado el recurso que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // no es numerico
        } else
            throw new CHttpException(404, 'No se ha especificado la Sección a la cual desea realizar la Inscripción. Vuelva a la página anterior e intentelo de nuevo.'); // esta vacio el request
    }

    public function cargarEstudianteIncribir($mEstudiante, $estatura, $modelRepresentante, $edad, $doble_inscripcion_pg_array, $inscripcion_regular_pg_array, $repitiente_pg_array, $observacion, $plantel_id, $seccion_plantel_id, $repitiente, $inscripcion_regular, $materia_pendiente, $materia_pendiente_array) {

        $validacionExistencia = false;
        $mDatosAnt = new DatosAntropometricos;
        $modulo = self::MODULO . 'InscribirEstudiantesIndividual';
        $periodo = PeriodoEscolar ::model()->getPeriodoActivo();

//en caso de que $mEstudiante->cedula_identidad sea FALSE o distinto de un numero se llama a la funcion que me compara los datos del representante con la fecha de nacimiento y los nombres del estudiante para poder saber si esta registrado o no,
// ademas busca si existe la cedula escolar generada por los datos del representante

        if ($edad < 18) {
            $mEstudiante->setScenario('crearEstudiante');
        } else {
            $mEstudiante->setScenario('estudianteMayor');
        }


        if ($mEstudiante->validate()) {


            if (empty($mEstudiante->cedula_identidad)) {
                $logMensaje = "se registro un estudiante sin cédula";

                $existeEstudiante = Estudiante::model()->validarEstudiante($mEstudiante); // valida si existe el estudiante cuando no tiene C.I
                $valor = $existeEstudiante[0]['existe'];
//                var_dump($valor);
//                die();

                if ($valor == 'representante') {
                    $mensaje = 'El estudiante que intenta ingresar ya esta registrado. Pruebe la opcion "Incluir Estudiante"';
                    $validacionExistencia = false;
                } else if ($valor == 'cedula_escolar') {
                    $mensaje = 'El estudiante que intenta ingresar ya esta registrado. La Cédula Escolar del mismo ya existe. Pruebe la opcion de "Incluir Estudiante"';
                    $validacionExistencia = false;
                } else if ($valor == '') {
                    $validacionExistencia = true;
                }
            } else {
                $logMensaje = "se agrego un estudiante con cédula";
                $validacionExistencia = true;
            }


            if ($validacionExistencia == true) {

                if ($mDatosAnt->validate()) {

                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($modelRepresentante) {
                            $modelRepresentante->save();
                            $mEstudiante->representante_id = $modelRepresentante->id;
                        }

                        $mEstudiante->save();
                        if ($estatura != '') {
                            $mDatosAnt->estudiante_id = $mEstudiante->id;
                            $mDatosAnt->estatura = $estatura;
                            $mDatosAnt->save();
                        }



                        $estudiantes_pg_array = $this->to_pg_array($mEstudiante->id);
                        if ($repitiente == '1') {
                            if ($observacion != '' AND $observacion != null) {
                                $resultadoInscripcion = Estudiante::model()->inscribirEstudiante($estudiantes_pg_array, (int) $plantel_id, (int) $seccion_plantel_id, (int) $periodo['id'], $modulo, $inscripcion_regular_pg_array, $doble_inscripcion_pg_array, $repitiente_pg_array, $observacion);
                            }
                        } else if ($inscripcion_regular == '1' || $materia_pendiente == '1') {
                            $observacionArray = $this->to_pg_array($observacion);
//                           var_dump($estudiantes_pg_array, (int) $plantel_id, (int) $seccion_plantel_id, (int) $periodo['id'], $modulo, $inscripcion_regular_pg_array, $doble_inscripcion_pg_array,$repitiente_pg_array,'{0}', $observacionArray);
//                            die();
                            $resultadoInscripcion = Estudiante::model()->inscribirEstudiantes($estudiantes_pg_array, (int) $plantel_id, (int) $seccion_plantel_id, (int) $periodo['id'], $modulo, $inscripcion_regular_pg_array, $doble_inscripcion_pg_array, $repitiente_pg_array, $materia_pendiente_array, $observacionArray);
                            //$estudiantes_pg_array, $plantel_id_decoded, $seccion_plantel_id_decoded, $periodo['id'], $modulo, $inscripcion_regular_pg_array, $doble_inscripcion_pg_array, '{0}', $materia_pendiente_pg_array, $observacion_pg_array
                        }





                        $transaction->commit();
                        $this->registerLog('ESCRITURA', 'plantel.matricula.agregarEstudiante', 'EXITOSO', $logMensaje);
                        $this->registerLog('ESCRITURA', 'plantel.matricula.agregarEstudiante', 'EXITOSO', "se agregaron datos antropometricos un estudiante");
                        $this->registerLog('ESCRITURA', 'InscribirEstudiantesIndividual', 'EXITOSO', 'Ha matriculado la Seccion Plantel');
                        $respuesta['statusCode'] = 'success';
                        $respuesta['idEstudiante'] = $mEstudiante->id;


                        $respuesta['mensaje'] = 'Estimado Usuario, el proceso de registro se ha realizado exitosamente.';
                        header('Cache-Control: no-cache, must-revalidate');
                        header('Content-type: application/json');
                        echo json_encode($respuesta);
                    } catch (Exception $ex) {
                        $transaction->rollback();

                        $respuesta['statusCode'] = 'error';
                        $respuesta['error'] = $ex;
                        $respuesta['mensaje'] = 'Estimado Usuario, ha ocurrido un error durante el proceso de de inscripcion. Intente nuevamente.';
                        header('Cache-Control: no-cache, must-revalidate');
                        header('Content-type: application/json');
                        echo json_encode($respuesta);
                    }
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $mDatosAnt));
                }
            } else {
                $respuesta['statusCode'] = 'error';
                $respuesta['mensaje'] = $mensaje;

                header('Cache-Control: no-cache, must-revalidate');
                header('Content-type: application/json');
                echo json_encode($respuesta);
            }
        } else {

            $this->renderPartial('//errorSumMsg', array('model' => $mEstudiante));
        }
    }

    public function actionAgregarEstudianteInscribir() {

        $mEstudiante = new Estudiante;
        $mRepresentante = new Representante;
        $mDatosAnt = New DatosAntropometricos;
        $usuario = Yii::app()->user->id;
        $estatus_id = self::REGISTRADO_ID; // REGISTRADO
        $estatus = 'A';

        /*         * *********************** */
        $periodo = PeriodoEscolar ::model()->getPeriodoActivo();
        $inscripcion_regular = $_POST['DatosGenerales']['inscripcionRegular'];
        $doble_inscripcion = $_POST['DatosGenerales']['dobleInscripcion'];
        $repitiente = $_POST['DatosGenerales']['repitiente'];
        $observacion = $_POST['DatosGenerales']['observacion'];
        $materia_pendiente = $_POST['DatosGenerales']['materiaPendiente'];
        $seccion_plantel_id = $_POST['DatosGenerales']['seccion_plantel_id'];
        $seccion_plantel_periodo = SeccionPlantelPeriodo::model()->consultarSeccionPeriodoId($seccion_plantel_id, $periodo['id']);

        $repitiente_array [] = (int) $repitiente;
        $inscripcion_regular_array[] = (int) $inscripcion_regular;
        $doble_inscripcion_array[] = (int) $doble_inscripcion;
        $doble_inscripcion_pg_array = $this->to_pg_array($doble_inscripcion_array);
        $inscripcion_regular_pg_array = $this->to_pg_array($inscripcion_regular_array);
        $materia_pendiente_array = $this->to_pg_array($materia_pendiente);
        $repitiente_pg_array = $this->to_pg_array($repitiente_array);


        /*         * ********************** */


        if (isset($_POST['DatosGenerales']) && isset($_POST['DatosGenerales']['cedulaRepresentante'])) {

            $cedulaRepresentante = substr($_POST['DatosGenerales']['cedulaRepresentante'], 2);

            if ($_POST['DatosGenerales']['cedula'] != '' || $_POST['DatosGenerales']['cedula'] < 0) {
                $cedulaEstudiante = substr($_POST['DatosGenerales']['cedula'], 2);
            } else {

                $cedulaEstudiante = NULL;
            }

            if (isset($_POST['DatosGenerales']['fechaNacimiento'])) {

                if ($_POST['DatosGenerales']['fechaNacimiento'] == "") {
                    $fecha = "";
                    $edad = 0;
                } else {
                    $fecha = date("Y-m-d", strtotime($_POST['DatosGenerales']['fechaNacimiento']));
                    $edad = $mEstudiante->calcularEdad($fecha);
                }
//var_dump($edad);die();
            }

            if ($edad > 18) {

                if ($_POST['DatosGenerales']['cedulaEscolar'] != $cedulaEstudiante) {

                    $mEstudiante->cedula_escolar = $cedulaEstudiante;
                }

//--------DATOS DEL ESTUDIANTE--

                $nombres = $mEstudiante->nombres = strtoupper(trim($_POST['DatosGenerales']['nombreEstudiante']));
                $mEstudiante->cedula_identidad = $cedulaEstudiante;
                $apellidos = $mEstudiante->apellidos = strtoupper(trim($_POST['DatosGenerales']['apellidoEstudiante']));
                $cedula_escolar = $mEstudiante->cedula_escolar = $_POST['DatosGenerales']['cedulaEscolar'];

                $fecha_nacimiento = $mEstudiante->fecha_nacimiento = $fecha;


                $mEstudiante->usuario_ini_id = Yii::app()->user->id;
                $mEstudiante->lateralidad_mano = strtoupper($_POST['DatosGenerales']['lateralidad']);
                $mEstudiante->estatus = $estatus;
                $mEstudiante->afinidad_id = $_POST['DatosGenerales']['afinidad'];
                $mEstudiante->sexo = $_POST['DatosGenerales']['sexo'];

                $mEstudiante->estatus_id = $estatus_id;
                $mEstudiante->plantel_actual_id = (int) $_POST['DatosGenerales']['plantel_id'];
                $mEstudiante->plantel_anterior_id = (int) $_POST['DatosGenerales']['plantel_id'];

                $estatura = $_POST['DatosGenerales']['estatura'];
                $registraEstudiante = $this->cargarEstudianteIncribir($mEstudiante, $estatura, $mRepresentante, $edad, $doble_inscripcion_pg_array, $inscripcion_regular_pg_array, $repitiente_pg_array, $observacion, (int) $_POST['DatosGenerales']['plantel_id'], $seccion_plantel_id, $repitiente, $inscripcion_regular, $materia_pendiente, $materia_pendiente_array);


//$registraEstudiante = $this->cargarEstudianteInscribir($mEstudiante, $estatura, $mRepresentante, $edad, $doble_inscripcion_pg_array, $inscripcion_regular_pg_array, $repitiente_pg_array, $observacion, (int) $_POST['DatosGenerales']['plantel_id'], $seccion_plantel_id, $repitiente, $inscripcion_regular);
//var_dump($mEstudiante);die();
            } else {

//   $cedulaEscolar = $cedulaRepresentante . str_replace('-', '', $fecha);
//---------DATOS DEL REPRESENTANTE--

                if ($_POST['DatosGenerales']['nombreRepresentante']) {
                    $mRepresentante->nombres = strtoupper(trim($_POST['DatosGenerales']['nombreRepresentante']));
                } else {
                    $mRepresentante->nombres = "";
                }
                if ($_POST['DatosGenerales']['cedulaRepresentante']) {
                    $mRepresentante->cedula_identidad = substr($_POST['DatosGenerales']['cedulaRepresentante'], 2);
                } else {
                    $mRepresentante->cedula_identidad = "";
                }
                if ($_POST['DatosGenerales']['apellidoRepresentante']) {
                    $mRepresentante->apellidos = strtoupper(trim($_POST['DatosGenerales']['apellidoRepresentante']));
                } else {
                    $mRepresentante->apellidos = "";
                }
                if ($_POST['DatosGenerales']['emailRepresentante']) {
                    $mRepresentante->correo = strtoupper($_POST['DatosGenerales']['emailRepresentante']);
                } else {
                    $mRepresentante->correo = "";
                }
                if ($_POST['DatosGenerales']['fecha_nacimiento']) {
                    $mRepresentante->fecha_nacimiento = date("Y-m-d", strtotime($_POST['DatosGenerales']['fecha_nacimiento']));
                } else {
                    $mRepresentante->fecha_nacimiento = "";
                }
                if ($_POST['DatosGenerales']['estado']) {
                    $mRepresentante->estado_id = $_POST['DatosGenerales']['estado'];
                } else {
                    $mRepresentante->estado_id = "";
                }
                if ($_POST['DatosGenerales']['telefonoMovil']) {
                    $mRepresentante->telefono_movil = Utiles::onlyNumericString($_POST['DatosGenerales']['telefonoMovil']);
                } else {
                    $mRepresentante->telefono_movil = "";
                }
                if ($_POST['DatosGenerales']['telefonoLocal']) {
                    $mRepresentante->telefono_habitacion = Utiles::onlyNumericString($_POST['DatosGenerales']['telefonoLocal']);
                } else {
                    $mRepresentante->telefono_habitacion = "";
                }
                $mRepresentante->usuario_ini_id = $usuario;
                $mRepresentante->estatus = $estatus;
                $mRepresentante->setScenario('crearRepresentante');


                $nombres = $mEstudiante->nombres = strtoupper(trim($_POST['DatosGenerales']['nombreEstudiante']));
                $mEstudiante->cedula_identidad = $cedulaEstudiante;
                $apellidos = $mEstudiante->apellidos = strtoupper(trim($_POST['DatosGenerales']['apellidoEstudiante']));
                $cedula_escolar = $mEstudiante->cedula_escolar = $_POST['DatosGenerales']['cedulaEscolar'];
                $fecha_nacimiento = $mEstudiante->fecha_nacimiento = $fecha;
                $mEstudiante->usuario_ini_id = $usuario;
                $mEstudiante->lateralidad_mano = strtoupper($_POST['DatosGenerales']['lateralidad']);
                $mEstudiante->estatus = $estatus;
                $mEstudiante->sexo = $_POST['DatosGenerales']['sexo'];

                $mEstudiante->afinidad_id = $_POST['DatosGenerales']['afinidad'];
                $mEstudiante->estatus_id = $estatus_id;
                $mEstudiante->plantel_actual_id = $_POST['DatosGenerales']['plantel_id'];
                $mEstudiante->plantel_anterior_id = $_POST['DatosGenerales']['plantel_id'];
                $mEstudiante->estado_id = $_POST['DatosGenerales']['estadoEstudiante'];
                $estatura = $_POST['DatosGenerales']['estatura'];

                if ($mRepresentante->validate()) {

                    $representanteTemp = Representante::model()->findByAttributes(array('cedula_identidad' => $mRepresentante->cedula_identidad));

                    if (isset($representanteTemp->id)) {


                        $representanteTemp = Representante::model()->findByPk($representanteTemp->id);
                        $representante_id = $mEstudiante->representante_id = $mRepresentante->id;

                        $representanteTemp->apellidos = $mRepresentante->apellidos;
                        $representanteTemp->nombres = $mRepresentante->nombres;
                        $representanteTemp->correo = $mRepresentante->correo;
                        $representanteTemp->fecha_nacimiento = $mRepresentante->fecha_nacimiento;
                        $representanteTemp->telefono_movil = $mRepresentante->telefono_movil;
                        $representanteTemp->telefono_habitacion = $mRepresentante->telefono_habitacion;
                        $representanteTemp->estado_id = $mRepresentante->estado_id;
                        $representanteTemp->usuario_act_id = Yii::app()->user->id;
                        $representanteTemp->fecha_act = date("Y-m-d H:i:s");
                        $representanteTemp->setScenario('crearRepresentante');
                        if ($representanteTemp->validate()) {
                            $registraEstudiante = $this->cargarEstudianteIncribir($mEstudiante, $estatura, $mRepresentante, $edad, $doble_inscripcion_pg_array, $inscripcion_regular_pg_array, $repitiente_pg_array, $observacion, (int) $_POST['DatosGenerales']['plantel_id'], $seccion_plantel_id, $repitiente, $inscripcion_regular, $materia_pendiente, $materia_pendiente_array);

                            // $registraEstudiante = $this->cargarEstudianteIncribir($mEstudiante, $estatura, $representanteTemp, $edad, $doble_inscripcion_pg_array, $inscripcion_regular_pg_array, $repitiente_pg_array, $observacion, (int) $_POST['DatosGenerales']['plantel_id'], $seccion_plantel_id, $repitiente, $inscripcion_regular);
//                            if ($representanteTemp->save()) {
//                                //echo 'actualizo representante ';
//                                $this->registerLog('ESCRITURA', 'plantel.matricula.agregarEstudiante', 'EXITOSO', 'Se ha modificado un representante');
//                                $mEstudiante->representante_id = $representanteTemp->id;
//                                // var_dump($mEstudiante);die();
//                                $registraEstudiante = $this->cargarEstudiante($mEstudiante, $estatura);
//                                //var_dump($registraEstudiante);die();
//                            } else {
//
//                                throw new CHttpException(500, 'Error! No se ha registrado el representante.');
//                            }
                        } else {
                            $this->renderPartial('//errorSumMsg', array('model' => $mRepresentante));
                        }
                    } else {

                        $registraEstudiante = $this->cargarEstudianteIncribir($mEstudiante, $estatura, $mRepresentante, $edad, $doble_inscripcion_pg_array, $inscripcion_regular_pg_array, $repitiente_pg_array, $observacion, (int) $_POST['DatosGenerales']['plantel_id'], $seccion_plantel_id, $repitiente, $inscripcion_regular, $materia_pendiente, $materia_pendiente_array);

//                        if ($mRepresentante->save()) {
//                            // echo 'guardo representante ';
//                            $this->registerLog('ACTUALIZACION', 'plantel.matricula.agregarEstudiante', 'EXITOSO', 'Se ha creado un representante');
//                            $mEstudiante->representante_id = $mRepresentante->id;
//
//                            $registraEstudiante = $this->cargarEstudiante($mEstudiante, $estatura);
//                        } else {
//                            throw new CHttpException(500, 'Error! no se ha completa la operación comuniquelo al administrador del sistema.');
//                        }
                    }
                } else {
                    $this->renderPartial('//errorSumMsg', array('model' => $mRepresentante));
                }
            }
        }
    }

}
