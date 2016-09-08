<?php

/* @var $this TipoCargoNominalController */
/* @var $model TipoCargoNominal */

$this->breadcrumbs=array(
        'Catálogo' => array('/catalogo'),
	'Tipos de Cargo Nominales'=>array('lista'),
	'Administración',
);
$this->pageTitle = 'Administración de Tipos de Cargo Nominales';

?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Lista de Tipos de Cargo Nominales</h5>

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
                                En este módulo podrá registrar y/o actualizar los datos de Tipos de Cargo Nominales.
                            </p>
                        </div>
                    </div>

                    <div class="pull-right" style="padding-left:10px;">
                        <a href="<?php echo $this->createUrl("/catalogo/tipoCargoNominal/registro"); ?>" type="submit" id='newRegister' data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Nuevo Tipos de Cargo Nominales                        </a>
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
                    setUpEventsFilters();
                }",
	'columns'=>array(
            array(
                'header' => '<center>Código</center>',
                'name' => 'codigo',
                'htmlOptions' => array(),
                'filter' => CHtml::textField('TipoCargoNominal[codigo]', $model->codigo, array('title' => '',)),
            ),
            array(
                'header' => '<center>Nombre</center>',
                'name' => 'nombre',
                'htmlOptions' => array(),
                'filter' => CHtml::textField('TipoCargoNominal[nombre]', $model->nombre, array('title' => '',)),
            ),
            array(
                'header' => '<center>Siglas</center>',
                'name' => 'siglas',
                'htmlOptions' => array(),
                'filter' => CHtml::textField('TipoCargoNominal[siglas]', $model->siglas, array('title' => '',)),
            ),
            array(
                'header' => '<center>Condición de Ingreso</center>',
                'name' => 'condicion_id',
                'htmlOptions' => array(),
                'value' => '$data->condicion->nombre',
                'filter' => $listDataCondicionNominal,
            ),
            array(
                'header' => '<center>Estatus</center>',
                'name' => 'estatus',
                'htmlOptions' => array(),
                'value' => 'strtr($data->estatus,array("A"=>"Activo", "I"=>"Inactivo", "E"=>"Eliminado"))',
                'filter' => array('A' => 'Activo', 'I' => 'Inactivo', 'E' => 'Eliminado'),
            ),
            /*
            array(
                'header' => '<center>Id</center>',
                'name' => 'id',
                'htmlOptions' => array(),
                'filter' => CHtml::textField('TipoCargoNominal[id]', $model->id, array('title' => '',)),
            ),
            array(
                'header' => '<center>Descripcion</center>',
                'name' => 'descripcion',
                'htmlOptions' => array(),
                'filter' => CHtml::textField('TipoCargoNominal[descripcion]', $model->descripcion, array('title' => '',)),
            ),
            array(
                'header' => '<center>Funciones</center>',
                'name' => 'funciones',
                'htmlOptions' => array(),
                'filter' => CHtml::textField('TipoCargoNominal[funciones]', $model->funciones, array('title' => '',)),
            ),
            array(
                'header' => '<center>Usuario_ini_id</center>',
                'name' => 'usuario_ini_id',
                'htmlOptions' => array(),
                'filter' => CHtml::textField('TipoCargoNominal[usuario_ini_id]', $model->usuario_ini_id, array('title' => '',)),
            ),
            array(
                'header' => '<center>Fecha_ini</center>',
                'name' => 'fecha_ini',
                'htmlOptions' => array(),
                'filter' => CHtml::textField('TipoCargoNominal[fecha_ini]', $model->fecha_ini, array('title' => '',)),
            ),
            array(
                'header' => '<center>Usuario_act_id</center>',
                'name' => 'usuario_act_id',
                'htmlOptions' => array(),
                'filter' => CHtml::textField('TipoCargoNominal[usuario_act_id]', $model->usuario_act_id, array('title' => '',)),
            ),
            array(
                'header' => '<center>Fecha_act</center>',
                'name' => 'fecha_act',
                'htmlOptions' => array(),
                'filter' => CHtml::textField('TipoCargoNominal[fecha_act]', $model->fecha_act, array('title' => '',)),
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

<?php
    
    Yii::app()->clientScript->registerScriptFile(
        Yii::app()->request->baseUrl . '/public/js/modules/catalogo/tipoCargoNominal/admin.js', CClientScript::POS_END
    );
    
?>
