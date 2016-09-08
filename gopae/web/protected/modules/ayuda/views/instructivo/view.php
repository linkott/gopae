
<?php $fecha_creacion = date("d-m-Y H:i:s", strtotime($model->fecha_ini)); ?>
<?php $fecha_actualizacion = date("d-m-Y H:i:s", strtotime($model->fecha_act)); ?>
<?php $fecha_eliminacion = date("d-m-Y H:i:s", strtotime($model->fecha_elim)); ?>
<table>
    <caption style="font-size: 15px; margin-left: 6px;"> Información de la Solicitud </caption>

     <tr>

        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Nombre</i></b></div>
                    <div class="profile-info-value">
                        <span id="estado"> <?php echo $model->nombre; ?> </span>
                    </div>
                </div>
            </div>
        </td>

    </tr>


    <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name" ><b><i>Imagen</i></b></div>
                    <div class="profile-info-value">
                        <?php if(!empty($model->url)): ?>
                            <a href="<?php echo Yii:: app()->baseUrl . $model->url; ?>" target="_blank" class="fa fa-cloud-download orange"></a>
                        <?php
                              else:
                                    echo "No tiene ningún archivo.";
                              endif;
                        ?>
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
                        <span id="estatus">  <?php echo CHtml::encode($model->estatus); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <?php if(empty($model->descripcion)):?>
<tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Descripción</i></b></div>
                    <div class="profile-info-value">
                        <span id="descripcion">  <?php echo "No asignada ninguna descripcion"; ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>
<?php
        endif;
        ?>
    <?php if(!empty($model->descripcion)):?>
     <tr>
        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Descripción</i></b></div>
                    <div class="profile-info-value">
                        <span id="descripcion">  <?php echo CHtml::encode($model->descripcion); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <?php endif; ?>

</table>

<table>
    <caption style="font-size: 15px; margin-left: 6px;"> Detalles de Auditoria </caption>
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


</table>