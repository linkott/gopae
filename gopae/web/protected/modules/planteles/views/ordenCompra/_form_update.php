<?php
/* @var $this OrdenCompraController */
/* @var $model OrdenCompra */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'orden-compra-update-form',
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
                }else {
                    ?>

                    <div class="row">
                        <div id="respOrdenCompra"><p></p></div>
                    </div>
                    <div class="widget-box">
                        <div class="widget-header">
                            <h5>Datos de Orden de Compra  <?php $meses = Utiles::getMeses(); echo $meses[$model->mes]." de ".$model->anio;  ?></h5>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="icon-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main form">

                                <div class="row">


                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo $form->labelEx($model, 'dependencia'); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo "<span class='datos-form'>" . $model->Dependencia->nombre. "</span>"; ?>
                                            <?php echo "<input id ='dependencia' type='hidden' name='OrdenCompra[dependencia]' value = '" . $model->dependencia . "' />"; ?>

                                            <?php echo $form->error($model, 'dependencia'); ?>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo $form->labelEx($model, 'fecha'); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo "<span class='datos-form'>" . date("d-m-Y") . "</span>"; ?>
                                            <?php
                                            if ($model->fecha) {
                                                echo $form->hiddenField($model, 'fecha');
                                            } else {
                                                echo "<input type='hidden' name='OrdenCompra[fecha]' value = '" . date("Y-m-d") . "' />";
                                            }
                                            ?>
                                            <?php echo $form->error($model, 'fecha'); ?>
                                        </div>
                                    </div>




                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo $form->labelEx($model, 'proveedor_id'); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php
                                            if ($model->proveedor_id != null) {
                                                echo "<span class='datos-form'>" . $model->proveedor->razon_social . "</span>";
                                                echo "<input type='hidden' name='OrdenCompra[proveedor_id]' value = '" . $model->proveedor_id . "' />";
                                            } else {
                                                echo "<span class='datos-form'>" . "No tiene proveedor asignado!" . "</span>";
                                            }
                                            ?>
                                            <?php echo $form->error($model, 'proveedor_id'); ?>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo $form->labelEx($model, 'unidad_administradora'); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php
                                            if ($model->unidad_administradora != null) {
                                                echo "<span class='datos-form'>" . "ZONA EDUCATIVA " . $model->unidadAdministradora->nombre . "</span>";
                                                echo "<input type='hidden' name='OrdenCompra[unidad_administradora]' value = '" . $model->unidad_administradora . "' />";
//                                                echo "<input type='hidden' name='OrdenCompra[mes]' value = '" . base64_encode($mes) . "' />";
//                                                echo "<input type='hidden' name='OrdenCompra[ano]' value = '" . base64_encode($ano) . "' />";
                                            } else {
                                                echo "<span class='datos-form'>" . "No tiene Zona educativa asignada!" . "</span>";
                                            }
                                            ?>
                                            <?php echo $form->error($model, 'unidad_administradora'); ?>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo $form->labelEx($model, 'unidad_ejecutora_local'); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php
                                            if ($model->unidad_ejecutora_local != null) {
                                                echo "<span class='datos-form'>" . "ZONA EDUCATIVA " . $model->unidadEjecutoraLocal->nombre . "</span>";
                                                echo "<input type='hidden' name='OrdenCompra[unidad_ejecutora_local]' value = '" . $model->unidad_ejecutora_local . "' />";
                                            } else {
                                                echo "<span class='datos-form'>" . "No tiene Zona Educativa!" . "</span>";
                                            }
                                            ?>
                                            <?php echo $form->error($model, 'unidad_ejecutora_local'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo "<label for='OrdenCompra[estado]'>Estado</label>"; ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo "<span class='datos-form'>" . $model->Dependencia->estado_id . "</span>"; ?>
                                            <?php echo "<input type='hidden' name='OrdenCompra[estado]' value = '" . $model->Dependencia->estado_id . "' />"; ?>
                                            <?php echo $form->error($model, 'estado'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo "<label for='OrdenCompra[municipio]'>Municipio</label>"; ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo "<span class='datos-form'>" . $model->Dependencia->municipio_id . "</span>"; ?>
                                            <?php echo "<input type='hidden' name='OrdenCompra[municipio]' value = '" . $model->Dependencia->municipio_id . "' />"; ?>
                                            <?php echo $form->error($model, 'codigo'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo "<label for='OrdenCompra[matricula]'>Matricula General</label>"; ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo "<span class='datos-form'>" . $datos_plantel[0]["matricula_general"] . "</span>"; ?>
                                            <?php echo "<input type='hidden' name='OrdenCompra[matricula_general]' value = '" . $datos_plantel[0]["matricula_general"] . "' />"; ?>
                                            
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo "<label for='OrdenCompra[matricula]'>Matricula Simoncito</label>"; ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo "<span class='datos-form'>" . $datos_plantel[0]["matricula_simoncito"] . "</span>"; ?>
                                            <?php echo "<input type='hidden' name='OrdenCompra[matricula_simoncito]' value = '" . $datos_plantel[0]["matricula_simoncito"] . "' />"; ?>
                                            
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo $form->labelEx($model, 'dias_habiles'); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo $form->textField($model, 'dias_habiles', array('class' => 'span-12', 'required' => 'required')); ?>
                                            <?php echo $form->error($model, 'dias_habiles'); ?>
                                        </div>
                                    </div>




                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo $form->labelEx($model, 'forma_pago_id'); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo $form->dropDownList($model, 'forma_pago_id', CHtml::listData(TipoPago::model()->findAll(array('order' => 'nombre ASC')), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-12', 'required' => 'required')); ?>
                                            <?php echo $form->error($model, 'forma_pago_id'); ?>
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="col-md-12">
                                            <?php echo $form->labelEx($model, 'anticipo'); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo $form->textField($model, 'anticipo', array('class' => 'span-12', 'required' => 'required')); ?>
                                            <?php echo $form->error($model, 'anticipo'); ?>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <?php echo $form->labelEx($model, 'lugar_entrega'); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo $form->textArea($model, 'lugar_entrega', array('class' => 'span-12')); ?>
                                            <?php echo $form->error($model, 'lugar_entrega'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" id='id' name="id"  value="<?php echo $model->id ?>" />
                    <input type="hidden" id='tipo_servicio' name='OrdenCompra[tipo_servicio]'  value="<?php echo $datos_plantel[0]["tipo_servicio"]; ?>" />


                    <div class="row" >
                        <?php
                        //   var_dump($datos_plantel[0]["tipo_servicio"]);
                        if ($datos_plantel[0]["tipo_servicio"] == 1) {
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                'id' => 'detalle-orden-compra-grid',
                                'dataProvider' => $model->listadoPlanificacion(base64_encode($model->dependencia),$model->mes,$model->anio),
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
                                        'value' => '"<input type=hidden id=cantidad_".$data["id"]." value=".$data["cantidades"]*$data["matricula_total"]."  name=cantidad[]  /><span id=cantidad".$data["id"].">".$data["cantidades"]*$data["matricula_total"]."</span>"',
                                        'htmlOptions' => array('width' => '10%'),
                                    ),
                                    array(
                                        'type' => 'raw',
                                        'header' => '<center>Unidad de Medida</center>',
                                        'name' => 'unm',
                                        'value' => '"<span id=unidad".$data["id"].">".$data["unm"]."</span>"',
                                        'htmlOptions' => array('width' => '5%'),
                                    ),
                                    array(
                                        'type' => 'raw',
                                        'header' => '<center> Precio Unitario</center>',
                                        'name' => 'precio',
                                        'htmlOptions' => array('width' => '10%'),
                                        'value' => '"<input type=hidden id=precio_".$data["id"]." value=".$data["precio"]."  name=precio[]  /><span id=precio".$data["id"].">".$data["precio"]." Bs.</span>"',
                                    ),
                                    array(
                                        'type' => 'raw',
                                        'header' => '<center> Total </center>',
                                        'name' => 'total',
                                        'htmlOptions' => array('width' => '10%'),
                                        'value' => '"<span id=total".$data["id"].">".$data["total"]*$data["matricula_total"]." Bs.</span>"',
                                    ),
                                    array(
                                        'type' => 'raw',
                                        'header' => '<center>Sustitutos</center>',
                                        'value' => array($this, 'columnaSustitutos'),
                                        'htmlOptions' => array('width' => '5%'),
                                    ),
                                ),
                            ));
                        } else if ($datos_plantel[0]["tipo_servicio"] == 2) {
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                'id' => 'unidad-medida-grid',
                                'dataProvider' => $model->listadoPlanificacionPlato($plantel_id),
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
                                        'value' => '"<input type=hidden id=cantidad_".$data["id"]." value=".$data["cantidades"]."  name=cantidad[]  /><span id=cantidad".$data["id"].">".$data["cantidades"]."</span>"',
                                        'htmlOptions' => array('width' => '10%'),
                                    ),
                                    array(
                                        'type' => 'raw',
                                        'header' => '<center> Precio Unitario</center>',
                                        'name' => 'precio',
                                        'htmlOptions' => array('width' => '10%'),
                                        'value' => '"<input type=hidden id=precio_".$data["id"]." value=".$data["precio"]."  name=precio[]  /><span id=precio".$data["id"].">".$data["precio"]."Bs.</span>"',
                                    ),
                                    array(
                                        'type' => 'raw',
                                        'header' => '<center> Total </center>',
                                        'name' => 'total',
                                        'htmlOptions' => array('width' => '10%'),
                                        'value' => '"<span id=total".$data["id"].">".$data["total"]." Bs.</span>"',
                                    ),
                                ),
                            ));
                        }
                        ?>
                    </div>

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

echo CHtml::scriptFile('/public/js/modules/plantel/ordenCompra.js');
?>

</div>
