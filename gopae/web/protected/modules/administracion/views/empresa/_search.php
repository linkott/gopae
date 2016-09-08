<?php
/* @var $this EmpresaController */
/* @var $model Empresa */
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
		<?php echo $form->label($model,'rif'); ?>
		<?php echo $form->textField($model,'rif',array('size'=>30, 'maxlength'=>30, 'class' => 'span-12', "required"=>"required",)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'razon_social'); ?>
		<?php echo $form->textField($model,'razon_social',array('size'=>60, 'maxlength'=>70, 'class' => 'span-12', "required"=>"required",)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'siglas'); ?>
		<?php echo $form->textField($model,'siglas',array('size'=>10, 'maxlength'=>10, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>12, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'origen_maxima_autoridad'); ?>
		<?php echo $form->textField($model,'origen_maxima_autoridad',array('size'=>1, 'maxlength'=>1, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre_maxima_autoridad'); ?>
		<?php echo $form->textField($model,'nombre_maxima_autoridad',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'apellido_maxima_autoridad'); ?>
		<?php echo $form->textField($model,'apellido_maxima_autoridad',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'origen_autoridad_administrativa'); ?>
		<?php echo $form->textField($model,'origen_autoridad_administrativa',array('size'=>1, 'maxlength'=>1, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre_autoridad_administrativa'); ?>
		<?php echo $form->textField($model,'nombre_autoridad_administrativa',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'apellido_autoridad_administrativa'); ?>
		<?php echo $form->textField($model,'apellido_autoridad_administrativa',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'origen_autoridad_planificacion'); ?>
		<?php echo $form->textField($model,'origen_autoridad_planificacion',array('size'=>1, 'maxlength'=>1, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre_autoridad_planificacion'); ?>
		<?php echo $form->textField($model,'nombre_autoridad_planificacion',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'apellido_autoridad_planificacion'); ?>
		<?php echo $form->textField($model,'apellido_autoridad_planificacion',array('size'=>40, 'maxlength'=>40, 'class' => 'span-12', )); ?>
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

	<div class="row">
		<?php echo $form->label($model,'cedula_maxima_autoridad'); ?>
		<?php echo $form->textField($model,'cedula_maxima_autoridad', array('class' => 'span-12',)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cedula_autoridad_administrativa'); ?>
		<?php echo $form->textField($model,'cedula_autoridad_administrativa', array('class' => 'span-12',)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cedula_autoridad_planificacion'); ?>
		<?php echo $form->textField($model,'cedula_autoridad_planificacion', array('class' => 'span-12',)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sector_id'); ?>
		<?php echo $form->dropDownList($model, 'sector_id', CHtml::listData(TipoSector::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sociedad_mercantil_id'); ?>
		<?php echo $form->dropDownList($model, 'sociedad_mercantil_id', CHtml::listData(SociedadMercantil::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->