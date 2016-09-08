<?php
/* @var $this ProveedorController */
/* @var $model Proveedor */
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
		<?php echo $form->label($model,'rif'); ?>
		<?php echo $form->textField($model,'rif',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'razon_social'); ?>
		<?php echo $form->textField($model,'razon_social',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_empresa_id'); ?>
		<?php echo $form->textField($model,'tipo_empresa_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'capital_social'); ?>
		<?php echo $form->textField($model,'capital_social'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_sector_id'); ?>
		<?php echo $form->textField($model,'tipo_sector_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'banco_id'); ?>
		<?php echo $form->textField($model,'banco_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_cuenta_id'); ?>
		<?php echo $form->textField($model,'tipo_cuenta_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'numero_cuenta'); ?>
		<?php echo $form->textField($model,'numero_cuenta'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'titular_cuenta'); ?>
		<?php echo $form->textField($model,'titular_cuenta',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado_id'); ?>
		<?php echo $form->textField($model,'estado_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'municipio_id'); ?>
		<?php echo $form->textField($model,'municipio_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parroquia_id'); ?>
		<?php echo $form->textField($model,'parroquia_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email_otro'); ?>
		<?php echo $form->textField($model,'email_otro',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'telfefono_local'); ?>
		<?php echo $form->textField($model,'telfefono_local'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'telfono_celular'); ?>
		<?php echo $form->textField($model,'telfono_celular'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'telfono_otro'); ?>
		<?php echo $form->textField($model,'telfono_otro'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'direccion'); ?>
		<?php echo $form->textArea($model,'direccion',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nil'); ?>
		<?php echo $form->textField($model,'nil',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ivss'); ?>
		<?php echo $form->textField($model,'ivss',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inces'); ?>
		<?php echo $form->textField($model,'inces',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'banavih'); ?>
		<?php echo $form->textField($model,'banavih',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'snc'); ?>
		<?php echo $form->textField($model,'snc',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'solvencia_laboral'); ?>
		<?php echo $form->textField($model,'solvencia_laboral',array('size'=>45,'maxlength'=>45)); ?>
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