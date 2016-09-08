<?php
/**
 * Clase Controladora de Ubicación Geográfica de los Planteles.
 * @author Nelson Javier Gonzalez Gonzalez
 * @createAt 2015-03-24
 * @updateAt 2015-03-24
 */
class UbicacionGeograficaController extends Controller {

    private static $urlCargaFotoGeoReferencia = '/public/uploads/plantel/georeferencia/';
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'geoReferencia';

    /**
     * @return array action filters
     */
    public static $_permissionControl = array(
        'read' => 'Consulta de Modulos de Referenciación de Plantel',
        'write' => 'Asignación de Georeferenciación a Plantel',
        'admin' => 'Administración Completa de GeoReferenciación de Planteles',
        'label' => 'Módulo de Georeferenciación de Planteles'
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
                'actions' => array('planteles','uploadFile','cargaGeoRef',),
                'pbac' => array('write', 'admin',),
            ),
            array('allow',
                'actions' => array('planteles'),
                'pbac' => array('read',),
            ),
            // este array siempre va asì para delimitar el acceso a todos los usuarios que no tienen permisologia de read o write sobre el modulo
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Esta acción mostrará al usuario los datos generales de un plantel junto al formulario para efectuar el registro de georeferenciación de la sede principal de esta institución
     * 
     * @param mixed $id Id del Plantel
     */
    public function actionPlanteles($id) {

        $idDecoded = $this->getIdDecoded($id);
        $plantel = PlantelPae::model()->getDataPlantelSinPae($idDecoded);
        if($plantel){
            $urlCargaArchivo = '/registroUnico/ubicacionGeografica/uploadFile/id/'.$id;
            $urlCargaGeoreferencia = '/registroUnico/ubicacionGeografica/cargaGeoRef/id/'.$id;
            
            $this->render('georeferencia', array(
                'plantel' => $plantel,
                'urlCargaArchivo'=>$urlCargaArchivo,
                'urlCargaGeoreferencia'=>$urlCargaGeoreferencia,
            ));
        }else{
            throw new CHttpException(404, 'El Plantel indicado no se encuentra registrado en nuestra base de datos.');
        }
    }
    
    /**
     * Esta acción permite efectuar la carga (en fileSystem) del archivo que contiene los datos georeferenciales.
     * 
     * @param int $id Id del Plantel
     * @throws CHttpException Si la petición se hace por una vía distinta de ajax se lanza una excepción 403 (Permission Denied)
     */
    public function actionUploadFile($id){
        if(Yii::app()->request->isAjaxRequest){
            $userId = Yii::app()->user->id;
            $filename= date('YmdHis').'-GEOREF-'.$userId;
            $upload_handler = new UploadHandler(null, true, null, $filename, self::$urlCargaFotoGeoReferencia);
        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta operación mediante esta vía');
        }
    }

    /**
     * 
     * 
     * @param int $id Id del Plantel
     * @throws CHttpException Si la petición se hace por una vía distinta de ajax se lanza una excepción 403 (Permission Denied)
     */
    public function actionCargaGeoRef($id){
        $respuesta=null;
        $idDecoded= $this->getIdDecoded($id);
        new Plantel;
        if(Yii::app()->request->isAjaxRequest ){
            $idDecoded = $this->getIdDecoded($id);
            $archivo = $this->getPost('archivo');

            $rutaImagen = str_replace('//', '/', Yii::app()->params['webDirectoryPath'].self::$urlCargaFotoGeoReferencia.$archivo);

            $result = Georeferencia::obtenerDetalleGeoreferencialDeArchivo($rutaImagen);

            //$respuesta=Plantel::model()->actualizarGeoreferencia($idDecoded,10.510533305556,-66.914878833333);
            if($result['resultado']=='EXITOSO'){
                $respuesta=Plantel::model()->actualizarGeoreferencia($idDecoded, 10.510533305556, -66.914878833333);
                $result['debug'] = $respuesta;
            }

            $this->jsonResponse($result);
            //Actualizo la "longitud" y "latitud" del plantel en caso de encontrar datos de Georefereciacion en la Imagen


        }
        else{
            throw new CHttpException(403, 'No está permitido efectuar esta operación mediante esta vía');
        }
    }

}
