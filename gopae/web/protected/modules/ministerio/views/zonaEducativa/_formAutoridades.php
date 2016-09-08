<div class="form" id="_formAutoridades">

    <div class="tab-pane active" id="autoridades">

        <div id="autor" class="widget-box">


            <div id="resultadoZonaAutoridades">
            </div>
            <div id="validaciones"> </div>

            <div class="widget-header">
                <h5>Autoridad de la Zona Educativa</h5>
                <div class="widget-toolbar">
                    <a  href="#" data-action="collapse">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div id="autoridadesZona" class="widget-body" >
                <div class="widget-body-inner" >
                    <div class="widget-main form">

                        <div class="row">

                            <input type="hidden" id="zona_id" value=<?php echo $zona_id ?> name="zona_id"/>

                            <div class="col-md-12" id ="listaAutoridad">
                                <?php
                                    $form = $this->beginWidget('CActiveForm', array(
                                        'id' => 'zonaAutoridades-form',
                                        // Please note: When you enable ajax validation, make sure the corresponding
                                        // controller action is handling ajax validation correctly.
                                        // There is a call to performAjaxValidation() commented in generated controller code.
                                        // See class documentation of CActiveForm for details on this.
                                        'enableAjaxValidation' => false,
                                    ));
                                ?>
                                <div class="col-md-5">
                                    <div class="col-md-12"><label for="Plantel_cedula">Cedula<span class="required">*</span></label></div>
                                    <input type="text" data-toggle="tooltip" data-placement="bottom" placeholder="V-00000000" title="Ej: V-99999999 ó E-99999999" id="cedula"  style="padding:4.5px 5px" maxlength="11" size="11" class="span-6" name="cedula" onkeypress = "return CedulaFormat(this, event)" />
                                    <button  id = "btnBuscarCedula"  class="btn btn-info btn-xs" type="submit" style="padding-top: 2px; padding-bottom: 2px;" >
                                        <i class="icon-search"></i> Buscar
                                    </button>

                                </div>
                                <?php
                                    $this->endWidget();
                                ?>
                            <?php
                            //if (isset($dataProviderAutoridades) && $dataProviderAutoridades !== array()) {
                            $this->widget(
                                'zii.widgets.grid.CGridView', array(
                                    'id' => 'autoridades-grid',
                                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                    // 40px is the height of the main navigation at bootstrap
                                    'dataProvider' => $dataProviderAutoridades,
                                    'summaryText' => false,
                                    'afterAjaxUpdate' =>   "function(){
                                                                asignEventsCgridView();
                                                            }",
                                    'columns' => array(
                                        array(
                                            'name' => 'cargo',
                                            'type' => 'raw',
                                            'header' => '<center><b>Cargo</b></center>'
                                        ),
                                        array(
                                            'name' => 'nombre',
                                            'type' => 'raw',
                                            'header' => '<center><b>Nombre y Apellido</b></center>',
                                        ),
                                        array(
                                            'name' => 'cedula',
                                            'type' => 'raw',
                                            'header' => '<center><b>Cédula</b></center>'
                                        ),
                                        array(
                                            'name' => 'correo',
                                            'type' => 'raw',
                                            'header' => '<center><b>Correo Electrónico</b></center>'
                                        ),
                                        array(
                                            'name' => 'telefono_celular',
                                            'type' => 'raw',
                                            'header' => '<center><b>Teléfono</b></center>'
                                        ),
                                        array(
                                            'name' => 'telefono_fijo',
                                            'type' => 'raw',
                                            'header' => '<center><b>Teléfono Fijo</b></center>'
                                        ),
                                        array(
                                            'header' => 'Acciones',
                                            'name' => 'boton',
                                            'type' => 'raw'
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
                            //}
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div id="botones" class="row">
    <div class="col-md-6">
        <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("../ministerio/zonaEducativa"); ?>" class="btn btn-danger">
            <i class="icon-arrow-left"></i>
            Volver
        </a>
    </div>
</div>

</div>
<?php Yii::app()->getSession()->add('usuario', $usuario); ?>

<div id = "agregarAutoridad" class="hide">
    <?php $this->renderPartial('_formAgregarAutoridad', array('usuario' => $usuario, 'zona_id' => $zona_id)); ?>
</div>

<div class="hide" id="datosAutoridad"> </div>
<div id = "dialog_success" class="hide">
    <div class="successDialogBox bigger-110">
        <p class="bigger-110">

        </p>
    </div>
</div>

<div id = "dialog_error" class="hide">
    <div class="alertDialogBox bigger-110">
        <p class="bigger-110">

        </p>
    </div>
</div>

<div id="dialog_cargo" class="hide">
    <?php $this->renderPartial('_formCargo', array('usuario' => $usuario, 'zona_id' => $zona_id)); ?>
</div>

<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<div id="dialogPantalla" class="hide"></div>

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/ministerio/eventosZonaEducativa.js', CClientScript::POS_END);
?>