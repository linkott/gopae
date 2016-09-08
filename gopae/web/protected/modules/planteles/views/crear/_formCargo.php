
<div id="dialog-autoridades" style="display: none">
    <div id="autoridad_error" class="errorDialogBox" style="display: none">
        <p>
            Debe seleccionar un cargo 
        </p>
    </div>
    <div class="col-md-8"><label for="cargo"> Cargo <span class="required"></span></label></div> &nbsp;&nbsp;
        <?php
        echo CHtml::dropDownList('cargo', 'cargo_id', array(3 => 'Director'), array('empty' => 'Seleccione', 'id' => 'cargo_id', 'class' => 'span-6'));
      //  echo CHtml::dropDownList('cargo', 'id', CHtml::listData
        //                (Cargo::model()->getCargoAutoridad(), 'id', 'nombre'), array('empty' => 'Seleccione', 'id'=>'cargo_id'));
        ?>
</div>