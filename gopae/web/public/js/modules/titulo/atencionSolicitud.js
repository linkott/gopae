


$("#busqueda_form").submit(function(evt) {

    evt.preventDefault();
    var mensaje = '';
    var error = false;
    var data = {
        tipoBusqueda: $("#tipoBusqueda").val(),
        codigoe: $("#codigoe").val(),
        codigop: $("#codigop").val()
    }

    if ($("#tipoBusqueda").val() == '') {
        mensaje = mensaje + "Por favor el tipo de búsqueda no puede estar vacío <br>";
        error = true;
    }

    if (error == false) {
        Loading.show();
        $.ajax({
            url: "/titulo/atencionSolicitud/mostrarConsultaPlantel",
            data: data,
            dataType: 'html',
            type: 'post',
            success: function(resp, resp2, resp3) {
                try {

                    var json = jQuery.parseJSON(resp3.responseText);
                    if (json.statusCode === "mensaje") {


                        $("#campos_vacios p").html('');
                        $("#campos_vacios").addClass('hide');
                        $("#busqueda p").html('');
                        $("#busqueda").addClass('hide');
                        $("#respuestaBuscar").removeClass('hide');
                        $("#respuestaBuscar p").html(json.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");

                    } else if (json.statusCode === "alert") {

                        $("#campos_vacios p").html('');
                        $("#campos_vacios").addClass('hide');
                        $("#respuestaBuscar p").html('');
                        $("#respuestaBuscar").addClass('hide');
                        $("#busqueda").removeClass('hide');
                        $("#busqueda p").html(json.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");

                    }
                    Loading.hide();
                } catch (e) {
                    $("#index").html(resp);
                    $("html, body").animate({scrollTop: 0}, "fast");
                    Loading.hide();
                }
                Loading.hide();
            }
        });
    } else {

        $("#campos_vacios").removeClass('hide');
        $("#campos_vacios p").html(mensaje);
        $("html, body").animate({scrollTop: 0}, "fast");

    }
});

function agregar_lote(plantel_id, periodo_actual_id, sumaTotal) {

    var data = {
        plantel_id: plantel_id,
        periodo_actual_id: periodo_actual_id
    }

    Loading.show();
    $.ajax({
        url: "/titulo/atencionSolicitud/mostrarAgregarLote",
        data: data,
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            var dialogAgregar_lote = $("#dialog_agregar_lote").removeClass('hide').dialog({
                modal: true,
                width: '850px',
                draggable: false,
                resizable: false,
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-plus'></i>Agregar Lotes de Seriales</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs",
                        click: function() {
                            $(this).dialog("close");
                        }
                    },
                    {
                        html: "Agregar &nbsp; <i class='fa fa-plus icon-on-right bigger-110'></i>",
                        "class": "btn btn-primary btn-xs",
                        click: function() {

                            var mensaje = '';
                            var error = false;
                            if ($("#primer_serial").val() == '') {
                                mensaje = mensaje + "Por favor el primer serial no puede estar vacío <br>";
                                error = true;
                            }
                            if ($("#primer_serial").val() != '') {
                                if (!/^([0-9])*$/.test($("#primer_serial").val())) {
                                    mensaje = mensaje + "Por favor el primer serial solo puede contener números, por favor verifique el dato que introdujo <br>";
                                    error = true;
                                }
                            }

                            var data = {
                                primer_serial: $("#primer_serial").val(),
                                ultimo_serial: $("#ultimo_serial").val(),
                                cantidad_serial: $("#cantidad_serial").val(),
                                fecha_entrega: $("#fecha_entrega").val(),
                                asignado: $("#asignado").val(),
                                plantel_id: plantel_id,
                                periodo_actual_id: periodo_actual_id,
                                codigo_estadistico: $("#codigo_estadistico").val(),
                                codigo_plantel: $("#codigo_plantel").val(),
                                tipoBusqueda: $("#tipoBusqueda").val()
                            }

                            Loading.show();
                            if (error == false) {
                                if ($("#ultimo_serial").val() != '' && sumaTotal != '') {
                                    $.ajax({
                                        url: "/titulo/atencionSolicitud/agregarLote",
                                        data: data,
                                        dataType: 'html',
                                        type: 'post',
                                        success: function(resp, resp2, resp3) {
                                            try {
                                                var json = jQuery.parseJSON(resp3.responseText);
                                                if (json.statusCode === 'alert') {

                                                    $("#error_agregar").removeClass('hide');
                                                    $("#error_agregar p").html(json.mensaje);
                                                    $("html, body").animate({scrollTop: 0}, "fast");

                                                }
                                                Loading.hide();
                                            } catch (e) {

                                                $("#dialog_agregar_lote").dialog('close');
                                                $("#atenderSolicitud").html(resp);

                                                $("html, body").animate({scrollTop: 0}, "fast");
                                                Loading.hide();
                                            }
                                            Loading.hide();
                                        }
                                    })
                                    Loading.hide();
                                }
                                Loading.hide();
                            } else {
                                $("#ultimo_serial").val('');
                                $("#cantidad_serial").val('');
                                $("#error_agregarLote").removeClass('hide');
                                $("#error_agregarLote p").html(mensaje);
                                Loading.hide();
                            }
                        }
                    }
                ]
            });
            $("html, body").animate({scrollTop: 0}, "fast");
            document.getElementById("dialog_agregar_lote").style.display = "block";
            $("#dialog_agregar_lote").html(resp);
            Loading.hide();
        }
    })
}


function mensajeAgregarLote(mensaje) {
    $("#mensaje_agregar_lote p").html(mensaje);
    var dialog = $("#mensaje_agregar_lote").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Mensaje de Alerta</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cerrar",
                "class": "btn btn-xs",
                click: function() {
                    $(this).dialog("close");
                }
            }
        ]
    });
}


function dialogo_error(mensaje) {
    $("#dialog_error p").html(mensaje);
    var dialog = $("#dialog_error").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Mensaje de Error</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cerrar",
                "class": "btn btn-xs",
                click: function() {
                    $(this).dialog("close");
                }
            }
        ]

    });
}