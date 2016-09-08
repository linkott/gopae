/**
 * Created by Ignacio Salazar ("/gescolar/web/public/modules/plantel/modificarPlantel.js").
 * Copied, Pasted and Edited by José Gabriel on 16/11/14.
 */
var datosGeneralesPlantel = "";

function CedulaFormat(vCedulaName, evento) {
    tecla = getkey(evento);
    vCedulaName.value = vCedulaName.value.toUpperCase();
    vCedulaValue = vCedulaName.value;
    valor = vCedulaValue.substring(2, 12);
    tam = vCedulaValue.length;
    var numeros = '0123456789/';
    var digit;
    var shift;
    var ctrl;
    var alt;
    var escribo = true;
    tam = vCedulaValue.length;

    if (shift && tam > 1) {
        return false;
    }
    for (var s = 0; s < valor.length; s++) {
        digit = valor.substr(s, 1);
        if (numeros.indexOf(digit) < 0) {
            noerror = false;
            break;
        }
    }
    if (escribo) {
        if (tecla == 8 || tecla == 37) {
            if (tam > 2)
                vCedulaName.value = vCedulaValue.substr(0, tam - 1);
            else
                vCedulaName.value = '';
            return false;
        }
        if (tam == 0 && tecla == 69) {
            vCedulaName.value = 'E-';
            return false;
        }
        if (tam == 0 && tecla == 86) {
            vCedulaName.value = 'V-';
            return false;
        }
        else if ((tam == 0 && !(tecla < 14 || tecla == 69 || tecla == 86 || tecla == 46)))
            return false;
        else if ((tam > 1) && !(tecla < 14 || tecla == 16 || tecla == 46 || tecla == 8 || (tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105)))
            return false;
    }
}

function getkey(e) {
    if (window.event) {

        shift = event.shiftKey;
        ctrl = event.ctrlKey;
        alt = event.altKey;
        return window.event.keyCode;
    }
    else if (e) {
        var valor = e.which;
        if (valor > 96 && valor < 123) {
            valor = valor - 32;
        }
        return valor;
    }
    else
        return null;
}


