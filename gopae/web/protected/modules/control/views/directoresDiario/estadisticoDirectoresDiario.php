<div class="breadcrumb row row-fluid" style="margin-left: 2px;">
    <li>
        <?php if($nivel=='region'): ?><a>Región</a><?php else: ?><a onclick="buscarFecha(<?php echo"'$fechaCambiada'" ?>,'region', 'x');">Región</a><?php endif; ?>
    </li>
    <?php if(!empty($dependencyName)): ?>
    <li>
        <span><?php echo ucwords(strtolower($dependencyName)); ?></span>
    </li>
    <?php endif; ?>
</div>

<div class="space-6"></div>



<table class="report table table-striped table-bordered table-hover">
    
    <thead>
        <tr>
            <th nowrap rowspan="2" class="center">
                <?php echo $titulo; ?>
            </th>

            <th colspan="2" class="center" title="Registro de Autoriades">
                Registro de Autoridades
            </th>

            <?php if($nivel=='estado'): ?>
            <th title="Director Registrado" rowspan="2" class="center">
                Acciones
            </th>     
            <?php endif; ?>
        </tr>
        
        <tr>
            <th class="center" title="Directores" colspan="2" >
                Directores
            </th>
        </tr> 
    </thead>
    <tbody>
        <?php if(empty($dataReport)){?>
        <tr>
            <td colspan="8">
                <div class="alertDialogBox" style="margin-top: 10px;">
                    <p>
                        No se han encontrado Registros.
                    </p>
                </div>
            </td>
        </tr>
        <?php }?>
        <?php if(!empty($dataReport)){?>
        <?php foreach ($dataReport as $data)
         { 
     ?>
                        
        <tr>
            <td class="center">
                        <?php if($nivel=='region'): ?><a onclick="buscarFecha(<?php echo"'$fechaCambiada'" ?>,<?php echo "'$siguienteNivel'"; ?>, <?php echo $data['id']; ?>);"><?php echo ucwords(strtolower($data['nombre'])); ?></a><?php else: ?><span><?php echo ucwords(strtolower($data['nombre'])); ?></span><?php endif; ?>
                       
            </td>  
            <td class="center" colspan="2">
            <?php if((int)$data['cantidad_directores']!==0): ?><a  href="/control/directoresDiario/ReporteDetalladoDirectoresDiario/col/con_director_fecha/lev/<?php echo $nivel; ?>/dep/<?php echo ($nivel=='region' || $nivel=='municipio')?$data['id']:$data['id']; ?>/fecha/<?php echo $fechaCambiada; ?>"><?php echo ucwords(strtolower($data['cantidad_directores'])); ?></a><?php else: ?><span><?php echo ucwords(strtolower($data['cantidad_directores'])); ?></span><?php endif; ?>
            </td>
            <?php if($nivel=='estado'){ ?>
        
            <td class="center">
                <div class="action-buttons">
                    <a title="Datos de Contacto" data-id="<?php echo $data['id']; ?>" class="fa icon-user contact-data"></a>&nbsp;&nbsp;
                </div>
            </td>
        
            <?php }?>
        <?php }?>  
        </tr>

        <?php }?>
        
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('.contact-data').unbind('click');
        $('.contact-data').on('click',
                function(e) {
                    e.preventDefault();
                    var estado_id = $(this).attr('data-id');
                    verDatosContacto('zona_educativa', estado_id);
                }
        );        
    });
</script>






            
                

           