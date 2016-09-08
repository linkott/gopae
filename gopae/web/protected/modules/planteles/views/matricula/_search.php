<?php
/* @var $this MatriculaController */
/* @var $model SeccionPlantel */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_ini_id'); ?>
		<?php echo $form->textField($model,'usuario_ini_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_ini'); ?>
		<?php echo $form->textField($model,'fecha_ini',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_act_id'); ?>
		<?php echo $form->textField($model,'usuario_act_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_act'); ?>
		<?php echo $form->textField($model,'fecha_act',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_elim'); ?>
		<?php echo $form->textField($model,'fecha_elim',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estatus'); ?>
		<?php echo $form->textField($model,'estatus',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'plantel_id'); ?>
		<?php echo $form->textField($model,'plantel_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grado_id'); ?>
		<?php echo $form->textField($model,'grado_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'plan_id'); ?>
		<?php echo $form->textField($model,'plan_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'capacidad'); ?>
		<?php echo $form->textField($model,'capacidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'turno_id'); ?>
		<?php echo $form->textField($model,'turno_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'seccion_id'); ?>
		<?php echo $form->textField($model,'seccion_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nivel_id'); ?>
		<?php echo $form->textField($model,'nivel_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->