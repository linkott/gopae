<?php
/* @var $this DistribucionTicketController */
/* @var $model DistribucionTicket */
/* @var $form CActiveForm */
?>



<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'clase-plantel-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>
<div id="validaciones">

</div>


    <div class="widget-box" id="mensaje">

        <div class="widget-header" style="border-width: thin;">
            <h5>Distribución de Solicitud</h5>

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
                <table>
                    <?php if (!isset($actualizar)):?>
      
                        <tr>
                            <td>

                                <input type="hidden" id='id'  name="id" value="<?php echo base64_encode($model->id); ?>" />
                                <div class="col-md-12">
                                    <label class="col-md-12" for="Estado">Estado <span class="required"> * </span></label>
                                    <?php echo CHtml::dropDownList('estado', '', CHtml::listData($estados, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>

                                </div>
                            </td>

                            <td>
                                <div class="col-md-12">
                                    <label class="col-md-12" for="tipo_ticket">Tipo de Ticket <span class="required"> * </span></label>
                                    <?php echo CHtml::dropDownList('tipo', '', CHtml::listData($tipoTicket, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7')); ?>
                                </div>
                            </td>

                           
                        </tr>

                        <tr>
                            <td>

                                <div class="col-md-12">
                                    <label class="col-md-12" for="correo_electronico">Correo Electronico<span class="required"> * </span></label>
                                    <?php echo $form->textField($model, 'correo_electronico', array('size' => 50, 'maxlength' => 180, 'class
' => 'col-xs-30 col-sm-30', 'required' => 'required')); ?>
                                </div>
                            </td>

                            <td>
                                <div class="col-md-12">
                                    <label class="col-md-12" for="telefono">Telefono<span class="required"> * </span></label>
                                    <?php echo $form->textField($model, 'telefono', array('size' => 50, 'maxlength' => 11, 'class
' => 'col-xs-30 col-sm-30', 'required' => 'required')); ?>
                                </div>
                            </td>


                        </tr>

                        <tr>
                             <td>
                                <div class="col-md-12">
                                    <label class="col-md-12" for="Unidad Responsable">Unidad Responsable<span class="required"> * </span></label>
                                    <input type="text" name="unidad_responsable" value="<?php echo Yii::app()->getSession()->get('unidad');?>" readonly="readonly" style="width: 193%;">
                                </div>

                            </td>
                        </tr>
                            
                        <?php
                    endif;
                    if (isset($actualizar)):
                        $estado = is_object($model->estado) ? $model->estado->id : '';
                        ?>
                        <?php $tipo = is_object($model->tipoTicket) ? $model->tipoTicket->id : ''; ?>
                        <?php $unidad = is_object($model->unidadRespTicket) ? $model->unidadRespTicket->id : ''; ?>



                        <tr>
                              <td>
                                <div class="col-md-12">
                                    <label class="col-md-12" for="Unidad Responsable">Unidad Responsable</label>
                                    <input type="text" value="<?php echo Yii::app()->getSession()->get('unidad') ?> "readonly="readonly" style="width:185%">

                                </div>
                            </td>
                        </tr>

              
                        <tr>
                            <td>
                                <input type="hidden" id='id'  name="id" value="<?php echo base64_encode($model->id); ?>" />
                                <div class="col-md-12">
                                    <label class="col-md-12" for="Estado">Estado <span class="required"> * </span></label>
                                    <?php echo CHtml::dropDownList('estado', $estado, CHtml::listData($estados, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'style' => 'width:77%;', 'required' => 'required')); ?>
                                </div>
                            </td>

                            <td>
                                <div class="col-md-12">
                                    <label class="col-md-12" for="tipo_ticket">Tipo de Ticket <span class="required"> * </span></label>
                                    <?php echo CHtml::dropDownList('tipo', $tipo, CHtml::listData($tipoTicket, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'style' => 'width:77%;', 'required' => 'required')); ?>
                                </div>
                            </td>
                        </tr>

                      
                        <tr>
                            <td>

                                <div class="col-md-12">
                                    <label class="col-md-12" for="correo_electronico">Correo Electronico<span class="required"> * </span></label>
                                    <?php echo $form->textField($model, 'correo_electronico', array('size' => 40, 'maxlength' => 30, 'class
' => 'col-xs-30 col-sm-30', 'required' => 'required', 'required' => 'required')); ?>
                                </div>
                            </td>

                            <td>
                                <div class="col-md-12">
                                    <label class="col-md-12" for="telefono">Telefono<span class="required"> * </span></label>
                                    <?php echo $form->textField($model, 'telefono', array('size' => 40, 'maxlength' => 30, 'class
' => 'col-xs-30 col-sm-30', 'required' => 'required', 'required' => 'required')); ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>

                </table>
            </div>
            <?php $this->endWidget(); ?>

        </div><!-- form -->
    <script>
                 <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
?>
    
        </script>
        <script>
      $(document).ready(function() {
     $.mask.definitions['~'] = '[+-]';
     $('#DistribucionTicket_telefono').mask('(0999) 999-9999');
    });
            </script>

