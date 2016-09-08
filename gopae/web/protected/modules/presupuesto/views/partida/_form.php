<?php
/* @var $this PartidaController */
/* @var $model Partida */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'partida-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

<div class="tabbable">

    <ul class="nav nav-tabs">

        <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>
        <!--        <li><a data-toggle="tab" href="#socios">Socios</a></li>
                <li><a data-toggle="tab" href="#documentos">Documentos</a></li>-->

    </ul>

    <div class="tab-content">
        <div id="datosGenerales" class="tab-pane active">

            <?php if ($form->errorSummary($model)) { ?>
                <div id ="div-result-message" class="errorDialogBox" >
                    <?php echo $form->errorSummary($model); ?>
                </div>

            <?php } else if ($estatusMod == true) { ?>

                <div id='exitPartida' class="successDialogBox">
                    <p>
                        Exito! Modificado satisfactoriamente.
                    </p>
                </div>


            <?php } else if ($estatus == true) { ?>

                <div id='exitPartida' class="successDialogBox">
                    <p>
                        Exito! registrado a la base de datos satisfactoriamente.
                    </p>
                </div>
            <?php } else { ?>

                <div id='infoPartida' class="infoDialogBox" style="">
                    <p>
                        Por favor ingrese los datos correspondientes, los campos marcados con <b><span class="required">*</span></b> son estrictamente requeridos.
                    </p>

                </div>
            <?php } ?>




            <div class="widget-box">
                <div class="widget-header">
                    <h5>Datos de Partida</h5>

                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="icon-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Codigo</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->textField($model, 'codigo', array('class' => 'span-7', 'required'=>'required')); ?>
                                    <?php echo $form->error($model, 'codigo'); ?>


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Descripción</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->textField($model, 'descripcion', array('class' => 'span-7', 'required'=>'required')); ?>
                                    <?php echo $form->error($model, 'descripcion'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Permite Partida Auxiliar</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'permite_partida_aux',array('1' => 'SI', '0'=>'NO'), array('class' => 'span-7', 'required'=>'required')); ?>
                                    <?php echo $form->error($model, 'permite_partida_aux'); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Admite Transferencia</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'admite_transferencia',array('1' => 'SI', '0'=>'NO'), array('class' => 'span-7', 'required'=>'required')); ?>
                                    <?php echo $form->error($model, 'admite_transferencia'); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Permite Asientos</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'permite_asientos',array('1' => 'SI', '0'=>'NO'), array('class' => 'span-7', 'required'=>'required')); ?>
                                    <?php echo $form->error($model, 'permite_asientos'); ?>
                                </div>
                            </div>

                           <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Tipo de Saldo</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'tipo_saldo_id', CHtml::listData(TipoSaldo::model()->findAllByAttributes(array('estatus' => 'A'), array('order' => 'nombre ASC')), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'required' => 'required')); ?>
                                    <?php echo $form->error($model, 'tipo_saldo_id'); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Tipo de Gasto</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'tipo_gasto_id', CHtml::listData(TipoGasto::model()->findAllByAttributes(array('estatus' => 'A'), array('order' => 'nombre ASC')), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'required' => 'required')); ?>
                                    <?php echo $form->error($model, 'tipo_gasto_id'); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Tipo de Partida</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'tipo_partida_id', CHtml::listData(TipoPartida::model()->findAllByAttributes(array('estatus' => 'A'), array('order' => 'nombre ASC')), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'required' => 'required')); ?>
                                    <?php echo $form->error($model, 'tipo_partida_id'); ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>


            <input type="hidden" id='id' name="id"  value="<?php echo $model->id ?>" />

            <hr>
            <div class="row-fluid wizard-actions">

                <a class="btn btn-danger" href="/proveedor/proveedor/">
                    <i class="icon-arrow-left bigger-110"></i>
                    Volver
                </a>

                <button class="btn btn-primary btn-next" data-last="Finish ">
                    Guardar
                    <i class=" icon-save"></i>
                </button>

            </div>
        </div>

    </div>
    <?php
    $this->endWidget();

    echo CHtml::scriptFile('/public/js/modules/presupuesto/partida.js');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
    ?>
</div>

<script>


    $(document).ready(function() {


        if (estado_id != null)
            $.ajax({
                type: "GET",
                url: "/proveedor/proveedor/seleccionarMunicipio",
                data: {Proveedor: {estado_id: estado_id}},
                success: function(data) {

                    $("#Proveedor_municipio_id").html(data);
                    $("#Proveedor_municipio_id").val(municipio_id);
                }
            });
        if (municipio_id != null)
            $.ajax({
                type: "GET",
                url: "/proveedor/proveedor/seleccionarParroquia",
                data: {Proveedor: {municipio_id: municipio_id}},
                success: function(data) {
                    $("#Proveedor_parroquia_id").html(data);
                    $("#Proveedor_parroquia_id").val(parroquia_id);

                }
            });

        if (poblacion_id != null || urbanizacion_id != null) {
            var dato = {
                Proveedor: {parroquia_id: parroquia_id}
            };
            var datoPoblacion = {
                parroquia_id: parroquia_id
            };
            $.ajax({
                type: "GET",
                data: dato,
                url: "/proveedor/proveedor/seleccionarUrbanizacion",
                update: "#Proveedor_urbanizacion_id",
                success: function(resutl) {
                    $("#Proveedor_urbanizacion_id").html(resutl);
                    $("#Proveedor_urbanizacion_id").val(urbanizacion_id);


                    $.ajax({
                        type: "GET",
                        data: datoPoblacion,
                        url: "/proveedor/proveedor/seleccionarPoblacion",
                        update: "#Proveedor_poblacion_id",
                        success: function(result) {
                            $("#Proveedor_poblacion_id").html(result);
                            $("#Proveedor_poblacion_id").val(poblacion_id);
                        }


                    });

                }
            });
        }

    });
</script>
