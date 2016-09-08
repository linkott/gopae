<form id="form-autoridad-fotografia" name="form-autoridad-fotografia" method="POST" action="/registroUnico/plantelesPae/registroFotografiaAutoridad/id/<?php echo base64_encode($model->id); ?>">
    <div class="widget-box">

        <div class="widget-header">
            <h5>Fotografía</h5>

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
                            
                            <div id="resultadoRegistroFotografia">
                                <div class="infoDialogBox">
                                    <p>
                                        Tome la fotografía de la autoridad, cuando esté de acuerdo con la fotografía obtenida, presione en el botón azul para "Registrar Fotografía".
                                    </p>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label for="Cargo_cedula">Cédula</label>
                                    <input id="Cargo_cedula" type="text" value="<?php echo $model->origen.'-'.$model->cedula; ?>" disabled class="span-12"/>
                                </div>

                                <div class="col-md-4">
                                    <label for="Cargo_nombre">Nombre</label>
                                    <input id="Cargo_nombre" type="text" disabled class="span-12" value="<?php echo $model->nombre; ?>"/>
                                </div>

                                <div class="col-md-4">
                                    <label for="Cargo_apellido">Apellido</label>
                                    <input id="Cargo_apellido" type="text" disabled class="span-12" value="<?php echo $model->apellido; ?>"/>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="space-6"></div>
                            </div>
                            
                            <div class="col-md-12">
                                <?php $fotografiaExistente = strlen($model->foto)>0 && is_file(str_replace('//', '/', Yii::app()->params['webDirectoryPath'].$model->foto)); ?>

                                <div class="col-md-5 top center">
                                    <div style="min-height: 270px; padding: 20px; background-color: #CCCCCC;">
                                        <video id="video" width="300" autoplay style="cursor: pointer;" title="Haga click para tomar una foto"></video>
                                    </div>
                                    <div class="space-6"></div>
                                    <button type="button" class="btn btn-success btn-xs <?php if($fotografiaExistente): ?>hide<?php endif; ?>" id="snap">
                                        <i class="fa fa-camera"></i> Tomar foto
                                    </button>
                                </div>
                                <div class="col-md-2 center">

                                </div>
                                <div class="col-md-5 center">
                                    <div style="min-height: 270px; padding: 20px; background-color: #CCCCCC;">
                                        <canvas class="hide" id="canvas" width="300" height="225"></canvas>
                                        <?php if($fotografiaExistente): ?>
                                            <img id="ImgPersonaFoto" class="" src="<?php echo $model->foto; ?>" />
                                            <input type="hidden" name="Persona[foto]" id="Persona_foto" value="<?php echo $model->foto; ?>" />
                                        <?php else: ?>
                                            <input type="hidden" name="Persona[foto]" id="Persona_foto" value="" />
                                        <?php endif; ?>
                                        <input type="hidden" id="fotoImgBase64" name="fotoImgBase64" />
                                    </div>
                                    <div class="space-6"></div>
                                    <?php if($fotografiaExistente): ?>
                                    <button type="button" class="btn btn-info btn-xs hide" id="cancel-snap-refresh">
                                        <i class="fa fa-arrow-left"></i> Cancelar
                                    </button>
                                    <button type="button" class="btn btn-info btn-xs" id="snap-refresh">
                                        <i class="fa fa-refresh"></i> Actualizar esta Foto
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
