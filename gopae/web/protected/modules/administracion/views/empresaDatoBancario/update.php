<?php
/* @var $this EmpresaDatoBancarioController */
/* @var $model EmpresaDatoBancario */

$this->pageTitle = 'Actualización de Datos de Empresa Dato Bancarios';

      $this->breadcrumbs=array(
	'Empresa Dato Bancarios'=>array('lista'),
	'Actualización',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'edicion')); ?>