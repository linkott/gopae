<?php
$this->breadcrumbs = array(
    'Planteles' => array('/planteles'),
    'Secciones',
);
?>
<div class = "widget-box collapsed">

    <div class = "widget-header">
        <h5>Identificación del Plantel <?php echo '"' . $datosPlantel['nom_plantel'] . '"'; ?></h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: none;" class = "widget-body-inner">
            <div class = "widget-main">

                <div class="row row-fluid center">
                    <div id="1eraFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Código del Plantel</b>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $datosPlantel['cod_plantel'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Código Estadistico</b>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $datosPlantel['cod_estadistico'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Denominación</b>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $datosPlantel['denominacion'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>

                    <div id="2daFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Nombre del Plantel</b>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $datosPlantel['nom_plantel'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Zona Educativa</b>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $datosPlantel['zona_educativa'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Estado', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $datosPlantel['estado'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--<div class = "widget-box collapsed">

    <div class = "widget-header">
        <h5>Búsqueda Avanzada de Secciones</h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: none;" class = "widget-body-inner">
            <div class = "widget-main">

<?php //echo CHtml::link('', '#', array('class' => 'search-button'));
?>
                <div class="search-form" style="display:block">
<?php
//                    $this->renderPartial('_search', array(
//                        'model' => $model
//                    ));
?>
                </div> search-form 
            </div>
        </div>
    </div>

</div>-->



<div class="widget-box">

    <?php
    Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
        data = {
            plantel_id : $('#plantel_id').val(),
            cod_plan : $('#cod_plan').val(),
            fund_juridico : $('#fund_juridico').val(),
            mencion : $('#mencion').val(),
            credencial : $('#credencial').val(),
            plan : $('#plan').val()
            };
	$('#plantel-plan-grid').yiiGridView('update', {
		data: data
	});
	return false;
});
");
    ?>

    <div class = "widget-header">
        <h5>Secciones</h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display:block;" class = "widget-body-inner">
            <div class = "widget-main">
                <div>
                    <div id="success">
                    </div>
                    <div id="div-result-message" style="min-height: 60px;">
                        <div class="infoDialogBox">
                            <p>Ingrese un Parámetro de Búsqueda</p>
                        </div>
                    </div>
                    <!--                    <div class = "pull-right" style = "padding-left:10px;">
                                            <a id="btnAsignarPlan" data-last = "Finish" class = "btn btn-success btn-next btn-sm">
                            <i class = "fa fa-plus icon-on-right"></i>
                            Asignar Plan de Estudio
                        </a>
                                        </div>-->

                    <div class = "col-lg-12"><div class = "space-6"></div></div>

                    <?php
                    echo CHtml::hiddenField('plantel_id', $plantel_id);
                    $plantel_id_decoded = base64_decode($plantel_id);

                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'seccion-plantel-grid',
                        'enableSorting' => false,
                        'dataProvider' => $model->search($plantel_id_decoded),
                        'filter' => $model,
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'pager' => array('pageSize' => 10),
                        'afterAjaxUpdate' => "function(){
                            
                                $('#PlanPlantel_plan').bind('keyup blur', function() {
                                    keyAlphaNum(this, true, true);
                                    makeUpper(this, true);
                                });
                                $('#PlanPlantel_mencion').bind('keyup blur', function() {
                                    keyAlphaNum(this, true, true);
                                    makeUpper(this, true);
                                });
                                $('#PlanPlantel_credencial').bind('keyup blur', function() {
                                    keyAlphaNum(this, true, true);
                                    makeUpper(this, true);
                                });
                                $('#PlanPlantel_fund_juridico').bind('keyup blur', function() {
                                    keyAlphaNum(this, true, true);
                                    makeUpper(this, true);
                                });
                                $('#PlanPlantel_cod_plan').bind('keyup blur', function() {
                                    keyNum(this, true,false);
                                });
                            }",
                        'summaryText' => false,
                        'columns' => array(
                            array(
                                'header' => '<center>Sección</center>',
                                'name' => 'seccion_id',
                                'value' => '(is_object($data->seccion) && isset($data->seccion->nombre))? $data->seccion->nombre: ""',
                            ),
                            array(
                                'header' => '<center>Grado</center>',
                                'name' => 'grado_id',
                                'value' => '(is_object($data->grado) && isset($data->grado->nombre))? $data->grado->nombre: ""',
                            ),
                            array(
                                'header' => '<center>Capacidad</center>',
                                'name' => 'capacidad',
                            ),
                            array(
                                'header' => '<center>Turno</center>',
                                'name' => 'turno_id',
                                'value' => '(is_object($data->turno) && isset($data->turno->nombre))? $data->turno->nombre: ""',
                            ),
                            array(
                                'header' => '<center>Estatus</center>',
                                'name' => 'estatus',
                                'filter' => array(
                                    'A' => 'Activo',
                                    'E' => 'Inactivo'
                                ),
                                'value' => 'strtr($data->estatus,array("A"=>"Activo", "E"=>"Inactivo"))',
                            ),
                            array(
                                'type' => 'raw',
                                'header' => 'Acciones',
                                'value' => array($this, 'columnaAcciones'),
                                'filter' => CHtml::hiddenField('SeccionPlantel[plantel_id]', $model->plantel_id),
                                'htmlOptions' => array('width' => '83px', 'nowrap' => 'nowrap'),
                            ),
                        ),
                        'pager' => array(
                            'header' => '',
                            'htmlOptions' => array('class' => 'pagination'),
                            'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                            'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                            'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                            'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                        ),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="row">

    <div class="col-md-6">
        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("planteles"); ?>" class="btn btn-danger">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
    </div>


</div>
<div class="hide" id="dialogo"></div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/matricula.js', CClientScript::POS_END);




