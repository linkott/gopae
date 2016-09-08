function VentanaDialog(id, direccion, title, accion, cod_tipo_dato) {
    var divResult = "resultadoOperacion";
    
    Loading.show();
    var data =
            {
                id: id,
        
                cod_tipo_dato: cod_tipo_dato
            };

//Accion Create. Aqui se pueden aperturar los tickes que se desean
    if (accion == "create") {
        $.ajax({
            url: direccion,
            data: data,
            dataType: 'html',
            type: 'GET',
            success: function(result, action)
            {
                var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                    modal: true,
                    width: '1100px',
                    draggable: false,
                    resizable: false,
                    position: ['center', 20],
                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-envelope'></i> &nbsp;" + title + "</h4></div>",
                    title_html: true,
                    buttons: [
                        {
                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                            "class": "btn btn-danger",
                            click: function() {
                                $(this).dialog("close");
                            }
                        },
                        {
                            html: "<i class='icon-save bigger-110'></i>&nbsp; Guardar",
                            "class": "btn btn-primary",
                            click: function() {


                                var divResult = "resultadoOperacion";
                                var urlDir = "/ayuda/ticket/" + accion + "/id/" + id;
                                var datos = $("#ticket-form").serialize();
                                var conEfecto = true;
                                var showHTML = true;
                                var method = "POST";
                                var responseFormat = "html";
                               
                               //alert(datos); return false;
                                var callback = function() {
                                    $('#clase-plantel-grid').yiiGridView('update', {
                                        
                                    });
                                    //$(this).dialog("close");
                                };
                                
 //Una ves obtenido los datos del formulario se valida del lado del cliente.                              
                                var tipoFormulario = $("#tipo-formulario").val();
                                
 // De ser el tipo de formulario correspondiente se resojen los datos.                               
                                if(tipoFormulario=="solicitud_nuevo_usuario"){
                                    
                                    var cedula = $.trim($('#cedula').val());
                                    var nombre = $.trim($('#nombre').val());
                                    var apellido = $.trim($('#apellido').val());
                                    var observacion = $.trim($('#observacion').val());
                                    var solicitante = $.trim($('#solicitante').val());
                                    var grupo = $.trim($("#grupo").val());
                                    var estado = $.trim($("#estado").val());
                                    
                                    if(cedula=="" || nombre=="" || apellido =="" || observacion =="" || solicitante==""){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: Los campos Cédula, Nombre, Apellido, Necesidad y Nombre del Solicitante no pueden estar vacios.');
                                    }
                                    else if(!isValidEmail($('#correo').val())){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: El formato de correo no es válido. Ej.: miusuario@me.gob.ve.');
                                    }
                                    else if(isNaN($('#cedula').val())){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: El formato de cédula es incorrecto. Ej.: 20413657.');
                                    }
                                    else if(!isValidPhone($('#telefono').val(), "fijo")){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: El campo Teléfono Fijo debe cumplir con el formato de un número de teléfono local y solo contener caracteres numericos. Ej.: 02121234567.');
                                    }
                                    else if(!isValidPhone($('#celular').val(), "movil")){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: El campo Teléfono Celular debe cumplir con el formato de un número de teléfono móvil y solo contener caracteres numericos. Ej.: 04261234567.');
                                    }
                                    else if(grupo=="" || estado==""){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: Debe seleccionar el Estado y el Grupo al que debe pertenecer el usuario.');
                                    }
                                    else{
                                        console.log("No existe error");
                                        if (datos) {
                                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                            $(this).dialog("close");
                                        }
                                    }
                                }
 // De ser otro tipo de formulario se muestra recogen otros datos.                               
                                else if(tipoFormulario=="solicitud_nuevo_plantel"){
                                    
                                    var codigo = $.trim($('#codigo_plantel').val());
                                    var solicitante = $.trim($('#solicitante_plantel').val());
                                    var observacion = $.trim($('#observacion_plantel').val());
                                    var solicitante = $.trim($('#solicitante_plantel').val());
                                    var zona_educativa = $.trim($("#zona_educativa").val());
                                    var dependencia = $.trim($("#dependencia").val());
                                    
                                    if(zona_educativa=="" || dependencia==""){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: Debe Seleccionar la Zona Educativa y la Dependencia del plantel.');
                                    }
                                    else if(codigo=="" || nombre=="" || solicitante==""){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: Los campos Código DEA del Plantel, Nombre de Plantel y Nombre del Solicitante no pueden estar vacios.');
                                    }
                                    else{
                                        console.log("No existe error");
                                        if (datos) {
                                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                            $(this).dialog("close");
                                        }
                                    }
                                    
                                }
                                else if(tipoFormulario=="error_sistema"){
                                    
                                    var observacion = $.trim($('#observacion_error').val());
                                    
                                    console.log(observacion.length);
                                    
                                    if(observacion.length<10){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: Debe indicar de forma detallada el error que se ha producido. Debe poseer más de 10 Caracteres.');
                                    }
                                    else{
                                        //console.log("No existe error");
                                        if (datos) {
                                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                            $(this).dialog("close");
                                        }
                                    }
                                    
                                }else if(tipoFormulario=="reseteo_clave"){
                                     var cedula = $.trim($('#cedula_res').val());
                                    var solicitante = $.trim($('#solicitante_res').val());
                                    var correo = $.trim($("#correo_res").val());
                                    var observacion = $.trim($("#observacion_res").val());
                                    
                                    if(cedula=="" || solicitante=="" || correo=="" || observacion==""){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: Debe Seleccionar la Cedula de Identidad, el Nombre del Solicitante, el Correo y la Observacion.');
                                    }
                                      else if(!isValidEmail($('#correo_res').val())){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: El formato de correo no es válido. Ej.: miusuario@me.gob.ve.');
                                    }
                                    
                                    else{
                                        //console.log("No existe error");
                                        if (datos) {
                                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                            $(this).dialog("close");
                                        }
                                    }    
                                }else if(tipoFormulario=="otra_solicitud"){
                                   var observacion = $.trim($('#observacion_otra').val());
                                   var solicitante =$.trim($('#solicitante_otra').val());
                                    
                                    console.log(observacion.length);
                                    
                                    if(observacion.length<10){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: Debe indicar de forma detallada el error que se ha producido. Debe poseer más de 10 Caracteres.');
                                    }
                                    if(solicitante==""){
                                        displayDialogBox('validaciones','error', 'DATOS FALTANTES: El campo solicitante no puede ser vacio.');
                                    }
                                    else{
                                        //console.log("No existe error");
                                        if (datos) {
                                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                            $(this).dialog("close");
                                        }
                                    }  
                                }
                                else{
                                    displayDialogBox('validaciones','error', 'Indique el Tipo de Ticket que desea aperturar.');
                                   
                                }
                                
                                //$("html, body").animate({scrollTop: 0}, "fast");
                            }       
                        }
                    ]
                });

                $("#dialogPantalla").html(result);
            
            }
        });
        Loading.hide();
    }
