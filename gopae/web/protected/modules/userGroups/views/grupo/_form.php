<?php
/* @var $this userGroups/GrupoController */
/* @var $model UserGroupsGroup */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'user-groups-group-form',
    'enableAjaxValidation'=>true,
)); ?>
    <div class="widget-box">

        <div class="widget-header">
            <h5>Información General del Grupo</h5>

            <div class="widget-toolbar">
                <a data-action="collapse" href="#">
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">

            <div class="widget-body-inner">

                <div class="widget-main form">
                    <?php $errSummary = $form->errorSummary($model); ?>
                    <?php if(!empty($errSummary)): ?>
                    <div class="row">
                        <div class="errorDialogBox"><?php echo $form->errorSummary($model); ?></div>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="infoDialogBox">
                            <p>
                               Todos los campos con <span class="required">*</span> son requeridos. 
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>

                        <div class="row">

                            <input type="hidden" id='id' name="id" value="<?php echo $model->id ?>" />
                            
                                <div class="col-md-6">
                                    <label class="col-md-12" for="groupname">Nombre del Grupo <span class="required">*</span></label>
                                    <?php echo $form->textField($model, 'groupname', array('required'=>'required', 'maxlength'=>30, 'class'=>'span-12', 'id'=>'groupname', 'placeholder'=>'Nombre del Grupo', 'title'=>'Nombre del Grupo. Será el Identificador en el Sistema, por lo que debe ser único.')); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-12" for="description">Descripción <span class="required">*</span></label>
                                    <?php echo $form->textField($model,'description',array('required'=>'required', 'maxlength'=>120, 'class'=>'span-12', 'id'=>'description', 'placeholder'=>'Descripción del Grupo', 'title'=>'Descripción del Grupo')); ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-12" for="level">Nivel de Acceso <span class="required">*</span></label>
                                    <?php echo $form->dropDownList($model, 'level', array_reverse(range(0,Yii::app()->user->level - 1), true), array('required'=>'required', 'class'=>'span-12', 'id'=>'level', 'title'=>'Nivel de Acceso')) ?>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-md-12" for="home">Página de Inicio <span class="required">*</span></label>
                                    <?php echo $form->dropDownList($model, 'home', UserGroupsAccess::homeList(), array('required'=>'required', 'class'=>'span-12', 'id'=>'level', 'title'=>'Nivel de Acceso')) ?>
                                </div>

                        </div>

                </div>
            </div>
        </div>
    </div>
    

<div class="widget-box">

        <div class="widget-header">
            <h5>Permisología</h5>

            <div class="widget-toolbar">
                <a data-action="collapse" href="#">
                    <i class="icon-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">

            <div class="widget-body-inner">

                <div class="widget-main form">
                    
                    <div class="tab-pane">
                        
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'dataProvider' => $dataProvider,
                            'ajaxUpdate' => false,
                            'enableSorting' => false,
                            'summaryText' => false,
                            'id' => 'rule-list',
                            'itemsCssClass' => 'table table-striped table-bordered table-hover',
                            'selectableRows' => 0,
                            'htmlOptions' => array('class' => 'x'),
                            'selectableRows' => 0,
                            'columns' => array(
                                array(
                                    'name' => 'Module',
                                ),
                                array(
                                    'name' => 'Controller',
                                ),
                                array(
                                    'name' => 'Read',
                                    'type' => 'raw',
                                ),
                                array(
                                    'name' => 'Write',
                                    'type' => 'raw',
                                ),
                                array(
                                    'name' => 'Admin',
                                    'type' => 'raw',
                                ),
                            ),
                        ));
                        ?>
                        
                        <div class="space-6"></div>
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div>
    
    </div>

    <hr>
    
    <div class="row">

        <div class="col-xs-6">
            <a class="btn btn-danger" href="<?php echo Yii::app()->createUrl('userGroups/grupo'); ?>">
                <i class="icon-arrow-left"></i>
                Volver
            </a>
        </div>
        
        <div class="col-xs-6">
            <button type="submit" data-last="Finish" title="Guardar Datos generales del Plantel" class="btn btn-primary btn-next pull-right">
                Guardar
                <i class="icon-save icon-on-right"></i>
            </button>
        </div>

    </div>
    
    <div class="row buttons left-flotted">
    <?php echo CHtml::hiddenField('UserGroupsAccess[what]', $what); ?>
    <?php echo CHtml::hiddenField('UserGroupsAccess[id]', $id); ?>
    <?php echo CHtml::hiddenField('UserGroupsAccess[displayname]', ucfirst($name)); ?>
    </div>
<?php $this->endWidget(); ?>