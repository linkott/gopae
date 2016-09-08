<?php
/* @var $this TipoCargoNominalController */
/* @var $model TipoCargoNominal */
/* @var $form CActiveForm */
$this->breadcrumbs=array(
	'Catálogo' => array('/catalogo'),
	'Tipos de Cargo Nominales'=>array('lista'),
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
                                'id'=>'tipo-cargo-nominal-form',
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
                                                            <?php echo $form->labelEx($model,'codigo'); ?>
                                                            <?php echo $form->textField($model,'codigo',array('size'=>10, 'maxlength'=>10, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>


                                                        <div class="col-md-8">
                                                            <?php echo $form->labelEx($model,'nombre'); ?>
                                                            <?php echo $form->textField($model,'nombre',array('size'=>60, 'maxlength'=>65, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">
                                                        
                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'siglas'); ?>
                                                            <?php echo $form->textField($model,'siglas',array('size'=>10, 'maxlength'=>10, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'estatus'); ?>
                                                            <?php echo $form->dropDownList($model, 'estatus', array('A'=>'Activo', 'I'=>'Inactivo', 'E'=>'Eliminado'), array('prompt'=>'- - -', 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'condicion_id'); ?>
                                                            <?php echo $form->textField($model,'condicion', array('class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">
                                                        
                                                        <div class="col-md-6">
                                                            <?php echo $form->labelEx($model,'descripcion'); ?>
                                                            <?php echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>12, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
                                                        </div>


                                                        <div class="col-md-6">
                                                            <?php echo $form->labelEx($model,'funciones'); ?>
                                                            <?php echo $form->textArea($model,'funciones',array('rows'=>6, 'cols'=>12, 'class' => 'span-12', 'disabled'=>'disabled',)); ?>
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
                                        <a class="btn btn-danger" href="<?php echo $this->createUrl("/catalogo/tipoCargoNominal"); ?>" id="btnRegresar">
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