// Si es la accion ubdate se puede atender ticket.
    else if (accion == "update" ){
           $.ajax({
            url: direccion,
            data: data,
            dataType: 'html',
            type: 'GET',
            success: function(result, action)
            {
                var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                    modal: true,
                    width: '1100px',
                    draggable: false,
                    resizable: false,
                    position: ['center', 20],
                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-envelope'></i> &nbsp;" + title + "</h4></div>",
                    title_html: true,
                    buttons: [
                        {
                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                            "class": "btn btn-danger",
                            click: function() {
                                $(this).dialog("close");
                            }
                        },
                        {
                            html: "<i class='icon-save bigger-110'></i>&nbsp; Guardar",
                            "class": "btn btn-primary",
                            click: function() {
                                var divResult = "resultadoOperacion";
                                var urlDir = "/configuracion/configuracion/" + accion + "/id/"+id+"/cod_tipo_dato/" +id;
                                var datos = $("#configuracion").serialize();
                                var conEfecto = true;
                                var showHTML = true;
                                var method = "POST";
                                var responseFormat = "html";
                                var callback = function() {
                                    $('#clase-plantel-grid').yiiGridView('update', {
                                        data: $(this).serialize()
                                    });
                                };
                                
                                  //alert(datos); return false;
                                var tipoFormulario = $("#tipo-formulario").val();
                                if(tipoFormulario=="tipo_date"){
                                var fecha = $.trim($("#valor_date").val());
                                 if(fecha==""){
                                    displayDialogBox('validaciones','error', 'DATOS FALTANTES: La Fecha no puede estar vacia.');
                                }else{
                                
                                    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                   $(this).dialog("close");
                               }
                                
                                
                                 
                             }else if(tipoFormulario=="tipo_bool"){
   
                                 var bool= $.trim($("#valor_bool").val());
                                  if(bool==''){
                                      //alert("sigo pr aqui"); die();
                                    displayDialogBox('validaciones','error', 'DATOS FALTANTES: El valor bool no puede ser null.');
                                }else{
                                    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                   $(this).dialog("close");
                               }
                             }
                                
                                //$("html, body").animate({scrollTop: 0}, "fast");
                                
                            }     
                            
                        }
                    ]
                });

    $("#dialogPantalla").html(result);
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $.datepicker.setDefaults($.datepicker.regional = {
        dateFormat: 'yy-mm-dd',
        showOn:'focus',
        showOtherMonths: false,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        minDate: new Date(1800, 1, 1),
        maxDate: 'today'
    });
     $('#valor_date').datepicker();
            }
        });
        Loading.hide();
    }

    else if (accion == "view") {
     
        $.ajax({
            url: direccion,
            data: data,
            dataType: 'html',
            type: 'GET',
            success: function(result, action)
            {
                var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                    modal: true,
                    width: '1100px',
                    draggable: false,
                    resizable: false,
                    position: ['center', 20],
                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
                    title_html: true,
                    buttons: [
                        {
                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                            "class": "btn btn-danger",
                            click: function() {
                                $(this).dialog("close");
                            }
                            
                        },
                      
                    ]
                });

                $("#dialogPantalla").html(result);
            },
            statusCode: {
                404: function() {
                    displayDialogBox(divResult, "error", "404: No se ha encontrado el recurso solicitado. Recargue la P&aacute;gina e intentelo de nuevo.");
                },
                400: function() {
                    displayDialogBox(divResult, "error", "400: Error en la petici&oacute;n, comuniquese con el Administrador del Sistema para correcci&oacute;n de este posible error.");
                },
                401: function() {
                    displayDialogBox(divResult, "error", "401: Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.");
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
            }
        
        });
        Loading.hide();

    }

