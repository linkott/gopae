$(document).ready(function() {
    
    $("#btn-refresh-cocineras-plantel").on('click', function(){
        listarMadresCocineras($("#plantel_id").val());
    });
    
    listarMadresCocineras($("#plantel_id").val());
    filtersKey();
    $("#form-asignacion-cocinera-plantel").submit(function(evt) {
        evt.preventDefault();
        validarAsignacion();
    });
});

function filtersKey() {
    $("#cedula").numeric(null);
    $("#cedula").on('keyup blur', function() {
        keyNum(this, false, false);
    });
}

function validarAsignacion() {
    
    $("#resultado-asignacion-cocinera").html('');
    $("#resultadoDialogoAsignacionCocinera").html('');

    var origen = $("#origen").val();
    var cedula = $("#cedula").val();

    if (origen.length > 0 && cedula.length > 0 && !isNaN(cedula)) {

        if (isValidOrigen(origen)) {
            
            var divResult = "";
            var urlDir = $("#form-asignacion-cocinera-plantel").attr('action');
            var datos = {origen: origen, cedula: cedula};
            var loadingEfect = true;
            var showResult = false;
            var method = "POST";
            var responseFormat = "html";
            var beforeSendCallback = null;
            var successCallback = function(response, estatusCode, dom) {

                $('#resultadoDialogoAsignacionCocinera').html(response).ready(function(){
                    
                    var dialog = $("#resultadoDialogoAsignacionCocinera").removeClass('hide').dialog({
                        modal: true,
                        width: '1000px',
                        dragable: false,
                        resizable: false,
                        //position: 'top',
                        title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Asignación de Madre Cocinera</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                                "class": "btn btn-danger btn-xs",
                                "id": "btn-volver-asignacion-cocinera",
                                click: function() {
                                    $("#cedula").val("");
                                    $("#resultadoDialogoAsignacionCocinera").html('<center><img src="/public/images/ajax-loader-red.gif"></center>');
                                    $(this).dialog("close");
                                }
                            },
                            {
                                html: "<i class='icon-save info bigger-110'></i>&nbsp; Asignar",
                                "class": "btn btn-primary btn-xs hide",
                                "id": "btn-guardar-asignacion-cocinera",
                                click: function() {
                                    $("#btn-submit-register-cocinera-form").click();
                                }
                            }

                        ]
                    });
                    
                    $("#btn-guardar-asignacion-cocinera").removeClass('hide');
                    settingFormCocinera();
                    $.mask.definitions['L'] = '[1-2]';
                    $.mask.definitions['X'] = '[2|4|6]';
                    $('#TalentoHumano_telefono_fijo').mask('(0299)999-9999');
                    $('#TalentoHumano_telefono_celular').mask('(04LX)999-9999');
                    $("#TalentoHumano_email_personal").on('keyup blur', function(){
                        keyEmail(this, false);
                    });
                    $("#TalentoHumano_email_personal").on('blur', function(){
                        clearField(this);
                    });
                    var foto = new String($("#TalentoHumano_foto").val());
                    if(foto.length==0){
                        configCamera(true, true);
                    }else{
                        configCamera(false, true);
                        $("#fotoImgBase64").val("data:image/png;base64");
                    }
                });

            };

            executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);

        }
        else {
            simpleDialogPopUp('#resultadoDialogo', 'error', 'El valor del Origen no es válido. Le recomendamos recargar la página e intentarlo de nuevo.');
        }

    }
    else{
        simpleDialogPopUp('#resultadoDialogo', 'error', 'El valor de la Cédula no es válido, debe contener solo caracteres numéricos. Le recomendamos recargar la página e intentarlo de nuevo.');
    }

}

function executeAsignacion(){
    var formValid = validateForm();
    
    var formType = $("#cocinera-form").attr('data-form-type');
    
    //console.log(formType);
    if(formType=='create'){
        $("#Cocinera_cedula").removeAttr('disabled').attr("readOnly","readOnly");
        $("#Cocinera_sexo").removeAttr('disabled');
        $("#Cocinera_fecha_nacimiento").removeAttr('disabled');
    }
    
    if(formValid){
        var divResult = "#resultado";
        var urlDir = $("#cocinera-form").attr('action');
        var datos = $("#cocinera-form").serialize();
        var loadingEfect = true;
        var showResult = true;
        var method = $("#cocinera-form").attr('method');
        var responseFormat = "html";
        var successCallback = function(response) {
            if(response.indexOf("errorDialogBox")==-1){
                $("#cedula").val("");
                listarMadresCocineras($("#plantel_id").val());
                $("#resultado-asignacion-cocinera").html(response);
                $("#btn-volver-asignacion-cocinera").click();
            }
        };
        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    }
}

