<?php
/* @var $this TipoCargoNominalController */
/* @var $model TipoCargoNominal */

$this->pageTitle = 'Actualización de Datos de Tipo Cargo Nominals';
      $this->breadcrumbs=array(
        'Catálogo' => array('/catalogo'),
	'Tipos de Cargo Nominales'=>array('lista'),
	'Actualización',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'edicion')); ?>
