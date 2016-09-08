<?php
/* @var $this CargoController */
/* @var $model Cargo */

$this->breadcrumbs=array(
	'Cargos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cargo', 'url'=>array('index')),
	array('label'=>'Create Cargo', 'url'=>array('create')),
	array('label'=>'View Cargo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cargo', 'url'=>array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model' => $model, 'subtitulo' => 'Modificar Cargo ' . $model->nombre)); ?>