<?php
$this->breadcrumbs = array(
    'Planteles' => array('/planteles'),
    'Secciones' => array('/planteles/seccionPlantel/admin/id/' . base64_encode($plantel_id)),
    'Calificaciónes' => array('/planteles/calificaciones/index/id/' . base64_encode($seccion_id) . '/plantel/' . base64_encode($plantel_id)),
    'Notas'
);
?>

<?php $this->renderPartial('_informacionEstudiante', array('datosEstudiante' => $datosEstudiante));
?>

<?php $this->renderPartial('_total_clases', array('datosSeccion' => $datosSeccionInfo, 'lapso' => base64_decode($lapso))); ?>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'regular-media-general-form',
    'enableAjaxValidation' => false,
        ));
?>

<div class = "widget-box">

    <div class = "widget-header">
        <h5>Evaluación <?php echo '"' . $datosEstudiante[0]['nombres'] . ' ' . $datosEstudiante[0]['apellidos'] . '"' . ' Lapso ' . base64_decode($lapso); ?></h5>
        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div class = "widget-body-inner">
            <div class = "widget-main">

                <div class="row">

                    <div class="col-md-12">
                        <div id="respuestaRegistro"  class="hide">
                            <p></p>
                        </div>
                        
                        <input type="hidden" name="grado" value="<?php echo base64_encode($datosSeccionInfo[0]['grado_id']); ?>"/>
                        <input type="hidden" name="plan" value="<?php echo base64_encode($datosSeccionInfo[0]['plan_id']); ?>"/>

                        <input type="hidden" name="lapso" value="<?php echo $lapso; ?>"/>
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'id' => 'asignatura-calificacion-grid',
                            'dataProvider' => AsignaturaEstudiante::model()->obtenerAsignaturasEstudianteGrid($id, $lapso),
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
                                    'header' => '<center>Nombre de la Asignatura</center>',
                                    'name' => 'nombre',
                                    'htmlOptions' => array('width' => '30%')
                                ),
                                array(
                                    'header' => '<center>Calificaciones</center>',
                                    'type' => 'raw',
                                    'value' => array($this, 'columnaAccionesCalificarAsignaturas'),
                                    'htmlOptions' => array('width' => '5%')
                                ),
                                array(
                                    'header' => '<center>Asistencia</center>',
                                    'type' => 'raw',
                                    'value' => array($this, 'columnaAccionesAsistencia'),
                                    'htmlOptions' => array('width' => '5%')
                                ),
                                array(
                                    'header' => '<center>Observación</center>',
                                    'type' => 'raw',
                                    'value' => array($this, 'columnaAccionesObservacion'),
                                    'htmlOptions' => array('width' => '20%')
                                )
                            ),
                        ));
                        ?>

                    </div>  

                </div>


                <div class="space-6"></div>
                <?php
                $countCalificaciones = AsignaturaEstudiante::model()->obtenerCantidadAsignaturasCalificadas($id, $lapso);
                if ($countCalificaciones[0]['count'] <= 0):
                    ?>
                    <hr>
                    <div class="row-fluid wizard-actions">

                        <button class="btn btn-primary btn-next" id="guardarCalificacion" data-last="Finish ">
                            Guardar
                            <i class=" icon-save"></i>
                        </button>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<div class="row-fluid">

    <a class="btn btn-danger" href="<?php echo '/planteles/calificaciones/index/id/' . base64_encode($seccion_id) . '/plantel/' . base64_encode($plantel_id); ?>">

        <i class="icon-arrow-left bigger-110"></i>
        Volver
    </a>
</div>
<div id="dialogo_confirmacion" class="hide"><p></p></div>
<?php
$this->endWidget();

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/calificaciones.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/fuelux/fuelux.spinner.min.js', CClientScript::POS_END);
?>
<input id="id" type="hidden" name="id" value="<?php echo base64_encode($id) ?>"/>