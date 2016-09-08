


<div class="form">
    <div class="errorSummary">
        <div class="successDialogBox">
            <p>
                <?php
                //Plantilla para mostrar los msj flash al usuario ej: Registro actualizado con exito
                echo Yii::app()->user->getFlash('mensajeExitoso');
                ?>
            </p>
        </div>                                   
    </div>
</div>


