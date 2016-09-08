

$('#capacidadSeccion').bind('keyup blur', function() {
    if ($("#capacidadSeccion").val() > 100)
    {
        $("#capacidadSeccion").val('100');
    }
    keyNum(this, false);// true acepta la ñ y para que sea español
});

function mostrarPlan() {

    Loading.show();

    $("#seccion_error p").html('');
    $("#seccion_error").hide();
    var mensaje = 'Por favor seleccione otro nivel que contenga un plan asociado';

    var data = {
        plantel_id: $("#plantel_id").val(),
        nivel_id: $("#nivelId").val()
    }

    $.ajax({
        url: "../../mostrarPlan",
        data: data,
        dataType: 'html',
        type: 'get',
        success: function(resp) {
            if (resp == 'false') {
                
                $("#planId").html('');
                var plan=document.getElementById("planId"); 
                var option=document.createElement("option"); 
                option.value="";
                option.text="-SELECCIONE-";    
                plan.appendChild(option); // y aqui lo añadiste

                document.getElementById("seccion_error").style.display = "block";
                $("#seccion_error p").html(mensaje);

            } else {
                $("#planId").html(resp);
            }
            Loading.hide();
        }
    });
    
}


function mostrarGrado() {

    Loading.show();

    $("#seccion_error p").html('');
    $("#seccion_error").hide();
    var mensaje = 'Por favor seleccione otro nivel que contenga un plan y un grado asociado';

    var data = {
        plan_id: $("#planId").val(),
        nivel_id: $("#nivelId").val()
    }

    $.ajax({
        url: "../../mostrarGrado",
        data: data,
        dataType: 'html',
        type: 'get',
        success: function(resp) {
            //  alert(resp);

            if (resp == 'false') {
                
                $("#gradoId").html('');
                var grado=document.getElementById("gradoId"); 
                var option=document.createElement("option"); 
                option.value="";
                option.text="-SELECCIONE-";    
                grado.appendChild(option); // y aqui lo añadiste
                
                document.getElementById("seccion_error").style.display = "block";
                $("#seccion_error p").html(mensaje);

            } else {
                $("#gradoId").html(resp);
            }
            Loading.hide();
        }
    });
}


function agregarSeccion() {

    Loading.show();
    var data = {
        plantel_id: $("#plantel_id").val()
    }

    $.ajax({
        url: "../../mostrarRegistrarSeccion",
        data: data,
        dataType: 'html',
        type: 'post',
        success: function(resp) {
            //  alert(resp);
            //  $("#dialog_registrarSeccion span").html($("#SeccionPlantel_seccion_id option:selected").text());
            var dialogRegistrar = $("#dialog_registrarSeccion").removeClass('hide').dialog({
                modal: true,
                width: '850px',
                draggable: false,
                resizable: false,
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Asignar Nueva Sección</h4></div>",
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
                        html: "Guardar &nbsp; <i class='icon-save icon-on-right bigger-110'></i>",
                        "class": "btn btn-primary btn-xs",
                        click: function() {


                            var data = {
                                //  seccion:$("#seccion-plantel-form").serialize(),
                                seccion_id: $("#seccionId").val(),
                                grado_id: $("#gradoId").val(),
                                capacidad: $("#capacidadAlumnos").val(),
                                turno_id: $("#turnoId").val(),
                                plantel_id: $("#plantel_id").val(),
                                nivel_id: $("#nivelId").val(),
                                plan_id: $("#planId").val()
                            }
                            Loading.show();
                            $.ajax({
                                url: "../../guardarSeccion",
                                data: data,
                                dataType: 'html',
                                type: 'post',
                                success: function(resp) {

                                    if (isNaN(resp)) { // si la respuesta son caracteres muestra el error de ingreso
                                        document.getElementById("resultadoRegistrar").style.display = "none";
                                        document.getElementById("resultadoSeccionRegistrar").style.display = "block";
                                        $("#resultadoSeccionRegistrar").html(resp);
                                        //document.getElementById("resultadoSeccion").style.display = "none";
                                        $("html, body").animate({scrollTop: 0}, "fast");
                                    } else { //muestra mensaje que guardo
                                        // alert('guardo');
                                        $("#seccionId").val('');
                                        $("#gradoId").val('');
                                        $("#capacidadAlumnos").val('');
                                        $("#turnoId").val('');
                                        $("#nivelId").val('');
                                        $("#planId").val('');
                                        refrescarGrid();
                                        document.getElementById("guardoRegistro").style.display = "block";
                                        dialogRegistrar.dialog('close');
                                        $("html, body").animate({scrollTop: 0}, "fast");
                                    }
                                    Loading.hide();
                                }
                            })

                        }
                    }
                ]
            });
            $("#dialog_registrarSeccion").html(resp);
            Loading.hide();
        }
    })
}


$("#resultadoSeccionRegistrar").click(function() {
    document.getElementById("resultadoSeccionRegistrar").style.display = "none";
    document.getElementById("resultadoRegistrar").style.display = "block";
});

