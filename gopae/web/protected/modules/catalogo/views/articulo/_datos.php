<div class="row">
    <div class="col-md-4">
        <label><b>Nivel:</b></label>
    </div>


    <div class="col-md-4">
        <label><b>Tipo de periodo:</b></label>
    </div>


        <div class="col-md-2">
        <label><b>Cantidad de periodo:</b></label>
    </div>

</div>
<div class="row">

    <div class="col-md-4">
        <?php echo CHtml::encode($model->nombre); ?>
    </div>

    <div class="col-md-4">
        <label>
            <?php
            if (isset($model->tipo_periodo_id)) {
                echo CHtml::encode($model->tipoPeriodo->nombre);
            }
            ?>
        </label>
    </div>

    <div class="col-md-4">
        <label><?php if ($model->cantidad):echo CHtml::encode($model->cantidad);
    endif; ?></label>
    </div>

</div>
<div class="row">


    
    <div class="col-md-4">
            <label><b>Cantidad de lapsos:</b></label>
        </div>



    
 
        <div class="col-md-4">
        <label><b>Permite materia pendiente:</b></label>
        </div>
        <div class="col-md-4">

        </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label><?php echo $model->cant_lapsos; ?></label>
    </div>

    <div class="col-md-4">
        <label><?php
            if ($model->permite_materia_pendiente == 1) {
                echo 'Si';
            } else if ($model->permite_materia_pendiente == 0) {
                echo 'No';
            } else {
                echo '';
            }
            ?></label>
    </div>
</div>