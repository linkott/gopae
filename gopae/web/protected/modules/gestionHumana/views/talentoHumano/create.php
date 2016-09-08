<?php

$this->pageTitle = 'Registro de Talento Humano';

/* @var $this ColaboradorasController */
/* @var $model Colaborador */
$this->breadcrumbs=array(
        'Gestión Humana'=>array('lista'),
	'Talento Humano'=>array('lista'),
	'Registro',
);

?>

<?php $this->renderPartial('_form', array(
        'formType' => 'create',
        'model'=>$model, 
        'estados'=>$estados, 
        'municipios'=>$municipios, 
        'parroquias'=>$parroquias, 
        'bancos' => $bancos, 
        'tiposDeCuenta' => $tiposDeCuenta, 
        'misiones' => $misiones,
        'gradosInstruccion' => $gradosInstruccion,
        'tiposDeCargo' => $tiposDeCargo,
        'diversidadesFuncionales' => $diversidadesFuncionales,
        'etnias' => $etnias,
        'origenes' => $origenes,
        'generos' => $generos,
        'mensajeExitoso' => $mensajeExitoso,
        'redireccionadoSaime' => $redireccionadoSaime,
        'submitHide' => $submitHide,
        'mensaje' => $mensaje,
        'csrfToken' => $csrfToken,
        )
      );
?>
