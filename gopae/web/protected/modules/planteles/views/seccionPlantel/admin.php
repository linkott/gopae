<?php
/* @var $this SeccionController */
/* @var $model Seccion */

$this->breadcrumbs = array(
    'Planteles' => array('consultar/'),
    'Secciones',
);
?>
<div id="resultadoElim"></div>
<div id ="guardoRegistro" class="successDialogBox" style="display: none">
    <p>
        Registro Exitoso
    </p>
</div>
<?php
$denominacion_id = $plantelPK['denominacion_id'];
$zona_educativa_id = $plantelPK['zona_educativa_id'];
$estado_id = $plantelPK['estado_id'];
?>
<div class = "widget-box collapsed">

    <div class = "widget-header">
        <h5>Identificación del Plantel <?php echo '"' . $plantelPK['nombre'] . '"'; ?></h5>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: none;" class = "widget-body-inner">
            <div class = "widget-main">

                <div class="row row-fluid center">
                    <div id="1eraFila" class="col-md-12">
                        <div class="col-md-4" >

                            <?php echo CHtml::label('<b>Código del Plantel</b>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $plantelPK['cod_plantel'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Código Estadistico</b>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $plantelPK['cod_estadistico'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Denominación</b>', '', array("class" => "col-md-12")); ?>
                            <?php if ($denominacion_id == null) { ?>
                                <?php
                                echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            } else {
                                ?>
                                <?php
                                echo CHtml::textField('', $plantelPK->denominacion->nombre, array('class' => 'span-7', 'readOnly' => 'readOnly'));
                                echo "no entro";
                                ?>
                            <?php } ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>

                    <div id="2daFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Nombre del Plantel</b>', '', array("class" => "col-md-12")); ?>
                            <?php echo CHtml::textField('', $plantelPK['nombre'], array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Zona Educativa</b>', '', array("class" => "col-md-12")); ?>
                            <?php if ($zona_educativa_id == null) { ?>
                                <?php
                                echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            } else {
                                ?>
                                <?php echo CHtml::textField('', $plantelPK->zonaEducativa->nombre, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                            <?php } ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Estado', '', array("class" => "col-md-12")); ?>
                            <?php if ($zona_educativa_id == null) { ?>
                                <?php
                                echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            } else {
                                ?>
                                <?php echo CHtml::textField('', $plantelPK->estado->nombre, array('class' => 'span-7', 'readOnly' => 'readOnly')); ?>
                            <?php } ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="tab-pane active" id="registrarS">

    <div class="widget-box">

        <?php
        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#seccion-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
        ?>


        <div class="search-form" style="display:none">
            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div><!-- search-form -->


        <?php
        if (isset($plantel_id) && $plantel_id != null) {
            ?>
            <input type="hidden" id="plantel_id" value="<?php echo $plantel_id ?>" name="plantel_id">
        <?php } ?>

        <?php
        $plan = SeccionPlantel::model()->llenarDropDown_plan_id($plantel_id);
        $nivel = SeccionPlantel::model()->llenarDropDown_nivel_id($plantel_id);
        ?>

        <div class = "widget-header">
            <h5>Secciones</h5>

            <div class = "widget-toolbar">
                <a href = "#" data-action = "collapse">
                    <i class = "icon-chevron-up"></i>
                </a>
            </div>

        </div>


        <div id="_formS" class="widget-body">
            <div style="display:block;" class="widget-body-inner">
                <div class="widget-main form">
                    <div>

                        <div class="col-md-12">
                            <div class="infoDialogBox">
                                <p>
                                    Antes de Crear una Sección, recuerde tener asignados los Niveles y Planes de Estudio de este plantel.
                                </p>
                            </div>
                        </div>
                        <?php if (Yii::app()->user->pbac('planteles.seccionPlantel.write') or Yii::app()->user->pbac('planteles.seccionPlantel.admin')): ?>
                            <div class="pull-right" style="padding-left: 20px; padding: 20px">
                                <button  id = "btnRegistrarSeccion"  class="btn btn-success btn-next btn-sm" type="button" data-last="Finish" onClick="agregarSeccion()">
                                    <i class="fa fa-plus icon-on-right"></i>
                                    Asignar Sección
                                </button>
                            </div>
                        <?php endif; ?>
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'seccion-grid',
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'summaryText' => false,
                            'dataProvider' => $model->search($plantel_id),
                            'filter' => $model,
                            'afterAjaxUpdate' => "function(){
                                $('#capacidadSeccion').bind('keyup blur', function() {
                                    keyNum(this, false);// true acepta la ñ y para que sea español
                                });

                         }",
                            'columns' => array(
                                array(
                                    'header' => '<center>Grado</center>',
                                    'name' => 'grado_id',
                                    'value' => '(is_object($data->grado) && isset($data->grado->nombre))? $data->grado->nombre: ""',
                                    'filter' => CHtml::listData(
                                            Grado::model()->findAll(
                                                    array(
                                                        'order' => 'consecutivo ASC',
                                                        'condition' => "estatus='A' "
                                                    )
                                            ), 'id', 'nombre'
                                    ),
                                ),
                                array(
                                    'header' => '<center>Sección</center>',
                                    'name' => 'seccion_id',
                                    'value' => '(is_object($data->seccion) && isset($data->seccion->nombre))? $data->seccion->nombre: ""',
                                    'filter' => CHtml::listData(
                                            Seccion::model()->findAll(
                                                    array(
                                                        'condition' => "estatus='A' ",
                                                        'order' => 'nombre ASC'
                                                    )
                                            ), 'id', 'nombre'
                                    ),
                                ),
                                array(
                                    'header' => '<center>Turno</center>',
                                    'name' => 'turno_id',
                                    'value' => '(is_object($data->turno) && isset($data->turno->nombre))? $data->turno->nombre: ""',
                                    'filter' => CHtml::listData(
                                            Turno::model()->findAll(
                                                    array(
                                                        'condition' => "estatus='A'",
                                                        'order' => 'nombre ASC'
                                                    )
                                            ), 'id', 'nombre'
                                    ),
                                ),
                                array(
                                    'header' => '<center>Nivel</center>',
                                    'name' => 'nivel_id',
                                    'value' => '(is_object($data->nivel) && isset($data->nivel->nombre))? $data->nivel->nombre: ""',
                                    'filter' => CHtml::listData($nivel, 'nivel_id', 'nombre'
                                    ),
                                ),
                                array(
                                    'header' => '<center>Plan</center>',
                                    'name' => 'plan_id',
                                    'value' => '((isset($data->plan->nombre) != null) && (isset($data->plan->mencion->nombre) != null) &&  (isset($data->plan->dopcion) != null))? $data->plan->nombre."[".$data->plan->mencion->nombre."]"."[".$data->plan->dopcion."]" : $data->plan->nombre',
                                    'filter' => CHtml::listData($plan, 'plan_id', 'nombre'),
                                ),
                                array(
                                    'header' => '<center>Capacidad</center>',
                                    'name' => 'capacidad',
                                    'filter' => CHtml::textField('SeccionPlantel[capacidad]', '', array('maxlength' => 3, 'id' => 'capacidadSeccion')),
                                ),
                                array(
                                    'header' => '<center>Estatus</center>',
                                    'name' => 'estatus',
                                    'filter' => array(
                                        'A' => 'Activo',
                                        'E' => 'Inactivo'
                                    ),
                                    'value' => array($this, 'estatusSeccion'),
                                ),
                                array(
                                    'type' => 'raw',
                                    'header' => '<center>Acciones</center>',
                                    'value' => array($this, 'columnaAcciones'),
                                    'htmlOptions' => array('nowrap' => 'nowrap'),
                                ),
                            ),
                            'pager' => array(
                                'header' => '',
                                'htmlOptions' => array('class' => 'pagination'),
                                'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                                'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                                'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                                'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="col-md-6">
        <div class="col-md-6">
            <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("planteles/consultar"); ?>" class="btn btn-danger">
                <i class="icon-arrow-left"></i>
                Volver
            </a>
            <?php $this->renderPartial('/_accionesSobrePlantel', array('plantel_id' => $plantel_id)) ?>
        </div>
    </div>
</div>

<div id="dialog_registrarSeccion" class="hide">

</div>


<div id="dialog_vizualizar" class="hide">
</div>

<div id="dialog_eliminacion" class="hide">
    <div class="alertDialogBox bigger-110">
        <p class="bigger-110 bolder center grey">
            &iquest;Estas seguro(a) que desea eliminar esta sección?
        </p>
    </div>
</div>
<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<div id="css_js">
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/seccionPlantel.js', CClientScript::POS_END);
?>
</div>