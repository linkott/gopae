<?php
/* @var $this TipoCuentaBancoController */
/* @var $model TipoCuentaBanco */

$this->pageTitle = 'Registro de Tipo Cuenta Bancos';

      $this->breadcrumbs=array(
	'Tipo Cuenta Bancos'=>array('lista'),
	'Registro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'registro')); ?>