<?php
    $form = new CActiveForm();
?>
<?php if($form->errorSummary($passModel)!==''): ?>
    <div class="errorDialogBox"><?php echo $form->errorSummary($passModel); ?></div>
<?php else: ?>
    <div class="successDialogBox">
        <p>
            Su clave ha sido actualizada correctamente.
        </p>
    </div>
<?php endif; ?>