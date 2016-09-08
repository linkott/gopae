



   <?php
/* @var $this ClasePlantelController */
/* @var $model ClasePlantel */
/* @var $form CActiveForm */
?>





<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clase-plantel-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
 

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

                                         <input type="hidden" id='id' name="id" value="<?php echo base64_encode($model->id);?>" />
                                                                
                                             <div class="col-md-6">
<label class="col-md-12" for="groupname">Periodo Escolar</label>
<?php
$i = date('Y');
$j = date('Y')+1;
//echo $i; echo '-'.$j;
$resultado=$i.'-'.$j;
echo 
$form->textField($model,'periodo',array('size'=>30,'maxlength'=>30,'class
'=>'col-xs-10 col-sm-5', 'required'=>'required', 'value'=>$resultado,'id'=>'nombre')); ?>
</div>                                     </div>

        
                    
                      <div class="row">

                                         <input type="hidden" id='id' name="id" value="<?php echo base64_encode($model->id);?>" />
                                                                
                                             <div class="col-md-6">
<label class="col-md-12" for="groupname">Año De Inicio</label>
<?php echo
$form->textField($model,'anio_inicio',array('size'=>30,'maxlength'=>30,'class
'=>'col-xs-10 col-sm-5', 'required'=>'required','value'=>$i)); ?>
</div>                                     </div>

                    
                    
                     <div class="row">
                         

                                                       
                     

                                         <input type="hidden" id='id' name="id" value="<?php echo base64_encode($model->id);?>" />
                                           <div class="col-md-6">
                                               
                                               <label class="col-md-12" for="groupname">Año De Fin</label>
<?php echo
$form->textField($model,'anio_fin',array('size'=>30,'maxlength'=>30,'class
'=>'col-xs-10 col-sm-5', 'required'=>'required','value'=>$j,'readonly'=>'readonly')); ?>
</div>   
                                               
                                       <?php //echo $form->labelEx($model, 'anio_fin', array("class" => "col-md-12")); ?>
                                        
                                        
                                      <?php   //$ini_year = 1900; $year_fin = date('Y')+1;
                                        //$anios = array();
                                       //$i=$ini_year;
                                        //while($i<=$year_fin){ 
                                            //$anios["$i"]=$i;
                                            //$i++;
                                                 
                                        
                                        //}
                                        
                                        //echo $form->dropDownList($model, 'anio_fin', $anios, array('empty' => '- SELECCIONE -', 'class' => 'span-4'));
                                        ?>
                                        <?php //echo $form->error($model, 'annio_fundado');  ?>
                                    

</div>       
                     </div>
        </div>

                    
                    
             

   
                        <!--	<div class="form action-center">
                            					<button type="submit" data-last="Finish" class="btn btn-primary btn-next">
                                                    Guardar
                                                    <i class="icon-arrow-right icon-on-right"></i>
                                                </button>

                        		<?php /*echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); */?>
                        		</div>-->
		


         
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
        


   <script>
$(document).ready(function() {

$("#nombre").keyup(function() {
        //makeUpper(this);
        $("#annio_fin").html($("#annio_inicio").val()+1);
        makeUpper(this);

     });
     
  $('#nombre').bind('keyup blur', function () {
 keyText(this, true);

});

    
  });



 
  
  

  </script>
<?php $this->endWidget(); ?>
<!-- form -->
