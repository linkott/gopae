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
<?php
$this->breadcrumbs = array(
    'Catalogo' => array('/catalogo'),
    'Unidades' => array('/ayuda/unidadRespTicket'),
);
?>
<div class="tab-content">
    <div id="datosGenerales" class="tab-pane active">
        <div class="widget-box">
            <div class="widget-header">
                <h5>Unidades Responsables</h5>
                <div class="widget-toolbar">
                    <a data-action="collapse" href="#">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body" id="idenUnidades">
                <div class="widget-body-inner" style="display: block;">
                    <div class="widget-main form">
                        <div class="infoDialogBox" id="campos" style="display:none;">

                        </div>
                        <?php
                        if ($form->errorSummary($model)):
                            ?>
                            <div id ="div-result-message" class="errorDialogBox" >
                                <?php echo $form->errorSummary($model); ?>
                            </div>
                        <?php endif;
                        ?>
                        <table>
                            <div class="span-16"> </div>
                            <tr>
                                <td>
                                    <div class="col-md-12">
                                        <label class="col-md-12" for="nombre">Nombre<span class="required">*</span> </label>
                                        <?php
                                        echo
                                        $form->textField($model, 'nombre', array('maxlength' => 100, 'required' => 'required', 'style' => 'width:200%;'));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="col-md-12">
                                        <label class="col-md-12" for="telefono_unidad">Telefono de la Unidad<span class="required">*</span> </label>
                                        <?php
                                        echo
                                        $form->textField($model, 'telefono_unidad', array('maxlength' => 11, 'required' => 'required', 'style' => 'width:100%;'));
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12">
                                        <label class="col-md-12" for="correo_unidad">Correo de la Unidad <span class="required">*</span> </label>
                                        <?php
                                        echo
                                        $form->emailField($model, 'correo_unidad', array('type' => 'email', 'maxlength' => 180, 'required' => 'required', 'style' => 'width:100%;'));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>



