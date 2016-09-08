
<table>
<div id="Ticket_tipo_ticket_id"> </div>
<input type="hidden" id="tipo-formulario" name="tipo-formulario" value="solicitud_actualizacion_datos_plantel" />

<tr>
    <td>
        <div class="col-md-12">
            <label class="col-md-12" for="codigo_plantel">Código DEA del Plantel: <span class="required">*</span></label>
            <input type="text" name="codigo_plantel" maxlength="15" style="width: 90%" id="codigo_plantel" required="required" placeholder="Ingrese el código del Plantel. Ej.: OD051946146">
        </div>
    </td>
    <td>
         <div class="col-md-12">
            <label class="col-md-12" for="nombre_plantel">Cedula del Estudiante: <span class="required">*</span></label>
            <input type="text" name="cedula_estudiante" style="width: 90%" maxlength="150" class="col-xs-10" required="required" id="cedula_estudiante" placeholder="Ingrese la Cedula del Estudiante"/>
        </div>
    </td>
</tr>

   <tr>
    <td>

        <div class="col-md-12">
            <label class="col-md-12" for="nombre_estudiante">Nombre del Estudiante <span class="required">*</span></label>
            <input type="text" name="nombre_estudiante" id="nombre_estudiante" style="width: 90%;" size="30" maxlength="30" class="col-xs-10" required="required" placeholder="Ingrese el Nombre del Estudiante" >
        </div>
    </td>

    <td>
        <div class="col-md-12">
            <label class="col-md-12" for="apellido">Apellido del Estudiante</label>
            <input type="text" name="apellido_estudiante" style="width: 90%;" maxlength="150" class="col-xs-10" required="required" id="apellido_estudiante" placeholder="Apellido del Estudiante">
        </div>

    <div class="space-6"></div>
    </td>
   </tr>
   <tr>
       <td>
     <div class="col-md-12">
            <label class="col-md-12" for="observacion_plantel">Información Adicional</label>
            <input type="text" name="observacion_estudiante" style="width: 181%;" maxlength="150" class="col-xs-10" required="required" id="" placeholder="Ingrese la información que crea oportuna">
     </div>
       </td>
   </tr>

<script type="text/javascript">

    $(document).ready(function() {
//funcion que valida que solo permite letras
        $('#codigo_plantel').bind('keyup blur', function() {
            keyAlphaNum(this, true, true);
            makeUpper(this);
        });
//funcion que limpia espacios en blancos
        $('#codigo_plantel').bind('blur', function() {
            clearField(this);
        });
//funcion que valida que solo permite letras
        $("#cedula_estudiante").keyup(function() {
            keyNum(this, false);
        });
//funcion que limpia espacios en blancos
        $('#cedula_estudiante').bind('blur', function() {
            clearField(this);
        });
     
 //funcion que limpia espacios en blanco
       $("#apellido_estudiante").keyup(function() {
            makeUpper(this);
            keyAlphaNum(this, true, true);
        });
        $('#apellido_estudiante').bind('blur', function() {
            clearField(this);
        });

        $("#nombre_estudiante").keyup(function() {
            makeUpper(this);
            keyAlphaNum(this, true, true);
        });
        $('#nombre_estudiante').bind('blur', function() {
            clearField(this);
        });

    });
</script>