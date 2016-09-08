<?php
/* @var $this CargoController */
/* @var $model Cargo */
$this->pageTitle = 'Listado de Roles en Espacios del MPPE';
$this->breadcrumbs = array(
    'Catalogo' => array('/catalogo'),
    'Roles'
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cargo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="widget-box">
    <div class="widget-header">
        <h5>Listado de Roles</h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">
                <div id="resultadoOperacion">
                    <div class="infoDialogBox">
                        <p>
                            Los Cargos acá registrados será utilizados para la definición de Autoridades de los distintos espacios (Zonas Educativas, Planteles...) del MPPE.
                        </p>
                    </div>
                    <?php
                    if (($groupId == 1) || ($groupId == 18)):
                    ?>
                    <div class="pull-right" style="padding-left:10px;">
                            <a  type="submit" onclick="VentanaDialog('', '/catalogo/cargo/create', 'Cargo', 'create', '')" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                <i class="fa fa-plus icon-on-right"></i>
                                Registrar Nuevo Cargo o Rol
                            </a>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-12"><div class="space-6"></div></div>
                </div><!-- search-form -->
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                    'id' => 'cargo-grid',
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
                            'header' => '<center>Nombre del Rol</center>',
                            'name' => 'nombre',
                        ),
                        array(
                            'header' => '<center>Ente o Espacio</center>',
                            'name'=>'ente_id',
                            'value' => '$data->ente->nombre',
                            'filter' => CHtml::listData(
                                    Ente::model()->findAll(
                                            array(
                                                'order' => 'id ASC'
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
                        ),
                    ),
                ));
                ?>


            </div>
        </div>
    </div>
</div>
<div class="row-fluid-actions">
    <a class="btn btn-danger" href="/catalogo">
        <i class="icon-arrow-left bigger-110"></i>
        Volver
    </a>
</div>

<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>


<div id="dialogPantalla" class="hide"></div>

<?php
echo CHtml::scriptFile('/public/js/modules/catalogo/cargo.js');
?>