    <table style="font-size:11px; width:800px;">

        <tr>
            <td colspan="6" align="center" style="background:#E5E5E5; padding:5px;">
                <b>IDENTIFICACI&Oacute;N DEL PLANTEL</b>
            </td>
        </tr>

        <tr colspan="6">
            <td>
                <?php
                if($model->codigo_ner != '')
                {
                    ?>
                        <label for="Plantel_cod_plantel"><b>C&oacute;digo NER</b></label>
                        <label class="span-7"><?php echo $model->codigo_ner;?></label>
                    <?php
                }
                ?>

            </td>
        </tr>

        <tr>
            <td><b>C&oacute;digo del plantel</b></td>
            <td>
                <?php echo $model->cod_plantel;?>
            </td>
            <td><b>C&oacute;digo estad&iacute;stico</b></td>
            <td>
                <?php echo $model->cod_estadistico;?>
            </td>
            <td><b>Denominaci&oacute;n</b></td>
            <td>
                <?php
                    if(!empty($model->parroquia_id))
                    {
                        echo $model->parroquia->nombre;
                    }
                ?>
            </td>
        </tr>

        <tr>
            <td><b>Nombre</b></td>
            <td>
                <?php echo $model->nombre;?>
            </td>
            <td><b>Estatus</b></td>
            <td>
                <?php
                    if(!empty($model->estatus_plantel_id))
                    {
                        echo $model->estatusPlantel->nombre;
                    }
                ?>
            </td>
            <td><b>A&ntilde;o de fundaci&oacute;n</b></td>
            <td>
                <?php echo $model->annio_fundado;?>
            </td>
        </tr>

    </table>





