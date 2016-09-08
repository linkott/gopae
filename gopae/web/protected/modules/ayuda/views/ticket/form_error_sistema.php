
<div id="Ticket_tipo_ticket_id"> </div>
<input type="hidden" id="tipo-formulario" name="tipo-formulario" value="error_sistema" />

<div class="widget-main form">

    <div class="row">

        <div class="col-md-12">
            <label class="col-md-12" for="observacion_error">Indique cómo se ha producido el error: <span class="required">*</span></label>
            <div class="col-md-12" >
                <input type="text" name="observacion_error" id="observacion_error" maxlength="300" style="width: 94.7%;" />
            </div>
        </div>


        <div class="col-md-12"><div class="space-10"></div></div>
        <div class="col-md-12">
                <?php $this->renderPartial('_archivo', array('model' => $model, 'modelArchivo' => $modelArchivo, 'subtitulo' => "Nuevo ticket")); ?>
        </div>
    </div>

</div>


