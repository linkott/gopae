
$(document).ready(function() {
    var id = btoa($("#id").val());
    $('#fileupload').fileupload({
        url: '/proveedor/proveedor/upload/id/' + id,
        acceptFileTypes: /(\.|\/)(jpe?g|png|pdf|doc|opt)$/i,
        maxFileSize: 5000000,
        singleFileUploads: true,
        autoUpload: true,
        process: [
            {
                action: 'load',
                fileTypes: /(\.|\/)(jpe?g|png|pdf)$/i,
                maxFileSize: 20000000 // 20MB
            },
            {
                action: 'resize',
                maxWidth: 1440,
                maxHeight: 900
            },
            {
                action: 'save'
            }
        ],
        error: function(jqXHR, textStatus, errorThrown) {
            $("#files").removeClass();
            $("#files").addClass('alertDialogBox');
            $("#files").html("Se produjo un error en la carga del archivo.");

        }

    });
    $('#fileupload').bind('fileuploaddone', function(e, data) {
        var archivos = data.jqXHR.responseJSON.files;
        //  console.debug(archivos=);
        //var ruta=file.url;
        //$('<p/>').text(file.name).appendTo('#files');
        $.each(archivos, function(index, file) {


            nombre = file.name;
                
           
            //alert("sd");
            $("#dialogPantalla").html('<div class="alertDialogBox">\n\
                <p class="bolder center grey"> \n\
¿Desea Cambiar el Nombre del Archivo?</p>\n\</div>\n\
<div class="row">\n\
<div class="col-md-12">\n\
<label class="col-md-12">Nombre:</label>\n\
<input class="col-md-12" required="required" id="nuevoNombre" name="nombre" type="text" value="' + nombre + '"/> \n\
</div>');
            var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                modal: true,
                width: '450px',
                dragable: false,
                resizable: false,
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-upload'></i> Modificar Archivo</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                        "class": "btn btn-danger btn-xs",
                        click: function() {
                            $(this).dialog("close");
                        }
                    },
                    {
                        html: "<i class='icon-save bigger-110'></i>&nbsp; Guardar",
                        "class": "btn btn-primary btn-xs",
                        click: function() {
                            var ext = getFileExtension(nombre);
                            var nombreBD = $("#nuevoNombre").val();
                            var tipo_documento = $("#tipo_documento").val();
                          
                                
                            var datos = {id: nombre, nombreBD: nombreBD, proveedor_id: id, tipo_documento:tipo_documento};
                            $.ajax({
                                url: '/proveedor/proveedor/guardarArchivo',
                                type: 'POST',
                                data: datos,
                                success: function(result)
                                {
                                    $("#files").removeClass();
                                    $("#files").html(result);



                                    $('#documento-proveedor-grid').yiiGridView('update', {
                                        data: $(this).serialize()
                                    });

                                }

                            });
                            
                            $(this).dialog("close");
                        }
                    }
                ]
            });
            

        });
    });
});

function getFileExtension(name)
{
    var found = name.lastIndexOf('.') + 1;
    return (found > 0 ? name.substr(found) : "");
}



function VentanaDialog(id, direccion, title, accion, datos) {

    accion = accion;
    Loading.show();
    var data = {id: id, datos: datos};
    if (accion === "borrar") {

        $("#dialogPantalla").html('<div class="alert alert-warning"> ¿Desea inactivar este proveedor?</div>');

        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> " + title + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; inactivar ",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/proveedor/proveedor/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#proveedor-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };
                        if (datos) {
                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, 'html', callback);
                            $(this).dialog("close");
                        }
                    }
                }
            ]
        });
        Loading.hide();
    }

    else if (accion === "activar") {

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Desea activar este Proveedor? </p></div>');

        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> " + title + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-xs orange",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-check bigger-110'></i>&nbsp; Reactivar",
                    "class": "btn btn-success btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/proveedor/proveedor/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#proveedor-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };

                        if (datos) {
                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, 'html', callback);
                            $(this).dialog("close");
                        }
                    }
                }
            ]
        });
        Loading.hide();
    }
}


function cambiarEstatus() {

    var id = $("id").val();
    var data = {id: id};
    var dialog = $("#dialogPantalla").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar esta unidad de medida</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-xs orange",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Unidad de Medida",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    executeAjax('_borrar', '/catalogo/unidadMedida/borrar', data, false, true, 'POST', 'html');
                }
            }
        ]
    });


}