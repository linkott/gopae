<div class="row col-md-12">
    <div id="scrolltable" style='border: 0px;background: #fff; overflow:auto;padding-right: 0px; padding-top: 0px; padding-left: 0px; padding-bottom: 0px;border-right: #DDDDDD 0px solid; border-top: #DDDDDD 0px solid;border-left: #DDDDDD 0px solid; border-bottom: #DDDDDD 0px solid;scrollbar-arrow-color : #999999; scrollbar-face-color : #666666;scrollbar-track-color :#3333333 ;height:600px; left: 28%; top: 300; width: 100%'>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'preinscritos-grid',
            'enableSorting' => false,
            'dataProvider' => $dataProvider,
            //'filter' => $model,
            'itemsCssClass' => 'table table-striped table-bordered table-hover',
            'pager' => array('pageSize' => 10),
            'afterAjaxUpdate' => "function(){

                            }",
            'summaryText' => '<strong><center>Total de Estudiantes Pre-inscritos: {end}</center></strong> ',
            'columns' => array(
                array(
                    'header' => '<center>Documento de Identidad</center>',
                    'name' => 'identificacion',
                    "type" => "raw"
                //'value' => 'strtr($data->estatus,array("A"=>"Activo", "E"=>"Inactivo"))',
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
                array(
                    'header' => $acciones,
                    "type" => "raw",
                    'name' => 'acciones',
                    'htmlOptions' => array('nowrap' => 'nowrap', 'width' => '15%'),
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
<script type="text/javascript">
    $(document).on('ready', function() {
        var peticionActiva = false;
        var inscritos;
        var plantel_id = $("#plantel_id").val();
        var seccion_plantel_id = $("#seccion_plantel_id").val();

        inscritos = '<?php print($inscritos); ?>';

        //$("#btnTerminarInscripcion").unbind('click');
        $("#btnTerminarInscripcion").click(function() {
            if (!peticionActiva) {
                var checkboxValuesRG = new Array();
                /* var checkboxValuesRP = new Array();
                 var checkboxValuesMP = new Array();
                 var checkboxValuesDI = new Array();
                 var checkboxValuesRC = new Array();
                 */
                $('input[name="inscripcionRegular[]"]').each(function() {
                    $(this).is(':checked') ? checkboxValuesRG.push(1) : checkboxValuesRG.push(0);
                });
                /* $('input[name="estudiantes[]"]:checked').each(function() {
                 checkboxValuesEst.push($(this).val());
                 });
                 $('input[name="estudiantes[]"]:checked').each(function() {
                 checkboxValuesEst.push($(this).val());
                 });
                 $('input[name="estudiantes[]"]:checked').each(function() {
                 checkboxValuesEst.push($(this).val());
                 });
                 $('input[name="estudiantes[]"]:checked').each(function() {
                 checkboxValuesEst.push($(this).val());
                 });
                 */
                divResult = 'dialogo';
                urlDir = '/planteles/matricula/inscribirEstudiantes/';
                datos = {
                    plantel_id: plantel_id,
                    inscritos: inscritos,
                    seccion_plantel_id: seccion_plantel_id,
                    checkboxValuesRG: checkboxValuesRG
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
                        }
                        peticionActiva = true;
                        Loading.show();
                    },
                    complete: function() {
                        peticionActiva = false;
                        Loading.hide();
                    },
                    success: function(json) {
                        if (json.statusCode === "success") {
                            dialog_success(json.mensaje, json.id, json.plantel);
                        }
                        else if (json.statusCode === "error") {
                            dialogo_error(json.mensaje);
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
                            displayDialogBox('dialog_asignarPlan', "error", xhr.status + ': ' + xhr.responseText);
                        }
                    }
                });
            } else {
                dialogo_peticion_activa();
            }
        });

        $("#btnRegresar").unbind('click');
        $("#btnRegresar").click(function(e) {
            e.preventDefault();
            if (!peticionActiva) {
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
                                $("#confirm").dialog("close");
                                peticionActiva = true;
                                window.location.assign("/planteles/matricula/inscripcion/id/" + seccion_plantel_id + '/plantel/' + plantel_id);


                            }
                        }

                    ]
                });

            } else {
                dialogo_peticion_activa();
            }
            // }
            ////     displayDialogBox(divResultAlerta, style, dataHtml);
            // }
        });
    });
</script>
