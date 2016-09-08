var dialogBoxCargaMasiva = null;

$(document).ready(function() {

    // Configuración del área de Carga del Archivo. Boton ver "Arrastre o Seleccione un archivo"
    $('#fileupload').fileupload({
        url: $("#urlCargaArchivo").val(),
        acceptFileTypes: /(\.|\/)(jpeg|png|jpg)$/i,
        maxFileSize: 50000000, // 50MB
        singleFileUploads: true,
        autoUpload: true,
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            displayDialogBox("div-result", "error", "Se ha producido un error en la carga del archivo.");
        }
    });

    // Evento que se ejecuta si sucede un error
    $('#fileupload').bind('fileuploadfail', function(e, data) {
        if(data !== undefined && data.result !== undefined){
            $.each(data.result.files, function(index, file) {
                var error = $('<span/>').text(file.error);
                $(data.context.children()[index]).append('<br>').append(error);
                displayDialogBox("div-result", "error", "Ha ocurrido un error: " + error);
            });
            displayDialogBox("div-result", "error", "Ha ocurrido un error");
        }
    });

    // Evento que se ejecuta cuando ha finalizado la carga del archivo
    $('#fileupload').bind('fileuploaddone', function(e, data) {
        var archivos = data.jqXHR.responseJSON.files;
        // $("#notificacionArchivo").html("<div class='alert alert-success' role='alert'><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>¡Archivo cargado con exito!</div>");
        $.each(archivos, function(index, file) {
            var archivo = file.name;
            $("#archivo").val(archivo);
        });
        extraerGeoreferenciacion();
    });

});

/**
 * Esta función efectúa una petición ajax con el nombre del archivo que se cargó mediante
 * jquery-fileupload. La función se ejecuta cuando se produce el evento "fileuploaddone".
 */
function extraerGeoreferenciacion() {

    var archivo = $("#archivo").val();
    var divResult = "#notificacionArchivo";

    var urlDir = $("#urlCargaGeoreferencia").val();

    var datos = {
        archivo: archivo
    };

    var loadingEfect = true;
    var showResult = false;
    var method = "POST";
    var responseFormat = "json";

    var errorCallback = function(){
        $(divResult).html("");
    };

    var successCallback = function(response) {
        $(divResult).html("");
        if(response!==undefined){
            if(response.resultado!==undefined && response.mensaje!==undefined){
                if(response.resultado=='EXITOSO'){
                    $("#latitud").val(response.latitud);
                    $("#longitud").val(response.longitud);
                    displayDialogBox("div-result", "exito", response.mensaje);
                }
                else{
                    displayDialogBox("div-result", "error", response.mensaje);
                    $("#latitud").val('');
                    $("#longitud").val('');
                }
            }
            else{
                displayDialogBox("div-result", "error", "Ha ocurrido un error");
            }
        }
        else{
            displayDialogBox("div-result", "error", "Ha ocurrido un error");
        }
    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback, errorCallback);

}
