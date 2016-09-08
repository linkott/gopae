<?php
/* @var $this NivelController */
/* @var $model NivelPlantel */

$this->breadcrumbs=array(
	'Nivel Plantels'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NivelPlantel', 'url'=>array('index')),
	array('label'=>'Manage NivelPlantel', 'url'=>array('admin')),
);
?>

<h1>Create NivelPlantel</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>