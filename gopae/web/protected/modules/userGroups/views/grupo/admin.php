<?php
/* @var $this GrupoController */

$this->breadcrumbs=array(
	'Grupos de Usuarios',
);

?>

<?php $this->renderPartial('groups', array('groupModel'=>$groupModel))?>