<div class="widget-main form">



    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">

        <div id="1eraFila" class="col-md-12">
            <div class="col-md-4" >
                <?php echo CHtml::label('Nombre del Plan', 'plan_id', array("class" => "col-md-12")); ?>
                <?php echo CHtml::textField('plan', '', array('class' => 'span-7', 'id' => 'plan')); ?>
            </div>

            <div class="col-md-4" >
                <?php echo CHtml::label('Credencial', 'credencial_id', array("class" => "col-md-12")); ?>
                <?php echo CHtml::textField('credencial', '', array('class' => 'span-7', 'id' => 'credencial')); ?>
            </div>
            <div class="col-md-4" >
                <?php echo CHtml::label('Mención', 'mencion_id', array("class" => "col-md-12")); ?>
                <?php echo CHtml::textField('mencion', '', array('class' => 'span-7', 'id' => 'mencion')); ?>
            </div>

        </div>
        <div id="2daFila" class="col-md-12">
            <div class="col-md-4" >
                <?php echo CHtml::label('Fundamento Juridico', 'fund_juridico_id', array("class" => "col-md-12")); ?>
                <?php echo CHtml::textField('fund_juridico', '', array('class' => 'span-7', 'id' => 'fund_juridico')); ?>
            </div>

            <div class="col-md-4" >
                <?php echo CHtml::label('Código de Plan', 'cod_plan', array("class" => "col-md-12")); ?>
                <?php echo CHtml::textField('cod_plan', '', array('class' => 'span-7', 'id' => 'cod_plan')); ?>
                <?php echo CHtml::hiddenField('plantel_id', $model->plantel_id); ?>
            </div>
            <div class="col-md-4">
            </div>

        </div>
    </div> 

    <div class="space-6"></div>

    <div class="row">
        <div class=" pull-right">
            <div class="col-md-12" style="margin-right: 35px;">
                <button class="btn btn-primary btn-next btn-sm" data-last="Finish" type="submit" id="buscarPlan">
                    Buscar
                    <i class="fa fa-search icon-on-right"></i>
                </button>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
