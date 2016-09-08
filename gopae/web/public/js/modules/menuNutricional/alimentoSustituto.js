$(document).ready(function() {


//    $("#alimento-sustituto-form").on('submit', function(evt) {
//        evt.preventDefault();
//
//        $.ajax({
//            url: "/menuNutricional/menuNutricional/agregarAlimentoSustituto",
//            data: $("#alimento-sustituto-sinAgregar-grid").serialize(),
//            dataType: 'html',
//            type: 'post',
//            success: function(resp) {
//                
//               // $("#respMenuAlimentoSustituto").html(resp);
////                $('#alimento-sustituto-grid').yiiGridView('update', {
////                    data: $(this).serialize()
////                });
//           
//            }
//
//        });
//
//    });

});


function agregarSustituto() {
var idAlimento = $("#alimento").val();
    Loading.show();
    var data = {id: id, datos: idAlimento};
    

        $.ajax({
            url: "menuNutricional/menuNutricional/agregarSustituto",
            data: data,
            dataType: 'html',
            type: 'post',
            success: function(result)
            {
              
            }
        });
        Loading.hide();
}


function cambiarEstatus() {

    var id = $("id").val();
    var data = {id: id};
    var dialog = $("#dialogPantalla").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar esta unidad de medida</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-xs orange",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Unidad de Medida",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    executeAjax('_borrar', '/catalogo/unidadMedida/borrar', data, false, true, 'POST', 'html');
                }
            }
        ]
    });


}