$(document).ready(function() {
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $.datepicker.setDefaults($.datepicker.regional = {
        dateFormat: 'dd-mm-yy',
        'showOn': 'focus',
        'showOtherMonths': false,
        'selectOtherMonths': true,
        'changeMonth': true,
        'changeYear': true,
        minDate: new Date(1979, 1, 1),
        maxDate: 'today',
        yearRange: '1979:2014'
    });
    $('#fecha_desde').datepicker();
    
    $.mask.definitions['L'] = '[1-2]';
    $.mask.definitions['Z'] = '[2|4]';
    $.mask.definitions['X'] = '[2|4|6]';

    $.mask.definitions['~'] = '[+-]';
    $('#Plantel_telefono_fijo').mask('(0299) 999-9999');

    $.mask.definitions['~'] = '[+-]';
    $('#Plantel_telefono_otro').mask('(0Z99) 999-9999');

    $.mask.definitions['~'] = '[+-]';
    $('#Plantel_nfax').mask('(0299) 999-9999');

    /* validacion cedula */
    $('#UserGroupsUser_cedula').bind('keyup blur', function() {
        clearField(this);
    });
    $('#UserGroupsUser_username').bind('keyup blur', function() {
        keyAlphaNum(this, false);
        clearField(this);
    });

    $('#Plantel_longitud').bind('keyup blur', function() {
        keyNum(this, true, true);
    });

    $('#Plantel_latitud').bind('keyup blur', function() {
        keyNum(this, true, true);
    });

    $("#Plantel_direccion").bind('keyup blur', function() {
        keyText(this, true);
    });

    $("#Plantel_consejo_comunal").bind('keyup blur', function() {
        keyText(this, true);
    });

    $("#plantel-form").on("submit", function(evt){
        var formType = $(this).attr("data-form-type");
        //console.log(formType);
        if(formType=='edicion'){
            evt.preventDefault();
            guardarDatosGenerales(evt);
        }
        else{
            var datos = $(this).serialize();
            validarDatosGenerales(evt, datos);
        }
    });
    
    $('#UserGroupsUser_nombre').bind('keyup blur', function() {
        keyAlphaNum(this, true, true);
    });
    
    $('#UserGroupsUser_apellido').bind('keyup blur', function() {
        keyAlphaNum(this, true, true);
    });

    $('#UserGroupsUser_telefono').mask('02999999999');
    $('#UserGroupsUser_telefono_celular').mask('04LX9999999');
    
    $('#UserGroupsUser_email').bind('keyup blur', function() {
        keyEmail(this, false);
    });
    
    if($("#plantel-form").attr('data-form-type')=='edicion'){
        datosGeneralesPlantel = $("#plantel-form").serialize();
    }
    
    $("#linkSolicitudComprobante").on('click', function(evt){
        evt.preventDefault();
        
        dialogSolicitudComprobante();
        
        var divResult = "#divResultDescargaComprobante";
        var urlDir = $(this).attr('href');
        var datos = '';
        var loadingEfect = false;
        var showResult = false;
        var method = 'GET';
        var responseFormat = "json";
        var successCallback = function(response, estatusCode, dom){
            var result = response.codigo;
            var mensaje = response.mensaje;
            if(result=='EXITO'){
                // displayDialogBox("#divResultDescargaComprobante", 'success', mensaje+" Haga click en el siguiente enlace para efectuar su descarga.");
                displayDialogBox("#divResultDescargaComprobante", 'success', mensaje+" Los Datos han sido validados correctamente, el comprobante será emitido posteriormente y enviado al correo del Director de la Institución.");
                $("#linkDescargaComprobanteCnae").attr("href", response.url_archivo_pdf+"?v="+Math.floor((Math.random() * 1000) + 1)).removeClass("hide");
            }
            else{
                displayDialogBox("#divResultDescargaComprobante", 'error', mensaje);
            }
            
        };
        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    });
    
    $("#Plantel_estado_id").on('change', function(){
        if($(this).val()!=''){
            var municipios = getDataCatastro('Municipio', 'estado_id', $(this).val());
            var municipiosSelect = generateOptionsToSelect(municipios, 'nombre', 'id', '');
            $("#Plantel_municipio_id").html(municipiosSelect);
            $("#Plantel_parroquia_id").html("<option>-SELECCIONE-</option>");
        }
        else{
            $("#Plantel_municipio_id").html('<option>-SELECCIONE-</option>');
            $("#Plantel_parroquia_id").html("<option>-SELECCIONE-</option>");
        }
        // $("#Plantel_urbanizacion_id").html("<option>-SELECCIONE-</option>");
        // $("#Plantel_poblacion_id").html("<option>-SELECCIONE-</option>");
    });
    
    $("#Plantel_municipio_id").on('change', function(){
        if($(this).val()!=''){
            var parroquias = getDataCatastro('Parroquia', 'municipio_id', $(this).val());
            var parroquiasSelect = generateOptionsToSelect(parroquias, 'nombre', 'id', '');
            $("#Plantel_parroquia_id").html(parroquiasSelect);
        }
        else{
            $("#Plantel_parroquia_id").html("<option>-SELECCIONE-</option>");
        }
        // $("#Plantel_urbanizacion_id").html("<option>-SELECCIONE-</option>");
        // $("#Plantel_poblacion_id").html("<option>-SELECCIONE-</option>");
    });

});

///// Validaciones del formulario plantel-form /////
$('#Plantel_cod_estadistico').bind('keyup blur', function() {
    keyNum(this, false);
});

$('#Plantel_cod_estadistico').bind('blur', function() {
    clearField(this);
});

$('#Plantel_cod_plantel').bind('keyup blur', function() {
    keyAlphaNum(this, false);
    makeUpper(this);
});

$('#Plantel_cod_plantel').bind('blur', function() {
    clearField(this);
});

$('#Plantel_cod_plantelNer').bind('keyup blur', function() {
    keyAlphaNum(this, false);
    makeUpper(this);
});

$('#Plantel_cod_plantelNer').bind('blur', function() {
    clearField(this);
});

