<?php
$this->breadcrumbs = array(
    'Planteles' => '/planteles/',
    'Planificación',
);
?>

<div class = "widget-box">

    <div class = "widget-header">
        <h5>Planificación del periodo <?php echo $periodo; ?></h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: block;" class = "widget-body-inner">
            <div class = "widget-main">

                <div class="row row-fluid center">

                    <div class="main-container" id="main-container">

                        <div class="main-container-inner">

                            <div class="page-content">

                                <div class="row">
                                    <div class="col-xs-12">
                                        <!-- PAGE CONTENT BEGINS -->

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <?php
//                                                if($registrarPeriodo == ''){
//                                                ?>
<!--                                                <div id="dialogAlertPeriodo" class="alertDialogBox" align="left">
                                                    <P>El periodo escolar //<?php echo $periodo; ?> no tiene planificación registrada.</P>
                                                </div>-->
                                                <?php
//                                                }
                                                ?>
                                            </div>
                                            <div class="col-sm-12">
                                                    <div class="col-xs-6" align="left">
                                                        <span id="mesAnterior" class="btn btn-primary btn-xs" unselectable="on" style="-moz-user-select: none;">
                                                            <i class="icon-chevron-left"></i>
                                                            Mes anterior
                                                        </span>
                                                        <span id="mesSiguiente" class="btn btn-primary btn-xs" unselectable="on" style="-moz-user-select: none;">
                                                            Mes siguiente
                                                            <i class="icon-chevron-right"></i>
                                                        </span>
                                                    </div>
                                                    <?php
//                                                    var_dump($this->validaPlanifiarPeriodo());
                                                    if($this->validaPlanifiarPeriodo() < 1 && !isset($_REQUEST['id'])):
                                                    ?>
                                                    <div class="col-xs-6" align="right" name="divPlanificarPeriodo">
                                                        <a class="btn btn-primary btn-xs" id="planificarPeriodo">
                                                            Planificar Periodo
                                                            <i class="fa fa-save"></i>
                                                        </a>
                                                    </div>
                                                    <?php
                                                    endif;
                                                    ?>
                                                    
                                                    
                                                    <br><br><br>
                                                    <div class="space"></div>
                                                    <?php
                                                    $mes = date('m');// + 1;
//                                                    if($mes > 12){
//                                                        $mes = 11;
//                                                    }
                                                    ?>
                                                    <span id="mesActual" class="hide"><?php echo $mes; ?></span>
                                                    <span id="anoActual" class="hide"><?php echo date('Y'); ?></span>
                                                    <div id="calendar">
                                                    </div>
                                            </div>
                                        </div>
                                        <!-- PAGE CONTENT ENDS -->
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div><!-- /.page-content -->
                        </div><!-- /.main-container-inner -->
                    </div><!-- /.main-container -->
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<span id="mesEvents" class="hide"><?php echo $mes; ?></span>
<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<div id="dialogPantalla" class="hide"></div>
<div id="dialogPantallaPlanificar" class="hide">
    <div id="dialogAlert" class="alertDialogBox">
        <p>¿Esta realmente seguro que desea planificar este periodo?</p>
    </div>
</div>
<div class="col-xs-6">
        <a id="btnRegresar" href="/planteles/" class="btn btn-danger">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
</div>
<div id="url" class="hide"><?php echo $url; ?></div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/fullcalendar.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/bootbox.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/planificacion/planificacion.js', CClientScript::POS_END);
?>
