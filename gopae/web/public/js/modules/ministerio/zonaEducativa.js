$('#cedula').tooltip({
    show: {
        effect: "slideDown",
        delay: 250
    }
});

$(document).ready(function() {

    asignAllEvents();
    asignEventsCgridView();
    
});

function asignAllEvents() {
    
    $('#UserGroupsUser_telefono').unbind('keyup blur');
    $('#UserGroupsUser_telefono').bind('keyup blur', function() {
        keyNum(this, false);
        clearField(this);
    });

    $('#UserGroupsUser_telefono_celular').unbind('keyup blur');
    $('#UserGroupsUser_telefono_celular').bind('keyup blur', function() {
        keyNum(this, false);
        clearField(this);
    });
    
    $('#UserGroupsUser_email').unbind('keyup blur');
    $('#UserGroupsUser_email').bind('keyup blur', function() {
        keyEmail(this, false);
        clearField(this);
    });
    
    $('#UserGroupsUser_nombre').bind('keyup blur');
    $('#UserGroupsUser_nombre').bind('keyup blur', function() {
        keyText(this, false);
    });

    $('#UserGroupsUser_nombre').bind('blur', function() {
        clearField(this);
    });
    
    $('#UserGroupsUser_apellido').bind('keyup blur');
    $('#UserGroupsUser_apellido').bind('keyup blur', function() {
        keyText(this, false);
    });

    $('#UserGroupsUser_apellido').bind('blur', function() {
        clearField(this);
    });
    
    $("#zonaAutoridades-form").unbind('submit');
    $("#zonaAutoridades-form").on('submit', function(evt) {
        evt.preventDefault();
        var cedula = $.trim($("#cedula").val());
        var zonaId = $("#zona_id").val();
        var tam = cedula.length;
        var mensaje = "Estimado usuario, el formato de la Cedula de Identidad no es el correcto";
        if (tam > 3 && tam <= 11 && !isNaN(zonaId)) {
            buscarCedulaAutoridad(cedula, zonaId);
        }
        else if (isNaN(zonaId)) {
            mensaje = "Estimado usuario, no se han podido obtener los datos necesarios para efectuar la operación, recargue la página e inténtelo de nuevo.";
            dialogo_error(mensaje);
        }
        else {
            dialogo_error(mensaje);
        }
    });
    
    $('#UserGroupsUser_cedula').unbind('keyup blur');
    $('#UserGroupsUser_cedula').bind('keyup blur', function() {
        keyText(this, true, true);
        clearField(this);
        //$('#UserGroupsUser_username').val($(this).val());
    });
    
    $('#ZonaEducativa_nombre').unbind('keyup blur');
    $('#ZonaEducativa_nombre').bind('keyup blur', function() {
        keyText(this, true, true);
        makeUpper(this);
    });
    
    $("#zona-educativa-form").unbind('submit');
    $("#zona-educativa-form").submit(function(evt) {
        evt.preventDefault();
        $.ajax({
            url: "/ministerio/zonaEducativa/actualizarDatosGenerales",
            data: $("#zona-educativa-form").serialize(),
            dataType: 'html',
            type: 'post',
            success: function(resp) {
                if (isNaN(resp)) {
                    //document.getElementById("resultado").style.display = "none";
                    document.getElementById("resultadoZona").style.display = "block";
                    $("html, body").animate({scrollTop: 0}, "fast");
                    //alert(resp);
                    $("#resultadoZona").html(resp);

                } else {
                    //document.getElementById("resultado").style.display = "none";
                    //   document.getElementById("success").setAttribute("class","successDialogBox");
                    document.getElementById("guardo").style.display = "block";
                }

            }
        });
    });

    $("#Zona_direccion").unbind('keyup blur');
    $("#Zona_direccion").bind('keyup blur', function() {
        keyText(this, false);
    });
    
    $("#correo").unbind('keyup blur');
    $("#correo").bind('keyup blur', function() {
        keyEmail(this, false);
        makeLower(this);
        isValidEmail(this);
    });
    
    $("#nombre").unbind('keyup blur');
    $("#nombre").bind('keyup blur', function() {
        keyAlpha(this, false);
        makeUpper(this);
    });

}

