<div class="col-md-12">
    <div class="row">
    <div class="widget-box collapsed">

        <div class="widget-header">
            <h5>Plantel <?php echo $plantel['cod_plantel']. ' "' . $plantel['nombre_plantel'] . '"'; ?></h5>

            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="icon-chevron-down"></i>
                </a>
            </div>

        </div>

        <div class="widget-body">

            <div class="widget-body-inner">

                <div class="widget-main">

                    <div class="widget-main form">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Código del Plantel', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['cod_plantel'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Código Estadistico', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['cod_estadistico'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Denominación', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['denominacion'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>
                            </div>

                            <div class="col-md-12"><div class="space-6"></div></div>

                            <div class="col-md-12">
                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Nombre del Plantel', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['nombre_plantel'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Zona Educativa', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['zona_educativa'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Dependencia', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['dependencia'], array('class' => 'span-7', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>
                            </div>

                            <div class="col-md-12"><div class="space-6"></div></div>

                            <div class="col-md-12">
                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Estado', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['estado'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Municipio', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['municipio'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Parroquia', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['parroquia'], array('class' => 'span-7', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>
                            </div>

                            <div class="col-md-12"><div class="space-6"></div></div>

                            <div class="col-md-12">
                                <div class="col-md-4" >
                                    <?php echo CHtml::label('¿El PAE se encuentra activo?', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['pae_activo'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Tipo de Servicio', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['tipo_servicio_pae'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('¿Posee Simoncito?', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['posee_simoncito'], array('class' => 'span-7', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>
                            </div>

                            <div class="col-md-12"><div class="space-6"></div></div>

                            <div class="col-md-12">
                                <div class="col-md-4" >
                                    <?php echo CHtml::label('¿Posee área de Cocina?', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['posee_area_cocina'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Condición de Servicio', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', $plantel['condicion_servicio_pae'], array('class' => 'span-12', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>

                                <div class="col-md-4" >
                                    <?php echo CHtml::label('Matricula Total', '', array("class" => "col-md-12")); ?>
                                    <?php echo CHtml::textField('', ((strlen($plantel['matricula_general'])===0)?'0':$plantel['matricula_general']), array('class' => 'span-7', 'readOnly' => 'readOnly', 'disabled'=>'disabled')); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
</div>