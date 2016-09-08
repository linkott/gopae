<?php
/* @var $this ClasePlantelController */
/* @var $model ClasePlantel */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'ticket-form',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>
<div id="validaciones">
    <div class="infoDialogBox">
        <p>
            Todos los campos marcados con el símbolo <span class="required">*</span> son campos requeridos para efectuar esta acción.
        </p>
    </div>
</div>
<div class="widget-box" id="mensaje">

    <div class="widget-header" style="border-width: thin;">
        <h5>Nueva Solicitud</h5>

        <div class="widget-toolbar">
            <a>
                <a data-action="collapse" href="#">
                    <i class="icon-chevron-up"></i>
                </a>
            </a>
        </div>
    </div>

    <div class="widget-body">

        <div class="widget-main form">

            <?php
            if ($form->errorSummary($model)):
                ?>
                <div id ="div-result-message" class="errorDialogBox" >

                    <?php echo $form->errorSummary($model); ?>
                </div>
                <?php
            endif;
            ?>

            <div class="row">

                <input type="hidden" id='id'  name="id" value="<?php echo base64_encode($model->id); ?>" />

                <div class="col-md-6">
                    <label class="col-md-12" for="groupname" title="Indique el tipo de Solicitud que desea aperturar">Tipo de Solicitud</label>
                    <?php echo $form->dropDownList($model, 'tipo_ticket_id', CHtml::listData(TipoTicket::model()->findAll(array('condition' => "estatus = 'A'", 'order' => 't.nombre' )), 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
                </div>

            </div>

            <div class="row">
                <div id="formularios">

                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function() {

            $("#ticket-form").on('submit', function(evt){
                evt.preventDefault();
            });

            if ($("#Ticket_tipo_ticket_id").val() != "") {

                var data = {id: $("#Ticket_tipo_ticket_id").val()};
                var divResult = "formularios";
                var urlDir = "/ayuda/ticket/formularios";
                var datos = data;
                var conEfecto = true;
                var showHTML = true;
                var method = "POST";

                executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method);

            }

            $("#Ticket_tipo_ticket_id").bind('change', function() {

                var data = {id: $("#Ticket_tipo_ticket_id").val()};
                var divResult = "formularios";
                var urlDir = "/ayuda/ticket/formularios";
                var datos = data;
                var conEfecto = true;
                var showHTML = true;
                var method = "POST";
                executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method);

            });

        });

    </script>

</div>
<?php $this->endWidget(); ?>
<!-- form -->
