function cambiarEstatusEstudiante(id, descripction, accion, inscripcion_id) {

    var accionDes = new String();
    var boton = new String();
    var botonClass = new String();

    $('#confirm-description').html(descripction);
    $("#div-result-message").html('');
    if (accion === 'A') {
        accionDes = 'Incluir';
        boton = "<i class='icon-ok bigger-110'></i>&nbsp; Incluir Estudiante";
        botonClass = 'btn btn-primary btn-xs';
    } else {
        accionDes = 'Excluir';
        boton = "<i class='icon-trash bigger-110'></i>&nbsp; Excluir Estudiante";
        botonClass = 'btn btn-danger btn-xs';
    }

    $(".confirm-action").html(accionDes);

    $("#confirm-status").removeClass('hide').dialog({
        width: 800,
        resizable: false,
        draggable: false,
        modal: true,
        position: ['center', 50],
        title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i> Exclusión de Estudiante </h4></div>",
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
                html: boton,
                "class": botonClass,
                click: function() {

                    var divResult = "div-result-message";
                    var urlDir = "/planteles/matricula/cambiarEstatus/";
                    var datos = {accion: accion, inscripcion_id: inscripcion_id, id: id};
                    var conEfecto = true;
                    var showHTML = true;
                    var method = "POST";
                    var responseFormat = "html";
                    var callback = function() {
                        refrescarGrid();
                    };

                    $("html, body").animate({scrollTop: 0}, "fast");

                    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                    $('#estudiantesInscrit').yiiGridView('update', {
                        data: $(this).serialize()
                    });
                    $(this).dialog("close");

                }
            }

        ]
    });

}
//------ACTUALIZA LA VISTA PPAL. CON LOS NUEVOS ALUMNOS LUEGO DE REGISTRAR------
function refrescarGrid() {
    $('#inscritos-grid').yiiGridView('update', {
        data: $(this).serialize()
    });

}
//* DATOS A PARTIR DE LA CEDULA DE IDENTIDAD  *

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

