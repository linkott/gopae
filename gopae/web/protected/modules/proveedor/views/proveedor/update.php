<?php

/* @var $this ProveedorController */
/* @var $model Proveedor */
$this->pageTitle = 'Editar Datos de Proveedor';
$this->breadcrumbs = array(
    'Proveedores' => array('/proveedor/proveedor/'),
    'Modificar Proveedor',
);
?>

<?php

$this->renderPartial('_form', array(
    'model' => $model,
    'modelSocio' => $modelSocio,
    'modelDocumento' => $modelDocumento,
    'modelZona'=>$modelZona,
    'proveedor_id' => $proveedor_id,
    'estatus' => $estatus,
    'estatusMod' => $estatusMod
));
?>