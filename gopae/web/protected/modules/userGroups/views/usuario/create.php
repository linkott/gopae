<?php
$this->pageTitle = 'Registro de Nuevo Usuario';
$this->breadcrumbs=array(
	'Usuarios'=>array('usuario/'),
	'Registro',
);

$what = UserGroupsAccess::USER;
$name = $model->username;

?>
<div class="col-xs-12">

    <div class="row-fluid">

        <div class="form">

            <div class="tabbable">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#newUser">Nuevo Usuario</a></li>
                </ul>

                <div class="tab-content">

                    <div id="newGroup" class="tab-pane active">

                    <?php

                    $this->renderPartial('_form', array('model'=> $model, 'dataProvider'=> $dataProvider, 'id'=>$id, 'data'=> $model, 'what'=>$what, 'name'=>$name, 'estados'=>$estados, 'grupos'=>$grupos, 'home_lists'=>$home_lists, 'status'=>$status, 'token'=>$token,));

                    ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/userGroups/usuario/editUsuario.min.js',CClientScript::POS_END); ?>