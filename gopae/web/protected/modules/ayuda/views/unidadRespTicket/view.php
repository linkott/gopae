<input type="hidden" id="unidadRespTicket" name="vista" value="vista_unidadRespTicket">
<?php $fecha_creacion = date("d-m-Y H:i:s", strtotime($model->fecha_ini)); ?>
<?php $fecha_actualizacion = date("d-m-Y H:i:s", strtotime($model->fecha_act)); ?>
<table>
    <tr>

        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Nombre</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona">  <?php echo CHtml::encode($model->nombre); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>

            <?php if (empty($model->telefono_unidad)): ?>
    <tr>
            <td>
                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Telefono de la Unidad</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><i><?php echo "No Asignado"; ?> </i></span>
                        </div>
                    </div>
                </div>
            </td>
    </tr>
            <?php
        endif;
        ?>
        <?php if (!empty($model->telefono_unidad)): ?>
        <tr>
            <td>
                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Telefono de la Unidad</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><i><?php echo CHtml::encode($model->telefono_unidad); ?> </i></span>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
<?php endif; ?>
    <?php if (empty($model->correo_unidad)): ?>
        <tr>
            <td>
                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Correo de la Unidad</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><i><?php echo "No Asignado"; ?> </i></span>
                        </div>
                    </div>
                </div>
            </td>
        </tr>


    <?php
endif;
?>

    <?php if (!empty($model->correo_unidad)): ?>
        <tr>
            <td>
                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Correo de la Unidad</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"> <?php echo CHtml::encode($model->correo_unidad); ?> </span>
                        </div>
                    </div>
                </div>

            </td>
        </tr>
<?php endif; ?>

    <?php ?>
</table>

<table>
    <caption style="font-size: 15px; margin-left: 6px;"> Detalles </caption>
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
                        <div class="profile-info-name"><b><i> Modificado por </i></b></div>
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

</table>


