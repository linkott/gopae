<?php
/* @var $this MenuNutricionalController */
/* @var $model MenuNutricional */

$this->breadcrumbs = array(
    'Plantel' => array('/planteles'),
    'Proveedor del Plantel'
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $('#plantel-proveedor-grid').yiiGridView('update', {
                    data: $(this).serialize()
            });
            return false;
    });
");
?>


<div class = "widget-box collapsed">

    <div class = "widget-header">
        <h4>Identificación del Plantel <?php echo '"' . $datosPlantel['nom_plantel'] . '"'; ?></h4>

        <div class = "widget-toolbar">
            <a href = "#" data-action = "collapse">
                <i class = "icon-chevron-down"></i>
            </a>
        </div>

    </div>

    <div class = "widget-body">
        <div style = "display: none;" class = "widget-body-inner">
            <div class = "widget-main">

                <div class="row row-fluid">
                    <?php $this->renderPartial('_informacionPlantel', array('datosPlantel' => $datosPlantel)); ?>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="widget-box">
    <div class="widget-header">
        <h4>Proveedor del Plantel</h4>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">

                <div class="infoDialogBox">
                    <p>
                        El plantel debe de tener un proveedor asignado para poder generar Órdenes de Pedido u Órdenes de Compra.
                    </p>
                </div>

                <div id="respProveedorAsignado"></div>
                <div id="respProveedorEliminado"></div>

                <div class="row">
                    <div class="text-right">
                        <button style="height: 28.5px;" class="btn btn-xs btn-success" id="btnAsignarProveedorNuevo">
                            <i class="icon-plus bigger-110"></i>
                            Asignar Nuevo Proveedor
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" >
                        <label><h5>Proveedor Asignado al Plantel</h5></label>

                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'id' => 'plantel-proveedor-grid',
                            'dataProvider' => $model->searchPorPlantel(base64_decode($id)),
                            //'filter' => $model,
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
                                    'type' => 'raw',
                                    'header' => '<center>RIF</center>',
                                    'value' => '$data->proveedor->rif'
                                ),
                                array(
                                    'type' => 'raw',
                                    'header' => '<center>Razón Social</center>',
                                    'value' => '$data->proveedor->razon_social'
                                ),
                                array(
                                    'type' => 'raw',
                                    'header' => '<center>Denominación de Empresa</center>',
                                    'value' => '$data->proveedor->tipoEmpresa->nombre',
                                ),
                                array(
                                    'type' => 'raw',
                                    'header' => '<center>Estado</center>',
                                    'value' => '$data->proveedor->estado->nombre',
                                ),
                                array(
                                    'type' => 'raw',
                                    'header' => '<center>Acciones</center>',
                                    'value' => array($this, 'columnaAcciones'),
                                    'htmlOptions' => array('width' => '5%'),
                                )
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<input type="hidden" name="id" id="plantelId" value="<?php echo $id; ?>">

<div class="row-fluid">
    <a class="btn btn-danger" href="/planteles">
        <i class="icon-arrow-left bigger-110"></i>
        Volver
    </a>
</div>

<?php
$this->widget('ext.loading.LoadingWidget');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/jquery.maskedinput.min.js', CClientScript::POS_END);
?>

<div id="dialogBusquedaProveedores" class="hide">
    <div class="col-md-12" id="resultadoOperacion">
        <div class="infoDialogBox">
            <p>
                Al realizar una busqueda por RIF debe rellenar con ceros a la izquierda en caso de que sea muy corta la identificación.
            </p>
        </div>
    </div>
    <div class="row">
        <form id="buscar-proveedor-form" name="buscar-proveedor-form">
            <div class="col-md-9">
                <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button" id="botonPersonaRif" class="btn btn-xs  dropdown-toggle"
                                data-toggle="dropdown" style="height: 28.5px;">
                            <span id="spanPersonaRif">PERSONA</span> <span class="caret"></span>
                        </button>

                        <ul class="dropdown-menu pull-left" role="menu">
                            <li><a class="rifAcciones" data-value="NATURAL">NATURAL</a></li>
                            <li><a class="rifAcciones" data-value="JURIDICA">JURIDICA</a></li>
                            <li><a class="rifAcciones" data-value="GUBERNAMENTAL">GUBERNAMENTAL</a></li>
                        </ul>
                    </div>
                    <?php
                    echo CHtml::textField('rif', '', array(
                        'id' => 'rif',
                        'class' => 'span-7',
                        'placeholder' => 'Buscar por RIF',
                        'required' => 'required'
                    ));
                    ?>
                </div>

            </div>
            <div class="col-md-1">
                <button id="buscarProveedor" class="btn btn-xs btn-primary" type="submit">
                    <i class="icon-search bigger-110"></i>
                    Buscar
                </button>
            </div>
        </form>
    </div>

    <div class="space-6"></div>

    <div class="row">
        <div class="col-md-12">

            <div id="respuestaBusqueda">
                <label><h5>Proveedores Consultados</h5></label>
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'itemsCssClass' => 'table table-striped table-bordered table-hover',
                    'id' => 'proveedor-grid',
                    'dataProvider' => $model->searchPorPlantel(0),
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
                            'type' => 'raw',
                            'header' => '<center>RIF</center>',
                            'value' => '$data->rif'
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Razón Social</center>',
                            'value' => '$data->razon_social'
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Denominación de Empresa</center>',
                            'value' => '$data->tipoEmpresa->nombre',
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Estado</center>',
                            'value' => '$data->estado->nombre',
                        ),
                        array(
                            'type' => 'raw',
                            'header' => '<center>Acciones</center>',
                            'value' => array($this, 'columnaAccionesProveedor'),
                            'htmlOptions' => array('width' => '5%'),
                        )
                    ),
                ));
                ?>
            </div>
        </div>

    </div>
