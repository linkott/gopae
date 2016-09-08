<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;

?>

<div class="col-xs-12">
    <div class="row row-fluid">
        <div class="form">

            <div class="tabbable">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>
                    <li><a data-toggle="tab" href="#desarrollo">Proyectos de Desarrollo Endógeno</a></li>
                    <li><a data-toggle="tab" href="#servicio">Servicios</a></li>
                    <li><a data-toggle="tab" href="#autoridades">Autoridades</a></li>
                    <li><a data-toggle="tab" href="#otros">Otros</a></li>
                    <li><a data-toggle="tab" href="#mapa">Ubicaci&oacute;n en el Mapa</a></li>
                </ul>

                <div class="tab-content">

                    <div id="desarrollo" class="tab-pane">Proyectos de Desarrollo Endógeno</div>
                    <div id="servicio" class="tab-pane">Servicios</div>
                    <div id="autoridades" class="tab-pane">Autoridades</div>
                    <div id="otros" class="tab-pane">Otros</div>
                    <div id="mapa" class="tab-pane">Ubicaci&oacute;n en el Mapa</div>


                    <div id="datosGenerales" class="tab-pane active">

                        <div id="resultado">
                            <div class="infoDialogBox">
                                <p>
                                    Debe Ingresar los Datos Generales del Plantel, los campos marcados con <span class="required">*</span> son requeridos.
                                </p>
                            </div>
                            <div class="alertDialogBox">
                                <p>
                                    Debe Ingresar los Datos Generales del Plantel, los campos marcados con <span class="required">*</span> son requeridos.
                                </p>
                            </div>
                            <div class="successDialogBox">
                                <p>
                                    Debe Ingresar los Datos Generales del Plantel, los campos marcados con <span class="required">*</span> son requeridos.
                                </p>
                            </div>
                            <div class="errorDialogBox">
                                <p>
                                    Debe Ingresar los Datos Generales del Plantel, los campos marcados con <span class="required">*</span> son requeridos.
                                </p>
                            </div>
                        </div>

                        <div class="widget-box">

                            <div class="widget-header">
                                <h5>Información General</h5>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">

                                <div style="display: block;" class="widget-body-inner">

                                    <div class="widget-main form">

                                        <form method="post" action="#" id="menu-item-form" enctype="multipart/form-data">

                                            <div class="row">

                                                <div class="col-md-2">
                                                    <p>
                                                        <img class="img-thumbnail" alt="..." >
                                                    </p>
                                                    <p class="col-md-12">
                                                        <button class="btn btn-info btn-sm" type="button">
                                                            <i class="icon-cloud-upload "></i>
                                                            Agregar Logo
                                                        </button>
                                                    </p>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="Plantel_cod_plantel">Código del Plantel<span class="required">*</span></label>
                                                    <input type="text" id="Plantel_cod_plantel" name="Plantel[cod_plantel]" class="span-7" maxlength="10" size="10">                                                                                    
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="Plantel_cod_estadistico">Código Estadístico<span class="required">*</span></label>
                                                    <input type="text" id="Plantel_cod_estadistico" name="Plantel[cod_estadistico]" class="span-7">                                                                                    
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="Plantel_estatus">Estatus<span class="required">*</span></label>
                                                    <input type="text" id="Plantel_estatus" name="Plantel[estatus]" class="span-9" maxlength="1" size="1">                                                                                    
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="Plantel_fecha_fundacion">Fecha de fundación<span class="required">*</span></label>
                                                    <input type="text" id="Plantel_fecha_fundacion" name="Plantel[fecha_fundacion]" class="span-7">                                                                                    
                                                </div>                                      

                                                <div class="col-md-3">
                                                    <label for="nombre">Zona Educativa<span class="required">*</span></label>
                                                    <input type="text" id="Plantel_nombre" name="Plantel[nombre]" class="span-7" maxlength="150" size="60">                                                                                    
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="eponimo_id">Distrito Escolar<span class="required">*</span></label>
                                                    <input type="text" id="Plantel_eponimo_id" name="Plantel[eponimo_id]" class="span-9">                                                                                    
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="eponimo_id">Denominación<span class="required">*</span></label>
                                                    <select name="Plantel[dependencia]" id="dependencia" class="span-7">
                                                        <option>Nacional</option>
                                                        <option>Estadal</option>
                                                    </select>
                                                    <i class="actionHelp"></i>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="tipo_dependencia_id">Dependencia<span class="required">*</span></label>
                                                    <input type="text" id="Plantel_tipo_dependencia_id" name="Plantel[tipo_dependencia_id]"  class="span-7">                                                                                    
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="Plantel_nombre">Nombre<span class="required">*</span></label>
                                                    <input type="text" id="Plantel_nombre" name="Plantel[nombre]" class="span-9" maxlength="150" size="60">                                                                                    </div>
                                            </div>


                                            <hr>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-md-6">
                                <a href="#" class="btn btn-danger">
                                    <i class="icon-arrow-left"></i>
                                    Regresar
                                </a>
                            </div>
                            <div class="col-md-6 wizard-actions">
                                <button type="submit" data-last="Finish" class="btn btn-primary btn-next">
                                    Guardar
                                    <i class="icon-arrow-right icon-on-right"></i>
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>