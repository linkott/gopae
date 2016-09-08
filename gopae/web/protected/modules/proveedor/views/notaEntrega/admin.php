<?php
/* @var $this NotaEntregaController */
/* @var $model NotaEntrega */

$this->breadcrumbs = array(
    'Proveedor' => array('/proveedor/proveedor'),
    'Notas de Entrega',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#nota-entrega-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>Notas de Entrega</h4>

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

                <div class="row" >
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'id' => 'nota-entrega-grid',
                        'dataProvider' => $model->OrdenCompraProveedor(base64_decode($_GET["id"])),
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
                                'header' => '<center>Codigo Orden de Compra</center>',
                                'name' => 'codigo_orden',
                            ),
                            array(
                                'header' => '<center>Mes de la Orden de Compra</center>',
                                'name' => 'mes',
                                'value' => array($this, 'mes'),
                                'filter' => array(Utiles::getMeses()),
                            ),
                            array(
                                'header' => '<center>Año</center>',
                                'name' => 'anio',
                            ),
                            array(
                                'header' => '<center>Codigo Nota Entrega</center>',
                                'name' => 'codigo',
                                'value' => array($this, 'columnaCodigoNota'),
                            ),
                            array(
                                'header' => '<center>Elaborada Por</center>',
                                'name' => 'usuario',
                                'value' => array($this, 'columnaElaborada'),
                            ),
                            array(
                                'header' => '<center>Estatus de la Nota de Entrega</center>',
                                'name' => 'estatus_nota_entrega',
                                'value' => array($this, 'columnaEstatusNota'),
                            ),
                            array(
                                'class' => 'CLinkColumn',
                                'header' => '<center>PDF</center>',
                                'labelExpression' => array($this, 'columnaPDF'),
                                'urlExpression' =>  array($this, 'columnaPDFLink')
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
                    echo CHtml::scriptFile('/public/js/modules/proveedor/notaEntrega.js');
                    ?>

</div>


<div id="dialogPantalla" class="hide"></div>
