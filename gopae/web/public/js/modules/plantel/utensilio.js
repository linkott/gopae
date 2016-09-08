$(document).ready(function() {
    $('#utensilio_id').bind('change', function() {
        var plantel_id = $("#plantel_id").text();
        var utensilio_id = $('#utensilio_id').val();
        agregarUtensilio(plantel_id, utensilio_id);
    });
});

function agregarUtensilio(plantel_id, utensilio_id){
    if(utensilio_id != ''){
        var direccion = '/planteles/modificar/insertarUtensilio';
        $.ajax({
            url: direccion,
            data: 'plantel_id=' + plantel_id + '&utensilio_id=' + utensilio_id,
            dataType: 'html',
            type: 'POST',
            success: function(result)
            {
                if(result == 1){
                    refrescarGridUtensilio();
                }
            }
        });
    }
}

function eliminarUtensilio(id) {
    var dialog = $("#dialogPantallaEliminarUtensilio").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggale: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Utensilio</h4></div>",
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
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Utensilio",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    var data = {
                        id: id,
                        //plantel_id: $("#plantel_id").val()
                    };
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                    executeAjax('_form', '/planteles/modificar/eliminarArticulo', data, true, true, 'POST', 'html', refrescarGridUtensilio);
//                    refrescarGridArticulo();
                    $(this).dialog("close");
                }
            }
        ]
    });
}

function refrescarGridUtensilio() {
//    var data = {
//        plantel_id: $("#plantel_id").text()
//    };
    $('#plantel-pae-utensilio-grid').yiiGridView('update', {
//        data:data
    });
}