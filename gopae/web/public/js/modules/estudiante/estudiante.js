$(document).ready(function() {
    $('#Estudiante_nombres').bind('keyup blur', function() {
        makeUpper(this);
        keyAlpha(this, true);
    });
    $('#Estudiante_apellidos').bind('keyup blur', function() {
        makeUpper(this);
        keyAlpha(this, true);
    });
    $('#Estudiante_codigo_plantel').bind('keyup blur', function() {
        makeUpper(this);
    });
    $('#Estudiante_cedula_identidad_representante').bind('keyup blur', function() {
        keyNum(this, false);// true acepta la ñ y para que sea español
    });
    $('#Estudiante_cedula_identidad').bind('keyup blur', function() {
        keyNum(this, false);// true acepta la ñ y para que sea español
    });
    $('#Estudiante_cedula_escolar').bind('keyup blur', function() {
        keyNum(this, false);// true acepta la ñ y para que sea español
    });

    $('#Estudiante_nombres_search').bind('keyup blur', function() {
        makeUpper(this);
        keyAlpha(this, true);
    });
    $('#Estudiante_apellidos_search').bind('keyup blur', function() {
        makeUpper(this);
        keyAlpha(this, true);
    });
    $('#Estudiante_codigo_plantel_search').bind('keyup blur', function() {
        makeUpper(this);
    });
    $('#Estudiante_cedula_identidad_representante_search').bind('keyup blur', function() {
        keyNum(this, false);// true acepta la ñ y para que sea español
    });
    $('#Estudiante_cedula_identidad_search').bind('keyup blur', function() {
        keyNum(this, false);// true acepta la ñ y para que sea español
    });
    $('#Estudiante_cedula_escolar_search').bind('keyup blur', function() {
        keyNum(this, false);// true acepta la ñ y para que sea español
    });
    $('#Estudiante_ingreso_familiar').bind('keyup blur', function() {
        keyNum(this, false);// true acepta la ñ y para que sea español
    });
    $('#Representante_empresa').bind('keyup blur', function() {
        makeUpper(this);
        keyAlphaNum(this, true, true);
    });

    /*VALIDACIONES DEL ESTUIANTE CREAR*/

//    $('#fecha').unbind('click');
//    $('#fecha').unbind('focus');
//    $('#fecha').datepicker();
//    $.datepicker.setDefaults($.datepicker.regional['es']);
//    $.datepicker.setDefaults($.datepicker.regional = {
//        dateFormat: 'dd-mm-yy',
//        'showOn': 'focus',
//        'showOtherMonths': false,
//        'selectOtherMonths': true,
//        'changeMonth': true,
//        'changeYear': true,
//        minDate: new Date(1800, 1, 1),
//        maxDate: 'today',
//        onSelect: function(selected, evnt) {
//            generarCedulaEscolar();
//        }
//    });
    
    /*VALIDACIONES POR REPRESENTANTE (MODIFICAR)*/
    $("#modificar-representante-form").submit(function(evt) {
        evt.preventDefault();
    $.ajax({
        url: "/estudiante/modificar/datos",
        data: $("#modificar-representante-form").serialize(),
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            if (isNaN(resp)) { // si la respuesta son caracteres muestra el error de ingreso
                //document.getElementById("resultado").style.display = "none";
                document.getElementById("resultadoRepresentante").style.display = "block";
                $("#resultadoRepresentante").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");
            } else { //muestra mensaje que guardo
                $("html, body").animate({scrollTop: 0}, "fast");
                $("#resultadoRepresentante").html('');
                $("#resultadoRepresentante").html('<div class="successDialogBox"><p>Datos del representante modificados con éxito.</p></div>');
//                $("#estudianteTab").click();
            }
        }
        });
    });
    /*VALIDACIONES POR ESTUDIANTE (MODIFICAR)*/
    $("#modificar-estudiante-form").submit(function(evt) {
        evt.preventDefault();
    $.ajax({
        url: "/estudiante/modificar/datos",
        data: $("#modificar-estudiante-form").serialize(),
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            if (isNaN(resp)) { // si la respuesta son caracteres muestra el error de ingreso
                //document.getElementById("resultado").style.display = "none";
                document.getElementById("resultadoEstudiante").style.display = "block";
                $("#resultadoEstudiante").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");
            } else { //muestra mensaje que guardo
                $("html, body").animate({scrollTop: 0}, "fast");
                $("#resultadoEstudiante").html('');
//                $("#representanteTab").click();
                $("#resultadoEstudiante").html('<div class="successDialogBox"><p>Datos del estudiante modificados con éxito.</p></div>');
                //$("#historialMedicoTab").click();
            }
        }
        });
    });
    
    /*VALIDACIONES POR REPRESENTANTE*/
    $("#representante-form").submit(function(evt) {
        evt.preventDefault();
    $.ajax({
        url: "/estudiante/crear",
        data: $("#representante-form").serialize(),
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            if (isNaN(resp)) { // si la respuesta son caracteres muestra el error de ingreso
                //document.getElementById("resultado").style.display = "none";
                document.getElementById("resultadoRepresentante").style.display = "block";
                $("#resultadoRepresentante").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");
            } else { //muestra mensaje que guardo
                $("html, body").animate({scrollTop: 0}, "fast");
                $("#resultadoRepresentante").html('');
                $("#resultadoEstudiante").html('<div class="successDialogBox"><p>Los datos ingresados del Estudiante en Representante, han sido actualizados con éxito, si deseas modificar los datos anteriores dale clic en la pestaña Representante y para guardar los cambios clic en Siguiente.</p></div>');
                $("#estudianteTab").click();
            }
        }
        });
    });
    /*VALIDACIONES POR ESTUDIANTE*/
    $("#estudiante-form").submit(function(evt) {
        evt.preventDefault();
    $.ajax({
        url: "/estudiante/crear",
        data: $("#estudiante-form").serialize(),
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            if (isNaN(resp)) { // si la respuesta son caracteres muestra el error de ingreso
                //document.getElementById("resultado").style.display = "none";
                document.getElementById("resultadoEstudiante").style.display = "block";
                $("#resultadoEstudiante").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");
            } else { //muestra mensaje que guardo
                $("html, body").animate({scrollTop: 0}, "fast");
                $("#cedulaRepresentante").val('');
                $("#nombreRepresentante").val('');
                $("#apellidoRepresentante").val('');
                $("#fecha_nacimiento_representante").val('');
                $("#Representante_estado_civil_id").val('');
                $("#Representante_afinidad_id").val('');
                $("#Representante_sexo").val('');
                $("#Representante_nacionalidad").val(1);
                $("#Representante_pais_id").val(248);
                $("#Representante_estado_nac_id").val('');
                $("#Representante_estado_id").val('');
                $("#Representante_municipio_id").val('');
                $("#Representante_parroquia_id").val('');
                $("#Representante_poblacion_id").val('');
                $("#Representante_urbanizacion_id").val('');
                $("#Representante_tipo_via_id").val('');
                $("#queryVia").val('');
                $("#Representante_direccion_dom").val('');
                $("#Representante_telefono_movil").val('');
                $("#Representante_telefono_habitacion").val('');
                $("#Representante_correo").val('');
                $("#Representante_empresa").val('');
                $("#Representante_telefono_empresa").val('');
                $("#Representante_profesion_id").val('');
                
                
                $("#cedulaEstudiante").val('');
                $("#Estudiante_nombres").val('');
                $("#Estudiante_apellidos").val('');
                $("#fecha").val('');
                $("#Estudiante_lateralidad").val('');
                $("#Estudiante_sexo").val('');
                $("#orden_nacimiento").val(''); /* ORDEN DE NACIMIENTO*/
                $("#cedula_escolar").val('');
                $("#Estudiante_estado_civil_id").val('');
                $("#Estudiante_nacionalidad").val(1);
                $("#Estudiante_pais_id").val(248);
                $("#Estudiante_estado_nac_id").val('');
                $("#Estudiante_etnia_id").val('');
                $("#Estudiante_etnia_id").val('');
                $("#Estudiante_estado_id").val('');
                $("#Estudiante_municipio_id").val('');
                $("#Estudiante_parroquia_id").val('');
                $("#Estudiante_poblacion_id").val('');
                $("#Estudiante_urbanizacion_id").val('');
                $("#Estudiante_tipo_via_id").val('');
                $("#query").val('');
                $("#Estudiante_direccion_dom").val('');
                $("#Estudiante_condicion_vivienda_id").val('');
                $("#Estudiante_condicion_infraestructura_id").val('');
                $("#Beca").val('');
                $("#Estudiante_ingreso_familiar").val('');
                $("#Canaima").val('');
                $("#Estudiante_serial_canaima").val('');
                $("#Estudiante_telefono_movil").val('');
                $("#Estudiante_telefono_habitacion").val('');
                $("#Estudiante_correo").val('');
                $("#Estudiante_diversidad_funcional_id").val('');
                $("#Estudiante_tipo_vivienda_id").val('');
                $("#Estudiante_ubicacion_vivienda_id").val('');
                
                $("#representanteTab").click();
                $("#resultadoEstudiante").html('');
                $("#resultadoRepresentante").html('<div class="successDialogBox"><p>Datos registrados con éxito.</p></div>');
                //$("#historialMedicoTab").click();
            }
        }
        });
    });
    /*VALIDACIONES POR HISTORIAL MEDICO*/
    $("#historial-medico-form").submit(function(evt) {
        evt.preventDefault();
    $.ajax({
        url: "/estudiante/crear",
        data: $("#historial-medico-form").serialize(),
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            if (isNaN(resp)) { // si la respuesta son caracteres muestra el error de ingreso
                //document.getElementById("resultado").style.display = "none";
                document.getElementById("resultadoHistorialMedico").style.display = "block";
                $("#resultadoHistorialMedico").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");
            } else { //muestra mensaje que guardo
                $("html, body").animate({scrollTop: 0}, "fast");
                $("#resultadoEstudiante").html('<div class="successDialogBox"><p>Los datos del Historial Medico del Estudiante han sido cargados con éxito, si deseas realizar algún cambio haz clic en Historial Medico seguido del boton Actualizar cambios.</p></div>');
                $("#estudianteTab").click();
            }
        }
        });
    });
    /*VALIDACIONES POR DATOS ANTOPROMETRICOS*/
    $("#datos-antropometricos-form").submit(function(evt) {
        evt.preventDefault();
    $.ajax({
        url: "/estudiante/crear",
        data: $("#datos-antropometricos-form").serialize(),
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            if (isNaN(resp)) { // si la respuesta son caracteres muestra el error de ingreso
                //document.getElementById("resultado").style.display = "none";
                document.getElementById("resultadoDatosAntropometricos").style.display = "block";
                $("#resultadoDatosAntropometricos").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");
            } else { //muestra mensaje que guardo
                $("html, body").animate({scrollTop: 0}, "fast");
                $("#resultadoEstudiante").html('<div class="successDialogBox"><p>Los datos Antropometricos del Estudiante han sido cargados con éxito, si deseas realizar algún cambio haz clic en Datos Antropometricos seguido del boton Actualizar cambios.</p></div>');
                $("#estudianteTab").click();
            }
        }
        });
    });

});

