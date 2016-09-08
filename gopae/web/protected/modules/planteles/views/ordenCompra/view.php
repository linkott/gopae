<?php
/* @var $this OrdenCompraController */
/* @var $model OrdenCompra */

$this->breadcrumbs=array(
	'Orden Compras'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrdenCompra', 'url'=>array('index')),
	array('label'=>'Create OrdenCompra', 'url'=>array('create')),
	array('label'=>'Update OrdenCompra', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrdenCompra', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrdenCompra', 'url'=>array('admin')),
);
?>

<h1>View OrdenCompra #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'codigo',
		'dias_habiles',
		'dependencia',
		'proveedor_id',
		'unidad_administradora',
		'unidad_ejecutora_local',
		'fecha',
		'lugar_compra',
		'forma_pago_id',
		'condicion_compra_id',
		'lugar_entrega',
		'moneda_extranjera_id',
		'anticipo',
		'firma_elaboracion',
		'firma_revision',
		'firma_aprobacion',
		'firma_autorizacion',
		'usuario_ini_id',
		'fecha_ini',
		'usuario_act_id',
		'fecha_act',
		'fecha_elim',
		'estatus',
	),
)); ?>
