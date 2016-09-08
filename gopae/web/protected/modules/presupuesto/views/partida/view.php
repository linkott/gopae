<?php
/* @var $this PartidaController */
/* @var $model Partida */

$this->breadcrumbs=array(
	'Partidas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Partida', 'url'=>array('index')),
	array('label'=>'Create Partida', 'url'=>array('create')),
	array('label'=>'Update Partida', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Partida', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Partida', 'url'=>array('admin')),
);
?>

<h1>View Partida #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'codigo',
		'descripcion',
		'permite_partida_aux',
		'admite_transferencia',
		'permite_asientos',
		'tipo_saldo_id',
		'tipo_gasto_id',
		'tipo_partida_id',
		'usuario_ini_id',
		'fecha_ini',
		'usuario_act_id',
		'fecha_act',
		'fecha_elim',
		'estatus',
	),
)); ?>
