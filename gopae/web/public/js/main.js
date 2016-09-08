var dialog = [];

dialog['error'] = 'errorDialogBox';
dialog['exito'] = 'successDialogBox';
dialog['alerta'] = 'alertDialogBox';
dialog['info'] = 'infoDialogBox';
dialog['success'] = 'successDialogBox';
dialog['alert'] = 'alertDialogBox';
dialog['errorDialogBox'] = 'errorDialogBox';
dialog['successDialogBox'] = 'successDialogBox';
dialog['alertDialogBox'] = 'alertDialogBox';
dialog['infoDialogBox'] = 'infoDialogBox';

var ajaxDataResponse = {response: '', mensaje: '', error: null};
var ajaxestatusCode = 200;
var ajaxDom = {data: '', error: ''};
var ajaxError = { error: ''};
var Loading = null;

function displayHtmlInDivId(divResult, dataHtml, conEfecto) {
    if (conEfecto) {
        var elemento = "#" + divResult;
        elemento = elemento.replace("##", "#");
        $(elemento).html("").html(dataHtml).fadeIn();
    } else {
        var elemento = "#" + divResult;
        elemento = elemento.replace("##", "#");
        $(elemento).html("").html(dataHtml);
    }
}

/**
 *
 * @param string divResult id del div sin el #
 * @param string style error, info, alert
 * @param string mensaje un mensaje
 */
function displayDialogBox(divResult, style, mensaje) {
    var classStyle = dialog[style];
    var dataHtml = "<div class='" + classStyle + "'><button onclick=\"$(this).parent().fadeOut('slow');\" class=\"close\" type=\"button\"><span aria-hidden=\"true\">&times;</span></button><p>" + mensaje + "</p></div>";
    displayHtmlInDivId(divResult, dataHtml);
}

/**
 *
 * @param String divResult id del div sin el #
 * @param String style error, info, alert
 * @param String mensaje un mensaje
 * @returns String
 */
function getDialogBox(style, mensaje) {
    var classStyle = dialog[style];
    var dataHtml = "<div class='" + classStyle + "'><p>" + mensaje + "</p></div>";
    return dataHtml;
}

/**
 * Esta funcion efectúa una petición ajax mediante la funcion $.ajax de jquery con manejo de errores.
 *
 * @param string divResult Indica el string selector jquery por atributo ID (#) donde se mostrará el resultado.
 * @param string urlDir Dirección a donde se efectuará la petición Ajax.
 * @param mixed datos los datos a enviar junto a la petición ajax, puede estar en formato string serializado o en formato json...
 * @param boolean loadingEfect Indica si muestra el efecto de cargando o no.
 * @param boolean showResult Indica si muestra el Resultado de la petición Ajax o no.
 * @param string method POST, GET, entre otros...
 * @param string responseFormat json, html, xml...
 * @param function successCallback function que se ejecutará luego de enviar la petición, se recibe el dataResponse.
 * @param function errorCallback function que se ejecutará si se produce un error
 * @param function beforeSendCallback function que se ejecutará antes de enviar la petición.
 */
function executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback, errorCallback, beforeSendCallback) {

    if (!method) {
        method = "POST";
    }

    if (!responseFormat) {
        responseFormat = "html";
    }

    $.ajax({
        type: method,
        url: urlDir,
        dataType: responseFormat,
        data: datos,
        beforeSend: function() {
            if (loadingEfect) {
                if(undefined !== Loading && Loading !== null && typeof Loading === 'object'){
                    Loading.show();
                }
                var url_image_load = "<div class='padding-5 center'><img title='Su transacci&oacute;n est&aacute; en proceso' src='/public/images/ajax-loader-red.gif'></div>";
                if(responseFormat.toLowerCase()=='html'){
                    displayHtmlInDivId(divResult, url_image_load);
                }
            }
            if (typeof beforeSendCallback == "function" && beforeSendCallback) {
                beforeSendCallback();
            }
        },
        success: function(response, estatusCode, dom) {
            ajaxDataResponse = response;
            ajaxestatusCode = estatusCode;
            ajaxDoom = dom;
            ajaxDataResponse.error = null;
            if (showResult) {
                displayHtmlInDivId(divResult, response, loadingEfect);
            }
            if (typeof beforeSendCallback == "function" && beforeSendCallback) {
                beforeSendCallback(response);
            }
            if (typeof successCallback == "function" && successCallback) {
                successCallback(response, estatusCode, dom);
            }
            if(undefined !== Loading && Loading !== null && typeof Loading === 'object'){
                Loading.hide();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            ajaxDataResponse = {mensaje: '', response: null, error: null};
            ajaxError = xhr;
            ajaxDataResponse.error = xhr;
            ajaxDataResponse.mensaje = '';
            if (xhr.status == '403') {
                ajaxDataResponse.mensaje = "Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.";
            } else if (xhr.status == '404') {
                ajaxDataResponse.mensaje = "ERROR 404: No se ha podido encontrar el recurso solicitado.";
            } else if (xhr.status == '401') {
                ajaxDataResponse.mensaje = "Datos insuficientes para efectuar esta acci&oacute;n.";
            } else if (xhr.status == '400') {
                ajaxDataResponse.mensaje = "Recurso no encontrado. Recargue la P&aacute;gina e intentelo de nuevo.";
            } else if (xhr.status == '500') {
                ajaxDataResponse.mensaje = "Se ha producido un error en el sistema, Comuniquese con el Administrador del Sistema para correcci&oacute;n del m&iacute;smo.";
            } else if (xhr.status == '503') {
                ajaxDataResponse.mensaje = "El servidor web se encuentra fuera de servicio. Comuniquese con el Administrador del Sistema para correcci&oacute;n del error.";
            } else if (xhr.status == '504') {
                ajaxDataResponse.mensaje = "El servidor web ha tardado mucho tiempo en responder por lo que la petición ha sido cancelada. Intente en otro momento.";
            } else if (xhr.status == '302') {
                ajaxDataResponse.mensaje = "El servidor ha intentado redirigirle a una nueva página.";
                if (xhr.redirect) {
                    // data.redirect contains the string URL to redirect to
                    window.location.replace(xhr.redirect);
                }
            }else{
                ajaxDataResponse.mensaje = "Ha ocurrido un error comuniquese con el administrador del sistema.";
            }
            if(undefined !== Loading && Loading !== null && typeof Loading === 'object'){
                Loading.hide();
            }
            displayDialogBox(divResult, "error", ajaxDataResponse.mensaje+" ("+ajaxError.responseText+")");
            if (typeof errorCallback == "function" && errorCallback) {
                errorCallback(xhr, ajaxOptions, thrownError, ajaxDataResponse.mensaje);
            }
        }
    });
}


/**
 * Esta funcion permite restringir los valores ingresados en un elemento (Solo Alfanumericos). Su utilizacion debe ser activada mediante un evento HTML.
 * Ej.: $('#mi_campo').bind('keyup blur', function () {
 * keyAlphaNum(this, true, true);
 * });
 *
 * @param JavascriptElement element Puede Ser un Campo de Texto. Ej.: this
 * @param Boolean with_space Denota si debe o no tener Espacios
 * @param Boolean with_spanhol Denota si debe o no tener SÃ­mbolos o Letras del EspaÃ±ol.
 */
function keyAlphaNum(element, with_space, with_spanhol) {

    if (with_space && with_spanhol) {
        if (element.value.match(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\- ]/g)) {
            element.value = element.value.replace(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\- ]/g, '');
        }
//alert('1.- '+with_space+with_spanhol);
    } else if (with_spanhol) {
        if (element.value.match(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\-]/g)) {
            element.value = element.value.replace(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\-]/g, '');
        }
//alert('2.- '+with_space+with_spanhol);
    } else if (with_space) {
        if (element.value.match(/[^0-9a-zA-Z\- ]/g)) {
            element.value = element.value.replace(/[^0-9a-zA-Z\- ]/g, '');
        }
//alert('3.- '+with_space+with_spanhol);
    } else {
        if (element.value.match(/[^0-9a-zA-Z\-]/g)) {
            element.value = element.value.replace(/[^0-9a-zA-Z\-]/g, '');
        }
//alert('4.- '+with_space+with_spanhol);
    }

}

/**
 * Esta funcion permite restringir los valores ingresados en un elemento (Texto). Su utilizacion debe ser activada mediante un evento HTML.
 * Ej.: $('#mi_campo').bind('keyup blur', function () {
 * keyText(this, true);
 * });
 *
 * @param JavascriptElement element Puede Ser un Campo de Texto. Ej.: this
 * @param Boolean with_spanhol Denota si debe o no tener SÃ­mbolos o Letras del EspaÃ±ol lo que se ingrese mediante teclado en el campo.
 */
function keyText(element, with_spanhol) {
    if (with_spanhol) {
        if (element.value.match(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ(\n)\-.(),;:_ ]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ(\n)\-.(),;:_ ]/g, ''));
        }
    } else {
        if (element.value.match(/[^0-9a-zA-Z(\n)\-.(),;:_ ]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9a-zA-Z(\n)\-.(),;:_ ]/g, ''));
        }
    }
}

