<?php
$this->pageTitle = 'Generador de Código de Catalogos';
$this->breadcrumbs = array(
    'Administración'=>'#',
    'Generador de Código de Catálogo',
);
?>
<?php
$class = get_class($model);
$fields_json = (isset($columnsTable) AND $columnsTable != array()) ? $columnsTable : 'NADA';
Yii::app()->clientScript->registerScript('generador.codigo', "
if('{$fields_json}'!='NADA'){
     $('#GeneradorForm_fields').select2({
                            createSearchChoice: function(term, data) {
                                if ($(data).filter(function() {
                                    return this.text.localeCompare(term) === 0;
                                }).length === 0) {
                                    return {id: term, text: term};
                                }
                            },
                            allowClear: true,
                            placeholder: 'Seleccione',
                            multiple: true,
                            maximumSelectionSize: 5,
                            data: {$fields_json},
                        });
                        $('#divFields').removeClass('hide');
                        }

$('#{$class}_connectionId').change(function(){
	var tableName=$('#{$class}_tableName');
	tableName.autocomplete('option', 'source', []);
        if(this.value != '' && this.value != null){
            $.ajax({
                    url: '" . Yii::app()->getUrlManager()->createUrl('/administracion/generadorCodigoCatalogo/getTableNames') . "',
                    data: {db: this.value},
                    dataType: 'json'
            }).done(function(data){
                    tableName.autocomplete('option', 'source', data);
            });
            }
});
$('#{$class}_modelClass').change(function(){
	$(this).data('changed',$(this).val()!='');
});
$('#{$class}_tableName').bind('keyup change', function(){
	var model=$('#{$class}_modelClass');
	var tableName=$(this).val();
	if(tableName.substring(tableName.length-1)!='*') {
		$('.form .row.model-class').show();
	}
	else {
		$('#{$class}_modelClass').val('');
		$('.form .row.model-class').hide();
	}
	if(!model.data('changed')) {
		var i=tableName.lastIndexOf('.');
		if(i>=0)
			tableName=tableName.substring(i+1);
		var tablePrefix=$('#{$class}_tablePrefix').val();
		if(tablePrefix!='' && tableName.indexOf(tablePrefix)==0)
			tableName=tableName.substring(tablePrefix.length);
		var modelClass='';
		$.each(tableName.split('_'), function() {
			if(this.length>0)
				modelClass+=this.substring(0,1).toUpperCase()+this.substring(1);
		});
		model.val(modelClass);
	}
});
$('.form .row.model-class').toggle($('#{$class}_tableName').val().substring($('#{$class}_tableName').val().length-1)!='*');
");
?>
<div class="widget-box ">

    <div class="widget-header">
        <h5>Generador de Código de Catálogos</h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div style="display: block;" class="widget-body-inner">
            <div class="widget-main">
                <div class="hide" id='divErrors'>
                    <div class="errorDialogBox">
                        <p>
                            Este módulo te permite crear clases que contendrán los datos de tablas catálogos con la finalidad de evitar efectuar queries a base de datos para obtener una lista de datos que no suele cambiar con frecuencia.
                        </p>
                    </div>
                </div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'generador-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnType' => true,
                        'validateOnChange' => true),
                ));
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php if (isset($errores) AND $errores != null AND $errores != array()) { ?>
                            <div class="errorDialogBox">
                                <p>
                                    <?php echo CHtml::errorSummary($errores); ?>
                                </p>
                            </div>
                            <?php
                        } else {
                            if (isset($exito) AND isset($msg_exito) AND $exito != array() AND $msg_exito != array() AND ! is_null($msg_exito) AND ! is_null($exito)) {
                                ?>
                                <div class="successDialogBox" id="succesMsg">
                                    <p>
                                        <?php echo $msg_exito; ?>
                                    </p>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>
                </div>
                <div class="row">
                    <div id="divConexion" class="col-md-6">
                        <?php echo $form->labelEx($model, 'connectionId', array("class" => "col-md-12")); ?>
                        <?php echo $form->textField($model, 'connectionId', array('class' => 'span-12 ', 'maxlenght' => '30', 'title' => 'Nombre de la conexión a la base de datos, el mismo debe estar en el archivo /config/main.php')); ?>
                        <?php echo $form->error($model, 'connectionId', array("class" => "col-md-12")); ?>
                    </div>
                </div>
                <div class="row">
                    <div id="divTabla" class="col-md-6">
                        <?php echo $form->labelEx($model, 'tableName', array("class" => "col-md-12")); ?>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'tableName',
                            'name' => 'tableName',
                            'source' => Yii::app()->hasComponent($model->connectionId) ? array_keys(Yii::app()->{$model->connectionId}->schema->getTables()) : array(),
                            'options' => array(
                                'minLength' => '0',
                                'focus' => new CJavaScriptExpression('function(event,ui) {
					$("#' . CHtml::activeId($model, 'tableName') . '").val(ui.item.label).change();
					return false;
				}')
                            ),
                            'htmlOptions' => array(
                                'id' => CHtml::activeId($model, 'tableName'),
                                'class' => 'span-12 ',
                                'size' => '65',
                                'title' => 'Nombre de la tabla'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tableName', array("class" => "col-md-12")); ?>
                    </div>
                </div>
                <div class="row">
                    <div id="divClase" class="col-md-6">
                        <?php echo $form->labelEx($model, 'modelClass', array("class" => "col-md-12")); ?>
                        <?php echo $form->textField($model, 'modelClass', array('class' => 'span-12', 'maxlenght' => '30', "title" => "Nombre del archivo que se generará", 'readonly'=>'readonly',)); ?>
                        <?php echo $form->error($model, 'modelClass', array("class" => "col-md-12")); ?>
                    </div>
                </div>
                
                <div class="row ">
                    <div id="divFields" class="col-md-6 hide">
                        <?php echo $form->labelEx($model, 'fields', array("class" => "col-md-12")); ?>
                        <?php echo CHtml::textField('GeneradorForm[fields]', '', array('id' => 'GeneradorForm_fields', 'class' => 'span-7', 'style' => "width:99%;")); ?>
                        <?php //echo $form->dropDownList($model, 'fields', CHtml::listData($model->fields, 'id', 'nombre'), array('class' => 'span-7', 'empty' => '-Seleccione-', 'style' => "width:91.5%; ")); ?>
                        <?php echo $form->error($model, 'fields', array("class" => "col-md-12")); ?>
                    </div>
                </div>
                
                <div class="row ">
                    <div id="divOrderBy" class="col-md-6 hide">
                        <?php echo $form->labelEx($model, 'orderBy', array("class" => "col-md-12")); ?>
                        <?php echo CHtml::textField('GeneradorForm[orderBy]', '', array('id' => 'GeneradorForm_orderBy', 'class' => 'span-7', 'style' => "width:99%;")); ?>
                        <?php //echo $form->dropDownList($model, 'fields', CHtml::listData($model->fields, 'id', 'nombre'), array('class' => 'span-7', 'empty' => '-Seleccione-', 'style' => "width:91.5%; ")); ?>
                        <?php echo $form->error($model, 'fields', array("class" => "col-md-12")); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 wizard-actions pull-right">
                        <button type="submit" data-last="Finish" class="btn btn-primary btn-next">
                            Generar
                            <i class="icon-save icon-on-right"></i>
                        </button>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
    <div id="css_js">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/select2-3.5.1/select2.min.js', CClientScript::POS_END); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/select2-3.5.1/select2_locale_es.js', CClientScript::POS_END); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/administracion/generadorCodigoCatalogo.js', CClientScript::POS_END); ?>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/public/js/select2-3.5.1/select2.css" rel="stylesheet" /> 
    </div>