
<div class = "widget-box">
    <div class = "widget-header" style="border-width: thin">
        <h5>Materias Pendientes</h5>

        <div class = "widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div class = "widget-body-inner">
            <div class = "widget-main">

                <div class="row row-fluid">
                    <div id="1eraFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('Materia Pendiente', '', array("class" => "col-md-12")); ?>
                            <?php
                            echo CHtml::dropDownList('materia_pendiente', '', $dropDownAsignaturaPendiente, array(
                                'id' => 'materia_pendiente',
                                'class' => 'span-7',
                                'empty' => array('' => '- SELECCIONE -'),
                            ));
                            ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Agregar otra Materia', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::checkBox('agregarMateria', false, array()); ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>

                    <div id="2daFila" class="col-md-12 hide">

                        <div class="col-md-4" >
                            <?php echo CHtml::label('Materia Pendiente', '', array("class" => "col-md-12")); ?>
                            <?php
                            echo CHtml::dropDownList('materia_pendiente_adicional', '', $dropDownAsignaturaPendiente, array(
                                'id' => 'materia_pendiente_adicional',
                                'class' => 'span-7',
                                'empty' => array('' => '- SELECCIONE -'),
                                'disabled' => 'disabled'
                            ));
                            ?>
                        </div>


                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>

                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
    });
</script>
