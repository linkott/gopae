<div class="infoDialogBox">
    <p>
        Seleccione un Tipo de Serial para el Banco e indique su numero.
    </p>
</div>

<div class="widget-box">
    <div class="widget-header">
        <h5>Tipos de Serial de cuenta del Banco - <?php echo $model->nombre; ?></h5>

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
                        <div id="mensajeTipoSerialCuentaBanco"></div>
                        <div id="divSelectTipoSerialCuentaBanco">
                            <?php $this->renderPartial('_formListaTipoSerialCuentaBanco', array('model'=>$model, 'tiposSerialDeCuentaProvider'=>$tiposSerialDeCuentaProvider, 'tipoSerialCuentaSelect'=>$tipoSerialCuentaSelect)); ?>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hide" id="deleteTipoSerialCuentaBancoDialog">
    <div class="alertDialogBox">
        <p>&iquest;Desea usted Eliminar este Tipo de Serial?</p>
    </div>
</div>

<div class="hide" id="tipoSerialCuentaBancoDialog">
    <?php $this->renderPartial('_formTipoSerialCuentaBanco', array('model'=>new TipoSerialCuentaBanco())); ?>
</div>