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
/* Se usan en Modificar Plantel */
function mostrarNer() {
    if (document.getElementById('ner').checked == true) {
        document.getElementById('divCod_plantel').style.display = 'none';
        document.getElementById('divCod_plantelNER').style.display = 'block';
        document.getElementById('divNombreNer').style.display = 'block';
        $("#Plantel_cod_plantel").val('');
        $("#Plantel_cod_plantel").attr('disable', 'disable');
    } else {
        document.getElementById('divCod_plantel').style.display = 'block';
        document.getElementById('divCod_plantelNER').style.display = 'none';
        document.getElementById('divNombreNer').style.display = 'none';
        $("#cod_plantelNer").val('');
        $("#cod_plantelNer").attr('disable', 'disable');
    }
}
function agregarProyecto() {
    var proyecto_endogeno_id = $("#proyectos_endogenos").val();
    var plantel_id = $("#plantel_id").val();
    var data =
            {
                proyecto_endogeno_id: proyecto_endogeno_id,
                plantel_id: plantel_id
            };
    $("#dialog_agregar_proyecto span").html($("#proyectos_endogenos option:selected").text());
    var dialog = $("#dialog_agregar_proyecto").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Agregar Proyecto</h4></div>",
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
                html: "Agregar Proyecto &nbsp; <i class='fa fa-plus icon-on-right bigger-110'></i>",
                "class": "btn btn-primary btn-xs",
                click: function() {
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                    executeAjax('_formEndogeno', 'agregarProyecto', data, false, true, 'GET', 'html');

                    $(this).dialog("close");
                }
            }
        ]
    });

    //$("#widget-endogeno").removeClass('collapsed');

}
function eliminarProyecto(proyecto_endogeno_id) {
    var plantel_id = $("#plantel_id").val();
    var data =
            {
                proyecto_endogeno_id: proyecto_endogeno_id,
                plantel_id: plantel_id,
            };
    var dialog = $("#dialog_eliminar_proyecto").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Proyecto</h4></div>",
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
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Proyecto",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                    executeAjax('_formEndogeno', 'eliminarProyecto', data, false, true, 'GET', 'html');
                    $(this).dialog("close");
                }
            }
        ]
    });


}
function condicionarServicios() {

    $("#calidad").val('');
    $("#fecha_desde").val('');
    $("#servicio_error").addClass('hide');
    var servicio_id = $("#servicios").val();

    if (servicio_id !== '') {
        $("#servicios").val('');
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

                        $(this).dialog("close");
                    }
                },
                {
                    html: "Guardar &nbsp; <i class='icon-save icon-on-right bigger-110'></i>",
                    "class": "btn btn-primary btn-xs",
                    click: function() {
                        var mensaje = '', error = false;
                        if ($("#calidad").val() === '') {
                            mensaje = "Debe seleccionar la calidad del servicio <br>";
                            error = true;
                        }
                        if ($("#fecha_desde").val() === '') {
                            mensaje = mensaje + "Debe seleccionar la fecha desde que se esta prestando este servicio <br>";
                            error = true;
                        }
                        if (!error) {
                            var data = {
                                id: servicio_id,
                                calidad: $("#calidad").val(),
                                fecha_desde: $("#fecha_desde").val(),
                                plantel_id: $("#plantel_id").val()
                            };
                            // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                            executeAjax('_formServicio', 'agregarServicio', data, true, true, 'GET', 'html');
                            $("#servicios").val('');
                            $(this).dialog("close");
                        }
                        else {
                            $("#servicio_error p").html(mensaje);
                            $("#servicio_error").removeClass('hide');
                        }
                    }
                }
            ]
        });
    }
}
function eliminarServicio(id) {
    var dialog = $("#dialog_eliminar_servicio").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Servicio</h4></div>",
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
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Servicio",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    var data = {
                        id: id,
                        plantel_id: $("#plantel_id").val()
                    };
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                    executeAjax('_formServicio', 'eliminarServicio', data, true, true, 'GET', 'html');
                    $(this).dialog("close");
                }
            }
        ]
    });
}
function actualizarServicio(servicio_id) {
    $("#servicios").val('');
    $("#calidadMod").val('');
    $("#fecha_desdeMod").val('');
    $("#servicio_errorMod").addClass('hide');
    var dialog = $("#dialog_modificar_servicio").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-plus'></i> Actualizar Servicio</h4></div>",
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
                html: "Actualizar &nbsp; <i class='icon-save icon-on-right bigger-110'></i>",
                "class": "btn btn-primary btn-xs",
                click: function() {
                    var mensaje = '', error = false;
                    if ($("#calidadMod").val() === '') {
                        mensaje = "Debe seleccionar la calidad del servicio <br>";
                        error = true;
                    }
                    if ($("#fecha_desdeMod").val() === '') {
                        mensaje = mensaje + "Debe seleccionar la fecha desde que se esta prestando este servicio <br>";
                        error = true;
                    }
                    if (!error) {
                        var data = {
                            id: servicio_id,
                            calidad: $("#calidadMod").val(),
                            fecha_desde: $("#fecha_desdeMod").val(),
                            plantel_id: $("#plantel_id").val()
                        };
                        // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                        executeAjax('_formServicio', 'actualizarServicio', data, true, true, 'GET', 'html');
                        $(this).dialog("close");
                    }
                    else {
                        $("#servicio_errorMod p").html(mensaje);
                        $("#servicio_errorMod").removeClass('hide');
                    }
                }
            }
        ]
    });
}
/* Se usan en Modificar Plantel */
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
function buscarCedulaAutoridad(cedula) {
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
function guardarNuevaAutoridad() {

    $.ajax({
        url: "guardarNuevaAutoridad",
        data: $("#plantelAgregarAutoridad-form").serialize(),
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            alert(resp);
            if (isNaN(resp)) {
                alert(resp);
                document.getElementById("resultadoAutoridades").style.display = "none";
                document.getElementById("resultadoPlantelAutoridades").style.display = "block";
                $("#resultadoPlantelAutoridades").html(resp);

            } else {
                alert('guardo');
                //  window.location.reload();
                document.getElementById("resultadoAutoridades").style.display = "none";
                document.getElementById("guardoAutoridades").style.display = "block";
                document.getElementById("autor").setAttribute("class", "widget-box");
            }

        }
    });
}///////////////////////////////fin////////////////////////////////////////////////////
///////////////si encuentra la cedula muestra ventana para agregar autoridad/////////////

