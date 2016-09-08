<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'clase-plantel-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>
<?php
$this->breadcrumbs = array(
    'Catalogo' => array('/catalogo'),
    'Unidades' => array('/ayuda/unidadRespTicket'),
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END); ?>
<?php $c = 0;
?>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>
            <li><a data-toggle="tab" href="#grupos">Grupos</a></li>
            <li><a data-toggle="tab" href="#distribucion">Distribucion</a></li>
        </ul>




        <div class="tab-content">
            <div id="datosGenerales" class="tab-pane active">
                <div class="widget-box">
                    <div class="widget-header">
                        <h5>Unidades Responsables</h5>
                        <div class="widget-toolbar">
                            <a data-action="collapse" href="#">
                                <i class="icon-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body" id="idenUnidades">
                        <div class="widget-body-inner" style="display: block;">
                            <div class="widget-main form">
                                <div class="infoDialogBox" id="campos" style="display:none;">
                                    <p >
                                        Los campos marcados <span class="required">*</span> son campos requeridos para efectuar esta acción.
                                    </p>
                                </div>
                                <?php if ($mensaje == 1): ?>
                                    <?php
                                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'id' => 'mensaje', 'message' => 'El Registro del unidadad responsable de ticket se ha creado con exito'));
                                endif;
                                ?>
                                <?php if ($mensaje == 2): ?>
                                    <?php
                                    $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'id' => 'mensaje', 'message' => 'El Registro del unidadad responsable de ticket se ha actualizado con exito'));
                                endif;
                                ?>
                                <?php
                                if ($form->errorSummary($model)):
                                    ?>
                                    <div id ="div-result-message" class="errorDialogBox" >
                                        <?php echo $form->errorSummary($model); ?>
                                    </div>
                                <?php endif;
                                ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-md-12" for="nombre">Nombre<span class="required">*</span> </label>
                                        <?php
                                        echo
                                        $form->textField($model, 'nombre', array('maxlength' => 100, 'required' => 'required', 'style' => 'width:200%;'));
                                        ?>
                                    </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-md-12" for="telefono_unidad">Telefono de la Unidad<span class="required">*</span> </label>
                                        <?php
                                        echo
                                        $form->textField($model, 'telefono_unidad', array('size' => 63,'maxlength' => 11, 'required' => 'required'));
                                        ?>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="col-md-12" for="correo_unidad">Correo de la Unidad <span class="required">*</span> </label>
                                        <?php
                                        echo
                                        $form->emailField($model, 'correo_unidad', array('size' => 63,'maxlength' => 180, 'required' => 'required'));
                                        ?>
                                    </div>
                                    
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="row">
                        <!--<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Guardar', array('class' => 'btn btn-primary')); ?>-->
                        <a class="btn btn-danger" href="/ayuda/unidadRespTicket">

                            <i class="icon-arrow-left bigger-110"></i>
                            Volver
                        </a>

                        <button class="btn btn-primary btn-next" data-last="Finish" style="margin-left: 900px;">
                            Guardar
                            <i class=" icon-save"></i>
                        </button>
                    </div>


                </div>

                <?php $this->endWidget(); ?>
                <div id="grupos" class="tab-pane">
                    <?php if (empty($mensaje)): ?>
                        <div class="infoDialogBox">
                            <p>
                                Debe Primero Resgistrar el Responsable de la Unidad para Luego Registrar los grupos </p>
                        </div>

                    <?php endif; ?>
                    <?php if (!empty($mensaje)): ?>
                        <?php $this->renderPartial('_listadoGrupos', array('dataProvider' => $dataProvider, 'id' => $id), false, true); ?>
                    </div>
                <?php endif; ?>
                <div id="distribucion" class="tab-pane">
                    <?php if (empty($mensaje)): ?>
                        <div class="infoDialogBox">
                            <p>
                                Debe Primero Resgistrar el Responsable de la Unidad para Luego Registrar los grupos </p>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($mensaje)): ?>
                        <?php $this->renderPartial('_listadoDistribuciones', array('dataProviderDistribucion' => $dataProviderDistribucion, 'id' => $id), false, true); ?>
                    </div>
                <?php endif; ?>
            </div>
    <script>


        $(document).ready(function() {
            $.mask.definitions['~'] = '[+-]';
            $('#UnidadRespTicket_telefono_unidad').mask('(0999) 999-9999');
            //funcion que valida que los datos sean solo alfanumericos
            $('#UnidadRespTicket_nombre').bind('keyup blur', function() {
                keyAlpha(this, true);
                makeUpper(this);
            });

            //funcion que impermite espacios en blancos

            var UnidadRespTicket_nombre = $.trim($('#UnidadRespTicket_nombre').val());
            var UnidadRespTicket_telefono_unidad = $.trim($('#UnidadRespTicket_telefono_unidad').val());
            // var UnidadRespTicket_correo_unidad = $.trim($('#UnidadRespTicket_correo_unidad').val());
            //if (UnidadRespTicket_nombre == "" || UnidadRespTicket_telefono_unidad == "" || UnidadRespTicket_correo_unidad == ""){
            //alert('siiiii');
            //}

            //    else if (!isValidEmail($('#UnidadRespTicket_correo_unidad').val())){
            //    displayDialogBox('validaciones', 'error', 'DATOS FALTANTES: El formato de correo no es válido. Ej.: miusuario@me.gob.ve.');
            //    }
        });
    </script>
    <?php if ($mensaje == 1) { ?>
        <script>

            $(document).ready(function() {
                //$("#campo").click(function() {
                $('#campo').hide("slow");
                //$("#parrafo").hide("slow");
                //funcion que impermite espacios en blancos
            });

        </script>


    <?php }
    ?>

