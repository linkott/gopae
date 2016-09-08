
<?php
/* @var $this ClasePlantelController */
/* @var $model ClasePlantel */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'clase-plantel-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>
<div id="validaciones">
    <div class="infoDialogBox">
        <p>
            Todos los campos marcados con el símbolo <span class="required">*</span> son campos requeridos para efectuar esta acción.
        </p>
<?php if (!empty($crear)): ?>
            <p>
                El archivo que corresponde al instructivo que desea registrar debe estar en los siguientes formatos: pdf,opt,doc.
            </p>
<?php endif; ?>
    </div>
</div>

<div class="widget-box" id="mensaje">

    <div class="widget-header" style="border-width: thin;">
        <h5>Grupo</h5>

        <div class="widget-toolbar">
            <a>
                <a data-action="collapse" href="#">
                    <i class="icon-chevron-up"></i>
                </a>
            </a>
        </div>
    </div>
    <div class="widget-body">

        <div class="widget-main form">

            <?php
            if ($form->errorSummary($model)):
                ?>
                <div id ="div-result-message" class="errorDialogBox" >

                <?php echo $form->errorSummary($model); ?>
                </div>
                <?php
            endif;
            ?>
            <div class="row">

                <input type="hidden" id='id' name="id" value="<?php echo base64_encode($model->id); ?>" />

                <table>
                    <?php if(empty($actualizar)):?>
                    <tr>
                        <td>
                            <div class="col-md-12">
                                <label class="col-md-12" for="correo_unidad">Grupo de la unidad <span class="required">*</span> </label>
                               <?php echo CHtml::dropDownList('grupo', '', CHtml::listData($grupos, 'id', 'groupname'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'style' => 'width:40%;', 'required' => 'required')); ?>     
                            </div>
                        </td>
                    </tr>
                    <?php  endif;?>
                    <?php if(!empty($actualizar)):?>
                    <?php  $grupo = is_object($model->group) ? $model->group->id : ''; ?>
                     <tr>
                        <td>
                            <div class="col-md-12">
                                <label class="col-md-12" for="grupo"> Grupos <span class="required">*</span> </label>
                               <?php echo CHtml::dropDownList('grupo', $grupo , CHtml::listData($grupos, 'id', 'groupname'), array('empty' => '- SELECCIONE -', 'class' => 'span-7', 'style' => 'width:40%;', 'required' => 'required')); ?>

                            </div>
                        </td>
                    </tr>
                    <?php  endif;?>

                    <div class="col-md-12">
                        <label class="col-md-12" for="grupo">Unidad Responsable de la Solicitud <span class="required">*</span> </label>
                        <input type="text" name='grupo' value="<?php echo Yii::app()->getSession()->get('unidad') ?> "readonly="readonly" style="width:100%">
                    </div>
                    </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>