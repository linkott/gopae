<?php
/* @var $this CargoController */
/* @var $data Cargo */
?>

<div class="widget-box">
       <div class="widget-header">
            <h5>Datos Personales</h5>

            <div class="widget-toolbar">
                <a>
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="form">
                <div class="widget-body">
       
                <div class="widget-main form">

                    <div class="row">

                        <div class="col-md-12">
                            <label class="col-md-12" ><b>Nombre:</b></label>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12">
                                 <div class="col-md-12" style="border: 1px solid #ccc; background-color:#FAFAFA; margin-bottom: 20px;"><?php echo $model->nombre; ?></div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">

                        <div class="col-md-12">
                            <label class="col-md-12" ><b>Siglas:</b></label>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12">
                                 <div class="col-md-12" style="border: 1px solid #ccc; background-color:#FAFAFA; margin-bottom: 20px;"><?php echo $model->siglas; ?></div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">

                        <div class="col-md-12">
                            <label class="col-md-12"><b>Observación o Descripción:</b></label>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-12" style="border: 1px solid #ccc; background-color:#FAFAFA; margin-bottom: 20px;"><?php if(strlen($model->observacion)>0){ echo $model->observacion;}else{ echo "NO TIENE";} ?></div>
                            </div>
                        </div>


                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <label class="col-md-12" ><b>Creado por:</b></label>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="col-md-12">
                                 <div class="col-md-12" style="border: 1px solid #ccc; background-color:#FAFAFA; margin-bottom: 20px;"><?php echo $model->usuarioIni->nombre . " " . $model->usuarioIni->apellido; ?></div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-md-12" ><b>Fecha de Creación:</b></label>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-12" style="border: 1px solid #ccc; background-color:#FAFAFA; margin-bottom: 20px;"><?php echo date("d-m-Y H:i:s", strtotime($model->fecha_ini)); ?></div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-md-12" ><b>Estatus:</b></label>
                        </div>
                      
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-12" style="border: 1px solid #ccc; background-color:#FAFAFA; margin-bottom: 20px;">
                                <?php
                                if ($model->estatus == "A") {
                                    echo "Activo";
                                } else if ($model->estatus == "E") {
                                    echo "Inactivo";
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <?php if ($model->usuarioAct) { ?>
                            <div class="col-md-12">
                                <label class="col-md-12" ><b>Modificado por:</b></label>
                            </div>
                        
                         <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-12" style="border: 1px solid #ccc; background-color:#FAFAFA; margin-bottom: 20px;">
                                     <?php echo $model->usuarioAct->nombre . " " . $model->usuarioAct->apellido; ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php } ?>
                    </div>

                    <div class="row">
                        <?php if ($model->usuarioAct) { ?>
                            <div class="col-md-12">
                                <label class="col-md-12"><b>Fecha de Actualización:</b></label>
                            </div>
                      
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-12" style="border: 1px solid #ccc; background-color:#FAFAFA; margin-bottom: 20px;"><?php echo date("d-m-Y H:i:s", strtotime($model->fecha_act)); ?></div>
                            </div>
                        </div>
                        
                        <?php } ?>
                    </div>
                    <div class="row">
                        <?php if ($model->estatus == "E") { ?>
                            <div class="col-md-12">
                                <label class="col-md-12"><b>Inhabilitado el:</b></label>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="col-md-12" style="border: 1px solid #ccc; background-color:#FAFAFA; margin-bottom: 20px;"><?php echo date("d-m-Y H:i:s", strtotime($model->fecha_elim)); ?></div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>    
        </div>
</div>
   
  