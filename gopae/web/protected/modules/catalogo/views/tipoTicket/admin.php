<?php
/* @var $this TipoFundamentoController */
/* @var $model TipoFundamento */

$this->breadcrumbs = array(
    'Tipo de Ticket' => array('/gmanual/tipoTicket'),
    'Ticket',
);
/*
  $this->menu=array(
  array('label'=>'List TipoFundamento', 'url'=>array('index')),
  array('label'=>'Create TipoFundamento', 'url'=>array('create')),
  );
 */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tipo-fundamento-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
echo CHtml::scriptFile('/public/js/modules/catalogo/tipo_ticket.js');
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>Tipo de Ticket</h4>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">
                <div class="row col-sm-8" id="resultadoOperacion"></div>
                <div class="row space-6"></div>
                <div>
                    <?php
                    if (($groupId == 1) || ($groupId == 18)) {
                        ?>
                        <div class="pull-right" style="padding-left:10px;">
                            <a  type="submit" onclick="VentanaDialog('', '/catalogo/tipoTicket/create', 'tipoTicket', 'create', '')" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                <i class="fa fa-plus icon-on-right"></i>
                                Registrar Tipo De Ticket
                            </a>

                        </div>

                        <?php
                    }
                    ?>

                    <div class="row space-40"></div>

                </div><!-- search-form -->
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                    'id' => 'clase-plantel-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'summaryText' => false,
                    'pager' => array(
                        'header' => '',
                        'htmlOptions' => array('class' => 'pagination'),
                        'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                        'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                        'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                        'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                    ),
                    'columns' => array(
                        array(
                            'header' => '<center>Descripcion</center>',
                            'name' => 'nombre',
                        ),
                        array(
                            'header' => '<center title="Unidad Responsable del Ticket">Unidad Resp.</center>',
                            'name' => 'unidad_resp_ticket_id',
                                'value' => '(is_object($data->unidadResponsable))?$data->unidadResponsable->nombre:""',
                                'filter' => CHtml::listData(
                                        UnidadRespTicket::model()->findAll(
                                        ), 'id', 'nombre'
                                ),
                        ),
                        array(
                            'header' => '<center> Estatus </center>',
                            'name' => 'estatus',
                            'filter' => array('A' => 'Activo', 'E' => 'Inactivo', 'R' => 'Resuelto'),
                            'value' => array($this, 'estatus'),
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Acción</center>',
                            'value' => array($this, 'columnaAcciones'),
                        ),
                    ),
                ));
                ?>
            </div>

        </div>

    </div>

    <div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>


    <div id="dialogPantalla" class="hide"></div>

<?php /* $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$dataProvider,
  'itemView'=>'_view',
  )); */ ?>

