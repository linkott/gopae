<?php
/* @var $this NivelController */
/* @var $model Nivel */

$this->breadcrumbs = array(
    'Catálogo' => array('/catalogo'),
    'Equipo',
);
?>

<div class="widget-box">

    <div class="widget-header">
        <h5>Equipo</h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="display: block;">
            <div class="widget-main">


                <div style="padding-left:10px;" class="pull-right">
                    <a class="btn btn-success btn-next btn-sm" data-last="Finish" href="#" onclick="registrarArticulo('equipo');">
                        <i class="fa fa-plus icon-on-right"></i>
                        Registrar nuevo equipo
                    </a>
                </div>

                <div class="col-lg-12"><div class="space-6"></div></div>

                <a href="#" class="search-button"></a>
                <div style="display:block" class="search-form">
                    <div>


                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'id' => 'articulo-grid',
                            'dataProvider' => $model->search('EQUIPO'),
                            'filter' => $model,
                            'pager' => array('pageSize' => 1),
                            'summaryText' => false,
                            'pager' => array(
                                'header' => '',
                                'htmlOptions' => array('class' => 'pagination'),
                                'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                                'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                                'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                                'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                            ),
//                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'afterAjaxUpdate' => "function(){
                            
                                    $('#nombreArticulo').bind('keyup blur', function() {
                                       //makeUpper(this);
                                       keyAlphaNum(this,true,true);
                                   });

                                    $('#Articulo_nombre_form').bind('keyup blur', function() {
                                        makeUpper(this);
                                        keyAlphaNum(this, true, true);
                                    });

                                    $('#Articulo_precio_regulado').bind('keyup blur', function() {
                                        keyNum(this, true);
                                    });

                                }",
                            'columns' => array(
                                array(
                                    'header' => 'Nombre del Equipo',
                                    'name' => 'nombre',
                                    'filter' => CHtml::textField('Articulo[nombre]', null, array('maxlength' => 70, 'id' => 'nombreArticulo', 'maxlength' => 160)),
                                ),
                                array(
                                    'header' => 'Unidad de Medida',
                                    'name' => 'unidad_medida_id',
                                    'value' => '(is_object($data->unidadMedida) && isset($data->unidadMedida->nombre))? $data->unidadMedida->nombre: ""',
                                    'filter' => CHtml::listData(
                                            UnidadMedida::model()->findAll(
                                                    array(
                                                        'order' => 'id ASC'
                                                    )
                                            ), 'id', 'nombre'
                                    ),
                                ),
//                                array(
//                                    'header' => 'Tipo de Articulo',
//                                    'name' => 'tipo_articulo_id',
//                                    'value' => '(is_object($data->tipoArticulo) && isset($data->tipoArticulo->nombre))? $data->tipoArticulo->nombre: ""',
//                                    'filter' => CHtml::listData(
//                                            TipoArticulo::model()->findAll(
//                                                    array(
//                                                        'order' => 'id ASC'
//                                                    )
//                                            ), 'id', 'nombre'
//                                    ),
//                                ),
                                array(
                                    'type'=> 'raw',
                                    'header' => 'Precio Nacional',
                                    'name' => 'precio_regulado',
                                    'value' => array($this, 'columnaPrecioRegulado'),
                                    'filter' => CHtml::textField('Articulo[precio_regulado]', null, array('id' => 'Articulo_precio_regulado')),
                                ),
                                array(
                                    'type'=> 'raw',
                                    'header' => 'Precio Baremo',
                                    'name' => 'precio_baremo',
                                    'value' => array($this, 'columnaPrecioReguladoBaremo'),
                                    'filter' => CHtml::textField('Articulo[precio_baremo]', null, array('id' => 'Articulo_precio_baremo')),
                                ),
                                array(
                                    'header' => 'Estatus',
                                    'name' => 'estatus',
                                    'filter' => array('A' => 'Activo', 'E' => 'Inactivo'),
                                    'value' => array($this, 'columnaEstatus'),
                                ),
                                array('type' => 'raw',
                                    'header' => '<center>Acciones</center>',
                                    'value' => array($this, 'columnaAcciones'),
                                ),
                            ),
                        ));
                        ?>
                        <div class="row-fluid-actions">
                            <a href="/catalogo" class="btn btn-danger">
                                <i class="icon-arrow-left bigger-110"></i>
                                Volver
                            </a>
                        </div>


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
            &iquest;Estas seguro de eliminar este Articulo?
        </p>
    </div>
</div>

<div id="dialogPantallaActivacion" class="hide"> 
    <div class="alertDialogBox bigger-110">
        <p class="bigger-110 bolder center grey">
            &iquest;Estas seguro que desea Activar este Articulo?
        </p>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catalogo/articulo.js', CClientScript::POS_END);
?>

