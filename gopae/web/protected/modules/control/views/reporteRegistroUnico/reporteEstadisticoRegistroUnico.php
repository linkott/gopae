<div class="breadcrumb row row-fluid" style="margin-left: 2px;">

    <?php if(!is_null($estado)): ?>
        <li>
            <a title="Municipios del Estado <?php echo ucwords(strtolower($estado->nombre)); ?>" onclick="reporteRegistroUnico('municipio', '<?php echo ucwords(strtolower($estado->id)); ?>');">
                <?php echo ucwords(strtolower($estado->nombre)); ?>
            </a>
        </li>
    <?php endif; ?>
</div>
<div class=" PrintArea">

    <table class="report table table-striped table-bordered table-hover ">

        <thead>
        <tr>
            <th nowrap rowspan="2" class="center">
                <?php echo $titulo; ?>
            </th>
            <th title="Total de Planteles" class="center">
                Total de Planteles
                <a id="infoTotalPlanteles">
                    <i class="fa fa-question"></i>
                </a>
            </th>
            <th title="Total de Planteles Beneficiados por el CNAE" class="center">
                Total de Planteles CNAE
                <a id="infoTotalPlantelesCnae">
                    <i class="fa fa-question"></i>
                </a>
            </th>
            <th title="Autoridades Verificadas" class="center">
                Autoridades Verificadas
                <a id="infoTotalAutoridadesVerificadas">
                    <i class="fa fa-question"></i>
                </a>
            </th>
            <th title="Autoridades Verificadas" class="center">
                Autoridades Verificadas <BR>(Sin Fotogafía)
                <a id="infoTotalAutoridadesVerificadasSinFoto">
                    <i class="fa fa-question"></i>
                </a>
            </th>
            <th class="center" title="Cocineras Escolares">
                Total de Cocineras Escolares
                <a id="infoTotalCocinerasEscolares">
                    <i class="fa fa-question"></i>
                </a>
            </th>
            <th class="center" title="Cocineras Escolares Asignadas">
                Cocineras Escolares Asignadas
                <a id="infoTotalCocinerasEscolaresAsignadas">
                    <i class="fa fa-question"></i>
                </a>
            </th>
            <th title="Planteles Beneficiados por el Proveedor MERCAL" class="center">
                Planteles con MERCAL
                <a id="infoTotalPlantelesBeneficiadosPorMERCAL">
                    <i class="fa fa-question"></i>
                </a>
            </th>
            <th title="Planteles Beneficiados por el Proveedor PDVAL" class="center">
                Planteles con PDVAL
                <a id="infoTotalPlantelesBeneficiadosPorPDVAL">
                    <i class="fa fa-question"></i>
                </a>
            </th>
            <th title="Planteles Beneficiados por Proveedores Otros" class="center">
                Planteles con Otros
                <a id="infoTotalPlantelesBeneficiadosPorOtros">
                    <i class="fa fa-question"></i>
                </a>
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

    //            $avance = 0;
    //            if((int)$data['planteles']>0):
    //                $avance = ($data['con_director']*100)/$data['planteles'];
    //            endif;

                $dependencyId = 0;

                if(strtolower($data['nombre'])=='total'){


                    if($nivel=='estado'){
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
                        <?php if(strtolower($data['nombre'])=='total'): ?>
                            <a><b><?php echo ucwords(Utiles::strtolower_utf8($data['nombre'])); ?></b></a>
                        <?php else: ?>
                            <span><?php echo ucwords(Utiles::strtolower_utf8($data['nombre'])); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="center">
                        <a title="Total de Planteles" class="a-rep-registro-unico" data-href="/control/reporteRegistroUnico/reporteDetalladoRegistroUnico/col/planteles/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>/rows/<?php echo $data['planteles']; ?>">
                            <?php echo $data['planteles']; ?>
                        </a>
                    </td>
                    <td class="center">
                        <a title="Total de Planteles CNAE" class="a-rep-registro-unico" data-href="/control/reporteRegistroUnico/reporteDetalladoRegistroUnico/col/total_cnae/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>/rows/<?php echo $data['total_cnae']; ?>">
                            <?php echo $data['total_cnae']; ?>
                        </a>
                    </td>
                    <td class="center">
                        <a title="Autoridades Verificadas" class="a-rep-registro-unico" data-href="/control/reporteRegistroUnico/reporteDetalladoRegistroUnico/col/autoridades_verificados/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>/rows/<?php echo $data['autoridades_verificados']; ?>">
                            <?php echo $data['autoridades_verificados']; ?>
                        </a>
                    </td>
                    <td class="center">
                        <a title="Autoridades Verificadas (Sin Fotografía)" class="a-rep-registro-unico" data-href="/control/reporteRegistroUnico/reporteDetalladoRegistroUnico/col/autoridades_verificados_sin_foto/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>/rows/<?php echo $data['autoridades_verificados_sin_foto']; ?>">
                            <?php echo $data['autoridades_verificados_sin_foto']; ?>
                        </a>
                    </td>
                    <td class="center">
                        <a title="Cocineras Escolares" class="a-rep-registro-unico" data-href="/control/reporteRegistroUnico/reporteDetalladoRegistroUnico/col/cocineras_escolares/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>/rows/<?php echo $data['cocineras_escolares']; ?>">
                            <?php echo $data['cocineras_escolares']; ?>
                        </a>
                    </td>
                    <td class="center">
                        <a title="Cocineras Escolares Asignadas" class="a-rep-registro-unico" data-href="/control/reporteRegistroUnico/reporteDetalladoRegistroUnico/col/cocineras_escolares_asignadas/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>/rows/<?php echo $data['cocineras_escolares_asignadas']; ?>">
                            <?php echo $data['cocineras_escolares_asignadas']; ?>
                        </a>
                    </td>
                    <td class="center">
                        <a title="Planteles con MERCAL" class="a-rep-registro-unico" data-href="/control/reporteRegistroUnico/reporteDetalladoRegistroUnico/col/beneficiados_x_mercal/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>/rows/<?php echo $data['beneficiados_x_mercal']; ?>">
                            <?php echo $data['beneficiados_x_mercal']; ?>
                        </a>
                    </td>
                    <td class="center">
                        <a title="Planteles con PDVAL" class="a-rep-registro-unico" data-href="/control/reporteRegistroUnico/reporteDetalladoRegistroUnico/col/beneficiados_x_pdval/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>/rows/<?php echo $data['beneficiados_x_pdval']; ?>">
                            <?php echo $data['beneficiados_x_pdval']; ?>
                        </a>
                    </td>
                    <td class="center">
                        <a title="Planteles con Otros" class="a-rep-registro-unico" data-href="/control/reporteRegistroUnico/reporteDetalladoRegistroUnico/col/beneficiados_x_otros/lev/<?php echo (strtolower($data['nombre'])!='total')?$nivel:$anteriorNivel; ?>/dep/<?php echo $dependencyId; ?>/rows/<?php echo $data['beneficiados_x_otros']; ?>">
                            <?php echo $data['beneficiados_x_otros']; ?>
                        </a>
                    </td>

                </tr>

            <?php endforeach; ?>

        <?php endif; ?>
    </tbody>
</table>
<span class="small">
    Reporte de Registro Único: <?php echo date("d-m-Y H:i:s"); ?>
    <br/>
    Sistema de Gestión Operativa del CNAE
</span>
</div>
<script type="text/javascript">
$(document).ready(function(){

    $('.a-rep-registro-unico').on('click', function(evt){
        evt.preventDefault();
        location.href = $(this).attr('data-href');
    });

    $('#infoTotalPlanteles').on('click', function(){
        $.gritter.removeAll();
        $.gritter.add({
            title: 'Total de Planteles',
            text: 'Esta Columna indica la cantidad total de Planteles Registrados en el Sistema, teniendo como fuente el Registro de Planteles Públicos, Privados y Subvencionados del Sistema de Gestión Escolar.',
            class_name: 'gritter-info gritter-center'
        });
        return false;
    });
    $('#infoTotalPlantelesCnae').on('click', function(){
        $.gritter.removeAll();
        $.gritter.add({
            title: 'Total de Planteles Beneficiados por el CNAE',
            text: 'Esta Columna indica la cantidad total de Planteles Beneficiados por el CNAE Registrados en el Sistema, que cumplen con los singuientes criterios: <BR>'+
            "<ol>" +
            "<li>Debe Poseer codigo CNAE</li><li>Debe ser Beneficiario del CNAE</li><li>Su Matricula General debe ser mayor a 0 </li>" +
            "</ol>",
            class_name: 'gritter-info gritter-center'
        });
        return false;
    });
    $('#infoTotalAutoridadesVerificadas').on('click', function(){
        $.gritter.removeAll();
        $.gritter.add({
            title: 'Total de Autoridades Verificadas',
            text: 'Esta Columna indica la cantidad total de Autoridades Verificadas en el Sistema, que cumplen con los singuientes criterios: <BR>'+
            "<ol>" +
            "<li>Debe haber presentado su Documento de Identidad</li><li>Debe poseer una fotografia Registrada en el Sistema</li><li>Debe ser Director(a), Sub-Director(a) o Enlace CNAE de la Institucion Educativa</li>" +
            "</ol>",
            class_name: 'gritter-info gritter-center'
        });
        return false;
    });
    $('#infoTotalAutoridadesVerificadasSinFoto').on('click', function(){
        $.gritter.removeAll();
        $.gritter.add({
            title: 'Total de Autoridades Verificadas Sin Fotografía',
            text: 'Esta Columna indica la cantidad total de Autoridades Verificadas Sin Fotografía en el Sistema, que cumplen con los singuientes criterios: <BR>'+
            "<ol>" +
            "<li>Debe haber presentado su Documento de Identidad</li><li>\'No\' poser una fotografía Registrada en el Sistema</li><li>Debe ser Director(a), Sub-Director(a) o Enlace CNAE de la Institucion Educativa</li>" +
            "</ol>",
            class_name: 'gritter-info gritter-center'
        });
        return false;
    });

    $('#infoTotalCocinerasEscolares').on('click', function(){
        $.gritter.removeAll();
        $.gritter.add({
            title: 'Total de Cocineras Escolares',
            text: 'Esta Columna indica la cantidad total de Cocineras y Cocineros Escolares Registrados en el Sistema, que cumplen con los singuientes criterios: <BR>'+
            "<ol>" +
            "<li>Debe ser empleada(o) del CNAE como Cocinera(o) Escolar</li>" +
            "</ol>",
            class_name: 'gritter-info gritter-center'
        });
        return false;
    });
    $('#infoTotalCocinerasEscolaresAsignadas').on('click', function(){
        $.gritter.removeAll();
        $.gritter.add({
            title: 'Total de Cocineras Escolares Asignadas',
            text: 'Esta Columna indica la cantidad total de Cocineras y Cocineros Escolares Asignados a una Institucion Educativa através del Sistema, que cumplen con los singuientes criterios: <BR>'+
            "<ol>" +
            "<li>Debe ser empleada(o) del CNAE como Cocinera(o) Escolar</li><li>Deben de estar Asignadas a una Institucion Educativa</li>" +
            "</ol>",
            class_name: 'gritter-info gritter-center'
        });
        return false;
    });
    $('#infoTotalPlantelesBeneficiadosPorMERCAL').on('click', function(){
        $.gritter.removeAll();
        $.gritter.add({
            title: 'Planteles Beneficiados por el Proveedor MERCAL',
            text: 'Esta Columna indica la cantidad total de Planteles Beneficiados por el Proveedor MERCAL, que cumplen con los singuientes criterios: <BR>'+
            "<ol>" +
            "<li>Debe Poseer codigo CNAE</li><li>Debe ser Beneficiario del CNAE</li><li>Su Matricula General debe ser mayor a 0 </li>"+
            "<li>Deben estar Beneficiados por el Programa de Alimentación Escolar através de Red Alimenticia MERCAL</li>" +
            "</ol>",
            class_name: 'gritter-info gritter-center'
        });
        return false;
    });
    $('#infoTotalPlantelesBeneficiadosPorPDVAL').on('click', function(){
        $.gritter.removeAll();
        $.gritter.add({
            title: 'Planteles Beneficiados por el Proveedor PDVAL',
            text: 'Esta Columna indica la cantidad total de Planteles Beneficiados por el Proveedor PDVAL, que cumplen con los singuientes criterios: <BR>'+
            "<ol>" +
            "<li>Debe Poseer codigo CNAE</li><li>Debe ser Beneficiario del CNAE</li><li>Su Matricula General debe ser mayor a 0 </li>"+
            "<li>Deben estar Beneficiados por el Programa de Alimentación Escolar através de Red Alimenticia PDVAL</li>" +
            "</ol>",
            class_name: 'gritter-info gritter-center'
        });
        return false;
    });
    $('#infoTotalPlantelesBeneficiadosPorOtros').on('click', function(){
        $.gritter.removeAll();
        $.gritter.add({
            title: 'Planteles Beneficiados por Proveedores Otros',
            text: 'Esta Columna indica la cantidad total de Planteles Beneficiados por el CNAE Registrados en el Sistema, que cumplen con los singuientes criterios: <BR>' +
            "<ol>" +
            "<li>Debe Poseer codigo CNAE</li><li>Debe ser Beneficiario del CNAE</li><li>Su Matricula General debe ser mayor a 0 </li>"+
            "<li>Deben estar Beneficiados por el Programa de Alimentación Escolar através de Otros Proveedores distintos a MERCAL y PDVAL</li>" +
            "</ol>",
            class_name: 'gritter-info gritter-center'
        });
    });

});

</script>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/css/PrintArea.css', CClientScript::POS_BEGIN); ?>
