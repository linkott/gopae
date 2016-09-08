<?php
    $model->scenario = 'formDatosBancarios';
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'talentoHumanoDatosBancarios-form',
        'htmlOptions' => array(
            'data-form-type'=>$formType, 
            'data-id-model'=>base64_encode($model->id), 
            'onsubmit'=>'return validateForm();',
        ), 
        'action' => Yii::app()->createUrl('/gestionHumana/talentoHumano/registroDatosBancarios/id/'.base64_encode($model->id)),
        // for inset effect
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
?>
    <div id="divResultDatosBancarios">
        <div class="infoDialogBox">
            <p>
                Todos los campos con <span class="required">*</span> son requeridos.
            </p>
        </div>
    </div>

    <div class="widget-box">

        <div class="widget-header">
            <h5>Datos de Bancarios</h5>

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

                        <div class="row">

                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'banco_id'); ?>
                                    <?php echo CHtml::dropDownList('TalentoHumano[banco_id]', $model->banco_id, CHtml::listData($bancosSelect, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12',)); ?>
                                </div>

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'tipo_cuenta_id'); ?>
                                    <?php echo CHtml::dropDownList('TalentoHumano[tipo_cuenta_id]', $model->tipo_cuenta_id, CHtml::listData($tiposCuentaSelect, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12',)); ?>
                                </div>

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'numero_cuenta'); ?>
                                    <?php echo $form->textField($model, 'numero_cuenta', array('maxlength' => "20", 'required'=>'required', 'class' => 'span-12', 'title'=>'Número de Cuenta Bancaria')); ?>
                                </div>
                            </div>

                            <div class="space-6"></div>

                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'origen_titular'); ?>
                                    <?php echo CHtml::dropDownList('TalentoHumano[origen_titular]', $model->origen_titular,  CHtml::listData($origenesSelect, 'abreviatura', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12')); ?>
                                </div>

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'cedula_titular'); ?>
                                    <?php echo $form->textField($model, 'cedula_titular', array('maxlength' => "15", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Nro. de Cédula del Titular de la Cuenta')); ?>
                                </div>

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'nombre_titular'); ?>
                                    <?php echo $form->textField($model, 'nombre_titular', array('maxlength' => "40", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Nombre y Apellido del Titular de la Cuenta')); ?>
                                </div>
                            </div>
                            
                            <div class="space-6"></div>

                            <div class="col-md-12">
                                
                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'banco_tarjeta_alimentacion_id'); ?>
                                    <?php $bancosSelect = CBanco::getData(); ?>
                                    <?php echo CHtml::dropDownList('TalentoHumano[banco_tarjeta_alimentacion_id]', $model->banco_tarjeta_alimentacion_id, CHtml::listData($bancosSelect, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', )); ?>
                                </div>

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'numero_tarjeta_alimentacion'); ?>
                                    <?php echo $form->textField($model, 'numero_tarjeta_alimentacion', array('maxlength' => "30", 'class' => 'span-12', 'placeholder'=>'Número de Tarjeta del Bono de Alimentación', 'data-inicial'=>$model->numero_tarjeta_alimentacion)); ?>
                                </div>

                                <div class="col-md-4">
                                    <?php echo $form->labelEx($model,'fecha_entrega_tarjeta_alimentacion'); ?>
                                    <?php echo $form->hiddenField($model, 'fecha_entrega_tarjeta_alimentacion', array('maxlength' => "10", 'class' => 'span-12', 'readOnly'=>'readOnly', 'placeholder'=>'Fecha de Entrega de Tarjeta del Bono de Alimentación', 'data-inicial'=>$model->fecha_entrega_tarjeta_alimentacion)); ?>
                                    <input id="read_fecha_entrega_tarjeta_alimentacion" value="<?php echo Utiles::transformDate($model->fecha_entrega_tarjeta_alimentacion, '-', 'y-m-d', 'd-m-y') ?>" type="text" maxlength="10" required='required' class='span-12' placeholder='DD-MM-YYYY' readOnly="readOnly" />
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>

    <hr>

    <div class="row <?php if($submitHide){ echo 'hide'; } ?>">

        <div class="col-md-6">
            <div class="space-6"></div>
        </div>

        <div class="col-md-6 wizard-actions">
            <button id="btn-submit-register-datosBancarios-talentoHumano-form" class="btn btn-primary btn-next" data-last="Finish" type="submit">
                Guardar
                <i class="icon-save icon-on-right"></i>
            </button>
        </div>

    </div>
<?php $this->endWidget(); ?>
