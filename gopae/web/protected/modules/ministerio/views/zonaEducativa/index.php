<?php
$this->breadcrumbs = array(
    'Zonas Educativas',
);
$this->pageTitle = "Zonas Educativas";
?>
<div class="widget-box">

    <div class="widget-header">

        <h5>
            Zonas Educativas
        </h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>

            </a>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="">
            <div class="widget-main">
                <div class="col-md-8">
                    <div id="dialogBoxReg" style="display:none"><?php $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'La Zona Educativa ha sido inhabilitada exitosamente.')); ?></div>
                    <div id="dialogBoxHab" style="display:none"><?php $this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'La Zona Educativa ha sido Habilitada exitosamente.')); ?></div>
                </div>
                <a href="#" class="search-button"></a>

                <div class="clearfix margin-5">
                    <?php
                    $data = $model->search('fecha_act DESC, fecha_ini DESC');

                    $this->widget('zii.widgets.grid.CGridView', array(
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'id' => 'asignatura-grid',
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

                                        $('#ZonaEducativa_nombre').bind('keyup blur', function () {
                                             keyAlphaNum(this, true, true);
                                             makeUpper(this);
                                        });

                                        $('#ZonaEducativa_estado').bind('keyup blur', function () {
                                             keyAlphaNum(this, true, true);
                                              makeUpper(this);
                                        });
                                    }

                                ",
                        'columns' => array(
                            array(
                                'header' => '<center>Nombre Asignado</center>',
                                'name' => 'nombre',
                                'filter' => CHtml::textField('ZonaEducativa[nombre]'),
                            ),
                            array(
                                'header' => '<center> Estado </center>',
                                'name' => 'estado_id',
                                'value' => '(is_object($data->Zestado))? $data->Zestado->nombre:""',
                                //'value' => '(in_array(Yii::app()->user->group,  array(UserGroups::JEFE_DRCEE, UserGroups::ADMIN_DRCEE, UserGroups::DESARROLLADOR, UserGroups::root)))?$data->estado:Yii::app()->user->estado',
                                'filter' => CHtml::listData(
                                        Estado::model()->findAll(
                                                array(
                                                    'condition' => "co_stat_data = 'A'",
                                                    'order' => 'nombre ASC'
                                                )
                                        ), 'id', 'nombre'
                                ),
                            ),
                            array(
                                'header' => '<center>Estatus</center>',
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
                </div>

                <div class="row">

                    <div class="col-md-6"  style="padding-left: 0px;">
                        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("../ministerio"); ?>" class="btn btn-danger">
                            <i class="icon-arrow-left"></i>
                            Volver
                        </a>
                    </div>

                </div>

            </div>

            <div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>

        </div>

    </div>

</div>

<div id="dialogPantalla" class="hide" ></div>
<div id="dialogEliminar" class="hide" ><?php $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => '<p class="bolder center grey"> ¿Desea Inhabilitar esta Asignatura? </p>')); ?></div>
<div id="dialogReactivar" class="hide" ><?php $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => '<p class="bolder center grey"> ¿Desea Habilitar Nuevamente esta Asignatura? </p>')); ?></div>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/ministerio/zonaEducativa.js', CClientScript::POS_END);
?>
