<?php
/* @var $model Zonas */

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'zona-proveedor-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>


<div class="widget-box">

    <div class="widget-header">
        <h4>Zona(s) de Atención</h4>

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
                    <p>Seleccione las zonas que estan al alcance del proveedor.</p>
                </div>

                <div class="col-lg-12"><div class="space-6"></div></div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="col-md-12">
                            <label><b>Estado</b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php
                            echo $form->dropDownList($model, 'estado_id', CHtml::listData(Estado::model()->findAll(array('order' => 'nombre ASC')), 'id', 'nombre'), array(
                                'empty' => '- SELECCIONE -',
                                'class' => 'span-7',
                                'ajax' => array(
                                    'type' => 'GET',
                                    'update' => '#Proveedor_municipio_id',
                                    'url' => CController::createUrl('/proveedor/proveedor/seleccionarMunicipio'),
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'estado_id'); ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="col-md-12">
                            <label><b>Municipio</b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php
                            echo $form->dropDownList($model, 'municipio_id', array(), array(
                                'empty' => '- SELECCIONE -',
                                'class' => 'span-7',
                                'ajax' => array(
                                    'type' => 'GET',
                                    'update' => '#Proveedor_parroquia_id',
                                    'url' => CController::createUrl('/proveedor/proveedor/seleccionarParroquia'),
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'municipio_id'); ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="col-md-12">
                            <label><b>Parroquia</b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php
                            echo $form->dropDownList($model, 'parroquia_id', array(), array(
                                'empty' => '- SELECCIONE -',
                                'class' => 'span-7',
                                'ajax' => array(
                                    'type' => 'GET',
                                    'update' => '#Proveedor_urbanizacion_id',
                                    'url' => CController::createUrl('/proveedor/proveedor/seleccionarUrbanizacion'),
                                    'success' => 'function(resutl) {
                                                $("#Proveedor_urbanizacion_id").html(resutl);
                                                var parroquia_id=$("#Proveedor_parroquia_id").val();

                                                var data=
                                                        {
                                                            parroquia_id: parroquia_id,

                                                        };
                                                $.ajax({
                                                    type:"GET",
                                                    data:data,
                                                    url:"/proveedor/proveedor/seleccionarPoblacion",
                                                    update:"#Proveedor_poblacion_id",
                                                    success:function(result){  $("#Proveedor_poblacion_id").html(result);}


                                                });

                                            }',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'parroquia_id'); ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="col-md-12">
                            <label><b>Población</b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php echo $form->dropDownList($model, 'poblacion_id', array('empty' => '- SELECCIONE -'), array('class' => 'span-7')); ?>
                            <?php echo $form->error($model, 'poblacion_id'); ?>
                        </div>
                    </div>
                    
                    <div class="col-md-1">
                         <div class="col-md-12">
                             <label style="color: transparent"><b>Agregar</b></label>
                        </div>
                            <a id="AgregarZona" class="btn btn-xs btn-primary" style="height: 28.5px;">
                                <i class="icon-map-marker bigger-110"></i>
                                Marcar Zona
                            </a>
                        </div>

                </div>
                <?php $this->endWidget(); ?>
                <div>
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'id' => 'documento-grid',
                        'dataProvider' => $model->search(),
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
                                'header' => '<center title="Estado atendido"> Estado </center>',
                                'name' => 'estado_id'
                            ),
                            array(
                                'header' => '<center title="Municipio atendido"> Municipio </center>',
                                'name' => 'municipio_id'
                            ),
                            array(
                                'header' => '<center title="Parroquia atendido"> Parroquia </center>',
                                'name' => 'parroquia_id'
                            ),
                            array(
                                'header' => '<center title="Población atendido"> Población </center>',
                                'name' => 'poblacion_id'
                            ),
                            array(
                                'header' => '<center title="Estatus"> Estatus </center>',
                                'name' => 'estatus',
                                'filter' => array('A' => 'Activo', 'E' => 'Inactivo'),
                                'value' => array($this, 'columnaEstatus'),
                            ),
                            array(
                                'type' => 'raw',
                                'header' => '<center>Acciones</center>',
                                'value' => array($this, 'columnaAccionesZonas'),
                                'htmlOptions' => array('width' => '5%'),
                            ),
                        ),
                    ));
                    ?>

                </div><!-- search-form -->
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
