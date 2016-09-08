<?php
/* @var $this MenuNutricionalController */
/* @var $model MenuNutricional */

$this->breadcrumbs=array(
	'Nota de Entrega'=>array('/proveedor/notaEntrega/index/id/'.$proveedor_id),
	'Despacho de Orden de Compra',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model, 'ordenCompra_id'=>$ordenCompra_id, 'datosOrdenCompra'=>$datosOrdenCompra,'estatus'=>$estatus,'proveedor_id'=>$proveedor_id)); ?>