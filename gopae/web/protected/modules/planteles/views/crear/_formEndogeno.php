
<div class="form" id="_formEndogeno">

    <?php
    if ($plantel_id !== NULL) {

        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'plantelEndogeno-form',
            'action' => 'guardarEndogeno',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        ));
        ?>

        <div class="tab-pane active" id="desarrollo">

            <div id="desaEndogeno" class="widget-box">

                <div id="resultadoPlantelEndogeno">
                </div>

                <div id="resultadoEndogeno" class="infoDialogBox">
                    <p>
                        Debe Seleccionar los Proyectos Endogenos del Plantel.
                    </p>
                </div>

                <div id ="guardoEndogeno" class="successDialogBox" style="display: none">
                    <p>
                        Registro Exitoso
                    </p>
                </div>

                <div class="widget-header">
                    <h5>Proyectos Endogenos</h5>
                    <div class="widget-toolbar">
                        <a  href="#" data-action="collapse">
                            <i class="icon-chevron-down"></i>
                        </a>
                    </div>
                </div>

                <div id="desarrolloEndogeno" class="widget-body" >
                    <div class="widget-body-inner" >
                        <div class="widget-main form">

                            <div class="row">

                                <div class="col-md-4">

                                    <label for="servicios">Proyectos Endogenos<span class="required"></span></label><br>
                                    <?php
                                    echo CHtml::dropDownList('proyectos_endogenos', 'id', $listProyectosEndo, array(
                                        'empty' => 'Seleccione un proyecto',
                                        'onChange' => 'agregarProyecto(' . $plantel_id . ')',
                                        'class' => 'span-9'
                                            )
                                    );
                                    ?>
                                </div>
                                <div class="col-md-8" id ="proyectosUsados">
                                    <div id="scrolltable" style='border: 0;background: #ffffff; overflow:auto;padding-right: 15px; padding-top: 15px; padding-left: 15px;
                                         padding-bottom: 15px;border-right: #6699CC 0px solid; border-top: #999999 0px solid;border-left: #6699CC 0px solid; border-bottom: #6699CC 0px solid;
                                         scrollbar-arrow-color : #999999; scrollbar-face-color : #666666;scrollbar-track-color :#3333333 ;height:120%; left: 28%; top: 300; width: 80%'>
                                         <?php
                                         if (isset($dataProvider) && $dataProvider !== array()) {
                                             // var_dump($dataProvider); die();
                                             $this->widget('zii.widgets.grid.CGridView', array(
                                                 'dataProvider' => $dataProvider,
                                                 'id' => 'proyectos_endogenos_grid',
                                                 'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                                 'summaryText' => false,
                                                 'columns' => array(
                                                     array(
                                                         'name' => 'nombre',
                                                         'type' => 'raw',
                                                         'header' => '<center><b>Proyecto Endogeno</b></center>'
                                                     ),
                                                     array(
                                                         'name' => 'boton',
                                                         'type' => 'raw',
                                                         'header' => '<center><b>Acciones</b></center>',
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
                                         }
                                         ?>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <br>
            <hr>
            <div class="row">

                <div class="col-md-6">
                    <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("planteles/consultar/index"); ?>"class="btn btn-danger">
                        <i class="icon-arrow-left"></i>
                        Volver
                    </a>
                </div>

                <div class="col-md-6 wizard-actions">
                    <button type="button" data-last="Finish" class="btn btn-primary btn-next" onClick="guardarEndogeno(<?php echo $plantel_id ?>)">
                        Guardar
                        <i class="icon-save icon-on-right"></i>
                    </button>
                </div>

            </div>
            <hr>

        </div>
        <?php
        $this->endWidget();
    } else {
        ?>
        <div class="infoDialogBox">
            <p>
                Debe Registrar un Plantel para acceder a esta opción.
            </p>
        </div>
    <?php } ?>

</div><!-- form -->

































