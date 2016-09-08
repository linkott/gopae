<?php

$this->breadcrumbs=array(
	'Grupos de Usuarios'=>array('grupo/'),
	'Edición',
);

$what = UserGroupsAccess::GROUP;
$name = $model->groupname;

?>
<div class="col-xs-12">

    <div class="row-fluid">

        <div class="form">

            <div class="tabbable">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#newGroup">Edición de Grupo</a></li>
                </ul>

                <div class="tab-content">

                    <div id="newGroup" class="tab-pane active">

                    <?php

                    $this->renderPartial('_form', array('model'=> $model, 'dataProvider'=> $dataProvider, 'id'=>$id, 'data'=> $model, 'what'=>$what, 'name'=>$name));

                    ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/public/js/modules/userGroups/grupo/editGrupo.js',CClientScript::POS_END); ?>