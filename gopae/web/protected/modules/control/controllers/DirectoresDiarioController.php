<?php

class DirectoresDiarioController extends Controller {

    //despues de la declaración de la clase va el siguiente codigo
    public $layout = '//layouts/main';
    static $_permissionControl = array(
        'read' => 'Consulta de Estadisticas Diaria de Carga de Autoridades',
        'write' => 'Consulta de Estaísticas y Reporte de Carga Diaria de Autoridades',
        'label' => 'Consulta de Reporte Diario de Carga de Autoridades'
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
                'actions' => array('index', 'EstadisticoDirectoresDiario','ReporteDetalladoDirectoresDiario'),
                'pbac' => array( 'write','admin'),
            ),
            array('allow',
                'actions' => array('index', 'EstadisticoDirectoresDiario','ReporteDetalladoDirectoresDiario'),
                'pbac' => array('read'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    
    // Esta variable me permitira usar la función reporteDetalladoPlantel de forma mas dinamica con fecha 
    public $fechaReporteDetallado;
    
    
    public function actionIndex() {
        $this->render('index');
    }
    
    
    public function actionEstadisticoDirectoresDiario(){
        
        if(Yii::app()->request->isAjaxRequest){
            
            if(($this->getPost('nivel') && $this->getPost('dependency')) || $this->getPost('fecha')){
               // Determina si es de estado o de  region 
                $nivel = $this->getPost('nivel');
                $dependency = $this->getPost('dependency');
                $fecha=$this->getPost('fecha');
                $fechaCambiada=date("Y-m-d", strtotime($fecha)); 
                
                $this->fechaReporteDetallado =$fechaCambiada;
                $dependencyName = '';
                
                if($nivel=='region'){
                    $titulo = 'Región';
                    $siguienteNivel = 'estado';
                    $this->fechaReporteDetallado =$fechaCambiada;
                    //var_dump($this->fechaReporteDetallado);
                }elseif($nivel=='estado'){
                    $region = new Region();
                    $result = $region->findByPk($dependency);
                    $dependencyName = $result->nombre;
                    $this->fechaReporteDetallado =$fechaCambiada;
                    //var_dump($fechaCambiada);
                    
                    $titulo = 'Estado';
                    $siguienteNivel = '';
                }
                
                if(empty($dependency) || !is_numeric($dependency)){
                    $dependency = null;
                }

                $model = new DirectoresDiario();
                $dataReport = $model->reporteEstadistico($nivel, $dependency,$fechaCambiada);
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                $this->renderPartial('estadisticoDirectoresDiario', array('titulo'=>$titulo, 'dataReport' => $dataReport, 'siguienteNivel'=>$siguienteNivel, 'nivel'=>$nivel, 'dependency'=>$dependency, 'dependencyName'=>$dependencyName,'fechaCambiada'=>$fechaCambiada), false, true);
                
            }
            else{
                throw new CHttpException(404, 'Recurso no encontrado. Recargue la página e intentelo de nuevo.');
            }
            
        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
        
    }
    
    public function actionReporteDetalladoDirectoresDiario($col, $lev, $dep=0,$fecha=null) {
        
        if(!Yii::app()->request->isAjaxRequest){
            
            if(in_array($lev, array('region','estado', 'municipio'))){

                if(is_numeric($dep)){
                    
                    $headers = array('Cod Plantel', 'Cod Estadistico', 'Nombre', 'Zona Educativa', 'Dependencia', 'Estatus', 'Año de Fundacion', 'Estado', 'Municipio', 'Parroquia', 'Direccion', 'Correo', 'Telefono Fijo', 'Telefono Otro', 'Zona Ubicacion', 'Clase de Plantel', 'Categoria', 'Condicion Estudio', 'Tipo Matricula', 'Turno', 'Modalidad', 'Director Cédula', 'Director Nombre', 'Director Apellido', 'Director Usuario', 'Director Telefono', 'Director Celular', 'Director Email', 'Director Twitter',);
                    
                    $colDef = array('cod_plantel'=>array(), 'cod_estadistico'=>array(), 'denominacion_id'=>array(), 'nombre'=>array(), 'zona_educativa'=>array(), 'tipo_dependencia'=>array(), 'estatus'=>array(), 'fundacion'=>array(), 'estado'=>array(), 'municipio'=>array(), 'parroquia'=>array(), 'direccion'=>array(), 'correo'=>array(), 'telefono_fijo'=>array(), 'telefono_otro'=>array(), 'zona_ubicacion'=>array(), 'clase_plantel'=>array(), 'categoria'=>array(), 'condicion_estudio'=>array(), 'tipo_matricula'=>array(), 'turno'=>array(), 'modalidad'=>array(), 'dir_cedula'=>array(), 'dir_nombre'=>array(), 'dir_apellido'=>array(), 'dir_usuario'=>array(), 'dir_telefono'=>array(), 'dir_celular'=>array(), 'dir_email'=>array(), 'dir_twitter'=>array());
                    
                    $planteles = new ControlPlantel();
                    if (is_null($fecha)) {
                        $fecha = date('Y-m-d');
                    } else {
                        if (Utiles::dateCheck($fecha, 'ymd')) {
                            $fecha = date('Y-m-d');
                        } else {
                            throw new CHttpException(404, 'Recurso no encontrado. Recargue la página e intentelo de nuevo.');
                        }
                    }
                    $dataReport = $planteles->reporteDetalladoPlantel($col, $lev, $dep,$fecha);
                    
                    if (Yii::app()->user->pbac('admin')) { // Si tienes permisos de administrador puedes descargar el CSV/EXCEL
                        $fileName = 'planteles-' . date('YmdHis') . '.csv';

                        CsvExport::export(
                                $dataReport, // a CActiveRecord array OR any CModel array
                                $colDef,
                                $headers,
                                true,
                                $fileName);

                    } else { // Si no eres administrador puedes es descargar el PDF
                        
                        $mPDF = Yii::app()->ePdf->mpdf('','A4-L', 0, '', 5, 5, 5, 5, 5, 5, 'L');
                        $mPDF->useSubstitutions=false;
                        $mPDF->simpleTables = true;
                        $mPDF->WriteHTML($this->renderPartial('application.modules.planteles.views.consultar._pdfHeader', array(), true));
                        $mPDF->WriteHTML($this->renderPartial('application.modules.planteles.views.consultar._reporteListaPlanteles', array('model' => $dataReport, 'headers'=>$headers), true));
                        $mPDF->Output( 'planteles-' . date('YmdHis') . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
                          
//                      $this->renderPartial('application.modules.planteles.views.consultar._pdfHeader', array(), false, true);
//                      $this->renderPartial('application.modules.planteles.views.consultar._reporteListaPlanteles', array('model' => $dataReport, 'headers'=>$headers), false, true);
                        
                    }
                }
                else{
                    throw new CHttpException(404, 'Recurso no encontrado. Recargue la página e intentelo de nuevo.');
                }

            }
            else{
                throw new CHttpException(404, 'Recurso no encontrado. Recargue la página e intentelo de nuevo.');
            }
        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
        }
        
    }
}
