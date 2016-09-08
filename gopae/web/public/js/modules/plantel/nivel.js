function eliminarNivel(nivel_id, id) {
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
                                nivel_id: nivel_id,
                                id: id
                            };
                    // executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback)
                    executeAjax('listaNivel', '/planteles/nivelPlantel/eliminarNivel', data, true, true, 'GET', 'html', refrescarGrid);
                    $(this).dialog("close");
                }
            }
        ]
    });
}
function refrescarGrid(){
    $('#nivel-grid').yiiGridView('update', {
    data: $(this).serialize()
});   
}