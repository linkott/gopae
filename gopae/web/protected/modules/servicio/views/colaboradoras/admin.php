<?php
/* @var $this ColaboradorasController */
/* @var $model Colaborador */

$this->pageTitle = 'Madres y Padres Colaboradores';

$this->breadcrumbs=array(
	'Servicio'=>array('lista'),
	'Colaboradoras',
);

?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Lista de Madres y Padres Colaboradores</h5>

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
                                En este módulo podrá registrar y/o actualizar los datos de las Madres y Padres Colaboradores. Estos datos son necesarios para realizar asignación de ellos a Planteles Educativos. Las Madres y Padres Colaboradores son parte esencial del Programa de Alimentación Escolar.
                            </p>
                        </div>
                    </div>
                    <?php
                    // if (($groupId == 1) || ($groupId == 18)) {
                    ?>
                    <div class="pull-right" style="padding-left:10px;">
                        <a href="<?php echo $this->createUrl('/servicio/colaboradoras/creacion/'); ?>" type="submit" id='newRegister' data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Nueva Madre o Padre Colaborador(a)
                        </a>
                    </div>
                    <?php
                    //}
                    ?>

                    <div class="row space-20"></div>

                </div>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id'=>'colaborador-grid',
                        'dataProvider'=>$dataProviderColaboradores,
                        'filter'=>$model,
                        'itemsCssClass' => 'table table-striped table-bordered table-hover',
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

                                    $('#Colaborador_cedula').bind('keyup blur', function () {
                                        keyNum(this, false);
                                        clearField(this);
                                    });

                                    $('#Colaborador_origen').bind('keyup blur', function () {
                                        keyText(this, true);
                                        clearField(this);
                                    });

                                    $('#Colaborador_nombre').bind('keyup blur', function () {
                                        keyText(this, true);
                                    });

                                    $('#Colaborador_nombre').bind('blur', function () {
                                        clearField(this);
                                    });

                                    $('#Colaborador_apellido').bind('keyup blur', function () {
                                        keyText(this, true);
                                    });

                                    $('#Colaborador_apellido').bind('blur', function () {
                                        clearField(this);
                                    });
                                }
                        ",
                        'columns'=>array(
                            array(
                                'header' => '<center>Origen</center>',
                                'name' => 'origen',
                                'filter' => CHtml::textField('Colaborador[origen]', $model->origen, array('title' => 'Origen', 'maxlength' => '1')),
                                'htmlOptions' => array('width'=>'5%'),
                            ),
                            array(
                                'header' => '<center>Documento de Identidad</center>',
                                'name' => 'cedula',
                                'filter' => CHtml::textField('Colaborador[cedula]', $model->cedula, array('title' => 'Documento de Identidad', 'maxlength' => '12')),
                                'htmlOptions' => array('width'=>'15%'),
                            ),
                            array(
                                'header' => '<center>Fecha de Nacimiento</center>',
                                'name' => 'fecha_nacimiento',
                                'value' => array($this, 'fechaNacimiento'),
                                'filter' => CHtml::textField('Colaborador[fecha_nacimiento]', Utiles::transformDate($model->fecha_ini, '-', 'ymd', 'dmy'), array('id' => "date-picker", 'placeHolder' => 'DD-MM-AAAA', 'maxlength' => '10')),
                            ),
                            array(
                                'header' => '<center>Nombre</center>',
                                'name' => 'nombre',
                                'filter' => CHtml::textField('Colaborador[nombre]', $model->nombre, array('title' => 'Nombre', 'placeholder'=>'Nombre', 'maxlength' => '80')),
                            ),
                            array(
                                'header' => '<center>Apellido</center>',
                                'name' => 'apellido',
                                'filter' => CHtml::textField('Colaborador[apellido]', $model->apellido, array('title' => 'Apellido', 'placeholder'=>'Apellido', 'maxlength' => '80')),
                            ),
                            array(
                                'header' => '<center>Estado</center>',
                                'name' => 'estado_id',
                                'value' => '(is_object($data->estado))? $data->estado->nombre : ""',
                                //'value' => '(is_object($data->responsableAsignado))?$data->bandejaActual->nombre:""',
                                'filter' => CHtml::listData( CEstado::getData() , 'id', 'nombre'),
                            ),
                            array(
                                'header' => '<center>Sexo</center>',
                                'name' => 'sexo',
                                'value' => array($this, 'sexo'),
                                //'value' => '(is_object($data->responsableAsignado))?$data->bandejaActual->nombre:""',
                                'filter' => CHtml::listData( $this->listaDeSexos() , 'id', 'nombre'),
                            ),
                            array(
                                'type' => 'raw',
                                'header' => '<center>Acción</center>',
                                'value' => 'ColaboradorasController::columnaAcciones($data, "'.$estatusAutoridadPlantel.'")',
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
        Yii::app()->request->baseUrl . '/public/js/modules/servicio/colaboradoras/admin.js',CClientScript::POS_END
    );
?>