/**
 * Esta funcion permite restringir los valores ingresados en un elemento (Texto). Su utilizacion debe ser activada mediante un evento HTML.
 * Ej.: $('#mi_campo').bind('keyup blur', function () {
 * keyText(this, true);
 * });
 *
 * PERMITE ADICIONAL A LOS CARACTERES COMUNES LAS LETRAS Ññ, - (GUION), () Y ACENTOS.
 *
 * @param JavascriptElement element Puede Ser un Campo de Texto. Ej.: this
 * @param Boolean with_spanhol Denota si debe o no tener SÃ­mbolos o Letras del EspaÃ±ol lo que se ingrese mediante teclado en el campo.
 */
function keyTextDash(element, with_spanhol, with_space) {
    if (with_space && with_spanhol) {
        if (element.value.match(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\-()_ ]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\-()_ ]/g, ''));
        }
    } else {
        if (element.value.match(/[^0-9a-zA-Z\-.()_]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9a-zA-Z-()_]/g, ''));

        }
    }
}

function keyAlpha(element, with_spanhol) {
    if (with_spanhol) {
        if (element.value.match(/[^a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\-.(),;: ]/g)) {
            element.value = $.trim(element.value.replace(/[^a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\-.(),;: ]/g, ''));
        }
    } else {
        if (element.value.match(/[^a-zA-Z]/g)) {
            element.value = $.trim(element.value.replace(/[^a-zA-Z]/g, ''));
        }
    }
}

function keyLettersAndSpaces(element, with_spanhol) {
    if (with_spanhol) {
        if (element.value.match(/[^a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\ ]/g)) {
            element.value = $.trim(element.value.replace(/[^a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\ ]/g, ''));
        }
    } else {
        if (element.value.match(/[^a-zA-Z\ ]/g)) {
            element.value = $.trim(element.value.replace(/[^a-zA-Z\ ]/g, ''));
        }
    }
}


function keyHexa(element, with_dash) {
    if (with_dash) {
        if (element.value.match(/[^0-9a-fA-F\-]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9a-fA-F\-]/g, ''));
        }
    } else {
        if (element.value.match(/[^0-9a-fA-F]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9a-fA-F]/g, ''));
        }
    }
}


/**
 * Esta funcion permite restringir los valores ingresados en un elemento (NÃºmeros). Su utilizacion debe ser activada mediante un evento HTML.
 * Ej.: $('#mi_campo').bind('keyup blur', function () {
 * keyNum(this, false);
 * });
 *
 * @param JavascriptElement element Puede Ser un Campo de Texto. Ej.: this
 * @param Boolean with_point Denota si debe o no tener puntos (.) lo que se ingrese mediante teclado en el campo.
 */
function keyNum(element, with_point, negative) {

    if (with_point) {
        if (negative) {
            if (element.value.match(/[^0-9.\-]/g)) {
                element.value = $.trim(element.value.replace(/[^0-9.\-]/g, ''));
            }
        }
        else {
            if (element.value.match(/[^0-9.]/g)) {
                element.value = $.trim(element.value.replace(/[^0-9.]/g, ''));
            }
        }
    } else {
        if (negative) {
            if (element.value.match(/[^0-9\-]/g)) {
                element.value = $.trim(element.value.replace(/[^0-9\-]/g, ''));
            }
        } else {
            if (element.value.match(/[^0-9]/g)) {
                element.value = $.trim(element.value.replace(/[^0-9]/g, ''));
            }
        }
    }
}

/**
 * Esta funcion permite restringir los valores ingresados en un elemento (NÃºmeros). Su utilizacion debe ser activada mediante un evento HTML.
 * Ej.: $('#mi_campo').bind('keyup blur', function () {
 * keyNum(this, false);
 * });
 *
 * @param JavascriptElement element Puede Ser un Campo de Texto. Ej.: this
 * @param Boolean with_point Denota si debe o no tener puntos (.) lo que se ingrese mediante teclado en el campo.
 */
function keyNumCompare(element, with_point) {

    if (with_point) {
        if (element.value.match(/[^0-9.<>=]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9.<>=]/g, ''));
        }
    } else {
        if (element.value.match(/[^0-9<>=]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9<>=]/g, ''));
        }
    }
}


