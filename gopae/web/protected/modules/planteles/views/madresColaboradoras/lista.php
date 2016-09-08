<table class="table table-condensed table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th id="colaborador-grid_c0">
                <center>Código del plantel</center>
            </th>
            <th id="colaborador-grid_c1">
                <center>Cédula</center>
            </th>
            <th id="colaborador-grid_c2">
                <center>Nombre y Apellido</center>
            </th>
            <th id="colaborador-grid_c3">
                <center>Nacimiento</center>
            </th>
            <th id="colaborador-grid_c4">
                <center>Asignado por</center>
            </th>
            <th id="colaborador-grid_c5">
                <center>Última Asistencia Registrada</center>
            </th>
            <th id="colaborador-grid_c6">
                <center>Acciones</center>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if(!is_null($colaboradoras) && count($colaboradoras)>0): ?>
        
            <?php foreach ($colaboradoras as $colaboradora): ?>
        <tr>
            <td class="table-data text-center" id="colaborador-grid_c0">
                <?php echo CHtml::encode($colaboradora['cod_plantel']); ?>
            </td>
            <td class="table-data text-center" id="colaborador-grid_c1">
                <?php echo CHtml::encode($colaboradora['origen'].'-'.$colaboradora['cedula']); ?>
            </td>
            <td class="table-data text-center" id="colaborador-grid_c2">
                <?php echo CHtml::encode($colaboradora['nombre'].' '.$colaboradora['apellido']); ?>
            </td>
            <td class="table-data text-center" id="colaborador-grid_c3">
                <?php echo Utiles::transformDate($colaboradora['fecha_nacimiento'], '-', 'y-m-d', 'd-m-y'); ?>
            </td>
            <td class="table-data text-center" id="colaborador-grid_c4">
                <?php echo CHtml::encode($colaboradora['usr_act_nombre'].' '.$colaboradora['usr_act_apellido']); ?> (<?php echo CHtml::encode($colaboradora['fecha_act_cp']); ?>)
            </td>
            <td class="table-data text-center" id="colaborador-grid_c5">
                <?php echo CHtml::encode($colaboradora['fecha_ultima_asistencia_reg'].' ('.str_pad($colaboradora['ultima_asistencia_reg'], 2, '0', STR_PAD_LEFT).')'); ?>
            </td>
            <td class="table-data text-center" id="colaborador-grid_c6">
                <?php echo $this->columnaAcciones($colaboradora); ?>
            </td>
        </tr>
            <?php endforeach; ?>
        
        <?php else: ?>
        <tr>
            <td colspan="7">
                <div class="alertDialogBox"><p>No se han encontrado Madres Colaboradoras Asignadas a este Plantel en el Periodo Actual</p></div>
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>