<br>










    <table style="font-size:11px; width:800px;">

        <tr>
            <td colspan="6" align="center" style="background:#E5E5E5; padding:5px;">
                <b>DATOS DE UBICACI&Oacute;N</b>
            </td>
        </tr>

        <tr>
            <td><b>Estado</b></td>
            <td>
                <?php
                    if(!empty($model->estado_id))
                    {
                        echo $model->estado->nombre;
                    }
                ?>
            </td>
            <td><b>Municipio</b></td>
            <td>
                <?php
                    if(!empty($model->municipio_id))
                    {
                        echo $model->municipio->nombre;
                    }
                ?>
            </td>
            <td><b>Parroquia</b></td>
            <td>
                <?php
                    if(!empty($model->parroquia_id))
                    {
                        echo $model->parroquia->nombre;
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td><b>Poblaci&oacute;n</b></td>
            <td>
                <?php echo $model->poblacion->nombre;?>
            </td>
            <td><b>Urbanizaci&oacute;n</b></td>
            <td>
                <?php echo $model->urbanizacion->nombre;?>
            </td>

            <td><b>Tipo de Via</b></td>
            <td>
                <?php echo $model->tipo_via->nb_tipo_via;?>
            </td>
            
        </tr>
        <tr>
             <td><b>Via</b></td>
            <td>
                <?php echo $model->via;?>
            </td> 
            <td><b>Direcci&oacute;n</b></td>
            <td>
                <?php echo $model->direccion;?>
            </td>
            <td><b>Tel&eacute;fono fijo</b></td>
            <td>
                <?php echo $model->telefono_fijo;?>
            </td>
        </tr>

        <tr>
            <td><b>Otro tel&eacute;fono</b></td>
            <td>
                <?php echo $model->telefono_otro;?>
            </td>
            <td><b>Nro Fax</b></td>
            <td>
                <?php echo $model->nfax;?>
            </td>
            <td><b>Correo</b></td>
            <td>
                <?php echo $model->correo;?>
            </td>
        </tr>

        <tr>
            <td><b>Zona de ubicaci&oacute;n</b></td>
            <td>
                <?php
                    if(!empty($model->zona_ubicacion_id))
                    {
                        echo $model->zonaUbicacion->nombre;
                    }
                ?>
            </td>
        </tr>

    </table>






<br>



    <table style="font-size:11px; width:800px;">

        <tr>
            <td colspan="6" align="center" style="background:#E5E5E5; padding:5px;">
                <b>OTROS DATOS</b>
            </td>
        </tr>

        <tr>
            <td><b>Clase plantel</b></td>
            <td>
                <?php
                    if(!empty($model->clase_plantel_id))
                    {
                        echo $model->clasePlantel->nombre;
                    }
                ?>
            </td>
            <td><b>Categor&iacute;a</b></td>
            <td>
                <?php
                    if(!empty($model->categoria_id))
                    {
                        echo $model->categoria->nombre;
                    }
                ?>
            </td>
            <td><b>Condici&oacute;n de estudio</b></td>
            <td>
                <?php
                    if(!empty($model->condicion_estudio_id))
                    {
                        echo $model->condicionEstudio->nombre;
                    }
                ?>
            </td>
        </tr>

        <tr>
            <td><b>Tipo matricula</b></td>
            <td>
                <?php
                    if(!empty($model->genero_id))
                    {
                        echo $model->genero->nombre;
                    }
                ?>
            </td>
            <td><b>Turno</b></td>
            <td>
                <?php
                    if(!empty($model->turno_id))
                    {
                        echo $model->turno->nombre;
                    }
                ?>
            </td>
            <td><b>R&eacute;gimen</b></td>
            <td>
                <?php
                    if(!empty($model->regimen_id))
                    {
                        echo $model->modalidad->nombre;
                    }
                ?>
            </td>
        </tr>

    </table>
    

<br>


    <table style="font-size:11px; width:800px;">

        <tr>
            <td colspan="6" align="center" style="background:#E5E5E5; padding:5px;">
                <b>SERVICIO</b>
            </td>
        </tr>

                    
        <tr>
            <th>
                <center>
                    <b>Servicio</b>
                </center>
            </th>
            <th>
                <center>
                    <b>Desde</b>
                </center>
            </th>
            <th>
                <center>
                    <b>Condici&oacute;n</b>
                </center>
            </th>
        </tr>

            <?php
            $resultado = ServicioPlantel::model()->obtenerServiciosPlantel($model->id);
            foreach ($resultado as $result)
            {
            echo '
                <tr class="odd">
                    <td>
                        <div>
                            '.$result['servicio'].'
                        </div>
                    </td>
                    <td>
                        <div>
                            '.$result['fecha_desde'].'
                        </div>
                    </td>
                    <td>
                        <div>
                            '.$result['nombre'].'
                        </div>
                    </td>
                </tr>
                ';

            }
            if($resultado == NULL)
            {
                echo
                '
                    <tr>
                        <td colspan="3">
                            No se encuentran servicios registrados en este plantel.
                        </td>
                    </tr>
                ';
            }
        ?>
                    

    </table>


<br>


    <table style="font-size:11px; width:800px;">

        <tr>
            <td colspan="6" align="center" style="background:#E5E5E5; padding:5px;">
                <b>PROYECTO END&Oacute;GENO</b>
            </td>
        </tr>
        <?php
            $resultado = ProyectosEndogenos::model()->obtenerDesarrolloEndogenosPlantel($model->id);
            foreach ($resultado as $result)
            {
                echo
                '
                    <tr class="odd">
                        <td>
                            <div>
                                '.$result['nombre'].'
                            </div>
                        </td>
                    </tr>
                ';
            }
            if($resultado == NULL)
            {
                echo
                '
                    <tr>
                        <td>
                            Este plantel no posee Proyecto End&oacute;geno.
                        </td>
                    </tr>
                ';
            }
        ?>

    </table>


<br>


    <table style="font-size:11px; width:800px;">

        <tr>
            <td colspan="6" align="center" style="background:#E5E5E5; padding:5px;">
                <b>AUTORIDADES</b>
            </td>
        </tr>
            <?php
                $datosAutoridades = AutoridadPlantel::model()->datosAutoridades($model->id);
            ?>

        <tr>
            <td>
                <center>
                    <b>Cargo</b>
                </center>
            </td>
            <td>
                <center>
                    <b>Nombres</b>
                </center>
            </td>
            <td>
                <center>
                    <b>C&eacute;dula</b>
                </center>
            </td>
            <td>
                <center>
                    <b>Correo</b>
                </center>
            </td>
            <td>
                <center>
                    <b>Tel&eacute;fono</b>
                </center>
            </td>
        </tr>
            <?php
            foreach ($datosAutoridades as $result)
            {
            echo '
                <tr class="odd">
                    <td>
                        <div>
                            '.$result['cargo'].'
                        </div>
                    </td>
                    <td>
                        <div>
                            '.$result['nombre'].'
                            '.$result['apellido'].'
                        </div>
                    </td>
                    <td>
                        <div>
                            '.$result['cedula'].'
                        </div>
                    </td>
                    <td>
                    <div>
                        '.$result['email'].'
                    </div>
                </td>
                <td>
                    <div>
                        '.$result['telefono'].'
                    </div>
                </td>
                <!--<td>
                    <div>
                    </div>
                </td>
                -->
            </tr>
            ';

        }
        if($datosAutoridades == NULL)
        {
            echo
            '
                <tr>
                    <td colspan="5">
                        Este plantel no se le ha asignado Autoridades.
                    </td>
                </tr>
            ';
        }
    ?>

    </table>