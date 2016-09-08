<?php
/* @var $this ColaboradorasController */
/* @var $model Colaborador */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="tab-pane" id="datosGenerales">
            <div class="form">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'colaborador-form',
                    'htmlOptions' => array('data-form-type'=>$formType, 'data-id-model'=>base64_encode($model->id), 'onsubmit'=>'return validateForm();'), // for inset effect
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                ));
                ?>
                <div id="resultado">
                    <?php if($mensaje): ?>
                    <div class="alertDialogBox">
                        <p class="note">
                            <?php echo $mensaje; ?> Todos los campos con <span class="required">*</span> son requeridos.
                        </p>
                    </div>
                    <?php else: ?>
                        <?php if(is_null($mensajeExitoso)): ?>
                        <?php 
                            if($model->hasErrors()):
                                $this->renderPartial('//errorSumMsg', array('model' => $model)); 
                            else: 
                        ?>
                        <div class="alertDialogBox">
                            <p class="note">Todos los campos con <span class="required">*</span> son requeridos.
                                <?php if($formType==='create'): ?>Debe cerciorarse de que el Número de Documento de Identidad, Nombre, Apellido y Fecha de Nacimiento de la persona esté debidamente escrito ya que no podrán ser editados luego.<?php else: ?>El Número de Documento de Identidad, Nombre, Apellido y Fecha de Nacimiento son datos que no pueden ser editados.<?php endif; ?></p>
                        </div>
                        <?php 
                            endif; 
                        ?>
                        <?php else: ?>
                            <div class="successDialogBox">
                                <p class="note"><?php echo $mensajeExitoso; ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div id="general">

                    <div class="widget-box">

                        <div class="widget-header">
                            <h5>Datos de Identificación y Servicio</h5>

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
                                                    <?php echo $form->labelEx($model,'origen'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[origen]', $model->origen, CHtml::listData($origenes, 'abreviatura', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12')); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'cedula'); ?>
                                                    <?php echo $form->textField($model, 'cedula', array('maxlength' => "15", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Nro. de Cédula')); ?>
                                                    <input id="read_existe_cedula" type="hidden" maxlength="2" disabled='disabled' <?php if($formType==='update' || is_numeric($model->id)): ?>value="Si"<?php endif; ?> readOnly="readOnly" />
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'fecha_nacimiento'); ?>
                                                    <?php echo $form->hiddenField($model, 'fecha_nacimiento', array('maxlength' => "10", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'YYYY-MM-DD', 'readOnly'=>'readOnly')); ?>
                                                    <input id="read_fecha_nacimiento_latino" value="<?php echo Utiles::transformDate($model->fecha_nacimiento, '-', 'y-m-d', 'd-m-y') ?>" type="text" maxlength="10" required='required' class='span-12' placeholder='DD-MM-YYYY' readOnly="readOnly" />
                                                </div>
                                            </div>

                                            <div class="space-6"></div>

                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'nombre'); ?>
                                                    <?php echo $form->textField($model, 'nombre', array('maxlength' => "40", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Nombre (s)', 'data-inicial'=>$model->nombre)); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'apellido'); ?>
                                                    <?php echo $form->textField($model, 'apellido', array('maxlength' => "40", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Apellido (s)', 'data-inicial'=>$model->apellido)); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'sexo'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[sexo]', $model->sexo, CHtml::listData($generos, 'abreviatura', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'data-inicial'=>$model->sexo)); ?>
                                                </div>
                                            </div>

                                            <div class="space-6"></div>

                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'mision_id'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[mision_id]', $model->mision_id, CHtml::listData($misiones, 'id', 'nombre'), array('prompt' => '- - -', 'class'=>'span-12',)); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'certificado_medico'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[certificado_medico]', $model->certificado_medico, array('Si'=>'Sí', 'No'=>'No',), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12')); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'manipulacion_alimentos'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[manipulacion_alimentos]', $model->manipulacion_alimentos, array('Si'=>'Sí', 'No'=>'No',), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12')); ?>
                                                </div>
                                            </div>

                                            <div class="space-6"></div>

                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'grado_instruccion_id'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[grado_instruccion_id]', $model->grado_instruccion_id, CHtml::listData($gradosInstruccion, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12')); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'cant_hijos'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[cant_hijos]', $model->cant_hijos,array('0'=>'Ninguno', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=> '7', '8'=>'8',), array('class'=>'span-12',)); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'hijo_en_plantel'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[hijo_en_plantel]', $model->hijo_en_plantel, array('Si'=>'Sí', 'No'=>'No',), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12')); ?>
                                                </div>
                                            </div>

                                            <div class="space-6"></div>

                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'enfermedades'); ?>
                                                    <?php echo $form->textArea($model, 'enfermedades', array('maxlength' => '400', 'rows'=>'3', 'class' => 'span-12', 'placeholder'=>'Indique si padece de alguna enfermedad o alergia')); ?>
                                                </div>

                                                <div class="col-md-8">
                                                    <?php echo $form->labelEx($model,'observacion'); ?>
                                                    <?php echo $form->textArea($model, 'observacion', array('maxlength' => '400', 'rows'=>'3', 'class' => 'span-12', 'placeholder'=>'Indique si lo amerita alguna observación')); ?>
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" value="<?php echo $csrfToken; ?>" readonly="readonly" name="<?php echo $this->csrfTokenName; ?>" />

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-6"></div>

                    <div class="widget-box">

                        <div class="widget-header">
                            <h5>Datos de Contacto y de Ubicación</h5>

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

                                            <div class="infoDialogBox">
                                                <p class="note">Todos los campos con <span class="required">*</span> son requeridos. Indicando el número de Teléfono Celular y Correo Electrónico la persona puede más adelante recibir notificaciones del sistema.</p>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'telefono'); ?>
                                                    <?php echo $form->textField($model, 'telefono', array('maxlength' => "14", 'class' => 'span-12', 'placeholder'=>'(0251)000-0000')); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'telefono_celular'); ?>
                                                    <?php echo $form->textField($model, 'telefono_celular', array('maxlength' => "14", 'class' => 'span-12', 'placeholder'=>'(0426)000-0000')); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'email'); ?>
                                                    <?php echo $form->emailField($model, 'email', array('maxlength' => "120", 'class' => 'span-12', 'placeholder'=>'user@email.com')); ?>
                                                </div>
                                            </div>

                                            <div class="space-6"></div>

                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'estado_id'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[estado_id]', $model->estado_id, CHtml::listData($estados, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12',
                                                                        'ajax' => array(
                                                                            'type' => 'POST',
                                                                            'id' => 'Colaborador_estado_id',
                                                                            'update' => '#Colaborador_municipio_id',
                                                                            'url' => CController::createUrl('/servicio/colaboradoras/municipiosStandalone'),
                                                                        ),
                                                    )); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'municipio_id'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[municipio_id]', $model->municipio_id, CHtml::listData($municipios, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12',
                                                                        'ajax' => array(
                                                                            'type' => 'POST',
                                                                            'id' => 'Colaborador_municipio_id',
                                                                            'update' => '#Colaborador_parroquia_id',
                                                                            'url' => CController::createUrl('/servicio/colaboradoras/parroquiasStandalone'),
                                                                        ),
                                                    )); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'parroquia_id'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[parroquia_id]', $model->parroquia_id, CHtml::listData($parroquias, 'id', 'nombre'), array('prompt' => '- - -', 'class'=>'span-12', )); ?>
                                                </div>
                                            </div>

                                            <div class="space-6"></div>

                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <?php echo $form->labelEx($model,'direccion'); ?>
                                                    <?php echo $form->textArea($model, 'direccion', array('maxlength' => "400", 'rows'=>'3', 'class' => 'span-12', 'placeholder'=>'Ingrese la dirección referencial de la vivienda de la Madre o Padre Colaborador')); ?>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="space-6"></div>

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
                                                    <?php echo CHtml::dropDownList('Colaborador[banco_id]', $model->banco_id, CHtml::listData($bancos, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12',)); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'tipo_cuenta_id'); ?>
                                                    <?php echo CHtml::dropDownList('Colaborador[tipo_cuenta_id]', $model->tipo_cuenta_id, CHtml::listData($tiposDeCuenta, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12',)); ?>
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
                                                    <?php echo CHtml::dropDownList('Colaborador[origen_titular]', $model->origen_titular,  CHtml::listData($origenes, 'abreviatura', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12')); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'cedula_titular'); ?>
                                                    <?php echo $form->textField($model, 'cedula_titular', array('maxlength' => "15", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Nro. de Cédula del Titular de la Cuenta')); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'nombre_titular'); ?>
                                                    <?php echo $form->textField($model, 'nombre_titular', array('maxlength' => "80", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Nombre y Apellido del Titular de la Cuenta')); ?>
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
                            <a class="btn btn-danger" href="/servicio/colaboradoras/lista" id="btnRegresar">
                                <i class="icon-arrow-left"></i>
                                Volver
                            </a>
                        </div>

                        <div class="col-md-6 wizard-actions">
                            <button id="btn-submit-register-colaborador-form" class="btn btn-primary btn-next" data-last="Finish" type="submit">
                                Guardar
                                <i class="icon-save icon-on-right"></i>
                            </button>
                        </div>

                    </div>
                </div><!-- form -->
              <?php $this->endWidget(); ?>  
            </div>
        </div>

    </div>
    
    <div id="resultadoDialogo" class="hide">

    </div>
    
</div>
<?php 
    Yii::app()->clientScript->registerScriptFile(
        Yii::app()->request->baseUrl . '/public/js/modules/servicio/colaboradoras/form.js',CClientScript::POS_END
    );
?>
<?php
    Yii::app()->clientScript->registerScriptFile(
        Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END
    );
?>
