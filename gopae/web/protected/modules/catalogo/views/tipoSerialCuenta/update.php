<?php
/* @var $this TipoSerialCuentaController */
/* @var $model TipoSerialCuenta */

$this->pageTitle = 'Actualización de Datos de Tipo Serial Cuentas';

$this->breadcrumbs=array(
    'Catálogo'=>array('/catalogo/'),
    //ucwords($this->id)
    'Tipo de Serial de Cuenta',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'edicion')); ?>