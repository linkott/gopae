<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;

?>

    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl.'/public/css/styles-iview.css'; ?>" />
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl.'/public/css/iview.css'; ?>" />
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl.'/public/css/skin-4/style.css'; ?>" />

    <div class="col-xs-12">
        <div class="row row-fluid">
            <div class="accordion-style1 panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle">
                                <i data-icon-show="icon-angle-right" data-icon-hide="icon-angle-down" class="bigger-110 icon-angle-down"></i>
                                &nbsp;AVISO IMPORTANTE
                            </a>
                        </h4>
                    </div>

                    <div id="collapseOne" class="panel-collapse in" style="height: auto;">
                        <div class="panel-body">
                            <p style="text-align: justify;font-size:15px;font-family: 'Helvetica';">
                                El día Lunes 16-03-2015 La Corporación Nacional de Alimentación Escolar (CNAE) da comienzo al Registro Único Nacional de Autoridades de Planteles, Cocineras y Cocineros Escolares, con la finalidad de dar un mejor servicio y realizar una gestión transparente.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#collapseTwo" data-parent="#accordion" data-toggle="collapse" class="accordion-toggle collapsed">
                                <i data-icon-show="icon-angle-right" data-icon-hide="icon-angle-down" class="bigger-110 icon-angle-right"></i>
                                &nbsp;El Manual de Usuario para el Registro Único Nacional
                            </a>
                        </h4>
                    </div>

                    <div id="collapseTwo" class="panel-collapse collapse" style="height: 0px;">
                        <div class="panel-body">
                            <p style="text-align: justify; font-size:15px;font-family: 'Helvetica';" > 
                                El Manual de Usuario para el Registro Único Nacional pueden encontrarlo en la sección de
                                <a href="/ayuda/instructivo">Ayuda/Instructivos</a> o pueden descargarlo desde este <a href="/public/uploads/instructivo/20150314152326AT.pdf">link</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/raphael-min.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.easing.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.fullscreen.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/iview.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/slider.js',CClientScript::POS_END); ?>
