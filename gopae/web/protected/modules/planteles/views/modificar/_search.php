<div class="widget-main form">



<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


	<div class="row">
		<div class="col-md-2"><b>C&oacute;digo plantel</b></div>
                <div class="col-md-4">
                    <?php echo $form->textField($model,'cod_plantel',array('size'=>10,'maxlength'=>10,'class'=>'span-7')); ?>
                </div>


		<div class="col-md-2"><b>C&oacute;digo estad&iacute;stico</b></div>
                <div class="col-md-4">
                    <?php echo $form->textField($model,'cod_estadistico',array('class'=>'span-7')); ?>
                </div>
	</div>

	<div class="row">

		<div class="col-md-2"><b>Denominaci&oacute;n</b></div>
                <div class="col-md-4">
                    <?php
                    $groupId = Yii::app()->user->group;

                    if($groupId == UserGroups::MISION_RIBAS_NAC)
                    {
                        echo '<select id="Plantel_estatus_plantel_id" name="Plantel[estatus_plantel_id]" class="span-7">
                                    <option value="9">MISIÓN RIBAS</option>
                                </select>';
                    }
                    else
                    {
                        echo $form->dropDownList($model, 'estatus_plantel_id', 
                                CHtml::listData(Denominacion::model()->findAll(array('order' => 'nombre ASC')),'id', 'nombre'),
                                array('empty' => '-Seleccione-','class' => 'span-7')
                        );
                    }
                    ?>
                </div>

		<div class="col-md-2"><b>Nombre del plantel</b></div>
                <div class="col-md-4">
                    <?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>150,'class'=>'span-7')); ?>
                </div>

	</div>

	<div class="row">

		<div class="col-md-2"><b>Estado</b></div>
                <div class="col-md-4">
                    <?php
                    echo $form->dropDownList(
                        $model, 'estado_id', CHtml::listData(Estado::model()->findAll(), 'id', 'nombre'), array(
                        'ajax' => array(
                            'type' => 'GET',
                            'update' => '#municipio',
                            'url' => CController::createUrl('seleccionarMunicipio'),
                        ),
                        'empty' => array('' => '-Seleccione-'), 'class' => 'span-7')
                    );
                    ?>
                </div>


		<div class="col-md-2"><b>Municipio</b></div>
                <div class="col-md-4">
                    <?php
                    echo $form->dropDownList($model, 'municipio_id', array(), array(
                        'empty' => '-Seleccione-',
                        'id' => 'municipio',
                        'class' => 'span-9',
                        'ajax' => array(
                            'type' => 'GET',
                            'update' => '#parroquia',
                            'url' => CController::createUrl('seleccionarParroquia'),
                        ),
                        'empty' => array('' => '-Seleccione-'), 'class' => 'span-7')
                    );
                    ?>
                </div>

	</div>

	<div class="row">

		<div class="col-md-2"><b>Parroquia</b></div>
                <div class="col-md-4">
                    <?php
                    echo $form->dropDownList($model, 'parroquia_id', array(), array(
                        'empty' => '-Seleccione-',
                        'id' => 'parroquia',
                        'class' => 'span-9',
                        'ajax' => array(
                            'type' => 'GET',
                            'update' => '#localidad',
                            'url' => CController::createUrl('seleccionarLocalidad'),
                        ),
                        'empty' => array('' => '-Seleccione-'), 'class' => 'span-7')
                    );
                    ?>
                </div>

		<div class="col-md-2"><b>Modalidad</b></div>
                <div class="col-md-4">
                    <?php
                            echo $form->dropDownList($model, 'modalidad_id', 
                                    CHtml::listData(Modalidad::model()->findAll(array('order' => 'nombre ASC')),'id', 'nombre'),
                                    array('empty' => '-Seleccione-','class' => 'span-7')
                            );
                    ?>
                </div>

	</div>

	<div class="row">


		<div class="col-md-2"><b>Estatus del plantel</b></div>
                <div class="col-md-4">
                    <?php
                            echo $form->dropDownList($model, 'estatus_plantel_id', 
                                    CHtml::listData(EstatusPlantel::model()->findAll(array('order' => 'nombre ASC')),'id', 'nombre'),
                                    array('empty' => '-Seleccione-','class' => 'span-7')
                            );
                    ?>
                </div>

		<div class="col-md-2"><b>Tipo de dependencia</b></div>
                <div class="col-md-4">
                    <?php
                            echo $form->dropDownList($model, 'tipo_dependencia_id', 
                               CHtml::listData(TipoDependencia::model()->findAll(array('order' => 'nombre ASC')),'id', 'nombre'),
                               array('empty' => '-Seleccione-','class' => 'span-7')
                            );
                    ?>
                </div>

		<div class="col-md-2"><b>Cédula del Director</b></div>
                <div class="col-md-4">
                    <input type="text" name="Plantel[cedula_director]" class="span-7" id="cedulaIdentidadDirector" maxlength="10">
                </div>

	</div>

    <div class="space-6"></div>

	<div class="row">
            <div class=" pull-right">
            <div class="col-md-12" style="margin-right: 35px;">
                <button class="btn btn-primary btn-next btn-sm" data-last="Finish" type="submit" id="buscarPlantel">
                    Buscar
                    <i class="fa fa-search icon-on-right"></i>
                </button>
            </div>
            </div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->


<script>
    $(document).ready(function() {

        $('#cedulaIdentidadDirector').bind('keyup blur', function() {
            keyNum(this, true);
        });

    });
</script>