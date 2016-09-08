<?php
/* @var $this TipoSectorController */
/* @var $model TipoSector */

$this->pageTitle = 'Actualización de Datos de Sector';

	$this->breadcrumbs=array(
    'Catálogo'=>array('/catalogo/'),
    'Sector',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'edicion')); ?>