<?php
/* @var $this GrupoController */
$this->pageTitle = 'Administración de Usuarios del Sistema';

$this->breadcrumbs=array(
	'Usuarios',
);
?>

<?php $this->renderPartial('users', array('userModel'=>$userModel))?>