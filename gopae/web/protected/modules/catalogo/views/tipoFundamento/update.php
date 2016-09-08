<?php
/* @var $this TipoFundamentoController */
/* @var $model TipoFundamento */
/*
$this->breadcrumbs=array(
	'Tipo Fundamentos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TipoFundamento', 'url'=>array('index')),
	array('label'=>'Create TipoFundamento', 'url'=>array('create')),
	array('label'=>'View TipoFundamento', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TipoFundamento', 'url'=>array('admin')),
);
*/
?>

<?php $this->renderPartial('_form', array('model'=>$model,'subtitulo'=>'Modificar este tipo de fundamento juridico')); ?>