<?php
/*
 * DATOS DEL PLANTEL
 */
$codigo = isset($datos_orden_compra[0]['codigo_nota']) ? $datos_orden_compra[0]['codigo_nota'] : '';
$cod_estadistico = isset($datos_orden_compra[0]['codigo_estadistico']) ? $datos_orden_compra[0]['codigo_estadistico'] : '';
$dependencia = isset($datos_orden_compra[0]['dependencia']) ? $datos_orden_compra[0]['dependencia'] : '';
$estado_plantel = isset($datos_orden_compra[0]['estado_plantel']) ? $datos_orden_compra[0]['estado_plantel'] : '';
$estado_proveedor = isset($datos_orden_compra[0]['proveedor_estado']) ? $datos_orden_compra[0]['proveedor_estado'] : '';
$rif = isset($datos_orden_compra[0]['proveedor_rif']) ? $datos_orden_compra[0]['proveedor_rif'] : '';
$razon_social = isset($datos_orden_compra[0]['razon_social']) ? $datos_orden_compra[0]['razon_social'] : '';
$municipio_proveedor = isset($datos_orden_compra[0]['proveedor_municipio']) ? $datos_orden_compra[0]['proveedor_municipio'] : '';
$municipio_plantel = isset($datos_orden_compra[0]['municipio_plantel']) ? $datos_orden_compra[0]['municipio_plantel'] : '';
$direccion_plantel = isset($datos_orden_compra[0]['direccion_plantel']) ? $datos_orden_compra[0]['direccion_plantel'] : '';
$direccion_proveedor = isset($datos_orden_compra[0]['proveedor_direccion']) ? $datos_orden_compra[0]['proveedor_direccion'] : '';
$unidad_administradora = isset($datos_orden_compra[0]['unidad_administradora']) ? $datos_orden_compra[0]['unidad_administradora'] : '';
$unidad_ejecutora = isset($datos_orden_compra[0]['unidad_ejecutora_local']) ? $datos_orden_compra[0]['unidad_ejecutora_local'] : '';
$telefono_plantel = (isset($datos_orden_compra[0]['telefono_plantel']) AND $datos_orden_compra[0]['telefono_plantel'] > 0) ? $datos_orden_compra[0]['telefono_fijo'] : '';
$telefono_proveedor = (isset($datos_orden_compra[0]['proveedor_telefono']) AND $datos_orden_compra[0]['proveedor_telefono'] > 0 ) ? $datos_orden_compra[0]['proveedor_telefono'] : '';
$telefono_proveedor_otro = (isset($datos_orden_compra[0]['proveedor_telefono_otro']) AND $datos_orden_compra[0]['proveedor_telefono_otro'] > 0 ) ? $datos_orden_compra[0]['proveedor_telefono_otro'] : '';
$tipo_servicio =  isset($datos_orden_compra[0]['tipo_servicio']) ? $datos_orden_compra[0]['tipo_servicio'] : '';
$dias_habiles = isset($datos_orden_compra[0]['dias_habiles']) ? $datos_orden_compra[0]['dias_habiles'] : '';
$anticipo = isset($datos_orden_compra[0]['anticipo']) ? $datos_orden_compra[0]['anticipo'] : '';
$lugar_entrega = isset($datos_orden_compra[0]['lugar_entrega']) ? $datos_orden_compra[0]['lugar_entrega'] : '';
$forma_pago = isset($datos_orden_compra[0]['forma_pago']) ? $datos_orden_compra[0]['forma_pago'] : '';
$fecha = isset($datos_orden_compra[0]['fecha']) ? date("d-m-Y", strtotime($datos_orden_compra[0]['fecha'])) : '';
$mes = isset($datos_orden_compra[0]['mes']) ? $datos_orden_compra[0]['mes'] : '';
$anio = isset($datos_orden_compra[0]['anio']) ? $datos_orden_compra[0]['anio'] : '';
?>
<img src="<?php echo Yii::app()->baseUrl . 'public/images/barra_n.png'; ?>" />
<br /><br/>
<table border="1" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;width:800px;border-collapse: collapse;
            border-spacing: 0px;
            text-align:left;  ">

    <tr>
        <td colspan="3" align="center" style="background:#E5E5E5; padding:3px;">
            <b>NOTA DE ENTREGA</b>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <b>Elaborado para:</b> 
            <?php 
            $meses=Utiles::getMeses();
            $mesesito=$meses[$mes];
            echo $mesesito." de ".$anio; ?>
        </td>
       

    </tr>
    <tr>
        <td>
            <b>Codigo:</b> 
            <?php echo $codigo; ?></td>
        <td >
            <b>Fecha:</b>
            <?php echo $fecha; ?>
        </td>
        <td>
            <b>Dias habiles:</b>
            <?php echo $dias_habiles; ?>
        </td>

    </tr>
    <tr>

        <td>
            <b>Forma de pago:</b>
            <?php echo $forma_pago; ?>
        </td>
        <td>
            <b>Anticipo:</b>
            <?php echo $anticipo; ?>
        </td>
        <td>
            <b>Lugar de Entrega:</b>
            <?php echo $lugar_entrega; ?>
        </td>


    </tr>


