<?php
/* @var $this OrdenCompraController */
/* @var $model OrdenCompra */

$this->breadcrumbs = array(
    'Planteles' => array('/planteles'),
    'Orden de Compra' => array('index'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#orden-compra-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>&Oacute;rdenes de Compra</h4>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">
                <div class="col-md-12" id="resultadoOperacion"></div>

                <div class="row">
                    <div class="col-md-3">
                        <?php
                        $mes = date("m") + 1;
                        if ($mes > 12) {
                            $mes = 1;
                        }
                        echo Chtml::dropDownList('mes', (int) date("m") + 1, Utiles::getMeses(), array('class' => 'span-7'))
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        if (Yii::app()->user->pbac('planteles.ordenCompra.write')):
                            ?>
                            <input type="hidden" name="id" id="id" value="<?php echo $_GET["id"]; ?>" />
                            <div class="pull-right" style="padding-left:10px;">
                                <a  type="submit" id="nuevaOrdenCompra" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                    <i class="fa fa-plus icon-on-right"></i>
                                    Registrar Nueva Orden de Compra
                                </a>

                            </div>

                            <?php
                        endif;
                        ?>
                    </div>
                </div>
                <div class="row" >
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'id' => 'orden-compra-grid',
                        'dataProvider' => $model->searchPorPlantel(base64_decode($_GET["id"])),
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
                                'header' => '<center>Codigo</center>',
                                'name' => 'codigo',
                            ),
                           
                            array(
                                'header' => '<center>Mes</center>',
                                'name' => 'mes',
                                'value' => array($this, 'mes'),
                                'filter' => Utiles::getMeses(),
                            ),
                            array(
                                'header' => '<center>Año</center>',
                                'name' => 'anio',
                            ),
                            array(
                                'header' => '<center>Fecha de Creación</center>',
                                'name' => 'fecha',
                            ),
                            array(
                                'header' => '<center>Elaborado Por</center>',
                                'name' => 'usuario_ini_id',
                                'value'=>'$data->usuarioIni->nombre." ".$data->usuarioIni->apellido'
                            ),
                            array(
                                'header' => '<center>Estatus</center>',
                                'name' => 'estatus',
                                'value' => array($this, 'estatus'),
                                'filter' => array('A' => 'Activo', 'E' => 'Inactivo'),
                            ),
                             array(
                                'class' => 'CLinkColumn',
                                'header' => '<center>PDF</center>',
                                'labelExpression' => '$data->codigo.".pdf"',
                                'urlExpression' => '"/planteles/ordenCompra/descargar/id/".base64_encode($data->codigo)'
                            ),
                            array(
                                'type' => 'raw',
                                'header' => '<center>Acciones</center>',
                                'value' => array($this, 'columnaAcciones'),
                                'htmlOptions' => array('width' => '5%'),
                            ),
                        ),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <a class="btn btn-danger" href="/planteles">
        <i class="icon-arrow-left bigger-110"></i>
        Volver
    </a>
</div>
<div><?php
                    $this->widget('ext.loading.LoadingWidget');
                    echo CHtml::scriptFile('/public/js/modules/plantel/ordenCompra.js');
                    ?>

</div>


<div id="dialogPantalla" class="hide"></div>
