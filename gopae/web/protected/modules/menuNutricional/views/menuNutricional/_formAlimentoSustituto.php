<?php
/* @var $model Alimentos */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'alimento-sustituto-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));


?>

<input id="alimento" type="hidden" value="<?php echo $idAlimento; ?>">
<input id="menu" type="hidden" value="<?php echo $modelMenu; ?>">

<div class="widget-box">

    <div class="widget-header">
        <h4>Sustituto(s) de <?php echo $modelMenuNutricional->alimentos->nombre;?></h4>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
            <a data-action="close" href="#">
                <i class="icon-remove"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">

        <div class="widget-main">
            <div id="respMenuAlimentoSustituto"></div>
            <div class="row">
                <div class="col-md-3">
                    <div class="col-md-12">
                        <label><b>Alimento</b><span class="required">*</span></label>
                    </div>
                    <div class="col-md-12">
                        <?php echo $form->dropDownList($model, 'alimentos_id', CHtml::listData(Articulo::model()->findAllByAttributes(array('estatus' => 'A', 'tipo_articulo_id' => '1'), array('order' => 'nombre ASC')), 'id', 'nombre'), array('empty' => '-Seleccione-', 'class' => 'span-6', 'required' => 'required')); ?>
                        <?php echo $form->error($model, 'alimentos_id'); ?>   
                    </div>
                </div>
                <div class="col-md-3">
                        <div class="col-md-12">
                            <label><b>Ración Pequeña<span class ="unidad_medidad_sustituto"></span></b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php echo $form->textField($model, 'cantidad', array('class' => 'span-7', 'required' => 'required', 'maxlength' => 5)); ?>
                            <?php echo $form->error($model, 'cantidad'); ?>   
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <label><b>Ración Mediana <span class ="unidad_medidad_sustituto"></span></b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php echo $form->textField($model, 'cantidad_mediana', array('class' => 'span-7', 'required' => 'required', 'maxlength' => 5)); ?>
                            <?php echo $form->error($model, 'cantidad_mediana'); ?>   
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <label><b>Ración Grande <span class ="unidad_medidad_sustituto"></span></b><span class="required">*</span></label>
                        </div>
                        <div class="col-md-12">
                            <?php echo $form->textField($model, 'cantidad_grande', array('class' => 'span-7', 'required' => 'required', 'maxlength' => 5)); ?>
                            <?php echo $form->error($model, 'cantidad_grande'); ?>   
                        </div>
                    </div>
                 </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary" id="agregarAlimentoSustituto" style="margin-top: 21px;">
                            <i class=" icon-plus"></i>
                            Agregar
                        </button>  
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="alimentoSeleccionado">
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'id' => 'alimento-sustituto-grid',
                        'dataProvider' => $model->searchAlimentoSustituto($idAlimento),
//                      'filter' => $model,
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
                        'columns' => array(
                            array(
                                'header' => '<center title="nombre del Alimento Cargado"> Nombre </center>',
                                'name' => 'nombre',
                            ),
                            array(
                                'type' => 'raw',
                                'header' => '<center>Acciones</center>',
                                'value' => array($this, 'columnaAccionesSustitutos'),
                                'htmlOptions' => array('width' => '5%'),
                            ),
                        ),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<!-- grid-alimentos-sustituto -->

<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>

<script>
    $(document).ready(function() {
        
        $("#MenuNutricionalSustitutos_alimentos_id").select2({
            allowClear: false
        });
        $('#MenuNutricionalSustitutos_cantidad,#MenuNutricionalSustitutos_cantidad_mediana, #MenuNutricionalSustitutos_cantidad_grande').bind('blur, keyup, change', function() {
         keyNum(this, true, false);
});


$("#MenuNutricionalSustitutos_alimentos_id").bind('change', function() {

            var unidad_medida = btoa($("#MenuNutricionalSustitutos_alimentos_id").val());
            data = {id: unidad_medida};
            $.ajax({
                url: "/menuNutricional/menuNutricional/obtenerUnidadMedida",
                data: data,
                dataType: 'html',
                type: 'post',
                success: function(result)
                {
                    $(".unidad_medidad_sustituto").html("( " + result + " )");

                }
            });



        });

        $("#alimento-sustituto-form").on('submit', function(evt) {
            
            evt.preventDefault();
            var id = $("#MenuNutricionalSustitutos_alimentos_id").val();
            agregarSustitutoAlimento(id);

        });


    });

</script>

