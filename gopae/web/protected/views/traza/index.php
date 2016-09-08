<?php
$this->breadcrumbs=array(
	'Trazas',
);

//$this->menu=array(
	//array('label'=>'Create Traza', 'url'=>array('create')),
//	array('label'=>'Manage Traza', 'url'=>array('admin')),
//);
?>

<h1>Trazas de Auditoria</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
