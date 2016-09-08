<?php
/* @var $model Documentos */
?>
<link rel="stylesheet" href="/public/js/jquery.upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="/public/js/jquery.upload/css/jquery.fileupload-ui.css">
<div class="widget-box">

    <div class="widget-header">
        <h4>Documento(s)</h4>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="display: block;">
            <div class="widget-main">
                <div class="infoDialogBox">
                    <p>Solo los siguientes tipo de archivos son validos: <b>PDF, JPG, PNG, DOC, OPT</b>.</p>
                </div>
                <div id="files"></div>
                <?php
                if (isset($tipo) && $tipo == 'update') {
                    ?>
                     <div class="col-md-12">
                                <div class="col-md-12">
                                    <label><b>Tipo de Documento</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <?php echo CHtml::dropDownList('tipo_documento','', CHtml::listData(CTipoDocumento::getData(), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'required' => 'required')) ?>
                                    
                                </div>
 <div class="col-md-4">
                    <span class="btn btn-primary smaller-90 fileinput-button pull-right">
                        <i class="fa fa-upload"></i>
                        <span> Cargar Nuevo Documento </span>
                        <input id="fileupload" type="file" name="files[]" >
                    </span>
 </div>
                    </div>

                <?php
                }
                ?>

                <div class="col-lg-12"><div class="space-6"></div></div>

                <div>
                  
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'id' => 'documento-proveedor-grid',
                            'dataProvider' => $model->searchDocumentoProveedor($proveedor_id),
                            'filter' => $model,
                            'pager' => array('pageSize' => 1),
                            'summaryText' => false,
                            'afterAjaxUpdate' => "function(){
                                }",
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
                                    'header' => '<center title="Nombre del Documento Cargado"> Nombre del Documento </center>',
                                    'labelExpression' => '$data->nombre',
                                    'urlExpression' => '"/proveedor/proveedor/descargar/id/".base64_encode($data->ruta)'
                                ),

//                                array(
////                                    'class' => 'CLinkColumn',
//                                    'header' => '<center title="Fecha de Registro"> Fecha de Registro </center>',
//                                    'name' => 'fecha_ini',
//                                    'value' => 'fecha_ini',
////                                    'urlExpression' => '"/proveedor/proveedor/descargar/id/".base64_encode($data->ruta)'
//                                ),

                                  array(
                                    'header' => '<center title="Tipo de documento cargado"> Tipo de Documento </center>',
                                    'name' => 'tipo_documento_id',
                                    'filter' => array(CHtml::listData(CTipoDocumento::getData(), 'id', 'nombre')),
                                    'value' => '$data->tipoDocumento->nombre',
                                ),
                                 array(
                                    'header' => '<center title="Usuario que cargo el documento"> Fecha de Carga </center>',
                                    'name' => 'fecha_ini',
                                    'filter' => false,
                                    'value' => 'date("d-m-Y H:i:s",strtotime($data->fecha_ini))',
                                ),
                                array(
                                    'header' => '<center title="Tipo de documento cargado"> Cargado Por </center>',
                                    'name' => 'usuario_ini_id',
                                    'filter' => false,
                                    'value' => '$data->usuarioIni->nombre',
                                ),
//                                array(
//                                    'header' => '<center title="Estatus del Documento Cargado"> Estatus </center>',
//                                    'name' => 'estatus',
//                                    'filter' => array('A' => 'Activo', 'E' => 'Inactivo'),
//                                    'value' => array($this, 'columnaEstatus'),
//                                ),

                            ),
                        ));
                        ?>

                   
                </div><!-- search-form -->
            </div>
        </div>
    </div>

</div>

<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<div id="dialogPantallaDocumento" class="hide"></div>
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
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/proveedor/documento.js', CClientScript::POS_END);
?>
