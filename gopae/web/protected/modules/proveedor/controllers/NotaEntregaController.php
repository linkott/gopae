<?php

class NotaEntregaController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    static $_permissionControl = array(
        'read' => 'Permite consultar las Notas de Entrega realizadas a este plantel',
        'write' => 'Permite Elaborar las Notas de Entrega',
        'admin' => 'Permite Desactivar, Eliminar las Notas de Entrega',
        'label' => 'Nota de Entrega'
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
                    'index', 'view'
                ),
                'pbac' => array('read'),
            ),
            //en esta seccion colocar todos los action del modulo
            array('allow',
                'actions' => array(
                    'create',
                    'update',
                    'elaborarNota',
                    'crearNota',
                    'descargar'
                ),
                'pbac' => array('write', 'admin'),
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
        $model = new NotaEntrega;
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
        $datos_plantel = PlantelPae::model()->datosPlantelNotaEntrega($idDecoded, $mes, $ano);
        if ($mes >= $mes_actual) {
            if ($planificacionActiva) {
                if ($datos_plantel[0]["proveedor_nombre"] != null) {
                    if ($datos_plantel[0]["pae_activo"] != null && $datos_plantel[0]["pae_activo"] == "SI") {
                        if ($datos_plantel[0]["nota_entrega"] == null) {
                            
                        } else {
                            $estatus = "con-orden-actual";
                        }
                    } else {
                        $estatus = "sin-pae-act";
                    }
                } else {
                    $estatus = "sin-prov";
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

    public function actionElaborarNota($id, $prov) {
        $model = new NotaEntrega;
        $estatus = "";
        $idDecoded = base64_decode($id);
        $ordenCompra = OrdenCompra::model()->datosOrdenCompra($idDecoded);



        $this->render('create', array(
            'model' => $model,
            'estatus' => $estatus,
            'estatusMod' => null,
            'proveedor_id' => $prov,
            'ordenCompra_id' => $id,
            'datosOrdenCompra' => $ordenCompra,
        ));
    }

    public function actionCrearNota() {

        $model = new NotaEntrega;
        if (isset($_POST['NotaEntrega']) AND isset($_FILES['NotaEntrega'])) {

            $ordenCompra = OrdenCompra::model()->datosOrdenCompra($_POST['NotaEntrega']['orden_id']);

            if (is_array($this->getPost('alimento')) and
                    is_array($this->getPost('cantidadEntregada'))
            ) {
                $arregloAlimento = $this->getPost('alimento');
                $arregloCantidad = $this->getPost('cantidadEntregada');



                if
                (count($arregloAlimento) == count($arregloCantidad)) {


//                    $model->attributes = $_POST['NotaEntrega'];
                    $model->codigo = 1;
                    $model->fecha = date('Y-m-d H:i:s');
                    $model->mes = '01';
                    $model->anio = 2014;
                    $model->orden_compra_id = $_POST['NotaEntrega']['orden_id'];
                    $model->usuario_ini_id = Yii::app()->user->id;
                    $model->fecha_ini = date("Y-m-d H:i:s");
                    $model->estatus = "A";
                    $archivo = $_FILES['NotaEntrega']['tmp_name']['archivo_nota_entrega'];
                    $nombre = $_FILES['NotaEntrega']['name']['archivo_nota_entrega'];
                    $trozos = explode(".", $nombre);
                    $formato = end($trozos);
                    $model->archivo_nota_entrega = $formato;


                    if ($model->validate()) {
                        $resultado = $model->registrarNota($model->attributes, $arregloAlimento, $arregloCantidad);
                        $json["status"] = $resultado[0]['registrar_nota'];

                        if ($json["status"] != NULL) {
                            $json["mensaje"] = "Nota de Entrega registrada con exito";

                            $model->findByPk($json["status"]);

                            $datos_nota_entrega = NotaEntrega::model()->datosNotaEntrega($json["status"]);
                            if ($datos_nota_entrega[0]["tipo_servicio"] == "INSUMO") {
                                $datos_insumos = NotaEntrega::model()->datosDetalleNotaEntrega($json["status"]);
                            } elseif ($datos_nota_entrega[0]["tipo_servicio"] == "PLATO SERVIDO") {
                                $datos_insumos = NotaEntrega::model()->datosDetalleNotaEntregaPlato($json["status"]);
                            } else {
                                $datos_insumos = null;
                            }

                            if ($datos_nota_entrega != null and $datos_insumos != null) {
                             
                                $ruta = realpath(Yii::app()->basePath . '/../public/uploads/notaEntrega');
                                $mPDF = Yii::app()->ePdf->mpdf();
                                $mPDF->WriteHTML($this->renderPartial('_headerNotaEntrega', array('datos_orden_compra' => $datos_nota_entrega), true));
                                $mPDF->WriteHTML($this->renderPartial('_bodyNotaEntrega', array('datos_insumos' => $datos_insumos), true));
                                 //$mPDF->WriteHTML($this->renderPartial('_footerNotaEntrega', array('datos_plantel' => $datos_plantel), true));
                                if (!file_exists($ruta)) {
                                    if (mkdir(Yii::app()->basePath . '/../public/uploads/notaEntrega', 0775)) {

                                        $command = 'chmod 775 -R  ' . Yii::app()->basePath . '/../public/uploads/notaEntrega';
                                        exec($command);
                                    }
                                }

                                $mPDF->Output(Yii::app()->basePath . '/../public/uploads/notaEntrega' . '/' . $datos_nota_entrega[0]["codigo_nota"] . '.pdf', EYiiPdf::OUTPUT_TO_FILE);
                                $ruta_imagen = $ruta . "/" . "A" . $datos_nota_entrega[0]["codigo_nota"] . "." . $formato;
                                if (is_uploaded_file($archivo)) {

                                    if (move_uploaded_file($archivo, $ruta_imagen)) {
                                        $json["status"] = "exito";
                                    } else {
                                        $json["status"] = "error-sin-archivo";
                                    }
                                }
                                // $upload_handler = new UploadHandler(null, true, null, date('YmdHis') . 'DP', "/public/uploads/documentoProveedor/");

                                $json["status"] = "exito";
                            } else {
                                $json["status"] = "exito-sin-pdf";
                            }
                        } elseif ($json["status"] == NULL) {
                            $json["mensaje"] = "Error al registrar la nota de entrega";
                        } else {
                            $json["mensaje"] = "hubo un error contactese con el administrador del sistema";
                        }
                    } else {
                        $json["status"] = "validacion";
                        $json["mensaje"] = $this->renderPartial('//errorSumMsg', array('model' => $model), TRUE);
                    }
                } else {
                    throw new CHttpException(404, 'Estimado Usuario, no se encontraron recursos solicitados.');
                }
            } else {

                throw new CHttpException(404, 'Estimado Usuario, no se encontro el recurso solicitado.');
            }

            echo json_encode($json);
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['NotaEntrega'])) {
            $model->attributes = $_POST['NotaEntrega'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new NotaEntrega('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['NotaEntrega']))
            $model->attributes = $_GET['NotaEntrega'];


        $dataProvider = new CActiveDataProvider('NotaEntrega');
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function columnaAcciones($data) {
        $prov = base64_encode($data["proveedor_id"]);
        $id = base64_encode($data["id"]);

        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';


        if ($data["estatus"] == "E") {
            $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "'/planteles/ordenCompra/view/id/" . $id, array("class" => "fa fa-search blue", "title" => "Visualizar esta Nota de Entrega")) . '</li>';
            if (Yii::app()->user->group == 1) {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Activar </span>", "#", array("class" => "fa fa-check green", "title" => "Activar esta Orden de compra", "onClick" => "VentanaDialog('$id',''/planteles/ordenCompra/activar','Activar Nota de Entrega','activar')")) . '</li>';
            }
        } else {

            if ($data["estatus_nota_entrega"] == '') {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Despachar Orden de Compra</span>", "/proveedor/notaEntrega/elaborarNota/id/" . $id . "/prov/" . $prov, array("class" => "fa fa-check-square blue", "title" => "Despachar esta Orden de Compra")) . '</li>';
            } else {
                $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Orden de Compra Despachada </span>", "", array("class" => "fa fa-check green", "title" => "Despachar esta Orden de Compra")) . '</li>';
            }
            //   $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Visualizar </span>", "'/planteles/ordenCompra/view/id/" . $id, array("class" => "fa fa-search blue", "title" => "Visualizar esta Nota de Entrega")) . '</li>';
            //   $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Modificar</span>", "'/planteles/ordenCompra/update/id/" . $id, array("class" => "fa fa-pencil green", "title" => "Modificar esta Nota de Entrega")) . '</li>';
            //   $columna .= '<li>' . CHtml::link("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;Eliminar</span>", "#", array("class" => "fa fa-trash-o red", "title" => "Inactivar esta Orden de compra", "onClick" => "VentanaDialog('$id','/planteles/ordenCompra/borrar','Inhabilitar Nota de Entrega','borrar')")) . '</li>';
        }

        $columna .= '</ul></div>';
        return $columna;
    }

    public function columnaCodigoNota($data) {
        if ($data["codigo"]) {
            $columna = $data["codigo"];
        } else {
            $columna = "---------";
        }
        return $columna;
    }

    public function columnaEstatusNota($data) {
        if ($data["estatus_nota_entrega"]) {
            $columna = $data["estatus_nota_entrega"];
        } else {
            $columna = "---------";
        }
        return $columna;
    }
     public function columnaElaborada($data) {
        if ($data["usuario"]) {
            $columna = $data["usuario"];
        } else {
            $columna = "---------";
        }
        return $columna;
    }
    public function columnaPdf($data) {
        if ($data["codigo"]) {
            $columna = $data["codigo"].".pdf";
        } else {
            $columna = "---------";
        }
        return $columna;
    }
    public function columnaPdfLink($data) {
        if ($data["codigo"]) {
            $columna = "/proveedor/notaEntrega/descargar/id/".base64_encode($data["codigo"]);
        } else {
            $columna = "---------";
        }
        return $columna;
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new NotaEntrega('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['NotaEntrega']))
            $model->attributes = $_GET['NotaEntrega'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return NotaEntrega the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = NotaEntrega::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function columnaSustitutos($data) {

        $idEncode = $data["menu_alimento_id"];
        $id = base64_encode($data["menu_alimento_id"]);

        $sustituto = NotaEntrega::model()->listadoPlanificacionSustituto($id);



        $columna = '<div class="btn-group">
                        <button class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
                            Seleccione
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-yellow pull-right">';


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


        $columna .= '</ul></div>';
        return $columna;
    }

    /**
     * Performs the AJAX validation.
     * @param NotaEntrega $model the model to be validated
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
            $columna = "Inactivo";
        } else if ($estatus == "A") {
            $columna = "Activo";
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
            $ruta = realpath(Yii::app()->basePath . '/../public/uploads/notaEntrega/');
            $nombre = base64_decode($_GET["id"]). '.pdf';
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
                        'message' => 'Nota de Entrega aprobada con exito!',
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
