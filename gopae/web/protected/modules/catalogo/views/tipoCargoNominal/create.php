<?php
/* @var $this TipoCargoNominalController */
/* @var $model TipoCargoNominal */

$this->pageTitle = 'Registro de Tipo Cargo Nominals';
      $this->breadcrumbs=array(
        'Catálogo' => array('/catalogo'),
	'Tipos de Cargo Nominales'=>array('lista'),
	'Registro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'registro')); ?>
