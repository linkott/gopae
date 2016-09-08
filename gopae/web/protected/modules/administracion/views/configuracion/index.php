<?php
/* @var $this ConfiguracionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Configuracions',
);

$this->menu=array(
	array('label'=>'Create Configuracion', 'url'=>array('create')),
	array('label'=>'Manage Configuracion', 'url'=>array('admin')),
);
?>

<h1>Configuracions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
