<?php
$this->breadcrumbs = array(
    'Planteles' => array('/planteles'),
    'Secciones' => array('/planteles/seccionPlantel/admin/id/' . base64_encode($plantel_id)),
    'Inscripción'
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
<div class="widget-box">
    <div class = "widget-header">
        <h5>Inscripción Inicial <?php echo $datosSeccion['grado'] . ' Sección "' . $datosSeccion['seccion'] . '"'; ?></h5>
        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class = "widget-body">
        <div style = "display:block;" class = "widget-body-inner">
            <div class = "widget-main">
                <div class="row row-fluid">
                    <div id="msgAlerta">
                    </div>
                    <div class="row col-md-12">
                        <?php
                        echo CHtml::hiddenField('plantel_id', $plantel_id);
                        echo CHtml::hiddenField('seccion_plantel_id', $seccion_plantel_id);
                        ?>
                           
                        <div class="col-md-12">
                         
                            <div class="col-md-12">
                                <div class="row  col-md-12 pull-right">
                                    <div class = "pull-right wizard-actions" style = "padding-left:10px;">
                                        <button id="btnRegistroNuevo" data-last = "Finish" class = "btn btn-success btn-next btn-sm tooltipMatricula" title="Registre rápidamente un nuevo estudiante para su inscripción">
                                            Registrar Nuevo Estudiante
                                            <i class = "fa fa-plus icon-on-right"></i>

                                        </button>
                                    </div>
                                    
                                    <div class = "pull-right wizard-actions" style = "padding-left:10px;">
                                        <button id="btnIncluirEst" data-last = "Finish" title="Buscar un estudiante ya registrado que no aparezca en el listado de 'Estudiantes Disponibles para la Inscripción'." class = "btn btn-success btn-next btn-sm tooltipMatricula">
                                            Buscar Estudiante Existente
                                            <i class="fa fa-search-plus icon-on-right"></i>
                                        </button>
                                    </div>
                                    
                                    <div style="padding-left:10px;" class="pull-right wizard-actions">
                                        <button id="linkDialogAyuda" title="Si tiene alguna duda sobre el proceso de matriculación presione aquí" class="btn btn-primary btn-next btn-sm tooltipMatricula">
                                            Ayuda
                                            <i class="fa fa-question icon-on-right"></i>
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class = "col-lg-12"></div>
                    <div class="col-md-12">
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <h5><strong>Estudiantes disponibles para la Inscripción</strong></h5>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <h5><strong>Estudiantes Pre-Inscritos</strong></h5>
                            </div>
                        </div>

                    </div>
                    <div id="gridEstudiantes" class="col-md-12" >
                        <?php $this->renderPartial('_gridEstudiantes', array('inscritos' => $inscritos, 'dataProviderIns' => $dataProviderIns, 'dataProviderPen' => $dataProviderPen)); ?>
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
            <?php $this->renderPartial('/_accionesSobrePlantel', array('plantel_id' => $plantel_id)) ?>
        </div>
        <div class="col-md-6 wizard-actions">

            <button id="btnGuardarInscripcion" type="submit" data-last="Finish" class="btn btn-primary btn-next">
                Siguiente
                <i class="icon-arrow-right icon-on-right"></i>
            </button>
        </div>


    </div>

    <div id="dialogPantalla"></div>
    <div id="confirm" class="hide center">

        <div class="alert alert-info ">
            <p> ¿ Esta seguro que son todos los estudiantes que desea inscribir ?  </p>
            <p> En caso contrario presione el botón Cancelar y verifique. </p>
        </div>

    </div>
    <div id="dialogoAyuda" class="hide" >
        <div class="alert alert-info ">
            <p> <b>1.-</b> El botón <b style="color: #00be67">"Registrar Nuevo Estudiante"</b> permite efectuar el registro rápido de un nuevo estudiante para su inscripción en esta sección. Cuando se culmine el proceso de registro del nuevo estudiante el mismo sera agregado al listado de <b style="color: #222a2d">"Estudiantes Pre-Inscritos"</b> en esta sección.</p>
        </div>
        <div class="alert alert-info ">
            <p> <b>2.-</b> El botón <b style="color: #00be67">"Buscar Estudiante"</b> permite efectuar una búsqueda de los estudiantes de dos formas, la primera efectua una busqueda de los estudiantes inscritos en el periodo anterior. La segunda, si tilda la opción <b>"Búsqueda Completa"</b> se realiza esta actividad en todos los registros de estudiantes a nivel nacional. Cuando se culmine el proceso de búsqueda y selección del estudiante el mismo sera agregado al listado de <b style="color: #222a2d">"Estudiantes Pre-Inscritos"</b> en esta sección.</p>
        </div>
        <div class="alert alert-info ">
            <p>
                <b>3.-</b> El listado de <b style="color: #222a2d">"Estudiantes disponibles para la Inscripción"</b> contendrá a todos aquellos estudiantes que fueron inscritos en este plantel, en el periodo anterior, dependiendo también del último grado en el que fue inscrito el estudiante.
            </p>
        </div>
        <div class="alert alert-info ">
            <p>
                <b>4.-</b> El listado de <b style="color: #222a2d">"Estudiantes Pre-Inscritos"</b> contendrá la lista de estudiantes seleccionados para ser inscritos en esta sección. Se debe tomar en cuenta que los estudiantes que hayan sido seleccionados mediante las opciones <b style="color: #00be67">"Registrar Nuevo Estudiante"</b> y <b style="color: #00be67">"Buscar Estudiante"</b> no se podrán regresar al listado de <b style="color: #222a2d">"Estudiantes disponibles para la Inscripción"</b>.
            </p>
        </div>
        <div class="alert alert-info ">
            <p>
                <b>5.-</b> Para pasar al Siguiente paso debe hacer click en el botón <b>"Siguiente"</b> en donde podrá efectuar la Caracterización de la Inscripción.
            </p>
        </div>
    </div>
</div>

<div class ="hide" id="incluir_Estudiante" ></div>
<div class="hide" id="dialog_peticion_activa">
    <div class="alertDialogBox">
        <p style="text-align: justify">
            Estimado usuario, en este momento se esta ejecutando una petición. Espere que dicha operación culmine e intente nuevamente.</p>
    </div>
</div>


<?php ?>
<script type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/pnotify.custom.min.css" media="screen, projection" />
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/matricula.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/pnotify.custom.min.js', CClientScript::POS_END);
