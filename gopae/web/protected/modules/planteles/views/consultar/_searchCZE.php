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
                    <?php echo $form->textField($model,'cod_estadistico',array('class'=>'span-7', 'maxlength'=>10)); ?>
                </div>
	</div>

	<div class="row">

		<div class="col-md-2"><b>Municipio</b></div>
                <div class="col-md-4">
                    <?php
                    echo $form->dropDownList(
                        $model, 'municipio_id', CHtml::

                        listData(
                            Municipio::model()->findAll(
                                    array(
                                            'condition'=>'estado_id = '.$estadoId
                                    )
                            ), 'id', 'nombre'
                        ),

                        array(
                        'ajax' => array(
                            'type' => 'GET',
                            'update' => '#parroquia',
                            'url' => CController::createUrl('seleccionarParroquia'),
                        ),
                        'empty' => array('' => '-Seleccione-'), 'class' => 'span-7')
                    );
                    ?>
                </div>

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

	</div>

	<div class="row">

		<div class="col-md-2"><b>Modalidad</b></div>
                <div class="col-md-4">
                    <?php
                            echo $form->dropDownList($model, 'modalidad_id', 
                                    CHtml::listData(Modalidad::model()->findAll(array('order' => 'nombre ASC')),'id', 'nombre'),
                                    array('empty' => '-Seleccione-','class' => 'span-7')
                            );
                    ?>
                </div>


		<div class="col-md-2"><b>Estatus del plantel</b></div>
                <div class="col-md-4">
                    <?php
                            echo $form->dropDownList($model, 'estatus_plantel_id', 
                                    CHtml::listData(EstatusPlantel::model()->findAll(array('order' => 'nombre ASC')),'id', 'nombre'),
                                    array('empty' => '-Seleccione-','class' => 'span-7')
                            );
                    ?>
                </div>

	</div>

	<div class="row">

		
		<!--<div class="col-md-2"><b>Nombre del director</b></div>
		<?php //echo $form->textField($model,'director_actual_id',array('class'=>'span-7')); ?>-->
		

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
