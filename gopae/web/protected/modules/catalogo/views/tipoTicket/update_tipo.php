<?php
/* @var $this ClasePlantelController */
/* @var $model ClasePlantel */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'clase-plantel-form',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>
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

        <div class="row row-fluid">

            <input type="hidden" id='id'  name="id" value="<?php echo base64_encode($model->id); ?>" />

            <div class="col-lg-6">

                <label class="col-md-12" for="Nombre">Nombre</label>

                <?php echo $form->textField($model, 'nombre', array('size' => 40, 'class ' => 'col-xs-30 col-sm-30', 'rows' => 20, 'cols' => 20, 'required' => 'required')); ?>

            </div>
<?php  $unidad = is_object($model->unidadResponsable) ? $model->unidadResponsable->id : ''; ?>
            <div class="col-lg-6">
                <label class="col-md-12" for="Unidad Responsable">Unidad Responsable <span class="required">*</span></label>
                <?php echo CHtml::dropDownList('unidad', $unidad, CHtml::listData($unidades, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'required' => 'required')); ?>
            </div>

        </div>

        <script>
            $(document).ready(function() {
                $("#TipoTicket_nombre").keyup(function() {

                });
                $('#TipoTicket_nombre').bind('keyup blur', function() {
                    keyAlpha(this, true);

                });
            });
        </script>

        <?php $this->endWidget(); ?>
        <!-- form -->
