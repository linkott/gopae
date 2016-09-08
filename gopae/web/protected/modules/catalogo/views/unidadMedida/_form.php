<?php
/* @var $this UnidadMedidaController */
/* @var $model UnidadMedida */
/* @var $form CActiveForm */


$form = $this->beginWidget('CActiveForm', array(
    'id' => 'unidad-medida-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>

<div class="widget-box">

    <div class="widget-header">
        <h5><?php echo $subtitulo; ?></h5>

        <div class="widget-toolbar">
            <a>
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="form">
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

                    <input type="hidden" id='id' name="id" value="<?php echo base64_encode($model->id); ?>" />

                    <div class="col-md-12">
                        <label class="col-md-12" for="groupname" >Nombre<span class="required">*</span></label>  
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-12">
                            <?php
                            echo
                            $form->textField($model, 'nombre', array('size' => 30, 'maxlength' => 30, 'class' => 'span-12', 'required' => 'required', 'id' => 'nombre'));
                            ?>
                        </div>   
                    </div>
                </div>
                <div class="row"></div>
                <div class="space-6"></div>
                <div class="row">

                    <div class="col-md-12">
                        <label class="col-md-12" for="groupname" >Siglas<span class="required">*</span></label>  
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-12">
                            <?php
                            echo
                            $form->textField($model, 'siglas', array('size' => 5, 'maxlength' => 5, 'class' => 'span-12', 'required' => 'required', 'id' => 'siglas'));
                            ?>
                        </div>   
                    </div>
                </div>
                <div class="row"><div class="space-6"></div></div>
                
                <div class="row">
                
                    <div class="col-md-12">
                        <label class="col-md-12" for="groupname" >Tipo de Unidad de Medida<span class="required">*</span></label>  
                    </div>
                    
                    <div class="col-md-12">
                            <div class="col-md-12">
                                <div id="unidadMedidaPreparacion">
                                    <?php
                                    echo $form->dropDownList(
                                            $model, 'tipo_unidad_medida_id', TipoUnidadMedida::getMostrarTipoUnidadMedida(), array('class' => 'span-5', 'empty' => array ('' =>'-SELECCIONE-'), 'class' => 'span-7', 'required'=>'true')
                                    );
                                    ?>
                                </div>                  
                            </div>            
                    </div>    
                </div>
                <div class="row"><div class="space-6"></div></div>
                <div class="row">

                    <div class="col-md-12">

                        <label class="col-md-12" for="groupname">Observación o Descripción</label>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-12">
                        <?php
                        echo
                        $form->textArea($model, 'observacion', array('class' => 'span-12', 'maxlength' => 255, 'id' => 'observacion'));
                        ?>
                        </div>   
                    </div>
                </div>
                <div class="row"></div>
                <div class="space-6"></div>
            </div>
        </div>
    </div>
</div>
<button class="hidden btn btn-primary" id="btnGuardarUnidadMedida" type="summit">Guardar</button>
<?php $this->endWidget(); ?>
<!-- form -->
<script>
    $(document).ready(function () {
        $("#observacion").on('keyup', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#observacion').on('keyup blur', function () {
            keyText(this, true);
        });
        $('#observacion').on('blur', function () {
            clearField(this);
        });

        $("#nombre").on('keyup', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#nombre').on('keyup blur', function () {
            keyLettersAndSpaces(this, true);
        });
        $('#nombre').on('blur', function () {
            clearField(this);
        });

        $('#siglas').on('keyup blur', function () {
            keyAlpha(this, false);
        });
        $('#siglas').on('blur', function () {
            clearField(this);
        });
    });
</script>

        


        