function asignEventsCgridView(){
    //console.log("eventosZonaEducativa.js");
    $(".change-data").unbind('click');
    $(".change-data").click(function() {

        var usuario_id = $(this).attr('data-id');
        var zona_id = $("#zona_id").val();
        var data = {
            usuario_id: usuario_id,
            zona_id: zona_id
        };

        executeAjax('datosAutoridad', '/ministerio/zonaEducativa/buscarAutoridad', data, true, true, 'GET', 'html');

        $("#datosAutoridad").removeClass('hide').dialog({
            modal: true,
            width: '800px',
            draggable: false,
            resizable: false,
            position: ['center', 50],
            title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-user'></i> Datos de la Autoridad de la Zona Educativa</h4></div>",
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
                    id: "btnActualizarDatosAutoridadZona",
                    click: function() {
                        var divResult = "#resultado-cambio-datos";
                        var divResultAjaxCallback = "_formAutoridades";
                        var mensaje = "";

                        var email = $("#email").val();
                        var emailBackup = $("#emailBackup").val();

                        var telf_fijo = $("#telf_fijo").val();
                        var telf_fijoBackup = $("#telf_fijoBackup").val();

                        var telf_cel = $("#telf_cel").val();
                        var telf_celBackup = $("#telf_celBackup").val();

                        var usuario_id = $("#usuario_id").val();
                        var zona_id = $("#zona_id").val();

                        if (zona_id.length > 0 && !isNaN(zona_id)) {
                            $("#resultado-cambio-datos").html('');
                            //                            if (emailBackup != email || telf_fijo != telf_fijoBackup || telf_cel != telf_celBackup || cargo_id != cargo_idBackup) {
                            if (emailBackup != email || telf_fijo != telf_fijoBackup || telf_cel != telf_celBackup || isNaN(telf_cel)) {

                                if (telf_cel != telf_celBackup && (!isValidPhone(telf_cel, 'movil') || telf_cel.length != 11)) {
                                    mensaje = "El teléfono celular no posee el formato correcto. <br>";
                                    $("#telf_cel").val(telf_celBackup);
                                }
                                if (telf_fijo != telf_fijoBackup && (!isValidPhone(telf_fijo, 'fijo') || telf_fijo.length != 11 || isNaN(telf_fijo))) {
                                    mensaje = mensaje + "El Teléfono Fijo no posee el formato correcto. <br>";
                                    $("#telf_fijo").val(telf_fijoBackup);
                                }
                                if (emailBackup != email && (!isValidEmail(email) || email.length < 3)) {
                                    mensaje = mensaje + "El Correo Electrónico no posee el formato correcto. <br>";
                                    $("#email").val(emailBackup);
                                }
                                
                                if ($.trim(mensaje).length<=0){
                                    var datos = $("#zonaAutoridadesUsuario-form").serialize();
                                    var datosAjaxCallback = {zona_id: zona_id, usuario_id: usuario_id};
                                    var urlDir = "/ministerio/zonaEducativa/actualizarDatosAutoridad";
                                    var urlDirAjaxCallback = "/ministerio/zonaEducativa/getAutoridadZona";
                                    var loadingEfect = true;
                                    var showResult = true;
                                    var method = "POST";
                                    var responseFormat = 'html';
                                    var callback = function() {
                                        $('#autoridades-grid').yiiGridView('update', {
                                            data: $(this).serialize()
                                        });
                                    };

                                    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, callback);

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
                    id: "btnResetClaveAutoridadZona",
                    click: function() {

                        //Cambiar el Correo
                        var divResult = "resultado-cambio-datos";

                        var email = $("#email").val();
                        var emailBackup = $("#emailBackup").val();
                        var usuario_id = $("#usuario_id").val();

                        if (usuario_id.length > 0) {

                            var datos = {id: usuario_id, zona_id: zona_id, email: email};
                            var urlDir = "/control/autoridadesZona/resetearClave";
                            var loadingEfect = true;
                            var showResult = true;
                            var method = "POST";
                            var responseFormat = 'html';
                            var callback = null;

                            // executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, beforeSend, callback)
                            executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, callback);

                        }
                        else {

                            displayDialogBox(divResult, 'error', 'No se ha podido identificar al usuario al que desea modificar el correo. Recargue la página e intenetelo de nuevo.');

                        }

                    }
                }
            ]
        });

    });
}


//-------------------------------------------------->DEPLEGAR FORMULARIO DE DETALLES 