function listarMadresCocineras(plantelId){
    
    var divResult = "#div-lista-cocineras-asignadas";
    var urlDir = '/registroUnico/madresCocineras/lista/id/'+plantelId;
    var datos = $("#cocinera-form").serialize();
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = null;

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    
}

function desvincularMadreCocinera(idCocineraPlantel){
    
    var plantelId = $("#plantel_id").val();
    var divResult = "#resultado-asignacion-cocinera";
    var urlDir = '/registroUnico/madresCocineras/desvincularMadreCocinera';
    var datos = {
        pid : plantelId,
        id : idCocineraPlantel
    };
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = function(){
        listarMadresCocineras($("#plantel_id").val());
    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    
}

function selectMunicipios(){
    
    var divResult = "#Cocinera_municipio_id";
    var urlDir = '/servicio/cocineras/municipiosStandalone';
    var datos = $("#cocinera-form").serialize();
    var loadingEfect = false;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = null;
    
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);

}

function selectParroquias(){
    
    var divResult = "#Cocinera_parroquia_id";
    var urlDir = '/servicio/cocineras/parroquiasStandalone';
    var datos = $("#cocinera-form").serialize();
    var loadingEfect = false;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = null;
    
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);

}

function settingFormCocinera(){
    
    var idCocinera = $("#cocinera-form").attr('data-id-model');
    var action = $("#cocinera-form").attr('action')+"";
    action = action.replace('validarAsignacion', 'registroAsignacion')+"/idCocin/"+idCocinera;
    
    $("#cocinera-form").attr('action', action);
    
    formInputFilters();
    
    $("#Cocinera_estado_id").unbind('change');
    $("#Cocinera_estado_id").on('change', function(){
        selectMunicipios();
    });

    $("#Cocinera_municipio_id").unbind('change');
    $("#Cocinera_municipio_id").on('change', function(){
        selectParroquias();
    });

    $("#cocinera-form").unbind('submit');
    $("#cocinera-form").on('submit', function(evt){
        evt.preventDefault();
        executeAsignacion();
    });
        
    var formType = $("#cocinera-form").attr('data-form-type');
    
    //console.log(formType);
    if(formType=='create'){
        // Dejo que puedan editar o corregir los nombres y apellidos
        $("#Cocinera_nombre").removeAttr('disabled');
        $("#Cocinera_apellido").removeAttr('disabled');
        // No puede ser modificada la información proveniente del SAIME
        $("#Cocinera_origen").attr('disabled', 'disabled');
        $("#Cocinera_sexo").attr('disabled', 'disabled');
        $("#Cocinera_cedula").attr('disabled','disabled');
        $("#Cocinera_fecha_nacimiento").attr('disabled','disabled');
    }
    else{
        $("#Cocinera_origen").attr('disabled', 'disabled');
        $("#Cocinera_cedula").attr('disabled','disabled');
        $("#Cocinera_nombre").attr('disabled','disabled');
        $("#Cocinera_apellido").attr('disabled','disabled');
        $("#Cocinera_fecha_nacimiento").attr('disabled','disabled');
        $("#Cocinera_sexo").attr('disabled', 'disabled');
    }



}

