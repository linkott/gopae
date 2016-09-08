function VentanaDialog(id, direccion, title, accion, datos) {
    Loading.show();
    var data = {id:id, datos:datos};

    if (accion === "create" || accion === "update") {
        $.ajax({
            url: direccion,
            data: data,
            dataType: 'html',
            type: 'POST',
            success: function(result, state){
                var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                    modal: true,
                    width: '700px',
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
                                $('#btnGuardarUnidadMedida').click();
                            }
                        }
                    ]
                });

                $("#dialogPantalla").html(result).ready(function(){
                    validacionFormulario(accion, id);
                });
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

        $("#dialogPantalla").html('<div class="alert alert-warning"> ¿Desea inactivar esta unidad de medida?</div>');

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
                        var urlDir = "/catalogo/unidadMedida/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#unidad-medida-grid').yiiGridView('update', {
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

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Desea habilitar esta unidad de medida? </p></div>');

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
                        var urlDir = "/catalogo/unidadMedida/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#unidad-medida-grid').yiiGridView('update', {
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
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar esta unidad de medida</h4></div>",
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
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Unidad de Medida",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    executeAjax('_borrar', '/catalogo/unidadMedida/borrar', data, false, true, 'POST', 'html');
                }
            }
        ]
    });


}

function validacionFormulario(accion, id){
    $("#unidad-medida-form").unbind('submit');
    $("#unidad-medida-form").on('submit',function(evt){
        evt.preventDefault();
        var divResult = "dialogPantalla";
        var urlDir = "/catalogo/unidadMedida/" + accion + "/ '" + id + "'";
        var datos = $("#unidad-medida-form").serialize();
        var conEfecto = true;
        var showHTML = true;
        var method = "POST";
        var callback = function() {
            validacionFormulario(accion, id);
            $('#unidad-medida-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
        };

        if (datos) {
            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, 'html', callback);
        }
        else {
            $(this).dialog("close");
        }
    });
}
