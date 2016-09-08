<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'asistencia-colaborador-plantel-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
));
?>

    <input type="hidden" value="<?php echo $mes; ?>" name="mes" />
    <input type="hidden" value="<?php echo $anio; ?>" name="anio" />

    <div class="row" id="resultRegistroAsistenciaColaboradoras">
        <div class="infoDialogBox">
            <p>Indique cuidadosamente la Cantidad de Días de Asistencia de las Madres Colaboradoras del Mes Seleccionado.<br/> Los días de asistencia no pueden ser mayor a los días planificados.</p>
        </div>
    </div>

    <div class="col-md-12">
        <div class="space-6"></div>
    </div>

    <div class="col-md-12">
        <input type="hidden" id="diasPlanificados" name="diasPlanificados" value="<?php echo $diasPlanificados; ?>" />

        <table class="table table-striped table-condensed table-bordered table-hover">
            <thead>
                <tr>
                    <th id="asit-colaborador-grid_c0" width="15%">
                        <center>Código del plantel</center>
                    </th>
                    <th id="asit-colaborador-grid_c3">
                        <center>Mes/Año</center>
                    </th>
                    <th id="asit-colaborador-grid_c1" width="12%">
                        <center>Días Planificados</center>
                    </th>
                    <th id="asit-colaborador-grid_c1">
                        <center>Cédula</center>
                    </th>
                    <th id="asit-colaborador-grid_c2">
                        <center>Nombre y Apellido</center>
                    </th>
                    <th id="asit-colaborador-grid_c6" width="10%">
                        <center>Asistencia</center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if(!is_null($colaboradoras) && count($colaboradoras)>0): $i = 0;?>

                    <?php
                        foreach ($colaboradoras as $colaboradora):
                    ?>
                <tr>
                    <td class="table-data" id="asit-colaborador-grid_c0r<?php echo $i; ?>" va>
                        <center><?php echo CHtml::encode($colaboradora['cod_plantel']); ?></center>
                    </td>
                    <td class="table-data" id="asit-colaborador-grid_c5r<?php echo $i; ?>">
                        <center><?php echo str_pad($mes, 2, '0', STR_PAD_LEFT).'/'.$anio; ?></center>
                    </td>
                    <td class="table-data" id="asit-colaborador-grid_c2r<?php echo $i; ?>">
                        <center><?php echo CHtml::encode($diasPlanificados); ?></center>
                    </td>
                    <td class="table-data text-center" id="asit-colaborador-grid_c1r<?php echo $i; ?>">
                        <?php echo CHtml::encode($colaboradora['origen'].'-'.$colaboradora['cedula']); ?>
                    </td>
                    <td class="table-data text-center" id="asit-colaborador-grid_c2r<?php echo $i; ?>">
                        <?php echo CHtml::encode($colaboradora['apellido'].' '.$colaboradora['nombre']); ?>
                    </td>
                    <td id="asit-colaborador-grid_c6r<?php echo $i; ?>">
                        <?php echo $this->inputAsistenciaMadresColaboradoras($colaboradora, $diasPlanificados); ?>
                    </td>
                </tr>
                    <?php
                            $i++;
                        endforeach;
                    ?>

                <?php else: ?>
                <tr>
                    <td colspan="7">
                        <div class="alertDialogBox"><p>No se han encontrado Madres Colaboradoras Asignadas a este Plantel en el Periodo Actual</p></div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div id="sectionBtnConfirmarAsistenciaColaboradoras" style="display: none;">
            <hr>

            <div class="row-fluid wizard-actions">

                <button class="btn btn-primary btn-next" data-last="Finish" type="submit" id="guardarAsistenciaMadresColaboradoras">
                    Confirmar
                    <i class="icon-arrow-right"></i>
                </button>

            </div>
        </div>
    </div>
<?php
$this->endWidget();
?>

<div id="dialogConfirmRegistroAsistenciaColaboradoras" class="hide">
    <div class="alertDialogBox">
        <p>
            ¿Confirma usted que desea realizar el registro de la asistencia ingresada? Debe Verificar los datos ingresados ya que no se podrá realizar ningún cambio posterior, tome en cuenta también que este registro incide directamente en el estipendio que será dado a las Madres Colaboradoras. Los Campos vacios serán rellenados con cero (0).
        </p>
    </div>
</div>