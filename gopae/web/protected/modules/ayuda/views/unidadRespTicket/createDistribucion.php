
      <div class="widget-header">
            <h5>Crear Nuevo Distribución</h5>
            <div class="widget-toolbar">
                <a>
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>
<?php
  $this->renderPartial('_formDistribucion', array(
            'model' => $model, 'estados' => $estados, 'tipoTicket' => $tipoTicket, 'unidadResponsable' => $unidadResponsable, 'actualizar'=>$actualizar

        ));?>