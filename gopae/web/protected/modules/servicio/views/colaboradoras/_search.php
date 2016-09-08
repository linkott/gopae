<?php
/* @var $this ColaboradorasController */
/* @var $model Colaborador */
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
		<?php echo $form->label($model,'origen'); ?>
		<?php echo $form->textField($model,'origen',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cedula'); ?>
		<?php echo $form->textField($model,'cedula'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_nacimiento'); ?>
		<?php echo $form->textField($model,'fecha_nacimiento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>40,'maxlength'=>40)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'apellido'); ?>
		<?php echo $form->textField($model,'apellido',array('size'=>40,'maxlength'=>40)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sexo'); ?>
		<?php echo $form->textField($model,'sexo',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'telefono_celular'); ?>
		<?php echo $form->textField($model,'telefono_celular',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>120)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'twitter'); ?>
		<?php echo $form->textField($model,'twitter',array('size'=>40,'maxlength'=>40)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'foto'); ?>
		<?php echo $form->textField($model,'foto',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mision_id'); ?>
		<?php echo $form->textField($model,'mision_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'certificado_medico'); ?>
		<?php echo $form->textField($model,'certificado_medico',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manipulacion_alimentos'); ?>
		<?php echo $form->textField($model,'manipulacion_alimentos',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>120)); ?>
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
		<?php echo $form->label($model,'direccion'); ?>
		<?php echo $form->textArea($model,'direccion',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'enfermedades'); ?>
		<?php echo $form->textArea($model,'enfermedades',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alergias'); ?>
		<?php echo $form->textArea($model,'alergias',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'observacion'); ?>
		<?php echo $form->textArea($model,'observacion',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_cuenta_id'); ?>
		<?php echo $form->textField($model,'tipo_cuenta_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'banco_id'); ?>
		<?php echo $form->textField($model,'banco_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'numero_cuenta'); ?>
		<?php echo $form->textField($model,'numero_cuenta',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'origen_titular'); ?>
		<?php echo $form->textField($model,'origen_titular',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cedula_titular'); ?>
		<?php echo $form->textField($model,'cedula_titular'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre_titular'); ?>
		<?php echo $form->textField($model,'nombre_titular',array('size'=>60,'maxlength'=>80)); ?>
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
		<?php echo $form->label($model,'estatus'); ?>
		<?php echo $form->textField($model,'estatus',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'plantel_actual_id'); ?>
		<?php echo $form->textField($model,'plantel_actual_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cant_hijos'); ?>
		<?php echo $form->textField($model,'cant_hijos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hijo_en_plantel'); ?>
		<?php echo $form->textField($model,'hijo_en_plantel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grado_instruccion_id'); ?>
		<?php echo $form->textField($model,'grado_instruccion_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'busqueda'); ?>
		<?php echo $form->textField($model,'busqueda'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->