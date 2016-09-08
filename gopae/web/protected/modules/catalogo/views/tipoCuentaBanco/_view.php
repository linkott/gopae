<?php
/* @var $this TipoCuentaBancoController */
/* @var $model TipoCuentaBanco */

$this->breadcrumbs=array(
	'Tipo Cuenta Bancos'=>array('lista'),
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
                                            <?php echo $form->labelEx($model,'tipo_cuenta_id'); ?>
                                            <?php echo $form->dropDownList($model, 'tipo_cuenta_id', CHtml::listData(TipoCuenta::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'identificador'); ?>
                                            <?php echo $form->textField($model,'identificador',array('size'=>10, 'maxlength'=>10, 'class' => 'span-12', )); ?>
                                        </div>

                                    </div>

                                    <div class="space-6"></div>

                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'usuario_ini_id'); ?>
                                            <?php echo $form->textField($model,'usuario_ini_id', array('class' => 'span-12',"required"=>"required",)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'fecha_ini'); ?>
                                            <?php echo $form->textField($model,'fecha_ini', array('class' => 'span-12',"required"=>"required",)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'usuario_act_id'); ?>
                                            <?php echo $form->textField($model,'usuario_act_id', array('class' => 'span-12',)); ?>
                                        </div>

                                    </div>

                                    <div class="space-6"></div>

                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'fecha_act'); ?>
                                            <?php echo $form->textField($model,'fecha_act', array('class' => 'span-12',)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'fecha_elim'); ?>
                                            <?php echo $form->textField($model,'fecha_elim', array('class' => 'span-12',)); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'estatus'); ?>
                                            <?php echo $form->dropDownList($model, 'estatus', array('A'=>'Activo', 'I'=>'Inactivo', 'E'=>'Eliminado'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
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
            </div>
        </div>

        </div><!-- form -->
        </div>
    </div>
</div>
