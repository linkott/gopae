/**
 * Created by jsinner on 16/11/14.
 */

// ingestaTextDialog
// cantidad_comensales
// tipo_ingesta_id

var listaIngestas = [{
    "id": 1,
    "nombre": "DESAYUNO",
    "estatus": "A",
    "nombre_label": "label-info"
}, {
    "id": 2,
    "nombre": "ALMUERZO",
    "estatus": "A",
    "nombre_label": "label-success"
}, {
    "id": 3,
    "nombre": "MERIENDA",
    "estatus": "A",
    "nombre_label": "label-yellow"
}, {
    "id": 4,
    "nombre": "CENA",
    "estatus": "A",
    "nombre_label": "label-important"
}];

var listaIngestasPlantel = new Array();

var mensajeIngestaComensales = "";

$(document).ready(function() {

    listaIngestasPlantel = $("#listaIngestasPlantel").val().split(";").filter(Boolean);

    var matriculaTotal = $("#matriculaTotal").val();
    $("#matriculaText").html(matriculaTotal);
    mensajeIngestaComensales = $("#resultFormIngestaComensales").html();

    $("#IngestaRegistroForm").on("submit", function(evt) {
        evt.preventDefault();
        $("#botonRegistroIngesta").click();
    });

    $("#PlantelIngesta_cantidad_comensales").numeric({decimal: false, negative: false});

    // console.log(listaIngestasPlantel);

    $("#tipo_ingesta_id").on("change", function() {
        
        var matriculaTotal = $("#matriculaTotal").val();
        $("#matriculaText").html(matriculaTotal);
        
        var optionSelected = $(
            "#tipo_ingesta_id option:selected");
        var optionSelectedText = optionSelected.text();
        var tipoIngestaId = $(this).val();

        if (tipoIngestaId.length > 0) {
            $("#ingestaTextDialog").val(optionSelectedText);
            $("#PlantelIngesta_tipo_ingesta_id").val(
                tipoIngestaId);
            $("#PlantelIngesta_cantidad_comensales").focus();

            if (existePlantelPae()) {
                var dialog = $("#dialogIngestaRegistro").removeClass(
                    'hide').dialog({
                    modal: true,
                    width: '750px',
                    draggale: false,
                    resizable: false,
                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Registro de Ingesta en el Plantel </h4></div>",
                    title_html: true,
                    buttons: [{
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-xs btn-danger",
                        "id": "botonCancelarIngesta",
                        "click": function() {
                            $("#ingestaTextDialog").val("");
                            $("#PlantelIngesta_tipo_ingesta_id").val("");
                            $("#PlantelIngesta_cantidad_comensales").val("");
                            $("#resultFormIngestaComensales").html(mensajeIngestaComensales);
                            $("#tipo_ingesta_id").val("");
                            $(this).dialog("close");
                        }
                    }, {
                        html: "Guardar Datos &nbsp;<i class='fa fa-save bigger-110'></i>",
                        "class": "btn btn-info btn-xs",
                        "id": "botonRegistroIngesta",
                        "click": function() {
                            var comensales = $("#PlantelIngesta_cantidad_comensales").val();

                            var mensaje = "La cantidad de comensales sobrepasa la cantidad total de la Matrícula Indicada en el Plantel. (" + matriculaTotal + ")";

                            if (comensales.length > 0 && cantidadDeComensalesValida()) {
                                registrarIngesta(optionSelected, optionSelectedText, tipoIngestaId);
                            }
                            else {
                                if (comensales.length <= 0) {
                                    mensaje = "Debe indicar la cantidad de comensales en esta ingesta.";
                                }
                                displayDialogBox("#resultFormIngestaComensales", "error", mensaje);
                            }
                        }
                    }]
                });
            } else {
                
                $("#tipo_ingesta_id").val("");
                
                displayDialogBox("#dialogoIngestaMensaje", "alert", "Antes de indicar las ingestas que provee el plantel debe cargar los Datos Generales del PAE así como los Datos de la Matrícula en el mismo.");

                var dialog = $("#dialogoIngestaMensaje").removeClass('hide').dialog({
                    modal: true,
                    width: '680px',
                    draggale: false,
                    resizable: false,
                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Registro de Ingestas </h4></div>",
                    title_html: true,
                    buttons: [{
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-xs btn-danger",
                        "id": "botonIngestaCancelar",
                        "click": function() {
                            $(this).dialog(
                                "close"
                            );
                        }
                    }]
                });
            }
        }

    });

});

function registrarIngesta(optionSelected, optionSelectedText, tipoIngestaId) {

    var plantelId = $("#PlantelIngesta_plantel_id").val();
    var divResult = "#resultadoIngestasPae";
    var urlDir = "/registroUnico/PlantelesPae/registroIngesta/id/" + base64_encode(plantelId);
    var datos = $("#IngestaRegistroForm").serialize();
    var loadingEfect = true;
    var showResult = false;
    var method = "POST";
    var responseFormat = "json";

    var successCallback = function(response, estatusCode, dom) {

        var mensaje = 'El servidor no ha proporcionado una respuesta con respecto a la operación';
        var status = 400;
        var boxStyle = 'error';

        if (undefined !== response.mensaje) {
            mensaje = response.mensaje;
        }

        if (undefined !== response.status) {
            status = response.status;
        }

        if (status == 200) {
            boxStyle = 'success';
            if (undefined !== response.data && undefined !== response.data
                .id) {
                var plantelIngesta = response.data;
                displayDialogBox("#resultadoIngestasPae", boxStyle, mensaje);
                agregarFilaIngestaPlantel(plantelIngesta.id, optionSelectedText, plantelIngesta.cantidad_comensales, tipoIngestaId, optionSelected);
                //console.log(listaIngestasPlantel);
            }
        } else {
            displayDialogBox("#resultadoIngestasPae", boxStyle, mensaje);
        }

        $("#botonCancelarIngesta").click();

        $("html, body").animate({
            scrollTop: 0
        }, "fast");

    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method,
        responseFormat, successCallback);

}

