
$(document).ready(function() {
    $('#razonAccion').bind('keyup blur', function() {
        makeUpper(this);
    });
    $("#PlantelPae_matricula_simoncito").numeric(false);
    $("#PlantelPae_matricula_general").numeric(false);
    $('#PlantelPae_matricula_simoncito, #PlantelPae_matricula_general').bind('keyup blur', function() {
        var matricula_simoncito = $('#PlantelPae_matricula_simoncito').val() * 1;
        var matricula_general = $('#PlantelPae_matricula_general').val() * 1;
        var suma = matricula_simoncito + matricula_general;
        $("#matriculaTotal").val(suma);
    });
});

function accion(plantel_id, value, classValue, icon, cambio_pae_activo) {

    if (cambio_pae_activo == 'SI') {
        $("#motivoEstatus").removeClass('hide');
    }
    else {
        $("#motivoEstatus").addClass('hide');
    }
    $("#motivo_inactividad").val('');
    $("#mensajeAlertaInfo").removeClass('hide');
    $("#mensajeAlerta").addClass('hide');
    $("#mensajeAlertaExito").addClass('hide');
    $('#razonAccion').val('');
    var dialog = $("#dialogPantallaObservacion").removeClass('hide').dialog({
        modal: true,
        width: '600px',
        draggale: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> " + value + " servicios del PAE </h4></div>",
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
                html: value + " <i class='fa fa-arrow-" + icon + " bigger-110'></i>",
                "class": "btn btn-" + classValue + " btn-xs",
                "id": "botonAccion",
                click: function() {

                    var plantel_pae_id = $("#PlantelPae_id").val();
                    var observacion = $("#razonAccion").val();
                    var motivo = $("#motivoInactividad").val();

                    if (observacion == '') {
                        $("#mensajeAlertaInfo").addClass('hide');
                        $("#mensajeAlerta").removeClass('hide');
                    }
                    else if (cambio_pae_activo == 'SI' && motivo == '') {
                        $("#mensajeAlertaInfo").addClass('hide');
                        $("#mensajeAlerta").removeClass('hide');
                    }
                    else {
//                        evt.preventDefault();
                        $.ajax({
                            url: "/planteles/modificar/accionActivar",
                            data: 'plantel_id=' + plantel_id + '&plantel_pae_id=' + plantel_pae_id + '&observacion=' + observacion + '&cambio_pae_activo=' + cambio_pae_activo + '&motivo_inactividad=' + $("#motivo_inactividad").val(),
                            dataType: 'html',
                            type: 'post',
                            dataType: 'json',
                                    success: function(json) {
                                        if (json.respuesta == 1) {
                                            $("html, body").animate({scrollTop: 0}, "fast");
                                            $("#dialogPantallaObservacion").dialog("close");
                                            $("#mensajeAlertaExito").removeClass('hide');
//                                        $("#btnEstatusAccion").addClass('hide');
                                            if (cambio_pae_activo == 'NO') {
                                                var pae_estatus = 'Inactivar';
                                                var className = 'danger';
                                                $("#btnEstatusAccion").attr('class', 'btn btn-danger');
                                                $("#btnEstatusAccion").attr('onclick', "accion(" + plantel_id + ", '" + pae_estatus + "', '" + className + "', 'down', 'SI');");
                                                $("#btnEstatusAccion").html('Inactivar <i class="fa fa-arrow-down"></i>');
                                                $("#PlantelPae_pae_activo").val('SI');
                                            }
                                            if (cambio_pae_activo == 'SI') {
                                                var pae_estatus = 'Activar';
                                                var className = 'success';
                                                $("#btnEstatusAccion").attr('class', 'btn btn-success');
                                                $("#btnEstatusAccion").html('Activar <i class="fa fa-arrow-up"></i>');
                                                $("#btnEstatusAccion").attr('onclick', "accion(" + plantel_id + ", '" + pae_estatus + "', '" + className + "', 'up', 'NO');");
                                                $("#PlantelPae_pae_activo").val('NO');
                                            }
                                            $("#PlantelPae_fecha_ultima_actualizacion").val(json.fecha_actualizacion);
                                        }
                                    }
                        });
                    }
                }
            }
        ]
    });
}

