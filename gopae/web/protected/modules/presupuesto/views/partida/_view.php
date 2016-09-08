<?php
/* @var $this PartidaController */
/* @var $data Partida */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::encode($data->codigo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('permite_partida_aux')); ?>:</b>
	<?php echo CHtml::encode($data->permite_partida_aux); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admite_transferencia')); ?>:</b>
	<?php echo CHtml::encode($data->admite_transferencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('permite_asientos')); ?>:</b>
	<?php echo CHtml::encode($data->permite_asientos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_saldo_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_saldo_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_gasto_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_gasto_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_partida_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_partida_id); ?>
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