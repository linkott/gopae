<div class="row">
    <?php if(!isset($mensaje)): ?>
    <div class="infoDialogBox">
        <p>El Registro de Asistencia de Madres y Padres Colaboradores de este mes ya ha sido efectuado.</p>
    </div>
    <?php else: ?>
    <div class="successDialogBox">
        <p><?php echo $mensaje; ?></p>
    </div>
    <?php endif; ?>
</div>

<div class="col-md-12">
    <div class="space-6"></div>
</div>

<div class="col-md-12">
    <input type="hidden" id="diasPlanificados" name="diasPlanificados" value="<?php echo $diasPlanificados; ?>" />

    <table class="table table-striped table-condensed table-bordered table-hover">
        <thead>
            <tr>
                <th id="asit-colaborador-grid_c1">
                    <center>Cédula</center>
                </th>
                <th id="asit-colaborador-grid_c2">
                    <center>Nombre y Apellido</center>
                </th>
                <th id="asit-colaborador-grid_c3">
                    <center>Mes/Año</center>
                </th>
                <th id="asit-colaborador-grid_c1" width="12%">
                    <center>Días Planificados</center>
                </th>
                <th id="asit-colaborador-grid_c6" width="10%">
                    <center>Asistencia</center>
                </th>
                <th id="asit-colaborador-grid_c6">
                    <center>Registrado Por</center>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if(!is_null($colaboradoras) && count($colaboradoras)>0): $i = 0;?>

                <?php
                    foreach ($colaboradoras as $colaboradora):
                ?>
            <tr>
                <td class="table-data text-center" id="asit-colaborador-grid_c1r<?php echo $i; ?>">
                    <?php echo CHtml::encode($colaboradora['origen'].'-'.$colaboradora['cedula']); ?>
                </td>
                <td class="table-data text-center" id="asit-colaborador-grid_c2r<?php echo $i; ?>">
                    <?php echo CHtml::encode($colaboradora['nombre'].' '.$colaboradora['apellido']); ?>
                </td>
                <td class="table-data text-center" id="asit-colaborador-grid_c5r<?php echo $i; ?>">
                    <center><?php echo str_pad($mes, 2, '0', STR_PAD_LEFT).'/'.$anio; ?></center>
                </td>
                <td class="table-data text-center" id="asit-colaborador-grid_c2r<?php echo $i; ?>">
                    <center><?php echo CHtml::encode($diasPlanificados); ?></center>
                </td>
                <td class="table-data text-center" id="asit-colaborador-grid_c6r<?php echo $i; ?>">
                    <?php echo CHtml::encode($colaboradora['asistencia']); ?>
                </td>
                <td class="table-data text-center" id="asit-colaborador-grid_c6r<?php echo $i; ?>">
                    <?php echo CHtml::encode($colaboradora['usr_ini_nombre'].' '.$colaboradora['usr_ini_apellido']); ?>
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
</div>