$(document).ready(function() {
    var ms = parseInt($("#PlantelPae_matricula_simoncito").val());
    var mg = parseInt($("#PlantelPae_matricula_general").val());
    var suma = (ms + mg);
    $("#matriculaTotal").val(suma);
});

$("#PlantelPae_posee_simoncito").bind('change', function() {
    var area_producion = $("#PlantelPae_posee_simoncito").val();
    if (area_producion == 'SI') {
        $("#PlantelPae_matricula_simoncito").attr('disabled', false);
        $("#PlantelPae_matricula_simoncito").val($("#matricula_simoncito_hidden").val());
        $("#PlantelPae_matricula_simoncito").focus();
    }
    else {
        $("#PlantelPae_matricula_simoncito").attr('disabled', true);
        $("#PlantelPae_matricula_simoncito").val('0');
    }
});

$("#PlantelPae_posee_area_produccion_agricola").bind('change', function() {
    var area_producion = $("#PlantelPae_posee_area_produccion_agricola").val();
    if (area_producion == 'SI') {
        $("#PlantelPae_hectareas_produccion").attr('disabled', false);
        $("#PlantelPae_hectareas_produccion").val($("#hectareas_produccion_hidden").val());
        $("#PlantelPae_hectareas_produccion").focus();
    }
    else {
        $("#PlantelPae_hectareas_produccion").attr('disabled', true);
        $("#PlantelPae_hectareas_produccion").val('0');
    }
});
$("#PlantelPae_hectareas_produccion").bind('keyup blur', function() {
    keyNum(this, true);
});
function guardarCambios() {

    $("#mensajeAlertaExito").addClass('hide');
    $("#mensajeAlertaError").addClass('hide');

    var tipo_servicio_pae_id = $("#PlantelPae_tipo_servicio_pae_id").val();
    var posee_simoncito = $("#PlantelPae_posee_simoncito").val();
    var posee_area_cocina = $("#PlantelPae_posee_area_cocina").val();
    var condicion_servicio_id = $("#PlantelPae_condicion_servicio_id").val();
    var posee_area_produccion_agricola = $("#PlantelPae_posee_area_produccion_agricola").val();
    var hectareas_produccion = $("#PlantelPae_hectareas_produccion").val();
    var posee_simoncito = $("#PlantelPae_posee_simoncito").val();
    var matricula_simoncito = $("#PlantelPae_matricula_simoncito").val();
    var matricula_general = $("#PlantelPae_matricula_general").val();
    var mensaje = '<p>';
    mensaje = mensaje + 'Corrige los siguientes errores:<br/>';
    if (tipo_servicio_pae_id == '') {
        mensaje = mensaje + ' - El Tipo de Servicio no puede estar vacio.<br/>';
    }
    if (posee_simoncito == '') {
        mensaje = mensaje + ' - Posee Simoncito no puede estar vacio.<br/>';
    }
    if (posee_area_cocina == '') {
        mensaje = mensaje + ' - Posee Area de Cocina no puede estar vacio.<br/>';
    }
    if (condicion_servicio_id == '') {
        mensaje = mensaje + ' - Condicion de Servicio no puede estar vacio.<br/>';
    }
    if (posee_simoncito == 'SI' && matricula_simoncito <= 0) {
        mensaje = mensaje + ' - Matricula Simoncito tiene que contener 1 o mas.<br/>';
    }
    if (matricula_general <= 0) {
        mensaje = mensaje + ' - Matricula General tiene que contener 1 o mas.<br/>';
    }
    if (posee_area_produccion_agricola == '') {
        mensaje = mensaje + ' - Posee área de producción agricola no puede estar vacio.<br/>';
    }
    else {
//            alert(posee_area_produccion_agricola);
        if (posee_area_produccion_agricola == 'SI' && hectareas_produccion == '') {
            mensaje = mensaje + ' - Hectareas de producción agricola no puede estar vacio.<br/>';
        }
        else if (posee_area_produccion_agricola == 'SI' && hectareas_produccion <= 0) {
            mensaje = mensaje + ' - Hectareas de producción agricola tiene que contener 1 o mas.<br/>';
        }
    }
    mensaje = mensaje + '</p>';

//        alert(mensaje);
    if (mensaje != '<p>Corrige los siguientes errores:<br/></p>') {
        $("html, body").animate({scrollTop: 0}, "fast");
        $("#mensajeAlertaError").removeClass('hide');
        $("#mensajeAlertaError").html(mensaje);
    }
    else {
        var id = $("#PlantelPae_id").val();
        var edito_matricula = $("#PlantelPae_edito_matricula").val();
        var plantel_id = $("#PlantelPae_plantel_id").val();
        var servicio_pae = $("#PlantelPae_tipo_servicio_pae_id").val();
        var posee_simoncito = $("#PlantelPae_posee_simoncito").val();
        var posee_area_cocina = $("#PlantelPae_posee_area_cocina").val();
        var condicion_servicio = $("#PlantelPae_condicion_servicio_id").val();
        var posee_area_produccion_agricola = $("#PlantelPae_posee_area_produccion_agricola").val();
        var hectareas_produccion = $("#PlantelPae_hectareas_produccion").val();

        if (edito_matricula == 'NO') {
            var dialog = $("#dialogPantallaConfirmacion").removeClass('hide').dialog({
                modal: true,
                width: '600px',
                draggale: false,
                resizable: false,
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Confirmar cambios </h4></div>",
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
                        html: "Guardar <i class='fa fa-arrow-save bigger-110'></i>",
                        "class": "btn btn-success btn-xs",
                        "id": "botonAccion",
                        click: function() {
                            ejecutarAjax(id, plantel_id, servicio_pae, posee_simoncito, posee_area_cocina, condicion_servicio, posee_area_produccion_agricola, hectareas_produccion, matricula_general, matricula_simoncito, edito_matricula);
                            $(this).dialog("close");
                        }
                    }
                ]
            });
        }
        else{
            ejecutarAjax(id, plantel_id, servicio_pae, posee_simoncito, posee_area_cocina, condicion_servicio, posee_area_produccion_agricola, hectareas_produccion, matricula_general, matricula_simoncito, edito_matricula);
        }
    }
}