function mostrarBusquedasCedula(plantel_id, autoridades) {

    var cedula = $("#cedula").val();
    if (cedula !== '') {
        $("#cedula").val('');
        var dialog = $("#dialog_cargo").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Cargo a Asignar</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-xs",
                    click: function() {
                        $("#cargo_id_c").val('');
                        $(this).dialog("close");
                    }
                },
                {
                    html: "Guardar &nbsp; <i class='icon-save icon-on-right bigger-110'></i>",
                    "class": "btn btn-primary btn-xs",
                    click: function() {
                        if ($("#cargo_id_c").val() !== '') {
                            var data = {
                                cedula: cedula,
                                plantel_id: plantel_id,
                                cargo: $("#cargo_id_c").val()
                                        // key: key
                            };
                            // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                            //   executeAjax('_formAutoridades', 'agregarAutoridad', data, false, true, 'GET', 'html');

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
                                        $("#cargo_id_c").val('');
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
//alert(plantel_id);
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
        dragable: false,
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
                                    dragable: false,
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


$(document).ready(function() {
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $.datepicker.setDefaults($.datepicker.regional = {
        dateFormat: 'yy-mm-dd',
        'showOn': 'focus',
        'showOtherMonths': false,
        'selectOtherMonths': true,
        'changeMonth': true,
        'changeYear': true,
        minDate: new Date(1999, 1, 1),
        maxDate: 'today'
    });
    $('#fecha_desde').datepicker();
    $('#fecha_desdeMod').datepicker();
    /* validacion cedula */
    $('#UserGroupsUser_cedula').bind('keyup blur', function() {
        //   keyNum(this, false);
        clearField(this);
        //$('#UserGroupsUser_username').val($(this).val());
    });


    $("#plantelMod-form").submit(function(evt) {
        evt.preventDefault();
        $.ajax({
            url: "actualizarDatosGenerales",
            data: $("#plantelMod-form").serialize(),
            dataType: 'html',
            type: 'post',
            success: function(resp) {
                if (isNaN(resp)) {
                    //document.getElementById("resultado").style.display = "none";
                    document.getElementById("resultadoPlantel").style.display = "block";
                    $("html, body").animate({scrollTop: 0}, "fast");
                    $("#resultadoPlantel").html(resp);

                } else {
                    window.location.reload();
                    //document.getElementById("resultado").style.display = "none";
                    //   document.getElementById("success").setAttribute("class","successDialogBox");
                    document.getElementById("guardo").style.display = "block";
                }

            }
        });
    });

    $(".change-data").unbind('click');
    $(".change-data").click(function() {

        usuario_id = $(this).attr('data-id');
        plantel_id = $("#plantel_id").val();
        data = {
            usuario_id: usuario_id,
            plantel_id: plantel_id
        };
        executeAjax('datosAutoridad', 'buscarAutoridad', data, true, true, 'GET', 'html');

        $("#datosAutoridad").removeClass('hide').dialog({
            modal: true,
            width: '800px',
            draggable: false,
            resizable: false,
            position: ['center', 50],
            title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-user'></i> Datos de la Autoridad del Plantel</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        $(this).dialog("close");
                        $("#datosAutoridad").html('').addClass('hide');
                    }
                },
                {
                    html: "Actualizar Datos <i class='icon-save bigger-110'></i>",
                    "class": "btn btn-primary btn-xs",
                    click: function() {

                        var divResult = "resultado-cambio-datos";
                        var divResultAjaxCallback = "_formAutoridades";
                        var mensaje = "";

                        var email = $("#email").val();
                        var emailBackup = $("#emailBackup").val();

                        var telf_fijo = $("#telf_fijo").val();
                        var telf_fijoBackup = $("#telf_fijoBackup").val();

                        var telf_cel = $("#telf_cel").val();
                        var telf_celBackup = $("#telf_celBackup").val();

//                        var cargo_id = $("#cargo_id_autoridad option:selected").val();
//                        var cargo_idBackup = $("#cargo_idBackup").val();

                        var usuario_id = $("#usuario_id").val();
                        var plantel_id = $("#plantel_id").val();

                        if (plantel_id.length > 0 && usuario_id.length > 0) {

                            $("#resultado-cambio-datos").html('');

//                            if (emailBackup != email || telf_fijo != telf_fijoBackup || telf_cel != telf_celBackup || cargo_id != cargo_idBackup) {
                            if (emailBackup != email || telf_fijo != telf_fijoBackup || telf_cel != telf_celBackup) {
                                if (telf_cel != telf_celBackup && (!isValidPhone(telf_cel, 'movil') || telf_cel.length != 11)) {
                                    mensaje = "El teléfono celular no posee el formato correcto <br>";
                                    $("#telf_cel").val(telf_celBackup);

                                }
                                if (telf_fijo != telf_fijoBackup && (!isValidPhone(telf_fijo, 'fijo') || telf_fijo.length != 11)) {
                                    mensaje = mensaje + "El teléfono fijo no posee el formato correcto <br>";
                                    $("#telf_fijo").val(telf_fijoBackup);
                                }
                                if (emailBackup != email && (!isValidEmail(email) || email.length < 3)) {
                                    mensaje = mensaje + "El correo electrónico no posee el formato correcto <br>";
                                    $("#email").val(emailBackup);
                                }
//                                if (cargo_id != cargo_idBackup && (!$.isNumeric(cargo_id) || cargo_id == "")) {
//                                    mensaje = mensaje + "El cargo seleccionado es invalido <br>";
//                                    $("#cargo_id").val(cargo_idBackup);
//                                }

                                if (mensaje == "") {
                                    var datos = $("#form-autoridad-plantel").serialize();
                                    var datosAjaxCallback = {plantel_id: plantel_id};
                                    var urlDir = "/planteles/modificar/actualizarDatosAutoridad";
                                    var urlDirAjaxCallback = "/planteles/modificar/getAutoridadPlantel";
                                    var conEfecto = true;
                                    var showHTML = true;
                                    var method = "POST";
                                    var responseFormat = "html";
                                    var callback = function() {
                                        $("#emailBackup").val($("#email").val());
                                        executeAjax(divResultAjaxCallback, urlDirAjaxCallback, datosAjaxCallback, conEfecto, showHTML, 'GET');
                                    };

                                    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                }
                                else {
                                    displayDialogBox(divResult, 'error', mensaje);
                                }
                            }

                        }
                        else {

                            displayDialogBox(divResult, 'error', 'No se ha podido identificar al usuario al que desea actualizar los datos. Recargue la página e intenetelo de nuevo.');

                        }

                    }
                },
                {
                    html: "Resetear Clave <i class='icon-key bigger-110'></i>",
                    "class": "btn btn-success btn-xs",
                    click: function() {

                        //Cambiar el Correo
                        var divResult = "resultado-cambio-datos";

                        var email = $("#email").val();
                        var emailBackup = $("#emailBackup").val();
                        var usuario_id = $("#usuario_id").val();

                        if (usuario_id.length > 0) {

                            var datos = {id: usuario_id, plantel_id: plantel_id, email: email};
                            var urlDir = "/control/autoridadesZona/resetearClave";
                            var conEfecto = true;
                            var showHTML = true;
                            var method = "POST";
                            var responseFormat = "html";
                            var callback = null;

                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                        }
                        else {

                            displayDialogBox(divResult, 'error', 'No se ha podido identificar al usuario al que desea modificar el correo. Recargue la página e intenetelo de nuevo.');

                        }

                    }
                }
            ]
        });

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

//$('#Plantel_telefono_fijo').bind('keyup blur', function() {
//    keyNum(this, false);
//});

//$('#Plantel_telefono_otro').bind('keyup blur', function() {
//    keyNum(this, false);
//});

$('#Plantel_nfax').bind('keyup blur', function() {
    keyNum(this, false);
});

$('#Plantel_cod_plantel').bind('keyup blur', function() {
    keyAlphaNum(this, false);
});

$('#cod_plantelNer').bind('keyup blur', function() {
    keyAlphaNum(this, false);
});
$('#UserGroupsUser_telefono').bind('keyup blur', function() {
    keyNum(this, false);
});
$('#UserGroupsUser_nombre').bind('keyup blur', function() {
    keyAlphaNum(this, true);
});
$('#UserGroupsUser_apellido').bind('keyup blur', function() {
    keyAlphaNum(this, true);
});
/*$('#cedula').bind('keypress', function(e) {
 CedulaFormat(this, e);
 });
 */


////////////////////////// Fin //////////////////////////////////////////////////


$("#_formAutoridades").click(function() {
    document.getElementById("guardoAutoridades").style.display = "none";
    document.getElementById("resultadoPlantelAutoridades").style.display = "none";
    document.getElementById("resultadoAutoridades").style.display = "block";
});






