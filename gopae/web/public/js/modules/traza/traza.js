function VentanaDialog(id,direccion,title,accion,datos) {
//poner primera en minuscula
   /* direccion = d;
    title = 'Consulta de plantel';

*/
accion=accion;
    Loading.show();
    var data =
            { 
                id: id,
                datos:datos
               
               


            };

       

     if(accion=="view"){

    $.ajax({
        url: direccion,
        data: data,
        dataType: 'html',
        type: 'GET',
        success: function(result,action)
        {
            var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                modal: true,
                width: '1100px',
                dragable: false,
                resizable: false,


                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
                title_html: true,
   
                        buttons: [
                        {   
                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                            "class": "btn btn-danger",
                            click: function() {
                                $(this).dialog("close");
                            }
                        },


                    ],


                        

                      
                   
                        });



                    
                         

                $("#dialogPantalla").html(result);
            }
        });
        Loading.hide();


    }

    }
    
    
    
    $(document).ready(function(){
    
    
    $('#date-picker').datepicker();
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
    
    $("#apertura_ticket").on('click', function(evt){
        evt.preventDefault();
        VentanaDialog('', '/ayuda/ticket/create', 'Ticket', 'create', '')
    });
    
    $('#Ticket_codigo').bind('keyup blur', function () {
        keyNum(this, false);
        clearField(this);
    });


    $('#Ticket_observacion').bind('keyup blur', function () {
        keyText(this, true);
    });

    $('#Ticket_observacion').bind('blur', function () {
        clearField(this);
    });
    
});

    

