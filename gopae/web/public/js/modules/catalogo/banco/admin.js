function setUpEventsFilters() {

    var identificador = "Banco";

    $('#' + identificador + '_nombre').bind('keyup blur', function () {
        keyAlpha(this, true, true);
    });

    $('#' + identificador + '_nombre').bind('blur', function () {
        clearField(this);
    });
}

$(document).ready(function () {
    setUpEventsFilters();
});