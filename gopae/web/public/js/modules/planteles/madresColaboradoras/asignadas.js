$(document).ready(function() {
    
    $("#btn-refresh-colaboradoras-plantel").on('click', function(){
        listarMadresColaboradoras($("#plantel_id").val());
    });
    
    listarMadresColaboradoras($("#plantel_id").val());
    filtersKey();
    $("#form-asignacion-colaborador-plantel").submit(function(evt) {
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
    
    $("#resultado-asignacion-colaboradora").html('');
    
    var origen = $("#origen").val();
    var cedula = $("#cedula").val();

    if (origen.length > 0 && cedula.length > 0 && !isNaN(cedula)) {

        if (isValidOrigen(origen)) {
            
            var dialog = $("#resultadoDialogoAsignacionColaboradora").removeClass('hide').dialog({
                modal: true,
                width: '1000px',
                dragable: false,
                resizable: false,
                //position: 'top',
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Asignación de Madre Colaboradora</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs",
                        "id": "btn-volver-asignacion-colaboradora",
                        click: function() {
                            $("#resultadoDialogoAsignacionColaboradora").html('<center><img src="/public/images/ajax-loader-red.gif"></center>');
                            $(this).dialog("close");
                        }
                    },
                    {
                        html: "<i class='icon-save info bigger-110'></i>&nbsp; Guardar / Asignar",
                        "class": "btn btn-primary btn-xs hide",
                        "id": "btn-guardar-asignacion-colaboradora",
                        click: function() {
                            $("#btn-submit-register-colaborador-form").click();
                        }
                    }

                ]
            });
            
            var divResult = "";
            var urlDir = $("#form-asignacion-colaborador-plantel").attr('action');
            var datos = {origen: origen, cedula: cedula};
            var loadingEfect = false;
            var showResult = false;
            var method = "POST";
            var responseFormat = "html";
            var beforeSendCallback = null;
            var successCallback = function(response, estatusCode, dom) {

                $('#resultadoDialogoAsignacionColaboradora').html(response).ready(function(){

                    $("#btn-guardar-asignacion-colaboradora").removeClass('hide');
                    
                    settingFormColaborador();

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
    
    var formType = $("#colaborador-form").attr('data-form-type');
    
    //console.log(formType);
    if(formType=='create'){
        $("#Colaborador_cedula").removeAttr('disabled').attr("readOnly","readOnly");
        $("#Colaborador_sexo").removeAttr('disabled');
        $("#Colaborador_fecha_nacimiento").removeAttr('disabled');
    }
    
    if(formValid){
        var divResult = "#resultado";
        var urlDir = $("#colaborador-form").attr('action');
        var datos = $("#colaborador-form").serialize();
        var loadingEfect = false;
        var showResult = true;
        var method = $("#colaborador-form").attr('method');
        var responseFormat = "html";
        var successCallback = function(response) {
            if(response.indexOf("errorDialogBox")==-1){
                $("#cedula").val("");
                listarMadresColaboradoras($("#plantel_id").val());
                $("#resultado-asignacion-colaboradora").html(response);
                $("#btn-volver-asignacion-colaboradora").click();
            }
        };
        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    }
}

function listarMadresColaboradoras(plantelId){
    
    var divResult = "#div-lista-colaboradoras-asignadas";
    var urlDir = '/planteles/madresColaboradoras/lista/id/'+plantelId;
    var datos = $("#colaborador-form").serialize();
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = null;

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    
}

function desvincularMadreColaboradora(idColaboradorPlantel){
    
    var plantelId = $("#plantel_id").val();
    var divResult = "#resultado-asignacion-colaboradora";
    var urlDir = '/planteles/madresColaboradoras/desvincularMadreColaboradora';
    var datos = {
        pid : plantelId,
        id : idColaboradorPlantel
    };
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = function(){
        listarMadresColaboradoras($("#plantel_id").val());
    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    
}

function selectMunicipios(){
    
    var divResult = "#Colaborador_municipio_id";
    var urlDir = '/servicio/colaboradoras/municipiosStandalone';
    var datos = $("#colaborador-form").serialize();
    var loadingEfect = false;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = null;
    
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);

}

function selectParroquias(){
    
    var divResult = "#Colaborador_parroquia_id";
    var urlDir = '/servicio/colaboradoras/parroquiasStandalone';
    var datos = $("#colaborador-form").serialize();
    var loadingEfect = false;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = null;
    
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);

}

function settingFormColaborador(){
    
    var idColaboradora = $("#colaborador-form").attr('data-id-model');
    var action = $("#colaborador-form").attr('action')+"";
    action = action.replace('validarAsignacion', 'registroAsignacion')+"/idColab/"+idColaboradora;
    
    $("#colaborador-form").attr('action', action);
    
    formInputFilters();
    
    $("#Colaborador_estado_id").unbind('change');
    $("#Colaborador_estado_id").on('change', function(){
        selectMunicipios();
    });

    $("#Colaborador_municipio_id").unbind('change');
    $("#Colaborador_municipio_id").on('change', function(){
        selectParroquias();
    });

    $("#colaborador-form").unbind('submit');
    $("#colaborador-form").on('submit', function(evt){
        evt.preventDefault();
        executeAsignacion();
    });
        
    var formType = $("#colaborador-form").attr('data-form-type');
    
    //console.log(formType);
    if(formType=='create'){
        // Dejo que puedan editar o corregir los nombres y apellidos
        $("#Colaborador_nombre").removeAttr('disabled');
        $("#Colaborador_apellido").removeAttr('disabled');
        // No puede ser modificada la información proveniente del SAIME
        $("#Colaborador_origen").attr('disabled', 'disabled');
        $("#Colaborador_sexo").attr('disabled', 'disabled');
        $("#Colaborador_cedula").attr('disabled','disabled');
        $("#Colaborador_fecha_nacimiento").attr('disabled','disabled');
    }
    else{
        $("#Colaborador_origen").attr('disabled', 'disabled');
        $("#Colaborador_cedula").attr('disabled','disabled');
        $("#Colaborador_nombre").attr('disabled','disabled');
        $("#Colaborador_apellido").attr('disabled','disabled');
        $("#Colaborador_fecha_nacimiento").attr('disabled','disabled');
        $("#Colaborador_sexo").attr('disabled', 'disabled');
    }
        
}

function formInputFilters(){
    
    // Filters
    
    $("#Colaborador_cedula").on('keyup blur', function(){
        keyNum(this, false, false);
    });
    
    $("#Colaborador_nombre").on('keyup blur', function(){
        keyText(this, true);
    });
    
    $("#Colaborador_apellido").on('keyup blur', function(){
        keyText(this, true);
    });
    
    $("#Colaborador_fecha_nacimiento").on('keyup blur', function(){
        keyNum(this, false, true);
    });
    
    $("#Colaborador_enfermedades").on('keyup blur', function(){
        keyText(this, true);
    });
    
    $("#Colaborador_observacion").on('keyup blur', function(){
        keyText(this, true);
    });
    
    $("#Colaborador_email").on('keyup blur', function(){
        keyEmail(this, false);
    });
    
    $("Colaborador_direccion").on('blur', function(){
        clearField(this);
    });
    
    $("#Colaborador_cedula_titular").on('keyup blur', function(){
        keyNum(this, false, false);
    });
    
    $("#Colaborador_nombre_titular").on('keyup blur', function(){
        keyText(this, true);
    });
    
    // Clear Fields
    
    $("#Colaborador_cedula").on('blur', function(){
        clearField(this);
    });
    
    $("#Colaborador_nombre").on('blur', function(){
        clearField(this);
    });
    
    $("#Colaborador_apellido").on('blur', function(){
        clearField(this);
    });
    
    $("#Colaborador_enfermedades").on('blur', function(){
        clearField(this);
    });
    
    $("#Colaborador_observacion").on('blur', function(){
        clearField(this);
    });
    
    $("#Colaborador_email").on('blur', function(){
        clearField(this);
    });
    
    $("Colaborador_direccion").on('blur', function(){
        clearField(this);
    });
    
    $("#Colaborador_cedula_titular").on('blur', function(){
        clearField(this);
    });
    
    $("#Colaborador_nombre_titular").on('blur', function(){
        clearField(this);
    });
    
    // Masks

    $.mask.definitions['L'] = '[1-2]';
    $.mask.definitions['X'] = '[2|4|6]';
    
    $('#Colaborador_telefono').mask('(0299)999-9999');
    $('#Colaborador_telefono_celular').mask('(04LX)999-9999');
    $('#Colaborador_numero_cuenta').mask('99999999999999999999');
    
}

function validateForm(){
    
    if(!isValidNombre()){
        $("#Colaborador_nombre").addClass('error');
        displayDialogBox('resultado', 'error', 'Solo debe hacer correcciones del nombre, no modificarlo por completo.');
        $("html, body").animate({ scrollTop: 0 }, "fast");
        return false;
    }
    if(!isValidApellido()){
        $("#Colaborador_apellido").addClass('error');
        displayDialogBox('resultado', 'error', 'Solo debe hacer correcciones del apellido, no modificarlo por completo.');
        $("html, body").animate({ scrollTop: 0 }, "fast");
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
    $nombreInicial = $("#Colaborador_nombre").attr('data-inicial');
    $nombre = $("#Colaborador_nombre").val();
    $indiceNombre = levenshtein($nombreInicial, $nombre);
    //console.log($indiceNombre);
    return ($indiceNombre<=3);
}

function isValidApellido(){
    $apellidoInicial = $("#Colaborador_apellido").attr('data-inicial');
    $apellido = $("#Colaborador_apellido").val();
    $indiceApellido = levenshtein($apellidoInicial, $apellido);
    //console.log($indiceApellido);
    return ($indiceApellido<=3);
}