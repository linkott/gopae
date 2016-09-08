<?php

class TituloController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    const MODULO = "Titulo.Solicitud";

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'indexTitulo', 'MostrarSolicitanteAlTitulo', 'registroSolicitudTitulo'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndexTitulo($id) {
        $plantel_id = base64_decode($id);
        $this->render('indexTitulo', array(
            'plantel_id' => $plantel_id,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Titulo;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Titulo'])) {
            $model->attributes = $_POST['Titulo'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Titulo'])) {
            $model->attributes = $_POST['Titulo'];
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
    //	public function actionIndex()
    //	{
    //		$dataProvider=new CActiveDataProvider('Titulo');
    //		$this->render('index',array(
    //			'dataProvider'=>$dataProvider,
    //		));
    //	}

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $model = new Titulo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Titulo']))
            $model->attributes = $_GET['Titulo'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Titulo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Titulo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Titulo $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'titulo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionMostrarSolicitanteAlTitulo($id) {

        $plantel_id = base64_decode($id);


        if (!is_numeric($plantel_id)) {
            throw new CHttpException(404, 'No se ha encontrado la solicitud de titulo. Vuelva a la página anterior e intentelo de nuevo.'); // es numerico
        } else {


            if ($plantel_id != '') {
                $plantelPK = Plantel::model()->findByPk($plantel_id);

                if ($plantelPK == null) {
                    $this->redirect('../../../consultar');
                }
            } else {

                $this->redirect('../../../consultar');
            }

            $resulSolicitudDeTitulo = Titulo::model()->solicitudTitulo($plantel_id);

//            $cantidaArreglo = count($resulSolicitudDeTitulo);
//            
//            var_dump($plantel_id);

            if ($resulSolicitudDeTitulo == array()) {

                $this->render('mensajeFinal');
//              $this->createUrl('mensajeFinal');
            } else {

                Yii::app()->session['solicitud'] = $resulSolicitudDeTitulo;

                if ($resulSolicitudDeTitulo) {

                    $dataSolicitud = $this->dataProviderSolicitudTitulo($resulSolicitudDeTitulo);
                    $this->render('admin', array('dataProvider' => $dataSolicitud,
                        'plantelPK' => $plantelPK
                            ), FALSE, TRUE);
                } else {

                }
            }
        }
    }

    function dataProviderSolicitudTitulo($resulSolicitudDeTitulo) {
        foreach ($resulSolicitudDeTitulo as $key => $value) {
            $cedula_identidad = $value['cedula_identidad'];
            $nombres = $value['nombres'];
            $apellidos = $value['apellidos'];
            $plantel_id = $value['plantel_actual_id'];
            $plan_nombre = $value['nombreplan'];
            $nombre_seccion = $value['nombre_seccion'];
            $grado = $value['grado'];

            $nombreApellido = $nombres . ' ' . $apellidos;
            $botones = "<div class='center'>" . CHtml::checkBox('EstSolicitud[]', "false", array('value' => base64_encode($value['id']),
//                   'onClick' => "Estudiante('')",
                        "title" => "solicitud")
                    ) .
                    "</div>";
//            $columna .= CHtml::checkBox('repitiente[]', false, array('id' => 'repitiente[]', 'title' => 'Repitente')) . '&nbsp;&nbsp;&nbsp;';
            $rawData[] = array(
                'id' => $key,
                'cedula_identidad' => '<center>' . $cedula_identidad . '</center>',
                'nombreApellido' => '<center>' . $nombreApellido . '</center>',
                'plan_nombre' => '<center>' . $plan_nombre . '</center>',
                'nombre_seccion' => "<center>" . $nombre_seccion . '</center>',
                'grado' => "<center>" . $grado . "</center>",
                'botones' => '<center>' . $botones . '</center>'
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

    public function actionRegistroSolicitudTitulo() {
        if (Yii::app()->request->isAjaxRequest) {


            $model = new Titulo;
            $resulSolicitudDeTitulo = Yii::app()->session->get('solicitud');
            $estudianteSeleccionado = $_POST['EstSeleccionado'];


            $estudianteSeleccionado = array_unique($estudianteSeleccionado);
            foreach ($estudianteSeleccionado as $key => $value) {

                $estudianteSeleccionado[$key] = base64_decode($value);
//            var_dump($estudianteSeleccionado);
//            die();
            }
//            var_dump($estudianteSeleccionado);
//            die();
            foreach ($estudianteSeleccionado as $keY2 => $value2) {

                foreach ($resulSolicitudDeTitulo as $key1 => $value1) {


                    if ((int) $value2 == $resulSolicitudDeTitulo[$key1]['id']) {
//                        echo "paso por el if";
//                        echo '<br>';
                        $idEstudiante[] = $resulSolicitudDeTitulo[$key1]['id'];
                        $gradoIdEstudiante[] = $resulSolicitudDeTitulo[$key1]['id_grado'];
                        $seccionIDEstudiante[] = $resulSolicitudDeTitulo[$key1]['id_seccion'];
                        $planIdEstudiante[] = $resulSolicitudDeTitulo[$key1]['plan_id'];
                        $seccionPlantelPeriodoIdEstudiante[] = $resulSolicitudDeTitulo[$key1]['seccion_plantel_periodo_id'];
                        $estatus[] = "A";
                        $tipoDocumentoId[] = 1;
                        $usuarioIniId[] = Yii::app()->user->id;
                        $periodoId[] = $resulSolicitudDeTitulo[$key1]['periodo_id'];
                        $estatusSolicitudId [] = 1;
                        $estatusActualId[] = 11;
                        $plantelId[] = $resulSolicitudDeTitulo[$key1]['plantel_actual_id'];

//                        var_dump($idEstudiante);
//                        var_dump($gradoIdEstudiante);
//                        var_dump($seccionIDEstudiante);
//                        var_dump($planIdEstudiante);
//                        var_dump($seccionPlantelPeriodoIdEstudiante);
//                        var_dump($tipoDocumentoId);
//                        var_dump($usuarioIniId);
//                        var_dump($periodoId);
//                        var_dump($estatusSolicitudId);
//                        var_dump($estatusActualId);
//                        var_dump($plantelId);
                    }
                }
            }
            $idEstudiante_pg_array = Utiles::toPgArray($idEstudiante);
            $gradoIdEstudiante_pg_array =  Utiles::toPgArray($gradoIdEstudiante);
            $seccionIDEstudiante_pg_array =  Utiles::toPgArray($seccionIDEstudiante);
            $planIdEstudiante_pg_array = Utiles::toPgArray($planIdEstudiante);
            $seccionPlantelPeriodoIdEstudiante_pg_array =  Utiles::toPgArray($seccionPlantelPeriodoIdEstudiante);
            $estatus_pg_array =  Utiles::toPgArray($estatus);
            $tipoDocumentoId_pg_array =  Utiles::toPgArray($tipoDocumentoId);
            $usuarioIniId_pg_array =  Utiles::toPgArray($usuarioIniId);
            $periodoId_pg_array =  Utiles::toPgArray($periodoId);
            $estatusSolicitudId_pg_array =  Utiles::toPgArray($estatusSolicitudId);
            $estatusActualId_pg_array = Utiles::toPgArray($estatusActualId);
            $plantelId_pg_array = Utiles::toPgArray($plantelId);

            $modulo = self::MODULO;
            $ip = Yii::app()->request->userHostAddress;
            $username = Yii::app()->user->name;
            $transaction = Yii::app()->db->beginTransaction();

            try {

                $resultadoProcesoAlm = Titulo::model()->registroSolicitud($idEstudiante_pg_array, $gradoIdEstudiante_pg_array, $seccionIDEstudiante_pg_array, $planIdEstudiante_pg_array, $seccionPlantelPeriodoIdEstudiante_pg_array, $estatus_pg_array, $tipoDocumentoId_pg_array, $usuarioIniId_pg_array, $periodoId_pg_array, $estatusSolicitudId_pg_array, $estatusActualId_pg_array, $plantelId_pg_array, $modulo, $ip, $username);

                $transaction->commit();
                $respuesta['statusCode'] = 'success';
                $respuesta['mensaje'] = 'Estimado Usuario, el proceso de solicitud de título se ha realizado exitosamente.';



                echo json_encode($respuesta);
                unset(Yii::app()->session['solicitud']);
                // var_dump($resultadoProcesoAlm);
            } catch (Exception $ex) {




                $transaction->rollback();

                $respuesta['statusCode'] = 'alert';
                $error = $ex->getMessage();

                $capturarCadena = explode("*", $error);

                $mensajeSerial = $capturarCadena[1] . ' CI: ' . $capturarCadena[2];

                $respuesta['error'] = $mensajeSerial;
                echo json_encode($respuesta);


            }
//            $this->renderpartial('mensajeFinal', array('model' => $model));
//            $this->createUrl('mensajeFinal');
//            Yii::app()->redo
//            Yii::app()->end();
        } else {

            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
//        var_dump($estudianteSeleccionado);
//
//        die();
    }

}