function eliminarIngesta(plantelIngestaid, ingesta, tipoIngestaId) {

    $("#tipoIngestaTextEliminar").html(ingesta.toLowerCase());

    var dialog = $("#dialogIngestaEliminar").removeClass('hide').dialog({
        modal: true,
        width: '750px',
        draggale: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Registro de Ingesta en el Plantel </h4></div>",
        title_html: true,
        buttons: [{
                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                "class": "btn btn-xs btn-danger",
                "id": "botonCancelarEliminarIngesta",
                "click": function() {
                    $(this).dialog("close");
                }
            },
            {
            html: "Eliminar &nbsp;<i class='fa fa-trash bigger-110'></i>",
            "class": "btn btn-info btn-xs",
            "id": "botonEliminarIngesta",
            "click": function() {

                var plantelId = $("#PlantelIngesta_plantel_id").val();
                var divResult = "#resultadoIngestasPae";
                var urlDir = "/registroUnico/PlantelesPae/eliminarIngesta/id/"+base64_encode(plantelId);
                var datos = {"plantelIngestaid": plantelIngestaid, "ingesta": ingesta, "tipoIngestaId": tipoIngestaId};
                var loadingEfect = false;
                var showResult = false;
                var method = "POST";
                var responseFormat = "json";

                var successCallback = function(response, estatusCode, dom) {

                    var mensaje = 'El servidor no ha proporcionado una respuesta con respecto a la operación';
                    var status = 400;
                    var boxStyle = 'error';

                    if (undefined !== response.mensaje) {
                        mensaje = response.mensaje;
                    }

                    if (undefined !== response.status) {
                        status = response.status;
                    }

                    if (status == 200) {
                        boxStyle = 'success';
                        if (undefined !== response.data && undefined !== response.data.id) {
                            var plantelIngesta = response.data;
                            displayDialogBox("#resultadoIngestasPae", boxStyle, mensaje);
                            eliminarFilaIngestaPlantel(plantelIngesta.id, ingesta, tipoIngestaId);
                        }
                    } else {
                        displayDialogBox("#resultadoIngestasPae", boxStyle, mensaje);
                    }

                    $("#botonCancelarEliminarIngesta").click();

                    $("html, body").animate({scrollTop: 0}, "fast");

                };

                executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
            }
        }]
    });

}

function existePlantelPae() {
    var result = ($("#PlantelPae_pae_activo").val() == 'SI' && !isNaN($("#PlantelPae_id").val()) && ($("#matriculaTotal").val() * 1) > 0);
    return result;
}

function cantidadDeComensalesValida() {
    var matriculaTotal = $("#matriculaTotal").val() * 1;
    var comensales = $("#PlantelIngesta_cantidad_comensales").val() * 1;
    var result = comensales <= matriculaTotal;
    return result;
}

/**
 *
 * @param id integer PlantelIngesta_id
 */
function agregarFilaIngestaPlantel(id, ingesta, comensales, tipoIngestaId, optionSelected) {

    listaIngestasPlantel.push(tipoIngestaId);
    $("#listaIngestasPlantel").val(listaIngestasPlantel.join(';'));

    if (listaIngestasPlantel.length > 0) {
        $("#trIngestaNotExists").remove();
    }
    var filaIngesta = '    <tr id="trIngesta' + id + '">\
        <td>' + htmlentities(ingesta) + '</td>\
        <td>' + htmlentities(comensales) + '</td>\
        <td><div style="text-align: right"><a onclick="eliminarIngesta(' + id + ', \'' + ingesta + '\', ' + tipoIngestaId + ');"><i class="fa fa-trash red"></i></a></div></td>\
    </tr>';
    console.log(listaIngestasPlantel);
    // Agrego la fila correspondiente a la ingesta seleccionada.
    $("#ingesta-grid-body").append(filaIngesta);
    // Elimino la ingesta a la lista de ingestas seleccionables.
    optionSelected.remove();
    return filaIngesta;
}

/**
 *
 * @param id integer PlantelIngesta_id
 */
function eliminarFilaIngestaPlantel(id, ingesta, tipoIngestaId) {

    var ingestaAEliminar = tipoIngestaId;

    var listaIngestasPlantelStr = $("#listaIngestasPlantel").val().replace(ingestaAEliminar, "").replace(";;",";");
    $("#listaIngestasPlantel").val(listaIngestasPlantelStr);
    listaIngestasPlantel = $("#listaIngestasPlantel").val().split(";").filter(Boolean);

    var filaIngesta = "";
    if (listaIngestasPlantel.length == 0) {
        filaIngesta = '    <tr id="trIngestaNotExists">\
        <td class="empty" colspan="3"><span class="empty">No existen ingestas registradas en este plantel.</span></td>\
    </tr>';
        $("#ingesta-grid-body").append(filaIngesta);
    }

    // Elimino la fila correspondiente a la ingesta seleccionada.
    $('#trIngesta' + id).remove();
    // Agrego la ingesta a la lista de ingestas seleccionables.
    $('#tipo_ingesta_id').append("<option id='tipoIngestaId"+tipoIngestaId+"' value='"+tipoIngestaId+"'>"+ingesta+"</option>");
    return filaIngesta;
}
