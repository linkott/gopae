<?php
/* @var $this RegistroController */

$this->breadcrumbs = array(
    'Talento Humano' => '/gestionHumana/talentoHumano',
    'Carga Masiva de '.$operacion,
);
?>
<input type="hidden" id="operacion" value="<?php echo strtolower($operacion); ?>" />
<input type="hidden" id="urlCargaArchivo" value="<?php echo $urlCargaArchivo; ?>" />
<input type="hidden" id="urlProcesamientoArchivo" value="<?php echo $urlProcesamientoArchivo; ?>" />

<div class="col-xs-12">
    <div class="row-fluid">
        <div class="form">
            <div id="cargaMasiva">
                <div class="row-fluid">
                    <div class="widget-box">

                        <div class="widget-header">
                            <h5> <i class="icon-upload-alt"></i> Carga Masiva de <?php echo $operacion; ?></h5>
                            <div class="widget-toolbar">
                                <a data-action="collapse" href="#">
                                    <i class="icon-chevron-up red"></i>
                                </a>
                            </div>

                        </div>

                        <div class="widget-body">
                            <div class="widget-body-inner" style="display:block;">
                                <div class="widget-main form">
                                    <div class="row row-fluid">
                                        
                                        <div class="infoDialogBox">
                                            <p>
                                                Descargue el archivo que contiene el formato de Carga de <?php echo $operacion; ?> haciendo click sobre la imagen. El archivo debe estar en formato xls u odt calc.
                                            </p>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="text-center">
                                            <div style="color: darkred">
                                                <p>Formato Carga Masiva de <?php echo strtolower($operacion); ?></p>
                                            </div>
                                            <a id="link_descarga_formato_<?php echo strtolower($operacion); ?>" href="/public/images/formatos/formato_<?php echo strtolower($operacion); ?>.png" title="Formato .xls de Carga Masiva de <?php echo $operacion; ?>">
                                                <img src="/public/images/img_libreoffice.png" width="38" />
                                            </a>
                                            <div class="space-6"></div>
                                            <span class="btn btn-lg btn-success smaller-90 fileinput-button">
                                                <i class="fa fa-upload"></i>
                                                &nbsp;
                                                <span> Arrastre o Seleccione un archivo ...</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input type="file" name="files[]" id="fileupload" />
                                            </span>


                                            <div class="space-6"></div>

                                        </div>
                                    </div>
                                    <div class="grid-view" id="result-grid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog-options" class="hide">
    <div id="result-fileupload"></div>
    <form name="form-carga-masiva" id="form-carga-masiva">
        <input type="hidden" name="archivo" id="archivo" />
        <input type="hidden" name="csrfToken" id="csrfToken" value="<?php echo $token; ?>" />
    </form>
    <div class="hide" id="fileupload-proccesing">
        <img />
    </div>
</div>

<link rel="stylesheet" href="/public/js/jquery.upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="/public/js/jquery.upload/css/jquery.fileupload-ui.css">
<link rel="stylesheet" href="/public/js/fancybox-1.3.4/jquery.fancybox-1.3.4.css">


<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/public/js/jquery.upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="/public/js/jquery.upload/js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="/public/js/jquery.upload/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!-- blueimp Gallery script -->
<script src="/public/js/jquery.upload/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/public/js/jquery.upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/public/js/jquery.upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/public/js/jquery.upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/public/js/jquery.upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload validation plugin -->
<script src="/public/js/jquery.upload/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/public/js/jquery.upload/js/jquery.fileupload-ui.js"></script>

<script src="/public/js/bootstrap-paginator.js"></script>

<script src="/public/js/fancybox-1.3.4/jquery.fancybox-1.3.4.js"></script>


<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/gestionHumana/ingresosMasivos/batch.js', CClientScript::POS_END); ?>
