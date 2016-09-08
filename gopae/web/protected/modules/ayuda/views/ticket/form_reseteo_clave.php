<div id="Ticket_tipo_ticket_id"> </div>
<input type="hidden" id="tipo-formulario" name="tipo-formulario" value="reseteo_clave" />


    <div class="widget-main form">

        <div class="row">

            <div class="col-md-4">
                <label class="col-md-12" for="Cedula">Cédula <span class="required">*</span></label>
                <input type="text" name="cedula_res" size="30" maxlength="10" class="col-xs-10" required="required" id="cedula_res" placeholder="Cedula de Identidad">
            </div>

                <div class="col-md-4">
                    <label class="col-md-12" for="solicitante">Solicitante: <span class="required">*</span></label>
                    <input type="text" name="solicitante_res" size="30" maxlength="30" class="col-xs-10" required="required" id="solicitante_res" placeholder="Nombre del Solicitante">    </div>

            <div class="col-md-4">
                <label class="col-md-12" for="correo">Correo: <span class="required">*</span></label>
                <input type="text" name="correo_res" size="30"  class="col-xs-10" required="required" id="correo_res" placeholder="Correo. ejemplo:richardgutierrez_25@hotmail.com">
            </div>


        
        <div class="col-md-12">
            <label class="col-md-12" for="observacion">Observación <span class="required">*</span></label>
            <input type="text" name="observacion_res" id="observacion_res" maxlength="300" placeholder="observación" style="width: 94.7%;" required='required'>
        </div>

    </div>
            </div>
</div>





   <script>

    $(document).ready(function() {
//funcion que valida que sea solo numerico
         $('#cedula_res').bind('keyup blur', function() {
            keyNum(this, false);
        });
 //funcion que evita espacios en blancos
        $('#cedula_res').bind('blur', function() {
            clearField(this);
            getDataFromSaime($(this).val());
        });
//funcion que permite solo letras
        $('#solicitante_res').bind('keyup blur', function() {
            keyAlpha(this, true);
            makeUpper(this);
        });
        $('#observacion_res').bind('keyup blur', function() {
            keyText(this, true);
            makeUpper(this);
        });
//funcion que limpia espacios en blancos

    });

    </script>