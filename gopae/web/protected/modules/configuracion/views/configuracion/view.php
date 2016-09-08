
<?php $fecha_creacion = date("d-m-Y H:i:s", strtotime($model->fecha_ini)); ?>
<?php $fecha_actualizacion = date("d-m-Y H:i:s", strtotime($model->fecha_act)); ?>

<table>
    <caption style="font-size: 15px; margin-left: 6px;"> Información de la Configuración </caption>
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
    </tr>
    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Descripción</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona"> <?php echo CHtml::encode($model->descripcion); ?></span>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <?php if (!empty($model->cod_tipo_dato)): ?>
        <tr>
            <td>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Tipo de Dato</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><i><?php echo CHtml::encode($model->cod_tipo_dato); ?> </i></span>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    <?php endif; ?>

    <?php if (!empty($model->valor_bool)): ?>
        <tr>
            <td>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Valor Bool</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><?php echo CHtml::encode($model->valor_bool); ?></span>
                        </div>
                    </div>
                </div>

            </td>
        </tr>
    <?php endif; ?>
    <?php if (!empty($model->valor_cod)): ?>
        <tr>
            <td>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Valor Codigo</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><?php echo CHtml::encode($model->valor_cod); ?></span>
                        </div>
                    </div>
                </div>

            </td>
        </tr>
    <?php endif; ?>

    <?php if (!empty($model->valor_str)): ?>
        <tr>
            <td>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Valor lString</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><?php echo CHtml::encode($model->valor_str); ?></span>
                        </div>
                    </div>
                </div>

            </td>
        </tr>
    <?php endif; ?>


    <?php if (!empty($model->valor_tex)): ?>
        <tr>
            <td>

                <div class="profile-info-row">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-name"><b><i>Valor Text</i></b></div>
                        <div class="profile-info-value">
                            <span id="estado"><?php echo CHtml::encode($model->valor_txt); ?></span>
                        </div>
                    </div>
                </div>

            </td>
        </tr>
    <?php endif; ?>
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

</table>