/**
 * Esta funcion permite restringir los valores ingresados en un elemento (Texto). Su utilizacion debe ser activada mediante un evento HTML.
 * Ej.: $('#mi_campo').bind('keyup blur', function () {
 * keyTwitter(this, true);
 * });
 *
 * @param JavascriptElement element Puede Ser un Campo de Texto. Ej.: this
 * @param Boolean with_spanhol Denota si debe o no tener SÃ­mbolos o Letras del EspaÃ±ol lo que se ingrese mediante teclado en el campo.
 */
function keyTwitter(element, with_spanhol) {
    if (with_spanhol) {
        if (element.value.match(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ_@]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ_@]/g, ''));
        }
    } else {
        if (element.value.match(/[^0-9a-zA-Z_@]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9a-zA-Z_@]/g, ''));
        }
    }
}

/**
 * Esta funcion permite restringir los valores ingresados en un elemento (Texto). Su utilizacion debe ser activada mediante un evento HTML.
 * Ej.: $('#mi_campo').bind('keyup blur', function () {
 * keyEmail(this, true);
 * });
 *
 * @param JavascriptElement element Puede Ser un Campo de Texto. Ej.: this
 * @param Boolean with_spanhol Denota si debe o no tener SÃ­mbolos o Letras del EspaÃ±ol lo que se ingrese mediante teclado en el campo.
 */
function keyEmail(element, with_spanhol) {
    if (with_spanhol) {
        if (element.value.match(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\-._@]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ\-._@]/g, ''));
        }
    } else {
        if (element.value.match(/[^0-9a-zA-Z\-._@]/g)) {
            element.value = $.trim(element.value.replace(/[^0-9a-zA-Z\-._@]/g, ''));
        }
    }
}

/**
 * Esta funcion permite restringir los valores ingresados en un elemento (Texto). Su utilizacion debe ser activada mediante un evento HTML.
 * Ej.: $('#mi_campo').bind('keyup blur', function () {
 * keyTextOnly(this);
 * });
 * @param JavascriptElement element Puede Ser un Campo de Texto. Ej.: this
 */
function keyTextOnly(element) {
    if (element.value.match(/[^a-zA-Z_]/g)) {
        element.value = $.trim(element.value.replace(/[^a-zA-Z_]/g, ''));
    }
}

/**
 * Esta función permite limpiar de espacios al inicio o final de los valores ingresados en un campo.
 * Ej.: $('#mi_campo').bind('blur', function () {
 * clearField(this);
 * });
 *
 * @param JavascriptElement element Puede Ser un Campo de Texto. Ej.: this
 */
function clearField(element) {
    element.value = $.trim(element.value);
}

function makeUpper(f) {
    $(f).val($(f).val().toUpperCase());
}

function makeLower(f) {
    $(f).val($(f).val().toLowerCase());
}

function firstUpper(f) {
    $(f).val(ucfirst($(f).val()));
}

function wordsFirstUpper(f) {
    $(f).val(ucwords($(f).val()));
}

function slug(Text) {
    return Text
            .toLowerCase()
            .replace(/ /g, '-')
            .replace(/[^\w-]+/g, '')
            ;
}

function isValidDate(date) {
    var matches = /^(\d{2})[-\/](\d{2})[-\/](\d{4})$/.exec(date);
    if (matches == null)
        return false;
    var d = matches[2];
    var m = matches[1] - 1;
    var y = matches[3];
    var composedDate = new Date(y, m, d);
    return composedDate.getDate() == d &&
            composedDate.getMonth() == m &&
            composedDate.getFullYear() == y;
}


/**
 *
 * @param String phone
 * @param String type
 * @returns {Boolean}
 */
function isValidPhone(phone, type) {

    phone = phone + "";
    phone = phone.trim();

    if (phone.length == 11 || phone.length == 10) {

        if (type == "fijo" || type == "fixed") {

            if (!startWith(phone, "02") && !startWith(phone, "2")) {
                return false;
            } else if (isNaN(phone)) {
                return false;
            }
            else {
                return true;
            }

        } else if (type == 'movil' || type == 'mobile') {

            var movilnet1 = "0416";
            var movilnet2 = "0426";
            var movistar1 = "0414";
            var movistar2 = "0424";
            var digitel1 = "0412";

            if (!startWith(phone, movilnet1) && !startWith(phone, movilnet2) && !startWith(phone, movistar1) && !startWith(phone, movistar2) && startWith(phone, digitel1) && !startWith(phone, movilnet1 * 1) && !startWith(phone, movilnet2 * 1) && !startWith(phone, movistar1 * 1) && !startWith(phone, movistar2 * 1) && startWith(phone, digitel1 * 1)) {
                return false;
            } else if (isNaN(phone)) {
                return false;
            }
            else {
                return true;
            }

        } else {
            return false;
        }

    } else {
        return false;
    }
}


