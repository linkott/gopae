function refrescarGrid() {
    $('#plantel-plan-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
}
function verPlanPlantel(id) {

    var divResult = "dialog-planEstudio";
    var urlDir = "/catalogo/planEstudio/verDetalle/id/" + id;
    var datos = {renderPartial: true};
    var conEfecto = true;
    var showHTML = true;
    var method = "GET";
    var callback = function() {

        $(document).ready(function() {
            $('input[type=text]')
            $('input[type=text]').tooltip({
                show: {
                    effect: "slideDown",
                    delay: 250
                }
            });
        });

    };

    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method);

    $("#dialog-planEstudio").removeClass('hide').dialog({
        width: 1100,
        resizable: false,
        draggable: false,
        position: ['center', 50],
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-search'></i> Detalle del Plan de Estudio </h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    $(this).dialog("close");
                }
            }
        ],
        close: function() {
            $("#dialog-planEstudio").html("");
        }
    });

}

function cambiarEstatusPlanPlantel(id, descripction, accion) {

    var accionDes = new String();
    var boton = new String();
    var botonClass = new String();

    $('#confirm-description').html(descripction);

    if (accion === 'A') {
        accionDes = 'Activar';
        boton = "<i class='icon-ok bigger-110'></i>&nbsp; Activar Grupo";
        botonClass = 'btn btn-primary btn-xs';
    } else {
        accionDes = 'Inactivar';
        boton = "<i class='icon-trash bigger-110'></i>&nbsp; Inactivar Grupo";
        botonClass = 'btn btn-danger btn-xs';
    }

    $(".confirm-action").html(accionDes);

    $("#confirm-status").removeClass('hide').dialog({
        width: 800,
        resizable: false,
        draggable: false,
        modal: true,
        position: ['center', 50],
        title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i> Cambio de Estatus de Plan de Estudio</h4></div>",
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
                html: boton,
                "class": botonClass,
                click: function() {

                    var divResult = "div-result-message";
                    var urlDir = "/planteles/planes/cambiarEstatus/id/" + id;
                    var datos = "accion=" + accion;
                    var conEfecto = true;
                    var showHTML = true;
                    var method = "POST";
                    var responseFormat = "html";
                    var callback = function() {
                        refrescarGrid();
                    };

                    $("html, body").animate({scrollTop: 0}, "fast");

                    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

                    $(this).dialog("close");

                }
            }

        ]
    });

}
$("#btnAsignarPlan").click(function() {

    var plantel_id = $("#plantel_id").val();

    divResult = 'dialog_asignarPlan';

    urlDir = '/planteles/planes/planesDisponibles/';

    datos = {
        plantel_id: plantel_id

    };

    conEfecto = true;

    showHTML = true;

    method = 'GET';

    callback = function() {


    };

    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method);

    $("#dialog_asignarPlan").removeClass('hide').dialog({
        width: 1000,
        resizable: false,
        draggable: false,
        position: ['center', 50],
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller red'><i class='icon-book'></i> Planes de Estudios Disponibles </h4></div>",
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
                html: "<i class='icon-plus bigger-110'></i>&nbsp; Agregar Plan",
                "class": "btn btn-primary btn-xs",
                click: function() {
                    divResult = 'divResult';

                    urlDir = '/planteles/planes/asignarPlan/';

                    datos = $("#plantel-plan-form").serialize();

                    conEfecto = true;

                    showHTML = true;

                    method = 'get';

                    callback = function(datahtml) {
                        console.log(datahtml);


                    };
                    $.ajax({
                        type: method,
                        url: urlDir,
                        dataType: "html",
                        data: datos,
                        beforeSend: function() {
                            if (conEfecto) {
                                var url_image_load = "<div class='center'><img title='Su transacci&oacute;n est&aacute; en proceso' src='/public/images/ajax-loader-red.gif'></div>";
                                displayHtmlInDivId(divResult, url_image_load);
                            }
                        },
                        success: function(datahtml, resp2, resp3) {

                            try {
                                var json = jQuery.parseJSON(resp3.responseText);
                                refrescarGrid();
                                displayDialogBox('div-result-message', 'exito', json.message);
                                $("#dialog_asignarPlan").dialog("close");
                            } catch (e) {
                                if (showHTML) {
                                    displayHtmlInDivId(divResult, datahtml, conEfecto);
                                }
                                if (typeof callback == "function" && callback) {
                                    callback.call();
                                }
                            }

                        },
                        statusCode: {
                            404: function() {
                                displayDialogBox(divResult, "error", "404: No se ha encontrado el recurso solicitado. Recargue la P&aacute;gina e intentelo de nuevo.");
                            },
                            400: function() {
                                displayDialogBox(divResult, "error", "400: Error en la petici&oacute;n, comuniquese con el Administrador del Sistema para correcci&oacute;n de este posible error.");
                            },
                            401: function() {
                                displayDialogBox(divResult, "error", "401: Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.");
                            },
                            403: function() {
                                displayDialogBox(divResult, "error", "403: Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.");
                            },
                            500: function() {
                                if (typeof callback == "function")
                                    callback.call();
                                displayDialogBox(divResult, "error", "500: Se ha producido un error en el sistema, Comuniquese con el Administrador del Sistema para correcci&oacute;n del m&iacute;smo.");
                            },
                            503: function() {
                                displayDialogBox(divResult, "error", "503: El servidor web se encuentra fuera de servicio. Comuniquese con el Administrador del Sistema para correcci&oacute;n del error.");
                            },
                            999: function(resp) {
                                displayDialogBox(divResult, "error", resp.status + ': ' + resp.responseText);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            //alert(thrownError);
                            if (xhr.status == '401') {
                                document.location.href = "http://" + document.domain + "/";
                            } else if (xhr.status == '400') {
                                displayDialogBox(divResult, "error", "Recurso no encontrado. Recargue la P&aacute;gina e intentelo de nuevo.");
                            } else if (xhr.status == '500') {
                                displayDialogBox(divResult, "error", "Se ha producido un error en el sistema, Comuniquese con el Administrador del Sistema para correcci&oacute;n del m&iacute;smo.");
                            } else if (xhr.status == '503') {
                                displayDialogBox(divResult, "error", "El servidor web se encuentra fuera de servicio. Comuniquese con el Administrador del Sistema para correcci&oacute;n del error.");
                            }
                            else if (xhr.status == '999') {
                                displayDialogBox('dialog_asignarPlan', "error", xhr.status + ': ' + xhr.responseText);
                            }
                        }
                    });
                }

            }

        ],
        close: function() {

            $(this).dialog("close");

        }

    });

});



