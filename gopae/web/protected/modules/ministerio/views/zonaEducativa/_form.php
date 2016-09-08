









<!-- Esto no se usa acá en este módulo ZonaEducativa-->























<?php
$this->breadcrumbs = array(
    'Planteles' => array('consultar/'),
    'Modificar Datos',
);
?>
<link rel="stylesheet" href="/public/js/jquery.upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="/public/js/jquery.upload/css/jquery.fileupload-ui.css">
<script type="text/javascript">
    $(document).ready(function() {
        //(isset(UserGroups::JEFE_ZONA)) ?

        var codigo_ner, estado_id, municipio_id, parroquia_id;
        var jefe_zona = '<?php print(UserGroups::JEFE_ZONA) ?>';
        var director = '<?php print(UserGroups::DIRECTOR) ?>';
        var jefe_drcee = '<?php print(UserGroups::JEFE_DRCEE) ?>';
        var group_id = '<?php echo Yii::app()->user->group; ?>';
        codigo_ner = '<?php ($model->codigo_ner !== '' && $model->codigo_ner !== null) ? print($model->codigo_ner) : print(null) ?>';
        isAdmin = '<?php (Yii::app()->user->pbac('planteles.modificar.admin')) ? print(true) : print(false) ?>';
        estado_id = '<?php ($model->estado_id) ? print($model->estado_id) : print(null) ?>';
        municipio_id = '<?php ($model->municipio_id) ? print($model->municipio_id) : print(null) ?>';
        parroquia_id = '<?php ($model->parroquia_id) ? print($model->parroquia_id) : print(null) ?>';
        poblacion_id = '<?php ($model->poblacion_id) ? print($model->poblacion_id) : print(null) ?>';
        urbanizacion_id = '<?php ($model->urbanizacion_id) ? print($model->urbanizacion_id) : print(null) ?>';
        id_plantel = '<?php ($model->id) ? print($model->id) : print(null) ?>';

        $('#Plantel_telefono_fijo').mask('(0299) 999-9999');
        $('#Plantel_telefono_otro').mask('(0499) 999-9999');
        if (codigo_ner != null && codigo_ner != '') {
            $("#ner").prop("checked", "checked");
            $("#ner").prop("disabled", "disabled");
            $("#divCod_plantel").addClass('hide');
            $("#Plantel_cod_plantelNer").val($("#Plantel_cod_plantel").val());
            document.getElementById('divCod_plantelNER').style.display = 'block';
            document.getElementById('divNombreNer').style.display = 'block';
        }
        else
        {
            $("#divNombreNer").addClass('hide');
            $("#divNER").addClass('hide');
        }
        if (!isAdmin)
            switch (group_id) {
                case jefe_drcee : // COORDINADOR DE CONTROL DE ESTUDIOS Y EVALUACION DE PLANTEL
                    {
                        // -- Widget -- \\
                        $("#identificacionPlantelHeader").addClass('hide');
                        $("#identificacionPlantelBody").addClass('hide');
                        // -- Campos -- \\
                        $("#divRegimen").addClass('hide');
                        $("#divCorreo").addClass('hide');
                        $("#divTelefonoFijo").addClass('hide');
                        $("#divTelefonoOtro").addClass('hide');

                        $("#divEstado").addClass('hide');
                        $("#divMunicipio").addClass('hide');
                        $("#divLongitud").addClass('hide');
                        $("#divLatitud").addClass('hide');
                        $("#divTipoUbicacion").addClass('hide');

                        // -- Pestañas -- \\
                        //$("#autoridades").addClass('hide');
                        $("#liOtros").addClass('hide');
                        $("#liMapas").addClass('hide');
                        break;
                    }
                case jefe_zona : // COORDINADOR DE ZONA EDUCATIVA
                    {
                        // -- Widget Body -- \\

                        // -- Campos -- \\
                        $("#Plantel_cod_plantel").attr('disabled', 'disabled');
                        $("#Plantel_cod_estadistico").attr('disabled', 'disabled');
                        $("#Plantel_estatus_plantel_id").attr('disabled', 'disabled');
                        $("#Plantel_annio_fundado").attr('disabled', 'disabled');
                        $("#Plantel_zona_educativa_id").attr('disabled', 'disabled');
                        $("#Plantel_distrito_id").attr('disabled', 'disabled');
                        $("#Plantel_tipo_dependencia_id").attr('disabled', 'disabled');
                        $("#Plantel_nombre").attr('disabled', 'disabled');

                        $("#Plantel_modalidad_id").attr('disabled', 'disabled');
                        $("#Plantel_correo").attr('disabled', 'disabled');

                        $("#Plantel_estado_id").attr('disabled', 'disabled');
                        $("#Plantel_municipio_id").attr('disabled', 'disabled');
                        $("#Plantel_parroquia_id").attr('disabled', 'disabled');
                        $("#Plantel_longitud").attr('disabled', 'disabled');
                        $("#Plantel_latitud").attr('disabled', 'disabled');
                        $("#Plantel_tipo_ubicacion_id").attr('disabled', 'disabled');

                        $("#proyectos_endogenos").attr('disabled', 'disabled');
                        $("#servicios").attr('disabled', 'disabled');
                        // -- Pestañas -- \\
                        // $("#autoridades").addClass('hide');
                        $("#liOtros").addClass('hide');
                        $("#liMapas").addClass('hide');
                        break;
                    }
                case director:
                    {
                        // -- Widget Body -- \\

                        // -- Campos -- \\
                        $("#Plantel_cod_plantel").attr('disabled', 'disabled');
                        $("#Plantel_cod_estadistico").attr('disabled', 'disabled');
                        $("#Plantel_estatus_plantel_id").attr('disabled', 'disabled');
                        $("#Plantel_annio_fundado").attr('disabled', 'disabled');
                        $("#Plantel_zona_educativa_id").attr('disabled', 'disabled');
                        $("#Plantel_distrito_id").attr('disabled', 'disabled');
                        $("#Plantel_tipo_dependencia_id").attr('disabled', 'disabled');
                        $("#Plantel_nombre").attr('disabled', 'disabled');
                        $("#Plantel_denominacion_id").attr('disabled', 'disabled');
                        $("#Plantel_estatus_plantel_id").attr('disabled', 'disabled');
                        $("#Plantel_zona_educativa_id").attr('disabled', 'disabled');

                        $("#Plantel_modalidad_id").attr('disabled', 'disabled');


                        // -- Pestañas -- \\
                        // $("#autoridades").addClass('hide');
                        $("#liOtros").addClass('hide');
                        $("#liMapas").addClass('hide');
                        break;
                    }
            }
        else {
            // -- Widget Body -- \\

            // -- Campos -- \\
            $("#Plantel_cod_plantel").attr('disabled', 'disabled');
            $("#Plantel_cod_estadistico").attr('disabled', 'disabled');
            $("#Plantel_estatus_plantel_id").attr('disabled', 'disabled');
            $("#Plantel_annio_fundado").attr('disabled', 'disabled');
            $("#Plantel_zona_educativa_id").attr('disabled', 'disabled');
            $("#Plantel_distrito_id").attr('disabled', 'disabled');
            $("#Plantel_tipo_dependencia_id").attr('disabled', 'disabled');
            $("#Plantel_nombre").attr('disabled', 'disabled');
            $("#Plantel_denominacion_id").attr('disabled', 'disabled');
            $("#Plantel_estatus_plantel_id").attr('disabled', 'disabled');
            $("#Plantel_zona_educativa_id").attr('disabled', 'disabled');

            $("#Plantel_modalidad_id").attr('disabled', 'disabled');


            // -- Pestañas -- \\
            // $("#autoridades").addClass('hide');
            $("#liOtros").addClass('hide');
            $("#liMapas").addClass('hide');
        }
        if (estado_id != null)
            $.ajax({
                type: "GET",
                url: "/zonaEducativa/zonaEducativa/seleccionarMunicipio",
                data: {estado_id: estado_id},
                success: function(data) {

                    $("#Plantel_municipio_id").html(data);
                    $("#Plantel_municipio_id").val(municipio_id);
                }
            });
        if (municipio_id != null)
            $.ajax({
                type: "GET",
                url: "/zonaEducativa/zonaEducativa/seleccionarParroquia",
                data: {municipio_id: municipio_id},
                success: function(data) {
                    $("#Plantel_parroquia_id").html(data);
                    $("#Plantel_parroquia_id").val(parroquia_id);

                }
            });


        /******************ALEXIS*************************/
        if (poblacion_id != null || urbanizacion_id != null) {
            var dato = {
                parroquia_id: parroquia_id,
            };
            $.ajax({
                type: "GET",
                data: dato,
                url: "/planteles/modificar/seleccionarUrbanizacion",
                update: "#Plantel_urbanizacion_id",
                success: function(resutl) {
                    $("#Plantel_urbanizacion_id").html(resutl);
                    $("#Plantel_urbanizacion_id").val(urbanizacion_id);


                    $.ajax({
                        type: "GET",
                        data: dato,
                        url: "/planteles/modificar/seleccionarPoblacion",
                        update: "#Plantel_poblacion_id",
                        success: function(result) {
                            $("#Plantel_poblacion_id").html(result);
                            $("#Plantel_poblacion_id").val(poblacion_id);
                        }


                    });

                },
            });
        }

        function log(message) {
            $("<div>").text(message).prependTo("#log");
            $("#log").scrollTop(0);
        }



        $("#query").autocomplete({
            source: "/planteles/modificar/ViaAutoComplete?id=" + parroquia_id,
            minLength: 1,
            select: function(event, ui) {
                log(ui.item ?
                        "Selected: " + ui.item.value + " aka " + ui.item.id :
                        "Nothing selected, input was " + this.value);
            }
        });


        /*******************
         if(parroquia_id!=null){

         $( "#query" ).autocomplete({
         source: "/planteles/modificar/ViaAutoComplete?id="+parroquia_id,
         minLength: 1,
         select: function( event, ui ) {
         log( ui.item ?
         "Selected: " + ui.item.value + " aka " + ui.item.id :
         "Nothing selected, input was " + this.value );
         }
         });

         }
         *********************/
        /*********************************************/

        var id = $("#id").val();
        $('#fileupload').fileupload({
            url: '/planteles/modificar/upload/id/' + id_plantel,
            acceptFileTypes: /(\.|\/)(jpe?g|png)$/i,
            maxFileSize: 5000000,
            singleFileUploads: true,
            beforeSend: function() {
                $("#tumbnailLogo").attr("src", "/public/img/loading_big.gif");
            },
            autoUpload: true,
            process: [
                {
                    action: 'load',
                    fileTypes: /(\.|\/)(jpe?g|png)$/i,
                    maxFileSize: 20000000 // 20MB
                },
                {
                    action: 'resize',
                    maxWidth: 1440,
                    maxHeight: 900
                },
                {
                    action: 'save'
                }
            ],
            error: function(jqXHR, textStatus, errorThrown) {
                $("#tumbnailLogo").attr("src", "/public/images/indice.svg");
                dialogo_error("Se produjo un error en la carga del Logo");
                // alert("Se produjo un error en la carga del Logo.");//ALEXIS ERROR DE CARGA


            }

        });
        $('#fileupload').bind('fileuploaddone', function(e, data) {
            var archivos = data.jqXHR.responseJSON.files;

            $("#notificacionArchivo").html("¡Archivo cargado con exito!");

            $.each(archivos, function(index, file) {
                var nombre = file.name;
                var ruta = "/public/uploads/LogoPlanteles/" + file.name;

                $("#tumbnailLogo").attr("src", "/public/uploads/LogoPlanteles/thumbnail/" + nombre);
                $("#nombreArchivo").val(nombre);
                $("#rutaArchivo").val(ruta);
            });
        });

        function getFileExtension(name)
        {
            var found = name.lastIndexOf('.') + 1;
            return (found > 0 ? name.substr(found) : "");
        }




    });


