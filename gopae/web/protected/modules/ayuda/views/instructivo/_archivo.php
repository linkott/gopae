
<div class="col-lg-12">
    <span class="btn btn-success smaller-90 fileinput-button">
        <i class="fa fa-upload"></i>
        <span> Cargue la Impresión de Pantalla...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" >
    </span>
    <div id="notificacionArchivo" ></div>
    <input id="nombreArchivo" type="hidden" name="nombreArchivo" >
    <input id="nombreBD" type="hidden" readonly="readonly" name="nombreBD" >
<!-- The container for the uploaded files -->
<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>


<div id="dialogPantalla" class="hide"></div>
<div id="files" class="files"></div>

<div id="listado">
    
</div>
<div id="subDialogPantalla"></div>
<br>
</div>
<!-- The template to display files available for upload -->

<!-- The main application script -->
<script>
    $(document).ready(function() {
        var id = $("#id").val();
        $('#fileupload').fileupload({
            url: '/ayuda/instructivo/upload?id=' + id,
            acceptFileTypes: /(\.|\/)(jpe?g|png|pdf|doc|opt|odp|odf)$/i,
            maxFileSize: 20000000,
            singleFileUploads: true,
            autoUpload: true,
            process: [
                {
                    action: 'load',
                    fileTypes: /(\.|\/)(jpe?g|png|pdf|doc|opt|odp|odf)$/i,
                    maxFileSize: 20000000 // 20MB
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
                alert("Se ha producido un error en la carga del archivo.");//ALEXIS ERROR DE CARGA
            }

        });
        $('#fileupload').bind('fileuploaddone', function(e, data) {
            var archivos = data.jqXHR.responseJSON.files;

            $("#notificacionArchivo").html("¡Archivo cargado con exito!");

            $.each(archivos, function(index, file) {
                var nombre = file.name;
                $("#nombreArchivo").val(nombre);
            });
        });
    });
    function getFileExtension(name)
    {
        var found = name.lastIndexOf('.') + 1;
        return (found > 0 ? name.substr(found) : "");
    }
</script>