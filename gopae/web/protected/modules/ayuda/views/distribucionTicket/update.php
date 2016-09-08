<?php
/* @var $this DistribucionTicketController */
/* @var $model DistribucionTicket */

$this->breadcrumbs=array(
	'Distribucion Tickets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DistribucionTicket', 'url'=>array('index')),
	array('label'=>'Create DistribucionTicket', 'url'=>array('create')),
	array('label'=>'View DistribucionTicket', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DistribucionTicket', 'url'=>array('admin')),
);
?>

<h1>Update DistribucionTicket <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>