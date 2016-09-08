<?php
/* @var $this CargoController */
/* @var $model Cargo */

$this->breadcrumbs=array(
	'Cargos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cargo', 'url'=>array('index')),
	array('label'=>'Manage Cargo', 'url'=>array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model' => $model, 'subtitulo' => 'Crear Cargo')); ?>