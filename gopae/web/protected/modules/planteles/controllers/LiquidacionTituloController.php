<?php

class LiquidacionTituloController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Liquidación de Título',
        'write' => 'Liquidación de Título',
        'label' => 'Liquidación de Título'
    );

    const MODULO = "Planteles.LiquidacionTitulo";

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
                'actions' => array('index'),
                'pbac' => array('read', 'write'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('guardarLiquidacionSeriales'),
                'pbac' => array('write'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($id) {

        $plantel_id = base64_decode($id);

        if (!is_numeric($plantel_id)) {
            throw new CHttpException(404, 'No se ha encontrado el plantel que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // es numerico
//            $mensaje = "No se ha encontrado el plantel que ha solicitado. Recargue la página e intentelo de nuevo.";
//            Yii::app()->user->setFlash('mensajeError', "$mensaje");
//            $this->renderPartial('//flashMsgv2');
            // Yii::app()->end();
        } else {

            $plantelPK = Plantel::model()->findByPk($plantel_id);
            $dataProviderMostrarLiquidacion = array();
            $dataProviderDatosDirector = array();
            $mensaje_liquidacionExitosa = '';
            $resultadoSeriales = Titulo::model()->serialesNoAsignados($plantel_id, $a = 'N');
            if ($resultadoSeriales != false) {
                $dataProviderLiquidacion = $this->dataProviderLiquidacion($resultadoSeriales);
//        var_dump($dataProviderLiquidacion);
//        die();
                $this->render('index', array(
                    'plantel_id' => $plantel_id,
                    'plantelPK' => $plantelPK,
                    'dataProviderLiquidacion' => $dataProviderLiquidacion,
                    'dataProviderMostrarLiquidacion' => $dataProviderMostrarLiquidacion,
                    'dataProviderDatosDirector' => $dataProviderDatosDirector,
                    'mensaje_liquidacionExitosa' => $mensaje_liquidacionExitosa
                ));
            } else {

                $dataProviderLiquidacion = array();
                $mostrarLiquidacionDeSeriales = Titulo::model()->mostrarLiquidacionDeSeriales($plantel_id);
                if ($mostrarLiquidacionDeSeriales != false) {
                    $dataProviderMostrarLiquidacion = $this->dataProviderMostrarLiquidacion($mostrarLiquidacionDeSeriales);

                    $resultado_datos_director = Titulo::model()->datosDirector($plantel_id);
                    if ($resultado_datos_director != false) {
                        $dataProviderDatosDirector = $this->dataProviderDatosDirector($resultado_datos_director);

                        $this->render('index', array(
                            'plantel_id' => $plantel_id,
                            'plantelPK' => $plantelPK,
                            'dataProviderMostrarLiquidacion' => $dataProviderMostrarLiquidacion,
                            'dataProviderLiquidacion' => $dataProviderLiquidacion,
                            'dataProviderDatosDirector' => $dataProviderDatosDirector,
                            'mensaje_liquidacionExitosa' => $mensaje_liquidacionExitosa
                        ));
                    } else {

                        $dataProviderDatosDirector == false;
                        $this->render('index', array(
                            'plantel_id' => $plantel_id,
                            'plantelPK' => $plantelPK,
                            'dataProviderMostrarLiquidacion' => $dataProviderMostrarLiquidacion,
                            'dataProviderLiquidacion' => $dataProviderLiquidacion,
                            'dataProviderDatosDirector' => $dataProviderDatosDirector,
                            'mensaje_liquidacionExitosa' => $mensaje_liquidacionExitosa
                        ));
                    }
                } else {

                    $this->render('noTieneSeriales', array(
                        'plantel_id' => $plantel_id,
                        'plantelPK' => $plantelPK
                    ));
                }
//            $this->render('noTieneSeriales', array(
//                'plantel_id' => $plantel_id,
//                'plantelPK' => $plantelPK
//            ));
            }
        }
    }

    public function dataProviderDatosDirector($resultado_datos_director) {

        foreach ($resultado_datos_director as $key => $value) {
            $nombre = $value['nombre'];
            $apellido = $value['apellido'];
            $cedula = $value['cedula'];

            $rawData[] = array(
                'id' => $key,
                'nombre' => '<center>' . $nombre . '</center>',
                'apellido' => '<center>' . $apellido . '</center>',
                'cedula' => '<center>' . $cedula . '</center>',
            );
        }

        return new CArrayDataProvider($rawData, array(
            'pagination' => false
                )
        );
    }

    public function dataProviderLiquidacion($resultadoSeriales) {
        foreach ($resultadoSeriales as $key => $value) {
            $serial = $value['serial'];
            //     $plantel_id = $value['plantel_id'];

            $rawData[] = array(
                'id' => $key,
                'serial' => '<center>' . $serial . '</center>',
                    //     'plantel_id' => '<center>' . $plantel_id . '</center>',
            );
        }

        return new CArrayDataProvider($rawData, array(
            'pagination' => false
                )
        );
    }

    public function actionGuardarLiquidacionSeriales($id) {

        $plantel_id = base64_decode($id);

        if (!is_numeric($plantel_id)) {
            // throw new CHttpException(404, 'No se ha encontrado la sección que ha solicitado para modificar. Vuelva a la página anterior e intentelo de nuevo.'); // es numerico
            $mensaje = "No se ha encontrado el plantel que ha solicitado. Recargue la página e intentelo de nuevo.";
            Yii::app()->user->setFlash('mensajeError', "$mensaje");
            $this->renderPartial('//flashMsgv2');
            // Yii::app()->end();
        } else {

            $liquidacionSerial = $_REQUEST['estatus_actual_id'];
            $observacionSerial = $_REQUEST['observacion'];
            $dataProviderLiquidacion = array();
            $resultadoSeriales = Titulo::model()->serialesNoAsignados($plantel_id, $a = 'S');

            if ($resultadoSeriales != false) {

                $transaction = Yii::app()->db->beginTransaction();

                foreach ($liquidacionSerial as $key => $value) {
                    $liquidacion[] = (int) $value;
                }

                foreach ($observacionSerial as $key => $value) {
                    $observacion[] = (string) $value;
                }

                foreach ($resultadoSeriales as $key => $value) {
                    $serial[] = (int) $value;
                }

                $serialTotal = Utiles::toPgArray($serial);
                $observacionTotal = Utiles::toPgArray($observacion);
                $liquidacionTotal = Utiles::toPgArray($liquidacion);

                $modulo = self::MODULO;
                $ip = Yii::app()->request->userHostAddress;
                $username = Yii::app()->user->name;
                $nombre = Yii::app()->user->nombre;
                $apellido = Yii::app()->user->apellido;
                $cedula = Yii::app()->user->cedula;

                try {

                    $resultadoGuardarLiquidacionSeriales = Titulo::model()->liquidacionSeriales($plantel_id, $serialTotal, $observacionTotal, $liquidacionTotal, $modulo, $ip, $username, $nombre, $apellido, $cedula);
                    $transaction->commit();


//                $respuesta['statusCode'] = 'success';
//                $respuesta['mensaje'] = 'Estimado Usuario, el proceso de liquidación de título se ha realizado exitosamente.';
//                echo json_encode($respuesta);

                    $mensaje_liquidacionExitosa.="Estimado Usuario, el proceso de liquidación de título se ha realizado exitosamente.";
                    $mostrarLiquidacionDeSeriales = Titulo::model()->mostrarLiquidacionDeSeriales($plantel_id);
                    //  var_dump($mostrarLiquidacionDeSeriales);
                    $dataProviderMostrarLiquidacion = $this->dataProviderMostrarLiquidacion($mostrarLiquidacionDeSeriales);
                    $plantelPK = Plantel::model()->findByPk($plantel_id);
                    $resultado_datos_director = Titulo::model()->datosDirector($plantel_id);
                    $dataProviderDatosDirector = $this->dataProviderDatosDirector($resultado_datos_director);
                    $this->renderPartial('index', array(
                        'plantel_id' => $plantel_id,
                        'plantelPK' => $plantelPK,
                        'dataProviderMostrarLiquidacion' => $dataProviderMostrarLiquidacion,
                        'dataProviderLiquidacion' => $dataProviderLiquidacion,
                        'dataProviderDatosDirector' => $dataProviderDatosDirector,
                        'mensaje_liquidacionExitosa' => $mensaje_liquidacionExitosa
                    ));
                } catch (Exception $ex) {
                    $transaction->rollback();

                    $respuesta['statusCode'] = 'error';
                    $respuesta['error'] = $ex;
                    $respuesta['mensaje'] = 'Estimado Usuario, ha ocurrido un error durante el proceso de liquidación de título. Intente nuevamente.';
                    echo json_encode($respuesta);
                }
            }
            // echo "estoy aqui";
        }
    }

    public function dataProviderMostrarLiquidacion($mostrarLiquidacionDeSeriales) {
        foreach ($mostrarLiquidacionDeSeriales as $key => $value) {
            $serial = $value['serial'];
            $nombre = $value['nombre'];
            $observacion = $value['observacion'];

            $rawData[] = array(
                'id' => $key,
                'serial' => '<center>' . $serial . '</center>',
                'nombre' => '<center>' . $nombre . '</center>',
                'observacion' => '<center>' . $observacion . '</center>',
            );
        }

        return new CArrayDataProvider($rawData, array(
            'pagination' => false
                )
        );
    }

    public function columnaLiquidacion($data) {

        //   $model = new Titulo;
        $selectLiquidacion = EstatusTitulo::model()->selectLiquidacion();
        $liquidacion = CHTML::dropDownList('estatus_actual_id[]', 'estatus_actual_id', CHtml::listData($selectLiquidacion, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'style' => 'width: 100%'));
        $columna = '<center>' . $liquidacion . '</center>';

        return $columna;
    }

    public function columnaObservacion($data) {

        $model = new EstatusTitulo;
        //   $selectLiquidacion = EstatusTitulo::model()->selectLiquidacion();
        $columnaAccion = "<input type='text' id='observacion' class='indeca span-7'  name='observacion[]'>";
        //   $liquidacion = "echo CHTML::dropDownList($model, 'cargo_responsable_id', CHtml::listData($selectLiquidacion, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7'))";
        $columna = '<center>' . $columnaAccion . '</center>';

        return $columna;
    }

//    public function columnaSerial($data) {
//
//        $serial = "<input type='text' id='serial' class='indeca span-7'  name='serial[]' readonly=true>";
//        $columna = '<center>' . $serial . '</center>';
//
//        return $columna;
//    }

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

}
