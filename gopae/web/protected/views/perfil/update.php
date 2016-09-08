<?php
$this->breadcrumbs=array(
	'Mi Perfil',
);

$this->pageTitle='Mi Perfil';

?>
<div class="col-xs-12">
    <div class="row-fluid">

        <div class="tabbable">

            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#perfil">Mis Datos de Acceso</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#contacto">Mis Datos de Contacto</a>
                </li>
            </ul>

            <div class="tab-content">

                <div id="perfil"  class="tab-pane active">

                    <div class="widget-box">

                        <div class="widget-header">
                            <h5>Mis Datos de Acceso</h5>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="icon-chevron-up"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">

                            <div class="widget-body-inner">

                                <div class="widget-main form">

                                    <?php
                                        $form = $this->beginWidget('CActiveForm', array(
                                            'id' => 'user-groups-password-form',
                                            'enableAjaxValidation' => false,
                                            'enableClientValidation' => true,
                                        ));
                                    ?>

                                    <div class="row-fluid" id="resultado">
                                    <?php if($form->errorSummary($passModel)!==''): ?>
                                        <div class="errorDialogBox"><?php echo $form->errorSummary($passModel); ?></div>
                                    <?php else: ?>
                                        <div class="infoDialogBox">
                                            <p>
                                                Todos los campos con <span class="required">*</span> son requeridos.
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                    </div>

                                    <div class="row-fluid">

                                        <div class="col-md-4">
                                            <label for="groupname" class="col-md-12">Cédula</label>
                                            <input type="text" style="width: 80%;" disabled value="<?php echo Yii::app()->user->cedula; ?>" />
                                        </div>

                                        <div class="col-md-4">
                                            <label for="description" class="col-md-12">Nombre</label>
                                            <input type="text" style="width: 80%;" disabled value="<?php echo Yii::app()->user->nombre; ?>" />
                                        </div>

                                        <div class="col-md-4">
                                            <label for="description" class="col-md-12">Apellido</label>
                                            <input type="text" style="width: 80%;" disabled value="<?php echo Yii::app()->user->apellido; ?>" />
                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <div class="space-6"></div>
                                    </div>

                                    <div class="row-fluid">

                                        <div class="col-md-4">
                                            <label for="groupname" class="col-md-12">Estado</label>
                                            <input type="text" style="width: 80%;" disabled value="<?php echo Yii::app()->user->estadoName; ?>" />
                                        </div>

                                        <div class="col-md-4">
                                            <label for="description" class="col-md-12">Usuario</label>
                                            <input type="text" style="width: 80%;" disabled value="<?php echo Yii::app()->user->name; ?>" />
                                        </div>

                                        <div class="col-md-4">
                                            <label for="description" class="col-md-12">Último Login</label>
                                            <input type="text" style="width: 80%;" disabled value="<?php echo Utiles::transformDate(substr(Yii::app()->user->lastLoginTime, 0, 10), '-', 'ymd', 'dmy').substr(Yii::app()->user->lastLoginTime, 10, 9); ?>" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="space-6"></div>
                                    </div>

                                        <?php echo $form->hiddenField($passModel, 'old_password', array('value' => 'filler')) ?>

                                    <div class="row-fluid">

                                        <div class="col-md-4">
                                            <label for="groupname" class="col-md-12">Clave Actual <span class="required">*</span></label>
                                            <?php echo CHtml::passwordField('UserGroupsUser[old_password]', '', array('id'=>'UserGroupsUser_old_password', 'size' => 60, 'maxlength' => 120, 'style'=>'width: 80%;', 'required'=>'required')); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="description" class="col-md-12">Nueva Clave <span class="required">*</span></label>
                                            <?php echo $form->passwordField($passModel, 'password', array('size' => 60, 'maxlength' => 120, 'style'=>'width: 80%;', 'required'=>'required')); ?>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="description" class="col-md-12">Confirme la Nueva Clave <span class="required">*</span></label>
                                            <?php echo $form->passwordField($passModel, 'password_confirm', array('size' => 60, 'maxlength' => 120, 'style'=>'width: 80%;', 'required'=>'required')); ?>
                                        </div>

                                    </div>


                                    <div class="col-md-12">
                                        <div class="space-6"></div>
                                    </div>

                                    <input type="hidden" name="changePasswordToken" value="<?php echo $token; ?>" />

                                    <?php echo CHtml::hiddenField('formID', $form->id) ?>

                                    <hr>

                                    <div class="row">

                                        <div class="col-xs-6">
                                            <a href="/site" class="btn btn-danger">
                                                <i class="icon-arrow-left"></i>
                                                Volver
                                            </a>
                                        </div>

                                        <div class="col-xs-6">
                                            <button class="btn btn-primary btn-next pull-right" title="Cambiar Clave de Acceso" data-last="Finish" type="submit">
                                                Cambiar Clave
                                                <i class="icon-exchange icon-on-right"></i>
                                            </button>
                                        </div>

                                    </div>
                                    <?php $this->endWidget(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="dialog-passwd" class="hide">
                        <div class="alertDialogBox">
                            <p id="mensaje-confirm">
                                ¿Confirma el cambio de clave?
                            </p>
                        </div>
                    </div>

                </div>

                <div id="contacto" class="tab-pane">

                    <div class="widget-box">

                        <div class="widget-header">
                            <h5>Mis Datos de Contacto</h5>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="icon-chevron-up"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">

                            <div class="widget-body-inner">

                                <div class="widget-main form">

                                    <form name="user-groups-contact-form" id="user-groups-contact-form" method="POST" >

                                        <div class="row-fluid" id="resultado-contacto">
                                        <?php if($form->errorSummary($passModel)!==''): ?>
                                            <div class="errorDialogBox"><?php echo $form->errorSummary($passModel); ?></div>
                                        <?php else: ?>
                                            <div class="infoDialogBox">
                                                <p>
                                                    Todos los campos con <span class="required">*</span> son requeridos.
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                        </div>

                                        <div class="row-fluid">

                                            <div class="col-md-6">
                                                <label for="description" class="col-md-12">Nombre</label>
                                                <input type="text" style="width: 90%;" disabled value="<?php echo Yii::app()->user->nombre; ?>" />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="description" class="col-md-12">Apellido</label>
                                                <input type="text" style="width: 90%;" disabled value="<?php echo Yii::app()->user->apellido; ?>" />
                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <div class="space-6"></div>
                                        </div>

                                        <div class="row-fluid">

                                            <div class="col-md-6">
                                                <label for="groupname" class="col-md-12">Teléfono Fijo <span class="required">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon-phone"></i></span>
                                                    <?php echo $form->textField($passModel, 'telefono', array('size' => 60, 'maxlength' => 11, 'style'=>'width: 90%;', 'required'=>'required', "autocomplete"=>"off", 'placeholder'=>'Teléfono Fijo con Código de Área',)); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="description" class="col-md-12">Teléfono Celular</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa-mobile fa"></i></span>
                                                    <?php echo $form->textField($passModel, 'telefono_celular', array('size' => 60, 'maxlength' => 11, 'style'=>'width: 90%;', "autocomplete"=>"off", 'placeholder'=>'Teléfono Celular con Código de Operadora', )); ?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <div class="space-6"></div>
                                        </div>

                                        <div class="row-fluid">

                                            <div class="col-md-6">
                                                <label for="description" class="col-md-12">Correo Electrónico <span class="required">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">@</span>
                                                    <?php echo $form->emailField($passModel, 'email', array('size' => 60, 'maxlength' => 120, 'style'=>'width: 90%;', 'required'=>'required', "autocomplete"=>"off", 'placeholder'=>'Correo Electrónico', )); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="description" class="col-md-12">Twitter</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa-twitter fa"></i></span>
                                                    <?php echo $form->textField($passModel, 'twitter', array('size' => 60, 'maxlength' => 40, 'style'=>'width: 90%;', 'class'=>'form-control', "autocomplete"=>"off", 'placeholder'=>'Nombre de Usuario en Twitter', )); ?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <div class="space-6"></div>
                                        </div>

                                        <input type="hidden" name="changePasswordToken" value="<?php echo $token; ?>" />

                                        <input type="hidden" id="formID" name="formID" value="user-groups-contact-form">

                                        <hr>

                                        <div class="row">

                                            <div class="col-xs-6">
                                                <a href="/site" class="btn btn-danger">
                                                    <i class="icon-arrow-left"></i>
                                                    Volver
                                                </a>
                                            </div>

                                            <div class="col-xs-6">
                                                <button class="btn btn-primary btn-next pull-right" title="Guardar Datos de Contacto" data-last="Finish" type="submit">
                                                    Guardar Datos
                                                    <i class="icon-save icon-on-right"></i>
                                                </button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/userGroups/usuario/perfil.min.js',CClientScript::POS_END); ?>