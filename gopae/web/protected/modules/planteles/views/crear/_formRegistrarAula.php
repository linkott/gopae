<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'nivel-form',
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
            <h4>Nivel</h4>

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
                            <?php echo $form->hiddenField($model, 'plantel_id',array('value' => $modelPlantel->id)); ?>
                            <?php echo $form->hiddenField($model, 'modalidad_id', array('value' => $modalidad_id->id)); ?>

                            <div class="row">
                                <span>
                                    <div class="col-md-4">
                                        Nombre del aula <span class="required">*</span>
                                        
                                        <?php echo $form->textField($model, 'nombre', array('maxlength' => 20, 'class' => 'col-sm-12', 'id'=>'Aula_nombre_form')); ?>
                                    </div>
                                    <div class="col-md-4">
                                        Capacidad <span class="required">*</span>
                                        <?php echo $form->textField($model, 'capacidad', array('maxlength' => 20, 'class' => 'col-sm-12', 'id'=>'Aula_capacidad_form')); ?>
                                    </div>
                                    <div class="col-md-4">
                                        Condici&oacute;n del aula <span class="required">*</span>
                                        <?php
                                        echo $form->dropDownList(
                                                $model, 'condicion_infraestructura_id', CHtml::listData($condicionInfraestructura, 'id', 'nombre'), array('class' => 'span-5',
                                            'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-5')
                                        );
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        Tipo de aula <span class="required">*</span>
                                        <?php
                                        echo $form->dropDownList(
                                                $model, 'tipo_aula_id', CHtml::listData($tipoAula, 'id', 'nombre'), array('class' => 'span-5',
                                            'empty' => array('' => '- SELECCIONE -'), 'class' => 'span-5')
                                        );
                                        ?>
                                    </div>
                                    <div class="col-md-8">
                                        Observaciones
                                        <?php echo $form->textArea($model, 'observacion', array('maxlength' => 200, 'class' => 'col-sm-12')); ?>
                                    </div>
                            </div>
                        </div>

                        <br>

                    </div>

                    <?php $this->endWidget(); ?>


                </div><!-- search-form -->
            </div><!-- search-form -->
        </div>
    </div>
</div>

</div>





<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/aula.js', CClientScript::POS_END);
?>

<script>
    $(document).ready(function() {
        $('#nivel-form').on('submit', function(evt) {
            evt.preventDefault();
            registrarNivel();
        });

        /*$('#nombre_turno').bind('keyup blur', function () {
         keyAlphaNum(this, true, true);
         //makeUpper(this);
         });
         
         $('#nombre_turno').bind('blur', function () {
         clearField(this);
         });*/
    });
</script>