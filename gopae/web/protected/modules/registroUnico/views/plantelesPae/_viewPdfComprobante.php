<?php
/**
 * Created by PhpStorm.
 * User: jsinner
 * Date: 25/11/14
 * Time: 08:05 AM
 */ ?>
<style>
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}
</style>
<div style="font-family: Verdana;">
    <div align="right" style="font-size: 9px;">
        Nro: <?php echo $codigo_seguridad; ?>
    </div>
    <p align="center"> 
        Corporaci&oacute;n Nacional de Alimentaci&oacute;n Escolar S. A. 
        <br/>
        <?php echo ucwords(strtolower($plantel['estado'])); ?>
    </p>
    <div align="center" style="text-align: center; font-family: Verdana; font-weight:bold;"> Constancia de Servicio (CNAE, S.A.) </div>
    <br/>
        <table width="100%" style="font-family: Verdana; font-size:10px; width:100%; border: solid 1px #002b36;">
            <tr>
                <td colspan="3" align="center" style="background:#E5E5E5; padding:2px;">
                    <b>IDENTIFICACI&Oacute;N DE LA INSTITUCI&Oacute;N EDUCATIVA</b>
                </td>
            </tr>
            <tr>
                <th align="left" colspan="3">
                    Nombre
                </th>
            </tr>
            <tr>
                <td colspan="3">
                    <?php echo htmlentities($plantel['nombre_plantel']); ?>
                </td>
            </tr>
            <tr>
                <th align="left">
                    Zona Educativa
                </th>
                <th align="left">
                    Denominaci&oacute;n
                </th>
                <th align="left">
                    C&oacute;digo CNAE
                </th>
            </tr>
            <tr>
                <td>
                    <?php echo htmlentities($plantel['zona_educativa']); ?>
                </td>
                <td>
                    <?php echo htmlentities($plantel['denominacion']); ?>
                </td>
                <td>
                    <?php echo htmlentities($plantel['cod_cnae']); ?>
                </td>
            </tr>
            <tr>
                <th align="left">
                    C&oacute;digo DEA
                </th>
                
                <th align="left">
                    C&oacute;digo Estad&iacute;stico
                </th>
                <th align="left">
                    <?php if(strlen($plantel['codigo_ner'])>0): ?>C&oacute;digo NER<?php else: echo " "; endif; ?>
                </th>
            </tr>
            <tr>
                <td>
                    <?php echo ($plantel['registro_cnae']!='S' && strpos($plantel['cod_plantel'], 'CNAE')===false)?htmlentities($plantel['cod_plantel']):'Sin C&oacute;digo DEA'; ?>
                </td>
                <td>
                    <?php echo ($plantel['registro_cnae']!='S' && strpos($plantel['cod_plantel'], 'CNAE')===false)?htmlentities($plantel['cod_estaditico']):''; ?>
                </td>
                <td>
                    <?php if(strlen($plantel['codigo_ner'])>0): echo htmlentities($plantel['codigo_ner']); else: echo " "; endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" style="">
                    <b>&nbsp;-&nbsp;-&nbsp;-&nbsp;</b>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" style="background:#E5E5E5; padding:2px;">
                    <b>UBICACI&Oacute;N DE LA INSTITUCI&Oacute;N EDUCATIVA</b>
                </td>
            </tr>
            <tr>
                <th align="left">
                    Estado
                </th>
                <th align="left">
                    Municipio
                </th>
                <th align="left">
                    Parroquia
                </th>
            </tr>
            <tr>
                <td>
                    <?php echo htmlentities($plantel['estado']); ?>
                </td>
                <td>
                    <?php echo htmlentities($plantel['municipio']); ?>
                </td>
                <td>
                    <?php echo htmlentities($plantel['parroquia']); ?>
                </td>
            </tr>
            <tr>
                <th colspan="3" align="left">
                    Direcci&oacute;n Referencial
                </th>
            </tr>
            <tr>
                 <td colspan="3">
                    <?php echo htmlentities($plantel['direccion']); ?>
                </td>
            </tr>
            <tr>
                <th align="left" colspan="3">
                    Consejo Comunal
                </th>
            </tr>
            <tr>
                <td colspan="3">
                    <?php echo htmlentities($plantel['consejo_comunal']); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" style="">
                    <b>&nbsp;-&nbsp;-&nbsp;-&nbsp;</b>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" style="background:#E5E5E5; padding:2px;">
                    <b>DIRECTOR DE LA INSTITUCI&Oacute;N EDUCATIVA</b>
                </td>
            </tr>
            <tr>
                <th align="left">
                    C&eacute;dula de Identidad
                </th>
                <th align="left">
                    Nombre y Apellido
                </th>
                <th align="left">
                    Tel&eacute;fono
                </th>
            </tr>
            <tr>
                <td>
                    <?php echo htmlentities($plantel['origen_director'].'-'.$plantel['cedula_director']); ?>
                </td>
                <td>
                    <?php echo htmlentities($plantel['nombre_director'].' '.$plantel['apellido_director']); ?>
                </td>
                <td>
                    <?php echo htmlentities(str_pad($plantel['telefono_director'], 11, '0', STR_PAD_LEFT)); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" style="">
                    <b>&nbsp;-&nbsp;-&nbsp;-&nbsp;</b>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" style="background:#E5E5E5; padding:2px;">
                    <b>ENLACE CNAE EN LA INSTITUCI&Oacute;N EDUCATIVA</b>
                </td>
            </tr>
            <tr>
                <th align="left">
                    C&eacute;dula de Identidad
                </th>
                <th align="left">
                    Nombre y Apellido
                </th>
                <th align="left">
                    Tel&eacute;fono
                </th>
            </tr>
            <tr>
                <td>
                    <?php echo htmlentities($plantel['origen_enlace_cnae'].'-'.$plantel['cedula_enlace_cnae']); ?>
                </td>
                <td>
                    <?php echo htmlentities($plantel['nombre_enlace_cnae'].' '.$plantel['apellido_enlace_cnae']); ?>
                </td>
                <td>
                    <?php echo htmlentities(str_pad($plantel['telefono_enlace_cnae'], 11, '0', STR_PAD_LEFT)); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" style="">
                    <b>&nbsp;-&nbsp;-&nbsp;-&nbsp;</b>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" style="background:#E5E5E5; padding:2px;">
                    <b>DATOS DEL SERVICIO CNAE</b>
                </td>
            </tr>
            <tr>
                <th align="left">
                    Matr&iacute;cula
                </th>
                <th align="left">
                    Madres Colaboradoras
                </th>
                <th align="left">
                    Proveedor Actual
                </th>
            </tr>
            <tr>
                <td>
                    <?php echo htmlentities((int)$plantel['matricula_educacion_tecnica'] + (int)$plantel['matricula_educacion_media_general'] + (int)$plantel['matricula_educacion_primaria'] + (int)$plantel['matricula_preescolar'] + (int)$plantel['matricula_maternal']); ?>
                </td>
                <td>
                    <?php echo htmlentities((int)$plantel['cantidad_madres_procesadoras']); ?>
                </td>
                <td>
                    <?php echo (in_array($plantel['siglas_proveedor_actual'], array('MERCAL', 'PDVAL')))?htmlentities($plantel['siglas_proveedor_actual']):htmlentities($plantel['razon_social_proveedor_actual']); ?>
                </td>
            </tr>
            <tr>
                <th align="left">
                    Fecha de Emisi&oacute;n
                </th>
                <th align="left">
                    Fecha de Vencimiento
                </th>
                <th align="left">
                    &nbsp;- - -
                </th>
            </tr>
            <tr>
                <td>
                    <?php echo date('d-m-Y'); ?>
                </td>
                <td>
                    <?php echo htmlentities(Utiles::transformDate($fecha_vencimiento, '-', 'y-m-d', 'd-m-y')); ?>
                </td>
                <td>
                    &nbsp;- - -
                </td>
            </tr>
        </table>
        
    <div align="center" style="padding-top: 33px; font-family: Verdana; font-size:8px; text-align: center; font-style: italic;">
        <b>ING. MIGUEL ÁNGEL MARÍN GRATEROL</b><br/>
        PRESIDENTE DE LA CORPORACIÓN NACIONAL DE ALIMENTACIÓN ESCOLAR, CNAE, S.A. <br/>
        Resolución DM/N° 00138 de fecha 18 de noviembre de 2014, publicada en Gaceta Oficial de la República Bolivariana de Venezuela <br/>
        N° 40.547 de fecha 24 de noviembre de 2014.
    </div>
    
    <div align="center" style="padding-top: 10px; font-family: Verdana; font-size:11px; text-align: center;">
        <img height="30%" src="<?php echo '/var/www/gopae/web/public/downloads/comprobantesPae/qr/'.$codigo_seguridad; ?>.png" />
    </div>
    
    <div align="center" style="padding-top: 15px; font-family: Verdana; font-size:7px; text-align: center; font-style: italic;">
        <b>"200 años después... Independencia y Revolución"</b><br/>
        Esq. de Salas a Caja de Agua, Edif. Sede del MPPE, Piso 16, Coordinación Nacional del Programa de Alimentación Escolar (P.A.E.)<br/>
        Parroquia Altagracia, Municipio Libertador Dtto. Capital, Caracas - Venezuela, <br/>
        Telf. (0212) 506.89.38/506.42.92.
    </div>

</div>
