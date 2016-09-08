<?php

class PlanificacionController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Gestion de Planificacion',
        'write' => 'Gestion de Planificacion',
        'label' => 'Gestion de Planificacion'
    );

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
                'actions' => array('index', 'todosEventos', 'obtenerMenu', 'agregarEvento', 'actualizarPlanificacion', 'detallesPlanificacion', 'eliminarPlanificacion', 'guardarCambios', 'limpiarEventos', 'asignarPlanificacion', 'planificarPeriodo'),
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

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //VERIFICO SI LA PLANIFICACION DEL MES ANTERIOR MANTIENE EL ESTATUS
        //EN A, PARA ACTUALIZARLO A ESTATUS CERRADO C
        $modelPlanificacion = new Planificacion;
        $periodo = PeriodoEscolar::model()->findAll(array('condition' => "estatus = 'A'"));
        
//        $fecha_ini_pae = Configuracion::model()->findAll(array('condition' => "nombre = 'FECHA_INI_PAE'"));
////        var_dump($fecha_ini_pae);die();
//        $fecha_ini_pae = $fecha_ini_pae[0]['valor_date'];
//        $fecha_fin_pae = Configuracion::model()->findAll(array('condition' => "nombre = 'FECHA_FIN_PAE'"));
//        $fecha_fin_pae = $fecha_fin_pae[0]['valor_date'];
//        //SELECT id, periodo, anio_inicio, anio_fin 
//        $fecha_periodo = PeriodoEscolar::model()->findAll(array('condition' => "estatus = 'A'"));
//        $fecha_inicio_periodo = $fecha_periodo[0]['anio_inicio'];
//        $fecha_fin_periodo = $fecha_periodo[0]['anio_fin'];
//        
//        $registrarPeriodo = '';
//        $registrosPlanificacion = Planificacion::model()->findAll(array('condition' => 'EXTRACT(YEAR FROM fecha_inicio)'));
//        if($fecha_ini_pae == $fecha_inicio_periodo && $fecha_fin_pae == $fecha_fin_periodo){
//            $registrarPeriodo = true;
//        }
        $plantel_id = '';
        if(isset($_REQUEST['id'])){
            $plantel_id = 'id/' . base64_decode($_REQUEST['id']);
        }

        $this->render('index', array('periodo' => $periodo[0]['periodo'], 'url'  => $plantel_id ));
    }

    public function actionTodosEventos() {
        $model = new Planificacion;
        $json = array();
//        $planificacion = $model->findAll();
        $periodo = PeriodoEscolar::model()->findAll(array('condition' => "estatus = 'A'"));
        $plantel_id = '';
        if(isset($_REQUEST['id'])){
            $plantel_id = $_REQUEST['id'];
        }
        $planificacion = $model->mostrarPlanificacion($plantel_id, $periodo[0]['periodo']);
        $cantidadPlanificacion = count($planificacion);
        echo '[';
        foreach ($planificacion AS $p => $planificacionValor) {
            $menuNutricional = MenuNutricional::model()->findAll(array('condition' => 'id=' . $planificacionValor['menu_nutricional_id']));
            $json['id'] = $planificacionValor['id'];
            $json['title'] = $menuNutricional[0]['nombre'];
            $json['start'] = $planificacionValor['fecha_inicio'];
            $json['end'] = $planificacionValor['fecha_fin'];
            $json['editable'] = false;
            $json['className'] = $planificacionValor['classname'];
            if ($p == $cantidadPlanificacion - 1) {
                echo json_encode($json);
            } else {
                echo json_encode($json) . ',';
            }
        }echo ']';
    }

    public function actionObtenerMenu() {
        $json = array();
        $item = $_REQUEST['id'];
        if ($item != '') {
            $tipoMenu = TipoMenu::model()->findAll(array('condition' => 'id = ' . $item));
            $labelTipoMenu = $tipoMenu[0]['nombre_label'];
            if ($item == '' || $item == NULL) {
                $lista = array('' => '- - -');
                foreach ($lista as $valor => $descripcion) {
                    echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                }
            } else {
                $lista = MenuNutricional::model()->findAll('tipo_menu = :item', array(':item' => $item), array('order' => 'nombre ASC'));
                $lista = CHtml::listData($lista, 'id', 'nombre');

                //                echo CHtml::tag('option', array('value' => ''), CHtml::encode('- SELECCIONE -'), true);

                foreach ($lista as $valor => $descripcion) {
                    $value = CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
                    $json['label'] = $labelTipoMenu; //Nombre label
                    $json['value'] = $value;
                    echo json_encode($json);
                }
            }
        }
    }

    public function actionAgregarEvento() {
        $json = array();
        $modelPlanificacion = new Planificacion();
        $menu_nutricional_id = $_POST['menu_nutricional_id'];
        $plantel_id = $_POST['plantel_id'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $allDay = $_POST['allDay'];
        $menuNutricional = MenuNutricional::model()->findAll(array('condition' => 'id = ' . $menu_nutricional_id));
        $tipoMenu = TipoMenu::model()->findAll(array('condition' => 'id = ' . $menuNutricional[0]['tipo_menu']));
        $className = $tipoMenu[0]['nombre_label'];

        $mesActual = date('m') + 1;
        if ($mesActual == 13) {
            $mesActual = 1;
        }
        $mesPost = date_format(date_create($start), 'm');

        $usuario_ini_id = Yii::app()->user->id;
        $fecha_ini = date("Y-m-d H:i:s");
//            if($allDay == 1){ $allDay = 'true'; }
//            if($allDay == 0){ $allDay = 'false'; }
//            var_dump($allDay);die();
        $modelPlanificacion->menu_nutricional_id = $menu_nutricional_id;
        $modelPlanificacion->tipo_menu_id = $tipoMenu[0]["id"];
        $modelPlanificacion->plantel_id = $plantel_id;
        $modelPlanificacion->fecha_inicio = $start;
        $modelPlanificacion->fecha_fin = $start;
//            $modelPlanificacion->allday = 'TRUE';
        $modelPlanificacion->classname = $className;
        $modelPlanificacion->usuario_ini_id = $usuario_ini_id;
        $modelPlanificacion->fecha_ini = $fecha_ini;
        $modelPlanificacion->estatus = 'A';

        //IDENTIFICO PARA QUE EL USUARIO AGREGE PLANIFICACION EN EL MES
        $mes = date_format(date_create($start), 'm');
        $mesActualPost = $_POST['mes'];
//            var_dump($mesActual);die();
        //SE REALIZA UNA CONSULTA EN LA BASE DE DATOS PARA IDENTIFICAR LA CANTIDAD DE INGESTA QUE POSEE EL PLANTEL
        $plantelPae = PlantelIngesta::model()->findAll(array('condition' => 'plantel_id = ' . $plantel_id));
//            var_dump($plantelPae);
//            if($plantelPae != null) {
        //IDENTIFICO SI ESA FECHA ESTA FERIADA Y NO PUEDA PLANIFICARLA
        $diaFeriado = Planificacion::model()->diasFeriados($_REQUEST['start']);
//                    var_dump($diaFeriado);die();
        if ($mesActual <= $mesPost) {
            if ($mesActualPost == $mes) {
                //VERIFICO SI ESE MES ACTUAL MANTIENE LAS PLANIFICACIONES EN ESTATUS C
                $planificacionC = Planificacion::model()->estatusPlanificacion($plantel_id);
                $estatus = count($planificacionC);
                //                    var_dump($planificacionC);
//                        if($estatus == 0){
                //SE REALIZA UNA VALIDACION PARA QUE NO SE REPITA LAS INGESTA POR DIA
                $planificacion = Planificacion::model()->findAll(array('condition' => 'menu_nutricional_id =' . $menu_nutricional_id . " AND fecha_inicio = '" . $start . "' AND plantel_id = $plantel_id"));
                if ($planificacion == null) {

                    $repetido = Planificacion::model()->findByAttributes(array('tipo_menu_id' => $tipoMenu[0]["id"], 'fecha_inicio' => $start, 'plantel_id' => $plantel_id));

                    if ($repetido) {
                        $json['respuesta'] = 'tope';
                    } else {

                        if ($diaFeriado[0]['dias_feriados'] == null) {
                            //                        var_dump($modelPlanificacion);die();
                            //                        $modelPlanificacion = Planificacion::model()->agregarEvento($menu_nutricional_id, $tipoMenu[0]["id"],$plantel_id, $start, $end, $allDay, $className);
                            if ($modelPlanificacion->validate()) {
                                //                            var_dump($modelPlanificacion);die();
                                $modelPlanificacion->save();
                                $this->registerLog('ESCRITURA', 'planificacion.agregarEvento', 'EXITOSO', 'Agrego un evento: ' . $start);
                                $id = $modelPlanificacion->primaryKey;
                                //                            var_dump($id);die();
                                //                        if($modelPlanificacion == null){
                                $json['respuesta'] = 'exito';
                                $json['id'] = $id;
                                $json['title'] = $menuNutricional[0]['nombre'];
                                $json['nombreLabel'] = $tipoMenu[0]['nombre_label'];
                            }
                        } else {
                            $json['respuesta'] = 'diaFeriado';
                            $json['descripcion'] = $diaFeriado[0]['dias_feriados'];
                        }
                    }
                } else {
                    $json['respuesta'] = 'repetido';
                }
//                        }
//                        else{
//                            $json['respuesta'] = 'cerrado';
//                        }
            } else {
                $json['respuesta'] = 'mesError';
            }
        } elseif ($mesActual > $mesPost) {
            $json['respuesta'] = 'mesDiferenteMenor';
        }
//                    elseif($mesActual < $mesPost){
//                        $json['respuesta'] = 'mesDiferenteMayor';
//                    }
//            }
//            else {
//                $json['respuesta'] = 'plantel';
//            }
        echo json_encode($json);
    }

    public function actionActualizarPlanificacion() {
        echo Yii::app()->getSession()->get('plantelIngesta');
    }
    
    public function actionPlanificarPeriodo(){
        $modelPlanificacion = new Planificacion;
        $resultado = $modelPlanificacion->model()->planificarPeriodo();
        echo $resultado;
    }
    
    public function validaPlanifiarPeriodo(){
        $configuracion = Configuracion::model()->findAll(array('condition' => "nombre = 'FECHA_INI_PAE' OR nombre = 'FECHA_FIN_PAE'"));
//        var_dump($configuracion);die();
        $fecha_ini = $configuracion[0]['valor_date'];
        $fecha_fin = $configuracion[1]['valor_date'];
        $planificacion = Planificacion::model()->hayPlanificacion($fecha_ini, $fecha_fin);
        return count($planificacion);
    }

    public function actionDetallesPlanificacion() {
        $planificacion_id = $_POST['planificacion_id'];
        $planificacion = Planificacion::model()->findAll(array('condition' => 'id = ' . $planificacion_id));
        $menuNutricional = MenuNutricional::model()->findAll(array('condition' => 'id = ' . $planificacion[0]['menu_nutricional_id'] . " AND estatus = 'A'"));
        $tipoMenu = TipoMenu::model()->findAll(array('condition' => 'id = ' . $planificacion[0]['tipo_menu_id'] . " AND estatus = 'A'"));
//            var_dump($menuNutricional);die();
        $json['id'] = $menuNutricional[0]['id'];
        $json['nombre'] = $menuNutricional[0]['nombre'];
        $json['tipoMenu'] = $tipoMenu[0]['nombre'];
        if($menuNutricional[0]['preparacion'] == null){
            $preparacion = '<br>No tiene datos de preparación.<br><br>';
        }
        else{
            $preparacion = $menuNutricional[0]['preparacion'];
        }
        $json['preparacion'] = $preparacion;
//            $json['tipo_menu'] = $menuNutricional[0]->tipoMenu->nombre;
        $json['calorias'] = $menuNutricional[0]['calorias'];
        $json['estatus'] = $planificacion[0]['estatus'];
        echo json_encode($json);
    }

    public function actionEliminarPlanificacion() {
        $id = $_POST['id'];
        $result = Planificacion::model()->eliminarPlanificacion($id);
        $this->registerLog('ESCRITURA', 'planificacion.eliminarPlanificacion', 'EXITOSO', 'Elimino un evento.');
    }

    public function actionGuardarCambios() {
        $plantel_id = $_REQUEST['id'];
        $guardar = Planificacion::model()->guardarCambios($plantel_id);
        $this->registerLog('ESCRITURA', 'planificacion.guardarCambios', 'EXITOSO', 'Guardo los cambios.');
//            var_dump($guardar);
    }

    public function actionLimpiarEventos() {
        $plantel_id = $_REQUEST['plantel_id'];
        $mes = $_REQUEST['mes'];
        $ano = $_REQUEST['ano'];
        $guardar = Planificacion::model()->limpiarEventos($plantel_id, $mes, $ano);
        $this->registerLog('ESCRITURA', 'planificacion.limpiarEventos', 'EXITOSO', 'Se limpio todos los eventos del mes: ' . $mes . ', año: ' . $ano);
//            var_dump($guardar);
    }

    public function actionAsignarPlanificacion() {
        $plantel_id = $_REQUEST['plantel_id'];
        $mes = $_REQUEST['mes'];
        $ano = $_REQUEST['ano'];
        $guardar = Planificacion::model()->asignarPlanificacion($plantel_id, $mes, $ano);
        $this->registerLog('ESCRITURA', 'planificacion.asignarPlanificacion', 'EXITOSO', 'Se asigno la planificacion todos los eventos del mes pasado, teniendo en cuenta que le mes donde se le asigno es: ' . $mes . ', año: ' . $ano);
//            var_dump($guardar);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Planificacion the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Planificacion::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Planificacion $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'planificacion-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
