<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MadresColaboradorasLegacyController
 *
 * @author José Gabriel González
 */
class MadresColaboradorasLegacyController extends Controller {

    public $defaultAction = 'index';

    //despues de la declaración de la clase va el siguiente codigo
    public $layout = '//layouts/main';
    static $_permissionControl = array(
        'read' => 'Consulta de Estadisticas de los Legados de Madres Colaboradoras en el Período 2013/2014',
        'write' => 'Consulta de Estadisticas de los Legados de Madres Colaboradoras en el Período 2013/2014',
        'admin' => 'Consulta de Estadisticas de los Legados de Madres Colaboradoras en el Período 2013/2014 a través de diferentes Estados y Regiones',
        'label' => 'Consulta de Estadisticas de los Legados de Madres Colaboradoras en el Período 2013/2014'
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
                'actions' => array('index', 'estadisticoMadresColaboradoras', 'graficoEstadal', 'reporteDetalladoNominaLegacy'),
                'pbac' => array('read', 'write', 'admin'),
            ),
            array('allow',
                'actions' => array('index', 'estadisticoMadresColaboradoras', 'graficoEstadal', 'reporteDetalladoNominaLegacy'),
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

    public function actionEstadisticoMadresColaboradoras() {

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
                }
                elseif ($nivel == 'estado') {
                    $region = new Region('search');
                    $result = $region->findByPk($dependency);
                    $titulo = 'Estado';
                    $anteriorNivel = 'region';
                    $siguienteNivel = 'municipio';
                    $region = new stdClass();
                    $region->nombre = $result->nombre;
                    $region->id = $dependency;
                }
                elseif ($nivel == 'municipio') {
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
                elseif ($nivel == 'estadoTotal') {
                    $titulo = 'Estado';
                    $anteriorNivel = 'region';
                    $siguienteNivel = 'municipio';
                    $region = new stdClass();
                    $region->nombre = 'Todas';
                    $region->id = '0';
                }

                if (empty($dependency) || !is_numeric($dependency)) {
                    $dependency = null;
                }

                $model = new NominaProcesadoras();
                $dataReport = $model->reporteEstadistico($nivel, $dependency);

                $this->renderPartial('estadisticoMadresColaboradoras', array('titulo' => $titulo, 'dataReport' => $dataReport, 'siguienteNivel' => $siguienteNivel, 'nivel' => $nivel, 'dependency' => $dependency, 'region' => $region, 'estado' => $estado, 'municipio' => $municipio, 'anteriorNivel' => $anteriorNivel), false, true);
            } else {
                throw new CHttpException(404, 'Recurso no encontrado. Recargue la página e intentelo de nuevo.');
            }
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

    public function actionGraficoEstadal() {

        if (Yii::app()->request->isAjaxRequest) {

            $estadoId = null;

            $dataReport = $this->formatDataGraficoEstadal(NominaProcesadoras::model()->reporteGrafico($estadoId));

            ld($dataReport);

            $this->renderPartial('graficoEstadalColaboradorasLegacy', array('dataReport' => $dataReport), false, true);
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

    public function actionReporteDetalladoNominaLegacy($col, $lev, $dep = 0) {

        if (!Yii::app()->request->isAjaxRequest) {

            if (in_array($lev, array('region', 'estado', 'estadoTotal', 'municipio'))) {

                if (is_numeric($dep)) {

                    $headers = array(
                        'Cédula',
                        'Origen',
                        'Cédula de Identidad SAIME',
                        'Nombres',
                        'Apellidos',
                        'Estado',
                        'Mes',
                        'Fecha de Nacimiento',
                        'Edad',
                        'País Origen',
                        'Consecutivo',
                        );

                    $colDef = array(
                        'cedula_text' => array(),
                        'origen' => array(),
                        'cedula' => array(),
                        'nombres' => array(),
                        'apellidos' => array(),
                        'estado' => array(),
                        'mes' => array(),
                        'fecha_nacimiento' => array(),
                        'edad' => array(),
                        'pais_origen' => array(),
                        'consecutivo' => array(),
                        );

                    $dataReport = NominaProcesadoras::model()->reporteDetallado($col, $lev, $dep);

//                    if (Yii::app()->user->pbac('admin')) { // Si tienes permisos de administrador puedes descargar el CSV/EXCEL
                    $fileName = 'NominaColaboradorasLegacy-' . date('YmdHis') . '.csv';

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

    private function formatDataGraficoEstadal($dataResult) {

        $dataReport = array('totales' => '', 'noviembre' => '', 'enero' => '', 'mayo' => '', 'junio' => '');

        foreach ($dataResult as $data) {
            $totales[] = (int) $data['madres'];
            $noviembre[] = (int) $data['noviembre'];
            $enero[] = (int) $data['enero'];
            $mayo[] = (int) $data['mayo'];
            $junio[] = (int) $data['junio'];
        }

        $dataReport['totales'] = implode(', ', $totales);
        $dataReport['noviembre'] = implode(', ', $noviembre);
        $dataReport['enero'] = implode(', ', $enero);
        $dataReport['mayo'] = implode(', ', $mayo);
        $dataReport['junio'] = implode(', ', $junio);

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
