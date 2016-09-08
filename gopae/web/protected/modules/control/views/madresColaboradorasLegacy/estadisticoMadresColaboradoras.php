<table class="report table table-striped table-bordered table-hover">

    <thead>
        <tr>
            <th nowrap rowspan="2" class="center">
                <?php echo $titulo; ?>
            </th>
            <th title="Total de Madres Colaboradoras" rowspan="2" class="center">
                Total
            </th>
            <th title="Madres Colaboradoras Registradas en Noviembre 2013" class="center">
                Noviembre
            </th>
            <th title="Madres Colaboradoras Registradas en Enero 2014" class="center">
                Enero
            </th>
            <th title="Madres Colaboradoras Registradas en Febrero 2014" class="center">
                Febrero
            </th>
            <th title="Madres Colaboradoras Registradas en Marzo 2014" class="center">
                Marzo
            </th>
            <th title="Madres Colaboradoras Registradas en Abril 2014" class="center">
                Abril
            </th>
            <th title="Madres Colaboradoras Registradas en Mayo 2014" class="center">
                Mayo
            </th>
            <th title="Madres Colaboradoras Registradas en Junio 2014" class="center">
                Junio
            </th>
            <th title="Madres Colaboradoras Registradas en Julio 2014" class="center">
                Julio
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if(empty($dataReport)): ?>
        <tr>
            <td colspan="10">
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
                elseif($nivel=='estadoTotal'){
                    $dependencyId = 0;
                }

            }else{
                $dependencyId = $data['id'];
            }
        ?>

        <tr>
            <td class="center">
                <?php if($nivel=='region' && strtolower($data['nombre'])!='total'): ?>
                    <a onclick="reporteEstadistico(<?php echo "'$siguienteNivel'"; ?>, <?php echo $data['id']; ?>);"><?php echo ucwords(strtolower($data['nombre'])); ?></a>
                <?php elseif(($nivel=='estado') && strtolower($data['nombre'])!='total'): ?>
                    <a onclick="reporteEstadistico(<?php echo "'$siguienteNivel'"; ?>, <?php echo $data['id']; ?>);"><?php echo ucwords(strtolower($data['nombre'])); ?></a>
                <?php elseif(($nivel=='estadoTotal') && strtolower($data['nombre'])!='total'): ?>
                    <a onclick="return false;"><?php echo ucwords(strtolower($data['nombre'])); ?></a>
                <?php elseif(strtolower($data['nombre'])=='total'): ?>
                    <a><b><?php echo ucwords(Utiles::strtolower_utf8($data['nombre'])); ?></b></a>
                <?php else: ?>
                    <span><?php echo ucwords(Utiles::strtolower_utf8($data['nombre'])); ?></span>
                <?php endif; ?>
            </td>
            <td class="center">
                <a href="/control/madresColaboradorasLegacy/reporteDetalladoNominaLegacy/col/madres/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['madres']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/madresColaboradorasLegacy/reporteDetalladoNominaLegacy/col/11/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['noviembre']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/madresColaboradorasLegacy/reporteDetalladoNominaLegacy/col/1/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['enero']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/madresColaboradorasLegacy/reporteDetalladoNominaLegacy/col/2/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['febrero']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/madresColaboradorasLegacy/reporteDetalladoNominaLegacy/col/3/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['marzo']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/madresColaboradorasLegacy/reporteDetalladoNominaLegacy/col/4/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['abril']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/madresColaboradorasLegacy/reporteDetalladoNominaLegacy/col/5/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['mayo']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/madresColaboradorasLegacy/reporteDetalladoNominaLegacy/col/6/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['junio']; ?>
                </a>
            </td>
            <td class="center">
                <a href="/control/madresColaboradorasLegacy/reporteDetalladoNominaLegacy/col/7/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>">
                    <?php echo $data['julio']; ?>
                </a>
            </td>
        </tr>

        <?php endforeach; ?>

        <?php endif; ?>
    </tbody>

</table>
<span class="small">Reporte: <?php echo date("d-m-Y H:i:s"); ?></span>