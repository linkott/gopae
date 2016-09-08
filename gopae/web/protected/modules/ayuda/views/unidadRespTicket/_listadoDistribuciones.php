<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/ayuda/unidad_responsable_ticket.js', CClientScript::POS_END); ?>
<div class="tab-pane active" id="autoridades">
    <div id="autor" class="widget-box">
        <div id="resultadoZonaAutoridades">
        </div>
        <div class="widget-header">
            <h5>Distribuciones de Solicitud</h5>
            <div class="widget-toolbar">
                <a  href="#" data-action="collapse">
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>
    <div id="autoridadesZona" class="widget-body" >
        <div class="widget-body-inner" >
            <div class="widget-main form">
                <div class="pull-right" style="padding-left:10px;">
                    <a  type="submit" onclick="VentanaDialogD('', '/ayuda/unidadRespTicket/crearDistribucion', 'Distribucion de Ticket', 'create', '')" data-last="Finish" class="btn btn-success btn-next btn-sm">
                        <i class="fa fa-plus icon-on-right"></i>
                        Registrar Distribuciones
                    </a>
                </div>
                <div class="row">
                    <?php echo '<input type="hidden" id="id" value=' . $id . ' name="id"/>'; ?>
                    <div class="col-md-12" id ="listaDistribucion">
                        <div class="col-md-12">
                            <?php
                            $this->widget(
                                    'zii.widgets.grid.CGridView', array(
                                'id' => 'clase-distribucion-grid',
                                'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                // 40px is the height of the main navigation at bootstrap
                                'dataProvider' => $dataProviderDistribucion,
                                'summaryText' => false,
                                'afterAjaxUpdate' => " function(){
                                    }

                                ",
                                'columns' => array(
                                    array(
                                        'header' => '<center><b>telefono</b></center>',
                                        'name' => 'telefono',
                                        'type' => 'raw',
                                        'htmlOptions' => array('width' => '20%')
                                    ),
                                    array(
                                        'header' => '<center><b>Correo Electronico</b></center>',
                                        'name' => 'correo_electronico',
                                        'type' => 'raw',
                                        'htmlOptions' => array('width' => '20%')
                                    ),
                                    array(
                                        'header' => '<center><b>Tipo de Ticket</b></center>',
                                        'name' => 'tipo_ticket',
                                        'type' => 'raw',
                                        'htmlOptions' => array('width' => '20%')
                                    ),
                                    array(
                                        'header' => '<center><b>Unidad Responsable</b></center>',
                                        'name' => 'unidad',
                                        'type' => 'raw',
                                        'htmlOptions' => array('width' => '20%')
                                    ),
                                    array(
                                        'header' => '<center><b>Estado</b></center>',
                                        'name' => 'estado',
                                        'type' => 'raw',
                                        'htmlOptions' => array('width' => '2<0%')
                                    ),
                                    array(
                                        'header' => 'Acciones',
                                        'name' => 'boton',
                                        'type' => 'raw'
                                    ),
                                ),
                                'pager' => array(
                                    'header' => '',
                                    'htmlOptions' => array('class' => 'pagination'),
                                    'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                                    'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                                    'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                                    'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                                ),
                                    )
                            );
//}
                            ?>
                            <div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
                        </div>
                    </div>
                    <br>
                    <br>

                </div>
            </div>
        </div>
    </div>
</div>
      </div>

<div id="dialogPantallaD" class="hide"></div>