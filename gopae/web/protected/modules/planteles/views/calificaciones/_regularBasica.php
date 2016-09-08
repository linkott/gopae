<?php
$this->breadcrumbs = array(
    'Planteles' => array('/planteles'),
    'Secciones' => array('/planteles/seccionPlantel/admin/id/' . base64_encode($plantel_id)),
    'Calificaciónes' => array('/planteles/calificaciones/index/id/' . base64_encode($seccion_id) . '/plantel/' . base64_encode($plantel_id)),
    'Notas'
);


?>

<?php $this->renderPartial('_informacionEstudiante', array('datosEstudiante' => $datosEstudiante)); ?>
<?php $this->renderPartial('_total_clases', array('datosSeccion' => $datosSeccionInfo, 'lapso'=>base64_decode($lapso))); ?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'regular-basica-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class = "widget-box">

    <div class = "widget-header">
        <h5>Evaluación <?php echo '"' . $datosEstudiante[0]['nombres'] . ' ' . $datosEstudiante[0]['apellidos'] . '"'; ?>   Lapso <?php echo base64_decode($lapso); ?></h5>
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
                        <div id="respuestaRegistro" class="hide">
                        </div>
                        <label class="col-md-12"><b>Resumen Evaluativo:</b></label>
                         <?php
                        if (!$model->resumen_evaluativo):?>
                        <div id="editor1" class="wysiwyg-editor" style="border:1px solid #ccc;" contenteditable="true">                      
                        </div>
                        <?php endif;?>
                        <?php
                        if ($model->resumen_evaluativo):
                            echo "<div class='wysiwyg-editor'>";
                            echo CHtml::decode($model->resumen_evaluativo);
                            echo "</div>";
                            endif;
                        ?>

                        <input type="hidden" name="lapso" value="<?php echo $lapso; ?>"/>
                        <input type="hidden" name="asignatura_id" value="<?php echo base64_encode($asignatura_id); ?>"/>
                        <?php
                        if (!$model->resumen_evaluativo):
                            echo $form->textArea($model, 'resumen_evaluativo', array('id' => 'resumen_evaluativo', 'readonly' => 'true', 'hidden' => 'hidden', 'required' => 'required'));
                        endif;
                        ?>
                    </div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <?php if (base64_decode($lapso) == 3): ?>


                        <div class="col-md-6">
                            <label class="col-md-12"><b>Calificación Nominal:</b></label>
                            <div class="col-md-4">
                                <?php
                                if (!$model->calif_nominal):
                                    echo $form->dropDownList($model, 'calif_nominal', CHtml::listData(CalificacionNominal::model()->findAllByAttributes(array('estatus' => 'A'), array('order' => 'acronimo ASC')), 'id', 'acronimo'), array('empty' => '-Seleccione-', 'class' => 'span-7', 'required' => 'required'));
                                endif;
                                if ($model->calif_nominal):
                                    if($model->calif_nominal==1):
                                        echo "A";
                                    endif;
                                    if($model->calif_nominal==2):
                                        echo "B";
                                    endif;
                                    if($model->calif_nominal==3):
                                        echo "C";
                                    endif;
                                    if($model->calif_nominal==4):
                                        echo "D";
                                    endif;
                                    if($model->calif_nominal==5):
                                        echo "E";
                                    endif;
                                    if($model->calif_nominal==6):
                                        echo "F";
                                    endif;
                                endif;
                                ?>
                            </div>
                        </div>


                    <?php endif; ?>
                    <div class="col-md-6">
                        <label class="col-md-12"><b>Asistencia:</b></label>
                        <div class="col-md-4">
                            <?php
                            if (strlen($model->asistencia)<=0){
                                echo $form->textField($model, 'asistencia', array('id' => 'asistencia', 'class' => 'indeas span-2', 'required' => 'required'));
                            }else {
                                echo CHtml::encode($model->asistencia);
                            }
                            
                            ?>
                        </div>
                    </div>

                </div>
                <div class="space-6"></div>
                <div class="row-fluid wizard-actions">
                  
                    <?php if (!$model->id): ?>
                        <button class="btn btn-primary btn-next" id="guardarCalificacionBasica" data-last="Finish ">
                            Guardar
                            <i class=" icon-save"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<br>
 <div class="row-fluid">
                    <a class="btn btn-danger" href="<?php echo '/planteles/calificaciones/index/id/' . base64_encode($seccion_id) . '/plantel/' . base64_encode($plantel_id); ?>">

                        <i class="icon-arrow-left bigger-110"></i>
                        Volver
                    </a>
 </div>
<div id="dialogo_confirmacion" class="hide"><p></p></div>
<?php $this->endWidget(); ?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/calificaciones.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/bootstrap-wysiwyg.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/markdown/markdown.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.hotkeys.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
?>
