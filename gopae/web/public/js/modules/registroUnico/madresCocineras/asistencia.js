$(document).ready(function() {
    
    $("#btn-refresh-asistencia-colaboradoras-plantel").on('click', function(){
        listarAsistenciaMadresColaboradoras($("#plantel_id").val());
    });
    
    $("#mes-escolar-pae-form").on('submit', function(evt) {
        evt.preventDefault();
        listarAsistenciaMadresColaboradoras();
    });
    
    $('#MesEscolarPae_id').bind('change', function() {
        listarAsistenciaMadresColaboradoras();
    });

});

function listarAsistenciaMadresColaboradoras(){
    
    var mesActual = 10;
    // var mesActual = $('#mesActual').val() * 1;
    var anioActual = $('#anioActual').val() * 1;

    var anioInicioPeriodo = $('#anio_inicio_periodo').val() * 1;
    var anioFinPeriodo = $('#inio_fin_periodo').val() * 1;

    var mesEscolarPae = $('#MesEscolarPae_id').val() * 1;
    var mesSeleccionado = '';
    var anio = '';
    var step = true;

    if (mesEscolarPae >= 09 && mesEscolarPae <= 12) {
        mesSeleccionado = mesEscolarPae + '-' + anioInicioPeriodo;
        $("#mesActualizado").val(mesEscolarPae);
        $("#anioActualizado").val(anioInicioPeriodo);
        anio = anioInicioPeriodo;
    }
    else if (mesEscolarPae >= 01 && mesEscolarPae <= 07) {
        mesSeleccionado = mesEscolarPae + '-' + anioFinPeriodo;
        $("#mesActualizado").val(mesEscolarPae);
        $("#anioActualizado").val(anioInicioPeriodo);
        anio = anioFinPeriodo;
    }

    if ((mesActual <= mesEscolarPae && anioActual == anio)) {
        $("#mensajeError").removeClass('hide');
        step = false;
    }
    else if ((mesActual > mesEscolarPae && anioActual != anio)) {
        $("#mensajeError").removeClass('hide');
        step = false;
    }

    if (step == true) {

        $("#madresColaboradorasPlantel").removeClass('hide');
        $("#btn-refresh-asistencia-colaboradoras-plantel").removeClass('hide');
        var mes = $("#mesActualizado").val();
        var anio = $("#anioActualizado").val();

        var divResult = "#divFormAsistenciaMadresColaboradorasPlantel";
        var urlDir = '/planteles/madresColaboradoras/asistencia/id/'+($("#plantel_id").val());
        var datos = {mes: mes, anio: anio};
        var loadingEfect = true;
        var showResult = false;
        var method = "POST";
        var responseFormat = "html";
        var successCallback = function(response, estatusCode, dom) {
            $("#divFormAsistenciaMadresColaboradorasPlantel").html(response).ready(function(){
                formAsistenciasColaboradorasPrepare();
            });
        };

        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
        
    }
    else{
        displayDialogBox('divFormAsistenciaMadresColaboradorasPlantel', 'error', 'No puedes generar la asistencia un día superior o igual al actual.');
    }

}

function formAsistenciasColaboradorasPrepare(){
    $("#asistencia-colaborador-plantel-form").on("submit", function(evt){
        evt.preventDefault();
        confirmRegistroAsistenciaColaboradoras();
    });
    $(".cantAsistenciaColaboradoras").val(0);
    $(".cantAsistenciaColaboradoras").numeric({ negative : false, decimal : false });
    $(".cantAsistenciaColaboradoras").on('keyup', function(){
        var diasPlanificados = $("#diasPlanificados").val()*1;
        var asistencia = $(this).val();
        if(asistencia.length>0){
            if(asistencia>diasPlanificados){
                $(this).val(diasPlanificados);
            }
        }
    });
    $(".cantAsistenciaColaboradoras").on('blur', function(){
        var asistencia = $(this).val();
        if(asistencia.length===0){
            $(this).val(0);
        }
    });

    $(".cantAsistenciaColaboradoras").on('focus', function(){
        var asistencia = $(this).val();
        if(asistencia=='0'){
            $(this).val("");
        }
    });

    $("#sectionBtnConfirmarAsistenciaColaboradoras").fadeIn('slow');
    
    if(typeof ($(".cantAsistenciaColaboradoras")[0])!="undefined"){
        $(".cantAsistenciaColaboradoras")[0].focus();
    }

}

function confirmRegistroAsistenciaColaboradoras(){
    
    $("#btn-dialog-close-confirm-registro-asistencia").removeAttr("disabled");
    
    $("#dialogConfirmRegistroAsistenciaColaboradoras").removeClass('hide').dialog({
        width: 600,
        resizable: false,
        modal: true,
        title: "<div class='widget-header'><h5 class='smaller blue'><i class='fa fa-exclamation-triangle'></i> Confirmación de Registro de Asistencia </h5></div>",
        title_html: true,
        buttons: [
            {
                "html": "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                "class": "btn btn-danger btn-xs",
                "id":"btn-dialog-close-confirm-registro-asistencia",
                "click": function() {
                    $(this).dialog("close");
                }
            },
            {
                "html": "Guardar&nbsp; <i class='icon-save bigger-110'></i>",
                "class": "btn btn-primary btn-xs",
                "id":"btn-dialog-close-confirm-registro-asistencia",
                "click": function() {
                    $("#btn-dialog-close-confirm-registro-asistencia").attr("disabled", "disabled");
                    registroAsistenciaColaboradoras();
                }
            }
        ],
        close: function() {
            
        }
    });
}

function registroAsistenciaColaboradoras() {

    var divResult = "#dialogConfirmRegistroAsistenciaColaboradoras";
    var urlDir = '/planteles/madresColaboradoras/registrarAsistencia/id/'+($("#plantel_id").val());
    var datos = $("#asistencia-colaborador-plantel-form").serialize();
    var loadingEfect = true;
    var showResult = false;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = function(response, estatusCode, dom) {
        $("#divFormAsistenciaMadresColaboradorasPlantel").html(response);
        $("#btn-dialog-close-confirm-registro-asistencia").click();
    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}