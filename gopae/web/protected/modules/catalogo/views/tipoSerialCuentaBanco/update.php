<?php
/* @var $this TipoSerialCuentaBancoController */
/* @var $model TipoSerialCuentaBanco */

$this->pageTitle = 'Actualización de Datos de Tipo Serial Cuenta Bancos';

      $this->breadcrumbs=array(
	'Tipo Serial Cuenta Bancos'=>array('lista'),
	'Actualización',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'edicion')); ?>