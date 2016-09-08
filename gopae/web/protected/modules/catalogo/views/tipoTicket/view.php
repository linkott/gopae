<?php
/* @var $this TipoFundamentoController */
/* @var $model TipoFundamento */
/*
$this->breadcrumbs=array(
	'Tipo Fundamentos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TipoFundamento', 'url'=>array('index')),
	array('label'=>'Create TipoFundamento', 'url'=>array('create')),
	array('label'=>'Update TipoFundamento', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TipoFundamento', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TipoFundamento', 'url'=>array('admin')),
);
?>

<h1>View TipoFundamento #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'usuario_ini_id',
		'usuario_act_id',
		'fecha_ini',
		'fecha_act',
		'fecha_elim',
		'estatus',
	),

)); 
*/
 $this->renderPartial('_view',array('model'=>$model));
?>
