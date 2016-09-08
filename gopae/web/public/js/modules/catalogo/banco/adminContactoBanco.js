function validation(){

    $('#ContactoBanco_nombre_apellido').on('keyup blur', function () {
        
    });

    $('#ContactoBanco_identificador').on('keyup blur', function () {
        keyAlphaNum(this, true);
    });
    
    $('#ContactoBanco_observaciones').on('keyup blur', function () {
        keyAlphaNum(this, true);
    });
    
    $('#ContactoBanco_correo').on('keyup blur', function () {
        keyEmail(this, true);
    });
    
    $("#contacto-banco-form").on('submit', function(evt){
        evt.preventDefault();
        registroConsultaBanco($(this));
    });
    
    $("#contacto-banco-grid").on('submit', function(evt){
        evt.preventDefault();
        registroConsultaBanco($(this));
    });
    
    $("#ContactoBanco_nombre_apellido_form").on('keyup blur', function() {  });
    
    
    $.mask.definitions['L'] = '[1-2]';
    $.mask.definitions['X'] = '[2|4|6]';
    
    $('#ContactoBanco_telefono_fax').mask('(0299)999-9999');
    $('#ContactoBanco_telefono_fijo').mask('(0299)999-9999');
    $('#ContactoBanco_telefono_celular').mask('(04LX)999-9999');
        
}

$(document).ready(function(){

    
    var bancoId = $("#Banco_idEncoded").val();
    getListaContactosBanco(bancoId);
    eventButtonsGrid(bancoId);
    
});


function registroConsultaBanco(form){
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
            refreshContactoBanco(response.bancoId);
            boxStyle = 'success';
        } else {
            boxStyle = 'error';
        }
        
        
        
        displayDialogBox('#mensajeContactoBanco', boxStyle, mensaje);

        $("#botonCancelarRegistroContactoBanco").click();

        $("html, body").animate({scrollTop: 0}, "fast");

    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}



function getListaContactosBanco(bancoIdEncoded){
    var divResult = "#divContactosBanco";
    var urlDir = "/catalogo/contactoBanco/lista/id/"+bancoIdEncoded;
    var datos = "";
    var loadingEfect = true;
    var showResult = true;
    var method = "GET";
    var responseFormat = "html";
    var successCallback = function(response){
        var bancoId = $("#Banco_idEncoded").val();
        eventButtonsGrid(bancoId);
        $("#newRegisterContactoBanco").unbind('click');
        $("#newRegisterContactoBanco").on('click', function(evt){
            getFormRegistroContactosBanco(bancoId);
        });
    };
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}

function getFormRegistroContactosBanco(bancoIdEncoded){
    var divResult = "#divFormContactosBancoDialog";
    var urlDir = $("#newRegisterContactoBanco").attr('data-href')+"/id/"+bancoIdEncoded;
    var datos = {"nombreBanco": $("#Banco_nombre").val()};
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = function(response){
        validation();
        
        
        $("#contacto-banco-form").on('submit', function(evt){
            evt.preventDefault();
            
        });
        
        $("#ContactoBanco_banco_id").val(atob(bancoIdEncoded));
        var dialog = $("#divFormContactosBancoDialog").removeClass('hide').dialog({
            modal: true,
            width: '750px',
            draggale: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Registro de Contacto del Banco </h4></div>",
            title_html: true,
            buttons: [{
                    html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                    "class": "btn btn-xs btn-danger",
                    "id": "botonCancelarRegistroContactoBanco",
                    "click": function() {
                        $(this).dialog("close");
                    }
                },
                {
                html: "Guardar &nbsp;<i class='fa fa-save bigger-110'></i>",
                "class": "btn btn-info btn-xs",
                "id": "botonRegistroContactoBanco",
                "click": function() {
                    $("#btnSubmitContactoBanco").click();
                    
                }
            }]
        });
    };
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}

