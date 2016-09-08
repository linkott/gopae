<?php
/* @var $this PlantelProveedorController */
/* @var $model PlantelProveedor */

$this->breadcrumbs=array(
	'Plantel Proveedors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PlantelProveedor', 'url'=>array('index')),
	array('label'=>'Create PlantelProveedor', 'url'=>array('create')),
	array('label'=>'Update PlantelProveedor', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PlantelProveedor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PlantelProveedor', 'url'=>array('admin')),
);
?>

<h1>View PlantelProveedor #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'plantel_id',
		'proveedor_id',
		'observacion',
		'proveedor_actual',
		'usuario_ini_id',
		'fecha_ini',
		'usuario_act_id',
		'fecha_act',
		'fecha_elim',
		'estatus',
	),
)); ?>
