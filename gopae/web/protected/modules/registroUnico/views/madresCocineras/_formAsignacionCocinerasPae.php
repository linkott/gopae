
    <div class="row">
        <?php if($this->hasPermissionToAsignCocineras($estatusAutoridadPlantel)): ?>
        <!-- Formulario de Asignacion de Cocinera de Plantel -->
        <form name="form-asignacion-cocinera-plantel" id="form-asignacion-cocinera-plantel" action="/registroUnico/madresCocineras/validarAsignacion/id/<?php echo base64_encode($plantel['id']); ?>" method="POST">

            <?php echo CHtml::hiddenField('plantel_id', base64_encode($plantel['id'])); ?>

            <div class="col-md-2">
                <?php echo CHtml::label('Origen', 'origen', array('required'=>'required')); ?>
                <?php echo CHtml::dropDownList('origen', 'V', CHtml::listData(COrigen::getData(), 'abreviatura', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12')); ?>
            </div>

            <div class="col-md-3">
                <?php echo CHtml::label('Nro. de Documento de Identidad', 'cedula', array('required'=>'required')); ?>
                <?php echo CHtml::textField('cedula', '', array('maxlength' => "15", 'required'=>'required', 'class' => 'span-12', 'title'=>'Nro. de Cédula', 'autocomplete'=>'off')); ?>
                <input id="read_existe_cedula" type="hidden" maxlength="2" disabled='disabled' readOnly="readOnly" />
            </div>

            <div class="col-md-1">
                <?php echo CHtml::label('&nbsp;&nbsp;', 'btn-submit-asignacion-cocinera-plantel', array('class'=>'col-md-12')); ?>
                <button class="btn btn-xs btn-success" id='btn-submit-asignacion-cocinera-plantel' style="padding: 2.5px 5px;" type="submit">
                    Asignar <i class="icon-plus icon-on-right"></i>
                </button>
            </div>

            <div class="col-md-4">
                <?php echo CHtml::label('Cantidad Necesaria de Cocineras', 'cant_necesaria', array()); ?>
                <?php
                    $matriculaTotal = (int)$plantel['matricula_general'];
                    $cantidadNecesariaCocineras = PlantelPae::calcularNecesidadDeCocineras($plantel['matricula_general']);
                ?>
                <?php echo CHtml::textField('cant_necesaria', $cantidadNecesariaCocineras, array('maxlength' => "15", 'class' => 'span-12', 'title'=>'Tomando en Cuenta que la Matricula Total es de '.$matriculaTotal.' estudiantes y que por cada '.PlantelPae::$cantidadDeAlumnosPorCocinera.' se necesita una cocinera.', 'disabled'=>'disabled')); ?>
            </div>
            
            <div class="col-md-2">
                <div class='col-md-12 text-right'>
                    <?php echo CHtml::label('&nbsp;', 'btn-refresh-cocineras-plantel', array('class'=>'col-md-12')); ?>
                    <button title="Refrescar la lista de Madres Cocineras" class="btn btn-xs btn-primary" id='btn-refresh-cocineras-plantel' style="padding: 2.5px 5px;" type="button">
                        Refrescar <i class="icon-refresh icon-on-right"></i>
                    </button>
                </div>
            </div>

        </form>
        <!-- Fin Formulario de Asignacion de Cocinera de Plantel -->
        <?php endif; ?>
    </div>

    <div class='col-md-12'><div class="row"><div class="col-md-6"></div></div></div>

    <div class="row">

        <div class="infoDialogBox">
            <p>
                1.- Recuerde siempre tener actualizada la matricula de estudiantes en el <a target="_blank" href="https://gescolar.me.gob.ve">Sistema de Gestión Escolar</a> para que se vea actualizada la cantidad de su matricula en el Sistema de Gestión Operativa del Programa de Alimentación Escolar.
                <br />
                2.- Si no posee la Matricula Escolar Actualizada no podrá asignar Madres Cocineras y/o Padres Cocineros a este plantel.
            </p>
        </div>

        <div id="resultado-asignacion-cocinera"></div>

    </div>

                        
<div id="resultadoDialogoAsignacionCocinera" class="hide"><center><img src="/public/images/ajax-loader-red.gif"></center></div>

<div id="div-lista-cocineras-asignadas"></div>
