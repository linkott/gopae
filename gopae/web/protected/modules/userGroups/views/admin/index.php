<?php
$this->breadcrumbs=array(
	Yii::t('userGroupsModule.general','profile')=>array('/userGroups'),
	Yii::t('userGroupsModule.general','Root Tools'),
);
?>
<div id="userGroups-container">
	<div class="userGroupsMenu-container">
		<?php $this->renderPartial('/admin/menu', array('mode' => 'profile', 'root' => true))?>
	</div>
	<?php if (!UserGroupsConfiguration::findRule('dumb_admin') || Yii::app()->user->pbac('admin')): ?>
	<?php //$this->renderPartial('configurations', array('confDataProvider'=>$confDataProvider))?>
	<!--<hr/>-->
	<?php //$this->renderPartial('crons', array('cronDataProvider'=>$cronDataProvider))?>
	<!--<hr/>-->
	<?php endif; ?>
	<?php $this->renderPartial('groups', array('groupModel'=>$groupModel))?>
	<hr/>
	<?php $this->renderPartial('users', array('userModel'=>$userModel))?>
</div>
