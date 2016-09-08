<?php
/* @var $this BancoController */
/* @var $model Banco */

$this->pageTitle = 'Actualización de Datos de Bancos';

	$this->breadcrumbs=array(
	'Catálogo'=>array('/catalogo/'),
        'Banco' => array('lista'),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'edicion',
    'tiposDeCuentaProvider'=>$tiposDeCuentaProvider, 'tipoCuentaSelect'=>$tipoCuentaSelect,
    'tiposSerialDeCuentaProvider'=>$tiposSerialDeCuentaProvider, 'tipoSerialCuentaSelect'=>$tipoSerialCuentaSelect,)); ?>

<?php    Yii::app()->clientScript->registerScriptFile(
               Yii::app()->request->baseUrl . '/public/js/bootbox.min.js',CClientScript::POS_END
             );
?>