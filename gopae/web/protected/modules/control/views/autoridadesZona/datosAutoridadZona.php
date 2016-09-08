<div id="resultado-cambio-correo">
<div class="infoDialogBox">
    <p>
        Si usted lo cree necesario puede editar el correo del Representante de la Zona Educativa.
    </p>
</div>
</div>

<form id="form-autoridad-zona">
    
    <div id="autoridadZonaContacto" class="tab-pane active">

        <div class="widget-box">

            <div class="widget-header" style="border-width: thin">
                <h5>CONTACTO <?php echo $model['zona']; ?></h5>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">

                <div class="widget-body-inner">

                    <div class="widget-main form">

                        <div class="row">

                            <div class="row-fluid">

                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Cédula</label>
                                    <input type="text" style="width: 90%;" readonly="" value="<?php echo $model['cedula']; ?>" />
                                </div>

                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Nombre y Apellido</label>
                                    <input type="text" style="width: 90%;" readonly="" value="<?php echo $model['nombre'] . ' ' . $model['apellido']; ?>" />
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row-fluid">

                                <div class="col-md-6">
                                    <label for="groupname" class="col-md-12">Teléfono Fijo</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-phone"></i></span>
                                        <input type="text" style="width: 90%;" readonly="" value="<?php echo $model['telefono']; ?>" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Teléfono Celular</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa-mobile fa"></i></span>
                                        <input type="text" style="width: 90%;" readonly="" value="<?php echo $model['telefono_celular']; ?>" />
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
                                        <input id="email" name="email" type="email" style="width: 90%;" value="<?php echo $model['email']; ?>" />
                                        <input id="emailBackup" name="emailBackup" type="hidden" style="width: 90%;" value="<?php echo $model['email']; ?>" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Twitter</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa-twitter fa"></i></span>
                                        <input type="text" style="width: 90%;" readonly="" value="<?php echo $model['twitter']; ?>" />
                                    </div>
                                </div>

                            </div>
                            
                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row-fluid">

                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Último Login</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                        <input type="text" style="width: 90%;" readonly="" value="<?php echo $model['last_login']; ?>" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">¿Este usuario ha cambió su Clave?</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-key"></i></span>
                                        <input type="text" style="width: 90%;" readonly="" value="<?php echo ($model['cambio_clave'])?'Si':'No'; ?>" />
                                    </div>
                                </div>

                            </div>
                            
                            <input type="hidden" style="display: none;" id="id" name="id" value="<?php echo base64_encode($model['user_id']); ?>">
                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('#email').unbind('blur');
        $('#email').unbind('keyup');
        $('#email').bind('keyup blur', function () {
            keyEmail(this, false);
        });
        $('#email').bind('blur', function () {
            clearField(this);
        });
        
    });
</script>