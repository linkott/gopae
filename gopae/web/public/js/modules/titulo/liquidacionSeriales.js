
$("#liquidacionSeriales_form").submit(function(evt) {

    evt.preventDefault();
    var mensaje = '';
    var error = false;
    var plantel_id = $("#plantel_id").val();

    $('select[name="estatus_actual_id[]"]').each(function() {

        if ($(this).val() == '') {
            //alert($(this).val());
            mensaje = mensaje + "Por favor la liquidación no puede estar vacío <br>";
            error = true;
            //       alert(error);
            return false;
        }
    });
//    if (liquidacionSerial.length > 0 && !jQuery.isEmptyObject(liquidacionSerial)) {
//        alert('liquidacion3');
//        mensaje = mensaje + "Por favor la liquidación no puede estar vacío <br>";
//        error = true;
//
//    }


    $('input[name="observacion[]"]').each(function() {

        if ($(this).val() == '') {
            mensaje = mensaje + "Por favor la observación no puede estar vacío <br>";
            error = true;
            return false;
        }

    });
//    alert(observacionSerial);
//    if (observacionSerial.length > 0 && !jQuery.isEmptyObject(observacionSerial)) {
//        alert('observacion3');
//        mensaje = mensaje + "Por favor la observación no puede estar vacío <br>";
//            error = true;
//
//    }

//
//
    Loading.show();
    if (error == false) {

        $.ajax({
            url: "/planteles/liquidacionTitulo/guardarLiquidacionSeriales/id/" + plantel_id,
            data: $("#liquidacionSeriales_form").serialize(),
            dataType: 'html',
            type: 'post',
            success: function(resp, resp2, resp3) {

                try {

                    var json = jQuery.parseJSON(resp3.responseText);
                    if (json.statusCode == "error") {

                        $("#exitoLiquidacion p").html('');
                        $("#exitoLiquidacion").addClass('hide');
                        $("#campo_vacio p").html('');
                        $("#campo_vacio").addClass('hide');
                        $("#errorLiquidacion").removeClass('hide');
                        $("#errorLiquidacion p").html(json.mensaje);//Pinto el ultimo serial segun la cantidada de estudiantes.
                        $("html, body").animate({scrollTop: 0}, "fast");
                    }
                    else if (json.statusCode == "success") {

                        $("#errorLiquidacion p").html('');
                        $("#errorLiquidacion").addClass('hide');
                        $("#exitoLiquidacion").removeClass('hide');
                        $("#exitoLiquidacion p").html(json.mensaje);
                        $("html, body").animate({scrollTop: 0}, "fast");

                    }
                    Loading.hide();
                } catch (e) {


                    $("#errorLiquidacion p").html('');
                    $("#errorLiquidacion").addClass('hide');
                    $("#campo_vacio p").html('');
                    $("#campo_vacio").addClass('hide');
//                    $("#exitoLiquidacion").removeClass('hide');
//                    $("#exitoLiquidacion p").html(resp);
                    $("#indePrincipal").addClass('hide');
                    $("#index").html(resp);
                    $("html, body").animate({scrollTop: 0}, "fast");
                    Loading.hide();
                }
                Loading.hide();
            }
        });

    } else {

        $("#campo_vacio").removeClass('hide');
        $("#campo_vacio p").html(mensaje);
        $("html, body").animate({scrollTop: 0}, "fast");
        Loading.hide();
    }

});