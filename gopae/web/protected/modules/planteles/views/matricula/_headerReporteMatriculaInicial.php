<?php
/*
 * DATOS DEL PLANTEL
 */
$cod_plantel = isset($datosPlantel['cod_plantel']) ? $datosPlantel['cod_plantel'] : '';
$cod_estadistico = isset($datosPlantel['cod_estadistico']) ? $datosPlantel['cod_estadistico'] : '';
$nombre_plantel = isset($datosPlantel['nom_plantel']) ? $datosPlantel['nom_plantel'] : '';
$municipio = isset($datosPlantel['municipio']) ? $datosPlantel['municipio'] : '';
$direccion = isset($datosPlantel['direccion']) ? $datosPlantel['direccion'] : '';
$zona_educativa = isset($datosPlantel['zona_educativa']) ? $datosPlantel['zona_educativa'] : '';
$telefono_fijo = (isset($datosPlantel['telefono_fijo']) AND $datosPlantel['telefono_fijo'] > 0) ? $datosPlantel['telefono_fijo'] : '';
$telefono_otro = (isset($datosPlantel['telefono_otro']) AND $datosPlantel['telefono_otro'] > 0 ) ? $datosPlantel['telefono_otro'] : '';
$denominacion = isset($datosPlantel['denominacion']) ? $datosPlantel['denominacion'] : '';

/*
 * DATOS DE LA SECCION
 */

$plan_estudio = isset($datosSeccion['plan_estudio']) ? $datosSeccion['plan_estudio'] : '';
$cod_plan = isset($datosSeccion['cod_plan']) ? $datosSeccion['cod_plan'] : '';
$mencion = isset($datosSeccion['mencion']) ? $datosSeccion['mencion'] : '';
$seccion = isset($datosSeccion['seccion']) ? $datosSeccion['seccion'] : '';
$grado = isset($datosSeccion['grado']) ? $datosSeccion['grado'] : '';
$cant_estudiantes = isset($datosSeccion['cant_estudiantes']) ? $datosSeccion['cant_estudiantes'] : '';

/*
 * DATOS DEL PERIODO
 * 
 * 
 */

$periodo_escolar = (isset($periodo['periodo'])) ? $periodo['periodo'] : '';
?>
<img src="<?php echo Yii::app()->baseUrl . 'public/images/barra_n.png'; ?>" />
<br /><br/>
<table style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;width:800px;">

    <tr>
        <td colspan="3" align="center" style="background:#E5E5E5; padding:3px;">
            <b>DATOS DEL PLANTEL</b>
        </td>
    </tr>

    <tr>
        <td>
            <b>C&oacute;digo del plantel:</b> 
            <?php echo $cod_plantel; ?></td>
        <td colspan="2">
            <b>Nombre del Plantel:</b>
            <?php echo $nombre_plantel; ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>C&oacute;digo Estad&iacute;stico:</b>
            <?php echo $cod_estadistico; ?>
        </td>

        <td colspan="2">
            <b>Dirección:</b>
            <?php echo $direccion; ?>
        </td>

    </tr>
    <tr>
        <td>
            <b>Denominación:</b>
            <?php echo $denominacion; ?>
        </td>
        <td>
            <b>Municipio:</b>
            <?php echo $municipio; ?>
        </td>
        <td>
            <b>Zona Educativa:</b>
            <?php echo $zona_educativa; ?>
        </td>


    </tr>

    <tr>
        <td colspan="3" align="center" style="background:#E5E5E5; padding:3px;">
            <b>IDENTIFICACI&Oacute;N DEL CURSO</b>
        </td>
    </tr>
    <tr>
        <td>
            <b>Año Escolar:</b>
            <?php echo $periodo_escolar; ?>
        </td>
        <td>
            <b>Grado o Año:</b>
            <?php echo $grado; ?>
        </td>
        <td>
            <b>Sección:</b>
            <?php echo $seccion; ?>
        </td>

    </tr>
    <tr>
        <td>
            <b>Plan de Estudio:</b>
            <?php echo $plan_estudio; ?>
        </td>
        <td>
            <b>C&oacute;digo del Plan:</b>
            <?php echo $cod_plan; ?>
        </td>
        <td>
            <b> Mención:</b>
            <?php echo $mencion; ?>
        </td>

    </tr>
    <tr>
        <td>
            <b> Estudiantes Matriculados:</b>
            <?php echo $cant_estudiantes; ?>
        </td>
    </tr>

</table>
<table   style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;width:800px;">
    <tr>
        <th colspan="14" align="center" style="background:#E5E5E5; padding:3px;">
            ESTUDIANTES MATRICULADOS
        </th>  
    </tr>
</table>
<table class="estudiantes" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;width:800px;border-collapse: collapse;
       border-spacing: 0px;
       text-align:center; border: 1px solid grey; ">
    <tr style="border: 1px solid grey;">
        <th width="25px" style=" border: 1px solid grey;"  rowspan="2" class="center">
            N°
        </th>
        <th width="30px" style=" border: 1px solid grey;"  rowspan="2"  class="center">
            Nac.
        </th>
        <th width="100px" style=" border: 1px solid grey;"  rowspan="2"  class="center">
            Documento de Identidad
        </th>
        <th width="170px" style=" border: 1px solid grey;"  rowspan="2"  class="center">
            Apellidos
        </th>
        <th width="170px" style=" border: 1px solid grey;" rowspan="2"  class="center">
            Nombres
        </th>
        <th width="40px" style=" border: 1px solid grey;"  rowspan="2"  class="center">
            Sexo
        </th>
        <th width="8z0px" style=" border: 1px solid grey;" colspan="3" class="center">
            Fecha de Nac.
        </th>
        <th width="80px" style=" border: 1px solid grey;" colspan="4" class="center">
            Escolaridad
        </th>
        <th width="80px" style=" border: 1px solid grey;"  rowspan="2"  class="center">
            Observación
        </th>

    </tr>
    <tr style=" border: 1px solid grey;" style=" border: 1px solid grey;">>
        <th width="30px" style=" border: 1px solid grey;"  class="center">
            Día
        </th>
        <th width="30px" style=" border: 1px solid grey;"  class="center">
            Mes
        </th>
        <th width="30px" style=" border: 1px solid grey;"  class="center">
            Año
        </th>
        <th width="20px" style=" border: 1px solid grey;"  class="center">
            RG
        </th>
        <th width="20px" style=" border: 1px solid grey;"  class="center">
            RP
        </th>
        <th width="20px" style=" border: 1px solid grey;"  class="center">
            MP
        </th>
        <th  width="20px" style=" border: 1px solid grey;"  class="center">
            DI
        </th>
    </tr>
</table>