<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_traza')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_traza), array('view', 'id'=>$data->id_traza)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_hora')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_hora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_maquina')); ?>:</b>
	<?php echo CHtml::encode($data->ip_maquina); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_transaccion')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_transaccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modulo')); ?>:</b>
	<?php echo CHtml::encode($data->modulo); ?>
	<br />


</div>