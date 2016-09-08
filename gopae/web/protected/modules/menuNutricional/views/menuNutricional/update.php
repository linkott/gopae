<?php
/* @var $this MenuNutricionalController */
/* @var $model MenuNutricional */

$this->breadcrumbs=array(
	'Menús Nutricionales'=>array('index'),
	'Modificar Menú'
);

$this->renderPartial('_form', array('model'=>$model, 'estatus'=>$estatus, 'estatusMod'=>$estatusMod,'modelAlimento' => $modelAlimento)); 
?>