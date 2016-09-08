
<?php $resultado = PeriodoEscolar::model()->buscar($model->id); ?>


<div class="view">

    <div class="tabbable">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>
        </ul>

        <div class="tab-content">

            <div id="datosGenerales" class="tab-pane active">

                <div class="widget-main form">

                    <?php foreach ($resultado as $r) { ?>
                        <?php $fecha_creacion = date("d-m-Y H:i:s", strtotime($r['fecha_ini'])); ?>


                        <?php $fecha_eliminacion = date("d-m-Y H:i:s", strtotime($r['fecha_elim'])); ?>

                        <div class="row">

                            <div class="col-md-6">
                                <label class="col-md-12" ><b>Periodo:</b></label>
                            </div>

                            <div class="col-md-6">
                                <label class="col-md-12" ><?php echo $r['periodo']; ?></label>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <label class="col-md-12" ><b>Creado por:</b></label>
                            </div>

                            <div class="col-md-6">
                                <label class="col-md-12" ><?php echo $r['nombre']; ?></label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-md-12" ><b>Fecha de Creación:</b></label>
                            </div>

                            <div class="col-md-6">
                                <label class="col-md-12" ><?php echo $fecha_creacion; ?></label>
                            </div>
                        </div>




                    <?php } ?>



                </div>
            </div>
        </div>
    </div>


