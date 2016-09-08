<?php
/* @var $this SociedadMercantilController */
/* @var $model SociedadMercantil */

$this->pageTitle = 'Registrar una Sociedad Mercantil';

$this->breadcrumbs=array(
    'Catálogo'=>array('/catalogo/'),
    'Sociedad Mercantil',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'formType'=>'registro')); ?>