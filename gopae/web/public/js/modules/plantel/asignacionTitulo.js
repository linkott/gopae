$(document).ready(function() {

//    //$("#selec_todoEst").attr('checked', 'checked');
//    var style = 'alerta';
//    var msgasignado = "<p>Estimado usuario, debe asignar el serial por lo menos a un Estudiante para realizar esta acción.</p>";
//    $("#btnAsignarTitulo").unbind('click');
//    $("#btnAsignarTitulo").click(function(e) {
////
//
//        var cedulaCandidato = new Array();
//        var candidadoAsignarTitulo = new Array();
//        $('input[name="candidatoTitulo[]"]').each(function() {
//            if ($(this).val() != '') {
//                candidadoAsignarTitulo.push($(this).val());
//                cedulaCandidato.push($(this).attr('id'));
//
//            }
//        });
//        alert(candidadoAsignarTitulo);
//        if (candidadoAsignarTitulo.length > 0 && !jQuery.isEmptyObject(candidadoAsignarTitulo)) {
//
//            datos = {
//                cedulaCandidato: cedulaCandidato,
//                candidadoAsignarTitulo: candidadoAsignarTitulo,
//            };
//            var conEfecto = true;
//            var showHTML = true;
//            var method = 'POST';
//            var divResult = 'result-solicitud';
//            var urlDir = '/planteles/AsignacionTitulo/GuardarAsignacionTitulo/';
//            $.ajax({
//                url: urlDir,
//                data: datos,
//                dataType: 'html',
//                type: method,
//                success: function(resp, resp2, resp3) {
//                    try {
//
//                        var json = jQuery.parseJSON(resp3.responseText);
//                        if (json.statusCode === "success") {
//
////                            $("#campo_vacio p").html('');
////                            $("#campo_vacio").addClass('hide');
//                            //                            $("#busqued p").html('');
//                            $("#result-solicitud").addClass('hide');
//                            $("#exitoSolicitud").removeClass('hide');
//                            $("#exitoSolicitud p").html(json.mensaje);
//                            //                            $("html, body").animate({scrollTop: 0}, "fast");
//                        } else if (json.statusCode === "error") {
//
////                            $("#campo_vacio p").html('');
////                            $("#campo_vacio").addClass('hide');
//                            //                            $("#respuestBuscar p").html('');
//                            //                            $("#respuestBuscar").addClass('hide');
//                            $("#errorAsignarTitulo").removeClass('hide');
//                            $("#errorAsignarTitulo p").html(json.mensaje);
//                            //                            $("html, body").animate({scrollTop: 0}, "fast");
//                        }
//
//                    } catch (e) {
//////
////////                        $("#atenderSolicitud").html(resp);
////////                        dialogAgregar_lote.dialog('close');
////        ////                        $("html, body").animate({scrollTop: 0}, "fast");
////        ////                        Loading.hide();
//                    }
//                }
//            });
//        }
//        else {
//
//            displayDialogBox('seleccionAsignarTitulo', style, msgasignado);
//        }
//
//    });
});
