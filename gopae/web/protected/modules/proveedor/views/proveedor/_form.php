<?php
/* @var $this ProveedorController */
/* @var $model Proveedor */
/* @var $form CActiveForm */

$this->pageTitle = 'Registro de Proveedores';

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'proveedor-form',
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
        <li><a data-toggle="tab" href="#socios">Socios</a></li>
        <li><a data-toggle="tab" href="#documentos">Documentos</a></li>
<!--        <li><a data-toggle="tab" href="#zonas">Zonas</a></li>-->

    </ul>

    <div class="tab-content">
        <div id="datosGenerales" class="tab-pane active">

            <?php if ($form->errorSummary($model)) { ?>
                <div id ="div-result-message" class="errorDialogBox" >
                    <?php echo $form->errorSummary($model); ?>
                </div>

            <?php } else if ($estatusMod == true) { ?>

                <div id='exitProveedor' class="successDialogBox">
                    <p>
                        Exito! Modificado satisfactoriamente.
                    </p>
                </div>


            <?php } else if ($estatus == true) { ?>

                <div id='exitProveedor' class="successDialogBox">
                    <p>
                        Exito! registrado a la base de datos satisfactoriamente.
                    </p>
                </div>
            <?php } else { ?>

                <div id='infoProveedor' class="infoDialogBox" style="">
                    <p>
                        Por favor ingrese los datos correspondientes, los campos marcados con <span class="required">*</span> son estrictamente requeridos.
                    <menu>
                        <ol>
                            <li>Si el rif el menor a 9 digitos rellene con ceros (0) a la izquierda.</li>
                            <li>Los campos IVSS, NIL, INCES, BANAVIH, SNC y Solvencia Laboral si no se llenan seran registrados con el estatus "NO TIENE".</li>
                        </ol>
                    </menu>

                </div>
            <?php } ?>

            <div class="widget-box">
                <div class="widget-header">
                    <h5>Datos de Proveedor</h5>

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
                                    <label>Rif<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">


                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" id="botonPersonaRif" class="btn btn-xs dropdown-toggle"
                                                    data-toggle="dropdown" style="height: 30px;">
                                                <span id="spanPersonaRif">Persona</span> <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu pull-left" role="menu">
                                                <li><a class="rifAcciones" data-value="Natural">Natural</a></li>
                                                <li><a class="rifAcciones" data-value="Jurídica">Jurídica</a></li>
                                                <li><a class="rifAcciones" data-value="Gubernamental">Gubernamental</a></li>

                                            </ul>
                                        </div>
                                        <?php echo $form->textField($model, 'rif', array('class' => 'form-control span-7', 'style' => 'height: 30px;', 'required' => 'required')); ?>
                                        <?php echo $form->error($model, 'rif'); ?>

                                    </div>


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Razón Social<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->textField($model, 'razon_social', array('class' => 'span-7', 'required' => 'required', 'style' => 'text-transform: uppercase;')); ?>
                                    <?php echo $form->error($model, 'razon_social'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Tipo de Servicio<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'tipo_servicio', array(1 => 'INSUMO', 0 => 'PLATO SERVIDO'), array('empty' => '- - -', 'class' => 'span-7', 'required' => 'required')); ?>
                                    <?php echo $form->error($model, 'tipo_servicio'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Capital<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->textField($model, 'capital_social', array('class' => 'span-7', 'required' => 'required')); ?>
                                    <?php echo $form->error($model, 'capital_social'); ?>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Telefono Local</label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->textField($model, 'telefono_local', array('class' => 'span-7')); ?>
                                    <?php echo $form->error($model, 'telefono_local'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Telefono Celular<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->textField($model, 'telefono_celular', array('class' => 'span-7', 'required' => 'required')); ?>
                                    <?php echo $form->error($model, 'telefono_celular'); ?>
                                </div>
                            </div>



                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Correo<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->textField($model, 'email', array('class' => 'span-7', 'required' => 'required', 'style' => 'text-transform: uppercase;')); ?>
                                    <?php echo $form->error($model, 'email'); ?>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Correo Alternativo</label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->textField($model, 'email_otro', array('class' => 'span-7', 'style' => 'text-transform: uppercase;')); ?>
                                    <?php echo $form->error($model, 'email_otro'); ?>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Tipo de Empresa<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'tipo_empresa_id', CHtml::listData(CTipoEmpresa::getData(), 'id', 'nombre'), array('empty' => '- - -', 'class' => 'span-7', 'required' => 'required')); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Sector<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'tipo_sector_id', CHtml::listData(CTipoSector::getData(), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'required' => 'required')); ?>
                                    <?php echo $form->error($model, 'tipo_sector_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-box">

                <div class="widget-header">
                    <h5>Datos de Ubicación</h5>

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
                                    <label>Estado<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    echo $form->dropDownList($model, 'estado_id', CHtml::listData(CEstado::getData(), 'id', 'nombre'), array(
                                        'empty' => '- SELECCIONE -',
                                        'class' => 'span-7',
                                        'ajax' => array(
                                            'type' => 'GET',
                                            'update' => '#Proveedor_municipio_id',
                                            'url' => CController::createUrl('/proveedor/proveedor/seleccionarMunicipio'),
                                        )
                                    ));
                                    ?>
                                    <?php echo $form->error($model, 'estado_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Municipio<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    echo $form->dropDownList($model, 'municipio_id', array(), array(
                                        'empty' => '- SELECCIONE -',
                                        'class' => 'span-7',
                                        'ajax' => array(
                                            'type' => 'GET',
                                            'update' => '#Proveedor_parroquia_id',
                                            'url' => CController::createUrl('/proveedor/proveedor/seleccionarParroquia'),
                                        )
                                    ));
                                    ?>
                                    <?php echo $form->error($model, 'municipio_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Parroquia<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    echo $form->dropDownList($model, 'parroquia_id', array(), array(
                                        'empty' => '- SELECCIONE -',
                                        'class' => 'span-7',
                                        'ajax' => array(
                                            'type' => 'GET',
                                            'update' => '#Proveedor_urbanizacion_id',
                                            'url' => CController::createUrl('/proveedor/proveedor/seleccionarUrbanizacion'),
                                            'success' => 'function(resutl) {
                                                $("#Proveedor_urbanizacion_id").html(resutl);
                                                var parroquia_id=$("#Proveedor_parroquia_id").val();

                                                var data=
                                                        {
                                                            parroquia_id: parroquia_id,

                                                        };
                                                $.ajax({
                                                    type:"GET",
                                                    data:data,
                                                    url:"/proveedor/proveedor/seleccionarPoblacion",
                                                    update:"#Proveedor_poblacion_id",
                                                    success:function(result){  $("#Proveedor_poblacion_id").html(result);}
                                                });
                                            }',
                                        )
                                    ));
                                    ?>
                                    <?php echo $form->error($model, 'parroquia_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Población<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'poblacion_id', array('empty' => '---'), array('class' => 'span-7')); ?>
                                    <?php echo $form->error($model, 'poblacion_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Urbanización<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'urbanizacion_id', array('empty' => '- - -'), array('class' => 'span-7')); ?>
                                    <?php echo $form->error($model, 'urbanizacion_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Capacidad de Distribución (Transporte)<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'capacidad_distribucion', array(1 => 'SI', 0 => 'NO'), array('empty' => '- - -', 'class' => 'span-7')); ?>
                                    <?php echo $form->error($model, 'capacidad_distribucion'); ?>
                                </div>
                            </div>

                            <div class=" col-md-12 space-6"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <label>Dirección Referencial <span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-12">
                                        <?php echo $form->textArea($model, 'direccion', array('class' => 'span-12', 'required' => 'required', 'style' => 'text-transform: uppercase;')); ?>
                                        <?php echo $form->error($model, 'direccion'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="widget-box">

                <div class="widget-header">
                    <h5>Datos de Auditoria</h5>

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
                                    <label>I.V.S.S </label>
                                </div>

                                <div class="col-md-12">

                                    <div class="input-group">

                                        <?php echo $form->textField($model, 'ivss', array('class' => 'form-control span-7')); ?>
                                        <?php echo $form->error($model, 'ivss'); ?>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm  dropdown-toggle"
                                                    data-toggle="dropdown">
                                                Acción <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li><a class="ivssAcciones" data-value="EN TRAMITE">EN TRAMITE</a></li>
                                                <li><a class="ivssAcciones" data-value="NO TIENE">NO TIENE</a></li>
                                                <li><a class="ivssAcciones" data-value="SI POSEE">SI POSEE</a></li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>N.I.L</label>
                                </div>
                                <div class="col-md-12">


                                    <div class="input-group">

                                        <?php echo $form->textField($model, 'nil', array('class' => 'form-control span-7')); ?>
                                        <?php echo $form->error($model, 'nil'); ?>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm dropdown-toggle"
                                                    data-toggle="dropdown">
                                                Acción <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li><a class="nilAcciones" data-value="EN TRAMITE">EN TRAMITE</a></li>
                                                <li><a class="nilAcciones" data-value="NO TIENE">NO TIENE</a></li>
                                                <li><a class="nilAcciones" data-value="SI POSEE">SI POSEE</a></li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">

                                    <label>I.N.C.E.S</label>
                                </div>
                                <div class="col-md-12">

                                    <div class="input-group">

                                        <?php echo $form->textField($model, 'inces', array('class' => 'form-control span-7')); ?>
                                        <?php echo $form->error($model, 'inces'); ?>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm dropdown-toggle"
                                                    data-toggle="dropdown">
                                                Acción <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li><a class="incesAcciones" data-value="EN TRAMITE">EN TRAMITE</a></li>
                                                <li><a class="incesAcciones" data-value="NO TIENE">NO TIENE</a></li>
                                                <li><a class="incesAcciones" data-value="SI POSEE">SI POSEE</a></li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>B.A.N.A.V.I.H</label>
                                </div>
                                <div class="col-md-12">

                                    <div class="input-group">

                                        <?php echo $form->textField($model, 'banavih', array('class' => 'form-control span-7')); ?>
                                        <?php echo $form->error($model, 'banavih'); ?>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm dropdown-toggle"
                                                    data-toggle="dropdown">
                                                Acción <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li><a class="banavihAcciones" data-value="EN TRAMITE">EN TRAMITE</a></li>
                                                <li><a class="banavihAcciones" data-value="NO TIENE">NO TIENE</a></li>
                                                <li><a class="banavihAcciones" data-value="SI POSEE">SI POSEE</a></li>

                                            </ul>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>S.N.C</label>
                                </div>
                                <div class="col-md-12">

                                    <div class="input-group">

                                        <?php echo $form->textField($model, 'snc', array('class' => 'form-control span-7')); ?>
                                        <?php echo $form->error($model, 'snc'); ?>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm dropdown-toggle"
                                                    data-toggle="dropdown">
                                                Acción <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li><a class="sncAcciones" data-value="EN TRAMITE">EN TRAMITE</a></li>
                                                <li><a class="sncAcciones" data-value="NO TIENE">NO TIENE</a></li>
                                                <li><a class="sncAcciones" data-value="SI POSEE">SI POSEE</a></li>

                                            </ul>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Solvencia Laboral</label>
                                </div>
                                <div class="col-md-12">

                                    <div class="input-group">

                                        <?php echo $form->textField($model, 'solvencia_laboral', array('class' => 'form-control span-7')); ?>
                                        <?php echo $form->error($model, 'solvencia_laboral'); ?>
                                        <div class="input-group-btn">
                                           <button type="button" class="btn btn-sm dropdown-toggle"
                                                    data-toggle="dropdown">
                                                Acción <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li><a class="solvenciaLaboralAcciones" data-value="EN TRAMITE">EN TRAMITE</a></li>
                                                <li><a class="solvenciaLaboralAcciones" data-value="NO TIENE">NO TIENE</a></li>
                                                <li><a class="solvenciaLaboralAcciones" data-value="SI POSEE">SI POSEE</a></li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="widget-box">

                <div class="widget-header">
                    <h5>Datos Financieros</h5>

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
                                    <label>Rif del Titular de la Cuenta<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">


                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" id="botonRifTitular" class="btn btn-xs dropdown-toggle"
                                                    data-toggle="dropdown" style="height: 30px;">
                                                <span id="spanTitularRif" >Persona</span> <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu pull-left" role="menu">
                                                <li><a class="rifTitularAcciones" data-value="Natural">Natural</a></li>
                                                <li><a class="rifTitularAcciones" data-value="Jurídica">Jurídica</a></li>
                                                <li><a class="rifTitularAcciones" data-value="Gubernamental">Gubernamental</a></li>
                                            </ul>
                                        </div>
                                        <?php echo $form->textField($model, 'rif_titular_cuenta', array('class' => 'form-control span-7', 'required' => 'required', 'style' => 'height: 30px;')); ?>
                                        <?php echo $form->error($model, 'rif_titular_cuenta'); ?>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Titular de la Cuenta<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->textField($model, 'titular_cuenta', array('class' => 'span-7', 'required' => 'required', 'style' => 'text-transform: uppercase;')); ?>
                                    <?php echo $form->error($model, 'titular_cuenta'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Banco<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'banco_id', CHtml::listData(CBanco::getData(), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'required' => 'required')); ?>
                                    <?php echo $form->error($model, 'banco_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Tipo de Cuenta<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->dropDownList($model, 'tipo_cuenta_id', CHtml::listData(CTipoCuenta::getData(), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'required' => 'required')); ?>
                                    <?php echo $form->error($model, 'tipo_cuenta_id'); ?>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label>Nro de Cuenta<span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->textField($model, 'numero_cuenta', array('class' => 'span-7')); ?>
                                    <?php echo $form->error($model, 'numero_cuenta'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label> ¿Posee algun familiar en el ministerio? <span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-1">
                                        <label for="v_m_si">SI:</label>
                                    </div>
                                    <div class="col-md-5">

                                        <?php echo $form->radioButton($model, 'vinculo_funcionario', array('id' => 'v_m_si', 'value' => '0', 'uncheckValue' => null)); ?>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="v_m_no">NO: </label>
                                    </div>
                                    <div class="col-md-5">
                                        &nbsp;<?php echo $form->radioButton($model, 'vinculo_funcionario', array('id' => 'v_m_no', 'value' => '1', 'uncheckValue' => null)); ?>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <input type="hidden" id='id' name="id"  value="<?php echo $model->id ?>" />

            <hr>
            <div class="row">

                <div class="col-md-6">
                    <a class="btn btn-danger" href="/proveedor/proveedor/">
                        <i class="icon-arrow-left bigger-110"></i>
                        Volver
                    </a>
                </div>

                <div class="col-md-6 text-right">
                    <button class="btn btn-primary btn-next" data-last="Finish ">
                        Guardar
                        <i class=" icon-save"></i>
                    </button>
                </div>

            </div>
        </div>
        <?php $this->endWidget(); ?>

        <div id="socios" class="tab-pane">
            <?php
            if ($model->id !== NULL) {
                $this->renderPartial('_formSocio', array('model' => $modelSocio, 'proveedor_id' => $proveedor_id, 'tipo' => 'update'/* , 'dataProvider' => $dataProviderAula */));
            } else {
                ?>
                <div id='infoProveedorSocios' class="alertDialogBox">
                    <p>
                        Debe registrar primero el proveedor para registrar los socios.
                    </p>
                </div>
                <?php
            }
            ?>
        </div>




        <div id="documentos" class="tab-pane">

            <?php
            if ($model->id !== NULL) {
                $this->renderPartial('_formDocumento', array('model' => $modelDocumento, 'proveedor_id' => $proveedor_id, 'tipo' => 'update'));
            } else {
                ?>
                <div id='infoProveedorDocumentos' class="alertDialogBox">
                    <p>
                        Debe registrar primero el proveedor para cargar los documentos.
                    </p>
                </div>
                <?php
            }
            ?>

        </div>




    </div>

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/proveedor/proveedor.js', CClientScript::POS_END);
?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        
        $('#Proveedor_rif').mask('V-999999999');
        $('#Proveedor_rif_titular_cuenta').mask('V-999999999');
    
        vinculo_funcionario = '<?php ($model->vinculo_funcionario) ? print($model->vinculo_funcionario) : print(null) ?>';
        estado_id = '<?php ($model->estado_id) ? print($model->estado_id) : print(null) ?>';
        municipio_id = '<?php ($model->municipio_id) ? print($model->municipio_id) : print(null) ?>';
        parroquia_id = '<?php ($model->parroquia_id) ? print($model->parroquia_id) : print(null) ?>';
        poblacion_id = '<?php ($model->poblacion_id) ? print($model->poblacion_id) : print(null) ?>';
        urbanizacion_id = '<?php ($model->urbanizacion_id) ? print($model->urbanizacion_id) : print(null) ?>';

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

        if (vinculo_funcionario != null) {

            $("#v_m_si").attr('checked', true);
            $("#v_m_no").attr('checked', false);

        } else {

            $("#v_m_si").attr('checked', false);
            $("#v_m_no").attr('checked', true);
        }

    });
</script>

