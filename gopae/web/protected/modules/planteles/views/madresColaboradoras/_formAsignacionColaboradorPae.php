
    <div class="row">
        <?php if($this->hasPermissionToAsignColaboradoras($estatusAutoridadPlantel)): ?>
        <!-- Formulario de Asignacion de Colaborador de Plantel -->
        <form name="form-asignacion-colaborador-plantel" id="form-asignacion-colaborador-plantel" action="/planteles/madresColaboradoras/validarAsignacion/id/<?php echo base64_encode($plantel['id']); ?>" method="POST">

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

            <div class="col-md-4">
                <?php echo CHtml::label('Cantidad Necesaria de Colaboradoras', 'cant_necesaria', array()); ?>
                <?php
                    $matriculaTotal = (int)$plantel['matricula_general'];
                    $cantidadNecesariaColaboradoras = PlantelPae::calcularNecesidadDeColaboradoras($plantel['matricula_general']);
                ?>
                <?php echo CHtml::textField('cant_necesaria', $cantidadNecesariaColaboradoras, array('maxlength' => "15", 'class' => 'span-12', 'title'=>'Tomando en Cuenta que la Matricula Total es de '.$matriculaTotal.' estudiantes y que por cada '.PlantelPae::$cantidadDeAlumnosPorColaboradora.' se necesita una colaboradora.', 'disabled'=>'disabled')); ?>
            </div>
            
            <div class="col-md-1">
                <div class='col-md-12'>
                    <?php echo CHtml::label('&nbsp;&nbsp;', 'btn-submit-asignacion-colaborador-plantel', array('class'=>'col-md-12')); ?>
                    <button class="btn btn-xs btn-success" id='btn-submit-asignacion-colaborador-plantel' style="padding: 2.5px 5px;" type="submit">
                        Asignar <i class="icon-plus icon-on-right"></i>
                    </button>
                </div>
            </div>
            
            <div class="col-md-2">
                <div class='col-md-12 text-right'>
                    <?php echo CHtml::label('&nbsp;', 'btn-refresh-colaboradoras-plantel', array('class'=>'col-md-12')); ?>
                    <button title="Refrescar la lista de Madres Colaboradoras" class="btn btn-xs btn-primary" id='btn-refresh-colaboradoras-plantel' style="padding: 2.5px 5px;" type="button">
                        Refrescar <i class="icon-refresh icon-on-right"></i>
                    </button>
                </div>
            </div>

        </form>
        <!-- Fin Formulario de Asignacion de Colaborador de Plantel -->
        <?php endif; ?>
    </div>

    <div class='col-md-12'><div class="row"><div class="col-md-6"></div></div></div>

    <div class="row">

        <div class="infoDialogBox">
            <p>
                1.- Recuerde siempre tener actualizada la matricula de estudiantes en el <a target="_blank" href="https://gescolar.me.gob.ve">Sistema de Gestión Escolar</a> para que se vea actualizada la cantidad de su matricula en el Sistema de Gestión Operativa del Programa de Alimentación Escolar.
                <br />
                2.- Si no posee la Matricula Escolar Actualizada no podrá asignar Madres y Padres Colaboradores a este plantel.
            </p>
        </div>

        <div id="resultado-asignacion-colaboradora"></div>

    </div>

                        
<div id="resultadoDialogoAsignacionColaboradora" class="hide"><center><img src="/public/images/ajax-loader-red.gif"></center></div>

<div id="div-lista-colaboradoras-asignadas"></div>
