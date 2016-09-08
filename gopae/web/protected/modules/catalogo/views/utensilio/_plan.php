<?php
/* @var $this ModalidadController */
/* @var $model Modalidad */
/* @var $form CActiveForm */

//echo CHtml::scriptFile('/public/js/modules/catalogo/nivel.js');
?>


<?php
$this->breadcrumbs = array(
    'Catalogo' => '/catalogo',
    'Nivel' => '/catalogo/nivel/',
    'Asignar Planes',
);
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'nivel-plan-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => true,
        ));
?>
<!--Evitar la redireccion-->


<script>
    function noENTER(evt)
    {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if ((evt.keyCode == 13) && (node.type == "text"))
        {
            return false;
        }
    }
    document.onkeypress = noENTER;
</script>
<div class="widget-box collapsed">
    <input type="hidden" id='id' name="id" value="<?php echo base64_encode($model->id); ?>" />
    <div class="widget-header">
        <h5><?php echo CHtml::encode($model->nombre); ?></h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-down"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">

        <div class="widget-main form">



            <?php
            if ($form->errorSummary($model)):
                ?>
                <div id ="div-result-message" class="errorDialogBox" >
                    <?php echo $form->errorSummary($model); ?>
                </div>
                <?php
            endif;
            ?>

            <?php
            $this->renderPartial('_datos', array('model' => $model));
            ?>
        </div>
    </div>
</div>


<div class="widget-box collapsed">

    <div class="widget-header">
        <h4>Asignar Planes</h4>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-down"></i>
            </a>
        </div>
    </div>
    <div class="widget-body">

        <div class="widget-main form">


            <div id="paraAsignar">


                <!--                                    <label class="col-md-12"><b>Planes:</b></label>-->
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                    'id' => 'plan-grid',
                    'dataProvider' => $planesDisponibles->searchPlanDisponiblesNivel($model->id),
                    'filter' => $planesDisponibles,
                    'summaryText' => false,
                    'pager' => array(
                        'header' => '',
                        'htmlOptions' => array('class' => 'pagination'),
                        'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                        'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                        'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                        'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                    ),
                    'columns' => array(
                        array(
                            'header' => '<center>Codigo</center>',
                            'name' => 'cod_plan',
                             'htmlOptions' => array('width' => '8%')
                        ),
                        array(
                            'header' => '<center>Nombre</center>',
                            'name' => 'nombre',
                        ),
                        array(
                             'filter' => CHtml::listData(
                                    Mencion::model()->findAll(
                                            array(
                                                'order' => 'id ASC'
                                            )
                                    ), 'id', 'nombre'
                            ),
                            'header' => '<center>Mención</center>',
                            'name'=>'mencion_id',
                            'value' => array($this, 'mencion'),
                             'htmlOptions' => array('width' => '20%')
                        ),
                         array(
                            'filter'=>false, 
                            'header' => '<center>Opción</center>',
                            'name'=>'dopcion',
                            'htmlOptions' => array('width' => '20%')
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Acciones</center>',
                            'value' => array($this, 'asignarPlan'),
                             'htmlOptions' => array('width' => '8%')
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>



<div class="widget-box">

    <div class="widget-header">
        <h4>Planes Asignados</h4>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="widget-body">

        <div class="widget-main form">
            <div id="asignados">
                <!--<label  class="col-md-12">Planes Agregados</label>-->


                <?php
                $NivelPlan = NivelPlan::model()->obtenerPlanNivel($model->id);

                $dataProviderNivelPlan = new CArrayDataProvider($NivelPlan, array(
                    'pagination' => array(
                        'pageSize' => 15,
                    )
                ));
                ?>

                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                    'id' => 'nivel-plan-grid',
                    'dataProvider' => $dataProviderNivelPlan,
                    'summaryText' => false,
                    'pager' => array(
                        'header' => '',
                        'htmlOptions' => array('class' => 'pagination'),
                        'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                        'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                        'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                        'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                    ),
                    'columns' => array(
                        array(
                            'header' => '<center>Codigo</center>',
                            'name' => 'cod_plan',
                        ),
                        array(
                            'header' => '<center>Nombre</center>',
                            'name' => 'nombre',
                        ),
                         array(
                            'header' => '<center>Mención</center>',
                            'name'=>'mencion',
                             'htmlOptions' => array('width' => '20%')
                        ),
                        array(
                            'header' => '<center>Opción</center>',
                            'name'=>'dopcion',
                             'htmlOptions' => array('width' => '20%')
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Acciones</center>',
                            'value' => array($this, 'quitarPlan')
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>




<?php $this->endWidget(); ?>

<div class="space-8"></div>
<div class="row-fluid-actions">
    <a class="btn btn-danger" href="/catalogo/nivel/">
        <i class="icon-arrow-left bigger-110"></i>
        Volver
    </a>
</div>

<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<div id="dialogPantalla" class="hide"></div>



<!-- form -->
<script>

    function quitarPlan(id_plan_nivel, id_nivel) {

        id_nivel = $("#id").val();
        var data =
                {
                    id_plan_nivel: id_plan_nivel,
                    id_nivel: id_nivel
                };

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Esta seguro que desea eliminar este nivel? </p></div>');

        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            position: ['top', '10'],
            draggable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Nivel </h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-warning btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar",
                    "class": "btn btn-danger btn-xs",
                    click: function() {



                        var callback = function() {
                            $('#plan-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };


                        if (data) {
                            executeAjax('asignados', '/catalogo/nivel/QuitarPlan/', data, true, true, 'GET', callback);
                            $(this).dialog("close");
                        }
                    }
                }
            ],
        });


        Loading.hide();

    }

    function agregarPlan(id_plan) {

        id_nivel = $("#id").val();

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey"> ¿Esta seguro que desea Agregar este Plan?</p></div>');

        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            position: ['top', '10'],
            draggable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminar Nivel </h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='icon-remove bigger-110'></i>&nbsp; Cancelar",
                    "class": "btn btn-warning btn-xs",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html: "<i class='icon-save bigger-110'></i>&nbsp; Guardar",
                    "class": "btn btn-primary btn-xs",
                    click: function() {
                        var data =
                                {
                                    id_nivel: id_nivel,
                                    id_plan: id_plan
                                };
                        var callback = function() {
                            $('#plan-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };


                        if (data) {
                            executeAjax('asignados', '/catalogo/nivel/cargarPlan/', data, true, true, 'GET', callback);
                            $(this).dialog("close");
                        }
                    }
                }
            ],
        });


        Loading.hide();




        //VentanaDialog(data,'/catalogo/modalidad/nivel','Eliminar Nivel de Modalidad','borrarNivel');

        //

    }


    $(document).ready(function() {




        $("#nombre").keyup(function() {

            $("#nombre").val($("#nombre").val().toUpperCase());

        });

        $("#Modalidad_nivels").bind('change', function() {

            var id_nivel = $("#Modalidad_nivels").val();
            var id_modalidad = $("#id").val();

            if (id_nivel == "" || id_modalidad == "") {
            }
            else {

                agregar(id_nivel, id_modalidad);

            }


        });
    });
</script>

