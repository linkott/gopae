<?php
/* @var $this PlantelController */
/* @var $model Plantel */
/* @var $form CActiveForm */
$this->breadcrumbs = array(
    'Planteles' => array('/planteles/'),
    'Consulta de Plantel',
);
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'plantel-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        //  'validateOnSubmit' => true,
        'validateOnType' => true,
        'validateOnChange' => true),
        ));
?>
<?php //echo $form->errorSummary($model);  ?>
<?php
$groupId = Yii::app()->user->group;
$usuarioId = Yii::app()->user->id;
$view = '_viewDatosGenerales';

$plantelId = base64_decode($_GET['id']);
?>

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#datosGenerales" data-toggle="tab">Datos generales</a></li>
        <li><a href="#autoridades" data-toggle="tab">Autoridades</a></li>
        <li><a href="#pae" data-toggle="tab">Datos del PAE</a></li>
        <li><a href="#ingesta" data-toggle="tab">Ingestas</a></li>
        <li><a href="#equipo" data-toggle="tab">Equipos</a></li>
        <li><a href="#utensilio" data-toggle="tab">Utensilio</a></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane" id="autoridades">
            <?php $this->renderPartial('_viewAutoridad', array('model' => $model, 'plantel_id' => $plantelId)); ?>
        </div>

        <div class="tab-pane" id="pae">
            <?php
            $this->renderPartial('_formPlantelPae', array('plantel_id' => $model->id, 'model' => $modelPlantelPae, /* , 'dataProvider' => $dataProviderAula */));
            ?>
        </div>

        <div class="tab-pane" id="ingesta">
            <?php
            $this->renderPartial('_formIngesta', array('plantel_id' => $model->id, 'model' => $modelIngesta, /* , 'dataProvider' => $dataProviderAula */));
            ?>
        </div>

        <div class="tab-pane" id="equipo">
            <?php
            $this->renderPartial('_formEquipo', array('plantel_id' => $model->id, 'model' => $modelArticulos));
            ?>
        </div>

        <div class="tab-pane" id="utensilio">
            <?php
            $this->renderPartial('_formUtensilio', array('plantel_id' => $model->id, 'model' => $modelArticulos));
            ?>
        </div>

        <div class="tab-pane active" id="datosGenerales">
            <?php
            if($view){
                $this->renderPartial($view, array('model' => $model, 'plantel_id' => $plantelId));
            }
            ?>

            <hr>

            <div class="col-xs-6">
                <a class="btn btn-danger" href="/planteles/consultar/index" id="btnRegresar">
                    <i class="icon-arrow-left"></i>
                    Volver
                </a>
                 <?php $this->renderPartial('/_accionesSobrePlantel', array('plantel_id' => $plantelId)) ?>
            </div>

            <div class="col-xs-6" align="right">
                <a class="btn btn-primary pull-right" href="/planteles/consultar/reporte?id=<?php echo $_GET['id']; ?>" id="btnImprimir">
                    Imprimir
                    <i class="fa fa-print"></i>
                </a>
            </div>
            <br><br>
    
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>