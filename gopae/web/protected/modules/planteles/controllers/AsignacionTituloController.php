<?php

class AsignacionTituloController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Asignación de Título',
        'write' => 'Asignación de Título',
        'label' => 'Asignación de Título'
    );

    const MODULO = "Planteles.AsignacionTitulo";

    /**
     * @return array action filters
     */
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
                'actions' => array('index', 'GuardarAsignacionTitulo'),
                'pbac' => array('read', 'write'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index'),
                'pbac' => array('write'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($id) {
       
        $plantel_id = base64_decode($id);
        $plantelPK = Plantel::model()->findByPk($plantel_id);

//        var_dump($plantel_id);
//        die();
        $estudianteAsignar = Titulo::model()->cadidatoAsignacionTitulo($plantel_id);
        if ($estudianteAsignar) {
//        var_dump($estudianteAsignar);
//        die();
        $dataAsignarEstudiante = $this->dataProviderAsignarTitulo($estudianteAsignar);

        $cadidatoAsignacionTitulo = $this->render('index', array(
            'plantel_id' => $plantel_id,
            'plantelPK' => $plantelPK,
            'dataAsignarEstudiante' => $dataAsignarEstudiante,
        ));
        } else {

            $this->render('mensajeFinal');
        }
    }

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

    function dataProviderAsignarTitulo($estudianteAsignar) {

        foreach ($estudianteAsignar as $key => $value) {
            $cedula_identidad = $value['cedula_identidad'];
            $nombreApellido =  $value['nombres'] . ' ' .$value['apellidos'];
            $gradoSeccion = utf8_encode($value['nombre_grado']) . ' ' . $value['nombre_seccion'];
            $plan = $value['nombre_plan'];

//
//            $plantel_id = $value['plantel_actual_id'];
//            $plan_nombre = $value['nombreplan'];
//            $nombre_seccion = $value['nombre_seccion'];
//            $grado = $value['grado'];
//
//            $nombreApellido = $nombres . ' ' . $apellidos;
//            $botones = "<div class='center'>" . CHtml::checkBox('EstSolicitud[]', "false", array('value' => base64_encode($value['id']),
////                   'onClick' => "Estudiante('')",
//                        "title" => "solicitud")
//                    ) .
//                    "</div>";
            $campos = CHtml::textField('candidatoTitulo[]', '', array('id' => base64_encode($cedula_identidad),));
            $rawData[] = array(
                'id' => $key,
                'cedula_identidad' => '<center>' . $cedula_identidad . '</center>',
                'nombreApellido' => '<center>' . $nombreApellido . '</center>',
                'gradoSeccion' => '<center>' . $gradoSeccion . '</center>',
                'nombre_plan' => "<center>" . $plan . '</center>',
                'campos' => "<center>" . $campos . "</center>",
//                'grado' => "<center>" . $grado . "</center>",
//                'botones' => '<center>' . $botones . '</center>'
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

    public function actionGuardarAsignacionTitulo() {
        if (Yii::app()->request->isAjaxRequest) {

            $cedulaCandidato = $_POST['cedulaCandidato'];
            $serialesAsignarTitulo =  $_POST['candidadoAsignarTitulo'];
            $plantel_id =  $_POST['plantel_id'];
            foreach ($cedulaCandidato as $key => $value) {

                $cedulaCandidato[$key] = base64_decode($value);
            }
//            var_dump($cedulaCandidato);
//            die();            
            $cedulaCandidato_pg_array = Utiles::toPgArray($cedulaCandidato);
            $serialesAsignarTitulo_pg_array = Utiles::toPgArray($serialesAsignarTitulo);

//            $estatusSolicitudId_pg_array = Utiles::toPgArray($estatusSolicitudId);
//            $estatusActualId_pg_array = Utiles::toPgArray($estatusActualId);
//            $plantelId_pg_array = Utiles::toPgArray($plantelId);
            $usuarioIniId = Yii::app()->user->id;
            $modulo = self::MODULO;
            $ip = Yii::app()->request->userHostAddress;
            $username = Yii::app()->user->name;
            $nombreUsuario = Yii::app()->user->nombre;
            $apellidoUsuario = Yii::app()->user->apellido;
            $cedulaUsuario = Yii::app()->user->cedula;
            $transaction = Yii::app()->db->beginTransaction();

            try {

                $resultadoProcesoAlm = Titulo::model()->registrarAsignacionTitulo($cedulaCandidato_pg_array, $serialesAsignarTitulo_pg_array, $plantel_id, $usuarioIniId, $modulo, $ip, $username, $nombreUsuario, $apellidoUsuario, $cedulaUsuario);

                $transaction->commit();
                $respuesta['statusCode'] = 'success';
                $respuesta['mensaje'] = 'Estimado Usuario, el proceso de asignacion de título se ha realizado exitosamente.';



                echo json_encode($respuesta);
                unset(Yii::app()->session['solicitud']);
                // var_dump($resultadoProcesoAlm);
            } catch (Exception $ex) {
                $transaction->rollback();

//  $this->registerLog('ESCRITURA', self::MODULO . 'InscribirEstudiantes', 'FALLIDO', 'Ha intentado matricular la Seccion Plantel ' . $seccion_plantel_id);
                $respuesta['statusCode'] = 'alert';
                $error = $ex->getMessage();
//                var_dump($error);
//                die();
                $capturarCadena = explode("*", $error);
                $mensajeSerial = $capturarCadena[1] . ' ' . $capturarCadena[2];
              //  $respuesta['mensaje'] = $mensajeSerial;
                $respuesta['alert'] = $mensajeSerial;
                echo json_encode($respuesta);
            }
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

}
