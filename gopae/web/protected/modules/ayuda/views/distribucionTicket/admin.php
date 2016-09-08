<?php
/* @var $this TipoFundamentoController */
/* @var $model TipoFundamento */

$this->breadcrumbs = array(
    'Solicitud' => array('/ayuda/unidadRespTicket'),
    'Distribución',
);
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>Lista de Distribuciones</h4>

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
                                En el módulo podra hacer solicitudes, reportes o requerimientos como: Solución de Posibles Errores en el Sistema, Petición de Nueva Cuenta de Usuario, Reseteo de Clave, Solicitud de Registro de Plantel.
                            </p>
                        </div>
                    </div>

                            <div class="pull-right" style="padding-left:10px;">
                                <a  type="submit" onclick="VentanaDialog('','/ayuda/distribucionTicket/create','Distribucion de Ticket','create','')" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                    <i class="fa fa-plus icon-on-right"></i>
                                    Registrar Distribucion de Solicitud
                                </a>

                            </div>
                </div><!-- search-form -->
                <br>
                <br>

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
                                'header' => '<center> Estado </center>',
                                'name' => 'estado_id',
                                'value' => '(is_object($data->estado))? $data->estado->nombre : ""',
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
                                'name' => 'unidad_resp_ticket_id',
                                'value' => '(is_object($data->unidadRespTicket))? $data->unidadRespTicket->nombre : ""',
                                'filter' => CHtml::listData(
                                        UnidadRespTicket::model()->findAll(
                                                array(
                                                    'order' => 'nombre ASC'
                                                )
                                        ), 'id', 'nombre'
                                ),
                            ),
                               array(
                                'header' => '<center> Correo de la Unidad </center>',
                                'name' => 'correo_electronico',
                          
                            ),
                              array(
                                'header' => '<center> Telefono </center>',
                                'name' => 'telefono',
                            ),
                             array(
                                'header' => '<center>Tipo de Notificación</center>',
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
//                               
                             
                            array(
                                'header' => '<center> Estatus </center>',
                                'name' => 'estatus',
                                'filter'=>array('A'=>'Activo','E'=>'Eliminado'),
                                'value'=>array($this, 'estatus'),
                            ),
                            array(
                                'type' => 'raw',
                                'header' => '<center>Acción</center>',
                                'value' => array($this, 'columnaAcciones'),
                            ),
                        ),
                        'emptyText' => 'No se han encontrado distribuciones!',
                    ));
//                   echo "<pre>";
//                    print_r($this->asignado());
//                   echo "</pre>";
                    ?>
                    <div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
                    <?php

                echo CHtml::scriptFile('/public/js/modules/ayuda/distribucion_ticket.js');

                                Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
                ?>

                <div id="dialogPantalla" class="hide"></div>

<?php /* $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$dataProvider,
  'itemView'=>'_view',
  )); */ ?>

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

