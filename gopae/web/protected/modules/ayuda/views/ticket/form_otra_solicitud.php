
<div id="Ticket_tipo_ticket_id"> </div>


<input type="hidden" id="tipo-formulario" name="tipo-formulario" value="otra_solicitud" />

<div class="widget-main form">

    <div class="row">


        <div class="col-md-12">
            <label class="col-md-12" for="Observación_otra">Indique el motivo de su Notificación:</label>
            <div class="col-md-12" >
                <input type="text" name="observacion_otra" id="observacion_otra" maxlength="300" style="width: 94.7%;" required="required" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="space-6"></div>
        </div>

        <div class="col-md-12">
            <label class="col-md-12" for="Solicitante_otra">Solicitante: <span class="required">*</span></label>
            <div class="col-md-12" >
                <input type="text" name="solicitante_otra" id="solicitante_otra" maxlength="300" style="width: 94.7%;" required="required" />
            </div>
        </div>

        


        <div class="col-md-12"><div class="space-10"></div></div>
        <div class="col-md-12">
                <?php $this->renderPartial('_archivo', array('model' => $model, 'modelArchivo' => $modelArchivo, 'subtitulo' => "Nuevo ticket")); ?>
        </div>
    </div>

</div>

<script type="text/javascript">

    $(document).ready(function() {
       $('#silicitante_otra').bind('keyup blur', function() {
            keyAlpha(this, true);
            makeUpper(this);
        });

    });

</script>

