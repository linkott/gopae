<?php

/* @var $this ContactoBancoController */
/* @var $model ContactoBanco */

$this->breadcrumbs=array(
	'Contacto Bancos'=>array('lista'),
	'Administración',
);
$this->pageTitle = 'Administración de Contacto Bancos';

?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Lista de Contacto Bancos</h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">

                <div class="row space-6"></div>
                <div>
                    <div id="resultadoOperacion">
                        <div class="infoDialogBox">
                            <p>
                                En este módulo podrá registrar y/o actualizar los datos de Contacto Bancos.
                            </p>
                        </div>
                    </div>

                    <div class="pull-right" style="padding-left:10px;">
                        <a href="<?php echo $this->createUrl("/test/contactoBanco/registro"); ?>" type="submit" id='newRegister' data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Nuevo Contacto Bancos                        </a>
                    </div>


                    <div class="row space-20"></div>

                </div>

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
            'header' => '<center>id</center>',
            'name' => 'id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[id]', $model->id, array('title' => '',)),
        ),
        array(
            'header' => '<center>banco_id</center>',
            'name' => 'banco_id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[banco_id]', $model->banco_id, array('title' => '',)),
        ),
        array(
            'header' => '<center>nombre_apellido</center>',
            'name' => 'nombre_apellido',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[nombre_apellido]', $model->nombre_apellido, array('title' => '',)),
        ),
        array(
            'header' => '<center>telefono_fijo</center>',
            'name' => 'telefono_fijo',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[telefono_fijo]', $model->telefono_fijo, array('title' => '',)),
        ),
        array(
            'header' => '<center>telefono_fax</center>',
            'name' => 'telefono_fax',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[telefono_fax]', $model->telefono_fax, array('title' => '',)),
        ),
        array(
            'header' => '<center>telefono_celular</center>',
            'name' => 'telefono_celular',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[telefono_celular]', $model->telefono_celular, array('title' => '',)),
        ),
		/*
        array(
            'header' => '<center>identificador</center>',
            'name' => 'identificador',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[identificador]', $model->identificador, array('title' => '',)),
        ),
        array(
            'header' => '<center>observaciones</center>',
            'name' => 'observaciones',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[observaciones]', $model->observaciones, array('title' => '',)),
        ),
        array(
            'header' => '<center>usuario_ini_id</center>',
            'name' => 'usuario_ini_id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[usuario_ini_id]', $model->usuario_ini_id, array('title' => '',)),
        ),
        array(
            'header' => '<center>fecha_ini</center>',
            'name' => 'fecha_ini',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[fecha_ini]', $model->fecha_ini, array('title' => '',)),
        ),
        array(
            'header' => '<center>usuario_act_id</center>',
            'name' => 'usuario_act_id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[usuario_act_id]', $model->usuario_act_id, array('title' => '',)),
        ),
        array(
            'header' => '<center>fecha_act</center>',
            'name' => 'fecha_act',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[fecha_act]', $model->fecha_act, array('title' => '',)),
        ),
        array(
            'header' => '<center>fecha_elim</center>',
            'name' => 'fecha_elim',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[fecha_elim]', $model->fecha_elim, array('title' => '',)),
        ),
        array(
            'header' => '<center>estatus</center>',
            'name' => 'estatus',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('ContactoBanco[estatus]', $model->estatus, array('title' => '',)),
        ),
		*/
		array(
                    'type' => 'raw',
                    'header' => '<center>Acción</center>',
                    'value' => array($this, 'getActionButtons'),
                    'htmlOptions' => array('nowrap'=>'nowrap'),
                ),
	),
)); ?>
            </div>
        </div>
    </div>
</div>