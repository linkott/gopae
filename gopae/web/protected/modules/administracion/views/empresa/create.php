<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->pageTitle = 'Registro de Empresas';

      $this->breadcrumbs=array(
	'Empresas'=>array('lista'),
	'Registro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'registro')); ?>