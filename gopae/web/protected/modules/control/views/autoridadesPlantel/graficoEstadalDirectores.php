<script type="text/javascript">

    $(function () {
        $('#resultado').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Control de Carga de Datos'
            },
            subtitle: {
                text: 'Registro de Directores de Planteles x Estado'
            },
            xAxis: {
                categories: [
                    <?php if(Yii::app()->user->pbac('control.autoridadesPlantel.admin')): ?>
                     "Amazonas"
                    ,"Anzoategui"
                    ,"Apure"
                    ,"Aragua"
                    ,"Barinas"
                    ,"Bolívar"
                    ,"Carabobo"
                    ,"Cojedes"
                    ,"Delta Amacuro"
                    ,"Dtto Capital"
                    ,"Falcón"
                    ,"Guarico"
                    ,"Lara"
                    ,"Mérida"
                    ,"Miranda"
                    ,"Monagas"
                    ,"Nva Esparta"
                    ,"Portuguesa"
                    ,"Sucre"
                    ,"Tachira"
                    ,"Trujillo"
                    ,"Vargas"
                    ,"Yaracuy"
                    ,"Zulia"
                    <?php else: ?>
                     "<?php echo Yii::app()->user->estadoName; ?>"
                    <?php endif; ?>
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Cantidad de Planteles'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:12px; font-weight: bold;">{point.key}</span><table class="tooltip-chart">',
                pointFormat:  '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                              '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Totales',
                data: [<?php echo $dataReport['totales']; ?>],
                color: '#990000'

            },
            {
                name: 'Faltantes',
                data: [<?php echo $dataReport['faltantes']; ?>],
                color: '#0D233A'

            },
            {
                name: 'Registrados',
                data: [<?php echo $dataReport['registrados']; ?>],
                color: '#8BBC21'

            },
            {
                name: '% Avance',
                data: [<?php echo $dataReport['avances']; ?>]

            }]
        });
    });

</script>