<div class="widget-box">

        <div class="widget-header">
            <h5>Crear Nuevo Tipo de Ticket</h5>

            <div class="widget-toolbar">
                <a>
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>
        <?php
          $this->renderPartial('_form', array(
                    'model' => $model,'unidades'=>$unidades,
                ));

        ?>
</div>