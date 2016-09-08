<?php
/* @var $this OrdenCompraController */
/* @var $model OrdenCompra */

$this->breadcrumbs=array(
        'Planteles'=>array('/planteles'),
	'Orden de Compra'=>array('/planteles/ordenCompra/index/id/'.$plantel_id),
	'Crear Nueva',
);

?>

<?php $this->renderPartial('_form', array('model'=>$model, 'plantel_id'=>$plantel_id, 'datos_plantel'=>$datos_plantel,'mes'=>$mes,'ano'=>$ano, 'estatus'=>$estatus)); ?>