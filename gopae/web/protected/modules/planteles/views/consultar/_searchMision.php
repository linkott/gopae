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
                    <select id="Plantel_estatus_plantel_id" name="Plantel[estatus_plantel_id]" class="span-7">
                        <option value="9">MISIÓN RIBAS</option>
                    </select>
                </div>

		<div class="col-md-2"><b>Nombre del plantel</b></div>
                <div class="col-md-4">
                    <?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>150,'class'=>'span-7')); ?>
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

		<div class="col-md-2"><b>Tipo de dependencia</b></div>
                <div class="col-md-4">
                    <?php
                            echo $form->dropDownList($model, 'tipo_dependencia_id', 
                               CHtml::listData(TipoDependencia::model()->findAll(array('order' => 'nombre ASC')),'id', 'nombre'),
                               array('empty' => '-Seleccione-','class' => 'span-7')
                            );
                    ?>
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