$('#UserGroupsUser_telefono').bind('keyup blur', function() {
    keyAlphaNum(this, false);
});

$('#Plantel_codigo_ner').bind('keyup blur', function() {
    if( $('#Plantel_codigo_ner').val().length < 4 && $('#Plantel_codigo_ner').val().length != 0)
        $('#Plantel_codigo_ner').val('NER ');
    keyAlphaNum(this, true);//true si quiero espacios
    makeUpper(this);
});

$('#Plantel_codigo_ner').bind('blur', function() {
    clearField(this);
});

$('#Plantel_nombre').bind('keyup blur', function() {
    keyAlphaNum(this, true, true);//para que permita espacios en blanco
    makeUpper(this);
});

$('#Plantel_nombre').bind('blur', function() {
    clearField(this);
});


$.mask.definitions['K'] = '[0-9]';
$.mask.definitions['P'] = '[E|A|R|e|a|r]';

$('#Plantel_cod_plantelNer').mask('ZKKP');

////////////////////////// Fin //////////////////////////////////////////////////
function cerrarPestanasDatosGenerales() {
    //alert('hola');
    document.getElementById("identificacionP").setAttribute("class", "widget-box collapsed");
    document.getElementById("otrosDatosP").setAttribute("class", "widget-box collapsed");
    document.getElementById("datosUbicacionP").setAttribute("class", "widget-box collapsed");
}

///////////////////Guardar registro de la pestaña datos generales/////////////////
function guardarDatosGenerales(formEvnt){

    //console.log($("#plantel-form").attr("action"));
    var divResult = "#resultado";
    var urlDir = $("#plantel-form").attr("action");
    var datos = $("#plantel-form").serialize();
    var loadingEfect = true;
    var showResult = true;
    var method = $("#plantel-form").attr("method");
    var responseFormat = "html";
    var successCallback = function(response, estatusCode, dom){
        if(response.indexOf("errorDialogBox")!==-1){
            datosGeneralesPlantel = datos;
        }
        Loading.hide();
        $("html, body").animate({scrollTop: 0}, "fast");
    };

    if(validarDatosGenerales(formEvnt, datos)){
        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    }

}

function validarDatosGenerales(formEvnt, datos){
    
    var divResult = "resultado";

    if($("#Plantel_es_beneficiario_pae").val()!='SI'){

        formEvnt.preventDefault();
        $.gritter.add({
            title: 'Institución Educativa No Beneficiaria del PAE',
            text: 'Ha indicado en el campo <b>"Es beneficiario del PAE"</b> que este plantel <b>"No"</b> es beneficiario del Programa de Alimentación Escolar proveido por el CNAE, la naturaleza de este registro es justamente efectuar el registro de planteles beneficiarios.<br/><br/>Debe Seleccionar en este campo el valor <b>"Sí"</b>.',
            class_name: 'gritter-warning gritter-center'
        });
        $("#Plantel_es_beneficiario_pae").focus();
        scrollUp('slow');
        displayDialogBox("#resultado", 'error', 'Ha indicado en el campo <b>"Es beneficiario del PAE"</b> que este plantel <b>"No"</b> es beneficiario del Programa de Alimentación Escolar proveido por el CNAE, la naturaleza de este registro es justamente efectuar el registro de planteles beneficiarios.<br/><br/>Debe Seleccionar en este campo el valor <b>"Sí"</b>.');
        return false;
    }
    if($("#Plantel_estatus_plantel_id").val()!='1'){

        formEvnt.preventDefault();
        $.gritter.add({
            title: 'Institución Educativa Inactiva',
            text: 'La institución educativa debe estar en estatus <b>"Activa"</b>. El campo <b>"Estatus Plantel"</b> indica si una Institución se encuentra en estos momentos dictando clases y posee una matrícula estudiantil. Esta información no está relacionada con el Programa de Alimentación Escolar, si deseara indicar que el PAE se encuentra inactivo, debe indicarlo en la pestaña de Datos CNAE no sin antes realizar el registro o actualización de los <b>Datos Generales</b> de la Institución.<br/><br/>Debe seleccionar en este campo el Estatus <b>"Activo"</b>.',
            class_name: 'gritter-warning gritter-center'
        });
        $("#Plantel_estatus_plantel_id").focus();
        scrollUp('slow');
        displayDialogBox("#resultado", 'error', 'La institución educativa debe estar en estatus <b>"Activa"</b>. El campo <b>"Estatus Plantel"</b> indica si una Institución se encuentra en estos momentos dictando clases y posee una matrícula estudiantil. Esta información no está relacionada con el Programa de Alimentación Escolar, si deseara indicar que el PAE se encuentra inactivo, debe indicarlo en la pestaña de Datos CNAE no sin antes realizar el registro o actualización de los <b>Datos Generales</b> de la Institución.<br/><br/>Debe seleccionar en este campo el Estatus <b>"Activo"</b>.');
        return false;
    }
    if(datos==datosGeneralesPlantel){
        formEvnt.preventDefault();
        $.gritter.add({
            title: 'No hay cambios detectados',
            text: 'No existen cambios detectados en los datos generales de esta institución.',
            class_name: 'gritter-warning'
        });
        displayDialogBox(divResult, 'alert', "No existen cambios que guardar.");
        $("html, body").animate({scrollTop: 0}, "fast");
        return false;
    }
    
    return true;

}
///////////////////////Fin de Guardar registro////////////////////////////