</table>
<table border="1" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;width:800px;border-collapse: collapse;
            border-spacing: 0px;
            text-align:left;  ">

    <tr>
        <td colspan="3" align="center" style="background:#E5E5E5; padding:3px;">
            <b>DATOS DEL PROVEEDOR</b>
        </td>
    </tr>

    <tr>
        <td>
            <b>Rif:</b> 
            <?php echo $rif; ?></td>
        <td>
            <b>Nombre:</b>
            <?php echo $razon_social; ?>
        </td>
        <td>
            <b>Telefono:</b>
            <?php echo $telefono_proveedor; ?>
        </td>

    </tr>
    <tr>
        <td>
            <b>Telefono Otro:</b>
            <?php echo $telefono_proveedor_otro; ?>
        </td>

        <td>
            <b>Estado:</b>
            <?php echo $estado_proveedor; ?>
        </td>
        <td>
            <b>Municipio:</b>
            <?php echo $municipio_proveedor; ?>
        </td>

    </tr>
    <tr>
<td>
            <b>Tipo de Servicio:</b>
            <?php echo $tipo_servicio; ?>
        </td>

        <td colspan="2">
            <b>Dirección:</b>
            <?php echo $direccion_proveedor; ?>
        </td>
        
         
    </tr>


</table>


<table border="1" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;width:800px;border-collapse: collapse;
            border-spacing: 0px;
            text-align:left;  ">

    <tr>
        <td colspan="3" align="center" style="background:#E5E5E5; padding:3px;">
            <b>DATOS DEL PLANTEL</b>
        </td>
    </tr>

    <tr>
        <td>
            <b>C&oacute;digo Estad&iacute;stico:</b>
            <?php echo $cod_estadistico; ?>
        </td>
        <td>
            <b>C&oacute;digo del plantel:</b> 
            <?php echo $cod_estadistico; ?></td>
        <td>
            <b>Nombre del Plantel:</b>
            <?php echo $dependencia; ?>
        </td>
    </tr>
    <tr>

        <td>
            <b>Zona Educativa:</b>
            <?php echo $unidad_ejecutora; ?>
        </td>


        <td>
            <b>Estado:</b>
            <?php echo $estado_plantel; ?>
        </td>
        <td>
            <b>Municipio:</b>
            <?php echo $municipio_plantel; ?>
        </td>

    </tr>
    <tr>

        <td colspan="3">
            <b>Dirección:</b>
            <?php echo $direccion_plantel; ?>
        </td>


    </tr>

</table>

<table  border="1" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;width:800px;border-collapse: collapse;
            border-spacing: 0px;
            text-align:center;  ">
    <tr>
        <th colspan="14" align="center" style="background:#E5E5E5; padding:3px;">
            DETALLE DEL PEDIDO
        </th>  
    </tr>
</table>
<table border="1" class="estudiantes" style="font-size:8px; font-family:Helvetica Neue,Arial,Helvetica,sans-serif;width:800px;border-collapse: collapse;
       border-spacing: 0px;
       text-align:center;  ">
    <tr style="">
        <th width="50px" style=" "  rowspan="2" class="center">
            N°
        </th>
        <th width="300px" style=" "  rowspan="2"  class="center">
          <?php echo ucwords(strtolower($tipo_servicio)); ?>
        </th>
        <th width="150px" style=" "  rowspan="2"  class="center">
            Cantidad
        </th>
        <th width="150px" style=" "  rowspan="2"  class="center">
            Precio
        </th>
        <th width="150px" style=" " rowspan="2"  class="center">
            Sub-Total
        </th>

    </tr>
</table>