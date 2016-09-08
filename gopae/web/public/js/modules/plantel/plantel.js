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




$(document).ready(function() {
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $.datepicker.setDefaults($.datepicker.regional = {
        dateFormat: 'dd-mm-yy',
        'showOn': 'focus',
        'showOtherMonths': false,
        'selectOtherMonths': true,
        'changeMonth': true,
        'changeYear': true,
        minDate: new Date(1979, 1, 1),
        maxDate: 'today',
        yearRange: '1979:2014' 
    });
    $('#fecha_desde').datepicker();

    $.mask.definitions['~'] = '[+-]';
    $('#Plantel_telefono_fijo').mask('(0299) 999-9999');

    $.mask.definitions['~'] = '[+-]';
    $('#Plantel_telefono_otro').mask('(0299) 999-9999');

    $.mask.definitions['~'] = '[+-]';
    $('#Plantel_nfax').mask('(0299) 999-9999');

    /* validacion cedula */
    $('#UserGroupsUser_cedula').bind('keyup blur', function() {
        clearField(this);
    });
    $('#UserGroupsUser_username').bind('keyup blur', function() {
        keyAlphaNum(this, false);
        clearField(this);
    });
    
    $('#Plantel_longitud').bind('keyup blur', function() {
        keyNum(this, true, true);
    });
    
    $('#Plantel_latitud').bind('keyup blur', function() {
        keyNum(this, true, true);
    });
    
    $("#Plantel_direccion").bind('keyup blur', function() {
        keyText(this, false);
    });
    
});

///// Validaciones del formulario plantel-form //////////////////////////////////
$('#Plantel_cod_estadistico').bind('keyup blur', function() {
    keyNum(this, false);
});

$('#Plantel_cod_estadistico').bind('blur', function() {
    clearField(this);
});

//$('#Plantel_telefono_fijo').bind('keyup blur', function() {
//    keyNum(this, false);
//});
//
//$('#Plantel_telefono_otro').bind('keyup blur', function() {
//    keyNum(this, false);
//});
//
//$('#Plantel_nfax').bind('keyup blur', function() {
//    keyNum(this, false);
//});

$('#Plantel_cod_plantel').bind('keyup blur', function() {
    keyAlphaNum(this, false);
    makeUpper(this);
});

$('#Plantel_cod_plantel').bind('blur', function() {
    clearField(this);
});

$('#Plantel_cod_plantelNer').bind('keyup blur', function() {
    keyAlphaNum(this, false);
});

$('#Plantel_cod_plantelNer').bind('blur', function() {
    clearField(this);
});

$('#UserGroupsUser_telefono').bind('keyup blur', function() {
    keyAlphaNum(this, false);
});

$('#Plantel_codigo_ner').bind('keyup blur', function() {
    if( $('#Plantel_codigo_ner').val().length < 4 && $('#Plantel_codigo_ner').val().length != 0)
        $('#Plantel_codigo_ner').val('NER ');
    keyAlphaNum(this, true);//true si quiero espacios
    makeUpper(this);
});

$('#Plantel_codigo_ner').bind('blur', function() {
    clearField(this);
});

$('#Plantel_nombre').bind('keyup blur', function() {
    keyAlphaNum(this, true);//para que permita espacios en blanco
    makeUpper(this);
});

$('#Plantel_nombre').bind('blur', function() {
    clearField(this);
});


////////////////////////// Fin //////////////////////////////////////////////////
function cerrarPestanasDatosGenerales() {
    //alert('hola');
    document.getElementById("identificacionP").setAttribute("class", "widget-box collapsed");
    document.getElementById("otrosDatosP").setAttribute("class", "widget-box collapsed");
    document.getElementById("datosUbicacionP").setAttribute("class", "widget-box collapsed");
}

///////////////////Guardar registro de la pestaña datos generales/////////////////
$("#plantel-form").submit(function(evt) {

    evt.preventDefault();

    $.ajax({
        url: "index/",
        data: $("#plantel-form").serialize(),
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            if (isNaN(resp)) { // si la respuesta son caracteres muestra el error de ingreso
                document.getElementById("resultado").style.display = "none";
                document.getElementById("resultadoPlantel").style.display = "block";
                $("#resultadoPlantel").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");
            } else { //muestra mensaje que guardo
                window.location.reload();
                document.getElementById("resultado").style.display = "none";
                document.getElementById("guardo").style.display = "block";
                cerrarPestanasDatosGenerales();
                $("html, body").animate({scrollTop: 0}, "fast");
            }

        }
    })
});
///////////////////////Fin de Guardar registro////////////////////////////


