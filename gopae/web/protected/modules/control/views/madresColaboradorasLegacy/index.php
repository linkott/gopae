<?php
/* @var $this AutoridadesplantelController */

$this->breadcrumbs = array(
    'Control' => '/control',
    'Madres Colaboradoras Legacy',
);
?>
<div class="col-xs-12">
    <div class="row row-fluid">

        <div class="tabbable">

            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#directores">Madres Colaboradoras</a>
                </li>
            </ul>

            <div class="tab-content">

                <div id="directores"  class="tab-pane active">

                    <div class="widget-box">

                        <div class="widget-header">
                            <h5>Reporte <span id="tipoReporteText">Estadístico</span> de Madres Colaboradoras</h5>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="icon-chevron-up"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">

                            <div class="widget-body-inner">

                                <div class="widget-main form">

                                    <div class="row-fluid" style="text-align: right;">

                                        <div class="btn-group" style="margin-right: 5px;">
                                            <button class="btn btn-sm dropdown-toggle" data-toggle="dropdown">
                                                Seleccione
                                                <span id="selectTipoReporteText"></span>
                                                <span class="icon-caret-down icon-on-right"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-info pull-right">
                                                <li>
                                                    <a id="repEstadistico">Reporte Estadístico General &nbsp;<i class="fa fa-file-text-o"></i></a>
                                                </li>
                                                <li>
                                                    <a id="repGrafico">Reporte Gráfico General &nbsp;<i class="icon-bar-chart"></i></a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>

                                    <div class="space-6"></div>

                                    <div id="resultado-script" class="row-fluid hide"></div>

                                    <div class="space-6"></div>

                                    <div id="resultado">
                                        <?php $this->renderPartial('//msgBox', array('class'=>'infoDialogBox', 'message'=>'Indique el reporte que desea visualizar haciendo click en el botón "Seleccione"')); ?>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div id="dialog-contacto" class="hide">
    <div class="center">
        <img src="<?php echo Yii::app()->baseUrl; ?>/public/images/ajax-loader-red.gif">
    </div>
</div>

<div id="dialog-observacion" class="hide">
    <form id="form-control-zona-directores">
        <div id="autoridadZonaContacto" class="tab-pane active">

            <div id="resultadoControlZonaDirectores">
                <div class="infoDialogBox">
                    <p>
                        Todos los campos con <span class="required">*</span> son requeridos.
                    </p>
                </div>
            </div>

            <div class="widget-box">

                <div class="widget-header" style="border-width: thin">
                    <h5>Observación de Control</h5>

                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="icon-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body">

                    <div class="widget-body-inner">

                        <div class="widget-main form">

                            <div class="row">

                                <div class="row-fluid">

                                    <div class="col-md-12">
                                        <label for="observacion" class="col-md-12">Observación <span class="required">*</span></label>
                                        <textarea id="control_zona_observacion" name="control_zona_observacion" maxlength="400" style="width: 99%;"></textarea>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </form>
</div>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/control/madresColaboradorasLegacy.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jchart/jchart.min.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jchart/modules/exporting.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jchart/themes/grid.js', CClientScript::POS_END); ?>