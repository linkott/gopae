
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'plantelAgregarAutoridad-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="tab-pane active" id="agregarAutoridad">

    <div id="agreAutoridad" class="widget-box">



        <div id="resultadoAgAutoridad" class="infoDialogBox">
            <p>
                Debe Ingresar los Datos para agregar una autoridad. Los campo marcados con * son requeridos. 
            </p>
        </div>
        <div id="errorSummaryA" class="errorDialogBox" style="display: none">
            <p>

            </p> 
        </div>


        <div class="widget-header" style="border-width: thin">
            <h5>Agregar Autoridad</h5>
            <div class="widget-toolbar">
                <a  >
                    <i class="icon-chevron-down"></i>
                </a>
            </div>
        </div>

        <div id="agregarAutoridadP" class="widget-body" >
            <div class="widget-body-inner" >
                <div class="widget-main form">                      

                    <div class="row">
                        <?php echo '<input type="hidden" id="plantel_id" value=' . $plantel_id . ' name="plantel_id"/>'; ?>

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="col-md-12"><label for="cedula">Cedula<span class="required">*</span></label> </div> 
                                <?php echo $form->textField($usuario, 'cedula', array('maxlength' => "10", 'size' => '10', 'class' => 'span-6', 'onkeypress' => 'return CedulaFormat(this, event)')); ?>

                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12"> <label for="nombre">Nombre<span class="required">*</span></label> </div> 
                                <?php echo $form->textField($usuario, 'nombre', array('maxlength' => "20", 'size' => '20', 'class' => 'span-6')); ?>

                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12"> <label for="apellido">Apellido<span class="required">*</span></label> </div> 
                                <?php echo $form->textField($usuario, 'apellido', array('maxlength' => "20", 'size' => '20', 'class' => 'span-6')); ?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="col-md-12"><label for="username">Usuario<span class="required">*</span></label> </div> 
                                <?php echo $form->textField($usuario, 'username', array('maxlength' => "20", 'size' => '52', 'class' => 'span-6')); ?>
                            </div>

                            <div class="col-md-4" >
                                <div class="col-md-12"> <label for="email">E-mail<span class="required">*</span></label> </div> 
                                <?php echo $form->textField($usuario, 'email', array('maxlength' => "50", 'size' => '50', 'class' => 'span-6')); ?>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12"><label for="telefono">Telefono<span class="required">*</span></label> </div> 
                                <?php echo $form->textField($usuario, 'telefono', array('maxlength' => "11", 'size' => '11', 'class' => 'span-6')); ?>
                            </div>
                        </div>  
                        <div class="col-md-12">

                            <div class="col-md-4">
                                <div class="col-md-12"><label for="cargo">Cargo<span class="required">*</span></label> </div> 
                                <?php
                                echo CHtml::dropDownList(
                                        'cargo', 'cargo_id', array(
                                    3 => 'Director'), array(
                                    'empty' => 'Seleccione',
                                    'class' => 'span-6'
                                        )
                                );
                                ?>
                            </div>
                        </div>  

                    </div>
                </div>

            </div>
        </div>
    </div>

    <hr>

</div>
<?php $this->endWidget(); ?>
