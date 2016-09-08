<?php
/* @var $this TipoFundamentoController */
/* @var $model TipoFundamento */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tipo-fundamento-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
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
        document.onkeypress = noENTER;
</script>

<div class="widget-box">

        <div class="widget-header">
            <h5><?php echo $subtitulo; ?></h5>

            <div class="widget-toolbar">
                <a>
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>

							<div class="form">

							
								 <div class="widget-body">
							        
							            	<div class="widget-main form">

							                             
							                                <?php
							                                    if($form->errorSummary($model)):
							                                ?>
							                                <div id ="div-result-message" class="errorDialogBox" >
							                                    <?php echo $form->errorSummary($model); ?>
							                                </div>
							                                <?php
							                                    endif;
							                                ?>
								                               


							                                    <div class="row">

						<input type="hidden" id='id' name="id" value="<?php echo base64_encode($model->id); ?>" />
							                                                                
							                                             <div class="col-md-6">
							<label class="col-md-12" for="groupname">Nombre o Descripción</label>
							<?php echo
							$form->textField($model,'nombre',array('size'=>30,'maxlength'=>30,'class
							'=>'col-xs-10 col-sm-9', 'required'=>'required','id'=>'nombre')); ?>
							</div>                                     </div>
																		<div class="row">
							                                        		
							                                        		
							                                        	</div>
							                </div>

							   
							                        <!--	<div class="form action-center">
							                            					<button type="submit" data-last="Finish" class="btn btn-primary btn-next">
							                                                    Guardar
							                                                    <i class="icon-arrow-right icon-on-right"></i>
							                                                </button>

							                        		<?php /*echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); */?>
							                        		</div>-->
									


         </div>
     </div>
 </div>


<?php $this->endWidget(); ?>
<!-- form -->
<script>
$(document).ready(function (){

$("#nombre").keyup(function(){

$("#nombre").val($("#nombre").val().toUpperCase());

});

$('#nombre').bind('keyup blur', function () {
 keyText(this, true);

});

$('#nombre').bind('blur', function () {
  clearField(this);
 });

							});
</script>