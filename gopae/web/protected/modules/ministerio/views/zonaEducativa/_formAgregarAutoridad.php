<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'zonaAgregarAutoridad-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="tab-pane active" id="agregarAutoridad">

    <div id="agreAutoridad" class="widget-box">

        <div id="validacionesA">
            <div class="infoDialogBox">

                <p>
                    Debe ingresar los datos requeridos para agregar una autoridad. Los campo marcados con * son requeridos.
                </p>
            </div>
        </div>

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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <?php echo '<input type="hidden" id="plantel_id" value=' . $zona_id . ' name="zona_id"/>'; ?>
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
                            <div class="col-md-12"><label for="telefono_celular">Telefono Celular<span class="required">*</span></label> </div>
                            <?php echo $form->textField($usuario, 'telefono_celular', array('maxlength' => "11", 'size' => '11', 'class' => 'span-6')); ?>
                        </div>

                        <div class="col-md-4">
                            <div class="col-md-12"><label for="telefono">Telefono Fijo<span class="required">*</span></label> </div>
                            <?php echo $form->textField($usuario, 'telefono', array('maxlength' => "11", 'size' => '11', 'class' => 'span-6')); ?>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12"><label for="cargo">Cargo<span class="required">*</span></label> </div>
                            <?php
                            $ente_id = 4; // 4=Zona Educativa
                            echo CHtml::dropDownList('cargo', 'id', CHtml::listData
                                            (Cargo::model()->getCargoAutoridad(Yii::app()->user->id, $ente_id), 'id', 'nombre'), array('empty' => 'Seleccione', 'id' => 'cargo_id', 'class' => 'span-6'));
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