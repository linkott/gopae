<div class="infoDialogBox">
    <p>
        Seleccione un Tipo de Cuenta para el Banco e ingrese un Identificador.
    </p>
</div>

<div class="widget-box">
    <div class="widget-header">
        <h5>Tipos de cuenta del Banco - <?php echo $model->nombre; ?></h5>

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
                        <div id="mensajeTipoCuentaBanco"></div>
                        <div id="divSelectTipoCuentaBanco">
                            <?php  $this->renderPartial('_formListaTipoCuentaBanco', array('model'=>$model, 'tiposDeCuentaProvider'=>$tiposDeCuentaProvider, 'tipoCuentaSelect'=>$tipoCuentaSelect)); ?>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hide" id="deleteTipoCuentaBancoDialog">
    <div class="alertDialogBox">
        <p>&iquest;Desea usted Eliminar este Tipo de Cuenta?</p>
    </div>
</div>

<div class="hide" id="tipoCuentaBancoDialog">
    <?php $this->renderPartial('_formTipoCuentaBanco', array('model'=>new TipoCuentaBanco())); ?>
</div>