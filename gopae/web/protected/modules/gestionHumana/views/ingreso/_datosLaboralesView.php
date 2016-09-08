

<?php 
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'ingreso-empleado-view',
        'htmlOptions' => array('data-form-type'=>'view',), // for inset effect
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); 
?>

<?php if($model->estatus == 'A'): //Recordar cambiar el != a == ?>

<div id="div-result">
<?php
    if($model->hasErrors()):
        $this->renderPartial('//errorSumMsg', array('model' => $model));
    elseif(Yii::app()->user->hasFlash('success')): $this->renderPartial('//msgBox', array('class' => 'successDialogBox', 'message' => Yii::app()->user->getFlash('success')));
    else:
?>
    <div class="infoDialogBox"><p class="note">Todos los campos con <span class="required">*</span> son requeridos.</p></div>
<?php
    endif;
?>
</div>

<div id="div-datos-generales">

    <div class="widget-box">

        <div class="widget-header">
            <h5>Datos de Ingreso</h5>

            <div class="widget-toolbar">
                <a data-action="collapse" href="#">
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-body-inner">
                <div class="widget-main">
                    <div id="resultadoOperacion">
                        <div id="mensajeIngresoEmpleado"></div>
                    </div>
                    <div class="widget-main form">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'posee_numero_contrato'); ?>
                                    <?php echo $form->textField($model,'posee_numero_contrato', array('class' => 'span-12',"required"=>"required", 'readOnly'=>'readOnly')); ?>
                                </div>

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'nro_contrato'); ?>
                                    <?php echo $form->textField($model,'nro_contrato',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12', 'readOnly'=>'readOnly' )); ?>
                                </div>


                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'fecha_ingreso'); ?>
                                    <?php echo $form->textField($model,'fecha_ingreso', array('class' => 'span-12',"required"=>"required", 'readOnly'=>'readOnly')); ?>
                                </div>


                          </div>

                            <div class="space-6"></div>

                            <div class="col-md-12">

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'categoria_ingreso_id'); ?>
                                    <?php echo $form->textField($model->categoriaIngreso,'nombre', array('class' => 'span-12',"required"=>"required", 'readOnly'=>'readOnly')); ?>
                                </div>


                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'tipo_cargo_nominal_id'); ?>
                                    <?php echo $form->textField($model->tipoCargoNominal,'nombre', array('class' => 'span-12',"required"=>"required", 'readOnly'=>'readOnly')); ?>
                                </div>


                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'cargo_nominal_id'); ?>
                                    <?php echo $form->textField($model->cargoNominal,'nombre', array('class' => 'span-12',"required"=>"required", 'readOnly'=>'readOnly')); ?>
                                </div>

                          </div>

                            <div class="space-6"></div>

                            <div class="col-md-12">

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'estructura_organizativa_id'); ?>
                                    <?php echo $form->textField($model->estructuraOrganizativa,'nombre', array('class' => 'span-12',"required"=>"required", 'readOnly'=>'readOnly')); ?>
                                </div>


                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'condicion_nominal_id'); ?>
                                    <?php echo $form->textField($model->condicionNominal,'nombre', array('class' => 'span-12',"required"=>"required", 'readOnly'=>'readOnly')); ?>
                                </div>


                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'tipo_nomina_id'); ?>
                                    <?php echo $form->textField($model->tipoNomina,'nombre', array('class' => 'span-12',"required"=>"required", 'readOnly'=>'readOnly')); ?>
                                </div>

                          </div>

                            <div class="space-6"></div>

                            <div class="col-md-12">

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'plantel_id'); ?>
                                    <?php echo $form->textField( (isset($model->plantel->nombre))?$model->plantel:$model,(isset($model->plantel->nombre))?'nombre':'plantel_id', array('class' => 'span-12',"required"=>"required", 'readOnly'=>'readOnly')); ?>
                                </div>
                                
                                <div class="col-md-12">
                                    <?php echo $form->labelEx($model,'observaciones'); ?>
                                    <?php echo $form->textArea($model,'observaciones', array('class' => 'span-12',"required"=>"required", 'readOnly'=>'readOnly')); ?>
                                </div>

                          </div>

                            <div class="space-6"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ELSE: ?>
        <div class="alertDialogBox">
            <p class="note">
                <?php echo $model->talentoHumano->nombre.' '.$model->talentoHumano->apellido; ?> no esta ingresada, por favor registre sus datos de ingreso.
            </p>
        </div>
        
        <div class="row">
            <div class="pull-right" style="padding-left:10px;">
                <a type="submit" id='ingresoEmpleadoBoton' data-last="Finish" class="btn btn-success btn-next btn-sm">
                    <i class="fa fa-plus icon-on-right"></i>
                    Dar Ingreso a <?php echo $model->talentoHumano->nombre.' '.$model->talentoHumano->apellido; ?>
                </a>
            </div>
        </div>
        
        <?php ENDIF; ?>
        
        
        <hr>
        <div class="row">

            <div class="col-md-6">
                <a class="btn btn-danger" href="/gestionHumana/talentoHumano/lista" id="btnRegresar">
                    <i class="icon-arrow-left"></i>
                    Volver
                </a>
            </div>


        </div>

    </div>
</div>
<?php $this->endWidget(); ?>

       
        
        <div id="resultDialog" class="hide"></div>
        <div id="divFormRegistroIngresoEmpleado"></div>
        <div id="divFormIngresoEmpleadoDialog" class="hide"></div>




