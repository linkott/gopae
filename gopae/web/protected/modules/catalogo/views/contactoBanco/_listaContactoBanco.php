<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contacto-banco-grid',
	'dataProvider'=>$dataProvider,
        'filter'=>$model,
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'summaryText' => 'Mostrando {start}-{end} de {count}',
        'pager' => array(
            'header' => '',
            'htmlOptions' => array('class' => 'pagination'),
            'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
            'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
            'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
            'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
        ),
        'afterAjaxUpdate' => "
                function(){
                    
                }",
	'columns'=>array(
        array(
            'header' => '<center>Nombre completo</center>',
            'name' => 'nombre_apellido',
            'htmlOptions' => array(),
            'filter' => CHtml::textField('ContactoBanco[nombre_apellido]', $model->nombre_apellido, array('title' => '', "id"=>"ContactoBanco_nombre_apellido_form",)),             
        ),
        array(
            'header' => '<center>Cargo</center>',
            'name' => 'identificador',
            'htmlOptions' => array(),
            'filter' => CHtml::textField('ContactoBanco[identificador]', $model->identificador, array('title' => '', "id"=>"ContactoBanco_identificador_form",)),
        ),
        array(
            'header' => '<center>Correo Electronico</center>',
            'name' => 'correo',
            'htmlOptions' => array(),
            'filter' => CHtml::textField('ContactoBanco[correo]', $model->correo, array('title' => '', "id"=>"ContactoBanco_correo_form",)),
        ),
        array(
            'header' => '<center>Telefono fijo</center>',
            'name' => 'telefono_fijo',
            'htmlOptions' => array(),
            'filter' => CHtml::textField('ContactoBanco[telefono_fijo]', $model->telefono_fijo, array('title' => '', "id"=>"ContactoBanco_telefono_fijo_form",)),
        ),
		
		array(
                    'type' => 'raw',
                    'header' => '<center>Acción</center>',
                    'value' => array($this, 'getActionButtons'),
                    'htmlOptions' => array('nowrap'=>'nowrap'),
                ),
	),
)); ?>


