<?php
/* @var $this OrdenCompraController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Orden Compras',
);
  echo CHtml::cssFile('/public/css/iconosCatalogo.css');
?>


<div  class="col-xs-12">
 
    <div class="linkCatalogo" onclick="">
        <span class="titulo">Insumo</span>
        <a href="/catalogo/alimento/" class="circle" style="background-image: url('/<?php echo Yii::app()->baseUrl . './public/images/iconoCatalogo/Alimentos.png' ?>');">
        </a>
    </div>
 
    <div class="linkCatalogo" onclick="">
        <span class="titulo">Plato Servido</span>
        <a href="/catalogo/utensilio/" class="circle" style="background-image: url('/<?php echo Yii::app()->baseUrl . './public/images/iconoCatalogo/Utensilios.png' ?>');">
        </a>
    </div>
</div>