//Al hacer click en cualquier lado del formulario devuelve el mensaje inicial
$("#resultadoPlantel").click(function() {
    document.getElementById("guardo").style.display = "none";
    document.getElementById("resultadoPlantel").style.display = "none";
    document.getElementById("resultado").style.display = "block";
});

var cod_plantel =  $("#Plantel_cod_plantel").val();

/////////////////////////////mostrar ner/////////////////////////////////////////
function mostrarNer() {
    if (document.getElementById('ner').checked == true) {
        $("#lblNer span").addClass('required').html('*');
        $("#lblCodNer span").addClass('required').html('*');
        //document.getElementById('divCod_plantel').style.display = 'none';
        //document.getElementById('divCod_plantelNER').style.display = 'block';
        $("#Plantel_cod_plantel").val('');
        $("#Plantel_codigo_ner").removeAttr('readonly');
        $("#Plantel_codigo_ner").val('NER ');
        $("#Plantel_codigo_ner").focus();
    } else {
        $("#lblNer span").removeClass('required').html('');
        $("#lblCodNer span").removeClass('required').html('');
        //document.getElementById('divCod_plantel').style.display = 'block';
        //document.getElementById('divCod_plantelNER').style.display = 'none';
        //document.getElementById('divNombreNer').style.display = 'none';
        $("#cod_plantelNer").val('');
        $("#Plantel_codigo_ner").val('');
        $("#Plantel_codigo_ner").attr('readonly', 'true');
        $("#Plantel_cod_plantel").val(cod_plantel);
        //  $("#cod_plantelNer").attr('disabled', TRUE);
    }
}
///////////////////////////////fin////////////////////////////////////////////////


/////////////////Verificar si existe la cedula en la tabla usergroups_user///////
function buscarCedulaAutoridad(cedula) {

    var plantel_id = $("#plantel_id").val();
    if (cedula != '' || cedula != null) {
        
        var divResult = "#cargandoBusquedaAutoridad";
        var urlDir = "/registroUnico/PlantelesPae/buscarCedula/id/"+base64_encode(plantel_id);
        var datos = {cedula: cedula, plantel_id: plantel_id};
        var loadingEfect = true;
        var showResult = false;
        var method = "GET";
        var responseFormat = "json";
        var successCallback = function(resp, estatusCode, dom) {
            $("#cargandoBusquedaAutoridad").html("");
            if (resp.statusCode === "mensaje")
                dialogo_error(resp.mensaje);
            if (resp.statusCode === "successC")
                mostrarBusquedasCedula(plantel_id, resp.autoridades, resp);
            // agregarCargo
            if (resp.statusCode === "successU")
                mostrarDialog(resp.nombre, resp.apellido, resp.usuario);
            // agregarUsuario
        };
        var beforeSendCallback = function(){
            $("#cargandoBusquedaAutoridad").html("<div class='padding-5 center'><img title='Su transacci&oacute;n est&aacute; en proceso' src='/public/images/ajax-loader-red.gif'></div>");
        };

        var errorCallback = null;
        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback, errorCallback, beforeSendCallback);

    }
}
////////////////////////////////////fin//////////////////////////////////////////


