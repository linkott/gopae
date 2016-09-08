<?php $fecha_hora = date("d-m-Y H:i:s", strtotime($model->fecha_hora)); ?>
<table>
    <caption style="font-size: 15px; margin-left: 6px;"> Información del Ticket </caption>
    <tr>

        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Username</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona">  <?php echo CHtml::encode($model->username); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>

        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Fecha</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona">  <?php echo CHtml::encode($fecha_hora); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>
                        <tr>

        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Ip</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona">  <?php echo CHtml::encode($model->ip_maquina); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>

                        <tr>

        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Tipo Transacción</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona">  <?php echo CHtml::encode($model->tipo_transaccion); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>
                         <tr>

        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Modulo</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona">  <?php echo CHtml::encode($model->modulo); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <?php if(!empty($model->resultado_transaccion)){?>
    <tr>

        <td>
            <div class="profile-info-row">
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-name"><b><i>Resultado Transacción</i></b></div>
                    <div class="profile-info-value">
                        <span id="nombre_zona">  <?php echo CHtml::encode($model->resultado_transaccion); ?> </span>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <?php }?>

                    </table>
