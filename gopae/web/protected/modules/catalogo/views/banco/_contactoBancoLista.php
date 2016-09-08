<div class="infoDialogBox">
    <p>
        Seleccione un Contacto para el Banco e ingrese sus datos.
    </p>
</div>

<div class="widget-box">
    <div class="widget-header">
        <h5>Contactos del Banco - <?php echo $model->nombre; ?></h5>
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
                        <div id="mensajeContactoBanco"></div>
                        <div id="divSelectContactoBanco">
                            <?php $this->renderPartial('_formListaContactoBanco', array('model'=>$model, )); ?>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hide" id="deleteContactoBancoDialog">
    <div class="alertDialogBox">
        <p>&iquest;Desea usted Eliminar este Contacto?</p>
    </div>
</div>

<div class="hide" id="tipoCuentaBancoDialog">
    <?php// $this->renderPartial('_formTipoCuentaBanco', array('model'=>new TipoCuentaBanco())); ?>
</div>