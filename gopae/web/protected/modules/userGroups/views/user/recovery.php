<?php
$this->breadcrumbs=array(
	Yii::t('userGroupsModule.recovery','User Activation'),
);

?>
<div id="userGroups-container">
	<div class="col-md-12">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'user-groups-recovery-form',
			'enableAjaxValidation'=>true,
		)); ?>
                <div class="tab-pane active" id="autoridadZonaContacto">
            <div id="resultadoControlZonaDirectores">
                <div class="infoDialogBox">
                    <p>
                        Todos los campos con <span class="required">*</span> son requeridos. 
                    </p>
                </div>
            </div>
            <div class="widget-box">

                <div style="border-width: thin" class="widget-header">
                    <h5>Recuperación de Clave de Usuario</h5>

                    <div class="widget-toolbar">
                        <a data-action="collapse" href="#">
                            <i class="icon-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body">

                    <div class="widget-body-inner">

                        <div class="widget-main form">

                            <div class="row">

                                <div class="row-fluid">

                                    <div class="col-md-12">
                                        <?php if (strpos($model->username, '_user') === 0): ?>
                                        <div class="row">
                                            <?php echo $form->labelEx($model,'username', array('class'=>'col-md-12')); ?>
                                            <?php echo $form->textField($model,'username', array('style'=>'width:40%;')); ?>
                                            <?php echo $form->error($model,'username'); ?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="space-6"></div>
                                        <div>
                                            <?php echo $form->label($model, 'password', array('class'=>'col-md-12')) ?>
                                            <?php echo $form->passwordField($model,'password', array('style'=>'width:40%;', 'required'=>'required')); ?>
                                            <?php echo $form->error($model,'password'); ?>
                                        </div>
                                        <div class="space-6"></div>
                                        <div>
                                            <?php echo $form->label($model, 'password_confirm', array('class'=>'col-md-12')) ?>
                                            <?php echo $form->passwordField($model,'password_confirm', array('style'=>'width:40%;', 'required'=>'required')); ?>
                                            <?php echo $form->error($model,'password_confirm'); ?>
                                        </div>
                                        <?php
                                        /* 
                                        <div>
                                            ?php echo $form->label($model, 'question') ?>
                                            ?php echo $form->textField($model,'question'); ?>
                                            ?php echo $form->error($model,'question'); ?>
                                        </div>
                                        <div>
                                            ?php echo $form->label($model, 'answer') ?>
                                            ?php echo $form->textField($model,'answer'); ?>
                                            ?php echo $form->error($model,'answer'); ?>
                                        </div>*/
                                        ?>
                                        <hr>
                                        <div class="row buttons">
                                            <button name="yt0" class="btn btn-primary btn-next pull-right" title="Actualizar Clave de Acceso" data-last="Finish" type="submit">
                                                Actualizar Clave
                                                <i class="icon-exchange icon-on-right"></i>
                                            </button>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
                
		<?php $this->endWidget(); ?>
	</div>
</div>