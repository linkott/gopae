/**
 * Created by gabriel on 07/11/14.
 */

var datosPae = "";

$(document).ready(function() {
    $('#razonAccion').bind('keyup blur', function() {
        makeUpper(this);
    });

    $("#PlantelPae_matricula_maternal").numeric({decimal: false, negative: false});
    $("#PlantelPae_matricula_preescolar").numeric({decimal: false, negative: false});
    $("#PlantelPae_matricula_educacion_primaria").numeric({decimal: false, negative: false});
    $("#PlantelPae_matricula_educacion_media_general").numeric({decimal: false, negative: false});
    $("#PlantelPae_matricula_educacion_especial").numeric({decimal: false, negative: false});
    $("#PlantelPae_cantidad_madres_procesadoras").numeric({decimal: false, negative: false});

    $("#PlantelPae_hectareas_produccion").numeric({negative: false});
    $("#PlantelPae_matricula_maternal, #PlantelPae_matricula_preescolar, #PlantelPae_matricula_educacion_primaria, #PlantelPae_matricula_educacion_media_general, #PlantelPae_matricula_educacion_tecnica, #PlantelPae_matricula_educacion_especial, #PlantelPae_matricula_docente_obrero").on("blur", function(){
        var matricula = $(this).val();
        if(matricula.length==0 || isNaN(matricula)){
            $(this).val("0");
        }
        else if(matricula>4000){
            $(this).val("4000");
        }
        settingTotalMatricula();
    });
    $("#PlantelPae_matricula_maternal, #PlantelPae_matricula_preescolar, #PlantelPae_matricula_educacion_primaria, #PlantelPae_matricula_educacion_media_general, #PlantelPae_matricula_educacion_tecnica, #PlantelPae_matricula_educacion_especial").on("keyup", function(){
        settingTotalMatricula();
    });

    $("#PlantelPae_tipo_servicio_pae_id").on('change', function(){
        if($(this).val()=='1'){ // 1 = Insumo
            $("#PlantelPae_proveedor_actual_id").attr('required', true);
        }
        else{
            $("#PlantelPae_proveedor_actual_id").removeAttr('required');
        }
    });

    $("#PlantelPae_posee_area_produccion_agricola").bind('change', function() {
        var area_producion = $("#PlantelPae_posee_area_produccion_agricola").val();
        if (area_producion == 'SI') {
            $("#PlantelPae_hectareas_produccion").attr('readOnly', false);
            $("#PlantelPae_hectareas_produccion").val($("#hectareas_produccion_hidden").val());
            $("#PlantelPae_hectareas_produccion").focus();
        }
        else {
            $("#PlantelPae_hectareas_produccion").attr('readOnly', true);
            $("#PlantelPae_hectareas_produccion").val('0');
        }
    });

    toggleAffectedFields("#PlantelPae_posee_maternal");
    toggleAffectedFields("#PlantelPae_imparte_educacion_preescolar");
    toggleAffectedFields("#PlantelPae_imparte_educacion_primaria");
    toggleAffectedFields("#PlantelPae_imparte_educacion_media_general");
    toggleAffectedFields("#PlantelPae_imparte_educacion_tecnica");
    toggleAffectedFields("#PlantelPae_imparte_educacion_especial");
    toggleAffectedFields("#PlantelPae_posee_area_produccion_agricola");
    if($("#PlantelPae_matricula_docente_obrero").val()==''){
        $("#PlantelPae_matricula_docente_obrero").val('0');
    }
    settingTotalMatricula();

    $("#PlantelPae_posee_maternal, #PlantelPae_imparte_educacion_preescolar, #PlantelPae_imparte_educacion_primaria, #PlantelPae_imparte_educacion_media_general, #PlantelPae_imparte_educacion_tecnica, #PlantelPae_imparte_educacion_especial, #PlantelPae_posee_area_produccion_agricola").on('change', function(){
        toggleAffectedFields(this);
        settingTotalMatricula();
    });

    $("#datos-plantel-pae-form").on('submit', function(evt){
        // console.log($("#plantel-pae-form"));
        // console.log(evt);
        evt.preventDefault();
        activarServicio($("PlantelPae_plantel_id").val());
    });

    datosPae = $("#datos-plantel-pae-form").serialize();

});


