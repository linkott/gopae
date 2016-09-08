<?php
/* @var $this ContactoBancoController */
/* @var $model ContactoBanco */

$this->pageTitle = 'Registro de Contacto Bancos';
      $this->breadcrumbs=array(
        'Mi Módulo' => array('#'),
	'Contacto Bancos'=>array('lista'),
	'Registro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'registro')); ?>