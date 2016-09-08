<?php
/* @var $this TipoCuentaBancoController */
/* @var $model TipoCuentaBanco */

$this->pageTitle = 'Actualización de Datos de Tipo Cuenta Bancos';

      $this->breadcrumbs=array(
	'Tipo Cuenta Bancos'=>array('lista'),
	'Actualización',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'edicion')); ?>