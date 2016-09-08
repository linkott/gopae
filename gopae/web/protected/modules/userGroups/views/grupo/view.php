<div class="tabbable">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>
        <li><a data-toggle="tab" href="#niveles">Permisología</a></li>
    </ul>

    <div class="tab-content">

        <div id="datosGenerales" class="tab-pane active">

            <div class="widget-main form">
                <div class="row">
                    <div class="col-md-4 bolder align-right"><label for="groupname">Nombre del Grupo:</label></div>
                    <div class="col-md-8"><input class="span-12" value="<?php echo $model->groupname; ?>" id="groupname" name="groupname" type="text" readonly="readonly" title="Nombre del Grupo, así será identificado un grupo en el código del sistema." /></div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-md-4 bolder align-right"><label for="description">Descripción:</label></div>
                    <div class="col-md-8"><input class="span-12" value="<?php echo $model->description; ?>" id="description" name="description" type="text" readonly="readonly" title="Descripción del Grupo. Es la forma amigable de mostrar el nombre del Grupo." /></div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-md-4 bolder align-right"><label for="level">Nivel de Acceso:</label></div>
                    <div class="col-md-8"><input class="span-12" value="<?php echo $model->level; ?>" id="level" name="level" type="text" readonly="readonly" title="Nivel de Acceso del Grupo." /></div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-md-4 bolder align-right"><label for="home">Página de Inicio Sessión:</label></div>
                    <div class="col-md-8"><input class="span-12" value="<?php echo $model->home; ?>" id="home" name="home" type="text" readonly="readonly" title="URL a la que será redirigido por defecto cuando inicie sesión." /></div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-md-4 bolder align-right"><label for="home">Estatus del Grupo:</label></div>
                    <div class="col-md-8"><input class="span-12" value="<?php echo strtr($model->estatus,array('A'=>'Activo','I'=>'Inactivo', 'E'=>'Eliminado', )); ?>" id="estatus" name="estatus" type="text" readonly="readonly" title="Estatus del Grupo: Indica si un Grupo está Activo o Inactivo." /></div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-md-4 bolder align-right"><label for="user_ini">Registrado por:</label></div>
                    <div class="col-md-8">
                        <input class="span-12" title="Login con el que accede un usuario a su cuenta. Regularmente corresponde a su número de Cédula." value="<?php echo (isset($model->userIni)) ? $model->userIni->username : ''; ?>" id="user_ini" name="user_ini" type="text" readonly="readonly" />
                        <br/><br/>
                        <input class="span-12" title="Nombre y Apellido del Usuario que efectuó el registro del grupo." value="<?php echo $model->userIni->nombre . ' ' . $model->userIni->apellido; ?>" id="user_ini" name="user_ini" type="text" readonly="readonly" />
                    </div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="col-md-4 bolder align-right"><label for="date_ini">Registrado en la fecha:</label></div>
                    <div class="col-md-8"><input class="span-12" value="<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $model->date_ini)->format('d-m-Y H:i:s'); ?>" id="date_ini" name="date_ini" type="text" readonly="readonly" title="Fecha en la que fue registrado el Grupo." /></div>
                </div>
                <?php if (!is_null($model->date_act)): ?>
                    <div class="space-6"></div>
                    <div class="row">
                        <div class="col-md-4 bolder align-right"><label for="user_act">Última actualización por:</label></div>
                        <div class="col-md-8">
                                    <input class="span-12" title="Login con el que accede un usuario a su cuenta. Regularmente corresponde a su número de Cédula." value="<?php echo (isset($model->userAct)) ? $model->userAct->username : ''; ?>" id="user_act" name="user_act" type="text" readonly="readonly" />
                                <br/><br/>
                            <input class="span-12" title="Nombre y Apellido del Usuario que efectuó el registro del grupo." value="<?php echo $model->userAct->nombre . ' ' . $model->userAct->apellido; ?>" id="user_act" name="user_act" type="text" readonly="readonly" />
                        </div>
                    </div>
                    <div class="space-6"></div>
                    <div class="row">
                        <div class="col-md-4 bolder align-right"><label for="date_act">Última actualización en la fecha:</label></div>
                        <div class="col-md-8"><input class="span-12" value="<?php if (!is_null($model->date_act)) { echo DateTime::createFromFormat('Y-m-d H:i:s', $model->date_act)->format('d-m-Y H:i:s'); } ?>" id="date_act" name="date_act" type="text" readonly="readonly" title="Fecha en la que se efectuó la última actualización en datos del Grupo." /></div>
                    </div>
            <?php endif; ?>
            <?php if (!is_null($model->date_del) && $model->estatus == 'E'): ?>
                    <div class="space-6"></div>
                    <div class="row">
                        <div class="col-md-4 bolder align-right"><label for="date_ini">Eliminado en la fecha:</label></div>
                        <div class="col-md-8"><input class="span-12" value="<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $model->date_del)->format('d-m-Y H:i:s'); ?>" id="date_del" name="date_del" type="text" readonly="readonly" title="Fecha en la que se eliminó el Grupo." /></div>
                    </div>
            <?php endif; ?>
            </div>

        </div>

        <div id="niveles" class="tab-pane">

            <div class="widget-main form">
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
            </div>

        </div>

    </div>

</div>