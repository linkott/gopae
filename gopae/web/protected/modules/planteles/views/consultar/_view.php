<?php
/* @var $this ConsultarController */
/* @var $data Plantel */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cod_estadistico')); ?>:</b>
	<?php echo CHtml::encode($data->cod_estadistico); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cod_plantel')); ?>:</b>
	<?php echo CHtml::encode($data->cod_plantel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('planta_fisica_id')); ?>:</b>
	<?php echo CHtml::encode($data->planta_fisica_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('denominacion_id')); ?>:</b>
	<?php echo CHtml::encode($data->denominacion_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_dependencia_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_dependencia_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('estado_id')); ?>:</b>
	<?php echo CHtml::encode($data->estado_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('municipio_id')); ?>:</b>
	<?php echo CHtml::encode($data->municipio_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parroquia_id')); ?>:</b>
	<?php echo CHtml::encode($data->parroquia_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('localidad_id')); ?>:</b>
	<?php echo CHtml::encode($data->localidad_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('direccion')); ?>:</b>
	<?php echo CHtml::encode($data->direccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('distrito_id')); ?>:</b>
	<?php echo CHtml::encode($data->distrito_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zona_educativa_id')); ?>:</b>
	<?php echo CHtml::encode($data->zona_educativa_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modalidad_id')); ?>:</b>
	<?php echo CHtml::encode($data->modalidad_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nivel_id')); ?>:</b>
	<?php echo CHtml::encode($data->nivel_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('condicion_estudio_id')); ?>:</b>
	<?php echo CHtml::encode($data->condicion_estudio_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('correo')); ?>:</b>
	<?php echo CHtml::encode($data->correo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono_fijo')); ?>:</b>
	<?php echo CHtml::encode($data->telefono_fijo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono_otro')); ?>:</b>
	<?php echo CHtml::encode($data->telefono_otro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('director_actual_id')); ?>:</b>
	<?php echo CHtml::encode($data->director_actual_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('director_supl_actual_id')); ?>:</b>
	<?php echo CHtml::encode($data->director_supl_actual_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subdirector_actual_id')); ?>:</b>
	<?php echo CHtml::encode($data->subdirector_actual_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subdirector_supl_actual_id')); ?>:</b>
	<?php echo CHtml::encode($data->subdirector_supl_actual_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coordinador_actual_id')); ?>:</b>
	<?php echo CHtml::encode($data->coordinador_actual_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coordinador_supl_actual_id')); ?>:</b>
	<?php echo CHtml::encode($data->coordinador_supl_actual_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clase_plantel_id')); ?>:</b>
	<?php echo CHtml::encode($data->clase_plantel_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('condicion_infra_id')); ?>:</b>
	<?php echo CHtml::encode($data->condicion_infra_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('categoria_id')); ?>:</b>
	<?php echo CHtml::encode($data->categoria_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('regimen_id')); ?>:</b>
	<?php echo CHtml::encode($data->regimen_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('posee_electricidad')); ?>:</b>
	<?php echo CHtml::encode($data->posee_electricidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('posee_edificacion')); ?>:</b>
	<?php echo CHtml::encode($data->posee_edificacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logo')); ?>:</b>
	<?php echo CHtml::encode($data->logo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observacion')); ?>:</b>
	<?php echo CHtml::encode($data->observacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('es_tecnica')); ?>:</b>
	<?php echo CHtml::encode($data->es_tecnica); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('especialidad_tec_id')); ?>:</b>
	<?php echo CHtml::encode($data->especialidad_tec_id); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('estatus_plantel_id')); ?>:</b>
	<?php echo CHtml::encode($data->estatus_plantel_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('latitud')); ?>:</b>
	<?php echo CHtml::encode($data->latitud); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('longitud')); ?>:</b>
	<?php echo CHtml::encode($data->longitud); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('annio_fundado')); ?>:</b>
	<?php echo CHtml::encode($data->annio_fundado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('turno_id')); ?>:</b>
	<?php echo CHtml::encode($data->turno_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('genero_id')); ?>:</b>
	<?php echo CHtml::encode($data->genero_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_ubicacion_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_ubicacion_id); ?>
	<br />

	*/ ?>

</div>