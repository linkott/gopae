<?php
/* @var $this ProveedorController */
/* @var $model Proveedor */
$this->pageTitle = 'Registro de Proveedores';
$this->breadcrumbs=array(
	'Proveedores'=>array('index'),
	'Registrar Nuevo',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model ,'estatus'=>$estatus, 'estatusMod'=>$estatusMod)); ?>