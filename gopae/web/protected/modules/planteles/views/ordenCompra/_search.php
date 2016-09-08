<?php
/* @var $this OrdenCompraController */
/* @var $model OrdenCompra */
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
		<?php echo $form->textField($model,'codigo',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dias_habiles'); ?>
		<?php echo $form->textField($model,'dias_habiles'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dependencia'); ?>
		<?php echo $form->textField($model,'dependencia'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'proveedor_id'); ?>
		<?php echo $form->textField($model,'proveedor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unidad_administradora'); ?>
		<?php echo $form->textField($model,'unidad_administradora'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unidad_ejecutora_local'); ?>
		<?php echo $form->textField($model,'unidad_ejecutora_local'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lugar_compra'); ?>
		<?php echo $form->textField($model,'lugar_compra'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'forma_pago_id'); ?>
		<?php echo $form->textField($model,'forma_pago_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'condicion_compra_id'); ?>
		<?php echo $form->textField($model,'condicion_compra_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lugar_entrega'); ?>
		<?php echo $form->textArea($model,'lugar_entrega',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'moneda_extranjera_id'); ?>
		<?php echo $form->textField($model,'moneda_extranjera_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'anticipo'); ?>
		<?php echo $form->textField($model,'anticipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firma_elaboracion'); ?>
		<?php echo $form->textField($model,'firma_elaboracion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firma_revision'); ?>
		<?php echo $form->textField($model,'firma_revision'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firma_aprobacion'); ?>
		<?php echo $form->textField($model,'firma_aprobacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firma_autorizacion'); ?>
		<?php echo $form->textField($model,'firma_autorizacion'); ?>
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