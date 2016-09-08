<?php
/* @var $this SocioController */
/* @var $model Socio */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'socio-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>

    <div class="widget-box">
        <div id="resultadoRegistrar" class="infoDialogBox">
            <p>
                Por Favor Ingrese los datos correspondientes para registrar una sección, Los campos marcados con <span class="required">*</span> son requeridos.
            </p>
        </div>
        <div class="widget-header">
            <h4>Socio</h4>

            <div class="widget-toolbar">
                <a data-action="collapse" href="#">
                    <i class="icon-chevron-up"></i>
                </a>
            </div>

        </div>

        <div class="widget-body">
            <div class="widget-body-inner" style="display: block;">
                <div class="widget-main">

                    <a href="#" class="search-button"></a>
                    <div style="display:block" class="search-form">
                        <div class="widget-main form">
                            <input type="hidden" id='model_id' name="model_id" value="<?php echo $model->id ?>" />

                            <div class="row">
                                <div class="col-md-4">
                                    <?php echo $form->hiddenField($model, 'proveedor_id', array('value' => $_REQUEST['Socio']['proveedor_id'])); ?>
                                    Rif <span class="required">*</span><br>
                                    
                                    


                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" id="botonPersonaRif" class="btn btn-sm  dropdown-toggle"
                                                    data-toggle="dropdown" style="height: 30px;">
                                              PERSONA <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu pull-left" role="menu">
                                                <li><a class="rifAcciones" data-value="NATURAL">NATURAL</a></li>
                                                <li><a class="rifAcciones" data-value="JURIDICA">JURIDICA</a></li>

                                            </ul>
                                        </div>
                                        <?php echo $form->textField($model, 'rif', array('class'=>'form-control span-7','style'=>'height: 30px;','required' => 'required', 'readonly' => 'readonly')); ?>
                                        <?php // echo $form->error($model, 'rif'); ?>
                                        
                                    </div>
                                    <?php // echo $form->textField($model, 'rif', array('size' => 14, 'maxlength' => 14, 'class' => 'col-sm-12', 'required' => 'required')); ?>
                                </div>
                                <div class="col-md-4">
                                    Nombres Del Socio <span class="required">*</span><br>
                                    <?php echo $form->textField($model, 'nombres', array('size' => 50, 'maxlength' => 50, 'class' => 'col-sm-12')); ?>
                                </div>
                                <div class="col-md-4">
                                    Apellidos Del Socio <span class="required">*</span><br>
                                    <?php echo $form->textField($model, 'apellidos', array('size' => 50, 'maxlength' => 50, 'class' => 'col-sm-12')); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    Tel&eacute;fono Celular<br>
                                    <?php echo $form->textField($model, 'telefono_celular', array('size' => 21, 'maxlength' => 21, 'class' => 'col-sm-12')); ?>
                                </div>
                                <div class="col-md-4">
                                    Correo<br>
                                    <?php echo $form->textField($model, 'correo', array('size' => 60, 'maxlength' => 150, 'class' => 'col-sm-12')); ?>
                                </div>
                                <div class="col-md-4">
                                    ¿Posee Certificado De Salud? <span class="required">*</span><br>
                                    <?php echo $form->dropDownList($model,'certificado_salud', array('1' => 'SI', '0' => 'NO'), array('empty' => '-SELECCIONE-', 'class' => 'col-sm-12')); ?>
                                    <?php // echo $form->textField($model, 'certificado_salud', array('class' => 'col-sm-12')); ?>
                                </div>
                            </div>

                            <?php $this->endWidget(); ?>
                        </div>
                    </div><!-- search-form -->
                </div><!-- search-form -->
            </div>
        </div>
    </div>

</div><!-- form -->

<script>
$(document).ready(function() {
    $('.rifAcciones').bind('click', function() {
        if ($(this).attr('data-value') === "NATURAL") {
            $("#Socio_rif").attr('readonly', false);
            $('#Socio_rif').mask('V-999999999');

        } else if ($(this).attr('data-value') === "JURIDICA") {
            $("#Socio_rif").attr('readonly', false);
            $('#Socio_rif').mask('J-999999999');

        } else {
        }
        $("#Socio_rif").focus();
    });
});
$('#Socio_telefono_celular').mask('(0469) 999-9999');

$('#Socio_nombres').bind('keyup blur', function() {
    makeUpper(this);
    keyAlpha(this, true);
});
$('#Socio_apellidos').bind('keyup blur', function() {
    makeUpper(this);
    keyAlpha(this, true);
});
</script>