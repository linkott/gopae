<?php
/* @var $this TipoSectorController */
/* @var $model TipoSector */

$this->pageTitle = 'Registro de Sector';

$this->breadcrumbs=array(
    'Catálogo'=>array('/catalogo/'),
    'Sector',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'registro')); ?>