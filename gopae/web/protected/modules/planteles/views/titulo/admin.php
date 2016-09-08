


<div id="exitoSolicitud" class="hide successDialogBox">
    <p></p>

    <div class="col-md-6" style="padding-top: 4%">
        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("planteles/consultar"); ?>" class="btn btn-danger">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
    </div>

</div>


<div id="result-solicitud" >
    <?php
    /* @var $this TituloController */
/* @var $model Titulo */




$this->breadcrumbs = array(
    'Consultar Planteles' => array('consultar/'),
    'Secciones',
);

$denominacion_id = $plantelPK['denominacion_id'];
$zona_educativa_id = $plantelPK['zona_educativa_id'];
$estado_id = $plantelPK['estado_id'];
?>
    <div id="errorSolicitud" class="hide errorDialogBox" ><p></p> </div>
    <div id="seleccionchecked"> </div>

<div class = "widget-box collapsed">

        <div class = "widget-header">
            <h5>Identificación del Plantel <?php echo '"' . $plantelPK['nombre'] . '"'; ?></h5>

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
                                    <?php echo CHtml::textField('', $plantelPK['cod_plantel'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('<b>Código Estadistico</b>', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantelPK['cod_estadistico'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('<b>Denominación</b>', '', array("class" => "col-md-12")); ?>
                                    <?php if ($denominacion_id == null) { ?>
                                        <?php
                                        echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                                    } else {
                                        ?>
                                        <?php
                                        echo CHtml::textField('', $plantelPK->denominacion->nombre, array('class' => 'span-7', 'readOnly' => 'readOnly'));
                                        echo "no entro";
                                        ?>
                                    <?php } ?>
                                </div>

                            </div>

                            <div class = "col-md-12"><div class = "space-6"></div></div>

                            <div id="2daFila" class="col-md-12">
                                <div class="col-md-4" >
                                    <?php echo CHtml::label('<b>Nombre del Plantel</b>', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantelPK['nombre'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('<b>Zona Educativa</b>', '', array("class" => "col-md-12")); ?>
                                    <?php if ($zona_educativa_id == null) { ?>
                                        <?php
                                        echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                                    } else {
                                        ?>
                                        <?php echo CHtml::textField('', $plantelPK->zonaEducativa->nombre, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                                    <?php } ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('<b>Estado', '', array("class" => "col-md-12")); ?>
                                    <?php if ($zona_educativa_id == null) { ?>
                                        <?php
                                        echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                                    } else {
                                        ?>
                                        <?php echo CHtml::textField('', $plantelPK->estado->nombre, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                                    <?php } ?>
                                </div>

                            </div>

                            <div class = "col-md-12"><div class = "space-6"></div></div>
                        </div>
                    </div>
                </div>
            </div>

    </div>


    <div id="servicioCalid" class="widget-box">

        <div class="widget-header">
            <h5>Candidatos a solicitud de t&iacute;tutlo </h5>
            <div class="widget-toolbar">
                <a  href="#" data-action="collapse">
                    <i class="icon-chevron-down"></i>
                </a>
            </div>
        </div>

        <div id="servicio" class="widget-body" >
            <div class="widget-body-inner" >
                <div class="widget-main form">

                    <div class="row">
                        <div class="col-md-12" id ="solicitud-titulo">
                            <div id="scrolltable" style='border: 0px;background: #fff; overflow:auto;padding-right: 0px; padding-top: 0px; padding-left: 0px; padding-bottom: 0px;border-right: #DDDDDD 0px solid; border-top: #DDDDDD 0px solid;border-left: #DDDDDD 0px solid; border-bottom: #DDDDDD 0px solid;scrollbar-arrow-color : #999999; scrollbar-face-color : #666666;scrollbar-track-color :#3333333 ;height:225px; left: 28%; top: 300; width: 100%'>
                                <?php
                                //var_dump($dataProvider);
                                //        die();
                                if (isset($dataProvider)) {

                                    $this->widget(
                'zii.widgets.grid.CGridView', array(
            'id' => 'solicitudTitulo-grid',
            'itemsCssClass' => 'table table-striped table-bordered table-hover',
            'dataProvider' => $dataProvider,
            'summaryText' => false,
            'columns' => array(
                    array(
                    "name" => "boton",
                    "type" => "raw",
                    'header' => '<div class="center">' . CHtml::checkBox('selec_todoEst', false, array('id' => 'selec_todoEst', 'title' => 'Seleccionar todos','class' => 'tooltipMatricula')) . "</div>"
            ),
            array(
                    'name' => 'cedula_identidad',
                    'type' => 'raw',
                    'header' => '<center><b>Cédula Identidad</b></center>'
                ),
                array(
                    'name' => 'nombreApellido',
                    'type' => 'raw',
                    'header' => '<center><b>Nombres y Apellidos</b></center>'
                ),
                array(
                    'name' => 'grado',
                    'type' => 'raw',
                    'header' => '<center><b> Grado </b></center>'
                ),
                array(
                    'name' => 'nombre_seccion',
                    'type' => 'raw',
                    'header' => '<center><b> Sección </b></center>'
                ),
                array(
                    'name' => 'plan_nombre',
                'type' => 'raw',
                    'header' => '<center><b> Nombre del Plan</b></center>'
                ),
                array(
                    'name' => 'botones',
                'type' => 'raw',
                    'header' => '<center><b>Solicitud</b></center>'
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
                )
        );
    }
    ?>
                            </div>
                        </div>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="col-md-2">
        <div class="col-md-6">
            <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("planteles/consultar"); ?>" class="btn btn-danger">
                <i class="icon-arrow-left"></i>
                Volver
            </a>
        </div>
    </div>

<button id="btnGuardarSolicitud" type="button" class="btn btn-primary btn btn-primary btn-next pull-right" role="button" aria-disabled="false"><span class="ui-button-text"><i class="icon-save info bigger-110"></i>&nbsp; Ingresar solicitud de título</span>
</button>


        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/solicitudTitulo.js', CClientScript::POS_END); ?>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/main.js', CClientScript::POS_END); ?>

</div>