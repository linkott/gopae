<?php
/* @var $this SocioController */
/* @var $model Socio */
?>
<div class="widget-box">

    <div class="widget-header">
        <h4>Socio(s)</h4>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="display: block;">
            <div class="widget-main">
                
                <?php
                if(isset($tipo) && $tipo == 'update') {
                ?>

                <div style="padding-left:10px;" class="pull-right">
                    <a class="btn btn-success btn-next btn-sm" data-last="Finish" href="#" onclick="registrarSocio(<?php echo $proveedor_id; ?>);">
                        <i class="fa fa-plus icon-on-right"></i>
                        Registrar nuevo socio
                    </a>
                </div>
                
                <?php
                }
                ?>

                <div class="col-lg-12"><div class="space-6"></div></div>

                <a href="#" class="search-button"></a>
                <div style="display:block" class="search-form">
                    <div>
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'id' => 'socio-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'pager' => array('pageSize' => 1),
                            'summaryText' => false,
                            'afterAjaxUpdate' => "function(){
                                }",
                            'pager' => array(
                                'header' => '',
                                'htmlOptions' => array('class' => 'pagination'),
                                'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                                'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                                'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                                'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                            ),
                            'filter' => $model,
                            'columns' => array(
                                    'rif',
                                    'nombres',
                                    'apellidos',
                                    array(
                                        'header' => '<center title="Certificado De Salud">Certificados De Salud</center>',
                                        'name' => 'certificado_salud',
                                        'value' => '($data->certificado_salud == 0)? "NO": "SI"',
                                        'filter' => array('1' => 'SI', '0' => 'NO'),
                                    ),
                                    'telefono_celular',
                                    'correo',
                                    array(
                                        'header' => 'Tipo De Socio',
                                        'name' => 'tipo_socio',
                                        'value' => '($data->tipo_socio == 0)? "SIMPLE": "REPRESENTANTE"',
                                        'filter' => array('0' => 'SIMPLE', '1' => 'REPRESENTANTE'),
                                    ),
                                array(
                                    'header' => '<center title="Estatus del Aula">Estatus</center>',
                                    'name' => 'estatus',
                                    'filter'=> array('A' => 'Activo', 'E' => 'Inactivo'),
                                    'value'=>array($this, 'columnaEstatus'),
                                ),
                                array(
                                    'type' => 'raw',
                                    'header' => '<center>Acciones</center>',
//                                    'filter' => CHtml::hiddenField('Socio[tipo]', $tipo, array('id' => 'Socio_tipo')),
                                    'value' => array($this, 'columnaAccionesSocio'),
                                    'htmlOptions' => array('nowrap' => 'nowrap'),
                                ),
                            ),
                        ));
                        ?>
                        
                    </div><!-- search-form -->
                </div><!-- search-form -->
            </div>
        </div>
    </div>

</div>

<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<div id="dialogPantalla" class="hide"></div>
<div id="dialogPantallaConsultar" class="hide"></div>
<div id="dialogPantallaEliminar" class="hide"> 
    <div class="alertDialogBox bigger-110">
        <p class="bigger-110 bolder center grey">
            &iquest;Estas seguro de eliminar este Socio?
        </p>
    </div>
</div>
<div id="dialogPantallaActivacion" class="hide"> 
    <div class="alertDialogBox bigger-110">
        <p class="bigger-110 bolder center grey">
            &iquest;Estas seguro de activar este Socio?
        </p>
    </div>
</div>
<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/proveedor/socio.js', CClientScript::POS_END);
?>