function formInputFilters(){
    
    // Filters

    $("#Cocinera_cedula").on('keyup blur', function(){
        keyNum(this, false, false);
    });
    
    $("#Cocinera_nombre").on('keyup blur', function(){
        keyText(this, true);
    });
    
    $("#Cocinera_apellido").on('keyup blur', function(){
        keyText(this, true);
    });
    
    $("#Cocinera_fecha_nacimiento").on('keyup blur', function(){
        keyNum(this, false, true);
    });
    
    $("#Cocinera_enfermedades").on('keyup blur', function(){
        keyText(this, true);
    });
    
    $("#Cocinera_observacion").on('keyup blur', function(){
        keyText(this, true);
    });
    
    $("#Cocinera_email").on('keyup blur', function(){
        keyEmail(this, false);
    });
    
    $("Cocinera_direccion").on('blur', function(){
        clearField(this);
    });
    
    $("#Cocinera_cedula_titular").on('keyup blur', function(){
        keyNum(this, false, false);
    });
    
    $("#Cocinera_nombre_titular").on('keyup blur', function(){
        keyText(this, true);
    });
    
    // Clear Fields
    
    $("#Cocinera_cedula").on('blur', function(){
        clearField(this);
    });
    
    $("#Cocinera_nombre").on('blur', function(){
        clearField(this);
    });
    
    $("#Cocinera_apellido").on('blur', function(){
        clearField(this);
    });
    
    $("#Cocinera_enfermedades").on('blur', function(){
        clearField(this);
    });
    
    $("#Cocinera_observacion").on('blur', function(){
        clearField(this);
    });
    
    $("#Cocinera_email").on('blur', function(){
        clearField(this);
    });
    
    $("Cocinera_direccion").on('blur', function(){
        clearField(this);
    });
    
    $("#Cocinera_cedula_titular").on('blur', function(){
        clearField(this);
    });
    
    $("#Cocinera_nombre_titular").on('blur', function(){
        clearField(this);
    });
    
    // Masks

    $.mask.definitions['L'] = '[1-2]';
    $.mask.definitions['X'] = '[2|4|6]';
    
    $('#Cocinera_telefono').mask('(0299)999-9999');
    $('#Cocinera_telefono_celular').mask('(04LX)999-9999');
    $('#Cocinera_numero_cuenta').mask('99999999999999999999');
    
}

function validateForm(){

    if(!isValidNombre()){
        $("#Cocinera_nombre").addClass('error');
        displayDialogBox('resultado', 'error', 'Solo debe hacer correcciones del nombre, no modificarlo por completo.');
        $("html, body").animate({ scrollTop: 0 }, "fast");
        return false;
    }
    if(!isValidApellido()){
        $("#Cocinera_apellido").addClass('error');
        displayDialogBox('resultado', 'error', 'Solo debe hacer correcciones del apellido, no modificarlo por completo.');
        $("html, body").animate({ scrollTop: 0 }, "fast");
        return false;
    }
    if(!isValidFoto()){
        showNotify("Datos Faltantes", "Debe tomar la foto del Talento Humano que desée registrar o asignar en el sistema.");
        displayDialogBox("resultado", "error", "Debe tomar la foto del Talento Humano que desée registrar o asignar en el sistema.");
        return false;
    }
    if(!isValidDatosContacto()){
        showNotify("Datos Faltantes", "Debe ingresar un correo electrónico y al menos uno de los dos números telefónicos (Fijo o Celular).");
        displayDialogBox("resultado", "error", "Debe ingresar un correo electrónico y al menos uno de los dos números telefónicos (Fijo o Celular)");
        return false;
    }

    return true;
}

function isValidOrigen(origen){
    var origenes = ['V', 'E', 'P'];
    if($.inArray(origen, origenes)>=0){ // La función inArray de jQuery te devuelve el índice del array en donde se encuentra el valor buscado
        return true;
    }
    return false;
}

function isValidBooleanEs(input){
    var booleans = ['Si', 'No'];
    if($.inArray(input, booleans)>=0){
        return true;
    }
    return false;
}

function isValidNombre(){
    $nombreInicial = $("#Cocinera_nombre").attr('data-inicial');
    $nombre = $("#Cocinera_nombre").val();
    $indiceNombre = levenshtein($nombreInicial, $nombre);
    //console.log($indiceNombre);
    return ($indiceNombre<=3);
}

function isValidApellido(){
    $apellidoInicial = $("#Cocinera_apellido").attr('data-inicial');
    $apellido = $("#Cocinera_apellido").val();
    $indiceApellido = levenshtein($apellidoInicial, $apellido);
    //console.log($indiceApellido);
    return ($indiceApellido<=3);
}

function isValidFoto(){
    var fotoImgBase64 = $("#fotoImgBase64").val();
    return (fotoImgBase64.length>0 && fotoImgBase64.indexOf("data:image/png;base64")!=-1);
}

function isValidDatosContacto(){
    var emailPersonla = $("#TalentoHumano_email_personal").val();
    var telefonoFijo = $("#TalentoHumano_telefono_fijo").val();
    var telefonoCelular = $("#TalentoHumano_telefono_celular").val();
    
    return (emailPersonla.length>0 && (telefonoCelular.length>0 || telefonoFijo.length>0));
}
