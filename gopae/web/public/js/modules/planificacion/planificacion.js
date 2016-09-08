    jQuery(function($) {
    
    $('#planificarPeriodo').click(function() {
        var title = 'Planificar Periodo';
        var dialog = $("#dialogPantallaPlanificar").removeClass('hide').dialog({
            modal: true,
            width: '600px',
            dragable: false,
            resizable: false,
            //position: 'top',
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'>" + title + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }

                },
                {
                    html: "<i class='icon-save info bigger-110'></i>&nbsp; Planificar",
                    "class": "btn btn-success btn-xs",
                    "id": "planificar",
                    click: function() {
                        Loading.show();
                        $.ajax({
                            url: '/planificacion/planificacion/planificarPeriodo',
                            success: function(data){
                                if(data == 1){
                                    $("#planificarPeriodo").addClass('hide');
                                    $('#calendar').fullCalendar('next');
                                    if($('#calendar').fullCalendar('prev')){
                                        Loading.hide();
                                    }
                                }
                            }
                        });
                        $(this).dialog("close");
                    }
                }
            ]
        });
    });
    
    $('#mesSiguiente').click(function() {
        var mes = $('#mesActual').text();
        var date = $('#calendar').fullCalendar('getDate');
        var getMes = date.getMonth() + 1;
        $("#mesEvents").text(getMes);
        $('#calendar').fullCalendar('next');
    });
    
    $('#mesAnterior').click(function() {
        $('#calendar').fullCalendar('prev');
    });

        /* initialize the external events
         -----------------------------------------------------------------*/

        $('#external-events div.external-event').each(function() {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });

        /* initialize the calendar
         -----------------------------------------------------------------*/

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        
        var calendar = $('#calendar').fullCalendar({
            disableDragging: true,
            weekends: false,
            header: {
                left: 'title',//'prev,next',
                center: '', //'title',
                right: '',//'month' //agendaWeek,agendaDay
            },
            events: "/planificacion/planificacion/todosEventos/" + $("#url").text(),
//                cache: true
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function(date, allDay) { // this function is called when something is dropped
            },
            selectable: false,
            selectHelper: true,
            select: function(start, end, allDay) {
                
                start = (new Date(start)).toISOString().slice(0, 10);
                fecha = start.split("-");
                start = fecha[2] + "-" + fecha[1] + "-" + fecha[0];
                
                $("#mensajeAlerta").addClass('hide');
                $("#mensajeAlertaSuccess").addClass('hide');

                $.ajax({
                url: '/planificacion/planificacion/actualizarPlanificacion',
                data: 'plantel_id=' + plantel_id,
                type: "POST",
//                dataType: 'json',
                success: function(data) {
//                    alert(json.value);
                    $("#tipoMenu").html(data);
                    $("#menu").html('<option value="">- - -</option>');
                }
                });
                
                var title = 'Agregar Planificación';

            }
            ,
            eventClick: function(calEvent, jsEvent, view) {
                
//                start = calEvent.start;
//                start = (new Date(start)).toISOString().slice(0, 10);
//                fecha = start.split("-");
//                start = fecha[2] + "-" + fecha[1] + "-" + fecha[0];

//        alert('Event: ' + calEvent.title);
//        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
//        alert('View: ' + view.name);
                
                
//                console.log(calEvent);
                var openVista = '<div class="widget-box"><div class="widget-header"><h5>Planificaci&oacute;n</h5><div class="widget-toolbar"><a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a></div></div><div class="widget-body"><div class="widget-body-inner" style="display: block;"><div class="widget-main"><a href="#" class="search-button"></a><div style="display:block" class="search-form"><div class="widget-main form">';
                var closeVista = '</div><!-- search-form --></div><!-- search-form --></div></div></div></div>';
                $.ajax({
                url: '/planificacion/planificacion/detallesPlanificacion',
                data: '&planificacion_id=' + calEvent.id,
                type: "POST",
                dataType: 'json',
                success: function(json) {
//                    alert(json.nombre);
//                    console.log(json);
                    $("#dialogPantalla").html(openVista + '<div class="row">\n\
                        <div class="col-sm-12">Menú Nutricional</div>\n\
                        <div class="col-sm-12"><input type="text" value="' + json.nombre + '" readOnly class="span-12"></div><br><br><br>\n\
                        <div class="col-sm-6">Tipo de Menú</div>\n\
                        <div class="col-sm-6">Calorías</div>\n\
                        <div class="col-sm-6"><input type="text" value="' + json.tipoMenu + '" readOnly class="span-12"></div>\n\
                        <div class="col-sm-6"><input type="text" value="' + json.calorias + '" readOnly class="span-12"></div>\n\
                        <br><br><br>Preparación<br><div class="col-sm-12" style="border:1px solid #CCC;">' + json.preparacion + '</div></div>' + closeVista);
                        if(json.estatus == 'A'){
                            $("#eliminar").removeClass("hide");
                        }
                    }
                });
                
                var title = 'Consultar Planificación';
                var dialog = $("#dialogPantalla").removeClass('hide').dialog({
                    modal: true,
                    width: '800px',
                    dragable: false,
                    resizable: false,
                    //position: 'top',
                    title: "<div class='widget-header widget-header-small'><h4 class='smaller'>" + title + "</h4></div>",
                    title_html: true,
                    buttons: [
                        {
                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                            "class": "btn btn-danger btn-xs",
                            click: function() {
                                $(this).dialog("close");
                            }

                        }
                    ]
                });
            }
        });
        });