/**
 * Validate email function with regualr expression
 *
 * If email isn't valid then return false
 *
 * @param email
 * @return Boolean
 */
function isValidEmail(email) {

    var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    var valid = emailReg.test(email);

    if (!valid) {
        return false;
    } else {
        return true;
    }

}

function isValidTwitter(twitter) {

    var twitterReg = new RegExp(/(^|[^@\w])@(\w{1,15})\b/);
    var valid = twitterReg.test(twitter);

    if (!valid) {
        return false;
    } else {
        return true;
    }

}

function startWith(subject, search) {

    if (subject.indexOf(search) == 0) {
        return true;
    }

    return false;

}

function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}

function scrollUp(speed) {
    if (speed == null || speed == '' || speed != "fast" || speed != "slow") {
        speed = "fast";
    }
    //console.log(speed);
    $("html, body").animate({scrollTop: 0}, speed);
}

function showNotify(title, message) {
    
    new PNotify({
        title: '<font size="3.5"><strong>'+title+'</strong></font>',
        text: '<p style="text-align: justify">'+message+'</p>',
        icon: 'icon-group',
        animate_speed: 700,
        delay: 5000,
        styling: 'fontawesome',
        animation: {
            'effect_in': 'drop',
            'options_in': {easing: 'easeOutBounce'},
            'effect_out': 'drop',
            'options_out': {easing: 'easeInExpo'}
        }
    });
}

/**
 * 
 * @param string selector Selector de jQuery, por ejemplo: #dialogo.
 * @returns boolean
 */
/**
 * 
 * @param {string} selector Selector de jQuery, por ejemplo: #dialogo.
 * @param {string} icon Nombre de Clase de un ícono de Fontawesome o del Tema de la Aplicación
 * @param {string} title Título de la caja PopUp.
 * @param {string} message Contenido
 * @param {integer} width 
 * @param {integer} height
 * @returns {undefined}
 */
function simpleDialogPopUp(selector, icon, title, message, width, height){
    
    $(selector).html(message);
    
    if(title.length===0){
        title = 'Notificación';
    }
    
    if(icon.length===0){
        icon = 'icon-search';
    }
    
    if(isNaN(height)){
        height = 100;
    }

    if(isNaN(width)){
        width = 600;
    }
    
    $(selector).removeClass('hide').dialog({
        width: width,
        resizable: false,
        modal: true,
        title: "<div class='widget-header'><h5 class='smaller blue'><i class='fa "+icon+"'></i> "+title+" </h5></div>",
        title_html: true,
        buttons: [
            {
                "html": "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                "class": "btn btn-danger btn-xs",
                "id":"btn-dialog-close",
                "click": function() {
                    $(this).dialog("close");
                }
            }
        ],
        close: function() {
            $(selector).html("");
        }
    });
    
}

/**
 * Reset form
 * @returns {undefined}
 */
jQuery.fn.reset = function() {
    $(this).each(function() {
        this.reset();
    });
};

/**
 * Base 64 encode like PHP method
 *
 * @param {type} data
 * @returns {base64_encode.enc|window.unescape|String}
 */
function base64_encode(data) {
    // discuss at: http://phpjs.org/functions/base64_encode/
    // original by: Tyler Akins (http://rumkin.com)
    // improved by: Bayron Guevara
    // improved by: Thunder.m
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Rafał Kukawski (http://kukawski.pl)
    // bugfixed by: Pellentesque Malesuada
    // example 1: base64_encode('Kevin van Zonneveld');
    // returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
    // example 2: base64_encode('a');
    // returns 2: 'YQ=='
    // example 3: base64_encode('✓ à la mode');
    // returns 3: '4pyTIMOgIGxhIG1vZGU='

    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
            ac = 0,
            enc = '',
            tmp_arr = [];

    if (!data) {
        return data;
    }

    data = unescape(encodeURIComponent(data))

    do {
        // pack three octets into four hexets
        o1 = data.charCodeAt(i++);
        o2 = data.charCodeAt(i++);
        o3 = data.charCodeAt(i++);

        bits = o1 << 16 | o2 << 8 | o3;

        h1 = bits >> 18 & 0x3f;
        h2 = bits >> 12 & 0x3f;
        h3 = bits >> 6 & 0x3f;
        h4 = bits & 0x3f;

        // use hexets to index into b64, and append result to encoded string
        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
    } while (i < data.length);

    enc = tmp_arr.join('');

    var r = data.length % 3;

    return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}

/**
 * Base 64 decode like PHP method
 *
 * @param {type} data
 * @returns {unresolved}
 */
function base64_decode(data) {
    // discuss at: http://phpjs.org/functions/base64_decode/
    // original by: Tyler Akins (http://rumkin.com)
    // improved by: Thunder.m
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // input by: Aman Gupta
    // input by: Brett Zamir (http://brett-zamir.me)
    // bugfixed by: Onno Marsman
    // bugfixed by: Pellentesque Malesuada
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
    // returns 1: 'Kevin van Zonneveld'
    // example 2: base64_decode('YQ===');
    // returns 2: 'a'
    // example 3: base64_decode('4pyTIMOgIGxhIG1vZGU=');
    // returns 3: '✓ à la mode'

    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
            ac = 0,
            dec = '',
            tmp_arr = [];

    if (!data) {
        return data;
    }

    data += '';

    do {
        // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));

        bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

        o1 = bits >> 16 & 0xff;
        o2 = bits >> 8 & 0xff;
        o3 = bits & 0xff;

        if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1);
        } else if (h4 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1, o2);
        } else {
            tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
        }
    } while (i < data.length);

    dec = tmp_arr.join('');

    return decodeURIComponent(escape(dec.replace(/\0+$/, '')));
}

