function setUpEventsFields() {

    var identificador = "Banco";

    $('#' + identificador + '_nombre').bind('keyup blur', function () {
        keyAlpha(this, true, true);
    });

    $('#' + identificador + '_nombre').bind('blur', function () {
        clearField(this);
    });
}

$(document).ready(function () {
    
    setUpEventsFields();

    //Tipo Cuenta Banco
    
    $("#TipoCuentaBanco_identificador").on('keyup blur', function () {
        keyNum(this, false);
    });

    $("#tipo-cuenta-banco-form").on('submit', function(evt){
        evt.preventDefault();
        registroTipoCuenta($(this));
    });
    
    //Tipo Serial Cuenta Banco
    
    $("#TipoSerialCuentaBanco_serial").on('keyup blur', function () {
        keyNum(this, false);
    });
    
    $("#tipo-serial-cuenta-banco-form").on('submit', function(evt){
        evt.preventDefault();
        registroTipoSerialCuenta($(this));
    });
    
});

// FUNCIONES DE TIPO CUENTA BANCO

function displayTipoCuentaBancoForm (campoTc ,bancoId, bancoNombre){
    var tipoCuentaId = $(campoTc).val();
    var tipoCuentaField = $(campoTc).attr('id');
    var tipoCuentaNombre = $("#"+tipoCuentaField+" option:selected").text();
    
    $("#TipoCuentaBanco_banco_id").val(bancoId);
    $("#TipoCuentaBanco_banco").val(bancoNombre);
    $("#TipoCuentaBanco_tipo_cuenta_id").val(tipoCuentaId);
    $("#TipoCuentaBanco_tipo_cuenta").val(tipoCuentaNombre);
    $("#TipoCuentaBanco_identificador").val("");
    $("#TipoCuentaBanco_identificador").focus();
    
    var dialog = $("#tipoCuentaBancoDialog").removeClass('hide').dialog({
        modal: true,
        width: '750px',
        draggale: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Registro de Tipo de Cuenta del Banco "+bancoNombre+" </h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                "class": "btn btn-xs btn-danger",
                "id": "botonCancelarRegistroTipoCuentaBanco",
                "click": function() {
                    $(this).dialog("close");
                }
            },
            {
                html: "Guardar &nbsp;<i class='fa fa-save bigger-110'></i>",
                "class": "btn btn-info btn-xs",
                "id": "botonRegistroTipoCuentaBanco",
                "click": function() {
                    $("#btnSubmitTipoCuentaBanco").click();
                }
            }]
    });
}


function registroTipoCuenta(form){
    var divResult = "";
    var urlDir = form.attr('action');
    var datos = form.serialize();
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
            refreshTipoCuentaBanco(response.bancoId, response.bancoNombre);
        } else {
            boxStyle = 'error';
        }
        
        displayDialogBox('#mensajeTipoCuentaBanco', boxStyle, mensaje);

        $("#botonCancelarRegistroTipoCuentaBanco").click();

        $("html, body").animate({scrollTop: 0}, "fast");

    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}

function refreshTipoCuentaBanco(bancoId, bancoNombre){
    var divResult = "#divSelectTipoCuentaBanco";
    var urlDir = "/catalogo/banco/listaTipoCuentaBanco/id/"+base64_encode(bancoId);
    var datos = {"nombre":bancoNombre};
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";

    var successCallback = null;

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}


function eliminarTipoCuentaBanco(tipoCuentaBancoIdEncoded){

    var dialog = $("#deleteTipoCuentaBancoDialog").removeClass('hide').dialog({
        modal: true,
        width: '750px',
        draggale: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminación de Tipo de Cuenta</h4></div>",
        title_html: true,
        buttons: [{
                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-xs btn-danger",
                "id": "botonCancelarEliminacionTipoCuentaBanco",
                "click": function() {
                    $(this).dialog("close");
                }
            },
            {
            html: "Aceptar &nbsp;<i class='fa fa-trash bigger-110'></i>",
            "class": "btn btn-warning btn-xs",
            "id": "botonEliminacionTipoCuentaBanco",
            "click": function() {

                var divResult = "#mensajeTipoCuentaBanco";
                var urlDir = "/catalogo/banco/eliminaTipoCuentaBanco/id/"+tipoCuentaBancoIdEncoded;
                var bancoNombre = $("#Banco_nombre").val();
                var bancoId = $("#Banco_idEncoded").val();
                var datos = {'bancoNombre':bancoNombre, 'bancoId':bancoId};
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
                        refreshTipoCuentaBanco(response.bancoId, response.bancoNombre);
                    } else {
                        boxStyle = 'error';
                    }

                    $("#botonCancelarEliminacionTipoCuentaBanco").click();

                    displayDialogBox('#mensajeTipoCuentaBanco', boxStyle, mensaje);

                };

                executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
            }
        }]
    });

}
//FIN DE FUNCIONES TIPO CUENTA BANCO
//
//FUNCIONES DE TIPO SERIAL CUENTA BANCO
//

