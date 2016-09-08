<?php
/* @var $this DefaultController */
$this->breadcrumbs = array(
    'Consultar Planteles' => array('consultar/'),
    'Título'
);
?>


<div  class="col-xs-12">
    <div class="col-md-12"><br><br> </div>
    <p>
        <?php if (Yii::app()->user->id == '1') { ?>
            <a href="/planteles/titulo/mostrarSolicitanteAlTitulo/id/<?php echo base64_encode($plantel_id) ?>"  class="lol">
                <img src="<?php echo Yii::app()->baseUrl . '../../../../public/images/iconoCatalogo/identificadores.png' ?>"/>
                <span class="titulo">Solucitud de Título</span>
            </a>
        <?php } ?>

        <a href="/planteles/asignacionTitulo/index/id/<?php echo base64_encode($plantel_id) ?>" class="lol">
            <img src="<?php echo Yii::app()->baseUrl . '../../../../public/images/iconoCatalogo/identificadores.png' ?>"/>
            <span class="titulo">Asignación de Título</span>
        </a>

        <a href="/planteles/liquidacionTitulo/index/id/<?php echo base64_encode($plantel_id) ?>" class="lol">
            <img src="<?php echo Yii::app()->baseUrl . '../../../../public/images/iconoCatalogo/identificadores.png' ?>"/>
            <span class="titulo">Liquidación de Título</span>
        </a>

    </p>
    <div class="col-md-12"><br><br> </div>

</div>

<?php
echo CHtml::cssFile('/public/css/iconosCatalogo.css');
?>