function levenshtein(s1, s2) {
  //       discuss at: http://phpjs.org/functions/levenshtein/
  //      original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
  //      bugfixed by: Onno Marsman
  //       revised by: Andrea Giammarchi (http://webreflection.blogspot.com)
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  // reimplemented by: Alexander M Beedie
  //        example 1: levenshtein('Kevin van Zonneveld', 'Kevin van Sommeveld');
  //        returns 1: 3

  if (s1 == s2) {
    return 0;
  }

  var s1_len = s1.length;
  var s2_len = s2.length;
  if (s1_len === 0) {
    return s2_len;
  }
  if (s2_len === 0) {
    return s1_len;
  }

  // BEGIN STATIC
  var split = false;
  try {
    split = !('0')[0];
  } catch (e) {
    split = true; // Earlier IE may not support access by string index
  }
  // END STATIC
  if (split) {
    s1 = s1.split('');
    s2 = s2.split('');
  }

  var v0 = new Array(s1_len + 1);
  var v1 = new Array(s1_len + 1);

  var s1_idx = 0,
    s2_idx = 0,
    cost = 0;
  for (s1_idx = 0; s1_idx < s1_len + 1; s1_idx++) {
    v0[s1_idx] = s1_idx;
  }
  var char_s1 = '',
    char_s2 = '';
  for (s2_idx = 1; s2_idx <= s2_len; s2_idx++) {
    v1[0] = s2_idx;
    char_s2 = s2[s2_idx - 1];

    for (s1_idx = 0; s1_idx < s1_len; s1_idx++) {
      char_s1 = s1[s1_idx];
      cost = (char_s1 == char_s2) ? 0 : 1;
      var m_min = v0[s1_idx + 1] + 1;
      var b = v1[s1_idx] + 1;
      var c = v0[s1_idx] + cost;
      if (b < m_min) {
        m_min = b;
      }
      if (c < m_min) {
        m_min = c;
      }
      v1[s1_idx + 1] = m_min;
    }
    var v_tmp = v0;
    v0 = v1;
    v1 = v_tmp;
  }
  return v0[s1_len];
}

/**
 * 
 * //Example jQuery get cursor position function call
 * $("input[name='username']").getCursorPosition();
 *
 * @returns {Number}
 */
jQuery.fn.getCursorPosition = function() {
    if (this.lengh == 0)
        return -1;
    return $(this).getSelectionStart();
};

/**
 *
 * //Example jQuery set cursor position function call
 * $("input[name='username']").setCursorPosition(5);
 *
 * @param {type} position
 * @returns {jQuery.fn}
 */
jQuery.fn.setCursorPosition = function(position) {
    if (this.lengh == 0)
        return this;
    return $(this).setSelection(position, position);
};

/**
 *
 * //Example jQuery get text selection function call
 * $("input[name='username']").getSelection();
 *
 * @returns {Number}
 */
jQuery.fn.getSelection = function() {
    if (this.lengh == 0)
        return -1;
    var s = $(this).getSelectionStart();
    var e = $(this).getSelectionEnd();
    return this[0].value.substring(s, e);
};

/**
 * 
 * //Example jQuery get text selection start function call
 * $("input[name='username']").getSelectionStart();
 * 
 * @returns {document@call;getElementById.selectionStart|input.selectionStart|document@call;getElementById.value.length|choice.length|Number}
 */
