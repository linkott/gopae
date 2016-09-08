$(document).ready(function() {
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $.datepicker.setDefaults($.datepicker.regional = {
        dateFormat: 'dd-mm-yy',
        'showOn': 'focus',
        'showOtherMonths': false,
        'selectOtherMonths': true,
        'changeMonth': true,
        'changeYear': true,
        minDate: new Date(1999, 1, 1),
        maxDate: 'today'
    });
    $('#fecha_desde').datepicker();
    $('#fecha_desdeMod').datepicker();

    ///// Validaciones del formulario plantel-form //////////////////////////////////
    $('#Plantel_cod_estadistico').bind('keyup blur', function() {
        keyNum(this, false);
    });
    $('#Plantel_cod_estadistico_view').bind('keyup blur', function() {
        keyNum(this, false);
    });

    $('#Plantel_telefono_fijo').bind('keyup blur', function() {
        keyNum(this, false);
    });

    $('#Plantel_telefono_otro').bind('keyup blur', function() {
        keyNum(this, false);
    });

    $('#Plantel_nfax').bind('keyup blur', function() {
        keyNum(this, false);
    });

    $('#Plantel_cod_plantel').bind('keyup blur', function() {
        keyAlphaNum(this, false);
    });

    $('#Plantel_cod_plantel_view').bind('keyup blur', function() {
        keyAlphaNum(this, false);
    });

    $('#cod_plantelNer').bind('keyup blur', function() {
        keyAlphaNum(this, false);
    });

    ////////////////////////// Fin //////////////////////////////////////////////////


});
/* Se usan en Modificar Plantel */

function consultarPlantel(id) {

    direccion = 'consultar/consultarPlantel';
    title = 'Consulta de plantel';

    Loading.show();
    var data =
            {
                id: id
            };
    $.ajax({
        url: direccion,
        data: data,
        dataType: 'html',
        type: 'GET',
        success: function(result)
        {
            var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                modal: true,
                width: '1100px',
                dragable: false,
                resizable: false,
                position: 'top',
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
                title_html: true
            });
            $("#dialogPantalla").html(result);
        }
    });
    Loading.hide();
}