//Al hacer click en cualquier lado del formulario devuelve el mensaje inicial
$("#resultadoPlantel").click(function() {
    document.getElementById("guardo").style.display = "none";
    document.getElementById("resultadoPlantel").style.display = "none";
    document.getElementById("resultado").style.display = "block";
});

/////////////////////////////mostrar ner/////////////////////////////////////////
function mostrarNer() {
    if (document.getElementById('ner').checked == true) {
        $("#lblNer span").addClass('required').html('*');
        $("#lblCodNer span").addClass('required').html('*');
        document.getElementById('divCod_plantel').style.display = 'none';
        document.getElementById('divCod_plantelNER').style.display = 'block';
        $("#Plantel_cod_plantel").val('');
        $("#Plantel_codigo_ner").removeAttr('readonly');
        
        $("#Plantel_codigo_ner").val('NER ');
        $("#Plantel_codigo_ner").focus();
    } else {
         $("#lblNer span").removeClass('required').html('');
         $("#lblCodNer span").removeClass('required').html('');
        document.getElementById('divCod_plantel').style.display = 'block';
        document.getElementById('divCod_plantelNER').style.display = 'none';
      //  document.getElementById('divNombreNer').style.display = 'none';
        $("#cod_plantelNer").val('');
        $("#Plantel_codigo_ner").val('');
        $("#Plantel_codigo_ner").attr('readonly', 'true');
      //  $("#cod_plantelNer").attr('disabled', TRUE);
    }
}
///////////////////////////////fin////////////////////////////////////////////////




function agregarProyecto(plantel_id) {
    var proyecto_endogeno_id = $("#proyectos_endogenos").val();

    var data =
            {
                proyecto_endogeno_id: proyecto_endogeno_id,
                plantel_id: plantel_id
            };
    $("#dialog_agregar_proyecto span").html($("#proyectos_endogenos option:selected").text());
    var dialog = $("#dialog_agregar_proyecto").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Agregar Proyecto</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-xs",
                click: function() {
                    $("#proyectos_endogenos").val('');
                    $(this).dialog("close");
                }
            },
            {
                html: "Agregar Proyecto &nbsp; <i class='fa fa-plus icon-on-right bigger-110'></i>",
                "class": "btn btn-primary btn-xs",
                click: function() {
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                   // executeAjax('_formEndogeno', '../../agregarProyecto', data, false, true, 'POST', 'html', null);
                   $.ajax({
                                url: "agregarProyecto",
                                data: data,
                                dataType: 'html',
                                type: 'get',
                                success: function(resp) {
                                    $("#proyectos_endogenos").val('');
                                    $("#dialog_agregar_proyecto").dialog("close");
                                    $("#_formEndogeno").html(resp);
                                }
                            })
                  //  $(this).dialog("close");
                }
            }
        ]
    });

    //$("#widget-endogeno").removeClass('collapsed');

}

function eliminarProyecto(key, plantel_id) {

    var data = {
        id: key,
        plantel_id: plantel_id
    }
    $.ajax({
        url: "quitarProyecto",
        data: data,
        dataType: 'html',
        type: 'get',
        success: function(resp) {
            $("#_formEndogeno").html(resp);
        }
    })
}




//////////////////////Guardar proyectos endogenos//////////////////////////
function guardarEndogeno(plantel_id) {

    //   alert($("#ProyectosEndogenosPlantel_proyectos_endogenos_id").val());

    $.ajax({
        url: "guardarEndogeno",
        data: {id: plantel_id}, 
        dataType: 'html',
        type: 'get',
        success: function(resp) {

            if (isNaN(resp)) { //permite saber si contiene caracteres o numeros
                document.getElementById("resultadoEndogeno").style.display = "none";
                document.getElementById("resultadoPlantelEndogeno").style.display = "block";
                $("#resultadoPlantelEndogeno").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");
            } else {
                document.getElementById("resultadoEndogeno").style.display = "none";
                document.getElementById("guardoEndogeno").style.display = "block";
                document.getElementById("proyectos_endogenos_grid").style.display = "none";
                document.getElementById("desaEndogeno").setAttribute("class", "widget-box");
                $("html, body").animate({scrollTop: 0}, "fast");
            }
        }
    })
}
/////////////////fin///////////////////////////////////////////////////////////

