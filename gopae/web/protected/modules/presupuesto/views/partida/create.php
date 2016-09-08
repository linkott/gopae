<?php
/* @var $this PartidaController */
/* @var $model Partida */

$this->breadcrumbs=array(
	'Partidas'=>array('index'),
	'Nueva Partida',
);

?>
<?php $this->renderPartial('_form', array('model'=>$model ,'estatus'=>$estatus, 'estatusMod'=>$estatusMod)); ?>