//////////////////////////////Guardar nueva autoridad////////////////////////////
function guardarNuevaAutoridad() {

    var data = $("#plantelAgregarAutoridad-form").serialize();
    var plantelId = $("#PlantelPae_plantel_id").val();
    var divResult = "";
    var urlDir = "guardarNuevaAutoridad";
    var datos = data;
    var loadingEfect = true;
    var showResult = false;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = function(resp, resp2, resp3) {
           if (isNaN(resp)) {
                document.getElementById("resultadoAutoridades").style.display = "none";
                document.getElementById("resultadoPlantelAutoridades").style.display = "block";
                $("#resultadoPlantelAutoridades").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");

            } else {
                document.getElementById("resultadoAutoridades").style.display = "none";
                document.getElementById("guardoAutoridades").style.display = "block";
                document.getElementById("autor").setAttribute("class", "widget-box");
                $("html, body").animate({scrollTop: 0}, "fast");
            }
        };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    
}///////////////////////////////fin////////////////////////////////////////////////////


function eliminarAutoridad(id) {

    $("#dialogConfirmEliminarAutoridad").removeClass('hide').dialog({
        modal: true,
        width: '680px',
        draggable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Desvinculación de Autoridad</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='fa fa-arrow-left bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-xs",
                "id" : "btnCancelarEliminarAutoridad",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                html: "Aceptar &nbsp; <i class='fa fa-arrow-right icon-on-right bigger-110'></i>",
                "class": "btn btn-primary btn-xs",
                click: function() {
                    var plantelId = $("#PlantelPae_plantel_id").val();
                    var data = {
                        id: id,
                        plantel_id: plantelId
                    };
                    var divResult = "";
                    var urlDir = "/registroUnico/plantelesPae/eliminarAutoridad/plantelId/"+base64_encode(plantelId);
                    var datos = data;
                    var loadingEfect = true;
                    var showResult = false;
                    var method = "POST";
                    var responseFormat = "html";
                    var successCallback = function(resp, resp2, resp3) {
                        $("#_formAutoridades").html(resp);
                        $("#btnCancelarEliminarAutoridad").click();
                    };

                    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
                }
            }
        ]
    });
    $("#dialogConfirmEliminarAutoridad").show();

}


///////////////si encuentra la cedula muestra ventana para agregar autoridad/////////////

