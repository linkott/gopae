<?php
/* @var $this ProveedorController */
/* @var $model Proveedor */

$this->pageTitle = "Proveedores";

$this->breadcrumbs=array(
	'Proveedores',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#proveedor-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Proveedores</h5>

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
                    if (Yii::app()->user->pbac('proveedor.proveedor.write') or Yii::app()->user->pbac('proveedor.proveedor.admin')):
                        ?>
                        <div class="pull-right" style="padding-left:10px;">
                            <a  type="submit" href="/proveedor/proveedor/create" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                <i class="fa fa-plus icon-on-right"></i>
                                Registrar un Proveedor
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
                        'id' => 'proveedor-grid',
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
                                'header' => '<center>Rif</center>',
                                'name' => 'rif',
                                'htmlOptions' => array('width' => '15%'),
                            ),
                            array(
                                'header' => '<center>Nombre</center>',
                                'name' => 'razon_social',
                            ),
                            array(
                                'header' => '<center>Estado</center>',
                                'name' => 'estado_id',
                                'value' => '$data->estado->nombre',
                                'filter' => CHtml::listData(CEstado::getData(), 'id', 'nombre'),
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

<div><?php $this->widget('ext.loading.LoadingWidget');
echo CHtml::scriptFile('/public/js/modules/proveedor/proveedor.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);

?>

</div>


<div id="dialogPantalla" class="hide"></div>