</script>




<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'plantelMod-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            //  'validateOnSubmit' => true,
            'validateOnType' => true,
            'validateOnChange' => true),
    ));
    echo CHtml::hiddenField('plantel_id', $plantel_id, array('id' => 'plantel_id'));
    ?>
    <?php //echo $form->errorSummary($model); ?>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#datosGenerales" data-toggle="tab">Datos generales</a></li>
            <li><a href="#desarrollo" data-toggle="tab">Desarrollo Endógeno</a></li>
            <li><a href="#servicio" data-toggle="tab">Servicios</a></li>
            <li><a href="#autoridades" data-toggle="tab">Autoridades</a></li>
            <!-- <li id="liOtros"><a href="#otros" data-toggle="tab">Otros</a></li> -->
            <?php
            if (Yii::app()->user->pbac('planteles.modificar.admin')) {
                ?>
                <li><a href="#aula" data-toggle="tab">Aula</a></li>
                <?php
            }
            ?>
        </ul>

        <div class="tab-content">

            <!--     <div class="tab-pane" id="desarrollo">Desarrollo endogeno</div> -->
            <!--   <div class="tab-pane" id="servicio">Servicios</div> -->
            <!--   <div class="tab-pane" id="autoridades">Autoridades</div> -->
            <!--<div class="tab-pane" id="otros">Otros</div>-->
            <!-- <div class="tab-pane" id="aula">Aula</div>-->


            <div class="tab-pane active" id="datosGenerales">

                <div  id="identificacionP" class="widget-box">

                    <div id="resultadoPlantel">
                    </div>

                    <div id="resultado">
                        <div class="infoDialogBox">
                            <p>
                                Debe Ingresar los Datos Generales del Plantel, los campos marcados con <span class="required">*</span> son requeridos.
                            </p>
                        </div>
                    </div>
                    <div id ="guardo" class="successDialogBox" style="display: none">
                        <p>
                            Registro exitoso
                        </p>
                    </div>
                    <br>
                    <div class="widget-header" style="border-width: 1px">
                        <h5>Identificaci&oacute;n Del Plantel</h5>
                        <div class="widget-toolbar">
                            <a  href="#" data-action="collapse">
                                <i class="icon-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div id="identificacionPlantel" class="widget-body" >
                        <div class="widget-body-inner" >
                            <div class="widget-main form">

                                <div class="row">
                                    <div class="col-md-2" style="height: 300px">


                                        <p align="center">
                                            <img id="tumbnailLogo" style="width:140px;height:140px;" class="img-thumbnail" alt="..." src="<?php
                                            if (empty($model->logo)) {
                                                echo Yii::app()->baseUrl . '/public/images/indice.svg';
                                            } else {
                                                echo '/public/uploads/LogoPlanteles/thumbnail/' . $model->logo;
                                            }
                                            ?>" />
                                        </p>


                                        <p align="center">
                                            <span class="btn btn-info btn-sm fileinput-button">
                                                <i class="fa fa-cloud-upload"></i>
                                                <span> Subir logo...</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input id="fileupload" type="file" name="files[]" >

                                            </span>

                                            <?php echo $form->hiddenField($model, 'logo', array('id' => 'nombreArchivo')); ?>
                                        </p>
                                    </div>

                                    <div id="divNER" class="col-md-3">
                                        <label class="col-md-12" for="ner" title="Núcleo de Educación Rural">NER</label>
                                        <input type="checkbox" id="ner" name="ner" value="" onchange="mostrarNer();" onclick="mostrarNer();" style="margin-left: 15px;">
                                    </div>

                                    <div id="divNombreNer" class="col-md-7">
                                        <?php echo $form->labelEx($model, 'codigo_ner', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'codigo_ner', array('class' => 'span-4', 'style' => 'width: 160px')); ?>
                                        <?php //echo $form->error($model, 'codigo_ner');   ?>
                                    </div>

                                    <div class="col-md-10"></div>

                                    <div  id="divCod_plantel" class="col-md-3" >
                                        <?php echo $form->labelEx($model, 'cod_plantel', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'cod_plantel', array('size' => 10, 'maxlength' => 10, 'class' => 'span-7')); ?><br>
                                        <?php //echo $form->error($model, 'cod_plantel');  ?>
                                    </div>

                                    <div  id="divCod_plantelNER" class="col-md-3" style="display: none">
                                        <?php echo $form->labelEx($model, 'cod_plantelNer', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'cod_plantelNer', array('size' => 4, 'maxlength' => 4, 'class' => 'span-7')); ?>
                                    </div>

                                    <div id="divCodEstadistico" class="col-md-3">
                                        <?php echo $form->labelEx($model, 'cod_estadistico', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'cod_estadistico', array('class' => 'span-7', 'size' => 10, 'maxlength' => 10)); ?>

                                        <?php //echo $form->error($model, 'cod_estadistico');  ?>
                                    </div>

                                    <div id="divDenominacion" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'denominacion_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'denominacion_id', CHtml::listData($denominacion, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'denominacion_id');   ?>
                                    </div>

                                    <div class="col-md-10"></div>

                                    <div id="divNombre"  class="col-md-3">
                                        <?php echo $form->labelEx($model, 'nombre', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'nombre', array('size' => 60, 'maxlength' => 150, 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'nombre');  ?>
                                    </div>

                                    <div id="divZonaEducativa" class="col-md-3">
                                        <?php echo $form->labelEx($model, 'zona_educativa_id', array("class" => "col-md-12")); ?>
                                        <?php
                                        echo $form->dropDownList(
                                                $model, 'zona_educativa_id', CHtml::listData($zonaEducativa, 'id', 'nombre'), array(
                                            'ajax' => array(
                                                'type' => 'GET',
                                                'update' => '#distrito_nuevo_id',
                                                'url' => CController::createUrl('crear/seleccionDistrito'),
                                            ),
                                            'empty' => array('' => '-Seleccione-'), 'class' => 'span-7',
                                                )
                                        );
                                        ?>
                                        <?php //echo $form->dropDownList($model, 'zona_educativa_id', CHtml::listData($zonaEducativa, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7'));   ?>
                                        <?php //echo $form->error($model, 'zona_educativa_id'); ?>
                                    </div>

                                    <div id="divTipoDependencia" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'tipo_dependencia_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'tipo_dependencia_id', CHtml::listData($tipoDependencia, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'tipo_dependencia_id');   ?>
                                    </div>

                                    <div class="col-md-10"></div>

                                    <div id="divDistrito" class="col-md-3">
                                        <?php echo $form->labelEx($model, 'distrito_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'distrito_id', CHtml::listData($distrito, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'id' => 'distrito_nuevo_id')); ?>
                                        <?php //echo $form->error($model, 'distrito_id');  ?>
                                    </div>

                                    <div id="divEstatusPlantel"  class="col-md-3">
                                        <?php echo $form->labelEx($model, 'estatus_plantel_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'estatus_plantel_id', CHtml::listData($estatusPlantel, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'estatus_plantel_id');  ?>
                                    </div>

                                    <div id="divAnnioFundado"  class="col-md-4">
                                        <?php echo $form->labelEx($model, 'annio_fundado', array("class" => "col-md-12")); ?>
                                        <?php
                                        $ini_year = 1900;
                                        $year_fin = date('Y') + 1;
                                        $anios = array();
                                        for ($i = $ini_year; $i <= $year_fin; $i++) {
                                            $anios["$i"] = $i;
                                        }

                                        echo $form->dropDownList($model, 'annio_fundado', $anios, array('empty' => '-Seleccione-', 'class' => 'span-7'));
                                        ?>
                                        <?php //echo $form->error($model, 'annio_fundado');   ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div id="datosUbicacionP" class="widget-box collapsed" >

                    <div class="widget-header">
                        <h5>Datos de Ubicaci&oacute;n</h5>

                        <div class="widget-toolbar">
                            <a data-action="collapse" href="#">
                                <i class="icon-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main form">

                                <div class="row">

                                    <div id="divEstado" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'estado_id', array("class" => "col-md-12")); ?>
                                        <?php
                                        echo $form->dropDownList(
                                                $model, 'estado_id', CHtml::listData($estado, 'id', 'nombre'), array(
                                            'ajax' => array(
                                                'type' => 'GET',
                                                'update' => '#Plantel_municipio_id',
                                                'url' => CController::createUrl('/zonaEducativa/zonaEducativa/seleccionarMunicipio'),
                                            ),
                                            'empty' => array('' => '-Seleccione-'), 'class' => 'span-7',
                                                )
                                        );
                                        ?>
                                        <?php //echo $form->error($model, 'estado_id');  ?>
                                    </div>

                                    <div id="divMunicipio" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'municipio_id', array("class" => "col-md-12")); ?>
                                        <?php
                                        echo $form->dropDownList($model, 'municipio_id', array(), array(
                                            'empty' => '-Seleccione-',
                                            'class' => 'span-7',
                                            'ajax' => array(
                                                'type' => 'GET',
                                                'update' => '#Plantel_parroquia_id',
                                                'url' => CController::createUrl('/zonaEducativa/zonaEducativa/seleccionarParroquia'),
                                            ),
                                            'empty' => array('' => '-Seleccione-'), 'class' => 'span-7',
                                        ));
                                        ?>
                                        <?php //echo $form->error($model, 'municipio_id');  ?>
                                    </div>

                                    <!--<div id="divParroquia" class="col-md-4">
                                    <?php echo $form->labelEx($model, 'parroquia_id', array("class" => "col-md-12")); ?>
                                    <?php
                                    echo $form->dropDownList($model, 'parroquia_id', array(), array(
                                        'empty' => '-Seleccione-',
                                        'id' => 'Plantel_parroquia_id',
                                        'class' => 'span-7',
                                        'ajax' => array(
                                            'type' => 'GET',
                                            'update' => '#Plantel_localidad_id',
                                            'url' => CController::createUrl('/zonaEducativa/zonaEducativa/seleccionarLocalidad'),
                                        ),
                                        'empty' => array('' => '-Seleccione-'),
                                    ));
                                    ?>
                                    <?php //echo $form->error($model, 'parroquia_id');   ?>
                                    </div>-->

                                    <!--ALEXIS EDITANDO-->
                                    <div id="divParroquia" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'parroquia_id', array("class" => "col-md-12")); ?>
                                        <?php
                                        echo $form->dropDownList($model, 'parroquia_id', array(), array(
                                            'empty' => '- SELECCIONE -',
                                            'id' => 'Plantel_parroquia_id',
                                            'class' => 'span-7',
                                            'ajax' => array(
                                                'type' => 'GET',
                                                'update' => '#Plantel_urbanizacion_id',
                                                'url' => CController::createUrl('/zonaEducativa/zonaEducativa/seleccionarUrbanizacion'),
                                                'success' => 'function(resutl) {
                                                $("#Plantel_urbanizacion_id").html(resutl);
                                                var parroquia_id=$("#Plantel_parroquia_id").val();

                                                var data=
                                                        {
                                                            parroquia_id: parroquia_id,

                                                        };
                                                $.ajax({
                                                    type:"GET",
                                                    data:data,
                                                    url:"/planteles/modificar/seleccionarPoblacion",
                                                    update:"#Plantel_poblacion_id",
                                                    success:function(result){  $("#Plantel_poblacion_id").html(result);}


                                                });

                                            }',
                                            ),
                                            'empty' => array('' => '- SELECCIONE -'),
                                        ));
                                        ?>

                                    </div>

                                    <div id="divPoblacion" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'poblacion_id', array("class" => "col-md-12")); ?>
                                        <?php
                                        echo $form->dropDownList($model, 'poblacion_id', array(), array(
                                            'empty' => '- SELECCIONE -',
                                            'id' => 'Plantel_poblacion_id',
                                            'class' => 'span-7',
                                            'empty' => array('' => '- SELECCIONE -'),
                                        ));
                                        ?>

                                    </div>

                                    <div id="divUrbanizacion" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'urbanizacion_id', array("class" => "col-md-12")); ?>

                                        <?php
                                        echo $form->dropDownList($model, 'urbanizacion_id', array(), array(
                                            'empty' => '- SELECCIONE -',
                                            'id' => 'Plantel_urbanizacion_id',
                                            'class' => 'span-7',
                                            'empty' => array('' => '- SELECCIONE -'),
                                        ));
                                        ?>

                                    </div>

                                    <div id="divTipoVia" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'tipo_via_id', array("class" => "col-md-12")); ?>

                                        <?php
                                        $lista = Plantel::model()->obtenerTipoVia();

                                        echo $form->dropDownList($model, 'tipo_via_id', CHtml::listData($lista, 'id', 'nombre'), array(
                                            'empty' => '- SELECCIONE -',
                                            'id' => 'Plantel_tipo_via_id',
                                            'class' => 'span-7',
                                            'empty' => array('' => '- SELECCIONE -'),
                                        ));
                                        ?>
                                    </div>



                                    <div id="divVia" class="col-md-4">


                                        <?php echo $form->labelEx($model, 'via', array("class" => "col-md-12")); ?>
                                        <div class="autocomplete-w1">
                                            <?php echo $form->textField($model, 'via', array('size' => 160, 'maxlength' => 160, 'placeholder' => 'Introduzca nombre de la via', 'class' => 'span-7', 'id' => 'query', 'onkeyup' => 'makeUpper("#query");')); ?>
                                            <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content" hidden="hidden"></div>
                                        </div>



                                    </div>


                                    <!--FIN ALEXIS-->
                                    <!--<div id="divLocalidad" class="col-md-4">
                                    <?php echo $form->labelEx($model, 'localidad_id', array("class" => "col-md-12")); ?>
                                    <?php
                                    echo $form->dropDownList($model, 'localidad_id', array(), array(
                                        'empty' => '-Seleccione-',
                                        'class' => 'span-7',
                                    ));
                                    ?>
                                    <?php //echo $form->error($model, 'localidad_id');  ?>
                                    </div>-->

                                    <div id="divDireccion" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'direccion', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'direccion', array('size' => 6, 'maxlength' => 100, 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'direccion');  ?>
                                    </div>

                                    <div id="divTelefonoFijo" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'telefono_fijo', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'telefono_fijo', array('size' => 11, 'maxlength' => 11, 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'telefono_fijo');  ?>
                                    </div>

                                    <div  id="divTelefonoOtro" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'telefono_otro', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'telefono_otro', array('size' => 11, 'maxlength' => 11, 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'telefono_otro');  ?>
                                    </div>

                                    <div id="divNFax" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'nfax', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'nfax', array('size' => 11, 'maxlength' => 11, 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'correo');  ?>
                                    </div>

                                    <div id="divCorreo" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'correo', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'correo', array('size' => 60, 'maxlength' => 100, 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'correo');  ?>
                                    </div>

                                    <div id="divZonaUbicacion" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'zona_ubicacion_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'zona_ubicacion_id', CHtml::listData($zona_ubicacion, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'correo');   ?>
                                    </div>


                                    <div class="row row-fluid">
                                        <div class="col-md-2" style="width: 140px">
                                            <label>Tipo Ubicación</label>
                                            <div class="row" style="padding-left: 10px;">
                                                <div id="divFronteriza" class="col-md-2" style="width: 140px">
                                                    <label for="fronteriza"><i>Fronteriza</i></label>
                                                    <input type="checkbox" name="fronteriza" id="fronteriza" value="1">
                                                    <?php //echo $form->checkBox($tipoUbicacion,'id');    ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2" style="width: 140px">
                                            <label>&nbsp;</label>
                                            <div class="row">
                                                <div id="divIndigena" class="col-md-2" style="width: 140px">
                                                    <label for="indigena"><i>Indígena</i></label>
                                                    <input type="checkbox" name="indigena" id="indigena" value="2">
                                                    <?php //echo $form->checkBox($tipoUbicacion,'id');    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2" style="width: 140px">
                                            <label>&nbsp;</label>
                                            <div class="row">
                                                <div id="divDificilAcceso" class="col-md-2" style="width: 140px">
                                                    <label for="dificil_acceso"><i>Difícil Acceso</i></label>
                                                    <input type="checkbox" name="dificil_acceso" id="dificil_acceso" value="3">
                                                    <?php //echo $form->checkBox($tipoUbicacion,'id');    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="widget-header">
                                    <h5>Coordenadas Geogr&aacute;ficas</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-body-inner">
                                        <div class="widget-main form">
                                            <div class="row">
                                                <div id="divLogitud" class="col-md-4">
                                                    <?php echo $form->labelEx($model, 'longitud', array("class" => "col-md-12")); ?>
                                                    <?php echo $form->textField($model, 'longitud', array('class' => 'span-7', 'maxlenght' => '30')); ?>
                                                    <?php //echo $form->error($model, 'longitud');   ?>
                                                </div>

                                                <div id="divLatitud" class="col-md-4">
                                                    <?php echo $form->labelEx($model, 'latitud', array("class" => "col-md-12")); ?>
                                                    <?php echo $form->textField($model, 'latitud', array('class' => 'span-7', 'maxlenght' => '30')); ?>
                                                    <?php //echo $form->error($model, 'latitud');    ?>
                                                </div>
                                                <div id='divBtnCoordenadas' class="col-md-4" style="padding-top: 27px;">
                                                    <button  id = "btnBuscarCoor"  class="btn btn-info btn-xs" type="button" >
                                                        <i class="icon-search"></i>
                                                        Ver en el Mapa
                                                    </button>
                                                </div>
                                            </div>
                                            <div class='space-6'></div>
                                            <center>
                                                <div id="map_canvas"  style="width:100%; height:400px; position:relative; -moz-box-shadow: 0 0 5px 5px #888;-webkit-box-shadow: 0 0 5px 5px#888;box-shadow: 0 0 5px 5px #888;"></div>
                                            </center>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div id="otrosDatosP" class="widget-box collapsed">
                    <div class="widget-header">
                        <h5>Otros Datos</h5>

                        <div class="widget-toolbar">
                            <a  href="#" data-action="collapse" >
                                <i class="icon-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div id="infoGeneral" class="widget-body" >
                        <div  class="widget-body-inner" >
                            <div class="widget-main form">

                                <div class="row">
                                    <div id="divClasePlantel" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'clase_plantel_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'clase_plantel_id', CHtml::listData($clasePlantel, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'clase_plantel_id');   ?>
                                    </div>

                                    <div id="divCategoria" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'categoria_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'categoria_id', CHtml::listData($categoria, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'categoria_id');  ?>
                                    </div>

                                    <div id="divCondicionesEstudio" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'condicion_estudio_id', array("class" => "col-md-12")); ?>
                                        <?php
                                        echo $form->dropDownList(
                                                $model, 'condicion_estudio_id', CHtml::listData($condicionEstudio, 'id', 'nombre'), array(
                                            'ajax' => array(
                                                'type' => 'GET',
                                                'update' => '#turno_nuevo_id',
                                                'url' => CController::createUrl('crear/asignacionTurno'),
                                            ),
                                            'empty' => array('' => '-Seleccione-'), 'class' => 'span-7',
                                                )
                                        );
                                        ?>
                                        <?php //echo $form->error($model, 'condicion_estudio_id');   ?>
                                    </div>

                                    <div id="divGenero" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'genero_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'genero_id', CHtml::listData($genero, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'genero_id');   ?>
                                    </div>

                                    <div id="divTurno" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'turno_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'turno_id', CHtml::listData($turno, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'id' => 'turno_nuevo_id')); ?>
                                        <?php //echo $form->error($model, 'turno_id');   ?>
                                    </div>

                                    <div id="divRegimen" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'modalidad_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'modalidad_id', CHtml::listData($modalidadEstudio, 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'modalidad_id');   ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">



                    <div class="col-md-6 wizard-actions pull-right">
                        <button type="submit" data-last="Finish" class="btn btn-primary btn-next">
                            Guardar
                            <i class="icon-save icon-on-right"></i>
                        </button>
                    </div>

                </div>
                <?php $this->endWidget(); ?>
            </div>

            <div class="tab-pane" id="desarrollo">
                <?php
                $this->renderPartial('_formEndogeno', array('dataProvider' => $dataProviderPE,
                    'listProyectosEndo' => $listProyectosEndo,
                    'plantel_id' => $plantel_id,
                        // 'ids_proyectosEndoP' => $ids_proyectosEndoP
                        )
                );
                ?>
            </div>

            <!-- ignacio -->
            <div class="tab-pane" id="servicio">
                <?php $this->renderPartial('_formServicio', array('listServicios' => $listServicios, 'plantel_id' => $plantel_id, 'dataProvider' => $dataProviderServ)); ?>
            </div>

            <div class="tab-pane" id="autoridades">
                <?php
                $this->renderPartial('_formAutoridades', array('autoridadPlantel' => $autoridadPlantel, 'cargoSelect' => $cargoSelect, 'plantel_id' => $plantel_id, 'dataProvider' => $dataProviderAutoridades));
                ?>
            </div>

            <div class="tab-pane" id="aula">
                <?php
                $this->renderPartial('_formAula', array('autoridadPlantel' => $autoridadPlantel, 'cargoSelect' => $cargoSelect, 'plantel_id' => $plantel_id, 'model' => $modelAula, /* , 'dataProvider' => $dataProviderAula */));
                ?>
            </div>


        </div>
    </div>
    <br>
    <div class="col-md-6">
        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("planteles/consultar/"); ?>" class="btn btn-danger">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
        <?php $this->renderPartial('/_accionesSobrePlantel', array('plantel_id' => $plantel_id)) ?>
    </div>
