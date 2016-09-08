<?php

/* @var $this ContactoBancoController */
/* @var $model ContactoBanco */

$this->breadcrumbs=array(
        'Catálogo' => array('/catalogo'),
	'Contacto Bancos'=>array('lista'),
	'Administración',
);
$this->pageTitle = 'Administración de Contacto Bancos';

?>
<div class="infoDialogBox">
    <p>
        En este módulo podrá registrar y/o actualizar los datos de Contacto Bancos.
    </p>
</div>
<div class="widget-box">
    <div class="widget-header">
        <h5>Lista de Contactos - <?php echo $model->banco->nombre; ?></h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">

                <div class="row space-6"></div>
                <div>
                    <div id="resultadoOperacion">
                        <div id="mensajeContactoBanco"></div>
                    </div>
                    
                    
                    <div class="pull-right" style="padding-left:10px;">
                        <button  data-href="<?php echo $this->createUrl("/catalogo/contactoBanco/registro/id/".$model->banco->id); ?>" id='newRegisterContactoBanco' class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Nuevo Contacto del Banco            
                        </button>
                    </div>


                    <div class="row space-20"></div>

                </div>
                <div id="divListaContactoBanco">
                    <?php $this->renderPartial('_listaContactoBanco', array('model'=>$model, 'dataProvider'=>$dataProvider)); ?>
                </div>            
            </div>
        </div>
    </div>
</div>

<div id="divFormContactosBancoDialog" class="hide"></div>

<?php
    /**
     * Yii::app()->clientScript->registerScriptFile(
     *   Yii::app()->request->baseUrl . '/public/js/modules/miModulo/ContactoBancoController/contacto-banco/admin.js', CClientScript::POS_END
     *);
     */
?>