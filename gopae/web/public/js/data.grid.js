/**
 * Indica si se está haciendo o no una búsqueda
 */
var _isSearch = new String("false");

/**
 * Indica el número de página en un grupo de registros listados y paginados
 */
var _page = new String("1");

/**
 * Indica el número de registros que se mostrarán por páginas
 */
var _rows = new String("10");

/**
 * Indica el nombre del campo por el que se desea buscar
 */
var _searchCriteria = new String("");

/**
 * Indica la operación de búsqueda
 */
var _searchOper = new String("eq");

/**
 * Indica el parámetro de búsqueda
 */
var _searchParameter = new String("");

/**
 * Indica el nombre del campo por el que se ordenará los registros listados
 */
var _sortField = new String("id");

/**
 * Indica el tipo orden que tendran el grupo de registros ASC DESC
 */
var _gridDirection = new String("ASC");

/**
 * 
 * @param String form_paginate Id attribute Form's
 * @param String url_controller Se supone que en la URL viene la pagina
 * @param String div_string Id attribute Div's where you want to show the table grid
 * @returns Integer
 */
function sinnerGrid(form_paginate, url_controller, div_string){

        var isSearch = $("#"+form_paginate+" input#isSearch").val();
        var searchCriteria = $("#"+form_paginate+" input#searchCriteria").val();
        var searchParameter = $("#"+form_paginate+" input#searchParameter").val();
        var sortField = $("#"+form_paginate+" input#sortField").val();
        var direction = $("#"+form_paginate+" input#direction").val();
        var rows = $("#"+form_paginate+" input#rows").val();
        
	if(isSearch===""){isSearch = _isSearch;}
	if(rows===""){rows = _rows;}
	if(sortField===""){sortField = _sortField;}
	if(direction===""){direction = _gridDirection;}
	_searchParameter = searchParameter;
	
	var datos = "&isSearch="+isSearch+"&sortField="+sortField+"&direction="+direction+"&rows="+rows+"&searchCriteria="+searchCriteria+"&searchParameter="+searchParameter;
        
	$.ajax({
            type: "POST",
            dataType: "html",
            data: datos,
            url: url_controller,
            success: function(datos){
                $("#"+div_string).html(datos).fadeIn("slow");
            }
	});
        
        return 0;
	
}

/**
 * @param Array headers Cabecera de la Tabla con los índices o keys de los datos pasados en dataResponse.response.data
 * @param Object dataResponse Datos a imprimir en la tabla
 * @param boolean paginate Indica si la tabla va a ser o no paginada
 * @param int rows Indica cuantas filas deben ser mostradas en cada página
 * @param int page Página actual
 * @param boolean indexed
 */
function printTableResponse(headers, dataResponse, paginate, rows, page, indexed) {

    var htmlResponse = '<div class"col-lg-12"><div class="space-6"></div></div><div class="row-fluid">';

    htmlResponse = htmlResponse + getDialogBox(dataResponse.class_style, dataResponse.message);

    htmlResponse = htmlResponse + '<table class="table table-striped table-bordered table-hover">';

    htmlResponse = htmlResponse + getHeaders(headers, indexed);

    htmlResponse = htmlResponse + getBody(headers, dataResponse.response.data, paginate, rows, page, indexed);

    htmlResponse = htmlResponse + '</table>';

    htmlResponse = htmlResponse + '</div>';

    currentPageT = page;

    $("#result-grid").html(htmlResponse).ready(function(){
        $(function () {
            $('[data-toggle="popover"]').popover();
        });
        $.gritter.add({
            title: 'Notificación',
            text: 'Para ver más detalle del resultado de la operación puede hacer click sobre el link de <b>Observación o Mensaje</b>.',
            sticky: false,
            time: '',
            class_name: 'gritter-warning'
        });
    });
    
    // console.log(page, totalRowsT, rowsInPageT);
    
    var options = getPaginationOptions(page, totalRowsT, rowsInPageT);
    
    printPagination(options);
}

function printPagination(options) {
    $('#div-pagination-grid').bootstrapPaginator(options);
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
    
    if(total>rowsP){

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
    }
    else{
        if(total==1){
            limit = total;
        }else if(total>1){
            limit = total-1;
        }
    }
    var registro = null;

    // console.log(offset);
    // console.log(limit);
    // console.log(data);
    // console.log(data.length);
    
    var dataToShow = "";
    var dataToShowShort = "";
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
                        dataToShow = new String(registro[header.key]);
                        dataToShow = dataToShow.replace('"','').replace("'", "");
                        dataToShowShort = dataToShow.substring(0, 50);
                        dataToShowShort = dataToShowShort.replace('"','').replace("'", "");
                        if(!containsHtml(dataToShow)){
                            if(dataToShow.length>50){
                                body = body + '    <td><a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Resultado" data-content="'+dataToShow.replace('"', "")+'">'+dataToShowShort+'...</a></td>';
                            }else{
                                body = body + '    <td>'+dataToShow+'</td>';
                            }
                        }else{
                            body = body + '    <td>'+dataToShow+'</td>';
                        }
                    }
                }

            };

            // console.log(i);

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
                printTableResponse(ajaxDataResponse, true, rowsInPageT, newPage, true);
            }
        }
    };

    return options;
}

function printTableAll() {

    if (dialogBoxCorpoelec != null) {
        dialogBoxCorpoelec.dialog("close");
    }

    var htmlTable = getDialogBox(ajaxDataResponse.class_style, ajaxDataResponse.message);

    var data = ajaxDataResponse.response.data;

    var registro = null;

    htmlTable = htmlTable + "<div class='space-6'></div>";

    htmlTable = htmlTable + "<table class='table table-striped table-bordered table-hover'><caption>Resultado de la Carga de Corpoelec</caption><thead>";

    htmlTable = htmlTable + "<tr><th>Localidad</th><th>Resultado</th><th>Mensaje</th></tr>";

    htmlTable = htmlTable + "</thead><tbody>";

    for (i = 0; i < data.length; i++) {

        registro = data[i];

        htmlTable = htmlTable + "<tr>";

        htmlTable = htmlTable + "<td>" + registro.localidad + "</td>";
        htmlTable = htmlTable + "<td>" + registro.resultado + "</td>";
        htmlTable = htmlTable + "<td>" + registro.mensaje + "</td>";

        htmlTable = htmlTable + "</tr>";

    }

    htmlTable = htmlTable + "</tbody></table>";

    $("#result-grid").html(htmlTable);

}
