$(document).ready(function() {

    $('.look-data').unbind('click');
    $('.look-data').on('click',
            function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                ver(id);
            }
    );

    $('.change-status').unbind('click');
    $('.change-status').on('click',
            function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                var description = $(this).attr('data-description');
                var accion = $(this).attr('data-action');
                cambiarEstatus(id, description, accion);
            }
    );
    
    $('#UserGroupsUser_last_login').datepicker();
    $.datepicker.setDefaults($.datepicker.regional = {
        dateFormat: 'dd-mm-yy',
        showOn:'focus',
        showOtherMonths: false,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        minDate: new Date(1800, 1, 1),
        maxDate: 'today'
    });
    
    $('#UserGroupsUser_cedula').bind('keyup blur', function () {
        keyNum(this, false);
    });
    
    $('#UserGroupsUser_cedula').bind('blur', function () {
        clearField(this);
    });
    
    $('#UserGroupsUser_nombre').bind('keyup blur', function () {
        keyAlphaNum(this, true, true);
    });
    
    $('#UserGroupsUser_nombre').bind('blur', function () {
        clearField(this);
    });
    
    $('#UserGroupsUser_apellido').bind('keyup blur', function () {
        keyAlphaNum(this, true, true);
    });
    
    $('#UserGroupsUser_apellido').bind('blur', function () {
        clearField(this);
    });
    
    $('#UserGroupsUser_username').bind('keyup blur', function () {
        keyAlphaNum(this, true, true);
    });
    
    $('#UserGroupsUser_username').bind('blur', function () {
        clearField(this);
    });

});

/**
 * Esta función ejecuta mediante ajax la consulta de los datos de un Usuario
 * 
 * @param {type} id Id del Usuario
 * @returns {undefined}
 */
function ver(id) {
    
    var divResult = "dialog-user";
    var urlDir = "/userGroups/usuario/view/id/" + id;
    var datos = "";
    var loadingEfect = true;
    var showResult = true;
    var method = "GET";
    var responseFormat = "html";
    var beforeSend = null;
    var callback = function(response) {

        $(document).ready(function() {
            $('input[type=text]')
            $('input[type=text]').tooltip({
                show: {
                    effect: "slideDown",
                    delay: 250
                }
            });
        });
        
    };

    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, callback);

    $("#dialog-user").removeClass('hide').dialog({
        width: 900,
        height: 600,
        resizable: false,
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-search'></i> Usuarios </h4></div>",
        title_html: true,
        buttons: [
            {
                html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    $(this).dialog("close");
                }
            }
        ],
        close: function() {
            $("#dialog-user").html("");
        }
    });

}

function cambiarEstatusGrupo(id, descripction, accion) {
    
    var accionDes = new String();
    var boton = new String();
    var botonClass = new String();
    
    $('#confirm-description').html(descripction);
    
    if(accion==='A'){
        accionDes = 'Activar';
        boton = "<i class='icon-ok bigger-110'></i>&nbsp; Activar Usuario";
        botonClass = 'btn btn-primary btn-xs';
    }else{
        accionDes = 'Inactivar';
        boton = "<i class='icon-trash bigger-110'></i>&nbsp; Inactivar Usuario";
        botonClass = 'btn btn-danger btn-xs';
    }
    
    $(".confirm-action").html(accionDes);
    
    $("#confirm-status").removeClass('hide').dialog({
        width: 700,
        resizable: false,
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='icon-warning-sign red'></i> Cambio de Estatus de Usuario</h4></div>",
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
                html: boton,
                "class": botonClass,
                click: function() {
                    
                    var divResult = "div-result-message";
                    var urlDir = "/userGroups/usuario/cambiarEstatus/id/"+id;
                    var datos = "accion="+accion;
                    var loadingEfect = true;
                    var showResult = true;
                    var method = "POST";
                    var responseFormat = "html";
                    var beforeSend = null;
                    var callback = function(){
                        $('#user-user-grid').yiiGridView('update', {
                            data: $(this).serialize()
                        });
                    };

                    $("html, body").animate({ scrollTop: 0 }, "fast");

                    executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, callback);
                    
                    $(this).dialog("close");
                    
                }
            }
            
        ]
    });

}