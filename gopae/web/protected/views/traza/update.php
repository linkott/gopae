<?php
$this->breadcrumbs=array(
	'Trazas'=>array('index'),
	$model->id_traza=>array('view','id'=>$model->id_traza),
	'Update',
);

$this->menu=array(
	array('label'=>'Listar Trazas', 'url'=>array('index')),
	array('label'=>'Create Traza', 'url'=>array('create')),
	array('label'=>'Ver Traza', 'url'=>array('view', 'id'=>$model->id_traza)),
	array('label'=>'Administrar Trazas', 'url'=>array('admin')),
);
?>

<h1>Update Traza <?php echo $model->id_traza; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
