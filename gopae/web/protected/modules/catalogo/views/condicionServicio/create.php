<?php
/* @var $this CondicionServicioController */
/* @var $model CondicionServicio */

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

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#datosGenerales" data-toggle="tab">Crear condici&oacute;n de Servicio</a>
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
    
    
    