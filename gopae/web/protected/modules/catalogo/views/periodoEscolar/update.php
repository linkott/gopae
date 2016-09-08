<?php
/* @var $this ClasePlantelController */
/* @var $model ClasePlantel */
/*
$this->breadcrumbs=array(
	'Clase Plantels'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClasePlantel', 'url'=>array('index')),
	array('label'=>'Create ClasePlantel', 'url'=>array('create')),
	array('label'=>'View ClasePlantel', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClasePlantel', 'url'=>array('admin')),
);
*/
?>
<div class="widget-box">

        <div class="widget-header">
            <h5>Modificar esta Clase de mencion</h5>

            <div class="widget-toolbar">
                <a data-action="collapse" href="#">
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>

					<?php $this->renderPartial('_form', array('model'=>$model)); ?>