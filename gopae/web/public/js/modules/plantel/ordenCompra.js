$(document).ready(function() {
    $('#nuevaOrdenCompra').bind('click', function() {

        var d = new Date();

        var mes_actual = d.getMonth();
        
        var mes = btoa($('#mes').val());

        if (atob(mes) <= mes_actual) {
            $("#resultadoOperacion").html('<div class="alertDialogBox"><p>Solo se pueden realizar ordenes de compra durante los meses posteriores al actual.</p></div>');
        }else{
            $("#resultadoOperacion").html('');
        var id = $('#id').val();
        window.location.href = "/planteles/ordenCompra/create/id/" + id + "/item/" + mes;
        }

    });

    $('#OrdenCompra_anticipo').bind('keyup blur', function() {
        keyNum(this, true);

    });

    $('#OrdenCompra_dias_habiles').bind('keyup blur', function() {
        keyNum(this, true);

    });

    $(".osito").bind('click', function() {

        var id = $(this).attr('data-id');
        
        var temp_unidad = $('#unidad' + id).html();
        var temp_cantidad = $('#cantidad' + id).html();
        var temp_nombre = $('#nombre' + id).html();
        var temp_precio = $('#precio' + id).html();
        var temp_total = $('#total' + id).html();
        var temp_alim = $(this).attr('data-alim');
        $('#unidad' + id).html($(this).attr('data-um'));
        $('#cantidad' + id).html($(this).attr('data-cantidades'));
        $('#nombre' + id).html($(this).attr('data-nombre'));
        $('#precio' + id).html($(this).attr('data-precio'));
        $('#total' + id).html($(this).attr('data-total'));
        $("#alimento_id_" + id).attr("value", ($(this).attr('data-alim')));
        $("#cantidad_" + id).attr("value", $(this).attr('data-cantidad'));
        $("#precio_" + id).attr("value", $(this).attr('data-precio'));

        $(this).html("<span style='font-family:Helvetica Neue,Arial,Helvetica,sans-serif;'>&nbsp;&nbsp;" + temp_nombre + "</span>");
        $(this).attr('data-um', temp_unidad);
        $(this).attr('data-cantidades', temp_cantidad);
        $(this).attr('data-nombre', temp_nombre);
        $(this).attr('data-precio', temp_precio);
        $(this).attr('data-total', temp_total);
        $(this).attr('data-alimento', temp_alim);



    });

});

$("#orden-compra-form").on('submit', function(evt) {

    evt.preventDefault();
    $.ajax
            ({
                url: '/planteles/ordenCompra/elaborarOrden/',
                data: $("#orden-compra-form").serialize(),
                dataType: 'json',
                type: 'post',
                beforeSend:function(){ Loading.show();},
                success: function(resp)
                {
                      Loading.hide();
                    if (resp.status == "exito") {

                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("successDialogBox");
                        $("#respOrdenCompra p").html(resp.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");
                        //alert(btoa($("#dependencia").val()));
                        window.location.href = "/planteles/ordenCompra/index/id/" + btoa($("#dependencia").val()) + "";


                    } else if (resp.status == "error") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("alertDialogBox");
                        $("#respOrdenCompra p").html(resp.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "validacion") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra p").html(resp.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "con-orden-actual") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("alertDialogBox");
                        $("#respOrdenCompra p").html("Ya se registro una orden de compra durante este mes");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "sin-pae-act") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("alertDialogBox");
                        $("#respOrdenCompra p").html("Este plantel no recibe servicio de alimentacion escolar");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "sin-prov") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("alertDialogBox");
                        $("#respOrdenCompra p").html("Este plantel no tiene ningun proveedor asignado");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "sin-plan") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("alertDialogBox");
                        $("#respOrdenCompra p").html("Este plantel no posee una planificacion alimentaria durante este mes");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    }
                }

            });

});
$("#orden-compra-update-form").on('submit', function(evt) {

    evt.preventDefault();
    $.ajax
            ({
                url: '/planteles/ordenCompra/modificarOrden/',
                data: $("#orden-compra-update-form").serialize(),
                dataType: 'json',
                type: 'post',
                beforeSend:function(){ Loading.show();},
                success: function(resp)
                {
                      Loading.hide();
                    if (resp.status == "exito") {

                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("successDialogBox");
                        $("#respOrdenCompra p").html(resp.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");
                        //alert(btoa($("#dependencia").val()));
                        window.location.href = "/planteles/ordenCompra/index/id/" + btoa($("#dependencia").val()) + "";


                    } else if (resp.status == "error") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("alertDialogBox");
                        $("#respOrdenCompra p").html(resp.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "validacion") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra p").html(resp.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "con-orden-actual") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("alertDialogBox");
                        $("#respOrdenCompra p").html("Ya se registro una orden de compra durante este mes");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "sin-pae-act") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("alertDialogBox");
                        $("#respOrdenCompra p").html("Este plantel no recibe servicio de alimentacion escolar");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "sin-prov") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("alertDialogBox");
                        $("#respOrdenCompra p").html("Este plantel no tiene ningun proveedor asignado");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "sin-plan") {
                        $("#respOrdenCompra").removeClass();
                        $("#respOrdenCompra").addClass("alertDialogBox");
                        $("#respOrdenCompra p").html("Este plantel no posee una planificacion alimentaria durante este mes");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    }
                }

            });

});

function VentanaDialog(id, direccion, title, accion, datos) {

    accion = accion;
    Loading.show();
    var data = {id: id, datos: datos};
    if (accion === "borrar") {

        $("#dialogPantalla").html('<div class="alert alert-warning"> ¿Desea Eliminar esta Orden de Compra?</div>');

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
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar ",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/planteles/ordenCompra/eliminar/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#orden-compra-grid').yiiGridView('update', {
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

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Desea activar esta Orden Compra? </p></div>');

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
                        var urlDir = "/planteles/ordenCompra" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#orden-compra-grid').yiiGridView('update', {
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
     else if (accion === "aprobar") {

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Desea Aprobar esta Orden Compra? </p></div>');

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
                    html: "<i class='icon-check bigger-110'></i>&nbsp; Aprobar",
                    "class": "btn btn-success btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/planteles/ordenCompra/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "GET";
                        var callback = function() {
                            $('#orden-compra-grid').yiiGridView('update', {
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