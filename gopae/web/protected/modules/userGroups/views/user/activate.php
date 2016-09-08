<?php
$this->breadcrumbs = array(
    Yii::t('userGroupsModule.recovery', 'User Activation'),
);
?>
<div id="userGroups-container">
    <?php if (Yii::app()->user->hasFlash('mail')): ?>
    <div class="info">
            <?php echo Yii::app()->user->getFlash('mail'); ?>
        </div>
    <?php endif; ?>
    <div class="form ">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-groups-activate-form',
            'enableAjaxValidation' => false,
        ));
        ?>
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
                                        <div class="row">
                                            <?php echo $form->labelEx($activeModel, 'username', array('class' => 'col-md-3')); ?>
                                            &nbsp;
                                            <?php echo $form->textField($activeModel, 'username'); ?>
                                            <?php echo $form->error($activeModel, 'username'); ?>
                                        </div>
                                        <div class="col-md-12"><div class="space-6"></div></div>
                                        <div class="row">
                                            <?php echo $form->labelEx($activeModel, 'activation_code', array('class' => 'col-md-3')); ?>
                                            &nbsp;
                                            <?php echo $form->textField($activeModel, 'activation_code'); ?>
                                            <?php echo $form->error($activeModel, 'activation_code'); ?>
                                        </div>
                                        <hr style="margin-bottom:10px">
                                        <div class="row pull-right">
                                            <?php echo CHtml::hiddenField('id', $form->id); ?>
                                            <button id="btnRecuperarClave" type="submit" data-last="Finish" class="btn btn-primary btn-sm">
                                                Recuperar Clave
                                                <i class="icon-key icon-on-right"></i>
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

    <hr>

    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-groups-request-form',
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="tab-pane active" id="autoridadZonaContacto">
            <div id="resultadoControlZonaDirectores">
            </div>
            <div class="widget-box collapsed">

                <div style="border-width: thin" class="widget-header">
                    <h5>Reenvio de Correo Electrónico</h5>

                    <div class="widget-toolbar">
                        <a data-action="collapse" href="#">
                            <i class="icon-chevron-down"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body ">

                    <div class="widget-body-inner">

                        <div class="widget-main form">

                            <div class="row">

                                <div class="row-fluid">

                                    <div class="col-md-12">
                                        <div class="row">
                                            <?php echo $form->labelEx($requestModel, 'email', array('class' => 'col-md-3')); ?>
                                            &nbsp;
                                            <?php echo $form->textField($requestModel, 'email'); ?>
                                            <?php echo $form->error($requestModel, 'email'); ?>
                                        </div>
                                        <hr style="margin-bottom:10px">
                                        <div class="row pull-right">
                                            <?php echo CHtml::hiddenField('id', $form->id); ?>
                                            <button id="btnReenviarCorreo" type="submit" data-last="Finish" class="btn btn-primary btn-sm">
                                                Reenviar Correo
                                                <i class="icon-envelope icon-on-right"></i>
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
