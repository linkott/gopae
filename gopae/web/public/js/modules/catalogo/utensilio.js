function VentanaDialog(id, direccion, title, accion, datos) {

    accion = accion;
    Loading.show();
    var data = {id:id, datos:datos};

    if (accion === "create" || accion === "update") {
        $.ajax({
            url: direccion,
            data: data,
            dataType: 'html',
            type: 'POST',
            success: function(result, action)
            {
                var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                    modal: true,
                    width: '1100px',
                    dragable: false,
                    resizable: false,
                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-plus'></i> " + title + "</h4></div>",
                    title_html: true,
                    buttons: [
                        {
                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Cancelar",
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
                                var urlDir = "/catalogo/utensilio/" + accion + "/ '" + id + "'";
                                var datos = $("#utensilio-form").serialize();
                                var conEfecto = true;
                                var showHTML = true;
                                var method = "POST";
                                var callback = function() {
                                    $('#utensilio-grid').yiiGridView('update', {
                                        data: $(this).serialize()
                                    });
                                };

                                if (datos) {
                                    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, 'html', callback);
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

    else if (accion === "view") {

        $.ajax({
            url: direccion,
            data: data,
            dataType: 'html',
            type: 'GET',
            success: function(result, action)
            {
                var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                    modal: true,
                    width: '700px',
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

    else if (accion === "borrar") {

        $("#dialogPantalla").html('<div class="alert alert-warning"> ¿Desea inactivar este utensilio?</div>');

        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> " + title + "</h4></div>",
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
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; inactivar ",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/catalogo/utensilio/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#utensilio-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };
                        if (datos) {
                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, 'html', callback);
                            $(this).dialog("close");
                        }
                    }
                }
            ]
        });
        Loading.hide();
    }

    else if (accion === "activar") {

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Desea habilitar este utensilio? </p></div>');

        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> " + title + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-xs orange",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-check bigger-110'></i>&nbsp; Reactivar",
                    "class": "btn btn-success btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/catalogo/utensilio/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#utensilio-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };

                        if (datos) {
                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, 'html', callback);
                            $(this).dialog("close");
                        }
                    }
                }
            ]
        });
        Loading.hide();
    }
}


function cambiarEstatus() {

    var id = $("id").val();
    var data = {id: id};
    var dialog = $("#dialogPantalla").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar este utensilio </h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-xs orange",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Utensilio",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    executeAjax('_borrar', '/catalogo/utensilio/borrar', data, false, true, 'POST', 'html');
                }
            }
        ]
    });


}