function buscarCedulaAutoridad(cedula) {

    if (cedula != '' || cedula != null) {
        $.ajax({
            url: "/planteles/matricula/buscarCedulaEstudiante",
            data: {cedula: cedula,
            },
            dataType: 'json',
            type: 'get',
            success: function(resp) {

                if (resp.statusCode === "mensaje") {
                    $('#infoEstudiante').removeClass();
                    $('#infoEstudiante').addClass('alertDialogBox');
                    $('#infoEstudiante p').html(resp.mensaje);
                    $("#cedula").val("");
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

                    if (resp.edad >= 18) {
                        $('#infoEstudiante').removeClass();
                        $('#infoEstudiante').addClass('infoDialogBox');
                        $('#infoEstudiante p').html('Se ha detectado que el estudiante que desea registrar es <b>mayor de edad</b>. Sus datos serán tomados automaticamente como datos de representante.');

                        $("#nombreRepresentante").val("");
                        $("#apellidoRepresentante").val("");
                        $("#cedulaRepresentante").val("");
                        $("#fecha_nacimiento_representante").val("");
                        $("#afinidad").val("");
                        $("#estado_id").val("");
                        $("#telefonoMovil").val("");
                        $("#telefonoLocal").val("");
                        $("#email").val("");

                        $("#nombreRepresentante").attr('readonly', true);
                        $("#apellidoRepresentante").attr('readonly', true);
                        $("#cedulaRepresentante").attr('readonly', true);
                        $("#fecha_nacimiento_representante").attr('readonly', true);
                        $("#afinidad").attr('disabled', true);
                        $("#estado_id").attr('disabled', true);
                        $("#telefonoMovil").attr('readonly', true);
                        $("#telefonoLocal").attr('readonly', true);
                        $("#correo").attr('readonly', true);
                        $("#email").attr('readonly', true);

                        var cedulaTemp = $("#cedula").val().substr(2);
                        $("#cedula_escolar").val(cedulaTemp);

                    } else {
                        $('#infoEstudiante').removeClass();
                        $('#infoEstudiante').addClass('infoDialogBox');
                        $('#infoEstudiante p').html('Se ha detectado que el estudiante que desea registrar es <b>menor de edad</b>.Por lo cual debe registrar los datos del representante.');

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

                    if (resp.error === true) {

                        $('#infoEstudiante').removeClass();
                        $('#infoEstudiante').addClass('alertDialogBox');
                        $('#infoEstudiante').html(resp.mensaje);
                        $("#cedula").val("");
                        $("#Estudiante_nombres").val('');
                        $("#Estudiante_apellidos").val('');
                        $("#cedula_escolar").val('');
                        $("#fecha").val('');
                        $("#cedula").reset();

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
                        $("#cedula").val('');
                        generarCedulaEscolar();


                    }

                    if (resp.bloqueo === true) {


                        $("#Estudiante_nombres").attr('readonly', true);
                        $("#Estudiante_apellidos").attr('readonly', true);

                    }
                    if (resp.bloqueo === false) {

                        // alert('nombres diferentes');
                        $("#Estudiante_nombres").attr('readonly', false);
                        $("#Estudiante_apellidos").attr('readonly', false);

                    }



                    $("#cedulaRepresentante").attr('readonly', false);
                }
                if (resp.statusCode === "error") {
                    $('#infoEstudiante').removeClass();
                    $('#infoEstudiante').addClass('alertDialogBox');
                    $('#infoEstudiante').html(resp.mensaje);

                    $("#cedula").val("");
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
function dialogo_peticion_activa() {
    var dialog = $("#dialog_peticion_activa").removeClass('hide').dialog({
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


function dialog_success(mensaje, id, plantel, individual) {
    $("#dialog_success p").html(mensaje);
    var dialog_success = $("#dialog_success").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-check'></i> Inscripción Exitosa </h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cerrar",
                "class": "btn btn-xs",
                click: function() {
                    $("#dialog_success p").html('');
                    dialog_success.dialog("close");
                    if (individual) {
                        $("#dialog_escolaridad").dialog("close");
                        window.location.reload();
                    }
                    else {
                        window.location.assign("/planteles/seccionPlantel/admin/id/" + plantel);
                    }


                }
            }
        ]

    });
}
//* funcion para la estatura...
function keyDecimal(element, with_point, negative) {

    if (with_point) {
        if (negative) {
            if (element.value.match(/[^0-9.,\-]/g)) {
                element.value = $.trim(element.value.replace(/[^0-9.,\-]/g, ''));
            }
        }
        else {
            if (element.value.match(/[^0-9.,]/g)) {
                element.value = $.trim(element.value.replace(/[^0-9.,]/g, ''));
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

function generarCedulaEscolar() {

    var cedulaRepresentante = $.trim($("#cedulaRepresentante").val());
    var fechaNacimientoEst = $.trim($("#fecha").val());
    var ordenNacimientoEst = $.trim($("#orden_nacimiento").val());
    var cedulaEstudiante = $.trim($("#cedula").val());

    //console.log({cedula: cedulaEstudiante});

    cedulaRepresentante = cedulaRepresentante.substr(2);
    cedulaEstudiante = cedulaEstudiante.substr(2);
    var fechaNacimientoLimpia = $.trim(replaceAll("-", "", fechaNacimientoEst));

    // console.log({cedula: cedulaEstudiante, cedulaCantChar: cedulaEstudiante.length, isNum: (!isNaN(cedulaEstudiante))});


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

function mostrarNotificacion() {
    new PNotify({
        title: '<font size="3.5"><strong>Proceso de Matriculación</strong></font>',
        text: '<p style="text-align: justify">Estimado usuario, esta tarea puede tardar varios minutos. Espere mientras se culmina el proceso.</p>',
        icon: 'icon-group',
        animate_speed: 700,
        delay: 5000,
        styling: 'fontawesome',
        animation: {
            'effect_in': 'drop',
            'options_in': {easing: 'easeOutBounce'},
            'effect_out': 'drop',
            'options_out': {easing: 'easeInExpo'},
        }
    });
}

function calcular_edad(fecha) {
    var fechaActual = new Date();
    var diaActual = fechaActual.getDate();
    var mmActual = fechaActual.getMonth() + 1;
    var yyyyActual = fechaActual.getFullYear();
    FechaNac = fecha.split("/");
    var diaCumple = FechaNac[0];
    var mmCumple = FechaNac[1];
    var yyyyCumple = FechaNac[2];
    //retiramos el primer cero de la izquierda
    if (mmCumple.substr(0, 1) == 0) {
        mmCumple = mmCumple.substring(1, 2);
    }
    //retiramos el primer cero de la izquierda
    if (diaCumple.substr(0, 1) == 0) {
        diaCumple = diaCumple.substring(1, 2);
    }
    var edad = yyyyActual - yyyyCumple;

    //validamos si el mes de cumpleaños es menor al actual
    //o si el mes de cumpleaños es igual al actual
    //y el dia actual es menor al del nacimiento
    //De ser asi, se resta un año
    if ((mmActual < mmCumple) || (mmActual == mmCumple && diaActual < diaCumple)) {
        edad--;
    }
    return edad;
}

$(document).ready(function() {
    $(".tooltipMatricula").tooltip({
        show: {
            effect: "slideDown",
            delay: 250
        }
    });
    $('.change-status').unbind('click');
    $('.change-status').on('click',
            function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                var description = $(this).attr('data-descripcion');
                var accion = $(this).attr('data-action');
                var inscripcion_id = $(this).attr('data-inscripcion_id');
                cambiarEstatusEstudiante(id, description, accion, inscripcion_id);
            }
    );

    $("#linkDialogAyuda").unbind('click');
    $("#linkDialogAyuda").on('click', function() {
        $("html, body").animate({scrollTop: 0}, "fast").ready(function() {
            var dialog = $("#dialogoAyuda").removeClass('hide').dialog({
                modal: true,
                width: '750px',
                draggable: false,
                resizable: false,
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Ayuda</h4></div>",
                title_html: true,
                position: ['center', 50],
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
        });

    });

});


//---FUNCION PARA ADMITIR SOLO LETRAS EN LOS CAMPOS PARA NOMBRE Y APELLIDO-- *mey*

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


