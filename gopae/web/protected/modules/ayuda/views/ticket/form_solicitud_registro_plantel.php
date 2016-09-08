
<div id="Ticket_tipo_ticket_id"> </div>
<input type="hidden" id="tipo-formulario" name="tipo-formulario" value="solicitud_nuevo_plantel" />

<div class="widget-main form">

    <div class="row">

        <div class="col-md-4">

            <label class="col-md-12" for="zona_educativa">Zona Educativa <span class="required">*</span></label>
            <input class="col-xs-12" type='text' value='ZONA EDUCATIVA DE <?php echo Yii::app()->user->estadoName;?>' id='zona_educativa' name='zona_educativa' readonly="readonly"/>
            <?php // echo CHtml::dropDownList('zona_educativa', '', CHtml::listData($zonas_educativas, 'nombre', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'required'=>'required', )); ?>

        </div>


        <div class="col-md-4">
            <label class="col-md-12" for="dependencia">Dependencia <span class="required">*</span></label>
            <?php echo CHtml::dropDownList('dependencia', '', CHtml::listData($dependencias, 'nombre', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'required'=>'required', )); ?>

        </div>

        <div class="col-md-4">
            <label class="col-md-12" for="codigo_plantel">Código DEA del Plantel: <span class="required">*</span></label>
            <input type="text" name="codigo_plantel" maxlength="15" class="col-xs-10" id="codigo_plantel" required="required" placeholder="Ingrese el código del Plantel. Ej.: OD051946146">
        </div>

        <div class="space-6"></div>

        <div class="col-md-12">
            <label class="col-md-12" for="nombre_plantel">Nombre del Plantel: <span class="required">*</span></label>
            <input type="text" name="nombre_plantel" style="width: 94.7%" maxlength="150" class="col-xs-10" required="required" id="nombre_plantel" placeholder="Ingrese el Nombre del Plantel"/>
        </div>
    </div>

    <div class="space-6"></div>

    <div class="row">


        <div class="col-md-12">
            <label class="col-md-12" for="solicitante_plantel">Solicitante <span class="required">*</span></label>
            <input type="text" name="solicitante_plantel" id="solicitante_plantel" style="width: 94.7%;" size="30" maxlength="30" class="col-xs-10" required="required" placeholder="Ingrese el Nombre de la Autoridad Solicitante" >
        </div>
    </div>

    <div class="space-6"></div>

    <div class="row">

        <div class="col-md-12">
            <label class="col-md-12" for="observacion_plantel">Información Adicional</label>
            <input type="text" name="observacion_plantel" style="width: 94.7%;" maxlength="150" class="col-xs-10" required="required" id="" placeholder="Ingrese la información que crea oportuna">
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
//funcion que valida que solo permite letras
        $('#nombre_plantel').bind('keyup blur', function() {
            keyAlphaNum(this, true, true);
            makeUpper(this);
        });
//funcion que limpia espacios en blancos
        $('#nombre_plantel').bind('blur', function() {
            clearField(this);
        });
//funcion que valida que solo permite letras
        $("#solicitante_plantel").keyup(function() {
            keyAlphaNum(this, true, true);
            makeUpper(this);
        });
//funcion que limpia espacios en blancos
        $('#solicitante_plantel').bind('blur', function() {
            clearField(this);
        });
        $("#codigo_plantel").keyup(function() {
            makeUpper(this);
            keyAlphaNum(this, false, false);
        });
 //funcion que limpia espacios en blanco
        $('#codigo_plantel').bind('blur', function() {
            clearField(this);
        });


        $("#solicitante_plantel").keyup(function() {
            makeUpper(this);
            keyAlphaNum(this, true, true);
        });
        $('#solicitante_plantel').bind('blur', function() {
            clearField(this);
        });

        $("#observacion_plantel").keyup(function() {
            keyText(this, true);
        });
//funcion que limpia espacios en blanco
        $('#observacion_plantel').bind('blur', function() {
            clearField(this);
        });

    });

</script>