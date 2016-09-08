<style type="text/css">

    .estudiantes table, .estudiantes th, .estudiantes td {
        border: 1px solid grey;
    }  
    .estudiantes table {
        border-collapse: collapse;
        border-spacing: 0px;
        text-align:center;
    }
</style>

<?php
if (isset($estudiantes) AND $estudiantes != array()) {
    ?>
    <table class="estudiantes" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;width:800px;border-collapse: collapse;
           border-spacing: 0px;
           text-align:center; border: 1px solid grey; ">

        <?php
        foreach ($estudiantes as $key => $value) {
            $nacionalidad = isset($value['nacionalidad']) ? $value['nacionalidad'] : '';
            $cedula_identidad = isset($value['cedula_identidad']) ? $value['cedula_identidad'] : '';
            $cedula_escolar = isset($value['cedula_escolar']) ? $value['cedula_escolar'] : '';
            $nombres = isset($value['nombres']) ? $value['nombres'] : '';
            $apellidos = isset($value['apellidos']) ? $value['apellidos'] : '';
            $sexo = isset($value['sexo']) ? $value['sexo'] : '';
            $fecha_nacimiento = (isset($value['fecha_nacimiento'])) ? $value['fecha_nacimiento'] : '';
            $inscripcion_regular = (isset($value['inscripcion_regular'])) ? $value['inscripcion_regular'] : '';
            $materia_pendiente = isset($value['materia_pendiente']) ? $value['materia_pendiente'] : '';
            $repitiente = (isset($value['repitiente'])) ? $value['repitiente'] : '';
            $doble_inscripcion = (isset($value['doble_inscripcion'])) ? $value['doble_inscripcion'] : '';
            $observacion = isset($value['observacion']) ? $value['observacion'] : '';
            $documento_identidad = '';
            $rg_check = '';
            $mp_check = '';
            $rp_check = '';
            $di_check = '';
            $fecha_array = explode('-', $fecha_nacimiento);
            $anio = isset($fecha_array[0]) ? $fecha_array[0] : '';
            $mes = isset($fecha_array[1]) ? $fecha_array[1] : '';
            $dia = isset($fecha_array[2]) ? $fecha_array[2] : '';

            if ($cedula_identidad > 0)
                $documento_identidad = 'C.I: ' . $cedula_identidad;
            else {
                $documento_identidad = 'C.E: ' . $cedula_escolar;
            }
            if (!($observacion != ''))
                $observacion = '**********';
            $rg_check = CHtml::checkBox('RG', (bool) $inscripcion_regular);
            $mp_check = CHtml::checkBox('RG', (bool) $materia_pendiente);
            $rp_check = CHtml::checkBox('RG', (bool) $repitiente);
            $di_check = CHtml::checkBox('RG', (bool) $doble_inscripcion);
            ?>

            <tr>

                <td width="25px" align="center"  >
                    <?php echo $key + 1; ?>
                </td>
                <td  width="30px" align="center">
                    <?php echo $nacionalidad; ?>
                </td>
                <td  width="100px"  align="center">
                    <?php echo $documento_identidad; ?>
                </td>
                <td  width="170px"  align="center">
                    <?php echo $apellidos; ?>
                </td>
                <td  width="170px"  align="center">
                    <?php echo $nombres; ?>
                </td>
                <td  width="40px"  align="center">
                    <?php echo $sexo; ?>
                </td>
                <td width="30px"  align="center">
                    <?php echo $dia; ?>
                </td>
                <td width="30px"  align="center">
                    <?php echo $mes; ?>
                </td>
                <td  width="30px" align="center">
                    <?php echo $anio; ?>
                </td>
                <td width="20px" align="center">
                    <?php echo $rg_check; ?>
                </td>
                <td width="20px" align="center">
                    <?php echo $rp_check; ?>
                </td>
                <td width="20px" align="center">
                    <?php echo $mp_check; ?>
                </td>
                <td width="20px" align="center">
                    <?php echo $di_check; ?>
                </td>
                <td  width="80px"  align="center">
                    <?php echo $observacion; ?>
                </td>

            </tr>

            <?php
        }
        echo "</table>";
    }
    ?>
<!--    <tr>
    <th colspan="6" class="center">
    </th>
    
    
    <th  class="center">
    </th>

</tr>-->






    <br>









