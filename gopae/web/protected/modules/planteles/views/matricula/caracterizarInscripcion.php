<?php
$this->breadcrumbs = array(
    'Planteles' => array('/planteles'),
    'Secciones' => array('/planteles/seccionPlantel/admin/id/' . $plantel_id),
    'Inscripción' => array('/planteles/matricula/inscripcion/id/' . $seccion_plantel_id . '/plantel/' . $plantel_id),
    'Caracterizar Inscripción'
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
        <h5>Inscripción por Lotes <?php echo $datosSeccion['grado'] . ' Sección "' . $datosSeccion['seccion'] . '"'; ?></h5>
        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class = "widget-body">
        <div style = "display:block;" class = "widget-body-inner">
            <div class = "widget-main">
                <div class="row">
                    <div id="msgAlerta">
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12">

                            <div class="infoDialogBox">
                                <p><font size="2">Estimado usuario, en el caso que se le haya olvidado agregar algún estudiante, puede continuar el proceso de matriculación. Tras culminar dicha tarea podrá agregar los estudiantes que desee presionando sobre el botón <a target="_blank" href="/planteles/matricula/consultar/id/<?php echo $plantel_id; ?>"><i class="fa fa-user blue" title="Inscribir Estudiante"></i> </a> correspondiente a determinada sección ubicado en la lista de Secciones de este plantel.</font></p>
                            </div>

                        </div>
                        <?php
                        echo CHtml::hiddenField('plantel_id', $plantel_id);
                        echo CHtml::hiddenField('seccion_plantel_id', $seccion_plantel_id);
                        ?>
                        <div class="col-md-12">
                            <div class="row col-md-12">
                                <h5><strong>Preinscritos</strong></h5>
                            </div>
                        </div>
                        <div class = "col-lg-12"><div class = "space-6"></div></div>
                    </div>
                    <div id="gridEstudiantesPreInscritos" class="col-md-12">
                        <?php $this->renderPartial('_gridEstudPreInscritos', array('inscritos' => $inscritos, 'dataProvider' => $dataProvider, 'seccion_plantel_id' => $seccion_plantel_id, 'plantel_id' => $plantel_id, 'acciones' => $acciones)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="col-md-12">
    <div class="col-md-6">
        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("/planteles/matricula/inscripcion/id/" . $seccion_plantel_id . '/plantel/' . $plantel_id); ?>" class="btn btn-danger">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
    </div>
    <div class="col-md-6 wizard-actions pull-right">
        <button id="btnTerminarInscripcion" type="submit" data-last="Finish" class="btn btn-primary btn-next">
            Guardar
            <i class="icon-save icon-on-right"></i>
        </button>
    </div>
</div>
<div class="hide" id="dialogo"></div>
<div class="hide" id="dialog_error"><p></p></div>
<div class="hide" id="dialog_success"><p></p></div>
<div class="hide" id="dialog_peticion_activa">
    <div class="alertDialogBox">
        <p style="text-align: justify">
            Estimado usuario, en este momento se esta ejecutando una petición. Espere que dicha operación culmine e intente nuevamente.</p>
    </div>
</div>
<div id="confirm" class="hide center">
    <div class="alert alert-info ">
        <p> ¿ Esta seguro que desea volver a la página anterior ?  </p>
        <p> De hacerlo debera incluir nuevamente los estudiantes al Listado de Estudiantes Pre-Inscritos. </p>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/matricula.js', CClientScript::POS_END);




