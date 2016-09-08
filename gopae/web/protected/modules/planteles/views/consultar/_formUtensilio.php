<?php
/* @var $this AulaController */
/* @var $model Ingesta */
$this->pageTitle = 'Edición de Datos del Plantel';
?>
<div class="widget-box">

    <div class="widget-header">
        <h5>Utensilio del Plantel</h5>

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
                            'id' => 'plantel-pae-utensilio-grid',
                            'dataProvider' => $model->search(2),
                            'filter' => false,
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
                                    'header' => 'Nombre',
                                    'name' => 'articulo_id',
                                    'value' => '$data->articulo->nombre',
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

<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<div id="plantel_id" class="hide"><?php echo base64_decode($_GET['id']); ?></div>
<div id="dialogPantalla" class="hide"></div>
<div id="dialogPantallaConsultar" class="hide"></div>
<div id="dialogPantallaEliminarUtensilio" class="hide"> 
    <div class="alertDialogBox bigger-110">
        <p class="bigger-110 bolder center grey">
            &iquest;Estas seguro de eliminar este Utensilio?
        </p>
    </div>
</div>

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/utensilio.js', CClientScript::POS_END);
?>
