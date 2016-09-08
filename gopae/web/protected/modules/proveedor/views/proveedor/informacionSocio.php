<?php
/* @var $this NivelController */
/* @var $data Nivel */
?>

<div class="view">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#datosGenerales" data-toggle="tab">Datos Generales</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="datosGenerales">
                <div class="widget-main form">
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Rif:</b></label>
                        </div>
                        <div class="col-md-8">
                            <label><?php echo $model->rif; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Nombres:</b></label>
                        </div>
                        <div class="col-md-8">
                            <label><?php echo $model->nombres; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Apellidos:</b></label>
                        </div>
                        <div class="col-md-8">
                            <label><?php echo $model->apellidos; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Tel&eacute;fono Celular:</b></label>
                        </div>
                        <div class="col-md-8">
                            <label><?php echo $model->telefono_celular; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>Correo:</b></label>
                        </div>
                        <div class="col-md-8">
                            <label><?php echo $model->correo; ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label><b>¿Posee Certificado De Salud?:</b></label>
                        </div>
                        <div class="col-md-8">
                            <label>
                                <?php
                                $cs = $model->certificado_salud;
                                if ($cs == 1) {
                                    echo 'SI';
                                } else {
                                    echo 'NO';
                                }
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="row">  
                        <div class="col-md-4">
                            <label><b>Fecha de Creación:</b></label>		
                        </div>

                        <div class="col-md-4">
                            <label><?php echo CHtml::encode(date("d-m-Y H:i:s", strtotime($model->fecha_ini))); ?></label>				
                        </div>
                    </div>

                    <div class="row">  
                        <div class="col-md-4">
                            <label><b>Estatus:</b></label>		
                        </div>
                        <div class="col-md-4">
                            <label>
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
                        <?php if ($model->usuario_act_id) { ?>
                            <div class="col-md-4">
                                <label class="" ><b>Modificado por:</b></label>		
                            </div>

                            <div class="col-md-6">
                                <label class="" >
                                    <?php
                                    $datos = Nivel::model()->datosUsuario($model->usuario_ini_id);
                                    echo $datos['nombre'] . ' ' . $datos['apellido'] . ' (' . $datos['username'] . ')';
                                    ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="row">  
                        <?php if ($model->usuario_act_id) { ?>
                            <div class="col-md-4">
                                <label class=""><b>Fecha de Actualización:</b></label>
                            </div>

                            <div class="col-md-6">
                                <label class="">
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
        </div>
    </div>
</div>