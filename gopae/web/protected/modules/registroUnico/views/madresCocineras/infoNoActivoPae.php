<?php

$this->pageTitle = 'Plantel sin beneficio del PAE';

$this->breadcrumbs=$this->breadcrumbs = array(
    'Planteles' => array('/planteles/'),
    'Madres y Padres Cocineros',
);

$this->renderPartial('planteles.views.consultar._infoPlantel', array('plantel'=>$plantel));

?>
<div class="row">
    <div class="col-md-12">
        <div class="widget-box">
            <div class="widget-header">
                <h5>Madres y Padres Cocineros del CNAE en el Plantel</h5>

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
                            <div class="row">
                                <?php
                                    $this->renderPartial('//msgBox', array(
                                        'class' => 'errorDialogBox',
                                        'message' => 'Este Plantel no está registrado como beneficiario del Programa de Alimentación Escolar (PAE). Si desea solicitar el beneficio del PAE para este plantel, comuniquese con la Coordinación del PAE de la Zona Educativa o notifiquelo a la Coordinación Nacional del PAE la cual efectuará su registro. Esto lo debe hacer antes de Efectuar el Registro de Madres y Padres Colaboradores.',
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
