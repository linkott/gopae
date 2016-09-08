<div class="widget-box">

    <div class="widget-header">
        <h5>Identificaci&oacute;n Del Plantel "<?php echo $model->nombre; ?>"</h5>

        <div class="widget-toolbar">
            <a  href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div id="idenPlantel" class="widget-body" >
        <div class="widget-body-inner" >
            <div class="widget-main form">                      

                <div class="row">
                    <div class="col-md-12">
                        <table>
                            <tr>
                                <td rowspan="4" >
                                    <p align= "center">
                                        <img id="tumbnailLogo" style="width:140px;height:140px;" class="img-thumbnail" alt="..." src ="<?php echo (empty($model->logo)) ? Yii::app()->baseUrl . '/public/images/indice.svg' : Yii::app()->baseUrl . '/public/uploads/LogoPlanteles/thumbnail/' . $model->logo; ?>">
                                    </p>
                                </td>
                            </tr>

                            <tr class="col-md-12">

                                <td colspan="3" style="vertical-align: top; width: 50px">
                                    <?php
                                    if ($model->codigo_ner != '') {
                                        ?>
                                        <label for="Plantel_cod_ner"><b>C&oacute;digo NER</b></label>
                                        <label class="span-7">
                                            <input type="text" value="<?php echo $model->codigo_ner; ?>" disabled="disbled">
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </td>

                            </tr>

                            <tr class="col-md-2">
                                <td style="vertical-align: top; width: 50px">

                                    <label for="Plantel_cod_plantel" class="col-md-9 " style="height:25px ">C&oacute;digo del Plantel</label>
                                    <label class="span-7">
                                        <input type="text" value="<?php echo $model->cod_plantel; ?>" class="span-7" disabled="disbled">
                                    </label>

                                </td>

                                <td style="vertical-align: top; width: 50px">

                                    <label for="Plantel_cod_estadistico" class="col-md-9" style="height:25px ">C&oacute;digo Estad&iacute;stico</label>
                                    <label class="span-7">
                                        <input type="text" value="<?php echo $model->cod_estadistico; ?>" class="span-7" disabled="disbled">
                                    </label>

                                </td>

                                <td style="vertical-align: top; width: 50px">

                                    <label for="Pantel_denominacion_id" class="col-md-9" style="height:25px ">Denominaci&oacute;n</label>

                                    <?php
                                    if (empty($model->denominacion_id)) {
                                        $denominacion = '';
                                    } else {
                                        $denominacion = $model->denominacion->nombre;
                                    }
                                    ?>
                                    <label class="span-7">    
                                        <input type="text" value="<?php echo $denominacion; ?>" class="span-7" disabled="disbled">
                                    </label>

                                </td>
                            </tr>

                            <tr class="col-md-11">
                                <td style="vertical-align: top; width: 50px">

                                    <label for="Plantel_nombre" class="col-md-9" style="height:25px ">Nombre del Plantel</label>
                                    <label class="span-7">
                                        <input type="text" value="<?php echo $model->nombre; ?>" class="span-7" readonly="readonly">
                                    </label>
                                </td>

                                <td style="vertical-align: top; width: 50px">

                                    <label for="Plantel_zona_educativa_id" class="col-md-9" style="height:25px ">Zona Educativa</label>

<?php
if (empty($model->zona_educativa_id)) {
    $zonaEducativa = '';
} else {
    $zonaEducativa = $model->zonaEducativa->nombre;
}
?>
                                    <label class="span-7">    
                                        <input type="text" value="<?php echo $zonaEducativa; ?>" class="span-7" readonly="readonly">
                                    </label>

                                </td>

                                <td style="vertical-align: top; width: 50px">

                                    <label for="Plantel_tipo_dependencia_id" class="col-md-9" style="height:25px ">Tipo de Dependencia</label>

<?php
if (empty($model->tipo_dependencia_id)) {
    $tipoDependencia = '';
} else {
    $tipoDependencia = $model->tipoDependencia->nombre;
}
?>
                                    <label class="span-7">    
                                        <input type="text" value="<?php echo $tipoDependencia; ?>" class="span-7" disabled="disabled">
                                    </label>
                                </td>

                            </tr>
                            <tr class="col-md-11">
                                <td style="vertical-align: top; width: 50px">

                                    <label for="Plantel_distrito_id" class="col-md-9" style="height:25px ">Distrito</label> 
<?php
/* PROBLEMA CON LA TABLA DISTRITO MIENTRAS NO TENGA NADA ESTARA ASI, MODIFICADO POR IGNACIO */
// $distrito = Distrito::model()->findAll('id ='.$model->distrito_id);
//echo $distrito[0]['nombre'];
?>
                                    <label class="span-7">
                                        <input type="text" value="<?php #echo $model->distrito_id;  ?>" class="span-7" disabled="disabled">
                                    </label>
                                </td>                                     

                                <td style="vertical-align: top; width: 50px">

                                    <label for="Plantel_estatus_plantel_id" class="col-md-9" style="height:25px ">Estatus</label>
                                    <?php
                                    if (empty($model->estatus_plantel_id)) {
                                        $estatusPlantel = '';
                                    } else {
                                        $estatusPlantel = $model->estatusPlantel->nombre;
                                    }
                                    ?>
                                    <label class="span-7">
                                        <input type="text" value="<?php echo $estatusPlantel; ?>" class="span-7" disabled="disabled">
                                    </label>
                                </td>

                                <td style="vertical-align: top; width: 50px">

                                    <label for="Plantel_annio_fundado" class="col-md-9" style="height:25px ">A&ntilde;o de fundaci&oacute;n</label>
                                    <label class="span-7">
                                        <input type="text" value="<?php echo $model->annio_fundado; ?>" class="span-7" disabled="disabled">
                                    </label>
                                </td>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

<div class="widget-box collapsed" id="datosUbicacionP">

    <div class="widget-header">

        <h5>Datos de Ubicaci&oacute;n</h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-down"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="display: none;">
            <div class="widget-main form">

                <div class="row">

                    <div class="col-md-4" id="divEstado">

                        <label for="Plantel_estado_id" class="span-8">Estado</label>
<?php
if (empty($model->estatus_plantel_id)) {
    $estado = '';
} else {
    $estado = $model->estado->nombre;
}
?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $estado; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divMunicipio">

                        <label for="Plantel_municipio_id" class="span-8">Municipio</label>
                        <?php
                        if (empty($model->municipio_id)) {
                            $municipio = '';
                        } else {
                            $municipio = $model->municipio->nombre;
                        }
                        ?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $municipio; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divParroquia">

                        <label for="Plantel_parroquia_id" class="span-8">Parroquia</label>
                        <?php
                        if (empty($model->parroquia_id)) {
                            $parroquia = '';
                        } else {
                            $parroquia = $model->parroquia->nombre;
                        }
                        ?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $parroquia; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>
                    <!--ALEXIS-->
                    <div class="col-md-4" id="divPoblacion">

                        <label for="Plantel_poblacion_id" class="span-8">Población</label>
<?php
if (empty($model->poblacion_id)) {
    $poblacion = '';
} else {
    $poblacion = $model->poblacion->nombre;
}
?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $poblacion; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divUrbanizacion">

                        <label for="Plantel_urbanizacion_id" class="span-8">Urbanización</label>
<?php
if (empty($model->urbanizacion_id)) {
    $urbanizacion = '';
} else {
    $urbanizacion = $model->urbanizacion->nombre;
}
?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $urbanizacion; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divTipoVia">

                        <label for="Plantel_tipo_via_id" class="span-8">Tipo de Via</label>
<?php
if (empty($model->tipo_via_id)) {
    $tipo_via = '';
} else {
    $tipo_via = $model->tipo_via->nb_tipo_via;
}
?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $tipo_via; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divVia">

                        <label for="Plantel_via_id" class="span-8">Via</label>
                        <?php
                        if (empty($model->via)) {
                            $via = '';
                        } else {
                            $via = $model->via;
                        }
                        ?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $via; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>
                    <!--FIN-->

                    <div class="col-md-4" id="divDireccion">

                        <label for="Plantel_direccion" class="span-8">Direcci&oacute;n</label>
                        <label class="span-8">
                            <input type="text" class="span-7" value="<?php echo $model->direccion; ?>" readonly="readonly">
                        </label>

                    </div>

                    <div class="col-md-4" id="divTelefonoFijo">

                        <label for="Plantel_telefono_fijo" class="span-8">Tel&eacute;fono Fijo</label>
                        <label class="span-8">
                            <input type="text" value="<?php echo $model->telefono_fijo; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divTelefonoOtro">

                        <label for="Plantel_telefono_otro" class="span-8">Otro Tel&eacute;fono</label>
                        <label class="span-8">
                            <input type="text" value="<?php echo $model->telefono_otro; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divNFax">

                        <label for="Plantel_nfax" class="span-8">Nº Fax</label>
                        <label class="span-8">
                            <input type="text" value="<?php echo $model->nfax; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divCorreo">

                        <label for="Plantel_correo" class="span-8">Correo</label>
                        <label class="span-8">
                            <input type="text" value="<?php echo $model->correo; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divZonaUbicacion">

                        <label for="Plantel_zona_ubicacion_id" class="span-8">Zona Ubicaci&oacute;n</label>
<?php
if (empty($model->zona_ubicacion_id)) {
    $zonaUbicacion = '';
} else {
    $zonaUbicacion = $model->zonaUbicacion->nombre;
}
?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $zonaUbicacion; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>


                    <div class="row row-fluid">
                        <div class="col-md-4" id="divFronteriza">
<?php
$resultado = Plantel::model()->obtenerTipoUbicacion($plantel_id);
count($resultado);

if (!empty($resultado)) {
;
    ?> 
                                <label for="fronteriza" >Tipo de ubicaci&oacute;n </label>
                                <label class="span-8">
    <?php
    foreach ($resultado as $result) {
        echo $result['nombre'] . '<input type="checkbox" checked="checked" disabled="disabled"> ';
    }
} else {
    echo "<div></div>";
}
?>
                            </label>
                        </div> 
                    </div>
                </div>

                <div class="widget-header">
                    <h5>Coordenadas Geogr&aacute;ficas</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-body-inner">
                        <div class="widget-main form">
                            <div class="row">
                                <div id="divLogitud" class="col-md-4">
                                    <label for="Plantel_latitud" class="col-md-12 required">Longitud</label>
                                    <input type="text" value="<?php echo $model->longitud; ?>" name="Plantel[longitud]" id="Plantel_longitud"  class="span-7" disabled="disabled">

                                </div>

                                <div id="divLatitud" class="col-md-4">
                                    <label for="Plantel_latitud" class="col-md-12 required">Latitud</label>
                                    <input type="text" value="<?php echo $model->latitud; ?>" name="Plantel[latitud]"  id="Plantel_latitud" class="span-7" disabled="disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

<div class="widget-box collapsed" id="otrosDatosP">
    <div class="widget-header">
        <h5>Otros Datos</h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-down"></i>
            </a>
        </div>
    </div>

    <div class="widget-body" id="infoGeneral">
        <div class="widget-body-inner" style="display: none;">
            <div class="widget-main form">

                <div class="row">

                    <div class="col-md-4" id="divCondicionesEstudio">

                        <label for="Plantel_condicion_estudio_id" class="span-8">Condici&oacute;n Estudio</label>
<?php
if (empty($model->condicion_estudio_id)) {
    $condicionEstudio = '';
} else {
    $condicionEstudio = $model->condicionEstudio->nombre;
}
?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $condicionEstudio; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divGenero">

                        <label for="Plantel_genero_id" class="span-8">Tipo Matricula</label>
<?php
if (empty($model->genero_id)) {
    $genero = '';
} else {
    $genero = $model->genero->nombre;
}
?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $genero; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                    <div class="col-md-4" id="divTurno">

                        <label for="Plantel_turno_id" class="span-8">Turno</label>
<?php
if (empty($model->turno_id)) {
    $turno = '';
} else {
    $turno = $model->turno->nombre;
}
?>
                        <label class="span-8">
                            <input type="text" value="<?php echo $turno; ?>" class="span-7" disabled="disabled">
                        </label>

                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/valid_coordenadas.js', CClientScript::POS_END);
?>

