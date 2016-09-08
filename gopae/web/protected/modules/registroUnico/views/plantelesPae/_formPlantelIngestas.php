<?php
/* @var $this AulaController */
/* @var $model Ingesta */
$this->pageTitle = 'Edición de Datos del Plantel';
?>

<div class='infoDialogBox'>
    <p>
    Seleccione la o las ingestas que provee el plantel, así como la cantidad de comensales por ingesta.
    </p>
</div>

<div class="widget-box">

    <div class="widget-header">
        <h5>Ingestas del Plantel <?php echo ' - ('.$plantel->cod_plantel.') '.$plantel->nombre; ?></h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="display: block;">
            <div class="widget-main">

                <div class="col-lg-12"><div class="space-6"></div></div>
                <div style="display:block">
                    <div class="row">

                        <div id="resultadoIngestasPae"></div>

                        <div class="col-md-12">

                        <?php $tipoIngestasIds = array(); ?>

                        <input type="hidden" id="listaIngestasPlantel" value="<?php if(is_array($ingestas) && count($ingestas)>0): foreach($ingestas as $ingesta): $tipoIngestasIds[] = $ingesta['tipo_ingesta_id']; echo $ingesta['tipo_ingesta_id'].";"; endforeach; endif; ?>" readonly />

                        <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'plantel-ingesta-form',
                                'enableAjaxValidation' => true,
                            ));
                            $listaTipoIngesta = CTipoMenu::getData('id', $tipoIngestasIds, true);
                        ?>
                        <label for="tipo_ingesta_id" style="float: left;">Tipo de Ingesta<span class="required">*</span> &nbsp;</label>
                            <select id="tipo_ingesta_id" name="tipo_ingesta_id" class="span-6" title="Seleccione la o las ingestas que provee el plantel, así como la cantidad de comensales por ingesta.">
                                <option value="">- - -</option>
                                <?php
                                    if(is_array($listaTipoIngesta)):
                                        foreach($listaTipoIngesta as $tipoIngesta):
                                ?>
                                <option id="tipoIngestaId<?php echo $tipoIngesta['id']; ?>" value="<?php echo $tipoIngesta['id']; ?>"><?php echo $tipoIngesta['nombre']; ?></option>
                                <?php
                                        endforeach;
                                    endif;
                                ?>
                            </select>
                        <?php
                            $this->endWidget();
                        ?>
                        </div>

                        <div class="col-md-12">
                            <div class="space-6"></div>
                        </div>

                        <div class="col-md-12">
                            <div class="grid-view">

                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th id="ingesta-grid_c0">
                                                Tipo de Ingesta
                                            </th>
                                            <th id="ingesta-grid_c1">
                                                Comensales
                                            </th>
                                            <th width="10%" id="ingesta-grid_c2">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="ingesta-grid-body">
                                        <?php if(is_array($ingestas) && count($ingestas)>0): ?>
                                        <?php     foreach($ingestas as $ingesta): ?>
                                        <tr id="trIngesta<?php echo $ingesta['id']; ?>">
                                            <td><?php echo htmlentities($ingesta['nombre']); ?></td>
                                            <td><?php echo htmlentities($ingesta['cantidad_comensales']); ?></td>
                                            <td><div style="text-align: right"><a onclick="eliminarIngesta(<?php echo htmlentities($ingesta['id']); ?>, '<?php echo htmlentities($ingesta['nombre']); ?>', <?php echo htmlentities($ingesta['tipo_ingesta_id']); ?>);"><i class="fa fa-trash red"></i></a></div></td>
                                        </tr>
                                        <?php     endforeach; ?>
                                        <?php else: ?>
                                        <tr id="trIngestaNotExists">
                                            <td class="empty" colspan="3"><span class="empty">No existen ingestas registradas en este plantel.</span></td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div><!-- search-form -->
                </div><!-- search-form -->
            </div>
        </div>
    </div>

</div>
<hr>
    <div id="botones" class="row">
        <div class="">
            <a id="btnRegresar" href="<?php echo Yii::app()->createUrl("registroUnico/plantelesPae/lista"); ?>" class="btn btn-danger">
                <i class="icon-arrow-left"></i>
                Volver
            </a>
            <div class="btn-group dropup">
                <button data-toggle="dropdown" class="btn dropdown-toggle" style="height:42px;">
                    Acciones
                    <span class="icon-caret-up icon-on-right"></span>
                </button>
                <ul class="dropdown-menu dropdown-yellow pull-right">
                    <li>
                        <a href="/registroUnico/madresCocineras/asignadas/id/<?php echo base64_encode($model->id); ?>" title="Registro y Consulta de Madres Cocineras" class="fa fa-female purple">
                            <span style="font-family:Helvetica Neue,Arial,Helvetica,sans-serif;">&nbsp;&nbsp;Madres Cocineras</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<div id="dialogIngestaRegistro" class="hide">
    <form name="IngestaRegistroForm" id="IngestaRegistroForm" method="post">
        <div class="widget-box">
            <div class="widget-header">
                <h5>Ingesta y Comensales en el Plantel</h5>

                <div class="widget-toolbar">
                    <a data-action="collapse" href="#">
                        <i class="icon-chevron-up"></i>
                    </a>
                </div>

            </div>
            <div class="widget-body">
                <div class="widget-body-inner" style="display: block;">
                    <div class="widget-main">

                        <div class="row">

                            <div class="">
                                <div id="resultFormIngestaComensales">
                                    <div class="infoDialogBox bigger-110">
                                        <p>
                                            Indique la cantidad de comensales en esta ingesta. Tenga en cuenta que la Matricula Total es de <span id="matriculaText"></span> estudiantes.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12"><div class="space-6"></div></div>

                            <div class="">
                                <div class="col-md-6">
                                    <label for="ingestaTextDialog">Tipo de Ingesta</label>
                                    <input type="text" name="ingestaText" id="ingestaTextDialog" class="span-12" required="" readonly />
                                    <input type="hidden" name="PlantelIngesta[plantel_id]" id="PlantelIngesta_plantel_id" value="<?php echo $model->id ?>" readonly />
                                    <input type="hidden" name="PlantelIngesta[tipo_ingesta_id]" id="PlantelIngesta_tipo_ingesta_id" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label for="cantidad_comensales">Cantidad de Comensales <span class="required">*</span></label>
                                    <input type="number" name="PlantelIngesta[cantidad_comensales]" class="span-12" id="PlantelIngesta_cantidad_comensales" min="0" max="99999" required/>
                                </div>
                            </div>
                            <div>
                                <div class="col-md-12">
                                <button type="submit" class="btn btn-primary hide">Guardar Datos <i class="icon-save"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="dialogIngestaEliminar" class="hide">
    <div class="alertDialogBox bigger-110">
        <p class="">
            &iquest;Estas seguro de eliminar el Tipo de Ingesta <span id="tipoIngestaTextEliminar"></span> de esta Institución Educativa?
        </p>
    </div>
</div>

<div id="dialogoIngestaMensaje" class="hide"></div>

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/registroUnico/ingesta.js', CClientScript::POS_END);
?>
