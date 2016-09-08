<div class="widget-main form">



<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>



	<div class="row">

		<div class="col-md-2"><b>Denominaci&oacute;n</b></div>
                <div class="col-md-4">
                    <?php
                            echo $form->dropDownList($model, 'estatus_plantel_id', 
                                    CHtml::listData(Denominacion::model()->findAll(array('order' => 'nombre ASC')),'id', 'nombre'),
                                    array('empty' => '-Seleccione-','class' => 'span-7')
                            );
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

		<div class="col-md-2"><b>Cédula del Director</b></div>
                <div class="col-md-4">
                    <input type="text" name="Plantel[cedula_director]" class="span-7" id="cedulaIdentidadDirector" maxlength="10">
                </div>

	</div>


	<br>

	<div class="row" align="right">
		<div class="col-md-10">
			<button class="btn btn-primary btn-next btn-sm" data-last="Finish" type="submit" id="buscarPlantel">
	            Buscar
	            <i class="fa fa-search icon-on-right"></i>
	        </button>
    	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
