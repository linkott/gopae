<?php
$this->breadcrumbs = array(
    'Planteles' => array('/planteles'),
    'Secciones' => array('/planteles/seccionPlantel/admin/id/' . base64_encode($plantel_id)),
    'Calificaciónes' => array('/planteles/calificaciones/index/id/' . base64_encode($seccion_id) . '/plantel/' . base64_encode($plantel_id)),
    'Notas'
);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'regular-media-general-form',
    'enableAjaxValidation' => false,
        ));
?>




<div class = "widget-box">

    <div class = "widget-header">
        <h5>Evaluación "materia" sección ""</h5>
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
                        <?php
                        
                        //var_dump(SeccionPlantel::model()->existeEstudiantesInscriptosEnSeccion($seccion_plantel_id));

                        $this->widget(
                                'zii.widgets.grid.CGridView', array(
                            'id' => 'estudiantesInscrit',
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'dataProvider' => InscripcionEstudiante::model()->InscritosPorSeccionDocente($seccion_id,$lapso),
                            'summaryText' => false,
                            'columns' => array(
                                array(
                                    'name' => 'cedula_escolar',
                                    'header' => '<center><b>Documento de Identidad</b></center>'
                                ),
                                array(
                                    'name' => 'fecha_nacimiento',
                                    'header' => '<center><b>Edad</b></center>',
                                    'value' => array($this, 'columnaEdad'),
                                    'type' => 'html'
                                ),
                                array(
                                    'name' => 'nomape',
                                    'header' => '<center><b>Nombre y Apellido</b></center>'
                                ),
                              
                                array(
                                    'header' => '<center><b>Calificaciones</b></center>',
                                    'type' => 'raw',
                                    'value' => array($this, 'columnaAccionesCalificarAsignaturas'),
                                    'htmlOptions' => array('width' => '5%')
                                ),
                                array(
                                    'header' => '<center><b>Asistencia</b></center>',
                                    'type' => 'raw',
                                    'value' => array($this, 'columnaAccionesAsistencia'),
                                    'htmlOptions' => array('width' => '5%')
                                ),
                                array(
                                    'header' => '<center><b>Observación</b></center>',
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
                <hr>

                <div class="row-fluid wizard-actions">
                    <button class="btn btn-primary btn-next" id="guardarCalificacion" data-last="Finish ">
                        Guardar
                        <i class=" icon-save"></i>
                    </button>
                </div>
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
<script>

</script>
