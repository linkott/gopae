<?php
/* @var $this PlantelPaeController */
/* @var $model Plantel */

$this->pageTitle = 'Registro de Plantels';
$this->breadcrumbs=array(
    'Registro Único de Planteles'=>array('lista'),
    'Institución Educativa'=>array('lista'),
    'Actualización de Datos',
);
?>

<?php $this->renderPartial('_form',
    array(
        'model' => $model,
        'id' => $id,
        'usuario' => $usuario,
        'model' => $model,
        'modelPae' => $modelPae,
        'denominaciones' => $denominaciones,
        'dependencias' => $dependencias,
        'zonasEducativas' => $zonasEducativas,
        'estatusPlantel' => $estatusPlantel,
        'estados' => $estados,
        'municipios' => $municipios,
        'parroquias' => $parroquias,
        'poblaciones' => $poblaciones,
        'urbanizaciones' => $urbanizaciones,
        'tiposDeVias' => $tiposDeVias,
        'zonasUbicacion' => $zonasUbicacion,
        'turnos' => $turnos,
        'modalidades' => $modalidades,
        'tiposDeMatricula' => $tiposDeMatricula,
        'mensajeExitoso' => $mensajeExitoso,
        'submitHide' => $submitHide,
        'mensaje' => $mensaje,
        'csrfToken' => $csrfToken,
        'csrfTokenPae' => $csrfTokenPae,
        'autoridadesPlantel' => $autoridadesPlantel,
        'dataProviderAutoridades' => $dataProviderAutoridades,
        'cargoSelect' => $cargoSelect,
        'ingestas' => $ingestas,
        'autoridadUsuario' => $autoridadUsuario,
        'isnew' => $isnew,
        'formType'=>'edicion',
        'error' => $error,
        )
);
?>
