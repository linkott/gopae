<?php
/* @var $this SeccionController */
/* @var $model Seccion */
/* @var $form CActiveForm */
?>
<script>
    $(document).ready(function() {
        $('#capacidadAlumnos').bind('keyup blur', function() {
            if ($("#capacidadAlumnos").val() > 100)
            {
                $("#capacidadAlumnos").val('100');
            }
            keyNum(this, false);// true acepta la ñ y para que sea español
        });

        $("#resultadoSeccionRegistrar").click(function() {
            document.getElementById("resultadoSeccionRegistrar").style.display = "none";
            document.getElementById("resultadoRegistrar").style.display = "block";
        });

        function noENTER(evt)
        {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type == "text"))
            {
                return false;
            }
        }
        document.onkeypress = noENTER;
    });
</script>
<div class="form" id="_formRegistrarSeccion">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'seccion-plantel-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            //  'validateOnSubmit' => true,
            'validateOnType' => true,
            'validateOnChange' => true),
    ));
    ?>



    <div class="tab-pane active" id="registrarS">

        <div id="autor" class="widget-box ">

            <div id="resultadoSeccionRegistrar">
            </div>

            <div id="seccion_error" class="errorDialogBox" style="display: none">
                <p>
                </p>
            </div>

            <div id="resultadoRegistrar" class="infoDialogBox">
                <p>
                    Por Favor Ingrese los datos correspondientes para registrar una sección, Los campos marcados con <span class="required">*</span> son requeridos.
                </p>
            </div>

            <div id ="guardoRegistro" class="successDialogBox" style="display: none">
                <p>
                    Registro Exitoso
                </p>
            </div>

            <div class="widget-header">
                <h5>Registrar Sección</h5>
                <div class="widget-toolbar">
                    <a  href="#" data-action="collapse">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div id="registrarSeccion" class="widget-body" >
                <div class="widget-body-inner" >
                    <div class="widget-main form">

                        <div style="padding: 20px" class="row">

                            <div  id="divNombre" class="col-md-4" >
                                <?php echo $form->labelEx($model, 'seccion_id', array("class" => "col-md-12")); ?>
                                <?php echo $form->dropDownList($model, 'seccion_id', CHtml::listData($seccion, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'id' => 'seccionId')); ?>

                            </div>

                            <div  id="divNivel_id" class="col-md-4" >
                                <?php echo $form->labelEx($model, 'nivel_id', array("class" => "col-md-12")); ?>
                                <?php //echo $form->dropDownList($model, 'nivel_id', CHtml::listData($nivel, 'nivel_id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'id' => 'nivelId')); ?>
                                <?php
                                echo $form->dropDownList(
                                        $model, 'nivel_id', CHtml::listData($nivel, 'nivel_id', 'nombre'), array(
                                    'empty' => array('' => '- SELECCIONE -'),
                                    'class' => 'span-7',
                                    'id' => 'nivelId',
                                    'onChange' => 'mostrarPlan()'
                                        )
                                );
                                ?>

                            </div>
                            <!--CHtml::listData($plan, 'id', 'nombre') -->
                            <div  id="divPlan_id" class="col-md-4" >
                                <?php echo $form->labelEx($model, 'plan_id', array("class" => "col-md-12")); ?>
                                <?php //echo $form->dropDownList($model, 'plan_id', array(), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'id' => 'planId')); ?>
                                <?php
                                //var_dump($model); die();
                                echo $form->dropDownList(
                                        $model, 'plan_id', $plan, array(
                                    'empty' => array('' => '- SELECCIONE -'),
                                    'class' => 'span-7',
                                    'id' => 'planId',
                                    'onChange' => 'mostrarGrado()'
                                        )
                                );
                                ?>
                            </div>
                            <div class="col-md-12"> </div>

                            <div  id="divGrado_id" class="col-md-4" >
                                <?php echo $form->labelEx($model, 'grado_id', array("class" => "col-md-12")); ?>
                                <?php echo $form->dropDownList($model, 'grado_id', $grado, array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'id' => 'gradoId')); ?>

                            </div>

                            <div  id="divCapacidad" class="col-md-4" >
                                <?php echo $form->labelEx($model, 'capacidad', array("class" => "col-md-12", "title" => "Cantidad de estudiantes para esta sección")); ?>
                                <?php echo $form->textField($model, 'capacidad', array('class' => 'span-7', 'id' => 'capacidadAlumnos', 'placeholder' => 'Cantidad de estudiantes')); ?>

                            </div>

                            <div  id="divTurno_id" class="col-md-4" >
                                <?php echo $form->labelEx($model, 'turno_id', array("class" => "col-md-12")); ?>
                                <?php echo $form->dropDownList($model, 'turno_id', CHtml::listData($turno, 'id', 'nombre'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'id' => 'turnoId')); ?>

                            </div>

                        </div>
                        <br>
                        <br>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <!--  <div id="botones" class="row">

          <div class="col-md-6">
              <a id="btnRegresar" href=" // echo Yii::app()->createUrl("planteles/consultar/"); " class="btn btn-danger">
                  <i class="icon-arrow-left"></i>
                  Volver
              </a>
          </div>


      </div> -->

    <?php $this->endWidget(); ?>

</div><!-- form -->

<div id="css_js">
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/seccionPlantel.js', CClientScript::POS_END);
    ?>
</div>






