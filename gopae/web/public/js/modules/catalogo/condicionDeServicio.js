
$(document).on('ready', function() {

    
    $('#nombrecondicion').bind('keyup blur', function() {
         keyLettersAndSpaces(this,true);

         makeUpper(this);
    });
    

});

/* Se usan en Modificar elimar,activar,consular o crear condiciones de Servicio  */

function condicionDeServicio(id,identificador) {
    
    direccion = '/catalogo/condicionServicio/ConsultarCondicionDeServicio';
    
    Loading.show();
    var data =
            {
                id: id,
                identificador: identificador
        
            };
    $.ajax({
        url: direccion,
        data: data,
        dataType: 'html',
        type: 'POST',
        success: function(result)
        {
            var botones = new Array();
            
            if(identificador=='1'){ //Consultar
                title = 'Consulta de Condiciones de Servicio ';
                var dialog = $("#dialogPantalla").removeClass('hide')
                botones = [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs",
                        click: function() {
                            $(this).dialog("close");
                        }
                    }
                ];
            }
            else if(identificador=='2'){ //editar 
                title = 'Actualizar de Condiciones de Servicio ';
                var dialog = $("#dialogPantalla").removeClass('hide')
                botones = [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs",
                        click: function() {
                            $(this).dialog("close");
                        }
                    },                        
                    {
                        html: "<i class='icon-save bigger-110'></i>&nbsp; Guardar",
                        "class": "btn btn-primary btn-xs",
                        click: function() {     
                            
                                var divResult = "dialogPantalla";
                                var urlDir = "/catalogo/condicionServicio/actualizar";
                                var datos = $("#plantel-form").serialize();
                                var conEfecto = true;
                                var showHTML = true;
                                var method = "POST";
                                var responseFormat = "html";
                                var callback = function(){
                                    

                                    $('#condicion-servicio-grid').yiiGridView('update', {
                                        data: $(this).serialize()
                                    });
                                    
                                    
                                };

                                $("html, body").animate({ scrollTop: 0 }, "fast");
                                if(datos){
                                //$(this).dialog("close");
                                executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                }
                                
                                else{
                                    
                                $(this).dialog("close");    
                                }

                            
                        }
                    }
                ];
            }
            else if( identificador=='3' ){ // crear 

              title = 'Crear de Condiciones de Servicio '; 
               var dialog = $("#dialogPantalla").removeClass('hide');
                botones = [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs",
                        click: function() {

                            $(this).dialog("close");
                        }
                    },                        
                    {
                        html: "<i class='icon-save bigger-110'></i>&nbsp; Guardar",
                        "class": "btn btn-primary btn-xs",
                        click: function() {      
                                var divResult = "dialogPantalla";
                                var urlDir = "/catalogo/condicionServicio/create";
                                var datos = $("#plantel-form").serialize();
                                var conEfecto = true;
                                var showHTML = true;
                                var method = "POST";
                                var responseFormat = "html";
                                var callback = function(){
                                    $('#condicion-servicio-grid').yiiGridView('update', {
                                        data: $(this).serialize()
                                    });
                                   
                                };

                                $("html, body").animate({ scrollTop: 0 }, "fast");
                                if(datos){
                                executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
    
                                }
                                else{
                                     
                                $(this).dialog("close");    
                                }

                            
                        }
                    }
                ]
            //   });
            }
            
            else if( identificador=='4' ){ // Eliminar 
                
                title = 'Eliminar de Condiciones de Servicio ';
                 
                var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                   modal: true,
                   width: '450px',
                   dragable : false,
                   resizable: false,
                   position: ['center', 50],


                   title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
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
                   html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Condición de Servicio",
                   "class": "btn btn-danger btn-xs",
                   click: function() {
                                   var divResult = "dialogPantalla";
                                   var urlDir = "/catalogo/condicionServicio/ConsultarCondicionDeServicio";
                                   var datos = {id:id,
                                                identificador:'6'};
                                   var conEfecto = true;
                                   var showHTML = true;
                                   var method = "POST";
                                   var responseFormat = "html";
                                   var callback = function(){
                                       $('#condicion-servicio-grid').yiiGridView('update', {
                                           data: $(this).serialize()
                                       });
                                   };

                                   $("html, body").animate({ scrollTop: 0 }, "fast");
                                   if(datos){
                                   executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                    
                                   $(this).dialog("close");
                                   }
                               }
                           }
                       ]
                    });
                   }
                   else if (identificador=='5') // Activar
                   {
                      
                       
                    title = 'Activar Condiciones de Servicio ';
                   var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                   modal: true,
                   width: '450px',
                   draggable : false,
                   resizable: false,
                   position: ['center', 50],
                   title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
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
                   html: "<i class='fa icon-ok bigger-110'></i>&nbsp; Activar Condición de Servicio",
                   "class": "btn btn-success btn-xs",
                   click: function() {
                                   var divResult = "dialogPantalla";
                                   var urlDir = "/catalogo/condicionServicio/ConsultarCondicionDeServicio";
                                   var datos = {id:id,
                                                identificador:'7'};
                                   var conEfecto = true;
                                   var showHTML = true;
                                   var method = "POST";
                                   var responseFormat = "html";
                                   var callback = function(){
                                       $('#condicion-servicio-grid').yiiGridView('update', {
                                           data: $(this).serialize()
                                       });
                                   };

                                   $("html, body").animate({ scrollTop: 0 }, "fast");
                                   if(datos){
                                   executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                    
                                   $(this).dialog("close");
                                   }
                               }
                           }
                       ]
                    
                    });

                   }
                   if(identificador!=='4' && identificador !=='5'){
                        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                        modal: true,
                        width: '450px',
                        dragable: false,
                        position: ['center', 50],
                        resizable: false,
                      
                        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-home'></i> " + title + "</h4></div>",
                        title_html: true,
                        buttons: botones,
                        close: function() {
                           $("#dialog-group").html("");
                        }
                        });
                    }   
                    $("#dialogPantalla").html(result);                                     
                    
               }
    });
                                           
    
    Loading.hide();

}
