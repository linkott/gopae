<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->pageTitle = 'Actualización de Datos de Empresas';

      $this->breadcrumbs=array(
	'Empresas'=>array('lista'),
	'Actualización',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'edicion')); ?>