<?php
/* @var $this userGroups/UsuarioController */
/* @var $model UserGroupsUsuario */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-groups-user-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('onSubmit' => "return validateUserForm('$id');")
        )
    );
?>
<div class="widget-box">

    <div class="widget-header">
        <h5>Información General del Usuario</h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">

        <div class="widget-body-inner">

            <div class="widget-main form">
                <?php $errSummary = $form->errorSummary($model); ?>
                <?php if (!empty($errSummary)): ?>
                    <div class="row-fluid" id="resultado">
                        <div class="errorDialogBox"><?php echo $form->errorSummary($model); ?></div>
                    </div>
                <?php else: ?>
                    <div class="row-fluid" id="resultado">
                        <div class="infoDialogBox">
                            <p>
                                Todos los campos con <span class="required">*</span> son requeridos. 
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <input type="hidden" id='id' name="id" value="<?php echo $model->id ?>" />
                <div class="row">
                    <div class="row-fluid">

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_cedula">Cédula <span class="required">*</span></label>
                            <?php if($id=='new'): ?>
                                <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][cedula]', $data->cedula, array('style' => 'width: 80%;', 'maxlength' => '10', 'required' => 'required')); ?>
                            <?php else: ?>
                                <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][cedula]', $data->cedula, array('style' => 'width: 80%;', 'maxlength' => '10', 'required' => 'required', 'readonly'=>'readonly')); ?>
                            <?php endif;?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_nombre">Nombre <span class="required">*</span></label>
                            <?php if(Yii::app()->user->name=='admin'): ?>
                            <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][nombre]', $data->nombre, array('style' => 'width: 80%;', 'maxlength' => '40', 'required' => 'required')); ?>
                            <?php else: ?>
                            <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][nombre]', $data->nombre, array('style' => 'width: 80%;', 'maxlength' => '40', 'required' => 'required', 'readonly'=>'readonly')); ?>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_apellido">Apellido <span class="required">*</span></label>
                            <?php if(Yii::app()->user->name=='admin'): ?>
                            <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][apellido]', $data->apellido, array('style' => 'width: 80%;', 'maxlength' => '40', 'required' => 'required')); ?>
                            <?php else: ?>
                            <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][apellido]', $data->apellido, array('style' => 'width: 80%;', 'maxlength' => '40', 'required' => 'required', 'readonly'=>'readonly')); ?>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="space-6"></div>
                    </div>

                    <div class="row-fluid">

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_telefono">Teléfono Fijo</label>
                            <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][telefono]', $data->telefono, array('style' => 'width: 80%;', 'maxlength' => '11')); ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_telefono_celular">Teléfono Celular</label>
                            <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][telefono_celular]', $data->telefono_celular, array('style' => 'width: 80%;', 'maxlength' => '11')); ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_email">Correo Electrónico <span class="required">*</span></label>
                            <?php echo CHtml::emailField('UserGroupsAccess[' . $what . '][email]', $data->email, array('style' => 'width: 80%;', 'maxlength' => '40', 'required' => 'required')); ?>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="space-6"></div>
                    </div>

                    <div class="row-fluid">

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_estado_id">Estado/Provincia <span class="required">*</span></label>
                            <?php echo CHtml::dropDownList('UserGroupsAccess[' . $what . '][estado_id]', $data->estado_id, $estados, array('prompt' => '- SELECCIONE -', 'required'=>'required', 'style'=>'width: 80%;')); ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_group_id">Grupo de Usuario <span class="required">*</span></label>
                            <?php echo CHtml::dropDownList('UserGroupsAccess[' . $what . '][group_id]', $data->group_id, $grupos, array('prompt' => '- SELECCIONE -', 'required'=>'required', 'style'=>'width: 80%;') ); ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_home">Página de Inicio <span class="required">*</span></label>
                            <?php echo CHtml::dropDownList('UserGroupsAccess[' . $what . '][home]', $data->home, $home_lists, array('prompt' => '- SELECCIONE -', 'required'=>'required', 'style'=>'width: 80%;')); ?>
                        </div>

                    </div>
                    
                    <div class="col-md-12">
                        <div class="space-6"></div>
                    </div>

                    <div class="row-fluid">

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_username">Usuario <span class="required">*</span></label>
                            <?php if(Yii::app()->user->name=='admin'): ?>
                            <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][username]', $data->username, array('style' => 'width: 80%;', 'maxlength' => '14', 'required' => 'required')); ?>
                            <?php else: ?>
                            <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][username]', $data->username, array('style' => 'width: 80%;', 'maxlength' => '14', 'required' => 'required', 'readonly'=>'readonly')); ?>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_password">Clave <span class="required">*</span></label>
                            <?php if($id=='new'): ?>
                                <?php echo CHtml::passwordField('UserGroupsAccess[' . $what . '][password]', '', array('style' => 'width: 80%;', 'maxlength' => '200', 'required' => 'required')); ?>
                            <?php else: ?>
                                <?php echo CHtml::passwordField('UserGroupsAccess[' . $what . '][password]', '', array('style' => 'width: 80%;', 'maxlength' => '200')); ?>
                            <?php endif;?>
                        </div>

                        <div class="col-md-4">
                            <label class="col-md-12" for="confirm_password">Confirme su Clave <span class="required">*</span></label>
                            <?php if($id=='new'): ?>
                                <?php echo CHtml::passwordField('UserGroupsAccess[' . $what . '][password_confirm]', '', array('style' => 'width: 80%;', 'maxlength' => '40', 'required' => 'required')); ?>
                            <?php else: ?>
                                <?php echo CHtml::passwordField('UserGroupsAccess[' . $what . '][password_confirm]', '', array('style' => 'width: 80%;', 'maxlength' => '40')); ?>
                            <?php endif;?>
                        </div>

                    </div>
                    
                    <div class="col-md-12">
                        <div class="space-6"></div>
                    </div>

                    <div class="row-fluid">

                        <div class="col-md-4">
                            <label class="col-md-12" for="UserGroupsAccess_1_status">Estatus <span class="required">*</span></label>
                            <?php echo CHtml::dropDownList('UserGroupsAccess[' . $what . '][status]', $data->status, $status, array('prompt' => '- SELECCIONE -', 'required'=>'required', 'style'=>'width: 80%;')); ?>
                        </div>

                    </div>
                    
                    <input type="hidden" name="userAdminToken" value="<?php echo $token; ?>" />
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(Yii::app()->user->name=='admin'): ?>
<div class="widget-box collapsed">

    <div class="widget-header">
        <h5>Permisología Personalizada al Usuario</h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-down"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">

        <div class="widget-body-inner">

            <div class="widget-main form">

                <div class="tab-pane">

                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'dataProvider' => $dataProvider,
                        'ajaxUpdate' => false,
                        'enableSorting' => false,
                        'summaryText' => false,
                        'id' => 'rule-list',
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'selectableRows' => 0,
                        'htmlOptions' => array('class' => 'x'),
                        'selectableRows' => 0,
                        'columns' => array(
                            array(
                                'name' => 'Module',
                            ),
                            array(
                                'name' => 'Controller',
                            ),
                            array(
                                'name' => 'Read',
                                'type' => 'raw',
                            ),
                            array(
                                'name' => 'Write',
                                'type' => 'raw',
                            ),
                            array(
                                'name' => 'Admin',
                                'type' => 'raw',
                            ),
                        ),
                    ));
                    ?>

                    <div class="space-6"></div>

                </div>

            </div>

        </div>

    </div>

</div>
<?php endif; ?>
<hr>

<div class="row">

    <div class="pull-left" style="margin-left: 12px;">
        <a class="btn btn-danger" href="<?php echo Yii::app()->createUrl('userGroups/usuario'); ?>">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
    </div>
    <div class="pull-right" style="margin-right: 12px;">
        <button class="btn btn-primary btn-next" data-last="Finish" type="submit">
            Guardar
            <i class="icon-save icon-on-right"></i>
        </button>
    </div>

</div>

<div class="row buttons left-flotted">
<?php echo CHtml::hiddenField('UserGroupsAccess[what]', $what); ?>
<?php echo CHtml::hiddenField('UserGroupsAccess[id]', $id); ?>
<?php echo CHtml::hiddenField('UserGroupsAccess[displayname]', ucfirst($name)); ?>
</div>
<?php $this->endWidget(); ?>

<div id="dialog_error"><p></p></div>