<?php
/**
 * Created by PhpStorm.
 * User: nelson
 * Date: 11/03/15
 * Time: 03:44 PM
 */
class ReporteRegistroUnicoController extends Controller {

    public $defaultAction = 'index';

    //despues de la declaración de la clase va el siguiente codigo
    public $layout = '//layouts/main';
    static $_permissionControl = array(
        'read' => 'Consulta de Estadisticas de Registro Único CNAE',
        'write' => 'Consulta de Estadísticas y Reporte de Registro Único CNAE',
        'admin' => 'Consulta de Estadisticas de Registro Único CNAE',
        'label' => 'Consulta de Reporte de Registro Único CNAE'
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
                'actions' => array('index', 'reporteEstadisticoRegistroUnico', 'reporteDetalladoRegistroUnico'),
                'pbac' => array('read', 'write', 'admin'),
            ),
            array('allow',
                'actions' => array('index', 'reporteEstadisticoRegistroUnico', 'reporteDetalladoRegistroUnico'),
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

    public function actionReporteEstadisticoRegistroUnico() {

        if (Yii::app()->request->isAjaxRequest) {

            if ($this->getPost('nivel') && $this->getPost('dependency')) {
                
                $nivel = $this->getPost('nivel');
                $dependency = $this->getPost('dependency');

                $region = null;
                $estado = null;
                $municipio = null;

                if ($nivel == 'estado') {

                    $titulo = 'Estado';
                    $anteriorNivel = 'region';
                    $siguienteNivel = 'municipio';
                    $region = new stdClass();
                    // $region->nombre = $result->nombre;
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

                $model = new ReporteRegistroUnico();
                $dataReport = $model->reporteEstadisticoRegistroUnico($nivel, $dependency);

                $this->renderPartial('reporteEstadisticoRegistroUnico', array('titulo' => $titulo, 'dataReport' => $dataReport, 'siguienteNivel' => $siguienteNivel, 'nivel' => $nivel, 'dependency' => $dependency, 'region' => $region, 'estado' => $estado, 'municipio' => $municipio, 'anteriorNivel' => $anteriorNivel), false, true);

            } else {
                throw new CHttpException(404, 'Recurso no encontrado. Recargue la página e intentelo de nuevo.');
            }
        } else {
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
    }

    public function actionReporteDetalladoRegistroUnico($col, $lev, $dep = 0, $rows=null) {

        if (!Yii::app()->request->isAjaxRequest) {

            if (in_array($lev, array('region', 'estado', 'municipio'))) {

                if (is_numeric($dep)) {

                    $headers = array();
                    $colDef = array();
                    $reporte = new ReporteRegistroUnico();

                    /**
                     * @var dataReport is a CActiveRecord array OR any CModel array
                     */
                    $dataReport = array();

                    if(in_array($col, array("planteles", "total_cnae", "beneficiados_x_mercal", "beneficiados_x_pdval", "beneficiados_x_otros"))){
                        list($headers, $colDef) = $this->getStructureForPlanteles();
                        $dataReport = $reporte->detalleRegistroUnicoPlanteles($col, $dep, $rows);
                    }
                    elseif(in_array($col, array("autoridades_verificados"))){
                        list($headers, $colDef) = $this->getStructureForAutoridadPlanteles();
                        $dataReport = $reporte->detalleRegistroUnicoAutoridades($col, $dep, $rows);
                    }
                    elseif(in_array($col, array("autoridades_verificados_sin_foto"))){
                        list($headers, $colDef) = $this->getStructureForAutoridadPlanteles();
                        $dataReport = $reporte->detalleRegistroUnicoAutoridades($col, $dep, $rows);
                    }
                    elseif(in_array($col, array("cocineras_escolares", "cocineras_escolares_asignadas"))){
                        list($headers, $colDef) = $this->getStructureForCocineras();
                        $dataReport = $reporte->detalleRegistroUnicoCocineras($col, $dep, $rows);
                    }

                    $fileName = 'detalle_'. $col . date('YmdHis') . '.csv';

                    CsvExport::export($dataReport, $colDef, $headers, true, $fileName);

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


    public function getStructureForPlanteles(){

        $headers = array(
            'Cod. DEA',
            'Cod. Estadístico',
            'Cod. CNAE',
            'Cod. NER',
            'Nombre del Plantel',
            'Año de Fundación',
            'Registro en CNAE',
            'Es Beneficiario PAE',
            'Denominación',
            'Dependencia',
            'Estado',
            'Municipio',
            'Parroquia',
            'Zona Educativa',
            'PAE Activo',
            'Proveedor Actual',
            'Tipo de Servicio',
            'Ingestas',
            'Cantidad de Cocineras',
            'Matricula Maternal',
            'Matricula Preescolar',
            'Matricula Educación Primaria',
            'Matricula Educación Media General',
            'Matricula Educación Técnica',
            'Matricula Educación Especial',
            'Matricula Docente / Obrero',
            'Matricula General',
            'Origen Director',
            'Cédula Director',
            'Apellido del Director',
            'Nombre del Director',
            'Teléfono del Director',
            'Email del Director',
            'Origen Sub-Director',
            'Cédula Sub-Director',
            'Apellido del Sub-Director',
            'Nombre del Sub-Director',
            'Teléfono del Sub-Director',
            'Email del Sub-Director',
            'Origen Enlace CNAE',
            'Cédula Enlace CNAE',
            'Apellido del Enlace CNAE',
            'Nombre del Enlace CNAE',
            'Teléfono del Enlace CNAE',
            'Email del Enlace CNAE',
        );
        $colDef = array(
            'cod_plantel' => array(),
            'cod_estadistico' => array(),
            'cod_cnae' => array(),
            'codigo_ner' => array(),
            'nombre_plantel' => array(),
            'annio_fundado' => array(),
            'registro_cnae' => array(),
            'es_beneficiario_pae'=>array(),
            'denominacion' => array(),
            'dependencia' => array(),
            'estado' => array(),
            'municipio' => array(),
            'parroquia'=> array(),
            'zona_educativa' => array(),
            'pae_activo' => array(),
            'proveedor'=>array(),
            'tipo_servicio_pae' => array(),
            'ingestas' => array(),
            'cantidad_madres_procesadoras' => array(),
            'matricula_maternal' => array(),
            'matricula_preescolar' => array(),
            'matricula_educacion_primaria' => array(),
            'matricula_educacion_media_general' => array(),
            'matricula_educacion_tecnica' => array(),
            'matricula_educacion_especial' => array(),
            'matricula_docente_obrero' => array(),
            'matricula_general' => array(),
            'origen_director' => array(),
            'cedula_director' => array(),
            'apellido_director' => array(),
            'nombre_director' => array(),
            'telefono_director' => array(),
            'email_director' => array(),
            'origen_sub_director' => array(),
            'cedula_sub_director' => array(),
            'apellido_sub_director' => array(),
            'nombre_sub_director' => array(),
            'telefono_sub_director' => array(),
            'email_sub_director' => array(),
            'origen_enlace_pae' => array(),
            'cedula_enlace_pae' => array(),
            'apellido_enlace_pae' => array(),
            'nombre_enlace_pae' => array(),
            'telefono_enlace_pae' => array(),
            'email_enlace_pae' => array(),
        );

        return array($headers,$colDef);

    }

    public function getStructureForAutoridadPlanteles(){

        $headers = array(
            'Cod. DEA',
            'Cod. Estadístico',
            'Cod. CNAE',
            'Cod. NER',
            'Nombre del Plantel',
            'Año de Fundación',
            'Registro en CNAE',
            'Denominación',
            'Dependencia',
            'Estado',
            'Municipio',
            'Parroquia',
            'Zona Educativa',
            'PAE Activo',
            'Tipo de Servicio',
            'Ingestas',
            'Cantidad de Cocineras',
            'Matricula Maternal',
            'Matricula Preescolar',
            'Matricula Educación Primaria',
            'Matricula Educación Media General',
            'Matricula Educación Técnica',
            'Responsabilidad',
            'Origen Autoridad',
            'Cédula Autoridad',
            'Apellido del Autoridad',
            'Nombre del Autoridad',
            'Teléfono del Autoridad',
            'Email del Autoridad',
        );
        $colDef = array(
            'cod_plantel' => array(),
            'cod_estadistico' => array(),
            'cod_cnae' => array(),
            'codigo_ner' => array(),
            'nombre_plantel' => array(),
            'annio_fundado' => array(),
            'registro_cnae' => array(),
            'denominacion' => array(),
            'dependencia' => array(),
            'estado' => array(),
            'municipio' => array(),
            'parroquia'=> array(),
            'zona_educativa' => array(),
            'pae_activo' => array(),
            'tipo_servicio_pae' => array(),
            'ingestas' => array(),
            'cantidad_madres_procesadoras' => array(),
            'matricula_maternal' => array(),
            'matricula_preescolar' => array(),
            'matricula_educacion_primaria' => array(),
            'matricula_educacion_media_general' => array(),
            'matricula_educacion_tecnica' => array(),
            'responsabilidad_autoridad' => array(),
            'origen_autoridad' => array(),
            'cedula_autoridad' => array(),
            'apellido_autoridad' => array(),
            'nombre_autoridad' => array(),
            'telefono_autoridad' => array(),
            'email_autoridad' => array(),
        );

        return array($headers,$colDef);

    }

    public function getStructureForCocineras(){
        $headers = array(
            'Estado - Cocinera Escolar',
            'Origen - Cocinera Escolar',
            'Cédula de Identidad - Cocinera Escolar',
            'Nombre - Cocinera Escolar',
            'Apellido - Cocinera Escolar',
            'Fecha de Nacimiento - Cocinera Escolar',
            'Género',
            'Teléfono Celular',
            'Teléfono Fijo',
            'Email - Cocinera Escolar',
            'Cod. DEA',
            'Cod. Estadístico',
            'Cod. CNAE',
            'Nombre del Plantel',
            'Registro en CNAE',
            'Denominación',
            'Dependencia',
            'Estado',
            'Municipio',
            'Parroquia',
            'Origen Autoridad',
            'Cédula Autoridad',
            'Apellido del Autoridad',
            'Nombre del Autoridad',
            'Teléfono del Autoridad',
            'Email del Autoridad'
        );
        $colDef = array(
            'estado_cocinera_escolar'=>array(),
            'origen'=>array(),
            'cedula'=>array(),
            'nombre'=>array(),
            'apellido'=>array(),
            'fecha_nacimiento'=>array(),
            'sexo'=>array(),
            'telefono_celular'=>array(),
            'telefono_fijo'=>array(),
            'email_personal'=>array(),
            'cod_plantel'=>array(),
            'cod_estadistico'=>array(),
            'cod_cnae'=>array(),
            'nombre_plantel'=>array(),
            'registro_cnae'=>array(),
            'denominacion'=>array(),
            'dependencia'=>array(),
            'estado'=>array(),
            'municipio'=>array(),
            'parroquia'=>array(),
            'origen_director'=>array(),
            'cedula_director'=>array(),
            'apellido_director'=>array(),
            'nombre_director'=>array(),
            'telefono_director'=>array(),
            'email_director'=>array()
        );

        return array($headers,$colDef);
    }

}
