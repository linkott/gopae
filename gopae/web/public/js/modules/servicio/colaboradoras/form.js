$(document).ready(function(){
    
    formInputFilters();
    busquedaSaime();
    
    var formType = $("#colaborador-form").attr('data-form-type');
    
    if(formType==='create'){
        $("#Colaborador_cedula").on('blur', function(){
            busquedaSaime();
        });
    }
    else{
        $("#Colaborador_origen").attr('disabled', 'disabled');
        $("#Colaborador_cedula").attr('readOnly','readOnly');
        $("#Colaborador_nombre").attr('disabled','disabled');
        $("#Colaborador_apellido").attr('disabled','disabled');
        $("#Colaborador_fecha_nacimiento").attr('disabled','disabled');
        $("#Colaborador_sexo").attr('disabled', 'disabled');
    }
        
});

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

function busquedaSaime(){
            
    var origen = $("#Colaborador_origen").val();
    var cedula = $("#Colaborador_cedula").val();
    
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
                    
                    var cedulaInicial = $("#Colaborador_cedula").attr('data-inicial');
                    
                    $("#read_existe_cedula").val('Si');

                    var nombreInicial = $("#Colaborador_nombre").val();
                    if(nombreInicial.length==0 || !isValidNombre() || cedulaInicial!=cedula){
                        $("#Colaborador_nombre").val(nombre);
                    }

                    var apellidoInicial = $("#Colaborador_apellido").val();
                    if(apellidoInicial.length==0 || !isValidApellido() || cedulaInicial!=cedula){
                        $("#Colaborador_apellido").val(apellido);
                    }

                    $("#Colaborador_cedula").attr('data-inicial',cedula);
                    $("#Colaborador_nombre").attr('data-inicial',nombre);
                    $("#Colaborador_apellido").attr('data-inicial',apellido);

                    $("#Colaborador_fecha_nacimiento").val(fecha_nacimiento);
                    $("#read_fecha_nacimiento_latino").val(fecha_nacimiento_latino);
                    $("#Colaborador_sexo").val(sexo);

                    $("#Colaborador_origen_titular").val(origen);
                    $("#Colaborador_cedula_titular").val(cedula);
                    $("#Colaborador_nombre_titular").val(nombre + " " + apellido);
                }
                else{
                    var cedula = $("#Colaborador_cedula").attr('data-inicial');
                    $("#Colaborador_cedula").val(cedula);
                    $("#read_existe_cedula").val('No');
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
    console.log($indiceNombre);
    return ($indiceNombre<=3);
}

function isValidApellido(){
    $apellidoInicial = $("#Colaborador_apellido").attr('data-inicial');
    $apellido = $("#Colaborador_apellido").val();
    $indiceApellido = levenshtein($apellidoInicial, $apellido);
    console.log($indiceApellido);
    return ($indiceApellido<=3);
}
