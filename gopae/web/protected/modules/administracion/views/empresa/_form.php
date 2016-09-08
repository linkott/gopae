<?php
/* @var $this EmpresaController */
/* @var $model Empresa */
/* @var $form CActiveForm */
?>
<div class="col-xs-12">
    <div class="row-fluid">

        <div class="tabbable">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#datosGenerales" data-toggle="tab">Datos Generales</a></li>
                <!--<li class="active"><a href="#otrosDatos" data-toggle="tab">Otros Datos Relacionados</a></li>-->
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="datosGenerales">
                    <div class="form">

                        <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'empresa-form',
                                'htmlOptions' => array('data-form-type'=>$formType,), // for inset effect
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

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'rif'); ?>
                                                            <?php echo $form->textField($model,'rif',array('size'=>30, 'maxlength'=>30, 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'razon_social'); ?>
                                                            <?php echo $form->textField($model,'razon_social',array('size'=>60, 'maxlength'=>70, 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'siglas'); ?>
                                                            <?php echo $form->textField($model,'siglas',array('size'=>10, 'maxlength'=>10, 'class' => 'span-12', )); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'descripcion'); ?>
                                                            <?php echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>12, 'class' => 'span-12', )); ?>
                                                        </div>



                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'nombre_maxima_autoridad'); ?>
                                                            <?php echo $form->textField($model,'nombre_maxima_autoridad',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
                                                        </div>


                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'apellido_maxima_autoridad'); ?>
                                                            <?php echo $form->textField($model,'apellido_maxima_autoridad',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'origen_autoridad_administrativa'); ?>
                                                            <?php echo $form->textField($model,'origen_autoridad_administrativa',array('size'=>1, 'maxlength'=>1, 'class' => 'span-12', )); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'nombre_autoridad_administrativa'); ?>
                                                            <?php echo $form->textField($model,'nombre_autoridad_administrativa',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'apellido_autoridad_administrativa'); ?>
                                                            <?php echo $form->textField($model,'apellido_autoridad_administrativa',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'origen_autoridad_planificacion'); ?>
                                                            <?php echo $form->textField($model,'origen_autoridad_planificacion',array('size'=>1, 'maxlength'=>1, 'class' => 'span-12', )); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'nombre_autoridad_planificacion'); ?>
                                                            <?php echo $form->textField($model,'nombre_autoridad_planificacion',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'apellido_autoridad_planificacion'); ?>
                                                            <?php echo $form->textField($model,'apellido_autoridad_planificacion',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'estatus'); ?>
                                                            <?php echo $form->dropDownList($model, 'estatus', array('A'=>'Activo', 'I'=>'Inactivo', 'E'=>'Eliminado'), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'cedula_maxima_autoridad'); ?>
                                                            <?php echo $form->textField($model,'cedula_maxima_autoridad', array('class' => 'span-12',)); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'cedula_autoridad_administrativa'); ?>
                                                            <?php echo $form->textField($model,'cedula_autoridad_administrativa', array('class' => 'span-12',)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'cedula_autoridad_planificacion'); ?>
                                                            <?php echo $form->textField($model,'cedula_autoridad_planificacion', array('class' => 'span-12',)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'sector_id'); ?>
                                                            <?php echo $form->dropDownList($model, 'sector_id', CHtml::listData(TipoSector::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'sociedad_mercantil_id'); ?>
                                                            <?php echo $form->dropDownList($model, 'sociedad_mercantil_id', CHtml::listData(SociedadMercantil::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-md-6">
                                        <a class="btn btn-danger" href="<?php echo $this->createUrl("/administracion/empresa"); ?>" id="btnRegresar">
                                            <i class="icon-arrow-left"></i>
                                            Volver
                                        </a>
                                    </div>

                                    <div class="col-md-6 wizard-actions">
                                        <button class="btn btn-primary btn-next" data-last="Finish" type="submit">
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

                <div class="tab-pane" id="otrosDatos">
                    <div class="alertDialogBox">
                        <p>
                            Próximamente: Esta área se encuentra en Desarrollo.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div id="resultDialog" class="hide"></div>

        <?php
            /**
             * Yii::app()->clientScript->registerScriptFile(
             *   Yii::app()->request->baseUrl . '/public/js/modules/EmpresaController/empresa/form.js',CClientScript::POS_END
             *);
             */
        ?>
    </div>
</div>