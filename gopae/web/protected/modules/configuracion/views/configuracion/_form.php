<?php
/* @var $this ConfiguracionController */
/* @var $model Configuracion */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'configuracion-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cod_tipo_dato'); ?>
		<?php echo $form->textField($model,'cod_tipo_dato',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'cod_tipo_dato'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor_bool'); ?>
		<?php echo $form->textField($model,'valor_bool'); ?>
		<?php echo $form->error($model,'valor_bool'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor_cod'); ?>
		<?php echo $form->textField($model,'valor_cod',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'valor_cod'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor_str'); ?>
		<?php echo $form->textField($model,'valor_str',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'valor_str'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor_lstr'); ?>
		<?php echo $form->textField($model,'valor_lstr',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'valor_lstr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor_txt'); ?>
		<?php echo $form->textArea($model,'valor_txt',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'valor_txt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor_int'); ?>
		<?php echo $form->textField($model,'valor_int'); ?>
		<?php echo $form->error($model,'valor_int'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor_date'); ?>
		<?php echo $form->textField($model,'valor_date'); ?>
		<?php echo $form->error($model,'valor_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario_ini_id'); ?>
		<?php echo $form->textField($model,'usuario_ini_id'); ?>
		<?php echo $form->error($model,'usuario_ini_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario_act_id'); ?>
		<?php echo $form->textField($model,'usuario_act_id'); ?>
		<?php echo $form->error($model,'usuario_act_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_ini'); ?>
		<?php echo $form->textField($model,'fecha_ini',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'fecha_ini'); ?>
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
		<?php echo $form->labelEx($model,'estatus_usur'); ?>
		<?php echo $form->textField($model,'estatus_usur',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'estatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->