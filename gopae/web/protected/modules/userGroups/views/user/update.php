<div id="userGroups-container">
	<div class="userGroupsMenu-container">
		<?php $this->renderPartial('/admin/menu', array(
			'mode' => 'profile', 
			'username' => Yii::app()->user->id === $miscModel->id ? NULL : $miscModel->username,
		)); ?>
	</div>
	
	<h1><?php echo Yii::t('userGroupsModule.general','Update User').' '.ucfirst($miscModel->username); ?></h1>
	<h2><?php echo Yii::t('userGroupsModule.general', 'Security'); ?></h2>
	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-groups-password-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
	)); ?>
		<p class="note">Campos con <span class="required">*</span> son olbigatorios.</p>
		
		<?php if (Yii::app()->user->pbac('userGroups.user.admin') && Yii::app()->user->id !== $passModel->id) :?>
			<?php echo $form->hiddenField($passModel,'old_password', array('value'=>'filler'))?>
		<?php else: ?>
		<div class="row">
			<?php echo $form->labelEx($passModel,'old_password'); ?>
			<?php echo $form->passwordField($passModel,'old_password',array('size'=>60,'maxlength'=>120)); ?>
			<?php echo $form->error($passModel,'old_password'); ?>
		</div>
		<?php endif; ?>
		<div class="row">
			<?php echo $form->labelEx($passModel,'password'); ?>
			<?php echo $form->passwordField($passModel,'password',array('size'=>60,'maxlength'=>120)); ?>
			<?php echo $form->error($passModel,'password'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($passModel,'password_confirm'); ?>
			<?php echo $form->passwordField($passModel,'password_confirm',array('size'=>60,'maxlength'=>120)); ?>
			<?php echo $form->error($passModel,'password_confirm'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::hiddenField('formID', $form->id) ?>
			<?php echo CHtml::ajaxSubmitButton(Yii::t('userGroupsModule.general','Change Password'), Yii::app()->baseUrl .'/userGroups/user/update/id/'.$passModel->id, array('update' => '#userGroups-container'), array('id' => 'submit-pass'.$passModel->id.rand()) ); ?>
		</div>

	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>