jQuery.fn.getSelectionStart = function() {
    if (this.lengh == 0)
        return -1;
    input = this[0];

    var pos = input.value.length;

    if (input.createTextRange) {
        var r = document.selection.createRange().duplicate();
        r.moveEnd('character', input.value.length);
        if (r.text == '')
            pos = input.value.length;
        pos = input.value.lastIndexOf(r.text);
    } else if (typeof (input.selectionStart) != "undefined")
        pos = input.selectionStart;

    return pos;
};

/**
 *
 * //Example jQuery get text selection end function call
 * $("input[name='username']").getSelectionEnd();
 *
 * @returns {Number|document@call;getElementById.value.length|choice.length|document@call;getElementById.selectionEnd|input.selectionEnd}
 */
jQuery.fn.getSelectionEnd = function() {
    if (this.lengh == 0)
        return -1;
    input = this[0];

    var pos = input.value.length;

    if (input.createTextRange) {
        var r = document.selection.createRange().duplicate();
        r.moveStart('character', -input.value.length);
        if (r.text == '')
            pos = input.value.length;
        pos = input.value.lastIndexOf(r.text);
    } else if (typeof (input.selectionEnd) != "undefined")
        pos = input.selectionEnd;

    return pos;
};

/**
 *
 * //Example jQuery set text selection function call
 * $("input[name='username']").setSelection(4, 20);
 *
 * @param {type} selectionStart
 * @param {type} selectionEnd
 * @returns {jQuery.fn}
 */
jQuery.fn.setSelection = function(selectionStart, selectionEnd) {
    if (this.lengh == 0)
        return this;
    input = this[0];

    if (input.createTextRange) {
        var range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', selectionEnd);
        range.moveStart('character', selectionStart);
        range.select();
    } else if (input.setSelectionRange) {
        input.focus();
        input.setSelectionRange(selectionStart, selectionEnd);
    }

    return this;
};

/**
 * //Example jQuery set text selection function between a range call
 * $('#elem').selectRange(3,5);
 *
 * @param {type} start
 * @param {type} end
 * @returns {jQuery.fn@call;each}
 */
jQuery.fn.selectRange = function(start, end) {
    return this.each(function() {
        if (this.setSelectionRange) {
            this.focus();
            this.setSelectionRange(start, end);
        } else if (this.createTextRange) {
            var range = this.createTextRange();
            range.collapse(true);
            range.moveEnd('character', end);
            range.moveStart('character', start);
            range.select();
        }
    });
};

function isValidOrigen(origen) {
    var origenes = ['V', 'E', 'P'];
    if ($.inArray(origen, origenes) >= 0) { // La función inArray de jQuery te devuelve el índice del array en donde se encuentra el valor buscado
        return true;
    }
    return false;
}

function var_dump(input){
    console.log(input);
}

function achronim(s){ 
    var words, acronym, nextWord, indexWord, index, next;
    words = s.split(' ');
    acronym = "";
    index = 0 ;
    while (index<words.length) {
        nextWord = words[index];
        acronym = acronym + next, indexWord.charAt(0);
        index = index + 1 ;
    }
    return acronym;
}

function ucwords(str) {
  //  discuss at: http://phpjs.org/functions/ucwords/
  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // improved by: Waldo Malqui Silva
  // improved by: Robin
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Onno Marsman
  //    input by: James (http://www.james-bell.co.uk/)
  //   example 1: ucwords('kevin van  zonneveld');
  //   returns 1: 'Kevin Van  Zonneveld'
  //   example 2: ucwords('HELLO WORLD');
  //   returns 2: 'HELLO WORLD'

  return (str + '')
    .replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1) {
      return $1.toUpperCase();
    });
}

function ucfirst(str) {
  //  discuss at: http://phpjs.org/functions/ucfirst/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Onno Marsman
  // improved by: Brett Zamir (http://brett-zamir.me)
  //   example 1: ucfirst('kevin van zonneveld');
  //   returns 1: 'Kevin van zonneveld'

  str += '';
  var f = str.charAt(0)
    .toUpperCase();
  return f + str.substr(1);
}



