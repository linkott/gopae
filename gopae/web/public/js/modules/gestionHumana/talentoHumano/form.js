$(document).ready(function(){
    
    formInputFilters();
    busquedaSaime();
    
    $("#TalentoHumano_estado_id").on('change', function(){
        var municipios = getDataCatastro('Municipio', 'estado_id', $(this).val(), false, 'nombre');
        $("#TalentoHumano_municipio_id").html(generateOptionsToSelect(municipios, 'nombre', 'id', null));
    });
    
    $("#TalentoHumano_municipio_id").on('change', function(){
        var parroquias = getDataCatastro('Parroquia', 'municipio_id', $(this).val(), false, 'nombre');
        $("#TalentoHumano_parroquia_id").html(generateOptionsToSelect(parroquias, 'nombre', 'id', null));
    });
    
    var formType = $("#talentoHumano-form").attr('data-form-type');
    
    if(formType==='create'){
        $("#TalentoHumano_cedula").on('blur', function(){
            busquedaSaime();
        });
    }
    else{
        $("#TalentoHumano_origen").attr('disabled', 'disabled');
        $("#TalentoHumano_cedula").attr('readOnly','readOnly');
        $("#TalentoHumano_nombre").attr('disabled','disabled');
        $("#TalentoHumano_apellido").attr('disabled','disabled');
        $("#TalentoHumano_fecha_nacimiento").attr('disabled','disabled');
        $("#TalentoHumano_sexo").attr('disabled', 'disabled');
    }
    
    $("#talentoHumanoDatosBancarios-form").on('submit',function(evt){
        evt.preventDefault();
        registroDatosBancarios($(this));
    });
    
    if($("#talentoHumano-form").attr('data-form-type')=='update'){
        $("#talentoHumano-form").on('submit',function(evt){
            evt.preventDefault();
            registroDatosTalentoHumano($(this));
        });
    }

});

function formInputFilters(){
    
    // Filters
    
    $("#TalentoHumano_cedula").on('keyup blur', function(){
        keyNum(this, false, false);
    });
    
    $("#TalentoHumano_nombre").on('keyup blur', function(){
        keyAlpha(this, true, true);
    });
    
    $("#TalentoHumano_apellido").on('keyup blur', function(){
        keyAlpha(this, true, true);
    });
    
    $("#TalentoHumano_fecha_nacimiento").on('keyup blur', function(){
        keyNum(this, false, true);
    });
    
    $("#TalentoHumano_enfermedades").on('keyup blur', function(){
        keyText(this, true);
    });
    
    $("#TalentoHumano_observacion, #TalentoHumano_aptitudes").on('keyup blur', function(){
        keyText(this, true);
    });
    
    $("#TalentoHumano_email_personal").on('keyup blur', function(){
        keyEmail(this, false);
    });
    
    $("TalentoHumano_direccion").on('blur', function(){
        clearField(this);
    });
    
    $("#TalentoHumano_twitter").on('keyup blur', function(){
        keyTwitter(this, false);
    });
    
    $("#TalentoHumano_cedula_titular").on('keyup blur', function(){
        keyNum(this, false, false);
    });
    
    $("#TalentoHumano_nombre_titular").on('keyup blur', function(){
        keyLettersAndSpaces(this, false);
        makeUpper(this);
    });
    
    // Clear Fields
    
    $("#TalentoHumano_cedula").on('blur', function(){
        clearField(this);
    });
    
    $("#TalentoHumano_nombre").on('blur', function(){
        clearField(this);
    });
    
    $("#TalentoHumano_apellido").on('blur', function(){
        clearField(this);
    });
    
    $("#TalentoHumano_enfermedades").on('blur', function(){
        clearField(this);
    });
    
    $("#TalentoHumano_observacion").on('blur', function(){
        clearField(this);
    });
    
    $("#TalentoHumano_email_personal").on('blur', function(){
        clearField(this);
    });
    
    $("TalentoHumano_direccion").on('blur', function(){
        clearField(this);
    });
    
    $("TalentoHumano_aptitudes").on('blur', function(){
        clearField(this);
    });
    
    $("#TalentoHumano_cedula_titular").on('blur', function(){
        clearField(this);
    });
    
    $("#TalentoHumano_nombre_titular").on('blur', function(){
        clearField(this);
    });
    
    // Masks

    $.mask.definitions['L'] = '[1-2]';
    $.mask.definitions['X'] = '[2|4|6]';
    
    $('#TalentoHumano_telefono_fijo').mask('(0299)999-9999');
    $('#TalentoHumano_telefono_celular').mask('(04LX)999-9999');
    $('#TalentoHumano_numero_cuenta').mask('99999999999999999999');
    $('#TalentoHumano_numero_tarjeta_alimentacion').mask('99999999999999999999');
    
    
    if($("#talentoHumano-form").attr('data-form-type')!='update'){
        $('#read_fecha_nacimiento_latino').datepicker(); 
        $.datepicker.setDefaults({
            closeText: 'Cerrar',
            prevText: 'Anterior',
            nextText: 'Siguiente',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd-mm-yy',
            showOn: 'focus',
            showOtherMonths: false,
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            minDate: new Date(1700, 1, 1),
            maxDate: 'yesterday',
            onSelect: function(dateText, inst)
            {
                $('#TalentoHumano_fecha_nacimiento').val($.datepicker.formatDate("yy-mm-dd", $('#read_fecha_nacimiento_latino').datepicker('getDate')));
            }
        });
    }
    
    if($('#TalentoHumano_fecha_entrega_tarjeta_alimentacion').val()!=""){
        $('#read_fecha_entrega_tarjeta_alimentacion').datepicker({
            closeText: 'Cerrar',
            prevText: 'Anterior',
            nextText: 'Siguiente',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd-mm-yy',
            showOn: 'focus',
            showOtherMonths: false,
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            minDate: new Date(1700, 1, 1),
            maxDate: 'yesterday',
            onSelect: function(dateText, inst)
            {
                $('#TalentoHumano_fecha_entrega_tarjeta_alimentacion').val($.datepicker.formatDate("yy-mm-dd", $('#read_fecha_entrega_tarjeta_alimentacion').datepicker('getDate')));
            }
        }); 
    }
    // $.datepicker.setDefaults();
}

