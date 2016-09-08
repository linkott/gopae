var ajaxResponseTitulo = {};
var currentPageT = 1;
var rowsInPageT = 10;
var totalPagesT = 1;
var totalRowsT = 0;

$(document).ready(function() {

    // console.log("FileUpload");

    $('#fileupload').fileupload({
        url: '/titulo/registro/uploadFile',
        acceptFileTypes: /(\.|\/)(xls|xlsx|ods)$/i,
        maxFileSize: 50000000, // 50MB
        singleFileUploads: true,
        autoUpload: true,
        process: [
            {
                action: 'load',
                fileTypes: /(\.|\/)(xls?x|ods)$/i,
                maxFileSize: 50000000 // 50MB
            },
            {
                action: 'resize',
                maxWidth: 1440,
                maxHeight: 900
            },
            {
                action: 'save'
            }
        ],
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            alert("Se ha producido un error en la carga del archivo.");
        }

    });

    $('#fileupload').bind('fileuploaddone', function(e, data) {
        var archivos = data.jqXHR.responseJSON.files;

        $("#notificacionArchivo").html("¡Archivo cargado con exito!");

        $.each(archivos, function(index, file) {

            var archivo = file.name;
            var token = $("#csrfToken").val();

            var divResult = "";
            var urlDir = "/titulo/registro/registroSeriales/";
            var datos = {
                archivo: archivo,
                csrfToken: token
            };
            var loadingEfect = false;
            var showResult = false;
            var method = "POST";
            var responseFormat = "json";

            var beforeSend = null;

            var callback = function() {
                // console.log(ajaxDataResponse);
                // console.log(ajaxDataResponse.response.data);
                ajaxResponseTitulo = ajaxDataResponse;
                var data = ajaxDataResponse.response.data;
                totalRowsT = data.length;
                if(rowsInPageT>0){
                    totalPagesT = Math.ceil(totalRowsT/rowsInPageT);
                }
                else{
                    totalPagesT = 1;
                }
                printTableResponse(ajaxDataResponse, true, rowsInPageT, currentPageT, true);
            };

            // divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, beforeSend, callback

            executeFormatedAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, beforeSend, callback);
        });
    });


});

function getFileExtension(name){

    var found = name.lastIndexOf('.') + 1;
    return (found > 0 ? name.substr(found) : "");

}


function printTableResponse(dataResponse, paginate, rows, page, indexed){

    var headers = [{
                        key: 'serial',
                        label: 'Serial'
                   },
                   {
                        key: 'mensaje',
                        label: 'Observación'
                   },
                   {
                        key: 'resultado',
                        label: 'Resultado'
                   }];

    var htmlResponse = '<div class"col-lg-12"><div class="space-6"></div></div><div class="row-fluid">';

    htmlResponse = htmlResponse + getDialogBox(dataResponse.class_style, dataResponse.message);

    htmlResponse = htmlResponse + '<table class="table table-striped table-bordered table-hover">'

    htmlResponse = htmlResponse + getHeaders(headers, indexed);

    htmlResponse = htmlResponse + getBody(headers, dataResponse.response.data, paginate, rows, page, indexed);

    htmlResponse = htmlResponse + '</table>';

    htmlResponse = htmlResponse + '</div>';

    currentPageT = page;

    $("#papel-moneda-grid").html(htmlResponse);

    options = getPaginationOptions(page, totalRowsT, rowsInPageT);

    printPagination(options);
}


/**
 *
 * Permite mostrar la cabecera de una tabla, dado un array de headers.
 *
 * @param array headers Arreglo de Objeto JSON que contiene los headers.
 *
 * @return String
 *
 **/
function getHeaders(headers, indexed){

    var countHeaders = headers.length;
    var header = null;
    var html = new String('<thead>');

    if(indexed){
        html = html + '<th id="head_index"><center>Nro.</center></th>';
    }

    for (var i = 0; i < headers.length; i++) {
        header = headers[i];
        html = html + '<th id="head_'+header.key+'"><center>'+header.label+'</center></th>';
    };

    html = html + '</thead>';

    return html;
}

/**
 * Permite mostrar el cuerpo de una tabla, dado una cantidad de registros. Puede ser paginada.
 *
 * @param array headers Arreglo de Objeto JSON que contiene los headers.
 * @param array data Arreglo de Objeto JSON que contiene los datos a mostrar en la tabla.
 * @param int rowsP Cantidad de Registros a mostrar por página.
 * @param int page Pagina que se va a mostrar
 * @param boolean paginate Indica si debe ser o no paginado
 *
 * @return String
 *
 **/
function getBody(headers, data, paginate, rowsP, page, indexed){

    if(rowsP>total){
        rowsP = total;
    }

    if(page<1){
        page = 1;
    }

    var html = new String('<tbody>');
    var total = data.length;
    var offset = 0;
    var limit = rowsP;
    var body = '';

    if(paginate){

        if(page>1){
            offset = (rowsP * (page-1));
        }

        if(rowsP<total){
            limit = offset + rowsP;
        }

        if(limit>total){
            limit = total-1;
        }

    }else{

        limit = total-1;

    }

    var registro = null;

    // console.log(offset);
    // console.log(limit);

    for (var i = offset; i < limit; i++) {

        if (typeof data[i] !== 'undefined') {

            registro = data[i];

            body = body + '<tr>';

            if(indexed){
                body = body + '    <td>'+((i*1)+1)+'</td>';
            }

            for (var j = 0; j < headers.length; j++) {

                if (typeof headers[j] !== 'undefined') {
                    header = headers[j];
                    // console.log(header);
                    // console.log(registro[header.key]);
                    if(registro[header.key] != null){
                        body = body + '    <td>'+registro[header.key]+'</td>';
                    }
                }

            };

            //console.log(i);

            body = body + '</tr>';

        }else{
            break;
        }

    };

    html = html + body + '</tbody>';
    return html;
}

function getPaginationOptions(currentPage, totalRows, rowsP){

    if(rowsP>totalRows){
        rowsP = totalRows;
    }

    var options = {
        currentPage: currentPageT,
        totalPages: totalPagesT,
        useBootstrapTooltip:true,
        bootstrapMajorVersion: 3,
        tooltipTitles: function (type, page, current) {
            switch (type) {
            case "first":
                return "Ir a la primera página";
            case "prev":
                return "Ir a la página anterior";
            case "next":
                return "Ir a la página siguiente";
            case "last":
                return "Ir a la última página";
            case "page":
                return "Ir a la página " + page;
            }
        },
        itemTexts: function (type, page, current) {
            switch (type) {
            case "first":
                return '<span title="Primera página">&#9668;&#9668;</span>';
            case "prev":
                return '<span title="Página Anterior">&#9668;</span>';
            case "next":
                return '<span title="Página Siguiente">&#9658;</span>';
            case "last":
                return '<span title="Última página">&#9658;&#9658;</span>';
            case "page":
                return '<span title="'+page+'">'+page+'</span>';
            }
        },
        onPageChanged: function(e,oldPage,newPage){
            if(oldPage!=newPage){
                printTableResponse(ajaxResponseTitulo, true, rowsInPageT, newPage, true);
            }
        }
    };

    return options;
}

function printPagination(options){
    $('#pagination-papel-moneda-grid').bootstrapPaginator(options);
}