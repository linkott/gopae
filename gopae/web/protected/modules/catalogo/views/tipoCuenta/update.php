<?php
/* @var $this TipoCuentaController */
/* @var $model TipoCuenta */

$this->pageTitle = 'Actualización de Datos de Tipo de Cuentas';

	$this->breadcrumbs=array(
    'Catálogo'=>array('/catalogo/'),
    'Tipos de Cuenta',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'edicion')); ?>