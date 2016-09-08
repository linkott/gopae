<?php
/* @var $this EstudianteController */
/* @var $model Estudiante */
/* @var $form CActiveForm */
?>


<div class = "widget-box">

    <div class = "widget-header" style="border-width: thin">
        <h5>Búsqueda del estudiante</h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-up"></i>
            </a>
        </div>

    </div>
    <div style="margin-right:10px;" class = "widget-main">
         <div class = "widget-body">
            <div style = "display: block;" class = "widget-body-inner">
                <div class = "widget-main"  style="margin-left:10px;">
                    <div class="row">
                        <div id="respuestaBuscar" class="hide errorDialogBox" ><p></p> </div>
                        <div id="busquedaVacia" class="hide alertDialogBox" ><p></p> </div>
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'estudiante-form',
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnType' => true,
                                'validateOnChange' => true),
                        ));
                        echo CHtml::hiddenField('individual', $individual);
                        ?>



                        <div id="1eraFila" class="row">

                            <?php echo $form->labelEx($model, 'cedula_escolar', array('class' => 'col-md-2')); ?>
                            <div class="col-md-4">
                                <?php echo $form->textField($model, 'cedula_escolar', array('class' => 'span-7')); ?>
                                <?php echo $form->error($model, 'cedula_escolar'); ?>
                            </div>



                            <?php echo $form->labelEx($model, 'cedula_identidad', array('class' => 'col-md-2')); ?>
                            <div class="col-md-4" >
                                <?php echo $form->textField($model, 'cedula_identidad', array('class' => 'span-7')); ?>
                                <?php echo $form->error($model, 'cedula_identidad'); ?>
                            </div>

                        </div>


                        <div id="2daFila" class="row">

                            <?php echo $form->labelEx($model, 'nombres', array('class' => 'col-md-2')); ?>
                            <div class="col-md-4" >
                                <?php echo $form->textField($model, 'nombres', array('class' => 'span-7')); ?>
                                <?php echo $form->error($model, 'nombres'); ?>
                            </div>


                            <?php echo $form->labelEx($model, 'apellidos', array('class' => 'col-md-2')); ?>
                            <div class="col-md-4" >
                                <?php echo $form->textField($model, 'apellidos', array('class' => 'span-7')); ?>
                                <?php echo $form->error($model, 'apellidos'); ?>
                            </div>
                        </div>

                        <div id="3eraFila" class="row">
                            <?php echo $form->labelEx($model, 'Cédula representante', array('class' => 'col-md-2')); ?>

                            <div class="col-md-4" >
                                <?php echo $form->textField($model, 'cirepresentante', array('class' => 'span-7')); ?>
                                <?php echo $form->error($model, 'cirepresentante'); ?>
                            </div>

                            <div class="col-md-4" >
                                <!--    <label  title="Búsqueda Completa">
                                        Búsqueda Completa</label>
                                    <input type="checkbox" id="busquedaCompleta" name="busquedaCompleta" value="" style="margin-left: 15px;"> -->
                                <?php echo CHtml::label('Búsqueda Completa', ''); ?>
                                <?php echo CHtml::checkBox('busquedaCompleta'); ?>
                            </div>

                        </div>
                        <?php $this->endWidget(); ?>
                        <div >

                            <a id="btnBuscar" class="pull-right btn btn-primary btn-sm" style="margin-top:-30px;margin-right:2%">
                                Buscar
                                <i class="icon-search icon-on-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


    <div id="busqueRealizada" class="hide"> </div>
    <script> $("#btnBuscar").click(function() {

            var inscritos;
            inscritos = '<?php print($inscritos); ?>';
            var seccion_plantel_id;
            var peticionActiva = false;
            var individual = $("#individual").val();
            seccion_plantel_id = '<?php print($seccion_plantel_id); ?>';
            var plantel_id;
            plantel_id = '<?php print($plantel_id); ?>';
            //        evt.preventDefault();
            Loading.show();

            var busquedaCompleta = $('#busquedaCompleta').filter(":checked").length;
            //   alert(busquedaCompleta);

            if (!peticionActiva) {
                $.ajax({
                    url: "/planteles/matricula/BuscarEstudiante",
                    data: {cedula_escolar: $("#Estudiante_cedula_escolar").val(),
                        cedula_identidad: $("#Estudiante_cedula_identidad").val(),
                        seccion_plantel_id: seccion_plantel_id,
                        nombres: $("#Estudiante_nombres").val(),
                        apellidos: $("#Estudiante_apellidos").val(),
                        ci_representante: $("#Estudiante_cirepresentante").val(),
                        inscritos: inscritos,
                        individual: individual,
                        plantel_id: plantel_id,
                        busquedaCompleta: busquedaCompleta
                    },
                    dataType: 'html',
                    type: 'POST',
                    beforeSend: function() {
                        mostrarNotificacion();
                        peticionActiva = true;
                        // alert(busquedaCompleta);
                        $("#Estudiante_cedula_escolar").attr('readonly', true);
                        $("#Estudiante_cedula_identidad").attr('readonly', true);
                        $("#Estudiante_nombres").attr('readonly', true);
                        $("#Estudiante_apellidos").attr('readonly', true);
                        $("#Estudiante_cirepresentante").attr('readonly', true);
                        $("#busquedaCompleta").attr('disabled', true);
                        $("#btnBuscar").attr('disabled', true);
                    },
                    afterSend: function() {
                        peticionActiva = false;
                    },
                    success: function(resp, resp2, resp3) {

                        $("#Estudiante_cedula_escolar").attr('readonly', false);
                        $("#Estudiante_cedula_identidad").attr('readonly', false);
                        $("#Estudiante_nombres").attr('readonly', false);
                        $("#Estudiante_apellidos").attr('readonly', false);
                        $("#Estudiante_cirepresentante").attr('readonly', false);
                        $("#busquedaCompleta").attr('disabled', false);
                        $("#btnBuscar").attr('disabled', false);
                        try {

                            var json = jQuery.parseJSON(resp3.responseText);
                            if (json.statusCode === "mensaje") {

                                $("#busquedaVacia p").html('');
                                $("#busquedaVacia").addClass('hide');
                                $("#respuestaBuscar").removeClass('hide');
                                $("#respuestaBuscar p").html(json.mensaje);
                            } else if (json.statusCode === "alert") {
                                $("#busqueRealizada").html('').addClass('hide');
                                $("#respuestaBuscar p").html('');
                                $("#respuestaBuscar").addClass('hide');
                                $("#busquedaVacia").removeClass('hide');
                                $("#busquedaVacia p").html(json.mensaje);
                            }
                            Loading.hide();
                        } catch (e) {

                            $("#busqueRealizada").html(resp).removeClass('hide');
                            $("#busquedaVacia p").html('');
                            $("#busquedaVacia").addClass('hide');
                            $("#respuestaBuscar p").html('');
                            $("#respuestaBuscar").addClass('hide');
                            Loading.hide();
                        }

                    }

                });
            } else {
                dialogo_peticion_activa();
            }
        });
        $('#Estudiante_nombres').bind('keyup blur', function() {
            keyLettersAndSpaces(this, true);
            makeUpper(this);
        });
        $('#Estudiante_apellidos').bind('keyup blur', function() {
            keyLettersAndSpaces(this, true);
            makeUpper(this);
        });
        $('#Estudiante_nombres').bind('blur', function() {
            clearField(this);
        });
        $('#Estudiante_apellidos').bind('blur', function() {
            clearField(this);
        });
        $('#Estudiante_cedula_escolar').bind('keyup blur', function() {
            keyNum(this, true);
        });
        $('#Estudiante_cedula_identidad').bind('keyup blur', function() {
            keyNum(this, true);
        });
        $('#Estudiante_cirepresentante').bind('keyup blur', function() {
            keyNum(this, true);
        });


    </script>