function ejecutarAjax(id, plantel_id, servicio_pae, posee_simoncito, posee_area_cocina, condicion_servicio, posee_area_produccion_agricola, hectareas_produccion, matricula_general, matricula_simoncito, edito_matricula) {
    $.ajax({
        url: "/planteles/modificar/modificarPae",
        data: 'id=' + id +
                '&plantel_id=' + plantel_id +
                '&servicio_pae=' + servicio_pae +
                '&posee_simoncito=' + posee_simoncito +
                '&posee_area_cocina=' + posee_area_cocina +
                '&condicion_servicio=' + condicion_servicio +
                '&posee_area_produccion_agricola=' + posee_area_produccion_agricola +
                '&hectareas_produccion=' + hectareas_produccion +
                '&matricula_general=' + matricula_general +
                '&matricula_simoncito=' + matricula_simoncito +
                '&edito_matricula=' + edito_matricula,
        type: 'post',
        dataType: 'json',
        success: function(json) {
            $("#PlantelPae_id").val(json.plantel_pae_id);
            $("#PlantelPae_plantel_id").val(json.plantel_id);
            $("#PlantelPae_pae_activo").val(json.pae_activo);
            $("#PlantelPae_tipo_servicio_pae_id").val(json.tipo_servicio);
            $("#PlantelPae_edito_matricula").val(json.edito_matricula);
//                    $("#PlantelPae_posee_simoncito").val(json.posee_simoncito);
            $("#fecha_inicio").val(json.fecha_inicio);
            $("#PlantelPae_fecha_ultima_actualizacion").val(json.fecha_ultima);
            $("#PlantelPae_matricula_general").val(json.matricula_general);
            $("#PlantelPae_matricula_simoncito").val(json.matricula_simoncito);
            $("#PlantelPae_posee_area_cocina").val(json.posee_area_cocina);
            $("#PlantelPae_condicion_servicio_id").val(json.condicion_servicio);
            $("#posee_area_produccion_agricola").val(json.posee_area_produccion_agricola);
            $("#hectareas_produccion").val(json.hectareas_produccion);
            $("#PlantelPae_tipo_servicio_pae_id").attr('disabled', 'disabled');
            $("#PlantelPae_posee_simoncito").attr('disabled', 'disabled');
            $("#PlantelPae_matricula_simoncito").attr('disabled', 'disabled');
            $("#PlantelPae_matricula_general").attr('disabled', 'disabled');

            $("html, body").animate({scrollTop: 0}, "fast");
            $("#mensajeAlertaExito").removeClass('hide');
        }
    });
}

