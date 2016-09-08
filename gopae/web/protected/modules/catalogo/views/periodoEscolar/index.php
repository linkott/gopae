<?php
/* @var $this MencionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Clase de Periodo Escolar'=>array('admin'),
);

$this->menu=array(
	array('label'=>'Create Mencion', 'url'=>array('create')),
	array('label'=>'Manage Mencion', 'url'=>array('admin')),
);
?>

<h1>Mencions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>