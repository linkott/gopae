<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'total-clases-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class = "widget-box collapsed">

    <div class = "widget-header">
        <h5>Total de Clases Impartidas</h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: none;" class = "widget-body-inner">
            <div class = "widget-main">     

                <div class="row">

                    <div class="col-md-12">
                        <div id="respuestaRegistroAsistencia"  class="alert alert-block hide">
                        </div>

                        <div class="col-md-12" >
                            <?php echo CHtml::label('<strong>Total de clases durante:</strong>', '', array("class" => "col-md-12")); ?>

                        </div>


                        <div class="col-md-12">
                            <?php
                            echo CHtml::hiddenField('periodo', array('required' => 'required', 'value'=> $lapso));
                            ?>
                        </div>
                        <div class = "col-md-12"><div class = "space-6"></div></div>

                        <?php

                        $this->widget(
                                'zii.widgets.grid.CGridView', array(
                            'id' => 'estudiantesInscrit',
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'dataProvider' => PlanesGradosAsignaturas::model()->getAsignaturasAsistencia($datosSeccion[0]['grado_id'], $datosSeccion[0]['plan_id'], $lapso),
                            'summaryText' => false,
                            'columns' => array(
                                array(
                                    'name' => 'asignaturas',
                                    'header' => '<center><b>Asignatura</b></center>',
                                ),
                                array(
                                    'type' => 'raw',
                                    'name' => 'total_clases',
                                    'header' => '<center><b>Nro. Clases</b></center>',
                                    'value' => array($this, 'columnaTotalClases'),
                                    'htmlOptions' => array('width' => '9%')
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
                        ?>

                        <input type='hidden' id='seccionPlantel' name='grado_id' value='<?php echo $datosSeccion[0]['grado_id']; ?>' required='required'>
                        <input type='hidden' id='seccionPlantel' name='plan_id' value='<?php echo $datosSeccion[0]['plan_id']; ?>' required='required'>
                        <input type='hidden' id='seccionPlantel' name='seccionPlantel' value='<?php echo $datosSeccion[0]['seccion_id']; ?>' required='required'>
                        <div class = "col-md-12"><div class = "space-6"></div></div>

                    </div>
                    <hr>
                    <div class="row-fluid wizard-actions">
                           <?php 
                           $total=PlanesGradosAsignaturas::model()->getAsignaturasAsistenciaListado($datosSeccion[0]['grado_id'], $datosSeccion[0]['plan_id'], $lapso);
//                           echo '<pre>';
//                           var_dump($total);
//                           echo '</pre>';
                           
                           if($total[0]['total_clases']==NULL):?>
                        <button class="btn btn-primary btn-next" id="guardarTotalClases" data-last="Finish ">
                            Guardar
                            <i class=" icon-save"></i>
                        </button>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->endWidget();
?>