function htmlentities(e,t,n,r){var i=get_html_translation_table("HTML_ENTITIES",t),s="";e=e==null?"":e+"";if(!i){return false}if(t&&t==="ENT_QUOTES"){i["'"]="&#039;"}if(!!r||r==null){for(s in i){if(i.hasOwnProperty(s)){e=e.split(s).join(i[s])}}}else{e=e.replace(/([\s\S]*?)(&(?:#\d+|#x[\da-f]+|[a-zA-Z][\da-z]*);|$)/g,function(e,t,n){for(s in i){if(i.hasOwnProperty(s)){t=t.split(s).join(i[s])}}return t+n})}return e}

function get_html_translation_table(e,t){var n={},r={},i;var s={},o={};var u={},a={};s[0]="HTML_SPECIALCHARS";s[1]="HTML_ENTITIES";o[0]="ENT_NOQUOTES";o[2]="ENT_COMPAT";o[3]="ENT_QUOTES";u=!isNaN(e)?s[e]:e?e.toUpperCase():"HTML_SPECIALCHARS";a=!isNaN(t)?o[t]:t?t.toUpperCase():"ENT_COMPAT";if(u!=="HTML_SPECIALCHARS"&&u!=="HTML_ENTITIES"){throw new Error("Table: "+u+" not supported")}n["38"]="&";if(u==="HTML_ENTITIES"){n["160"]="&nbsp;";n["161"]="&iexcl;";n["162"]="&cent;";n["163"]="&pound;";n["164"]="&curren;";n["165"]="&yen;";n["166"]="&brvbar;";n["167"]="&sect;";n["168"]="&uml;";n["169"]="&copy;";n["170"]="&ordf;";n["171"]="&laquo;";n["172"]="&not;";n["173"]="&shy;";n["174"]="&reg;";n["175"]="&macr;";n["176"]="&deg;";n["177"]="&plusmn;";n["178"]="&sup2;";n["179"]="&sup3;";n["180"]="&acute;";n["181"]="&micro;";n["182"]="&para;";n["183"]="&middot;";n["184"]="&cedil;";n["185"]="&sup1;";n["186"]="&ordm;";n["187"]="&raquo;";n["188"]="&frac14;";n["189"]="&frac12;";n["190"]="&frac34;";n["191"]="&iquest;";n["192"]="&Agrave;";n["193"]="&Aacute;";n["194"]="&Acirc;";n["195"]="&Atilde;";n["196"]="&Auml;";n["197"]="&Aring;";n["198"]="&AElig;";n["199"]="&Ccedil;";n["200"]="&Egrave;";n["201"]="&Eacute;";n["202"]="&Ecirc;";n["203"]="&Euml;";n["204"]="&Igrave;";n["205"]="&Iacute;";n["206"]="&Icirc;";n["207"]="&Iuml;";n["208"]="&ETH;";n["209"]="&Ntilde;";n["210"]="&Ograve;";n["211"]="&Oacute;";n["212"]="&Ocirc;";n["213"]="&Otilde;";n["214"]="&Ouml;";n["215"]="&times;";n["216"]="&Oslash;";n["217"]="&Ugrave;";n["218"]="&Uacute;";n["219"]="&Ucirc;";n["220"]="&Uuml;";n["221"]="&Yacute;";n["222"]="&THORN;";n["223"]="&szlig;";n["224"]="&agrave;";n["225"]="&aacute;";n["226"]="&acirc;";n["227"]="&atilde;";n["228"]="&auml;";n["229"]="&aring;";n["230"]="&aelig;";n["231"]="&ccedil;";n["232"]="&egrave;";n["233"]="&eacute;";n["234"]="&ecirc;";n["235"]="&euml;";n["236"]="&igrave;";n["237"]="&iacute;";n["238"]="&icirc;";n["239"]="&iuml;";n["240"]="&eth;";n["241"]="&ntilde;";n["242"]="&ograve;";n["243"]="&oacute;";n["244"]="&ocirc;";n["245"]="&otilde;";n["246"]="&ouml;";n["247"]="&divide;";n["248"]="&oslash;";n["249"]="&ugrave;";n["250"]="&uacute;";n["251"]="&ucirc;";n["252"]="&uuml;";n["253"]="&yacute;";n["254"]="&thorn;";n["255"]="&yuml;"}if(a!=="ENT_NOQUOTES"){n["34"]="&quot;"}if(a==="ENT_QUOTES"){n["39"]="&#39;"}n["60"]="&lt;";n["62"]="&gt;";for(i in n){if(n.hasOwnProperty(i)){r[String.fromCharCode(i)]=n[i]}}return r}

String.prototype.capitalize = function() {return this.toLowerCase().charAt(0).toUpperCase() + this.slice(1);};

function containsHtml(str){
    return /<[a-z][\s\S]*>/i.test(str);
}

function getAge(dateString) {
  var today = new Date();
  var birthDate = new Date(dateString);
  var age = today.getFullYear() - birthDate.getFullYear();
  var m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  return age;
}
