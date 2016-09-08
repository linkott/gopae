<?php
/*
 * Vista Principal para agregar nuevo registro de matricula 
 * 
 */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'nuevo-matricula-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>

<div id="guardoRegistro">
    <?php
    if ($form->errorSummary($model)):
        ?>
    <div id ="div-result-message" class="errorDialogBox" >
            <?php echo $form->errorSummary($model); ?>

                </div>
            <?php
        endif;
        ?>
        <?php
        if ($form->errorSummary($mEstudiante)):
            ?>
            <div id ="div-result-message" class="errorDialogBox" >
                <?php echo $form->errorSummary($mEstudiante); ?>
            </div>
            <?php
        endif;
        ?>

</div>


<div >

    <div  id="datosRepresentante">
        <?php
        $this->renderPartial('_formRepresentante', array('model' => $model,
            'modelAfinidad' => $modelAfinidad
        ));
        ?>
    </div>

    <div  id="datosEstudiante" >
        <div id="loading"></div>
        <?php
        // Yii::app()->clientScript->scriptMap['jquery.js'] = false;

        $this->renderPartial('_formNuevoEstudiante', array(
            'mEstudiante' => $mEstudiante, 'mDatosAnt' => $mDatosAnt, 'cedulaEscolar' => $cedulaEscolar
                ), FALSE, TRUE);
        ?>

    </div>


    <div  id="datosEscolaridad">
        <div class="hide" id="summary">
            <p> </p>
        </div>
        <?php
        if (!empty($key)) {
            $this->renderPartial('_formEscolaridad', array(
                'mEstudiante' => $mEstudiante,
                'key' => $key
                    ), FALSE, TRUE);
        }
        ?>
    </div>

</div>

<?php $this->endWidget();
?>