function eliminarAutoridad(id) {
    displayDialogBox("#dialogPantalla", 'alert', '¿Estas Seguro que Desea Desvincular a esta Autoridad de la Zona Educativa?');
    var dialog = $("#dialogPantalla").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> Cargo </h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-arrow-left bigger-110'></i> Volver",
                "class": "btn btn-xs btn-orange",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                html: "<i class='icon-trash bigger-110'></i> Desvincular esta Autoridad",
                "class": "btn btn-danger btn-xs",
                id: 'btnEliminarAutoridadZona',
                click: function() {
                    var divResult = "#dialogPantalla";
                    var urlDir = "/ministerio/zonaEducativa/eliminarAutoridad";
                    var zona_id = $("#zona_id").val();
                    var datos = {id: id, zona_id: zona_id};
                    var loadingEfect = true;
                    var showResult = true;
                    var method = "POST";
                    var responseFormat = 'html';
                    var callback = function() {
                        $("#btnEliminarAutoridadZona").attr("class", "hide");
                        $('#autoridades-grid').yiiGridView('update', {
                            data: $(this).serialize()
                        });
                        asignAllEvents();
                    };
                    // executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, beforeSend, callback)
                    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, callback);
                    //$(this).dialog("close");

                }
            }
        ],
    });


    Loading.hide();
}



function consultarZonaEducativa(id) {

    direccion = '/ministerio/zonaEducativa/consultarZonaEducativa';

    title = 'Detalles de Zona Educativa';

    Loading.show();
    var data =
            {
                id: id
            };

    $.ajax({
        url: direccion,
        data: data,
        dataType: 'html',
        type: 'GET',
        success: function(result)
        {
            var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                modal: true,
                width: '700px',
                dragable: false,
                resizable: false,
                //position: 'top',
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-search'></i> " + title + "</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs ",
                        click: function() {
                            $(this).dialog("close");
                            refrescarGrid();
                        }
                    }
                ]
            });
            $("#dialogPantalla").html(result);
        }
    });
    Loading.hide();
}

//-------------------------------------------->DESPLEGAR FORMULARIO UPDATE

function modificarZonaEducativa(id) {


    direccion = '/ministerio/zonaEducativa/modificarZonaEducativa';

    title = 'Modificar Zona Educativa';
    Loading.show();
    var data = {id: id};
    $.ajax({
        url: direccion,
        data: data,
        dataType: 'html',
        type: 'GET',
        success: function(result)
        {
            $("#dialogPantalla").removeClass('hide').dialog({
                modal: true,
                width: '900px',
                dragable: false,
                resizable: false,
                //position: 'top',
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-search'></i> " + title + "</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs",
                        click: function() {
                            $(this).dialog("close");
                            refrescarGrid();
                        }

                    },
                    {
                        html: "<i class='icon-save info bigger-110'></i>&nbsp; Guardar",
                        "class": "btn btn-primary btn-xs",
                        click: function() {
                            procesarCambio();
                            refrescarGrid();
                        }

                    }

                ],
                close: function() {
                    $("#dialogPantalla").html("");
                }
            });
            $("#dialogPantalla").html(result);
        }
    });
    Loading.hide();
}


//--------------------------------------------->desplegar pop-up para registrar

function registrarZonaEducativa() {

    direccion = '/ministerio/zonaEducativa/create';
    title = 'Crear Nueva ZonaEducativa';
    Loading.show();

    //var data = {id: id};

    $.ajax({
        url: direccion,
        //data: data,
        dataType: 'html',
        type: 'get',
        success: function(result)
        {
            $("#dialogPantalla").removeClass('hide').dialog({
                modal: true,
                width: '900px',
                dragable: false,
                resizable: false,
                //position: 'top',
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-pencil'></i> " + title + "</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs",
                        click: function() {
                            refrescarGrid();
                            $(this).dialog("close");
                        }

                    },
                    {
                        html: "<i class='icon-save info bigger-110'></i>&nbsp; Guardar",
                        "class": "btn btn-primary btn-xs",
                        click: function() {
                            crearZonaEducativa();
                            refrescarGrid();
                            // $("#nombre_zonaEducativa").val("");
                        }

                    }

                ],
            });
            $("#dialogPantalla").html(result);

        }
    });
    Loading.hide();
}



