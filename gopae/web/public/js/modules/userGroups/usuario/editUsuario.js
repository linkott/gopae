$(document).ready(function(){
   
    $("#UserGroupsAccess_1_cedula").bind('keyup blur', function () {
        keyNum(this, false);
    });
    
    $("#UserGroupsAccess_1_username").bind('keyup blur', function () {
        keyAlphaNum(this, false, false);
        clearField(this);
        makeUpper(this);
    });
    
    $("#UserGroupsAccess_1_nombre").bind('keyup blur', function () {
        keyAlphaNum(this, true, true);
        makeUpper(this);
    });
    
    $("#UserGroupsAccess_1_apellido").bind('keyup blur', function () {
        keyAlphaNum(this, true, true);
        makeUpper(this);
    });
    
    $('#UserGroupsAccess_1_email').bind('keyup blur', function () {
        keyEmail(this, false);
    });
    
    $('#UserGroupsAccess_1_telefono').bind('keyup blur', function () {
        keyNum(this, false);
    });
    
    $('#UserGroupsAccess_1_telefono_celular').bind('keyup blur', function () {
        keyNum(this, false);
    });
    
    $("#UserGroupsAccess_1_cedula").bind('blur', function () {
        var valorCedula = $(this).val();
        if(valorCedula.length>3){
            var cedula = 'V-'+valorCedula;
            buscarCedulaAutoridad(cedula);
        }
    });
    
});

function buscarCedulaAutoridad(cedula) {
    var plantel_id = $("#plantel_id").val();
    if (cedula != '' || cedula != null) {
        $.ajax({
            url: "/userGroups/usuario/buscarCedula",
            data: {cedula: cedula,
                plantel_id: plantel_id},
            dataType: 'json',
            type: 'post',
            success: function(resp) {
                if (resp.statusCode === "mensaje"){
                    dialogo_error(resp.mensaje);
                    $("#UserGroupsAccess_1_username").val(resp.usuario);
                }
                if (resp.statusCode === "successU"){
                    $("#UserGroupsAccess_1_nombre").val(resp.nombre);
                    $("#UserGroupsAccess_1_apellido").val(resp.apellido);
                    if($("#UserGroupsAccess_1_username").val().length===0 || ($("#UserGroupsAccess_1_username").val()!=resp.usuario && resp.usuario.length!==0)){
                        $("#UserGroupsAccess_1_username").val(resp.usuario);
                    }
                }
            }

        });
    }
}

function dialogo_error(mensaje) {
    $("#dialog_error p").html(mensaje);
    var dialog = $("#dialog_error").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Mensaje de Error</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cerrar",
                "class": "btn btn-xs",
                click: function() {
                    $(this).dialog("close");
                }
            }
        ]
    });
}

function validateUserForm(tipo){
    
    var clave = $("#UserGroupsAccess_1_password").val();
    
    if(lasClavesCoinciden()){
        if(clave.length>=6 || (tipo!="new" && clave.length===0)){
            
            //buscarCedulaAutoridad('V-'+$("#UserGroupsAccess_1_cedula").val());
            
            var phone = $("#UserGroupsAccess_1_telefono").val();
            var mobile = $("#UserGroupsAccess_1_telefono_celular").val();
            
            if(!isValidPhone(phone, "fijo") && phone.length>0){
                displayDialogBox('resultado', 'error', "- El teléfono fijo debe contener el código de área y tener 10 u 11 dígitos. Ej.1: 02563641666. Ej.2: 2563641666.");
                $("html, body").animate({ scrollTop: 0 }, "fast");
                return false;
            }

            if(!isValidPhone(mobile, "movil") && mobile.length>0){
                displayDialogBox('resultado', 'error', "- El teléfono móvil debe contener el código de la operadora y tener 10 u 11 dígitos. Ej.1: 04161234567. Se permiten los códigos 0416, 0426, 0414, 0424 y 0412.");
                $("html, body").animate({ scrollTop: 0 }, "fast");
                return false;
            }
            
            return true;
            
        }
        else{
            displayDialogBox('resultado', 'error', 'Las Claves debe contener al menos 6 caracteres. Puede incluir los caracteres especiales @-#$&+.*^¿?=~.');
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return false;
        }
    }
    else{
        displayDialogBox('resultado', 'error', 'La Clave de Confirmación no coincide con la Clave Nueva Ingresada.');
        $("html, body").animate({ scrollTop: 0 }, "fast");
        return false;
    }
    
}

function lasClavesCoinciden(){
    var clave = $("#UserGroupsAccess_1_password").val();
    var claveConfirm = $("#UserGroupsAccess_1_password_confirm").val();
    return (claveConfirm===clave);
}
