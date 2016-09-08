<?php
$nombres_director = (isset($datosAutoridades['nombres_director']) AND $datosAutoridades['nombres_director'] != '') ? $datosAutoridades['nombres_director'] : '';
$apellidos_director = (isset($datosAutoridades['apellidos_director']) AND $datosAutoridades['apellidos_director'] != '') ? $datosAutoridades['apellidos_director'] : '';
$cedula_director = (isset($datosAutoridades['cedula_director']) AND $datosAutoridades['cedula_director'] != '') ? $datosAutoridades['cedula_director'] : '';
$nombres_zona = (isset($datosAutoridades['nombres_zona']) AND $datosAutoridades['nombres_zona'] != '') ? $datosAutoridades['nombres_zona'] : '';
$apellidos_zona = (isset($datosAutoridades['apellidos_zona']) AND $datosAutoridades['apellidos_zona'] != '') ? $datosAutoridades['apellidos_zona'] : '';
$cedula_zona = (isset($datosAutoridades['cedula_zona']) AND $datosAutoridades['cedula_zona'] != '') ? $datosAutoridades['cedula_zona'] : '';
?>
<table >
    <tr>
        <td >
            <table width="250px" class="estudiantes_footer" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;border-collapse: collapse;
                   border-spacing: 0px;
                   text-align:left; border: 1px solid grey; ">
                <tr style="border: 1px solid grey;">
                    <th  style="text-align: left;border: 1px solid grey;"  colspan="2" class="center">
                        Fecha de Remisión:
                    </th>
                </tr>
                <tr style="border: 1px solid grey;">
                    <th width="170px" style=" text-align: left;border: 1px solid grey;"   class="center">
                        Director(a)
                    </th>
                    <th  style=" text-align: center;border: 1px solid grey;"  rowspan="7" class="center">
                        SELLO DEL PLANTEL
                    </th>
                </tr>
                <tr style="border: 1px solid grey;">
                    <th  style=" text-align: left;border: 1px solid grey;"  class="center">
                        Apellidos y Nombres:
                    </th>
                </tr>
                <tr style="text-align: left;border: 1px solid grey;">
                    <td  style=" border: 1px solid grey;"  class="center">
                        <?php echo $nombres_director . ' ' . $apellidos_director; ?>
                    </td>
                </tr>
                <tr style="border: 1px solid grey;">
                    <th  style="text-align: left; border: 1px solid grey;"  class="center">
                        Cédula de Identidad:
                    </th>
                </tr>
                <tr style="border: 1px solid grey;">
                    <td  style="text-align: left; border: 1px solid grey;"  class="center">
                        <?php echo str_replace(',', '.', number_format($cedula_director)); ?>
                    </td>
                </tr>
                <tr style="border: 1px solid grey;">
                    <th  style="text-align: left; border: 1px solid grey;"  class="center">
                        FIRMA
                    </th>
                </tr>
                <tr style="border: 1px solid grey;">
                    <th  style=" border: 1px solid grey;"  class="center">
                        ____________________________
                    </th>
                </tr>
            </table> 
        </td>
        <td >  
            <table width="250px" class="estudiantes_footer" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;border-collapse: collapse;
                   border-spacing: 0px;
                   text-align:center; border: 1px solid grey; ">

                <tr>

                </tr></table>
        </td>
        <td >
            <table width="250px" class="estudiantes_footer" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;border-collapse: collapse;
                   border-spacing: 0px;
                   text-align:center; border: 1px solid grey; ">
                <tr style="border: 1px solid grey;">
                    <th  style="text-align: left; border: 1px solid grey;"  colspan="2" class="center">
                        Fecha de Recepción:
                    </th>
                </tr>
                <tr style="border: 1px solid grey;">
                    <th  width="170px" style=" text-align: left;border: 1px solid grey;"   class="center">
                        Funcionario Receptor
                    </th>
                    <th  style=" border: 1px solid grey;"  rowspan="7" class="center">
                        SELLO DE LA ZONA EDUCATIVA
                    </th>
                </tr>
                <tr style="border: 1px solid grey;">
                    <th  style=" text-align: left;border: 1px solid grey;"  class="center">
                        Apellidos y Nombres:
                    </th>
                </tr>
                <tr style="border: 1px solid grey;">
                    <td style="text-align: left; border: 1px solid grey;"  class="center">
                        <?php echo $nombres_zona . ' ' . $apellidos_zona; ?>
                    </td>
                </tr>
                <tr style="border: 1px solid grey;">
                    <th  style="text-align: left; border: 1px solid grey;"  class="center">
                        Cédula de Identidad:
                    </th>
                </tr>
                <tr style="border: 1px solid grey;">
                    <td  style="text-align: left; border: 1px solid grey;"  class="center">
                        <?php echo str_replace(',', '.', number_format($cedula_zona)); ?>
                    </td>
                </tr>
                <tr style="border: 1px solid grey;">
                    <th style=" text-align: left;border: 1px solid grey;"  class="center">
                        FIRMA
                    </th>
                </tr>
                <tr style="border: 1px solid grey;">
                    <th  style=" border: 1px solid grey;"  class="center">
                        ____________________________
                    </th>
                </tr>
            </table>
        </td>
    </tr>

</table>    