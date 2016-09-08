<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('lista'),
);\n";
?>
?>

<div class="tabbable">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#datosGenerales" data-toggle="tab">Datos Generales</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="datosGenerales">
            <div class="form">

        <div id="div-datos-generales">

            <div class="widget-box">

                <div class="widget-header">
                    <h5>Datos Generales</h5>

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
    if($column->autoIncrement)
        continue;
?>
                                        <div class="col-md-4">
                                            <?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
                                            <?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
                                        </div>

<?php
    $countByRow++;
    if($countByRow==3){
        $countByRow = 0;
?>
                                    </div>

                                    <div class="space-6"></div>

                                    <div class="col-md-12">
<?php
    }
}
?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div><!-- form -->
        </div>
    </div>
</div>
