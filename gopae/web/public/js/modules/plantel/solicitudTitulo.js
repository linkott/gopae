$(document).ready(function() {

    //$("#selec_todoEst").attr('checked', 'checked');
    $("#selec_todoEst").unbind('click');
    $("#selec_todoEst").click(function() {


        var select = $("#selec_todoEst").is(':checked') ? true : false;
        if (select == true) {

            $('input[name="EstSolicitud[]"]').each(function() {
                $(this).attr('checked', 'checked');
            });
        }
        else {

            $('input[name="EstSolicitud[]"]').each(function() {
                $(this).attr('checked', false);
            });
        }

    });
    $("#btnGuardarSolicitud").unbind('click');
    $("#btnGuardarSolicitud").click(function(e) {

        var EstSeleccionado = new Array();
        $('input[name="EstSolicitud[]"]:checked').each(function() {
            EstSeleccionado.push($(this).val());
        });
        var style = 'alerta';
        var msgchecked = "<p>Estimado usuario, debe seleccionar por lo menos un Estudiante para realizar esta acción.</p>";
        if (EstSeleccionado.length > 0 && !jQuery.isEmptyObject(EstSeleccionado)) {
            var conEfecto = true;
            var showHTML = true;
            var method = 'POST';
            var divResult = 'result-solicitud';
            var urlDir = '/planteles/Titulo/RegistroSolicitudTitulo/';
            var datos;

            datos = {
                EstSeleccionado: EstSeleccionado
            };
            $.ajax({
                url: urlDir,
                data: datos,
                dataType: 'html',
                type: method,
                success: function(resp, resp2, resp3) {
                    try {

                        var json = jQuery.parseJSON(resp3.responseText);
                        if (json.statusCode === "success") {


//                            $("#campo_vacio p").html('');
//                            $("#campo_vacio").addClass('hide');
//                            $("#busqued p").html('');
                            $("#result-solicitud").addClass('hide');
                            $("#exitoSolicitud").removeClass('hide');
                            $("#exitoSolicitud p").html(json.mensaje);
//                            $("html, body").animate({scrollTop: 0}, "fast");
                        } else if (json.statusCode === "alert") {
//
//                            $("#campo_vacio p").html('');
//                            $("#campo_vacio").addClass('hide');
//                            $("#respuestBuscar p").html('');
//                            $("#respuestBuscar").addClass('hide');
                            $("#errorSolicitud").removeClass('hide');
                            $("#errorSolicitud p").html(json.error);
//                            $("html, body").animate({scrollTop: 0}, "fast");
                        }

                    } catch (e) {

//                        $("#atenderSolicitud").html(resp);
//                        dialogAgregar_lote.dialog('close');
//                        $("html, body").animate({scrollTop: 0}, "fast");
//                        Loading.hide();
                    }


                }

            });


        } else {
            displayDialogBox('seleccionchecked', style, msgchecked);
        }
    });

});
//< div class = "center" > < input type = "checkbox" name = "selec_todoEst" value = "1" class = "tooltipMatricula" title = "Seleccionar todos" id = "selec_todoEst" checked = "checked" > < /div>