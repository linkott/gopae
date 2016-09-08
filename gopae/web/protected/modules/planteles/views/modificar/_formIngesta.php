<?php
/* @var $this AulaController */
/* @var $model Ingesta */
$this->pageTitle = 'Edición de Datos del Plantel';
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
//                            var_dump(CTipoMenu::getData());die();
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'plantel-ingesta-form',
                                'enableAjaxValidation' => true,
                            ));

                            echo $form->dropDownList(
                                $model, 'id', CHtml::listData(CTipoMenu::getData(), 'id', 'nombre'), array('empty' => '- - -', 'class' => 'col-sm-4')
                            );

                            $this->endWidget();
                            
                        ?>
                        <br><br>


                        <?php
                        
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'id' => 'ingesta-grid',
                            'dataProvider' => $model->search(),
                            'pager' => array('pageSize' => 1),
                            'summaryText' => false,
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
                                    'header' => 'Tipo de Ingestas',
                                    'name' => 'tipo_ingesta_id',
                                    'value' => '$data->tipoIngesta->nombre',
                                    'filter' => false,
//                                    'filter' => CHtml::listData(
//                                            TipoMenu::model()->findAll(
//                                                array(
//                                                    'order' => 'nombre ASC'
//                                                )
//                                            ), 'id', 'nombre'
//                                        ),
                                ),
                                /*USUARIO FECHA_INI FORMAT DD-MM-AAAA, NOMBRES (NOMBRES APELLIDOS)*/
//                                array(
//                                    'header' => '<center title="Estatus del Aula">Estatus</center>',
//                                    'name' => 'estatus',
//                                    'filter'=> array('A' => 'Activo', 'E' => 'Inactivo'),
//                                    'value'=>array($this, 'columnaEstatus'),
//                                ),
                                array(
                                    'type' => 'raw',
                                    'header' => '<center>Acciones</center>',
                                    'filter' => CHtml::hiddenField('Aula[plantel_id]', $plantel_id, array('id' => 'Aula_plantel_id')),
                                    'value' => array($this, 'columnaAccionesIngesta'),
                                    'htmlOptions' => array('nowrap' => 'nowrap', 'width'=>'5%'),
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
<div id="dialogPantallaEliminar" class="hide"> 
    <div class="alertDialogBox bigger-110">
        <p class="bigger-110 bolder center grey">
            &iquest;Estas seguro de eliminar esta Ingesta?
        </p>
    </div>
</div>

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/ingesta.js', CClientScript::POS_END);
?>
