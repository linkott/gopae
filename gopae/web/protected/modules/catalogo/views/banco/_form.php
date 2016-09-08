<?php
/* @var $this BancoController */
/* @var $model Banco */
/* @var $form CActiveForm */
?>
<?php echo CHtml::hiddenField('Banco[idEncoded]', base64_encode($model->id), array()); ?>

<div class="col-xs-12">
    <div class="row-fluid">

        <div class="tabbable">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#datosGenerales" data-toggle="tab">Datos Generales</a></li>
                <li><a href="#contactosBanco" data-toggle="tab">Contacto</a></li>
                <li><a href="#tiposCuentaBanco" data-toggle="tab">Tipos de Cuenta</a></li>
                <li><a href="#tiposSerialBanco" data-toggle="tab">Tipos de Serial</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="datosGenerales">
                    <div class="form">

                        <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'banco-form',
                                'htmlOptions' => array('data-form-type'=>$formType,), // for inset effect
                                // Please note: When you enable ajax validation, make sure the corresponding
                                // controller action is handling ajax validation correctly.
                                // There is a call to performAjaxValidation() commented in generated controller code.
                                // See class documentation of CActiveForm for details on this.
                                'enableAjaxValidation'=>false,
                        )); ?>

                        <div id="div-result">
                            <?php
                            if($model->hasErrors()):
                                $this->renderPartial('//errorSumMsg', array('model' => $model));
                            else:
                            ?>
                            <div class="infoDialogBox"><p class="note">Todos los campos con <span class="required">*</span> son requeridos.</p></div>
                            <?php
                               endif;
                            ?>
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

                                                        <div class="col-md-8">
                                                            <?php echo $form->labelEx($model,'nombre'); ?>
                                                            <?php echo $form->textField($model,'nombre',array('size'=>60, 'maxlength'=>160, 'class' => 'span-12', "required"=>"required",)); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?php echo $form->labelEx($model,'estatus'); ?>
                                                            <?php echo $form->dropDownList($model, 'estatus', array('A'=>'Activo', 'I'=>'Inactivo', 'E'=>'Eliminado'), array('prompt'=>'- - -', 'class' => 'span-12', )); ?>
                                                        </div>

                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-md-6">
                                        <a class="btn btn-danger" href="<?php echo $this->createUrl("/catalogo/banco"); ?>" id="btnRegresar">
                                            <i class="icon-arrow-left"></i>
                                            Volver
                                        </a>
                                    </div>

                                    <div class="col-md-6 wizard-actions">
                                        <button class="btn btn-primary btn-next" data-last="Finish" type="submit">
                                            Guardar
                                            <i class="icon-save icon-on-right"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div><!-- form -->
                </div>
                
                <div class="tab-pane" id="contactosBanco">
                    <?php if($model->isNewRecord): ?>
                        <div class="alertDialogBox">
                            <p>
                                Debe efectuar el registro de los Datos Generales del Banco antes de vincular un Contacto.
                            </p>
                        </div>
                    <?php else: ?>
                        <div id="divContactosBanco">
                            <br/>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="tab-pane" id="tiposCuentaBanco">
                    <?php if($model->isNewRecord): ?>
                        <div class="alertDialogBox">
                            <p>
                                Debe efectuar el registro de los Datos Generales del Banco antes de vincular un Tipo de Cuenta.
                            </p>
                        </div>
                    <?php else: ?>
                        <?php $this->renderPartial('_tiposCuentaBancoLista', array('model'=>$model, 'tiposDeCuentaProvider'=>$tiposDeCuentaProvider, 'tipoCuentaSelect'=>$tipoCuentaSelect)); ?>
                    <?php endif; ?>
                </div>
                
                <div class="tab-pane" id="tiposSerialBanco">
                    <?php if($model->isNewRecord): ?>
                        <div class="alertDialogBox">
                            <p>
                                Debe efectuar el registro de los Datos Generales del Banco antes de vincular un Tipo de Serial.
                            </p>
                        </div>
                    <?php else: ?>
                        <?php  $this->renderPartial('_tiposSerialCuentaBancoLista', array('model'=>$model, 'tiposSerialDeCuentaProvider'=>$tiposSerialDeCuentaProvider, 'tipoSerialCuentaSelect'=>$tipoSerialCuentaSelect)); ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <div id="resultDialog" class="hide"></div>

    </div>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catalogo/banco/form.js',CClientScript::POS_END); ?>
<?php //if($model->isNewRecord): ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catalogo/banco/adminContactoBanco.js',CClientScript::POS_END); ?>
<?php //endif; ?>