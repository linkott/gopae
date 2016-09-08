      <div class="widget-header">
            <h5>Crear Nuevo Grupo</h5>
            <div class="widget-toolbar">
                <a>
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>
<?php $this->renderPartial('_form', array('model'=>$model,'grupos' => $grupos,'actualizar' => $actualizar));