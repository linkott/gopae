<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<!-- sidebar -->
<div class="col-xs-12">
    <div class="row row-fluid">
            <?php
                $this->beginWidget('zii.widgets.CPortlet', array());
                $this->widget('zii.widgets.CMenu', array(
                    'items' => $this->menu,
                    'htmlOptions' => array('class' => 'nav nav-pills'),
                ));
                $this->endWidget();
            ?>
    </div>
    <div class="row-fluid">
        <?php echo $content; ?>
    </div>
</div>
<!-- sidebar -->
<?php $this->endContent(); ?>
