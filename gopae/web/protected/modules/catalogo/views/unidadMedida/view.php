

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'usuario_ini_id',
		'fecha_ini',
		'usuario_act_id',
		'fecha_act',
		'fecha_elim',
		'estatus',
                'siglas',
	),
)); ?>
