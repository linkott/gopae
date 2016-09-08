<script type="text/javascript">

    $(function () {
        $('#resultado').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Control de Nomina Madres Colaboradoras Legacy'
            },
            subtitle: {
                text: 'Registro de Madres Colaboradoras x Estado'
            },
            xAxis: {
                categories: [
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
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Registro de Madres Colaboradoras'
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
                name: 'Noviembre',
                data: [<?php echo $dataReport['noviembre']; ?>],
                color: '#0D233A'

            },
            {
                name: 'Enero',
                data: [<?php echo $dataReport['enero']; ?>],
                color: '#8BBC21'

            },
            {
                name: 'Mayo',
                data: [<?php echo $dataReport['mayo']; ?>]
            },
            {
                name: 'Junio',
                data: [<?php echo $dataReport['junio']; ?>]
            }]
        });
    });

</script>