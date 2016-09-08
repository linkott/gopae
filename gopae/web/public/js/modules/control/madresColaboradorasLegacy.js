$(document).on('ready', function(){

    $("#repEstadistico").on('click', function(evt){
        evt.preventDefault();
        reporteEstadistico('estadoTotal', 'x');
    });

    $("#repGrafico").on('click', function(evt){
        evt.preventDefault();
        reporteGraficoMadresColaboradorasLegacy();
    });

    $('#control_zona_observacion').bind('keyup blur', function () {
        keyText(this, true);
    });

    $('#control_zona_observacion').bind('blur', function () {
        clearField(this);
    });

});

/**
 * Genera el reporte Estadístico de Carga de Autoridades.
 * Si el nivel es "region" la dependency no es requerida, pero, si el nivel es "estado" la dependency debe ser el Id de la región de esos estados
 *
 * @param String nivel (estado, region)
 * @param Integer dependency
 */
function reporteEstadistico(nivel, dependency){

    $("#fechaCondicion").addClass('hide');

    var divResult = "resultado";
    var urlDir = "/control/madresColaboradorasLegacy/estadisticoMadresColaboradoras";
    var datos = 'nivel='+nivel+'&dependency='+dependency;
    var conEfecto = true;
    var showHTML = true;
    var method = "POST";
    var responseFormat = "html";
    var callback = null;

    $("#tipoReporteText").html("Estadístico General");
    $("#selectTipoReporteText").html(": Estadístico General");
    //$("html, body").animate({ scrollTop: 0 }, "fast");

    // executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback, errorCallback, beforeSendCallback)
    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

}

function reporteGraficoMadresColaboradorasLegacy(){

    var divResult = "resultado";
    var urlDir = "/control/madresColaboradorasLegacy/graficoEstadal";
    var datos = "";
    var conEfecto = true;
    var showHTML = true;
    var method = "POST";
    var responseFormat = "html";
    var callback = function() {
        $("#fechaCondicion").addClass('hide');
    };

    $("#tipoReporteText").html("Gráfico General");
    $("#selectTipoReporteText").html(": Gráfico General");
    //$("html, body").animate({ scrollTop: 0 }, "fast");

    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

}

function dialogRegistroControl(entidad, referencia, estado){

    var divResult = "dialog-contacto";
    var urlDir = "/control/madresColaboradorasLegacy/getRegistroControlAutoridadZona";
    var datos = "estado_id="+referencia+"&entidad="+entidad;
    var conEfecto = true;
    var showHTML = true;
    var method = "POST";
    var responseFormat = "html";
    var callback = null;

    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

    $("#dialog-contacto").removeClass('hide').dialog({
        width: 950,
        height: 500,
        resizable: false,
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-user'></i> Datos de Contacto de Zona Educativa "+estado+"</h4></div>",
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
            $("#dialog-contacto").html("");
        }
    });
}