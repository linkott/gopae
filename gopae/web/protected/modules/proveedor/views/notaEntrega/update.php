<?php
/* @var $this OrdenCompraController */
/* @var $model OrdenCompra */

$this->breadcrumbs=array(
	'Orden Compras'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrdenCompra', 'url'=>array('index')),
	array('label'=>'Create OrdenCompra', 'url'=>array('create')),
	array('label'=>'View OrdenCompra', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrdenCompra', 'url'=>array('admin')),
);
?>

<h1>Update OrdenCompra <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>