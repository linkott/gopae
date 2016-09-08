<?php
/* @var $this DefaultController */
$this->pageTitle='Datos Catálogo';

$this->breadcrumbs = array(
    'Catálogo'
);
?>


<div  class="col-xs-12">
 
    <div class="linkCatalogo" onclick="">
        <span class="titulo">Alimentos</span>
        <a href="/catalogo/alimento/" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/Alimentos.png' ?>');">
        </a>
    </div>
 
    <div class="linkCatalogo" onclick="">
        <span class="titulo">Utensilios</span>
        <a href="/catalogo/utensilio/" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/Utensilios.png' ?>');">
        </a>
    </div>
 
    <div class="linkCatalogo" onclick="">
        <span class="titulo">Equipos</span>
        <a href="/catalogo/equipo/" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/Articulos.png' ?>');">
        </a>
    </div>

    <div class="linkCatalogo" onclick="">
        <span class="titulo">Unidades de Medida</span>
        <a href="/catalogo/unidadMedida/" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/unidades_de_medida.png' ?>');">
        </a>
    </div>
    
    <div class="linkCatalogo" onclick="">
        <span class="titulo">Condiciones de Servicio</span>
        <a href="/catalogo/condicionServicio/" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/condicionesServicios.png' ?>');">
        </a>
    </div>
    
    <div class="linkCatalogo" onclick="">
        <span class="titulo">Roles</span>
        <a href="/catalogo/cargo/" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/Cargos.png' ?>');">
        </a>
    </div>
    
    <div class="linkCatalogo" onclick="">
        <span class="titulo">Tipos de Fundamentos Jurídicos</span>
        <a href="/catalogo/tipoFundamento/" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/fundamentos_juridicos.png' ?>');">
        </a>
    </div>
    
    <div class="linkCatalogo" onclick="">
        <span class="titulo">Período Escolar</span>
        <a href="/catalogo/periodoEscolar/" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/periodoEscolar.png' ?>');">
        </a>
    </div>
    
    <div class="linkCatalogo" onclick="">
        <span class="titulo"> Unidades Responsables </span>
        <a href="/ayuda/unidadRespTicket/" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/Unidad_responsable.png'?>');">
        </a>
    </div>

    <div class="linkCatalogo" onclick="">
        <span class="titulo"> Bancos </span>
        <a href="/catalogo/banco" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/condicionInfraestructura.png'?>');">
        </a>
    </div>

    <div class="linkCatalogo" onclick="">
        <span class="titulo"> Tipos de Sociedades Mercantil </span>
        <a href="/catalogo/sociedadMercantil" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/Generos_2.png'?>');">
        </a>
    </div>

    <div class="linkCatalogo" onclick="">
        <span class="titulo"> Tipos de Sector Empresarial </span>
        <a href="/catalogo/tipoSector" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/Secciones_2.png'?>');">
        </a>
    </div>

    <div class="linkCatalogo" onclick="">
        <span class="titulo"> Tipos de Cuenta Bancaria </span>
        <a href="/catalogo/tipoCuenta" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/Condiciones_de_Estudios_2.png'?>');">
        </a>
    </div>

    <div class="linkCatalogo" onclick="">
        <span class="titulo"> Tipos de Seriales de Cuenta Bancaria </span>
        <a href="/catalogo/tipoSerialCuenta" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/Grados_2.png'?>');">
        </a>
    </div>
    
    
    <div class="linkCatalogo" onclick="">
        <span class="titulo"> Tipos de Cargos Nominales </span>
        <a href="/catalogo/tipoCargoNominal" class="circle" style="background-image: url('<?php echo Yii::app()->baseUrl . '../../public/images/iconoCatalogo/Secciones_2.png'?>');">
        </a>
    </div>

</div>



    <?php
    echo CHtml::cssFile('/public/css/iconosCatalogo.css');

    
