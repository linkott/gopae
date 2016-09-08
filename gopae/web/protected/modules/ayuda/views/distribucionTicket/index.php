<?php
/* @var $this DistribucionTicketController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Distribucion Tickets',
);

$this->menu=array(
	array('label'=>'Create DistribucionTicket', 'url'=>array('create')),
	array('label'=>'Manage DistribucionTicket', 'url'=>array('admin')),
);
?>

<h1>Distribucion Tickets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
