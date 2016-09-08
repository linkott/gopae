<div class="col-sm-10 col-sm-offset-1" style="min-height: 400px;">
    <div class="login-container">
        <div class="space-6"></div>
        <div class="position-relative">
            <?php if (Yii::app()->user->hasFlash('mail')): ?>
                <h2>
                    <?php echo Yii::app()->user->getFlash('mail'); ?>
                </h2>
            <?php endif; ?>

            <?php if (CHtml::errorSummary($model_pr)): ?>
                <div class="errorDialogBox">
                    <?php echo CHtml::errorSummary($model_pr); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($model_pr->errors['answer']) && !isset($model_pr->errors['email']) && !isset($model_pr->errors['username'])): ?>
                <div class="row">
                    <h2><?php echo $model_pr->errors['question'][0]; ?></h2>
                    <?php echo $form->labelEx($model_pr, 'answer'); ?>
                    <?php echo $form->textField($model_pr, 'answer'); ?>
                    <?php echo $form->error($model_pr, 'answer'); ?>
                </div>
            <?php endif; ?>
            
            <div class="clearfix">

                <a href="/" class="width-100 pull-left btn btn-sm btn-success">
                    Volver a la Página de Acceso
                    <i class="icon-arrow-left icon-on-left"></i>
                </a>
                
            </div>
        </div>
    </div>
</div>
