function VentanaDialog(id, direccion, title, accion, datos) {
    accion = accion;
    Loading.show();
    var data =
            {
                id: id,
                datos: datos
            };

    if (accion == "create" || accion == "update") {
        $.ajax({
            url: direccion,
            data: data,
            dataType: 'html',
            type: 'GET',
            success: function(result, action)
            {
                var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                    modal: true,
                    width: '1000px',
                    dragable: false,
                    resizable: false,
                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
                    title_html: true,
                    buttons: [
                        {
                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                            "class": "btn btn-danger",
                            click: function() {
                                $(this).dialog("close");
                            }
                        },
                        {
                            html: "<i class='icon-save bigger-110'></i>&nbsp; Guardar",
                            "class": "btn btn-primary",
                            click: function() {

                                var divResult = "#dialogPantalla";
                                var urlDir = "/ayuda/distribucionTicket/" + accion + "/id/" + id;
                                var datos = $("#clase-plantel-form").serialize();
                                var conEfecto = true;
                                var showHTML = true;
                                var method = "POST";
                                var responseFormat = "html";
                                var callback = function() {
                                    $('#clase-plantel-grid').yiiGridView('update', {
                                        data: $(this).serialize()
                                    });
                                };

                                var distribucion = $.trim($('#DistribucionTicket_correo_electronico').val());
                                var estado = $.trim($('#estado').val());
                                var tipo = $.trim($('#DistribucionTicket_telefono').val());
                                if (distribucion == "" || estado == "" || tipo == '') {
                                    displayDialogBox('validaciones', 'error', 'DATOS FALTANTES: Los campos Estado, Tipo de Ticket, y Correo no pueden estar vacios.');

                                } else if (!isValidEmail($('#DistribucionTicket_correo_electronico').val())) {
                                    displayDialogBox('validaciones', 'error', 'DATOS FALTANTES: El formato de correo no es válido. Ej.: miusuario@me.gob.ve.');
                                } else if (datos) {
                                    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

                                } else {
                                    $(this).dialog("close");
                                }
                            }
                        },
                    ],
                });
                $("#dialogPantalla").html(result);
            }
        });
        Loading.hide();
    }
    else if (accion == "view") {
        $.ajax({
            url: direccion,
            data: data,
            dataType: 'html',
            type: 'GET',
            success: function(result, action)
            {
                var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                    modal: true,
                    width: '1100px',
                    dragable: false,
                    resizable: false,
                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
                    title_html: true,
                    buttons: [
                        {
                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                            "class": "btn btn-danger",
                            click: function() {
                                $(this).dialog("close");
                            }
                        },
                    ],
                });

                $("#dialogPantalla").html(result);
            }
        });
        Loading.hide();
    }
    else if (accion == "borrar") {
        $("#dialogPantalla").html('Decea usted eliminar esta unidad responsable de solicitud?');
        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Unidad responsable",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/ayuda/distribucionTicket/delete?id=" + id;
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var responseFormat = "html";
                        var callback = function() {
                            $('#clase-plantel-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };

                        $("html, body").animate({scrollTop: 0}, "fast");
                        if (datos) {
                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                            $(this).dialog("close");
                        }
                    }
                }

            ],
        });
        Loading.hide();
    }
    else if (accion == "activar") {
        $("#dialogPantalla").html('Estas seguro que decea activarlo?');
        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; Activar Unidad responsable de Ticket",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/ayuda/distribucionTicket/activar?id=" + id;
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var responseFormat = "html";
                        var callback = function() {
                            $('#clase-plantel-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };

                        $("html, body").animate({scrollTop: 0}, "fast");
                        if (datos) {
                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                            $(this).dialog("close");
                        }
                    }
                }

            ],
        });
        Loading.hide();

    }

    $(document).ready(function() {
        $("#apertura_ticket").on('click', function(evt) {
            evt.preventDefault();
            VentanaDialog('', '/ayuda/ticket/create', 'Ticket', 'create', '')
        });

        $('#Ticket_codigo').bind('keyup blur', function() {
            keyNum(this, false);
            clearField(this);
        });


        $('#Ticket_observacion').bind('keyup blur', function() {
            keyText(this, true);
        });

        $('#Ticket_observacion').bind('blur', function() {
            clearField(this);
        });

    });
}




