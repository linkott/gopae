<div class="tab-pane active" id="agregarAutoridad">

    <div id="agreAutoridad" class="widget-box">

        <div id="divResult">
        </div>

        <div class="widget-header" style="border-width: thin">
            <h5>Planes de Estudios</h5>
            <div class="widget-toolbar">
                <a  >
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>
        <div id="agregarAutoridadP" class="widget-body" >
            <div class="widget-body-inner" >
                <div class="widget-main form">  

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        //'action' => Yii::app()->createUrl($this->route),
                        'id' => 'plantel-plan-form',
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            //  'validateOnSubmit' => true,
                            'validateOnType' => true,
                            'validateOnChange' => true),
                    ));
                    ?>
                    <div class="row">
                        <div id="1eraFila" class="col-md-12">
                            <div class="col-md-12" >
                                <?php echo CHtml::hiddenField('plantel_id', $plantel_id); ?>
                                <?php echo $form->labelEx($modelPlan, 'plan_id', array("class" => "col-md-12")); ?>
                                <?php echo $form->dropDownList($modelPlan, 'plan_id', CHtml::listData($planesDisponibles, 'id', 'nombre'), array('empty' => '-Seleccione-', 'style' => "width:91.5%; "));
                                ?>
                                <div class="row col-md-12" ><?php echo $form->error($modelPlan, 'plan_id'); ?> </div>
                            </div>
                        </div>

                        <div id="2daFila" class="col-md-12 hide">
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                    <br>
                </div>
            </div>
        </div>


    </div>
</div>



