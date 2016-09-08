


$(document).ready(function() {

    var totalClases = '';
    $("#total-clases-form").on('submit', function(evt) {

        evt.preventDefault();
        var mensaje = '<p><b>¿Esta seguro que desea cargar estas asistencias? <br> luego de cargarlas no podran ser modificadas.</b></p>';
        var formulario = this.id;

        dialogo_confirmacionBasicaAsistencia(mensaje, formulario);

    });





    $.mask.definitions['2'] = '[0-2]';
    $.mask.definitions['0'] = '[0-9]';
    $(".indeca").mask('20.0');
    $(".indeas").mask('00');

    $(".indeca").bind('change, blur, keyup', function() {
        //alert(parseFloat($(this).val()));
        if (parseFloat($(this).val()) > 20.0) {

            $(this).val('20.0');
        }
        else if ($(this).val() == '20._') {

            $(this).val('20.0');
        }
        else if ($(this).val() == '00.0') {

            $(this).val('01.0');
        }
        else if ($(this).val() == '__') {

            $(this).val('');
        }

    });
    $(".indeas").bind('change, blur, keyup', function() {
        $(this).css('color','#858585');
        if ($(this).val() == '__') {

            $(this).val('');
        }

    });






    $("#regular-media-general-form").on('submit', function(evt) {
        evt.preventDefault();
        var mensaje = '<p><b>¿Esta seguro que desea cargar estas calificaciones & asistencias? <br> luego de cargarlas no podran ser modificadas.</b></p>';
        var formulario = this.id;
        dialogo_confirmacion(mensaje, formulario);

    });

    $("#regular-basica-form").on('submit', function(evt) {
        evt.preventDefault();
        var mensaje = '<p><b>¿Esta seguro que desea cargar estas calificaciones & asistencias? <br> luego de cargarlas no podran ser modificadas.</b></p>';
        var formulario = this.id;
        if ($("#resumen_evaluativo").val() != '') {
            dialogo_confirmacionBasica(mensaje, formulario);
        } else {
            $("#editor1").click();
            $("#editor1").focus();
        }

    });




    //$('.indeca').ace_spinner({value:0,min:0,max:20,step:1, on_sides: false,touch_spinner: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});

    /*******DESD AQUI CARGAMOS EL TEXTAREA OCULTO ****/

    edit = $("#resumen_evaluativo").val();
    $("#editor1").html(edit);

    $("#editor1").keyup(function() {

        cambio = $("#editor1").html();
        $("#resumen_evaluativo").html(cambio);

    });

    /***************************************************/

    $('#editor1').ace_wysiwyg({
        toolbar:
                [
                    'font',
                    null,
                    'fontSize',
                    null,
                    {name: 'bold', className: 'btn-info'},
                    {name: 'italic', className: 'btn-info'},
                    {name: 'strikethrough', className: 'btn-info'},
                    {name: 'underline', className: 'btn-info'},
                    null,
                    {name: 'insertunorderedlist', className: 'btn-success'},
                    {name: 'insertorderedlist', className: 'btn-success'},
                    {name: 'outdent', className: 'btn-purple'},
                    {name: 'indent', className: 'btn-purple'},
                    null,
                    {name: 'justifyleft', className: 'btn-primary'},
                    {name: 'justifycenter', className: 'btn-primary'},
                    {name: 'justifyright', className: 'btn-primary'},
                    {name: 'justifyfull', className: 'btn-inverse'},
                    null,
                    {name: 'undo', className: 'btn-grey'},
                    {name: 'redo', className: 'btn-grey'}
                ]

    }).prev().addClass('wysiwyg-style1');

    $('[data-toggle="buttons"] .btn').on('click', function(e) {
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        var toolbar = $('#editor1').prev().get(0);
        if (which == 1 || which == 2 || which == 3) {
            toolbar.className = toolbar.className.replace(/wysiwyg\-style(1|2)/g, '');
            if (which == 1)
                $(toolbar).addClass('wysiwyg-style1');
            else if (which == 2)
                $(toolbar).addClass('wysiwyg-style2');
        }
    });


    function dialogo_confirmacion(mensaje, formulario) {
        var alerta = '<span id="respuestaConfirmacion" class="label label-warning  arrowed-in-right hide"></span>';

        $("#dialogo_confirmacion p").html('<div class="infoDialogBox">' + mensaje + '</div>' + '<br><b>Contraseña:</b><br><input type="password" id="passConfirm" class="span-7"/><br>' + alerta);






        var dialog = $("#dialogo_confirmacion").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            draggable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Alerta de Confirmación</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-warning btn-xs orange",
                    click: function() {

                        $(this).dialog("close");

                    }
                },
                {
                    html: "<i class='icon-save bigger-110'></i>&nbsp; Continuar",
                    "class": "btn btn-primary btn-xs",
                    click: function()
                    {
                        if ($("#passConfirm").val().length < 6) {
                            $("#respuestaConfirmacion").removeClass('hide');
                            $("#respuestaConfirmacion").html('<i class="icon-warning-sign bigger-120"></i> <b>¡minimo 6 caracteres!</b>');

                        } else {
                            $("#respuestaConfirmacion").addClass('hide');
                            var password = btoa($("#passConfirm").val());

                            $.ajax
                                    ({
                                        url: '/planteles/calificaciones/confirmarUsuario/',
                                        data: {password: password},
                                        dataType: 'json',
                                        type: 'post',
                                        success: function(respuesta)
                                        {


                                            if (respuesta.success)
                                            {
                                                var id = $("#id").val();
                                                var url = '/planteles/calificaciones/cargarNotas/id/' + id;
                                                $.ajax
                                                        ({
                                                            url: url,
                                                            data: $("#" + formulario).serialize(),
                                                            dataType: 'json',
                                                            type: 'post',
                                                            success: function(resp)
                                                            {

                                                                if (resp.success) {
                                                                    $("#dialogo_confirmacion").dialog("close");
                                                                    $("#respuestaRegistro").removeClass('hide errorDialogBox');
                                                                    $("#guardarCalificacion").remove();
                                                                    $("#respuestaRegistro").addClass('successDialogBox');
                                                                    $("#respuestaRegistro p").html('Proceso de calificación finalizado!');
                                                                    $('#asignatura-calificacion-grid').yiiGridView('update', {
                                                                        data: $(this).serialize()
                                                                    });
                                                                }
                                                                else {
                                                                    if (resp.detalle) {

                                                                        $.each(resp, function(key, data) {
                                                                            if(key=='idField'){
                                                                            $.each(data, function(index, data) {
                                                                              
                                                                                $("#CalificacionAsignaturaEstudiante_asistencia"+data).css('color','#f00');
                                                                            });
                                                                        }
                                                                        });
                                                                        $("#dialogo_confirmacion").dialog("close");
                                                                        $("#respuestaRegistro").addClass('errorDialogBox');
                                                                        $("#respuestaRegistro").removeClass('hide');
                                                                        $("#respuestaRegistro p").html(resp.mensaje);
                                                                    }
                                                                    else {
                                                                        $("#dialogo_confirmacion").dialog("close");
                                                                        $("#respuestaRegistro").addClass('errorDialogBox');
                                                                        $("#respuestaRegistro").removeClass('hide');
                                                                        $("#respuestaRegistro p").html(resp.mensaje);
                                                                    }
                                                                }

                                                            }
                                                        });
                                            } else if (respuesta.error) {
                                                $("#respuestaConfirmacion").removeClass('hide');
                                                $("#respuestaConfirmacion").html('<i class="icon-warning-sign bigger-120"></i> <b>¡Error de Contraseña!</b>');
                                            }

                                        }
                                    });
                        }

                    }
                }

            ]

        });
    }


    function dialogo_confirmacionBasica(mensaje, formulario) {
        var alerta = '<span id="respuestaConfirmacion" class="label label-warning  arrowed-in-right hide"></span>';

        $("#dialogo_confirmacion p").html('<div class="infoDialogBox">' + mensaje + '</div>' + '<br><b>Contraseña:</b><br><input type="password" id="passConfirm" class="span-7"/><br>' + alerta);






        var dialog = $("#dialogo_confirmacion").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            draggable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Alerta de Confirmación</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-warning btn-xs orange",
                    click: function() {

                        $(this).dialog("close");

                    }
                },
                {
                    html: "<i class='icon-save bigger-110'></i>&nbsp; Continuar",
                    "class": "btn btn-primary btn-xs",
                    click: function()
                    {
                        if ($("#passConfirm").val().length < 6) {
                            $("#respuestaConfirmacion").removeClass('hide');
                            $("#respuestaConfirmacion").html('<i class="icon-warning-sign bigger-120"></i> <b>¡minimo 6 caracteres!</b>');

                        } else {
                            $("#respuestaConfirmacion").addClass('hide');
                            var password = btoa($("#passConfirm").val());

                            $.ajax
                                    ({
                                        url: '/planteles/calificaciones/confirmarUsuario/',
                                        data: {password: password},
                                        dataType: 'json',
                                        type: 'post',
                                        success: function(respuesta)
                                        {


                                            if (respuesta.success)
                                            {
                                                var id = $("#id").val();
                                                var url = '/planteles/calificaciones/cargarNotasBasicas/id/' + id;
                                                $.ajax
                                                        ({
                                                            url: url,
                                                            data: $("#" + formulario).serialize(),
                                                            dataType: 'html',
                                                            type: 'post',
                                                            success: function(resp, statusCode, respuestaJson)
                                                            {

                                                                try {
                                                                    var json = jQuery.parseJSON(respuestaJson.responseText);
                                                                    if (json.success) {
                                                                        $("#" + formulario).find('input, textarea, select').attr('disabled', 'disabled');
                                                                        $("#editor1").attr('contenteditable', 'false');
                                                                        $("#guardarCalificacionBasica").remove();
                                                                        $("#dialogo_confirmacion").dialog("close");
                                                                        $("#respuestaRegistro").removeClass('hide');
                                                                        $("#respuestaRegistro").html('<center>' + json.mensaje + '</center><br>');

                                                                    }
                                                                } catch (e) {
                                                                    $("#dialogo_confirmacion").dialog("close");
                                                                    $("#respuestaRegistro").removeClass('hide');
                                                                    $("#respuestaRegistro").html(resp);
                                                                }


                                                            }
                                                        });
                                            } else if (respuesta.error) {
                                                $("#respuestaConfirmacion").removeClass('hide');
                                                $("#respuestaConfirmacion").html('<i class="icon-warning-sign bigger-120"></i> <b>¡Error de Contraseña!</b>');
                                            }

                                        }
                                    });
                        }

                    }
                }

            ]

        });
    }



    function dialogo_confirmacionBasicaAsistencia(mensaje, formulario) {
        var alerta = '<span id="respuestaConfirmacion" class="label label-warning  arrowed-in-right hide"></span>';

        $("#dialogo_confirmacion p").html('<div class="infoDialogBox">' + mensaje + '</div>' + '<br><b>Contraseña:</b><br><input type="password" id="passConfirm" class="span-7"/><br>' + alerta);


        var dialog = $("#dialogo_confirmacion").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            draggable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Alerta de Confirmación</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-warning btn-xs orange",
                    click: function() {

                        $(this).dialog("close");

                    }
                },
                {
                    html: "<i class='icon-save bigger-110'></i>&nbsp; Continuar",
                    "class": "btn btn-primary btn-xs",
                    click: function()
                    {
                        if ($("#passConfirm").val().length < 6) {

                            $("#respuestaConfirmacion").removeClass('hide');
                            $("#respuestaConfirmacion").html('<i class="icon-warning-sign bigger-120"></i> <b>¡minimo 6 caracteres!</b>');

                        } else {
                            $("#respuestaConfirmacion").addClass('hide');
                            var password = btoa($("#passConfirm").val());

                            $.ajax
                                    ({
                                        url: '/planteles/calificaciones/confirmarUsuario/',
                                        data: {password: password},
                                        dataType: 'json',
                                        type: 'post',
                                        success: function(respuesta)
                                        {


                                            if (respuesta.success)
                                            {
                                                var id = $("#id").val();
                                                var url = '/planteles/calificaciones/cargarTotalClases/';
                                                $.ajax
                                                        ({
                                                            url: url,
                                                            data: $("#" + formulario).serialize(),
                                                            dataType: 'html',
                                                            type: 'post',
                                                            success: function(resp, statusCode, respuestaJson)
                                                            {

                                                                try {
                                                                    var json = jQuery.parseJSON(respuestaJson.responseText);
                                                                    if (json.success) {
                                                                        $("#" + formulario).find('input, textarea, select').attr('disabled', 'disabled');
                                                                        $("#guardarCalificacionBasica").remove();
                                                                        $("#dialogo_confirmacion").dialog("close");

                                                                        $("#respuestaRegistroAsistencia").removeClass();
                                                                        $("#respuestaRegistroAsistencia").addClass('successDialogBox');
                                                                        $("#respuestaRegistroAsistencia").html('<center>' + json.mensaje + '</center><br>');

                                                                    } else if (json.error) {

                                                                        $("#guardarCalificacionBasica").remove();
                                                                        $("#dialogo_confirmacion").dialog("close");
                                                                        $("#respuestaRegistroAsistencia").removeClass();
                                                                        $("#respuestaRegistroAsistencia").addClass('alertDialogBox');
                                                                        $("#respuestaRegistroAsistencia").html('<center>' + json.mensaje + '</center><br>');


                                                                    }
                                                                } catch (e) {
                                                                    $("#dialogo_confirmacion").dialog("close");
                                                                    $("#respuestaRegistroAsistencia").removeClass('hide');
                                                                    $("#respuestaRegistroAsistencia").html(resp);
                                                                }


                                                            }
                                                        });
                                            } else if (respuesta.error) {

                                                $("#respuestaRegistroAsistencia").removeClass('hide');
                                                $("#respuestaRegistroAsistencia").html('<i class="icon-warning-sign bigger-120"></i> <b>¡Error de Contraseña!</b>');
                                            }

                                        }
                                    });
                        }

                    }
                }

            ]

        });
    }
});