var options, a;
jQuery(function() {
    function log(message) {
        $("<div>").text(message).prependTo("#log");
        $("#log").scrollTop(0);
    }
    var id = "";
    $("#Estudiante_parroquia_id").change(function() {
        if ($("#Estudiante_parroquia_id").val() != "") {
            $('#query').attr('readonly', false);
            id = $("#Estudiante_parroquia_id").val();
            $("#query").autocomplete({
                source: "/estudiante/crear/ViaAutoComplete?id=" + id,
                minLength: 1,
                select: function(event, ui) {
                    log(ui.item ?
                            "Selected: " + ui.item.value + " aka " + ui.item.id :
                            "Nothing selected, input was " + this.value);
                }
            });
        }
        else {
            $('#query').attr('readonly', true);
            $("#query").autocomplete({
                source: "/estudiante/crear/ViaAutoComplete?id=" + id,
                minLength: 1,
                select: function(event, ui) {
                    log(ui.item ?
                            "Selected: " + ui.item.value + " aka " + ui.item.id :
                            "Nothing selected, input was " + this.value);
                }
            });
        }
    });
});

function CedulaFormat(vCedulaName, evento) {
    tecla = getkey(evento);
    vCedulaName.value = vCedulaName.value.toUpperCase();
    vCedulaValue = vCedulaName.value;
    valor = vCedulaValue.substring(2, 12);
    tam = vCedulaValue.length;
    var numeros = '0123456789/';
    var digit;
    var shift;
    var ctrl;
    var alt;
    var escribo = true;
    tam = vCedulaValue.length;

    if (shift && tam > 1) {
        return false;
    }
    for (var s = 0; s < valor.length; s++) {
        digit = valor.substr(s, 1);
        if (numeros.indexOf(digit) < 0) {
            noerror = false;
            break;
        }
    }
    if (escribo) {
        if (tecla == 8 || tecla == 37) {
            if (tam > 2)
                vCedulaName.value = vCedulaValue.substr(0, tam - 1);
            else
                vCedulaName.value = '';
            return false;
        }
        if (tam == 0 && tecla == 69) {
            vCedulaName.value = 'E-';
            return false;
        }
        if (tam == 0 && tecla == 86) {
            vCedulaName.value = 'V-';
            return false;
        }
        else if ((tam == 0 && !(tecla < 14 || tecla == 69 || tecla == 86 || tecla == 46)))
            return false;
        else if ((tam > 1) && !(tecla < 14 || tecla == 16 || tecla == 46 || tecla == 8 || (tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105)))
            return false;
    }
}

