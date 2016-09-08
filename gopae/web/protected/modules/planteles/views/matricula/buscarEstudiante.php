<div class="col-md-12" id ="busqueRealizada">
    <div id="scrolltable" style='border: 0px;background: #fff; overflow:auto;padding-right: 0px; padding-top: 0px; padding-left: 0px; padding-bottom: 0px;border-right: #DDDDDD 0px solid; border-top: #DDDDDD 0px solid;border-left: #DDDDDD 0px solid; border-bottom: #DDDDDD 0px solid;scrollbar-arrow-color : #999999; scrollbar-face-color : #666666;scrollbar-track-color :#3333333 ;height:225px; left: 28%; top: 300; width: 100%'>
        <?php
//        var_dump($inscriptos);
//        die();
        if (isset($dataProvider)) {
            // var_dump($dataProvider['inscripto']);
            //  die();
            $this->widget(
                    'zii.widgets.grid.CGridView', array(
                'id' => 'estudiante-grid',
                'itemsCssClass' => 'table table-striped table-bordered table-hover',
                'dataProvider' => $dataProvider,
                'summaryText' => false,
                'columns' => array(
                    array(
                        'name' => 'cedula_escolar',
                        'type' => 'raw',
                        'header' => '<center><b>Cédula Escolar</b></center>'
                    ),
                    array(
                        'name' => 'cedula_identidad',
                        'type' => 'raw',
                        'header' => '<center><b>Cédula Identidad</b></center>'
                    ),
                    array(
                        'name' => 'nombres',
                        'type' => 'raw',
                        'header' => '<center><b>Nombres</b></center>'
                    ),
                    array(
                        'name' => 'apellidos',
                        'type' => 'raw',
                        'header' => '<center><b>Apellidos</b></center>'
                    ),
                    array(
                        'name' => 'codplant_nombreplante',
                        'type' => 'raw',
                        'header' => '<center><b>Código y Nombre del Plantel</b></center>'
                    ),
                    array(
                        'name' => 'boton',
                        'type' => 'raw',
                        'header' => '<center><b>Acciones</b></center>'
                    ),
                ),
                'pager' => array(
                    'header' => '',
                    'htmlOptions' => array('class' => 'pagination'),
                    'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                    'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                    'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                    'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                ),
                    )
            );
        }
        ?>
    </div>