//Al hacer click en cualquier lado del formulario devuelve el mensaje inicial
$("#resultadoPlantelEndogeno").click(function() {
    document.getElementById("guardoEndogeno").style.display = "none";
    document.getElementById("resultadoPlantelEndogeno").style.display = "none";
    document.getElementById("resultadoEndogeno").style.display = "block";
});




////////////////////obtengo los servicios y la calidad para mostrar///////////////

function condicionarServicios(plantel_id) {

    var servicio_id = $("#servicios").val();

    if (servicio_id !== '') {
        $("#servicios").val('');
        $("#servicio_error p").html('');
        $("#servicio_error").hide();
        var dialog = $("#dialog_calidad_servicio").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            draggable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-plus'></i> Calidad del Servicio</h4></div>",
            title_html: true,

            buttons: [
                {
                    text: "Cancelar",
                    "class": "btn btn-xs",
                    click: function() {
                        $("#calidad").val('');
                        $("#fecha_desde").val('');
                        $(this).dialog("close");
                    }
                },
                {
                    text: "Agregar",
                    "class": "btn btn-primary btn-xs",
                    click: function() {
                        var mensaje = '';
                        var error = false;
                        var fecha_desd = $("#fecha_desde").val();
                        var fecha = $("#fecha_fundacion").val();
                        var annio_desd = new Array();
                        annio_desd = fecha_desd.split("-");
                        var annio_desde = annio_desd[2];
                        if ($("#calidad").val() == '') {
                            mensaje = mensaje + "La Calidad del servicio no puede estar vacio <br>";
                            error = true;
                        }
                        if (fecha_desd == '') {
                            mensaje = mensaje + "La Fecha del servicio no puede estar vacio <br>";
                            error = true;
                        }
                        else if (annio_desde < fecha) {
                            mensaje = mensaje + "La Fecha del servicio no puede ser mayor a la fecha de fundación del plantel <br>";
                            error = true;
                        }


                        if (error != true) {
                            var data = {
                                id: servicio_id,
                                plantel_id: plantel_id,
                                calidad: $("#calidad").val(),
                                fecha_desde: $("#fecha_desde").val(),
                            };

                            $.ajax({
                                url: "agregarServicio",
                                data: data,
                                dataType: 'html',
                                type: 'get',
                                success: function(resp) {
                                    $("#calidad").val('');
                                    $("#fecha_desde").val('');
                                    $("#dialog_calidad_servicio").dialog("close");
                                    $("#_formServicio").html(resp);
                                }
                            })
                        } else {
                            document.getElementById("servicio_error").style.display = "block";
                            $("#servicio_error p").html(mensaje);
                            
                        }
                    }
                }
            ]
        });
        $("#dialog-servicio").show();
    }

}
/////////////////////////////////////////////fin//////////////////////////////////



////////////////////////////////////Guardar servicio//////////////////////////////

function guardarServicio(plantel_id) {


    $.ajax({
        url: "guardarServicio",
        data: {plantel_id: plantel_id},
        dataType: 'html',
        type: 'get',
        success: function(resp) {
            if (isNaN(resp)) {
                document.getElementById("resultadoServicio").style.display = "none";
                document.getElementById("resultadoPlantelServicio").style.display = "block";
                $("#resultadoPlantelServicio").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");
            } else {
                document.getElementById("resultadoServicio").style.display = "none";
                document.getElementById("guardoServicio").style.display = "block";
                document.getElementById("servicio-grid").style.display = "none";
                document.getElementById("servicioCalid").setAttribute("class", "widget-box");
                $("html, body").animate({scrollTop: 0}, "fast");

            }
        }
    })
}
///////////////////////////////////////fin////////////////////////////////////////


//Al hacer click en cualquier lado del formulario devuelve el mensaje inicial
$("#resultadoPlantelServicio").click(function() {
    document.getElementById("guardoServicio").style.display = "none";
    document.getElementById("resultadoPlantelServicio").style.display = "none";
    document.getElementById("resultadoServicio").style.display = "block";
});

$("#guardoServicio").click(function() {
    document.getElementById("guardoServicio").style.display = "none";
    document.getElementById("resultadoServicio").style.display = "block";
});

/////////////////////////////Eliminar servicio///////////////////////////////////

function eliminarServicio(key, plantel_id) {

    var data = {
        id: key,
        plantel_id: plantel_id
    }
    $.ajax({
        url: "quitarServicio",
        data: data,
        dataType: 'html',
        type: 'get',
        success: function(resp) {
            $("#_formServicio").html(resp);
        }
    })
}
/////////////////////////////fin/////////////////////////////////////////////////

