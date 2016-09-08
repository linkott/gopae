<?php
/* @var $this MenuNutricionalController */
/* @var $model MenuNutricional */

$this->breadcrumbs=array(
	'Menu Nutricionals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MenuNutricional', 'url'=>array('index')),
	array('label'=>'Create MenuNutricional', 'url'=>array('create')),
	array('label'=>'Update MenuNutricional', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MenuNutricional', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MenuNutricional', 'url'=>array('admin')),
);
?>

<h1>View MenuNutricional #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'preparacion',
		'precio_mercado',
		'precio_varemos',
		'tipo_menu',
		'usuario_ini_id',
		'fecha_ini',
		'usuario_act_id',
		'fecha_act',
		'fecha_elim',
		'estatus',
	),
)); ?>
