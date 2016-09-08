<?php $tiposDeCuentaProvider=ContactoBanco::model()->search() ?>
    <div  class="col-md-12">
        
        <label for="contacto_id" class="span-3">Tipo de Cuenta</label>
            
    </div>
    <div class="space-6"></div>
    <div class="col-md-12">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
           'id'=>'banco-tipo-cuenta-grid',
           'dataProvider'=>$tiposDeCuentaProvider,
           'itemsCssClass' => 'table table-striped table-bordered table-hover',
           'summaryText' => 'Mostrando {start}-{end} de {count}',
           'pager' => array(
               'header' => '',
               'htmlOptions' => array('class' => 'pagination'),
               'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
               'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
               'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
               'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
           ),
           'afterAjaxUpdate' => "
                    function(){
                       setUpEventsFilters();
                   }",
           'columns'=>array(

               array(
                   'header' => '<center>Nombre y Apellido</center>',
                   'value' => '$data->banco->nombre_apellido'
               ),
               array(
                   'header' => '<center>Telefono Fijo</center>',
                   'value' => '$data->banco->telefono_fijo'
               ),
               array(
                   'header' => '<center>Fax</center>',
                   'value' => '$data->banco->telefono_fax'
               ),
               array(
                   'header' => '<center>Celular</center>',
                   'value' => '$data->banco->telefono_celular'
               ),
               array(
                   'type' => 'raw',
                   'header' => '<center>Acción</center>',
                   'value' => array($this, 'getActionButtonsTiposCuentaBanco'),
                   'htmlOptions' => array('nowrap'=>'nowrap'),
               ),

           ),

    )); ?>
    </div>