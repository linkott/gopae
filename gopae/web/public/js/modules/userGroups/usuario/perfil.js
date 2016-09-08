$(document).ready(function(){
   
    $("#user-groups-password-form").on('submit', function(evt){
        evt.preventDefault();
        changePassword($(this));
    });
    
    $("#user-groups-contact-form").on('submit', function(evt){
        evt.preventDefault();
        contactData($(this));
    });
    
    $('#UserGroupsUser_twitter').bind('keyup blur', function () {
        keyTwitter(this, false);
    });
    
    $('#UserGroupsUser_email').bind('keyup blur', function () {
        keyEmail(this, false);
    });
    
    $('#UserGroupsUser_telefono').bind('keyup blur', function () {
        keyNum(this, false);
    });
    
    $('#UserGroupsUser_telefono_celular').bind('keyup blur', function () {
        keyNum(this, false);
    });
    
});

function changePassword(form){

    var password_old = $("#UserGroupsUser_old_password").val();
    var password_new = $("#UserGroupsUser_password").val();
    var password_confirm = $("#UserGroupsUser_password_confirm").val();
    var strength = howStrength(password_new);

    var mensaje = '';
    var style = 'error';
    var divResult = 'resultado';

    var error = hasError();

    if(error){
        
        $("html, body").animate({scrollTop: 0}, "fast");
        $("#UserGroupsUser_password").focus();
        
        switch (error){
            case 1:
                mensaje = 'La Clave debe Tener al Menos 6 Caracteres.';
                break;
            case 2:
                mensaje = 'No Coinciden La Clave y su Confirmación.';
                break;
        }

        displayDialogBox(divResult, style, mensaje);

    }else{
         
         if(strength=="Débil"){
             $("#mensaje-confirm").html("<b>Su Clave es Débil.</b><br/><br/>¿Confirma el cambio de clave?");
         }
         else if(password_old==password_new){
             $("#mensaje-confirm").html("<b>Su Clave nueva es igual a la Clave Anterior</b><br/><br/>¿Confirma el cambio de clave?");
         }
         else{
             $("#mensaje-confirm").html("¿Confirma el cambio de clave?");
         }
         
         $("#dialog-passwd").removeClass('hide').dialog({
             width: 400,
             resizable: false,
             modal: true,
             title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-exchange'></i> Cambio de Clave </h4></div>",
             title_html: true,
             buttons: [
                 {
                     html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Cancelar",
                     "class": "btn btn-danger btn-xs",
                     click: function() {
                         $(this).dialog("close");
                     }
                 },
                 {
                     html: "Aceptar &nbsp;<i class='icon-exchange bigger-110'></i>",
                     "class": "btn btn-primary btn-xs",
                     click: function() {
                         
                         var divResult = "resultado";
                         var urlDir = "/perfil";
                         var datos = $("#user-groups-password-form").serialize();
                        var loadingEfect = true;
                        var showResult = true;
                        var method = "POST";
                        var responseFormat = "html";
                        var beforeSend = null;
                         var callback = function(){
                                        $("#UserGroupsUser_old_password").val("");
                                        $("#UserGroupsUser_password").val("");
                                        $("#UserGroupsUser_password_confirm").val("");
                         };
 
                         $("html, body").animate({ scrollTop: 0 }, "fast");

                        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, callback);
                         
                         $(this).dialog("close");
                     }
                 }
             ],
             close: function() {
                 $("#dialog-passwd").addClass("hide");
             }
         });
        
    }

}

function hasError(){

    var password_old = $("#UserGroupsUser_old_password").val();
    var password_new = $("#UserGroupsUser_password").val();
    var password_confirm = $("#UserGroupsUser_password_confirm").val();
    
    /**
     * 0 = Todo Bien
     * 1 = Password debe Tener al Menos 6 Caracteres.
     * 2 = No Coinciden La Clave y su Confirmación.
     */
    var resultado = 0;
    
    if(password_old.length>0 && password_new.length>0 && password_confirm.length>0){
        
        if(password_new.length>=6){
            
            var strength = howStrength(password_new);
        
            if(password_new!=password_confirm){
                
                resultado = 2;
                
            }
            
        }else{
            
            resultado = 1;
            
        }
        
    }
    
    return resultado;

}

function howStrength(pwd) {
    
    var strength = false;
    var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{6,}).*", "g");
    
    if (pwd.length == 0) {
        strength = false;
    } else if (strongRegex.test(pwd)) {
        strength = 'Fuerte';
    } else if (mediumRegex.test(pwd)) {
        strength = 'Media';
    } else {
        strength = 'Débil';
    }
    
    return strength;
}


function contactData(){
    
    var mensaje = '';
    var style = 'error';
    var divResult = 'resultado-contacto';
    
    var hasError = hasErrorContactData();
    
    if(hasError.length>0){
        
        var mensaje = hasError;
        displayDialogBox(divResult, style, mensaje);
        
    }else{
        
        var divResult = "resultado-contacto";
        var urlDir = "/perfil/contacto";
        var datos = $("#user-groups-contact-form").serialize();
        var loadingEfect = true;
        var showResult = true;
        var method = "POST";
        var responseFormat = "html";
        var beforeSend = null;
        var callback = null;

        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, callback);

        
    }
    
    $("html, body").animate({ scrollTop: 0 }, "fast");
    
}

function hasErrorContactData(){
    
    var email = $("#UserGroupsUser_email").val();
    var phone = $("#UserGroupsUser_telefono").val();
    var mobile = $("#UserGroupsUser_telefono_celular").val();
    var twitter = $("#UserGroupsUser_twitter").val();
    
    var resultado = new String("");
    
    if(!isValidPhone(phone, "fijo")){
        resultado = "- El teléfono fijo debe contener el código de área y tener 10 u 11 dígitos. Ej.1: 02563641666. Ej.2: 2563641666.";
    }
    
    if(!isValidPhone(mobile, "movil") && mobile.length>0){
        if(resultado.length>0){
            resultado += "<br/>";
        }
        resultado += "- El teléfono móvil debe contener el código de la operadora y tener 10 u 11 dígitos. Ej.1: 04161234567. Se permiten los códigos 0416, 0426, 0414, 0424 y 0412.";
    }
    
    if(!isValidTwitter(twitter) && twitter.length>0){
        if(resultado.length>0){
            resultado += "<br/>";
        }
        resultado += "- El twitter debe comenzar con el caracter \"@\". Ej.: @miTwitter.";
    }
    
    return resultado;
    
}