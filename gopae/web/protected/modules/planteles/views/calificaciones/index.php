<?php
$this->breadcrumbs = array(
    'Planteles' => array('/planteles'),
    'Secciones' => array('/planteles/seccionPlantel/admin/id/' . base64_encode($plantel_id)),
    'Calificaciónes'
);
?>
<div class = "widget-box collapsed">

    <div class = "widget-header">
        <h5>Identificación del Plantel <?php echo '"' . $datosPlantel['nom_plantel'] . '"'; ?></h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: none;" class = "widget-body-inner">
            <div class = "widget-main">

                <div class="row row-fluid">
                    <?php $this->renderPartial('_informacionPlantel', array('datosPlantel' => $datosPlantel)); ?>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="widget-box collapsed">
    <div class = "widget-header">
        <h5>Datos de la Sección</h5>
        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>
    </div>
    <div class = "widget-body">
        <div style = "display:block;" class = "widget-body-inner">
            <div class = "widget-main">
                <div class="row row-fluid">
                    <div id="msgAlerta">
                    </div>

                    <div class = "col-lg-12"><div class = "space-6"></div></div>
                    <div id="gridEstudiantes" class="col-md-12" >
                        <div class="widget-main form">

                            <div class="row">

                                <div class="col-md-11" id ="detallesSec">

                                    <?php $this->renderPartial('_informacionSeccion', array('datosSeccion' => $datosSeccionInfo)); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="widget-box">
    <div class = "widget-header">
        <h5>Calificaciónes <?php echo $datosSeccion['grado'] . ' Sección "' . $datosSeccion['seccion'] . '"'; ?></h5>
        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class = "widget-body">
        <div style = "display:block;" class = "widget-body-inner">
            <div class = "widget-main">

                <div id="msgAlerta">
                </div>

                <?php
                echo CHtml::hiddenField('plantel_id', $plantel_id);
                echo CHtml::hiddenField('seccion_plantel_id', $seccion_plantel_id);
                ?>
                
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div id ="estudiantesIns">
                        </div>
                        <div>

                            <?php
                            //var_dump(SeccionPlantel::model()->existeEstudiantesInscriptosEnSeccion($seccion_plantel_id));

                            $this->widget(
                                    'zii.widgets.grid.CGridView', array(
                                'id' => 'estudiantesInscrit',
                                'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                'dataProvider' => InscripcionEstudiante::model()->InscritosPorSeccion($seccion_plantel_id),
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
                                        'type'=>'html'
                                    ),
                                    array(
                                        'name' => 'nomape',
                                        'header' => '<center><b>Nombre y Apellido</b></center>'
                                    ),
                                    array(
                                        'type' => 'raw',
                                        'header' => '<center><b>Acciones</b></center>',
                                        'htmlOptions'=>array('nowrap'=>'nowrap'),
                                        'value' => array($this, 'columnaAcciones'),
                                        'htmlOptions' => array('width' => '5%'),
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="col-md-12">
    <div class="col-md-6">
        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("/planteles/seccionPlantel/admin/id/" . base64_encode($plantel_id)); ?>" class="btn btn-danger">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
    </div>



</div>

<div id="dialogPantalla"></div>

<div class ="hide" id="incluir_Estudiante" ></div>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/pnotify.custom.min.css" media="screen, projection" />
<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/calificaciones.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/pnotify.custom.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
?>

<script>
    $(document).ready(function() {

    });
</script>


