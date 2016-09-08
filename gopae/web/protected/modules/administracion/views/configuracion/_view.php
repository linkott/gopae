<?php
/* @var $this ConfiguracionController */
/* @var $data Configuracion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cod_tipo_dato')); ?>:</b>
	<?php echo CHtml::encode($data->cod_tipo_dato); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_bool')); ?>:</b>
	<?php echo CHtml::encode($data->valor_bool); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_cod')); ?>:</b>
	<?php echo CHtml::encode($data->valor_cod); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_str')); ?>:</b>
	<?php echo CHtml::encode($data->valor_str); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_lstr')); ?>:</b>
	<?php echo CHtml::encode($data->valor_lstr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_txt')); ?>:</b>
	<?php echo CHtml::encode($data->valor_txt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_int')); ?>:</b>
	<?php echo CHtml::encode($data->valor_int); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_date')); ?>:</b>
	<?php echo CHtml::encode($data->valor_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_ini_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_ini_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_act_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_act_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_ini')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_ini); ?>
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