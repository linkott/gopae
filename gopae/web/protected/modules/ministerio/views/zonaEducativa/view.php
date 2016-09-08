
           
<table>
    
    <tr> 
        <td><br><center>
        <?php       
                    echo CHtml::image(Yii::app()->baseUrl . '/public/images/educacion/'.$nombre_estado.'.png', "", array("width" => "95px", "height" => "95px"));
                    
                    
                    ?>    
            
            
            
        </td>
        
        
        <td> 
<div class="space-12"></div>
<div class="profile-user-info profile-user-info-striped">
<div class="profile-info-row">
    <div class="profile-info-name"><b><i>NOMBRE</i></b></div>
<div class="profile-info-value">
<span id="nombre_zona"><?php echo $zona_nombre;?> &nbsp;</span>
</div>
</div>


<div class="profile-info-row">
<div class="profile-info-name"><b><i>ESTADO</i></b></div>
<div class="profile-info-value">
<span id="estado"><i class="icon-map-marker light-orange bigger-110"></i>&nbsp &nbsp<?php echo $nombre_estado;?></span>
</div>
</div>
    
<div class="profile-info-row">
<div class="profile-info-name"><b><i>AUTORIDAD</i></b></div>
<div class="profile-info-value">
<span id="estado"><?php echo $nombreApellido;?> &nbsp;</span>
</div>
</div>
    
<div class="profile-info-row">
<div class="profile-info-name"><b><i>TELÉFONO</i></b></div>
<div class="profile-info-value">
    <span id="estado"><?php echo $telefonos;?> &nbsp;</span>
</div>
</div>
    
<div class="profile-info-row">
<div class="profile-info-name"><b><i>CORREO</i></b></div>
<div class="profile-info-value">
<span id="estado"><i><?php echo $email;?> &nbsp;</i></span>
</div>
</div>

</div>
        </td>
      
    </tr>

</table>  