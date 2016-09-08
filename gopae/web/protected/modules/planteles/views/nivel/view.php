<?php
/* @var $this NivelController */
/* @var $model NivelPlantel */

$this->breadcrumbs=array(
	'Nivel Plantels'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NivelPlantel', 'url'=>array('index')),
	array('label'=>'Create NivelPlantel', 'url'=>array('create')),
	array('label'=>'Update NivelPlantel', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NivelPlantel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NivelPlantel', 'url'=>array('admin')),
);
?>

<h1>View NivelPlantel #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'plantel_id',
		'nivel_id',
		'usuario_ini_id',
		'fecha_ini',
		'usuario_act_id',
		'fecha_act',
		'fecha_elim',
		'estatus',
	),
)); ?>