//-------------------------------------------------------->REGISTRAR 
function crearZonaEducativa()
{


    direccion = '/ministerio/zonaEducativa/crear';

    var nombre = $('#nombre_zonaEducativa').val();

    var data = {nombre: nombre};
    //alert(data);
    // executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, beforeSend, callback)
    executeAjax('error', direccion, data, false, true, 'POST', 'html', null, refrescarGrid);
    refrescarGrid();

}


//----------------------------------------------->>MODIFICAR NOMBRE  sin serialize
function procesarCambio()
{

    direccion = 'procesarCambio';

    var id = $('#id').val();
    var nombre = $('#nombre_zonaEducativa').val();

    var data = {ZonaEducativa: {id: id, nombre: nombre}};

    executeAjax('dialogPantalla', direccion, data, false, true, 'POST', 'html', refrescarGrid);
    refrescarGrid();

}

function borrar(id) {


    direccion = 'eliminar';

    var dialog = $("#dialogEliminar").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar ZonaEducativa</h4></div>",
        title_html: true,
        //html: 'hola....',
        buttons: [
            {
                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                "class": "btn btn-xs",
                click: function() {
                    refrescarGrid();
                    $(this).dialog("close");

                }
            },
            {
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    var data = {
                        id: id
                    };
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, callback)
                    executeAjax('dialogEliminar', direccion, data, false, true, 'GET', 'html', refrescarGrid);
                    $(this).dialog("close");
                    refrescarGrid();
                    $("#dialogBoxReg").show("slow");
                    $("#dialogBoxHab").hide("slow");
                    refrescarGrid();
                }
            }
        ]
    });
}

//* .-------------------REACTIVACION .-------------------------------------------

function reactivar(id) {


    direccion = 'reactivar';

    var dialog = $("#dialogReactivar").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Reactivar ZonaEducativa</h4></div>",
        title_html: true,
        //html: 'hola....',
        buttons: [
            {
                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                "class": "btn btn-xs",
                click: function() {
                    refrescarGrid();
                    $(this).dialog("close");

                }
            },
            {
                html: "<i class='icon-ok bigger-110'></i>&nbsp; Reactivar",
                "class": "btn btn-success btn-xs",
                click: function() {
                    var data = {
                        id: id
                    };
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, callback)
                    executeAjax('dialogReactivar', direccion, data, false, true, 'GET', 'html', refrescarGrid);
                    $(this).dialog("close");
                    refrescarGrid();
                    $("#dialogBoxReg").hide("slow");
                    $("#dialogBoxHab").show("slow");
                }
            }
        ]
    });
}

//------------------------------------------------------------------------------

function refrescarGrid() {

    $('#zonaEducativa-grid').yiiGridView('update', {
        data: $(this).serialize()
    });

}
function cerrar_dialogo()
{

    Loading.show();

//               $("#dialogPantalla").dialog("close");
    window.location.reload();
    document.getElementById("guardo").style.display = "block";


    Loading.hide();


}



//------------------------funciones para MODIFICAR AUTORIDADES----------------->

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

