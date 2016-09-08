<?php
/* @var $this PlantelesPaeController */
/* @var $model Plantel */
/* @var $modelPae PlantelPae */
/* @var $form CActiveForm */

$form=$this->beginWidget('CActiveForm', array(
    'id'=>'datos-plantel-pae-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    // 'htmlOptions'=>array('onSubmit'=>'return false',),
    'enableAjaxValidation'=>false,
)); ?>

<div class="infoDialogBox">
    <p>
        Debe tener mucho cuidado con la información ingresada en el sistema, la falsificación de los datos proporcionados a una institución del estado puede ser considerada como un <a href="http://www.tsj.gov.ve/legislacion/ledi.htm" target="_blank">delito informático</a>. Estos datos seran comprobados con la matricula cargada en el <a href="<?php echo Yii::app()->params['hostNameGescolar']; ?>" target="_blank">Sistema de Gestion Escolar</a>.
    </p>
</div>

<div id="resultado-plantel-pae"></div>

<div onclick="$(this).fadeOut('slow');" class="successDialogBox hide" id="mensajeAlertaExito"><p>Los Datos PAE de la Institución Educativa se han registrado de forma exitosa.</p></div>
<div onclick="$(this).fadeOut('slow');" class="errorDialogBox hide" id="mensajeAlertaError"></div>
<div id="mensajeAlertaWarning"></div>

