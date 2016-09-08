<?php
/* @var $this UnidadRespTicketController */
/* @var $data UnidadRespTicket */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('correo_unidad')); ?>:</b>
	<?php echo CHtml::encode($data->correo_unidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_ini_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_ini_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_act_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_act_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono_unidad')); ?>:</b>
	<?php echo CHtml::encode($data->telefono_unidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('correo_persona')); ?>:</b>
	<?php echo CHtml::encode($data->correo_persona); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono_persona')); ?>:</b>
	<?php echo CHtml::encode($data->telefono_persona); ?>
	<br />

	*/ ?>

</div>