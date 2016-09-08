<?php $name = (int) $what === UserGroupsAccess::USER ? $data->username : $data->groupname; // assign to name it's value passw    ?>
<h3> 
    <?php
    if ((int) $what === UserGroupsAccess::USER) {
        if ($id === 'new')
            echo Yii::t('userGroupsModule.admin', 'New User: Data and Access Permissions');
        else
            echo Yii::t('userGroupsModule.admin', 'User {username}: Data and Access Permissions', array('{username}' => ucfirst($name)));
    } else {
        if ($id === 'new')
            echo Yii::t('userGroupsModule.admin', 'New Group: Data and Access Permissions');
        else
            echo Yii::t('userGroupsModule.admin', 'Group {groupname}: Data and Access Permissions', array('{groupname}' => ucfirst($name)));
    }
    ?>
</h3>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-groups-access-form-' . $what,
    'enableAjaxValidation' => false,
    'action' => Yii::app()->baseUrl . '/userGroups/admin',
        ));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'ajaxUpdate' => false,
    'enableSorting' => false,
    'summaryText' => false,
    'id' => 'rule-list',
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
<?php if (Yii::app()->user->pbac('userGroups.admin.admin')) { ?>
    <div class="row">
        <table>
            <tr>
                <?php
                if ((int) $what === UserGroupsAccess::GROUP):
                    ?>
                    <td><?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Group Level'), 'UserGroupsAccess_' . $what . '_level', array('class' => 'inline')) . CHtml::dropDownList('UserGroupsAccess[' . $what . '][level]', $data->level, array_reverse(range(0, Yii::app()->user->level - 1), true)); ?></td>
                    <td><?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Home'), 'UserGroupsAccess_' . $what . '_home', array('class' => 'inline')) . CHtml::dropDownList('UserGroupsAccess[' . $what . '][home]', $data->home, UserGroupsAccess::homeList()); ?></td>

                <tr>

                    <td><?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Group Name'), 'UserGroupsAccess_' . $what . '_groupname', array('class' => 'inline')); ?>
                        <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][groupname]', $name); ?></td>
                <?php
                endif;
                ?>
            </tr>

        </table>
        <table>


            <?php if ((int) $what === UserGroupsAccess::USER) { ?>
                <tr>



                    <td>
        <?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Usuario'), 'UserGroupsAccess_' . $what . '_username', array('class' => 'inline')); ?>
                    </td>

                    <td>
        <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][username]', $name); ?>

                    </td>








                    <td colspan="2">

        <?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Group'), 'UserGroupsAccess_' . $what . '_group_id', array('class' => 'inline')) . CHtml::dropDownList('UserGroupsAccess[' . $what . '][group_id]', $data->group_id, UserGroupsGroup::groupList()); ?>

                        <?php
                        $home_lists = UserGroupsAccess::homeList();
                        array_unshift($home_lists, Yii::t('userGroupsModule.admin', 'Group Home: {home}', array('{home}' => $data->group_home)));
                        ?>

                    </td>

                </tr>

                <tr>



                    <td>

        <?php
        echo CHtml::label(Yii::t('userGroupsModule.general', 'Home'), 'UserGroupsAccess_' . $what . '_home', array('class' => 'inline'));
        ?>


                    </td>

                    <td>
        <?php echo CHtml::dropDownList('UserGroupsAccess[' . $what . '][home]', $data->home, $home_lists); ?>
                    </td>




                    <td>

        <?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Nombres'), 'UserGroupsAccess_' . $what . '_nombre', array('class' => 'inline')); ?>


                    </td>

                    <td>

        <?php
        echo CHtml::textField('UserGroupsAccess[' . $what . '][nombre]', $data->nombre);
        ?>
                    </td>

                </tr>



                <tr>

                    <td>

        <?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Apellidos'), 'UserGroupsAccess_' . $what . '_apellido', array('class' => 'inline')); ?>


                    </td>

                    <td>

        <?php
        echo CHtml::textField('UserGroupsAccess[' . $what . '][apellido]', $data->apellido);
        ?>
                    </td>

                    <td>

        <?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Cedula'), 'UserGroupsAccess_' . $what . '_cedula', array('class' => 'inline')); ?>


                    </td>

                    <td>

        <?php
        echo CHtml::textField('UserGroupsAccess[' . $what . '][cedula]', $data->cedula);
        ?>
                    </td>



                </tr>



                <tr>



                    <td>

        <?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Telefono'), 'UserGroupsAccess_' . $what . '_telefono', array('class' => 'inline')); ?>



                    </td>

                    <td>
        <?php
        echo CHtml::textField('UserGroupsAccess[' . $what . '][telefono]', $data->telefono);
        ?>
                    </td>




                    <td>

        <?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Email'), 'UserGroupsAccess_' . $what . '_email', array('class' => 'inline')); ?>


                    </td>

                    <td>
        <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][email]', $data->email); ?>
                    </td>




                </tr>

                <tr>

                    <td>

        <?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Estado'), 'UserGroupsAccess_' . $what . '_estado_id', array('class' => 'inline')); ?>


                    </td>

                    <td>

        <?php
        $estado = new Estado();
        $estado_filtro = new CDbCriteria;
        $estado_filtro->order = 'nombre ASC';

        echo CHtml::dropDownList('UserGroupsAccess[' . $what . '][estado_id]', $data->estado_id, CHtml::listData(Estado::model()->findAll($estado_filtro), 'id', 'nombre'), array('prompt' => 'Seleccione...'));
        ?>  



                        <?php //echo CHtml::textField('UserGroupsAccess['.$what.'][estado_id]', $data->estado_id); ?>
                    </td>

                    <td>
                        <?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Direccion'), 'UserGroupsAccess_' . $what . '_direccion', array('class' => 'inline')); ?>
                    </td>

                    <td>

        <?php echo CHtml::textArea('UserGroupsAccess[' . $what . '][direccion]', $data->direccion); ?>

                    </td>



                </tr>







        <?php
    }
    ?>


        </table>
    </div>
            <?php if ($id === 'new' && (int) $what === UserGroupsAccess::USER) { ?>
        <div class="row">
                <?php echo CHtml::label(Yii::t('userGroupsModule.general', 'Password'), 'UserGroupsAccess_' . $what . '_password', array('class' => 'inline')); ?>
        <?php echo CHtml::textField('UserGroupsAccess[' . $what . '][password]', $data->password); ?>
        </div>

    <?php }
    ?>
    <?php } ?>

