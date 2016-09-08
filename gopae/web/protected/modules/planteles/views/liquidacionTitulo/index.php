
<div id="errorLiquidacion" class="hide errorDialogBox" ><p></p> </div>
<div id="campo_vacio" class="hide alertDialogBox" ><p></p> </div>
<?php
$this->breadcrumbs = array(
    'Consultar Planteles' => array('consultar/'),
    'Título' => array('/planteles/Titulo/indexTitulo/id/ ' . base64_encode($plantel_id)),
    'Liquidación de Títulos'
);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'liquidacionSeriales_form'
        ));
?>
<?php if ($mensaje_liquidacionExitosa != '') { ?>
    <div id="exitoLiquidacion" class="successDialogBox" >
        <p>
            <?php echo $mensaje_liquidacionExitosa ?>
        </p>
    </div>
<?php } ?>
<div id="index">

</div>

<div id="indePrincipal">
    <?php
    $denominacion_id = $plantelPK['denominacion_id'];
    $zona_educativa_id = $plantelPK['zona_educativa_id'];
    $estado_id = $plantelPK['estado_id'];
    ?>

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

    <?php if ($dataProviderLiquidacion != array()) { ?>
        <div class="widget-box">
            <div class = "widget-header">
                <h5>Liquidación de Seriales de Facsímiles</h5>
                <div class = "widget-toolbar">
                    <a href = "#" data-action = "collapse">
                        <i class = "icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class = "widget-body">
                <div style = "display:block;" class = "widget-body-inner">
                    <div class = "widget-main">

                        <div class="space-6"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div>

                                    <?php $plantel = base64_encode($plantel_id); ?>
                                    <input type="hidden" id="plantel_id" value="<?php echo $plantel ?>" name="plantel_id">
                                    <?php
                                    $this->widget(
                                            'zii.widgets.grid.CGridView', array(
                                        'id' => 'liquidacionSeriales',
                                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                        'dataProvider' => $dataProviderLiquidacion,
                                        'summaryText' => false,
                                        'columns' => array(
                                            array(
                                                'name' => 'serial',
                                                'header' => '<center><b>Seriales</b></center>',
                                                'type' => 'raw'
                                            ),
                                            array(
                                                'header' => '<center><b>Liquidación</b></center>',
                                                'value' => array($this, 'columnaLiquidacion'),
                                                'type' => 'raw'
                                            ),
                                            array(
                                                'header' => '<center><b>Observación</b></center>',
                                                'value' => array($this, 'columnaObservacion'),
                                                'type' => 'raw'
                                            ),
//                                    array(
//                                        'type' => 'raw',
//                                        'header' => '<center><b>Acciones</b></center>',
//                                        'htmlOptions' => array('nowrap' => 'nowrap'),
//                                        'value' => array($this, 'columnaAcciones'),
//                                        'htmlOptions' => array('width' => '5%'),
//                                    ),
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
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>




    <?php if ($dataProviderMostrarLiquidacion != array()) { ?>
        <div class="widget-box">
            <div class = "widget-header">
                <h5>Liquidación de Seriales de Facsímiles</h5>
                <div class = "widget-toolbar">
                    <a href = "#" data-action = "collapse">
                        <i class = "icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class = "widget-body">
                <div style = "display:block;" class = "widget-body-inner">
                    <div class = "widget-main">

                        <div class="space-6"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div>

                                    <?php $plantel = base64_encode($plantel_id); ?>
                                    <input type="hidden" id="plantel_id" value="<?php echo $plantel ?>" name="plantel_id">
                                    <?php
                                    $this->widget(
                                            'zii.widgets.grid.CGridView', array(
                                        'id' => 'mostrarLiquidacionSeriales',
                                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                        'dataProvider' => $dataProviderMostrarLiquidacion,
                                        'summaryText' => false,
                                        'columns' => array(
                                            array(
                                                'name' => 'serial',
                                                'header' => '<center><b>Seriales</b></center>',
                                                'type' => 'raw'
                                            ),
                                            array(
                                                'name' => 'nombre',
                                                'header' => '<center><b>Liquidación</b></center>',
                                                'type' => 'raw'
                                            ),
                                            array(
                                                'name' => 'observacion',
                                                'header' => '<center><b>Observación</b></center>',
                                                'type' => 'raw'
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
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="widget-box">
            <div class = "widget-header">
                <h5>Datos del Director</h5>
                <div class = "widget-toolbar">
                    <a href = "#" data-action = "collapse">
                        <i class = "icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class = "widget-body">
                <div style = "display:block;" class = "widget-body-inner">
                    <div class = "widget-main">

                        <div id="msgAlerta">
                        </div>

                        <div class="space-6"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <?php if ($dataProviderDatosDirector != array()) { ?>
                                        <?php $plantel = base64_encode($plantel_id); ?>
                                        <input type="hidden" id="plantel_id" value="<?php echo $plantel ?>" name="plantel_id">
                                        <?php
                                        $this->widget(
                                                'zii.widgets.grid.CGridView', array(
                                            'id' => 'mostrarLiquidacionSeriales',
                                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                            'dataProvider' => $dataProviderDatosDirector,
                                            'summaryText' => false,
                                            'columns' => array(
                                                array(
                                                    'name' => 'cedula',
                                                    'header' => '<center><b>Cédula</b></center>',
                                                    'type' => 'raw'
                                                ),
                                                array(
                                                    'name' => 'apellido',
                                                    'header' => '<center><b>Apellidos</b></center>',
                                                    'type' => 'raw'
                                                ),
                                                array(
                                                    'name' => 'nombre',
                                                    'header' => '<center><b>Nombre</b></center>',
                                                    'type' => 'raw'
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
                                        ?>
                                    <?php } elseif ($dataProviderDatosDirector == false) { ?>
                                        <div class="col-md-12" id="1eraFila">
                                            <div id="1eraFila" class="col-md-12">

                                                <table style="width:650%;" class="table table-striped table-bordered table-hover" class="align-center">
                                                    <thead>

                                                        <tr>
                                                            <th>
                                                                <b></b>
                                                            </th>
                                                        </tr>

                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="alertDialogBox">
                                                                    <p>
                                                                        Este plantel no tiene un director asignado aun por favor comuniquese con el administrador del sistema para que ingrese los datos del director actual.
                                                                    </p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>

                                                </table>

                                            </div>

                                            <div class = "col-md-12"><div class = "space-6"></div></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php } ?>


    <hr>
    <div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
    <div class="col-md-12">
        <div class="col-md-6">
            <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("/planteles/titulo/indexTitulo/id/" . base64_encode($plantel_id)); ?>" class="btn btn-danger">
                <i class="icon-arrow-left"></i>
                Volver
            </a>
        </div>
        <?php if ($dataProviderLiquidacion != array()) { ?>
            <div class="col-md-6" style="padding-left: 39%">
                <button id="btnGuardarLiquidacion" type="submit" data-last="Finish" class="btn btn-primary btn-next">
                    Guardar
                    <i class="icon-save icon-on-right"></i>
                </button>
            </div>
        <?php } ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<div id="css_js">
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/titulo/liquidacionSeriales.js', CClientScript::POS_END);
    ?>
</div>

<script>
    $(document).ready(function() {
        $('input[name="observacion[]"]').each(function() {

            $('input[name="observacion[]"]').bind('keyup blur', function() {
                keyText(this, false);
                makeUpper(this);
            });

            $('input[name="observacion[]"]').bind('blur', function() {
                clearField(this);
            });

        });

    });


</script>