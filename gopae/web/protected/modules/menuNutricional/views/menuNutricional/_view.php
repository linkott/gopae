<?php
$this->pageTitle = 'Menú: '.$model->nombre;
$this->breadcrumbs = array(
    'Menú Nutricional' => array('index'),
    $model->nombre,
);
?>
<div class="view">

    <div class="tabbable">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>
            <li><a data-toggle="tab" href="#ingredientes">Ingredientes</a></li>
        </ul>

        <div class="tab-content">

            <div id="datosGenerales" class="tab-pane active">
                
                <div class="widget-box">
                    <div class="widget-header">
                        <h5>Datos de Menú Nutricional</h5>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="icon-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main form">

                            <div class="row">
                                <div class="col-md-12" >
                                    <div class="col-md-12">
                                        <label class="col-md-12" ><b>Nombre</b></label>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="data-read" ><?php echo CHtml::encode($model->nombre); ?></label>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6" >
                                    <div class="col-md-12">
                                        <label class="col-md-12" ><b>Precio Baremo</b></label>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="data-read" ><?php echo CHtml::encode($model->precio_baremo)." Bs." ; ?></label>
                                    </div>
                                </div>


                                <div class="col-md-6" >
                                    <div class="col-md-12">
                                        <label class="col-md-12" ><b>Precio Mercado</b></label>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="data-read" ><?php echo CHtml::encode($model->precio_mercado)." Bs."; ?></label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="col-md-12">
                                    <label class="col-md-12">
                                        <b>Preparación</b>
                                    </label>

                                    <?php if (isset($model->preparacion)) { ?>
                                        <div class="col-md-12"  >
                                            <div style="border:1px solid #ccc; padding-left: 5px; min-height:100px;">
                                                <?php echo $model->preparacion; ?>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="col-md-12"  >
                                            <div class="col-md-12" style="border:1px solid #ccc; min-height:100px;">
                                                <?php echo "No posee datos de la preparación"; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?> 
                                </div>
                            </div>
                                </div>
                            <hr>
                            <div class="row">

                                <div class="col-md-3">
                                    <label class="col-md-12" ><b>Creado por:</b></label>
                                </div>

                                <div class="col-md-9">
                                    <label class="data-read" ><?php echo $model->usuarioIni->nombre . " " . $model->usuarioIni->apellido; ?></label>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="col-md-12" ><b>Fecha de Creación:</b></label>
                                </div>

                                <div class="col-md-9">
                                    <label class="data-read" ><?php echo date("d-m-Y H:i:s", strtotime($model->fecha_ini)); ?></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="col-md-12" ><b>Estatus:</b></label>
                                </div>
                                <div class="col-md-9">
                                    <label class="data-read" >
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
                                    <div class="col-md-3">
                                        <label class="col-md-12" ><b>Modificado por:</b></label>
                                    </div>

                                    <div class="col-md-9">
                                        <label class="data-read" >
                                            <?php echo $model->usuarioAct->nombre . " " . $model->usuarioAct->apellido; ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <?php if ($model->usuarioAct) { ?>
                                    <div class="col-md-3">
                                        <label class="col-md-12"><b>Fecha de Actualización:</b></label>
                                    </div>

                                    <div class="col-md-9">
                                        <label class="data-read">
                                            <?php echo date("d-m-Y H:i:s", strtotime($model->fecha_act)); ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php if ($model->estatus == "E") { ?>
                                    <div class="col-md-3">
                                        <label class="col-md-12"><b>Inhabilitado el:</b></label>
                                    </div>

                                    <div class="col-md-9 data-read">
                                        <label class="col-md-12"><?php echo date("d-m-Y H:i:s", strtotime($model->fecha_elim)); ?></label>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
             <div id="ingredientes" class="tab-pane">

                <?php
                if ($model->id !== NULL) {
                    $this->renderPartial('_viewIngredientes', array('model' => $model));
                } else {
                    ?>
                    <div id='alertMenuAlimento' class="alertDialogBox">
                        <p>
                            No se han cargado ingredientes.
                        </p>
                    </div>
                    <?php
                }
                ?>

            </div>
            
            
            
        </div>
    </div>
    <div class="row-fluid ">
        <div class="col-md-12 space-6"></div>
                    <a class="btn btn-danger" href="/menuNutricional/menuNutricional/">
                        <i class="icon-arrow-left bigger-110"></i>
                        Volver
                    </a>
    </div>
</div>