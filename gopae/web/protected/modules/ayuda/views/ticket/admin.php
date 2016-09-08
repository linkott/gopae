<?php
/* @var $this TipoFundamentoController */
/* @var $model TipoFundamento */

$this->breadcrumbs = array(
    'Ayuda' => array('/ayuda/tiket'),
    'Notificaciones',
);
?>

<div class="widget-box">
    <div class="widget-header">
        <h5>Lista de Notificaciones</h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">
                <div>
                    <div id="resultadoOperacion">
                        <div class="infoDialogBox">
                            <p>
                                En este módulo podra hacer solicitudes, notificaciones, reportes o requerimientos como: Solución de Posibles Errores en el Sistema, Petición de Nueva Cuenta de Usuario, Reseteo de Clave, Notificación de un Plantel no existente en el Sistema o un Plantel ya Inactivo.
                            </p>
                        </div>
                    </div>
                    <?php
                    // if (($groupId == 1) || ($groupId == 18)) {
                    ?>

                    <div class="pull-right" style="padding-left:10px;">
                        <a  type="submit" id='apertura_ticket' data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Crear Nueva Notificación
                        </a>
                    </div>
                    <div id="dialogPantalla" class="hide"></div>
                    <?php if(Yii::app()->user->pbac("ayuda.ticket.admin")):?>
                    <a class="btn btn-success btn-next btn-sm" href="/ayuda/ticket/exportarTodo">
                        <i class="fa fa-file-text-o"></i>
                        Exportar Todo los Registros
                    </a>
                    <a class="btn btn-success btn-next btn-sm" href="/ayuda/ticket/exportarFiltro">
                        <i class="fa fa-file-text-o"></i>
                        Exportar  Registros Filtrados
                    </a>
                    <?php
                    endif;
                    //}
                    ?>
                </div><!-- search-form -->
                <?php
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
                        'columns' => array(
                            array(
                                'header' => '<center>Código</center>',
                                'name' => 'codigo',
                                'filter' => CHtml::textField('Ticket[codigo]', $model->codigo, array('title' => 'Código del Ticket', 'maxlength' => '28')),
                            ),
                            array(
                                'header' => '<center>Tipo de Solicitud</center>',
                                'name' => 'tipo_ticket_id',
                                'value' => '(is_object($data->tipoTicket))?$data->tipoTicket->nombre:""',
                                'filter' => CHtml::listData(
                                        TipoTicket::model()->findAll(
                                                array(
                                                    'condition' => "estatus = 'A'",
                                                    'order' => 'id ASC'
                                                )
                                        ), 'id', 'nombre'
                                ),
                            ),
//                                 array(
//                                'header' => '<center> Descripción </center>',
//                                'name' => 'observacion',
//                                'value' => array($this, 'columnaObservacion'),
//                                'filter' => CHtml::textField('Ticket[observacion]', $model->observacion, array('title' => 'Código del Ticket', 'maxlength' => '150',)),
//                            ),

                            array(
                                'header' => '<center> Estado </center>',
                                'name' => 'estado_id',
                                'value' => '(is_object($data->estado))? $data->estado->nombre:""',
                                //'value' => '(in_array(Yii::app()->user->group,  array(UserGroups::JEFE_DRCEE, UserGroups::ADMIN_DRCEE, UserGroups::DESARROLLADOR, UserGroups::root)))?$data->estado:Yii::app()->user->estado',
                                'filter' => CHtml::listData(
                                        Estado::model()->findAll(
                                                array(
                                                    'condition' => "co_stat_data = 'A'",
                                                    'order' => 'nombre ASC'
                                                )
                                        ), 'id', 'nombre'
                                ),
                            ),

                             array(
                                'header' => '<center> Unidad Responsable </center>',
                                'name' => 'bandeja_actual_id',
                                'value' => '(is_object($data->bandejaActual))? $data->bandejaActual->nombre : ""',
                                //'value' => '(is_object($data->responsableAsignado))?$data->bandejaActual->nombre:""',
                                'filter' => CHtml::listData(
                                        UnidadRespTicket::model()->findAll(
                                        ), 'id', 'nombre'
                                ),
                            ),



                            array(
                                'header' => '<center>Fecha</center>',
                                'name' => 'fecha_ini',
                                'value' => array($this, 'fechaIni'),
                                'filter' => CHtml::textField('Ticket[fecha_ini]', Utiles::transformDate($model->fecha_ini, '-', 'ymd', 'dmy'), array('id' => "date-picker", 'placeHolder' => 'DD-MM-AAAA',)),
                            ),
                            array(
                                'header' => '<center> Estatus </center>',
                                'name' => 'estatus',
                                'filter' =>CHtml::listData($this->estatus_asig(),'id','nombre'),
                                'value' => array($this, 'estatus'),
                            ),
                            array(
                                'type' => 'raw',
                                'header' => '<center>Acción</center>',
                                'value' => array($this, 'columnaAcciones'),
                                'htmlOptions' => array('nowrap'=>'nowrap'),
                            ),
                        ),
                        'emptyText' => 'No se han encontrado Solicitudes o Notificaciones activas, si desea puede filtrar las solicitudes por otros estatus!',
                    ));
                    ?>
                    <div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
                    <?php
                ?>
            </div>
        </div>
    </div>
</div>
<?php
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

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/ayuda/ticket.js', CClientScript::POS_END); ?>
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

