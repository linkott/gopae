<?php
/* @var $this NivelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Planteles' => array('../planteles'),
    'Nivel'
);
?>
<?php
if (isset($plantelPK)) {
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
                            <?php
                            if($plantelPK['cod_plantel'] != null)
                            {
                                echo CHtml::textField('', $plantelPK['cod_plantel'], array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            else
                            {
                                echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Código Estadistico</b>', '', array("class" => "col-md-12")); ?>
                            <?php
                            if($plantelPK['cod_estadistico'] != null)
                            {
                                echo CHtml::textField('', $plantelPK['cod_estadistico'], array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            else
                            {
                                echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Denominación</b>', '', array("class" => "col-md-12")); ?>
                            <?php
                            if($plantelPK['denominacion_id'] != null)
                            {
                                echo CHtml::textField('', $plantelPK->denominacion->nombre, array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            else
                            {
                                echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>

                    <div id="2daFila" class="col-md-12">
                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Nombre del Plantel</b>', '', array("class" => "col-md-12")); ?>
                            <?php
                            if($plantelPK['nombre'] != null)
                            {
                                echo CHtml::textField('', $plantelPK['nombre'], array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            else
                            {
                                echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Zona Educativa</b>', '', array("class" => "col-md-12")); ?>
                            <?php
                            if($plantelPK['zona_educativa_id'] != null)
                            {
                                echo CHtml::textField('', $plantelPK->zonaEducativa->nombre, array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            else
                            {
                                echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            ?>
                        </div>

                        <div class="col-md-4" >
                            <?php echo CHtml::label('<b>Estado', '', array("class" => "col-md-12")); ?>
                            <?php
                            if($plantelPK['estado_id'] != null)
                            {
                                echo CHtml::textField('', $plantelPK->estado->nombre, array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            else
                            {
                                echo CHtml::textField('', '', array('class' => 'span-7', 'readOnly' => 'readOnly'));
                            }
                            ?>
                        </div>

                    </div>

                    <div class = "col-md-12"><div class = "space-6"></div></div>
                </div>
            </div>
        </div>
    </div>

        </div>
<?php
}
?>






                    <div id="listaNivel">
<div class="widget-box">

    <div class="widget-header">
        <h5>Nivel</h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div style="display: block;" class="widget-body-inner">
            <div class="widget-main">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'plantel-nivel-form',
                    'enableAjaxValidation' => true,
                ));
                ?>
                <input type="hidden" id='id' name="id" value="<?php echo $_GET['id']; ?>" />
                <?php
                /*LA MODALIDAD DE ESTE PLANTEL NO POSEE NIVELES ASOCIADOS, COMUNIQUESE CON CONTROL DE ESTUDIO DEL MMMEEṔEEE*/
                if($nivel == NULL)
                {
                    $this->renderPartial("//msgBox", array('class' => 'alertDialogBox', 'message' => 'La modalidad de este plantel no posee niveles asociados, comuníquese con la Dirección de Registro y Control de Estudio del Ministerio del Poder Popular para la Educación.'));

                }
                else
                {
                    if(Yii::app()->user->pbac('planteles.nivel.write') or Yii::app()->user->pbac('planteles.nivel.admin')){
                echo $form->dropDownList
                        (
                        $modelNivel, 'nombre', CHtml::listData($nivel, 'id', 'nombre'), array('empty' => '-SELECCIONE-')
                );
                    }
                ?>
                <div class="col-lg-12"><div class="space-6"></div></div>

                <a class="search-button" href="#"></a>
                <div class="search-form" style="display:block">
                        <div class="grid-view" id="nivel-grid">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                'id' => 'nivel-plantel-grid',
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
                                'dataProvider' => $model->search(),
                                'filter' => $model,
                                'columns' => array(
                                    array(
                                        'header' => 'Nivel',
                                        //'name' => 'nivel_id',
                                        'value' => '(is_object($data->nivel) && isset($data->nivel->nombre))? $data->nivel->nombre: ""',
//                                        'filter' => CHtml::listData(
//                                                Nivel::model()->findAll(
//                                                        array(
//                                                            'order' => 'nombre ASC',
//                                                        //'condition' => 'id = ' . $model->nivel_id
//                                                        )
//                                                ), 'id', 'nombre'
//                                        ),
                                    ),
                                    /*array(
                                        'header' => '<center>Estatus</center>',
                                        'name' => 'estatus',
                                        'filter' => array('A' => 'Activo', 'E' => 'Inactivo'),
                                        'value' => array($this, 'columnaEstatus'),
                                    ),*/
                                    array('type' => 'raw',
                                        'header' => '<center>Acciones</center>',
                                        'value' => array($this, 'columnaAcciones'),
                                    ),
                                ),
                            ));
                            ?>
                        </div>
                    </div><!-- search-form -->
                    <?php
                    }/*FIN DE SI POSEE NIVELES EN MODALIDADES*/
                    ?>
                    <div class="row-fluid-actions">
                        <a class="btn btn-danger" href="/planteles/">
                            <i class="icon-arrow-left bigger-110"></i>
                            Volver
                        </a>
                    </div>

                </div><!-- search-form -->
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script>

    /*function eliminarNivel(nivel_id, id) {
        var data =
                {
                    nivel_id: nivel_id,
                    id: id
                };
        executeAjax('listaNivel', '/planteles/nivel/eliminarNivel', data, true, true, 'GET', '');
    }*/
    $(document).ready(function() {

        $("#nombre").keyup(function() {

            $("#nombre").val($("#nombre").val().toUpperCase());

        });
        $("#Nivel_nombre").bind('change', function() {
            var id_nivel = $("#Nivel_nombre").val();
            var id_plantel = $("#id").val();

            if (id_nivel == "" || id_plantel == "") {
                //alert('Hay un archivo vacio.');
            }
            else {
                var data =
                        {
                            nivel_id: id_nivel,
                            id: id_plantel
                        };
                executeAjax('listaNivel', '/planteles/nivel/cargarNivel', data, true, true, 'GET', '');
            }
        });
    });
</script>
<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>

<div id="dialogPantallaEliminar" class="hide"> 
    <div class="alertDialogBox bigger-110">
        <p class="bigger-110 bolder center grey">
            &iquest;Estas seguro de eliminar este Nivel?
        </p>
    </div>
</div>
<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/plantel/nivel.js',CClientScript::POS_END);
?>