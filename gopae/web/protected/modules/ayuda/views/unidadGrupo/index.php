<?php
/* @var $this UnidadGrupoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Unidad Grupos',
);

$this->menu=array(
	array('label'=>'Create UnidadGrupo', 'url'=>array('create')),
	array('label'=>'Manage UnidadGrupo', 'url'=>array('admin')),
);
?>

<h1>Unidad Grupos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
