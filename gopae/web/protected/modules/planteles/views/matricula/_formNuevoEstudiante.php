<div class = "widget-box">

    <div class = "widget-header" style="border-width: thin;">

        <h5>Datos del estudiante</h5>
        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>

            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: block;" class = "widget-body-inner">
            <div class = "widget-main">
                <div class="row">
                    <div class="infoDialogBox" id="infoEstudiante">
                        <p> Por Favor Ingrese los datos correspondientes, Los campos marcados con <b><span class="required">*</span></b> son requeridos.</p>
                    </div>
                </div>

                <div class="row row-fluid">

                    <?php echo '<input type="hidden" id="formulario_tipo" value="1" name="id"/>'; ?>
                    <div id="1eraFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('Cédula de Identidad', '', array("class" => "col-md-12")); ?>

                            <?php echo '<input type="text" ata-toggle="tooltip" data-placement="bottom" placeholder="V-0000000" title="Ej: V-99999999 ó E-99999999" id="cedula"  maxlength="10" size="10" class="span-7" name="cedula" onkeypress = "return CedulaFormat(this, event)" />'; ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Nombre <span class="required">*</span>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $mEstudiante['nombres'], array('class' => 'span-7', 'id' => "Estudiante_nombres", 'required' => 'required', 'style' => 'text-transform:uppercase;')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Apellido <span class="required">*</span>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $mEstudiante['apellidos'], array('class' => 'span-7', 'id' => "Estudiante_apellidos", 'required' => 'required', 'style' => 'text-transform:uppercase;')); ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>

                    <div id="2daFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('Fecha de nacimiento <span class="required">*</span>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $mEstudiante['fecha_nacimiento'], array('class' => 'span-7', 'id' => 'fecha', 'required' => 'required', 'readOnly' => 'readOnly')); ?>
                        </div>



                        <div class="col-md-4" >

                            <?php echo CHtml::label('Estatura (metros)', '', array("class" => "col-md-12")); ?>

                            <input type="text" data-toggle="tooltip" data-placement="bottom" placeholder="0.00 m " title="Ej: 0.40 - 2.00"  id="Estudiante_estatura"  maxlength="4" size="10" min="0.40" max="2.30" name="Estudiante_estatura" required = "required" class="span-7" onkeypress="return(currencyFormat(this, '', '.', event));"/>

                        </div>
                        <div class="col-md-4" >
                            <?php echo CHtml::label('Lateralidad', '', array("class" => "span-7")); ?>

                            <?php
                            echo CHtml::dropDownList(
                                    '', '', array(
                                'DER' => 'DERECHO',
                                'IZQ' => 'IZQUIERDO',
                                'AMB' => 'AMBIDIESTRO',
                                    ), array(
                                'empty' => '-Seleccione-',
                                'class' => 'span-7',
                                'id' => 'Estudiante_lateralidad'
                                    )
                            );
                            ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>

                    <div id="3raFila" class = "col-md-12">
                        <div class="col-md-4" >
                            <label title="Seleccionar si el Estudiante posee hermanos nacidos en la misma fecha" for="orden_nacimiento" class="col-md-12">Orden de Nacimiento</label>
                            <select id="orden_nacimiento" name="orden_nacimiento">
                                <option value="">Seleccione</option>
                                <option value="" selected="selected">Único nacido en esta fecha</option>
                                <option value="1">Primero nacido en esta fecha</option>
                                <option value="2">Segundo nacido en esta fecha</option>
                                <option value="3">Tercero nacido en esta fecha</option>
                                <option value="4">Cuarto nacido en esta fecha</option>
                                <option value="5">Quinto nacido en esta fecha</option>
                                <option value="6">Sexto nacido en esta fecha</option>
                                <option value="7">Séptimo nacido en esta fecha</option>
                                <option value="8">Octavo nacido en esta fecha</option>
                            </select>
                        </div>
                        
                        

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Cédula Escolar <span class="required">*</span>', '', array("class" => "col-md-12")); ?>
                            <input type="text" id="cedula_escolar" value="<?php echo $cedulaEscolar; ?>" name="cedula_escolar" required="required" readonly="readonly" title="La Cédula Escolar del Estudiante es un dato requerido" class="span-7" />
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Estado donde Reside', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::activeDropDownList($mEstudiante, 'estado_id', CHtml::listData(Estado::model()->findAll(), 'id', 'nombre'), array('empty' => '-Seleccione-', 'id' => 'estudiante_estado_id', 'class' => 'span-7')); ?>
                        </div>
                        
                          <div class="col-md-4" >
                            <label title="Seleccionar el sexo" for="genero" class="col-md-12">Genero:</label>
                            <select id="sexo" name="sexo" class="span-7" required="required">
                                <option value="">-Seleccione-</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</div>



<script>

    $(document).ready(function() {

        $("#cedula").bind('blur', function() {

            var valorCedula = $(this).val();

            if (valorCedula.length > 0) {
                var cedula = valorCedula;
                buscarCedulaAutoridad(cedula);
                generarCedulaEscolar();
            }
            else {

                $("#cedula").val("");
                $("#Estudiante_nombres").val('');
                $("#Estudiante_apellidos").val('');
                $("#cedula_escolar").val('');
                $("#fecha").val('');
                $("#Estudiante_nombres").attr('readonly', false);
                $("#Estudiante_apellidos").attr('readonly', false);
                generarCedulaEscolar();
            }

        });



        $("#Estudiante_estatura").bind('keyup blur', function() {
            keyNum(this, true);
        });

        $("#Estudiante_nombres").bind('keyup blur', function() {
            keyTextDash(this, true);
            makeUpper(this);
        });

        $("#Estudiante_apellidos").bind('keyup blur', function() {
            keyTextDash(this, true);
            makeUpper(this);
        });

        $("#Estudiante_estatura").bind('blur', function() {
            var mensaje1 = "El valor en el campo Estatura no es correcto, el Rango de estatura es de 0.40m a 2.50m ";
            var estatura = $("#Estudiante_estatura").val();
            //var num=estatura.substring(0,1);
            if (estatura.length > 0 || estatura !== 0 || estatura !== 0.00) {
                if ((estatura >= 0.40) && (estatura <= 2.50)) {
                    // dialog_error(num);    
                } else {
                    $('#infoEstudiante').removeClass().addClass('alertDialogBox');
                    $('#infoEstudiante p').html(mensaje1);
                    $("#Estudiante_estatura").val('');
                }
            }
        });

        $("#orden_nacimiento").on('change', function() {
            generarCedulaEscolar();
        });

        /*****************Meylin***************************/
        $('#fecha').unbind('click');
        $('#fecha').unbind('focus');
        $('#fecha').datepicker();
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $.datepicker.setDefaults($.datepicker.regional = {
            dateFormat: 'dd-mm-yy',
            'showOn': 'focus',
            'showOtherMonths': false,
            'selectOtherMonths': true,
            'changeMonth': true,
            'changeYear': true,
            minDate: new Date(1996, 1, 1),
            maxDate: 'today',
            onSelect: function(selected, evnt) {
                generarCedulaEscolar();
            }
        });
    });//------------FIN DOCUMENT

</script>

