<?php
/* @var $this PartidaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Partidas',
);

$this->menu=array(
	array('label'=>'Create Partida', 'url'=>array('create')),
	array('label'=>'Manage Partida', 'url'=>array('admin')),
);
?>

<h1>Partidas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
