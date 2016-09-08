<div class="widget-box collapsed">

    <div class="widget-header">
        <h5>Información de la Solicitud</h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-down"></i>
            </a>
        </div>
    </div>
    <div class="widget-body">

        <div class="widget-main form">

            <?php
            if ($model->tipo_ticket_id == 1) {
                $this->renderPartial('view_solicitud_nuevo_usuario', array('model' => $model,));
            } else if ($model->tipo_ticket_id == 2) {
                $this->renderPartial('view_error_sistema', array('model' => $model,));
            } else if ($model->tipo_ticket_id == 3) {
                $this->renderPartial('view_solicitud_reseteo_clave', array('model' => $model,));
            } else if ($model->tipo_ticket_id == 4) {
                $this->renderPartial('view_atender_nuevo_plantel', array('model' => $model,));
            } else if ($model->tipo_ticket_id == 5) {
                $this->renderPartial('view_nuevo_plantel', array('model' => $model,));
            } else if ($model->tipo_ticket_id == 8) {
                $this->renderPartial('view_cocinera_escolar_no_presente', array('model' => $model,));
            } else {
                $this->renderPartial('view_otra_solicitud', array('model' => $model,));
            }
            ?>
        </div>
    </div>
</div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'ticket-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
            ));
            ?>

<input type="hidden" id="tipo-formulario" name="tipo-formulario" value="atencion-ticket" />

<div class="widget-box">

    <div class="widget-header">
        <h5>Atención de Solicitud</h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">

        <div class="widget-main form">

            <div class="row">
                <div id="validaciones">
<?php if (strlen($error) > 0): ?>
                        <div id ="div-result-message" class="errorDialogBox" >
                            <p><?php echo $error; ?></p>
                        </div>
                    <?php else: ?>
                        <div class="infoDialogBox">
                            <p>
                                Todos los campos marcados con el símbolo <span class="required">*</span> son campos requeridos para efectuar esta acción.
                            </p>
                        </div>
<?php endif; ?>
                </div>
                <table>
                    <tr>
                        <td width="33%">
                            <input type="hidden" id='id'  name="id" value="<?php echo base64_encode($model->id); ?>" />
                            <div class="col-md-12">
                                <label class="col-md-12" for="estatus_ticket">Cambiar Estatus a <span class="required">*</span></label>
                                <?php echo CHtml::dropDownList('estatus_ticket', '', CHtml::listData($estatusTicket, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
                            </div>

                        </td>
                        <td width="33%">
                            <div class="col-md-12">
                                <label class="col-md-12" for="att_unidad_responsable">Unidad Responsable <span id="unidad_responsable_req" class="hide"><span class="required">*</span></span></label>
                                <?php echo CHtml::dropDownList('att_unidad_responsable','', CHtml::listData($unidad_responsables, 'id', 'nombre'), array('empty' => '- - -', 'class' => 'span-8', 'disabled' => 'disabled')); ?>
                            </div>
                        </td>
                        <td width="33%">
                            <div class="col-md-12">
                                <label class="col-md-12" for="att_responsable_asignado"> Asignar a <span id="responsable_asignado_req" class="hide"><span class="required">*</span></span></label>
                                <?php echo CHtml::dropDownList('att_responsable_asignado','', CHtml::listData($model->getPosiblesResponsablesAsignados(), 'id', 'usuario'), array('empty' => '- - -', 'class' => 'span-8', 'disabled' => 'disabled')); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="space-6"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="col-md-12">
                                <label class="col-md-12">Respuesta de Atención: <span class="required">*</span></label>
                                <input type="text" name="atencion" style="width: 100%;" maxlength="300" class="col-xs-10" required="required" id="atencion" placeholder="Ingrese las observaciones de acuerdo al proceso de atención del ticket.">
                            </div>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div id="formularios">

    </div>
</div>



<script type="text/javascript">
    $('#atencion').bind('blur', function() {
        clearField(this);
    });

    $("#ticket-form").on('submit', function(evt) {
        evt.preventDefault();
    });

    $(document).ready(function() {
        if ($("#estatus_ticket").val() != "") {
            return false;
            var data = {id: $("#estatus_ticket").val()};
        }


        $("#estatus_ticket").on('change', function(){

            var estatus = $(this).val();

            $("#att_unidad_responsable").val("");
            $("#att_responsable_asignado").val("");

            if(estatus=='4'){ // Redireccionado
                $("#att_unidad_responsable").removeAttr("disabled");
                $("#att_responsable_asignado").attr("disabled","disabled");
                $("#unidad_responsable_req").attr("class","");
                $("#responsable_asignado_req").attr("class","hide");
            }else if(estatus == '5'){ // Asignado
                $("#att_responsable_asignado").removeAttr("disabled");
                $("#att_unidad_responsable").attr("disabled","disabled");
                $("#unidad_responsable_req").attr("class","hide");
                $("#responsable_asignado_req").attr("class","");
            }else{
                $("#att_responsable_asignado").attr("disabled","disabled");
                $("#att_unidad_responsable").attr("disabled","disabled");
                $("#unidad_responsable_req").attr("class","hide");
                $("#responsable_asignado_req").attr("class","hide");
            }

        });
    });

</script>
<?php $this->endWidget(); ?>