</div>


<div id="dialogos">
    <div id="dialog_calidad_servicio" class="hide">
        <?php $this->renderPartial('_formCalidadServicio'); ?>
    </div>
    <div id="dialog_modificar_servicio" class="hide">
        <?php $this->renderPartial('_formModificarServicio'); ?>
    </div>

    <div id="dialog_eliminar_servicio" class="hide">

        <div class="alertDialogBox bigger-110">
            <p class="bigger-110 bolder center grey">
                ¿Esta seguro de eliminar este servicio?
            </p>
        </div>

    </div>
    <div id="dialog_agregar_proyecto" class="hide">
        <div class="alert alert-info bigger-110">
            <p class="bigger-110 center"> ¿Desea agregar el servicio <strong><span></span></strong>?</p>
        </div>

        <div class="space-6"></div>

    </div>
    <div id="dialog_eliminar_proyecto" class="hide">
        <div class="alertDialogBox bigger-110">
            <p class="bigger-110 bolder center grey">
                ¿Esta seguro de eliminar este proyecto?
            </p>
        </div>
    </div>
    
    <div id = "dialog_error" class="hide">
        <div class="alertDialogBox bigger-110">
            <p class="bigger-110 grey">

            </p>
        </div>
    </div>
    <div id = "dialog_success" class="hide">
        <div class="successDialogBox bigger-110">
            <p class="bigger-110 bolder center grey">

            </p>
        </div>
    </div>
