<?php 

$this->breadcrumbs=array(
        'Catálogo' => array('/catalogo'),
	'Cargar Excel.'=>array('admin'),
);
$this->pageTitle = 'Administración de Contacto Bancos';
?>


<div class="infoDialogBox">
    <p>
        En este módulo podrá cargar la hoja de calculo.
    </p>
</div>

<div class="widget-box">
    <div class="widget-header">
        <h5>Titulo del Header</h5>

        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">
                <form id="formCargaExcel" method="post">
                    <div class="row space-6"></div>
                    <div>
                        <div id="resultadoOperacion">
                            <div id="mensajeCargaExcel"></div>
                        </div>

                        <div class="pull-top" style="padding-left:10px;">
                            <input id="archivo" type="file" name="archivo" />
                        </div>
                        <div class="pull-right" style="padding-left:10px;">
                            <button id='newRegisterCargaExcel' class="btn btn-success btn-next btn-sm">
                                <i class="fa fa-plus icon-on-right"></i>
                                Enviar
                            </button>
                        </div>


                        <div class="row space-20"></div>

                    </div>
                </form>
                <div id="divCargaExcel">
                </div>            
            </div>
        </div>
    </div>
</div>

<div id="divFormCargaExcelDialog" class="hide"></div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/catalogo/test/cargaExcel.js',CClientScript::POS_END); ?>

