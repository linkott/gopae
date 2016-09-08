<div class="form" id="_formAutoridades">
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
        document.onkeypress = noENTER;</script>

    <?php
    if ($plantel_id !== NULL) {
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'plantelAutoridades-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>
    <?php //$form->hiddenField($usuario, '');  ?>
    <div class="tab-pane active" id="autoridades">

        <div id="autor" class="widget-box ">


            <div id="resultadoPlantelAutoridades">
            </div>

            <div id="resultadoAutoridades" class="infoDialogBox">
                <p>
                    Por Favor Ingrese un Número de Cédula de la Autoridad de este Plantel que desea Registrar.
                </p>
            </div>

            <div id ="guardoAutoridades" class="successDialogBox" style="display: none">
                <p>
                    Registro Exitoso
                </p>
            </div> 

            <div class="widget-header">
                <h5>Autoridades Del Plantel</h5>
                <div class="widget-toolbar">
                    <a  href="#" data-action="collapse">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div id="autoridadesPlantel" class="widget-body" >
                <div class="widget-body-inner" >
                    <div class="widget-main form">                      

                        <div class="row">
                            <?php echo '<input type="hidden" id="plantel_id" value=' . $plantel_id . ' name="plantel_id"/>'; ?>
                            <div class="col-md-5">
                                <div class="col-md-12"><label for="Plantel_cedula">Cedula<span class="required">*</span></label></div>
                                <?php echo '<input type="text" data-toggle="tooltip" data-placement="bottom" placeholder="V-0000000" title="Ej: V-99999999 ó E-99999999" id="cedula"  style="padding:3px 4px" maxlength="10" size="10" class="span-6" name="cedula" onkeypress = "return CedulaFormat(this, event)" />'; ?>
                                <button  id = "btnBuscarCedula"  class="btn btn-info btn-xs" type="button" style="padding-top: 2px; padding-bottom: 2px;" >
                                    <i class="icon-search"></i>
                                    Buscar
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id ="listaAutoridad">
                                <?php
                                if (isset($dataProvider) && $dataProvider !== array()) {
                                    $this->widget(
                                            'zii.widgets.grid.CGridView', array(
                                        'id' => 'autoridades-grid',
                                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                        // 40px is the height of the main navigation at bootstrap
                                        'dataProvider' => $dataProvider,
                                        'summaryText' => false,
                                        'columns' => array(
                                            array(
                                                'name' => 'cargo',
                                                'type' => 'raw',
                                                'header' => '<center><b>Cargo</b></center>'
                                            ),
                                            array(
                                                'name' => 'nombre',
                                                'type' => 'raw',
                                                'header' => '<center><b>Nombre y Apellido</b></center>'
                                            ),
                                            array(
                                                'name' => 'cedula',
                                                'type' => 'raw',
                                                'header' => '<center><b>Cedula</b></center>'
                                            ),
                                            array(
                                                'name' => 'correo',
                                                'type' => 'raw',
                                                'header' => '<center><b>Correo Eléctronico</b></center>'
                                            ),
                                            array(
                                                'name' => 'telefono',
                                                'type' => 'raw',
                                                'header' => '<center><b>Teléfono</b></center>'
                                            ),
                                            array(
                                                'name' => 'boton',
                                                'type' => 'raw',
                                                'header' => ''
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
    <hr>
    <div id="botones" class="row">

        <div class="col-md-6">
            <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("planteles/consultar/"); ?>" class="btn btn-danger">
                <i class="icon-arrow-left"></i>
                Volver
            </a>
        </div>


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

<script >
    $('#cedula').tooltip({
        show: {
            effect: "slideDown",
            delay: 250,
        }
    });
    $("#btnBuscarCedula").click(function() {
        var cedula = $("#cedula").val();
        var tam = cedula.length;
        var mensaje = "Estimado usuario, el formato de la Cedula de Identidad no es el correcto";
        if (tam > 2 && tam <= 10) {
            buscarCedula(cedula);
        }
        else {
            dialogo_error(mensaje);
        }
    });
</script>
    
    
    
    

