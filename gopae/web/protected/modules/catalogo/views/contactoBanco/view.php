<?php
/* @var $this ContactoBancoController */
/* @var $model ContactoBanco */
/* @var $form CActiveForm */
$this->breadcrumbs=array(
	'Contacto Bancos'=>array('lista'),
);
?>
<div class="col-xs-12">
    <div class="row-fluid">

        <div class="tabbable">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#datosGenerales" data-toggle="tab">Vista de Datos Generales</a></li>
                <!--<li class="active"><a href="#otrosDatos" data-toggle="tab">Otros Datos Relacionados</a></li>-->
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="datosGenerales">
                    <div class="view">

                        <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'contacto-banco-form',
                                'htmlOptions' => array('onSubmit'=>'return false;',), // for inset effect
                                // Please note: When you enable ajax validation, make sure the corresponding
                                // controller action is handling ajax validation correctly.
                                // There is a call to performAjaxValidation() commented in generated controller code.
                                // See class documentation of CActiveForm for details on this.
                                'enableAjaxValidation'=>false,
                        )); ?>

                        <div id="div-datos-generales">

                            <div class="widget-box">

                                <div class="widget-header">
                                    <h5>Vista de Datos Generales</h5>

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
                                                            <?php echo $form->textField($model,'banco_id', array('class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'nombre_apellido'); ?>
                                                            <?php echo $form->textField($model,'nombre_apellido',array('size'=>60, 'maxlength'=>160, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'telefono_fijo'); ?>
                                                            <?php echo $form->textField($model,'telefono_fijo',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'telefono_fax'); ?>
                                                            <?php echo $form->textField($model,'telefono_fax',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'telefono_celular'); ?>
                                                            <?php echo $form->textField($model,'telefono_celular',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'identificador'); ?>
                                                            <?php echo $form->textField($model,'identificador',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'observaciones'); ?>
                                                            <?php echo $form->textArea($model,'observaciones',array('rows'=>6, 'cols'=>12, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'fecha_elim'); ?>
                                                            <?php echo $form->textField($model,'fecha_elim', array('class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'estatus'); ?>
                                                            <?php echo $form->dropDownList($model, 'estatus', array('A'=>'Activo', 'I'=>'Inactivo', 'E'=>'Eliminado'), array('prompt'=>'- - -', 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-md-6">
                                        <a class="btn btn-danger" href="<?php echo $this->createUrl("/catalogo/banco/edicion/id/".base64_encode($model->banco_id)); ?>" id="btnRegresar">
                                            <i class="icon-arrow-left"></i>
                                            Volver
                                        </a>
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

    </div>
</div>