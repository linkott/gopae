<table style="font-size:11px; width:800px; padding: 8px;">
    <?php foreach ($model as $datos): ?>

        <?php
        if ($datos->tipoTicket->nombre == 'Solicitud de Nuevo Usuario') {
            $descripcion_solicitud_nuevo_usuario = "Solicitud de Nuevo Usuario";
            list($cedula, $nombre, $apellido, $celular, $fijo, $correo, $estado, $grupo, $solicitante) = explode(";", $datos['descripcion']);
        } else if ($datos->tipoTicket->nombre == 'Reporte de Error en el Sistema') {
            $descripcion_error_sistema = "Reporte de Error en el Sistema";
            list($solicitante) = explode(";", $datos['descripcion']);
        } else if ($datos->tipoTicket->nombre == 'Notificación de Plantel no Existente en el Sistema') {
            $descripcion_nuevo_plantel = 'Notificación de Plantel no Existente en el Sistema';
            list($zonaEducativa, $dependencia, $cod_plan, $nombrePlantel, $solicitante) = explode(";", $datos['descripcion']);
        } else if ($datos->tipoTicket->nombre == 'Solicitud de Reseteo de Clave') {
            $descripcion_rec_clave = 'Solicitud de Reseteo de Clave';
            list($cedula, $solicitante, $correo, $celular) = explode(";", $datos['descripcion']);
        } else if ($datos->tipoTicket->nombre == 'Otra Solicitud') {
            $descripcion_otra_solicitud = 'Otra Solicitud';
            list($solicitante) = explode(";", $datos['descripcion']);
        }
        ?>
    <?php if($descripcion_solicitud_nuevo_usuario!='' || $descripcion_error_sistema!='' || $descripcion_nuevo_plantel!='' || $descripcion_rec_clave!='' || $descripcion_otra_solicitud!=''):?>
        <tr>
            <td colspan="12" align="center" style="background:#E5E5E5; padding:5px;">
                <b>Información de la Solicitud <?php echo CHtml::encode($datos['codigo']); ?>  </b>
            </td>
        </tr>
        <tr>
            <?php endif;?>
            <?php if ($descripcion_solicitud_nuevo_usuario == 'Solicitud de Nuevo Usuario'): ?>
            <tr>
                <td> <b> Tipo de Solicitud </b>  </td>
                <td>  <?php echo CHtml::encode($datos->tipoTicket->nombre); ?>  </td>
                <td> <b> Unidad Responsable </b> </td>
                <td> <?php echo CHtml::encode($datos->bandejaActual->nombre); ?>  </td>
                <td> <b> Cedula </b> </td>
                <td>  <?php echo CHtml::encode($cedula); ?>  </td>
                <td> <b> Nombre </b> </td>
                <td>  <?php echo CHtml::encode($nombre); ?>  </td>
                <td> <b> Apellido </b> </td>
                <td>  <?php echo CHtml::encode($apellido); ?>  </td>
            </tr>
            <tr>
                <td> <b> Celular </b> </td>
                <td>  <?php echo CHtml::encode($celular); ?>  </td>
                <td> <b> Telefono Fijo </b> </td>
                <td>  <?php echo CHtml::encode($fijo); ?>  </td>
                <td> <b> Correo </b> </td>
                <td>  <?php echo CHtml::encode($correo); ?>  </td>
                <td> <b> Estado </b> </td>
                <td>  <?php echo CHtml::encode($estado); ?>  </td>
                <td> <b> Grupo </b> </td>
                <td>  <?php echo CHtml::encode($grupo); ?>  </td>
            </tr>
            <tr>
                <td> <b> Estatus </b> </td>
                <td><?php echo CHtml::encode(strtr($datos['estatus'], array('A' => 'Activo', 'E' => 'Eliminado', 'S' => 'Resuelto', 'R' => 'Redireccionado', 'D' => 'Devuelto', 'P' => 'Asignado'))); ?></td>
                <td> <b> Aperturado por </b> </td>
                <td> <?php echo CHtml::encode($datos->usuarioIni->username); ?> </td>

                 <td> <b> Fecha de Apertura </b> </td>
                <td> <?php echo CHtml::encode($datos['fecha_ini']); ?> </td>
                <?php if (!empty($datos->usuarioAct->nombre)): ?>
                    <td> <b> Atendido por </b> </td>
                    <td> <?php echo CHtml::encode($datos->usuarioAct->username); ?> </td>
                <?php endif; ?>
               <?php if (empty($datos['fecha_act'])): ?>
                <td> <b> Atendido por </b> </td>
                <td> <?php echo "N/A" ?> </td>
                <td> <b> Fecha de Atención </b> </td>
                <td> <?php echo "N/A" ?> </td>
            <?php endif; ?>
                <?php if (!empty($datos['fecha_act'])): ?>
            <td> <b> Atendido por </b> </td>
            <td> <?php echo CHtml::encode($datos->usuarioAct->username); ?> </td>
            <td> <b> Fecha de Atención  </b> </td>
            <td> <?php echo CHtml::encode($datos['fecha_act']); ?>  </td>
                <?php endif; ?>
            </tr>
            <tr>
                <td> <b> Estado </b> </td>
                <td> <?php echo CHtml::encode($datos->estado->nombre); ?> </td>
                <td> <b> Observacion </b> </td>
                <td colspan="3">  <?php echo CHtml::encode($datos['observacion']); ?>  </td>
            </tr>


            <?php $descripcion_solicitud_nuevo_usuario = ''; ?>
        <?php endif; ?>
        <?php if ($descripcion_nuevo_plantel == 'Notificación de Plantel no Existente en el Sistema'): ?>
            <tr>
                <td> <b> Tipo de Solicitud </b>  </td>
                <td>  <?php echo CHtml::encode($datos->tipoTicket->nombre); ?>  </td>
                <td> <b> Unidad Responsable </b> </td>
                <td> <?php echo CHtml::encode($datos->bandejaActual->nombre); ?>  </td>
                <td> <b> Zona Educativa </b> </td>
                <td>  <?php echo CHtml::encode($zonaEducativa); ?>  </td>
                <td> <b> Dependencia </b> </td>
                <td>  <?php echo CHtml::encode($dependencia); ?>  </td>
                <td> <b> Codigo del Plan </b> </td>
                <td>  <?php echo CHtml::encode($cod_plan); ?>  </td>
            </tr>
            <tr>
                <td> <b> Nombre del Plantel </b> </td>
                <td>  <?php echo CHtml::encode($nombrePlantel); ?>  </td>
                <td> <b> Solicitante </b> </td>
                <td>  <?php echo CHtml::encode($solicitante); ?>  </td>
                <td> <b> Estatus </b> </td>
                <td><?php echo CHtml::encode(strtr($datos['estatus'], array('A' => 'Activo', 'E' => 'Eliminado', 'S' => 'Resuelto', 'R' => 'Redireccionado', 'D' => 'Devuelto', 'P' => 'Asignado'))); ?></td>
                <td> <b> Aperturado por </b> </td>
                <td> <?php echo CHtml::encode($datos->usuarioIni->username); ?> </td>
            </tr>
           <?php if (empty($datos['fecha_act'])): ?>
                <td> <b> Atendido por </b> </td>
                <td> <?php echo "N/A" ?> </td>
                <td> <b> Fecha de Atención </b> </td>
                <td> <?php echo "N/A" ?> </td>
            <?php endif; ?>
                <?php if (!empty($datos['fecha_act'])): ?>
                <tr>
            <td> <b> Atendido por </b> </td>
            <td> <?php echo CHtml::encode($datos->usuarioAct->username); ?> </td>
            <td> <b> Fecha de Atención  </b> </td>
            <td> <?php echo CHtml::encode($datos['fecha_ini']); ?>  </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td> <b> Estado </b> </td>
                <td> <?php echo CHtml::encode($datos->estado->nombre); ?> </td>
                <td> <b> Observacion </b> </td>
                <td colspan="3">  <?php echo CHtml::encode($datos['observacion']); ?>  </td>
            </tr>
            <?php $descripcion_nuevo_plantel = ''; ?>
        <?php endif; ?>
        <?php if ($descripcion_plantel_inactivo == 'Notificación de Plantel Inactivo'): ?>
            <tr>
                <td> <b> Tipo de Solicitud </b>  </td>
                <td>  <?php echo CHtml::encode($datos->tipoTicket->nombre); ?>  </td>
                <td> <b> Unidad Responsable </b> </td>
                <td> <?php echo CHtml::encode($datos->bandejaActual->nombre); ?>  </td>
                <?php if($datos->responsableAsignado->nombre):?>
                <td> <b> Responsable Asignado </b> </td>
                <td>  <?php echo CHtml::encode($datos->responsableAsignado->nombre); ?>  </td>
                <?php endif;?>
                <td> <b> Zona Educativa </b> </td>
                <td>  <?php echo CHtml::encode($zonaEducativa); ?>  </td>
                <td> <b> Dependencia </b> </td>
                <td>  <?php echo CHtml::encode($dependencia); ?>  </td>
                <td> <b> Código Plantel </b> </td>
                <td>  <?php echo CHtml::encode($cod_plan); ?>  </td>
            </tr>
            <tr>
                <td> <b> Nombre del Plantel </b> </td>
                <td>  <?php echo CHtml::encode($nombrePlantel); ?>  </td>
                <td> <b> Solicitante </b> </td>
                <td>  <?php echo CHtml::encode($solicitante); ?>  </td>
                <td> <b> Estatus </b> </td>
                <td><?php echo CHtml::encode(strtr($datos['estatus'], array('A' => 'Activo', 'E' => 'Eliminado', 'S' => 'Resuelto', 'R' => 'Redireccionado', 'D' => 'Devuelto', 'P' => 'Asignado'))); ?></td>
                <td> <b> Aperturado por </b> </td>
                <td> <?php echo CHtml::encode($datos->usuarioIni->username); ?> </td>
            </tr>
            <tr>
             <?php if (empty($datos['fecha_act'])): ?>
                <td> <b> Atendido por </b> </td>
                <td> <?php echo "N/A" ?> </td>
                <td> <b> Fecha de Atención </b> </td>
                <td> <?php echo "N/A" ?> </td>
            <?php endif; ?>
                <?php if (!empty($datos['fecha_act'])): ?>
            <td> <b> Atendido por </b> </td>
            <td> <?php echo CHtml::encode($datos->usuarioAct->username); ?> </td>
            <td> <b> Fecha de Atención  </b> </td>
            <td> <?php echo CHtml::encode($datos['fecha_ini']); ?>  </td>
        </tr>
        </tr>
        <?php endif; ?>
            </tr>
            <tr>
                <td> <b> Estado </b> </td>
                <td> <?php echo CHtml::encode($datos->estado->nombre); ?> </td>
                <td> <b> Observacion </b> </td>
                <td colspan="3">  <?php echo CHtml::encode($datos['observacion']); ?>  </td>
            </tr>

            <?php $descripcion_plantel_inactivo = ''; ?>
        <?php endif; ?>
        <?php if ($descripcion_error_sistema == 'Reporte de Error en el Sistema'): ?>
            <tr>
                <td> <b> Tipo de Solicitud </b>  </td>
                <td>  <?php echo CHtml::encode($datos->tipoTicket->nombre); ?>  </td>
                <td> <b> Unidad Responsable </b> </td>
                <td> <?php echo CHtml::encode($datos->bandejaActual->nombre); ?>  </td>
                <?php if($datos->responsableAsignado->nombre):?>
                <td> <b> Responsable Asignado </b> </td>
                <td>  <?php echo CHtml::encode($datos->responsableAsignado->nombre."".$datos->responsableAsignado->apellido); ?>  </td>
                <?php endif;?>
                <td> <b> Solicitante </b> </td>
                <td>  <?php echo CHtml::encode($solicitante); ?>  </td>
                <td> <b> Estatus </b> </td>
                <td><?php echo CHtml::encode(strtr($datos['estatus'], array('A' => 'Activo', 'E' => 'Eliminado', 'S' => 'Resuelto', 'R' => 'Redireccionado', 'D' => 'Devuelto', 'P' => 'Asignado'))); ?></td>
                  </tr>
            <tr>
                <td> <b> Aperturado por </b> </td>
                <td> <?php echo CHtml::encode($datos->usuarioIni->username); ?> </td>
                <td> <b> Fecha de Apertura </b> </td>
             <td> <?php echo CHtml::encode($datos['fecha_ini']); ?>  </td>
            <?php if (empty($datos['fecha_act'])): ?>
                <td> <b> Atendido por </b> </td>
                <td> <?php echo "N/A" ?> </td>
                <td> <b> Fecha de Atención </b> </td>
                <td> <?php echo "N/A" ?> </td>
            <?php endif; ?>

                <?php if (!empty($datos['fecha_act'])): ?>
            <td> <b> Atendido por </b> </td>
            <td> <?php echo CHtml::encode($datos->usuarioAct->username); ?> </td>
            <td> <b> Fecha de Atención  </b> </td>
            <td> <?php echo CHtml::encode($datos['fecha_act']); ?>  </td>
        </tr>
        <?php endif; ?>
            </tr>
            <tr>
                <td> <b> Observacion </b> </td>
                <td colspan="3">  <?php echo CHtml::encode($datos['observacion']); ?>  </td>
            </tr>

            <?php $descripcion_error_sistema = ''; ?>
        <?php endif; ?>

        <?php if ($descripcion_rec_clave == 'Solicitud de Reseteo de Clave'): ?>
            <tr>
                <td> <b> Tipo de Solicitud </b>  </td>
                <td>  <?php echo CHtml::encode($datos->tipoTicket->nombre); ?>  </td>
                <td> <b> Unidad Responsable </b> </td>
                <td> <?php echo CHtml::encode($datos->bandejaActual->nombre); ?>  </td>
                <?php if($datos->responsableAsignado->nombre):?>
                <td> <b> Responsable Asignado </b> </td>
                <td>  <?php echo CHtml::encode($datos->responsableAsignado->nombre." ".$datos->responsableAsignado->apellido); ?>  </td>
                <?php endif;?>
                <td> <b> Cedula </b> </td>
                <td>  <?php echo CHtml::encode($cedula); ?>  </td>
                <td> <b> Solicitante </b> </td>
                <td>  <?php echo CHtml::encode($solicitante); ?>  </td>
                <td> <b> Correo </b> </td>
                <td>  <?php echo CHtml::encode($correo); ?>  </td>
            </tr>
            <tr>
                 <td> <b> Estado </b> </td>
                <td> <?php echo CHtml::encode($datos->estado->nombre); ?> </td>
                <td> <b> Aperturado por </b> </td>
                <td> <?php echo CHtml::encode($datos->usuarioIni->nombre." ".$datos->usuarioIni->apellido); ?> </td>
                <td> <b> Fecha de Apertura </b> </td>
                 <td> <?php echo CHtml::encode($datos['fecha_ini']); ?>  </td>
                <?php if (empty($datos['fecha_act'])): ?>
                <td> <b> Atendido por </b> </td>
                <td> <?php echo "N/A" ?> </td>
                <td> <b> Fecha de Atención </b> </td>
                <td> <?php echo "N/A" ?> </td>
            <?php endif; ?>

                <?php if (!empty($datos['fecha_act'])): ?>
            <td> <b> Atendido por </b> </td>
            <td> <?php echo CHtml::encode($datos->usuarioAct->nombre." ".$datos->usuarioAct->apellido); ?> </td>
            <td> <b> Fecha de Atención  </b> </td>
            <td> <?php echo CHtml::encode($datos['fecha_ini']); ?>  </td>
        </tr>
        <?php endif; ?>
            </tr>
            <tr>
                <td> <b> Estado </b> </td>
                <td> <?php echo CHtml::encode($datos->estado->nombre); ?> </td>
                <td> <b> Observacion </b> </td>
                <td colspan="3">  <?php echo CHtml::encode($datos['observacion']); ?>  </td>
            </tr>
            <?php $descripcion_rec_clave = ''; ?>
        <?php endif; ?>
        <?php if ($descripcion_otra_solicitud == 'Otra Solicitud'): ?>
            <tr>
                <td> <b> Tipo de Solicitud </b>  </td>
                <td>  <?php echo CHtml::encode($datos->tipoTicket->nombre); ?>  </td>
                <td> <b> Unidad Responsable </b> </td>
                <?php if($datos->responsableAsignado->nombre):?>
                <td> <b> Responsable Asignado </b> </td>
                <td>  <?php echo CHtml::encode($datos->responsableAsignado->nombre." ".$datos->responsableAsignado->apellido); ?>  </td>
                <?php endif;?>
                <td> <?php echo CHtml::encode($datos->bandejaActual->nombre); ?>  </td>
                <td> <b> Solicitante </b> </td>
                <td>  <?php echo CHtml::encode($solicitante); ?>  </td>
            </tr>
            <tr>
            <?php if (empty($datos['fecha_act'])): ?>
                <td> <b> Atendido por </b> </td>
                <td> <?php echo "N/A" ?> </td>
                <td> <b> Fecha de Atención </b> </td>
                <td> <?php echo "N/A" ?> </td>
            <?php endif; ?>
                <td> <b> Aperturado por </b> </td>
                <td> <?php echo CHtml::encode($datos->usuarioIni->nombre." ".$datos->usuarioIni->apellido); ?> </td>
                <td> <b> Fecha de Apertura </b> </td>
                <td> <?php echo CHtml::encode($datos['fecha_ini']); ?> </td>
                <?php if (!empty($datos['fecha_act'])): ?>
            <td> <b> Atendido por </b> </td>
            <td> <?php echo CHtml::encode($datos->usuarioAct->nombre." ".$datos->usuarioAct->apellido); ?> </td>
            <td> <b> Fecha de Atención  </b> </td>
            <td> <?php echo CHtml::encode($datos['fecha_act']); ?>  </td>
        </tr>
        <?php endif; ?>
           <tr>
               
                <td> <b> Observacion </b> </td>
                <td colspan="6">  <?php echo CHtml::encode($datos['observacion']); ?>  </td>
            </tr>
        <?php $descripcion_otra_solicitud = ''; ?>
            <?php endif; ?>
    <?php endforeach; ?>
</table>
