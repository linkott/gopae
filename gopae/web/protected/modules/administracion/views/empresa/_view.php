<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->breadcrumbs=array(
	'Empresas'=>array('lista'),
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
                                            <?php echo $form->labelEx($model,'origen_maxima_autoridad'); ?>
                                            <?php echo $form->textField($model,'origen_maxima_autoridad',array('size'=>1, 'maxlength'=>1, 'class' => 'span-12', )); ?>
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
                                            <?php echo $form->labelEx($model,'estatus'); ?>
                                            <?php echo $form->dropDownList($model, 'estatus', array('A'=>'Activo', 'I'=>'Inactivo', 'E'=>'Eliminado'), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                        </div>

                                    </div>

                                    <div class="space-6"></div>

                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'cedula_maxima_autoridad'); ?>
                                            <?php echo $form->textField($model,'cedula_maxima_autoridad', array('class' => 'span-12',)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'cedula_autoridad_administrativa'); ?>
                                            <?php echo $form->textField($model,'cedula_autoridad_administrativa', array('class' => 'span-12',)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'cedula_autoridad_planificacion'); ?>
                                            <?php echo $form->textField($model,'cedula_autoridad_planificacion', array('class' => 'span-12',)); ?>
                                        </div>

                                    </div>

                                    <div class="space-6"></div>

                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'sector_id'); ?>
                                            <?php echo $form->dropDownList($model, 'sector_id', CHtml::listData(TipoSector::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
                                        </div>

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
            </div>
        </div>

        </div><!-- form -->
        </div>
    </div>
</div>
