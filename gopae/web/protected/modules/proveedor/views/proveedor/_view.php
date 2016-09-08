<?php
/* @var $this ProveedorController */
/* @var $data Proveedor */
$this->pageTitle = 'Datos de Proveedor';

$this->breadcrumbs = array(
    'Proveedores' => array('/proveedor/proveedor/'),
    'Detalles de Proveedor'
);
?>
<div class="tabbable">

    <ul class="nav nav-tabs">

        <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>
        <li><a data-toggle="tab" href="#socios">Socios</a></li>
        <li><a data-toggle="tab" href="#documentos">Documentos</a></li>
        <li><a data-toggle="tab" href="#zonas">Zona(s)</a></li>
        
    </ul>

    <div class="tab-content">
        <div id="datosGenerales" class="tab-pane active">


            <div class="widget-box">
                <div class="widget-header">
                    <h5>Datos de Proveedor</h5>

                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="icon-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Rif</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read" ><?php echo $model->rif; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Razón Social</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read" ><?php echo $model->razon_social; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Tipo de Empresa</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php if ($model->tipoEmpresa->nombre): ?>
                                        <span class="data-read" ><?php echo $model->tipoEmpresa->nombre ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="space-10"></div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Capital</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read" ><?php echo $model->capital_social; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Telefono Local</b></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read" ><?php if ($model->telefono_local) { ?>
                                        <?php echo $model->telefono_local; ?>
                                    <?php } else { ?>
                                        <?php
                                        echo "NO TIENE";
                                    }
                                    ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Telefono Celular</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">                       
                                    <span class="data-read" ><?php echo $model->telefono_celular; ?></span>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="space-10"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Sector</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php if ($model->tipoSector->nombre) { ?>
                                        <span class="data-read" ><?php echo $model->tipoSector->nombre; ?></span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Correo</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read" ><?php echo $model->email; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Correo Alternativo</b></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read"><?php if ($model->email_otro) { ?>
                                        <?php echo $model->email_otro; ?>
                                    <?php } else { ?>
                                        <?php
                                        echo "NO TIENE";
                                    }
                                    ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-box collapsed">

                <div class="widget-header">
                    <h5>Datos de Ubicación</h5>

                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="icon-chevron-down"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Estado</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read">
                                    <?php if (is_object($model->estado)) { ?>
                                        <?php
                                        echo $model->estado->nombre;
                                        ?>
                                    <?php } ?>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Municipio</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read">
                                    <?php if (is_object($model->municipio)) { ?>
                                        <?php
                                        echo $model->municipio->nombre;
                                        ?>
                                    <?php } ?>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Parroquia</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php if (is_object($model->parroquia)) { ?>
                                        <span class="data-read"><?php echo $model->parroquia->nombre; ?></span>
                                    <?php } ?>
                                        
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="space-10"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Población</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php if (is_object($model->Poblacion)) { ?>
                                        <span class="data-read"><?php echo $model->Poblacion->nombre; ?></span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Urbanización</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <?php if (is_object($model->Urbanizacion)) { ?>
                                        <span class="data-read"><?php echo $model->Urbanizacion->nombre; ?></span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="space-10"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <label><b>Dirección Referencial </b><span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="data-read"><?php echo $model->direccion; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="widget-box collapsed">

                <div class="widget-header">
                    <h5>Datos de Auditoria</h5>

                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="icon-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b> &nbsp;I.V.S.S</b></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read">
                                    <?php if ($model->ivss) { ?>
                                        <?php echo $model->ivss; ?>
                                    <?php } else { ?>
                                        <?php
                                        echo "NO TIENE";
                                    }
                                    ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>N.I.L</b></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read">
                                    <?php if ($model->nil) { ?>
                                        <?php echo $model->nil; ?>
                                    <?php } else { ?>
                                        <?php
                                        echo "NO TIENE";
                                    }
                                    ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">

                                    <label><b>I.N.C.E.S</b></label>

                                </div>
                                <div class="col-md-12">
                                    <span class="data-read">
                                    <?php if ($model->inces) { ?>
                                        <?php echo $model->inces; ?>
                                    <?php } else { ?>
                                        <?php
                                        echo "NO TIENE";
                                    }
                                    ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="space-10"></div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>B.A.N.A.V.I.H</b></label>

                                </div>
                                <div class="col-md-12">
                                    <span class="data-read">
                                    <?php if ($model->banavih) { ?>
                                        <?php echo $model->banavih; ?>
                                    <?php } else { ?>
                                        <?php
                                        echo "NO TIENE";
                                    }
                                    ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>S.N.C</b></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read">
                                    <?php if ($model->snc) { ?>
                                        <?php echo $model->snc; ?>
                                    <?php } else { ?>
                                        <?php
                                        echo "NO TIENE";
                                    }
                                    ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Solvencia Laboral</b></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read">
                                    <?php if ($model->solvencia_laboral) { ?>
                                        <?php echo $model->solvencia_laboral; ?>
                                    <?php } else { ?>
                                        <?php
                                        echo "NO TIENE";
                                    }
                                    ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget-box collapsed">

                <div class="widget-header">
                    <h5>Datos Financieros</h5>

                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="icon-chevron-down"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main form">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Rif del Titular de la Cuenta</b><span class="required">*</span></label>
                                </div>                        
                                <div class="col-md-12">
                                    <span class="data-read"><?php echo $model->rif_titular_cuenta; ?></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Titular de la Cuenta</b><span class="required">*</span></label>
                                </div>                        
                                <div class="col-md-12">
                                    <span class="data-read"><?php echo $model->titular_cuenta; ?></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Banco</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read"><?php echo $model->banco->nombre; ?></span>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="space-10"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Tipo de Cuenta</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read"><?php echo $model->tipoCuenta->nombre; ?></span>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b>Nro de Cuenta</b><span class="required">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <span class="data-read"><?php echo $model->numero_cuenta; ?></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <label><b> ¿Posee algun familiar en el ministerio? </b><span class="required">*</span></label>
                                </div>                        
                                <div class="col-md-12">
                                    <span class="data-read">
                                    <?php
                                    if ($model->vinculo_funcionario) {
                                        echo "SI";
                                        ?>

                                    <?php } else { ?>
                                        <?php
                                        echo "NO";
                                    }
                                    ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>




            <hr>
            <div class="row-fluid wizard-actions">

                <a class="btn btn-danger" href="/proveedor/proveedor/">
                    <i class="icon-arrow-left bigger-110"></i>
                    Volver
                </a>

            </div>
        </div>
        
        
        <div id="socios" class="tab-pane">
            <?php
            if ($model->id !== NULL) {
                $this->renderPartial('_formSocio', array('model' => $modelSocio, 'proveedor_id' => $proveedor_id, 'tipo' => 'view'/* , 'dataProvider' => $dataProviderAula */));
            } else {
                ?>
            <div id='infoProveedorSocios' class="alertDialogBox">
                <p>
                    Debe registrar primero el proveedor para registrar los socios.
                </p>
            </div>
                <?php
            }
            ?>
        </div>
        <div id="documentos" class="tab-pane">
   
                     <div>
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'id' => 'documento-grid',
                            'dataProvider' => $modelDocumentos->searchDocumentoProveedor($proveedor_id),
                            'filter' => $modelDocumentos,
                            'pager' => array('pageSize' => 1),
                            'summaryText' => false,
                            'afterAjaxUpdate' => "function(){
                                }",
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
                                    'class' => 'CLinkColumn',
                                    'header' => '<center title="Nombre del Documento Cargado"> Nombre del Documento </center>',
                                    'labelExpression' => '$data->nombre',
                                    'urlExpression' => '"/proveedor/proveedor/descargar/id/".base64_encode($data->ruta)'
                                ),
                                array(
                                    'header' => '<center title="Estatus del Documento Cargado"> Estatus </center>',
                                    'name' => 'estatus',
                                    'filter' => array('A' => 'Activo', 'E' => 'Inactivo'),
                                    'value' => array($this, 'columnaEstatus'),
                                ),
//                                array(
//                                    'type' => 'raw',
//                                    'header' => '<center>Acciones</center>',
//                                    'value' => array($this, 'columnaAccionesDocumentos'),
//                                    'htmlOptions' => array('width' => '5%'),
//                                ),
                            ),
                        ));
                        ?>
                    </div><!-- search-form -->
             
        </div>
        
        <div id="zonas" class="tab-pane">
            <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'id' => 'documento-grid',
                        'dataProvider' => $modelZona->search(),
                        'filter' => $modelZona,
                        'pager' => array('pageSize' => 1),
                        'summaryText' => false,
                        'afterAjaxUpdate' => "function(){
                                }",
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
                                'header' => '<center title="Estado atendido"> Estado </center>',
                                'name' => 'estado_id'
                            ),
                            array(
                                'header' => '<center title="Municipio atendido"> Municipio </center>',
                                'name' => 'municipio_id'
                            ),
                            array(
                                'header' => '<center title="Parroquia atendido"> Parroquia </center>',
                                'name' => 'parroquia_id'
                            ),
                            array(
                                'header' => '<center title="Población atendido"> Población </center>',
                                'name' => 'poblacion_id'
                            ),
                            array(
                                'header' => '<center title="Estatus"> Estatus </center>',
                                'name' => 'estatus',
                                'filter' => array('A' => 'Activo', 'E' => 'Inactivo'),
                                'value' => array($this, 'columnaEstatus'),
                            ),
                            array(
                                'type' => 'raw',
                                'header' => '<center>Acciones</center>',
                                'value' => array($this, 'columnaAccionesZonas'),
                                'htmlOptions' => array('width' => '5%'),
                            ),
                        ),
                    ));
                    ?>
        </div>
        
    </div>
</div>

