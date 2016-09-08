<?php
/* @var $this TipoFundamentoController */
/* @var $model TipoFundamento */

$this->breadcrumbs = array(
    'Catalogo' => array('/catalogo'),
);
?>

<?php
echo CHtml::scriptFile('/public/js/modules/ayuda/unidad_responsable_ticket.js');
 ///echo CHtml::scriptFile('/public/js/modules/ayuda/grupos.js');
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>Lista de Unidades Responsables de Ticket</h4>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">

                <div class="row space-6"></div>
                <div>
                    <div id="resultadoOperacion">
                        <div class="infoDialogBox">
                            <p>
                                Unidades reponsables de atencion de requerimientos y/o notoficaciones.
                            </p>
                        </div>
                    </div>
                    <?php
                    if(($groupId == 1) || ($groupId == 18))
                        {
                        ?>
                           <div class="pull-right" style="padding-left:10px;">
                            <a  type="submit" href="/ayuda/unidadRespTicket/create" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                <i class="fa fa-plus icon-on-right"></i>
                                Registrar Unidad Responsable de Ticket
                            </a>

                        </div>

                        <?php
                        }
                    ?>

                    <div class="row space-20"></div>

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
                                'header' => '<center> Nombre  de la Unidad  </center>',
                                'name' => 'nombre',
                            ),
                               array(
                                'header' => '<center> Estatus </center>',
                                'name' => 'estatus',
                                'filter'=> array('A'=>'Activo','E'=>'Eliminado'),
                                'value'=> array($this,'estatus'),
                            ),

                            array(
                                'type' => 'raw',
                                'header' => '<center>Acción</center>',
                                'value' => array($this, 'columnaAcciones'),
                            ),
                        ),
                        'emptyText' => 'No se han encontrado Unidades responsables de ticket',
                    ));
//                   echo "<pre>";
//                    print_r($this->asignado());
//                   echo "</pre>";
                    ?>
                    <div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
                    <?php


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

