<?php
/* @var $this OrdenCompraController */
/* @var $model OrdenCompra */

$this->breadcrumbs=array(
	'Orden Compras'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OrdenCompra', 'url'=>array('index')),
	array('label'=>'Create OrdenCompra', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#orden-compra-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Orden Compras</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'orden-compra-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'codigo',
		'dias_habiles',
		'dependencia',
		'proveedor_id',
		'unidad_administradora',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
