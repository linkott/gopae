<?php
/* @var $this OrdenCompraController */
/* @var $model OrdenCompra */

$this->breadcrumbs=array(

        'Planteles'=>array('/planteles'),
	'Orden de Compra'=>array('/planteles/ordenCompra/index/id/'.  base64_encode($model->dependencia) ),
	'Modificar Orden',

);

?>


<?php $this->renderPartial('_form_update', array('model'=>$model, 'estatus'=>$estatus, 'datos_plantel'=>$datos_plantel)); ?>