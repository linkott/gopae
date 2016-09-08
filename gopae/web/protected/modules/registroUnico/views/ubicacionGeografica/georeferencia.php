<?php
/* @var $this MadresCocinerasasController */

$this->pageTitle = 'Georeferenciación de Planteles';

$this->breadcrumbs = array(
    'Registro Único de Planteles' => array('/registroUnico/plantelesPae/lista'),
    'Institución Educativa' => array('/registroUnico/plantelesPae/edicion/id/'.base64_encode($plantel['id'])),
    'Georeferenciación',
);

$this->widget('ext.loading.LoadingWidget');

$this->renderPartial('planteles.views.consultar._infoPlantelPae', array('plantel' => $plantel));

?>
<input type="hidden" id="urlCargaArchivo" value="<?php echo $urlCargaArchivo; ?>" />
<input type="hidden" id="urlCargaGeoreferencia" value="<?php echo $urlCargaGeoreferencia; ?>" />

<div class="row">
    <div class="col-md-12">
        <div class="widget-box">
            <div class="widget-header">
                <h5>Información Georeferencial de Sede Principal del Plantel (<?php echo $plantel['cod_plantel']; ?>)</h5>

                <div class="widget-toolbar">
                    <a data-action="collapse" href="#">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
            </div>


            <div class="widget-body">
                <div class="widget-body-inner">
                    <div class="widget-main">
                        <div class="widget-main form">

                            <div class="row-fluid">
                                <div class="row">
                                    <div id="div-result">
                                        <div class="infoDialogBox">
                                            <p>
                                             Cargue una imagen correspondiente a una fotografía del plantel que haya sido tomada con información de geolocalización, este tipo de fotografías se pueden tomar con teléfono inteligente habilitando la GPS.
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label class="col-md-12" for="latitud">Latitud</label>
                                            <?php echo CHtml::textField('latitud',$plantel['latitud'],array('id'=>'latitud', 'class' => 'span-12', 'readonly' => 'readonly' )); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-md-12" for="longitud">Longitud</label>
                                            <?php echo CHtml::textField('longitud', $plantel['longitud'],array('id'=>'longitud', 'class' => 'span-12', 'readonly' => 'readonly' )); ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="space-6"></div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <span class="btn btn-lg btn-success smaller-90 fileinput-button">
                                                <i class="fa fa-upload"></i>
                                                &nbsp;
                                                <span> Cargue una fotografía del Plantel (GPS)...</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input type="file" name="files[]" id="fileupload" />
                                            </span>
                                            <input type="hidden" name="archivo" id="archivo" readonly="" />
                                        </div>
                                        <div class="col-md-6">
                                            <div id="notificacionArchivo"></div>
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

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/registroUnico/ubicacionGeografica/imagen.js', CClientScript::POS_END); ?>

<?php //echo $form->textField($model,'titulo',array('size'=>40, 'maxlength'=>40, 'required' => 'required', 'class' => 'span-12', )); ?>