function getkey(e) {
    if (window.event) {

        shift = event.shiftKey;
        ctrl = event.ctrlKey;
        alt = event.altKey;
        return window.event.keyCode;
    }
    else if (e) {
        var valor = e.which;
        if (valor > 96 && valor < 123) {
            valor = valor - 32;
        }
        return valor;
    }
    else
        return null;
}


  $("#cedulaEstudiante").bind('change, blur', function() {
         
        var valorCedula = $(this).val();
                        
            if (valorCedula.length > 0) {
                var cedula = valorCedula;
                buscarCedulaEstudiante(cedula);
                //generarCedulaEscolar();
            }
            else {
      
                $("#cedula").val("");
                $("#Estudiante_nombres").val('');
                $("#Estudiante_apellidos").val('');
                $("#cedula_escolar").val('');
                $("#fecha").val('');
                $("#Estudiante_nombres").attr('readonly', false);
                $("#Estudiante_apellidos").attr('readonly', false);
                generarCedulaEscolar();
            }

        });
        
        
function buscarCedulaEstudiante(cedula) {

    if (cedula != '' || cedula != null) {
        $.ajax({
            url: "/estudiante/crear/buscarEstudiante",
            data: {
                cedula: cedula
            },
            dataType: 'json',
            type: 'get',
            success: function(resp) {

                if (resp.statusCode === "mensaje") {
                    dialogo_error(resp.mensaje);
                    $("#cedulaEstudiante").val("");
                    $("#Estudiante_nombres").val('');
                    $("#Estudiante_apellidos").val('');
                    $("#cedula_escolar").val('');
                    $("#fecha").val('');
                    generarCedulaEscolar();
                }
                if (resp.statusCode === "successU") {
                    
                    $("#Estudiante_nombres").val(resp.nombre);
                    $("#Estudiante_apellidos").val(resp.apellido);
                    $("#fecha").val(resp.fecha);
//
//                    if (resp.edad >= 18) {
////                        dialogo_error('<p>Se ha detectado que el estudiante que desea registrar es mayor de edad. Sus datos serán tomados automaticamente como datos de representante.</p>');
////                        var cedulaTemp = $("#cedulaEstudiante").val().substr(2);
////                        $("#cedula_escolar").val(cedulaTemp);
//                    }

                    if (resp.error === true) {
                        dialogo_error(resp.mensaje);
                        $("#cedulaEstudiante").val("");
                        $("#Estudiante_nombres").val('');
                        $("#Estudiante_apellidos").val('');
                        $("#cedula_escolar").val('');
                        $("#fecha").val('');
                        $("#cedula").reset();
                        //generarCedulaEscolar();
                    }
                     if (resp.bloqueo === true) {
//                      $("#Estudiante_nombres").attr('readonly', true);
//                      $("#Estudiante_apellidos").attr('readonly', true);
                    }
                    if (resp.bloqueo === false){
                      alert('nombres diferentes');
                      $("#Estudiante_nombres").attr('readonly', false);
                      $("#Estudiante_apellidos").attr('readonly', false);
                    }

                    $("#cedulaRepresentante").attr('readonly', false);
                }
                if (resp.statusCode === "error") {
                    dialogo_error(resp.mensaje);

                    $("#cedulaEstudiante").val("");
                    $("#Estudiante_nombres").val('');
                    $("#Estudiante_apellidos").val('');
                    $("#cedula_escolar").val('');
                    $("#fecha").val('');

                    $("#nombreRepresentante").attr('readonly', false);
                    $("#apellidoRepresentante").attr('readonly', false);
                    $("#cedulaRepresentante").attr('readonly', false);
                    $("#fecha_nacimiento_representante").attr('readonly', false);
                    $("#afinidad").attr('disabled', false);
                    $("#estado_id").attr('disabled', false);
                    $("#telefonoMovil").attr('readonly', false);
                    $("#telefonoLocal").attr('readonly', false);
                    $("#correo").attr('readonly', false);
                    $("#email").attr('readonly', false);
                }
            }
        });
    }
}


