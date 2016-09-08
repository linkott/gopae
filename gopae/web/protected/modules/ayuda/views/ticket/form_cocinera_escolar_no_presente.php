    <div id="Ticket_tipo_ticket_id"></div>
    <input type="hidden" id="tipo-formulario" name="Cocinera[tipo-formulario]" value="cocinera_escolar_no_presente" />
    <input type="hidden" id="accion" name="accion" value="<?php echo $accion; ?>" />
    <input type="hidden" name="Ticket[tipo_ticket_id]" value="<?php echo $tipoTicketId; ?>" />
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">
                <label for="origen">Origen <span class="required">*</span></label>
                <select id="origen" name="Cocinera[origen]" class="span-12" required="required">
                    <option value="V">Venezolano</option>
                    <option value="E">Extranjero</option>
                    <option value="P">Pasaporte</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="cedula">Documento de Identidad <span class="required">*</span></label>
                <input type="text" id="cedula" name="Cocinera[cedula]" class="span-12" required="required" />
            </div>
            <div class="col-md-3">
                <label for="nombres">Nombres<span class="required">*</span></label>
                <input type="text" id="nombres" name="Cocinera[nombres]" class="span-12" required="required" />
            </div>
            <div class="col-md-3">
                <label for="apellidos">Apellidos <span class="required">*</span></label>
                <input type="text" id="apellidos" name="Cocinera[apellidos]" class="span-12" required="required" />
            </div>
        </div>
        <div class="col-xs-12">
            <div class="space-6"></div>
        </div>
        <div class="col-md-12">
            <div class="col-md-3">
                <label for="email">Correo Personal <span class="required">*</span></label>
                <input type="email" id="email" name="Cocinera[email]" class="span-12" value="@" required="required" />
            </div>
            <div class="col-md-3">
                <label for="telefono_fijo">Tel&eacute;fono Fijo <span class="required">*</span></label>
                <input type="text" id="telefono_fijo" class="span-12" name="Cocinera[telefono_fijo]" />
            </div>
            <div class="col-md-3">
                <label for="telefono_celular">Tel&eacute;fono Celular <span class="required">*</span></label>
                <input type="text" id="telefono_celular" class="span-12" name="Cocinera[telefono_celular]" />
            </div>
            <div class="col-md-3">
                <label for="codigo_plantel">C&oacute;digo del Plantel <span class="required">*</span></label>
                <input type="text" id="codigo_plantel" name="Cocinera[codigo_plantel]" class="span-12" required="required" />
            </div>
        </div>
        
        <div class="col-md-12">
            <label for="codigo_plantel">Observación</label>
                <textarea id="observacion" name="Cocinera[observacion]" class="span-12" />
        </div>
        
        <div class="col-md-12">
            <button id="btn-submit-register" class="btn btn-primary btn-next hide" data-last="Finish" type="submit">
                Guardar
                <i class="icon-save icon-on-right"></i>
            </button>
        </div>
            
    </div>

<script type="text/javascript">

    $(document).ready(function() {
        
        var accion = $("#accion").val();
        
        $("#ticket-form").unbind('submit');
        $("#ticket-form").on('submit', function(evt){
            evt.preventDefault();
            var id = $("#Ticket_tipo_ticket_id").val();
            var divResult = "resultadoOperacion";
            var urlDir = "/ayuda/ticket/" + accion + "/id/" + id;
            var datos = $("#ticket-form").serialize();
            var loadingEfect = true;
            var showResponse = true;
            var method = "POST";
            var responseFormat = "html";
            var callback = function(){
                $('#clase-plantel-grid').yiiGridView('update', {
                    data: $(this).serialize()
                });
                $("#btn-volver-apertura-ticket").click();
            };
            executeAjax(divResult, urlDir, datos, loadingEfect, showResponse, method, responseFormat, callback);
        });
        
        $('#codigo_plantel').unbind('keyup blur');
        //funcion que valida que solo permite letras
        $('#codigo_plantel').bind('keyup blur', function() {
            keyAlphaNum(this, true, true);
            makeUpper(this);
        });
        //funcion que limpia espacios en blancos
        $('#codigo_plantel').bind('blur', function() {
            clearField(this);
        });

        $("#cedula").unbind('keyup blur');
        //funcion que valida que solo permite letras
        $("#cedula").keyup(function() {
            keyNum(this, false);
        });
        //funcion que limpia espacios en blancos
        $('#cedula').bind('blur', function() {
            clearField(this);
        });

        $("#email").unbind('keyup blur');
        $("#email").keyup(function() {
            keyEmail(this, true);
            makeLower(this);
        });
        $('#email').bind('blur', function() {
            clearField(this);
        });

        $("#apellidos").unbind('keyup blur');
        //funcion que limpia espacios en blanco
        $("#apellidos").keyup(function() {
            makeUpper(this);
            keyAlphaNum(this, true, true);
        });
        $('#apellidos').bind('blur', function() {
            clearField(this);
        });

        $("#nombres").unbind('keyup blur');
        $("#nombres").keyup(function() {
            makeUpper(this);
            keyAlphaNum(this, true, true);
        });
        $('#nombres').bind('blur', function() {
            clearField(this);
        });
        
        $("#observacion").unbind('keyup blur');
        $("#observacion").keyup(function() {
            makeUpper(this);
            keyAlphaNum(this, true, true);
        });
        $('#observacion').bind('blur', function() {
            clearField(this);
        });
        
        $.mask.definitions['L'] = '[1-2]';
        $.mask.definitions['X'] = '[2|4|6]';

        $('#telefono_fijo').mask('(0299)999-9999');
        $('#telefono_celular').mask('(04LX)999-9999');

    });
</script>
