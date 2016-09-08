

function setUpEventsFilters(){
	var identificador = "SociedadMercantil";

	$('#'+identificador+'_nombre').bind('keyup blur', function() {
        keyAlpha(this, true, true);
    });

    $('#'+identificador+'_nombre').bind('blur', function() {
        clearField(this);
    });

    $('#'+identificador+'_siglas').bind('keyup blur', function() {
        makeUpper(this);
        keyAlpha(this, true, true);
    });

    $('#'+identificador+'_siglas').bind('blur', function() {
        clearField(this);
    });
}

$(document).ready(function(){
	setUpEventsFilters();
});