</div>
<div id="css_js">
    <script
        type='text/javascript'
        src='https://maps.googleapis.com/maps/api/js?key=AIzaSyC4TA6ZLZ_sIKtu2KOTjngWXonHPrpBoSE&sensor=false'
        >
    </script>
    <script>

        var options, a;
        jQuery(function() {

            function log(message) {
                $("<div>").text(message).prependTo("#log");
                $("#log").scrollTop(0);
            }

            var id = "";




            $("#Plantel_parroquia_id").change(function() {


                if ($("#Plantel_parroquia_id").val() != "") {

                    $('#query').attr('readonly', false);

                    id = $("#Plantel_parroquia_id").val();

                    $("#query").autocomplete({
                        source: "/planteles/modificar/ViaAutoComplete?id=" + id,
                        minLength: 1,
                        select: function(event, ui) {
                            log(ui.item ?
                                    "Selected: " + ui.item.value + " aka " + ui.item.id :
                                    "Nothing selected, input was " + this.value);
                        }
                    });

                }

                else {
                    $('#query').attr('readonly', true);
                    $("#query").autocomplete({
                        source: "/planteles/modificar/ViaAutoComplete?id=" + id,
                        minLength: 1,
                        select: function(event, ui) {
                            log(ui.item ?
                                    "Selected: " + ui.item.value + " aka " + ui.item.id :
                                    "Nothing selected, input was " + this.value);
                        }
                    });
                }



            });





        });
    </script>
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.upload/js/jquery.fileupload.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.upload/js/jquery.fileupload-process.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.upload/js/jquery.fileupload-image.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.upload/js/jquery.fileupload-validate.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.upload/js/jquery.fileupload-ui.js', CClientScript::POS_END);
    ?>
    <script src="/public/js/jquery.upload/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="/public/js/jquery.upload/js/load-image.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="/public/js/jquery.upload/js/canvas-to-blob.min.js"></script>
    <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
    <!-- blueimp Gallery script -->
    <script src="/public/js/jquery.upload/js/jquery.blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="/public/js/jquery.upload/js/jquery.iframe-transport.js"></script>
</div>
