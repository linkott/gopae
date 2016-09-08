<?php
$this->breadcrumbs = array(
    'Planteles',
);

$this->pageTitle = "Consulta de Planteles";

if($groupId != 30)
{
?>
    <div class="widget-box collapsed">

        <div class="widget-header">
            <h5>B&uacute;squeda Avanzada de Planteles</h5>

            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="icon-chevron-down"></i>
                </a>
            </div>

        </div>

        <div class="widget-body">
            <div style="display: none;" class="widget-body-inner">
                <div class="widget-main">

                    <?php echo CHtml::link('', '#', array('class' => 'search-button')); ?>
                    <div class="search-form" style="display:block">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                            'estadoId' => $estadoId,
                        ));
                        ?>
                    </div><!-- search-form -->
                </div>
            </div>
        </div>

    </div>
<?php
}
?>

<div class="widget-box">

    <?php
    Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#plantel-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	");
    ?>

    <div class="widget-header">
        <h5>Planteles</h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">
                <div>
                    <div class="col-lg-12"><div class="space-6"></div></div>

                    <?php
                    /*SI EL USUARIO ES COORDINADOR DE CONTROL DE ESTUDIO NO BUSCAR POR NOMBRE DE PLANTEL Y LA SECRETARIA*/
                    if(!in_array($groupId, array(UserGroups::ROOT, UserGroups::DESARROLLADOR, UserGroups::JEFE_ZONA, UserGroups::JEFE_DRCEE, UserGroups::JEFE_DRCEE_ZONA, UserGroups::DIRECTOR, UserGroups::ADMIN_DRCEE, UserGroups::ADMIN_DRCEE_ZONA, UserGroups::OPER_PLANTEL, UserGroups::OPER_ZONA, UserGroups::DOCENTE, UserGroups::MISION_RIBAS_NAC, UserGroups::MISION_RIBAS_REG)))
                    {
                        $nombrePlantel =
                            array(
                                'header' => '<center>Nombre del plantel</center>',
                                'name' => 'nombre',
                                'filter' => false,
                            );
                    }
                    else
                    {
                        $nombrePlantel =
                            array(
                                'header' => '<center>Nombre del plantel</center>',
                                'name' => 'nombre',
                            );
                    }

                    /*SI ES SECRETARIA NO TIENE PERMISO DE BUSQUEDA*/
                    if($groupId == UserGroups::ADMIN_USUARIOS)
                    {
                        $codigoPlantel =
                            array(
                                'header' => '<center>Código del plantel</center>',
                                'name' => 'cod_plantel',
                                'filter' => false,
                            );
                        $tipoDependencia =
                            array(
                                'header' => '<center>Tipo de dependencia</center>',
                                'name' => 'tipo_dependencia_id',
                                'value' => '(is_object($data->tipoDependencia) && isset($data->tipoDependencia->nombre))? $data->tipoDependencia->nombre : ""',
                                'filter' => false,
                            );
                        $estado =
                            array(
                                'header' => '<center>Estado</center>',
                                'name' => 'estado_id',
                                'value' => '(is_object($data->estado) && isset($data->estado->nombre))? $data->estado->nombre : ""',
                                'filter' => false,
                            );
                        $denominacion =
                            array(
                                'header' => '<center>Denominación</center>',
                                'name' => 'denominacion_id',
                                'value' => '(is_object($data->denominacion) && isset($data->denominacion->nombre))? $data->denominacion->nombre : ""',
                                'filter' => false,
                            );
                        $estatusPlantel =
                            array(
                                'header' => '<center>Estatus del plantel</center>',
                                'name' => 'estatus_plantel_id',
                                'value' => '(is_object($data->estatusPlantel) && isset($data->estatusPlantel->nombre))? $data->estatusPlantel->nombre : ""',
                                'filter' => false,
                            );
                    }
                    else
                    {
                        $codigoPlantel =
                            array(
                                'header' => '<center>Código del plantel</center>',
                                'name' => 'cod_plantel',
                                'filter' => CHtml::textField('Plantel[cod_plantel]', null),
                                //'filterHtmlOptions' => array('style' => 'display:none'),
                            );
                        $tipoDependencia =
                            array(
                                'header' => '<center>Tipo de dependencia</center>',
                                'name' => 'tipo_dependencia_id',
                                'value' => '(is_object($data->tipoDependencia) && isset($data->tipoDependencia->nombre))? $data->tipoDependencia->nombre: ""',
                                'filter' => CHtml::listData(CTipoDependencia::getData(), 'id', 'nombre'),
                            );

                        /*EN CASO DE QUE SEA EL COORDINADOR DE ZONA groupsId = (25)
                        * NO PERMITA REALIZAR BUSQUEDAS DE OTRAS ZONAS (ESTADOS)
                        */
                        if(in_array($groupId, array(UserGroups::MISION_RIBAS_REG, UserGroups::JEFE_ZONA, UserGroups::JEFE_DRCEE_ZONA, UserGroups::OPER_ZONA, UserGroups::ADMIN_DRCEE_ZONA, UserGroups::DIRECTOR, UserGroups::JCEE_PLANTEL, UserGroups::DOCENTE)))
                        {
                            $estado =
                                array(
                                    'header' => '<center>Estado</center>',
                                    'name' => 'estado_id',
                                    'value' => '(is_object($data->estado) && isset($data->estado->nombre))? $data->estado->nombre : ""',
                                    'filter' => false,
                                );
                        }
                        else
                        {
                            $estado =
                                array(
                                    'header' => '<center>Estado</center>',
                                    'name' => 'estado_id',
                                    'value' => '(is_object($data->estado) && isset($data->estado->nombre))? $data->estado->nombre: ""',
                                    'filter' => CHtml::listData(CEstado::getData(), 'id', 'nombre'),
                                );
                        }
                        if(($groupId == UserGroups::MISION_RIBAS_NAC) || ($groupId == UserGroups::MISION_RIBAS_REG))
                        {
                            $denominacion =
                                array(
                                    'header' => '<center>Denominación</center>',
                                    'name' => 'denominacion_id',
                                    'value' => '(is_object($data->denominacion) && isset($data->denominacion->nombre))? $data->denominacion->nombre : ""',
                                    'filter' => false
                                );

                        }
                        else
                        {
                            $denominacion =
                                array(
                                    'header' => '<center>Denominación</center>',
                                    'name' => 'denominacion_id',
                                    'value' => '(is_object($data->denominacion) && isset($data->denominacion->nombre))? $data->denominacion->nombre : ""',
                                    'filter' => CHtml::listData(CDenominacion::getData(), 'id', 'nombre'),
                                );
                        }
                        $estatusPlantel =
                            array(
                                'header' => '<center title="Estatus del Nivel">Estatus</center>',
                                'name' => 'estatus_plantel_id',
                                'value' => '(is_object($data->estatusPlantel) && isset($data->estatusPlantel->nombre))? $data->estatusPlantel->nombre: ""',
                                'filter' => CHtml::listData(CEstatusPlantel::getData(), 'id', 'nombre'),
                            );
                    }
                    
                    $beneficiarioPae = array(
                        'header' => '<center title="Beneficiario PAE">Beneficiario PAE</center>',
                        'name' => 'pae_activo',
                        'value' => '(is_array($data->plantelPae) && count($data->plantelPae)>0)?ucwords(strtolower($data->plantelPae[0]->pae_activo)):"No"',
                        'filter' => CHtml::listData(array(array('id'=>'SI', 'nombre'=>'Si'),array('id'=>'NO', 'nombre'=>'No')), 'id', 'nombre'),
                    );
                    
                    $matriculaTotal = array(
                        'header' => '<center title="Matricula Total">Matricula Total</center>',
                        'name' => 'matricula_total',
                        'value' => '(is_array($data->plantelPae) && count($data->plantelPae)>0)?($data->plantelPae[0]->matricula_general*1 + $data->matricula_simoncito*1):"No ha sido actualizada"',
                        'filter' => false,
                    );
                    
                    $this->widget('zii.widgets.grid.CGridView', array(
                    	'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'id' => 'plantel-grid',
                        'dataProvider' => $model->search(),
                        'filter' => $model,
                        'pager' => array('pageSize' => 1),
                        'summaryText' => false,
                        'afterAjaxUpdate' => "function(){

                             $('#Plantel_cod_estadistico').bind('keyup blur', function() {
                                 keyNum(this, false);
                             });
                             $('#Plantel_cod_estadistico_view').bind('keyup blur', function() {
                                 keyNum(this, false);
                             });

                             $('#Plantel_telefono_fijo').bind('keyup blur', function() {
                                 keyNum(this, false);
                             });

                             $('#Plantel_telefono_otro').bind('keyup blur', function() {
                                 keyNum(this, false);
                             });

                             $('#Plantel_nfax').bind('keyup blur', function() {
                                 keyNum(this, false);
                             });

                             $('#Plantel_cod_plantel').bind('keyup blur', function() {
                                 keyAlphaNum(this, false);
                             });

                             $('#Plantel_cod_plantel_view').bind('keyup blur', function() {
                                 keyAlphaNum(this, false);
                             });

                             $('#cod_plantelNer').bind('keyup blur', function() {
                                 keyAlphaNum(this, false);
                             });
                         }",
                        'columns' => array(
                            $codigoPlantel,
                            $nombrePlantel,
                            $tipoDependencia,
                            $estado,
                            $denominacion,
                            $matriculaTotal,
                            $beneficiarioPae,
                            $estatusPlantel,
                            array(
                                'type' => 'raw',
                                'header' => '<center>Acciones</center>',
                                'value' => array($this, 'columnaAcciones'),
                                'htmlOptions'=>array('nowrap'=>'nowrap'),
                            ),
                        ),
                        'pager' => array(
                                    'header' => '',
                                    'htmlOptions'=>array('class'=>'pagination'),
                                    'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                                    'prevPageLabel'  => '<span title="Página Anterior">&#9668;</span>',
                                    'nextPageLabel'  => '<span title="Página Siguiente">&#9658;</span>',
                                    'lastPageLabel'  => '<span title="Última página">&#9658;&#9658;</span>',
                                ),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>

<div id="dialogPantalla" class="hide"></div>
<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/consultarPlantel.js',CClientScript::POS_END);
?>