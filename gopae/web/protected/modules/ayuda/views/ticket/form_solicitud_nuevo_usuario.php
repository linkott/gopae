<div id="Ticket_tipo_ticket_id"> </div>
<input type="hidden" id="tipo-formulario" name="tipo-formulario" value="solicitud_nuevo_usuario" />

<div class="widget-main form">

    <div class="row">

        <div class="col-md-4">
            <label class="col-md-12" for="cedula">Cédula del Usuario <span class="required">*</span></label>
            <input type="text" name="cedula" size="30" maxlength="10" class="col-xs-10" id="cedula" required="required" placeholder="Cédula de Identidad">
        </div>
        <div>

            <div class="col-md-4">
                <label class="col-md-12" for="nombre">Nombre del Usuario <span class="required">*</span></label>
                <input type="text" name="nombre" placeholder="Nombre" size="30" maxlength="30" class="col-xs-10" required="required" id="nombre">    </div>
            <div>
                <div class="col-md-4">

                    <label class="col-md-12" for="apellido">Apellido del Usuario <span class="required">*</span></label>
                    <input type="text" name="apellido" placeholder="Apellido" size="30" maxlength="30" class="col-xs-10" required="required" id="apellido">
                </div>

            </div>

        </div>
    </div>



    <div class="row">


        <div class="col-md-4">
            <label class="col-md-12" for="celular">Teléfono Celular<span class="required">*</span></label>
            <input type="text" name="celular" placeholder="Teléfono Celular" maxlength="11" class="col-xs-10" required="required" id="celular">
        </div>


        <div class="col-md-4">
            <label class="col-md-12" for="telefono">Teléfono Fijo</label>
            <input type="text" name="fijo" placeholder="Teléfono Fijo" maxlength="11" class="col-xs-10" required="required" id="telefono">
        </div>


        <div class="col-md-4">
            <label class="col-md-12" for="correo"> Correo <span class="required">*</span></label>
            <input type="email" name="correo" placeholder="Correo" maxlength="150" class="col-xs-10" required="required" id="correo">
        </div>
    </div>


    <div class="row">


        <div class="col-md-4">
            <label class="col-md-12" for="estado">Estado <span class="required">*</span></label>

            <input type='text' class="col-xs-10" value='<?php echo Yii::app()->user->estadoName;?>' id='estado' name='estado' readonly="readonly"/>

            <?php //echo CHtml::dropDownList('estado', Yii::app()->user->estadoName, CHtml::listData($estados, 'nombre', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'required'=>'required')); ?>

        </div>


        <div class="col-md-4">
            <label class="col-md-12" for="grupo">Seleccione el Grupo de Usuario <span class="required">*</span></label>
            <?php echo CHtml::dropDownList('grupo', '', CHtml::listData($grupos, 'groupname', 'description'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'title' => 'Seleccione el Grupo de Usuario al que debe pertenecer esta persona.', 'required' => 'required')); ?>

        </div>


        <div class="col-md-4">
            <label class="col-md-12" for="solicitante">Solicitante <span class="required">*</span></label>
            <input type="text" name="solicitante" placeholder="Ingrese el Nombre de la Autoridad Solicitante" size="30" maxlength="30" class="col-xs-10" required="required" id="solicitante">
        </div>



    </div>
    <div class="space-6"></div>
    <div class="row">

        <div class="col-md-12">
            <label class="col-md-12" for="observacion">Indique la necesidad de la solicitud del nuevo usuario <span class="required">*</span></label>
            <input type="text" name="observacion" id="observacion" maxlength="300" placeholder="observación" style="width: 94.7%;" required='required'> 
        </div>

    </div>
</div>

<script>

    $(document).ready(function() {

//funcion que valida que la cedula sea solo numerica 
        $('#cedula').bind('keyup blur', function() {
            keyNum(this, false);
        });
//funcion que impermite espacios en blancos
        $('#cedula').bind('blur', function() {
            clearField(this);
            getDataFromSaime($(this).val());
        });
//funcion que valida que los datos sean solo alfanumericos
        $('#nombre').bind('keyup blur', function() {
            keyAlpha(this, true);
            makeUpper(this);
        });
//funcion que impermite espacios en blancos
        $('#nombre').bind('blur', function() {
            clearField(this);
        });
//funcion que valida que los datos sean solo alfanumericos
        $('#apellido').bind('keyup blur', function() {
            keyAlpha(this, true);
            makeUpper(this);
        });
//funcion que impermite espacios en blancos
        $('#apellido').bind('blur', function() {
            clearField(this);
        });
//funcion que valida que la cedula sea solo numerica
        $('#celular').bind('keyup blur', function() {
            keyNum(this, false);
        });
//funcion que impermite espacios en blancos
        $('#celular').bind('blur', function() {
            clearField(this);
        });
//funcion que valida que el telefono sea solo numerico
        $('#telefono').bind('keyup blur', function() {
            keyNum(this, false);
        });
//funcion que impermite espacios en blancos
        $('#telefono').bind('blur', function() {
            clearField(this);
        });

//funcion que valida que los datos sean solo alfanumericos
        $('#solicitante').bind('keyup blur', function() {
            keyAlpha(this, true);
            makeUpper(this);
        });
        $('#observacion').bind('keyup blur', function() {
            keyText(this, true);
            makeUpper(this);
        });
//funcion que impide espacios en blancos
        $('#observacion').bind('blur', function() {
            clearField(this);
        });


    });

</script>


