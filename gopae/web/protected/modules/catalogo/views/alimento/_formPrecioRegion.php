<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'articulo-form',
        'enableAjaxValidation' => false,
        #'id'=>'seccion-form',
        #'enableAjaxValidation' => false,
        #'enableClientValidation' => true,
        'clientOptions' => array(
            //'validateOnSubmit' => true,
            'validateOnType' => true,
            'validateOnChange' => true),
    ));
    ?>
    <div id="resultado"></div>

    <div class="widget-box">
        <div class="widget-header">
            <h4>Precio de "<?php echo $nombreArticulo; ?>"</h4>

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
                            <input type="hidden" id='id' name="id" value="<?php echo $model->id; ?>" />
                            <input type="hidden" id='estado_id' name="estado_id" value="<?php echo $estado_id; ?>" />
                            <input type="hidden" id='articulo_id' name="articulo_id" value="<?php echo $articulo_id; ?>" />
                            <input type="hidden" id='articulo_model_id' name="articulo_model_id" value="<?php echo $articulo_model_id; ?>" />
                            <input type="hidden" id='precio_region_id' name="precio_region_id" value="<?php echo $precio_region_id; ?>" />
                            <input type="hidden" id='id_encode' name="id_encode" value="<?php echo base64_encode($_GET['id']); ?>" />

                            <div class="row">
                                <div class="col-md-6">
                                    Precio del Articulo <span class="required">*</span>
                                    <br>
                                    <?php echo $form->textField($model, 'precio_regulado', array('size' => 70, 'maxlength' => 100, 'class' => 'col-sm-12', 'id' => 'Articulo_precio_regulado_form')); ?>
                                    <?php // echo $model->unidadMonetaria->id; ?>
                                </div>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div><!-- search-form -->
                </div><!-- search-form -->
            </div>
        </div>
    </div>

</div>


<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catalogo/articulo.js', CClientScript::POS_END);
?>

<script>
    $(document).ready(function() {
        $('#articulo-form').on('submit', function(evt) {
            evt.preventDefault();
            procesarCambioMonetario();
        });

    $('#Articulo_nombre_form').bind('keyup blur', function() {
        makeUpper(this);
        keyAlphaNum(this, true, true);
    });

    $('#Articulo_precio_regulado_form').bind('keyup blur', function() {
        keyNum(this, true);
    });

//    $('#Articulo_tipo_articulo_id').bind('change', function() {
//        tipo_alimento = $("#Articulo_tipo_articulo_id").val();
//        if(tipo_alimento == 1) {
//            $("#unidadMedidaAlimento").removeClass('hide');
//            $("#unidadMedidaUtencilio").addClass('hide');
//        }
//        else {
//            $("#unidadMedidaAlimento").addClass('hide');
//            $("#unidadMedidaUtencilio").removeClass('hide');
//        }
//    });
    
    });
</script>