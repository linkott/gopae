<?php
/* @var $this NivelController */
/* @var $data Nivel */
?>
<br>
<div class="view">

    <div class="tabbable">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>
            <?php if ($model->estatus == 'A' && $mostrarInscriptos == true) { ?>
                <li><a data-toggle="tab" href="#estudiantesInscriptos">Estudiantes Inscriptos</a></li>
            <?php } ?>
        </ul>

        <div class="tab-content">

            <div id="datosGenerales" class="tab-pane active">

                <div class="widget-main form">

                    <div class="row">                                                                

                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Nombre de sección:</b></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><?php echo CHtml::encode($model->seccion->nombre); ?></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Nivel:</b></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><?php echo CHtml::encode($model->nivel->nombre); ?></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Plan:</b></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><?php echo CHtml::encode($model->plan->nombre); ?></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Grado:</b></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><?php echo CHtml::encode($model->grado->nombre); ?></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Capacidad:</b></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><?php echo CHtml::encode($model->capacidad); ?></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Turno:</b></label>					
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><?php echo CHtml::encode($model->turno->nombre); ?></label>					
                        </div>

                    </div>

                    <div class="row">  

                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Creado por:</b></label>			
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><?php echo CHtml::encode($model->usuarioIni->nombre . " " . $model->usuarioIni->apellido); ?></label>
                        </div>

                    </div>

                    <div class="row">  
                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Fecha de Creación:</b></label>		
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><?php echo CHtml::encode(date("d-m-Y H:i:s", strtotime($model->fecha_ini))); ?></label>				
                        </div>
                    </div>

                    <div class="row">  
                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Estatus:</b></label>		
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12" >
                                <?php
                                if ($model->estatus == "A") {
                                    echo "Activo";
                                } else if ($model->estatus == "E") {
                                    echo "Inactivo";
                                }
                                ?>			
                            </label>
                        </div>
                    </div>		


                    <div class="row">                                                                
                        <?php if ($model->usuarioAct) { ?>
                            <div class="col-md-6">
                                <label class="col-md-12" ><b>Modificado por:</b></label>		
                            </div>

                            <div class="col-md-6">
                                <label class="col-md-12" >
                                    <?php echo CHtml::encode($model->usuarioAct->nombre . " " . $model->usuarioAct->apellido); ?>			
                                </label>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="row">  
                        <?php if ($model->usuarioAct) { ?>
                            <div class="col-md-6">
                                <label class="col-md-12"><b>Fecha de Actualización:</b></label>
                            </div>

                            <div class="col-md-6">
                                <label class="col-md-12">
                                    <?php echo CHtml::encode(date("d-m-Y H:i:s", strtotime($model->fecha_act))); ?>	
                                </label>
                            </div>
                        <?php } ?>	
                    </div>
                    <div class="row">  
                        <?php if ($model->estatus == "E") { ?>
                            <div class="col-md-6">
                                <label class="col-md-12"><b>Inhabilitado el:</b></label>
                            </div>

                            <div class="col-md-6">
                                <label class="col-md-12"><?php echo CHtml::encode(date("d-m-Y H:i:s", strtotime($model->fecha_elim))); ?></label>
                            </div>

                        <?php } ?>
                    </div>


                </div>
            </div>


            <div id="estudiantesInscriptos" class="tab-pane">

                <div class="widget-main form">

                    <div class="row">                                                                
                    
                    <div class="col-md-11" id ="estudiantesIns">
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
                                        );
                                    }
                                    ?> 
                                </div>
                        </div>

                </div>

            </div>


        </div> 

    </div>

</div>