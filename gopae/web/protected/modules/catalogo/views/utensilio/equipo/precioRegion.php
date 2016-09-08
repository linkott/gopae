<?php
/* @var $this NivelController */
/* @var $model Nivel */

$this->breadcrumbs = array(
    'Catálogo' => array('/catalogo'),
    'Articulo' => array('/catalogo/articulo/'),
    'Precio Región',
);
?>

<div class="widget-box">

    <div class="widget-header">
        <h5>Precio Región</h5>

        <div class="widget-toolbar">
            <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-body-inner" style="display: block;">
            <div class="widget-main">
                <div style="display:block" class="search-form">





                            <!--
                    <div id="articulo" class="tab-pane active">
                        <div class="widget-box collapsed">

                            <div class="widget-header">
                                <h5>
                                    Articulo <?php echo $modelArticulo['nombre']; ?>
                                </h5>

                                <div class="widget-toolbar">
                                    <a data-action="collapse" href="#">
                                        <i class="icon-chevron-down"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="widget-body">
                                <div class="widget-body-inner" style="display: none;">
                                    <div class="widget-main">

                                        <div style="display:block" class="search-form">
                                            Aqui van los corotos

                                        </div><!-- search-form
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            -->

                    <br>




                    <div id="preciosRegion" class="tab-pane active">
                        <div class="widget-box">

                            <div class="widget-header">
                                <h5>
                                    Precio Regi&oacute;n <?php echo $modelArticulo['nombre']; ?>
                                </h5>

                                <div class="widget-toolbar">
                                    <a data-action="collapse" href="#">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                </div>

                            </div>

                            <div class="widget-body">
                                <div class="widget-body-inner" style="display: block;">
                                    <div class="widget-main">

                                        <div style="display:block" class="search-form">


                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>

                                                    <tr>
                                                        <th>
                                                <center>
                                                    <b>Nombre del Estado</b>
                                                </center>
                                                </th>
                                                <th width="20%">
                                                <center>
                                                    <b>Precio Regulado</b>
                                                </center>
                                                </th>
                                                <th width="10%">
                                                <center>
                                                    <b>Acci&oacute;n</b>
                                                </center>
                                                </th>
                                                </tr>

                                                </thead>

                                                <tbody>
                                                    <?php
                                                    if ($precioRegion != null) {
                                                        foreach ($precioRegion AS $pre) {
                                                            ?>
                                                            <tr class="odd">
                                                                <td>
                                                                    <div>
                                                                        <?php echo $pre['nombre']; ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        <?php
                                                                        //Abreviatura de unidad_monetaria_id
                                                                        //s$unidadMonetaria = UnidadMonetaria::model()->findAll(array('condition' => "'abreviatura = '" . $pre['abreviatura'] . "'"));
                                                                        echo $pre['precio_regulado'] . ' ' . $pre['abreviatura'];
                                                                        ?>
                                                                    </div>
                                                                </td>
                                                                <td align="center">
                                                                    <a title="Modificar Precio" onclick="modificarPrecio(<?php echo base64_decode($_GET['id']); ?>, <?php if($pre['precio_region_id'] != '') { echo $pre['precio_region_id']; } else { echo 'null';} ?>, <?php echo $pre['estado_id']; ?>, <?php if($pre['articulo_id'] != '') { echo $pre['articulo_id']; } else { echo 'null';} ?>)" class="fa fa-pencil green"> Modificar</a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div><!-- search-form -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="row-fluid-actions">
                    <a href="/catalogo/articulo" class="btn btn-danger">
                        <i class="icon-arrow-left bigger-110"></i>
                        Volver
                    </a>
                </div>
            </div><!-- search-form -->
        </div><!-- search-form -->
    </div>
</div>

<div id="dialogPantallaRegion" class="hide"></div>
<div><?php $this->widget('ext.loading.LoadingWidget'); ?></div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catalogo/articulo.js', CClientScript::POS_END);
?>

