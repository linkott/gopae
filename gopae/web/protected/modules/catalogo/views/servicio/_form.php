
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
    
</div>

<div class="widget-box" id="mensaje">

    <div class="widget-header" style="border-width: thin;">
        <h5>Servicio</h5>

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
                    <tr>
                        <td>
<div class="col-md-6">
                <label class="col-md-12" for="groupname">Nombre o Descripción</label>
                     <?php
                echo
                $form->textField($model, 'nombre', array('size' => 60, 'maxlength' => 50, 'class
' => 'col-xs-30 col-sm-30', 'required' => 'required'));
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
    <script>
        $(document).ready(function() {

            $("#Servicio_nombre").keyup(function() {
                //makeUpper(this);
                makeUpper(this);

            });

            $('#Servicio_nombre').bind('keyup blur', function() {
                keyText(this, true);

            });
            $('#Servicio_nombre').bind('blur', function() {
                clearField(this);
            });

        });

    </script>
