<?php
/* @var $this ContactoBancoController */
/* @var $model ContactoBanco */

$this->breadcrumbs=array(
	'Contacto Bancos'=>array('lista'),
);
?>

<div class="tabbable">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#datosGenerales" data-toggle="tab">Datos Generales</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="datosGenerales">
            <div class="form">

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
                                            <?php echo $form->labelEx($model,'banco_id'); ?>
                                            <?php echo $form->dropDownList($model, 'banco_id', CHtml::listData(Banco::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'nombre_apellido'); ?>
                                            <?php echo $form->textField($model,'nombre_apellido',array('size'=>60, 'maxlength'=>160, 'class' => 'span-12', "required"=>"required",)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'telefono_fijo'); ?>
                                            <?php echo $form->textField($model,'telefono_fijo',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12', "required"=>"required",)); ?>
                                        </div>

                                    </div>

                                    <div class="space-6"></div>

                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'telefono_fax'); ?>
                                            <?php echo $form->textField($model,'telefono_fax',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12', )); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'telefono_celular'); ?>
                                            <?php echo $form->textField($model,'telefono_celular',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12', )); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'identificador'); ?>
                                            <?php echo $form->textField($model,'identificador',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
                                        </div>

                                    </div>

                                    <div class="space-6"></div>

                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'observaciones'); ?>
                                            <?php echo $form->textArea($model,'observaciones',array('rows'=>6, 'cols'=>12, 'class' => 'span-12', )); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'usuario_ini_id'); ?>
                                            <?php echo $form->textField($model,'usuario_ini_id', array('class' => 'span-12',"required"=>"required",)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'fecha_ini'); ?>
                                            <?php echo $form->textField($model,'fecha_ini', array('class' => 'span-12',"required"=>"required",)); ?>
                                        </div>

                                    </div>

                                    <div class="space-6"></div>

                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'usuario_act_id'); ?>
                                            <?php echo $form->textField($model,'usuario_act_id', array('class' => 'span-12',)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'fecha_act'); ?>
                                            <?php echo $form->textField($model,'fecha_act', array('class' => 'span-12',)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'fecha_elim'); ?>
                                            <?php echo $form->textField($model,'fecha_elim', array('class' => 'span-12',)); ?>
                                        </div>

                                    </div>

                                    <div class="space-6"></div>

                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'estatus'); ?>
                                            <?php echo $form->dropDownList($model, 'estatus', array('A'=>'Activo', 'I'=>'Inactivo', 'E'=>'Eliminado'), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div><!-- form -->
        </div>
    </div>
</div>
