<?php
/* @var $this ClasePlantelController */
/* @var $model ClasePlantel */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'clase-grupo-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>
<div id="validacionesG"> </div>
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

<div class="widget-box" id="mensaje">
    <div class="widget-header" style="border-width: thin;">
        <h5>Grupo</h5>
        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main form">
            <div class="row">
                    <div class="col-md-6">
                        <label class="col-md-12" for="grupo">Unidad Responsable de la Solicitud <span class="required">*</span> </label>
                        <input type="text" name='grupo' value="<?php echo Yii::app()->getSession()->get('unidad') ?> "readonly="readonly" style="width: 90%;">
                    </div>
                            <div class="col-md-6">
                                <label class="col-md-12" for="correo_unidad">Grupo de la unidad <span class="required">*</span> </label>
                                <?php echo CHtml::dropDownList('grupo', '', CHtml::listData($grupos, 'id', 'groupname'), array('empty' => '- SELECCIONE -', 'required' => 'required', 'style' => 'width:100%')); ?>
                                 </div>
                            </div>
                        </div>
        </div>
</div>

    <?php $this->endWidget(); ?>