<table class="table table-condensed table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th id="cocinera-grid_c0">
                <center>Código del plantel</center>
            </th>
            <th id="cocinera-grid_c1">
                <center>Cédula</center>
            </th>
            <th id="cocinera-grid_c2">
                <center>Nombre y Apellido</center>
            </th>
            <th id="cocinera-grid_c3">
                <center>Nacimiento</center>
            </th>
            <th id="cocinera-grid_c4">
                <center>Asignado por</center>
            </th>
            <th id="cocinera-grid_c5">
                <center>Última Asistencia Registrada</center>
            </th>
            <th id="cocinera-grid_c6">
                <center>Acciones</center>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if(!is_null($cocineras) && count($cocineras)>0): ?>
        
            <?php foreach ($cocineras as $cocinera): ?>
        <tr>
            <td class="table-data text-center" id="cocinera-grid_c0">
                <?php echo CHtml::encode($cocinera['cod_plantel']); ?>
            </td>
            <td class="table-data text-center" id="cocinera-grid_c1">
                <?php echo CHtml::encode($cocinera['origen'].'-'.$cocinera['cedula']); ?>
            </td>
            <td class="table-data text-center" id="cocinera-grid_c2">
                <?php echo CHtml::encode($cocinera['nombre'].' '.$cocinera['apellido']); ?>
            </td>
            <td class="table-data text-center" id="cocinera-grid_c3">
                <?php echo Utiles::transformDate($cocinera['fecha_nacimiento'], '-', 'y-m-d', 'd-m-y'); ?>
            </td>
            <td class="table-data text-center" id="cocinera-grid_c4">
                <?php echo CHtml::encode($cocinera['usr_act_nombre'].' '.$cocinera['usr_act_apellido']); ?> (<?php echo CHtml::encode($cocinera['fecha_act_cp']); ?>)
            </td>
            <td class="table-data text-center" id="cocinera-grid_c5">
                <?php echo CHtml::encode($cocinera['fecha_ultima_asistencia_reg'].' ('.str_pad($cocinera['ultima_asistencia_reg'], 2, '0', STR_PAD_LEFT).')'); ?>
            </td>
            <td class="table-data text-center" id="cocinera-grid_c6">
                <?php echo $this->columnaAcciones($cocinera); ?>
            </td>
        </tr>
            <?php endforeach; ?>

        <?php else: ?>
        <tr>
            <td colspan="7">
                <div class="alertDialogBox"><p>No se han encontrado Madres Colaboradoras Asignadas a este Plantel</p></div>
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
