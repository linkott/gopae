<?php
/* @var $this EmpresaDatoBancarioController */
/* @var $model EmpresaDatoBancario */

$this->pageTitle = 'Registro de Empresa Dato Bancarios';

      $this->breadcrumbs=array(
	'Empresa Dato Bancarios'=>array('lista'),
	'Registro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'registro')); ?>