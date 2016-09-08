<?php
/* @var $this UnidadGrupoController */
/* @var $model UnidadGrupo */

$this->breadcrumbs=array(
	'Unidad Grupos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UnidadGrupo', 'url'=>array('index')),
	array('label'=>'Create UnidadGrupo', 'url'=>array('create')),
	array('label'=>'Update UnidadGrupo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UnidadGrupo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UnidadGrupo', 'url'=>array('admin')),
);
?>

<h1>View UnidadGrupo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group_id',
		'unidad_resp_ticket_id',
		'usuario_ini_id',
		'usuario_act_id',
		'estatus',
		'fecha_ini',
		'fecha_act',
	),
)); ?>
