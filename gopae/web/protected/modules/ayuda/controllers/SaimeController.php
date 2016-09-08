<?php

class SaimeController extends Controller {

	//public $layout='//layouts/cuerpo';   // DEFINICIÒN DEL LAYOUT

	// PARTE I
	static $_permissionControl = array(
		'read'  => 'Consulta de Cédula por BD de SAIME',
		'label' => 'Consulta de Cédula por BD de SAIME',
	);

	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'userGroupsAccessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {

		//en esta seccion colocar los action de solo lectura o consulta
		return array(
			array('allow',
				'actions' => array('index', 'consultaSaimeSinOrigen', 'consultaSaime'),
				'pbac' => array('read', 'write', 'admin'),
			),
			array('allow',
				'actions' => array('index', 'consultaSaimeSinOrigen', 'consultaSaime'),
				'users' => array('@'),
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionIndex() {
		throw new CHttpException(404, 'Página no encontrada.');
	}

	public function actionConsultaSaime($origen, $cedula, $format = 'json') {

		if (is_numeric($cedula) && (int) $cedula <= 2147483647 && in_array($origen, array('V', 'E', 'P'))) {

			$numeroCedula = $cedula;
			if (is_null($origen)) {
				$origen = 'V';
			}

			$busquedaCedula = Saime::busquedaOrigenCedula($origen, $numeroCedula);// valida si existe la cedula en la tabla saime

			if (!$busquedaCedula) {
				$mensaje = "La Cedula de Identidad <b>$origen-$numeroCedula</b> no se encuentra registrada en nuestro sistema, si cree que esto puede ser un error "
				 . "por favor contacte al personal de soporte mediante "
				. "<a href='mailto:soporte.gescolar@me.gob.ve'>soporte.gescolar@me.gob.ve</a>";
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				echo json_encode(array('statusCode' => 'error', 'mensaje' => $mensaje));// NO EXISTE EN SAIME
				Yii::app()->end();
			} else {
				echo json_encode(array('statusCode' => 'success', 'mensaje' => 'El Documento de Identidad ha sido encontrado en nuestra base de datos', 'origen' => $busquedaCedula['origen'], 'cedula' => trim($busquedaCedula['cedula']), 'nombre' => trim($busquedaCedula['nombre']), 'apellido' => trim($busquedaCedula['apellido']), 'fecha_nacimiento' => trim($busquedaCedula['fecha_nacimiento']), 'sexo' => trim($busquedaCedula['sexo']), 'fecha_nacimiento_latino' => trim(Utiles::transformDate($busquedaCedula['fecha_nacimiento'], '-', 'y-m-d', 'd-m-y')), ));
			}
		} else {
			$mensaje                                         = "No ha ingresado los parámetros necesarios para cumplir con la respuesta a su petición. La Cédula debe contener caracteres numéricos y el Origen solo debe ser V, E ó P.";
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			echo json_encode(array('statusCode' => 'error', 'mensaje' => $mensaje));// NO EXISTE EN SAIME
		}

	}

	public function actionConsultaSaimeSinOrigen($cedula, $format = 'json') {

		if (is_numeric($cedula) && (int) $cedula <= 2147483647) {

			$numeroCedula   = $cedula;
			$origen         = 'V';
			$busquedaCedula = Saime::busquedaOrigenCedula($origen, $numeroCedula);// valida si existe la cedula en la tabla saime

			if (!$busquedaCedula) {
				$origen         = 'E';
				$busquedaCedula = Saime::busquedaOrigenCedula($origen, $numeroCedula);// valida si existe la cedula en la tabla saime
			}

			if (!$busquedaCedula) {
				$mensaje = "Esta Cedula de Identidad no se encuentra registrada en nuestro sistema, si cree que esto puede ser un error "
				. "por favor contacte al personal de soporte mediante "
				. "<a href='mailto:soporte.gescolar@me.gob.ve'>soporte.gescolar@me.gob.ve</a>";
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				echo json_encode(array('statusCode' => 'error', 'mensaje' => $mensaje));// NO EXISTE EN SAIME
				Yii::app()->end();
			} else {
				echo json_encode(array('statusCode' => 'success', 'mensaje' => 'El Documento de Identidad ha sido encontrado en nuestra base de datos', 'nombre' => $busquedaCedula['nombre'], 'apellido' => $busquedaCedula['apellido'], 'fecha_nacimiento' => $busquedaCedula['fecha_nacimiento'], 'sexo' => $busquedaCedula['sexo']));
			}
		} else {
			$mensaje                                         = "No ha ingresado los parámetros necesarios para cumplir con la respuesta a su petición. La Cédula debe contener caracteres numéricos.";
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));// NO EXISTE EN SAIME
		}

	}

}
