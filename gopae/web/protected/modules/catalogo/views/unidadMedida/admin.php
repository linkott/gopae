<?php
/* @var $this UnidadMedidaController */
/* @var $model UnidadMedida */

$this->breadcrumbs = array(
    'Catalogo' => array('/catalogo'),
    'Unidades de Medida',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#unidad-medida-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Unidades de Medida</h5>

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
                    <?php
                    if (Yii::app()->user->pbac('catalogo.UnidadMedida.write') or Yii::app()->user->pbac('catalogo.UnidadMedida.admin')):
                        ?>
                        <div class="pull-right" style="padding-left:10px;">
                            <a  type="submit" onclick="VentanaDialog('', '/catalogo/unidadMedida/create', 'Unidad de medida', 'create', '')" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                <i class="fa fa-plus icon-on-right"></i>
                                Registrar Nueva Unidad de medida
                            </a>

                        </div>

                        <?php
                    endif;
                    ?>
                </div>
                <div class="row" >
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'id' => 'unidad-medida-grid',
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
                                'header' => '<center>Nombre</center>',
                                'name' => 'nombre',
                            ),
                            array(
                                'header' => '<center>Siglas</center>',
                                'name' => 'siglas',
                                'htmlOptions' => array('width' => '20%'),
                            ),                           
                            array(
                                'header' => '<center>Estatus</center>',
                                'name' => 'estatus',
                                'value' => array($this, 'estatus'),
                                'filter' => array('A' => 'Activo', 'E' => 'Inactivo'),
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
    <a class="btn btn-danger" href="/catalogo">
        <i class="icon-arrow-left bigger-110"></i>
        Volver
    </a>
</div>
<div><?php $this->widget('ext.loading.LoadingWidget');
echo CHtml::scriptFile('/public/js/modules/catalogo/unidadMedida.js');
?>

</div>


<div id="dialogPantalla" class="hide"></div>