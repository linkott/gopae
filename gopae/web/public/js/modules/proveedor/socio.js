function registrarSocio(id) {
    direccion = '../../registrar';
    title = 'Crear nuevo socio';
    Loading.show();
    //var data = {id: id};
    $.ajax({
        url: direccion,
        data: {Socio:{proveedor_id:id}},
        dataType: 'html',
        type: 'POST',
        success: function(result)
        {
            $("#dialogPantalla").removeClass('hide').dialog({
                modal: true,
                width: '800px',
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
//                            document.getElementById('socio-form').submit();
                            registrar();
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

function registrar()
{
    direccion = '../../crear';
    var proveedor_id = $('#Socio_proveedor_id').val();
    var rif = $('#Socio_rif').val();
    var nombres = $('#Socio_nombres').val();
    var apellidos  = $('#Socio_apellidos').val();
    var telefono_celular = $('#Socio_telefono_celular').val();
    var correo = $('#Socio_correo').val();
    var certificado_salud = $('#Socio_certificado_salud').val();

    var data = {Socio: {proveedor_id:proveedor_id, rif: rif, nombres: nombres, apellidos: apellidos, telefono_celular:telefono_celular, correo:correo, certificado_salud:certificado_salud}};
    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
    executeAjax('dialogPantalla', direccion, data, true, true, 'POST', 'html', refrescarGrid);
}

function consultarSocio(id) {
    direccion = '../../informacionSocio';
    title = 'Detalles Del Socio';
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
            var dialog = $("#dialogPantallaConsultar").removeClass('hide').dialog({
                modal: true,
                width: '800px',
                dragable: false,
                resizable: false,
                //position: 'top',
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'>" + title + "</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs",
                        click: function() {
                            refrescarGrid();
                            $(this).dialog("close");
                        }

                    }

                ]
            });
            $("#dialogPantallaConsultar").html(result);
        }
    });
    Loading.hide();
}

function modificarSocio(id, proveedor_id) {
    direccion = '../../modificarSocio';
    title = 'Modificar Socio';
    Loading.show();
    var data = {id:id, Socio:{proveedor_id:proveedor_id}};
    $.ajax({
        url: direccion,
        data: data,
        dataType: 'html',
        type: 'GET',
        success: function(result)
        {
            $("#dialogPantalla").removeClass('hide').dialog({
                modal: true,
                width: '800px',
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
                        }
                    },
                    {
                        html: "<i class='icon-save info bigger-110'></i>&nbsp; Guardar",
                        "class": "btn btn-primary btn-xs",
                        click: function() {
                            procesarCambioSocio();
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

function procesarCambioSocio()
{
    direccion = '../../procesarCambioSocio';
    var id = $('#model_id').val();
    var proveedor_id = $('#Socio_proveedor_id').val();
    var rif = $('#Socio_rif').val();
    var nombres = $('#Socio_nombres').val();
    var apellidos  = $('#Socio_apellidos').val();
    var telefono_celular = $('#Socio_telefono_celular').val();
    var correo = $('#Socio_correo').val();
    var certificado_salud = $('#Socio_certificado_salud').val();

    var data = {Socio: {id:id, proveedor_id:proveedor_id, rif: rif, nombres: nombres, apellidos: apellidos, telefono_celular:telefono_celular, correo:correo, certificado_salud:certificado_salud}};
    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
    executeAjax('dialogPantalla', direccion, data, true, true, 'POST', 'html', refrescarGrid);
}

function eliminarSocio(id) {
    var dialog = $("#dialogPantallaEliminar").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Socio</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-warning btn-xs",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Socio",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    var data = {
                        id: id
                    };
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                    executeAjax('_formRegistrarSocio', '../../eliminarSocio', data, true, true, 'GET', 'html', refrescarGrid);
                    refrescarGrid();
                    refrescarGrid();
                    $(this).dialog("close");
                }
            }
        ]
    });
}

function activarSocio(id) {
    var dialogAct = $("#dialogPantallaActivacion").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Activar Articulo</h4></div>",
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
                html: "<i class='icon-ok bigger-110'></i>&nbsp; Activar Socio",
                "class": "btn btn-success btn-xs",
                click: function() {
                    var data = {
                        id: id
                    };
                    executeAjax('_formRegistrarSocio', '../../activarSocio', data, true, true, 'GET', 'html', refrescarGrid);
                    refrescarGrid();
                    refrescarGrid();
                    $(this).dialog("close");
                }
            }
        ]
    });
}

function refrescarGrid(){
    $('#socio-grid').yiiGridView('update', {
    data: $(this).serialize()
});   
}