<div class="col-md-7 table-responsive">
    <div id="scrolltable" style='border: 0px;background: #fff; overflow:auto;padding-right: 0px; padding-top: 0px; padding-left: 0px; padding-bottom: 0px;border-right: #DDDDDD 0px solid; border-top: #DDDDDD 0px solid;border-left: #DDDDDD 0px solid; border-bottom: #DDDDDD 0px solid;scrollbar-arrow-color : #999999; scrollbar-face-color : #666666;scrollbar-track-color :#3333333 ;height:600px; left: 28%; top: 300; width: 100%'>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'pendientes-grid',
            'summaryText' => '<strong><center>Total de Estudiantes Disponibles Para la Inscripción: {end} <span title="Estudiantes Seleccionados" id="seleccionadosEst" class="red"></span></center></strong> ',
            'enableSorting' => false,
            'dataProvider' => $dataProviderPen,
            //'filter' => $model,
            'itemsCssClass' => 'table table-striped table-bordered table-hover table-inscripcion',
            'pager' => array('pageSize' => 10),
            'afterAjaxUpdate' => "function(){

                            }",
            'columns' => array(
                array(
                    "name" => "boton",
                    "type" => "raw",
                    'header' => '<div class="center">' . CHtml::checkBox('selec_todoEst', false, array('id' => 'selec_todoEst', 'title' => 'Seleccionar todos', 'class' => 'tooltipMatricula')) . "</div>"
                ),
                array(
                    'header' => '<center>Documento de Identidad</center>',
                    'name' => 'identificacion',
                    "type" => "raw",
                //'value' => '(is_object($data->grado) && isset($data->grado->nombre))? $data->grado->nombre: ""',
                ),
                array(
                    'header' => '<center>Edad</center>',
                    'name' => 'edad',
                    "type" => "raw"
                ),
                array(
                    'header' => '<center>Nombre y Apellido</center>',
                    'name' => 'nom_completo',
                    "type" => "raw"
                //'value' => '(is_object($data->turno) && isset($data->turno->nombre))? $data->turno->nombre: ""',
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
        ));
        ?>
    </div>
</div>

<div class="col-md-1 center">
    <div class = "col-md-12"><div class = "space-12"></div></div>
    <div class = "col-md-12" style = "padding-left:10px;">
        <button id="btnIncluir" title="Incluir los estudiantes Seleccionados del Listado 'Estudiantes disponibles para la Inscripción'." data-last = "Finish" class="btn btn-success btn-sm tooltipMatricula" data-placement="top">
            <i class="icon-arrow-right"></i>
        </button>
    </div>
    <div class = "col-md-12"><div class = "space-6"></div></div>

    <div class = "col-md-12" style = "padding-left:10px;">
        <button id="btnExcluir"  title="Exluir los estudiantes Seleccionados del Listado 'Estudiantes Pre-Inscritos'." data-last = "Finish"  class="btn btn-success btn-sm tooltipMatricula">
            <i class="icon-arrow-left"></i>
        </button>
    </div>
