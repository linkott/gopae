<div class="widget-box">

    <div class="widget-header">
        <h5>Reporte Estadístico de Registro de Directores de Plantel a Diario</h5>

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
                            <span class="icon-caret-down icon-on-right"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-info pull-right">
                            <li>
                                <a id="repEstadisticoDiario">Reporte Estadístico</a>
                            </li>
                            <li>
                                <a id="repGraficoDiario">Reporte Gráfico</a>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="space-6"></div>

                <div id="resultadoDiario" class="row-fluid">

                    <div class="infoDialogBox">
                        <p>
                            Seleccione el Tipo de Reporte que desea consultar.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Crear Javascript del Reporte de Directores Diarios -->
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/control/autoridadesPlantel.js',CClientScript::POS_END); ?>