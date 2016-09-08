<?php
$this->breadcrumbs = array(
    'Consultar Planteles' => array('consultar/'),
    'Secciones por Plantel' => array("/planteles/seccionPlantel/admin/id/". base64_encode($plantel_id)),
    'Detalles de la Sección'
     //'Secciones' => array('consultar/admin/id'),
);
?>



<div class="widget-box">
    <div class = "widget-header">
            <h5>Identificación del Plantel <?php echo '"' . $datosPlantel['nom_plantel'] . '"'; ?></h5>
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
                 
                    <div class = "col-lg-12"><div class = "space-6"></div></div>
                    <div id="gridEstudiantes" class="col-md-12" >
                          <div class="widget-main form">

                    <div class="row">                                                                
                    
                    <div class="col-md-11" id ="detallesPlantel">
                    
                       <?php $this->renderPartial('_informacionPlantel', array('plantel_id' => $plantel_id,'datosPlantel' => $datosPlantel)); ?>
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
            <h5>Datos de la Sección</h5>
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
                 
                    <div class = "col-lg-12"><div class = "space-6"></div></div>
                    <div id="gridEstudiantes" class="col-md-12" >
                          <div class="widget-main form">

                    <div class="row">                                                                
                    
                    <div class="col-md-11" id ="detallesSec">
                    
                       <?php $this->renderPartial('_informacionSeccion', array('datosSeccion' => $datosSeccion)); ?>
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
        <h5><?php echo $model->grado->nombre . ' Sección "' . $model->seccion->nombre. '"'; ?></h5>
        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class = "widget-body">

            <div class = "widget-main">
                <div class="row row-fluid">
                    <div id="msgAlerta">
                    </div>
                    <div class="row col-md-12">
                        <?php
                        echo CHtml::hiddenField('plantel_id', $plantel_id);
                      //  echo CHtml::hiddenField('seccion_plantel_id', $seccion_plantel_id);
                        ?>
                        <div class="col-md-12">
                            <div class="col-md-7">
                                <div class="row col-md-12">
                                    <h5><strong>Lista de Estudiantes</strong></h5>
                                </div>
                            </div>
                     
                        </div>

                    </div>
                    <div class = "col-lg-12"><div class = "space-6"></div></div>
                    <div id="gridEstudiantes" class="col-md-12" >
                          <div class="widget-main form"><?php if($totalInscritos['count']!=0){?>  
                              <i><b>Total de estudiantes Inscritos: </b></i>&nbsp;<?php echo ' ' . $totalInscritos['count'] . '  '; ?>    
                    <div class="row">                                                                
                    
                    <div class="col-md-11" id ="estudiantesInscritos">
                    
                                     
                                    <?php
                                    //  var_dump(count($servicios));
                                   if (isset($dataProvider)) {
                                        // var_dump($dataProvider); 
                                        $this->widget(
                                                'zii.widgets.grid.CGridView', array(
                                            'id' => 'estudiantesInscrit',
                                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                            'dataProvider' => $dataProvider,
                                            'summaryText' => false,
                                           
                                            'columns' => array(
                                                array(
                                                    'name' => 'cedula_escolar',
                                                    'type' => 'raw',
                                                    'header' => '<center><b>Cédula Escolar</b></center>'
                                                ),
                                                array(
                                                    'name' => 'edad',
                                                    'type' => 'raw',
                                                    'header' => '<center><b>Edad</b></center>'
                                                ),
                                                array(
                                                    'name' => 'nomape',
                                                    'type' => 'raw',
                                                    'header' => '<center><b>Nombre y Apellido</b></center>'
                                                ),
                                                array(
                                                    'name' => 'cedula_identidad',
                                                    'type' => 'raw',
                                                    'header' => '<center><b>Cédula del Representante</b></center>'
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
                                        );  }else{ echo '<div class="infoDialogBox">
                                                          <p>
                                                              Esta seccion no tiene ningún estudiante inscrito.
                                                          </p>
                                                      </div>';
                                                    }
                                    ?>
                                   
                                </div>
                        </div>
                          <?php  }else{ echo '<div class="infoDialogBox">
                                                          <p>
                                                             Esta seccion no tiene ningún estudiante inscrito.
                                                          </p>
                                                      </div>';
                                                    }?>
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
            <?php $this->renderPartial('/_accionesSobrePlantel', array('plantel_id' => $plantel_id)) ?>
        </div>
    


    </div>
    
    <div id="dialogPantalla"></div>

    <div class ="hide" id="incluir_Estudiante" ></div>
