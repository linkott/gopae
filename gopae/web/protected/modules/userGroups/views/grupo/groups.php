<div class="widget-box">
    
    <div class="widget-header">
        <h5>Grupos de Usuarios</h5>
        <div class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="icon-chevron-up"></i>
            </a>
        </div>
    </div>

    <div class="widget-body">
        <div style="display:block;" class="widget-body-inner">
            <div class="widget-main">
                <div id="div-grupo">
                    
                    <div id="div-result-message" style="min-height: 60px;">
                    <?php if (Yii::app()->user->hasFlash('group')): ?>
                        <div class="successDialogBox">
                            <p><?php echo Yii::app()->user->getFlash('group'); ?></p>
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
                    if (Yii::app()->user->pbac('userGroups.admin.admin')):
                    ?>
                        <div class="pull-right" style="padding-left:10px;">
                            <a href="<?php echo Yii::app()->createUrl('userGroups/grupo/nuevo/'); ?>" id="link-new" data-last="Finish" class="btn btn-success btn-next btn-sm">
                                <i class="fa fa-plus icon-on-right"></i> &nbsp;
                                <span class="space-2">Registrar un Nuevo Grupo</span>
                            </a>
                        </div>
                    <?php
                    endif;
                    ?>
                    
                    <div class="col-lg-12"><div class="space-6"></div></div>

                    <?php
                    /* echo CHtml::ajaxLink(Yii::t('userGroupsModule.admin', 'add group'), 
                      Yii::app()->createUrl('/userGroups/admin/accessList', array('what'=>UserGroupsAccess::GROUP, 'id'=>'new')),
                      array('success'=>'js: function(data){ $("#group-detail").slideUp("slow", function(){ $("#group-detail").html(data).slideDown();}); }'),
                      array('id'=>'new-group-'.time())); */
                    ?>
                    
                    <div class="clearfix margin-5">
                        <?php
                            
                            if (Yii::app()->user->hasFlash('group')){
                                $dataProvider = $groupModel->search('date_act DESC, date_ini DESC');
                            }
                            else{
                                $dataProvider = $groupModel->search('estatus ASC');
                            }
                            
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'dataProvider' => $dataProvider,
                                'id' => 'user-group-grid',
                                'itemsCssClass' => 'table table-striped table-bordered table-hover',
                                'enableSorting' => false,
                                'filter' => $groupModel,
                                'summaryText' => false,
                                'afterAjaxUpdate' => " function(){

                                        $('.look-data').unbind('click');
                                        $('.look-data').on('click',
                                            function(e) {
                                                e.preventDefault();
                                                var id = $(this).attr('data-id');
                                                verGrupo(id);
                                            }
                                        );

                                        $('.change-status').unbind('click');
                                        $('.change-status').on('click',
                                            function(e) {
                                                e.preventDefault();
                                                var id = $(this).attr('data-id');
                                                var description = $(this).attr('data-description');
                                                var accion = $(this).attr('data-action');
                                                cambiarEstatusGrupo(id, description, accion);
                                            }
                                        );
                                        
                                        $('#UserGroupsGroup_level').bind('keyup blur', function () {
                                            keyNumCompare(this, false);
                                        });
                                    }
                                ",
                                //'selectionChanged' => 'function(id) { getPermission("' . Yii::app()->baseUrl . '", "' . UserGroupsAccess::GROUP . '", $.fn.yiiGridView.getSelection(id))}',
                                'columns' => array(
                                    'groupname',
                                    'description',
                                    array(
                                        'name'=>'level',
                                        'value'=>'$data->level',
                                        'filter'=>CHtml::textField('UserGroupsGroup[level]', null, array('title'=>'Debe contender solo caracteres numéricos, puede también utilizar expresiones como >, >=, <, <=.', )),
                                    ),
                                    array(
                                        'name'=>'estatus',
                                        'header'=>'Estatus',
                                        'value'=>'strtr($data->estatus,array("A"=>"Activo", "I"=>"Inactivo", "E"=>"Eliminado"))',
                                        'filter'=>array('A'=>'Activo','I'=>'Inactivo','E'=>'Eliminado'),
                                    ),
                                    array(
                                        'type' => 'raw',
                                        'header'=>'Acciones',
                                        'value'=>array($this,'columnaAcciones'),
                                        'htmlOptions'=>array('width'=>'83px','nowrap'=>'nowrap'),
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

<div id="dialog-group" class="hide">
    <div class="center">
        <img src="<?php echo Yii::app()->baseUrl; ?>/public/images/ajax-loader-red.gif">
    </div>
</div>

<div id="confirm-status" class="hide">
    <div class="alertDialogBox">
        <p>
            Al <span class="confirm-action"></span> el Grupo "<b id="confirm-description"></b>" se <span class="confirm-action"></span>án de igual forma la cuenta de los Usuarios pertenecientes a este Grupo y su Inicio de Sesión en el sistema estará condicionado.
        </p>
    </div>
    <div class="bigger-110 bolder grey pull-right">
        Desea usted <span class="confirm-action"></span> el Grupo?
    </div>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/userGroups/grupo/admin.js',CClientScript::POS_END); ?>