<div class="view">

    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>
        </ul>

        <div class="tab-content">

            <div id="datosGenerales" class="tab-pane active">

                <div class="widget-main form">

                    <div class="row">

                        <div class="col-md-6">
                            <label class="col-md-12" ><b>Nombre:</b></label>
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
                                    echo "Eliminado";
                                }
                                ?>
                            </label>
                        </div>
                    </div>


                    <div class="row">
                        <?php if (!empty($model->usuarioAct)): ?>
                            <div class="col-md-6">
                                <label class="col-md-12" ><b>Modificado por:</b></label>
                            </div>

                            <div class="col-md-6">
                                <label class="col-md-12" >
                                    <?php echo CHtml::encode($model->usuarioAct->nombre . " " . $model->usuarioAct->apellido); ?>
                                </label>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <?php if (empty($model->usuarioAct)): ?>
                            <div class="col-md-6">
                                <label class="col-md-12"><b>Fecha de Actualización:</b></label>
                            </div>

                            <div class="col-md-6">
                                <label class="col-md-12">
                                    <?php echo CHtml::encode(date("d-m-Y H:i:s", strtotime($model->fecha_act))); ?>
                                </label>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <?php if ($model->estatus == "E"): ?>
                            <div class="col-md-6">
                                <label class="col-md-12"><b>Inhabilitado el:</b></label>
                            </div>

                            <div class="col-md-6">
                                <label class="col-md-12"><?php echo CHtml::encode(date("d-m-Y H:i:s", strtotime($model->fecha_elim))); ?></label>
                            </div>

                        <?php endif; ?>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>