<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'traza-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_hora'); ?>
		<?php echo $form->textField($model,'fecha_hora'); ?>
		<?php echo $form->error($model,'fecha_hora'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip_maquina'); ?>
		<?php echo $form->textField($model,'ip_maquina',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'ip_maquina'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo_transaccion'); ?>
		<?php echo $form->textField($model,'tipo_transaccion',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'tipo_transaccion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modulo'); ?>
		<?php echo $form->textField($model,'modulo',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'modulo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->