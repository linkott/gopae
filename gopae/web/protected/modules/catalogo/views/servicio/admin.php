<?php
/* @var $this TipoFundamentoController */
/* @var $model TipoFundamento */

$this->breadcrumbs = array(
    'Catalogo' => array('/catalogo/servicio'),
    'Servicios',
);
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
?>
<div class="widget-main form" style="overflow:hidden;">
    <div class="widget-box">
        <div class="widget-header">
            <h4>Lista de Servicios</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="icon-chevron-up"></i>
                </a>
            </div>

        </div>

        <div class="widget-body">

            <div class="widget-main">
                <div class="row col-sm-12" id="resultadoOperacion"></div>
                <div class="row space-6"></div>
                <?php
                if (Yii::app()->user->pbac('catalogo.servicio.admin')):
                    ?>
                    <div class="pull-right" style="padding-left:10px;">
                        <a  type="submit" onclick="VentanaDialog('', '/catalogo/servicio/create', 'Servicio', 'create', '')" data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Servicio
                        </a>
                    </div>
                    <?php
                endif;
                ?>  <div class="row space-40"></div>
                <?php
                $columnas = array(
                    array(
                        'type' => 'raw',
                        'header' => '<center>Nombre del Servicio</center>',
                        'name' => 'nombre',
                    ),
                    array(
                        'header' => '<center> Estatus </center>',
                        'name' => 'estatus',
                        'filter' => array('A' => 'Activo', 'E' => 'Eliminado'),
                        'value' => array($this, 'estatus'),
                    ),
                    array(
                        'type' => 'raw',
                        'header' => '<center>Acción</center>',
                        'value' => array($this, 'columnaAcciones'),
                    ),
                );

                $this->widget('zii.widgets.grid.CGridView', array(
                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                    'id' => 'clase-plantel-grid',
                    'filter' => $model,
                    'dataProvider' => $model->search(),
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

                                        $('#date-picker').datepicker();
                                        $.datepicker.setDefaults($.datepicker.regional = {
                                                dateFormat: 'dd-mm-yy',
                                                showOn:'focus',
                                                showOtherMonths: false,
                                                selectOtherMonths: true,
                                                changeMonth: true,
                                                changeYear: true,
                                                minDate: new Date(1800, 1, 1),
                                                maxDate: 'today'
                                            });

                                        $('#Ticket_codigo').bind('keyup blur', function () {
                                            keyNum(this, false);
                                            clearField(this);
                                        });


                                        $('#Ticket_observacion').bind('keyup blur', function () {
                                            keyText(this, true);
                                        });

                                        $('#Ticket_observacion').bind('blur', function () {
                                            clearField(this);
                                        });
                                    }
                                ",
                    'columns' => $columnas,
                ));
                ?>
            </div><!-- search-form -->
        </div>

    </div>
</div>
<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<div id="dialogPantalla" class="hide"></div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catalogo/servicio.js', CClientScript::POS_END); ?>