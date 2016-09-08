<?php
/* @var $this TipoFundamentoController */
/* @var $model TipoFundamento */

$this->breadcrumbs = array(
    'Ayuda' => array('/ayuda/instructivo'),
    'Instructivos',
);
/*
  $this->menu=array(
  array('label'=>'List TipoFundamento', 'url'=>array('index')),
  array('label'=>'Create TipoFundamento', 'url'=>array('create')),
  );
 */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tipo-fundamento-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="widget-main form" style="overflow:hidden;">

    <div class="widget-box">
        <div class="widget-header">
            <h4>Lista de Instructivos</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="icon-chevron-up"></i>
                </a>
            </div>

        </div>

        <div class="widget-body">

            <div class="widget-main">
                <div class="row col-sm-12" id="resultadoOperacion"></div>
                <div class="row space-6"></div>


                <?php
                if (Yii::app()->user->pbac('ayuda.instructivo.admin')):
                    ?>
                    <div class="pull-right" style="padding-left:10px;">
                        <a  type="submit" onclick="VentanaDialog('', '/ayuda/instructivo/create', 'Instructivo', 'create', '')" data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Instructivo
                        </a>

                    </div>

                    <?php
                endif;
                ?>  <div class="row space-40"></div>
                <?php
                if (Yii::app()->user->pbac('ayuda.instructivo.admin')) {
                    $columnas = array(
                        array(
                            'type' => 'raw',
                            'header' => '<center>Nombre del Instructivo</center>',
                            'name' => 'nombre',
                            'htmlOptions'=>array('width'=>'30%'),
                            'value'=>array($this, 'columnaNombre'),
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center> Descripción </center>',
                            'name' => 'descripcion',
                            'value' => array($this, 'columnaObservacion'),
                            'htmlOptions'=>array('width'=>'40%'),
                        ),
                        array(
                            'header' => '<center> Fecha </center>',
                            'name' => 'fecha_ini',
                            'filter' => CHtml::textField('Instructivo[fecha_ini]', Utiles::transformDate($model->fecha_ini, '-', 'ymd', 'dmy'), array('id' => "date-picker", 'placeHolder' => 'DD-MM-AAAA',)),
                            'value' => array($this, 'fechaIni'),
                            'htmlOptions'=>array('width'=>'10%'),
                        ),
                        array(
                            'header' => '<center> Estatus </center>',
                            'name' => 'estatus',
                            'filter' => array('A' => 'Activo', 'E' => 'Eliminado'),
                            'value' => array($this, 'estatus'),
                            'htmlOptions'=>array('width'=>'10%'),
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Acción</center>',
                            'value' => array($this, 'columnaAcciones'),
                            'htmlOptions'=>array('width'=>'10%'),
                        ),
                    );
                } else {
                    $columnas = array(
                        array(
                            'header' => '<center>Instructivo</center>',
                            'name' => 'nombre',
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center> Descripción </center>',
                            'name' => 'descripcion',
                            'value' => array($this, 'columnaObservacion'),
                        ),
                        array(
                            'header' => '<center> Fecha </center>',
                            'name' => 'fecha_ini',
                            'filter' => CHtml::textField('Instructivo[fecha_ini]', Utiles::transformDate($model->fecha_ini, '-', 'ymd', 'dmy'), array('id' => "date-picker", 'placeHolder' => 'DD-MM-AAAA',)),
                            'value' => array($this, 'fechaIni'),
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Acción</center>',
                            'value' => array($this, 'columnaAcciones'),
                        ),
                    );
                }

                $this->widget('zii.widgets.grid.CGridView', array(
                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                    'id' => 'clase-plantel-grid',
                    'filter' => $model,
                    'dataProvider' => $model->search(),
                    'summaryText' => 'Mostrando {start}-{end} de {count}',
                    'pager' => array(
                        'header' => '',
                        'htmlOptions' => array('class' => 'pagination'),
                        'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                        'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                        'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                        'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                    ),
                    'afterAjaxUpdate' => "

                                    function(){
                                        $('#date-picker').datepicker();
                                        $.datepicker.setDefaults($.datepicker.regional = {
                                                dateFormat: 'dd-mm-yy',
                                                showOn:'focus',
                                                showOtherMonths: false,
                                                selectOtherMonths: true,
                                                changeMonth: true,
                                                changeYear: true,
                                                minDate: new Date(1800, 1, 1),
                                                maxDate: 'today'
                                            });

                                        $('#Ticket_codigo').bind('keyup blur', function () {
                                            keyNum(this, false);
                                            clearField(this);
                                        });


                                        $('#Ticket_observacion').bind('keyup blur', function () {
                                            keyText(this, true);
                                        });

                                        $('#Ticket_observacion').bind('blur', function () {
                                            clearField(this);
                                        });
                                    }
                                ",
                    'columns' => $columnas,
                ));
                ?>
            </div><!-- search-form -->

        </div>

    </div>
</div>

<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>


<div id="dialogPantalla" class="hide"></div>

<?php /* $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$dataProvider,
  'itemView'=>'_view',
  )); */ ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/ayuda/instructivo.js', CClientScript::POS_END); ?>

<link rel="stylesheet" href="/public/js/jquery.upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="/public/js/jquery.upload/css/jquery.fileupload-ui.css">
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
