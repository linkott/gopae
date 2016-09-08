
<?php
/* @var $this PlantelController */
/* @var $model Plantel */
/* @var $form CActiveForm */
?>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'plantel-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            //  'validateOnSubmit' => true,
            'validateOnType' => true,
            'validateOnChange' => true),
    ));
    ?>
    <?php //echo $form->errorSummary($model);  ?>

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#datosGenerales" data-toggle="tab">Actualizar condici&oacute;n de Servicio</a>
            </li>
        </ul>
            <div class="tab-pane active" id="actualizar_CodiServicio">
                <?php
                    $this->renderPartial('_form',array('model'=>$model));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    
    
    