</div>
<script>
    $(document).ready(function() {

        var inscritos;
        var seccion_plantel_id;
        var plantel_id;
        inscritos = '<?php print($inscriptos); ?>';
        seccion_plantel_id = '<?php print($seccion_plantel_id); ?>';
        plantel_id = '<?php print($plantel_id); ?>';
        $(".add-estud").unbind('click');
        $(".add-estud").on('click', function(e) {
            e.preventDefault();
            var id_incluir = new Array();
            var conEfecto = true;
            var showHTML = true;
            var method = 'post';
            var divResult = 'gridEstudiantes';
            var urlDir = '/planteles/matricula/incluirEstudiantesPorLotes/';
            var datos;
            id_incluir.push($(this).attr("data"));
            datos = {
                id_incluir: id_incluir,
                inscritos: inscritos,
                seccion_plantel_id: seccion_plantel_id,
                plantel_id: plantel_id,
                nuevoRegistro: 'si'

            };
            callback = function() {

            };
            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method);
            $("#incluir_Estudiante").dialog("close");
        });
        $(".add-estud-individual").unbind('click');
        $(".add-estud-individual").on('click', function(e) {
            e.preventDefault();
            var estudiante_id = $(this).attr("data");
            var conEfecto = true;
            var showHTML = true;
            var method = 'post';
            var divResult = 'dialog_escolaridad';
            var urlDir = '/planteles/matricula/caracterizarInscripcionIndividual/';
            var datos;
            var peticionActiva = false;
            datos = {
                estudiante_id: base64_encode(estudiante_id),
                seccion_plantel_id: base64_encode(seccion_plantel_id),
                plantel_id: base64_encode(plantel_id)

            };
            callback = function() {

            };
            if (!peticionActiva) {
                $("#incluir_Estudiante").dialog("close");
                $.ajax({
                    url: urlDir,
                    data: datos,
                    dataType: 'html',
                    type: method,
                    beforeSend: function() {
                        //mostrarNotificacion();
                        peticionActiva = true;
                        if (conEfecto) {
                            var url_image_load = "<div class='center'><img title='Su transacci&oacute;n est&aacute; en proceso' src='/public/images/ajax-loader-red.gif'></div>";
                            displayHtmlInDivId(divResult, url_image_load);
                        }
                    },
                    complete: function() {
                        peticionActiva = false;
                    },
                    success: function(resp, statusCode, jqXHR) {
                        try {
                            var json = jQuery.parseJSON(jqXHR.responseText);
                        } catch (e) {
                            $("#" + divResult).html(resp);
                            var dialog_escolaridad = $("#" + divResult).removeClass('hide').dialog({
                                modal: true,
                                width: '800px',
                                draggable: false,
                                resizable: false,
                                title: "<div class='widget-header widget-header-small'><h4 class='smaller orange'><i class='fa fa-group'></i> Caracterizar Inscripción</h4></div>",
                                title_html: true,
                                buttons: [
                                    {
                                        html: "<i class='icon-remove bigger-110'></i>&nbsp; Cerrar",
                                        "class": "btn btn-xs",
                                        click: function() {
                                            $(this).dialog("close");
                                        }
                                    },
                                    {
                                        html: "<i class='icon-plus bigger-110'></i>&nbsp; Guardar",
                                        "class": "btn btn-xs btn-primary",
                                        click: function() {
                                            $("#" + divResultInterno).html('').addClass('hide');
                                            var conEfectoInterno = true;
                                            var methodInterno = 'post';
                                            var divResultInterno = 'summary';
                                            var urlDirInterno = '/planteles/matricula/inscribirEstudiante/';
                                            var datosInterno;
                                            var inscripcion_regular = $("#inscripcion_regular").is(':checked') ? 1 : 0;
                                            var repitiente = $("#repitiente").is(':checked') ? 1 : 0;
                                            var materia_pendiente = $("#materia_pendiente").is(':checked') ? 1 : 0;
                                            var doble_inscripcion = $("#doble_inscripcion").is(':checked') ? 1 : 0;
                                            var observacion = $("#observaciones").val();
                                            datosInterno = {
                                                estudiante_id: base64_encode(estudiante_id),
                                                seccion_plantel_id: base64_encode(seccion_plantel_id),
                                                plantel_id: base64_encode(plantel_id),
                                                observacion: base64_encode(observacion),
                                                doble_inscripcion: (doble_inscripcion),
                                                repitiente: (repitiente),
                                                materia_pendiente: materia_pendiente,
                                                inscripcion_regular: (inscripcion_regular)

                                            };
                                            if (!peticionActiva) {
                                                $.ajax({
                                                    url: urlDirInterno,
                                                    data: datosInterno,
                                                    dataType: 'json',
                                                    type: methodInterno,
                                                    beforeSend: function() {
                                                        //mostrarNotificacion();
                                                        peticionActiva = true;
                                                        if (conEfectoInterno) {
                                                            var url_image_load = "<div class='center'><img title='Su transacci&oacute;n est&aacute; en proceso' src='/public/images/ajax-loader-red.gif'></div>";
                                                            displayHtmlInDivId(divResultInterno, url_image_load);
                                                        }
                                                    },
                                                    complete: function() {
                                                        peticionActiva = false;
                                                    },
                                                    success: function(json) {
                                                        if (json.statusCode === "success") {
                                                            dialog_success(json.mensaje, json.id, json.plantel, true);
                                                        }
                                                        else
                                                        if (json.statusCode === "error") {
                                                            dialogo_error(json.mensaje);
                                                        } else
                                                        if (json.statusCode === "mensaje") {
                                                            $("#" + divResultInterno).removeClass('hide');
                                                            displayDialogBox(divResultInterno, "error", json.mensaje);
                                                        }
                                                    },
                                                    statusCode: {
                                                        404: function() {
                                                            displayDialogBox(divResultInterno, "error", "404: No se ha encontrado el recurso solicitado. Recargue la P&aacute;gina e intentelo de nuevo.");
                                                        },
                                                        400: function() {
                                                            displayDialogBox(divResultInterno, "error", "400: Error en la petici&oacute;n, comuniquese con el Administrador del Sistema para correcci&oacute;n de este posible error.");
                                                        },
                                                        401: function() {
                                                            displayDialogBox(divResultInterno, "error", "401: Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.");
                                                        },
                                                        403: function() {
                                                            displayDialogBox(divResultInterno, "error", "403: Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.");
                                                        },
                                                        500: function() {
                                                            if (typeof callback == "function")
                                                                callback.call();
                                                            displayDialogBox(divResultInterno, "error", "500: Se ha producido un error en el sistema, Comuniquese con el Administrador del Sistema para correcci&oacute;n del m&iacute;smo.");
                                                        },
                                                        503: function() {
                                                            displayDialogBox(divResultInterno, "error", "503: El servidor web se encuentra fuera de servicio. Comuniquese con el Administrador del Sistema para correcci&oacute;n del error.");
                                                        },
                                                        999: function(resp) {
                                                            displayDialogBox(divResultInterno, "error", resp.status + ': ' + resp.responseText);
                                                        }
                                                    },
                                                    error: function(xhr, ajaxOptions, thrownError) {
                                                        //alert(thrownError);
                                                        if (xhr.status == '401') {
                                                            document.location.href = "http://" + document.domain + "/";
                                                        } else if (xhr.status == '400') {
                                                            displayDialogBox(divResultInterno, "error", "Recurso no encontrado. Recargue la P&aacute;gina e intentelo de nuevo.");
                                                        } else if (xhr.status == '500') {
                                                            displayDialogBox(divResultInterno, "error", "Se ha producido un error en el sistema, Comuniquese con el Administrador del Sistema para correcci&oacute;n del m&iacute;smo.");
                                                        } else if (xhr.status == '503') {
                                                            displayDialogBox(divResultInterno, "error", "El servidor web se encuentra fuera de servicio. Comuniquese con el Administrador del Sistema para correcci&oacute;n del error.");
                                                        }
                                                        else if (xhr.status == '999') {
                                                            displayDialogBox(divResultInterno, "error", xhr.status + ': ' + xhr.responseText);
                                                        }
                                                    }

                                                });
                                            } else {
                                                dialogo_peticion_activa();
                                            }
                                        }
                                    }
                                ]

                            });
                        }
                    },
                    statusCode: {
                        404: function() {
                            displayDialogBox(divResult, "error", "404: No se ha encontrado el recurso solicitado. Recargue la P&aacute;gina e intentelo de nuevo.");
                        },
                        400: function() {
                            displayDialogBox(divResult, "error", "400: Error en la petici&oacute;n, comuniquese con el Administrador del Sistema para correcci&oacute;n de este posible error.");
                        },
                        401: function() {
                            displayDialogBox(divResult, "error", "401: Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.");
                        },
                        403: function() {
                            displayDialogBox(divResult, "error", "403: Usted no est&aacute; autorizado para efectuar esta acci&oacute;n.");
                        },
                        500: function() {
                            if (typeof callback == "function")
                                callback.call();
                            displayDialogBox(divResult, "error", "500: Se ha producido un error en el sistema, Comuniquese con el Administrador del Sistema para correcci&oacute;n del m&iacute;smo.");
                        },
                        503: function() {
                            displayDialogBox(divResult, "error", "503: El servidor web se encuentra fuera de servicio. Comuniquese con el Administrador del Sistema para correcci&oacute;n del error.");
                        },
                        999: function(resp) {
                            displayDialogBox(divResult, "error", resp.status + ': ' + resp.responseText);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        //alert(thrownError);
                        if (xhr.status == '401') {
                            document.location.href = "http://" + document.domain + "/";
                        } else if (xhr.status == '400') {
                            displayDialogBox(divResult, "error", "Recurso no encontrado. Recargue la P&aacute;gina e intentelo de nuevo.");
                        } else if (xhr.status == '500') {
                            displayDialogBox(divResult, "error", "Se ha producido un error en el sistema, Comuniquese con el Administrador del Sistema para correcci&oacute;n del m&iacute;smo.");
                        } else if (xhr.status == '503') {
                            displayDialogBox(divResult, "error", "El servidor web se encuentra fuera de servicio. Comuniquese con el Administrador del Sistema para correcci&oacute;n del error.");
                        }
                        else if (xhr.status == '999') {
                            displayDialogBox(divResult, "error", xhr.status + ': ' + xhr.responseText);
                        }
                    }

                });
            } else {
                dialogo_peticion_activa();
            }

        });
    });

</script>