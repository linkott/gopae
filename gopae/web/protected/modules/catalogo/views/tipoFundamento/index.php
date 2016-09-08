<?php
/* @var $this TipoFundamentoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tipo Fundamentos',
);

$this->menu=array(
	array('label'=>'Create TipoFundamento', 'url'=>array('create')),
	array('label'=>'Manage TipoFundamento', 'url'=>array('admin')),
);
?>

<h1>Tipo Fundamentos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
