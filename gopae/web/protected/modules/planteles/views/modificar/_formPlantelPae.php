<div class="widget-box">
    <div class="widget-header">
        <h5>Datos del PAE</h5>
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
                        
                        

<div class="form">
    <?php
        $bloqueaCamposMatricula = '';
        $puedeEditarMatricula = $this->hasPermissionToEditMatricula($model);
        if($puedeEditarMatricula):
    ?>
    <div class="infoDialogBox">
        <p>
            El Periodo para cargar la cantidad de matricula es desde el d&iacute;a <?php echo Utiles::transformDate($fechaIniMatricula, '-', 'ymd', 'dmy'); ?> hasta el d&iacute;a <?php echo Utiles::transformDate($fechaFinMatricula, '-', 'ymd', 'dmy'); ?>. Estos datos seran comprobados luego con la matricula cargada en el <a href="<?php echo Utiles::$gescolar; ?>">Sistema de Gestion Escolar</a>.
        </p>
    </div>
    <?php
    else:
        $bloqueaCamposMatricula = 'disabled';
    endif;
    ?>
    <div class="successDialogBox hide" id="mensajeAlertaExito"><p>Datos del plantel modificado con éxito.</p></div>
<div class="errorDialogBox hide" id="mensajeAlertaError"></div>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'plantel-pae-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

<?php
    if($model->pae_activo != null){
        $requerido = '';
    }
    else if($model->pae_activo == null){
        $requerido = '<span class="required">*</span>';
    }
?>

    <div class="row">

	<div class="col-sm-4">
            <?php echo $form->hiddenField($model,'id'); ?>
            <?php echo $form->hiddenField($model,'plantel_id'); ?>
            <?php echo $form->hiddenField($model,'edito_matricula'); ?>
            <label>¿El PAE se encuentra activo?</label>
            <?php echo $form->textField($model,'pae_activo',array('size'=>2,'maxlength'=>2, 'class' => 'span-12', 'disabled' => 'disabled')); ?>
	</div>

	<div class="col-sm-4">
            <label>Tipo de Servicio <?php echo $requerido; ?></label>
            <?php // echo $model->tipoServicioPae->nombre; ?>
            <?php // echo $form->textField($model,'tipo_servicio_pae_id'); ?>
            <?php
            $disabled = '';
            if($model->tipo_servicio_pae_id != ''){
                $disabled = 'disabled';
            }
            echo $form->dropDownList(
                    $model, 'tipo_servicio_pae_id', CHtml::listData(CTipoServicioPae::getData(), 'id', 'nombre'), array('empty' => array('' => '- - -'), 'class' => 'span-12', 'disabled' => $disabled)
            );
            ?>
	</div>

	<div class="col-sm-4">
            <label>Condición de Servicio <?php echo $requerido; ?></label>
            <?php
            echo $form->dropDownList(
                    $model, 'condicion_servicio_id', CHtml::listData(CCondicionServicio::getData(), 'id', 'nombre'  ), array('empty' => array('' => '- SELECCIONE -'), 'class' => 'span-12')
            );
            ?>
	</div>
        
    </div>
    <br>
    <div class="row">
        
	<div class="col-sm-4">
            <label>Fecha de Inicio</label>
            <?php
//            var_dump($model->id);
            $fecha_inicio = '';
            $fecha_ultima_actualizacion = '';
            if($model->id != null){
                $fecha_inicio = date_create($model->fecha_inicio);
                $fecha_inicio = date_format($fecha_inicio,"d-m-Y H:i:s");
            }
            ?>
            <input type="text" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>" id="fecha_inicio" class="span-12" disabled="disabled">
	</div>

	<div class="col-sm-4">
            <label>Ultima fecha de Actualización</label>
            <?php
            if($model->id != null){
                $fecha_ultima_actualizacion = date_create($model->fecha_ultima_actualizacion);
                $fecha_ultima_actualizacion = date_format($fecha_ultima_actualizacion,"d-m-Y H:i:s");
            }
            ?>
            <input type="text" name="fecha_ultima_actualizacion" value="<?php echo $fecha_ultima_actualizacion; ?>" id="PlantelPae_fecha_ultima_actualizacion" class="span-12" disabled="disabled">
	</div>

	<div class="col-sm-4">
            <label>¿Posee area de cocina? <?php echo $requerido; ?></label>
            <?php
            echo $form->dropDownList(
                    $model, 'posee_area_cocina', CHtml::listData(array(array('id' => 'SI', 'nombre' => 'SI'), array('id' => 'NO', 'nombre' => 'NO')), 'id', 'nombre'  ), array('class' => 'span-12')
            );
            ?>
	</div>
        
    </div>
    <br>
    
    <div class="row">

	<div class="col-sm-4">
            <label>¿Posee Simoncito? <?php echo $requerido; ?></label>
            <?php
            if($model->edito_matricula == 'SI'){
                $bloqueaCamposMatricula = 'disabled';
            }
            ?>
            <?php
            echo $form->dropDownList(
                    $model, 'posee_simoncito', CHtml::listData(array(array('id' => 'SI', 'nombre' => 'SI'), array('id' => 'NO', 'nombre' => 'NO')), 'id', 'nombre'  ), array('class' => 'span-12', 'disabled' => $bloqueaCamposMatricula)
            );
            ?>
	</div>

	<div class="col-sm-4">
            <label>¿Posee área de producción agricola? <?php echo $requerido; ?></label>
            <?php
            echo $form->dropDownList(
                    $model, 'posee_area_produccion_agricola', CHtml::listData(array(array('id' => 'SI', 'nombre' => 'SI'), array('id' => 'NO', 'nombre' => 'NO')), 'id', 'nombre'  ), array('class' => 'span-12')
            );
            ?>
	</div>

	<div class="col-sm-4">
            <label>Hectareas de producción</label>
            <?php
            $disabled = '';
            if($model->posee_area_produccion_agricola == 'NO'){
                $disabled = "disabled";
            }
            ?>
            <?php echo $form->textField($model,'hectareas_produccion', array('class' => 'span-12', 'disabled' => $disabled)); ?>
            <?php echo $form->hiddenField($model,'hectareas_produccion', array('class' => 'span-12', 'id' => 'hectareas_produccion_hidden')); ?>
	</div>
        
    </div>
    <br>
    <div class="row">

	<div class="col-sm-4">
            <label>Matricula Simoncito</label>
            <?php
            if($model->matricula_simoncito != 0 || $model->posee_simoncito == 'NO'){
                $bloqueaCamposMatricula = 'disabled';
            }
            ?>
            <?php echo $form->textField($model,'matricula_simoncito', array('class' => 'span-12', 'disabled' => $bloqueaCamposMatricula, 'maxlength' => '3', 'data-actual' => $model->matricula_simoncito)); ?>
            <?php echo $form->hiddenField($model,'matricula_simoncito', array('class' => 'span-12', 'id' => 'matricula_simoncito_hidden')); ?>
	</div>

	<div class="col-sm-4">
            <label>Matricula General</label>
            <?php
            $bloqueaCamposMatricula = '';
            $puedeEditarMatricula = $this->hasPermissionToEditMatricula($model);
            if(!$puedeEditarMatricula){
                $bloqueaCamposMatricula = 'disabled';
            }
            ?>
            <?php echo $form->textField($model,'matricula_general', array('class' => 'span-12', 'disabled' => $bloqueaCamposMatricula, 'maxlength' => '4', 'data-actual' => $model->matricula_general)); ?>
	</div>
        
        <div class="col-sm-4">
            <label>Matricula Total</label>
            <input type="text" class="span-12" value="0" id="matriculaTotal" disabled="disabled"/>
        </div>
        
    </div>

