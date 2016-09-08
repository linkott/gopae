function setUpEventsFilters(){

	var identificador = "TipoSerialCuenta";

	$('#'+identificador+'_nombre').bind('keyup blur', function() {
        keyAlpha(this, true, true);
        firstUpper(this);
    });

    $('#'+identificador+'_nombre').bind('blur', function() {
        clearField(this);
    });
}

$(document).ready(function(){
	setUpEventsFilters();
});