function toggleAffectedFields(element){
    var affectedFieldId = $(element).attr('data-affectedField');
    var isAfirmative = $(element).val()=='SI';
    var actualValue = $("#"+affectedFieldId).val();

    /**
     *
     * console.log({
     *   "isAfirmative" : isAfirmative,
     *   "campo" : affectedFieldId,
     *   "valor": $("#"+affectedFieldId).val()
     * })
     *
     */

    if(isAfirmative){
        $("#"+affectedFieldId).removeAttr('readOnly');

        if($("#"+affectedFieldId).val()==''){
            $("#"+affectedFieldId).val('0');
        }
        else{
            $("#"+affectedFieldId).val($("#"+affectedFieldId).val());
        }
        $("#"+affectedFieldId).focus();
        
        //$("#"+affectedFieldId).val("");
        $("#"+affectedFieldId).attr('min','1');
    }else{
        $("#"+affectedFieldId).attr('data-pastValue', actualValue);
        $("#"+affectedFieldId).val('0');
        $("#"+affectedFieldId).attr('readOnly', true);
        $("#"+affectedFieldId).attr('min','0');
    }
}

function settingTotalMatricula() {
    var maternal = $("#PlantelPae_matricula_maternal").val()*1;
    var preescolar = $("#PlantelPae_matricula_preescolar").val()*1;
    var educacion_primaria = $("#PlantelPae_matricula_educacion_primaria").val()*1;
    var educacion_media_general = $("#PlantelPae_matricula_educacion_media_general").val()*1;
    var educacion_tecnica = $("#PlantelPae_matricula_educacion_tecnica").val()*1;
    var educacion_especial = $("#PlantelPae_matricula_educacion_especial").val()*1;
    var docente_obrero = $("#PlantelPae_matricula_docente_obrero").val()*1;
    var suma = (maternal+preescolar+educacion_primaria+educacion_media_general+educacion_tecnica+educacion_especial+docente_obrero);
    $("#matriculaTotal").val(suma);
}

function activarServicio(plantel_id) {

    $("#mensajeAlertaExito").addClass('hide');
    $("#mensajeAlertaError").addClass('hide');

    var tipo_servicio_pae_id = $("#PlantelPae_tipo_servicio_pae_id").val();
    var posee_simoncito = $("#PlantelPae_posee_simoncito").val();
    var posee_maternal = $("#PlantelPae_posee_maternal").val();
    var imparte_educacion_preescolar = $("#PlantelPae_imparte_educacion_preescolar").val();
    var posee_area_cocina = $("#PlantelPae_posee_area_cocina").val();
    var condicion_servicio_id = $("#PlantelPae_condicion_servicio_id").val();
    var posee_area_produccion_agricola = $("#PlantelPae_posee_area_produccion_agricola").val();
    var hectareas_produccion = $("#PlantelPae_hectareas_produccion").val();
    var matricula_maternal = $("#PlantelPae_matricula_maternal").val()*1;
    var matricula_preescolar = $("#PlantelPae_matricula_preescolar").val()*1;
    var matricula_simoncito = matricula_maternal+matricula_preescolar;
    var docente_obrero = $("#PlantelPae_matricula_docente_obrero").val()*1;
    var proveedor_id = $("#PlantelPae_proveedor_actual_id").val();
    var mensaje = '';
    if (tipo_servicio_pae_id == '' || isNaN(tipo_servicio_pae_id)) {
        mensaje = mensaje + ' - Debe indicar el tipo de servicio por el que es beneficiada la Institución Educativa.<br/>';
    }
    if (posee_simoncito == '') {
        mensaje = mensaje + ' - Debe indicar si posee el Programa Simoncito.<br/>';
    }
    if (posee_area_cocina == '') {
        mensaje = mensaje + ' - Debe indicar si posee o no área para el servicio de alimentación.<br/>';
    }
    if (condicion_servicio_id == '') {
        mensaje = mensaje + ' - Debe seleccionar una Condicion Actual del Servicio.<br/>';
    }
    if (posee_simoncito == 'SI' && posee_maternal != 'SI' && imparte_educacion_preescolar != 'SI') {
        mensaje = mensaje + ' - Si la institucion posee el Programa Simoncito, debe indicar si posee Maternal o Imparte Educacion Preescolar.<br/>';
    }
    if (posee_simoncito == 'SI' && matricula_simoncito <= 0) {
        mensaje = mensaje + ' - Si la institucion posee el Programa Simoncito, en la Matricula de Simoncitos debe indicar si existen 1 o más beneficiados del Programa.<br/>';
    }
    if (posee_area_produccion_agricola == '') {
        mensaje = mensaje + ' - El campo posee área de producción agricola no puede estar vacio.<br/>';
    }
    else {
        // console.log(posee_area_produccion_agricola);
        if (posee_area_produccion_agricola == 'SI' && hectareas_produccion == '') {
            mensaje = mensaje + ' - Hectareas de producción agricola no puede estar vacio.<br/>';
        }
        else if (posee_area_produccion_agricola == 'SI' && hectareas_produccion <= 0) {
            mensaje = mensaje + ' - Hectareas de producción agricola tiene que contener 1 o mas.<br/>';
        }
    }
    if(tipo_servicio_pae_id=='1' && proveedor_id!='5' && proveedor_id!='6'){
        mensaje = mensaje + ' - El tipo de servicio por "Insumos" es solo atendido por los proveedores MERCAL o PDVAL, si tiene este tipo de servicio seleccione uno de los Proveedores antes mencionados.<br/>';
    }

    if(mensaje.length>0){
        mensaje = '<p><b>Estimado usuario, por favor corrija los siguientes errores:</b><br/><br/>'+mensaje+'</p>';
        $("html, body").animate({scrollTop: 0}, "fast");
        $("#mensajeAlertaError").removeClass('hide');
        $("#mensajeAlertaError").html(mensaje);
    }
    else {

        var dialog = $("#confirmacion").removeClass('hide').dialog({
            modal: true,
            width: '680px',
            draggale: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Registro de Datos y Activación de Servicios del PAE </h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                    "class": "btn btn-xs btn-danger",
                    "id":"botonAccionCancelar",
                    "click": function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "Guardar Datos / Activar Servicio &nbsp;<i class='fa fa-check bigger-110'></i>",
                    "class": "btn btn-success btn-xs",
                    "id": "botonAccionActivar",
                    "click": function() {
                        guardarDatosPae();
                    }
                }
            ]
        });
    }

    $("#PlantelPae_matricula_educacion_tecnica").numeric({decimal: false, negative: false});

}