function refreshContactoBanco(bancoId){
    
    var divResult = "#divListaContactoBanco";
    var urlDir = "/catalogo/contactoBanco/listaContactoBanco/id/"+bancoId;
    var datos = '';
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";

    var successCallback = function () {
        eventButtonsGrid(bancoId);
    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}

function eventButtonsGrid(bancoId)
{
    $(".boton-ver").click( function (evento) {
        var idContactoBanco = atob( $(this).attr("id") );
        evento.preventDefault();
        getFormVerContactosBanco(idContactoBanco);
    });
    
    $(".boton-editar").click( function (evento) {
        var idContactoBanco = atob( $(this).attr("id") );
        evento.preventDefault();
        getFormEditarContactosBanco(idContactoBanco, bancoId);
    });
       
    $(".boton-eliminar").click( function (evento) {
        var idContactoBanco = atob( $(this).attr("id") );
        evento.preventDefault();
         bootbox.confirm("¿Estas seguro/a?", function(result) {
            if(result) {
                eliminarContactoBanco(idContactoBanco, bancoId);
            }
        });
    });
    
    $(".boton-activar").click( function (evento) {
        var idContactoBanco = atob( $(this).attr("id") );
        evento.preventDefault();
         bootbox.confirm("¿Estas seguro/a?", function(result) {
            if(result) {
                activarContactoBanco(idContactoBanco, bancoId);
            }
        });
    });
}


function eliminarContactoBanco(contactoId, bancoId){
    
    var divResult = "";
    var urlDir = "/catalogo/contactoBanco/eliminacion/id/"+contactoId;
    var datos = "";
    var loadingEfect = false;
    var showResult = false;
    var method = "POST";
    var responseFormat = "html";

    var successCallback = function(evt) {
        refreshContactoBanco(bancoId);
    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}


function activarContactoBanco(contactoId, bancoId){
    
    var divResult = "";
    var urlDir = "/catalogo/contactoBanco/activacion/id/"+contactoId;
    var datos = "";
    var loadingEfect = false;
    var showResult = false;
    var method = "POST";
    var responseFormat = "html";

    var successCallback = function(evt) {
        refreshContactoBanco(bancoId);
    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}

function getFormEditarContactosBanco(contactoId, bancoIdEncoded){
    var divResult = "#divFormContactosBancoDialog";
    var urlDir = "/catalogo/contactoBanco/edicion/id/"+contactoId;
    var datos = "";
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = function(response){
        validation();
        
        $("#contacto-banco-form").on('submit', function(evt){
            evt.preventDefault();
        });
        
        $("#ContactoBanco_banco_id").val(bancoIdEncoded);
        var dialog = $("#divFormContactosBancoDialog").removeClass('hide').dialog({
            modal: true,
            width: '750px',
            draggale: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Modificar Contacto del Banco </h4></div>",
            title_html: true,
            buttons: [{
                    html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                    "class": "btn btn-xs btn-danger",
                    "id": "botonCancelarRegistroContactoBanco",
                    "click": function() {
                        $(this).dialog("close");
                    }
                },
                {
                html: "Guardar &nbsp;<i class='fa fa-save bigger-110'></i>",
                "class": "btn btn-info btn-xs",
                "id": "botonRegistroContactoBanco",
                "click": function() {
                    $("#btnSubmitContactoBanco").click();
                }
            }]
        });
    };
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}


function getFormVerContactosBanco(contactoId){
    var divResult = "#divFormContactosBancoDialog";
    var urlDir = "/catalogo/contactoBanco/consulta/id/"+contactoId;
    var datos = "";
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = function(response){
        validation();
        $("[class^='disable']").attr('disabled',true);
        var dialog = $("#divFormContactosBancoDialog").removeClass('hide').dialog({
            modal: true,
            width: '750px',
            draggale: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i>Contacto del Banco </h4></div>",
            title_html: true,
            buttons: [{
                    html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                    "class": "btn btn-xs btn-danger",
                    "id": "botonCancelarRegistroContactoBanco",
                    "click": function() {
                        $(this).dialog("close");
                    }
            }]
        });
    };
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}


