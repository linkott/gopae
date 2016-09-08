
<?php
$this->breadcrumbs = array(
    'Consultar Planteles' => array('consultar/'),
    'Título' => array('/planteles/Titulo/indexTitulo/id/ ' . base64_encode($plantel_id)),
    'Liquidación de Títulos'
);

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



<div class = "widget-box">

    <div class = "widget-header">
        <h5></h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: block;" class = "widget-body-inner">
            <div class = "widget-main">

                <div class="row align-center">
                    <div class="col-md-12">

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
                                                        Este plantel no tiene seriales para realizar la liquidaci&oacute;n.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>

                            <div class = "col-md-12"><div class = "space-6"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-6 wizard-actions" style="padding-top: 1%; padding-right:40%">
        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("/planteles/titulo/indexTitulo/id/" . base64_encode($plantel_id)); ?>" class="btn btn-danger">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
