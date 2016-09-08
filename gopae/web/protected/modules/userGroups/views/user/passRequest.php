<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-groups-passrequest-form',
    'action' => $this->createUrl('/login/recuperarClave'),
    'enableAjaxValidation' => true,
        ));
?>
<fieldset>
    <label class="block clearfix">
        <span class="block input-icon input-icon-right">
            <?php echo $form->textField($model_pr, 'username', array('id' => 'username_pr', 'class' => 'input form-control', 'required' => 'required', 'placeholder' => 'Usuario')); ?>
            <i class="icon-user"></i>
        </span>
    </label>

    <label class="block clearfix">
        <span class="block input-icon input-icon-right">
            <?php echo $form->textField($model_pr, 'email', array('type' => 'email', 'id' => 'email_pr', 'class' => 'input form-control', 'required' => 'required', 'placeholder' => 'Correo Electrónico')); ?>
            <i class="icon-envelope"></i>
        </span>
    </label>

    <div class="space-24"></div>

    <div class="clearfix">
        
        <button type="submit" class="width-65 pull-right btn btn-sm btn-success">
            Obtener una nueva clave
            <i class="icon-arrow-right icon-on-right"></i>
        </button>
    </div>
</fieldset>

<?php $this->endWidget(); ?>
	