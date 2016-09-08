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
                        {
                            html: "<i class='icon-save bigger-110'></i>&nbsp; Guardar",
                            "class": "btn btn-primary",
                            click: function() {


                                var divResult = "dialogPantalla";
                                var urlDir = "/ayuda/instructivo/" + accion + "/id/" + id;
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

                                var tipoFormulario = $("#tipo-formulario").val();

                                if (tipoFormulario == "update") {
                                    // De ser el tipo de formulario correspondiente se resojen los datos.                                                                 
                                    var nombre = $.trim($('#Instructivo_nombre').val());
                                    var descripcion = $.trim($('#Instructivo_descripcion').val());
                                    //var validar = $.trim($('#validar').val());
                                    var validar = $.trim($("#validar").val());
                                    var nombreArchivo = $.trim($('#nombreArchivo').val());
                                    if (nombre == '') {
                                        displayDialogBox('validaciones', 'error', 'DATOS FALTANTES: Debe ingresar el nombre del documento.');
                                        $("html, body").animate({scrollTop: 0}, "fast");
                                    } else if (datos) {
                                        executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

                                    }
                                } else if (tipoFormulario == "crear") {
                                    var nombre = $.trim($('#Instructivo_nombre').val());
                                    var descripcion = $.trim($('#Instructivo_descripcion').val());
                                    //var validar = $.trim($('#validar').val());
                                    var validar = $.trim($("#validar").val());
                                    var nombreArchivo = $.trim($('#nombreArchivo').val());
                                    if (nombre == '') {
                                        displayDialogBox('validaciones', 'error', 'DATOS FALTANTES: Debe ingresar el nombre del documento.');
                                    }else if(nombreArchivo==''){
                                        displayDialogBox('validaciones', 'error', 'DATOS FALTANTES: Debe cargar un archivo que corresponde al instructivo que desea registrar.');
 
                                        $("html, body").animate({scrollTop: 0}, "fast");
                                    } else if (datos) {
                                        executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

                                    }


                                }
                                else {
                                    $(this).dialog("close");
                                }
                            }

                        }
                    ]
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
                        }
                    ]
                });

                $("#dialogPantalla").html(result);
            }
        });
        Loading.hide();
    }
    else if (accion == "borrar") {
        $("#dialogPantalla").html('Estas seguro?');
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
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Instructivo",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/ayuda/instructivo/delete?id=" + id;
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

            ]
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
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; Activar Instructivo",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/ayuda/instructivo/activar?id=" + id;
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

            ]
        });
        Loading.hide();

    }

}

$(document).ready(function() {

    $('#date-picker').datepicker();
    $.datepicker.setDefaults($.datepicker.regional = {
        dateFormat: 'dd-mm-yy',
        showOn: 'focus',
        showOtherMonths: false,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        minDate: new Date(1800, 1, 1),
        maxDate: 'today'
    });

});
