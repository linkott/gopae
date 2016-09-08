<div onclick="$(this).fadeOut('slow');"  class="errorDialogBox">
    <?php
        echo CHtml::errorSummary($model);
    ?>
</div>
