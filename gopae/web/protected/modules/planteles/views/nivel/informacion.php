<?php
/* @var $this NivelController */
/* @var $data Nivel */
?>

<div class="view" align="center">
    
    <table style="width:600px;" class="table table-striped table-bordered table-hover">
        <thead>
                    
            <tr>
                <th id="niveles">
                    <b>Nivel</b>
                </th>
                <th id="modalidad">
                    <b>Modalidad</b>
                </th>
            </tr>

        </thead>

        <tbody>
            <tr>
                <td>
                    <?php echo $model->nombre;?>
                </td>
                <td>
                    <?php echo $model->modalidad->nombre;?>
                </td>
            </tr>
        </tbody>
        
    </table>
</div>