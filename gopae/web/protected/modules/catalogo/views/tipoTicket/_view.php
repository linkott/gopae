
<div class="view">

    <div class="tabbable">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#view">Datos Generales</a></li>
        </ul>

        <div class="tab-content">

            <div id="datosGenerales" class="tab-pane active">

                <div class="widget-main form">

                    <div class="row">

                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Tipo de Ticket:</b></label>
                        </div>

                        <div class="col-md-6">
                            <label class="col-md-12" ><?php echo CHtml::encode($model->nombre); ?></label>
                        </div>


                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Creado por:</b></label>
                        </div>
                        

                        <div class="col-md-6">
                            <label class="col-md-12" ><?php echo CHtml::encode($model->usuarioIni->nombre); ?></label>
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
                     <?php if ($model->usuarioAct) { ?>
                            <div class="col-md-6">
                                <label class="col-md-12" ><b>Modificado por:</b></label>
                            </div>

                            <div class="col-md-6">
                                <label class="col-md-12" >
                 <?php echo CHtml::encode($model->usuarioAct->nombre); ?>
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
            </div>
        </div>
    </div>
</div>
