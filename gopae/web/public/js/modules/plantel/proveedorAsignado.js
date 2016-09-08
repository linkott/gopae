$(document).ready(function() {
    $.mask.definitions['~'] = '[+-]';
    $.mask.definitions['6'] = '[1-2]';

});

//function asignarProveedor() {
//    alert("sad");
//    var proveedor_id = id;
//    var plantel_id = $("#plantelId").val();
//    
//
//    $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey">¿Desea inactivar este Menú?</p></div>');
//    var dialog = $("#dialogPantalla").removeClass('hide').dialog({
//        modal: true,
//        width: '450px',
//        dragable: false,
//        resizable: false,
//        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Asignación de Proveedor</h4></div>",
//        title_html: true,
//        buttons: [
//            {
//                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
//                "class": "btn btn-warning btn-xs",
//                click: function() {
//                    $(this).dialog("close");
//                }
//            },
//            {
//                html: "<i class='icon-trash bigger-110'></i>&nbsp; Asignar ",
//                "class": "btn btn-primary btn-xs",
//                click: function() {
//                    var divResult = "resultadoOperacion";
//                    var urlDir = "/planteles/proveedorAsignado/asignarProveedor";
//                    var datos = {plantel_id:plantel_id, proveedor_id:proveedor_id};
//                    var conEfecto = true;
//                    var showHTML = true;
//                    var method = "POST";
//                    var callback = function() {
//                        $('#plantel-proveedor-grid').yiiGridView('update', {
//                            data: $(this).serialize()
//                        });
//                    };
//                    if (datos) {
//                        $.ajax({
//                            url: urlDir,
//                            data: datos,
//                            dataType: 'html',
//                            type: method,
//                            success: function(resp) {
//                                $("#respProveedorAsignado").html(resp);
//
//                                $('#proveedor-grid').yiiGridView('update', {
//                                    data: $(this).serialize()
//                                });
//                                $('#plantel-proveedor-grid').yiiGridView('update', {
//                                    data: $(this).serialize()
//                                });
//
//                            }
//
//                        });
//                        $(this).dialog("close");
//                    }
//                }
//            }
//        ]
//    });
//    Loading.hide();
//
//}



function VentanaDialog(id, direccion, title, accion, datos) {

    accion = accion;
    Loading.show();
    var data = {id: id, datos: datos};
    if (accion === "borrar") {

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey">¿Desea inactivar este Menú?</p></div>');

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
                    "class": "btn btn-warning btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; inactivar ",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/menuNutricional/menuNutricional/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#menu-grid').yiiGridView('update', {
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

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Desea activar este Menú? </p></div>');

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
                    "class": "btn btn-warning btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-check bigger-110'></i>&nbsp; Reactivar",
                    "class": "btn btn-success btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/menuNutricional/menuNutricional/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#menu-grid').yiiGridView('update', {
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