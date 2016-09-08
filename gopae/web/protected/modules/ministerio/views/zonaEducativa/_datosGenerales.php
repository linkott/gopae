<?php
/* @var $this ZonaEducativaController */
/* @var $model ZonaEducativa */
/* @var $form CActiveForm */

$this->pageTitle = 'Edición de Datos de Zona Educativa';
?>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "/ministerio/zonaEducativa/seleccionarMunicipio/estado_id/<?php echo $model->estado_id; ?>",
            data: null,
            success: function(data) {
                $("#Plantel_estado_id").attr('readOnly', 'true');
                $("#Plantel_municipio_id").html(data);
                $("#Plantel_municipio_id").val(<?php echo $model->municipio_id; ?>);
            }
        });
    });
</script>
<div id="resultadoZona"></div>
<div id="resultado">
    <div class="infoDialogBox">
        <p>
            Debe Ingresar los Datos Generales de la Zona Educativa. Los campo marcados con <span class="required">*</span> son requeridos.
        </p>
    </div>
</div>


<div id="guardo" class="successDialogBox" style="display: none">
    <p>
        Registro exitoso
    </p>
</div>

<div  id="modificarZona" class="widget-box">

    <div class="widget-header">
        <h5>Datos Generales</h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-body-inner">
            <div class="widget-main">
                <div class="widget-main form">

                    <div class="row" align="left">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'zona-educativa-form',
                            'enableAjaxValidation' => false,
                        ));
                        ?>
                        <?php echo $form->errorSummary($model); ?>
                        <?php echo '<input type="hidden" id="id" value=' . $model->id . ' name="id"/>'; ?>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="col-md-12"><label for="nombre">Nombre<span class="required">*</span></label> </div>
                                <?php echo $form->textField($model, 'nombre', array('maxlength' => "60", 'size' => '60', 'class' => 'span-12', 'id' => 'nombre')); ?>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><label for="nombre">Estado<span class="required">*</span></label> </div>
                                <?php
                                echo $form->dropDownList(
                                        $model, 'estado_id', CHtml::listData($estado, 'id', 'nombre', ''), array('readonly' => 'readonly',
                                    'ajax' => array(
                                        'type' => 'GET',
                                        //'disabled'=>'true',
                                        'id' => 'Plantel_estado_id',
                                        'update' => '#Plantel_municipio_id',
                                        'url' => CController::createUrl('/ministerio/zonaEducativa/seleccionarMunicipio'),
                                    ),
                                    'empty' => array('' => '-Seleccione-'), 'class' => 'span-12',
                                        )
                                );
                                ?>
                            </div>
                            <div id="divMunicipio" class="col-md-4">
                                <?php echo $form->labelEx($model, 'Municipio', array("class" => "col-md-12")); ?>
                                <?php
                                echo $form->dropDownList($model, 'municipio_id', array(), array(
                                    'empty' => '-Seleccione-',
                                    'id' => 'Plantel_municipio_id',
                                    'class' => 'span-12',
                                    'ajax' => array(
                                        'type' => 'GET',
                                    //'update' => '#Plantel_parroquia_id',
                                    //'url' => CController::createUrl('seleccionarParroquia'),
                                    ),
                                    'empty' => array('' => '-Seleccione-'), 'class' => 'span-12',
                                ));
                                ?>
                                <?php //echo $form->error($model, 'telefono_otro'); ?>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div id="divTelefonoFijo" class="col-md-4">
                                <?php echo $form->labelEx($model, 'telefono_fijo', array("class" => "col-md-12")); ?>
                                <?php echo $form->textField($model, 'telefono_fijo', array('size' => 11, 'id' => 'telefono_fijo', 'maxlength' => 11, 'class' => 'span-12', 'onkeyup' => "var reg = /[^0-9 ]/gi;
                                                                   if(reg.test(this.value))this.value = this.value.replace(reg,'');")); ?>
                                <?php echo $form->error($model, 'telefono_fijo'); ?>
                            </div>

                            <div id="divTelefonoOtro" class="col-md-4">
                                <?php echo $form->labelEx($model, 'Télefono Adicional', array("class" => "col-md-12")); ?>
                                <?php echo $form->textField($model, 'telefono_otro', array('size' => 11, 'id' => 'telefono_otro', 'maxlength' => 11, 'class' => 'span-12', 'onkeyup' => "var reg = /[^0-9 ]/gi;
                                                                   if(reg.test(this.value))this.value = this.value.replace(reg,'');")); ?>
                                <?php echo $form->error($model, 'telefono_otro'); ?>
                            </div>


                            <div id="divCorreo" class="col-md-4">
                                <?php echo $form->labelEx($model, 'correo', array("class" => "col-md-12")); ?>
                                <?php echo $form->textField($model, 'correo', array('size' => 40, 'maxlength' => 60, 'class' => 'span-12', 'id' => 'correo')); ?>
                                <?php echo $form->error($model, 'correo'); ?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div id="divDireccion" class="col-md-12">
                                <?php echo $form->labelEx($model, 'Dirección Referencial<span class="required">*</span>', array("class" => "col-md-12")); ?>
                                <?php echo $form->textArea($model, 'direccion_referencial', array('class'=>'span-12', 'rows' => 5, 'id' => 'direccion')); ?>
                                <?php echo $form->error($model, 'direccion_referencial'); ?>
                            </div>
                        </div>

                    </div>
                    <?php $this->endWidget(); ?>
                </div>

                <hr>

                <div class="row">

                    <div class="col-md-6">
                        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("../ministerio/zonaEducativa"); ?>" class="btn btn-danger">
                            <i class="icon-arrow-left"></i>
                            Volver
                        </a>
                    </div>

                    <div class="col-md-6 wizard-actions">
                        <button type="submit" data-last="Finish" class="btn btn-primary btn-next">
                            Guardar
                            <i class="icon-save icon-on-right"></i>
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>