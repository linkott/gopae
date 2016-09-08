$(document).on('ready', function() {
    $('#busqueda_fecha').unbind('click');
    $("#busqueda_fecha").on('click', function(evt) {
        evt.preventDefault();
        var fecha = $("#fecha_desde").val();
        buscarFecha(fecha, 'region', 'x');

    });

    $('#repEstadisticoDiario').unbind('click');
    $("#repEstadisticoDiario").on('click', function(evt) {
        evt.preventDefault();
        var fecha = $("#fecha_desde").val();
        buscarFecha(fecha, 'region', 'x');
    });



    $('#repGraficoDiario').unbind('click');
    $('#repGraficoDiario').on('click', function(evt) {

    });


    /*AQUI CARGAMOS EL DATE PICKER PARA LAS FECHAS*******/
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $.datepicker.setDefaults($.datepicker.regional = {
        dateFormat: 'dd-mm-yy',
        'showOn': 'focus',
        'showOtherMonths': false,
        'selectOtherMonths': true,
        'changeMonth': true,
        'changeYear': true,
        minDate: new Date(2014, 1, 1),
        maxDate: 'today',
        //yearRange: '2014:2014' 
    });
    $('#fecha_desde').datepicker();



});

function reporteEstadisticoDiario(nivel, dependency) {

    var divResult = "resultado";
    var urlDir = "/control/DirectoresDiario/estadisticoDirectoresDiario";
    var datos = 'nivel=' + nivel + '&dependency=' + dependency;
    var conEfecto = true;
    var showHTML = true;
    var method = "POST";
    var responseFormat = "html";
    var callback = null;

    /*$("#tipoReporteTextDiario").html("Estadístico");
     $("#selectTipoReporteTextDiario").html(": Estadístico");
     $("html, body").animate({ scrollTop: 0 }, "fast");

     */
    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
    $("#infoDirectoresDiario").hide();
    $("#fechaCondicion").removeClass('hide');


}
// parametro de fecha 
function buscarFecha(fecha, nivel, dependency) {

    var divResult = "resultado";
    var urlDir = "/control/DirectoresDiario/estadisticoDirectoresDiario";
    var datos = 'fecha=' + fecha + '&nivel=' + nivel + '&dependency=' + dependency;
    var conEfecto = true;
    var showHTML = true;
    var method = "POST";
    var responseFormat = "html";
    var callback = null;

    $("#tipoReporteText").html("Estadístico Diario");
    $("#selectTipoReporteText").html(": Estadístico Diario");
    //$("html, body").animate({ scrollTop: 0 }, "fast");

    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
    $("#infoDirectoresDiario").hide();
    $("#fechaCondicion").removeClass('hide');
}