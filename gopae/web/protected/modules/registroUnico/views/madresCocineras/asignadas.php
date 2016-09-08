<?php
/* @var $this MadresCocinerasasController */

$this->pageTitle = 'Madres y Padres Cocineros del Plantel';

$this->breadcrumbs = array(
    'Registro Único de Planteles' => array('/registroUnico/plantelesPae/lista'),
    'Institución Educativa' => array('/registroUnico/plantelesPae/edicion/id/'.base64_encode($plantel['id'])),
    'Cocineros(a) Escolares',
);

$this->renderPartial('planteles.views.consultar._infoPlantelPae', array('plantel' => $plantel));
?>
<div class="row">
    <div class="col-md-12">
        <div class="widget-box">
            <div class="widget-header">
                <h5>Madres y Padres Cocineros CNAE del Plantel</h5>

                <div class="widget-toolbar">
                    <a data-action="collapse" href="#">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-body-inner">
                    <div class="widget-main">
                        <div class="widget-main form">

                            <div class="row-fluid">

                                <div class="tabbable">

                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#asignacion" data-toggle="tab">Asignación</a></li>
                                        <li><a href="#asistencia" data-toggle="tab">Asistencia</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <?php $this->widget('ext.loading.LoadingWidget'); ?>
                                        <div class="tab-pane active" id="asignacion">
                                            <?php
                                            if (strtoupper($plantel['pae_activo']) == 'SI'):

                                                $this->renderPartial('_formAsignacionCocinerasPae', array('plantel' => $plantel, 'estatusAutoridadPlantel' => $estatusAutoridadPlantel));
                                                ?>
                                                <?php
                                                Yii::app()->clientScript->registerScriptFile(
                                                        Yii::app()->request->baseUrl . '/public/js/pnotify.custom.min.js', CClientScript::POS_END
                                                );
                                                Yii::app()->clientScript->registerScriptFile(
                                                        Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END
                                                );
                                                Yii::app()->clientScript->registerScriptFile(
                                                        Yii::app()->request->baseUrl . '/public/js/modules/registroUnico/madresCocineras/asignadas.js', CClientScript::POS_END
                                                );
                                                Yii::app()->clientScript->registerScriptFile(
                                                        Yii::app()->request->baseUrl . '/public/js/modules/registroUnico/madresCocineras/fotografia.js', CClientScript::POS_END
                                                );
//                                                Yii::app()->clientScript->registerScriptFile(
//                                                        Yii::app()->request->baseUrl . '/public/js/modules/registroUnico/madresCocineras/asistencia.js', CClientScript::POS_END
//                                                );
                                            else:
                                                ?>
                                                <div class="row">
                                                    <?php
                                                    $this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => 'El Plantel no posee Activo el Programa de Alimentación Escolar (PAE). Si desea solicitar la Activación del beneficio PAE para este plantel, comuniquese con la Coordinación del PAE de la Zona Educativa o notifiquelo a la Coordinación Nacional.'));
                                                    ?>
                                                </div>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                        <div class="tab-pane" id="asistencia">
                                            <?php $this->renderPartial('_formAsistenciaCocinerasPae', array('plantel' => $plantel, 'estatusAutoridadPlantel' => $estatusAutoridadPlantel, 'mesEscolarPae' => $mesEscolarPae, 'modelMesEscolarPae' => $modelMesEscolarPae, 'periodoEscolarActivo' => $periodoEscolarActivo, 'model' => $modelMadresCocinerasPlantel, 'dataProvider' => $dataProviderMadresCocinerasPlantel)); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
