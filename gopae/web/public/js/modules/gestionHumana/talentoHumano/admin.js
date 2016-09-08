$(document).ready(function() {

    $('#date-picker').datepicker();
    $.datepicker.setDefaults({
        dateFormat: 'dd-mm-yy',
        showOn: 'focus',
        showOtherMonths: false,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        minDate: new Date(1700, 1, 1),
        maxDate: 'today'
    });

    $('#TalentoHumano_cedula').bind('keyup blur', function() {
        keyNum(this, false);
        clearField(this);
    });

    $('#TalentoHumano_origen').bind('keyup blur', function() {
        keyText(this, true);
        clearField(this);
    });

    $('#TalentoHumano_nombre').bind('keyup blur', function() {
        keyAlphaNum(this, true);
    });

    $('#TalentoHumano_nombre').bind('blur', function() {
        clearField(this);
    });

    $('#TalentoHumano_apellido').bind('keyup blur', function() {
        keyAlphaNum(this, true);
    });

    $('#TalentoHumano_apellido').bind('blur', function() {
        clearField(this);
    });

});