/////////////////Verificar si existe la cedula en la tabla usergroups_user///////
function buscarCedula(cedula) {

    var plantel_id = $("#plantel_id").val();
    if (cedula != '' || cedula != null) {
        $.ajax({
            url: "buscarCedula",
            data: {cedula: cedula,
                plantel_id: plantel_id},
            dataType: 'json',
            type: 'get',
            success: function(resp) {
                if (resp.statusCode === "mensaje")
                    dialogo_error(resp.mensaje);
                if (resp.statusCode === "successC")
                    mostrarBusquedasCedula(plantel_id, resp.autoridades);
                // agregarCargo
                if (resp.statusCode === "successU")
                    mostrarDialog(resp.nombre, resp.apellido, resp.usuario);
                // agregarUsuario

            }

        });
    }
}
////////////////////////////////////fin//////////////////////////////////////////


//////////////////////////////Guardar nueva autoridad////////////////////////////
function guardarNuevaAutoridad() {

    $.ajax({
        url: "guardarNuevaAutoridad",
        data: $("#plantelAgregarAutoridad-form").serialize(),
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            if (isNaN(resp)) {
                document.getElementById("resultadoAutoridades").style.display = "none";
                document.getElementById("resultadoPlantelAutoridades").style.display = "block";
                $("#resultadoPlantelAutoridades").html(resp);
                $("html, body").animate({scrollTop: 0}, "fast");

            } else {
                document.getElementById("resultadoAutoridades").style.display = "none";
                document.getElementById("guardoAutoridades").style.display = "block";
                document.getElementById("autor").setAttribute("class", "widget-box");
                $("html, body").animate({scrollTop: 0}, "fast");
            }

        }
    });
}///////////////////////////////fin////////////////////////////////////////////////////








function eliminarAutoridad(id) {
    var plantel_id = $("#plantel_id").val();
    var data = {
        id: id,
        plantel_id: plantel_id
    };
    $.ajax({
        url: "eliminarAutoridad",
        data: data,
        dataType: 'html',
        type: 'get',
        success: function(resp) {
            $("#_formAutoridades").html(resp);
        }
    });
}


///////////////si encuentra la cedula muestra ventana para agregar autoridad/////////////

function mostrarBusquedasCedula(plantel_id, autoridades) {

    var cedula = $("#cedula").val();
    if (cedula !== '') {
        $("#cedula").val('');
        var dialog = $("#dialog_cargo").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            draggable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Cargo a Asignar</h4></div>",
            title_html: true,
            buttons: [
                {
                     html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-xs",
                    click: function() {
                        $("#cargo_id").val('');
                        $(this).dialog("close");
                    }
                },
                {
                    html: "Guardar &nbsp; <i class='icon-save icon-on-right bigger-110'></i>",
                    "class": "btn btn-primary btn-xs",
                    click: function() {
                        //  alert($("#cargo_id").val());
                        if ($("#cargo_id").val() !== '') {
                            var data = {
                                cedula: cedula,
                                plantel_id: plantel_id,
                                cargo: $("#cargo_id").val()
                            };
                            // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                            //   executeAjax('_formAutoridades', 'agregarAutoridad', data, false, true, 'get', '');

                            $.ajax({
                                url: "agregarAutoridad",
                                data: data,
                                dataType: 'html',
                                type: 'post',
                                /* success: function(resp) {
                                 //   alert(resp);
                                 console.log(resp);
                                 //   $("#cargo_id").val('');
                                 //  $("#dialog_cargo").dialog("close");
                                 $("#_formAutoridades").html(resp);
                                 //  document.getElementById("botones").style.display = "block";
                                 //  document.getElementById("servicioCalid").setAttribute("class", "widget-box");
                                 }
                                 */
                                success: function(resp, resp2, resp3) {
                                    try {
                                        var json = jQuery.parseJSON(resp3.responseText);
                                        $("#dialog_cargo").dialog("close");
                                        dialogo_error(json.mensaje);
                                    } catch (e) {
                                        $("#cargo_id").val('');
                                        $("#dialog_cargo").dialog("close");
                                        $("#_formAutoridades").html(resp);
                                    }

                                }
                            });
                        }
                        else {
                            $("#autoridad_error").show();
                        }
                    }
                }
            ]
        });
        $("#dialog-autoridades").show();
        //  $("#dialog_cargo").dialog("open");
    }
}
////////////////////////////////////////fin/////////////////////////////////////////////



