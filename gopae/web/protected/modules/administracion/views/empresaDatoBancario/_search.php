<?php
/* @var $this EmpresaDatoBancarioController */
/* @var $model EmpresaDatoBancario */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id', array('class' => 'span-12',"required"=>"required",)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'empresa_id'); ?>
		<?php echo $form->dropDownList($model, 'empresa_id', CHtml::listData(Empresa::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'banco_id'); ?>
		<?php echo $form->dropDownList($model, 'banco_id', CHtml::listData(Banco::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_cuenta'); ?>
		<?php echo $form->textField($model,'tipo_cuenta',array('size'=>30, 'maxlength'=>30, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nro_cuenta'); ?>
		<?php echo $form->textField($model,'nro_cuenta',array('size'=>20, 'maxlength'=>20, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_ini_id'); ?>
		<?php echo $form->textField($model,'usuario_ini_id', array('class' => 'span-12',"required"=>"required",)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_ini'); ?>
		<?php echo $form->textField($model,'fecha_ini', array('class' => 'span-12',"required"=>"required",)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_act_id'); ?>
		<?php echo $form->textField($model,'usuario_act_id', array('class' => 'span-12',)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_act'); ?>
		<?php echo $form->textField($model,'fecha_act', array('class' => 'span-12',)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estatus'); ?>
		<?php echo $form->dropDownList($model, 'estatus', array('A'=>'Activo', 'I'=>'Inactivo', 'E'=>'Eliminado'), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->