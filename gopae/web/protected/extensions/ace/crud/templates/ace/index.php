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

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('lista'),
	'Administración',
);\n";
?>
$this->pageTitle = 'Administración de <?php echo $label; ?>';

?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Lista de <?php echo $label; ?></h5>

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
                        <div class="infoDialogBox">
                            <p>
                                En este módulo podrá registrar y/o actualizar los datos de <?php echo $label; ?>.
                            </p>
                        </div>
                    </div>

                    <div class="pull-right" style="padding-left:10px;">
                        <a href="<?php echo '<?php echo $this->createUrl("'.$baseUrl.'/registro"); ?>'; ?>" type="submit" id='newRegister' data-last="Finish" class="btn btn-success btn-next btn-sm">
                            <i class="fa fa-plus icon-on-right"></i>
                            Registrar Nuevo <?php echo $label; ?>
                        </a>
                    </div>


                    <div class="row space-20"></div>

                </div>

<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$dataProvider,
        'filter'=>$model,
        'itemsCssClass' => 'table table-striped table-bordered table-hover',
        'summaryText' => 'Mostrando {start}-{end} de {count}',
        'pager' => array(
            'header' => '',
            'htmlOptions' => array('class' => 'pagination'),
            'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
            'prevPageLabel' => '<span title="Página Anterior">&#9668;</span>',
            'nextPageLabel' => '<span title="Página Siguiente">&#9658;</span>',
            'lastPageLabel' => '<span title="Última página">&#9658;&#9658;</span>',
        ),
        'afterAjaxUpdate' => "
                function(){

                }",
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7){
		echo "\t\t/*\n";
?>
        array(
            'header' => '<center><?php echo $column->name; ?></center>',
            'name' => '<?php echo $column->name; ?>',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('<?php echo $this->getModelClass(); ?>[<?php echo $column->name; ?>]', $model-><?php echo $column->name; ?>, array('title' => '',)),
        ),
<?php
        }
        else{
?>
        array(
            'header' => '<center><?php echo $column->name; ?></center>',
            'name' => '<?php echo $column->name; ?>',
            'htmlOptions' => array(),
            //'filter' => CHtml::textField('<?php echo $this->getModelClass(); ?>[<?php echo $column->name; ?>]', $model-><?php echo $column->name; ?>, array('title' => '',)),
        ),
<?php
        }
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
                    'type' => 'raw',
                    'header' => '<center>Acción</center>',
                    'value' => array($this, 'getActionButtons'),
                    'htmlOptions' => array('nowrap'=>'nowrap'),
                ),
	),
)); ?>
            </div>
        </div>
    </div>
</div>