<?php
$this->breadcrumbs = array(
    'Planteles' => array('/planteles'),
    'Planes de Estudio',
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

<div class = "widget-box collapsed">

    <div class = "widget-header">
        <h5>Búsqueda Avanzada de Planes de Estudio</h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: none;" class = "widget-body-inner">
            <div class = "widget-main">

                <?php echo CHtml::link('', '#', array('class' => 'search-button'));
                ?>
                <div class="search-form" style="display:block">
                    <?php
                    $this->renderPartial('_search', array(
                        'model' => $model
                    ));
                    ?>
                </div><!-- search-form -->
            </div>
        </div>
    </div>

</div>



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
        <h5>Planes de Estudio</h5>

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
                    <div class = "pull-right" style = "padding-left:10px;">
                        <a id="btnAsignarPlan" data-last = "Finish" class = "btn btn-success btn-next btn-sm">
                            <i class = "fa fa-plus icon-on-right"></i>
                            Asignar Plan de Estudio
                        </a>
                    </div>

                    <div class = "col-lg-12"><div class = "space-6"></div></div>

                    <?php
                    echo CHtml::hiddenField('plantel_id', $model->plantel_id);
                    /* $nombre = array(
                      'header' => '<center>Nombre</center>',
                      'name' => 'nombre',
                      //'value' => '(is_object($datosPlantel->nombre) && isset($datosPlantel->nombre))? $datosPlantel->nombre : ""',
                      );
                      $cod_plan = array(
                      'header' => '<center>Código de Plan</center>',
                      'name' => 'cod_plan',
                      //'value' => '(is_object($datosPlantel->cod_plan) && isset($datosPlantel->cod_plan))? $datosPlantel->cod_plan : ""',
                      );
                      $mencion = array(
                      'header' => '<center>Mención</center>',
                      'name' => 'mencion_id',
                      'value' => '(is_object($datosPlantel->mencion) && isset($datosPlantel->mencion->nombre))? $datosPlantel->mencion->nombre : ""',
                      'filter' => CHtml::listData(
                      Mencion::model()->findAll(
                      array(
                      'order' => 'nombre ASC'
                      )
                      ), 'id', 'nombre'
                      ),
                      );
                      $credencial = array(
                      'header' => '<center>Credencial</center>',
                      'name' => 'credencial_id',
                      'value' => '(is_object($datosPlantel->credencial) && isset($datosPlantel->credencial->nombre))? $datosPlantel->credencial->nombre : ""',
                      'filter' => CHtml::listData(
                      Credencial::model()->findAll(
                      array(
                      'order' => 'nombre ASC'
                      )
                      ), 'id', 'nombre'
                      ),
                      );
                      $fund_juridico = array(
                      'header' => '<center>Fundamento Juridico</center>',
                      'name' => 'fund_juridico_id',
                      'value' => '(is_object($datosPlantel->fund_juridico_id) && isset($datosPlantel->fund_juridico_id->nombre))? $datosPlantel->fund_juridico_id->nombre : ""',
                      'filter' => CHtml::listData(
                      FundamentoJuridico::model()->findAll(
                      array(
                      'order' => 'nombre ASC'
                      )
                      ), 'id', 'nombre'
                      ),
                      );
                      /* $estatusPlantel = array(
                      'header' => '<center title="Estatus del Plantel">Estatus</center>',
                      'name' => 'estatus_plantel_id',
                      'value' => '(is_object($datosPlantel->estatusPlantel) && isset($datosPlantel->estatusPlantel->nombre))? $datosPlantel->estatusPlantel->nombre: ""',
                      'filter' => CHtml::listData(
                      EstatusPlantel::model()->findAll(
                      array(
                      'order' => 'id ASC',
                      )
                      ), 'id', 'nombre'
                      ),
                      );
                     *
                     */


                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'plantel-plan-grid',
                        'enableSorting' => false,
                        'dataProvider' => $model->search(),
                        'filter' => $model,
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'pager' => array('pageSize' => 10),
                        'afterAjaxUpdate' => "function(){
                            $('.look-data').unbind('click');
                            $('.look-data').on('click',
                                    function(e) {
                                        e.preventDefault();
                                        var id = $(this).attr('data-id');
                                        verPlanPlantel(id);
                                    }
                            );

                            $('.change-status').unbind('click');
                            $('.change-status').on('click',
                                    function(e) {
                                        e.preventDefault();
                                        var id = $(this).attr('data-id');
                                        var description = $(this).attr('data-description');
                                        var accion = $(this).attr('data-action');
                                        cambiarEstatusPlanPlantel(id, description, accion);
                                    }
                            );
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
                                'header' => '<center>Código del Plan</center>',
                                'name' => 'cod_plan',
                                'value' => '(is_object($data->planes) && isset($data->planes->cod_plan))? $data->planes->cod_plan : ""',
                            ),
                            array(
                                'header' => '<center>Nombre del Plan</center>',
                                'name' => 'plan',
                                'value' => '(is_object($data->planes) && isset($data->planes->nombre))? $data->planes->nombre : ""',
                                'filter' => CHtml::textField('PlanPlantel[plan]', null, array('id' => 'PlanPlantel_plan')),
                            ),
                            array(
                                'header' => '<center>Mención</center>',
                                'name' => 'mencion',
                                'value' => '(is_object($data->planes->mencion) && isset($data->planes->mencion->nombre))? $data->planes->mencion->nombre : ""',
                                'filter' => CHtml::textField('PlanPlantel[mencion]', null, array('id' => 'PlanPlantel_mencion')),
                            ),
                            array(
                                'header' => '<center>Credencial</center>',
                                'name' => 'credencial',
                                'value' => '(is_object($data->planes->credencial) && isset($data->planes->credencial->nombre))? $data->planes->credencial->nombre : ""',
                                'filter' => CHtml::textField('PlanPlantel[credencial]', null, array('id' => 'PlanPlantel_credencial')),
                            ),
                            array(
                                'header' => '<center>Fundamento Juridico</center>',
                                'name' => 'fund_juridico',
                                'value' => '(is_object($data->planes->fund_juridico_id) && isset($data->planes->fund_juridico_id->nombre))? $data->planes->fund_juridico_id->nombre : ""',
                                'filter' => CHtml::textField('PlanPlantel[fund_juridico]', null, array('id' => 'PlanPlantel_fund_juridico')),
                            ),
                            array(
                                'name' => 'estatus',
                                'header' => 'Estatus',
                                'value' => 'strtr($data->estatus,array("A"=>"Activo", "E"=>"Inactivo"))',
                                'filter' => array('A' => 'Activo', 'E' => 'Inactivo'),
                            ),
                            array(
                                'type' => 'raw',
                                'header' => 'Acciones',
                                'value' => array($this, 'columnaAcciones'),
                                'filter' => CHtml::hiddenField('PlanPlantel[plantel_id]', $model->plantel_id),
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
        <?php $this->renderPartial('/_accionesSobrePlantel', array('plantel_id' => $model->plantel_id)) ?>
    </div>

    <!-- <div class="col-md-6 wizard-actions">
         <button type="submit" data-last="Finish" class="btn btn-primary btn-next">
             Guardar
             <i class="icon-save icon-on-right"></i>
         </button>
     </div>
    -->

</div>
<div class="hide" id="dialog_asignarPlan"></div>
<div class="hide" id="dialog-planEstudio"></div>
<div id="confirm-status" class="hide">
    <div class="alertDialogBox">
        <p style="text-align: justify">
            Al <strong><span class="confirm-action"></span></strong> el Plan de Estudio "<b id="confirm-description"></b>" se <strong><span class="confirm-action"></span>á</strong> de igual forma el proceso de matricula con dicho Plan de Estudio en el sistema.
        </p>
    </div>
    <div class="alert alert-info bigger-110">
        <p class="bigger-110 center">  Desea usted <strong><span class="confirm-action"></span></strong> el Plan de Estudio?</p>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/planes.js', CClientScript::POS_END);




