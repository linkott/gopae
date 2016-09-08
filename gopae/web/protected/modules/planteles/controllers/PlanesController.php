<?php

class PlanesController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Permite Consultar Planes de Estudios',
        'write' => 'Permite Crear , Modificar , Activar, Inactivar Planes de Estudios',
        //'admin'=> 'Administración de Planes de Estudios'
        'label' => 'Planes de Estudios de un Plantel'
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
                    'consultar',),
                'pbac' => array('read'),
            ),
            //en esta seccion colocar todos los action del modulo
            array('allow',
                'actions' => array(
                    'asignarPlan',
                    'cambiarEstatus',
                    'planesDisponibles',
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
            $model = new PlanPlantel('search');
            $model->unsetAttributes();  // clear any default values
            $id = $_REQUEST['id'];
            $plantel_id = base64_decode($id);
            $model->plantel_id = $plantel_id;

            if (isset($_GET['PlanPlantel'])) {
                $model->attributes = $_GET['PlanPlantel'];
                $model->plantel_id = $_GET['PlanPlantel']['plantel_id'];
                $model->cod_plan = $_GET['PlanPlantel']['cod_plan'];
                $model->plan = $_GET['PlanPlantel']['plan'];
                $model->mencion = $_GET['PlanPlantel']['mencion'];
                $model->credencial = $_GET['PlanPlantel']['credencial'];
                $model->fund_juridico = $_GET['PlanPlantel']['fund_juridico'];
            } elseif (isset($_GET['plantel_id']) && isset($_GET['cod_plan']) && isset($_GET['plan']) && isset($_GET['mencion']) && isset($_GET['credencial']) && isset($_GET['fund_juridico'])) {
                $model->plantel_id = $_GET['plantel_id'];
                $model->cod_plan = $_GET['cod_plan'];
                $model->plan = $_GET['plan'];
                $model->mencion = $_GET['mencion'];
                $model->credencial = $_GET['credencial'];
                $model->fund_juridico = $_GET['fund_juridico'];
            }
            $data = Plantel::model()->obtenerDatosIdentificacion($plantel_id);
            $this->render('index', array(
                'model' => $model,
                'datosPlantel' => $data,
            ));
        } else
        if (array_key_exists('id', $_REQUEST) && $_REQUEST['id'] !== '') {
            $id = $_REQUEST['id'];
            $plantel_id = base64_decode($id);
            if (is_numeric($plantel_id)) {
                $model = new PlanPlantel('search');
                $model->unsetAttributes();  // clear any default values
                $model->plantel_id = $plantel_id;
                $data = Plantel::model()->obtenerDatosIdentificacion($plantel_id);
                $this->render('index', array(
                    'model' => $model,
                    'datosPlantel' => $data,
                ));
            } else
                throw new CHttpException(404, 'No se ha encontrado el recurso que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // no es numerico
        } else
            throw new CHttpException(404, 'No se ha especificado el Plantel al cual desea visualizar los Planes de Estudios. Vuelva a la página anterior e intentelo de nuevo.'); // esta vacio el request
    }

    public function actionPlanesDisponibles() {

        if (Yii::app()->request->isAjaxRequest && array_key_exists('plantel_id', $_REQUEST) && $_REQUEST['plantel_id'] !== '') {

            $id = $plantel_id = $_REQUEST['plantel_id'];

            //$plantel_id = base64_decode($id);

            if (is_numeric($plantel_id)) {

                $nivelesPlantel = $this->obtenerNiveles($plantel_id);
                $planesNivelPlanel = $this->obtenerPlanesNivelPlantel($nivelesPlantel);
                $planesAsignados = $this->obtenerPlanesAsignados($plantel_id);
                $planesDispoiblesIds = $this->filtrarPlanesDisponibles($planesNivelPlanel, $planesAsignados);
                $planesDisponibles = $this->obtenerDatosPlanesDisponibles($planesDispoiblesIds);
                $model = new PlanPlantel('asignarPlan');
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                $this->renderPartial('_asignarPlan', array(
                    'planesDisponibles' => $planesDisponibles,
                    'modelPlan' => $model,
                    'plantel_id' => $plantel_id
                        ), false, true);
                Yii::app()->end();
            } else
                throw new CHttpException(404, 'No se ha encontrado el recurso que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.'); // no es numerico
        } else
            throw new CHttpException(404, 'Usted no esta autorizado para acceder mediante esta via. Vuelva a la página anterior e intentelo de nuevo.'); // esta vacio el request
    }

    public function actionAsignarPlan() {
        if (Yii::app()->request->isAjaxRequest && array_key_exists('plantel_id', $_REQUEST) && array_key_exists('PlanPlantel', $_REQUEST)) {

            $id = $plantel_id = $_REQUEST['plantel_id'];
            $plan_id = $_REQUEST['PlanPlantel']['plan_id'];
            //$plantel_id = base64_decode($id);
            $model = new PlanPlantel('asignarPlan');
            $model->plan_id = $plan_id;
            $model->plantel_id = $plantel_id;
            $model->usuario_ini_id = Yii::app()->user->id;
            $model->estatus = 'A';
            if ($model->validate()) {

                $this->validarPlantel($plantel_id);
                $this->validarPlan($plan_id);


                if ($model->save()) {
                    Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                    echo json_encode(array('message' => 'Se Agregó el Plan de Estudio Exitosamente'));
                    Yii::app()->end();
                } else {
                    Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                    $this->renderPartial('//errorSumMsg', array('model' => $model, false, true));
                    Yii::app()->end();
                }
            } else {
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                $this->renderPartial('//errorSumMsg', array('model' => $model, false, true));
                Yii::app()->end();
            }
        } else
            throw new CHttpException(999, 'Usted no esta autorizado para acceder mediante esta via. Vuelva a la página anterior e intentelo de nuevo.'); // esta vacio el request
    }

    public function actionCambiarEstatus($id) {

        $accion = $this->getPost('accion');

        if (in_array($accion, array('E', 'A'))) {

            $idDecoded = base64_decode($id);

            $plan = new PlanPlantel();

            if (is_numeric($idDecoded)) {

                $model = PlanPlantel::model()->findByPk($idDecoded);

                if ($model) {

                    $result = $plan->cambiarEstatusPlanPlantel($idDecoded, $accion);

                    if ($result->isSuccess) {

                        if ($accion == 'E') {
                            $this->registerLog('ELIMINACION', 'planteles.planPlantel.cambiarEstatus', 'EXITOSO', 'Se ha Inactivado el Plan de Estudio ' . $model->plan_id . ' para el plantel' . $model->plantel_id);
                        } else {
                            $this->registerLog('ESCRITURA', 'planteles.planPlantel.cambiarEstatus', 'EXITOSO', 'Se ha Activado el Plan de Estudio ' . $model->plan_id . ' para el plantel' . $model->plantel_id);
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
                    throw new CHttpException(404, 'No se ha encontrado el Plan de Estudio que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
                }
            } else {
                throw new CHttpException(404, 'No se ha encontrado el Plan de Estudio que ha solicitado. Vuelva a la página anterior e intentelo de nuevo.');
            }
        } else {

            $class = 'errorDialogBox';
            $message = 'No se ha especificado la acción a tomar sobre el grupo, recargue la página e intentelo de nuevo.';

            $this->renderPartial('//msgBox', array(
                'class' => $class,
                'message' => $message,
            ));
        }
    }

    public function obtenerNiveles($plantel_id) {

        $model = NivelPlantel::model()->getNiveles($plantel_id);

        if (!$model)
            throw new CHttpException(999, 'Estimado Usuario, debe solicitar a Registro y Control de Estudios asociar los niveles al plantel y despues usted podrá asignar los planes de estudios al mismo. Para agilizar el proceso le recomendamos aperturar un ticket indicando dicha situación y sumunistrando el Código del Plantel o el Código Estadistico del Plantel. Para aperturar un ticket presione <a href="/ayuda/ticket">aqui</a>.');

        return $model;
    }

    public function obtenerPlanesNivelPlantel($niveles_plantel) {

        $model = NivelPlan::model()->getPlanesNivelPlantel($niveles_plantel);

        if (!$model)
            throw new CHttpException(999, 'Estimado Usuario, no concuerdan los Niveles Asociados al Plantel con nuestros registros. Debe solicitar a Registro y Control de Estudios. Para agilizar el proceso le recomendamos aperturar un ticket indicando dicha situación y sumunistrando el Código del Plantel o el Código Estadistico del Plantel. Para aperturar un ticket presione <a href="/ayuda/ticket">aqui</a>. ');

        return $model;
    }

    public function obtenerPlanesAsignados($plantel_id) {

        $model = PlanPlantel::model()->getPlanesAsignados($plantel_id);

        if (!is_array($model))
            throw new CHttpException(999, 'Estimado Usuario, (falta msj).');

        return $model;
    }

    public function filtrarPlanesDisponibles($planesNivelPlanel, $planesAsignados) {
        $planesDisponibles = array();
        foreach ($planesNivelPlanel as $value) {
            if (!in_array($value, $planesAsignados)) {
                $planesDisponibles[] = $value;
            }
        }
        return $planesDisponibles;
    }

    public function obtenerDatosPlanesDisponibles($plan_ids) {
        if ($plan_ids !== array())
            $model = Plan::model()->getDatosPlanes($plan_ids);
        else
            throw new CHttpException(999, 'Estimado Usuario, no posee más Planes de Estudio para asignar.');

        return $model;
    }

    public function validarPlantel($plantel_id) {

        $result = Plantel::model()->findByPk($plantel_id);

        if ($result === null)
            throw new CHttpException(999, 'Estimado Usuario, ha alterado algunos valores, cierre la ventana e intente nuevamente.');

        return $result;
    }

    public function validarPlan($plan_id) {

        $result = Plan::model()->findByPk($plan_id);

        if ($result === null)
            throw new CHttpException(999, 'Estimado Usuario, ha alterado algunos valores, cierre la ventana e intente nuevamente.');

        return $result;
    }

    /**
     * Permite generar la columna acciones del CGridView que muestra las planes que posee determinado plantel
     * @param array $data Contiene la data procesada de determinada fila mediante el dataProvider que recibe el CGridView
     */
    public function columnaAcciones($data) {
        $estatus = $data["estatus"];
        $columna = '<div class="action-buttons">';
        $mencion = (is_object($data->planes->mencion) && isset($data->planes->mencion->nombre)) ? $data->planes->mencion->nombre : "";
        $dopcion = (is_object($data->planes->mencion) && isset($data->planes->mencion->nombre)) ? $data->planes->mencion->nombre : "";
        $nombre = (is_object($data->planes) && isset($data->planes->nombre)) ? $data->planes->nombre : "";
        $data_description = $nombre . '[' . $mencion . '][' . $dopcion . ']';

        if (Yii::app()->user->pbac('read'))
            $columna .= CHtml::link("", "#", array("class" => "fa icon-zoom-in look-data", 'data-id' => base64_encode($data->plan_id), "title" => "Consultar Plan de Estudio")) . '&nbsp;&nbsp;';

        if (Yii::app()->user->pbac('write')) {
            if (($estatus == 'A') || ($estatus == '')) {
                $columna .= CHtml::link("", "#", array("class" => "fa icon-trash red change-status", 'data-action' => 'E', 'data-id' => base64_encode($data->id), 'data-description' => $data_description, "title" => "Inactivar Plan de Estudio")) . '&nbsp;&nbsp;';
            } else if ($estatus == 'E') {
                $columna .= CHtml::link("", "", array("class" => 'fa fa-check change-status', 'data-action' => 'A', 'data-id' => base64_encode($data->id), 'data-description' => $data_description, 'title' => 'Activar Plan de Estudio'));
            }
        }
        $columna .= '</div>';
        return $columna;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PlanPlantel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PlanPlantel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PlanPlantel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'plantel-plan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
