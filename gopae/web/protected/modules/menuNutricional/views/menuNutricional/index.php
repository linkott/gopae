<?php
/* @var $this MenuNutricionalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Menu Nutricionals',
);

$this->menu=array(
	array('label'=>'Create MenuNutricional', 'url'=>array('create')),
	array('label'=>'Manage MenuNutricional', 'url'=>array('admin')),
);
?>

<h1>Menu Nutricionals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
