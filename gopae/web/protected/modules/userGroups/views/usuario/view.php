<div class="tabbable">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#datosGenerales">Datos Generales</a></li>
        <li><a data-toggle="tab" href="#niveles">Permisología</a></li>
    </ul>

    <div class="tab-content">

        <div id="datosGenerales" class="tab-pane active">

            <div class="widget-main form">
                <div class="row">
                    <div class="row-fluid">
                        <div class="col-md-4">
                            <label class="col-md-12" for="groupname">Cédula</label>
                            <input type="text" value="<?php echo $model->cedula; ?>" disabled="" style="width: 80%;">
                        </div>

                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Nombre</label>
                            <input type="text" value="<?php echo $model->nombre; ?>" disabled="" style="width: 80%;">
                        </div>

                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Apellido</label>
                            <input type="text" value="<?php echo $model->apellido; ?>" disabled="" style="width: 80%;">
                        </div>
                    </div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="row-fluid">
                        <div class="col-md-4">
                            <label class="col-md-12" for="groupname">Usuario</label>
                            <input type="text" value="<?php echo $model->username; ?>" disabled="" style="width: 80%;">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Grupo</label>
                            <input type="text" value="<?php echo $model->relUserGroupsGroup->description; ?>" disabled="" style="width: 80%;">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Estado/Provincia</label>
                            <input type="text" value="<?php echo $model->estado->nombre; ?>" disabled="" style="width: 80%;">
                        </div>
                    </div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="row-fluid">
                        <div class="col-md-4">
                            <label class="col-md-12" for="groupname">Teléfono</label>
                            <input type="text" value="<?php echo $model->telefono; ?>" disabled="" style="width: 80%;">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Teléfono Celular</label>
                            <input type="text" value="<?php echo $model->telefono_celular; ?>" disabled="" style="width: 80%;">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Correo Electrónico</label>
                            <input type="text" value="<?php echo $model->email; ?>" disabled="" style="width: 80%;">
                        </div>
                    </div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="row-fluid">
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Página Inicio</label>
                            <input type="text" value="<?php echo $model->home; ?>" disabled="" style="width: 80%;">
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Último Login</label>
                            <input type="text" value="<?php echo (strlen($model->last_login)>0)?DateTime::createFromFormat('Y-m-d H:i:s', $model->last_login)->format('d-m-Y H:i:s'):''; ?>" disabled="" style="width: 80%;">
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12" for="groupname">Última Dirección IP</label>
                            <input type="text" value="<?php echo $model->last_ip_address; ?>" disabled="" style="width: 80%;">
                        </div>
                    </div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="row-fluid">
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Cambio su Clave?</label>
                            <input type="text" value="<?php echo ($model->cambio_clave)?'Sí':'No'; ?>" disabled="" style="width: 80%;">
                        </div>
                    </div>
                </div>
                <div class="space-6"></div>
                <div class="row">
                    <div class="row-fluid">
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Registrado por Usuario</label>
                            <input type="text" value="<?php echo (isset($model->userIni)) ? $model->userIni->username : ''; ?>" disabled="" style="width: 80%;">
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Registrado por</label>
                            <input type="text" value="<?php echo (isset($model->userIni))? $model->userIni->nombre . ' ' . $model->userIni->apellido:''; ?>" disabled="" style="width: 80%;">
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12" for="groupname">Registrado a la fecha</label>
                            <input type="text" value="<?php echo (strlen($model->date_ini)>0)?DateTime::createFromFormat('Y-m-d H:i:s', $model->date_ini)->format('d-m-Y H:i:s'):''; ?>" disabled="" style="width: 80%;">
                        </div>
                    </div>
                </div>
                
                <?php if (strlen($model->date_act)>0): ?>
                <div class="space-6"></div>
                <div class="row">
                    <div class="row-fluid">
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Última actualización por Usuario</label>
                                    <input type="text" value="<?php echo (isset($model->userAct)) ? $model->userAct->username : ''; ?>" disabled="" style="width: 80%;">
                            </div>
                        <div class="col-md-4">
                            <label class="col-md-12" for="description">Última actualización por</label>
                            <input type="text" value="<?php echo (isset($model->userAct))? $model->userAct->nombre . ' ' . $model->userAct->apellido:''; ?>" disabled="" style="width: 80%;">
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12" for="groupname">Última actualización a la fecha</label>
                            <input type="text" value="<?php echo (DateTime::createFromFormat('Y-m-d H:i:s', $model->date_act))?DateTime::createFromFormat('Y-m-d H:i:s', $model->date_act)->format('d-m-Y H:i:s'):''; ?>" disabled="" style="width: 80%;">
                        </div>
                    </div>
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