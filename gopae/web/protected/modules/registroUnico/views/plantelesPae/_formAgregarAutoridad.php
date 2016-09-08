
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
                        <input type="hidden" id="UserGroupsUser_plantel_id" name="plantel_id" value="<?php echo $plantel_id; ?>" readonly />

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="col-md-12"><label for="cedula">Cédula<span class="required">*</span></label> </div> 
                                <?php echo $form->textField($autoridadUsuario, 'cedula', array('maxlength' => "10", 'size' => '10', 'class' => 'span-12', 'onkeypress' => 'return CedulaFormat(this, event)')); ?>

                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12"> <label for="nombre">Nombre<span class="required">*</span></label> </div> 
                                <?php echo $form->textField($autoridadUsuario, 'nombre', array('maxlength' => "20", 'size' => '20', 'class' => 'span-12')); ?>

                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12"> <label for="apellido">Apellido<span class="required">*</span></label> </div> 
                                <?php echo $form->textField($autoridadUsuario, 'apellido', array('maxlength' => "20", 'size' => '20', 'class' => 'span-12')); ?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="col-md-12"><label for="username">Usuario<span class="required">*</span></label> </div> 
                                <?php echo $form->textField($autoridadUsuario, 'username', array('maxlength' => "20", 'size' => '52', 'class' => 'span-12')); ?>
                            </div>

                            <div class="col-md-4" >
                                <div class="col-md-12"> <label for="email">E-mail<span class="required">*</span></label> </div> 
                                <?php echo $form->emailField($autoridadUsuario, 'email', array('maxlength' => "50", 'size' => '50', 'class' => 'span-12')); ?>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12"><label for="telefono">Teléfono Celular<span class="required">*</span></label> </div>
                                <?php echo $form->textField($autoridadUsuario, 'telefono_celular', array('maxlength' => "11", 'size' => '11', 'class' => 'span-12')); ?>
                            </div>
                        </div>  
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="col-md-12"><label for="telefono">Teléfono Fijo</label> </div>
                                <?php echo $form->textField($autoridadUsuario, 'telefono', array('maxlength' => "11", 'size' => '11', 'class' => 'span-12')); ?>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><label for="cargo">Cargo<span class="required">*</span></label> </div> 
                                <?php
                                echo CHtml::dropDownList('cargo', 'id', 
                                                CHtml::listData(CCargo::getData('ente_id', 1, false, true), 'id', 'nombre'), 
                                                array('empty' => 'Seleccione', 'id' => 'cargo_id', 'class'=>'span-12'));
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label for="UserGroupsUser_presento_documento_identidad">Presentó el Documento de Identidad<span class="required">*</span></label>
                                <select id="UserGroupsUser_presento_documento_identidad" name="UserGroupsUser[presento_documento_identidad]" class="span-12">
                                    <option>- - -</option>
                                    <option value="SI">Sí</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>
                        </div>  

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<?php $this->endWidget(); ?>