<div class="widget-box">
    <div class="widget-header">
        <h5>Datos del PAE - <?php echo '('.$model->cod_plantel.') '.$model->nombre; ?></h5>
        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="">
            <div class="widget-main">

                <a href="#" class="search-button"></a>
                <div style="display:block" class="search-form">
                    <div class="widget-main form">

                        <div class="form" id="divFormPae">
                            <?php $bloqueaCamposMatricula = ''; ?>
                            
                        <?php
                            if($modelPae->pae_activo != null){
                                $requerido = '';
                            }
                            else if($modelPae->pae_activo == null){
                                $requerido = '<span class="required">*</span>';
                            }
                        ?>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-4">
                                            <?php echo $form->hiddenField($modelPae,'id'); ?>
                                            <?php echo $form->hiddenField($modelPae,'plantel_id'); ?>
                                            <?php echo $form->hiddenField($modelPae,'edito_matricula'); ?>
                                            <label for="">¿El PAE se encuentra activo?</label>
                                            <?php echo $form->dropDownList($modelPae,'pae_activo', array('SI'=>'SI', 'NO'=>'NO'), array('class' => 'span-12',)); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Fecha de Registro</label>
                                        <?php
                                        //            var_dump($modelPae->id);
                                        $fecha_inicio = '';
                                        $fecha_ultima_actualizacion = '';
                                        if($modelPae->id != null){
                                            $fecha_inicio = date_create($modelPae->fecha_inicio);
                                            $fecha_inicio = date_format($fecha_inicio,"d-m-Y H:i:s");
                                        }
                                        ?>
                                        <input type="text" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>" id="fecha_inicio" class="span-12" disabled="disabled">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Ultima fecha de Actualización</label>
                                        <?php
                                        if($modelPae->id != null){
                                            $fecha_ultima_actualizacion = date_create($modelPae->fecha_ultima_actualizacion);
                                            $fecha_ultima_actualizacion = date_format($fecha_ultima_actualizacion,"d-m-Y H:i:s");
                                        }
                                        ?>
                                        <input type="text" name="fecha_ultima_actualizacion" value="<?php echo $fecha_ultima_actualizacion; ?>" id="PlantelPae_fecha_ultima_actualizacion" class="span-12" disabled="disabled">
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <label for="PlantelPae_tipo_servicio_pae_id">Tipo de Servicio <?php echo $requerido; ?></label>
                                        <?php
                                        echo $form->dropDownList(
                                            $modelPae, 'tipo_servicio_pae_id', CHtml::listData(CTipoServicioPae::getData(), 'id', 'nombre'), array('empty' => array('' => '- - -'), 'class' => 'span-12', "required"=>"required",)
                                        );
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'proveedor_actual_id'); ?>
                                        <?php echo $form->dropDownList($modelPae, 'proveedor_actual_id', CHtml::listData(CProveedor::getData(), 'id', 'abreviatura'), array('prompt'=>'Otro Proveedor', 'class' => 'span-12', )); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'posee_proveedor_complementario'); ?>
                                        <?php echo $form->dropDownList($modelPae, 'posee_proveedor_complementario', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <label for="PlantelPae_posee_area_produccion_agricola">¿Posee Área de Producción Agricola? <?php echo $requerido; ?></label>
                                    <?php echo $form->dropDownList($modelPae, 'posee_area_produccion_agricola', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required", 'data-affectedField'=>'PlantelPae_hectareas_produccion',)); ?>
                                </div>

                                <div class="col-md-4">
                                    <label for="PlantelPae_hectareas_produccion">Área de Producción (mt<sup>2</sup>)</label>
                                    <?php
                                    $disabled = '';
                                    if($modelPae->posee_area_produccion_agricola == 'NO'){
                                        $disabled = "readonly";
                                    }
                                    ?>
                                    <?php echo $form->textField($modelPae,'hectareas_produccion', array('class' => 'span-12', 'readonly' => $disabled)); ?>
                                </div>

                                <div class="col-md-4">
                                    <label for="PlantelPae_posee_simoncito">¿Posee el Programa Simoncito?</label>
                                    <?php echo $form->dropDownList($modelPae, 'posee_simoncito', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-4">
                                        <label for="PlantelPae_posee_area_cocina">¿Posee área para el Servicio de Alimentación? <?php echo $requerido; ?></label>
                                        <?php echo $form->dropDownList($modelPae, 'posee_area_cocina', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="PlantelPae_condicion_servicio_id">Condición de Servicio <?php echo $requerido; ?></label>
                                        <?php
                                        echo $form->dropDownList(
                                            $modelPae, 'condicion_servicio_id', CHtml::listData(CCondicionServicio::getData(), 'id', 'nombre'  ), array('empty' => array('' => '- SELECCIONE -'), 'class' => 'span-12')
                                        );
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'posee_permiso_sanitario_vigente'); ?>
                                        <?php echo $form->dropDownList($modelPae, 'posee_permiso_sanitario_vigente', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required",)); ?>
                                    </div>

                                </div>

                            </div>

                        </div><!-- form -->

                    </div><!-- search-form -->
                </div><!-- search-form -->
            </div>
        </div>
    </div>
</div>

<div class="widget-box">
    <div class="widget-header">
        <h5>Matrícula y Madres Procesadoras del PAE - <?php echo '('.$model->cod_plantel.') '.$model->nombre; ?></h5>
        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="">
            <div class="widget-main">

                <a href="#" class="search-button"></a>
                <div style="display:block" class="search-form">
                    <div class="widget-main form">
                        <div class="form" id="divFormMatricula">

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'posee_maternal'); ?>
                                        <?php echo $form->dropDownList($modelPae, 'posee_maternal', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required", 'data-affectedField'=>'PlantelPae_matricula_maternal',)); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'matricula_maternal'); ?>
                                        <?php echo $form->numberField($modelPae,'matricula_maternal', array('class' => 'span-12', 'min'=>'0', 'max'=>'4000', "required"=>"required",)); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'imparte_educacion_preescolar'); ?>
                                        <?php echo $form->dropDownList($modelPae, 'imparte_educacion_preescolar', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required", 'data-affectedField'=>'PlantelPae_matricula_preescolar',)); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'matricula_preescolar'); ?>
                                        <?php echo $form->numberField($modelPae,'matricula_preescolar', array('class' => 'span-12', 'min'=>'0', 'max'=>'4000', "required"=>"required",)); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'imparte_educacion_primaria'); ?>
                                        <?php echo $form->dropDownList($modelPae, 'imparte_educacion_primaria', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required", 'data-affectedField'=>'PlantelPae_matricula_educacion_primaria',)); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'matricula_educacion_primaria'); ?>
                                        <?php echo $form->numberField($modelPae,'matricula_educacion_primaria', array('class' => 'span-12', 'min'=>'0', 'max'=>'4000', "required"=>"required",)); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'imparte_educacion_media_general'); ?>
                                        <?php echo $form->dropDownList($modelPae, 'imparte_educacion_media_general', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required", 'data-affectedField'=>'PlantelPae_matricula_educacion_media_general',)); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'matricula_educacion_media_general'); ?>
                                        <?php echo $form->numberField($modelPae,'matricula_educacion_media_general', array('class' => 'span-12', 'min'=>'0', 'max'=>'4000', "required"=>"required",)); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'imparte_educacion_tecnica'); ?>
                                        <?php echo $form->dropDownList($modelPae, 'imparte_educacion_tecnica', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required", 'data-affectedField'=>'PlantelPae_matricula_educacion_tecnica',)); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'matricula_educacion_tecnica'); ?>
                                        <?php echo $form->numberField($modelPae,'matricula_educacion_tecnica', array('class' => 'span-12', 'min'=>'0', 'max'=>'4000', "required"=>"required",)); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'imparte_educacion_especial'); ?>
                                        <?php echo $form->dropDownList($modelPae, 'imparte_educacion_especial', array('NO'=>'No', 'SI'=>'Sí',), array('prompt'=>'- - -', 'class' => 'span-12', "required"=>"required", 'data-affectedField'=>'PlantelPae_matricula_educacion_especial',)); ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($modelPae,'matricula_educacion_especial'); ?>
                                        <?php echo $form->numberField($modelPae,'matricula_educacion_especial', array('class' => 'span-12', 'min'=>'0', 'max'=>'4000', "required"=>"required",)); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-sm-4">
                                        <?php echo $form->labelEx($modelPae,'matricula_docente_obrero'); ?>
                                        <?php echo $form->numberField($modelPae,'matricula_docente_obrero', array('class' => 'span-12', 'min'=>'0', 'max'=>'500', "required"=>"required",)); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Matricula Total</label>
                                        <input type="text" class="span-12" value="0" id="matriculaTotal" disabled="disabled"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <?php echo $form->labelEx($modelPae,'cantidad_madres_procesadoras'); ?>
                                        <?php echo $form->numberField($modelPae,'cantidad_madres_procesadoras', array('class' => 'span-12', 'min'=>'0', 'max'=>'4000', "required"=>"required",)); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                        </div><!-- search-form -->
                    </div><!-- search-form -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <hr>
    <div class="col-sm-12">
        <?php
        if($modelPae->pae_activo == 'SI'){
            $class = 'danger';
            $value = 'Inactivar';
            $icon = 'down';
        }
        elseif($modelPae->pae_activo == 'NO'){
            $class = 'success';
            $value = 'Guardar Datos y Activar';
            $icon = 'up';
        }
        else{
            $class = '... hide';
            $value = '...';
            $icon = '...';
        }
        ?>
        <div class="col-xs-6">
            <a class="btn btn-danger" href="<?php echo Yii::app()->createUrl("/registroUnico/plantelesPae/lista"); ?>" id="btnRegresarDatosPae">
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
        <div class="col-sm-6" align="right">
            <?php
            if($modelPae->pae_activo != null){
                if($modelPae->pae_activo != null &&  Yii::app()->user->pbac('registroUnico.plantelesPae.admin')){
                    ?>
                <?php
                }
                ?>
                &nbsp;&nbsp;
                <button type="submit" class="btn btn-info"  id="btnEstatusActualizar">
                    Guardar Datos
                    <i class="fa fa-save"></i>
                </button>
            <?php
            }
            else if($modelPae->pae_activo == null && Yii::app()->user->pbac('planteles.modificar.admin')){
                ?>
                <button type="submit" class="btn btn-success" id="btnEstatusActivacion">
                    Guardar Datos y Activar el Servicio
                    <i class="fa fa-arrow-up"></i>
                </button>
                &nbsp;&nbsp;
                <a class="btn btn-info hide" type="submit" id="btnEstatusGuardar">
                    Guardar Datos y Activar el Servicio
                    <i class="fa fa-arrow-up"></i>
                </a>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<div id="dialogPantallaConfirmacion">
    <div class="infoDialogBox hide">
        <p>
            ¿Está usted realmente seguro de guardar estos cambios de matricula?
            <br/>
            Estos datos seran comprobados luego con la matricula cargada en el Sistema de Gestion Escolar.
            <br/>
            Tenga en cuenta que no podrá editar de nuevo estos datos.
        </p>
    </div>
</div>
<div id="dialogPantallaObservacion" class="hide">
    <div class="alertDialogBox" id="mensajeAlertaInfo"><p>Indique detalladamente el motivo por el cual quiere realizar esta acción.</p></div>
    <div class="errorDialogBox hide" id="mensajeAlerta"><p>Hay campos vacíos que son requeridos.</p></div>
    <div class="row">
        <div id="motivoEstatus" class="hide">
            <b>Motivo</b> <span class="required">*</span><br>
            <select class="col-sm-12" id="motivo_inactividad">
                <option value="">- - -</option>
                <?php
                $motivos = CMotivoInactividadPae::getData();
                foreach($motivos AS $motivo){
                    echo '<option value="' . $motivo['id'] . '"> ' . $motivo["nombre"] . '</option>';
                }
                ?>
            </select><br><br>
        </div>
        <b>Observación</b> <span class="required">*</span><br>
        <textarea id="razonAccion" class="col-sm-12"></textarea>
    </div>
</div>


<div id="confirmacion" class="hide">
    <div class="alertDialogBox" id="mensajeAlertaInfo">
        <p>
            ¿Está usted seguro de guardar los datos y activar el servicio del PAE en esta Institución Educativa?
            <br/><br/>
            &nbsp;&nbsp;- Estos datos seran comprobados luego con el Sistema de Gestión Escolar.
            <br/>
            &nbsp;&nbsp;- Tenga en cuenta que no podrá editar de nuevo estos datos.
        </p>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/registroUnico/plantelPae.js', CClientScript::POS_END);
?>
