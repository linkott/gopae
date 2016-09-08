<?php
/* @var $this PartidaController */
/* @var $model Partida */
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
		<?php echo $form->label($model,'codigo'); ?>
		<?php echo $form->textField($model,'codigo',array('size'=>22,'maxlength'=>22)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'permite_partida_aux'); ?>
		<?php echo $form->textField($model,'permite_partida_aux'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admite_transferencia'); ?>
		<?php echo $form->textField($model,'admite_transferencia'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'permite_asientos'); ?>
		<?php echo $form->textField($model,'permite_asientos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_saldo_id'); ?>
		<?php echo $form->textField($model,'tipo_saldo_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_gasto_id'); ?>
		<?php echo $form->textField($model,'tipo_gasto_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_partida_id'); ?>
		<?php echo $form->textField($model,'tipo_partida_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_ini_id'); ?>
		<?php echo $form->textField($model,'usuario_ini_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_ini'); ?>
		<?php echo $form->textField($model,'fecha_ini'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_act_id'); ?>
		<?php echo $form->textField($model,'usuario_act_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_act'); ?>
		<?php echo $form->textField($model,'fecha_act'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_elim'); ?>
		<?php echo $form->textField($model,'fecha_elim'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estatus'); ?>
		<?php echo $form->textField($model,'estatus',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->