</div>
<div class="col-md-4">

    <div class="col-md-12" style="padding-top :3px">
        <div class = "col-md-12"><div class = "space-11"></div></div>
        <div id="scrolltable" style='border: 0px;background: #fff; overflow:auto;padding-right: 0px; padding-top: 0px; padding-left: 0px; padding-bottom: 0px;border-right: #DDDDDD 0px solid; border-top: #DDDDDD 0px solid;border-left: #DDDDDD 0px solid; border-bottom: #DDDDDD 0px solid;scrollbar-arrow-color : #999999; scrollbar-face-color : #666666;scrollbar-track-color :#3333333 ;height:600px; left: 28%; top: 300; width: 100%'>

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'inscritos-grid',
                'enableSorting' => false,
                'dataProvider' => $dataProviderIns,
                //'filter' => $model,
                'itemsCssClass' => 'table table-striped table-bordered table-hover table-inscripcion',
                'pager' => array('pageSize' => 10),
                'afterAjaxUpdate' => "function(){

                            }",
                'summaryText' => '<strong><center>Total de Estudiantes Pre-inscritos: {end} <span title="Estudiantes Seleccionados" id="seleccionadosIns" class="red"></span></center></strong> ',
                'columns' => array(
                    array(
                        'name' => 'boton',
                        "type" => "raw",
                        'header' => '<div class="center">' . CHtml::checkBox('selec_todoIns', false, array('id' => 'selec_todoIns', 'title' => 'Seleccionar todos', 'class' => 'tooltipMatricula')) . "</div>"
                    ),
                    array(
                        'header' => '<center>Documento de Identidad</center>',
                        'name' => 'identificacion',
                        "type" => "raw",
                    //'value' => '(is_object($data->grado) && isset($data->grado->nombre))? $data->grado->nombre: ""',
                    ),
                    array(
                        'header' => '<center>Nombre y Apellido</center>',
                        'name' => 'nom_completo',
                        "type" => "raw",
                    //'value' => '(is_object($data->turno) && isset($data->turno->nombre))? $data->turno->nombre: ""',
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
            ));
            ?>
        </div>
    </div>
    <div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
    <div class="hide" id="dialog_comfirmacion"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var peticionActiva = false;
        var plantel_id = $("#plantel_id").val();
        var seccion_plantel_id = $("#seccion_plantel_id").val();
        var style = 'alerta';
        var divResultAlerta = 'msgAlerta';
        var msgIncluirExcluir = "<p>Estimado usuario, debe seleccionar por lo menos un Estudiante para realizar esta acción.</p>";
        var msgGuardar = "<p>Estimado usuario, para realizar esta acción debe haber por lo menos un Estudiante incluido en la nueva lista.</p>";
        var inscritos;
        inscritos = '<?php print($inscritos); ?>';
        $('#seleccionadosEst').html('(0)');
        $('#seleccionadosIns').html('(0)');

        $('input[name="estudiantes[]"]').unbind('click');
        $('input[name="estudiantes[]"]').click(function() {
            var cantidad = 0;
            $('input[name="estudiantes[]"]').each(function() {
                if ($(this).is(':checked'))
                    cantidad++;
            });
            $('#seleccionadosEst').html('(' + cantidad + ')');
        });
        $('input[name="estudiantesIns[]"]').unbind('click');
        $('input[name="estudiantesIns[]"]').click(function() {
            var cantidad = 0;
            $('input[name="estudiantesIns[]"]').each(function() {
                if ($(this).is(':checked'))
                    cantidad++;
            });
            $('#seleccionadosIns').html('(' + cantidad + ')');
        });
        $("#selec_todoEst").unbind('click');
        $("#selec_todoEst").click(function() {
            var cantidad = 0;
            var select = $("#selec_todoEst").is(':checked') ? true : false;
            if (select) {
                $('input[name="estudiantes[]"]').each(function() {
                    $(this).attr('checked', 'checked');
                    cantidad++;
                });
            }
            else {
                $('input[name="estudiantes[]"]').each(function() {
                    $(this).attr('checked', false);
                });
            }
            $('#seleccionadosEst').html('(' + cantidad + ')');
        });
        $("#selec_todoIns").unbind('click');
        $("#selec_todoIns").click(function() {
            var cantidad = 0;
            var select = $("#selec_todoIns").is(':checked') ? true : false;
            if (select) {
                $('input[name="estudiantesIns[]"]').each(function() {
                    $(this).attr('checked', 'checked');
                    cantidad++;
                });
            }
            else {
                $('input[name="estudiantesIns[]"]').each(function() {
                    $(this).attr('checked', false);
                });
            }
            $('#seleccionadosIns').html('(' + cantidad + ')');
        });
        $("#btnIncluir").unbind('click');
        $("#btnIncluir").click(function() {
            if (!peticionActiva) {
                var checkboxValuesEst = new Array();
                $('input[name="estudiantes[]"]:checked').each(function() {
                    checkboxValuesEst.push($(this).val());
                });
                if (checkboxValuesEst.length > 0 && !jQuery.isEmptyObject(checkboxValuesEst)) {
                    $("#" + divResultAlerta).html("");
                    divResult = 'gridEstudiantes';
                    urlDir = '/planteles/matricula/incluirEstudiantesPorLotes/';
                    datos = {
                        plantel_id: plantel_id,
                        estudiantes: checkboxValuesEst,
                        inscritos: inscritos,
                        seccion_plantel_id: seccion_plantel_id
                    };
                    conEfecto = true;
                    showHTML = true;
                    method = 'post';
                    callback = function() {

                    };
//                    notify = new PNotify({
//                        title: 'Proceso de Matriculación',
//                        text: 'Estimado usuario, esta tarea puede tardar varios minutos. Espere mientras se culmina el proceso.',
//                        styling: 'fontawesome',
//                        icon: 'icon-group',
//                        delay: 1000,
//                        //animate_speed: 700,
////                        animation: {
////                            effect_in: 'scale',
////                            options_in: {easing: 'easeOutElastic'},
////                            effect_out: 'same',
////                            options_out: {easing: 'easeInCubic'}
////                        }
//                    });
                    $.ajax({
                        type: method,
                        url: urlDir,
                        dataType: "html",
                        data: datos,
                        beforeSend: function() {
                            if (conEfecto) {
                                var url_image_load = "<div class='center'><img title='Su transacci&oacute;n est&aacute; en proceso' src='/public/images/ajax-loader-red.gif'></div>";
                                displayHtmlInDivId(divResult, url_image_load);
                            }
                            mostrarNotificacion();
                            peticionActiva = true;
                        },
                        afterSend: function() {
                            peticionActiva = false;
                        },
                        success: function(resp) {
                            $("#" + divResult).html(resp);
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
                                displayDialogBox('dialog_asignarPlan', "error", xhr.status + ': ' + xhr.responseText);
                            }
                        }
                    });
//                executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method);
                }
                else {
                    displayDialogBox(divResultAlerta, style, msgIncluirExcluir);
                }
            } else {
                dialogo_peticion_activa();
            }


        });
        $("#btnExcluir").unbind('click');
        $("#btnExcluir").click(function() {

            if (!peticionActiva) {
                var checkboxValuesIns = new Array();
                $('input[name="estudiantesIns[]"]:checked').each(function() {
                    checkboxValuesIns.push($(this).val());
                });
                if (checkboxValuesIns.length > 0 && !jQuery.isEmptyObject(checkboxValuesIns)) {
                    $("#" + divResultAlerta).html("");
                    divResult = 'gridEstudiantes';
                    urlDir = '/planteles/matricula/excluirEstudiantesPorLotes/';
                    datos = {
                        plantel_id: plantel_id,
                        estudiantes: checkboxValuesIns,
                        inscritos: inscritos,
                        seccion_plantel_id: seccion_plantel_id
                    };
                    conEfecto = true;
                    showHTML = true;
                    method = 'post';
                    callback = function() {

                    };
                    $.ajax({
                        type: method,
                        url: urlDir,
                        dataType: "html",
                        data: datos,
                        beforeSend: function() {
                            if (conEfecto) {
                                var url_image_load = "<div class='center'><img title='Su transacci&oacute;n est&aacute; en proceso' src='/public/images/ajax-loader-red.gif'></div>";
                                displayHtmlInDivId(divResult, url_image_load);
                            }
                            mostrarNotificacion();
                            peticionActiva = true;
                        },
                        afterSend: function() {
                            peticionActiva = false;
                        },
                        success: function(resp) {
                            $("#" + divResult).html(resp);
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
                                displayDialogBox('dialog_asignarPlan', "error", xhr.status + ': ' + xhr.responseText);
                            }
                        }

                    });
                }
                else {
                    displayDialogBox(divResultAlerta, style, msgIncluirExcluir);
                }
            } else {
                dialogo_peticion_activa();
            }
        });
        $("#btnGuardarInscripcion").unbind('click');
        $("#btnGuardarInscripcion").click(function() {
            if (!peticionActiva) {
                if (inscritos.length > 2) {
                    $("#confirm").removeClass('hide').dialog({
                        width: 450,
                        resizable: false,
                        draggable: false,
                        modal: true,
                        position: ['center', 50],
                        title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i> Proceso de Matriculación</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                                "class": "btn btn-danger btn-xs",
                                click: function() {
                                    $(this).dialog("close");
                                }
                            },
                            {
                                html: "<i class='icon-ok bigger-110'></i>&nbsp; Confirmar",
                                "class": 'btn btn-primary btn-xs',
                                click: function() {
                                    divResult = 'gridEstudiantes';
                                    urlDir = '/planteles/matricula/preCaracterizarInscripcion/';
                                    datos = {
                                        plantel_id: plantel_id,
                                        inscritos: inscritos,
                                        seccion_plantel_id: seccion_plantel_id
                                    };
                                    conEfecto = true;
                                    method = 'post';
                                    $.ajax({
                                        type: method,
                                        url: urlDir,
                                        dataType: "json",
                                        data: datos,
                                        beforeSend: function() {
                                            if (conEfecto) {
                                                var url_image_load = "<div class='center'><img title='Su transacci&oacute;n est&aacute; en proceso' src='/public/images/ajax-loader-red.gif'></div>";
                                                displayHtmlInDivId(divResult, url_image_load);
                                                mostrarNotificacion();
                                                peticionActiva = true;
                                            }
                                        },
                                        afterSend: function() {
                                            peticionActiva = false;
                                        },
                                        success: function(resp) {
                                            $("#confirm").dialog("close");
                                            window.location.assign("/planteles/matricula/caracterizarInscripcion/c/" + resp.codigo);
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
                                                displayDialogBox('dialog_asignarPlan', "error", xhr.status + ': ' + xhr.responseText);
                                            }
                                        }
                                    });
                                }
                            }

                        ]
                    });
                }
                else {
                    displayDialogBox(divResultAlerta, style, msgGuardar);
                }
            } else {
                dialogo_peticion_activa();
            }
            // }
            ////     displayDialogBox(divResultAlerta, style, dataHtml);
            // }
        });
        $("#btnIncluirEst").unbind('click');
        $("#btnIncluirEst").click(function() {
            $.ajax({
                url: "/planteles/matricula/incluirEstudiante",
                data: {estudiantes: $("#estudiante-form").serialize(), inscritos: inscritos,
                    plantel_id: plantel_id,
                    seccion_plantel_id: seccion_plantel_id
                },
                dataType: 'html',
                type: 'post',
                success: function(resp) {
                    $("#incluir_Estudiante").removeClass('hide').dialog({
                        width: 1100,
                        resizable: false,
                        draggable: false,
                        position: ['center', 50],
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-search'></i> Buscar a estudiante a incluir </h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                                "class": "btn btn-danger btn-xs",
                                click: function() {
                                    $(this).dialog("close");
                                    Loading.hide();
                                }
                            },
                        ],
                        close: function() {
                            // $("#dialog-planEstudio").html("");
                        }
                    });
                    $("#incluir_Estudiante").html(resp);
                }

            });
        });
        $("#btnRegistroNuevo").unbind('click');
        $("#btnRegistroNuevo").bind('click', function() {

            registrarEstudiante(inscritos, seccion_plantel_id, plantel_id);
        });
        function registrarEstudiante(inscritos, seccion_plantel_id, plantel_id) {
            $.mask.definitions['~'] = '[+-]';
            direccion = '/planteles/matricula/dialogoRegistro';
            title = 'Nuevo Registro';
            //var data = {id: id};

            if (!peticionActiva) {
                $.ajax({
                    url: direccion,
                    //data: data,
                    dataType: 'html',
                    type: 'get',
                    success: function(result)
                    {
                        $("#dialogPantalla").removeClass('hide').dialog({
                            modal: true,
                            width: '900px',
                            draggable: false,
                            resizable: false,
                            position: ['center', 10],
                            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-pencil'></i> " + title + "</h4></div>",
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

                                        //                    var plantel_id=$("#plantel_id").val();
                                        //                    var seccion_plantel_id = $("#seccion_plantel_id").val();
                                        //                    var inscritos = $("#inscritos").val();




                                        var cedulaRepresentante = $("#cedulaRepresentante").val();
                                        var nombreRepresentante = $("#nombreRepresentante").val();
                                        var apellidoRepresentante = $("#apellidoRepresentante").val();
                                        var emailRepresentante = $("#email").val();
                                        var afinidad = $("#afinidad").val();
                                        var telefonoMovil = $("#telefonoMovil").val();
                                        var telefonoLocal = $("#telefonoLocal").val();
                                        var cedula = $("#cedula").val();
                                        var nombreEstudiante = $("#Estudiante_nombres").val();
                                        var apellidoEstudiante = $("#Estudiante_apellidos").val();
                                        var cedulaEscolar = $("#cedula_escolar").val();
                                        var fechaNacimiento = $("#fecha").val();
                                        var estatura = $("#Estudiante_estatura").val();
                                        var lateralidad = $("#Estudiante_lateralidad").val();
                                        var estado = $("#estado_id").val();
                                        var estadoEstudiante = $("#estudiante_estado_id").val();
                                        var sexo = $("#sexo").val();

                                        //                        var plantel_id=$("#plantel_id").val();
                                        //                        var seccion_plantel_id = $("#seccion_plantel_id").val();
                                        //                        var inscritos = $("#inscritos").val();
                                        //
                                        var nombreRepresentante = $("#nombreRepresentante").val();
                                        var apellidoRepresentante = $("#apellidoRepresentante").val();
                                        var cedulaRepresentante = $("#cedulaRepresentante").val();
                                        var emailRepresentante = $("#email").val();
                                        var afinidad = $("#afinidad").val();
                                        var telefonoMovil = $("#telefonoMovil").val();
                                        var telefonoLocal = $("#telefonoLocal").val();
                                        var cedula = $("#cedula").val();
                                        var nombreEstudiante = $("#Estudiante_nombres").val();
                                        var apellidoEstudiante = $("#Estudiante_apellidos").val();
                                        var cedulaEscolar = $("#cedula_escolar").val();
                                        var fechaNacimiento = $("#fecha").val();
                                        var estatura = $("#Estudiante_estatura").val();
                                        var lateralidad = $("#Estudiante_lateralidad").val();
                                        var estado = $("#estado_id").val();
                                        var estadoEstudiante = $("#estudiante_estado_id").val();
                                        var fechaNacimientoRepresentante = $("#fecha_nacimiento_representante").val();
                                        var divResult = "guardoRegistro";
                                        var urlDir = "/planteles/matricula/agregarEstudiante/"; //ALEXIS ACCION DONDE SE ENVIA EL ARREGLO

                                        var datos = {DatosGenerales: {
                                                plantel_id: plantel_id,
                                                seccion_plantel_id: seccion_plantel_id,
                                                inscritos: inscritos,
                                                cedulaRepresentante: cedulaRepresentante,
                                                nombreRepresentante: nombreRepresentante,
                                                apellidoRepresentante: apellidoRepresentante,
                                                emailRepresentante: emailRepresentante,
                                                telefonoMovil: telefonoMovil,
                                                telefonoLocal: telefonoLocal,
                                                afinidad: afinidad,
                                                cedula: cedula,
                                                nombreEstudiante: nombreEstudiante,
                                                apellidoEstudiante: apellidoEstudiante,
                                                cedulaEscolar: cedulaEscolar,
                                                fechaNacimiento: fechaNacimiento,
                                                estatura: estatura,
                                                lateralidad: lateralidad,
                                                estado: estado,
                                                estadoEstudiante: estadoEstudiante,
                                                fecha_nacimiento: fechaNacimientoRepresentante,
                                                sexo: sexo
                                            }


                                        };
                                        $.ajax({
                                            url: urlDir,
                                            data: datos,
                                            dataType: 'html',
                                            type: 'post',
                                            beforeSend: function() {
                                                mostrarNotificacion();
                                                peticionActiva = false;
                                            },
                                            afterSend: function() {
                                                peticionActiva = false;
                                            },
                                            success: function(resp, statusCode, respuestaJson) {

                                                try {
                                                    var json = jQuery.parseJSON(respuestaJson.responseText);
                                                    if (json.statusCode == 'success') {

                                                        var id_incluir_var = json.idEstudiante;
                                                        var id_incluir = new Array();
                                                        id_incluir.push(id_incluir_var);
                                                        var divResult = 'gridEstudiantes';
                                                        var urlDir = '/planteles/matricula/incluirEstudiantesPorLotes/';
                                                        var datos = {
                                                            id_incluir: id_incluir,
                                                            inscritos: inscritos,
                                                            nuevoRegistro: 'si',
                                                            plantel_id: plantel_id,
                                                            seccion_plantel_id: seccion_plantel_id
                                                        };
                                                        var conEfecto = true;
                                                        var showHTML = true;
                                                        var method = 'post';
                                                        $.ajax({
                                                            url: urlDir,
                                                            data: datos,
                                                            dataType: 'html',
                                                            type: 'post',
                                                            beforeSend: Loading.show(),
                                                            success: function(respuesta) {
                                                                $("#dialogPantalla").dialog("close");
                                                                Loading.hide(),
                                                                        $("#gridEstudiantes").html(respuesta);
                                                            }

                                                        });
                                                    } else {
                                                        $('#infoEstudiante').removeClass().addClass('alertDialogBox');
                                                        $('#infoEstudiante').html(json.mensaje);
                                                    }
                                                } catch (e) {
                                                    dialogo_error(resp);
                                                }
                                            }
                                        });
                                        //$(this).dialog("close");

                                    }
                                }



                            ],
                        });
                        $("#dialogPantalla").html(result);
                    }
                });
            } else {
                dialogo_peticion_activa();
            }
            // Loading.hide();
        }

    });
</script>
