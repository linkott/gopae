<?php
/* @var $this MenuNutricionalController */
/* @var $model MenuNutricional */

$this->breadcrumbs=array(
	'Menús Nutricionales'=>array('/menuNutricional/menuNutricional/'),
	'Nuevo Menú',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'estatus'=>$estatus, 'estatusMod'=>$estatusMod)); ?>