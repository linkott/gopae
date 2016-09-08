<?php
/* @var $this PlantelController */
/* @var $model Plantel */
/* @var $form CActiveForm */
?>
<?php
$this->breadcrumbs = array(
    'Planteles' => array('consultar/'),
    'Nuevo Plantel',
);
?>
<link rel="stylesheet" href="/public/js/jquery.upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="/public/js/jquery.upload/css/jquery.fileupload-ui.css">   
<div class="form">
    <?php
    if (Yii::app()->getSession()->get('plantel_id') != NULL) {
        $id = Yii::app()->getSession()->get('plantel_id');
    } else {
        $id = null;
    }

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'plantel-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            //  'validateOnSubmit' => true,
            'validateOnType' => true,
            'validateOnChange' => true),
    ));
    ?>

    <?php //echo $form->errorSummary($model);    ?>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#datosGenerales" data-toggle="tab">Datos generales</a></li>
            <li><a href="#desarrollo" data-toggle="tab">Desarrollo Endógeno</a></li>
            <li><a href="#servicio" data-toggle="tab">Servicios</a></li>
            <li><a href="#autoridades" data-toggle="tab">Autoridades</a></li>
            <!-- <li><a href="#otros" data-toggle="tab">Otros</a></li>-->
            <?php
            /*COORDINADOR DE ZONA, DIRECTOR Y ROOT (ADMIN)*/
            $groupId = Yii::app()->user->group;
            if ($groupId == UserGroups::ADMIN_0 || $groupId == UserGroups::COORD_ZONA || $groupId == UserGroups::DIRECTOR) {
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
            <div class="tab-pane" id="otros">Otros</div>


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
                            Registro Exitoso
                        </p>
                    </div>

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
                                                <img id="tumbnailLogo" style="width:140px;height:140px;" class="img-thumbnail" alt="..." src="<?php echo Yii::app()->baseUrl . '/public/images/indice.svg';?>" />
                                             </p>
                                        
                                       
                                        <p align="center">
                                            <span class="btn btn-info btn-sm fileinput-button">
                                                <i class="fa fa-cloud-upload"></i>
                                                <span> Subir logo...</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input id="fileupload" type="file" name="files[]" >

                                            </span>
                                            
                                             <?php echo $form->hiddenField($model, 'logo',array( 'id'=>'nombreArchivo'));?>
                                        </p>
                                    </div>

                                    <div id="divNER" class="col-md-3" title="Si es un Nucleo Educativo Rural">

                                        <label class="col-md-12" for="ner" title="Núcleo de Educación Rural">NER</label>
                                        <input type="checkbox" id="ner" name="ner" value="" onchange="mostrarNer();" onclick="mostrarNer();" style="margin-left: 15px;">

                                    </div>

                                    <div id="divNombreNer" class="col-md-7">
                                        <div  class="col-md-12">
                                            <label id="lblNer" class="col-md-12" for="codigo_ner">Código NER <span ></span></label>
                                        </div>
                                        <?php echo $form->textField($model, 'codigo_ner', array('size' => 15, 'maxlength' => 15, 'class' => 'span-4', 'style' => 'width: 160px', 'readonly' => 'true')); ?>
                                        <?php //echo $form->error($model, 'codigo_ner'); ?>
                                    </div>

                                    <div class="col-md-10"></div>

                                    <div  id="divCod_plantel" class="col-md-3" >
                                        <?php echo $form->labelEx($model, 'cod_plantel', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'cod_plantel', array('size' => 10, 'maxlength' => 10, 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'cod_plantel'); ?>
                                    </div>

                                    <div  id="divCod_plantelNER" class="col-md-3" style="display: none">
                                        <label id="lblCodNer" class="col-md-12" for="cod_plantelNer" >Código Plantel NER <span></span></label>
                                        <?php echo $form->textField($model, 'cod_plantelNer', array('size' => 4, 'maxlength' => 4, 'class' => 'span-7')); ?>
                                    </div>

                                    <div id="divCodEstadistico" class="col-md-3">
                                        <?php echo $form->labelEx($model, 'cod_estadistico', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'cod_estadistico', array('class' => 'span-7', 'size' => 10, 'maxlength' => 10)); ?>
                                        <?php //echo $form->error($model, 'cod_estadistico');  ?>
                                    </div>

                                    <div id="divDenominacion" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'denominacion_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'denominacion_id', CHtml::listData($denominacion, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'denominacion_id'); ?>
                                    </div>

                                    <div class="col-md-10"></div>

                                    <div id="divNombre"  class="col-md-3">
                                        <?php echo $form->labelEx($model, 'nombre', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'nombre', array('size' => 60, 'maxlength' => 150, 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'nombre'); ?>
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
                                            'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-7',
                                                )
                                        );
                                        ?>
                                        <?php //echo $form->dropDownList($model, 'zona_educativa_id', CHtml::listData($zonaEducativa, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'zona_educativa_id');  ?>
                                    </div>

                                    <div id="divTipoDependencia" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'tipo_dependencia_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'tipo_dependencia_id', CHtml::listData($tipoDependencia, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'tipo_dependencia_id');  ?>
                                    </div>

                                    <div class="col-sm-12"></div>

                                    <div id="divDistrito" class="col-md-3  col-md-offset-2">
                                        <?php echo $form->labelEx($model, 'distrito_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'distrito_id', CHtml::listData($distrito, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'id' => 'distrito_nuevo_id')); ?>
                                        <?php //echo $form->error($model, 'distrito_id');  ?>
                                    </div>

                                    <div id="divEstatusPlantel"  class="col-md-3">
                                        <?php echo $form->labelEx($model, 'estatus_plantel_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'estatus_plantel_id', CHtml::listData($estatusPlantel, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
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

                                        echo $form->dropDownList($model, 'annio_fundado', $anios, array('empty' => '- SELECCIONE -', 'class' => 'span-7'));
                                        ?>
                                        <?php //echo $form->error($model, 'annio_fundado');   ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div id="datosUbicacionP" class="widget-box collapsed">

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
                                                'url' => CController::createUrl('crear/seleccionarMunicipio'),
                                            ),
                                            'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-7',
                                                )
                                        );
                                        ?>
                                        <?php //echo $form->error($model, 'estado_id');   ?>
                                    </div>

                                    <div id="divMunicipio" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'municipio_id', array("class" => "col-md-12")); ?>
                                        <?php
                                        echo $form->dropDownList($model, 'municipio_id', array(), array(
                                            'empty' => '- SELECCIONE -',
                                            'class' => 'span-7',
                                            'ajax' => array(
                                                'type' => 'GET',
                                                'update' => '#Plantel_parroquia_id',
                                                'url' => CController::createUrl('crear/seleccionarParroquia'),
                                            ),
                                            'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-7',
                                        ));
                                        ?>
                                        <?php //echo $form->error($model, 'municipio_id');   ?>
                                    </div>

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
                                                'url' => CController::createUrl('crear/seleccionarUrbanizacion'),
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
                                                    url:"/planteles/crear/seleccionarPoblacion",
                                                    update:"#Plantel_poblacion_id",
                                                    success:function(result){  $("#Plantel_poblacion_id").html(result);}


                                                });

                                            }',
                                            ),
                                            'empty' => array('' => '- SELECCIONE -'),
                                        ));
                                        ?>
                                        <?php //echo $form->error($model, 'parroquia_id');  ?>
                                    </div>


                                    <!-- ALEXIS comenzo a editar desd aqui-->

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
                                        <?php //echo $form->error($model, 'parroquia_id');  ?>
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

                                    <!--TERMINE DE EDITAR-->

                                    <div id="divDireccion" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'direccion', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'direccion', array('size' => 6, 'maxlength' => 100, 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'direccion');  ?>
                                    </div>

                                    <div id="divTelefonoFijo" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'telefono_fijo', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'telefono_fijo', array('size' => 11, 'maxlength' => 11, 'placeholder' => 'Ejemplo 02125555555', 'class' => 'span-7')); ?>

                                        <?php //echo $form->error($model, 'telefono_fijo');   ?>
                                    </div>

                                    <div  id="divTelefonoOtro" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'telefono_otro', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'telefono_otro', array('size' => 11, 'maxlength' => 11, 'placeholder' => 'Ejemplo 02125555555', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'telefono_otro');  ?>
                                    </div>

                                    <div id="divNFax" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'nfax', array("class" => "col-md-12")); ?>
                                        <?php echo $form->textField($model, 'nfax', array('size' => 11, 'maxlength' => 11, 'placeholder' => 'Ejemplo 02125555555', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'correo');  ?>
                                    </div>

                                    <div id="divCorreo" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'correo', array("class" => "col-md-12")); ?>
                                        <?php echo $form->emailField($model, 'correo', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'ejemplo@ejemplo.com', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'correo');  ?>
                                    </div>

                                    <div id="divZonaUbicacion" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'zona_ubicacion_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'zona_ubicacion_id', CHtml::listData($zona_ubicacion, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'correo');  ?>
                                    </div>


                                    <div class="row row-fluid">
                                        <div class="col-md-2" style="width: 140px">
                                            <label>Tipo Ubicación</label>
                                            <div class="row" style="padding-left: 10px;">
                                                <div id="divFronteriza" class="col-md-2" style="width: 140px; padding-top: 5px;">
                                                    <label for="fronteriza"><i>Fronteriza</i></label>
                                                    <input type="checkbox" name="fronteriza" id="fronteriza" value="1">
                                                    <?php //echo $form->checkBox($tipoUbicacion,'id');  ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2" style="width: 140px">
                                            <label>&nbsp;</label>
                                            <div class="row">
                                                <div id="divIndigena" class="col-md-2" style="width: 140px; padding-top: 5px;">
                                                    <label for="indigena"><i>Indígena</i></label>
                                                    <input type="checkbox" name="indigena" id="indigena" value="2">
                                                    <?php //echo $form->checkBox($tipoUbicacion,'id');  ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2" style="width: 140px">
                                            <label>&nbsp;</label>
                                            <div class="row">
                                                <div id="divDificilAcceso" class="col-md-2" style="width: 140px; padding-top: 5px;">
                                                    <label for="dificil_acceso"><i>Difícil Acceso</i></label>
                                                    <input type="checkbox" name="dificil_acceso" id="dificil_acceso" value="3">
                                                    <?php //echo $form->checkBox($tipoUbicacion,'id');  ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
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
                                                    <?php //echo $form->error($model, 'longitud'); ?>
                                                </div>

                                                <div id="divLatitud" class="col-md-4">
                                                    <?php echo $form->labelEx($model, 'latitud', array("class" => "col-md-12")); ?>
                                                    <?php echo $form->textField($model, 'latitud', array('class' => 'span-7', 'maxlenght' => '30')); ?>
                                                    <?php //echo $form->error($model, 'latitud');  ?>
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
                                        <?php echo $form->dropDownList($model, 'clase_plantel_id', CHtml::listData($clasePlantel, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'clase_plantel_id');  ?>
                                    </div>

                                    <div id="divCategoria" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'categoria_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'categoria_id', CHtml::listData($categoria, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
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
                                            'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-7',
                                                )
                                        );
                                        ?>
                                        <?php //echo $form->error($model, 'condicion_estudio_id');  ?>
                                    </div>

                                    <div id="divGenero" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'genero_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'genero_id', CHtml::listData($genero, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'genero_id');  ?>
                                    </div>

                                    <div id="divTurno" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'turno_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'turno_id', CHtml::listData($turno, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'id' => 'turno_nuevo_id')); ?>
                                        <?php //echo $form->error($model, 'turno_id');  ?>
                                    </div>

                                    <div id="divRegimen" class="col-md-4">
                                        <?php echo $form->labelEx($model, 'modalidad_id', array("class" => "col-md-12")); ?>
                                        <?php echo $form->dropDownList($model, 'modalidad_id', CHtml::listData($modalidadEstudio, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
                                        <?php //echo $form->error($model, 'regimen_id');  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">

                    <div class="col-xs-6">
                        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("planteles/consultar/"); ?>" class="btn btn-danger">
                            <i class="icon-arrow-left"></i>
                            Volver
                        </a>
                    </div>

                    <div class="col-xs-6">
                        <button type="submit" data-last="Finish" title="Guardar Datos generales del Plantel" class="btn btn-primary btn-next pull-right">
                            Guardar
                            <i class="icon-save icon-on-right"></i>
                        </button>
                    </div>

                </div>

                <?php $this->endWidget(); ?>
            </div>

            <div class="tab-pane" id="desarrollo">
                <?php
                $this->renderPartial('_formEndogeno', array(
                    'listProyectosEndo' => $listProyectosEndo,
                    'plantel_id' => $id,
                        // 'ids_proyectosEndoP' => $ids_proyectosEndoP
                        )
                );
                Yii::app()->getSession()->remove('proyecto');
                ?>
            </div>


            <!-- ignacio -->
            <div class="tab-pane" id="servicio">
                <?php
                $this->renderPartial('_formServicio', array('list' => $list, 'plantel_id' => $id));
                Yii::app()->getSession()->remove('servicios');
                ?>
            </div>

            <div class="tab-pane" id="autoridades">
                <?php
                $this->renderPartial('_formAutoridades', array('autoridadPlantel' => $autoridadPlantel, 'cargoSelect' => $cargoSelect, 'plantel_id' => $id, 'dataProvider' => $dataProviderAutoridades, 'autoridades' => $autoridades));
                //  Yii::app()->getSession()->remove('autoridades');
                ?>
            </div>

            <div class="tab-pane" id="aula">
                <?php
                if ($id !== NULL) {
                    $this->renderPartial('_formAula', array('plantel_id' => $id, 'model' => $modelAula, /* , 'dataProvider' => $dataProviderAula */));
                } else {
                    ?>
                    <div class="infoDialogBox">
                        <p>
                            Debe Registrar un Plantel para acceder a esta opción.
                        </p>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>
</div>

<div id="dialog_calidad_servicio" class="hide">
    <?php $this->renderPartial('_formCalidadServicio'); ?>
</div>

<div id = "dialog_cargo" class="hide">
    <?php $this->renderPartial('_formCargo'); ?>
</div>

<div id = "agregarAutoridad" class="hide">
    <?php $this->renderPartial('_formAgregarAutoridad', array('usuario' => $usuario, 'plantel_id' => $id)); ?>

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
        <p class="bigger-110 bolder center grey">

        </p>
    </div>
</div>
<div id = "dialog_success" class="hide">
    <div class="successDialogBox bigger-110">
        <p class="bigger-110 bolder center grey">

        </p>
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
                        source: "/planteles/crear/ViaAutoComplete?id=" + id,
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
                        source: "/planteles/crear/ViaAutoComplete?id=" + id,
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
        
        
        $(document).ready(function() {
            
           
        $('#fileupload').fileupload({
            url: '/planteles/crear/upload/',
            acceptFileTypes: /(\.|\/)(jpe?g|png)$/i,
            maxFileSize: 5000000,
            singleFileUploads: true,
            beforeSend:function(){
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



    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/plantel.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/valid_coordenadas.js', CClientScript::POS_END);
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



