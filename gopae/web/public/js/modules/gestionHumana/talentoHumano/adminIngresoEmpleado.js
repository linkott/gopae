

$(document).ready(function(){
    //Llama a la vista del controlador y declara el ID por medio de un campo oculto
    var ingresosId = $("#ingresoEmpleado_idEndoced").val();
    getListaIngresos(ingresosId);
    botones();

    });
    


function botones(){    
    $("#ingreso-empleado-form").on('submit', function(evt){
        evt.preventDefault();
        registroIngresos($(this));
    });
    
    /*AQUI CARGAMOS EL DATE PICKER PARA LAS FECHAS*******/
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $.datepicker.setDefaults($.datepicker.regional = {
        dateFormat: 'yy-mm-dd',
        'showOn': 'focus',
        'showOtherMonths': false,
        'selectOtherMonths': true,
        'changeMonth': true,
        'changeYear': true,
        minDate: new Date(1815, 1, 1),
        maxDate: 'today',
        //yearRange: '2014:2014' 
    });
    $('#IngresoEmpleado_fecha_ingreso').datepicker();
    
}

// 1: Llama a la vista de otro controlador.
function getListaIngresos(empleadoIdEncoded){
    var divResult = "#divDatosLaborales";
    var urlDir = "/gestionHumana/ingreso/admin/id/"+empleadoIdEncoded;
    var datos = $("#TalentoHumano_idEndoced").val();
    var loadingEfect = true;
    var showResult = true;
    var method = "GET";
    var responseFormat = "html";
    var successCallback = function(response){
        //eventButtonsGrid(bancoId);
        botones();
        $("#ingresoEmpleadoBoton").unbind('click');
        $("#ingresoEmpleadoBoton").on('click', function(evt){
            getFormRegistroIngresoEmpleado(empleadoIdEncoded,  base64_decode(datos));
        });
    };
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}



// 2: Llama a la vista del modal.
function getFormRegistroIngresoEmpleado(ingresoIdEncoded, talentoHumanoId){
    var divResult = "#divFormIngresoEmpleadoDialog";
    var urlDir = '/gestionHumana/Ingreso/registro/id/'+ingresoIdEncoded;
    var datos = '';
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "html";
    var successCallback = function(response){
        botones();
        $("#ingresoEmpleado_talento_humano_id").val(talentoHumanoId);
        var dialog = $("#divFormIngresoEmpleadoDialog").removeClass('hide').dialog({
            modal: true,
            width: '900px',
            draggale: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i>Registrar Ingreso</h4></div>",
            title_html: true,
            buttons: [{
                    html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                    "class": "btn btn-xs btn-danger",
                    "id": "botonCancelarIngresoEmpleado",
                    "click": function() {
                        $(this).dialog("close");
                    }
                },
                {
                html: "Guardar &nbsp;<i class='fa fa-save bigger-110'></i>",
                "class": "btn btn-info btn-xs",
                "id": "botonRegistroIngresoEmpleado",
                "click": function() {
                    $("#btnSubmitIngresoEmpleado").click();
                }
            }]
        });
    };
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}



function registroIngresos(form){
    var divResult = "";
    var urlDir = form.attr('action');
    var datos = form.serialize();
    var loadingEfect = false;
    var showResult = false;
    var method = "POST";
    var responseFormat = "json";

    var successCallback = function(response, estatusCode, dom) {

        var mensaje = 'El servidor no ha proporcionado una respuesta con respecto a la operación';
        var status = 400;
        var boxStyle = 'error';

        if (undefined !== response.mensaje) {
            mensaje = response.mensaje;
        }

        if (undefined !== response.status) {
            status = response.status;
        }

        if (status == 200) {
            var ingresosId = response.idIngreso;
            getListaIngresos(ingresosId);
            boxStyle = 'success';
        } else {
            boxStyle = 'error';
        }
        
        
        
        displayDialogBox('#div-result', boxStyle, mensaje);

        $("#botonCancelarRegistroIngresoEmpleado").click();

        $("html, body").animate({scrollTop: 0}, "fast");

    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}


function base64_encode(data) {
  //  discuss at: http://phpjs.org/functions/base64_encode/
  // original by: Tyler Akins (http://rumkin.com)
  // improved by: Bayron Guevara
  // improved by: Thunder.m
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Rafał Kukawski (http://kukawski.pl)
  // bugfixed by: Pellentesque Malesuada
  //   example 1: base64_encode('Kevin van Zonneveld');
  //   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
  //   example 2: base64_encode('a');
  //   returns 2: 'YQ=='

  var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    enc = '',
    tmp_arr = [];

  if (!data) {
    return data;
  }

  do { // pack three octets into four hexets
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

function base64_decode(data) {
  //  discuss at: http://phpjs.org/functions/base64_decode/
  // original by: Tyler Akins (http://rumkin.com)
  // improved by: Thunder.m
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //    input by: Aman Gupta
  //    input by: Brett Zamir (http://brett-zamir.me)
  // bugfixed by: Onno Marsman
  // bugfixed by: Pellentesque Malesuada
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //   example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
  //   returns 1: 'Kevin van Zonneveld'
  //   example 2: base64_decode('YQ===');
  //   returns 2: 'a'

  var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    dec = '',
    tmp_arr = [];

  if (!data) {
    return data;
  }

  data += '';

  do { // unpack four hexets into three octets using index points in b64
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

  return dec.replace(/\0+$/, '');
}
