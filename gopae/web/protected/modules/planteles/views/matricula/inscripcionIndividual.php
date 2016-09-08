<?php
$this->breadcrumbs = array(
    'Planteles' => array('/planteles'),
    'Secciones' => array('/planteles/seccionPlantel/admin/id/' . base64_encode($plantel_id)),
    'Inscripcion Individual'
);
?>
<div class = "widget-box collapsed">

    <div class = "widget-header">
        <h5>Identificación del Plantel <?php echo '"' . $datosPlantel['nom_plantel'] . '"'; ?></h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: none;" class = "widget-body-inner">
            <div class = "widget-main">

                <div class="row row-fluid">
                    <?php $this->renderPartial('_informacionPlantel', array('datosPlantel' => $datosPlantel)); ?>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="widget-box">
    <div class = "widget-header">
        <h5>Datos de la Sección</h5>
        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class = "widget-body">
        <div style = "display:block;" class = "widget-body-inner">
            <div class = "widget-main">
                <div class="row row-fluid">
                    <div id="msgAlerta">
                    </div>

                    <div class = "col-lg-12"><div class = "space-6"></div></div>
                    <div id="gridEstudiantes" class="col-md-12" >
                        <div class="widget-main form">

                            <div class="row">

                                <div class="col-md-11" id ="detallesSec">

                                    <?php $this->renderPartial('_informacionSeccion', array('datosSeccion' => $datosSeccionInfo)); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="widget-box">
    <div class = "widget-header">
        <h5>Matrícula <?php echo $datosSeccion['grado'] . ' Sección "' . $datosSeccion['seccion'] . '"'; ?></h5>
        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class = "widget-body">
        <div style = "display:block;" class = "widget-body-inner">
            <div class = "widget-main">

                <div id="msgAlerta">
                </div>

                <?php
                echo CHtml::hiddenField('plantel_id', $plantel_id);
                echo CHtml::hiddenField('individual', $individual);
                echo CHtml::hiddenField('seccion_plantel_id', $seccion_plantel_id);
                ?>
                <div class="row-fluid">

                    <div class="col-md-12">

                        <div class="col-md-12 text-right">

                            <div class = "pull-right wizard-actions" style = "padding-left:10px;">
                                <button id="btnRegistroIndividualNuevo" data-last = "Finish" class = "btn btn-success btn-next btn-sm">
                                    Registrar Nuevo Estudiante
                                    <i class = "fa fa-plus icon-on-right"></i>
                                </button>
                            </div>

                            <div class = "pull-right wizard-actions" style = "padding-left:10px;">
                                <button id="btnIncluirEst" data-last = "Finish" class = "btn btn-success btn-next btn-sm tooltipMatricula">
                                    Buscar Estudiante Existente
                                    <i class="fa fa-search-plus icon-on-right"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12"> <div class="space-6"></div></div>
                    <div class="col-md-12">
                        <div id="div-result-message" class=""></div>
                    </div>

                </div>

                <div class="space-6"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div id ="estudiantesIns">
                        </div>
                        <div>

                            <?php
                            //var_dump(SeccionPlantel::model()->existeEstudiantesInscriptosEnSeccion($seccion_plantel_id));

                            $this->widget(
                                    'zii.widgets.grid.CGridView', array(
                                'id' => 'estudiantesInscrit',
                                'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                'dataProvider' => SeccionPlantel::model()->existeEstudiantesInscritosIndividualEnSeccion($seccion_plantel_id),
                                'summaryText' => '<strong><center>Total de Estudiantes Inscritos: {count}</center></strong> ',
                                'afterAjaxUpdate' => "function(){ $('.change-status').unbind('click');
                                    $('.change-status').on('click',
                                            function(e) {
                                                e.preventDefault();
                                                var id = $(this).attr('data-id');
                                                var description = $(this).attr('data-descripcion');
                                                var accion = $(this).attr('data-action');
                                                var inscripcion_id = $(this).attr('data-inscripcion_id');
                                                cambiarEstatusEstudiante(id, description, accion, inscripcion_id);
                                            }
                                    ); }",
                                'columns' => array(
                                    array(
                                        'name' => 'dni',
                                        'header' => '<center><b>Documento Identidad</b></center>',
                                        'value' => array($this, 'columnaDocumentoIdentidad'),
                                        'type' => 'raw'
                                    ),
                                    array(
                                        'name' => 'fecha_nacimiento',
                                        'header' => '<center><b>Edad</b></center>',
                                        'value' => array($this, 'columnaEdad'),
                                        'type' => 'html'
                                    ),
                                    array(
                                        'name' => 'nomape',
                                        'header' => '<center><b>Nombre y Apellido</b></center>'
                                    ),
                                    array(
                                        'type' => 'raw',
                                        'header' => '<center><b>Acciones</b></center>',
                                        'value' => array($this, 'columnaAccionesIndividual'),
                                        'htmlOptions' => array('width' => '83px', 'nowrap' => 'nowrap'),
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
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class = "pull-right wizard-actions " style = "padding-left:10px;">
                        <a  href="<?php echo Yii::app()->createUrl("/planteles/matricula/reporte/id/" . base64_encode($plantel_id) . '/seccion/' . base64_encode($seccion_plantel_id)); ?>"  id="reporteMatricula"   class = "btn btn-primary btn-next btn-sm ">
                            Imprimir Matricula
                            <i class="fa fa-file-pdf-o icon-on-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="col-md-12">
    <div class="col-md-6">
        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("/planteles/seccionPlantel/admin/id/" . base64_encode($plantel_id)); ?>" class="btn btn-danger">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
        <?php $this->renderPartial('/_accionesSobrePlantel', array('plantel_id' => $plantel_id)) ?>
    </div>
    



</div>

<div id="dialogPantalla"></div>

<div class ="hide" id="incluir_Estudiante" ></div>
<div class ="hide" id="dialog_escolaridad" ></div>
<div class ="hide" id="dialog_success" ><p></p></div>
<div class ="hide" id="dialog_error" ><p></p></div>
<div id="confirm-status" class="hide">
    <div class="alert alert-info bigger-110">
        <p class="bigger-110 center">¿Desea usted <strong><span class="confirm-action"></span></strong> al estudiante <strong><span id="confirm-description"></span></strong>?</p>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/pnotify.custom.min.css" media="screen, projection" />
<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/matricula.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/pnotify.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
?>

<script>
    $(document).ready(function() {
        $.mask.definitions['~'] = '[+-]';
        var peticionActiva = false;
        var seccion_plantel_id = '<?php print($seccion_plantel_id); ?>';
        var plantel_id = '<?php print($plantel_id); ?>';
        var inscritos = '<?php print($inscritos); ?>';
        var individual = $("#individual").val();

        $("#reporteMatricula").unbind('click');
        $("#reporteMatricula").bind('click', function(e) {
            mostrarNotificacion();
        });
        $("#btnRegistroIndividualNuevo").bind('click', function() {
            registrarEstudiante();
        });
        //---- DESPLIEGA POP-UP DEL FORMULARIO
        function registrarEstudiante() {

            direccion = '/planteles/matricula/dialogoRegistro/key/<?php print($_GET['key']); ?>';
            title = 'Nuevo Registro';
            // Loading.show();


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
                            dragable: false,
                            resizable: false,
                            position: ['center', 10],
                            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-pencil'></i> " + title + "</h4></div>",
                            title_html: true,
                            buttons: [
                                {
                                    html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                                    "class": "btn btn-danger btn-xs",
                                    click: function() {
                                        //refrescarGrid();
                                        peticionActiva = false;
                                        $("#dialogPantalla").html('');
                                        $(this).dialog("close");
                                    }

                                },
                                {
                                    html: "<i class='icon-save info bigger-110'></i>&nbsp; Guardar",
                                    "class": "btn btn-primary btn-xs",
                                    "id": "botonSubmit",
                                    click: function() {
                                        var boxes = $('.escolaridad-check');
                                        if (boxes.filter(":checked").length == 0) {

                                            alerta = "Debe tildar al menos una opción de escolaridad";
                                            $('#infoEscolaridad').removeClass().addClass('alertDialogBox');
                                            $('#infoEscolaridad p').html(alerta);
                                        }

                                        else {
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
                                            var inscripcionRegular = $("#inscripcion_regular").val();
                                            var materiaPendiente = $("#materia_pendiente").val();
                                            var repitiente = $("#repitiente").val();
                                            var repitienteCompleto = $("#repitiente_completo").val();
                                            var diferido = $("#diferido").val();
                                            var dobleInscripcion = $("#doble_inscripcion").val();
                                            var sexo = $("#sexo").val();


                                            var nombreRepresentante = $("#nombreRepresentante").val();
                                            var apellidoRepresentante = $("#apellidoRepresentante").val();
                                            var cedulaRepresentante = $("#cedulaRepresentante").val();
                                            var emailRepresentante = $("#email").val();
                                            var afinidad = $("#afinidad").val();
                                            var cedula = $("#cedula").val();
                                            var nombreEstudiante = $("#Estudiante_nombres").val();
                                            var apellidoEstudiante = $("#Estudiante_apellidos").val();
                                            var cedulaEscolar = $("#cedula_escolar").val();
                                            var fechaNacimiento = $("#fecha").val();
                                            var estatura = $("#Estudiante_estatura").val();
                                            var lateralidad = $("#Estudiante_lateralidad").val();
                                            var estado = $("#estado_id").val();
                                            var inscripcionRegular = $("#inscripcion_regular").is(':checked') ? 1 : 0;
                                            var materiaPendiente = $("#materia_pendiente").is(':checked') ? 1 : 0;
                                            var repitiente = $("#repitiente").is(':checked') ? 1 : 0;
                                            var repitienteCompleto = $("#repitiente_completo").is(':checked') ? 1 : 0;
                                            var diferido = $("#diferido").is(':checked') ? 1 : 0;
                                            var dobleInscripcion = $("#doble_inscripcion").is(':checked') ? 1 : 0;
                                            var materia_pendiente = $("#doble_inscripcion").is(':checked') ? 1 : 0;
                                            var observacion = $("#observaciones").val();
                                            var divResult = "guardoRegistro";
                                            var estadoEstudiante = $("#estudiante_estado_id").val();
                                            var fechaNacimientoRepresentante = $("#fecha_nacimiento_representante").val();
                                            var urlDir = "/planteles/matricula/agregarEstudianteInscribir/"; //ALEXIS ACCION DONDE SE ENVIA EL ARREGLO

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
                                                    inscripcionRegular: inscripcionRegular,
                                                    materiaPendiente: materiaPendiente,
                                                    repitiente: repitiente,
                                                    repitienteCompleto: repitienteCompleto,
                                                    diferido: diferido,
                                                    dobleInscripcion: dobleInscripcion,
                                                    fecha_nacimiento: fechaNacimientoRepresentante,
                                                    estadoEstudiante: estadoEstudiante,
                                                    plantel_id: plantel_id,
                                                            seccion_plantel_id: seccion_plantel_id,
                                                            inscripcionRegular: inscripcionRegular,
                                                            materiaPendiente: materiaPendiente,
                                                            repitiente: repitiente,
                                                            repitienteCompleto: repitienteCompleto,
                                                            diferido: diferido,
                                                            dobleInscripcion: dobleInscripcion,
                                                            seccion_plantel_id: seccion_plantel_id, observacion: observacion,
                                                    sexo: sexo
                                                }


                                            };
                                            var conEfecto = true;
                                            var showHTML = true;
                                            var method = "POST";
                                            var llaveDobleEnvio = true;

                                            $.ajax({
                                                url: urlDir,
                                                data: datos,
                                                dataType: 'html',
                                                type: 'post',
                                                beforeSend: function() {

                                                    mostrarNotificacion();

                                                    peticionActiva = true;
                                                },
                                                afterSend: function() {

                                                    peticionActiva = false;
                                                },
                                                success: function(resp, statusCode, respuestaJson) {

                                                    try {
                                                        var json = jQuery.parseJSON(respuestaJson.responseText);
                                                        if (json.statusCode == 'success') {


                                                            peticionActiva = false;
                                                            $("#dialogPantalla").dialog("close");
                                                            $('#estudiantesInscrit').yiiGridView('update', {
                                                                data: $(this).serialize()
                                                            });

                                                            $('#infoEstudiante').removeClass().addClass('hide');


                                                        } else {
                                                            //$('#infoEstudiante').removeClass().addClass('alertDialogBox');
                                                            //$('#infoEstudiante').html(json.mensaje);
                                                            dialogo_error(json.mensaje);
                                                        }

                                                    } catch (e) {
                                                        dialogo_error(resp);
                                                    }

                                                }
                                            });

                                        }
                                    }
                                }

                            ]
                        });
                        $("#dialogPantalla").html(result);
                    }
                });
            } else {
                dialogo_peticion_activa();
            }

        }

        $("#btnIncluirEst").click(function() {
            $.ajax({
                url: "/planteles/matricula/incluirEstudiante",
                data: {estudiantes: $("#estudiante-form").serialize(), inscritos: inscritos,
                    plantel_id: plantel_id,
                    seccion_plantel_id: seccion_plantel_id,
                    individual: individual
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
    });
</script>


