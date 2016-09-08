<?php
/* @var $this OrdenCompraController */
/* @var $data OrdenCompra */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::encode($data->codigo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dias_habiles')); ?>:</b>
	<?php echo CHtml::encode($data->dias_habiles); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dependencia')); ?>:</b>
	<?php echo CHtml::encode($data->dependencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proveedor_id')); ?>:</b>
	<?php echo CHtml::encode($data->proveedor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unidad_administradora')); ?>:</b>
	<?php echo CHtml::encode($data->unidad_administradora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unidad_ejecutora_local')); ?>:</b>
	<?php echo CHtml::encode($data->unidad_ejecutora_local); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lugar_compra')); ?>:</b>
	<?php echo CHtml::encode($data->lugar_compra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('forma_pago_id')); ?>:</b>
	<?php echo CHtml::encode($data->forma_pago_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('condicion_compra_id')); ?>:</b>
	<?php echo CHtml::encode($data->condicion_compra_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lugar_entrega')); ?>:</b>
	<?php echo CHtml::encode($data->lugar_entrega); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('moneda_extranjera_id')); ?>:</b>
	<?php echo CHtml::encode($data->moneda_extranjera_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anticipo')); ?>:</b>
	<?php echo CHtml::encode($data->anticipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firma_elaboracion')); ?>:</b>
	<?php echo CHtml::encode($data->firma_elaboracion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firma_revision')); ?>:</b>
	<?php echo CHtml::encode($data->firma_revision); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firma_aprobacion')); ?>:</b>
	<?php echo CHtml::encode($data->firma_aprobacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firma_autorizacion')); ?>:</b>
	<?php echo CHtml::encode($data->firma_autorizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_ini_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_ini_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_ini')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_ini); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_act_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_act_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_act')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_act); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_elim')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_elim); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estatus')); ?>:</b>
	<?php echo CHtml::encode($data->estatus); ?>
	<br />

	*/ ?>

</div>