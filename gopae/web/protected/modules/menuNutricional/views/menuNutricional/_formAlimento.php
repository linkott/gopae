<?php
/* @var $model Alimentos */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'alimento-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));

$modelMenuNutricional = new MenuNutricionalAlimento;

?>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/select2.css" rel="stylesheet" />
<div class="widget-box">

    <div class="widget-header">
        <h4>Alimento(s)</h4>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="display: block;">
            <div class="widget-main">
                <div id="respMenuAlimento"></div>
                <div class="infoDialogBox">
                    <p> Por favor ingrese los datos correspondientes, los campos marcados con <b><span class="required">*</span></b> son estrictamente requeridos.</p>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <label><b>Alimento</b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php echo $form->dropDownList($modelMenuNutricional, 'alimentos_id', CHtml::listData(Articulo::model()->findAllByAttributes(array('estatus' => 'A', 'tipo_articulo_id' => '1'), array('order' => 'nombre ASC')), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-6', 'required' => 'required')); ?>
                            <?php echo $form->error($modelMenuNutricional, 'alimentos_id'); ?>   
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <label><b>Ración Pequeña<span class ="unidad_medidad"></span></b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php echo $form->textField($modelMenuNutricional, 'cantidad', array('class' => 'span-7', 'required' => 'required', 'maxlength' => 5)); ?>
                            <?php echo $form->error($modelMenuNutricional, 'cantidad'); ?>   
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <label><b>Ración Mediana <span class ="unidad_medidad"></span></b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php echo $form->textField($modelMenuNutricional, 'cantidad_mediana', array('class' => 'span-7', 'required' => 'required', 'maxlength' => 5)); ?>
                            <?php echo $form->error($modelMenuNutricional, 'cantidad_mediana'); ?>   
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <label><b>Ración Grande <span class ="unidad_medidad"></span></b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php echo $form->textField($modelMenuNutricional, 'cantidad_grande', array('class' => 'span-7', 'required' => 'required', 'maxlength' => 5)); ?>
                            <?php echo $form->error($modelMenuNutricional, 'cantidad_grande'); ?>   
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="col-md-12">
                            <input type="hidden" name="MenuNutricionalAlimento[menu_nutricional_id]" value="<?php echo $modelMenu->id; ?>">
                            <button class="btn btn-sm btn-primary" id="agregarAlimento" style="margin-top: 21px;">
                                <i class=" icon-plus"></i>
                                Agregar
                            </button>  
                        </div>
                    </div>

                </div>
                <?php $this->endWidget(); ?>
                <div class="col-lg-12"><div class="space-6"></div></div>
                <hr>
                <div class="row">

                    <div class="col-md-12">

                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'id' => 'alimento-grid',
                            'dataProvider' => $model->searchAlimento($modelMenu->id),
//                            'filter' => $model,
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
                            'columns' => array(
                                array(
                                    'header' => '<center title="nombre del Alimento Cargado"> Nombre </center>',
                                    'name' => 'nombre',
                                ),
                                array(
                                    'header' => '<center title="Precio Baremo del Alimento Cargado por Unidad"> Precio Baremo </center>',
                                    'name' => 'precio_baremo',
                                    'htmlOptions' => array('width' => '10%')
                                ),
                                array(
                                    'header' => '<center title="Cantidad del Alimento Cargado"> Cantidad </center>',
                                    'name' => 'cantidad',
                                    'htmlOptions' => array('width' => '5%'),
                                ),
                                array(
                                    'header' => '<center>Cantidad Mediana</center>',
                                    'name' => 'cantidad_mediana',
                                    'htmlOptions' => array('width' => '12%'),
                                ),
                                array(
                                    'header' => '<center>Cantidad Grande</center>',
                                    'name' => 'cantidad_grande',
                                    'htmlOptions' => array('width' => '10%'),
                                ),
                                array(
                                    'header' => '<center title="Unidad de Medida del Alimento Cargado"> Unidad de Medida </center>',
                                    'name' => 'unidad_medida',
                                    'htmlOptions' => array('width' => '5%')
                                ),
                                array(
                                    'type' => 'raw',
                                    'header' => '<center>Acciones</center>',
                                    'value' => array($this, 'columnaAccionesAlimentos'),
                                    'htmlOptions' => array('width' => '5%'),
                                ),
                            ),
                        ));
                        ?>

                    </div><!-- grid-alimentos -->


                </div>


            </div>
        </div>
    </div>

</div>


<div id="sustitutos"></div>
<div id="dialogConfirm"></div>
<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<div id="dialogPantallaAlimento" class="hide"></div>
<script>
    $(document).ready(function() {


        
   

        $("#MenuNutricionalAlimento_alimentos_id").bind('change', function() {

            var unidad_medida = btoa($("#MenuNutricionalAlimento_alimentos_id").val());
            data = {id: unidad_medida};
            $.ajax({
                url: "/menuNutricional/menuNutricional/obtenerUnidadMedida",
                data: data,
                dataType: 'html',
                type: 'post',
                success: function(result)
                {
                    $(".unidad_medidad").html("( " + result + " )");

                }
            });



        });


    });
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/menuNutricional/alimento.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/select2.min.js', CClientScript::POS_END);
?>
