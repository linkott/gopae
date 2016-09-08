$(document).on('ready', function(){
    $("#repEstadistico").on('click', function(evt){
        evt.preventDefault();
        reporteEstadistico('region', 'x');
    });

    $("#repEstadisticoRegistroUnico").on('click', function(evt){
        evt.preventDefault();
        reporteRegistroUnico('estado', 'x');
    });

    $("#repGrafico").on('click', function(evt){
        evt.preventDefault();
        reporteGraficoDirectores();
    });


    $('#control_zona_observacion').bind('keyup blur', function () {
        keyText(this, true);
    });

    $('#control_zona_observacion').bind('blur', function () {
        clearField(this);
    });

    //$("div#print_button").click(function(){
    //    alert('HOLA');
    //    $("div.PrintArea").printArea();
    //});

    $()
    $("div#print_button").on('click', function(){
        $("div.PrintArea").printArea("popup");
    });

});

/**
 * Genera el reporte Estadístico de Carga de Autoridades.
 * Si el nivel es "region" la dependency no es requerida, pero, si el nivel es "estado" la dependency debe ser el Id de la región de esos estados
 *
 * @param String nivel (estado, region)
 * @param Integer dependency
 */
function reporteRegistroUnico(nivel, dependency){

    $("#fechaCondicion").addClass('hide');

    var divResult = "resultado";
    var urlDir = "/control/reporteRegistroUnico/reporteEstadisticoRegistroUnico";
    var datos = 'nivel='+nivel+'&dependency='+dependency;
    var conEfecto = true;
    var showHTML = true;
    var method = "POST";
    var responseFormat = "html";
    var callback = null;

    $("#print_button").removeClass("hide");
    $("#tipoReporteText").html("Estadístico General");
    $("#selectTipoReporteText").html(": Estadístico General");
    //$("html, body").animate({ scrollTop: 0 }, "fast");

    // executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback, errorCallback, beforeSendCallback)
    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

}

function reporteEstadistico(nivel, dependency){

    $("#fechaCondicion").addClass('hide');
    //$("#print_button").removeClass("hide");

    var divResult = "resultado";
    var urlDir = "/control/reporteRegistroUnico/estadisticoDirectores";
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

function reporteGraficoDirectores(){

    var divResult = "resultado-script";
    var urlDir = "/control/reporteRegistroUnico/graficoEstadalDirectores";
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

    // executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback, errorCallback, beforeSendCallback)
    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

}


/**
 * Tiene la tarea de consultar y mostrar los Datos del Contacto de una Zona Educativa
 * Si la entidad es "zona_educativa" la referencia debería ser el Id del Estado de esa Zona Educativa
 *
 * @param String entidad
 * @param Integer referencia
 */
function verDatosContacto(entidad, referencia){

    var divResult = "dialog-contacto";
    var urlDir = "/control/autoridadesZona/getAutoridadZonaEstado";
    var datos = "estado_id="+referencia+"&entidad="+entidad;
    var conEfecto = true;
    var showHTML = true;
    var method = "POST";
    var responseFormat = "html";
    var callback = null;

    // executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback, errorCallback, beforeSendCallback)
    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

    $("#dialog-contacto").removeClass('hide').dialog({
        width: 800,
        height: 600,
        resizable: false,
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-user'></i> Datos de Contacto de Zona Educativa </h4></div>",
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
                html: "Cambiar Correo <i class='icon-save bigger-110'></i>",
                "class": "btn btn-primary btn-xs",
                click: function() {

                    //Cambiar el Correo
                    var divResult = "resultado-cambio-correo";

                    var emailZona = $("#email").val();
                    var emailBackup = $("#emailBackup").val();
                    var userId = $("#id").val();

                    if(userId.length>0){

                        if(isValidEmail(emailZona) && emailZona.length>3){

                            if(emailBackup!=emailZona){

                                var datos = $("#form-autoridad-zona").serialize();
                                var urlDir = "/control/autoridadesZona/cambiarCorreo";
                                var conEfecto = true;
                                var showHTML = true;
                                var method = "POST";
                                var responseFormat = "html";
                                var callback = function() {
                                    $("#emailBackup").val($("#email").val());
                                };

                                executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);

                            }

                        }else{

                            displayDialogBox(divResult, 'error', 'Este no parece ser un correo electrónico válido.');
                            $("#email").val(emailBackup);

                        }
                    }
                    else{

                        displayDialogBox(divResult, 'error', 'No se ha podido identificar al usuario al que desea modificar el correo. Recargue la página e intenetelo de nuevo.');

                    }

                }
            },
            {
                html: "Resetear Clave <i class='icon-key bigger-110'></i>",
                "class": "btn btn-success btn-xs",
                click: function() {

                    //Cambiar el Correo
                    var divResult = "resultado-cambio-correo";

                    var emailZona = $("#email").val();
                    var emailBackup = $("#emailBackup").val();
                    var userId = $("#id").val();

                    if(userId.length>0){

                        var datos = $("#form-autoridad-zona").serialize();
                        var urlDir = "/control/autoridadesZona/resetearClave";
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var responseFormat = "html";
                        var callback = null;

                        executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                    }
                    else{

                        displayDialogBox(divResult, 'error', 'No se ha podido identificar al usuario al que desea modificar el correo. Recargue la página e intenetelo de nuevo.');

                    }

                }
            }
        ],
        close: function() {
            $("#dialog-contacto").html("");
        }
    });

}

/**
 * Si la entidad es "zona_educativa" la referencia debería ser el Id del Estado de esa Zona Educativa
 *
 * @param String entidad
 * @param Integer referencia
 */
function dialogObservacion(estado_id, estado){

    $("#dialog-observacion").removeClass('hide').dialog({
        width: 800,
        height: 350,
        resizable: false,
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-pencil'></i> Observacion de Zona Educativa "+estado+"</h4></div>",
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
                html: "Guardar &nbsp; <i class='icon-save bigger-110'></i>",
                "class": 'btn btn-primary btn-xs',
                click: function() {

                    var obs = $("#control_zona_observacion").val().trim();

                    if(obs.length==0){

                        displayDialogBox("resultadoControlZonaDirectores", 'error', "Debe ingresar una observación para que el control pueda ser registrado.");

                    }else{

                        var divResult = "resultadoControlZonaDirectores";
                        var urlDir = "/control/autoridadesZona/controlAutoridadZonaEstado";
                        var datos = $("#form-control-zona-directores").serialize()+"&estado_id="+estado_id;
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var responseFormat = "html";
                        var callback = function(){
                            $("#control_zona_observacion").val("");
                        };

                        executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                    }

                }
            }
        ],
        close: function() {
            $(this).dialog("close");
        }
    });

}


function dialogRegistroControl(entidad, referencia, estado){

    var divResult = "dialog-contacto";
    var urlDir = "/control/autoridadesZona/getRegistroControlAutoridadZona";
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