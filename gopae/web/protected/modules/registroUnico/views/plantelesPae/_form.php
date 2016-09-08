<?php
/* @var $this PlantelPaeController */
/* @var $model Plantel */
/* @var $form CActiveForm */
?>
<?php $disableByEdition = ($formType=='edicion')?true:false; ?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/public/css/pnotify.custom.min.css" media="screen, proyection"/>
<meta http-equiv="no-cache">
<div class="col-xs-12">
    <div class="row-fluid">

        <div class="tabbable">
            <?php
                if (Yii::app()->getSession()->get('plantel_id') != NULL) {
                    $id = Yii::app()->getSession()->get('plantel_id');
                } else {
                    $id = null;
                }
            ?>

        <?php //echo $form->errorSummary($model);    ?>
        <?php if($model->estado_id != Yii::app()->user->estado && $formType=='edicion'): ?>
            <div class="errorDialogBox">
                <p>
                    El Estado en el que usted se encuentra (<?php echo Yii::app()->user->estadoName; ?>) no es el mismo que el de este plantel. Tenga mucho cuidado al editar la data de esta institución educativa.
                </p>
            </div>
        <?php endif; ?>
        <div class="tabbable">

            <ul class="nav nav-tabs">
                <li id="liDatosGenerales" class="active"><a href="#datosGenerales" data-toggle="tab">Datos Generales</a></li>
                <li id="liDatosPae"><a href="#datosPae" data-toggle="tab">Datos CNAE</a></li>
                <li id="liIngestas"><a href="#ingestas" data-toggle="tab">Ingestas</a></li>
                <li id="liAutoridades"><a href="#autoridades" data-toggle="tab">Autoridades</a></li>
                <li id="liComprobante"><a href="#comprobante" data-toggle="tab">Comprobante</a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="datosGenerales">

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'plantel-form',
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'htmlOptions' => array(
                            'data-form-type' => $formType,
                        ),
                        'clientOptions' => array(
                            //  'validateOnSubmit' => true,
                            'validateOnType' => true,
                            'validateOnChange' => true),
                    ));
                    ?>

                        <div class="infoDialogBox">
                            <p>
                                Debe Ingresar los Datos Generales del Plantel, los campos marcados con <span class="required">*</span> son requeridos.
                            </p>
                        </div>
                        

                        <div id="resultado">
                            <?php
                                  if($model->hasErrors()):
                                      $this->renderPartial('//errorSumMsg', array('model' => $model));
                                  elseif(isset($mensajeExitoso) && strlen($mensajeExitoso)>0):
                                      $this->renderPartial('//msgBox', array('class'=>'successDialogBox', 'message'=>$mensajeExitoso));
                                  endif;
                            ?>
                        </div>

                    <div class="widget-box" id="wbIdentificacionPlantel">

                        <div class="widget-header">
                            <h5>Identificaci&oacute;n de la Institución Educativa</h5>
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

                                        <div class="col-md-2" style="padding-top: 30px; height: 300px">

                                            <?php if($formType!='edicion'): ?>
                                            <div class="col-md-12">
                                                <button id="btnPlantelSinCodigoDea" type="button" class="btn btn-xs btn-primary">Plantel sin Código DEA</button>
                                                <input id="plantelSinCodigoDea" value="0" disabled="" type="hidden">
                                            </div>
                                            <?php else: ?>
                                            <p align="center">
                                                <img id="tumbnailLogo" style="width:140px;height:140px;" class="img-thumbnail" alt="..." src="<?php echo Yii::app()->baseUrl . '/public/images/indice.svg'; ?>" />
                                            </p>
                                            <?php endif; ?>

                                        </div>

                                        <div id="divNER" class="col-md-3" title="Seleccione si es un Nucleo Educativo Rural">

                                            <label class="col-md-12" for="ner" title="Núcleo de Educación Rural">NER</label>
                                            <input type="checkbox" id="ner" name="ner" value="" onchange="mostrarNer();" onclick="mostrarNer();"  <?php echo ($disableByEdition)?'readOnly="readOnly" disabled':""; ?> style="margin-left: 15px;">

                                        </div>

                                        <div id="divNombreNer" class="col-md-3">
                                            <div  class="col-md-12">
                                                <label id="lblNer" class="col-md-12" for="codigo_ner">Código NER <span ></span></label>
                                            </div>
                                            <?php echo $form->textField($model, 'codigo_ner', array('size' => 15, 'maxlength' => 15, 'class' => 'span-12', 'readonly' => 'true')); ?>
                                            <?php //echo $form->error($model, 'codigo_ner'); ?>
                                        </div>

                                        <div id="divBeneficiarioPaePlantel"  class="col-md-4">
                                            <?php echo $form->labelEx($model, 'es_beneficiario_pae', array("class" => "col-md-12")); ?>
                                            <?php echo $form->dropDownList($model, 'es_beneficiario_pae', array('SI'=>'Sí', 'NO'=>'No'), array('empty' => '- SELECCIONE -', 'class' => 'span-12', 'required'=>'required')); ?>
                                            <?php //echo $form->error($model, 'estatus_plantel_id');  ?>
                                        </div>

                                        <div class="col-sm-10">

                                        </div>

                                        <div  id="divCod_plantel" class="col-md-3" >

                                            <label for="Plantel_cod_plantel" class="col-md-12">Código DEA <span class="required">*</span></label>
                                            <?php echo $form->textField($model, 'cod_plantel', array('size' => 10, 'maxlength' => 10, 'class' => 'span-12', 'readonly'=>$disableByEdition, 'required'=>'required')); ?>
                                            <?php //echo $form->error($model, 'cod_plantel'); ?>
                                        </div>

                                        <div  id="divCod_plantelNER" class="col-md-3" style="display: none">
                                            <label id="lblCodNer" class="col-md-12" for="Plantel_cod_plantelNer" >Código DEA de la Institución NER <span></span></label>
                                            <div class="input-group">
                                                <span style="cursor: pointer;" id="spanInfoCodigoNer" class="input-group-addon"><i class="icon-question"></i></span>
                                                <?php echo $form->textField($model, 'cod_plantelNer', array('size' => 4, 'maxlength' => 4, 'class' => 'span-12', 'readonly'=>$disableByEdition, )); ?>
                                            </div>
                                        </div>

                                        <div id="divCodEstadistico" class="col-md-3">
                                            <?php echo $form->labelEx($model, 'cod_estadistico', array("class" => "col-md-12")); ?>
                                            <?php echo $form->textField($model, 'cod_estadistico', array('class' => 'span-12', 'size' => 10, 'maxlength' => 10, 'readonly'=>$disableByEdition)); ?>
                                        </div>

                                        <div id="divCodCnae" class="col-md-4">
                                            <?php echo $form->labelEx($model, 'cod_cnae', array("class" => "col-md-12", "Title"=>"Código Autogenerado por el Sistema para la Identificación del Plantel en la Corporación Nacional de Alimentación Escolar")); ?>
                                            <?php echo $form->textField($model, 'cod_cnae', array('class' => 'span-12', 'size' => 10, 'maxlength' => 15, 'readOnly'=>true)); ?>
                                        </div>

                                        <div id="divDenominacion" class="col-md-3">
                                            <?php echo $form->labelEx($model, 'denominacion_id', array("class" => "col-md-12 required")); ?>
                                            <?php echo $form->dropDownList($model, 'denominacion_id', CHtml::listData($denominaciones, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-12', 'required'=>true, 'readonly'=>$disableByEdition,)); ?>
                                            <?php //echo $form->error($model, 'denominacion_id'); ?>
                                        </div>

                                        <div id="divNombre"  class="col-md-7">
                                            <?php echo $form->labelEx($model, 'nombre', array("class" => "col-md-12")); ?>
                                            <?php echo $form->textField($model, 'nombre', array('size' => 60, 'maxlength' => 150, 'class' => 'span-12', 'required'=>true,)); ?>
                                            <?php //echo $form->error($model, 'nombre'); ?>
                                        </div>

                                        <div class="col-sm-10"></div>

                                        <div id="divZonaEducativa" class="col-md-3">
                                            <?php echo $form->labelEx($model, 'zona_educativa_id', array("class" => "col-md-12 required")); ?>
                                            <?php
                                            echo $form->dropDownList(
                                                    $model, 'zona_educativa_id', CHtml::listData($zonasEducativas, 'id', 'nombre'), array('empty' => array('' => '- SELECCIONE -'), 'class' => 'span-12', 'required'=>true,)
                                            );
                                            ?>
                                            <?php //echo $form->dropDownList($model, 'zona_educativa_id', CHtml::listData($zonasEducativa, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-12')); ?>
                                            <?php //echo $form->error($model, 'zona_educativa_id');  ?>
                                        </div>

                                        <div id="divTipoDependencia" class="col-md-3">
                                            <?php echo $form->labelEx($model, 'tipo_dependencia_id', array("class" => "col-md-12 required")); ?>
                                            <?php echo $form->dropDownList($model, 'tipo_dependencia_id', CHtml::listData($dependencias, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-12', 'required'=>true,)); ?>
                                            <?php //echo $form->error($model, 'tipo_dependencia_id');  ?>
                                        </div>

                                        <div id="divEstatusPlantel"  class="col-md-4">
                                            <?php echo $form->labelEx($model, 'estatus_plantel_id', array("class" => "col-md-12")); ?>
                                            <?php echo $form->dropDownList($model, 'estatus_plantel_id', CHtml::listData($estatusPlantel, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-12')); ?>
                                            <?php //echo $form->error($model, 'estatus_plantel_id');  ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="datosUbicacionP" class="widget-box">

                        <div class="widget-header">
                            <h5>Datos de Ubicaci&oacute;n</h5>

                            <div class="widget-toolbar">
                                <a data-action="collapse" href="#">
                                    <i class="icon-chevron-up"></i>
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
                                                    $model, 'estado_id', CHtml::listData($estados, 'id', 'nombre'), array(
                                                        'required'=>true,
                                                        // 'ajax' => array(
                                                        //     'type' => 'POST',
                                                        //     'update' => '#Plantel_municipio_id',
                                                        //     'url' => CController::createUrl('/registroUnico/plantelesPae/municipiosStandAlone'),
                                                        //     'success' => 'function(result) {
                                                        //         $("#Plantel_municipio_id").html(result);
                                                        //         $("#Plantel_parroquia_id").html("<option>-SELECCIONE-</option>");
                                                        //         $("#Plantel_urbanizacion_id").html("<option>-SELECCIONE-</option>");
                                                        //         $("#Plantel_poblacion_id").html("<option>-SELECCIONE-</option>");
                                                        //     }
                                                        //     '
                                                        // ),
                                                        'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-12',
                                                    )
                                                );
                                            ?>
                                            <?php //echo $form->error($model, 'estado_id');   ?>
                                        </div>

                                        <div id="divMunicipio" class="col-md-4">
                                            <?php echo $form->labelEx($model, 'municipio_id', array("class" => "col-md-12")); ?>
                                            <?php
                                            echo $form->dropDownList($model, 'municipio_id', CHtml::listData($municipios, 'id', 'nombre'), array(
                                                'empty' => '- SELECCIONE -',
                                                'class' => 'span-12', '
                                                required'=>true,
                                                //'ajax' => array(
                                                //    'type' => 'POST',
                                                //    'update' => '#Plantel_parroquia_id',
                                                //    'url' => CController::createUrl('/registroUnico/plantelesPae/parroquiasStandAlone'),
                                                //    'success' => 'function(result) {
                                                //        $("#Plantel_parroquia_id").html(result);
                                                //        $("#Plantel_urbanizacion_id").html("<option>-SELECCIONE-</option>");
                                                //        $("#Plantel_poblacion_id").html("<option>-SELECCIONE-</option>");
                                                //    }
                                                //    '
                                                //),
                                                'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-12',
                                            ));
                                            ?>
                                            <?php //echo $form->error($model, 'municipio_id');   ?>
                                        </div>

                                        <div id="divParroquia" class="col-md-4">
                                            <?php echo $form->labelEx($model, 'parroquia_id', array("class" => "col-md-12")); ?>
                                            <?php
                                            echo $form->dropDownList($model, 'parroquia_id', CHtml::listData($parroquias, 'id', 'nombre'), array(
                                                'empty' => '- SELECCIONE -',
                                                'id' => 'Plantel_parroquia_id',
                                                'class' => 'span-12',
                                                'required'=>true,
                                                // 'ajax' => array(
                                                //     'type' => 'POST',
                                                //     'update' => '#Plantel_urbanizacion_id',
                                                //     'url' => CController::createUrl('/registroUnico/plantelesPae/seleccionarUrbanizacion'),
                                                //     'success' => 'function(resutl) {
                                                //         $("#Plantel_urbanizacion_id").html(resutl);
                                                //         var parroquia_id=$("#Plantel_parroquia_id").val();
// 
                                                //         var data={parroquia_id: parroquia_id};
                                                //         $.ajax({
                                                //             type:"POST",
                                                //             data:data,
                                                //             url:"/registroUnico/plantelesPae/seleccionarPoblacion",
                                                //             update:"#Plantel_poblacion_id",
                                                //             success:function(result){  $("#Plantel_poblacion_id").html(result);}
                                                //         });
                                                // }',
                                                // ),
                                                'empty' => array('' => '- SELECCIONE -'),
                                            ));
                                            ?>
                                            <?php //echo $form->error($model, 'parroquia_id');  ?>
                                        </div>

                                        <!--TERMINE DE EDITAR-->

                                        <div id="divDireccion" class="col-md-4">
                                            <?php echo $form->labelEx($model, 'direccion', array("class" => "col-md-12")); ?>
                                            <?php echo $form->textField($model, 'direccion', array('maxlength' => 100, 'required'=>true, 'class' => 'span-12')); ?>
                                            <?php //echo $form->error($model, 'direccion');  ?>
                                        </div>

                                        <div id="divTelefonoFijo" class="col-md-4">
                                            <?php echo $form->labelEx($model, 'telefono_fijo', array("class" => "col-md-12")); ?>
                                            <?php echo $form->textField($model, 'telefono_fijo', array('size' => 11, 'maxlength' => 11, 'placeholder' => 'Ejemplo 02125555555', 'required'=>true, 'class' => 'span-12')); ?>
                                            <?php //echo $form->error($model, 'telefono_fijo');   ?>
                                        </div>

                                        <div  id="divTelefonoOtro" class="col-md-4">
                                            <?php echo $form->labelEx($model, 'telefono_otro', array("class" => "col-md-12")); ?>
                                            <?php echo $form->textField($model, 'telefono_otro', array('size' => 11, 'maxlength' => 11, 'placeholder' => 'Ejemplo 02125555555', 'class' => 'span-12')); ?>
                                            <?php //echo $form->error($model, 'telefono_otro');  ?>
                                        </div>

                                        <div id="divCorreo" class="col-md-4">
                                            <?php echo $form->labelEx($model, 'correo', array("class" => "col-md-12")); ?>
                                            <?php echo $form->emailField($model, 'correo', array('size' => 60, 'maxlength' => 100, 'placeholder' => 'ejemplo@ejemplo.com', 'class' => 'span-12')); ?>
                                            <?php //echo $form->error($model, 'correo');  ?>
                                        </div>

                                        <div id="divZonaUbicacion" class="col-md-4">
                                            <?php echo $form->labelEx($model, 'zona_ubicacion_id', array("class" => "col-md-12")); ?>
                                            <?php echo $form->dropDownList($model, 'zona_ubicacion_id', CHtml::listData($zonasUbicacion, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-12')); ?>
                                        </div>


                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model,'otras_sedes'); ?>
                                            <?php echo $form->textField($model,'otras_sedes', array('class' => 'span-12',"required"=>"required", 'maxlength'=>'2')); ?>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div id="otrosDatosP" class="widget-box">
                        <div class="widget-header">
                            <h5>Otros Datos</h5>

                            <div class="widget-toolbar">
                                <a  href="#" data-action="collapse" >
                                    <i class="icon-chevron-up"></i>
                                </a>
                            </div>
                        </div>

                        <div id="infoGeneral" class="widget-body" >
                            <div  class="widget-body-inner" >
                                <div class="widget-main form">

                                    <div class="row">
                                        <div id="divGenero" class="col-md-4">
                                            <?php echo $form->labelEx($model, 'genero_id', array("class" => "col-md-12")); ?>
                                            <?php echo $form->dropDownList($model, 'genero_id', CHtml::listData($tiposDeMatricula, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'required'=>true, 'class' => 'span-12')); ?>
                                            <?php //echo $form->error($model, 'genero_id');  ?>
                                        </div>

                                        <div id="divTurno" class="col-md-4">
                                            <?php echo $form->labelEx($model, 'turno_id', array("class" => "col-md-12")); ?>
                                            <?php echo $form->dropDownList($model, 'turno_id', CHtml::listData($turnos, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'required'=>true, 'class' => 'span-12',)); ?>
                                            <?php //echo $form->error($model, 'turno_id');  ?>
                                        </div>

                                        <div class="col-md-4">
                                            <?php echo $form->labelEx($model, 'consejo_comunal', array("class" => "col-md-12")); ?>
                                            <?php echo $form->textField($model, 'consejo_comunal', array('required'=>true, 'class' => 'span-12')); ?>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <?php echo $form->labelEx($model, 'posee_cbit', array("class" => "col-md-12")); ?>
                                            <?php echo $form->dropDownList($model, 'posee_cbit', array('NO'=>'No','SI'=>'Sí',), array('class' => 'span-12')); ?>
                                        </div>

                                        <div class="col-md-6">
                                            <?php echo $form->labelEx($model, 'cbit_con_internet', array("class" => "col-md-12")); ?>
                                            <?php echo $form->dropDownList($model, 'cbit_con_internet', array('NO'=>'No','SI'=>'Sí',), array('class' => 'span-12')); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-xs-6">
                            <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("/registroUnico/plantelesPae/lista"); ?>" class="btn btn-danger">
                                <i class="icon-arrow-left"></i>
                                Volver
                            </a>
                            
                            <div class="btn-group dropup">
                                <button data-toggle="dropdown" class="btn dropdown-toggle" style="height:42px;">
                                    Acciones
                                    <span class="icon-caret-up icon-on-right"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-yellow pull-right">
                                    <li>
                                        <a href="/registroUnico/madresCocineras/asignadas/id/<?php echo base64_encode($model->id); ?>" title="Registro y Consulta de Madres Cocineras" class="fa fa-female purple">
                                            <span style="font-family:Helvetica Neue,Arial,Helvetica,sans-serif;">&nbsp;&nbsp;Madres Cocineras</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <button type="submit" data-last="Finish" title="Guardar Datos Generales de la Institución Educativa" class="btn btn-primary btn-next pull-right">
                                Guardar
                                <i class="icon-save icon-on-right"></i>
                            </button>
                        </div>

                    </div>

                    <?php $this->endWidget(); ?>
                </div>

                <div class="tab-pane" id="datosPae">
                    <?php
                    if(is_object($modelPae)):
                        $this->renderPartial('_formPlantelPae', array('plantel_id' => $model->id, 'model'=>$model, 'modelPae' => $modelPae));
                    else:
                    ?>
                    <div class="infoDialogBox">
                        <p>
                            Debe registrar en principio los Datos Generales de la Institución Educativa.
                        </p>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>

                <div class="tab-pane" id="autoridades">
                    <?php
                    if($dataProviderAutoridades && is_object($modelPae)):
                        $this->renderPartial('_formAutoridades', array(
                            'autoridadPlantel' => $autoridadesPlantel, 
                            'cargoSelect' => $cargoSelect,
                            'plantel_id' => $model->id,
                            'plantel' => $model,
                            'dataProvider' => $dataProviderAutoridades,
                            )
                        );
                    else:
                    ?>
                    <div class="infoDialogBox">
                        <p>
                            Debe registrar en principio los Datos Generales de la Institución Educativa.
                        </p>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>

                <div class="tab-pane" id="ingestas">
                    <?php
                    if(is_object($modelPae)):
                        $this->renderPartial('_formPlantelIngestas', array(
                                'plantel_id' => $model->id,
                                'model'=>$model,
                                'plantel'=>$model,
                                'modelPae' => $modelPae,
                                'ingestas' => $ingestas));
                    else:
                        ?>
                        <div class="infoDialogBox">
                            <p>
                                Debe registrar en principio los Datos Generales de la Institución Educativa.
                            </p>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>

                <div class="tab-pane" id="comprobante">

                    <?php 
                        $mensaje = Yii::app()->user->getFlash('errorComprobante');
                        if(!is_null($mensaje)): 
                    ?>
                    <div class="errorDialogBox">
                        <p>
                            <?php echo htmlentities($mensaje); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    
                    <div class='alertDialogBox'>
                        <p>
                            Cerciórese de haber cargado los siguientes datos antes de generar el Comprobante CNAE.
                            <br/><br/>
                            &nbsp;&nbsp;1.- Datos Generales del Institución Educativa.
                            <br/>
                            &nbsp;&nbsp;2.- Datos del PAE en la Institución Educativa.
                            <br/>
                            &nbsp;&nbsp;3.- Matricula Total.
                            <br/>
                            &nbsp;&nbsp;4.- Autoridades de la Institución Educativa (Director y Enlace PAE).
                            <br/>
                            &nbsp;&nbsp;5.- Ingestas proveidas en la Institución Educativa.
                        </p>
                    </div>
                    <?php
                    if(is_object($modelPae)):
                    ?>
                    <div class="widget-box">
                        <div class="widget-header">
                            <h5>Emisión de Comprobante CNAE</h5>

                            <div class="widget-toolbar">
                                <a  href="#" data-action="collapse" >
                                    <i class="icon-chevron-up"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body" >
                            <div  class="widget-body-inner" >
                                <div class="widget-main form">
                                    <div class="row">
                                        <div class="col-md-12 center">
                                            <a title="Validar Datos del Plantel para la Posterior Emisión del Comprobante" class="btn btn-primary" id="linkSolicitudComprobante" href="/registroUnico/plantelesPae/datosComprobante/id/<?php echo base64_encode($model->id); ?>">
                                                Validar Datos
                                                <i class="fa fa-file-pdf-o"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    else:
                    ?>
                    <div class="infoDialogBox">
                        <p>
                            Debe registrar en principio los Datos Generales de la Institución Educativa.
                        </p>
                    </div>
                    <?php
                    endif;
                    ?>
                    <div class="row">
                        <hr>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("registroUnico/plantelesPae/lista"); ?>" class="btn btn-danger">
                                    <i class="icon-arrow-left"></i>
                                    Volver
                                </a>
                                <div class="btn-group dropup">
                                    <button data-toggle="dropdown" class="btn dropdown-toggle" style="height:42px;">
                                        Acciones
                                        <span class="icon-caret-up icon-on-right"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-yellow pull-right">
                                        <li>
                                            <a href="/registroUnico/madresCocineras/asignadas/id/<?php echo base64_encode($model->id); ?>" title="Registro y Consulta de Madres Cocineras" class="fa fa-female purple">
                                                <span style="font-family:Helvetica Neue,Arial,Helvetica,sans-serif;">&nbsp;&nbsp;Madres Cocineras</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="/registroUnico/madresCocineras/asignadas/id/<?php echo base64_encode($model->id); ?>" title="Registro y Consulta de Madres Cocineras" class="btn btn-purple">
                                    Registro de Madres Cocineras
                                    <i class="fa fa-female"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
        <div id = "dialog_cargo" class="hide">
            <?php if(is_object($modelPae)) $this->renderPartial('_formCargo'); ?>
        </div>

        <div id = "agregarAutoridad" class="hide">
            <?php if(is_object($modelPae)) $this->renderPartial('_formAgregarAutoridad', array('autoridadUsuario' => $autoridadUsuario, 'plantel_id' => $id)); ?>
        </div>

        <div id="dialogConfirmEliminarAutoridad" class="hide">
            <div class="alertDialogBox">
                <p>
                    &iquest;Está usted seguro de desvincular a esta persona como autoridad de esta Institución Educativa?
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
        <div id = "dialogInfoCodigoNer" class="hide">
            <div class="infoDialogBox">
                <p>
                    El Código DEA asignado a los Nucleos de Educación Rural tendrán la siguiente estructura:
                    <span style="padding-left: 5px;">
                        <p style="padding-left: 100px;">
                            1.- Constará de cuatro (4) dígitos.
                        </p>
                        <p style="padding-left: 100px;">
                            2.- El primer dígito es la letra "Z".
                        </p>
                        <p style="padding-left: 100px;">
                            3.- Los dos dígitos siguientes corresponden al Código de la Zona Educativa.
                        </p>
                        <p style="padding-left: 100px;">
                            4.- El último dígito será una letra. Si el documento probatorio de estudio corresponde a:<br/><br/>
                            <span style="padding-left: 20px">
                                A.- Pre-Escolar, Educación Básica, Media Diversificada y Profesional: "R".<br/>
                            </span>
                            <span style="padding-left: 20px">
                                B.- Modalidad de Adultos: "A".<br/>
                            </span>
                            <span style="padding-left: 20px">
                                C.- Equivalencia: "E".<br/>
                            </span>
                        </p>
                    </span>
                </p>
            </div>
        </div>

    <div id="css_js">
        <?php $this->widget('ext.loading.LoadingWidget'); ?>
        <script>
            datosGeneralesPlantel = '';
            (function(){
                <?php if(isset($isnew) && strlen($isnew)): ?>
                $("#liDatosPae a").click();
                <?php endif; ?>

                <?php if(isset($error) && $error=='comprobante'): ?>
                $("#liComprobante a").click();
                <?php endif; ?>
            })();
            var options, a;
            jQuery(function() {

                $("#spanInfoCodigoNer").on('click', function(){
                    $("#dialogInfoCodigoNer").removeClass('hide').dialog({
                        modal: true,
                        width: '1000px',
                        dragable: false,
                        resizable: false,
                        //position: 'top',
                        title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Detalle del Código DEA de un NER</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                                "class": "btn btn-danger btn-xs",
                                "id": "btn-volver-info-codigo-ner",
                                click: function() {
                                    $(this).dialog("close");
                                }
                            }
                        ]
                    });
                });
                
                $("#btnPlantelSinCodigoDea").on('click', function(){
                    var estatus = $("#plantelSinCodigoDea").val()*1;
                    if(estatus==0){
                        $("#btnPlantelSinCodigoDea").html("Plantel con Código DEA");
                        $("#btnPlantelSinCodigoDea").removeClass("btn-primary").addClass("btn-success");
                        $("#plantelSinCodigoDea").val(1);
                        $("#Plantel_cod_plantel").val("SIN-CODIGO");
                        $("#Plantel_cod_plantel").attr("readonly","readonly");
                        $("#Plantel_cod_estadistico").val("");
                        $("#Plantel_cod_estadistico").attr("readonly","readonly");
                    }
                    else{
                        $("#btnPlantelSinCodigoDea").removeClass("btn-success").addClass("btn-primary");
                        $("#btnPlantelSinCodigoDea").html("Plantel sin Código DEA");
                        $("#plantelSinCodigoDea").val(0);
                        $("#Plantel_cod_plantel").val("");
                        $("#Plantel_cod_plantel").removeAttr("readonly");
                        $("#Plantel_cod_estadistico").val("");
                        $("#Plantel_cod_estadistico").removeAttr("readonly");
                    }
                });

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

        </script>

        <?php
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catastro/catastro.min.js',CClientScript::POS_END);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.gritter.min.js', CClientScript::POS_END);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/pnotify.custom.min.js', CClientScript::POS_END);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/registroUnico/plantel.js', CClientScript::POS_END);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/registroUnico/autoridades/fotografia.js', CClientScript::POS_END);
        ?>

        </div>
    </div>
</div>
<div class="hide" id="dialogDescargaComprobanteCnae">
    <div id="divResultDescargaComprobante">
        <div class="infoDialogBox">
            <p>
                Se está efectuando la generación del comprobante. En pocos segundos se podrá visualizar un link de descarga del mismo.
            </p>
        </div>
        <div align="center">
            <img src="/public/images/ajax-loader-red.gif" />
        </div>
    </div>
    <div class="padding-6 center">
    </div>
</div>
