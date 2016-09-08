<?php
/* @var $this ZonaEducativaController */
/* @var $model ZonaEducativa */

$this->breadcrumbs=array(
	'Zona Educativas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ZonaEducativa', 'url'=>array('index')),
	array('label'=>'Manage ZonaEducativa', 'url'=>array('admin')),
);
?>

<h1>Create ZonaEducativa</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>