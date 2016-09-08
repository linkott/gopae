<?php
/* @var $this ProveedorController */
/* @var $model Proveedor */

$this->menu=array(
	array('label'=>'List Proveedor', 'url'=>array('index')),
	array('label'=>'Create Proveedor', 'url'=>array('create')),
	array('label'=>'Update Proveedor', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Proveedor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Proveedor', 'url'=>array('admin')),
);
?>

<h1>View Proveedor #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'rif',
		'razon_social',
		'tipo_empresa_id',
		'capital_social',
		'tipo_sector_id',
		'banco_id',
		'tipo_cuenta_id',
		'numero_cuenta',
		'titular_cuenta',
		'estado_id',
		'municipio_id',
		'parroquia_id',
		'email',
		'email_otro',
		'telfefono_local',
		'telfono_celular',
		'telfono_otro',
		'direccion',
		'nil',
		'ivss',
		'inces',
		'banavih',
		'snc',
		'solvencia_laboral',
		'usuario_ini_id',
		'fecha_ini',
		'usuario_act_id',
		'fecha_act',
		'fecha_elim',
		'estatus',
	),
)); ?>
