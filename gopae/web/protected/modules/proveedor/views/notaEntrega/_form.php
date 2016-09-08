<?php
/* @var $this NotaEntregaController */
/* @var $model NotaEntrega */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'nota-entrega-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <div class="tabbable">

        <ul class="nav nav-tabs">

            <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>

        </ul>

        <div class="tab-content">
            <div id="datosGenerales" class="tab-pane active">

                <?php if ($form->errorSummary($model)) { ?>
                    <div id ="div-result-message" class="errorDialogBox" >
                        <?php echo $form->errorSummary($model); ?>
                    </div>
                <?php } ?>

                <?php
                if ($estatus == "sin-pae-act") {
                    $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'Este plantel no tiene el servicio PAE'));
                } elseif ($estatus == "sin-plan") {
                    $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'Este plantel no tiene planificacion durante este mes'));
                } elseif ($estatus == "sin-prov") {
                    $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'Este plantel no tiene Proveedor asignado'));
                } elseif ($estatus == "con-orden-actual") {
                    $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'Este plantel ya tiene una nota de entrega elaborada durante este mes.'));
                } elseif ($estatus == "mes-menor") {
                    $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'Solo se pueden realizar notas de entrega durante los meses posteriores al actual.'));
                } else {
                    ?>

                    <div class="row">
                        <div id="respNotaEntrega"><p></p></div>
                    </div>
                    <div class="widget-box">
                        <div class="widget-header">
                            <h5>Nota de Entrega para la Orden de Compra  <?php
                                $meses = Utiles::getMeses();
                                echo $meses[$datosOrdenCompra[0]["mes"]] . " de " . $datosOrdenCompra[0]["anio"];
                                ?></h5>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="icon-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main form">

                                <div class="row" >
                                    <?php
                                    //   var_dump($datos_plantel[0]["tipo_servicio"]);
                                    if ($datosOrdenCompra[0]["tipo_servicio"] == 'INSUMO') {
                                        $this->widget('zii.widgets.grid.CGridView', array(
                                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                            'id' => 'detalle-nota-entrega-grid',
                                            'dataProvider' => $model->listadoOrdenCompraInsumo($ordenCompra_id),
                                            'summaryText' => false,
                                            'pager' => array(
                                                'header' => '',
                                                'htmlOptions' => array('class' => 'pagination'),
                                                'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                                                'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                                                'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                                                'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                                            ),
                                            'columns' => array(
                                                array(
                                                    'type' => 'raw',
                                                    'header' => '<center>Nombre</center>',
                                                    'name' => 'nombre',
                                                    'value' => '"<input type=hidden id=alimento_id_".$data["id"]." value=".$data["id"]."  name=alimento[]  /><span id=nombre".$data["id"].">".$data["nombre"]."</span>"',
                                                 'htmlOptions' => array('width' => '18%'),
                                                    ),
                                                array(
                                                    'type' => 'raw',
                                                    'header' => '<center>U/M</center>',
                                                    'name' => 'unm',
                                                    'value' => '"<span id=unidad".$data["id"].">".$data["unm"]."</span>"',
                                                    'htmlOptions' => array('width' => '5%'),
                                                ),
                                                array(
                                                    'type' => 'raw',
                                                    'header' => '<center>Cantidad</center>',
                                                    'name' => 'cantidades',
                                                    'value' => '"<span id=cantidad".$data["id"]." data-cantidad=".$data["cantidades"]."  >".$data["cantidades"]."</span>"',
                                                    'htmlOptions' => array('width' => '10%'),
                                                ),
                                                array(
                                                    'type' => 'raw',
                                                    'header' => '<center> Precio Unitario</center>',
                                                    'name' => 'precio',
                                                    'htmlOptions' => array('width' => '10%'),
                                                    'value' => '"<span id=precio".$data["id"]." data-precio=".$data["precio"]."   >".$data["precio"]." Bs.</span>"',
                                                ),
                                                array(
                                                    'type' => 'raw',
                                                    'header' => '<center> Subtotal de la Orden De Compra </center>',
                                                    'name' => 'total',
                                                    'htmlOptions' => array('width' => '10%'),
                                                    'value' => '"<span id=total".$data["id"].">".$data["total"]."</span>"',
                                                ),
                                                array(
                                                    'type' => 'raw',
                                                    'header' => '<center> Cantidad Entregada </center>',
                                                    'htmlOptions' => array('width' => '10%'),
                                                    'value' => '"<input id=cantidadEntregada".$data["id"]." name=cantidadEntregada[] data-id=".$data["id"]." class=cantidadEntregada type=text />"',
                                                ),
                                                  array(
                                                    'type' => 'raw',
                                                    'header' => '<center> Subtotal de la Nota Entrega </center>',
                                                    'htmlOptions' => array('width' => '10%'),
                                                    'value' => '"<input  type=hidden id=totalEntregado".$data["id"]." name=totalEntregado[] value=0  /><span id=totalEntregadoSpan".$data["id"]."  >0 Bs.</span>"',
                                                ),
                                            ),
                                        ));
                                    } else if ($datosOrdenCompra[0]["tipo_servicio"] == 'PLATO SERVIDO') {
                                        $this->widget('zii.widgets.grid.CGridView', array(
                                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                            'id' => 'detalle-nota-entrega-grid',
                                            'dataProvider' => $model->listadoOrdenCompraInsumo($ordenCompra_id),
                                            'summaryText' => false,
                                            'pager' => array(
                                                'header' => '',
                                                'htmlOptions' => array('class' => 'pagination'),
                                                'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                                                'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                                                'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                                                'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                                            ),
                                            'columns' => array(
                                                array(
                                                    'type' => 'raw',
                                                    'header' => '<center>Nombre</center>',
                                                    'name' => 'nombre',
                                                    'value' => '"<input type=hidden id=alimento_id_".$data["id"]." value=".$data["id"]."  name=alimento[]  /><span id=nombre".$data["id"].">".$data["nombre"]."</span> <input name=id".$data["id"]." type=hidden value=".$data["id"]." >"',
                                                ),
                                                array(
                                                    'type' => 'raw',
                                                    'header' => '<center>Cantidad</center>',
                                                    'name' => 'cantidades',
                                                    'value' => '"<span id=cantidad".$data["id"].">".$data["cantidades"]."</span>"',
                                                    'htmlOptions' => array('width' => '10%'),
                                                ),
                                                array(
                                                    'type' => 'raw',
                                                    'header' => '<center> Precio Unitario</center>',
                                                    'name' => 'precio',
                                                    'htmlOptions' => array('width' => '10%'),
                                                    'value' => '"<span id=precio".$data["id"].">".$data["precio"]." Bs.</span>"',
                                                ),
                                                array(
                                                    'type' => 'raw',
                                                    'header' => '<center> Total de la Orden De Compra </center>',
                                                    'name' => 'total',
                                                    'htmlOptions' => array('width' => '10%'),
                                                    'value' => '"<span id=total".$data["id"].">".$data["total"]." Bs.</span>"',
                                                ),
                                            ),
                                        ));
                                    }
                                    ?>
                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo $form->labelEx($model, 'archivo_nota_entrega'); ?>
                                        </div>
                                        <div class="col-md-12">
                                           
                                            <?php echo $form->fileField($model, 'archivo_nota_entrega', array('required' => 'required', 'id'=>'archivo')); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" id='id' name="id"  value="<?php echo $model->id ?>" />
                    <input type="hidden" id='nota_entrega_id' name='NotaEntrega[orden_id]'  value="<?php echo $datosOrdenCompra[0]["id"]; ?>" />

                    <input type="hidden" id='tipo_servicio' name='NotaEntrega[tipo_servicio]'  value="<?php echo $datosOrdenCompra[0]["tipo_servicio"]; ?>" />
                    <input type="hidden" id='proveedor_id' name='proveedor_id'  value="<?php echo base64_decode($proveedor_id); ?>" />




                </div>

                <hr>
                <div class="row-fluid wizard-actions">

                    <a class="btn btn-danger" href="/proveedor/proveedor/">
                        <i class="icon-arrow-left bigger-110"></i>
                        Volver
                    </a>

                    <button class="btn btn-primary btn-next" data-last="Finish ">
                        Guardar
                        <i class=" icon-save"></i>
                    </button>

                </div>
            <?php } ?>

        </div>
    </div><!-- form -->
    <?php
    $this->widget('ext.loading.LoadingWidget');
    $this->endWidget();

    echo CHtml::scriptFile('/public/js/modules/proveedor/notaEntrega.js');
    ?>

</div>
