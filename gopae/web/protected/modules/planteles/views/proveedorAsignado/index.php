<?php
/* @var $this PlantelProveedorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Plantel Proveedors',
);

$this->menu=array(
	array('label'=>'Create PlantelProveedor', 'url'=>array('create')),
	array('label'=>'Manage PlantelProveedor', 'url'=>array('admin')),
);
?>

<h1>Plantel Proveedors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
