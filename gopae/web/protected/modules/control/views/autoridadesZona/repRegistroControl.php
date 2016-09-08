
<table class="report table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">
                Actividad
            </th>
            <th class="center">
                Observación
            </th>
            <th class="center">
                Fecha
            </th>
            <th class="center">
                Por
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider as $data): ?>
        <tr>
            <td class="center"><?php echo $data->actividad ;?></td>
            <td class="center"><?php echo $data->observacion ;?></td>
            <td class="center"><?php $fecha = substr($data->fecha_ini, 0, 19); echo (strlen($fecha)>0)?DateTime::createFromFormat('Y-m-d H:i:s', $fecha)->format('d-m-Y H:i:s'):'' ;?></td>
            <td class="center"><?php echo $data->usuarioIni->nombre.' '.$data->usuarioIni->apellido ;?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>