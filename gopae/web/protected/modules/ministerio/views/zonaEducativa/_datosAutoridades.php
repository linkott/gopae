<div id="resultado-cambio-datos">
    <div class="infoDialogBox">
        <p>
            Si usted lo cree necesario puede correo electrónico, teléfono fijo y celular y el cargo de la Autoridad del Plantel.
        </p>
    </div>
</div>

<form id="zonaAutoridadesUsuario-form" name="zonaAutoridadesUsuario-form" method="POST">

    <div id="autoridadPlantelContacto" class="tab-pane active">

        <div class="widget-box">

            <div class="widget-header" style="border-width: thin">
                <h5>CONTACTO <?php echo $modelAutoridad['cargo']; ?></h5>

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
                                    <input type="text" style="width: 90%;" readonly="" value="<?php echo $modelAutoridad['cedula']; ?>" />
                                    <input type="hidden" class="hide" name="cedulaAutoridadZonaHidden" readonly="" value="<?php echo $modelAutoridad['cedula']; ?>" />
                                </div>

                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Usuario</label>
                                    <input type="text" style="width: 90%;" readonly="" value="<?php echo $modelAutoridad['username']; ?>" />
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row-fluid">
                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Nombres y Apellidos</label>
                                    <input type="text" style="width: 90%;" readonly="" value="<?php echo $modelAutoridad['nombre'] . ' ' . $modelAutoridad['apellido']; ?>" />
                                </div>


                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Teléfono Celular</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa-mobile fa"></i></span>
                                        <input type="text" name="telf_cel"  id="telf_cel" style="width: 90%;"  maxlength="11" value="<?php echo $modelAutoridad['telefono_celular']; ?>" />
                                        <input id="telf_celBackup" name="telf_celBackup" type="hidden" style="width: 90%;" value="<?php echo $modelAutoridad['telefono_celular']; ?>" />
                                    </div>
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
                                        <input type="text" name="telf_fijo" id="telf_fijo" style="width: 90%;" maxlength="11" value="<?php echo $modelAutoridad['telefono']; ?>" />
                                        <input id="telf_fijoBackup" name="telf_fijoBackup" type="hidden" style="width: 90%;" value="<?php echo $modelAutoridad['telefono']; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Correo Electrónico <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon">@</span>
                                        <input id="email" name="email" type="email" style="width: 90%;" value="<?php echo $modelAutoridad['email']; ?>" />
                                        <input id="emailBackup" name="emailBackup" type="hidden" style="width: 90%;" value="<?php echo $modelAutoridad['email']; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>

                            <div class="row-fluid">
                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Cargo</label>
                                    <?php
//                                    echo CHtml::dropDownList('cargo', 'id', CHtml::listData
//                                                    (Cargo::model()->getCargoAutoridad(), 'id', 'nombre'), array('empty' => 'Seleccione', 'id' => 'cargo_id_autoridad', 'class' => 'span-7'));
                                    ?>
                                    <input id="cargo_idBackup" name="cargo_idBackup" type="text"  readOnly = "readOnly" style="width: 90%;" title="<?php echo $modelAutoridad['cargo']; ?>" value="<?php echo $modelAutoridad['cargo']; ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label for="description" class="col-md-12">Último Login</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                        <input type="text" style="width: 90%;" readonly="" value="<?php echo $modelAutoridad['last_login']; ?>" />
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" style="display: none;" id="usuario_id" name="usuario_id" value="<?php echo base64_encode($modelAutoridad['usuario_id']); ?>">
                            <input type="hidden" style="display: none;" id="zona_id" name="zona_id" value="<?php echo base64_encode($modelAutoridad['zona_id']); ?>">

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
//        var cargo_id;
//        cargo_id = '<?php $modelAutoridad['cargo_id'] ? print($modelAutoridad['cargo_id']) : print(null) ?>';
//        if (cargo_id !== null) {
//            $('#cargo_id_autoridad').val(cargo_id);
//        }
        $('#email').unbind('blur');
        $('#email').unbind('keyup');

        $('#telf_fijo').unbind('blur');
        $('#telf_fijo').unbind('keyup');

        $('#telf_cel').unbind('blur');
        $('#telf_cel').unbind('keyup');

        $('#email').bind('keyup blur', function() {
            keyEmail(this, false);
            makeUpper(this);
        });
        $('#telf_fijo').bind('keyup blur', function() {
            keyNum(this, false);
            clearField(this);
        });
        $('#telf_cel').bind('keyup blur', function() {
            keyNum(this, false);
            clearField(this);
        });
        $('#email').bind('blur', function() {
            clearField(this);
        });

    });
</script>