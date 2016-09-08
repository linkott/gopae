<?php
/* @var $this NivelController */
/* @var $model NivelPlantel */

$this->breadcrumbs=array(
	'Nivel Plantels'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NivelPlantel', 'url'=>array('index')),
	array('label'=>'Create NivelPlantel', 'url'=>array('create')),
	array('label'=>'View NivelPlantel', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NivelPlantel', 'url'=>array('admin')),
);
?>

<h1>Update NivelPlantel <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>