function accionActivar(plantel_id) {

    $("#mensajeAlertaExito").addClass('hide');
    $("#mensajeAlertaError").addClass('hide');

    var tipo_servicio_pae_id = $("#PlantelPae_tipo_servicio_pae_id").val();
    var posee_simoncito = $("#PlantelPae_posee_simoncito").val();
    var posee_area_cocina = $("#PlantelPae_posee_area_cocina").val();
    var condicion_servicio_id = $("#PlantelPae_condicion_servicio_id").val();
    var posee_area_produccion_agricola = $("#PlantelPae_posee_area_produccion_agricola").val();
    var hectareas_produccion = $("#PlantelPae_hectareas_produccion").val();
    var matricula_simoncito = $("#PlantelPae_matricula_simoncito").val();
    var matricula_general = $("#PlantelPae_matricula_general").val();
    var mensaje = '<p>';
    mensaje = mensaje + 'Corrige los siguientes errores:<br/>';
    if (tipo_servicio_pae_id == '') {
        mensaje = mensaje + ' - El Tipo de Servicio no puede estar vacio.<br/>';
    }
    if (posee_simoncito == '') {
        mensaje = mensaje + ' - Posee Simoncito no puede estar vacio.<br/>';
    }
    if (posee_area_cocina == '') {
        mensaje = mensaje + ' - Posee Area de Cocina no puede estar vacio.<br/>';
    }
    if (condicion_servicio_id == '') {
        mensaje = mensaje + ' - Condicion de Servicio no puede estar vacio.<br/>';
    }
    if (posee_simoncito == 'SI' && matricula_simoncito <= 0) {
        mensaje = mensaje + ' - Matricula Simoncito tiene que contener 1 o mas.<br/>';
    }
    if (matricula_general <= 0) {
        mensaje = mensaje + ' - Matricula General tiene que contener 1 o mas.<br/>';
    }
    if (posee_area_produccion_agricola == '') {
        mensaje = mensaje + ' - Posee área de producción agricola no puede estar vacio.<br/>';
    }
    else {
//            alert(posee_area_produccion_agricola);
        if (posee_area_produccion_agricola == 'SI' && hectareas_produccion == '') {
            mensaje = mensaje + ' - Hectareas de producción agricola no puede estar vacio.<br/>';
        }
        else if (posee_area_produccion_agricola == 'SI' && hectareas_produccion <= 0) {
            mensaje = mensaje + ' - Hectareas de producción agricola tiene que contener 1 o mas.<br/>';
        }
    }
    mensaje = mensaje + '</p>';

//        alert(mensaje);
    if (mensaje != '<p>Corrige los siguientes errores:<br/></p>') {
        $("html, body").animate({scrollTop: 0}, "fast");
        $("#mensajeAlertaError").removeClass('hide');
        $("#mensajeAlertaError").html(mensaje);
    }
    else {

        var dialog = $("#confirmacion").removeClass('hide').dialog({
            modal: true,
            width: '600px',
            draggale: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Activar servicios del PAE </h4></div>",
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
                    html: "Activar <i class='fa fa-arrow-up bigger-110'></i>",
                    "class": "btn btn-success btn-xs",
                    "id": "botonAccionActivar",
                    click: function() {

                        var servicio_pae = $("#PlantelPae_tipo_servicio_pae_id").val();
                        var posee_simoncito = $("#PlantelPae_posee_simoncito").val();
                        var posee_area_cocina = $("#PlantelPae_posee_area_cocina").val();
                        var condicion_servicio = $("#PlantelPae_condicion_servicio_id").val();
                        var posee_area_produccion_agricola = $("#PlantelPae_posee_area_produccion_agricola").val();
                        var hectareas_produccion = $("#PlantelPae_hectareas_produccion").val();
                        var matricula_simoncito = $("#PlantelPae_matricula_simoncito").val();
                        var matricula_general = $("#PlantelPae_matricula_general").val();

                        $.ajax({
                            url: "/planteles/modificar/activarPae",
                            data: 'plantel_id=' + plantel_id +
                                    '&servicio_pae=' + servicio_pae +
                                    '&posee_simoncito=' + posee_simoncito +
                                    '&posee_area_cocina=' + posee_area_cocina +
                                    '&condicion_servicio=' + condicion_servicio +
                                    '&posee_area_produccion_agricola=' + posee_area_produccion_agricola +
                                    '&hectareas_produccion=' + hectareas_produccion +
                                    '&matricula_general=' + matricula_general +
                                    '&matricula_simoncito=' + matricula_simoncito,
                            type: 'post',
                            dataType: 'json',
                            success: function(json) {
                                $("#PlantelPae_id").val(json.plantel_pae_id);
                                $("#PlantelPae_plantel_id").val(json.plantel_id);
                                $("#PlantelPae_pae_activo").val(json.pae_activo);
                                $("#PlantelPae_tipo_servicio_pae_id").val(json.tipo_servicio);
                                $("#PlantelPae_posee_simoncito").val(json.posee_simoncito);
                                $("#PlantelPae_edito_matricula").val(json.edito_matricula);
                                $("#fecha_inicio").val(json.fecha_inicio);
                                $("#PlantelPae_fecha_ultima_actualizacion").val(json.fecha_ultima);
                                $("#PlantelPae_matricula_general").val(json.matricula_general);
                                $("#PlantelPae_posee_area_cocina").val(json.posee_area_cocina);
                                $("#PlantelPae_condicion_servicio_id").val(json.condicion_servicio);

                                $("#PlantelPae_tipo_servicio_pae_id").attr('disabled', 'disabled');
                                $("#PlantelPae_posee_simoncito").attr('disabled', 'disabled');
                                $("#PlantelPae_matricula_simoncito").attr('disabled', 'disabled');
                                $("#PlantelPae_matricula_general").attr('disabled', 'disabled');

                                $("html, body").animate({scrollTop: 0}, "fast");
                                $("#mensajeAlertaExito").removeClass('hide');
                                $("#btnEstatusAccionGuardar").removeClass('hide');
                                $("#btnEstatusAccion").addClass('btn btn-danger');
                                $("#btnEstatusAccion").html('Inactivar <i class="fa fa-arrow-down bigger-110"></i>');
                                $("#btnEstatusAccion").attr('onclick', "accion(" + json.plantel_id + ", 'Inactivar', 'danger', 'down', 'SI')");
                                $("#confirmacion").dialog("close");
                            }
                        });
                    }
                }
            ]
        });
    }
}