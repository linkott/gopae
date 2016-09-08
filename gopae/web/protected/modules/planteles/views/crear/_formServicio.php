<div class="form" id="_formServicio">

    <?php
    if ($plantel_id !== NULL) {

        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'plantelServicios-form',
            //  'action' => 'guardarServicios',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        ));
        ?>

        <div class="tab-pane active" id="servicio">
            <div id="servicioCalid" class="widget-box">

                <div id="resultadoPlantelServicio">
                </div>

                <div id="resultadoServicio" class="infoDialogBox">
                    <p>
                        Debe Seleccionar los Servicios del Plantel.
                    </p>
                </div>

                <div id ="guardoServicio" class="successDialogBox" style="display: none">
                    <p>
                        Registro Exitoso
                    </p>
                </div>

                <div class="widget-header">
                    <h5>Servicios</h5>
                    <div class="widget-toolbar">
                        <a  href="#" data-action="collapse">
                            <i class="icon-chevron-down"></i>
                        </a>
                    </div>
                </div>

                <div id="servicio" class="widget-body" >
                    <div class="widget-body-inner" >
                        <div class="widget-main form">

                            <div class="row">
                                <?php $fecha_fundacion = Plantel::model()->obtenerFechaFundacion($plantel_id); ?>
                                <input type="hidden" id="fecha_fundacion" value="<?php echo $fecha_fundacion ?>" name="plantel_id">
                                <div class="col-md-4">

                                    <label for="servicios">Servicios<span class="required"></span></label><br>
                                    <?php
                                    echo CHtml::dropDownList('servicios', 'id', $list, array(
                                        'empty' => 'Seleccione un servicio',
                                        'onChange' => 'condicionarServicios(' . $plantel_id . ')'
                                            )
                                    );
                                    ?>
                                </div>
                                <div class="col-md-6" id ="serviciosUsados">
                                    <div id="scrolltable" style='border: 0;background: #ffffff; overflow:auto;padding-right: 15px; padding-top: 15px; padding-left: 15px;
                                         padding-bottom: 15px;border-right: #6699CC 0px solid; border-top: #999999 0px solid;border-left: #6699CC 0px solid; border-bottom: #6699CC 0px solid;
                                         scrollbar-arrow-color : #999999; scrollbar-face-color : #666666;scrollbar-track-color :#3333333 ;height:120%; left: 28%; top: 300; width: 120%'>
                                         <?php
                                         //  var_dump(count($servicios));
                                         if (isset($dataProvider) && $dataProvider !== array()) {
                                             // var_dump($dataProvider);
                                             $this->widget(
                                                     'zii.widgets.grid.CGridView', array(
                                                 'id' => 'servicio-grid',
                                                 'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                                 'dataProvider' => $dataProvider,
                                                 'summaryText' => false,
                                                 'columns' => array(
                                                     array(
                                                         'name' => 'servicio',
                                                         'type' => 'raw',
                                                         'header' => '<center><b>Servicio</b></center>'
                                                     ),
                                                     array(
                                                         'name' => 'calidad',
                                                         'type' => 'raw',
                                                         'header' => '<center><b>Calidad del Servicio</b></center>'
                                                     ),
                                                     array(
                                                         'name' => 'fecha_desde',
                                                         'type' => 'raw',
                                                         'header' => '<center><b>Fecha Inicio</b></center>'
                                                     ),
                                                     array(
                                                         'name' => 'boton',
                                                         'type' => 'raw',
                                                         'header' => '<center><b>Acciones</b></center>'
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
                                                     )
                                             );
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
                    <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("planteles/consultar/"); ?>"class="btn btn-danger">
                        <i class="icon-arrow-left"></i>
                        Volver
                    </a>
                </div>

                <div class="col-md-6 wizard-actions">
                    <button type="button" data-last="Finish" class="btn btn-primary btn-next" onClick="guardarServicio(<?php echo $plantel_id ?>)">
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
        <div  id="mensajeServicio" class="infoDialogBox">
            <p>
                Debe Registrar un Plantel para acceder a esta opción.
            </p>
        </div>
    <?php } ?>
</div>