function busquedaSaime(){
            
    var origen = $("#TalentoHumano_origen").val();
    var cedula = $("#TalentoHumano_cedula").val();
    
    if(origen.length>0 && cedula.length>0){
    
        if(isValidOrigen(origen)){
            
            var divResult = "";
            var urlDir = "/ayuda/saime/consultaSaime/origen/"+origen+"/cedula/"+cedula;
            var datos = "";
            var loadingEfect = false;
            var showResult = false;
            var method = "GET";
            var responseFormat = "json";
            var beforeSendCallback = null;
            var successCallback = function(response, estatusCode, dom){
                
                console.log(response.statusCode);
                if(response.statusCode==='success'){
                    var origen = response.origen;
                    var cedula = response.cedula;
                    var nombre = response.nombre;
                    var apellido = response.apellido;
                    var fecha_nacimiento = response.fecha_nacimiento;
                    var fecha_nacimiento_latino = response.fecha_nacimiento_latino;
                    var sexo = response.sexo;
                    
                    var cedulaInicial = $("#TalentoHumano_cedula").attr('data-inicial');
                    
                    $("#read_existe_cedula").val('Si');

                    var nombreInicial = $("#TalentoHumano_nombre").val();
                    if(nombreInicial.length==0 || !isValidNombre() || cedulaInicial!=cedula){
                        $("#TalentoHumano_nombre").val(nombre);
                    }

                    var apellidoInicial = $("#TalentoHumano_apellido").val();
                    if(apellidoInicial.length==0 || !isValidApellido() || cedulaInicial!=cedula){
                        $("#TalentoHumano_apellido").val(apellido);
                    }

                    $("#TalentoHumano_cedula").attr('data-inicial',cedula);
                    $("#TalentoHumano_nombre").attr('data-inicial',nombre);
                    $("#TalentoHumano_apellido").attr('data-inicial',apellido);

                    $("#TalentoHumano_fecha_nacimiento").val(fecha_nacimiento);
                    $("#read_fecha_nacimiento_latino").val(fecha_nacimiento_latino);
                    $("#TalentoHumano_sexo").val(sexo);

                    $("#TalentoHumano_origen_titular").val(origen);
                    $("#TalentoHumano_cedula_titular").val(cedula);
                    var nombreCompleto = nombre + " " + apellido;
                    nombreCompleto = nombreCompleto.toUpperCase();
                    nombreCompleto = nombreCompleto.substr(0, 40);
                    $("#TalentoHumano_nombre_titular").val();
                    
                    $("#TalentoHumano_verificado_saime").val('Si');
                }
                else{
                    var cedula = $("#TalentoHumano_cedula").attr('data-inicial');
                    if($("#talentoHumano-form").attr('data-form-type')!='update'){
                        $("#TalentoHumano_cedula").val(cedula);
                    }
                    $("#read_existe_cedula").val('No');
                    $("#TalentoHumano_verificado_saime").val('No');
                    simpleDialogPopUp("#resultadoDialogo", "fa-credit-card", 'Búsqueda de Documento de Identidad', getDialogBox('error', response.mensaje));
                }

            };
            
            executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);

        }else{
            displayDialogBox('#resultado', 'error', 'El valor del Origen no es válido. Le recomendamos recargar la página e intentarlo de nuevo.');
        }

    }
    
}


