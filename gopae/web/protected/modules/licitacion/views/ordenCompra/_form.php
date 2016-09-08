<?php
/* @var $this OrdenCompraController */
/* @var $model OrdenCompra */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orden-compra-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'codigo'); ?>
		<?php echo $form->textField($model,'codigo',array('size'=>60,'maxlength'=>160)); ?>
		<?php echo $form->error($model,'codigo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dias_habiles'); ?>
		<?php echo $form->textField($model,'dias_habiles'); ?>
		<?php echo $form->error($model,'dias_habiles'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dependencia'); ?>
		<?php echo $form->textField($model,'dependencia'); ?>
		<?php echo $form->error($model,'dependencia'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'proveedor_id'); ?>
		<?php echo $form->textField($model,'proveedor_id'); ?>
		<?php echo $form->error($model,'proveedor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unidad_administradora'); ?>
		<?php echo $form->textField($model,'unidad_administradora'); ?>
		<?php echo $form->error($model,'unidad_administradora'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unidad_ejecutora_local'); ?>
		<?php echo $form->textField($model,'unidad_ejecutora_local'); ?>
		<?php echo $form->error($model,'unidad_ejecutora_local'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lugar_compra'); ?>
		<?php echo $form->textField($model,'lugar_compra'); ?>
		<?php echo $form->error($model,'lugar_compra'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'forma_pago_id'); ?>
		<?php echo $form->textField($model,'forma_pago_id'); ?>
		<?php echo $form->error($model,'forma_pago_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'condicion_compra_id'); ?>
		<?php echo $form->textField($model,'condicion_compra_id'); ?>
		<?php echo $form->error($model,'condicion_compra_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lugar_entrega'); ?>
		<?php echo $form->textArea($model,'lugar_entrega',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'lugar_entrega'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'moneda_extranjera_id'); ?>
		<?php echo $form->textField($model,'moneda_extranjera_id'); ?>
		<?php echo $form->error($model,'moneda_extranjera_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'anticipo'); ?>
		<?php echo $form->textField($model,'anticipo'); ?>
		<?php echo $form->error($model,'anticipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firma_elaboracion'); ?>
		<?php echo $form->textField($model,'firma_elaboracion'); ?>
		<?php echo $form->error($model,'firma_elaboracion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firma_revision'); ?>
		<?php echo $form->textField($model,'firma_revision'); ?>
		<?php echo $form->error($model,'firma_revision'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firma_aprobacion'); ?>
		<?php echo $form->textField($model,'firma_aprobacion'); ?>
		<?php echo $form->error($model,'firma_aprobacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firma_autorizacion'); ?>
		<?php echo $form->textField($model,'firma_autorizacion'); ?>
		<?php echo $form->error($model,'firma_autorizacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario_ini_id'); ?>
		<?php echo $form->textField($model,'usuario_ini_id'); ?>
		<?php echo $form->error($model,'usuario_ini_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_ini'); ?>
		<?php echo $form->textField($model,'fecha_ini'); ?>
		<?php echo $form->error($model,'fecha_ini'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario_act_id'); ?>
		<?php echo $form->textField($model,'usuario_act_id'); ?>
		<?php echo $form->error($model,'usuario_act_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_act'); ?>
		<?php echo $form->textField($model,'fecha_act'); ?>
		<?php echo $form->error($model,'fecha_act'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_elim'); ?>
		<?php echo $form->textField($model,'fecha_elim'); ?>
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