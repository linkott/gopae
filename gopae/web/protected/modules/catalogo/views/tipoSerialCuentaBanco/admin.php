<?php

/* @var $this TipoSerialCuentaBancoController */
/* @var $model TipoSerialCuentaBanco */

$this->breadcrumbs=array(
	'Tipo Serial Cuenta Bancos'=>array('lista'),
	'Administración',
);
$this->pageTitle = 'Administración de Tipo Serial Cuenta Bancos';

?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Lista de Tipo Serial Cuenta Bancos</h5>

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
                                En este módulo podrá registrar y/o actualizar los datos de Tipo Serial Cuenta Bancos.
                            </p>
                        </div>
                    </div>

                    <div class="pull-right" style="padding-left:10px;">
                        <a href="<?php echo $this->createUrl("/catalogo/tipoSerialCuentaBanco/registro"); ?>" type="submit" id='newRegister' data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Nuevo Tipo Serial Cuenta Bancos                        </a>
                    </div>


                    <div class="row space-20"></div>

                </div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tipo-serial-cuenta-banco-grid',
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
            //'filter' => CHtml::textField('TipoSerialCuentaBanco[id]', $model->id, array('title' => '',)),
        ),
        array(
            'header' => '<center>banco_id</center>',
            'name' => 'banco_id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoSerialCuentaBanco[banco_id]', $model->banco_id, array('title' => '',)),
        ),
        array(
            'header' => '<center>tipo_serial_cuenta_id</center>',
            'name' => 'tipo_serial_cuenta_id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoSerialCuentaBanco[tipo_serial_cuenta_id]', $model->tipo_serial_cuenta_id, array('title' => '',)),
        ),
        array(
            'header' => '<center>serial</center>',
            'name' => 'serial',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoSerialCuentaBanco[serial]', $model->serial, array('title' => '',)),
        ),
        array(
            'header' => '<center>usuario_ini_id</center>',
            'name' => 'usuario_ini_id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoSerialCuentaBanco[usuario_ini_id]', $model->usuario_ini_id, array('title' => '',)),
        ),
        array(
            'header' => '<center>fecha_ini</center>',
            'name' => 'fecha_ini',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoSerialCuentaBanco[fecha_ini]', $model->fecha_ini, array('title' => '',)),
        ),
		/*
        array(
            'header' => '<center>usuario_act_id</center>',
            'name' => 'usuario_act_id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoSerialCuentaBanco[usuario_act_id]', $model->usuario_act_id, array('title' => '',)),
        ),
        array(
            'header' => '<center>fecha_act</center>',
            'name' => 'fecha_act',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoSerialCuentaBanco[fecha_act]', $model->fecha_act, array('title' => '',)),
        ),
        array(
            'header' => '<center>fecha_elim</center>',
            'name' => 'fecha_elim',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoSerialCuentaBanco[fecha_elim]', $model->fecha_elim, array('title' => '',)),
        ),
        array(
            'header' => '<center>estatus</center>',
            'name' => 'estatus',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoSerialCuentaBanco[estatus]', $model->estatus, array('title' => '',)),
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