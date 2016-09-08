<?php
/* @var $this ReporteRegistroUnicoController */

$this->breadcrumbs = array(
    'Control' => '/control',
    'Registro Único del CNAE',
);
?>
    <div class="col-xs-12">
        <div class="row row-fluid">

            <div class="tabbable">

                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#directores">Registro Único</a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div id="directores"  class="tab-pane active">

                        <div class="widget-box">

                            <div class="widget-header">
                                <h5>Reporte <span id="tipoReporteText">Estadístico</span> del Registro Único del CNAE </h5>

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
                                                <div id="print_button" class = "btn btn-primary btn-next btn-sm hide" style = " margin-right: 5px;">Imprimir <i class="fa fa-print icon-on-right"></i></div>

                                                <button class="btn btn-sm dropdown-toggle" data-toggle="dropdown">
                                                    Tipo de Reporte
                                                    <span id="selectTipoReporteText"></span>
                                                    <span class="icon-caret-down icon-on-right"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-info pull-right">
                                                    <li>
                                                        <a id="repEstadisticoRegistroUnico">Reporte de Registro Unico &nbsp;<i class="fa fa-file-text-o"></i></a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>

                                        <div class="space-6"></div>


                                        <div id="resultado-script" class="row-fluid hide"></div>



                                        <div class="space-6"></div>

                                        <div class="row row-fluid hide" id="fechaCondicion">
                                            <div class="row-fluid col-md-12">

                                                <?php $fechaActual = date('d-m-Y');

                                                echo CHtml::textField('fecha_desde', "$fechaActual", array('size' => 10, 'maxlength' => 10, 'id' => 'fecha_desde', 'style' => 'width:200px;padding-top:2px;', 'readOnly' => 'readOnly'));
                                                ?>

                                                <button style="padding-top: 3px; padding-bottom: 2px;" type="button" class="btn btn-info btn-xs" id="busqueda_fecha">
                                                    <i class="icon-search"></i>
                                                    Consultar
                                                </button>

                                            </div>
                                        </div>

                                        <div class="space-6"></div>
                                        <!-- El siguiente Div imprime la vista de reporteEstadisticoRegistroUnico.php -->
                                        <div id="resultado" class="row-fluid" style="min-height: 300px;">
                                        <!-- Fin del div que trae la vista-->

                                            <div class="alertDialogBox">
                                                <p>
                                                    Se recomienda no ejecutar este reporte en los momentos en los que se efectúan procesos masivos de Registro Único ya que este reporte se genera en tiempo real y dichas consultas pueden ralentizar el proceso. Seleccione el Tipo de Reporte que desea consultar.
                                                </p>
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
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.gritter.min.js', CClientScript::POS_BEGIN); ?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/control/autoridadesPlantel.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jchart/jchart.min.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jchart/modules/exporting.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jchart/themes/grid.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/control/directoresDiario.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/control/reporteRegistroUnico.js', CClientScript::POS_END); ?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/control/jquery-1.9.0.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/control/jquery.PrintArea.js', CClientScript::POS_BEGIN); ?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/css/PrintArea.css', CClientScript::POS_BEGIN); ?>
