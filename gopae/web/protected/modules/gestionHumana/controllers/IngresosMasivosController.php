<?php

/**
 * Clase Controladora de Peticiones del Módulo de Gestión Humana que permite dar ingreso a la corporación a un talento humano por carga masiva.
 *
 * @author José Gabriel González <jgonzalezp@me.gob.ve>
 * @createAt 2015-02-06
 * @updateAt 2015-02-06
 */
class IngresosMasivosController extends Controller {
    
    
    private static $urlCargaIngreso = '/gestionHumana/ingresosMasivos/uploadFile';
    private static $urlProcesamientoArchivo = '/gestionHumana/ingresosMasivos/procesamiento';
    private static $pathCargaIngresos = '/public/uploads/talentoHumano/ingresos';

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'index';

    /**
     * @return array action filters
     */
    public static $_permissionControl = array(
        'read' => 'Consulta de Ingresos de Talento Humano por lotes',
        'write' => 'Registro de Ingresos del Talento Humano por lotes',
        'admin' => 'Administración Completa de los Ingresos de Talento Humano por lotes',
        'label' => 'Módulo de Ingresos de Talento Humano por lotes'
    );

    /**
     * @return array action filters
     */
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
                'actions' => array(),
                'pbac' => array('write', 'admin'),
            ),
            array('allow',
                'actions' => array(),
                'pbac' => array('read'),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $this->csrfTokenName = 'csrfToken';
        $token = $this->getCsrfToken('Carga masiva de Orden Sise');
        $operacion = 'Ingresos';
        $urlCargaArchivo = self::$urlCargaIngreso;
        $urlProcesamientoArchivo = self::$urlProcesamientoArchivo;
        
        if (Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(403, 'No esta permitido efectuar esta operación mediante esta vía');
        } else {
            $this->render('index', array(
                'token' => $token, 
                'operacion' => $operacion, 
                'urlCargaArchivo'=>$urlCargaArchivo,
                'urlProcesamientoArchivo' => $urlProcesamientoArchivo,
            ));
        }
    }
    
    public function actionUploadFile(){

        if(Yii::app()->request->isAjaxRequest){
            $userId = Yii::app()->user->id;
            $upload_handler = new UploadHandler(null, true, null, date('YmdHis') . '-INGRESOS-'.$userId, "/public/uploads/talentoHumano/ingresos/");
        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta operación mediante esta vía');
        }

    }
    
    public function actionProcesamiento() {

        $result = new stdClass();
        $result->result = false;
        $result->info = "Operación incompleta.";
        $result->response = new stdClass();
        $result->response->data = array();

        if(Yii::app()->request->isAjaxRequest){

            $operacion = base64_decode($this->getPost("operacion"));
            $archivo = $this->getPost("archivo");

            $this->csrfTokenName = 'csrfToken';

            if($this->validateCsrfToken()){

                if(in_array($operacion, array('ingresos'))){

                    $targetFile = rtrim(realpath(Yii::app()->basePath."/..").self::$pathCargaIngresos,'/') . '/' . $archivo;

                    if(is_file($targetFile) && Utiles::isValidExtension($archivo, array('xlsx','xls', 'ods'))){

                        $readDataOnly = true;
                        $excelReader = new ExcelReader($targetFile);

                        list($result->result,
                             $result->class_style,
                             $result->message,
                             $objReaderExcel,
                             $objReader) = $excelReader->getReader($readDataOnly);

                        //Verifico que las extensiones del archivo sean las requeridas
                        if($result->result){

                            $sheetData = $objReader->getActiveSheet()->toArray(null,true,true,true);

                            $result->response->data = $sheetData;

                            //                            $ip_cliente = Helper::getRealIp();
                            //                            $usuario = Yii::app()->user->id;
                            //
                            //                            $result->response->data = array();
                            //
                            //                            list($result->result, $result->response->data) = $cargaOrdenSise->loadOrdenSise($sheetData, $operacion, $usuario, $ip_cliente);
                            //
                            //                            if($result->result){
                            //                                $result->class_style = "success";
                            //                                $result->message = "El proceso se ha completado. Puede ver el resultado detallado del mismo en la tabla siguiente.";
                            //                            }else{
                            //                                $result->class_style = "alert";
                            //                                $result->message = "El proceso ha culminado con algunas advertencias. Puede ver el resultado detallado del mismo en la tabla siguiente.";
                            //                            }

                        }

                        $this->jsonResponse($result);

                    }else{
                        throw new CHttpException(401, 'Debe indicar el archivo de donde se obtendrá la información para efectuar la operación. Recargue la página e intentelo de nuevo.'.$targetFile);
                    }

                }else{
                    throw new CHttpException(401, 'Operación desconocidad. Recargue la página e intentelo de nuevo.');
                }

            }else{
                throw new CHttpException(401, 'No se ha podido identificar la fuente de los datos. Recargue la página e intentelo de nuevo.');
            }

        }else{
            throw new CHttpException(403, 'No está permitido efectuar esta operación mediante esta vía');
        }

    }
    
}
