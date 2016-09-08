

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'ingreso-empleado-form',
        'htmlOptions' => array('data-form-type'=>'view',), // for inset effect
        'action'=>Yii::app()->createUrl('/gestionHumana/Ingreso/registroIngresoEmpleado/id/'.$model->id),// for inset effect
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
)); ?>

<div id="div-result">
<?php
           if($model->hasErrors()):
               $this->renderPartial('//errorSumMsg', array('model' => $model));
           elseif(Yii::app()->user->hasFlash('success')): 
               $this->renderPartial('//msgBox', array('class' => 'successDialogBox', 'message' => Yii::app()->user->getFlash('success')));
           else:
?>
                <div class="infoDialogBox"><p class="note">Todos los campos con <span class="required">*</span> son requeridos.</p></div>
                <div id="divFormContactosBancoDialog" class="hide"></div>
<?php
           endif;
?>
</div>

                        <div id="div-datos-generales">

                            <div class="widget-box">

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
                                                <div class="row">
                                                    <div class="col-md-12">
                                                <?php echo $form->hiddenField($model, 'talento_humano_id'); ?>
                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'posee_numero_contrato'); ?>
                                                            <?php echo $form->dropDownList($model, 'posee_numero_contrato', array('SI'=>'Sí', 'NO'=>'No',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'nro_contrato'); ?>
                                                            <?php echo $form->textField($model,'nro_contrato',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12', )); ?>
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'fecha_ingreso'); ?>
                                                            <?php echo $form->textField($model,'fecha_ingreso', array('class' => 'span-12',"required"=>"required", 'readOnly' => 'readOnly')); ?>
   
                                                            </div>
                                                    </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'categoria_ingreso_id'); ?>
                                                            <?php echo $form->dropDownList($model, 'categoria_ingreso_id', CHtml::listData(CategoriaIngreso::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'tipo_cargo_nominal_id'); ?>
                                                            <?php echo $form->dropDownList($model, 'tipo_cargo_nominal_id', CHtml::listData(TipoCargoNominal::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'cargo_nominal_id'); ?>
                                                            <?php echo $form->dropDownList($model, 'cargo_nominal_id', CHtml::listData(CargoNominal::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'estructura_organizativa_id'); ?>
                                                            <?php echo $form->dropDownList($model, 'estructura_organizativa_id', CHtml::listData(EstructuraOrganizativa::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'condicion_nominal_id'); ?>
                                                            <?php echo $form->dropDownList($model, 'condicion_nominal_id', CHtml::listData(CondicionNominal::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'tipo_nomina_id'); ?>
                                                            <?php echo $form->dropDownList($model, 'tipo_nomina_id', CHtml::listData(TipoNomina::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'plantel_id'); ?>
                                                            <?php echo $form->dropDownList($model, 'plantel_id', CHtml::listData(Plantel::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
                                                        </div>

                                                        <div class="col-md-8">
                                                            <?php echo $form->labelEx($model,'observaciones'); ?>
                                                            <?php echo $form->textArea($model,'observaciones',array('rows'=>6, 'cols'=>12, 'class' => 'span-12', )); ?>
                                                        </div>
                                                        
                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">
                                                        
                                                        <div class="row hide">

                                                            <div class="col-md-6 wizard-actions">
                                                                <button class="btn btn-primary btn-next hide" id="btnSubmitIngresoEmpleado" data-last="Finish" type="submit">
                                                                    Guardar
                                                                    <i class="icon-save icon-on-right"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
       

        <div id="resultDialog" class="hide"></div>
        