function guardarAutoridad(plantel_id, autoridades) {

    $.ajax({
        url: "guardarAutoridad",
        data: {plantel_id: plantel_id,
            autoridades: autoridades},
        dataType: 'html',
        type: 'post',
        success: function(resp, resp2, resp3) {
            try {
                var json = jQuery.parseJSON(resp3.responseText);
                $("#dialog_cargo").dialog("close");
                dialogo_error(json.mensaje);
            } catch (e) {
                $("#_formAutoridades").html(resp);
                $("#guardoAutoridades").show();
            }

        }
    });
}





function mostrarDialog(nombre, apellido, usuario) {
    var cedula = $("#cedula").val();
    var plantel_id = $("#plantel_id").val();
    $("#UserGroupsUser_nombre").val(nombre);
    $("#UserGroupsUser_apellido").val(apellido);
    $("#UserGroupsUser_cedula").val(cedula);
    $("#UserGroupsUser_username").val(usuario);
    $("#UserGroupsUser_cedula").attr('readOnly', true);
    $("#UserGroupsUser_username").attr('readOnly', true);
    var dialogAutoridad = $("#agregarAutoridad").removeClass('hide').dialog({
        modal: true,
        width: '850px',
        height: '490',
        draggable: false,
        resizable: true,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Agregar Usuario</h4></div>",
        title_html: true,
        buttons: [
            {
                 html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-xs",
                click: function() {
                    $("#cargo_id").val('');
                    $("#UserGroupsUser_cedula").val('');
                    $("#UserGroupsUser_username").val('');
                    $("#UserGroupsUser_nombre").val('');
                    $("#UserGroupsUser_apellido").val('');
                    $("#UserGroupsUser_email").val('');
                    $('#UserGroupsUser_telefono').val('');
                    $("#errorSummaryA p").html('');
                    $("#errorSummaryA").hide();
                    dialogAutoridad.dialog("close");

                }
            },
            {
                html: "Guardar &nbsp; <i class='icon-save icon-on-right bigger-110'></i>",
                "class": "btn btn-primary btn-xs",
                click: function() {

                    $.ajax({
                        url: "guardarNuevaAutoridad",
                        data: $("#plantelAgregarAutoridad-form").serialize(),
                        dataType: 'html',
                        type: 'post',
                        success: function(resp, resp1, resp3) {

                            try {
                                var json = jQuery.parseJSON(resp3.responseText);
                                if (json.statusCode === "mensajeError") {

                                    $("#errorSummaryA p").html(json.mensaje);
                                    $("#errorSummaryA").show();
                                }
                            } catch (e) {
                                $("#errorSummaryA p").html('');
                                $("#errorSummaryA").hide();
                                $("#cargo_id").val('');
                                $("#UserGroupsUser_cedula").val('');
                                $("#UserGroupsUser_username").val('');
                                $("#UserGroupsUser_nombre").val('');
                                $("#UserGroupsUser_apellido").val('');
                                $("#UserGroupsUser_email").val('');
                                $('#UserGroupsUser_telefono').val('');
                                dialogAutoridad.dialog("close");

                                /* Nuevo Dialogo Confirmar Registro NUEVO */
                                $("#dialog_success p").html("Usuario Registrado exitosamente, esta en la cola para su activaci&oacute;n");
                                var dialog_success = $("#dialog_success").removeClass('hide').dialog({
                                    modal: true,
                                    width: '450px',
                                    draggable: false,
                                    resizable: false,
                                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Registro Exitoso</h4></div>",
                                    title_html: true,
                                    buttons: [
                                        {
                                            html: "<i class='icon-remove bigger-110'></i>&nbsp; Cerrar",
                                            "class": "btn btn-xs",
                                            click: function() {
                                                $("#dialog_success p").html('');
                                                dialog_success.dialog("close");
                                            }
                                        }
                                    ]
                                });

                                // renderizar cambios
                                $("#_formAutoridades").html(resp);

                            }

                        }
                        /* success: function(resp) {
                         
                         
                         $("html, body").animate({scrollTop: 0}, "fast")
                         $("#errorSummary").html(resp);
                         //  $("#cargo_id").val('');
                         // $("#dialog_cargo").dialog("close");
                         //  $("#_formAutoridades").html(resp);
                         //  document.getElementById("botones").style.display = "block";
                         // document.getElementById("servicioCalid").setAttribute("class", "widget-box");
                         }
                         */
                    });
                }
            }
        ]
    });
}
//$("#dialog_agregarAutoridad").show();

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