<?php
/* @var $this AulaController */
/* @var $model Ingesta */
?>
<div class="widget-box">

    <div class="widget-header">
        <h5>Ingestas del Plantel</h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="display: block;">
            <div class="widget-main">

                <div class="col-lg-12"><div class="space-6"></div></div>

                <a href="#" class="search-button"></a>
                <div style="display:block" class="search-form">
                    <div>

                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'id' => 'ingesta-grid',
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
                            'id' => 'ingesta-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'columns' => array(
                                array(
                                    'header' => 'Tipo de Ingesta',
                                    'name' => 'tipo_ingesta_id',
                                    'value' => '$data->tipoIngesta->nombre',
                                    'filter' => false,
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
