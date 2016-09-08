<?php
/* @var $this NivelController */
/* @var $data Nivel */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modalidad_id')); ?>:</b>
	<?php echo CHtml::encode($data->modalidad_id); ?>
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

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_elim')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_elim); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estatus')); ?>:</b>
	<?php echo CHtml::encode($data->estatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('annio_semestre')); ?>:</b>
	<?php echo CHtml::encode($data->annio_semestre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->cantidad); ?>
	<br />

	*/ ?>

</div>