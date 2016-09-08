<?php
/* @var $this TalentoHumanoController */
/* @var $model TalentoHumano */

$this->pageTitle = 'Talento Humano del CNAE';

$this->breadcrumbs=array(
	'Gestión Humana'=>array('lista'),
	'Talento Humano',
);

?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Listado de Talento Humano</h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">

                <div class="row space-6"></div>
                <div>
                    <div id="resultadoOperacion">
                        <div class="infoDialogBox">
                            <p>
                                En este módulo podrá registrar y/o actualizar los datos del Talento Humano del CNAE. Estos datos son necesarios para realizar asignación de ellos a Planteles Educativos como Madres o Padres Cocineros como parte esencial del Programa de Alimentación Escolar.
                            </p>
                        </div>
                    </div>
                    <?php
                    // if (($groupId == 1) || ($groupId == 18)) {
                    ?>
                    <div class="pull-right" style="padding-left:10px;">
                        <a href="<?php echo $this->createUrl('/gestionHumana/talentoHumano/creacion/'); ?>" type="submit" id='newRegister' data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Nuevo Talento Humano
                        </a>
                    </div>
                    <?php
                    //}
                    ?>

                    <div class="row space-20"></div>

                </div>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id'=>'talento-humano-lista-grid',
                        'dataProvider'=>$dataProviderTalentoHumano,
                        'filter'=>$model,
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
                        'emptyText' => '<div class="alertDialogBox"><p>No se encontraron resultados. Puede que no haya ingresado aún un parámetro de búsqueda.</p></div>',
                        'summaryText' => 'Mostrando {start}-{end} de {count}',
                        'pager' => array(
                            'header' => '',
                            'htmlOptions' => array('class' => 'pagination'),
                            'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                            'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
                            'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
                            'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
                        ),
                        'afterAjaxUpdate' => "
                                function(){

                                    $('#date-picker').datepicker();
                                    $.datepicker.setDefaults({
                                        dateFormat: 'dd-mm-yy',
                                        showOn:'focus',
                                        showOtherMonths: false,
                                        selectOtherMonths: true,
                                        changeMonth: true,
                                        changeYear: true,
                                        minDate: new Date(1700, 1, 1),
                                        maxDate: 'today'
                                    });

                                    $('#TalentoHumano_cedula').bind('keyup blur', function () {
                                        keyNum(this, false);
                                        clearField(this);
                                    });

                                    $('#TalentoHumano_origen').bind('keyup blur', function () {
                                        keyText(this, true);
                                        clearField(this);
                                    });

                                    $('#TalentoHumano_nombre').bind('keyup blur', function () {
                                        keyText(this, true);
                                    });

                                    $('#TalentoHumano_nombre').bind('blur', function () {
                                        clearField(this);
                                    });

                                    $('#TalentoHumano_apellido').bind('keyup blur', function () {
                                        keyText(this, true);
                                    });

                                    $('#TalentoHumano_apellido').bind('blur', function () {
                                        clearField(this);
                                    });
                                }
                        ",
                        'columns'=>array(
                            array(
                                'header' => '<center>Origen</center>',
                                'name' => 'origen',
                                'filter' => CHtml::textField('TalentoHumano[origen]', $model->origen, array('title' => 'Origen', 'maxlength' => '1')),
                                'htmlOptions' => array('width'=>'5%'),
                            ),
                            array(
                                'header' => '<center>Documento de Identidad</center>',
                                'name' => 'cedula',
                                'filter' => CHtml::textField('TalentoHumano[cedula]', $model->cedula, array('title' => 'Documento de Identidad', 'maxlength' => '12')),
                                'htmlOptions' => array('width'=>'15%'),
                            ),
                            array(
                                'header' => '<center>Nombre</center>',
                                'name' => 'nombre',
                                'filter' => CHtml::textField('TalentoHumano[nombre]', $model->nombre, array('title' => 'Nombre', 'placeholder'=>'Nombre', 'maxlength' => '80')),
                            ),
                            array(
                                'header' => '<center>Apellido</center>',
                                'name' => 'apellido',
                                'filter' => CHtml::textField('TalentoHumano[apellido]', $model->apellido, array('title' => 'Apellido', 'placeholder'=>'Apellido', 'maxlength' => '80')),
                            ),
                            array(
                                'header' => '<center>Estado</center>',
                                'name' => 'estado_id',
                                'value' => '(is_object($data->estado))? $data->estado->nombre : ""',
                                //'value' => '(is_object($data->responsableAsignado))?$data->bandejaActual->nombre:""',
                                'filter' => CHtml::listData( CEstado::getData() , 'id', 'nombre'),
                            ),
                            array(
                                'header' => '<center>Categoría de Cargo</center>',
                                'name' => 'tipo_cargo_actual_id',
                                'value' => '(is_object($data->tipoCargoActual))? $data->tipoCargoActual->nombre : ""',
                                'filter' => CHtml::listData( $tiposDeCargo , 'id', 'nombre'),
                            ),
                            array(
                                'header' => '<center>Estatus</center>',
                                'name' => 'estatus',
                                'value' => 'strtr($data->estatus'.", array(TalentoHumano::ASPIRANTE=>'Aspirante', TalentoHumano::EMPLEADO_ACTIVO=>'Empleado', TalentoHumano::EMPLEADO_INACTIVO=>'Inactivo', TalentoHumano::EMPLEADO_PASIVO=>'Pasivo', TalentoHumano::EN_COMISION_DE_SERVICIO=>'Comisión de Servicio', TalentoHumano::OTRO=>'Otro'))",
                                'filter' => array(TalentoHumano::ASPIRANTE=>'Aspirante', TalentoHumano::EMPLEADO_ACTIVO=>'Empleado', TalentoHumano::EMPLEADO_INACTIVO=>'Inactivo', TalentoHumano::EMPLEADO_PASIVO=>'Pasivo', TalentoHumano::EN_COMISION_DE_SERVICIO=>'Comisión de Servicio', TalentoHumano::OTRO=>'Egreso'),
                            ),
                            array(
                                'type' => 'raw',
                                'header' => '<center>Acción</center>',
                                'value' => 'TalentoHumanoController::columnaAcciones($data, "'.$estatusAutoridadPlantel.'")',
                                'htmlOptions' => array('nowrap'=>'nowrap'),
                            ),
                        ),
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php 
    Yii::app()->clientScript->registerScriptFile(
        Yii::app()->request->baseUrl . '/public/js/modules/gestionHumana/talentoHumano/admin.js',CClientScript::POS_END
    );
?>
