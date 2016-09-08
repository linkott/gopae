<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    
    <div class="row" style="max-height: 257px">
        
        <div class="col-md-12">
            <div class="space-6"></div>
        </div>

        <div class="col-md-12">
                <div class="col-md-2"><b>C&oacute;digo Plantel</b></div>
                <div class="col-md-4">
                    <?php echo $form->textField($model,'cod_plantel',array('size'=>10,'maxlength'=>10,'class'=>'span-7')); ?>
                </div>


                <div class="col-md-2"><b>C&oacute;digo Estad&iacute;stico</b></div>
                <div class="col-md-4">
                    <?php echo $form->textField($model,'cod_estadistico',array('class'=>'span-7')); ?>
                </div>
        </div>
        
        <div class="col-md-12">
            <div class="space-6"></div>
        </div>

        <div class="col-md-12">

                <div class="col-md-2"><b>Denominaci&oacute;n</b></div>
                <div class="col-md-4">
                    <?php
                    $groupId = Yii::app()->user->group;

                    if($groupId == UserGroups::MISION_RIBAS_NAC)
                    {
                        echo '<select id="Plantel_estatus_plantel_id" name="Plantel[estatus_plantel_id]" class="span-7">
                                    <option value="9">MISIÓN RIBAS</option>
                                </select>';
                    }
                    else
                    {
                        echo $form->dropDownList($model, 'estatus_plantel_id', 
                                CHtml::listData(CDenominacion::getData(), 'id', 'nombre'),
                                array('empty' => '-Seleccione-','class' => 'span-7')
                        );
                    }
                    ?>
                </div>

                <div class="col-md-2"><b>Nombre del Plantel</b></div>
                <div class="col-md-4">
                    <?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>150,'class'=>'span-7')); ?>
                </div>

        </div>
        
        <div class="col-md-12">
            <div class="space-6"></div>
        </div>

        <div class="col-md-12">

                <div class="col-md-2"><b>Estado</b></div>
                <div class="col-md-4">
                    <?php
                    echo $form->dropDownList(
                        $model, 'estado_id', CHtml::listData(CEstado::getData(), 'id', 'nombre'), array('empty' => array('' => '-Seleccione-'), 'class' => 'span-7')
                    );
                    ?>
                </div>


                <div class="col-md-2"><b>Cédula del Director</b></div>
                <div class="col-md-4">
                    <input type="text" name="Plantel[cedula_director]" class="span-7" id="cedulaIdentidadDirector" maxlength="10">
                </div>


        </div>
        
        <div class="col-md-12">
            <hr>

            <div class="row">
                <div class=" pull-right">
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-next btn-sm" data-last="Finish" type="submit" id="buscarPlantel">
                            Buscar
                            <i class="fa fa-search icon-on-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php $this->endWidget(); ?>


<script>
    $(document).ready(function() {

        $('#cedulaIdentidadDirector').bind('keyup blur', function() {
            keyNum(this, true);
        });
        
        $("#yw0").on('submit', function(){
            $("#lnkBusquedaAvanzadaRegUnicPlantelesPae").click();
        });

    });
</script>
