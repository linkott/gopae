<?php
/* @var $this NivelController */
/* @var $data Nivel */
?>

<div class="view" align="center">
    
    <table style="width:800px;" class="table table-striped table-bordered table-hover">
        <thead>
                    
            <tr>
                <th>
                    <b>Nombre</b>
                </th>
                <th>
                    <b>Capacidad</b>
                <th>
                    <b>Condici&oacute;n infraestructura</b>
                </th>
                <th>
                    <b>Tipo de aula</b>
                </th>
                <th>
                    <b>Observaciones</b>
                </th>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td>
                    <?php echo $model->nombre;?>
                </td>
                <td>
                    <?php echo $model->capacidad;?>
                <td>
                    <?php
                        if(isset($model->condicion_infraestructura_id))
                        {
                            echo $model->condicionInfraestructura->nombre;
                        }
                    ?>
                </td>
                <td>
                    <?php
                        if(isset($model->tipo_aula_id))
                        {
                            echo $model->tipoAula->nombre;
                        }
                    ?>
                </td>
                <td>
                    <?php
                        echo $model->observacion;
                    ?>
                </td>
            </tr>
        </tbody>
        
    </table>
</div>

<div class="view" align="center">
    <b>DATOS DE AUDITORIA</b>
</div>

<div class="view" align="center">
    
    <table style="width:600px;" class="table table-striped table-bordered table-hover">
        <thead>
                    
            <tr>
                <th>
                    <b>Nombres del creador</b>
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
                        $datos = Nivel::model()->datosUsuario($model->usuario_ini_id);
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
if($model->fecha_ini != $model->fecha_act)
{
?>
    <div class="view" align="center">

        <table style="width:600px;" class="table table-striped table-bordered table-hover">
            <thead>

                <tr>
                    <th>
                        <b>Nombres quien lo modifico</b>
                    </th>
                    <th>
                        <b>Fecha Modifiada</b>
                    </th>
                </tr>

            </thead>

            <tbody>
                <tr>
                    <td>
                        <?php
                            $datos = Nivel::model()->datosUsuario($model->usuario_act_id);
                            echo $datos['nombre'] . ' ' . $datos['apellido']. ' (' . $datos['username'] . ')';
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
                        <b>Fecha inactivada</b>
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