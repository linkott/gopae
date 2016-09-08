<?php
/* @var $this UnidadGrupoController */
/* @var $model UnidadGrupo */

$this->breadcrumbs=array(
	'Unidad Grupos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UnidadGrupo', 'url'=>array('index')),
	array('label'=>'Create UnidadGrupo', 'url'=>array('create')),
	array('label'=>'View UnidadGrupo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UnidadGrupo', 'url'=>array('admin')),
);
?>

<h1>Update UnidadGrupo <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>