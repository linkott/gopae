<?php

class OrdenCompraController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Permite consultar las Ordenes de Compra realizadas a este plantel',
        'write' => 'Permite Elaborar las Ordenes de Compra',
        'admin' => 'Permite Desactivar, Eliminar las Ordenes de Compra',
        'label' => 'Orden de Compra'
    );

    public function filters() {
        return array(
            'userGroupsAccessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {

        //en esta seccion colocar los action de solo lectura o consulta
        return array(
            array('allow',
                'actions' => array(
                    'index', 'view', 'descargar',
                ),
                'pbac' => array('read'),
            ),
            //en esta seccion colocar todos los action del modulo
            array('allow',
                'actions' => array(
                    'create',
                    'update',
                    'elaborarOrden',
                    'descargar',
                    'modificarOrden'
                ),
                'pbac' => array('write'),
            ),
            array('allow',
                'actions' => array(
                    'eliminar',
                    'aprobar',
                    'descargar',
                ),
                'pbac' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id, $item) {
        $model = new OrdenCompra;
        $estatus = "";
        $idDecoded = base64_decode($id);
        $mes_actual = (int) date("m");
        $mes = base64_decode($item);
        if ($mes_actual == 12) {
            $ano = date("Y") + 1;
        } else {
            $ano = date("Y");
        }

        $planificacionActiva = Planificacion::model()->planificacionActiva($idDecoded, $mes, $ano);
        $datos_plantel = PlantelPae::model()->datosPlantelOrdenCompra($idDecoded, $mes, $ano);
        if ($mes >= $mes_actual) {
            if ($planificacionActiva) {
                if (($datos_plantel[0]["matricula_general"] + $datos_plantel[0]["matricula_simoncito"]) > 0) {
                    if ($datos_plantel[0]["proveedor_nombre"] != null) {
                        if ($datos_plantel[0]["pae_activo"] != null && $datos_plantel[0]["pae_activo"] == "SI") {
                            if (strlen($datos_plantel[0]["tipo_servicio"]) != 0) {
                                if ($datos_plantel[0]["orden_compra"] == null) {
                                    
                                } else {
                                    $estatus = "con-orden-actual";
                                }
                            } else {
                                $estatus = "sin-tipo-servicio";
                            }
                        } else {
                            $estatus = "sin-pae-act";
                        }
                    } else {
                        $estatus = "sin-prov";
                    }
                } else {
                    $estatus = "sin-matricula";
                }
            } else {
                $estatus = "sin-plan";
            }
        } else {
            $estatus = "mes-menor";
        }



        $this->render('create', array(
            'estatus' => $estatus,
            'model' => $model,
            'plantel_id' => $id,
            'mes' => $mes,
            'ano' => $ano,
            'datos_plantel' => $datos_plantel,
        ));
    }

    public function actionElaborarOrden() {
        $model = new OrdenCompra;
        $estatus = "";
        $mes = base64_decode($_POST['OrdenCompra']["mes"]);
        $mes_actual = (int) date("m");
        if ($mes_actual == 12) {
            $ano = date("Y") + 1;
        } else {
            $ano = date("Y");
        }

        $json = array();
        $idDecoded = $_POST['OrdenCompra']['dependencia'];
        $planificacionActiva = Planificacion::model()->planificacionActiva($idDecoded, $mes, $ano);
        $datos_plantel = PlantelPae::model()->datosPlantelOrdenCompra($idDecoded, $mes, $ano);

        if ($mes >= $mes_actual) {
            if ($planificacionActiva) {
                if (($datos_plantel[0]["matricula_general"] + $datos_plantel[0]["matricula_simoncito"]) > 0) {
                    if ($datos_plantel[0]["proveedor_nombre"] != null) {
                        if ($datos_plantel[0]["pae_activo"] != null && $datos_plantel[0]["pae_activo"] == "SI") {
                            if ($datos_plantel[0]["tipo_servicio"] != null) {
                                if ($datos_plantel[0]["orden_compra"] == null) {

                                    if (isset($_POST['OrdenCompra'])) {

                                        if (is_array($this->getPost('alimento')) and
                                                is_array($this->getPost('cantidad')) and
                                                is_array($this->getPost('precio'))
                                        ) {
                                            $arregloAlimento = $this->getPost('alimento');
                                            $arregloCantidad = $this->getPost('cantidad');
                                            $arregloPrecio = $this->getPost('precio');


                                            if
                                            (count($arregloAlimento) == count($arregloCantidad) and
                                                    count($arregloCantidad) == count($arregloPrecio)
                                            ) {


                                                $model->attributes = $_POST['OrdenCompra'];
                                                $model->tipo_servicio = $datos_plantel[0]["tipo_servicio"];
                                                $model->codigo = $datos_plantel[0]["plantel_id"];
                                                $model->dependencia = $datos_plantel[0]["plantel_id"];
                                                $model->unidadAdministradora = $datos_plantel[0]["zona_id"];
                                                $model->proveedor = $datos_plantel[0]["proveedor_id"];
                                                $model->unidadEjecutoraLocal = $datos_plantel[0]["zona_id"];
                                                $model->lugar_compra = 1;
                                                $model->usuario_ini_id = Yii::app()->user->id;
                                                $model->fecha_ini = date("Y-m-d H:i:s");
                                                $model->mes = base64_decode($_POST['OrdenCompra']['mes']);
                                                $model->anio = base64_decode($_POST['OrdenCompra']['ano']);
                                                $model->estatus = "A";

                                                if ($model->validate()) {

                                                    $resultado = $model->registrarOrden($model->attributes, $arregloAlimento, $arregloCantidad, $arregloPrecio);
                                                    $json["status"] = $resultado[0]['registrar_orden'];



                                                    if ($json["status"] != NULL) {
                                                        $json["mensaje"] = "Orden de compra registrado con exito";

                                                        $model->findByPk($json["status"]);

                                                        $datos_orden_compra = OrdenCompra::model()->datosOrdenCompra($json["status"]);
                                                        if ($datos_orden_compra[0]["tipo_servicio"] == "INSUMO") {
                                                            $datos_insumos = OrdenCompra::model()->datosDetalleOrdenCompra($json["status"]);
                                                        } elseif ($datos_orden_compra[0]["tipo_servicio"] == "PLATO SERVIDO") {
                                                            $datos_insumos = OrdenCompra::model()->datosDetalleOrdenCompraPlato($json["status"]);
                                                        } else {
                                                            $datos_insumos = null;
                                                        }

                                                        if ($datos_orden_compra != null and $datos_insumos != null) {
                                                            $ruta = realpath(Yii::app()->basePath . '/../public/uploads/ordenCompra');
                                                            $mPDF = Yii::app()->ePdf->mpdf();
                                                            $mPDF->WriteHTML($this->renderPartial('_headerOrdenCompra', array('datos_orden_compra' => $datos_orden_compra), true));
                                                            $mPDF->WriteHTML($this->renderPartial('_bodyOrdenCompra', array('datos_insumos' => $datos_insumos), true));
                                                            $mPDF->WriteHTML($this->renderPartial('_footerOrdenCompra', array('datos_plantel' => $datos_plantel), true));
                                                            if (!file_exists($ruta)) {
                                                                if (mkdir(Yii::app()->basePath . '/../public/uploads/ordenCompra', 0775)) {
                                                                    $command = 'chmod 775 -R  ' . Yii::app()->basePath . '/../public/uploads/ordenCompra';
                                                                    exec($command);
                                                                }
                                                            }

                                                            $mPDF->Output(Yii::app()->basePath . '/../public/uploads/ordenCompra' . '/' . $datos_orden_compra[0]["codigo"] . '.pdf', EYiiPdf::OUTPUT_TO_FILE);

                                                            $json["status"] = "exito";
                                                        } else {
                                                            $json["status"] = "exito-sin-pdf";
                                                        }
                                                    } elseif ($json["status"] == NULL) {
                                                        $json["mensaje"] = "Error al registrar orden de compra";
                                                    } else {
                                                        $json["mensaje"] = "hubo un error contactese con el administrador del sistema";
                                                    }
                                                } else {
                                                    $json["status"] = "validacion";
                                                    $json["mensaje"] = $this->renderPartial('//errorSumMsg', array('model' => $model), TRUE);
                                                }
                                            } else {
                                                $json["status"] = "error";
                                                $json["mensaje"] = 'Error! 404 Estimado Usuario, no se encontraron recursos solicitados.';
                                            }
                                        } else {
                                            $json["status"] = "error";
                                            $json["mensaje"] = 'Error! 404 Estimado Usuario, no se encontraron recursos solicitados.';
                                        }
                                    }
                                } else {
                                    $json["status"] = "con-orden-actual";
                                }
                            } else {
                                $estatus = "sin-tipo-servicio";
                            }
                        } else {
                            $json["status"] = "sin-pae-act";
                        }
                    } else {
                        $json["status"] = "sin-prov";
                    }
                } else {
                    $json["status"] = "sin-matricula";
                }
            } else {
                $json["status"] = "sin-plan";
            }
        } 
        else {
            $json["status"] = "mes-menor";
        }
        echo json_encode($json);
    }

    public function actionModificarOrden() {
        $model = $this->loadModel($_POST["id"]);
        $estatus = "";


        if (isset($_POST['OrdenCompra'])) {

            if (is_array($this->getPost('alimento')) and
                    is_array($this->getPost('cantidad')) and
                    is_array($this->getPost('precio'))
            ) {
                $arregloAlimento = $this->getPost('alimento');
                $arregloCantidad = $this->getPost('cantidad');
                $arregloPrecio = $this->getPost('precio');


                if
                (count($arregloAlimento) == count($arregloCantidad) and
                        count($arregloCantidad) == count($arregloPrecio)
                ) {

                    $codigo = $model->codigo;
                    $id = $model->id;
                    $model->attributes = $_POST['OrdenCompra'];
                    $model->codigo = $codigo;
                    //$model->id = $id;
                    $model->usuario_ini_id = Yii::app()->user->id;
                    $model->fecha_ini = date("Y-m-d H:i:s");
                    $model->estatus = "A";

                    if ($model->validate()) {

                        $resultado = $model->modificarOrden($model->attributes, $arregloAlimento, $arregloCantidad, $arregloPrecio);

                        $json["status"] = $resultado[0]["modificar_orden"];



                        if ($json["status"] == $id) {
                            $json["mensaje"] = "Orden de compra Modificada con exito";



                            $datos_orden_compra = OrdenCompra::model()->datosOrdenCompra($json["status"]);
                            if ($datos_orden_compra[0]["tipo_servicio"] == "INSUMO") {
                                $datos_insumos = OrdenCompra::model()->datosDetalleOrdenCompra($json["status"]);
                            } elseif ($datos_orden_compra[0]["tipo_servicio"] == "PLATO SERVIDO") {
                                $datos_insumos = OrdenCompra::model()->datosDetalleOrdenCompraPlato($json["status"]);
                            } else {
                                $datos_insumos = null;
                            }

                            if ($datos_orden_compra != null and $datos_insumos != null) {

                                $ruta = realpath(Yii::app()->basePath . '/../public/uploads/ordenCompra');
                                $mPDF = Yii::app()->ePdf->mpdf();
                                $mPDF->WriteHTML($this->renderPartial('_headerOrdenCompra', array('datos_orden_compra' => $datos_orden_compra), true));
                                $mPDF->WriteHTML($this->renderPartial('_bodyOrdenCompra', array('datos_insumos' => $datos_insumos), true));
                                $mPDF->WriteHTML($this->renderPartial('_footerOrdenCompra', array('datos_plantel' => $datos_plantel), true));
                                if (!file_exists($ruta)) {
                                    if (mkdir(Yii::app()->basePath . '/../public/uploads/ordenCompra', 0775)) {
                                        $command = 'chmod 775 -R  ' . Yii::app()->basePath . '/../public/uploads/ordenCompra';
                                        exec($command);
                                    }
                                } else if (file_exists($ruta . "/" . $datos_orden_compra[0]["codigo"] . '.pdf')) {

                                    $command = 'mv ' . $ruta . "/" . $datos_orden_compra[0]["codigo"] . '.pdf ' . $ruta . "/old" . $datos_orden_compra[0]["codigo"] . '.pdf';
                                    exec($command);
                                }

                                $mPDF->Output(Yii::app()->basePath . '/../public/uploads/ordenCompra' . '/' . $datos_orden_compra[0]["codigo"] . '.pdf', EYiiPdf::OUTPUT_TO_FILE);

                                $json["status"] = "exito";
                            } else {
                                $json["status"] = "exito-sin-pdf";
                            }
                        } elseif ($json["status"] == NULL || $json["status"] == 404) {
                            $json["mensaje"] = "Error al Modificar orden de compra";
                        } else {
                            $json["mensaje"] = "hubo un error contactese con el administrador del sistema";
                        }
                    } else {
                        $json["status"] = "validacion";
                        $json["mensaje"] = $this->renderPartial('//errorSumMsg', array('model' => $model), TRUE);
                    }
                } else {
                    $json["status"] = "error";
                    $json["mensaje"] = 'Error! 404 Estimado Usuario, no se encontraron recursos solicitados.';
                }
            } else {
                $json["status"] = "error";
                $json["mensaje"] = 'Error! 404 Estimado Usuario, no se encontraron recursos solicitados.';
            }
        }

        echo json_encode($json);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $estatus = "";

        $model = $this->loadModel(base64_decode($id));

        $datos_plantel = PlantelPae::model()->datosPlantelOrdenCompra($model->dependencia, $model->mes, $model->anio);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrdenCompra'])) {
            $model->attributes = $_POST['OrdenCompra'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'estatus' => $estatus,
            'datos_plantel' => $datos_plantel,
            'plantel_id' => $id
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionEliminar() {
        $id = $_POST["id"];
        $resultado = OrdenCompra::model()->EliminarOrden($id);
        if ($resultado) {
            $this->renderPartial('//msgBox', array(
                'class' => 'successDialogBox',
                'message' => 'Orden de Compra Eliminada con exito!',
            ));
        } else {
            throw new CHttpException(404, 'Error Eliminando Orden de Compra.');
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new OrdenCompra('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrdenCompra']))
            $model->attributes = $_GET['OrdenCompra'];


        $dataProvider = new CActiveDataProvider('OrdenCompra');
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function columnaAcciones($data) {
        $id = $data["id"];
        $id = base64_encode($id);

        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';


        if ($data->estatus == "E") {
            // $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "'/planteles/ordenCompra/view/id/" . $id, array("class" => "fa fa-search blue", "title" => "Visualizar esta Orden de Compra")) . '</li>';
            if (Yii::app()->user->group == 1) {
                //$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Activar </span>", "#", array("class" => "fa fa-check green", "title" => "Activar esta Orden de compra", "onClick" => "VentanaDialog('$id',''/planteles/ordenCompra/activar','Activar Orden de Compra','activar')")) . '</li>';
                $columna .= '<li>' . "Orden Aprobada" . '</li>';
            }
        } else {
            if ($data["firma_aprobacion"] == 0) {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Aprobar</span>", "", array("class" => "fa fa-check blue", "title" => "Aprobar esta Orden de Compra", "onClick" => "VentanaDialog('$id','/planteles/ordenCompra/aprobar','Aprobar Orden de Compra','aprobar')")) . '</li>';
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar</span>", "/planteles/ordenCompra/update/id/" . $id, array("class" => "fa fa-pencil green", "title" => "Modificar esta Orden de Compra")) . '</li>';
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar</span>", "", array("class" => "fa fa-trash-o red", "title" => "Inactivar esta Orden de compra", "onClick" => "VentanaDialog('$id','/planteles/ordenCompra/borrar','Inhabilitar Orden de Compra','borrar')")) . '</li>';
            } else {
                $columna .= '<li>' . "<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Orden Aprobada</span>" . '</li>';
            }
            //$columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "'/planteles/ordenCompra/view/id/" . $id, array("class" => "fa fa-search blue", "title" => "Visualizar esta Orden de Compra")) . '</li>';
        }

        $columna .= '</ul></div>';
        return $columna;
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new OrdenCompra('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrdenCompra']))
            $model->attributes = $_GET['OrdenCompra'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return OrdenCompra the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = OrdenCompra::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'No existe la Orden la orden de compra.');
        return $model;
    }

    public function columnaSustitutos($data) {

        $idEncode = $data["id"];
        $id = base64_encode($data["id"]);
        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';
        if (!empty($data["menu_alimento_id"])) {
            $sustituto = OrdenCompra::model()->listadoPlanificacionSustituto($id);

            if ($data["cantidadsustitutos"] > 0) {
                $sustitutoTotal = explode(',', $data["sustitutototal"]);
                for ($x = 0; $x < $data["cantidadsustitutos"]; $x++) {


                    $columna .= "<li>"
                            . "<a class = 'osito fa fa-plus blue' "
                            . "data-cantidades = '" . $sustituto[$x]["cantidad"] * $data["matricula_general"] . "' "
                            . "data-um = '" . $sustituto[$x]["um"] . "' "
                            . "data-precio = '" . $sustituto[$x]["precio"] . "' "
                            . "data-id = '" . $data["id"] . "' "
                            . "data-alim ='" . $sustituto[$x]["alimento_id"] . "' "
                            . "data-nombre = '" . trim($sustituto[$x]["nombre"]) . "' "
                            . "data-total = '" . $sustituto[$x]["precio"] * $sustituto[$x]["cantidad"] * $data["matricula_general"] . "' />"
                            . "<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>"
                            . "&nbsp;&nbsp;" . trim($sustituto[$x]["nombre"]) . ""
                            . "</span>"
                            . "</a>"
                            . "</li>";
                }
            } else {
                $columna .= '<li>' . "<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp; No tiene sustitutos </span></li>";
            }
        } else {
            $columna .= '<li>' . "<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp; No tiene sustitutos </span></li>";
        }

        $columna .= '</ul></div>';
        return $columna;
    }

    /**
     * Performs the AJAX validation.
     * @param OrdenCompra $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'orden-compra-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function estatus($data) {
        $estatus = $data["estatus"];

        if ($estatus == "E") {
            $columna = "Inactiva";
        } else if ($estatus == "A") {
            if ($data["firma_aprobacion"] == 0) {
                $columna = "(Activa) Sin Aprobar";
            } else {
                $columna = "(Activa) Aprobada";
            }
        }
        return $columna;
    }

    public function mes($data) {

        $id = $data["mes"];
        $noOfZeros = 1; // i.e. you are converting 2 to 002.
        $divider = pow(10, $noOfZeros); // Now you are creating a divider (/100 in this case)
        $id = $id / $divider; // dividing the id by 100. i.e. 5 gets converted to 0.05
        $zeroedId = str_replace(".", "", $id);

        $mes = $zeroedId;

        $meses = Utiles::getMeses();

        $columna = $meses[$data["mes"]];


        return $columna;
    }

    public function anio($data) {
        $año = $data["fecha"];

        $columna = date("Y", strtotime($año));

        return $columna;
    }

    public function actionDescargar() {
        if (isset($_GET["id"])) {
            $ruta = realpath(Yii::app()->basePath . '/../public/uploads/ordenCompra/');
            $nombre = base64_decode($_GET["id"]) . '.pdf';
            $archivo = $ruta . "/" . $nombre;

            header("Content-disposition: attachment;filename=$nombre");
            header("Content-type: application/octet-stream");
            readfile($archivo);
        }
    }

    public function actionAprobar($id) {
        if (isset($id)) {

            $model = $this->loadModel(base64_decode($id));

            $model->firma_aprobacion = 1;
            if ($model->validate()) {
                if ($model->update()) {
                    $this->renderPartial('//msgBox', array(
                        'class' => 'successDialogBox',
                        'message' => 'Orden de Compra aprobada con exito!',
                    ));
                } else {
                    throw new CHttpException(500, 'Estimado Usuario ha ocurrido un error pongase en contacto con el administrador del sistema.');
                }
            } else {
                $this->renderPartial('//errorSumMsg', array('model' => $model));
            }
        } else {

            throw new CHttpException(404, 'Estimado Usuario, no se encontraron recursos solicitados.');
        }
    }

}