function guardarDatosPae(){

    var plantelId = $("#PlantelPae_plantel_id").val();
    var divResult = "";
    var urlDir = "/registroUnico/PlantelesPae/activarPae/id/"+base64_encode(plantelId);
    var datos = $("#datos-plantel-pae-form").serialize();
    var loadingEfect = false;
    var showResult = false;
    var method = "POST";
    var responseFormat = "json";

    var successCallback = function(response, estatusCode, dom){

        var mensaje = 'El servidor no ha proporcionado una respuesta con respecto a la operación';
        var status = 400;
        var boxStyle = 'error';

        datosPae = datos;

        if(undefined !== response.mensaje){mensaje = response.mensaje;}

        if(undefined !== response.status){status = response.status;}

        if(status==200){
            $boxStyle = 'success';
            $("#mensajeAlertaExito").removeClass('hide');
            //$("#resultado-plantel-pae").html(response.mensaje);
            if(undefined !== response.data && undefined !== response.data.plantel_id){
                var plantel = response.data;
                $("#PlantelPae_pae_activo").val(plantel.pae_activo);
                $("#fecha_inicio").val(plantel.fecha_inicio);
                $("#PlantelPae_fecha_ultima_actualizacion").val(plantel.fecha_ultima_actualizacion);
                $("#PlantelPae_id").val(plantel.id);
            }
        }
        else{
            $("#mensajeAlertaError").html(mensaje).removeClass('hide');
        }

        $("#botonAccionCancelar").click();

        $("html, body").animate({scrollTop: 0}, "fast");

    };

    if(datos!=datosPae){
        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    }
    else{
        console.log(divResult);
        $("#botonAccionCancelar").click();
        $.gritter.add({
            title: 'No hay cambios detectados',
            text: 'No existen cambios detectados en los datos del PAE de esta institución.',
            class_name: 'gritter-warning'
        });
        displayDialogBox('mensajeAlertaWarning', 'alert', "No existen cambios que guardar.");
        $("html, body").animate({scrollTop: 0}, "fast");
    }

}