$(document).ready(function() {
    $('.look-data').unbind('click');
    $('.look-data').on('click',
            function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                verPlanPlantel(id);
            }
    );

    $('.change-status').unbind('click');
    $('.change-status').on('click',
            function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                var description = $(this).attr('data-description');
                var accion = $(this).attr('data-action');
                cambiarEstatusPlanPlantel(id, description, accion);
            }
    );

    $('#plan').bind('keyup blur', function() {
        keyAlphaNum(this, true, false);
        makeUpper(this, true);
    });
    $('#mencion').bind('keyup blur', function() {
        keyAlphaNum(this, true, true);
        makeUpper(this, true);
    });
    $('#credencial').bind('keyup blur', function() {
        keyAlphaNum(this, true, true);
        makeUpper(this, true);
    });
    $('#fund_juridico').bind('keyup blur', function() {
        keyAlphaNum(this, true, true);
        makeUpper(this, true);
    });
    $('#cod_plan').bind('keyup blur', function() {
        keyNum(this, true, true);
    });
    $('#PlanPlantel_plan').bind('keyup blur', function() {
        keyAlphaNum(this, true, true);
        makeUpper(this, true);
    });
    $('#PlanPlantel_mencion').bind('keyup blur', function() {
        keyAlphaNum(this, true, true);
        makeUpper(this, true);
    });
    $('#PlanPlantel_credencial').bind('keyup blur', function() {
        keyAlphaNum(this, true, true);
        makeUpper(this, true);
    });
    $('#PlanPlantel_fund_juridico').bind('keyup blur', function() {
        keyAlphaNum(this, true, true);
        makeUpper(this, true);
    });
    $('#PlanPlantel_cod_plan').bind('keyup blur', function() {
        keyNum(this, true, false);
    });

});