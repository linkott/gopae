
<?php if (isset($estatus)) { ?>

    <div class="form">
        <div class="errorSummary">
            <?php if ($estatus === "success") { ?>

                <div class="successDialogBox">
                    <p>
                        <?php
                        Yii::app()->user->setFlash('mensajeExitoso', "Registro Exitoso");
                        echo Yii::app()->user->getFlash('mensajeExitoso');
                        ?>
                    </p>
                </div>   
            <?php } elseif ($estatus === "error") { ?>

                <div class="errorDialogBox">
                    <p>
                        <?php
                        //Yii::app()->user->setFlash('mensajeExitoso', "REGISTRO EXITOSO"); 
                        //Plantilla para mostrar los msj flash al usuario ej: Registro actualizado con exito
                        echo Yii::app()->user->getFlash('mensajeError');
                        ?>
                    </p>
                </div> 
            <?php } ?> 

        </div>
    </div>
<?php } ?>


