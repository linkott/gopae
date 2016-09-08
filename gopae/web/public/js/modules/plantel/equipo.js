$(document).ready(function() {
    $('#PlantelPaeArticulo_id').bind('change', function() {
        var plantel_id = $("#plantel_id").text();
        var equipo_id = $('#PlantelPaeArticulo_id').val();
        agregarEquipo(plantel_id, equipo_id);
    });
});

function agregarEquipo(plantel_id, equipo_id){
    if(equipo_id != ''){
        var direccion = '/planteles/modificar/insertarEquipo';
        $.ajax({
            url: direccion,
            data: 'plantel_id=' + plantel_id + '&equipo_id=' + equipo_id,
            dataType: 'html',
            type: 'POST',
            success: function(result)
            {
                if(result == 1){
                    refrescarGridArticulo();
                }
            }
        });
    }
}

function eliminarEquipo(id) {
    var dialog = $("#dialogPantallaEliminar").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggale: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Equipo</h4></div>",
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
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Equipo",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    var data = {
                        id: id,
                        //plantel_id: $("#plantel_id").val()
                    };
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                    executeAjax('_form', '/planteles/modificar/eliminarArticulo', data, true, true, 'POST', 'html', refrescarGridArticulo);
//                    refrescarGridArticulo();
                    $(this).dialog("close");
                }
            }
        ]
    });
}

function refrescarGridArticulo() {
//    var data = {
//        plantel_id: $("#plantel_id").text()
//    };
    $('#plantel-pae-articulo-grid').yiiGridView('update', {
//        data:data
    });
}