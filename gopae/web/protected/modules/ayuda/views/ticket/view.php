<?php $resultado = Ticket::model()->buscar($model->id); ?>
<?php $resultado2 = Ticket::model()->buscar2($model->id); ?>
<?php foreach ($resultado as $r) { ?>
    <?php $fecha_creacion = date("d-m-Y H:i:s", strtotime($r['fecha_ini'])); ?>
    <?php $fecha_eliminacion = date("d-m-Y H:i:s", strtotime($r['fecha_elim'])); ?>
    <table>
        <caption style="font-size: 15px; margin-left: 15px;"> Informacion </caption>
        <?php
        list($cedula, $nombre, $apellido, $celular, $fijo, $correo, $estado, $grupo, $solicitante) = explode(";", $r['descripcion']);
        ?>
        <tr>
            <td>
                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Cedula</i></b></div>
                        <div class="profile-info-value">
                            <span id="nombre_zona"> <?php echo $cedula; ?></span>
                        </div>
                    </div>
                </div>

            </td>

            <td>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Nombre</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><i><?php echo $nombre; ?> </i></span>
                        </div>
                    </div>
            </td>
            <td>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Apellido</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><?php echo $apellido; ?></span>
                        </div>
                    </div>
                </div>


            </td>
        </tr>
        <tr>

            <td>
                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Celular</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"> <?php echo $celular; ?> </span>
                        </div>
                    </div>

            </td>

            <td>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Telefono Fijo</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><i> <?php echo $fijo; ?></i></span>
                        </div>
                    </div>
                </div>
            </td>



            <td>
                </div>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Correo</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><i><?php echo $correo; ?> </i></span>
                        </div>
                        </
                        </td>


                        <tr>
                            <td>

                                <div class="profile-info-row">
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-name"><b><i>Estado</i></b></div>
                                        <div class="profile-info-value">
                                            <span id="estado"><i> <?php echo $estado; ?></i></span>
                                        </div>
                                    </div>
                            </td>
                            <td>

                                <div class="profile-info-row">
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-name"><b><i>Grupos</i></b></div>
                                        <div class="profile-info-value">
                                            <span id="estado"> <?php echo $grupo; ?> </span>
                                        </div>
                                    </div>
                            </td>
                            <td>

                                <div class="profile-info-row">
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-name"><b><i>Solicitante</i></b></div>
                                        <div class="profile-info-value">
                                            <span id="estado"><i> <?php echo $solicitante; ?></i></span>
                                        </div>
                                    </div>
                            </td>
                        </tr>
                        </table>

                        <table>
                            <caption style="font-size: 15px; margin-left: 15px;"> Acciones </caption>



                            <tr>
                                <td>
                                    <div class="profile-info-row">
                                        <div class="profile-user-info profile-user-info-striped">
                                            <div class="profile-info-name"><b><i>Usuario:</i></b></div>

                                            <div class="profile-info-value">
                                                <span id="nombre_zona"> <?php echo $r['nombre_usuario']; ?></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="profile-info-row">
                                        <div class="profile-user-info profile-user-info-striped">
                                            <div class="profile-info-name"><b><i>Estatus</i></b></div>
                                            <?php
                                            if ($r['estatus'] == "A") {
                                                $columna = "activo";
                                            } else {
                                                $columna = "eliminado";
                                            }
                                            ?>
                                            <div class="profile-info-value">
                                                <span id="estado"><?php echo $columna; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                                <?php foreach ($resultado2 as $r2) { ?>
                                    <?php $fecha_creacion2 = date("d-m-Y H:i:s", strtotime($r2['fecha_act'])); ?>
                                    <?php $fecha_actualizacion2 = date("d-m-Y H:i:s", strtotime($r2['fecha_act'])); ?>
                                    <?php $fecha_eliminacion2 = date("d-m-Y H:i:s", strtotime($r2['fecha_elim'])); ?>

    <?php if ($r2['nombre_usuario'] != null and $r2['fecha_act'] != null) { ?>

                                        <div class="profile-info-row">
                                            <div class="profile-user-info profile-user-info-striped">
                                                <div class="profile-info-name"><b><i>Modificado Por</i></b></div>
                                                <div class="profile-info-value">
                                                    <span id="estado"> <?php echo $r['nombre_usuario']; ?> </span>
                                                </div>
                                            <?php } ?>

    <?php if ($r2['fecha_act'] != null) { ?>


                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"><b><i>Fecha De Actualizacion</i></b></div>
                                                    <div class="profile-info-value">
                                                        <span id="estado"><i><?php echo $fecha_actualizacion2; ?> </i></span>
                                                    </div>


                                                </div>
    <?php } ?>



                                            </td>
                                            </tr>

<?php } ?>

                                        </table>
