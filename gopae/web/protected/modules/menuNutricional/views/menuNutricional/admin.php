<?php
/* @var $this MenuNutricionalController */
/* @var $model MenuNutricional */

$this->pageTitle = 'Menús Nutricionales';
$this->breadcrumbs=array(
	'Menú Nutricional',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#menu-nutricional-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Menús Nutricionales</h5>

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
                    if (Yii::app()->user->pbac('menuNutricional.menuNutricional.write') or Yii::app()->user->pbac('menuNutricional.menuNutricional.admin')):
                        ?>
                        <div class="pull-right" style="padding-left:10px;">
                            <a  type="submit" href="/menuNutricional/menuNutricional/create" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                <i class="fa fa-plus icon-on-right"></i>
                                Registrar un Menú Nutricional
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
                        'id' => 'menu-grid',
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
                                'header' => '<center>Precio Baremo</center>',
                                'name' => 'precio_baremo',
                                'value' => array($this, 'columnaPrecioBaremo'),
                                'htmlOptions' => array('width' => '10%'),

                            ),
                            array(
                                'header' => '<center>Precio Mercado</center>',
                                'name' => 'precio_mercado',
                                'value' => array($this, 'columnaPrecioMercado'),
                                'htmlOptions' => array('width' => '10%'),

                            ),
                            array(
                                'header' => '<center>Tipo de menú</center>',
                                'name' => 'tipo_menu',
                                'value' => '$data->tipoMenu->nombre',
                                'htmlOptions' => array('width' => '10%'),
                                'filter' => CHtml::listData(
                                        TipoMenu::model()->findAll(
                                                array(
                                                    'condition' => "estatus = 'A'",
                                                    'order' => 'nombre ASC'
                                                )
                                        ), 'id', 'nombre'
                                ),

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
                            )
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
echo CHtml::scriptFile('/public/js/modules/menuNutricional/menuNutricional.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);

?>

</div>


<div id="dialogPantalla" class="hide"></div>