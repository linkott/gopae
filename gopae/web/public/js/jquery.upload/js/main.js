/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';
var id=$("#modelo").val();
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        
        url: '/fundamentoJuridico/fundamentoJuridico/upload?id='+id,
        acceptFileTypes: /(\.|\/)(jpe?g|png|pdf|doc|opt)$/i
    });

  
    
     
        
        
    

});
$('#fileupload').on('fileuploaddone', function(e, data) {
//console.debug(data);
$.each(data.result, function (index, file) {
console.debug(file);
var datos = file[0];
$.ajax({
type: "POST",
dataType: "html",
data: datos,
url: "file.php",
success: function(datos){
$("#result_callback").html(datos).fadeIn("slow");
}
});
});
});
