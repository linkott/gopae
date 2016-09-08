$(document).ready(function() {
    $('#PlantelIngesta_id').bind('change', function() {
        var plantel_id = $("#plantel_id").text();
        var ingesta_id = $('#PlantelIngesta_id').val();
        agregarIngesta(plantel_id, ingesta_id);
    });
});

function agregarIngesta(plantel_id, ingesta_id){
    if(ingesta_id != ''){
        var direccion = '/planteles/modificar/insertarIngesta';
        $.ajax({
            url: direccion,
            data: 'plantel_id=' + plantel_id + '&ingesta_id=' + ingesta_id,
            dataType: 'html',
            type: 'POST',
            success: function(result)
            {
//                alert(result);
                if(result == 1){
                    refrescarGrid();
                }
            }
        });
    }
}

function eliminarIngesta(id) {
    var dialog = $("#dialogPantallaEliminar").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggale: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Ingesta</h4></div>",
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
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Ingesta",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    var data = {
                        id: id,
                        //plantel_id: $("#plantel_id").val()
                    };
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                    executeAjax('_form', '/planteles/modificar/eliminarIngesta', data, true, true, 'POST', 'html', refrescarGrid);
//                    refrescarGrid();
                    $(this).dialog("close");
                }
            }
        ]
    });
}

function refrescarGrid() {
//    var data = {
//        plantel_id: $("#plantel_id").text()
//    };
    $('#ingesta-grid').yiiGridView('update', {
//        data:data
    });
}