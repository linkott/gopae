<?php
/* @var $this NivelController */
/* @var $model NivelPlantel */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nivel-plantel-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'plantel_id'); ?>
		<?php echo $form->textField($model,'plantel_id'); ?>
		<?php echo $form->error($model,'plantel_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nivel_id'); ?>
		<?php echo $form->textField($model,'nivel_id'); ?>
		<?php echo $form->error($model,'nivel_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario_ini_id'); ?>
		<?php echo $form->textField($model,'usuario_ini_id'); ?>
		<?php echo $form->error($model,'usuario_ini_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_ini'); ?>
		<?php echo $form->textField($model,'fecha_ini',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'fecha_ini'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario_act_id'); ?>
		<?php echo $form->textField($model,'usuario_act_id'); ?>
		<?php echo $form->error($model,'usuario_act_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_act'); ?>
		<?php echo $form->textField($model,'fecha_act',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'fecha_act'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_elim'); ?>
		<?php echo $form->textField($model,'fecha_elim',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'fecha_elim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estatus'); ?>
		<?php echo $form->textField($model,'estatus',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'estatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/nivel.js',CClientScript::POS_END);
?>