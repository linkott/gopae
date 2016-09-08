function setUpEventsFilters() {

    var identificador = "TipoCargoNominal";

    $('#' + identificador + '_nombre').bind('keyup blur', function () {
        keyAlphaNum(this, true, true);
    });
    
    $('#' + identificador + '_descripcion, #' + identificador + '_funciones').bind('keyup blur', function () {
        keyText(this, true, true);
    });
    
    $('#' + identificador + '_codigo, #' + identificador + '_siglas').bind('keyup blur', function () {
        keyAlphaNum(this, false, false);
    });

    $('#' + identificador + '_nombre, #' + identificador + '_descripcion, #' + identificador + '_funciones').bind('blur', function () {
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
