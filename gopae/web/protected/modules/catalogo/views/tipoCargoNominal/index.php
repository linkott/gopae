<?php

/* @var $this TipoCargoNominalController */
/* @var $model TipoCargoNominal */

$this->breadcrumbs=array(
	'Catálogo' => array('/catalogo'),
	'Tipos de Cargo Nominales'=>array('lista'),
);
$this->pageTitle = 'Administración de Tipo Cargo Nominals';

?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Lista de Tipo Cargo Nominals</h5>

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
                                En este módulo podrá registrar y/o actualizar los datos de Tipo Cargo Nominals.
                            </p>
                        </div>
                    </div>

                    <div class="pull-right" style="padding-left:10px;">
                        <a href="<?php echo $this->createUrl("/catalogo/tipoCargoNominal/registro"); ?>" type="submit" id='newRegister' data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Nuevo Tipo Cargo Nominals                        </a>
                    </div>


                    <div class="row space-20"></div>

                </div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tipo-cargo-nominal-grid',
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
            //'filter' => CHtml::textField('TipoCargoNominal[id]', $model->id, array('title' => '',)),
        ),
        array(
            'header' => '<center>codigo</center>',
            'name' => 'codigo',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[codigo]', $model->codigo, array('title' => '',)),
        ),
        array(
            'header' => '<center>nombre</center>',
            'name' => 'nombre',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[nombre]', $model->nombre, array('title' => '',)),
        ),
        array(
            'header' => '<center>siglas</center>',
            'name' => 'siglas',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[siglas]', $model->siglas, array('title' => '',)),
        ),
        array(
            'header' => '<center>descripcion</center>',
            'name' => 'descripcion',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[descripcion]', $model->descripcion, array('title' => '',)),
        ),
        array(
            'header' => '<center>funciones</center>',
            'name' => 'funciones',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[funciones]', $model->funciones, array('title' => '',)),
        ),
		/*
        array(
            'header' => '<center>condicion_id</center>',
            'name' => 'condicion_id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[condicion_id]', $model->condicion_id, array('title' => '',)),
        ),
        array(
            'header' => '<center>usuario_ini_id</center>',
            'name' => 'usuario_ini_id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[usuario_ini_id]', $model->usuario_ini_id, array('title' => '',)),
        ),
        array(
            'header' => '<center>fecha_ini</center>',
            'name' => 'fecha_ini',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[fecha_ini]', $model->fecha_ini, array('title' => '',)),
        ),
        array(
            'header' => '<center>usuario_act_id</center>',
            'name' => 'usuario_act_id',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[usuario_act_id]', $model->usuario_act_id, array('title' => '',)),
        ),
        array(
            'header' => '<center>fecha_act</center>',
            'name' => 'fecha_act',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[fecha_act]', $model->fecha_act, array('title' => '',)),
        ),
        array(
            'header' => '<center>estatus</center>',
            'name' => 'estatus',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('TipoCargoNominal[estatus]', $model->estatus, array('title' => '',)),
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
