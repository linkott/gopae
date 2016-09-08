<div class="widget-box">

    <div class="widget-header">
        <h5>Reporte <span id="tipoReporteTextDiario">Estadístico</span> Estadístico de Registro de Directores de Plantel a Diario</h5>

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
                            Tipo de Reporte
                            <span id="selectTipoReporteTextDiario"></span>
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-info pull-right">
                            <li>
                                <a id="repEstadisticoDiario">Reporte Estadístico
                                 <i class="icon-calendar"></i>
                                </a>
                            </li>
<!--                            <li>
                                <a id="repGraficoDiario">Reporte Gráfico
                                 <i class="icon-bar-chart"></i>
                                </a>
                            </li>-->
                        </ul>
                    </div>

                </div>

                <div class="space-6"></div>

                <div id="resultadoDiario" class="row-fluid">

                    <div id="infoDirectoresDiario" class="infoDialogBox">
                        <p>
                            Seleccione el Tipo de Reporte que desea consultar.
                        </p>
                    </div>
                    <div class="space-6"></div>
                        <div class="row row-fluid hide" id="fechaCondicion">
                        <div class="row-fluid col-md-12">

                            <?php $fechaActual= date('d-m-Y');
 //var_dump($fechaActual);

                            echo CHtml::textField('fecha_desde',"$fechaActual",array('size' => 10, 'maxlength' => 10, 'id' => 'fecha_desde', 'style' => 'width:200px;padding-top:2px;', 'readOnly' => 'readOnly')); ?>

                            <button style="padding-top: 2px; padding-bottom: 2px;" type="button" class="btn btn-info btn-xs" id="busqueda_fecha">
                            <i class="icon-search"></i>
                            Buscar
                        </button>

                        </div>
                    </div>
                      <div class="space-6"></div>
                    <div id="resultadoDirectotesDiario" >

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/control/directoresDiario.js', CClientScript::POS_END); ?>