function guardarAutoridad(id, autoridades) {

    $.ajax({
        url: "/ministerio/zonaEducativa/guardarAutoridad",
        data: {id: id,
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


function buscarCedulaAutoridad(cedula, zonaId) {
    
    if (cedula != '' && cedula != null && !isNaN(zonaId)) {
        $.ajax({
            url: "/ministerio/zonaEducativa/buscarCedula",
            data: {cedula: cedula, id: zonaId},
            dataType: 'json',
            type: 'get',
            success: function(resp) {
                //console.log(resp.statusCode);
                if (resp.statusCode === "mensaje") { // Existe un error, puede que el usuario ya tenga un cargo asignado
                    dialogo_error(resp.mensaje);
                }
                else if (resp.statusCode === "successC") { // Ya el usuario existe solo hay que agregarle el cargo
                    var autoridad = resp.autoridades[0];
                    //console.log(autoridad);
                    mostrarBusquedasCedula(autoridad.zona_educativa_id, resp.autoridades, autoridad.cargo_id);
                }
                if (resp.statusCode === "successU") { // Agregar Usuario Nuevo
                    mostrarDialog(resp.nombre, resp.apellido, resp.usuario);
                }

            }

        });
    }
}

function mostrarBusquedasCedula(id, autoridades, cargo) {
    
    var divResult = "#dialog_cargo";
    var urlDir = "/ministerio/zonaEducativa/getFormCargo";
    var datos = null;
    var loadingEfect = true;
    var showResult = true;
    var method = "GET";
    var responseFormat = "html";
    var beforeSend = null;
    
    var callback = function(){
    
        var cedula_value = $("#cedula").val();
        var cedula = cedula_value.substring(2, 10);
        if (cedula != '') {
            //$("#dialog_cargo").removeClass('hide');
            var dialog = $("#dialog_cargo").removeClass('hide').dialog({
                modal: true,
                width: '500px',
                dragable: false,
                resizable: false,
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Cargo a Asignar</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-xs",
                        click: function() {
                            $("#cargo_id_c").val('');
                            $(this).dialog("close");
                        }
                    },
                    {
                        html: "Guardar &nbsp; <i class='icon-save icon-on-right bigger-110'></i>",
                        id: "btnGuardarAutoridadZona",
                        "class": "btn btn-primary btn-xs",
                        click: function() {


                            //  alert($("#cargo_id").val());
                            if ($("#cargo_id_c").val() !== '') {
                                var data = {
                                    cedula: cedula,
                                    zona_id: id,
                                    cargo: $("#cargo_id_c").val(),
                                    // key: key
                                };
                                
                                $.ajax({
                                    url: "/ministerio/zonaEducativa/agregarAutoridad",
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
                                            $("#dialog_cargo").html(resp);
                                            $("#btnGuardarAutoridadZona").addClass("hide");
                                            $('#autoridades-grid').yiiGridView('update', {
                                                data: $(this).serialize()
                                            });
                                            $("#cedula").val("");
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
        }
    };
    
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, callback);
}

function mostrarDialog(nombre, apellido, usuario) {
    var cedula = $("#cedula").val();
    var zona_id = $("#zona_id").val();
    $("#UserGroupsUser_nombre").val(nombre);
    $("#UserGroupsUser_apellido").val(apellido);
    $("#UserGroupsUser_cedula").val(cedula);
    $("#UserGroupsUser_username").val(usuario);
    $("#UserGroupsUser_cedula").attr('readOnly', true);
    $("#UserGroupsUser_username").attr('readOnly', true);
    var dialogAutoridad = $("#agregarAutoridad").removeClass('hide').dialog({
        modal: true,
        width: '850px',
        height: '520',
        dragable: false,
        resizable: true,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Vincular Autoridad a la Zona Educativa</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
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
                    var cargo = $.trim($("#cargo_id").val());
                    var email = $.trim($("#UserGroupsUser_email").val());
                    var telefono_fijo = $.trim($("#UserGroupsUser_telefono").val());
                    var telefono_celular = $.trim($("#UserGroupsUser_telefono_celular").val());
                    var nombreC = $.trim($("#UserGroupsUser_nombre").val());
                    var apellido = $.trim($("#UserGroupsUser_apellido").val());
                    if (cargo == "" || nombre == "" || email == "" || telefono_fijo == "" || telefono_celular == "" || nombreC == '' || apellido == '') {
                        displayDialogBox('validacionesA', 'error', 'DATOS FALTANTES: Los campos Cargo, Email, Telefono Fijo, Nombre, Apellido y Telefono Celular no pueden estar vacios.');
                    }
                    else {
                        displayDialogBox('validacionesA', 'info', 'Debe ingresar los datos requeridos para agregar una autoridad. Los campo marcados con * son requeridos.');
                        $.ajax({
                            url: "/ministerio/zonaEducativa/guardarNuevaAutoridad",
                            data: $("#zonaAgregarAutoridad-form").serialize(),
                            dataType: 'html',
                            type: 'post',
                            success: function(resp, resp1, resp3) {
                                try {
                                    var json = jQuery.parseJSON(resp);
                                    displayDialogBox('validacionesA', 'error', json.mensaje);
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
                                    $("#dialog_success p").html("Usuario Registrado exitosamente, está pendiente por su activaci&oacute;n en el sistema");
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
                                    $("#_formAutoridades").html(resp);
                                }
                            }
                        });
                    }

                }
            }
        ]
    });
}



//$("#dialog_agregarAutoridad").show();

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