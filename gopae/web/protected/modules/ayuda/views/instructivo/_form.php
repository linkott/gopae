
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
<?php //$resultado = PeriodoEscolar::model()->Inactivar_todo($model->id);   ?>


<?php if(empty($crear)):?>
<input type="hidden" id="tipo-formulario" name="tipo-formulario" value="update" />
<?php
endif;
?>

<?php if(!empty($crear)):?>
<input type="hidden" id="tipo-formulario" name="tipo-formulario" value="crear" />
<?php
endif;
?>
<div id="validaciones">
    <div class="infoDialogBox">
        <p>
        Todos los campos marcados con el símbolo <span class="required">*</span> son campos requeridos para efectuar esta acción.
        </p>
        <?php if(!empty($crear)): ?>
        <p>
            El archivo que corresponde al instructivo que desea registrar debe estar en los siguientes formatos: pdf,opt,doc.
        </p>
        <?php  endif;?>
    </div>
</div>

<div class="widget-box" id="mensaje">

    <div class="widget-header" style="border-width: thin;">
        <h5>Instructivo</h5>

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
                        <div class="col-md-12">
                            <label class="col-md-12" for="groupname">Nombre <span class="required">*</span> </label>
                            <?php
                            echo
                            $form->textField($model, 'nombre', array('maxlength' => 200, 'required' => 'required', 'style'=>'width:100%;'));
                            ?>
                        </div>
                    </td>
                </tr>
               
                <tr>
                    <td>
                    <div class="col-md-12">

                        <div style="width: 100%">
                            <label class="col-md-12" for="Url">Indique una breve descripción del instructivo</label>
                    <?php
                    echo
                    $form->textArea($model, 'descripcion', array('size' => 100, 'maxlength' => 500, 'required' => 'required','style'=>'width:100%;'));


                    ?>
                           
                </div>
                    </td>
                </tr>

                <tr>
                    <td>

                        <?php if(!empty($crear)):?>
     <?php $this->renderPartial('_archivo', array('model' => $model, 'subtitulo' => "Nuevo Instructivo"));   endif;?>
                    </td>
                </tr>

            </table>
</div>
                        </div>
    </div>
<script>

    function noENTER(evt)
    {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if ((evt.keyCode == 13) && (node.type == "text"))
        {
            return false;
        }
    }
    document.onkeypress = noENTER;</script>

<?php $this->endWidget(); ?>
<!-- form -->

<script>

    $(document).ready(function() {

//funcion que valida que los datos sean solo alfanumericos
        $('#Instructivo_nombre').bind('keyup blur', function() {
            makeUpper(this);
        });
//funcion que impermite espacios en blancos
        $('#Instructivo_nombre').bind('blur', function() {
            clearField(this);
        });
     
//funcion que valida que la cedula sea solo numerica
        $('#Instructivo_descripcion').bind('keyup blur', function() {
            makeUpper(this);
        });

    });

</script>