function mostrarBusquedasCedula(plantel_id, autoridades, resp) {

    var cedula = $("#cedula").val();

    $("#Cargo_cedula").val(resp.cedula);
    $("#Cargo_nombre").val(resp.nombre);
    $("#Cargo_apellido").val(resp.apellido);

    //console.log(autoridades);

    if (cedula !== '') {
        $("#cedula").val('');
        var dialog = $("#dialog_cargo").removeClass('hide').dialog({
            modal: true,
            width: '750px',
            draggable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Cargo a Asignar</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "id" : "btnCancelarAsignacionCargo",
                    "class": "btn btn-xs",
                    click: function() {
                        $("#Cargo_presento_documento_identidad").val('');
                        $("#Cargo_cedula").val('');
                        $("#Cargo_nombre").val('');
                        $("#Cargo_apellido").val('');
                        $("#cargo_id_c").val('');
                        $(this).dialog("close");
                    }
                },
                {
                    html: "Guardar &nbsp; <i class='icon-save icon-on-right bigger-110'></i>",
                    "class": "btn btn-primary btn-xs",
                    click: function() {

                        //  alert($("#cargo_id").val());
                        if ($("#cargo_id_c").val() !== '' && $("#Cargo_presento_documento_identidad").val()=='SI') {
                            var data = {
                                cedula: cedula,
                                plantel_id: plantel_id,
                                cargo: $("#cargo_id_c").val(),
                                presento_documento_identidad: $("#Cargo_presento_documento_identidad").val()
                            };
                            
                            var plantelId = $("#PlantelPae_plantel_id").val();
                            var divResult = "";
                            var urlDir = "/registroUnico/plantelesPae/agregarAutoridad/id/"+base64_encode(plantelId);
                            var datos = data;
                            var loadingEfect = true;
                            var showResult = false;
                            var method = "POST";
                            var responseFormat = "html";
                            var successCallback = function(resp, resp2, resp3) {
                                    try {
                                        var json = jQuery.parseJSON(resp3.responseText);
                                        $("#dialog_cargo").dialog("close");
                                        dialogo_error(json.mensaje);
                                    } catch (e) {
                                        $("#btnCancelarAsignacionCargo").click();
                                        $("#cargo_id").val('');
                                        $("#dialog_cargo").dialog("close");
                                        $("#_formAutoridades").html(resp);
                                    }

                                };

                            executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
                            
                        }
                        else {
                            if ($("#Cargo_presento_documento_identidad").val() != 'SI'){
                                $.gritter.add({
                                    title: 'No se ha presentado el Documento de Identidad',
                                    text: 'Para poder registrar la autoridad la misma debe presentar su documento de identidad.',
                                    class_name: 'gritter-error'
                                });
                            }
                            $("#autoridad_error").show();
                        }
                    }
                }
            ]
        });
        $("#dialog-autoridades").show();
    }
}
////////////////////////////////////////fin/////////////////////////////////////////////



function guardarAutoridad(plantel_id, autoridades) {
    
    var data = {plantel_id: plantel_id, autoridades: autoridades};

    var plantelId = $("#PlantelPae_plantel_id").val();
    var divResult = "";
    var urlDir = "/registroUnico/plantelesPae/guardarAutoridad/id/"+base64_encode(plantelId);
    var datos = data;
    var loadingEfect = true;
    var showResult = false;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = function(resp, resp2, resp3) {
            try {
                var json = jQuery.parseJSON(resp3.responseText);
                $("#dialog_cargo").dialog("close");
                dialogo_error(json.mensaje);
            } catch (e) {
                $("#_formAutoridades").html(resp);
                $("#guardoAutoridades").show();
            }
        };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);

}

