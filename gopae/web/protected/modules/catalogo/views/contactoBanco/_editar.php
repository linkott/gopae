<?php
/* @var $this ContactoBancoController */
/* @var $model ContactoBanco */
/* @var $form CActiveForm */
?>
<div class="col-xs-12">
    <div class="row-fluid">

                    <div class="form">

                        <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'contacto-banco-form',
                                'htmlOptions' => array('data-form-type'=>$formType,),
                                'action'=>Yii::app()->createUrl('/catalogo/contactoBanco/edicionContactoBanco/id/'.$model->id),// for inset effect
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
           elseif(Yii::app()->user->hasFlash('success')):               $this->renderPartial('//msgBox', array('class' => 'successDialogBox', 'message' => Yii::app()->user->getFlash('success')));
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
                                    <h5>Datos Generales </h5>

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

                                                        <div class="col-md-6">
                                                            <?php echo CHtml::hiddenField('ContactoBanco[banco_id]', '', array("required"=>"required", 'readOnly'=>true,)); ?>
                                                            <?php echo $form->labelEx($model,'nombre_apellido'); ?>
                                                            <?php echo $form->textField($model,'nombre_apellido',array('size'=>60, 'maxlength'=>160, 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo $form->labelEx($model,'identificador'); ?>
                                                            <?php echo $form->textField($model,'identificador',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>

                                                    </div>

                                                    <div class="space-6"></div>

                                                     <div class="col-md-12">
                                                        
                                                        <div class="col-md-6">
                                                            <?php echo $form->labelEx($model,'telefono_fijo'); ?>
                                                            <?php echo $form->textField($model,'telefono_fijo',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>
                                                         
                                                        <div class="col-md-6">
                                                            <?php echo $form->labelEx($model,'correo'); ?>
                                                            <?php echo $form->textField($model,'correo',array('size'=>60, 'maxlength'=>120, 'class' => 'span-12',)); ?>
                                                        </div>

                                                  </div>
                                                    
                                                  <div class="col-md-12">

                                                        <div class="col-md-6">
                                                            <?php echo $form->labelEx($model,'telefono_fax'); ?>
                                                            <?php echo $form->textField($model,'telefono_fax',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12',)); ?>
                                                        </div>


                                                        <div class="col-md-6">
                                                            <?php echo $form->labelEx($model,'telefono_celular'); ?>
                                                            <?php echo $form->textField($model,'telefono_celular',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12',)); ?>
                                                        </div>

                                                  </div>

                                   

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">
                                                        
                                                        <div class="col-md-12">
                                                            <?php echo $form->labelEx($model,'observaciones'); ?>
                                                            <?php echo $form->textArea($model,'observaciones',array('rows'=>6, 'cols'=>12, 'class' => 'span-12', )); ?>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row hide">

                                    <div class="col-md-6">
                                        <a class="btn btn-danger" href="<?php echo $this->createUrl("/catalogo/contactoBanco"); ?>" id="btnRegresar">
                                            <i class="icon-arrow-left"></i>
                                            Volver
                                        </a>
                                    </div>

                                    <div class="col-md-6 wizard-actions">
                                        <button class="btn btn-primary btn-next hide" id="btnSubmitContactoBanco" data-last="Finish" type="submit">
                                            Guardar
                                            <i class="icon-save icon-on-right"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div><!-- form -->
                </div>

        <?php
            /**
             * Yii::app()->clientScript->registerScriptFile(
             *   Yii::app()->request->baseUrl . '/public/js/modules/banco/contacto-banco/form.js',CClientScript::POS_END
             *);
             */
        ?>
    </div>
