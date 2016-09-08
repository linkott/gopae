<?php
if(isset($mensaje)){ 
    echo $mensaje;
}
?>


<?php if (isset($estatus)) { ?>

    <div class="form">
        <div class="errorSummary">
            <?php if ($estatus === "success") { ?>

                <div class="successDialogBox">
                    <p>
                        <?php
                        echo Yii::app()->user->getFlash('mensajeExitoso');
                        ?>
                    </p>
                </div>   
            <?php } elseif ($estatus === "error") { ?>

                <div class="errorDialogBox">
                    <p>
                        <?php
                        echo Yii::app()->user->getFlash('mensajeError');
                        ?>
                    </p>
                </div> 
            <?php } ?> 

        </div>
    </div>
<?php } ?>