function mostrarDialog(nombre, apellido, usuario) {
    var cedula = $("#cedula").val();
    var plantel_id = $("#plantel_id").val();
    $("#UserGroupsUser_nombre").val(nombre);
    $("#UserGroupsUser_apellido").val(apellido);
    $("#UserGroupsUser_cedula").val(cedula);
    $("#UserGroupsUser_username").val(usuario);
    $("#UserGroupsUser_cedula").attr('readOnly', true);
    $("#UserGroupsUser_username").attr('readOnly', true);
    var dialogAutoridad = $("#agregarAutoridad").removeClass('hide').dialog({
        modal: true,
        width: '950px',
        draggable: false,
        resizable: true,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Agregar Usuario</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-xs",
                "id": "btnCancelarAgregarNuevaAutoridad",
                click: function() {
                    $("#cargo_id").val('');
                    $("#UserGroupsUser_cedula").val('');
                    $("#UserGroupsUser_username").val('');
                    $("#UserGroupsUser_nombre").val('');
                    $("#UserGroupsUser_apellido").val('');
                    $("#UserGroupsUser_email").val('');
                    $('#UserGroupsUser_telefono').val('');
                    $("#UserGroupsUser_telefono_celular").val('');
                    $('#UserGroupsUser_presento_documento_identidad').val('');
                    $("#errorSummaryA p").html('');
                    $("#errorSummaryA").hide();
                    dialogAutoridad.dialog("close");
                }
            },
            {
                html: "Guardar &nbsp; <i class='icon-save icon-on-right bigger-110'></i>",
                "class": "btn btn-primary btn-xs",
                click: function() {
                    
                    var poseeDocIdentidad = $('#UserGroupsUser_presento_documento_identidad').val();
                    
                    if(poseeDocIdentidad=='SI'){
                        
                        var plantelId = $("#PlantelPae_plantel_id").val();
                        var divResult = "";
                        var urlDir = "/registroUnico/plantelesPae/guardarNuevaAutoridad/id/"+base64_encode(plantelId);
                        var datos = $("#plantelAgregarAutoridad-form").serialize();
                        var loadingEfect = true;
                        var showResult = false;
                        var method = "POST";
                        var responseFormat = "html";

                        var successCallback = function(resp, resp1, resp3) {
                            
                            //console.log(resp);
                            
                            try {
                                var json = jQuery.parseJSON(resp3.responseText);
                                if (json.statusCode === "mensajeError") {
                                    $("#errorSummaryA p").html(json.mensaje);
                                    $("#errorSummaryA").show();
                                }
                            } catch (e) {
                                $("#errorSummaryA p").html('');
                                $("#errorSummaryA").hide();
                                $("#cargo_id").val('');
                                $("#UserGroupsUser_cedula").val('');
                                $("#UserGroupsUser_username").val('');
                                $("#UserGroupsUser_nombre").val('');
                                $("#UserGroupsUser_apellido").val('');
                                $("#UserGroupsUser_email").val('');
                                $('#UserGroupsUser_telefono').val('');
                                $('#UserGroupsUser_telefono_celular').val();
                                
                                $("#btnCancelarAgregarNuevaAutoridad").click();
                                
                                dialogAutoridad.dialog("close");

                                /* Nuevo Dialogo Confirmar Registro NUEVO */
                                $("#dialog_success p").html("Usuario Registrado Exitosamente, el usuario debe esperar su verificaci&oacute;n para la activaci&oacute;n en el sistema.");
                                var dialog_success = $("#dialog_success").removeClass('hide').dialog({
                                    modal: true,
                                    width: '450px',
                                    draggable: false,
                                    resizable: false,
                                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Registro Exitoso</h4></div>",
                                    title_html: true,
                                    buttons: [
                                        {
                                            html: "<i class='icon-remove bigger-110'></i>&nbsp; Cerrar",
                                            "class": "btn btn-xs",
                                            click: function() {
                                                $("#dialog_success p").html('');
                                                dialog_success.dialog("close");
                                            }
                                        }
                                    ]
                                });

                                // renderizar cambios
                                $("#_formAutoridades").html(resp);

                            }

                        };
                        
                        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
                        
                    }
                    else{
                        $.gritter.add({
                                title: 'No se ha presentado el Documento de Identidad',
                                text: 'Para poder registrar la autoridad la misma debe presentar su documento de identidad.',
                                class_name: 'gritter-error'
                        });
                    }

                }
            }
        ]
    });
}
//$("#dialog_agregarAutoridad").show();

function dialogo_error(mensaje) {
    $("#dialog_error p").html(mensaje);
    var dialog = $("#dialog_error").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Mensaje de Error</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cerrar",
                "class": "btn btn-xs",
                click: function() {
                    $(this).dialog("close");
                }
            }
        ]
    });
}

function dialogSolicitudComprobante(){
    
    var mensaje = '<div class="infoDialogBox">\
            <p>\
                Se está efectuando la generación del comprobante. En pocos segundos se podrá visualizar un link de descarga del mismo.\
            </p>\
        </div>\
        <div align="center">\
            <img src="/public/images/ajax-loader-red.gif" />\
        </div>';
    
    $("#divResultDescargaComprobante").html(mensaje);
    
    $("#linkDescargaComprobanteCnae").attr("href", "#").addClass("hide");
    
    var dialog = $("#dialogDescargaComprobanteCnae").removeClass('hide').dialog({
        modal: true,
        width: '680px',
        draggable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-file-pdf-o'></i>&nbsp; Solicitud de Comprobante CNAE</h4></div>",
        title_html: true,
        buttons: [
            {
                "html":  "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                "class": "btn btn-xs btn-danger",
                "id":    "btnCancelarDialogSolicitudComprobante",
                "click": function() {
                    $(this).dialog("close");
                }
            }
        ]
    });
}
