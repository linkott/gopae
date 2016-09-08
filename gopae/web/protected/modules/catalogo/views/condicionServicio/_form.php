<?php
/* @var $this CondicionServicioController */
/* @var $model CondicionServicio */
/* @var $form CActiveForm */

?>
<script>

    
        $('#condicionServicio').bind('keyup blur', function() {
   
            keyLettersAndSpaces(this,true);

        makeUpper(this);
        //  });

        /*$('#').bind('keyup blur', function() {
         keyAlphaNum(this, true, true);
         //makeUpper(this);
         });*/
    });

$(document).ready(function() {  
    function noENTER(evt)
    {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if ((evt.keyCode == 13) && (node.type == "text"))
        {
            return false;
        }
        }
        document.onkeypress = noENTER;
    
});

</script>
<div class="form">
    <div class="tab-content">
        <div class="widget-main form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'condicion-servicio-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableClientValidation' => false,
                'enableAjaxValidation' => false,
            ));
            ?>
            <?php
            if ($form->errorSummary($model)):
                ?>
                <div id ="div-result-message" class="errorDialogBox" >
                    <?php echo $form->errorSummary($model); ?>
                </div>
                <?php
            endif;
            ?>
            <?php echo $form->hiddenField($model, 'id', array('class' => 'hide')); ?>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'nombre ', array('class' => 'col-sm-3 control-label no-padding-right')); ?>
                <?php echo $form->textField($model, 'nombre', array('size' => 60,'id'=>'condicionServicio', 'maxlength' => 70, 'class' => 'col-xs-10 col-sm-5')); ?>

            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!-- form -->
<div class="space-7"></div>
