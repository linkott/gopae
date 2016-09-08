<?php
/* @var $this CondicionServicioController */
/* @var $model CondicionServicio */

echo CHtml::scriptFile('/public/js/modules/catalogo/condicionDeServicio.js');
$this->breadcrumbs = array(
    'Condición de Servicios' => array('index'),
);
?>
        <div class="widget-header">
            <h4>Condici&oacuten de Servicios</h4>
            <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
         </div>

<div class="widget-body">
    <div style="display:block;" class="widget-body-inner">
        <div class="widget-main">
            <div>



                    <div class="pull-right" style="padding-left:10px;">
                        <a type="submit" data-last="Finish" class="btn btn-success btn-next btn-sm" onclick="condicionDeServicio('','3')">
                            <i class="fa fa-plus icon-on-right" ></i>
                            Registrar una nuevo Condici&oacute;n de Servicio
                        </a>
                        <br>
                        <br>

                        </div>

                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'itemsCssClass' => 'table table-striped table-bordered  table-hover',
                        'id' => 'condicion-servicio-grid',
                        'dataProvider' => $model->search(),
                        'filter' => $model,
                        'summaryText' => false,
                        'pager' => array(
                            'header' => '',
                            'htmlOptions' => array('class' => 'pagination'),
                            'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                            'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                            'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                            'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                        ),
                        'afterAjaxUpdate' => " function(){

                                              $('#nombrecondicion').bind('keyup blur', function () {
                                                     keyTextDash(this, true,true);
                                                     makeUpper(this);
                                                });
                                            }

                                        ",
                                        'columns' => array(
                                            array(
                                                'name' => 'nombre',
                                                'filter' => CHtml::textField('CondicionServicio[nombre]', null, array('maxlength' => 10, 'id' => 'nombrecondicion')),
                                            ),
                                            // array('name' => 'usuario_ini_id', 'value' => '$data->usuarioIni->usuario'),
                                            array('header' => '<center title="Estatus de la condicon de servicio">Estatus</center>',
                                                'name' => 'estatus',
                                                'filter' => array('A' => 'Activo', 'E' => 'Inactivo'),
                                                'value' => array($this, 'Estatus')
                                            ),
                                            array(
                                                'type' => 'raw',
                                                'header' => '<center>Acciones</center>',
                                                'value' => array($this, 'columnaAcciones'),
                                            ),
                                        ),
                                    ));
                    ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("catalogo"); ?>" class="btn btn-danger">
                                <i class="icon-arrow-left"></i>
                                Volver
                            </a>
                        </div>
                    </div>
                    
                </div>
        
            </div>
        </div>
        
        <div id="dialogPantalla" class="hide"></div>


        <div><?php $this->widget('ext.loading.LoadingWidget');
?></div>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catalogo/condicionDeServicio.js', CClientScript::POS_END); ?>