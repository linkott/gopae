// Put event listeners into place
/**
 * 
 * @param boolean cameraActive
 * @param boolean buttonsActive
 * @returns boolean
 */
function configCamera(cameraActive, buttonsActive){

    if(cameraActive){
        
        $.gritter.add({
            title: 'Activar Camara',
            text: 'Para activar la camara haga click en el boton "Compartir", "Compartir dispositivo seleccionado" de la ventana emergente de su navegador para poder visualizar la imagen de la cámara web.',
            class_name: 'gritter-warning'
        });

        var canvasArea = "canvas";
        var videoArea = "video";
        // Grab elements, create settings, etc.
        var canvas = document.getElementById(canvasArea),
            context = canvas.getContext("2d"),
            video = document.getElementById(videoArea),
            videoObj = {"video": true},
            errBack = function (error) {
                //showNotify("Error en la Captura de Video", error.code);
                console.log("Video capture error:", error.code);
            };
        // Put video listeners into place
        if (navigator.getUserMedia) { // Standard
            navigator.getUserMedia(videoObj, function (stream) {
                video.src = stream;
                video.play();
            }, errBack);
        } else if (navigator.webkitGetUserMedia) { // WebKit-prefixed
            navigator.webkitGetUserMedia(videoObj, function (stream) {
                video.src = window.webkitURL.createObjectURL(stream);
                video.play();
            }, errBack);
        }
        else if (navigator.mozGetUserMedia) { // Firefox-prefixed
            navigator.mozGetUserMedia(videoObj, function (stream) {
                video.src = window.URL.createObjectURL(stream);
                video.play();
            }, errBack);
        }
    }
    else{
        $.gritter.add({
            title: 'Esta Persona Ya Posee una Fotografía',
            text: 'Puede hacer click en el botón azul "<i class="fa fa-refresh"></i> Actualizar esta Foto" si desea tomar una nueva fotografía.',
            class_name: 'gritter-warning'
        });
    }

    if(buttonsActive){
        buttonsEvents(video, videoObj, errBack, canvas, context);
    }
    
    return true;
}

function buttonsEvents(video, videoObj, errBack, canvas, context){

    console.log("Seteando eventos sobre botones");

    $("#snap, #video").unbind("click");
    $("#snap, #video").on("click", function(evt){
        console.log(this);
        $("#canvas").removeClass("hide");
        context.drawImage(video, 0, 0, 300, 225);
        $("#fotoImgBase64").val(canvas.toDataURL());
    }); 
    
    $("#cancel-snap-refresh").unbind("click");
    $("#cancel-snap-refresh").on("click", function(evt){
        console.log(this);
        $("#canvas").addClass("hide");
        $("#cancel-snap-refresh").addClass("hide");
        $("#snap").addClass("hide");
        $("#ImgTalentoHumanoFoto").removeClass("hide");
        $("#snap-refresh").removeClass("hide");
        $("#fotoImgBase64").val("data:image/png;base64");
    });
    
    $("#snap-refresh").unbind("click");
    $("#snap-refresh").on("click", function(evt){
        console.log(this);
        configCamera(true, true);
        $("#canvas").removeClass("hide");
        $("#cancel-snap-refresh").removeClass("hide");
        $("#snap").removeClass("hide");
        $("#ImgTalentoHumanoFoto").addClass("hide");
        $("#snap-refresh").addClass("hide");
        $("#fotoImgBase64").val("");
    });
}
