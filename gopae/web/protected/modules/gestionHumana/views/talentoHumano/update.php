<?php

$this->pageTitle = 'Edición de Datos de Madres y Padres Colaboradores';

/* @var $this ColaboradorasController */
/* @var $model Colaborador */
$this->breadcrumbs=array(
        'Gestión Humana'=>array('lista'),
	'Talento Humano'=>array('lista'),
	'Edición',
);

?>

<?php $this->renderPartial('_form', array(
        'formType' => 'update',
        'model'=>$model, 
        'ingresoId'=>$ingresoId,
        'estados'=>$estados, 
        'municipios'=>$municipios, 
        'parroquias'=>$parroquias, 
        'bancosSelect' => $bancos, 
        'tiposCuentaSelect' => $tiposCuenta,
        'misiones' => $misiones,
        'gradosInstruccion' => $gradosInstruccion,
        'tiposDeCargo' => $tiposDeCargo,
        'diversidadesFuncionales' => $diversidadesFuncionales,
        'etnias' => $etnias,
        'origenes' => $origenes,
        'generos' => $generos,
        'estatus'=>$estatus,
        'mensajeExitoso' => $mensajeExitoso,
        'redireccionadoSaime' => $redireccionadoSaime,
        'submitHide' => $submitHide,
        'mensaje' => $mensaje,
        'csrfToken' => $csrfToken,
        )
      );
?>
