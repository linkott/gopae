function setUpEventsFilters(){

	var identificador = "TipoSector";

	$('#'+identificador+'_nombre').bind('keyup blur', function() {
        makeUpper(this);
        keyAlpha(this, true, true);
    });

    $('#'+identificador+'_nombre').bind('blur', function() {
        clearField(this);
    });
}

$(document).ready(function(){
	setUpEventsFilters();
});