<div class="row buttons left-flotted">
<?php echo CHtml::hiddenField('UserGroupsAccess[what]', $what); ?>
<?php echo CHtml::hiddenField('UserGroupsAccess[id]', $id); ?>
<?php echo CHtml::hiddenField('UserGroupsAccess[displayname]', ucfirst($name)); ?>
<?php echo CHtml::submitButton(Yii::t('userGroupsModule.general', 'Save')); ?>
</div>
<?php $this->endWidget(); ?>
<?php if ($id !== 'new' && Yii::app()->user->pbac('userGroups.admin.admin')): ?>

    <!--- aqui es doden hace el link para mostrar los datos usuario-->
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-groups-delete-form-' . $what,
        'enableAjaxValidation' => false,
        'action' => Yii::app()->baseUrl . '/userGroups/admin',
    ));
    ?>


    <div class="row buttons right-flotted">




    <?php echo CHtml::hiddenField('UserGroupsAccess[what]', $what); ?>
    <?php echo CHtml::hiddenField('UserGroupsAccess[id]', $id); ?>
    <?php echo CHtml::hiddenField('UserGroupsAccess[displayname]', ucfirst($name)); ?>
    <?php echo CHtml::hiddenField('UserGroupsAccess[delete]', 'yes'); ?>
    <?php
    if ((int) $what === UserGroupsAccess::USER)
        $confirm_message = Yii::t('userGroupsModule.admin', 'Do you really want to delete the user {user}?', array('{user}' => ucfirst($name)));
    else {
        $confirm_message = Yii::t('userGroupsModule.admin', 'Do you really want to delete the group {group}?', array('{group}' => ucfirst($name)));
        $confirm_message .= '\n' . Yii::t('userGroupsModule.admin', 'Remember if you delete a Group you\'ll delete all the users that belongs to it.');
    }
    ?>
        <?php echo CHtml::submitButton(Yii::t('userGroupsModule.general', 'Delete'), array('onclick' => 'js: if(confirm("' . $confirm_message . '")) {return true;}else{return false;}')); ?>
    </div>
        <?php $this->endWidget(); ?>
    <?php endif; ?>
