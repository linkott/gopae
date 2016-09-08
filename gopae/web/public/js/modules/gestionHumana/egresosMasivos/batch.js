var dialogBoxCargaMasiva = null;

$(document).ready(function() {
    
    var operacion = ($("#operacion").val());
    var urlCargaArchivo = $("#urlCargaArchivo").val();
    
    $("a#link_descarga_formato_"+operacion).fancybox({
       'overlayShow'	: true,
        'transitionIn'	: 'elastic',
        'transitionOut'	: 'elastic',
        'overlayOpacity': 0.5,
        'titlePosition'	: 'over',
        'opacity'	: true,
        title: "Puede <a href='/public/formatos/formato_carga_"+operacion+".xls'>Descargar</a> el Formato de Carga Masiva de Ingresos en este <a href='/public/formatos/formato_carga_egresos.xls'>link</a>.",
    });

    // Configuración del área de Carga del Archivo. Boton ver "Arrastre o Seleccione un archivo"
    $('#fileupload').fileupload({
        url: urlCargaArchivo,
        acceptFileTypes: /(\.|\/)(xlsx|xls|ods)$/i,
        maxFileSize: 50000000, // 50MB
        singleFileUploads: true,
        autoUpload: true,
        error: function(jqXHR, textStatus, errorThrown) {
            displayDialogBox("result-grid", "error", "Se ha producido un error en la carga del archivo.");
        }
    });

    // Evento que se ejecuta si sucede un error
    $('#fileupload').bind('fileuploadfail', function(e, data) {

        console.log(e);
        console.log(data);

        $.each(data.result.files, function(index, file) {
            var error = $('<span/>').text(file.error);
            $(data.context.children()[index]).append('<br>').append(error);
            displayDialogBox("result-fileupload", "error", "Ha ocurrido un error: " + error);
        });

    });

    // Evento que se ejecuta cuando ha finalizado la carga del archivo
    $('#fileupload').bind('fileuploaddone', function(e, data) {

        var archivos = data.jqXHR.responseJSON.files;

        $("#notificacionArchivo").html("¡Archivo cargado con exito!");

        $.each(archivos, function(index, file) {

            var archivo = file.name;
            $("#archivo").val(archivo);

            displayDialogBox("result-fileupload", "exito", "El archivo se ha cargado exitósamente con el nombre <b>" + archivo + "</b>, indique la operación que desea efectuar con la información del archivo.");

            $("#dialog-options").removeClass('hide').dialog({
                width: 800,
                resizable: false,
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller blue'><i class='fa fa-cloud-upload '></i> Carga Masiva de Órdenes Sise </h4></div>",
                title_html: true,
                buttons: [
                    {
                        "html": "<i class='icon-arrow-left bigger-110'></i> &nbsp; Cancelar",
                        "class": 'btn btn-danger btn-xs btn-data-'+operacion,
                        "id": "btn-eliminar-"+operacion,
                        click: function() {
                            $(this).dialog("close");
                        }
                    },
                    {
                        html: "Carga Masiva de "+operacion+wordsFirstUpper(operacion)+" &nbsp; <i class='fa fa-cloud-upload bigger-110'></i>",
                        "class": 'btn btn-primary btn-xs btn-data-'+operacion,
                        "id": "btn-agregar-"+operacion,
                        click: function() {
                            dialogBoxCargaMasiva = $(this);
                            cargaMasiva(base64_encode(operacion));
                        }
                    }
                ],
                close: function() {
                    $(this).dialog("close");
                }
            });


        });

    });

});

function cargaMasiva(oper) {

    //console.log("Voy a " + base64_decode(oper));

    var token = $("#csrfToken").val();
    var archivo = $("#archivo").val();
    var divResult = "result-grid";

    var urlDir = $("#urlProcesamientoArchivo").val();
    var datos = {
        archivo: archivo,
        csrfToken: token,
        operacion: oper
    };
    var loadingEfect = false;
    var showResult = false;
    var method = "POST";
    var responseFormat = "json";

    var beforeSend = null;

    var callbackFunction = function() {
        //console.log(ajaxDataResponse);
        //printTableAll();
        if (dialogBoxOrdenesSise !== null) {
            dialogBoxOrdenesSise.dialog("close");
        }

        var data = ajaxDataResponse.response.data;
        totalRowsT = data.length;
        if (rowsInPageT > 0) {
            totalPagesT = Math.ceil(totalRowsT / rowsInPageT);
        }
        else {
            totalPagesT = 1;
        }
        
        var headers = [{
            key: 'localidad',
            label: 'Localidad'
        },
        {
            key: 'orden',
            label: 'Orden'
        },
        {
            key: 'estatus',
            label: 'Estatus'
        },
        {
            key: 'mensaje',
            label: 'Observación'
        },
        {
            key: 'resultado',
            label: 'Resultado'
        }];
        
        printTableResponse(headers, ajaxDataResponse, true, rowsInPageT, 1, true);
    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, callbackFunction);

}
