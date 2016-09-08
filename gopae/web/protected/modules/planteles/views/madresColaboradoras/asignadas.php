<?php
/* @var $this MadresColaboradorasController */

$this->pageTitle = 'Madres y Padres Colaboradores del Plantel';

$this->breadcrumbs = array(
    'Planteles' => array('/planteles/'),
    'Madres y Padres Colaboradores',
);

$this->renderPartial('planteles.views.consultar._infoPlantelPae', array('plantel' => $plantel));
?>
<div class="row">
    <div class="col-md-12">
        <div class="widget-box">
            <div class="widget-header">
                <h5>Madres y Padres Colaboradores PAE en el Plantel</h5>

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

                                        <div class="tab-pane active" id="asignacion">
                                            <?php
                                            if (strtoupper($plantel['pae_activo']) == 'SI'):

                                                $this->renderPartial('_formAsignacionColaboradorPae', array('plantel' => $plantel, 'estatusAutoridadPlantel' => $estatusAutoridadPlantel));
                                                ?>
                                                <?php
                                                Yii::app()->clientScript->registerScriptFile(
                                                        Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END
                                                );
                                                Yii::app()->clientScript->registerScriptFile(
                                                        Yii::app()->request->baseUrl . '/public/js/modules/planteles/madresColaboradoras/asignadas.js', CClientScript::POS_END
                                                );
                                                Yii::app()->clientScript->registerScriptFile(
                                                        Yii::app()->request->baseUrl . '/public/js/modules/planteles/madresColaboradoras/asistencia.js', CClientScript::POS_END
                                                );
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
                                            <?php $this->renderPartial('_formAsistenciaColaboradorPae', array('plantel' => $plantel, 'estatusAutoridadPlantel' => $estatusAutoridadPlantel, 'mesEscolarPae' => $mesEscolarPae, 'modelMesEscolarPae' => $modelMesEscolarPae, 'periodoEscolarActivo' => $periodoEscolarActivo, 'model' => $modelMadresColaboradorasPlantel, 'dataProvider' => $dataProviderMadresColaboradorasPlantel)); ?>
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