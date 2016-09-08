<div class="col-sm-10 col-sm-offset-1">
    <div class="login-container">

        <div class="space-6"></div>

        <div class="position-relative">

            <div id="result">
                <?php //var_dump($model->getErrors()); ?>
                <?php if ($model->getErrors()): ?>
                    <?php if ($model->getError('password') != '' || $model->getError('username') != ''): ?>
                        <div class="errorDialogBox">
                            <p>
                                <?php $error= $model->getError('password'); echo $error; ?>
                                <a onclick="show_box('signup-box');
                                            return false;
                                            $('#result').fadeOut();" class="user-signup-link">¿Olvidaste tu Clave?</a>
                            </p>
                        </div>
                    <?php elseif ($model->getError('verifyCode') != ''): ?>
                        <div class="errorDialogBox">
                            <p>
                                El código de seguridad ingresado es incorrecto.
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="errorDialogBox">
                            <p>
                                Puede que su usuario se encuentre Inactivo.
                            </p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <?php if (isset(Yii::app()->request->cookies['success'])): ?>
                <div class="infoDialogBox">
                    <p><?php echo Yii::app()->request->cookies['success']->value; ?></p>
                    <?php unset(Yii::app()->request->cookies['success']); ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="infoDialogBox">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('mail')): ?>
                <div class="infoDialogBox">
                    <p><?php echo Yii::app()->user->getFlash('mail'); ?></p>
                </div>
            <?php endif; ?>

            <div id="login-box" class="login-box visible widget-box no-border">
                <div class="widget-body">
                    <div class="widget-main">
                        <h4 class="header blue lighter bigger">
                            <i class="icon-unlock green"></i>
                            Acceso al Sistema de Gestión Operativa del CNAE
                        </h4>

                        <div class="space-6"></div>

                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'login-form',
                            'enableAjaxValidation' => false,
                            'focus' => array($model, 'username'),
                        ));
                        ?>
                        <fieldset>

                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" value="<?php echo $model->username; ?>" id="UserGroupsUser_username" name="UserGroupsUser[username]" placeholder="Usuario" required="required" class="input form-control" autocomplete="off" />
                                    <i class="icon-user"></i>
                                </span>
                            </label>

                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">
                                    <input type="password" value="<?php echo $model->password; ?>" id="UserGroupsUser_password" name="UserGroupsUser[password]" placeholder="Clave" required="required" class="input form-control" autocomplete="off" />
                                    <i class="icon-lock"></i>
                                </span>
                            </label>

                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right lighter">
                                    <?php echo $form->checkBox($model, 'rememberMe', array('id' => 'rememberMe', 'checked' => 'checked')); ?>
                                    <label for="rememberMe" class="lighter">Recuérdame</label>
                                </span>
                            </label>

                            <div class="block clearfix">
                                <div class="col-xs-4" style="padding-left: 0px;">
                                    <a id="linkRefreshCaptcha" tabindex="-1" style="border-style: none;" title="Haga Click para obtener otra Imágen. El Código no es sensible a mayúsculas y minúsculas.">
                                        <img id="siimage" style="border: 1px solid #DDDDDD; margin-right: 15px" src="/login/captcha/sid/<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left" height="45" />
                                    </a>
                                </div>
                                <div class="col-xs-8" style="text-align: right; padding-right: 0px;">
                                    <span class="block input-icon input-icon-right">
                                        <?php echo $form->textField($model,'verifyCode', array('required'=>'required', 'style'=>'width: 100%;', 'maxlength'=>'10', 'required'=>'required', 'placeholder'=>'Ingrese el Código de la Imagen', 'title'=>'Ingrese el Código de la Imagen. El código no es sensible a mayúsculas y minúsculas.', 'autocomplete'=>'off')); ?>
                                        <i class="icon-qrcode"></i>
                                    </span>
                                </div>
                            </div>
                            <div>
                                <div class="hide">
                                    <div></div>
                                </div>
                                <div class="hide">
                                    <div></div>
                                </div>
                                <div class="hide">
                                    <div><div></div></div>
                                    <div><input type="hidden" name="<?php echo $tokenName; ?>" value="<?php echo $tokenValue; ?>" /></div>
                                    <div><div></div></div>
                                </div>
                                <div class="hide">
                                    <div></div>
                                </div>
                                <div class="hide">
                                    <div></div>
                                </div>
                            </div>

                            <div class="space"></div>

                            <div class="clearfix">
                                <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                    <i class="icon-key"></i>
                                    Ingresar
                                </button>
                            </div>

                            <div class="space-4"></div>
                        </fieldset>
                    <?php $this->endWidget(); ?>

                    </div><!-- /widget-main -->

                    <div class="toolbar clearfix">
                        <div>
                            <a onclick="show_box('faqs-box');
                                    return false;" class="forgot-password-link">
                                <i class="icon-arrow-left"></i>
                                Preguntas Frecuentes
                            </a>
                        </div>

                        <div>
                            <a onclick="show_box('signup-box');
                                    return false;" class="user-signup-link">
                                ¿Olvidaste tu Clave?
                                <i class="icon-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div><!-- /widget-body -->
            </div><!-- /login-box -->

            <div id="faqs-box" class="forgot-box widget-box no-border">
                <div class="widget-body">
                    <div class="widget-main">

                        <h4 class="header red lighter bigger">
                            <i class="icon-key"></i>
                            Preguntas Frecuentes
                        </h4>

                        <div class="space-6"></div>
                        <p class="faqs-q">
                            <b>Estoy presentando un Error 503 en el Navegador</b>
                        </p>
                        <fieldset class="faqs-q">
                            <label class="block clearfix faqs-a">
                                <i>R: Puede que deba Configurar el Proxy en su Navegador para poder acceder a la Red interna del Ministerio del Poder Popular para La Educación.</i>
                            </label>
                        </fieldset>
                        <p class="faqs-q">
                            <b>¿Quién puede ingresar al Sistema?</b>
                        </p>
                        <fieldset>
                            <label class="block clearfix faqs-a">
                                <i>R: Al Sistema puede ingresar todo aquel al que se le haya dado permiso por parte del Ministerio del Poder Popular para la Educación y que efectúe labores en la Gestión Escolar.</i>
                            </label>
                        </fieldset>
                        <p class="faqs-q">
                            <b>¿Cómo Obtengo un Usuario para ingresar al Sistema?</b>
                        </p>
                        <fieldset>
                            <label class="block clearfix faqs-a">
                                <i>R: Si usted efectúa labores en la Gestión Escolar debe solicitarlo a las autoridades del MPPE.</i>
                            </label>
                        </fieldset>
                        <p class="faqs-q">
                            <b>¿Qué navegador debo utilizar para ejecutar la Aplicación?</b>
                        </p>
                        <fieldset>
                            <label class="block clearfix faqs-a">
                                <i>R: Recomendamos el Uso de las últimas versiones de Mozilla Firefox, Chromium, Google Chrome o Cunaguaro en su versión 27 o superior.</i>
                            </label>
                        </fieldset>
                    </div><!-- /widget-main -->

                    <div class="toolbar center">
                        <a href="#" onclick="show_box('login-box');
                                return false;" class="back-to-login-link">
                            Volver al Login
                            <i class="icon-arrow-right"></i>
                        </a>
                    </div>
                </div><!-- /widget-body -->
            </div><!-- /forgot-box -->

            <div id="signup-box" class="signup-box widget-box no-border">
                <div class="widget-body">
                    <div class="widget-main">
                        <h4 class="header green lighter bigger">
                            <i class="icon-group blue"></i>
                            ¿Olvidaste tu Clave?
                        </h4>

                        <div class="space-6"></div>
                        <p> Ingrese los datos necesarios para recuperar su clave: </p>

                        <!-- Formulario de Recupación de Clave -->
                        <?php $this->renderPartial('passRequest', array('model_pr' => $model_pr)); ?>
                    </div>

                    <div class="toolbar center">
                        <a href="#" onclick="show_box('login-box');
                                return false;" class="back-to-login-link">
                            <i class="icon-arrow-left"></i>
                            Volver al Login
                        </a>
                    </div>
                </div><!-- /widget-body -->

            </div><!-- /signup-box -->

        </div><!-- /position-relative -->

    </div>

</div><!-- /.col -->

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/main.min.js',CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/userGroups/usuario/login.min.js',CClientScript::POS_END);
?>