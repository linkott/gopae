<?php
/* @var $this ClasePlantelController */
/* @var $model ClasePlantel */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>



	<div class="row">
		<div class="col-md-2"><b>Nombre</b></div>
		<?php echo $form->textField($model,'periodo',array('size'=>30,'maxlength'=>30,'class'=>'span-7')); ?>
	</div>




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