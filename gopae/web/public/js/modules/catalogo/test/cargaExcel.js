$(document).ready(function () {

    $("#archivo").on('submit', function(evt){
        evt.preventDefault();
    });

    $("#formCargaExcel").on('submit', function(evt){
        evt.preventDefault();        
        $("#").attr();
        cargarExcel(ruta);
    });
    
    

    
});


function cargarExcel(ruta){
    var divResult = "#divCargaExcel";
    var urlDir = "/test/cargaExcel/ver";
    var datos = {"ruta":ruta};
    var loadingEfect = true;
    var showResult = true;
    var method = "POST";
    var responseFormat = "json";
    var successCallback = function(event){

    };
    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
}

