<?php

echo CHtml::scriptFile('/public/js/plantel.js');

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#plantel-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<div class="widget-box">

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'plantel-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'pager'=>array('pageSize'=>1),
	'columns'=>array(
		'cod_plantel',
		'cod_estadistico',
		'nombre',


	array(
		'name' => 'tipo_dependencia_id',
		'value' => '$data->tipoDependencia->nombre',
		'filter' => CHtml::listData(
			TipoDependencia::model()->findAll(
				array(
					'order' => 'id ASC'
				)
			),
			'id',
			'nombre'
		),
	),

	array(
		'name' => 'estado_id',
		'value' => '$data->estado->nombre',
		'filter' => CHtml::listData(
			Estado::model()->findAll(
				array(
					'order' => 'id ASC'
				)
			),
			'id',
			'nombre'
		),
	),

	array(
		'name' => 'municipio_id',
		'value' => '$data->municipio->nombre',
		'filter' => CHtml::listData(
			Municipio::model()->findAll(
				array(
					'order' => 'id ASC'
				)
			),
			'id',
			'nombre'
		),
	),

	array(
		'name' => 'estatus_plantel_id',
		'value' => '$data->estatusPlantel->nombre',
		'filter' => CHtml::listData(
			EstatusPlantel::model()->findAll(
				array(
					'order' => 'id ASC'
				)
			),
			'id',
			'nombre'
		),
	),

		array(
			'type' => 'raw',
			'header'=>'Acciones',
			'value'=>"'<a class=\'fa fa-search\'></a>'",
		),
	),
)); ?>


</div>
