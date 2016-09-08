<div class="breadcrumb row row-fluid" style="margin-left: 2px;">
    <li>
        <?php if($nivel=='region'): ?><a>Región</a><?php else: ?><a onclick="reporteEstadistico('region', 'x');">Región</a><?php endif; ?>
    </li>
    <?php if(!is_null($region)): ?>
    <li>
       <a title="Estados de la Región <?php echo ucwords(strtolower($region->nombre)); ?>" onclick="reporteEstadistico('estado', '<?php echo ucwords(strtolower($region->id)); ?>');">
           <?php echo ucwords(strtolower($region->nombre)); ?>
       </a>
    </li>
    <?php endif; ?>
    <?php if(!is_null($estado)): ?>
    <li>
        <a title="Municipios del Estado <?php echo ucwords(strtolower($estado->nombre)); ?>" onclick="reporteEstadistico('municipio', '<?php echo ucwords(strtolower($estado->id)); ?>');">
            <?php echo ucwords(strtolower($estado->nombre)); ?>
        </a>
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
            <th title="Total de Planteles" rowspan="2" class="center">
                Total
            </th>
            <th title="Planteles con Director Registrado" rowspan="2" class="center">
                Registrados
            </th>
            <th title="Porcentaje de Avance" rowspan="2" class="center">
                %
            </th>
            <th colspan="2" class="center" title="Directores de Planteles de Dependencia Nacional, Estadal o Municipal">
                Dir. Planteles Públicos
            </th>
            <th colspan="2" class="center" title="Directores de Planteles Privados">
                Dir. Planteles Privados
            </th>
            <th colspan="2" class="center" title="Directores de Planteles Subvencionados">
                Dir. Otros Planteles
            </th>
            <?php if($nivel=='estado'): ?>
            <th title="Planteles con Director Registrado" rowspan="2" class="center">
                Acciones
            </th>
            <?php endif; ?>
        </tr>
        <tr>
            <th class="center" title="Planteles de Dependencia Nacional, Estadal o Municipal Sin Director Registrado">
                No Registrados
            </th>
            <th class="center" title="Planteles de Dependencia Nacional, Estadal o Municipal Con Director Registrado">
                Registrados
            </th>
            <th class="center" title="Planteles Privados Sin Director Registrado">
                No Registrados
            </th>
            <th class="center" title="Planteles Privados Con Director Registrado">
                Registrados
            </th>
            <th class="center" title="Planteles Subvencionados Sin Director Registrado">
                No Registrados
            </th>
            <th class="center" title="Planteles Subvencionados Con Director Registrado">
                Registrados
            </th>
        </tr>
    </thead>
    
    <tbody>
        <?php if(empty($dataReport)): ?>
        <tr>
            <td colspan="11">
                <div class="alertDialogBox" style="margin-top: 10px;">
                    <p>
                        No se han encontrado Registros.
                    </p>
                </div>
            </td>
        </tr>
        <?php else: ?>
        
        <?php foreach ($dataReport as $data): ?>
        
        <?php 
            
            $avance = 0;
            if((int)$data['planteles']>0):
                $avance = ($data['con_director']*100)/$data['planteles'];
            endif;
            
            $dependencyId = 0;
            
            if(strtolower($data['nombre'])=='total'){
                
                if($nivel=='region'){
                    $dependencyId = 0;
                }
                elseif($nivel=='estado'){
                    $dependencyId = $data['region_id'];
                }
                elseif($nivel=='municipio'){
                    $dependencyId = $data['estado_id'];
                }
    
            }else{
                $dependencyId = $data['id'];
            }
        ?>
        
        <tr>
            <td class="center">
                <?php if($nivel=='region' && strtolower($data['nombre'])!='total'): ?>
                    <a onclick="reporteEstadistico(<?php echo "'$siguienteNivel'"; ?>, <?php echo $data['id']; ?>);"><?php echo ucwords(strtolower($data['nombre'])); ?></a>
                <?php elseif($nivel=='estado' && strtolower($data['nombre'])!='total'): ?>
                    <a onclick="reporteEstadistico(<?php echo "'$siguienteNivel'"; ?>, <?php echo $data['id']; ?>);"><?php echo ucwords(strtolower($data['nombre'])); ?></a>
                <?php elseif(strtolower($data['nombre'])=='total'): ?>
                    <a><b><?php echo ucwords(Utiles::strtolower_utf8($data['nombre'])); ?></b></a>
                <?php else: ?>
                    <span><?php echo ucwords(Utiles::strtolower_utf8($data['nombre'])); ?></span>
                <?php endif; ?>
            </td>
            <td class="center">
                <a href="/control/autoridadesPlantel/reporteDetalladoDirectores/col/planteles/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['planteles']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/autoridadesPlantel/reporteDetalladoDirectores/col/con_director/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['con_director']; ?>
                </a>
            </td>
            <td class="center">
                <a><?php echo number_format($avance,2,',','.'); ?></a>
            </td>
            <td class="center">
                <a href="/control/autoridadesPlantel/reporteDetalladoDirectores/col/publ_sin_director/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['publ_sin_director']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/autoridadesPlantel/reporteDetalladoDirectores/col/publ_con_director/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['publ_con_director']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/autoridadesPlantel/reporteDetalladoDirectores/col/priv_sin_director/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['priv_sin_director']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/autoridadesPlantel/reporteDetalladoDirectores/col/priv_con_director/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['priv_con_director']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/autoridadesPlantel/reporteDetalladoDirectores/col/otros_sin_director/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['otros_sin_director']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/autoridadesPlantel/reporteDetalladoDirectores/col/otros_con_director/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['otros_con_director']; ?>
                </a>
            </td>
            <?php if ($nivel == 'estado' && strtolower($data['nombre']) != 'total' && Yii::app()->user->pbac('admin')): ?>
            <td class="center">
                <div class="action-buttons">
                    <a title="Datos de Contacto" data-id="<?php echo $data['id']; ?>" class="fa icon-user contact-data"></a>&nbsp;&nbsp;
                    <a title="Registrar Observación" data-id="<?php echo $data['id']; ?>" data-estado="<?php echo $data['nombre']; ?>" class="fa fa-pencil green observ-data"></a>&nbsp;&nbsp;
                    <a title="Ver Registro de Control" data-id="<?php echo $data['id']; ?>" data-estado="<?php echo $data['nombre']; ?>" class="fa fa-file-text-o red rep-control"></a>
                </div>
            </td>
            <?php endif; ?>
        </tr>

        <?php endforeach; ?>
        
        <?php endif; ?>
    </tbody>
    
</table>
<span class="small">Reporte: <?php echo date("d-m-Y H:i:s"); ?></span>
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

        $('.observ-data').unbind('click');
        $('.observ-data').on('click',
                function(e) {
                    e.preventDefault();
                    var estado_id = $(this).attr('data-id');
                    var estado = $(this).attr('data-estado');
                    dialogObservacion(estado_id, estado);
                }
        );

        $('.rep-control').unbind('click');
        $('.rep-control').on('click',
                function(e) {
                    e.preventDefault();
                    var estado_id = $(this).attr('data-id');
                    var estado = $(this).attr('data-estado');
                    dialogRegistroControl('zona_educativa', estado_id, estado);
                }
        );
        
    });
</script>