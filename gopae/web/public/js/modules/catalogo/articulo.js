
$('#nombreArticulo').bind('keyup blur', function() {
    //makeUpper(this);
    keyAlphaNum(this, true, true);
});

$('#Articulo_nombre_form').bind('keyup blur', function() {
    makeUpper(this);
    keyAlphaNum(this, true, true);
});

$('#Articulo_precio_regulado').bind('keyup blur', function() {
    keyNum(this, true);
});



function consultarArticulo(id) {
    direccion = 'informacion';
    title = 'Detalles del articulo';
    Loading.show();
    var data =
            {
                id: id
            };
    //alert (id);
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

function registrarArticulo(nombre) {
    direccion = 'registrar';
    title = 'Crear nuevo ' + nombre;
    Loading.show();
    //var data = {id: id};
    $.ajax({
        url: direccion,
        //data: data,
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
    direccion = 'crear';
    var nombre = $('#Articulo_nombre_form').val();
    var unidad_medida_id = $('#Articulo_unidad_medida_id').val();
    var precio_regulado = $('#Articulo_precio_regulado_form').val();
    var precio_baremo = $('#Articulo_precio_baremo_form').val();
    var tipo_articulo_id = $('#Articulo_tipo_articulo_id').val();
    if(tipo_articulo_id == 1) {
        var franja_id = $('#Articulo_franja_id').val();
        if(franja_id == '') {
            franja_id = '';
        }
    }
    else {
        franja_id = 'null';
    }

    var data = {Articulo: {nombre: nombre, unidad_medida_id: unidad_medida_id, precio_regulado: precio_regulado, precio_baremo: precio_baremo, tipo_articulo_id: tipo_articulo_id, franja_id: franja_id}};
    
    executeAjax('dialogPantalla', direccion, data, true, true, 'POST', 'html', refrescarGrid);

    $('#Articulo_nombre_form').val('');
    $('#Articulo_unidad_medida_id').val('');
    $('#Articulo_precio_regulado_form').val('');

}

function modificarArticulo(id) {

    //alert(id);
    direccion = 'modificar';
    title = 'Modificar Articulo';
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
                            procesarCambio();
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



function modificarPrecio(id, precio_region_id, estado_id, articulo_id) {
    direccion = 'modificarPrecioRegion';
    title = 'Modificar Precio';
    Loading.show();
    var data = {id:id, precio_region_id: precio_region_id, estado_id: estado_id, articulo_id: articulo_id};
    $.ajax({
        url: direccion,
        data: data,
        dataType: 'html',
        type: 'GET',
        success: function(result)
        {
            $("#dialogPantallaRegion").removeClass('hide').dialog({
                modal: true,
                width: '600px',
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
                            procesarCambioMonetario();
                        }
                    }
                ],
                close: function() {
                    $("#dialogPantallaRegion").html("");
                }
            });
            $("#dialogPantallaRegion").html(result);
        }
    });
    Loading.hide();
}

function procesarCambio()
{
    direccion = 'procesarCambio';
    var id = $('#id').val();
    var nombre = $('#Articulo_nombre_form').val();
    var unidad_medida_id = $('#Articulo_unidad_medida_id').val();
    var precio_regulado = $('#Articulo_precio_regulado_form').val();
    var precio_baremo = $('#Articulo_precio_baremo_form').val();
    var tipo_articulo_id = $('#Articulo_tipo_articulo_id').val();
    if(tipo_articulo_id == 1) {
        var franja_id = $('#Articulo_franja_id').val();
        if(franja_id == '') {
            franja_id = '';
        }
    }
    else {
        franja_id = 'null';
    }
    
    var data = {Articulo: {id:id, nombre: nombre, unidad_medida_id: unidad_medida_id, precio_regulado: precio_regulado, precio_baremo: precio_baremo, tipo_articulo_id: tipo_articulo_id, franja_id: franja_id}};
//    var data = {Articulo: {id:id, nombre: nombre, unidad_medida_id: unidad_medida_id, precio_regulado: precio_regulado, tipo_articulo_id: tipo_articulo_id, franja_id: franja_id}};
    executeAjax('dialogPantalla', direccion, data, false, true, 'POST', 'html', refrescarGrid);

}

function procesarCambioMonetario()
{
    direccion = 'procesarCambioMonetario';
    var id = $('#id').val();
    var precio_regulado = $('#Articulo_precio_regulado_form').val();
    var estado_id = $('#estado_id').val();
    var articulo_id = $('#articulo_id').val();
    var articulo_model_id = $('#articulo_model_id').val();
    var precio_region_id = $('#precio_region_id').val();
    var id_encode = $('#id_encode').val();
    
    var data = {Articulo: {id:id, precio_regulado: precio_regulado, estado_id:estado_id, articulo_id:id, articulo_model_id:articulo_model_id, precio_region_id:precio_region_id}};
//    executeAjax('dialogPantallaRegion', direccion, data, true, true, 'POST', 'html');
    $.ajax({
        url: direccion,
        data: data,
        dataType: 'html',
        type: 'POST',
        success: function(result)
        {
//            alert(1);
            $("#preciosRegion").load('_precioRegionLoad?id=' + id_encode + '&precio_region_id=' + precio_region_id + '&estado_id=' + estado_id + '&articulo_id=' + articulo_id + '');
            $("#resultado").html(result);

        }
        
        
        
        
    });

}

function eliminarArticulo(id) {
    var dialog = $("#dialogPantallaEliminar").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Articulo</h4></div>",
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
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Articulo",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    var data = {
                        id: id
                    };
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                    executeAjax('_form', 'eliminarArticulo', data, true, true, 'GET', 'html', refrescarGrid);
                    $(this).dialog("close");
                }
            }
        ]
    });
}

function activarArticulo(id) {
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
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Activar Articulo",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    var data = {
                        id: id
                    };
                    executeAjax('_form', 'activarArticulo', data, true, true, 'GET', 'html', refrescarGrid);
                    $(this).dialog("close");
                }
            }
        ]
    });
}
function quitar(id, nivel_id) {
    var dialog = $("#dialogPantallaEliminar").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Nivel</h4></div>",
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
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Nivel",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    var data =
                            {
                                id: id,
                                nivel_id: nivel_id
                            };
                    executeAjax('listaGrado', '/catalogo/nivel/QuitarGrado', data, true, true, 'GET', 'html');
                    $(this).dialog("close");
                }
            }
        ]
    });

}

function refrescarGrid() {
    $('#articulo-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
}