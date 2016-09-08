$(document).ready(function() {
    $("#e1").select2({
        multiple: true,
        placeholder: "Seleccione los campos de la tabla",
        maximumSelectionSize: 5
    });
    $('#GeneradorForm_connectionId').bind('keyup blur', function() {
        keyTextOnly(this);
        clearField(this);
    });
    $('#GeneradorForm_tableName').bind('keyup blur', function() {
        keyText(this, false);
        clearField(this);
    });
    $('#GeneradorForm_modelClass').bind('keyup blur', function() {
        keyTextOnly(this);
        clearField(this);
    });

    $('#GeneradorForm_tableName').bind('blur', function() {
        var valor = this.value;
        if (valor != null && valor != '') {
            var divResult = "GeneradorForm_fields";
            var divError = "divErrors";
            var urlDir = "/administracion/generadorCodigoCatalogo/getTableColumns/";
            var datos = $("#generador-form").serialize();
            var conEfecto = true;
            var showHTML = true;
            var method = "GET";
            var mensaje;
            $("#" + divError).addClass('hide');
            $("#" + divError).html('');
            $("#succesMsg").addClass('hide');
            $("#succesMsg").html('');
            $.ajax({
                type: method,
                url: urlDir,
                dataType: 'json',
                data: datos,
                beforeSend: function() {
                    if (conEfecto) {
                        var url_image_load = "<div class='center'><img title='Su transacci&oacute;n est&aacute; en proceso' src='/public/images/ajax-loader-red.gif'></div>";
                        displayHtmlInDivId(divResult, url_image_load);
                    }
                },
                success: function(json) {
                    if (json.statusCode == 'SUCCESS') {
                        
                        console.log(json.data);
                        
                        $("#GeneradorForm_fields").select2({
                            createSearchChoice: function(term, data) {
                                if ($(data).filter(function() {
                                    return this.text.localeCompare(term) === 0;
                                }).length === 0) {
                                    return {id: term, text: term};
                                }
                            },
                            allowClear: true,
                            placeholder: 'Seleccione',
                            multiple: true,
                            maximumSelectionSize: 7,
//                            formatSelectionTooBig: function(a){
//                                return "No puede seleccionar más de "+a+" elementos.";
//                            },
                            data: json.data
                        });
                        
                        $("#GeneradorForm_orderBy").select2({
                            createSearchChoice: function(term, data) {
                                if ($(data).filter(function() {
                                    return this.text.localeCompare(term) === 0;
                                }).length === 0) {
                                    return {id: term, text: term};
                                }
                            },
                            allowClear: true,
                            placeholder: 'Seleccione',
                            multiple: true,
                            maximumSelectionSize: 2,
//                            formatSelectionTooBig: function(a){
//                                return "No puede seleccionar más de "+a+" elementos.";
//                            },
                            data: json.data
                        });

                        $("#divFields").removeClass('hide');
                        $("#divOrderBy").removeClass('hide');
                        if (json.existe_archivo == true) {
                            var cantDataArchivo = json.cantDataArchivo;
                            mensaje = 'Estimado usuario, se ha generado este archivo anteriormente el mismo contine '+cantDataArchivo+' registro(s).';
                            $("#" + divError).removeClass('hide');
                            displayDialogBox(divError, "alert", mensaje);
                        }
                    }
                    if (json.statusCode == 'ERROR') {
                        $("#" + divError).removeClass('hide');
                        displayDialogBox(divError, "error", json.mensaje);
                    }


                },
                statusCode: {
                    404: function() {
                        displayDialogBox(divResult, "error", "404: No se ha encontrado el recurso solicitado. Recargue la P&aacute;gina e intentelo de nuevo.");
                    },
                    400: function() {
                        displayDialogBox(divResult, "error", "400: Error en la petici&oacute;n, comuniquese con el Administrador del Sistema para correcci&oacute;n de este posible error.");
                    },
                    401: function() {
                        displayDialogBox(divResult, "error", "401: Datos insuficientes para efectuar esta acci&oacute;n.");
                    },
                    403: function() {
                        displayDialogBox(divResult, "error", "403: Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.");
                    },
                    500: function() {
                        displayDialogBox(divResult, "error", "500: Se ha producido un error en el sistema, Comuniquese con el Administrador del Sistema para correcci&oacute;n del m&iacute;smo.");
                    },
                    503: function() {
                        displayDialogBox(divResult, "error", "503: El servidor web se encuentra fuera de servicio. Comuniquese con el Administrador del Sistema para correcci&oacute;n del error.");
                    },
                    999: function(resp) {
                        displayDialogBox(divResult, "error", resp.status + ': ' + resp.responseText);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    //alert(xhr.status);
                    //alert(thrownError);
                    if (xhr.status == '403') {
                        displayDialogBox(divResult, "error", "Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.");
                    } else if (xhr.status == '401') {
                        displayDialogBox(divResult, "error", "Datos insuficientes para efectuar esta acci&oacute;n..");
                    } else if (xhr.status == '400') {
                        displayDialogBox(divResult, "error", "Recurso no encontrado. Recargue la P&aacute;gina e intentelo de nuevo.");
                    } else if (xhr.status == '500') {
                        displayDialogBox(divResult, "error", "Se ha producido un error en el sistema, Comuniquese con el Administrador del Sistema para correcci&oacute;n del m&iacute;smo.");
                    } else if (xhr.status == '503') {
                        displayDialogBox(divResult, "error", "El servidor web se encuentra fuera de servicio. Comuniquese con el Administrador del Sistema para correcci&oacute;n del error.");
                    }
                }
            });



        }
    });

});
//$("#generador-form").submit(function(evt) {
//    evt.preventDefault();
//    $.ajax({
//        url: "/administracion/generadorCodigo/generarClase",
//        data: $("#generador-form").serialize(),
//        dataType: 'html',
//        type: 'post',
//        success: function(dataHtml) {
//            console.log(dataHtml);
//        }
//    });
//        }
//);
