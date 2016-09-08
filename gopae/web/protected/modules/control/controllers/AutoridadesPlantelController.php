<?php

/**
 * @author José Gabriel González
 */
class AutoridadesPlantelController extends Controller {

    public $defaultAction = 'index';

    //despues de la declaración de la clase va el siguiente codigo
    public $layout = '//layouts/main';
    static $_permissionControl = array(
        'read' => 'Consulta de Estadisticas de Carga de Autoridades',
        'write' => 'Consulta de Estaísticas y Reporte de Carga de Autoridades',
        'admin' => 'Consulta de Estadisticas de Carga de Autoridades a través de diferentes Estados y Regiones',
        'label' => 'Consulta de Reporte de Carga de Autoridades'
    );

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

        // en este array colocar solo los action de consulta
        return array(
            array('allow',
                'actions' => array('index', 'estadisticoDirectores', 'graficoDirectores', 'graficoEstadalDirectores', 'reporteDetalladoDirectores'),
                'pbac' => array('read', 'write', 'admin'),
            ),
            array('allow',
                'actions' => array('index', 'estadisticoDirectores', 'graficoDirectores', 'graficoEstadalDirectores', 'reporteDetalladoDirectores'),
                'pbac' => array('read',),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionEstadisticoDirectores() {

        if (Yii::app()->request->isAjaxRequest) {

            if ($this->getPost('nivel') && $this->getPost('dependency')) {

                if (Yii::app()->user->pbac('admin')) {
                    $nivel = $this->getPost('nivel');
                    $dependency = $this->getPost('dependency');
                } else {
                    $nivel = 'municipio';
                    $dependency = Yii::app()->user->estado;
                }

                $region = null;
                $estado = null;
                $municipio = null;

                if ($nivel == 'region') {
                    $titulo = 'Región';
                    $anteriorNivel = 'region';
                    $siguienteNivel = 'estado';
                } elseif ($nivel == 'estado') {
                    $region = new Region('search');
                    $result = $region->findByPk($dependency);
                    $titulo = 'Estado';
                    $anteriorNivel = 'region';
                    $siguienteNivel = 'municipio';
                    $region = new stdClass();
                    $region->nombre = $result->nombre;
                    $region->id = $dependency;
                } elseif ($nivel == 'municipio') {
                    $estado = new Estado('search');
                    $result = $estado->findByPk($dependency)->with('region');
                    $titulo = 'Municipio';
                    $anteriorNivel = 'estado';
                    $siguienteNivel = 'parroquia';
                    $estado = new stdClass();
                    $estado->nombre = $result->nombre;
                    $estado->id = $dependency;
                    $region = new stdClass();
                    $region->nombre = $result->region->nombre;
                    $region->id = $result->region_id;
                }

                if (empty($dependency) || !is_numeric($dependency)) {
                    $dependency = null;
                }

                $model = new DirectoresPlantel();
                $dataReport = $model->reporteEstadistico($nivel, $dependency);

                $this->renderPartial('estadisticoDirectores', array('titulo' => $titulo, 'dataReport' => $dataReport, 'siguienteNivel' => $siguienteNivel, 'nivel' => $nivel, 'dependency' => $dependency, 'region' => $region, 'estado' => $estado, 'municipio' => $municipio, 'anteriorNivel' => $anteriorNivel), false, true);
            } else {
                throw new CHttpException(404, 'Recurso no encontrado. Recargue la página e intentelo de nuevo.');
            }
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

    public function actionGraficoEstadalDirectores() {

        if (Yii::app()->request->isAjaxRequest) {

            $estadoId = null;

            if(Yii::app()->user->pbac('control.autoridadesPlantel.admin')){
                $estadoId = null;
            }else{
                $estadoId = Yii::app()->user->estado;
            }

            $model = new DirectoresPlantel();
            $dataReport = $this->formatDataGraficoEstadalDirectores($model->reporteGrafico($estadoId));

            $this->renderPartial('graficoEstadalDirectores', array('dataReport' => $dataReport), false, true);
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

    public function actionReporteDetalladoDirectores($col, $lev, $dep = 0) {

        if (!Yii::app()->request->isAjaxRequest) {

            if (in_array($lev, array('region', 'estado', 'municipio'))) {

                if (is_numeric($dep)) {

                    $headers = array(
                        'Cod Plantel',
                        'Cod Estadistico',
                        'Denominación',
                        'Nombre',
                        'Zona Educativa',
                        'Dependencia',
                        'Estatus',
                        'Año de Fundación',
                        'Estado',
                        'Municipio',
                        'Parroquia',
                        'Dirección',
                        'Correo',
                        'Teléfono Fijo',
                        'Teléfono Otro',
                        'Zona Ubicación',
                        'Clase de Plantel',
                        'Categoria',
                        'Condición Estudio',
                        'Tipo Matrícula',
                        'Turno',
                        'Modalidad',
                        'Director Cédula',
                        'Director Nombre',
                        'Director Apellido',
                        'Director Usuario',
                        'Director Teléfono',
                        'Director Celular',
                        'Director Email',
                        'Director Twitter');

                    $colDef = array(
                        'cod_plantel' => array(),
                        'cod_estadistico' => array(),
                        'denominacion' => array(),
                        'nombre' => array(),
                        'zona_educativa' => array(),
                        'tipo_dependencia' => array(),
                        'estatus' => array(),
                        'fundacion' => array(),
                        'estado' => array(),
                        'municipio' => array(),
                        'parroquia' => array(),
                        'direccion' => array(),
                        'correo' => array(),
                        'telefono_fijo' => array(),
                        'telefono_otro' => array(),
                        'zona_ubicacion' => array(),
                        'clase_plantel' => array(),
                        'categoria' => array(),
                        'condicion_estudio' => array(),
                        'tipo_matricula' => array(),
                        'turno' => array(),
                        'modalidad' => array(),
                        'dir_cedula' => array(),
                        'dir_nombre' => array(),
                        'dir_apellido' => array(),
                        'dir_usuario' => array(),
                        'dir_telefono' => array(),
                        'dir_celular' => array(),
                        'dir_email' => array(),
                        'dir_twitter' => array());

                    $planteles = new ControlPlantel();

                    $dataReport = $planteles->reporteDetalladoPlantel($col, $lev, $dep);

//                    if (Yii::app()->user->pbac('admin')) { // Si tienes permisos de administrador puedes descargar el CSV/EXCEL
                    $fileName = 'planteles-' . date('YmdHis') . '.csv';

                    CsvExport::export(
                            $dataReport, // a CActiveRecord array OR any CModel array
                            $colDef, $headers, true, $fileName);

                    //                    } else { // Si no eres administrador puedes es descargar el PDF
//
//                        $mPDF = Yii::app()->ePdf->mpdf('','A4-L', 0, '', 5, 5, 5, 5, 5, 5, 'L');
//                        $mPDF->useSubstitutions=false;
//                        $mPDF->simpleTables = true;
//                        $mPDF->WriteHTML($this->renderPartial('application.modules.planteles.views.consultar._pdfHeader', array(), true));
//                        $mPDF->WriteHTML($this->renderPartial('application.modules.planteles.views.consultar._reporteListaPlanteles', array('model' => $dataReport, 'headers'=>$headers), true));
//                        $mPDF->Output( 'planteles-' . date('YmdHis') . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
//
//                    }
                } else {
                    throw new CHttpException(404, 'Recurso no encontrado. Recargue la página e intentelo de nuevo.');
                }
            } else {
                throw new CHttpException(404, 'Recurso no encontrado. Recargue la página e intentelo de nuevo.');
            }
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

    private function formatDataGraficoEstadalDirectores($dataResult) {

        $dataReport = array('totales' => '', 'faltantes' => '', 'registrados' => '', 'avances' => '');

        foreach ($dataResult as $data) {

            $totales[] = (int) $data['planteles'];
            $faltante[] = (int) $data['sin_director'];
            $registrados[] = (int) $data['con_director'];

            if ((int) $data['planteles'] > 0):
                $avances[] = number_format(($data['con_director'] * 100) / $data['planteles'], 2, '.', '');
            else:
                $avances[] = 0;
            endif;
        }

        $dataReport['totales'] = implode(', ', $totales);
        $dataReport['faltantes'] = implode(', ', $faltante);
        $dataReport['registrados'] = implode(', ', $registrados);
        $dataReport['avances'] = implode(', ', $avances);

        return $dataReport;
    }

    // Uncomment the following methods and override them if needed
    /*
      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
