$(document).ready(function() {
    
    $.mask.definitions['~'] = '[+-]';
    $.mask.definitions['6'] = '[1-2]';
    
    //$('#Proveedor_rif').attr('readOnly', 'readOnly');
    //$('#Proveedor_rif_titular_cuenta').attr('readOnly', 'readOnly');
    
    $('.rifAcciones').click();
    
    $('.rifAcciones').bind('click', function() {

        if ($(this).attr('data-value') === "Natural") {
            $("#spanPersonaRif").html('Natural');
            $('#Proveedor_rif').mask('V-999999999');
            $("#Proveedor_rif").removeAttr('readonly');
            $('#Proveedor_rif').focus();
        } else if ($(this).attr('data-value') === "Jurídica") {
            $("#spanPersonaRif").html('Jurídica');
            $('#Proveedor_rif').mask('J-999999999');
            $("#Proveedor_rif").removeAttr('readonly');
            $('#Proveedor_rif').focus();
        } else if ($(this).attr('data-value') === "Gubernamental") {
            $("#spanPersonaRif").html('Gubern...');
            $('#Proveedor_rif').mask('G-999999999');
            $("#Proveedor_rif").removeAttr('readonly');
            $('#Proveedor_rif').focus();
        }else {
            $("#Proveedor_rif").val('');
            $("#Proveedor_rif").attr('readonly', 'readonly');
        }
        
    });

    //$('#Proveedor_ivss').mask('999999999');

    $("#Proveedor_razon_social").bind('keyup', function() {

        keyText(this, true);
    });

    $("#Proveedor_direccion").bind('keyup', function() {

        keyText(this, true);
    });

    $("#Proveedor_ivss").bind('keyup', function() {

        keyNum(this, true);
    });

    $("#Proveedor_titular_cuenta").bind('keyup', function() {

        keyText(this, true);
    });

    $("#Proveedor_numero_cuenta").bind('keyup', function() {

        keyNum(this, true);
    });

    $("#Proveedor_capital_social").bind('keyup', function() {

        keyNum(this, true);
    });

    $("#Proveedor_nil").attr('readonly', true);
    $("#Proveedor_nil").attr('required', true);

    $("#Proveedor_ivss").attr('readonly', true);
    $("#Proveedor_ivss").attr('required', true);

    $("#Proveedor_snc").attr('readonly', true);
    $("#Proveedor_snc").attr('required', true);

    $("#Proveedor_banavih").attr('readonly', true);
    $("#Proveedor_banavih").attr('required', true);

    $("#Proveedor_inces").attr('readonly', true);
    $("#Proveedor_inces").attr('required', true);

    $("#Proveedor_solvencia_laboral").attr('readonly', true);
    $("#Proveedor_solvencia_laboral").attr('required', true);

    $('#Proveedor_telefono_local').mask('(0299) 999-9999');
    $('#Proveedor_telefono_celular').mask('(0469) 999-9999');


    $('.ivssAcciones').bind('click', function() {

        if ($(this).attr('data-value') === "NO TIENE") {

            $("#Proveedor_ivss").val('NO TIENE');
            $("#Proveedor_ivss").attr('readonly', true);

        } else if ($(this).attr('data-value') === "EN TRAMITE") {

            $("#Proveedor_ivss").val('EN TRAMITE');
            $("#Proveedor_ivss").attr('readonly', true);

        } else {
            $("#Proveedor_ivss").val('');
            $("#Proveedor_ivss").attr('readonly', false);
            $("#Proveedor_ivss").attr('required', true);

        }


    });

    $('.rifTitularAcciones').bind('click', function() {

        if ($(this).attr('data-value') === "Natural") {
            $("#spanTitularRif").html('Natural');
            $('#Proveedor_rif_titular_cuenta').mask('V-999999999');
            $("#Proveedor_rif_titular_cuenta").removeAttr('readonly');
            $('#Proveedor_rif_titular_cuenta').click();
        } else if ($(this).attr('data-value') === "Jurídica") {
            $("#spanTitularRif").html('Jurídica');
            $('#Proveedor_rif_titular_cuenta').mask('J-999999999');
            $("#Proveedor_rif_titular_cuenta").removeAttr('readonly');
            $('#Proveedor_rif_titular_cuenta').click();
        } else if ($(this).attr('data-value') === "Gubernamental") {
            $("#spanTitularRif").html('Gubern...');
            $('#Proveedor_rif_titular_cuenta').mask('G-999999999');
            $("#Proveedor_rif_titular_cuenta").removeAttr('readonly');
            $('#Proveedor_rif_titular_cuenta').click();
        } else {
            $("#Proveedor_rif_titular_cuenta").val('');
            $("#Proveedor_rif_titular_cuenta").attr('readonly', 'readonly');
        }


    });

    $('.nilAcciones').bind('click', function() {

        if ($(this).attr('data-value') === "NO TIENE") {
            $("#Proveedor_nil").val('NO TIENE');
            $("#Proveedor_nil").attr('readonly', true);

        } else if ($(this).attr('data-value') === "EN TRAMITE") {
            $("#Proveedor_nil").val('EN TRAMITE');
            $("#Proveedor_nil").attr('readonly', true);

        } else if ($(this).attr('data-value') === "SI POSEE") {
            $("#Proveedor_nil").val('');
            $("#Proveedor_nil").attr('readonly', false);
            $('#Proveedor_nil').mask('999999-9');
            $("#Proveedor_nil").attr('required', true);

        }

    });
    $('.incesAcciones').bind('click', function() {

        if ($(this).attr('data-value') === "NO TIENE") {
            $("#Proveedor_inces").val('NO TIENE');
            $("#Proveedor_inces").attr('readonly', true);

        } else if ($(this).attr('data-value') === "EN TRAMITE") {
            $("#Proveedor_inces").val('EN TRAMITE');
            $("#Proveedor_inces").attr('readonly', true);

        } else if ($(this).attr('data-value') === "SI POSEE") {
            $("#Proveedor_inces").val('');
            $("#Proveedor_inces").attr('readonly', false);
            $('#Proveedor_inces').mask('999999999');
            $("#Proveedor_inces").attr('required', true);

        }

    });

    $('.banavihAcciones').bind('click', function() {

        if ($(this).attr('data-value') === "NO TIENE") {
            $("#Proveedor_banavih").val('NO TIENE');
            $("#Proveedor_banavih").attr('readonly', true);

        } else if ($(this).attr('data-value') === "EN TRAMITE") {
            $("#Proveedor_banavih").val('EN TRAMITE');
            $("#Proveedor_banavih").attr('readonly', true);

        } else if ($(this).attr('data-value') === "SI POSEE") {
            $("#Proveedor_banavih").val('');
            $("#Proveedor_banavih").attr('readonly', false);
            $('#Proveedor_banavih').mask('99999999');
            $("#Proveedor_banavih").attr('required', true);

        }

    });

    $('.sncAcciones').bind('click', function() {

        if ($(this).attr('data-value') === "NO TIENE") {
            $("#Proveedor_snc").val('NO TIENE');
            $("#Proveedor_snc").attr('readonly', true);

        } else if ($(this).attr('data-value') === "EN TRAMITE") {
            $("#Proveedor_snc").val('EN TRAMITE');
            $("#Proveedor_snc").attr('readonly', true);

        } else if ($(this).attr('data-value') === "SI POSEE") {
            $("#Proveedor_snc").val('');
            $("#Proveedor_snc").attr('readonly', false);
            $("#Proveedor_snc").attr('required', true);
            $('#Proveedor_snc').mask('9999999999999999');
        }

    });

    $('.solvenciaLaboralAcciones').bind('click', function() {

        if ($(this).attr('data-value') === "NO TIENE") {
            $("#Proveedor_solvencia_laboral").val('NO TIENE');
            $("#Proveedor_solvencia_laboral").attr('readonly', true);

        } else if ($(this).attr('data-value') === "EN TRAMITE") {
            $("#Proveedor_solvencia_laboral").val('EN TRAMITE');
            $("#Proveedor_solvencia_laboral").attr('readonly', true);

        } else if ($(this).attr('data-value') === "SI POSEE") {
            $("#Proveedor_solvencia_laboral").val('');
            $("#Proveedor_solvencia_laboral").attr('readonly', false);
            $("#Proveedor_solvencia_laboral").attr('required', true);
            $('#Proveedor_solvencia_laboral').mask('999-9999-99-99999');

        }

    });

});



function VentanaDialog(id, direccion, title, accion, datos) {

    accion = accion;
    Loading.show();
    var data = {id: id, datos: datos};
    if (accion === "borrar") {

        $("#dialogPantalla").html('<div class="alert alert-warning"> ¿Desea inactivar este proveedor?</div>');

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
                    "class": "btn btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; inactivar ",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/proveedor/proveedor/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#proveedor-grid').yiiGridView('update', {
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

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Desea activar este Proveedor? </p></div>');

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
                    "class": "btn btn-xs orange",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-check bigger-110'></i>&nbsp; Reactivar",
                    "class": "btn btn-success btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/proveedor/proveedor/" + accion + "/";
                        var datos = {id: id, accion: accion};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#proveedor-grid').yiiGridView('update', {
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