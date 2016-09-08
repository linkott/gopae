<?php
/* @var $this SociedadMercantilController */
/* @var $model SociedadMercantil */

$this->pageTitle = 'Actualización de Datos de una Sociedad Mercantil';

$this->breadcrumbs=array(
    'Catálogo'=>array('/catalogo/'),
    'Sociedad Mercantil',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'edicion')); ?>