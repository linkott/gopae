<?php
/* @var $this PlantelProveedorController */
/* @var $model PlantelProveedor */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'plantel-proveedor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'plantel_id'); ?>
		
		<?php echo $form->error($model,'plantel_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'proveedor_id'); ?>
		<?php echo $form->textField($model,'proveedor_id'); ?>
		<?php echo $form->error($model,'proveedor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'observacion'); ?>
		<?php echo $form->textArea($model,'observacion',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'observacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'proveedor_actual'); ?>
		<?php echo $form->textField($model,'proveedor_actual'); ?>
		<?php echo $form->error($model,'proveedor_actual'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario_ini_id'); ?>
		<?php echo $form->textField($model,'usuario_ini_id'); ?>
		<?php echo $form->error($model,'usuario_ini_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_ini'); ?>
		<?php echo $form->textField($model,'fecha_ini',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'fecha_ini'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario_act_id'); ?>
		<?php echo $form->textField($model,'usuario_act_id'); ?>
		<?php echo $form->error($model,'usuario_act_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_act'); ?>
		<?php echo $form->textField($model,'fecha_act',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'fecha_act'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_elim'); ?>
		<?php echo $form->textField($model,'fecha_elim',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'fecha_elim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estatus'); ?>
		<?php echo $form->textField($model,'estatus',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'estatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

   <div class="tabbable">

        <ul class="nav nav-tabs">

            <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Básicos</a></li>
            <li><a data-toggle="tab" href="#alimentos">Ingredientes</a></li>
            <!-- <li><a data-toggle="tab" href="#alimentos">alimentos</a></li>-->
        </ul>

        <div class="tab-content">
            <div id="datosGenerales" class="tab-pane active">

                <?php if ($form->errorSummary($model)) { ?>
                    <div id ="div-result-message" class="errorDialogBox" >
                        <?php echo $form->errorSummary($model); ?>
                    </div>

                <?php } else if ($estatusMod == true) { ?>

                    <div id='exitMenuNutricional' class="successDialogBox">
                        <p>
                            Exito! Modificado satisfactoriamente.
                        </p>
                    </div>


                <?php } else if ($estatus == true) { ?>

                    <div id='exitMenuNutricional' class="successDialogBox">
                        <p>
                            Exito! registrado a la base de datos satisfactoriamente.
                        </p>
                    </div>
                <?php } else { ?>

                    <div id='infoMenuNutricional' class="infoDialogBox" style="">
                        <p>
                            Por favor ingrese los datos correspondientes, los campos marcados con <b><span class="required">*</span></b> son estrictamente requeridos.

                        </p>
                    </div>
                <?php } ?>

                <div class="widget-box">
                    <div class="widget-header">
                        <h5>Datos de Menú Nutricional</h5>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="icon-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main form">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="col-md-12">
                                        <label><b>Nombre</b><span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-12">
                                        <?php echo $form->textField($model, 'nombre', array('class' => 'span-7', 'required' => 'required', 'style' => 'text-transform: uppercase;')); ?>
                                        <?php echo $form->error($model, 'nombre'); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <label><b>Precio Baremo</b><span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-12">
                                        <?php echo $form->textField($model, 'precio_baremo', array('class' => 'form-control span-7', 'style' => 'height: 30px;', 'required' => 'required')); ?>
                                        <?php echo $form->error($model, 'precio_baremo'); ?>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="col-md-12" >
                                        <label><b>Preparación</b><span class="required">*</span></label>
                                    </div>
                                    <!--                            <div class="col-md-12">
                                    <?php echo $form->textArea($model, 'preparacion', array('class' => 'span-7', 'required' => 'required', 'style' => 'text-transform: uppercase;')); ?>
                                    <?php echo $form->error($model, 'preparacion'); ?>
                                                                    </div>-->

                                    <div class="col-md-12" >

                                        <div id="editor1" class="wysiwyg-editor" style="border:1px solid #ccc;" contenteditable="true">
                                        </div>
                                        <?php
                                        if ($model->preparacion) {
                                            $model->preparacion = CHtml::decode($model->preparacion);
                                        }

                                        echo $form->textArea($model, 'preparacion', array('id' => 'preparacion', 'readonly' => 'true', 'hidden' => 'hidden'));
                                        ?>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <label><b>Precio de Mercado</b></label>
                                    </div>
                                    <div class="col-md-12">
                                        <?php echo $form->textField($model, 'precio_mercado', array('class' => 'span-7')); ?>
                                        <?php echo $form->error($model, 'precio_mercado'); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <label><b>Tipo de Menú</b><span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-12">
                                        <?php echo $form->dropDownList($model, 'tipo_menu', CHtml::listData(TipoMenu::model()->findAll(array('order' => 'id ASC')), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'required' => 'required')); ?>
                                        <?php echo $form->error($model, 'tipo_menu'); ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <label><b> Calorías (Kcal) </b><span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-12">
                                        <?php echo $form->textField($model, 'calorias', array('class' => 'span-7', 'required'=>'required')); ?>
                                        <?php echo $form->error($model, 'calorias'); ?>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id='id' name="id"  value="<?php echo $model->id ?>" />

                <hr>
                <div class="row-fluid wizard-actions">

                    <a class="btn btn-danger" href="/menuNutricional/menuNutricional/">
                        <i class="icon-arrow-left bigger-110"></i>
                        Volver
                    </a>

                    <button class="btn btn-primary btn-next" data-last="Finish ">
                        Guardar
                        <i class=" icon-save"></i>
                    </button>

                </div>
            </div>

            <?php $this->endWidget(); ?>

            <div id="alimentos" class="tab-pane">

                <?php
                if ($model->id !== NULL) {
                    $this->renderPartial('_formAlimento', array('model' => $modelAlimento, 'modelMenu' => $model, 'menu_id' => $model->id, 'tipo' => 'update'));
                } else {
                    ?>
                    <div id='infoMenuAlimento' class="alertDialogBox">
                        <p>
                            Debe registrar primero el menú para cargar los alimentos.
                        </p>
                    </div>
                    <?php
                }
                ?>

            </div>




        </div>

        <?php
        echo CHtml::scriptFile('/public/js/modules/menuNutricional/menuNutricional.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
        ?>
    </div>