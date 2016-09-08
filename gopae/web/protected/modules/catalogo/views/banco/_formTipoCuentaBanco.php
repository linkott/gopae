<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'tipo-cuenta-banco-form',
            'htmlOptions' => array('data-form-type'=>'new'), // for inset effect
            'action'=>Yii::app()->createUrl('/catalogo/banco/registroTipoCuentaBanco'),
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
    )); ?>

    <div id="div-result">
  
    </div>

    <div id="div-datos-generales">

        <div class="widget-box">

            <div class="widget-header">
                <h5>Datos Generales</h5>

                <div class="widget-toolbar">
                    <a data-action="collapse" href="#">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-body-inner">
                    <div class="widget-main">
                        <div class="widget-main form">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-4">
                                        <label for="TipoCuentaBanco_banco">Banco</label>
                                        <?php echo CHtml::textField('TipoCuentaBanco[banco]', '', array('size'=>60, 'maxlength'=>160, 'class' => 'span-12', "required"=>"required", 'readOnly'=>true,)); ?>
                                        <?php echo CHtml::hiddenField('TipoCuentaBanco[banco_id]', '', array("required"=>"required", 'readOnly'=>true,)); ?>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="TipoCuentaBanco_tipo_cuenta">Tipo de Cuenta</label>
                                        <?php echo CHtml::textField('TipoCuentaBanco[tipo_cuenta]', '', array('size'=>60, 'maxlength'=>160, 'class' => 'span-12', "required"=>"required", 'readOnly'=>true,)); ?>
                                        <?php echo CHtml::hiddenField('TipoCuentaBanco[tipo_cuenta_id]', '', array("required"=>"required", 'readOnly'=>true,)); ?>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <?php echo $form->labelEx($model,'identificador'); ?>
                                        <?php echo $form->textField($model, 'identificador', array('size'=>60, 'maxlength'=>5, 'class' => 'span-12', "required"=>"required",)); ?>
                                    </div>
                                    
                                    <button id="btnSubmitTipoCuentaBanco" class="btn btn-primary btn-next hidden" type="submit"></button>

                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->