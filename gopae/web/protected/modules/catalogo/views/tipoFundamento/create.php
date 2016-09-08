<?php
/* @var $this TipoFundamentoController */
/* @var $model TipoFundamento */
/*
$this->breadcrumbs=array(
	'Tipo Fundamentos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TipoFundamento', 'url'=>array('index')),
	array('label'=>'Manage TipoFundamento', 'url'=>array('admin')),
);
*/
?>

<?php $this->renderPartial('_form', array('model'=>$model,'subtitulo'=>'Nuevo Tipo de Fundamento Juridico')); ?>