</div>

<div id="dialogPantalla" class="hide"></div>


<script>

    var dialogProveedor = null;

    $(document).ready(function() {

        $.mask.definitions['~'] = '[+-]';
        $.mask.definitions['6'] = '[1-2]';
        $("#rif").attr('readonly', true);
        $('.rifAcciones').bind('click', function() {

            if ($(this).attr('data-value') === "NATURAL") {
                $("#spanPersonaRif").html('NATURAL');

                $("#rif").attr('readonly', false);
                $('#rif').mask('V-999999999');

            } else if ($(this).attr('data-value') === "JURIDICA") {
                $("#spanPersonaRif").html('JURIDICA');

                $("#rif").attr('readonly', false);
                $('#rif').mask('J-999999999');

            } else if ($(this).attr('data-value') === "GUBERNAMENTAL") {
                $("#spanPersonaRif").html('GUBER...');

                $("#rif").attr('readonly', false);
                $('#rif').mask('G-999999999');

            } else {


            }
            $("#rif").focus();

        });

        $("#btnAsignarProveedorNuevo").on("click", function(){

            displayDialogBox("#resultadoOperacion","info","Al realizar una busqueda por RIF debe rellenar con ceros a la izquierda en caso de que sea muy corta la identificación.");
            $("#respProveedorEliminado").html('');
            $("#respProveedorAsignado").html('');
            Loading.show();
            dialogProveedor = $("#dialogBusquedaProveedores").removeClass('hide').dialog({
                modal: true,
                width: '70%',
                dragable: false,
                resizable: false,
                title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-truck'></i> Busqueda de Proveedores</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                        "class": "btn btn-danger btn-xs",
                        id: "btnDialogBusquedaProveedorVolver",
                        click: function() {
                            $(this).dialog("close");
                            $("#resultadoOperacion").html("");
                        }
                    }
                ]
            });
            Loading.hide();

        });

        $("#buscar-proveedor-form").on('submit', function(evt) {

            evt.preventDefault();

            //            $("#razon_social").val().length > 0 ||
            //            $("#estado_id").val().length > 0 ||
            //            $("#tipo_empresa_id").val().length > 0

            if ($("#rif").val().length > 0) {
                Loading.show();
                $.ajax({
                    url: "/planteles/proveedorAsignado/buscarProveedor",
                    data: {rif: btoa($("#rif").val()) },
                    dataType: 'html',
                    type: 'post',
                    success: function(resp) {
                        Loading.hide();
                        $("#respuestaBusqueda").html(resp);
                        $("#rif").val("");
                    }
                });

            } else {
                $("#rif").focus();
            }
        });


    });

    function asignarProveedor(id) {

        var proveedor_id = btoa(id);
        var plantel_id = $("#plantelId").val();

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey">¿Desea asignar este proveedor al plantel?</p></div>');
        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Asignación de Proveedor</h4></div>",
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
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; Asignar ",
                    "class": "btn btn-primary btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/planteles/proveedorAsignado/agregarProveedor";
                        var datos = {plantel_id: plantel_id, proveedor_id: proveedor_id};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#plantel-proveedor-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };
                        if (datos) {
                            $.ajax({
                                url: urlDir,
                                data: datos,
                                dataType: 'html',
                                type: method,
                                success: function(resp) {
                                    $("#respProveedorAsignado").html(resp);
                                    $("#respProveedorEliminado").html('');
                                    $("#resultadoOperacion").html(resp);
                                    $("#rif").val("");
                                    $("#btnDialogBusquedaProveedorVolver").click();
                                    // $("#respuestaBusqueda").html('');
                                    $('#plantel-proveedor-grid').yiiGridView('update', {
                                        data: $(this).serialize()
                                    });

                                }

                            });
                            $(this).dialog("close");
                        } else {
                            alert(datos);
                        }
                    }
                }
            ]
        });
        Loading.hide();

    }

    function eliminarProveedor(id) {
        var id = btoa(id);

        $("#dialogPantalla").html('<div class="alertDialogBox"><p class="bolder center grey">¿Desea Eliminar este proveedor de plantel?</p></div>');
        var dialog = $("#dialogPantalla").removeClass('hide').dialog({
            modal: true,
            width: '450px',
            dragable: false,
            resizable: false,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='fa fa-exclamation-triangle'></i> Eliminación de Proveedor</h4></div>",
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
                    html: "<i class='icon-trash bigger-110'></i>&nbsp; Eliminar ",
                    "class": "btn btn-danger btn-xs",
                    click: function() {
                        var divResult = "resultadoOperacion";
                        var urlDir = "/planteles/proveedorAsignado/eliminarProveedor";
                        var datos = {id: id};
                        var conEfecto = true;
                        var showHTML = true;
                        var method = "POST";
                        var callback = function() {
                            $('#plantel-proveedor-grid').yiiGridView('update', {
                                data: $(this).serialize()
                            });
                        };
                        if (datos) {
                            $.ajax({
                                url: urlDir,
                                data: datos,
                                dataType: 'html',
                                type: method,
                                success: function(resp) {
                                    $("#respProveedorEliminado").html(resp);
                                    $("#respProveedorAsignado").html('');
                                    $('#plantel-proveedor-grid').yiiGridView('update', {
                                        data: $(this).serialize()
                                    });
                                }

                            });
                            $(this).dialog("close");
                        } else {
                            alert(datos);
                        }
                    }
                }
            ]
        });
        Loading.hide();

    }

</script>