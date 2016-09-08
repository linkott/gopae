$(document).ready(function(){

    $('input[type=text], select').tooltip();
    
    $('#groupname').bind('keyup blur', function () {
        keyAlphaNum(this, false, false);
        clearField(this);
        makeUpper(this);
    });
    
    $("#description").bind('keyup blur', function () {
        keyText(this, true);
    });
    
    $("#description").bind('blur', function(){
        clearField(this);
    });

});