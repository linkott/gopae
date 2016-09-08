<?php
?>
<br>
<div class="view" align="center" style="color: #C43030">
    <b>CONDICIÓN DE SERVICIO</b>
</div>
<div class="view" align="center">
    
    <table style="width:600px;" class="table table-striped table-bordered table-hover">
        <thead>
                    
            <tr>
                <th>
                    <b>CONDICI&Oacute;N DE SERVICIO</b>
                </th>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td>
                    <?php                   
                            echo $model->nombre;
?>
                </td>
            </tr>
        </tbody>
        
    </table>
</div>
<br>
<div class="view" align="center" style="color: #C43030">
    <b>DATOS DE AUDITORÍA</b>
</div>

<div class="view" align="center">
    
    <table style="width:600px;" class="table table-striped table-bordered table-hover">
        <thead>
                    
            <tr>
                <th>
                    <b>Nombres Del Creador</b>
                </th>
                <th>
                    <b>Fecha Creada</b>
                </th>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td>
                    <?php
                        $datos = CondicionServicio::model()->datosUsuarioAuditoria($model->usuario_ini_id);
                        echo $datos['nombre'] . ' ' . $datos['apellido']. ' (' . $datos['username'] . ')';
                    ?>
                </td>
                <td>
                    <?php
                    echo date_format(date_create($model->fecha_ini), 'd-m-Y - H:i:s');
                    ?>
                </td>
            </tr>
        </tbody>
        
    </table>
</div>


<?php
if($model->fecha_act != null)
{
?>
    <div class="view" align="center">

        <table style="width:600px;" class="table table-striped table-bordered table-hover">
            <thead>

                <tr>
                    <th>
                        <b>Nombres Quien Lo Modificó</b>
                    </th>
                    <th>
                        <b>Fecha Modificada</b>
                    </th>
                </tr>

            </thead>

            <tbody>
                <tr>
                    <td>
                        <?php
                            $datos = CondicionServicio::model()->datosUsuarioAuditoria($model->usuario_act_id);
                            if($datos == 0){
                             echo "No ha sido modificado";   
                            } else {
                            echo $datos['nombre'] . ' ' . $datos['apellido']. ' (' . $datos['username'] . ')';
                            }
                            
                            ?>
                    </td>
                    <td>
                        <?php
                        echo date_format(date_create($model->fecha_act), 'd-m-Y - H:i:s');
                        ?>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
<?php
}
if($model->fecha_elim != null)
{
?>
    <div class="view" align="center">

        <table style="width:600px;" class="table table-striped table-bordered table-hover">
            <thead>

                <tr>
                    <th>
                        <b>Fecha Inactivada</b>
                    </th>
                </tr>

            </thead>

            <tbody>
                <tr>
                    <td>
                        <?php
                           echo date_format(date_create($model->fecha_elim), 'd-m-Y - H:i:s');
                        ?>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
<?php
}
?>