// si es la accion activar se puede reactivar un 
    else if (accion == "activar") {

        $("#dialogPantalla").html('<div class="form center"> <label for="ticket_observacion">¿Estas seguro que desea activarlo? <br /> Indique el motivo de reactivación del Ticket</label><input type="text" id="ticket_observacion" name="observacion" maxlength="250" style="width:94.5%" /></div>').ready(function(){
            $('#ticket_observacion').bind('keyup blur', function() {
                keyText(this, true);
                makeUpper(this);
            });

            $('#ticket_observacion').bind('blur', function() {
                clearField(this);
            });
        });;
        
        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            draggable: false,
            resizable: false,
            position: ['center', 20],
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
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
                    html: "<i class='icon-check bigger-110'></i>&nbsp; Activar ticket",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        
                        var divResult = "resultadoOperacion";
                        var urlDir = "/ayuda/ticket/activar?id=" + id;
                        var observacion = $.trim($("#ticket_observacion").val());
                        var datos = {id: id, accion: accion, observacion: observacion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var responseFormat = "html";
                        var callback = function() {
                            $('#clase-plantel-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };

                        $("html, body").animate({scrollTop: 0}, "fast");
                        
                        if (observacion.length>=5 && datos) {
                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                            $(this).dialog("close");
                        }
                    }
                }

            ]
        });

        Loading.hide();

    }

}

function getDataFromSaime(cedula) {

        var divResult = "";
        var urlDir = "/ayuda/saime/consultaSaimeSinOrigen/cedula/" + cedula + "/format/json";
        var datos = {cedula: cedula};
        var conEfecto = false;
        var showHTML = false;
        var method = "POST";
        
        if (!isNaN(cedula)) {
            $.ajax({
                type: method,
                url: urlDir,
                dataType: "json",
                data: datos,
                success: function(jsonResponse) {
                    if(jsonResponse.statusCode == 'success'){
                        $("#nombre").val(jsonResponse.nombre);
                        $("#apellido").val(jsonResponse.apellido);
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
                        displayDialogBox(divResult, "error", "401: Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.");
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
                }
            });
        }

    }
$(document).ready(function(){
    $("#apertura_configuracion").on('click', function(evt){
        evt.preventDefault();
        VentanaDialog('', '/ayuda/ticket/create', 'Ticket', 'create', '')
    });
    $('#Ticket_codigo').bind('keyup blur', function () {
        keyNum(this, false);
        clearField(this);
    });

    $('#Ticket_observacion').bind('keyup blur', function () {
        keyText(this, true);
    });

    $('#Ticket_observacion').bind('blur', function () {
        clearField(this);
    });
    
});
$(document).ready(function() {

    $('#date-picker').datepicker();
    $.datepicker.setDefaults($.datepicker.regional = {
        dateFormat: 'dd-mm-yy',
        showOn: 'focus',
        showOtherMonths: false,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        minDate: new Date(1800, 1, 1),
        maxDate: 'today'
    });

});