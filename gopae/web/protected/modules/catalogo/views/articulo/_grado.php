<?php
/* @var $this ModalidadController */
/* @var $model Modalidad */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    'Catalogo' => array('/catalogo'),
    'Nivel' => '/catalogo/nivel/',
    'Grado',
);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'modalidad-nivel-form',
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
<div class="widget-box">

    <div class="widget-header">
        <h5><?php echo CHtml::encode($model->nombre); ?></h5>

        <div class="widget-toolbar">
            <a >
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="form">


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
                <div class="row">


                    <input type="hidden" id='id' name="id" value="<?php echo base64_encode($model->id); ?>" />

                    <div class="col-md-10">
                        <label class="col-md-12"><b></b></label>
                        <label class="col-md-12">Grado</label>
                        <?php
                        echo $form->dropDownList
                                (
                                $model, 'nombre', CHtml::listData($grado, 'id', 'nombre'), array('empty' => '-SELECCIONE-')
                        );
                        /*
                          echo $form->dropDownList($model, 'nivels',
                         * CHtml::listData(Nivel::model()->findAll(array('order' => 'nombre ASC')), 'id', 'nombre'), 
                         * array('required' => 'required', 'empty' => '-SELECCIONE-', 'data-placeholder' => 'Seleccione niveles...', 'class
                          ' => 'col-md-12 span-7')
                          );
                         */
                        ?>

                    </div>
                </div>
                <?php $this->endWidget(); ?>
                <div class="row">

                    <div class="col-md-12">
                        <label  class="col-md-12">Grados Agregados</label>
                        <div  class="col-md-12">
                            <div id="listaGrado">			
                                <?php
                                $l = Grado::model()->obtenerGrado(base64_encode($model->id), Yii::app()->user->id);

                                $dataProvider = new CArrayDataProvider($l, array(
                                    'pagination' => array(
                                        'pageSize' => 5,
                                    )
                                ));
                                ?>

                                <?php
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                    'id' => 'modalidad-nivel-grid',
                                    'dataProvider' => $dataProvider,
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
                                            'header' => '<center>Nombre</center>',
                                            'name' => 'nombre',
                                        ),
                                        array(
                                            'type' => 'raw',
                                            'header' => '<center>Acciones</center>',
                                            'value' => array($this, 'columna')
                                        ),
                                    ),
                                ));
                                ?>
                            </div>		
                            <div class="row-fluid-actions">
                                <a class="btn btn-danger" href="/catalogo/nivel/">
                                    <i class="icon-arrow-left bigger-110"></i>
                                    Volver
                                </a>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>

        </div>
    </div>
</div>

<div id="dialogPantallaEliminar" class="hide"> 
    <div class="alertDialogBox bigger-110">
        <p class="bigger-110 bolder center grey">
            &iquest;Estas seguro de eliminar este Grado?
        </p>
    </div>
</div>

<!-- form -->
<script type="text/javascript">

    $(document).ready(function() {
        $("#nombre").keyup(function() {

            $("#nombre").val($("#nombre").val().toUpperCase());

        });

        $("#Nivel_nombre").bind('change', function() {

            var id_grado = $("#Nivel_nombre").val();
            var id_nivel = $("#id").val();

            if (id_grado == "" || id_nivel == "") {
                //alert('Hay un archivo vacio.');
            }
            else {
                var data =
                        {
                            grado_id: id_grado,
                            id: id_nivel
                        };

                executeAjax('listaGrado', '/catalogo/nivel/cargarGrado', data, true, true, 'GET', '');
            }
        });
    });
</script>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catalogo/nivel.js', CClientScript::POS_END);
?>