function displayTipoSerialCuentaBancoForm (campoTsc ,bancoId, bancoNombre){
    var tipoSerialCuentaId = $(campoTsc).val();
    var tipoSerialCuentaField = $(campoTsc).attr('id');
    var tipoSerialCuentaNombre = $("#"+tipoSerialCuentaField+" option:selected").text();
    
    $("#TipoSerialCuentaBanco_banco_id").val(bancoId);
    $("#TipoSerialCuentaBanco_banco").val(bancoNombre);
    $("#TipoSerialCuentaBanco_tipo_serial_cuenta_id").val(tipoSerialCuentaId);
    $("#TipoSerialCuentaBanco_tipo_serial_cuenta").val(tipoSerialCuentaNombre);
    $("#TipoSerialCuentaBanco_serial").val("");
    $("#TipoSerialCuentaBanco_serial").focus();
    
    var dialog = $("#tipoSerialCuentaBancoDialog").removeClass('hide').dialog({
        modal: true,
        width: '750px',
        draggale: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Registro de Tipo de Serial de Nomina del Banco "+bancoNombre+" </h4></div>",
        title_html: true,
        buttons: [{
                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                "class": "btn btn-xs btn-danger",
                "id": "botonCancelarRegistroTipoSerialCuentaBanco",
                "click": function() {
                    $(this).dialog("close");
                }
            },
            {
            html: "Guardar &nbsp;<i class='fa fa-save bigger-110'></i>",
            "class": "btn btn-info btn-xs",
            "id": "botonRegistroTipoSerialCuentaBanco",
            "click": function() {
                $("#btnSubmitTipoSerialCuentaBanco").click();
            }
        }]
    });
}


function registroTipoSerialCuenta(form){
    var divResult = "";
    var urlDir = form.attr('action');
    var datos = form.serialize();
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
            refreshTipoSerialCuentaBanco(response.bancoId, response.bancoNombre);
        } else {
            boxStyle = 'error';
        }
        
        displayDialogBox('#mensajeTipoSerialCuentaBanco', boxStyle, mensaje);

        $("#botonCancelarRegistroTipoSerialCuentaBanco").click();

        $("html, body").animate({scrollTop: 0}, "fast");

    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}


function refreshTipoSerialCuentaBanco(bancoId, bancoNombre){
    var divResult = "#divSelectTipoSerialCuentaBanco";
    var urlDir = "/catalogo/banco/listaTipoSerialCuentaBanco/id/"+base64_encode(bancoId);
    var datos = {"nombre":bancoNombre};
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";

    var successCallback = null;

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}


function eliminarTipoSerialCuentaBanco(tipoSerialCuentaBancoIdEncoded){

    var dialog = $("#deleteTipoSerialCuentaBancoDialog").removeClass('hide').dialog({
        modal: true,
        width: '750px',
        draggale: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminación de Tipo de Serial de Nomina</h4></div>",
        title_html: true,
        buttons: [{
                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-xs btn-danger",
                "id": "botonCancelarEliminacionTipoSerialCuentaBanco",
                "click": function() {
                    $(this).dialog("close");
                }
            },
            {
            html: "Aceptar &nbsp;<i class='fa fa-trash bigger-110'></i>",
            "class": "btn btn-warning btn-xs",
            "id": "botonEliminacionTipoSerialCuentaBanco",
            "click": function() {

                var divResult = "#mensajeTipoSerialCuentaBanco";
                var urlDir = "/catalogo/banco/eliminaTipoSerialCuentaBanco/id/"+tipoSerialCuentaBancoIdEncoded;
                var bancoNombre = $("#Banco_nombre").val();
                var bancoId = $("#Banco_idEncoded").val();
                var datos = {'bancoNombre':bancoNombre, 'bancoId':bancoId};
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
                        refreshTipoSerialCuentaBanco(response.bancoId, response.bancoNombre);
                    } else {
                        boxStyle = 'error';
                    }

                    $("#botonCancelarEliminacionTipoSerialCuentaBanco").click();

                    displayDialogBox('#mensajeTipoSerialCuentaBanco', boxStyle, mensaje);

                };

                executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);

            }
        }]
    });

}
//FIN DE FUNCIONES TIPO SERIAL CUENTA BANCO

