<input type="hidden" id="tipo-formulario" name="configuracion" value="tipo_date" />

<?php
/* @var $this ClasePlantelController */
/* @var $model ClasePlantel */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'configuracion',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>
<input type="hidden" id="tipo-formulario" name="tipo-formulario" value="tipo_date" />
<div id="validaciones">
    <div class="infoDialogBox">
        <p>
            Debe seleccionar la fecha que desea cambiar
        </p>
    </div>
</div>
<div class="widget-box" id="mensaje">

    <div class="widget-header" style="border-width: thin;">
        <h5>Configuracion</h5>

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
            <table>
                <caption style="font-size: 15px; margin-left: 6px;"> Información del Ticket </caption>
                <tr>
                    <td>
                        <div class="profile-info-row">
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-name"><b><i>Nombre</i></b></div>
                                <div class="profile-info-value">
                                    <span id="nombre_configuracion">  <?php echo $model->nombre; ?> </span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="profile-info-row">
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-name"><b><i>Descripción</i></b></div>
                                <div class="profile-info-value">
                                    <span id="nombre_configuracion">  <?php echo $model->descripcion; ?> </span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
           
            <div class="row">

                <input type="hidden" id='id'  name="id" value="<?php echo base64_encode($model->id); ?>" />

               
                     <tr>
                    <td>
                        <div class="profile-info-row">
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-name"><b><i>Fecha</i></b></div>
                                <div class="profile-info-value">
                               <?php echo CHtml::textField('valor_date','', array('size' => 10, 'maxlength' => 10, 'id' => 'valor_date', 'style' => 'width:200px', 'readOnly' => 'readOnly')); ?>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>


 </table>
<?php $this->endWidget(); ?>
<!-- form -->