<?php $this->endWidget(); ?>

</div><!-- form --> 
                        
                    </div><!-- search-form -->
                </div><!-- search-form -->
            </div>
        </div>
    </div>
</div>

<hr>
<div class="col-sm-12">
    <?php
    if($model->pae_activo == 'SI'){
        $class = 'danger';
        $value = 'Inactivar';
        $icon = 'down';
    }
    elseif($model->pae_activo == 'NO'){
        $class = 'success';
        $value = 'Activar';
        $icon = 'up';
    }
    else{
        $class = '... hide';
        $value = '...';
        $icon = '...';
    }
    ?>
    <div class="col-sm-6"></div>
    <div class="col-sm-6" align="right">
        <?php
        if($model->pae_activo != null){
            if($model->pae_activo != null &&  Yii::app()->user->pbac('planteles.modificar.admin')){
        ?>
            <a class="btn btn-<?php echo $class; ?>" onclick="accion(<?php echo $model->plantel_id; ?>, '<?php echo $value; ?>', '<?php echo $class; ?>', '<?php echo $icon; ?>', '<?php echo $model->pae_activo; ?>');" id="btnEstatusAccion">
                <?php echo $value; ?>
                <i class="fa fa-arrow-<?php echo $icon; ?>"></i>
            </a>
        <?php
        }
        ?>
            &nbsp;&nbsp;
            <a class="btn btn-info" onclick="guardarCambios();" id="btnEstatusAccion">
                Guardar
                <i class="fa fa-save"></i>
            </a>
        <?php
        }
        else if($model->pae_activo == null && Yii::app()->user->pbac('planteles.modificar.admin')){
        ?>
            <a class="btn btn-success" onclick="accionActivar(<?php echo base64_decode($_REQUEST['id']); ?>);" id="btnEstatusAccion">
                Activar
                <i class="fa fa-arrow-up"></i>
            </a>
            &nbsp;&nbsp;
            <a class="btn btn-info hide" onclick="guardarCambios();" id="btnEstatusAccionGuardar">
                Guardar
                <i class="fa fa-save"></i>
            </a>
        <?php
        }
        ?>
    </div>
</div>
<br><br><br>
<div id="dialogPantallaConfirmacion">
    <div class="infoDialogBox hide"><p>¿Estas realmente seguro que deseas guardar estos cambios de matricula? Estos datos seran comprobados luego con la matricula cargada en el Sistema de Gestion Escolar.</p></div>
</div>
<div id="dialogPantallaObservacion" class="hide">
    <div class="alertDialogBox" id="mensajeAlertaInfo"><p>Indique el motivo detalladamente por el cual quiere realizar esta acción.</p></div>
    <div class="errorDialogBox hide" id="mensajeAlerta"><p>Hay campos vacios que son requeridos.</p></div>
    <div class="row">
        <div id="motivoEstatus" class="hide">
            <b>Motivo</b> <span class="required">*</span><br>
            <select class="col-sm-12" id="motivo_inactividad">
                <option value="">- - -</option>
                <?php
                $motivos = MotivoInactividadPae::model()->findAll();
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
    <div class="alertDialogBox" id="mensajeAlertaInfo"><p><b>¿Estas seguro que deseas activar servicios del PAE?.</b></p></div>
</div>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/plantelPae.js', CClientScript::POS_END);
?>
