<?php
/* @var $this ContactoBancoController */
/* @var $model ContactoBanco */

$this->pageTitle = 'Actualización de Datos de Contacto Bancos';
      $this->breadcrumbs=array(
        'Mi Módulo' => array('#'),
	'Contacto Bancos'=>array('lista'),
	'Actualización',
);
?>

<?php $this->renderPartial('_editar', array('model'=>$model, 'formType'=>'edicion',)); ?>