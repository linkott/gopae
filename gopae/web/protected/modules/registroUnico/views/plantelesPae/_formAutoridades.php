<?php
/**
 * @var $plantel Plantel
 * @var $autoridadesPlantel AutoridadPlantel
 * @var $dataProviderAutoridades CArrayDataProvider
 */
?>
<div class="form" id="_formAutoridades">

    <?php
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

        <div id="autor" class="widget-box">


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
                <h5>Autoridades del Plantel - (<?php echo $plantel->cod_plantel; ?>) <?php echo $plantel->nombre; ?></h5>
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
                            <?php echo '<input type="hidden" id="plantel_id" value=' . $plantel->id . ' name="plantel_id"/>'; ?>
                            <div class="col-md-4">
                                <div class="col-md-12"><label for="Plantel_cedula">Cédula de Identidad<span class="required">*</span></label></div>
                                <div class="input-group">
                                    <form id="formBusquedaAutoridadPlantelAsign">
                                        <input type="text" autocomplete="off" value="" data-toggle="tooltip" maxlength="15" data-placement="bottom" placeholder="V-0000000" title="Ej: V-99999999 ó E-99999999" id="cedula" class="form-control" name="cedula" onkeypress = "return CedulaFormat(this, event)" required />
                                        <span class="input-group-btn">
                                          <button class="btn btn-sm btn-info" id = "btnBuscarCedula" type="submit">
                                              <i class="icon-search"></i>
                                              Buscar
                                          </button>
                                        </span>
                                    </form>
                                </div><!-- /input-group -->
                            </div>
                            <div class="col-md-4">
                                <span class="cargandoBusquedaAutoridad"></span>
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
                                                'name' => 'telefono_fijo',
                                                'type' => 'raw',
                                                'header' => '<center><b>Teléfono Fijo</b></center>'
                                            ),
                                            array(
                                                'name' => 'telefono_celular',
                                                'type' => 'raw',
                                                'header' => '<center><b>Teléfono Celular</b></center>'
                                            ),
                                            array(
                                                'name' => 'presento_documento_identidad',
                                                'type' => 'raw',
                                                'header' => '<center><b>Verificada C.I.</b></center>',
                                            ),
                                            array(
                                                'name' => 'foto',
                                                'type' => 'raw',
                                                'header' => '<center><b>Foto</b></center>',
                                            ),
                                            array(
                                                'name' => 'boton',
                                                'type' => 'raw',
                                                'header' => '<center><b>Acciones</b></center>',
                                                'htmlOptions' => array('nowrap'=>'nowrap'),
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
                                <div class="text-muted credit">Se considera a una autoridad verificada cuando esta ha presentado su Documento de Identidad y se le ha tomado y guardado su fotografía en el sistema.</div>
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
                        <a href="/registroUnico/madresCocineras/asignadas/id/<?php echo base64_encode($plantel->id); ?>" title="Registro y Consulta de Madres Cocineras" class="fa fa-female purple">
                            <span style="font-family:Helvetica Neue,Arial,Helvetica,sans-serif;">&nbsp;&nbsp;Madres Cocineras</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="hide" id="datosAutoridad"></div>

</div>

<?php
$this->endWidget();
?>

<script >
    $('#cedula').tooltip({
        show: {
            effect: "slideDown",
            delay: 250
        }
    });
    
    $("#plantelAutoridades-form").on('submit', function(evt){
        evt.preventDefault();
        var cedula = $("#cedula").val();
        var mensaje = "Estimado usuario, el formato de la Cedula de Identidad no es el correcto.";
        if (cedula.length > 2 && cedula.length <= 11) {
            buscarCedulaAutoridad(cedula);
        }
        else {
            dialogo_error(mensaje);
        }
    });
    
    $("#formBusquedaAutoridadPlantelAsign").on('submit', function(evt){
        evt.preventDefault();
        var cedula = $("#cedula").val();
        var mensaje = "Estimado usuario, el formato de la Cedula de Identidad no es el correcto.";
        if (cedula.length > 2 && cedula.length <= 11) {
            buscarCedulaAutoridad(cedula);
        }
        else {
            dialogo_error(mensaje);
        }
    });

    $(".change-data").unbind('click');
    $(".change-data").click(function() {

        var plantelId = $("#PlantelPae_plantel_id").val();
        usuario_id = $(this).attr('data-id');
        plantel_id = $("#plantel_id").val();
        data = {
            usuario_id: usuario_id,
            plantel_id: plantel_id
        };
        var divResult = "#datosAutoridad";
        var urlDir = "/registroUnico/plantelesPae/buscarAutoridad/plantelId/"+base64_encode(plantelId);
        var datos = data;
        var loadingEfect = true;
        var showResult = true;
        var method = "GET";
        var responseFormat = "html";
        var successCallback = function(response, state, dom) {
            
            $("#datosAutoridad").html(response).ready(function(){

                $("#datosAutoridad").removeClass('hide').dialog({
                    modal: true,
                    width: '800px',
                    draggable: false,
                    resizable: false,
                    position: ['center', 50],
                    title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-user'></i> Datos de la Autoridad del Plantel</h4></div>",
                    title_html: true,
                    buttons: [
                        {
                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                            "class": "btn btn-danger btn-xs",
                            click: function() {
                                $(this).dialog("close");
                                $("#datosAutoridad").html('').addClass('hide');
                            }
                        },
                        {
                            html: "Actualizar Datos <i class='icon-save bigger-110'></i>",
                            "class": "btn btn-primary btn-xs",
                            click: function() {

                                var divResult = "resultado-cambio-datos";
                                var divResultAjaxCallback = "_formAutoridades";
                                var mensaje = "";

                                var email = $("#email").val();
                                var emailBackup = $("#emailBackup").val();

                                var telf_fijo = $("#telf_fijo").val();
                                var telf_fijoBackup = $("#telf_fijoBackup").val();

                                var telf_cel = $("#telf_cel").val();
                                var telf_celBackup = $("#telf_celBackup").val();

                                var presento_documento_identidad = $("#Editar_presento_documento_identidad").val();
                                var presento_documento_identidad_backup = $("#presento_documento_identidad_backup").val();

        //                        var cargo_id = $("#cargo_id_autoridad option:selected").val();
        //                        var cargo_idBackup = $("#cargo_idBackup").val();

                                var usuario_id = $("#usuario_id").val();
                                var plantel_id = $("#plantel_id").val();

                                // console.log(plantel_id.length);
                                // console.log(usuario_id.length);

                                if (plantel_id.length > 0 && usuario_id.length > 0) {

                                    $("#resultado-cambio-datos").html('');

                                    mensaje = "";
        //                          if (emailBackup != email || telf_fijo != telf_fijoBackup || telf_cel != telf_celBackup || cargo_id != cargo_idBackup) {
                                    if (emailBackup != email || telf_fijo != telf_fijoBackup || telf_cel != telf_celBackup || presento_documento_identidad!=presento_documento_identidad_backup) {
                                        if (telf_cel != telf_celBackup && (!isValidPhone(telf_cel, 'movil') || telf_cel.length != 11)) {
                                            mensaje = "El teléfono celular no posee el formato correcto <br>";
                                            $("#telf_cel").val(telf_celBackup);
                                        }
                                        if ((telf_fijo.length != 11 && telf_fijo.length != 0)) {
                                            mensaje = mensaje + "El teléfono fijo no posee el formato correcto <br>";
                                            $("#telf_fijo").val(telf_fijoBackup);
                                        }
                                        if (emailBackup != email && (!isValidEmail(email) || email.length < 3)) {
                                            mensaje = mensaje + "El correo electrónico no posee el formato correcto <br>";
                                            $("#email").val(emailBackup);
                                        }
                                        if(presento_documento_identidad!='SI'){
                                            mensaje = mensaje + "Para poder registrar la autoridad la misma debe presentar su documento de identidad.<br>";
                                            $.gritter.add({
                                                title: 'No se ha presentado el Documento de Identidad',
                                                text: 'Para poder registrar la autoridad la misma debe presentar su documento de identidad.',
                                                class_name: 'gritter-error'
                                            });
                                        }

                                        //console.log(mensaje);

                                        if (mensaje.length==0) {

                                            // console.log("Ejecutando la petición ajax");
                                            var divResult = '#resultado-cambio-datos';
                                            var datos = $("#form-autoridad-plantel").serialize();
                                            var urlDir = "/registroUnico/plantelesPae/actualizarDatosAutoridad";
                                            var loadingEfect = true;
                                            var showResult = true;
                                            var method = "POST";
                                            var responseFormat = 'html';
                                            var successCallback = function(response, state, dom) {
                                                if(response.indexOf('successDialogBox')!=-1){
                                                    var usrId = base64_decode($("#usuario_id").val());
                                                    $("#telefono_fijo_"+usrId).html($("#telf_fijo").val());
                                                    $("#telefono_celular_"+usrId).html($("#telf_cel").val());
                                                    $("#ci_"+usrId).html($("#Editar_presento_documento_identidad").val());
                                                    $("#correo_"+usrId).html($("#email").val().toLowerCase());
                                                }
                                            };

                                            executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);
                                        }
                                        else {
                                            mensaje = "Debe llenar todos los campos de forma adecuada. Puede que no haya ningún cambio que guardar en este formulario.<br>"+mensaje;
                                            displayDialogBox(divResult, 'error', mensaje);
                                        }
                                    }
                                    else{
                                        mensaje = "No existen cambios en el formulario como para efectuar una actualización.";
                                        displayDialogBox(divResult, 'error', mensaje);
                                    }

                                }
                                else {

                                    displayDialogBox(divResult, 'error', 'No se ha podido identificar al usuario al que desea actualizar los datos. Recargue la página e intenetelo de nuevo.');

                                }

                            }
                        },
                        {
                            html: "Resetear Clave <i class='icon-key bigger-110'></i>",
                            "class": "btn btn-success btn-xs hide",
                            click: function() {

                                $.gritter.removeAll();
                                //Cambiar el Correo
                                var divResult = "resultado-cambio-datos";

                                var email = $("#email").val();
                                var emailBackup = $("#emailBackup").val();
                                var usuario_id = $("#usuario_id").val();

                                if (usuario_id.length > 0) {

                                    var datos = {id: usuario_id, plantel_id: plantel_id, email: email};
                                    var urlDir = "/control/autoridadesZona/resetearClave";
                                    var conEfecto = true;
                                    var showHTML = true;
                                    var method = "POST";
                                    var callback = null;
                                    var responseFormat = "html";

                                    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                }
                                else {

                                    displayDialogBox(divResult, 'error', 'No se ha podido identificar al usuario al que desea modificar el correo. Recargue la página e intenetelo de nuevo.');

                                }

                            }
                        }
                    ]
                });
            });
            
        };

        executeAjax(divResult, urlDir, datos, loadingEfect, showResult, method, responseFormat, successCallback);

    });
    
    $(".picture-data").unbind('click');
    $(".picture-data").click(function() {
        
        var autoridadId = $(this).attr('data-id');
        var divResult = "#dialogFotografia";
        var datos = null;
        var urlDir = $(this).attr("data-url");
        var conEfecto = true;
        var showHTML = true;
        var method = "POST";
        var responseFormat = "html";
        var callback = function(response){
            
            $("#dialogFotografia").html(response).ready(function(){
    
                $("#dialogFotografia").removeClass('hide').dialog({
                    modal: true,
                    width: '980px',
                    draggable: false,
                    resizable: false,
                    position: ['center', 50],
                    title: "<div class='widget-header'><h4 class='smaller blue'><i class='icon-user'></i> Datos de la Autoridad del Plantel</h4></div>",
                    title_html: true,
                    buttons: [
                        {
                            html: "<i class='icon-arrow-left bigger-110'></i>&nbsp; Volver",
                            "class": "btn btn-danger btn-xs",
                            "id": "btnCancelarFotografia",
                            click: function() {
                                $.gritter.removeAll();
                                $(this).dialog("close");
                                $("#dialogFotografia").html('').addClass('hide');
                            }
                        },
                        {
                            html: "Registrar Fotografía <i class='icon-save bigger-110'></i>",
                            "class": "btn btn-primary btn-xs",
                            "id":"btnRegistrarFotografia",
                            click: function() {
                                var divResult = "#resultadoRegistroFotografia";
                                var fotoExistente = $("#fotoImgBase64").val();
                                if(fotoExistente.length==0){
                                    displayDialogBox(divResult, "error", "Debe tomar la foto de la autoridad, antes de efectuar el registro");
                                }else{
                                    var datos = $("#form-autoridad-fotografia").serialize();
                                    var urlDir = $("#form-autoridad-fotografia").attr("action");
                                    var conEfecto = true;
                                    var showHTML = true;
                                    var method = "POST";
                                    var responseFormat = "html";
                                    var callback = function(resp){

                                    };
                                    executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
                                }
                            }
                        }
                    ]
                });
        
                var fotoExistente = $("#Persona_foto").val();
                if(fotoExistente){
                    var cameraActive = false;
                    var buttonsActive = true;
                }else{
                    var cameraActive = true;
                    var buttonsActive = true;
                }
                configCamera(cameraActive, buttonsActive);
                $("#form-autoridad-fotografia").on("submit", function(evt){
                    evt.preventDefault();
                });
                $("#foto_"+autoridadId).html("Si");
            });
        };
        executeAjax(divResult, urlDir, datos, conEfecto, showHTML, method, responseFormat, callback);
    });
</script>
<div id = "dialogFotografia" class="hide">
</div>
