<?php $fecha_creacion = date("d-m-Y H:i:s", strtotime($model->fecha_ini)); ?>
<?php $fecha_actualizacion = date("d-m-Y H:i:s", strtotime($model->fecha_act)); ?>
<?php $fecha_eliminacion = date("d-m-Y H:i:s", strtotime($model->fecha_elim)); ?>
<?php
//list($solicitante) = explode(";", $model->descripcion);
    list($zonaEducativa, $dependencia, $cod_plan, $nombrePlantel, $solicitante) = explode(";",$model->descripcion);
$observacion = $model->observacion;
  $reg_historico = explode("\n", $model->observacion."\n");
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
                    <div class="profile-user-info profile-user-info-striped" style="height:60px;">
                        <div class="profile-info-name"><b><i>Zona Educativa</i></b></div>
                        <div class="profile-info-value">
                            <span id="nombre_zona"> <?php echo CHtml::encode($zonaEducativa); ?></span>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Dependencia</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><i><?php echo CHtml::encode($dependencia); ?> </i></span>
                        </div>
                    </div>
                </div>

            </td>
        </tr>

        <tr>
            <td>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped" style="height:60px;">
                        <div class="profile-info-name"><b><i>Código del Plantel</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><?php echo CHtml::encode($cod_plan); ?></span>
                        </div>
                    </div>
                </div>

            </td>
        </tr>

        <tr>
            <td>
                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped" style="height:60px;">
                        <div class="profile-info-name"><b><i>Nombre del Plantel</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"> <?php echo CHtml::encode($nombrePlantel); ?> </span>
                        </div>
                    </div>
                </div>

            </td>
        </tr>

        <tr>
            <td>
                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Solicitante</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><i> <?php echo CHtml::encode($solicitante); ?></i></span>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    <tr>
        <td>

            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Observacion</i></b></div>
                    <div class="profile-info-value">
                        <span id="estado"><i><?php echo CHtml::encode($necesidad); ?> </i></span>
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
                        <span id="estatus">  <?php echo CHtml::encode(strtr($model->estatus, array('A'=>'Activo', 'E'=>'Eliminado', 'S'=>'Resuelto', 'R'=>'Redireccionado', 'D'=>'Devuelto', 'P'=>'Asignado'))); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>

</table>


<table>
    <caption style="font-size: 15px; margin-left: 6px;"> Detalles </caption>
    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Aperturado por:</i></b></div>

                    <div class="profile-info-value">
                        <span id="nombre_zona"> <?php echo (is_object($model->usuarioIni))?$model->usuarioIni->nombre. ' ' .$model->usuarioIni->apellido:''; ?></span>
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
                <div class="profile-info-name"><b><i>Fecha de Actualizacion</i></b></div>
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
                            <span id="nombre_zona"><textarea wrap='off' style="width: 97%; height: 120px; white-space: nowrap;" readonly=""><?php echo CHtml::encode($observacion); ?></textarea></span>
                        </div>
                    </div>
                </div>

            </td>
        </tr>
</table>