$("#guardoRegistro").click(function() {
    //document.getElementById("resultadoSeccionRegistrar").style.display = "none";
    document.getElementById("guardoRegistro").style.display = "none";
    document.getElementById("resultadoElim").style.display = "none";
    //document.getElementById("resultadoRegistrar").style.display = "block";
});

$("#resultadoElim").click(function() {
    document.getElementById("resultadoElim").style.display = "none";
});

function mostrarSeccion(id) {

    Loading.show();

    var data = {
        id: id,
        plantel_id: $("#plantel_id").val()
    }
    //alert(id);
    $.ajax({
        url: "../../mostrarSeccion",
        data: data,
        dataType: 'html',
        type: 'get',
        success: function(resp) {
          //  alert(resp);
            //  $("#dialog_registrarSeccion span").html($("#SeccionPlantel_seccion_id option:selected").text());
            var dialogRegistrar = $("#dialog_registrarSeccion").removeClass('hide').dialog({
                modal: true,
                width: '850px',
                draggable: false,
                resizable: false,
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Asignar Nueva Sección</h4></div>",
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
                        html: "Guardar &nbsp; <i class='icon-save icon-on-right bigger-110'></i>",
                        "class": "btn btn-primary btn-xs",
                        click: function() {


                            var data = {
                                id: id,
                                seccion_id: $("#seccionId").val(),
                                grado_id: $("#gradoId").val(),
                                capacidad: $("#capacidadAlumnos").val(),
                                turno_id: $("#turnoId").val(),
                                nivel_id: $("#nivelId").val(),
                                plan_id: $("#planId").val(),
                                plantel_id: $("#plantel_id").val()
                            }

                            Loading.show();

                            $.ajax({
                                url: "../../modificarSeccion?id=" + id,
                                data: data,
                                dataType: 'html',
                                type: 'post',
                                success: function(resp) {

                                    if (isNaN(resp)) { // si la respuesta son caracteres muestra el error de ingreso
                                        document.getElementById("resultadoRegistrar").style.display = "none";
                                        document.getElementById("resultadoSeccionRegistrar").style.display = "block";
                                        $("#resultadoSeccionRegistrar").html(resp);
                                        //document.getElementById("resultadoSeccion").style.display = "none";
                                        $("html, body").animate({scrollTop: 0}, "fast");
                                    } else { //muestra mensaje que guardo
                                        // alert('guardo');
                                        $("#seccionId").val('');
                                        $("#gradoId").val('');
                                        $("#capacidadAlumnos").val('');
                                        $("#turnoId").val('');
                                        $("#nivelId").val('');
                                        $("#planId").val('');
                                        refrescarGrid();
                                        document.getElementById("guardoRegistro").style.display = "block";
                                        dialogRegistrar.dialog('close');
                                        $("html, body").animate({scrollTop: 0}, "fast");

                                    }
                                    Loading.hide();

                                }
                            })
                            //  $(this).dialog("close");

                        }
                    }
                ],
            });
            $("#dialog_registrarSeccion").html(resp);
            Loading.hide();
        }
    })
    //  $("#dialog_registrarSeccion").show();
}


function confirmarEliminacion(id) {

    
    var dialogElim = $("#dialog_eliminacion").removeClass('hide').dialog({
        modal: true,
        width: '450px',
        draggable: false,
        resizable: false,
        title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Sección</h4></div>",
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
                html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar Sección",
                "class": "btn btn-danger btn-xs",
                click: function() {
                    var data = {
                        id: id
                    }
                    Loading.show();
                    $.ajax({
                        url: "../../eliminarSeccion?id=" + id,
                        data: data,
                        dataType: 'html',
                        type: 'post',
                        success: function(resp) {
                            // alert(resp);
                            refrescarGrid();
                            dialogElim.dialog('close');
                            $('#resultadoElim').html(resp);
                            document.getElementById("resultadoElim").style.display = "block";
                            $("html, body").animate({scrollTop: 0}, "fast");
                            Loading.hide();
                        }
                    })
                }
            }
        ]
    });
    
    $("#dialog_registrarSeccion").show();
}



function vizualizar(id) {
    var data =
            {
                id: id
            };
    Loading.show();
    $.ajax({
        url: "../../vizualizar",
        data: data,
        dataType: 'html',
        type: 'GET',
        success: function(resp)
        {
            var dialog_vizualizarI = $("#dialog_vizualizar").removeClass('hide').dialog({
                modal: true,
                width: '800px',
                draggable: false,
                resizable: false,
                //position: 'top',
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'>Detalles de Sección</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs",
                        click: function() {
                            dialog_vizualizarI.dialog("close");
                        }

                    }

                ]
            });
            $("#dialog_vizualizar").html(resp);
            Loading.hide();
        }
    });
}

function refrescarGrid() {

    $('#seccion-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
}