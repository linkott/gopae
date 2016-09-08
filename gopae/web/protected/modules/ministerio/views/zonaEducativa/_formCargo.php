<div id="dialog-autoridades" style="display: none">
    <div id="autoridad_error" class="errorDialogBox" style="display: none">
        <p>
            Debe seleccionar un cargo
        </p>
    </div>
    <label for="cargo" class="col-md-12"> Cargo <span class="required">*</span></label> &nbsp;&nbsp;
    <?php
    /* ESTARA COMENTADO MIENTRAS LAS ZONAS EDUCATIVAS CARGAN LOS DIRECTORES */
    echo CHtml::dropDownList('cargo_id_c', 'id', CHtml::listData
                (Cargo::model()->getCargoAutoridad(Yii::app()->user->id, 4), 'id', 'nombre'), array('empty' => 'Seleccione', 'id' => 'cargo_id_c'));

//echo CHtml::dropDownList('cargo', 'cargo_id', array(3 => 'Director'), array('empty' => 'Seleccione', 'id' => 'cargo_id', 'class' => 'span-6'));
?>
</div>