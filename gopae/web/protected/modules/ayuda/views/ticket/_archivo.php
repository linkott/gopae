
<div class="col-lg-12">
    <span class="btn btn-success smaller-90 fileinput-button">
        <i class="fa fa-upload"></i>
        <span> Cargue la Impresión de Pantalla con el Error...</span>
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
    <?php
//    $lista = ArchivoFundamentoJuridico::model()->findAllByAttributes(array('fundamento_juridico_id' => $model->id), array('order' => 'id DESC'));
//    $dataProvider = new CArrayDataProvider($lista, array(
//        'pagination' => array(
//            'pageSize' => 5,
//        )
//    ));
/*
  $this->widget('zii.widgets.grid.CGridView', array(
  'itemsCssClass' => 'table table-striped table-bordered table-hover',
  'id' => 'archivo-fundamento-grid',
  'dataProvider' => $modelArchivo->search($llave),
  'summaryText' => false,
  'pager' => array(
  'header' => '',
  'htmlOptions' => array('class' => 'pagination'),
  'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
  'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
  'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
  'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
  ),
  'columns' => array(
  array(
  'class' => 'CLinkColumn',
  'header' => '<center>Nombre del Archivo</center>',
  'labelExpression' => '$data->nombre',
  'urlExpression' => '"/fundamentoJuridico/fundamentoJuridico/descargar?id=".base64_encode($data->ruta)'
  ),
  array(
  'type' => 'raw',
  'header' => '<center>Acciones</center>',
  'value' => array($this, 'columna'),
  ),
  ),
  ));

 */
?>
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
            url: '/ayuda/ticket/upload?id=' + id,
            acceptFileTypes: /(\.|\/)(jpe?g|png|pdf|doc|opt)$/i,
            maxFileSize: 5000000,
            singleFileUploads: true,
            autoUpload: true,
            process: [
                {
                    action: 'load',
                    fileTypes: /(\.|\/)(jpe?g|png|pdf|doc|opt)$/i,
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
                $("#nombreBD").val(nombre);
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