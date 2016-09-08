<?php
/* @var $this PartidaController */
/* @var $model Partida */

$this->breadcrumbs=array(
	'Presupuesto'=>array('/presupuesto/'),
	'Partidas',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#partida-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>Partidas Presupuestarias</h4>

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
                    if (Yii::app()->user->pbac('presupuesto.partida.write') or Yii::app()->user->pbac('presupuesto.partida.admin')):
                        ?>
                        <div class="pull-right" style="padding-left:10px;">
                            <a  type="submit" href="/presupuesto/partida/create" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                <i class="fa fa-plus icon-on-right"></i>
                                Registrar una Partida
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
                        'id' => 'partida-grid',
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
                                'header' => '<center>codigo</center>',
                                'name' => 'codigo',
                                'htmlOptions' => array('width' => '15%'),
                            ),
                            array(
                                'header' => '<center>Descipción</center>',
                                'name' => 'descripcion',
                            ),
                            array(
                                'header' => '<center>Tipo de Partida</center>',
                                'name' => 'tipo_partida_id',
                                'value' => '$data->tipoPartida->nombre',
                                'filter' => CHtml::listData(TipoPartida::model()->findAll(array('order' => 'nombre ASC')), 'id', 'nombre'),
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
echo CHtml::scriptFile('/public/js/modules/presupuesto/partida.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
?>

</div>


<div id="dialogPantalla" class="hide"></div>
