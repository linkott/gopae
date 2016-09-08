<?php
/* @var $this MadresCocinerasController */
/* @var $model TalentoHumano */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="tab-pane" id="datosGenerales">
            <div class="form">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'cocinera-form',
                    'htmlOptions' => array('data-form-type'=>$formType, 'data-id-model'=>base64_encode($model->id), 'onsubmit'=>'return validateForm();'), // for inset effect
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation' => false,
                ));
                ?>

                <div id="general">

                    <div class="widget-box">

                        <div class="widget-header">
                            <h5>Datos de Identificación</h5>

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
                                            
                                            <?php if($model->verificado_saime=='No'): ?>
                                            <div class="col-md-12">
                                                <div class="errorDialogBox">
                                                    <p>
                                                        El Documento de Identidad de esta persona no ha podido ser verificado con el SAIME. Solicite la Cédula de Identidad.
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="space-6"></div>
                                            <?php endif; ?>
                                            
                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'origen'); ?>
                                                    <?php echo CHtml::dropDownList('TalentoHumano[origen]', $model->origen, CHtml::listData($origenes, 'abreviatura', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12')); ?>
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
                                                    <?php echo CHtml::dropDownList('TalentoHumano[sexo]', $model->sexo, CHtml::listData($generos, 'abreviatura', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'data-inicial'=>$model->sexo)); ?>
                                                </div>
                                            </div>

                                            <div class="space-6"></div>

                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'numero_tarjeta_alimentacion'); ?>
                                                    <?php echo $form->textField($model, 'numero_tarjeta_alimentacion', array('maxlength' => "30", 'class' => 'span-12', 'placeholder'=>'Número de Tarjeta del Bono de Alimentación', 'disabled'=>'disabled', 'data-inicial'=>$model->numero_tarjeta_alimentacion)); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'banco_tarjeta_alimentacion_id'); ?>
                                                    <?php $bancosSelect = CBanco::getData(); ?>
                                                    <?php echo CHtml::dropDownList('TalentoHumano[banco_tarjeta_alimentacion_id]', $model->banco_tarjeta_alimentacion_id, CHtml::listData($bancosSelect, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled')); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="entregada_tarjeta_alimentacion">¿Tarjeta de Alimentación Entregada? <span class="required">*</span></label>
                                                    <?php $entregaFechaAlimentacion = (strlen($model->fecha_entrega_tarjeta_alimentacion)>0)?'Si':''; ?>
                                                    <?php echo CHtml::dropDownList('entregada_tarjeta_alimentacion', $entregaFechaAlimentacion, array("Si"=>"Si", "No"=>"No"), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12',)); ?>
                                                </div>
                                            </div>
                                            
                                            <div class="space-6"></div>

                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'email_personal'); ?>
                                                    <?php echo $form->emailField($model, 'email_personal', array('maxlength' => "180", 'class' => 'span-12', 'placeholder'=>'Correo Electrónico Personal', 'required'=>true)); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'telefono_fijo'); ?>
                                                    <?php echo $form->textField($model, 'telefono_fijo', array('maxlength' => "21", 'class' => 'span-12', 'placeholder'=>'Teléfono Fijo',)); ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <?php echo $form->labelEx($model,'telefono_celular'); ?>
                                                    <?php echo $form->textField($model, 'telefono_celular', array('maxlength' => "21", 'class' => 'span-12', 'placeholder'=>'Teléfono Celular',)); ?>
                                                </div>
                                            </div>

                                            <input type="hidden" value="<?php echo $csrfToken; ?>" readonly="readonly" name="<?php echo $this->csrfTokenName; ?>" />

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

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

                    <div class="widget-box">

                        <div class="widget-header">
                            <h5>Fotografía</h5>

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

                                            <?php $fotografiaExistente = strlen($model->foto)>0 && is_file(str_replace('//', '/', Yii::app()->params['webDirectoryPath'].$model->foto)); ?>

                                            <div class="col-md-5 top center">
                                                <div style="min-height: 270px; padding: 20px; background-color: #CCCCCC;">
                                                    <video id="video" width="300" autoplay style="cursor: pointer;" title="Haga click para tomar una foto"></video>
                                                </div>
                                                <div class="space-6"></div>
                                                <button type="button" class="btn btn-success btn-xs <?php if($fotografiaExistente): ?>hide<?php endif; ?>" id="snap">
                                                    <i class="fa fa-camera"></i> Tomar foto
                                                </button>
                                            </div>
                                            <div class="col-md-2 center">

                                            </div>
                                            <div class="col-md-5 center">
                                                <div style="min-height: 270px; padding: 20px; background-color: #CCCCCC;">
                                                    <canvas class="hide" id="canvas" width="300" height="225"></canvas>
                                                    <?php if($fotografiaExistente): ?>
                                                        <img id="ImgTalentoHumanoFoto" class="" src="<?php echo $model->foto; ?>" />
                                                        <?php echo $form->hiddenField($model, 'foto', array()); ?>
                                                    <?php else: ?>
                                                        <input type="hidden" name="TalentoHumano[foto]" id="TalentoHumano_foto" value="" />
                                                    <?php endif; ?>
                                                    <input type="hidden" id="fotoImgBase64" name="fotoImgBase64" />
                                                </div>
                                                <div class="space-6"></div>
                                                <?php if($fotografiaExistente): ?>
                                                <button type="button" class="btn btn-info btn-xs hide" id="cancel-snap-refresh">
                                                    <i class="fa fa-arrow-left"></i> Cancelar
                                                </button>
                                                <button type="button" class="btn btn-info btn-xs" id="snap-refresh">
                                                    <i class="fa fa-refresh"></i> Actualizar esta Foto
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row <?php if($submitHide){ echo 'hide'; } ?>">

                        <div class="col-md-6">
                            <a class="btn btn-danger" href="/registroUnico/planteles/lista" id="btnRegresar">
                                <i class="icon-arrow-left"></i>
                                Volver
                            </a>
                        </div>

                        <div class="col-md-6 wizard-actions">
                            <button id="btn-submit-register-cocinera-form" class="btn btn-primary btn-next" data-last="Finish" type="submit">
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
