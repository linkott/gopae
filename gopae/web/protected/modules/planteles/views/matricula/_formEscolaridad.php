

<div class = "widget-box">
    <div class = "widget-header" style="border-width: thin">
        <h5>Datos de Escolaridad</h5>

        <div class = "widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div class = "widget-body-inner">
            <div class = "widget-main">
                <div id="infoEscolaridad"><p></p></div>
                <div class="row row-fluid center">
                    <div id="1eraFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('Inscripción regular', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::checkBox('inscripcion_regular', false, array('class' => 'escolaridad-check')); ?>
                        </div>

                        <div class="col-md-4 " >
                            <?php echo CHtml::label('Repitiente', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::checkBox('repitiente', false, array('class' => 'escolaridad-check')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Doble Inscripción', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::checkBox('doble_inscripcion', false, array('class' => 'escolaridad-check')); ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>

                    <div id="2daFila" class="col-md-12">

                        <div class="col-md-4 " >
                            <?php echo CHtml::label('Materia Pendiente', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::checkBox('materia_pendiente', false, array('class' => 'escolaridad-check')); ?>
                        </div>

                        <!--                        <div class="col-md-4 hide" >
                        <?php echo CHtml::label('Diferido', '', array("class" => "col-md-12")); ?>
                        <?php echo CHtml::checkBox('diferido', false, array('class' => 'escolaridad-check')); ?>
                                                </div>-->

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>
                    <div id="observacion_escolaridad" class="col-md-12 hide">
                        <div class="col-md-12" >
                            <?php echo CHtml::label('Observaciones', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textArea('observaciones', '', array("class" => "col-md-12", 'placeHolder' => 'Describa las asignaturas que esta repitiendo el estudiante')); ?>
                        </div>

                        <div class="col-md-4" >
                        </div>

                    </div>
                    <div class = "col-md-12"><div class = "space-6"></div></div>

                </div>
            </div>
        </div>
    </div>

</div>
<div id="materiasPendientesWBox" class="hide">
    <?php
    if (isset($dropDownAsignaturaPendiente)) {
        $this->renderPartial('_materiasPendientes', array(
            'dropDownAsignaturaPendiente' => $dropDownAsignaturaPendiente,
                ), FALSE, TRUE);
    }
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#inscripcion_regular").unbind('click');
        $("#inscripcion_regular").click(function() {
            var select = $("#inscripcion_regular").is(':checked') ? true : false;
            if (select) {
                $('input[class="escolaridad-check"]').each(function() {
                    if ($(this).attr('name') != 'inscripcion_regular' && $(this).attr('name') != 'doble_inscripcion')
                        $(this).attr('disabled', 'disabled');
                });
            }
            else {
                $('input[class="escolaridad-check"]').each(function() {
                    if ($(this).attr('name') != 'inscripcion_regular' && $(this).attr('name') != 'doble_inscripcion')
                        $(this).attr('disabled', false);
                });
            }

        });

        $("#repitiente").unbind('click');
        $("#repitiente").click(function() {
            var select = $("#repitiente").is(':checked') ? true : false;
            $("#observaciones").val('');
            if (select) {
                $("#observacion_escolaridad").removeClass('hide');
                $('input[class="escolaridad-check"]').each(function() {
                    if ($(this).attr('name') != 'repitiente' && $(this).attr('name') != 'doble_inscripcion')
                        $(this).attr('disabled', 'disabled');
                });
            }
            else {
                $("#observacion_escolaridad").addClass('hide');
                $('input[class="escolaridad-check"]').each(function() {
                    if ($(this).attr('name') != 'repitiente' && $(this).attr('name') != 'doble_inscripcion')
                        $(this).attr('disabled', false);
                });
            }

        });

        $("#materia_pendiente").unbind('click');
        $("#materia_pendiente").click(function() {
            var select = $("#materia_pendiente").is(':checked') ? true : false;
            $("#observaciones").val('');
            if (select) {
                 $("#observacion_escolaridad").removeClass('hide');
                $('input[class="escolaridad-check"]').each(function() {
                    if ($(this).attr('name') != 'materia_pendiente' && $(this).attr('name') != 'doble_inscripcion')
                        $(this).attr('disabled', 'disabled');
                });
            }
            else {
                $("#observacion_escolaridad").addClass('hide');
                $('input[class="escolaridad-check"]').each(function() {
                    if ($(this).attr('name') != 'materia_pendiente' && $(this).attr('name') != 'doble_inscripcion')
                        $(this).attr('disabled', false);
                });
            }

        });
    });
</script>