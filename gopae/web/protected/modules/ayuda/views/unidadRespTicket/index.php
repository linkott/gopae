<?php
/* @var $this UnidadRespTicketController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Unidad Resp Tickets',
);

$this->menu=array(
	array('label'=>'Create UnidadRespTicket', 'url'=>array('create')),
	array('label'=>'Manage UnidadRespTicket', 'url'=>array('admin')),
);
?>

<h1>Unidad Resp Tickets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