function generarCedulaEscolar() {

    var cedulaRepresentante = $.trim($("#cedulaRepresentante").val());
    var fechaNacimientoEst = $.trim($("#fecha").val());
    var ordenNacimientoEst = $.trim($("#orden_nacimiento").val());
    var cedulaEstudiante = $.trim($("#cedula").val());

    console.log({cedula: cedulaEstudiante});

    cedulaRepresentante = cedulaRepresentante.substr(2);
    cedulaEstudiante = cedulaEstudiante.substr(2);
    var fechaNacimientoLimpia = $.trim(replaceAll("-", "", fechaNacimientoEst));

    console.log({cedula: cedulaEstudiante, cedulaCantChar: cedulaEstudiante.length, isNum: (!isNaN(cedulaEstudiante))});
    
    
    if (cedulaEstudiante.length > 0 && !isNaN(cedulaEstudiante)) {
        $("#cedula_escolar").val(cedulaEstudiante);
    } else if (!isNaN(cedulaRepresentante) && !isNaN(fechaNacimientoLimpia) && ((!isNaN(ordenNacimientoEst) && ordenNacimientoEst <= 8 && ordenNacimientoEst > 0) || ordenNacimientoEst.length == 0)) {
        if (!isNaN(ordenNacimientoEst) && ordenNacimientoEst.length > 0) {
            ordenNacimientoEst = parseInt(ordenNacimientoEst, 10);
        }
        $("#cedula_escolar").val(cedulaRepresentante + fechaNacimientoLimpia + ordenNacimientoEst);
    } else if (cedulaEstudiante.length == 0 && cedulaRepresentante.length == 0 && fechaNacimientoEst.length == 0) {
        $("#cedula_escolar").val("");
    }
    else {
        //dialogo_error('Ha ocurrido un error en el sistema por un dato ingresado por el usuario. Recargue la pagina he intente de nuevo.');
    }

}


