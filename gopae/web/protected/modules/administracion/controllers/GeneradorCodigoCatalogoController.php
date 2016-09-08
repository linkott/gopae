<?php

class GeneradorCodigoCatalogoController extends Controller {

    public $layout = '//layouts/column2';
    public $defaultAction = 'index';
    public $prefijoCatalogo = 'C';
    public $countData = 0;
    
    static $_permissionControl = array(
        'read' => 'Visualiza el Generador de Código',
        'write' => 'Genera Código de Tablas Catalogos',
        'admin' => 'Genera Código de Tablas Catalogos',
        'label' => 'Generador de Código'
    );

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'userGroupsAccessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'getTableColumns', 'getTableNames'),
                'pbac' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
//        $data = Estado::model()->findAll();
//        $plantilla = $this->renderPartial('template_no_dependientes', array('nombreClass' => 'Nuevo', 'data' => $data), true);
//        $ruta = Yii::app()->basePath;
//        $ruta.='/models/';
//        $ar = fopen($ruta."Nuevo.php", "w+") or
//                die("Problemas en la creacion");
//        fwrite($ar, $plantilla);
//        fclose($ar);
//die();
        $this->pageTitle = 'Generador de Código';
        $formulario = $this->getRequest('GeneradorForm');
        $formGenerador = new GeneradorForm();
        $fields = array();
        $orderBy = array();
        $fields_json = array();
        $fields_rawData = array();
        $columns_table = array();
        $data = array();
        $tableName = '';
        $existe_archivo = false;
        $no_existe_columna = false;
        if ($formulario != null) {
            $formGenerador->attributes = $formulario;
            $formGeneradorLimpio = new GeneradorForm();
            $formGeneradorLimpio->attributes = $formulario;
            if ($formGenerador->validate()) {
                
                /*
                 * VERIFICO SI HAY MAS DE UN CAMPO SELECCIONADO
                 * SI HAY MAS DE UNO HAGO UN EXPLODE
                 */
                if ((strrpos($formGenerador->fields, ',')) !== false) {
                    $fields = explode(',', $formGenerador->fields);
                } else {
                    if ($formGenerador->fields != '' AND ! is_null($formGenerador->fields)) {
                        $fields[] = $formGenerador->fields;
                    } else {
                        $formGenerador->addError('fields', "Campos a Seleccionar no debe estar vacio.");
                        $this->render('index', array('model' => $formGeneradorLimpio, 'errores' => $formGenerador));
                        Yii::app()->end();
                    }
                }
                                
                if ((strrpos($formGenerador->orderBy, ',')) !== false) {
                    $orderBy = explode(',', $formGenerador->orderBy);
                } else {
                    if ($formGenerador->orderBy != '' AND !is_null($formGenerador->orderBy)) {
                        $orderBy[] = $formGenerador->orderBy;
                    }
                }
                
                // CONVIERTO EL ARREGLO DE FIELDS EN UN JSON PARA QUE AL MOMENTO DE RENDERIZAR LA VISTA SI TENIA CAMPOS SELECCIONADOS NO LOS PIERDA
                foreach ($fields as $key => $value) {
                    $fields_rawData[] = array('id' => $value, 'text' => $value);
                }
                $fields_json = json_encode($fields_rawData);
                // OBTENGO LAS COLUMNAS DE LA TABLA PARA VALIDAR QUE REALMENTE LOS SUMINISTRADOS EXISTEN
                $columns_table = $formGenerador->getTableColumns($formGenerador->tableName);
                foreach ($columns_table as $valor => $descripcion) {
                    $data[] = array('id' => $descripcion, 'text' => $descripcion);
                }

                foreach ($fields as $key => $value) {
                    if (!in_array($value, $columns_table)) {
                        $no_existe_columna = true;
                        $formGenerador->addError('fields', "El campo <strong>'" . $value . "'</strong> no pertenece a la tabla '" . $formGenerador->tableName . "'");
                        $this->render('index', array('model' => $formGeneradorLimpio, 'errores' => $formGenerador, 'fields' => $fields_json, 'columnsTable' => json_encode($data)));
                        Yii::app()->end();
                    }
                }
                if (!$no_existe_columna) {
                    $ruta = $formGenerador->getBasePath() . "/{$this->prefijoCatalogo}" . $formGenerador->modelClass . '.php';
                    $existe_archivo = file_exists($ruta);
                    if ($existe_archivo) {
                        $result_elim_archivo = unlink($ruta);
                        //falta agregar mensaje de error cuando no se puede eliminar el archivo
                        $result_archivo_generado = $this->generarArchivo($formGenerador, $ruta);
                    } else {
                        $result_archivo_generado = $this->generarArchivo($formGenerador, $ruta);
                    }
                    if ($result_archivo_generado) {
                        $msg_exito = "Estimado usuario, se ha generado satisfactoriamente el archivo <strong> {$this->prefijoCatalogo}" . $formGenerador->modelClass . ".php </strong> en el directorio de Catálogos con {$this->countData} dato(s) generados. Recuerde configurar el owner y los permisos del archivo.";
                        $exito = true;
                    } else {
                        $formGenerador->addError('fields', "Estimado usuario, ha ocurrido un error durante la generación del archivo <strong> {$this->prefijoCatalogo}". $formGenerador->modelClass . ".php </strong>");
                        $this->render('index', array('model' => $formGeneradorLimpio, 'errores' => $formGenerador, 'fields' => $fields_json, 'columnsTable' => json_encode($data)));
                        Yii::app()->end();
                    }
                    $formGeneradorLimpio = new GeneradorForm();
                    $this->render('index', array('model' => $formGeneradorLimpio, 'exito' => $exito, 'msg_exito' => $msg_exito));
                }
                //$this->render('index', array('model' => $formGenerador));
            } else {
                $formGeneradorLimpio = new GeneradorForm();
                $formGeneradorLimpio->attributes = $formulario;
                $this->render('index', array('model' => $formGeneradorLimpio, 'errores' => $formGenerador));
            }
        } else {
            $formGenerador->fields = array();
            $this->render('index', array('model' => $formGenerador));
        }
    }

    /**
     * Provides autocomplete table names
     * @param string $db the database connection component id
     * @return string the json array of tablenames that contains the entered term $q
     */
    public function actionGetTableNames($db) {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $all = array();
            if (!empty($db) && Yii::app()->hasComponent($db) !== false && (Yii::app()->getComponent($db) instanceof CDbConnection))
                $all = array_keys(Yii::app()->{$db}->schema->getTables());

            echo json_encode($all);
        } else
            throw new CHttpException(404, 'The requested page does not exist.');
    }

    public function actionGetTableColumns() {
        $this->pageTitle = 'Generador de Código';
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $statusCode = 'ERROR';
            $sw = 0;
            $formulario = $this->getRequest('GeneradorForm');
            $formGenerador = new GeneradorForm();
            $existe_archivo = false;
            $cantDataArchivo = 0;
            $tableName = '';

            if ($formulario != null) {
                $formGenerador->attributes = $formulario;
                $mensaje = "Estimado usuario, no se encontraron las columnas de la tabla <strong>'" . $formGenerador->tableName . "'</strong> o dicha tabla no existe para la conexión <strong>'" . $formGenerador->connectionId . "'</strong>";
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $columns = $formGenerador->getTableColumns($formGenerador->tableName);
                    foreach ($columns as $valor => $descripcion) {
                        if ($sw == 0) {
                            $mensaje = '';
                            $statusCode = 'SUCCESS';
                            $sw = 1;
                            $pos = 0;
                            if (($pos = strrpos($formGenerador->tableName, '.')) !== false) {
                                $schema_table = explode('.', $formGenerador->tableName);
                                $tableName = (isset($schema_table[1])) ? $schema_table[1] : '';
                            } else {
                                $tableName = $formGenerador->tableName;
                            }
                            if ($tableName != '') {
                                $existe_archivo = file_exists($formGenerador->getBasePath() . '/'. $this->prefijoCatalogo . $formGenerador->modelClass . '.php');
                                if($existe_archivo){
                                    $claseCatalogo = $this->prefijoCatalogo.$formGenerador->modelClass;
                                    $objetoCatalogo = new $claseCatalogo();
                                    $cantDataArchivo = count($objetoCatalogo->getData());
                                }
                            }
                        }
                        $data[] = array('id' => $descripcion, 'text' => $descripcion);
                    }
                    header('Cache-Control: no-cache, must-revalidate');
                    header('Content-type: application/json');
                    echo json_encode(array('statusCode' => $statusCode, 'mensaje' => $mensaje, 'data' => $data, 'existe_archivo' => $existe_archivo, 'cantDataArchivo'=>$cantDataArchivo));
                    Yii::app()->end();
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
            } else {
                $mensaje = "Estimado usuario, no se ha suministrado los campos necesarios para realizar esta acción";
                header('Cache-Control: no-cache, must-revalidate');
                header('Content-type: application/json');
                echo json_encode(array('statusCode' => $statusCode, 'mensaje' => $mensaje, 'data' => $data));
            }
        } else {
            throw new CHttpException(404, 'Estimado Usuario, usted no esta autorizado para acceder mediante esta via.');
        }
    }

    public function generarArchivo(GeneradorForm $formGenerador, $ruta) {
        $resultado = null;
        if (is_object($formGenerador)) {
            if (($pos = strrpos($formGenerador->fields, ',')) !== false) {
                $columns = explode(',', $formGenerador->fields);
            } else {
                $columns[] = $formGenerador->fields;
            }
            $data = $formGenerador->executeQuery($formGenerador);
            $this->countData = count($data);
            if ($data != null) {
                $nombreClass = $this->prefijoCatalogo.$formGenerador->modelClass;
                $plantilla = $this->renderPartial('plantilla_catalogos', array('nombreClass' => $nombreClass, 'data' => $data, 'columnsTable' => $columns), true);
                $resultado = $nombreClass;
                touch($ruta);
                chmod($ruta, 0775);
                $ar = fopen($ruta, "w") or die("Problemas en la creacion");
                fwrite($ar, $plantilla);
                fclose($ar);
                if (file_exists($ruta)) {
                    return true;
                }
            }
        }

        return $resultado;
    }

}
