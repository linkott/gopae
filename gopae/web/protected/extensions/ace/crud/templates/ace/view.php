<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$baseUrl = $this->getUrlBase();
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('lista'),
);\n";
?>
?>
<div class="col-xs-12">
    <div class="row-fluid">

        <div class="tabbable">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#datosGenerales" data-toggle="tab">Vista de Datos Generales</a></li>
                <!--<li class="active"><a href="#otrosDatos" data-toggle="tab">Otros Datos Relacionados</a></li>-->
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="datosGenerales">
                    <div class="view">

                        <?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
                                'id'=>'".$this->class2id($this->modelClass)."-form',
                                'htmlOptions' => array('onSubmit'=>'return false;',), // for inset effect
                                // Please note: When you enable ajax validation, make sure the corresponding
                                // controller action is handling ajax validation correctly.
                                // There is a call to performAjaxValidation() commented in generated controller code.
                                // See class documentation of CActiveForm for details on this.
                                'enableAjaxValidation'=>false,
                        )); ?>\n"; ?>

                        <div id="div-datos-generales">

                            <div class="widget-box">

                                <div class="widget-header">
                                    <h5>Vista de Datos Generales</h5>

                                    <div class="widget-toolbar">
                                        <a data-action="collapse" href="#">
                                            <i class="icon-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-body-inner">
                                        <div class="widget-main">
                                            <div class="widget-main form">
                                                <div class="row">
                                                    <div class="col-md-12">
<?php

$limitByRow = 3;
$countByRow = 0;

foreach($this->tableSchema->columns as $column){
    if(!in_array($column->name, array('usuario_id', 'usuario_ini_id','usuario_act_id','usuario_eli_id','fecha_ini','fecha_act','fecha_eli','plantel_actual_id','estudiante_id'))){
        if($column->autoIncrement)
            continue;
?>

                                                        <div class="col-md-4">
                                                            <?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
                                                            <?php echo "<?php echo ".$this->generateActiveFieldToRead($this->modelClass,$column)."; ?>\n"; ?>
                                                        </div>

<?php
        $countByRow++;
        if($countByRow==3){
            $countByRow = 0;
?>                                                  </div>

                                                    <div class="space-6"></div>

                                                    <div class="col-md-12">
<?php
        }
    }
}
?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-md-6">
                                        <a class="btn btn-danger" href="<?php echo '<?php echo $this->createUrl("'.$baseUrl.'"); ?>'; ?>" id="btnRegresar">
                                            <i class="icon-arrow-left"></i>
                                            Volver
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php echo "<?php \$this->endWidget(); ?>\n"; ?>
                    </div><!-- form -->
                </div>

                <div class="tab-pane" id="otrosDatos">
                    <div class="alertDialogBox">
                        <p>
                            Próximamente: Esta área se encuentra en Desarrollo.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>