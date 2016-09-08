function setUpEventsFilters() {

    var identificador = "TipoCargoNominal";

    $('#' + identificador + '_nombre, #' + identificador + '_codigo, #' + identificador + '_siglas').bind('keyup blur', function () {
        keyAlphaNum(this, true, true);
    });

    $('#' + identificador + '_nombre, #' + identificador + '_codigo, #' + identificador + '_siglas').bind('blur', function () {
        clearField(this);
    });
    
    $('#' + identificador + '_codigo, #' + identificador + '_siglas').bind('keyup blur', function () {
        makeUpper(this);
        clearField(this);
    });
}

$(document).ready(function () {
    setUpEventsFilters();
});


