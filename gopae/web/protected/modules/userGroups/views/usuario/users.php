<div class="widget-box">

    <div class="widget-header">
        <h5>Usuarios</h5>
        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">
                <div id="div-usuario">

                    <div id="div-result-message" style="min-height: 60px;">
                    <?php if (Yii::app()->user->hasFlash('user')): ?>
                        <div class="successDialogBox">
                            <p><?php echo Yii::app()->user->getFlash('user'); ?></p>
                        </div>
                    <?php elseif (Yii::app()->user->hasFlash('error')): ?>
                        <div class="errorDialogBox">
                            <p><?php echo Yii::app()->user->getFlash('error'); ?></p>
                        </div>
                    <?php elseif (Yii::app()->user->hasFlash('permisos')): ?>
                        <div class="errorDialogBox">
                            <p><?php echo Yii::app()->user->getFlash('permisos'); ?></p>
                        </div>
                    <?php else: ?>
                        <div class="infoDialogBox">
                            <p>Ingrese un Parámetro de Búsqueda</p>
                        </div>
                    <?php endif; ?>
                    </div>

                    <?php
                    if (Yii::app()->user->pbac('userGroups.usuario.admin')):
?>
                        <div class="pull-right" style="padding-left:10px;">
                            <a href="<?php echo Yii::app()->createUrl('userGroups/usuario/nuevo/'); ?>" id="link-new" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                <i class="fa fa-plus icon-on-right"></i> &nbsp;
                                <span class="space-2">Registrar un Nuevo Usuario</span>
                            </a>
                        </div>
                    <?php
                    endif;
                    ?>

                    <div class="col-lg-12"><div class="space-6"></div></div>

                    <?php
                    /* echo CHtml::ajaxLink(Yii::t('userGroupsModule.admin', 'add user'),
                      Yii::app()->createUrl('/userGroups/admin/accessList', array('what'=>UserGroupsAccess::GROUP, 'id'=>'new')),
                      array('success'=>'js: function(data){ $("#user-detail").slideUp("slow", function(){ $("#user-detail").html(data).slideDown();}); }'),
                      array('id'=>'new-user-'.time())); */
                    ?>

                    <div class="clearfix margin-5">
                        <?php

                            if (Yii::app()->user->hasFlash('user')){
                                $dataProvider = $userModel->search('date_act DESC, date_ini DESC, id DESC, last_login DESC');
                            }
                            else{
                                $dataProvider = $userModel->search('status DESC, date_act DESC, date_ini DESC');
                            }

                            $this->widget('zii.widgets.grid.CGridView', array(
                                'dataProvider' => $dataProvider,
                                'id' => 'user-grid',
                                'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                'enableSorting' => true,
                                'filter' => $userModel,
                                'summaryText' => false,
                                'afterAjaxUpdate' => "

                                    function(){

                                        $('#UserGroupsUser_last_login').datepicker();
                                        $.datepicker.setDefaults($.datepicker.regional = {
                                            dateFormat: 'dd-mm-yy',
                                            showOn:'focus',
                                            showOtherMonths: false,
                                            selectOtherMonths: true,
                                            changeMonth: true,
                                            changeYear: true,
                                            minDate: new Date(1800, 1, 1),
                                            maxDate: 'today'
                                        });

                                        $('.look-data').unbind('click');
                                        $('.look-data').on('click',
                                            function(e) {
                                                e.preventDefault();
                                                var id = $(this).attr('data-id');
                                                ver(id);
                                            }
                                        );

                                        $('.change-status').unbind('click');
                                        $('.change-status').on('click',
                                            function(e) {
                                                e.preventDefault();
                                                var id = $(this).attr('data-id');
                                                var username = $(this).attr('data-username');
                                                var accion = $(this).attr('data-action');
                                                cambiarEstatus(id, username, accion);
                                            }
                                        );

                                        $('#UserGroupsUser_cedula').bind('keyup blur', function () {
                                            keyNum(this, false);
                                        });

                                        $('#UserGroupsUser_cedula').bind('blur', function () {
                                            clearField(this);
                                        });

                                        $('#UserGroupsUser_nombre').bind('keyup blur', function () {
                                            keyAlphaNum(this, true, true);
                                        });

                                        $('#UserGroupsUser_nombre').bind('blur', function () {
                                            clearField(this);
                                        });

                                        $('#UserGroupsUser_apellido').bind('keyup blur', function () {
                                            keyAlphaNum(this, true, true);
                                        });

                                        $('#UserGroupsUser_apellido').bind('blur', function () {
                                            clearField(this);
                                        });

                                        $('#UserGroupsUser_username').bind('keyup blur', function () {
                                            keyAlphaNum(this, true, true);
                                        });

                                        $('#UserGroupsUser_username').bind('blur', function () {
                                            clearField(this);
                                        });
                                    }
                                ",
                                //'selectionChanged' => 'function(id) { getPermission("' . Yii::app()->baseUrl . '", "' . UserGroupsAccess::GROUP . '", $.fn.yiiGridView.getSelection(id))}',
                                'columns' => array(
                                    array(
                                        'name'=>'username',
                                        'header'=>'Usuario',
                                        'value'=>'$data->username',
                                        'filter'=>CHtml::textField('UserGroupsUser[username]', null, array('title'=>'Usuario de Login', )),
                                    ),
                                    array(
                                        'name'=>'cedula',
                                        'header'=>'Cédula',
                                        'value'=>'$data->cedula',
                                        'filter'=>CHtml::textField('UserGroupsUser[cedula]', null, array('title'=>'Cédula de Identidad del Usuario', )),
                                    ),
                                    array(
                                        'name'=>'nombre',
                                        'header'=>'Nombre',
                                        'value'=>'ucwords(strtolower($data->nombre))',
                                        'filter'=>CHtml::textField('UserGroupsUser[nombre]', null, array('title'=>'Nombre', )),
                                    ),
                                    array(
                                        'name'=>'apellido',
                                        'header'=>'Apellido',
                                        'value'=>'ucwords(strtolower($data->apellido))',
                                        'filter'=>CHtml::textField('UserGroupsUser[apellido]', null, array('title'=>'Apellido', )),
                                    ),
                                    array(
                                        'name'=>'estado_id',
                                        'header'=>'Estado',
                                        'value'=>'$data->estado->nombre',
                                        'filter'=>CHtml::listData(Estado::model()->findAll(array('order' => 'nombre ASC')), 'id', 'nombre'),
                                    ),
                                    array(
                                        'name'=>'last_login',
                                        'header'=>'Último Login',
                                        'type'=>'html',
                                        'value'=>'(!empty($data->last_login))?date("<b>d-m-Y</b> H:i:s", strtotime($data->last_login)):""',
                                        'filter'=>CHtml::textField('UserGroupsUser[last_login]', null, array('title'=>'Fecha de Último Ingreso', 'maxlength'=>'10')),
                                    ),
                                    array(
                                        'name'=>'status',
                                        'header'=>'Estatus',
                                        'value'=>'strtr("{$data->status}", array("0"=>"Inactivo", "1"=>"Esperando por Activación", "2"=>"Esperando por Aprobación", "3"=>"Cambio de Password", "4"=>"Activo"))',
                                        'filter'=>array("0"=>"Inactivo", "1"=>"Esperando por Activación", "2"=>"Esperando por Aprobación", "3"=>"Cambio de Password", "4"=>"Activo"),
                                    ),
                                    array(
                                        'type' => 'raw',
                                        'header'=>'Acciones',
                                        'value'=>array($this,'columnaAcciones'),
                                        'htmlOptions'=>array('width'=>'83px'),
                                    ),
                                ),
                                'pager' => array(
                                    'header' => '',
                                    'htmlOptions'=>array('class'=>'pagination'),
                                    'firstPageLabel' => '<span title="Primera página">&#9668;&#9668;</span>',
                                    'prevPageLabel'  => '<span title="Página Anterior">&#9668;</span>',
                                    'nextPageLabel'  => '<span title="Página Siguiente">&#9658;</span>',
                                    'lastPageLabel'  => '<span title="Última página">&#9658;&#9658;</span>',
                                ),
                            ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog-user" class="hide">
    <div class="center">
        <img src="<?php echo Yii::app()->baseUrl; ?>/public/images/ajax-loader-red.gif">
    </div>
</div>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/userGroups/usuario/admin.min.js',CClientScript::POS_END); ?>