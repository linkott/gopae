<?php
/* @var $this AulaController */
/* @var $model Aula */
?>
<div class="widget-box">

    <div class="widget-header">
        <h4>Aula</h4>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="display: block;">
            <div class="widget-main">


                <div style="padding-left:10px;" class="pull-right">
                    <a class="btn btn-success btn-next btn-sm" data-last="Finish" href="#" onclick="registrarAula(<?php echo $plantel_id; ?>);">
                        <i class="fa fa-plus icon-on-right"></i>
                        Registrar nueva aula
                    </a>
                </div>

                <div class="col-lg-12"><div class="space-6"></div></div>

                <a href="#" class="search-button"></a>
                <div style="display:block" class="search-form">
                    <div>
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'id' => 'aula-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'pager' => array('pageSize' => 1),
                            'summaryText' => false,
                            'afterAjaxUpdate' => "function(){
                                $('#Aula_nombre').bind('keyup blur', function() {
                                    makeUpper(this);
                                    //keyAlphaNum(this);
                                });
                                $('#Aula_observacion').bind('keyup blur', function() {
                                    makeUpper(this);
                                    //keyAlphaNum(this);
                                });
                                $('#Aula_capacidad').bind('keyup blur', function() {
                                    if($('#Aula_capacidad').val() > 50)
                                    {
                                        $('#Aula_capacidad').val('50');
                                    }
                                    keyNum(this, false);// true acepta la ñ y para que sea español
                                });
                                $('#Aula_nombre').bind('blur', function() {
                                    clearField(this);
                                });
                                $('#Aula_observacion').bind('blur', function() {
                                    clearField(this);
                                });
                                }",
                            'pager' => array(
                                'header' => '',
                                'htmlOptions' => array('class' => 'pagination'),
                                'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                                'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                                'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                                'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                            ),
                            'id' => 'aula-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'columns' => array(
                                //'id',
                                array(
                                    'header' => 'Nombre del aula',
                                    'name' => 'nombre',
                                    'filter' => CHtml::textField('Aula[nombre]'),
                                ),
                                //'observacion',
                                array(
                                    'header' => 'Capacidad',
                                    'name' => 'capacidad',
                                    'filter' => CHtml::textField('Aula[capacidad]')
                                ),
                                //'nivel_id',
                                array(
                                    'header' => 'Condición Infraestructura',
                                    'name' => 'condicion_infraestructura_id',
                                    'value' => '$data->condicionInfraestructura->nombre',
                                    'filter' => CHtml::listData(
                                            CondicionInfraestructura::model()->findAll(
                                                    array(
                                                        'order' => 'id ASC'
                                                    )
                                            ), 'id', 'nombre'
                                    ),
                                ),
                                array(
                                    'header' => 'Tipo de aula',
                                    'name' => 'tipo_aula_id',
                                    'value' => '$data->tipoAula->nombre',
                                    'filter' => CHtml::listData(
                                            TipoAula::model()->findAll(
                                                    array(
                                                        'order' => 'id ASC'
                                                    )
                                            ), 'id', 'nombre'
                                    ),
                                ),
                                array(
                                    'header' => '<center title="Estatus del Aula">Estatus</center>',
                                    'name' => 'estatus',
                                    'filter'=> array('A' => 'Activo', 'E' => 'Inactivo'),
                                    'value'=>array($this, 'columnaEstatus'),
                                ),
                                array(
                                    'type' => 'raw',
                                    'header' => '<center>Acciones</center>',
                                    'filter' => CHtml::hiddenField('Aula[plantel_id]', $plantel_id, array('id' => 'Aula_plantel_id')),
                                    'value' => array($this, 'columnaAcciones'),
                                    'htmlOptions' => array('nowrap' => 'nowrap'),
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
<div id="dialogPantalla" class="hide"></div>
<div id="dialogPantallaConsultar" class="hide"></div>
<div id="dialogPantallaEliminar" class="hide"> 
    <div class="alertDialogBox bigger-110">
        <p class="bigger-110 bolder center grey">
            &iquest;Estas seguro de eliminar este Aula?
        </p>
    </div>
</div>
<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/aula.js', CClientScript::POS_END);
?>
