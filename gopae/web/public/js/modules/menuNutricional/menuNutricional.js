$(document).ready(function() {
    $.mask.definitions['~'] = '[+-]';
    $.mask.definitions['6'] = '[1-2]';
    
      edit = $("#preparacion").val();
    $("#editor1").html(edit);


    $("#editor1").keyup(function() {

        cambio = $("#editor1").html();
        $("#preparacion").html(cambio);

    });
    
    /**********************/
    
 $('#MenuNutricional_precio_baremo, #MenuNutricional_precio_mercado,#MenuNutricional_calorias').bind('blur, keyup', function () {
  keyNum(this,true,false);
 });
    
    
    
  /**************DESDE AQUI CARGAMOS LAS FUNCIONALIDADES WIN******/




    function showErrorAlert(reason, detail) {
        var msg = '';
        if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
        }
        else {
            console.log("error uploading file", reason, detail);
        }
        $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
    }

    //$('#editor1').ace_wysiwyg();//this will create the default editor will all buttons

    //but we want to change a few buttons colors for the third style
    $('#editor1').ace_wysiwyg({
        toolbar:
                [
                    'font',
                    null,
                    'fontSize',
                    null,
                    {name: 'bold', className: 'btn-info'},
                    {name: 'italic', className: 'btn-info'},
                    {name: 'strikethrough', className: 'btn-info'},
                    {name: 'underline', className: 'btn-info'},
                    null,
                    {name: 'insertunorderedlist', className: 'btn-success'},
                    {name: 'insertorderedlist', className: 'btn-success'},
                    {name: 'outdent', className: 'btn-purple'},
                    {name: 'indent', className: 'btn-purple'},
                    null,
                    {name: 'justifyleft', className: 'btn-primary'},
                    {name: 'justifycenter', className: 'btn-primary'},
                    {name: 'justifyright', className: 'btn-primary'},
                    {name: 'justifyfull', className: 'btn-inverse'},
                    null,
                    {name: 'undo', className: 'btn-grey'},
                    {name: 'redo', className: 'btn-grey'}
                ],
        'wysiwyg': {
            fileUploadError: showErrorAlert
        }
    }).prev().addClass('wysiwyg-style1');



    $('#editor2').css({'height': '200px'}).ace_wysiwyg({
        toolbar_place: function(toolbar) {
            return $(this).closest('.widget-box').find('.widget-header').prepend(toolbar).children(0).addClass('inline');
        },
        toolbar:
                [
                    'bold',
                    {name: 'italic', title: 'Change Title!', icon: 'icon-leaf'},
                    'strikethrough',
                    null,
                    'insertunorderedlist',
                    'insertorderedlist',
                    null,
                    'justifyleft',
                    'justifycenter',
                    'justifyright'
                ],
        speech_button: false
    });


    $('[data-toggle="buttons"] .btn').on('click', function(e) {
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        var toolbar = $('#editor1').prev().get(0);
        if (which == 1 || which == 2 || which == 3) {
            toolbar.className = toolbar.className.replace(/wysiwyg\-style(1|2)/g, '');
            if (which == 1)
                $(toolbar).addClass('wysiwyg-style1');
            else if (which == 2)
                $(toolbar).addClass('wysiwyg-style2');
        }
    });




    //Add Image Resize Functionality to Chrome and Safari
    //webkit browsers don't have image resize functionality when content is editable
    //so let's add something using jQuery UI resizable
    //another option would be opening a dialog for user to enter dimensions.
    if (typeof jQuery.ui !== 'undefined' && /applewebkit/.test(navigator.userAgent.toLowerCase())) {

        var lastResizableImg = null;
        function destroyResizable() {
            if (lastResizableImg == null)
                return;
            lastResizableImg.resizable("destroy");
            lastResizableImg.removeData('resizable');
            lastResizableImg = null;
        }

        var enableImageResize = function() {
            $('.wysiwyg-editor')
                    .on('mousedown', function(e) {
                        var target = $(e.target);
                        if (e.target instanceof HTMLImageElement) {
                            if (!target.data('resizable')) {
                                target.resizable({
                                    aspectRatio: e.target.width / e.target.height,
                                });
                                target.data('resizable', true);

                                if (lastResizableImg != null) {//disable previous resizable image
                                    lastResizableImg.resizable("destroy");
                                    lastResizableImg.removeData('resizable');
                                }
                                lastResizableImg = target;
                            }
                        }
                    })
                    .on('click', function(e) {
                        if (lastResizableImg != null && !(e.target instanceof HTMLImageElement)) {
                            destroyResizable();
                        }
                    })
                    .on('keydown', function() {
                        destroyResizable();
                    });
        }

        enableImageResize();

    }


});



function VentanaDialog(id, direccion, title, accion, datos) {

    accion = accion;
    Loading.show();
    var data = {id: id, datos: datos};
    if (accion === "borrar") {

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey">¿Desea inactivar este Menú?</p></div>');

        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> " + title + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-warning btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; inactivar ",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/menuNutricional/menuNutricional/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#menu-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };
                        if (datos) {
                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, 'html', callback);
                            $(this).dialog("close");
                        }
                    }
                }
            ]
        });
        Loading.hide();
    }

    else if (accion === "activar") {

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Desea activar este Menú? </p></div>');

        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> " + title + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-warning btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-check bigger-110'></i>&nbsp; Reactivar",
                    "class": "btn btn-success btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/menuNutricional/menuNutricional/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#menu-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };

                        if (datos) {
                            executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, 'html', callback);
                            $(this).dialog("close");
                        }
                    }
                }
            ]
        });
        Loading.hide();
    }
}


function cambiarEstatus() {

    var id = $("id").val();
    var data = {id: id};
    var dialog = $("#dialogPantalla").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        dragable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar esta unidad de medida</h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                "class": "btn btn-xs orange",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Unidad de Medida",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    executeAjax('_borrar', '/catalogo/unidadMedida/borrar', data, false, true, 'POST', 'html');
                }
            }
        ]
    });


}