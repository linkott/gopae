<?php
/* @var $this TipoSerialCuentaBancoController */
/* @var $model TipoSerialCuentaBanco */

$this->pageTitle = 'Registro de Tipo Serial Cuenta Bancos';

      $this->breadcrumbs=array(
	'Tipo Serial Cuenta Bancos'=>array('lista'),
	'Registro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'registro')); ?>