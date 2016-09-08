<?php

 ?>

<!--<div id="resultado">
    <div class="infoDialogBox">
        <p>
            Debe Ingresar los Datos Generales del Plantel, los campos marcados con <span class="required">*</span> son requeridos.
        </p>
    </div>
</div>-->
<div id="result-solicitud" >
    <div id ="solicitudRechazada" class="alertDialogBox" style="display:block">
        <p>
            Lo sentimos, actualmente no posee estudiante a quien solicitar título.
        </p>
</div>

<div class="col-md-2">
    <div class="col-md-6">
        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("planteles/consultar"); ?>" class="btn btn-danger">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
    </div>
</div>

</div>