$(document).ready(function() {

    $("#MenuNutricionalAlimento_alimentos_id").select2({
        allowClear: false
    });

    $('#MenuNutricionalAlimento_cantidad,#MenuNutricionalAlimento_cantidad_mediana, #MenuNutricionalAlimento_cantidad_grande').bind('blur, keyup', function() {
        keyNum(this, true, false);
    });


    $("#alimento-form").on('submit', function(evt) {
        evt.preventDefault();

        $.ajax({
            url: "/menuNutricional/menuNutricional/agregarAlimento",
            data: $("#alimento-form").serialize(),
            dataType: 'html',
            type: 'post',
            success: function(resp) {
                $("#respMenuAlimento").html(resp);
                $('#alimento-grid').yiiGridView('update', {
                    data: $(this).serialize()
                });

            }

        });

    });


});


function agregarSustitutoAlimento(id) {
    var idAlimento = $("#alimento").val();
    var idMenu = $("#menu").val();
    var cantidad= $("#MenuNutricionalSustitutos_cantidad").val();
    var cantidad_mediana= $("#MenuNutricionalSustitutos_cantidad_mediana").val();
    var cantidad_grande= $("#MenuNutricionalSustitutos_cantidad_grande").val();
    Loading.show();

    var data = {id: id, idAlimento: idAlimento, idMenu: idMenu, cantidad:cantidad, cantidad_mediana: cantidad_mediana, cantidad_grande: cantidad_grande};


    $.ajax({
        url: "/menuNutricional/menuNutricional/agregarAlimentoSustituto",
        data: data,
        dataType: 'html',
        type: 'post',
        success: function(result)
        {
            $("#respMenuAlimentoSustituto").html(result);
            var direccion = "/menuNutricional/menuNutricional/actualizarListado/id/" + idAlimento;
            var direccion2 = "/menuNutricional/menuNutricional/actualizarListadoDisponible/id/" + idMenu;
            $("#alimentoSeleccionado").load(direccion);
//             $('#alimento-sustituto-grid').yiiGridView('update', {
//                                data: $(this).serialize()
//                            });
//            $("#alimentoDisponible").load(direccion2);
        }
    });
    Loading.hide();
}

function quitarSustituto(id) {
    var idAlimento = $("#alimento").val();
    var idMenu = $("#menu").val();
    Loading.show();
    var data = {id: id, idAlimento: idAlimento};


    $.ajax({
        url: "/menuNutricional/menuNutricional/quitarAlimentoSustituto",
        data: data,
        dataType: 'html',
        type: 'post',
        success: function(result)
        {

            $("#respMenuAlimentoSustituto").html(result);

            var direccion = "/menuNutricional/menuNutricional/actualizarListado/id/" + idAlimento;
            var direccion2 = "/menuNutricional/menuNutricional/actualizarListadoDisponible/id/" + idMenu;
            $("#alimentoSeleccionado").load(direccion);

            $("#alimentoDisponible").load(direccion2);


        }
    });
    Loading.hide();
}



function VentanaDialog(id, direccion, title, accion, datos) {

    accion = accion;
    Loading.show();
    var data = {id: id, datos: datos};
    $("#dialogPantallaAlimento").removeClass('hide');
    $("#dialogPantallaAlimento").load(direccion, data, function() {
        Loading.hide();
    });

//
//    else if (accion === "activar") {
//
//        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Desea activar este Proveedor? </p></div>');
//
//        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
//            modal: true,
//            width: '450px',
//            dragable: false,
//            resizable: false,
//            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> " + title + "</h4></div>",
//            title_html: true,
//            buttons: [
//                {
//                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
//                    "class": "btn btn-xs orange",
//                    click: function() {
//                        $(this).dialog("close");
//                    }
//                },
//                {
//                    html: "<i class='icon-check bigger-110'></i>&nbsp; Reactivar",
//                    "class": "btn btn-success btn-xs",
//                    click: function() {
//                        var divResult = "resultadoOperacion";
//                        var urlDir = "/proveedor/proveedor/" + accion + "/";
//                        var datos = {id: id, accion: accion};
//                        var conEfecto = true;
//                        var showHTML = true;
//                        var method = "POST";
//                        var callback = function() {
//                            $('#proveedor-grid').yiiGridView('update', {
//                                data: $(this).serialize()
//                            });
//                        };
//
//                        if (datos) {
//                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, 'html', callback);
//                            $(this).dialog("close");
//                        }
//                    }
//                }
//            ]
//        });
//        Loading.hide();
//    }
//
//    else if (accion === "agregarSustituto") {
//
//        $.ajax({
//            url: direccion,
//            data: data,
//            dataType: 'html',
//            type: 'post',
//            success: function(result, action)
//            {
//                var dialog = $("#dialogPantallaAlimento").removeClass('hide').dialog({
//                    modal: true,
//                    width: '1100px',
//                    dragable: false,
//                    resizable: false,
//                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
//                    title_html: true,
//                    buttons: [
//                        {
//                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
//                            "class": "btn btn-danger",
//                            click: function() {
//                                $(this).dialog("close");
//                            }
//                        }
//
//                    ]
//
//
//                });
//
//
//                $("#dialogPantallaAlimento").html(result);
//            }
//        });
//        Loading.hide();
//    }

}



function VentanaConfirm(id, direccion, title, accion, datos) {
    accion = accion;
    Loading.show();
    var data = {id: id, datos: datos};
    if (accion === "borrar") {

        $("#dialogConfirm").html('<div class="alertDialogBox"> <p><b>¿Desea Eliminar este alimento del menú? </b><br> Al eliminar este alimento del menu se eliminaran tambien sus sustitutos.</p></div>');

        var dialog = $("#dialogConfirm").dialog({
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
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar ",
                    "class": "btn btn-danger btn-xs",
                    click: function() {

                        var divResult = "resultadoOperacion";
                        var urlDir = direccion;
                        var datos = {id: id};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "GET";
                        var callback = function(response) {

                            $("#respMenuAlimento").html(response);

                            $('#alimento-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                            $("#dialogPantallaAlimento").html('');
                        };

                        if (datos) {
                            $.ajax({
                                url: urlDir,
                                data: datos,
                                dataType: 'html',
                                type: method,
                                success: function(response)
                                {
                                    $("#respMenuAlimento").html(response);

                                    $('#alimento-grid').yiiGridView('update', {
                                        data: $(this).serialize()
                                    });
                                    $("#dialogPantallaAlimento").html('');

                                }
                            });

//                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, 'html', callback);
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
                    executeAjax('_borrar', '/catalogo/unidadMedida/borrar', data, false, true, 'post', 'html');
                }
            }
        ]
    });


}