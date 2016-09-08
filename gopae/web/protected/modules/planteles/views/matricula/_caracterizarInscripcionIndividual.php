<div id="summary" class="hide">


</div><div class = "widget-box collapsed">

    <div class = "widget-header" style="border-width: thin">
        <h5>Datos del Estudiante </h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>
    <div class = "widget-body">
        <div style = "display: block;" class = "widget-body-inner">
            <div class = "widget-main"  style="margin-left:10px;">
                <div class="row">
                    <?php
                    echo CHtml::hiddenField('estudiante_id', $estudiante_id);
                    echo CHtml::hiddenField('plantel_id', $plantel_id);
                    echo CHtml::hiddenField('seccion_plantel_id', $seccion_plantel_id);

                    $nombres = isset($estudiante['nombres']) ? $estudiante['nombres'] : null;
                    $apellidos = isset($estudiante['apellidos']) ? $estudiante['apellidos'] : null;
                    $fecha_nacimiento = isset($estudiante['fecha_nacimiento']) ? $estudiante['fecha_nacimiento'] : null;
                    $cedula_identidad = isset($estudiante['cedula_identidad']) ? $estudiante['cedula_identidad'] : null;
                    $cedula_escolar = isset($estudiante['cedula_escolar']) ? $estudiante['cedula_escolar'] : null;
                    $grado_actual = isset($estudiante['grado_actual']) ? $estudiante['grado_actual'] : null;
                    $plantel_actual = isset($estudiante['plantel_actual']) ? $estudiante['plantel_actual'] : null;
                    ?>
                    <div id="1eraFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('<strong>Nombres</strong>', '', array("class" => "col-md-12",)); ?>
                            <?php echo CHtml::textField('', $nombres, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<strong>Apellidos</strong>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $apellidos, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<strong>Fecha de Nacimiento</strong>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $fecha_nacimiento, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>

                    <div id="2daFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('<strong>Cédula de Identidad</strong>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $cedula_identidad, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<strong>Cédula Escolar</strong>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $cedula_escolar, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<strong>Grado Actual</strong>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $grado_actual, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>
                    </div>
                    <div class = "col-md-12"><div class = "space-6"></div></div>

                    <div id="2daFila" class="col-md-12">
                        <div class="col-md-12" >
                            <?php echo CHtml::label('<strong>Plantel Actual</strong>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $plantel_actual, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>
                    </div>
                    <div class = "col-md-12"><div class = "space-6"></div></div>


                </div>
            </div>
        </div>

    </div>

</div>
<div  id="datosEscolaridad">
    <?php
    $this->renderPartial('_formEscolaridad', array(
        'plantel_id' => $plantel_id,
        'estudiante_id' => $estudiante_id,
        'seccion_plantel_id' => $seccion_plantel_id
            ), FALSE, TRUE);
    ?>
</div>


