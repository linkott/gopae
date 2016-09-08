<div class = "widget-box">

    <div class = "widget-header" style="border-width: 1px;">
        <h5>Datos del Representante</h5>

        <div class = "widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div class = "widget-body-inner">
            <div class = "widget-main">
                <div class="row">
                      <div id='infoRepresentante' class="infoDialogBox">
                          <p>
                               Por Favor Ingrese los datos correspondientes, Los campos marcados con <b><span class="required">*</span></b> son requeridos.
                          </p>
                                </div>
                </div>

                <div class="row row-fluid">
                    <div id="1eraFila" class="col-md-12">
                        <div class="col-md-4" >

                            <?php echo CHtml::label('Cedula  <span class="required">*</span>', '', array("class" => "col-md-12")); ?>
                            <?php
                            echo CHtml::textField('cedulaR', '', array('class' => 'span-7',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'placeholder' => 'V-0000000',
                                'title' => 'Ej: V-99999999 ó E-99999999',
                                'id' => 'cedulaRepresentante',
                                'onkeypress' => 'return CedulaFormat(this, event)',
                                'size' => '10',
                                'style' => '-webkit-user-select:none;-moz-user-select:none;-o-user-select:none;',
                                'maxlength' => '10'
                            ));
                            ?>


                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Nombre  <span class="required">*</span>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('nombreRepresentante', '', array('class' => 'span-7', 'style' => 'text-transform:uppercase;', 'style' => '-webkit-user-select:none;-moz-user-select:none;')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Apellido  <span class="required">*</span>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('apellidoRepresentante', '', array('class' => 'span-7', 'style' => 'text-transform:uppercase;')); ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>

                    <div id="2daFila" class="col-md-12">
                        <div class="col-md-4" >

                            <?php echo CHtml::label('Fecha de Nacimiento', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('fecha_nacimiento_representante', '', array('class' => 'span-7', 'id' => 'fecha_nacimiento_representante')); ?>
                        </div>


                        <div class="col-md-4" >

                            <?php echo CHtml::label('Correo Electrónico', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::emailField('email', '', array('class' => 'span-7', 'style' => 'text-transform:uppercase;')); ?>
                        </div>

                        <div class="col-md-4" >

                            <?php echo CHtml::label('Teléfono Local', '', array("class" => "span-7")); ?>
                            <?php echo CHtml::textField('telefonoLocal', '', array('class' => 'span-7', 'maxlength   ' => '11')); ?>


                        </div>


                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>
                    <div id="2daFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('Teléfono Movil <span class="required">*</span>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('telefonoMovil', '', array('class' => 'span-7', 'maxlength' => '11')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Afinidad  <span class="required">*</span>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::activeDropDownList($modelAfinidad, 'id', CHtml::listData(Afinidad::model()->findAll(), 'id', 'nombre'), array('empty' => '-Seleccione-', 'id' => 'afinidad', 'class' => 'span-7'));
                            ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Estado <span class="required">*</span>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::activeDropDownList($model, 'estado_id', CHtml::listData(Estado::model()->findAll(), 'id', 'nombre'), array('empty' => '-Seleccione-', 'id' => 'estado_id', 'class' => 'span-7')); ?>
                        </div>

                    </div>
                    <div class = "col-md-12"><div class = "space-6"></div></div>

                </div>
            </div>
        </div>
    </div>

</div>
<div id="dialog_error" class="hide"><p></p></div>
<?php
?>

<script>

    $(document).ready(function() {
        
        $('#telefonoLocal').mask('(0299) 999-9999');
        $('#telefonoMovil').mask('(0499) 999-9999');


        $("#nombreRepresentante").attr('readonly', true);
        $("#apellidoRepresentante").attr('readonly', true);
        $("#fecha_nacimiento_representante").attr('readonly', true);
        $("#telefonoMovil").attr('readonly', true);
        $("#telefonoLocal").attr('readonly', true);
        $("#email").attr('readonly', true);
        $("#afinidad").attr('disabled', true);
        $("#estado_id").attr('disabled', true);

        $('#nombreRepresentante').bind('keyup blur', function() {
            keyText(this, false);

        });

        $('#email').bind('keyup blur', function() {
            keyEmail(this, false);

        });

//        $('#telefonoLocal').bind('keyup blur', function() {
//            keyNum(this);
//            clearField(this);
//
//        });
//        $('#telefonoMovil').bind('keyup blur', function() {
//            keyNum(this);
//            clearField(this);
//
//        });




        $("#cedulaRepresentante").bind('change, blur', function() {
            var valorCedula = $(this).val();
            if (valorCedula.length > 0) {
                var cedulaRepresentante = valorCedula;
                buscarCedulaRepresentante(cedulaRepresentante);
            }
            
            else {
                $("#nombreRepresentante").val('');
                        $("#apellidoRepresentante").val('');
                        $("#fecha_nacimiento_representante").val('');
                        $("#telefonoMovil").val('');
                        $("#telefonoLocal").val('');
                        $("#email").val('');
                        $("#afinidad").val('');
                        $("#estado_id").val('');


                        $("#nombreRepresentante").attr('readonly', true);
                        $("#apellidoRepresentante").attr('readonly', true);
                        $("#fecha_nacimiento_representante").attr('readonly', true);
                        $("#telefonoMovil").attr('readonly', true);
                        $("#telefonoLocal").attr('readonly', true);
                        $("#email").attr('readonly', true);
                        $("#afinidad").attr('disabled', true);
                        $("#estado_id").attr('disabled', true);
            }
        });

        $("#cedulaRepresentante").on('blur', function() {
            generarCedulaEscolar();
        });

    });





    function buscarCedulaRepresentante(cedulaRepresentante) {
        var plantel_id = $("#plantel_id").val();
        if (cedulaRepresentante != '' || cedulaRepresentante != null) {
            $.ajax({
                url: "/planteles/matricula/buscarCedulaRepresentante",
                data: {cedula: cedulaRepresentante,
                    plantel_id: plantel_id},
                dataType: 'json',
                type: 'post',
                success: function(resp) {
                    if (resp.statusCode === "mensaje") {

                        $("#nombreRepresentante").val('');
                        $("#apellidoRepresentante").val('');
                        $("#fecha_nacimiento_representante").val('');
                        $("#telefonoMovil").val('');
                        $("#telefonoLocal").val('');
                        $("#email").val('');
                        $("#afinidad").val('');
                        $("#estado_id").val('');


                        $("#nombreRepresentante").attr('readonly', true);
                        $("#apellidoRepresentante").attr('readonly', true);
                        $("#fecha_nacimiento_representante").attr('readonly', true);
                        $("#telefonoMovil").attr('readonly', true);
                        $("#telefonoLocal").attr('readonly', true);
                        $("#email").attr('readonly', true);
                        $("#afinidad").attr('disabled', true);
                        $("#estado_id").attr('disabled', true);


                        $("#cedulaRepresentante").val('');
                        
                        $('#infoRepresentante').removeClass();
                        $('#infoRepresentante').addClass('alertDialogBox');
                        $('#infoRepresentante p').html(resp.mensaje);

                        //dialogo_error(resp.mensaje);
                    }
                    if (resp.statusCode === "successU") {

                        if (resp.edad >= 18) {
                            $("#nombreRepresentante").val(resp.nombre);
                            $("#apellidoRepresentante").val(resp.apellido);
                            $("#fecha_nacimiento_representante").val(resp.fecha_nacimiento);
                            $("#telefonoMovil").val('');
                            $("#telefonoLocal").val('');
                            $("#email").val('');
                            $("#afinidad").val('');
                            $("#estado_id").val('');


                            $("#nombreRepresentante").attr('readonly', true);
                            $("#apellidoRepresentante").attr('readonly', true);
                            $("#fecha_nacimiento_representante").attr('readonly', true);
                            $("#telefonoMovil").attr('readonly', false);
                            $("#telefonoLocal").attr('readonly', false);
                            $("#email").attr('readonly', false);
                            $("#afinidad").attr('disabled', false);
                            $("#estado_id").attr('disabled', false);
                            
                            $('#infoRepresentante').addClass('infoDialogBox');
                            $('#infoRepresentante p').html('Representante Encontrado!');
                        } else {

                            $("#nombreRepresentante").val('');
                            $("#apellidoRepresentante").val('');
                            $("#fecha_nacimiento_representante").val('');
                            $("#telefonoMovil").val('');
                            $("#telefonoLocal").val('');
                            $("#email").val('');
                            $("#afinidad").val('');
                            $("#estado_id").val('');

                            $("#cedulaRepresentante").val('');
                            var mensaje = "Estimado usuario el representante debe ser mayor de edad";
                        $('#infoRepresentante').removeClass();
                        $('#infoRepresentante').addClass('alertDialogBox');
                        $('#infoRepresentante p').html(mensaje);
                        }

                        if (resp.exist == true) {


                            if (resp.edad >= 18) {

                                $("#telefonoMovil").val(resp.telefonoMovil);
                                $("#telefonoLocal").val(resp.telefonoLocal);
                                $("#telefonoMovil").blur();
                                $("#telefonoLocal").blur();
                                $("#email").val(resp.email);
                                $("#afinidad").val(resp.afinidad);
                                $("#estado_id").val(resp.estado);
                                $("#fecha_nacimiento_representante").val(resp.fecha_nacimiento);
                                $("#fecha_nacimiento_representante").attr('readonly', true);
                                $('#infoRepresentante').removeClass();
                        $('#infoRepresentante').addClass('infoDialogBox');
                        $('#infoRepresentante p').html('Representante Encontrado!');
                            } else {
                                $("#nombreRepresentante").val('');
                                $("#apellidoRepresentante").val('');
                                $("#fecha_nacimiento_representante").val('');
                                $("#telefonoMovil").val('');
                                $("#telefonoLocal").val('');
                                $("#email").val('');
                                $("#afinidad").val('');
                                $("#estado_id").val('');
                                var mensaje = "Estimado usuario el representante debe ser mayor de edad";
                                     $('#infoRepresentante').removeClass();
                                     $('#infoRepresentante').addClass('alertDialogBox');
                                     $('#infoRepresentante p').html(mensaje);
                            }

                        }
                    }
                }

            });
        }
    }




</script>