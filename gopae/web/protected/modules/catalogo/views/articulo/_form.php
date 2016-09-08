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

    <div class="widget-box">
        <div id="resultadoRegistrar" class="infoDialogBox">
            <p>
                Por Favor Ingrese los datos correspondientes para registrar una sección, Los campos marcados con <span class="required">*</span> son requeridos.
            </p>
        </div>
        <div class="widget-header">
            <h4>Articulo</h4>

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
                            <input type="hidden" id='id' name="id" value="<?php echo $model->id ?>" />

                            <div class="row">
                                <div class="col-md-4">
                                    Tipo de Articulo <span class="required">*</span>
                                    <br>
                                    <?php
                                    echo $form->dropDownList(
                                            $model, 'tipo_articulo_id', CHtml::listData($tipoArticulo, 'id', 'nombre'), array('class' => 'span-5', 'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-7')
                                    );
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    Nombre del Articulo <span class="required">*</span>
                                    <br>
                                    <?php echo $form->textField($model, 'nombre', array('size' => 70, 'maxlength' => 100, 'class' => 'col-sm-12', 'id' => 'Articulo_nombre_form')); ?>
                                </div>
                                <div class="col-md-4">
                                    Unidad de Medida <span class="required">*</span>
                                    <br>
                                    <div id="unidadMedidaAlimento">
                                    <?php
                                    echo $form->dropDownList(
                                            $model, 'unidad_medida_id', CHtml::listData($unidadMedida, 'id', 'nombre'), array('class' => 'span-5', 'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-7')
                                    );
                                    ?>
                                    </div>
                                    <div id="unidadMedidaUtencilio" class="hide">
                                    <?php
                                    echo $form->dropDownList(
                                            $model, 'unidad_medida_id', CHtml::listData($unidadMedidaUtencilio, 'id', 'nombre'), array('class' => 'span-5', 'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-7')
                                    );
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Precio Nacional <span class="required">*</span>
                                    <br>
                                    <?php echo $form->textField($model, 'precio_regulado', array('size' => 15, 'maxlength' => 15, 'class' => 'col-sm-12', 'id' => 'Articulo_precio_regulado_form')); ?>
                                </div>
                                <div class="col-md-4">
                                    Precio Baremo <span class="required">*</span>
                                    <br>
                                    <?php echo $form->textField($model, 'precio_baremo', array('size' => 15, 'maxlength' => 15, 'class' => 'col-sm-12', 'id' => 'Articulo_precio_baremo_form')); ?>
                                </div>
                                <div class="col-md-4">
                                    Unidad Monetaria
                                    <br>
                                    <b>
                                        <?php echo $unidadMonetaria[0]['nombre'] . ' (' . $unidadMonetaria[0]['abreviatura'] . ')'; ?>
                                    </b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 hidden" id="franja">
                                    Franja <span class="required">*</span>
                                    <br>
                                    <div id="cantidadFrajas"><?php // echo Fraja::model()->cantFranja(); ?></div>
                                    <?php
                                    echo $form->dropDownList(
                                            $model, 'franja_id', CHtml::listData(Franja::model()->findAll(), 'id', 'descripcion', 'nombre'  ), array('class' => 'span-5', 'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-7')
                                    );
                                    ?>
                                </div>
                                <!--
                                <div class="col-md-8">
                                    Descipci&oacute;n
                                    <br>
                                    <div id="descripcionFranja">SELECCIONA UNA FRANJA</div>
                                    <?php
                                    $franja = Franja::model()->findAll();
                                    foreach ($franja AS $f) {
                                        echo '<div id="descripcionFranja' . $f['id'] . '">' . $f['descripcion'] . '</div>';
                                    }
                                    ?>
                                </div>
                                -->
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
        $('#nivel-form').on('submit', function(evt) {
            evt.preventDefault();
            registrarArticulo();
        });

    $('#Articulo_nombre_form').bind('keyup blur', function() {
        makeUpper(this);
        keyAlphaNum(this, true, true);
    });

    $('#Articulo_precio_regulado_form').bind('keyup blur', function() {
        keyNum(this, true);
    });

    $('#Articulo_precio_baremo_form').bind('keyup blur', function() {
        keyNum(this, true);
    });
    
    $('#Articulo_tipo_articulo_id').bind('change', function() {
        var id = $("#Articulo_tipo_articulo_id").val();
        if(id == 1) {
            $("#franja").removeClass('hidden');
        }
        else {
            $("#franja").addClass('hidden');
        }
    });
        var id = $("#Articulo_tipo_articulo_id").val();
        if(id == 1) {
            $("#franja").removeClass('hidden');
        }
        else {
            $("#franja").addClass('hidden');
        }
    
    });
</script>