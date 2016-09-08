<?php $fecha_creacion = date("d-m-Y H:i:s", strtotime($model->fecha_ini)); ?>
<?php $fecha_actualizacion = date("d-m-Y H:i:s", strtotime($model->fecha_act)); ?>
<?php $fecha_eliminacion = date("d-m-Y H:i:s", strtotime($model->fecha_elim)); ?>

<?php
//list($solicitante) = explode(";", $model->descripcion);
$ticket = json_decode($model->descripcion);
//var_dump($ticket); die();
$observacion = $model->observacion;
$reg_historico = explode("\n", $model->observacion . "\n");
$necesidad = ' N/A ';
if (isset($reg_historico[0])) {
    $datos_necesidad = explode(" | ", $reg_historico[0]);
    $necesidad = (isset($datos_necesidad[1])) ? $datos_necesidad[1] . ' ' : ' N/A ';
}
?>
<table>
    <caption style="font-size: 15px; margin-left: 6px;"> Información de la Solicitud <?php echo CHtml::encode($model->codigo); ?> </caption>

    <tr>

        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Tipo de Solicitud</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona">  <?php echo CHtml::encode($model->tipoTicket->nombre); ?> </span>
                    </div>
                </div>
            </div>
        </td>

    </tr>

    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Unidad Responsable Actual</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona">  <?php echo CHtml::encode((is_object($model->bandejaActual)) ? $model->bandejaActual->nombre : 'N/A'); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Asignado a</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona">  <?php echo CHtml::encode((is_object($model->responsableAsignado)) ? $model->responsableAsignado->nombre . ' ' . $model->responsableAsignado->apellido : 'N/A'); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped" >
                    <div class="profile-info-name"><b><i>Codigo del Plantel</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona"> <?php echo CHtml::encode($ticket->codigo_plantel); ?></span>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td>

            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Documento de Identidad</i></b></div>
                    <div class="profile-info-value">
                        <span id="estado"><i><?php echo CHtml::encode($ticket->origen.'-'.$ticket->cedula); ?> </i></span>
                    </div>
                </div>
            </div>

        </td>
    </tr>

    <tr>
        <td>

            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Nombres</i></b></div>
                    <div class="profile-info-value">
                        <span id="estado"><?php echo CHtml::encode($ticket->nombres); ?></span>
                    </div>
                </div>
            </div>

        </td>
    </tr>

    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped" >
                    <div class="profile-info-name"><b><i>Apellido</i></b></div>
                    <div class="profile-info-value">
                        <span id="estado"> <?php echo CHtml::encode($ticket->apellidos); ?> </span>
                    </div>
                </div>
            </div>

        </td>
    </tr>
    
    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Teléfono Fijo</i></b></div>
                    <div class="profile-info-value">
                        <span id="estado"> <?php echo CHtml::encode($ticket->telefono_fijo.'&nbsp;'); ?> </span>
                    </div>
                </div>
            </div>

        </td>
    </tr>
    
    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Teléfono Celular</i></b></div>
                    <div class="profile-info-value">
                        <span id="estado"> <?php echo CHtml::encode($ticket->telefono_celular.'&nbsp;'); ?> </span>
                    </div>
                </div>
            </div>

        </td>
    </tr>
    
    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Correo Electrónico</i></b></div>
                    <div class="profile-info-value">
                        <span id="estado"> <?php echo CHtml::encode($ticket->email.'&nbsp;'); ?> </span>
                    </div>
                </div>
            </div>

        </td>
    </tr>
    
    <tr>
        <td>

            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped" style="min-height: 60px;">
                    <div class="profile-info-name"><b><i>Observación</i></b></div>
                    <div class="profile-info-value">
                        <span id="estado"><i><?php echo CHtml::encode($ticket->observacion.'&nbsp;'); ?> </i></span>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Estatus</i></b></div>
                    <div class="profile-info-value">
                        <span id="estatus">  <?php echo CHtml::encode(strtr($model->estatus, array('A' => 'Activo', 'E' => 'Eliminado', 'S' => 'Resuelto', 'R' => 'Redireccionado', 'D' => 'Devuelto', 'P' => 'Asignado'))); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>

</table>


<table>
    <caption style="font-size: 15px; margin-left: 6px;"> Historial de la Solicitud </caption>
    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Aperturado por:</i></b></div>

                    <div class="profile-info-value">
                        <span id="nombre_zona"> <?php echo (is_object($model->usuarioIni)) ? $model->usuarioIni->nombre . ' ' . $model->usuarioIni->apellido : ''; ?></span>
                    </div>
                </div>
            </div>

        </td>
    </tr>


    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Fecha Inicial:</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona"> <?php echo $fecha_creacion; ?></span>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <?php if (!empty($model->fecha_act) && !empty($model->usuario_ini_id)): ?>
        <tr>
            <td>
                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Atendido Últimamente por</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"> <?php echo (is_object($model->usuarioAct)) ? $model->usuarioAct->nombre . ' ' . $model->usuarioAct->apellido : ''; ?> </span>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="profile-info-row profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Fecha de Actualización</i></b></div>
                    <div class="profile-info-value">
                        <span id="estado"><i><?php echo $fecha_actualizacion; ?> </i></span>
                    </div>
                </div>
            </td>
        </tr>
    <?php endif; ?>

    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Registro Histórico</i></b></div>

                    <div class="profile-info-value">
                        <span id="observacion"> <p style="width: 50%"> <?php echo str_replace('|', '<br/>', CHtml::encode($observacion)); ?> </p></span>
                    </div>
                </div>
            </div>

        </td>
    </tr>
</table>
