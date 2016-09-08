<?php
/* @var $this NivelController */
/* @var $model Nivel */

$this->breadcrumbs=array(
	'Nivels'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Nivel', 'url'=>array('index')),
	array('label'=>'Manage Nivel', 'url'=>array('admin')),
);
?>

<h1>Create Nivel</h1>

<?php $this->renderPartial('_form', array('model'=>$model,
                        'modalidadEstudio' => $modalidadEstudio,)); ?>