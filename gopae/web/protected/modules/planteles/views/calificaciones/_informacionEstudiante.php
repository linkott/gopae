<div class = "widget-box collapsed">

    <div class = "widget-header">
        <h5>Identificación del Estudiante <?php echo '"' . $datosEstudiante[0]['nombres'] .' '. $datosEstudiante[0]['apellidos'] . '"'; ?></h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>

<div class = "widget-body">
        <div style = "display: none;" class = "widget-body-inner">
            <div class = "widget-main">

                <div class="row row-fluid">

<div id="1eraFila" class="col-md-12">
    
    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Documento de Identidad</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosEstudiante[0]['cedula_identidad'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>
    
    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Nombres</strong>', '', array("class" => "col-md-12",)); ?>
        <?php echo CHtml::textField('', $datosEstudiante[0]['nombres'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Apellidos</strong>', '', array("class" => "col-md-12")); ?>
        <?php echo CHtml::textField('', $datosEstudiante[0]['apellidos'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>

   

</div>

<div class = "col-md-12"><div class = "space-6"></div></div>

<div id="2daFila" class="col-md-12">
    
     <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Genero</strong>', '', array("class" => "col-md-12")); ?>
         
        <?php 
        if($datosEstudiante[0]['genero_id']==0){
          $genero="Femenino";
        }
        else if($datosEstudiante[0]['genero_id']==1){
          $genero="Masculino";
        }
        else if($datosEstudiante[0]['genero_id']==1){
          $genero="No tiene";
        } 
        echo CHtml::textField('',$genero, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
    </div>
    
    <div class="col-md-4" >
        <?php echo CHtml::label('<strong>Edad</strong>', '', array("class" => "col-md-12")); ?>
        <?php 
        $edad=Estudiante::model()->calcularEdad($datosEstudiante[0]['fecha_nacimiento']);
        
        echo CHtml::textField('',$edad, array('class' => 'span-7', 'readOnly' => 'readOnly')); 
        ?>
    </div>
    

</div>

<div class = "col-md-12"><div class = "space-6"></div></div>

             </div>
            </div>
        </div>
    </div>
</div>