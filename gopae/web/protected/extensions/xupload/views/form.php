<!-- The file upload form used as target for the file upload widget -->
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'form form',
    'action' => $this->url,
    'method' => 'post',
    'htmlOptions' => $this->htmlOptions,
    'enableAjaxValidation' => false,
        ));
?>
<div class="row fileupload-buttonbar center">
    <div class="span7">
        <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-info btn-sm fileinput-button">
            <i class="icon-cloud-upload"></i>
            <span><?php echo $this->t('1#Agregar Logo|0#Agregar Logo', $this->multiple); ?></span>
            <?php
            if ($this->hasModel()) :
                echo CHtml::activeFileField($this->model, $this->attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this->value, $htmlOptions) . "\n";
            endif;
            ?>
        </span>
    </div>
</div>
<br>
<!-- The table listing the files available for upload/download -->
<?php $this->endWidget(); ?>
