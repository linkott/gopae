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

echo "\$this->pageTitle = 'Actualización de Datos de $label';
      \$this->breadcrumbs=array(
        'Mi Módulo' => array('#'),
	'$label'=>array('lista'),
	'Actualización',
);\n";
?>
?>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model, 'formType'=>'edicion')); ?>"; ?>
