<?php

$this->pageTitle = 'Registro de Madres y Padres Colaboradores';

/* @var $this ColaboradorasController */
/* @var $model Colaborador */
$this->breadcrumbs=array(
        'Servicio'=>array('lista'),
	'Colaboradoras'=>array('lista'),
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