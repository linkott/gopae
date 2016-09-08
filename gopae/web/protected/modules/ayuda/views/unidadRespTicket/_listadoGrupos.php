<?php
 Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/ayuda/unidad_responsable_ticket.js', CClientScript::POS_END);?>   
<div class="tab-pane active" id="autoridades">
      <div id="autor" class="widget-box">
            <div class="widget-header">
                <h5>Grupos</h5>
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
                                <a  type="submit" onclick="VentanaDialogG('','/ayuda/unidadRespTicket/crearGrupo','Unidad y grupos de usuarios','create','')" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                    <i class="fa fa-plus icon-on-right"></i>
                                    Registrar Grupos
                                </a>

                            </div>

                        <div class="row">
                            <?php echo '<input type="hidden" id="id" value=' . $id . ' name="id"/>'; ?>
                             <div class="col-md-12" id ="listaGrupos">
                                <div class="col-md-12">

                                <?php
                                $this->widget(
                                        'zii.widgets.grid.CGridView', array(
                                    'id' => 'clase-plantel-grid',
                                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                    // 40px is the height of the main navigation at bootstrap
                                    'dataProvider' => $dataProvider,
                                    'summaryText' => false,
                                     'afterAjaxUpdate' => " function(){
                                    }

                                ",
                                    'columns' => array(
                                         array(
                                            'name' => 'nombre',
                                            'type' => 'raw',
                                            'header' => '<center><b>Unidad Responsable</b></center>'
                                        ),
                                        array(
                                            'name' => 'groupname',
                                            'type' => 'raw',
                                            'header' => '<center><b>Grupo</b></center>'
                                        ),
                                        array(
                                            'name' => 'description',
                                            'type' => 'raw',
                                            'header' => '<center><b>Descripción</b></center>'
                                        ),
                                        array(
                                            'name' => 'correo_unidad',
                                            'type' => 'raw',
                                            'header' => '<center><b>Correo Unidad</b></center>'
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

<div id="dialogPantallaG" class="hide"></div>