function dialogo_error(mensaje) {
    $("#dialog_error p").html(mensaje);
    var dialog = $("#dialog_error").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggable: false,
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


function keyTextOnly(element, with_spanhol) {//
    if (with_spanhol) {
        if (element.value.match(/[^a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ ]/g)) {
            element.value = $.trim(element.value.replace(/[^a-zA-ZáÁéÉíÍóÓúÚñÑäÄëËïÏöÖüÜ ]/g, ''));
        }
    } else {
        if (element.value.match(/[^a-zA-Z ]/g)) {
            element.value = $.trim(element.value.replace(/[^a-zA-Z ]/g, ''));
        }
    }
}


function currencyFormat(fld, milSep, decSep, e) {
    //alert(milSep)
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    //alert(whichCode)
    if (whichCode == 13)
        return true; // Enter
    if (whichCode == 8)
        return true; // Enter
    if (whichCode == 127)
        return true; // Enter
    if (whichCode == 9)
        return true; // Enter
    if (whichCode == 0)
        return true; // Tabulador
    key = String.fromCharCode(whichCode); // Get key value from key code
    if (strCheck.indexOf(key) == -1)
        return false; // Not a valid key
    len = fld.value.length;
    for (i = 0; i < len; i++)
        if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep))
            break;
    aux = '';
    for (; i < len; i++)
        if (strCheck.indexOf(fld.value.charAt(i)) != -1)
            aux += fld.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0)
        fld.value = '';
    if (len == 1)
        fld.value = '0' + decSep + '0' + aux;
    if (len == 2)
        fld.value = '0' + decSep + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += milSep;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        fld.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
            fld.value += aux2.charAt(i);
        fld.value += decSep + aux.substr(len - 2, len);
    }
    return false;
}
