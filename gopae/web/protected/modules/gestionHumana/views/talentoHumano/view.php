<?php
/* @var $this ColaboradorasController */
/* @var $model Colaborador */
/* @var $form CActiveForm */

$this->pageTitle = 'Consulta de Datos de Madres y Padres Colaboradores';

/* @var $this ColaboradorasController */
/* @var $model Colaborador */
$this->breadcrumbs=array(
        'Gestión Humana'=>array('lista'),
	'Talento Humano'=>array('lista'),
	'Consulta',
);
?>
<div class="col-md-12">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#datosGenerales" data-toggle="tab">Datos Generales</a></li>
            <li><a href="#asistencia" data-toggle="tab">Asistencia</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="datosGenerales">
                <div class="form">

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'colaborador-form',
                        'htmlOptions' => array('data-form-type'=>$formType, 'onSubmit'=>'return false;'), // for inset effect
                        // Please note: When you enable ajax validation, make sure the corresponding
                        // controller action is handling ajax validation correctly.
                        // There is a call to performAjaxValidation() commented in generated controller code.
                        // See class documentation of CActiveForm for details on this.
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div id="general">

                        <div class="widget-box">

                            <div class="widget-header">
                                <h5>Datos de Identificación y Servicio</h5>

                                <div class="widget-toolbar">
                                    <a data-action="collapse" href="#">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-body-inner">
                                    <div class="widget-main">
                                        <div class="widget-main form">

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'origen'); ?>
                                                        <?php echo CHtml::dropDownList('origen', $model->origen, CHtml::listData($origenes, 'abreviatura', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'cedula'); ?>
                                                        <?php echo CHtml::textField('cedula', $model->cedula, array('maxlength' => "15", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Nro. de Cédula', 'readOnly'=>'readOnly', )); ?>
                                                        <input id="read_existe_cedula" type="hidden" maxlength="2" disabled='disabled' />
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'fecha_nacimiento'); ?>
                                                        <input id="read_fecha_nacimiento_latino" value="<?php echo Utiles::transformDate($model->fecha_nacimiento, '-', 'y-m-d', 'd-m-y') ?>" type="text" maxlength="10" required='required' class='span-12' placeholder='DD-MM-YYYY' disabled='disabled' readOnly="readOnly" />
                                                    </div>
                                                </div>

                                                <div class="space-6"></div>

                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'nombre'); ?>
                                                        <?php echo CHtml::textField('nombre', $model->nombre, array('maxlength' => "40", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Nombre (s)', 'data-inicial'=>$model->nombre, 'readOnly'=>'readOnly',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'apellido'); ?>
                                                        <?php echo CHtml::textField('apellido', $model->apellido, array('maxlength' => "40", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Apellido (s)', 'data-inicial'=>$model->apellido, 'readOnly'=>'readOnly',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'sexo'); ?>
                                                        <?php echo CHtml::dropDownList('sexo', $model->sexo, CHtml::listData($generos, 'abreviatura', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'data-inicial'=>$model->sexo, 'disabled'=>'disabled',)); ?>
                                                    </div>
                                                </div>

                                                <div class="space-6"></div>

                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'mision_id'); ?>
                                                        <?php echo CHtml::dropDownList('mision_id', $model->mision_id, CHtml::listData($misiones, 'id', 'nombre'), array('prompt' => '- - -', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'certificado_medico'); ?>
                                                        <?php echo CHtml::dropDownList('certificado_medico', $model->certificado_medico, array('Si'=>'Sí', 'No'=>'No',), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'manipulacion_alimentos'); ?>
                                                        <?php echo CHtml::dropDownList('manipulacion_alimentos', $model->manipulacion_alimentos, array('Si'=>'Sí', 'No'=>'No',), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>
                                                </div>

                                                <div class="space-6"></div>

                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'grado_instruccion_id'); ?>
                                                        <?php echo CHtml::dropDownList('grado_instruccion_id', $model->grado_instruccion_id, CHtml::listData($gradosInstruccion, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'cantidad_hijos'); ?>
                                                        <?php echo CHtml::dropDownList('cantidad_hijos', $model->cantidad_hijos,array('0'=>'Ninguno', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=> '7', '8'=>'8',), array('class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'hijo_en_plantel'); ?>
                                                        <?php echo CHtml::dropDownList('hijo_en_plantel', $model->hijo_en_plantel, array('Si'=>'Sí', 'No'=>'No',), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>
                                                </div>

                                                <div class="space-6"></div>

                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'enfermedades'); ?>
                                                        <?php echo CHtml::textArea('enfermedades', $model->enfermedades, array('maxlength' => '400', 'rows'=>'3', 'class' => 'span-12', 'placeholder'=>'Indique si padece de alguna enfermedad o alergia', 'disabled'=>'disabled',)); ?>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <?php echo $form->labelEx($model,'observacion'); ?>
                                                        <?php echo CHtml::textArea('observacion', $model->observacion, array('maxlength' => '400', 'rows'=>'3', 'class' => 'span-12', 'placeholder'=>'Indique si lo amerita alguna observación', 'disabled'=>'disabled',)); ?>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if(strlen($model->foto)!=0): ?>
                        <div class="space-6"></div>
                        
                        <div class="widget-box">

                            <div class="widget-header">
                                <h5>Fotografía</h5>

                                <div class="widget-toolbar">
                                    <a data-action="collapse" href="#">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-body-inner">
                                    <div class="widget-main">
                                        <div class="widget-main form">
                                            <div class="row">
                                                <div class="col-md-12 center">
                                                    <img id="ImgTalentoHumanoFoto" src="<?php echo $model->foto; ?>" />                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="space-6"></div>

                        <div class="widget-box">

                            <div class="widget-header">
                                <h5>Datos de Contacto y de Ubicación</h5>

                                <div class="widget-toolbar">
                                    <a data-action="collapse" href="#">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-body-inner">
                                    <div class="widget-main">
                                        <div class="widget-main form">

                                            <div class="row">

                                                <div class="infoDialogBox">
                                                    <p class="note">Todos los campos con <span class="required">*</span> son requeridos. Indicando el número de Teléfono Celular y Correo Electrónico la persona puede más adelante recibir notificaciones del sistema.</p>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'telefono_fijo'); ?>
                                                        <?php echo CHtml::textField('telefono_fijo', $model->telefono_fijo, array('maxlength' => "14", 'class' => 'span-12', 'placeholder'=>'(0251)000-0000', 'readOnly'=>'readOnly',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'telefono_celular'); ?>
                                                        <?php echo CHtml::textField('telefono_celular', $model->telefono_celular, array('maxlength' => "14", 'class' => 'span-12', 'placeholder'=>'(0426)000-0000', 'readOnly'=>'readOnly',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'email_personal'); ?>
                                                        <?php echo CHtml::emailField('email_personal', $model->email_personal, array('maxlength' => "120", 'class' => 'span-12', 'placeholder'=>'user@email.com', 'readOnly'=>'readOnly',)); ?>
                                                    </div>
                                                </div>

                                                <div class="space-6"></div>

                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'estado_id'); ?>
                                                        <?php echo CHtml::dropDownList('estado', $model->estado_id, CHtml::listData($estados, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'municipio_id'); ?>
                                                        <?php echo CHtml::dropDownList('municipio', $model->municipio_id, CHtml::listData($municipios, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'parroquia_id'); ?>
                                                        <?php echo CHtml::dropDownList('parroquia', $model->parroquia_id, CHtml::listData($parroquias, 'id', 'nombre'), array('prompt' => '- - -', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>
                                                </div>

                                                <div class="space-6"></div>

                                                <div class="col-md-12">
                                                    <div class="col-md-12">
                                                        <?php echo $form->labelEx($model,'direccion'); ?>
                                                        <?php echo CHtml::textArea('direccion', $model->direccion, array('maxlength' => "400", 'rows'=>'3', 'class' => 'span-12', 'placeholder'=>'Ingrese la dirección referencial de la vivienda de la Madre o Padre Colaborador', 'disabled'=>'disabled',)); ?>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="space-6"></div>

                        <div class="widget-box">

                            <div class="widget-header">
                                <h5>Datos de Bancarios</h5>

                                <div class="widget-toolbar">
                                    <a data-action="collapse" href="#">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-body-inner">
                                    <div class="widget-main">
                                        <div class="widget-main form">

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'banco_id'); ?>
                                                        <?php echo CHtml::dropDownList('banco', $model->banco_id, CHtml::listData($bancos, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'tipo_cuenta_id'); ?>
                                                        <?php echo CHtml::dropDownList('tipo_cuenta', $model->tipo_cuenta_id, CHtml::listData($tiposDeCuenta, 'id', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'numero_cuenta'); ?>
                                                        <?php echo CHtml::textField('numero_cuenta', $model->numero_cuenta, array('maxlength' => "20", 'required'=>'required', 'class' => 'span-12', 'title'=>'Número de Cuenta Bancaria', 'readOnly'=>'readOnly',)); ?>
                                                    </div>
                                                </div>

                                                <div class="space-6"></div>

                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'origen_titular'); ?>
                                                        <?php echo CHtml::dropDownList('origen_titular', $model->origen_titular,  CHtml::listData($origenes, 'abreviatura', 'nombre'), array('prompt' => '- - -', 'required'=>'required', 'class'=>'span-12', 'disabled'=>'disabled',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'cedula_titular'); ?>
                                                        <?php echo CHtml::textField('cedula_titular', $model->cedula_titular, array('maxlength' => "15", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Nro. de Cédula del Titular de la Cuenta', 'readOnly'=>'readOnly',)); ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?php echo $form->labelEx($model,'nombre_titular'); ?>
                                                        <?php echo CHtml::textField('nombre_titular', $model->nombre_titular, array('maxlength' => "80", 'required'=>'required', 'class' => 'span-12', 'placeholder'=>'Nombre y Apellido del Titular de la Cuenta', 'readOnly'=>'readOnly',)); ?>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-md-6">
                                <a class="btn btn-danger" href="/servicio/colaboradoras" id="btnRegresar">
                                    <i class="icon-arrow-left"></i>
                                    Volver
                                </a>
                            </div>

                        </div>

                        <?php $this->endWidget(); ?>

                    </div><!-- form -->
                </div>
            </div>

            <div class="tab-pane" id="asistencia">
                <div class="alertDialogBox">
                    <p>
                        Próximamente: La consulta de Asistencia de las Madres y Padres Colaboradores se encuentra en Desarrollo.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
