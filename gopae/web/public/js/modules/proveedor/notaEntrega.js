$(document).ready(function() {
    $('.cantidadEntregada').numeric(false, true);
    $('.cantidadEntregada').attr('autocomplete', 'off');


    $('.cantidadEntregada').bind('keyup', function() {
        var id = $(this).attr('data-id');
        var valor = ($(this).val()*1);
        var precio = ($('#precio' + id).attr('data-precio')*1);
        var tope = ($('#cantidad' + id).attr('data-cantidad')*1);
        var total = (valor * precio);
//        console.log(tope);
//        console.log(valor);
//        console.log(tope > valor);
        if (tope >= valor) {
              $(this).removeClass('error');
            $("#totalEntregado" + id).attr("value", total);
            $('#totalEntregadoSpan' + id).html(total.toFixed(2) + ' Bs.');

        }else{
           
            $(this).addClass('error');
            $(this).val(0);
            $("#totalEntregado" + id).attr("value", 0 );
            $('#totalEntregadoSpan' + id).html('0 Bs.');
        }




    });
    
   
    

    $('#nuevaNotaEntrega').bind('click', function() {

        var d = new Date();

        var mes_actual = d.getMonth();

        var mes = btoa($('#mes').val());

        if (atob(mes) <= mes_actual) {
            $("#resultadoOperacion").html('<div class="alertDialogBox"><p>Solo se pueden realizar notas de entrega durante los meses posteriores al actual.</p></div>');
        } else {
            $("#resultadoOperacion").html('');
            var id = $('#id').val();
            window.location.href = "/proveedor/notaEntrega/create/id/" + id + "/item/" + mes;
        }

    });

    $('#NotaEntrega_anticipo').bind('keyup blur', function() {
        keyNum(this, true);

    });

    $('#NotaEntrega_dias_habiles').bind('keyup blur', function() {
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

$("#nota-entrega-form").on('submit', function(evt) {

    var formData = new FormData($("#nota-entrega-form")[0]);
    var navegador = window.URL || window.webkitURL;
    var file = $("#archivo")[0].files[0];
    //obtenemos el nombre del archivo
    var fileName = file.name;
    //obtenemos la extensión del archivo
    var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
    //obtenemos el tamaño del archivo
    
    if (fileExtension!=('pdf'||'jpg'||'png')){
        
        alert("archivo invalido");
    }
    var fileSize = file.size;
    //obtenemos el tipo de archivo image/png ejemplo
    var fileType = file.type;
    //mensaje con la información del archivo
    var objeto_url = navegador.createObjectURL(file);


    evt.preventDefault();
    $.ajax
            ({
                url: '/proveedor/notaEntrega/crearNota/',
                // data: $("#nota-entrega-form").serialize(),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    Loading.show();
                },
                success: function(resp)
                {
                    Loading.hide();
                    if (resp.status == "exito") {

                        $("#respNotaEntrega").removeClass();
                        $("#respNotaEntrega").addClass("successDialogBox");
                        $("#respNotaEntrega p").html(resp.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");
                        //alert(btoa($("#dependencia").val()));
                        window.location.href = "/proveedor/notaEntrega/index/id/" + btoa($("#proveedor_id").val()) + "";


                    } else if (resp.status == "error") {
                        $("#respNotaEntrega").removeClass();
                        $("#respNotaEntrega").addClass("alertDialogBox");
                        $("#respNotaEntrega p").html(resp.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "validacion") {
                        $("#respNotaEntrega").removeClass();
                        $("#respNotaEntrega p").html(resp.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "con-orden-actual") {
                        $("#respNotaEntrega").removeClass();
                        $("#respNotaEntrega").addClass("alertDialogBox");
                        $("#respNotaEntrega p").html("Ya se registro una nota de entrega durante este mes");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "sin-pae-act") {
                        $("#respNotaEntrega").removeClass();
                        $("#respNotaEntrega").addClass("alertDialogBox");
                        $("#respNotaEntrega p").html("Este plantel no recibe servicio de alimentacion escolar");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "sin-prov") {
                        $("#respNotaEntrega").removeClass();
                        $("#respNotaEntrega").addClass("alertDialogBox");
                        $("#respNotaEntrega p").html("Este plantel no tiene ningun proveedor asignado");
                        $("html, body").animate({scrollTop: 0}, "fast");
                    } else if (resp.status == "sin-plan") {
                        $("#respNotaEntrega").removeClass();
                        $("#respNotaEntrega").addClass("alertDialogBox");
                        $("#respNotaEntrega p").html("Este plantel no posee una planificacion alimentaria durante este mes");
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

        $("#dialogPantalla").html('<div class="alert alert-warning"> ¿Desea inactivar esta Orden de Compra?</div>');

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
                        var urlDir = "/proveedor/notaEntrega/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#nota-entrega-grid').yiiGridView('update', {
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
                        var urlDir = "/proveedor/notaEntrega/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#nota-entrega-grid').yiiGridView('update', {
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