function validateForm(){
    var cedulaRead = $("#read_existe_cedula").val();
    var existeCedula = cedulaRead==='Si';
    if(!existeCedula){
        displayDialogBox('resultado', 'error', 'El número de documento de identidad no ha podido ser encontrado en nuestra base de datos.');
        $("html, body").animate({ scrollTop: 0 }, "fast");
        return false;
    }
    else{
        
        if($("#TalentoHumano_telefono_fijo").val()=="" && $("#TalentoHumano_telefono_celular").val()==""){
            $("#TalentoHumano_telefono_fijo, #TalentoHumano_telefono_celular").addClass('error');
            displayDialogBox('resultado', 'error', 'Debe indicar al menos un número telefónico de contacto.');
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return false;
        }
        else{
            $("#TalentoHumano_telefono_fijo, #TalentoHumano_telefono_celular").removeClass('error');
        }
        
        if(!isValidNombre()){
            $("#TalentoHumano_nombre").addClass('error');
            displayDialogBox('resultado', 'error', 'Solo debe hacer correcciones del nombre, no modificarlo por completo.');
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return false;
        }
        else{
            $("#TalentoHumano_nombre").removeClass('error');
        }

        if(!isValidApellido()){
            $("#TalentoHumano_apellido").addClass('error');
            displayDialogBox('resultado', 'error', 'Solo debe hacer correcciones del apellido, no modificarlo por completo.');
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return false;
        }
        else{
            $("#TalentoHumano_apellido").removeClass('error');
        }
        var edad = getAge($('#TalentoHumano_fecha_nacimiento').val());
        if(edad<18 || edad>90){
            $("#TalentoHumano_fecha_nacimiento").addClass('error');
            if(edad<18){
                displayDialogBox('resultado', 'error', 'Esta persona parece no ser mayor de edad.');
            }
            else{
                displayDialogBox('resultado', 'error', 'Esta persona es mayor de 90 años.');
            }
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return false;
        }
    }
    return true;
}

function registroDatosTalentoHumano(form){
    var datos = form.serialize();
    var urlDir = form.attr('action');
    
    if(datos.length>0 && urlDir.length){
        var divResult = "#resultado";
        var loadingEfect = true;
        var showResult = true;
        var method = "POST";
        var responseFormat = "html";
        var successCallback = function(response, dom, statusCode){
            scrollUp();
        };
        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    }
}

function registroDatosBancarios(form){
    
    var datos = form.serialize();
    var urlDir = form.attr('action');
    
    if(datos.length>0 && urlDir.length){
        var divResult = "#divResultDatosBancarios";
        var loadingEfect = true;
        var showResult = true;
        var method = "POST";
        var responseFormat = "html";
        var successCallback = function(response, dom, statusCode){
            scrollUp();
        };
        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
    }
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
    $nombreInicial = $("#TalentoHumano_nombre").attr('data-inicial');
    $nombre = $("#TalentoHumano_nombre").val();
    $indiceNombre = levenshtein($nombreInicial, $nombre);
    console.log($indiceNombre);
    return ($indiceNombre<=5);
}

function isValidApellido(){
    $apellidoInicial = $("#TalentoHumano_apellido").attr('data-inicial');
    $apellido = $("#TalentoHumano_apellido").val();
    $indiceApellido = levenshtein($apellidoInicial, $apellido);
    console.log($indiceApellido);
    return ($indiceApellido<=5);
}
