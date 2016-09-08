<?php

/*
 * Vista Principal para la modificacion de datos de Zona Educativa
 *
 */

$this->breadcrumbs = array(
    'Zonas Educativas' => array('../ministerio/zonaEducativa'),
    'Modificar',
);
?>

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#datosGenerales" data-toggle="tab">Datos Generales</a></li>
        <li><a href="#autoridades" data-toggle="tab">Autoridades</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="datosGenerales">
            <?php
            $this->renderPartial('_datosGenerales', array(
                'model' => $model,
                'estado'=>$estado,
                'municipio'=>$municipio,
            ));
            ?>
        </div>

        <div class="tab-pane" id="autoridades">
           <?php $this->renderPartial('_formAutoridades', array('dataProviderAutoridades'=>$dataProviderAutoridades, 'usuario'=>$usuario, 'id'=>$id,
               'zona_id'=>$zona_id
                   )); ?>
        </div>

    </div>
</div>
<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/ministerio/zonaEducativa.js', CClientScript::POS_END);
?>
