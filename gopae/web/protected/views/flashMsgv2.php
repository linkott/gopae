<div class="form">
	<div class="errorSummary">
          <div class="errorDialogBox">
            <p>
	  <?php 
		//Plantilla para mostrar los msj flash al usuario ej: Registro actualizado con exito
		echo Yii::app() -> user -> getFlash('mensajeError'); ?>
            </p>
	 </div>                                   
       </div>
</div>

