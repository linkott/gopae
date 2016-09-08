<div id="1eraFila" class="col-md-12">
    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Nombre</strong>', '', array("class" => "col-md-12",)); ?>
        <?php echo CHtml::textField('', $datosSeccion[0]['seccion'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Nivel</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosSeccion[0]['nivel'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Plan</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosSeccion[0]['plan'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

</div>

<div class = "col-md-12"><div class = "space-6"></div></div>

<div id="2daFila" class="col-md-12">
    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Grado</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosSeccion[0]['grado'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Capacidad</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosSeccion[0]['capacidad'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Turno</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosSeccion[0]['turno'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

</div>

<div class = "col-md-12"><div class = "space-6"></div></div>