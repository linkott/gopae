<?php
/* @var $this PlantelProveedorController */
/* @var $model PlantelProveedor */

$this->breadcrumbs=array(
	'Plantel Proveedors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PlantelProveedor', 'url'=>array('index')),
	array('label'=>'Create PlantelProveedor', 'url'=>array('create')),
	array('label'=>'View PlantelProveedor', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PlantelProveedor', 'url'=>array('admin')),
);
?>

<h1>Update PlantelProveedor <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>