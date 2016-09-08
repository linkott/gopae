<?php
/* @var $this PartidaController */
/* @var $model Partida */

$this->breadcrumbs=array(
	'Partidas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Partida', 'url'=>array('index')),
	array('label'=>'Create Partida', 'url'=>array('create')),
	array('label'=>'View Partida', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Partida', 'url'=>array('admin')),
);
?>

<h1>Update Partida <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>