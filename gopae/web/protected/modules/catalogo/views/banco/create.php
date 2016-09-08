<?php
/* @var $this BancoController */
/* @var $model Banco */

$this->pageTitle = 'Registro de Bancos';

      $this->breadcrumbs=array(
        'Catálogo'=>array('/catalogo/'),
	'Bancos'=>array('lista'),
	'Registro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'registro')); ?>