<div id="dialog-servicio">
    <div id="servicio_error" class="errorDialogBox" style="display: none">
        <p>
        </p>
    </div>
    
    
    <div class="row col-md-12">
        <div class="col-md-6">
            <label for="calidad_servicio"> Calidad del Servicio <span class="required"></span></label> &nbsp;&nbsp;
        </div>
        <div class="col-md-6">
            <?php
            echo CHtml::dropDownList('calidad', 'id', CHtml::listData
                            (CondicionServicio::model()->getCondServ(), 'id', 'nombre'), array('empty' => 'Seleccione', 'style' => 'width:200px'));
            ?>
        </div>
    </div>
    <div class="col-md-12"><div class="space-6"></div></div>
    <div class="row col-md-12">

        <div class="col-md-6">
            <label for="fecha_desde"> Desde <span class="required"></span></label> &nbsp;&nbsp;
        </div>
        <div class="col-md-6">
            <?php echo CHtml::textField('fecha_desde', '', array('size' => 10, 'maxlength' => 10, 'id' => 'fecha_desde', 'style' => 'width:200px' , 'readOnly' => 'readOnly'
                )); ?>
        </div>
    </div>
</div>