    <div  class="col-md-12">
        <?php if(count($tipoSerialCuentaSelect)>0): ?>
        <label for="tipo_serial_cuenta_id" class="span-3">Tipo de Serial</label>
        <?php echo CHtml::dropDownList(
               'tipo_serial_cuenta_id', 
               '', 
               Chtml::listData($tipoSerialCuentaSelect, 'id', 'nombre'), 
               array('prompt'=>'- - -', 'class'=>'span-9', 'onChange'=>'displayTipoSerialCuentaBancoForm(this, '.$model->id.', \''.addslashes($model->nombre).'\');')); 
               endif;
        ?>        
    </div>
    <div class="space-6"></div>
    <div class="col-md-12">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
           'id'=>'banco-tipo-serial-cuenta-grid',
           'dataProvider'=>$tiposSerialDeCuentaProvider,
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
                   'header' => '<center>Banco</center>',
                   'value' => '$data->banco->nombre'
               ),
               array(
                   'header' => '<center>Tipo de Serial</center>',
                   'value' => '$data->tipoSerialCuenta->nombre'
               ),
               array(
                   'header' => '<center>Serial</center>',
                   'value' => '$data->serial',
               ),
               array(
                   'type' => 'raw',
                   'header' => '<center>Acción</center>',
                   'value' => array($this, 'getActionButtonsTiposSerialCuentaBanco'),
                   'htmlOptions' => array('nowrap'=>'nowrap'),
               ),

           ),

    )); ?>
    </div>