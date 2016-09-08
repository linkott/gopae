<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<!--  
	<div class="row">
		<?php echo $form->label($model,'id_traza'); ?>
		<?php echo $form->textField($model,'id_traza'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_hora'); ?>
		<?php echo $form->textField($model,'fecha_hora'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ip_maquina'); ?>
		<?php echo $form->textField($model,'ip_maquina',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_transaccion'); ?>
		<?php echo $form->textField($model,'tipo_transaccion',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modulo'); ?>
		<?php echo $form->textField($model,'modulo',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->