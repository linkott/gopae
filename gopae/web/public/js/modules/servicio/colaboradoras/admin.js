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

    $('#Colaborador_cedula').bind('keyup blur', function() {
        keyNum(this, false);
        clearField(this);
    });

    $('#Colaborador_origen').bind('keyup blur', function() {
        keyText(this, true);
        clearField(this);
    });

    $('#Colaborador_nombre').bind('keyup blur', function() {
        keyAlphaNum(this, true);
    });

    $('#Colaborador_nombre').bind('blur', function() {
        clearField(this);
    });

    $('#Colaborador_apellido').bind('keyup blur', function() {
        keyAlphaNum(this, true);
    });

    $('#Colaborador_apellido').bind('blur', function() {
        clearField(this);
    });

});