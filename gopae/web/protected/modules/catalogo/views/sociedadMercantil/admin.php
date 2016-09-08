<?php

/* @var $this SociedadMercantilController */
/* @var $model SociedadMercantil */

$this->breadcrumbs=array(
    'Catálogo'=>array('/catalogo/'),
    'Sociedad Mercantil',
);
$this->pageTitle = 'Administración de Sociedades Mercantiles';

?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Lista de Sociedades Mercantiles</h5>

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
                                En este módulo podrá registrar y/o actualizar los datos de Sociedades Mercantiles.
                            </p>
                        </div>
                    </div>

                    <div class="pull-right" style="padding-left:10px;">
                        <a href="<?php echo $this->createUrl("/catalogo/sociedadMercantil/registro"); ?>" type="submit" id='newRegister' data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Sociedad Mercantil                        </a>
                    </div>


                    <div class="row space-20"></div>

                </div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sociedad-mercantil-grid',
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
            'header' => '<center>Nombre</center>',
            'name' => 'nombre',
            'htmlOptions' => array(),
            'filter' => CHtml::textField('SociedadMercantil[nombre]', $model->nombre, array('title' => '',)),
            ),
        array(
            'header' => '<center>Siglas</center>',
            'name' => 'siglas',
            'htmlOptions' => array(),
            'filter' => CHtml::textField('SociedadMercantil[siglas]', $model->siglas, array('title' => '',)),
        ),
        array(
            'name' => 'estatus',
            'header' => '<center>Estatus</center>',
            'value' => 'strtr($data->estatus,array("A"=>"Activo", "I"=>"Inactivo", "E"=>"Eliminado"))',
            'filter' => array('A' => 'Activo', 'I' => 'Inactivo', 'E' => 'Eliminado'),
        ),
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
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catalogo/sociedadMercantil/admin.js',CClientScript::POS_END); ?>