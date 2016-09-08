
<div id="autoridad_error" class="errorDialogBox" style="display: none">
    <p>
        Cerciórese de haber seleccionado un Cargo y tenga en cuenta que para poder registrar la autoridad la misma debe presentar su documento de identidad.
    </p>
</div>

<div id="dialog-autoridades" style="display: none" class="row">

    <div id="cargoAutoridad" class="widget-box">

        <div class="widget-header" style="border-width: thin">
            <h5>Agregar Autoridad</h5>
            <div class="widget-toolbar">
                <a  >
                    <i class="icon-chevron-down"></i>
                </a>
            </div>
        </div>

        <div id="agregarCargoAutoridadP" class="widget-body" >
            <div class="widget-body-inner" >
                <div class="widget-main form">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="Cargo_cedula">Cédula</label>
                                <input id="Cargo_cedula" type="text" disabled class="span-12"/>
                            </div>

                            <div class="col-md-4">
                                <label for="Cargo_nombre">Nombre</label>
                                <input id="Cargo_nombre" type="text" disabled class="span-12"/>
                            </div>

                            <div class="col-md-4">
                                <label for="Cargo_apellido">Apellido</label>
                                <input id="Cargo_apellido" type="text" disabled class="span-12"/>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="space-6"></div>
                        </div>

                        <div class="col-md-12">

                            <form name="seleccionCargoForm" id="seleccionCargoForm" method="POST">

                                <div class="col-md-12">
                                    <label for="cargo_id_c" class="col-md-12"> Seleccione el Cargo de la Autoridad <span class="required">*</span></label>
                                    <?php
                                    /* ESTARA COMENTADO MIENTRAS LAS ZONAS EDUCATIVAS CARGAN LOS DIRECTORES */
                                    echo CHtml::dropDownList('cargo_id_c', 'id', CHtml::listData
                                                (CCargo::getData('ente_id', 1, false, true), 'id', 'nombre'),
                                                array('empty' => 'Seleccione', 'id' => 'cargo_id_c', 'class'=>'span-12'));

                                    //echo CHtml::dropDownList('cargo', 'cargo_id', array(3 => 'Director'), array('empty' => 'Seleccione', 'id' => 'cargo_id_c', 'class' => 'span-6'));
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <div class="space-6"></div>
                                </div>
                                <div class="col-md-12">
                                    <label for="Cargo_presento_documento_identidad">Presentó el Documento de Identidad<span class="required">*</span></label>
                                    <select id="Cargo_presento_documento_identidad" name="presento_documento_identidad" class="span-12">
                                        <option>- - -</option>
                                        <option value="SI">Sí</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="space-6"></div>
                                </div>
                                
                                
                                
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
