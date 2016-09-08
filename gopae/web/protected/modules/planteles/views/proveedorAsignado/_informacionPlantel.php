<div id="1eraFila" class="col-md-12">
    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Código del Plantel</strong>', '', array("class" => "col-md-12",)); ?>
        <?php echo CHtml::textField('', $datosPlantel['cod_plantel'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Código Estadistico</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosPlantel['cod_estadistico'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Denominación</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosPlantel['denominacion'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

</div>

<div class = "col-md-12"><div class = "space-6"></div></div>

<div id="2daFila" class="col-md-12">
    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Nombre del Plantel</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosPlantel['nom_plantel'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Zona Educativa</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosPlantel['zona_educativa'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Estado</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosPlantel['estado'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

</div>

<div class = "col-md-12"><div class = "space-6"></div></div>