<?php

class ZonaEducativaController extends Controller {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout             = '//layouts/column2';
	static $_permissionControl = array(
		'read'  => 'Consulta de Zonas Educativas',
		'write' => 'Modificacion de Zonas Educativas',
		'label' => 'Consulta de Zonas Educativas',
	);

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'userGroupsAccessControl', // perform access control for CRUD operations
			//'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	const MODULO = "ZonaEducativa.ModificarController.";

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array(
					'index',
					'view',
					'consultarZonaEducativa',
					'modificarZonaEducativa',
					'consultarZonaEducativa',
				),
				'pbac' => array('read', 'write', 'admin'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create',
					'update',
					'actualizarDatosGenerales',
					'actualizarServicio',
					'ActualizarDatosAutoridad',
					'consultarZonaEducativa',
					'modificarZonaEducativa',
					'procesarCambio',
					'crear',
					'create',
					'editar',
					'eliminar',
					'reactivar',
					'actualizarDatosGenerales',
					'seleccionarMunicipio',
					'agregarAutoridad',
					'guardarNuevaAutoridad',
					'buscarAutoridad',
					'eliminarAutoridad',
					'getAutoridadZona',
					'buscarCedula',
					'getFormCargo',
					'actualizarDatosAutoridad',
				),
				'users' => array('write', 'admin'),
			),
			/* array('allow', // allow admin user to perform 'admin' and 'delete' actions
			'actions'=>array('admin','delete'),
			'users'=>array('@'),
			), */
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionEditar($id) {

		$zona_id = base64_decode($id);

		Yii::app()->getSession()->add('zona_id', $zona_id);
		$model = $this->loadModel($zona_id);

		$autoridadZona = new AutoridadZonaEducativa;
		$usuario       = new UserGroupsUser('nuevoUsuario');
		$estado_id     = $model->estado_id;
		/* ARMADO DEL GRID AUTORIDADES Y EL DROPDOWLIST DEL MISMO */

		$autoridades = $autoridadZona->buscarAutoridadesZona($zona_id, $estado_id);

		// ld($autoridades, $zona_id);

		$dataProviderAutoridades = $this->dataProviderAutoridades($autoridades);
		/* FIN ARMADO DEL GRID AUTORIDADES Y EL DROPDOWLIST DEL MISMO */

		/* Listado de municipios y estados */
		$estado    = Estado::model()->findAll(array('order' => 'nombre ASC', 'condition' => 'id=' . $model->estado_id));
		$municipio = Municipio::model()->findAll(array('order' => 'nombre ASC'));
		$this->render('editar', array(
			'model'                   => $model,
			'id'                      => $zona_id,
			'usuario'                 => $usuario,
			'autoridadZona'           => $autoridadZona,
			'estado'                  => $estado,
			'municipio'               => $municipio,
			'dataProviderAutoridades' => $dataProviderAutoridades,
			'zona_id'                 => $zona_id,
		));
	}

	/* --------------------------------------------------------------------------
	 * CONSULTAR DETALLES DE ZONA EDUCATIVA------------------------------------->
	 *
	 */

	public function actionConsultarZonaEducativa($id) {

		$model = new ZonaEducativa;
		
		$rawData         = array();
		$id              = $_GET['id'];
		$resultadoGuardo = $model->detallesZona($id);
		
		foreach ($resultadoGuardo as $key => $data) {

			//$id=$data1['id'];
			$nombre         = $data['nombre'];
			$zona_nombre    = $data['z_nombre'];
			$apellido       = $data['apellido'];
			$nombre_estado  = $data['estado_nombre'];
			$nombreApellido = strtoupper($data['nombre'] . ' ' . $data['apellido']);
			$telefonos      = $data['telefono'] . ' ' . $data['telefono_celular'];
			$email          = $data['email'];

			$rawData[] = array(
				'id'             => $key,
				'nombreApellido' => $nombreApellido,
				'zona_nombre'    => $zona_nombre,
				'nombre_estado'  => $nombre_estado,
				'telefonos'      => $telefonos,
				'email'          => $email,
			);
		
		}
		$dataProvider = new CArrayDataProvider($rawData, array(
			'pagination' => array(
				'pageSize' => 15,
			),
		));

		//Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		$this->renderPartial('view', array('dataProvider' => $dataProvider,
			'nombre_estado'                                  => $nombre_estado,
			'nombreApellido'                                 => $nombreApellido,
			'zona_nombre'                                    => $zona_nombre,
			'telefonos'                                      => $telefonos,
			'email'                                          => $email,
		), false, true);
		Yii::app()->end();

	}

	public function actionGetFormCargo() {
		$this->renderPartial('_formCargo', array());
	}

	//--------------------------------------------------------------------->

	public function actionSeleccionarMunicipio($estado_id) {

		$item = $estado_id;

		if ($item == '' || $item == NULL) {
			$lista = array('empty' => '-SELECCIONE-');

			foreach ($lista as $valor => $descripcion) {
				echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
			}
		} else {
			$lista = Municipio::model()->findAll(array('condition' => 'estado_id =' . $item, 'order' => 'nombre ASC'));
			$lista = CHtml::listData($lista, 'id', 'nombre');
			echo CHtml::tag('option', array('value' => ''), CHtml::encode('-SELECCIONE-'), true);

			foreach ($lista as $valor => $descripcion) {
				echo CHtml::tag('option', array('value' => $valor), CHtml::encode($descripcion), true);
			}
		}
	}

	//------------------------------------------------------------------------->

	public function actionIndex() {
		$model = new ZonaEducativa('search');
		$model->unsetAttributes();// clear any default values
		if (isset($_GET['ZonaEducativa'])) {
			$model->attributes = $_GET['ZonaEducativa'];
		}
		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ZonaEducativa the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = ZonaEducativa::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	static function registrarTraza($transaccion, $accion) {
		$Utiles = new Utiles();
		$modulo = "ZonaEducativa.ZonaEducativaController." . $accion;
		$Utiles->traza($transaccion, $modulo, date('Y-m-d H:i:s'));
	}

	/**
	 * Performs the AJAX validation.
	 * @param ZonaEducativa $model the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'zona-educativa-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/*     * *****************************************************************************
	 * ---------------------------AUTORIDADES---------------------------------------
	 *
	 * *****************************************************************************
	 */

	public function dataProviderAutoridades($autoridades) {
		$rawData           = array();
		$boton             = '';
		$usuario_id_signed = Yii::app()->user->id;
		if ($autoridades != array()) {

			foreach ($autoridades as $key => $value) {
				$boton      = '';
				$id         = $value['id'];
				$usuario_id = $value['usuario_id'];
				if ($usuario_id_signed != $usuario_id) {
					$boton = "<div class='action-buttons center'>" .
					CHtml::link("", "", array("class" => "icon-pencil green change-data", 'data-id' => $usuario_id, "title" => "Modificar Autoridad")) . '&nbsp;&nbsp;' .
					CHtml::link("", "", array("class" => "icon-trash red remove-data", 'onClick' => "eliminarAutoridad($id)", "title" => "Eliminar Autoridad")) .
					"</div>";
				}
				$nombre = "<div class='center'>" . Utiles::strtoupper_utf8($value['nombre']) . ' ' . Utiles::strtoupper_utf8($value['apellido']) . "</div>";
				$cedula = "<div class='center'>" . $value['cedula'] . "</div>";
				$cargo  = "<div class='center'>" . $value['nombre_cargo'] . "</div>";

				$telefono_celular = "<div class='center'>" . $value['telefono_celular'] . "</div>";
				$telefono_fijo    = "<div class='center'>" . $value['telefono_fijo'] . "</div>";
				$correo           = "<div class='center'>" . $value['email'] . "</div>";
				$rawData[]        = array(
					'id'               => $key,
					'cargo'            => $cargo,
					'nombre'           => $nombre,
					'cedula'           => $cedula,
					'correo'           => $correo,
					'telefono_fijo'    => $telefono_fijo,
					'telefono_celular' => $telefono_celular,
					'boton'            => $boton,
				);
			}
			return new CArrayDataProvider($rawData, array(
				'pagination' => array(
					'pageSize' => 5,
				),
			));
		} else {

			return new CArrayDataProvider($rawData, array(
				'pagination' => array(
					'pageSize' => 5,
				),
			));
		}
	}

	public function validarActualizacionAutoridad($telf_fijo, $telf_cel, $usuario_id, $email) {
		$mensaje = "";
		if ($telf_fijo == null || $telf_fijo == '') {
			$mensaje .= "El campo Teléfono Fijo no puede estar vacio <br>";
		} elseif (strlen($telf_fijo) < 11 || !is_numeric($telf_fijo)) {
			$mensaje .= "El campo Teléfono Fijo debe poseer 11 Dígitos <br>";
		}

		if ($telf_cel == null || $telf_cel == '') {
			$mensaje .= "El campo Teléfono Celular no puede estar vacio <br>";
		} elseif (strlen($telf_cel) < 11 || !is_numeric($telf_cel)) {
			$mensaje .= "El campo Teléfono Celular debe poseer 11 Dígitos <br>";
		}

		if ($email == null || $email == '') {
			$mensaje .= "El campo Correo Eletrónico no puede estar vacio <br>";
		} elseif (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
			$mensaje .= "El campo Correo Eletrónico no posee el formato correcto <br>";
		} elseif ($email == AutoridadPlantel::model()->validarUniqueEmail($email, $usuario_id)) {
			$mensaje .= "Este Correo Eletrónico ya esta registrado <br>";
		}

		if ($mensaje == "") {
			return null;
		} else {
			return $mensaje;
		}
	}

	public function validarUsuario($origen, $cedula, $autoridades, $zonaId) {

		$existe_usuario_autoridad = "";
		$autoridadZona            = new AutoridadZonaEducativa();

		$busquedaCedula = $autoridadZona->busquedaSaime($origen, $cedula);// valida si existe la cedula en la tabla saime
		if (!$busquedaCedula) {
			$mensaje = "Esta Cedula de Identidad no se encuentra registrada en nuestro sistema, "
			. "por favor contacte al personal de soporte mediante "
			. "<a href='mailto:soporte_gescolar@me.gob.ve'>soporte_gescolar@me.gob.ve</a>";
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));// NO EXISTE EN SAIME
			// $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
			Yii::app()->end();
		} else {
			$busquedaCedulaUG = $autoridadZona->busquedaUserGroups($origen, $cedula);
			if ($busquedaCedulaUG == null) {
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				echo json_encode(array('statusCode' => 'successU', 'nombre' => $busquedaCedula['nombre'], 'apellido' => $busquedaCedula['apellido'], 'usuario' => $busquedaCedula['cedula'] . $this->generarLetraFromCedula($cedula)));
				Yii::app()->end();
			} else {
				$usuarioId = $busquedaCedulaUG[0]['id'];
				
				$existe_usuario_autoridad = ZonaEducativa::model()->validarAutoridad($usuarioId, $zonaId, true);

				if ($existe_usuario_autoridad) {
					// ya tiene un cargo en ese plantel o en la Zona
					$dondeTieneCargo = $existe_usuario_autoridad[0];
					$dataCargo       = $existe_usuario_autoridad[1];

					$resultado = '';
					if ($dondeTieneCargo == 'plantel') {
						$resultado = 'en el Plantel con el Código ' . $dataCargo['codigo'] . ' como ' . $dataCargo['cargo'];
					} elseif ($dondeTieneCargo == 'zona') {
						$resultado = 'en la Zona Educativa de ' . $dataCargo['codigo'] . ' como ' . $dataCargo['cargo'];
					}

					$mensaje = "El Usuario ya posee un cargo como Autoridad en el MPPE, $resultado, por lo que debe ser retirado de este cargo antes de asumir otro.<br/><br/>"
					 . " Si cree que esto puede ser una excepción comuniquelo al correo "
					. "<a href='mailto:soporte_gescolar@me.gob.ve'>soporte_gescolar@me.gob.ve</a>";
					Yii::app()->clientScript->scriptMap['jquery.js'] = false;
					echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
					//$this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
					$this->registerLog('ILEGAL', 'Planteles.Modificar.BuscarCedula', 'NO EXITOSO', 'El Usuario ha intentado registrar una autoridad (C.I: ' . $origen . '-' . $cedula . ') que ya posee un cargo en el MPPE');
					Yii::app()->end();
				} else {
					$usuarioUGU       = UserGroupsUser::model()->findByPk($usuarioId);
					$group_id_usuario = (isset($usuarioUGU) && $usuarioUGU->group_id !== null) ? $usuarioUGU->group_id : null;
					$grupoUsuario     = (isset($usuarioUGU) && is_object($usuarioUGU->relUserGroupsGroup) !== null) ? $usuarioUGU->relUserGroupsGroup->description : null;

					Yii::app()->clientScript->scriptMap['jquery.js'] = false;
					echo json_encode(array('statusCode' => 'successC', 'cedula' => $cedula, 'autoridades' => $autoridades));// debe asignar un cargo
					// $this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
					Yii::app()->end();
				}
			}
		}
	}

	//------------------------------------------------------------------------->

	public static function generarLetraFromCedula($cedula) {

		if (is_numeric($cedula)) {
			$numero = $cedula;
		} else {
			$numero = substr($cedula, 2);
		}

		$letra = substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($numero, "XYZ", "012") % 23, 1);

		return $letra;
	}

	public function validarUsuarioNuevo($usuario) {
		$mensaje = "";

		/*
		 * Validar Cedula
		 */
		if ($usuario['cedula'] == null || trim($usuario['cedula']) == '' || !is_numeric($usuario['cedula'])) {
			$mensaje .= "El campo Cédula no puede estar vacio y debe contener solo números <br>";
		}
		if ($usuario['nombre'] == null || trim($usuario['nombre']) == '') {
			$mensaje .= "El campo Nombre no puede estar vacio <br>";
		}
		if ($usuario['apellido'] == null || trim($usuario['apellido']) == '') {
			$mensaje .= "El campo Apellido no puede estar vacio <br>";
		}
		if ($usuario['telefono'] == null || trim($usuario['cedula']) == '') {
			$mensaje .= "El campo Teléfono Fijo no puede estar vacio <br>";
		}
		if (strlen($usuario['telefono']) < 11) {
			$mensaje .= "El campo Telefono debe poseer 11 Dígitos <br>";
		}
		if ($usuario['email'] == null || trim($usuario['email']) == '') {
			$mensaje .= "El campo Email no puede estar vacio <br>";
		}
		if (!(filter_var($usuario['email'], FILTER_VALIDATE_EMAIL))) {
			$mensaje .= "El campo Email no posee el formato correcto <br>";
		}
		if ($usuario['email'] == AutoridadZonaEducativa::model()->validarUniqueEmail($usuario['email'])) {
			$mensaje .= "Este email ya esta registrado <br>";
		}
		//        if ($usuario['cargo'] == null || $usuario['cargo'] == '') {
		//            $mensaje .= "El campo Cargo no puede estar vacio <br>";
		//        } elseif ($usuario['cargo'] == AutoridadZonaEducativa::model()->validarExisteCargo($usuario['cargo'], $usuario['id'])) {
		//            $mensaje .= "Este cargo ya fue asignado. <br>";
		//        }
		if ($usuario['cedula'] == AutoridadZonaEducativa::model()->validarUniqueUsuario($usuario['cedula'])) {
			$mensaje .= "Este Usuario esta registrado. <br>";
		}

		if ($mensaje == "") {
			return null;
		} else {
			return $mensaje;
		}
	}

	//------------------------------------------------------------------------->

	public function actionBuscarCedula() {
		if (isset($_REQUEST['cedula'])) {
			$cedula             = $_REQUEST['cedula'];
			$zona_id            = (int) $_REQUEST['id'];
			$existe             = false;
			$cedulaArrayDecoded = array();
			$cedulaDecoded      = "";
			if (strpos($cedula, "-")) {
				$cedulaArrayDecoded = explode("-", $cedula);
				if (count($cedulaArrayDecoded) == 2) {
					$origen        = $cedulaArrayDecoded[0];
					$cedulaDecoded = $cedulaArrayDecoded[1];
					if (!(is_string($origen) && strlen($origen) == 1 && is_numeric($cedulaDecoded) && strlen($cedulaDecoded) > 1 && strlen($cedulaDecoded) <= 8)) {
						// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
						$mensaje                                         = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
						Yii::app()->clientScript->scriptMap['jquery.js'] = false;
						echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
						Yii::app()->end();
					}
				} else {
					// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
					$mensaje                                         = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
					Yii::app()->clientScript->scriptMap['jquery.js'] = false;
					echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
					Yii::app()->end();
				}
			} else {
				// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
				$mensaje                                         = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
				Yii::app()->end();
			}
			$autoridades = AutoridadZonaEducativa::model()->buscarAutoridadesZona($zona_id);

			if ($autoridades == array()) {
				/*
				 * Es la primera vez que entra en este ciclo por lo tanto solo resta buscar la cedula en la base de datos
				 * Si es distinto de un array() es porque anteriormente ya habia agregado una autoridad al plantel,
				 * en ese caso hay que validar si la cedula no esta primero en este arreglo
				 */
				$this->validarUsuario($origen, $cedulaDecoded, $autoridades, $zona_id);
			} else {

				foreach ($autoridades as $key => $value) {
					if ($value['cedula'] == $cedulaDecoded) {
						$existe                                          = true;
						$mensaje                                         = "Esta cedula posee un cargo asignado en esta Zona Educativa.";
						Yii::app()->clientScript->scriptMap['jquery.js'] = false;
						echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
						//$this->renderPartial('mensaje', array('mensaje' => $mensaje), false, true);
						Yii::app()->end();
					}
				}
				if (!$existe) {
					$this->validarUsuario($origen, $cedulaDecoded, $autoridades, $zona_id);
				}
			}
		} else {
			throw new CHttpException(404, 'No se han especificado los datos necesarios. Recargue la página e intentelo de nuevo.');// esta vacio el request
		}
	}

	public function actionGuardarNuevaAutoridad() {
		if ($this->hasRequest('UserGroupsUser')) {
			$existe   = false;
			$formUser = $this->getRequest('UserGroupsUser');
			$cedula   = array_key_exists('cedula', $formUser) ? $formUser['cedula'] : null;
			if (strpos($cedula, "-")) {
				$cedulaArrayDecoded = explode("-", $cedula);
				if (count($cedulaArrayDecoded) == 2) {
					$origen        = $cedulaArrayDecoded[0];
					$cedulaDecoded = $cedulaArrayDecoded[1];
					if (!(is_string($origen) && strlen($origen) == 1 && is_numeric($cedulaDecoded) && strlen($cedulaDecoded) > 1 && strlen($cedulaDecoded) <= 8)) {
						// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
						$mensaje                                         = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
						Yii::app()->clientScript->scriptMap['jquery.js'] = false;
						echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
						Yii::app()->end();
					}
				} else {
					// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
					$mensaje                                         = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
					Yii::app()->clientScript->scriptMap['jquery.js'] = false;
					echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
					Yii::app()->end();
				}
			} else {
				// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
				$mensaje                                         = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
				Yii::app()->end();
			}

			$autoridadZona = new AutoridadZonaEducativa();
			$usuario       = array(
				'origen'           => $origen,
				'cedula'           => $cedulaDecoded,
				'username'         => $formUser['username'],
				'nombre'           => $formUser['nombre'],
				'apellido'         => $formUser['apellido'],
				'email'            => $formUser['email'],
				'telefono'         => $formUser['telefono'],
				'telefono_celular' => $formUser['telefono_celular'],
				'cargo'            => $this->getRequest('cargo'),
				'zona_id'          => $this->getRequest('zona_id')
			);
			$validacionResult = $this->validarUsuarioNuevo($usuario);
			if ($validacionResult == NULL) {
				$resultRegistroAutoridad = $autoridadZona->guardarUsuario($usuario);
				if ($resultRegistroAutoridad) {
					$this->registrarTraza('Guardó Nueva Autoridad', 'GuardarNuevaAutoridad');
					$selectCargo                                         = Cargo::model()->getCargoAutoridad(Yii::app()->user->id);
					$autoridades                                         = $autoridadZona->buscarAutoridadesZona($usuario['zona_id']);
					$dataProviderAutoridades                             = $this->dataProviderAutoridades($autoridades);
					Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
					$usuario                                             = Yii::app()->getSession()->get('usuario');
					$zona_id                                             = Yii::app()->getSession()->get('zona_id');
					$this->renderPartial('_formAutoridades', array('autoridadZona' => $autoridadZona, 'usuario' => $usuario, 'cargoSelect' => $selectCargo, 'zona_id' => $zona_id, 'dataProviderAutoridades' => $dataProviderAutoridades), false, true);
					Yii::app()->end();
				} else {
					$mensaje = "Registro invalido, por favor intente nuevamente";
					echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $mensaje));
					Yii::app()->end();
				}
			} else {
				echo json_encode(array('statusCode' => 'mensajeError', 'mensaje' => $validacionResult));
				Yii::app()->end();
			}
		} else {
			throw new CHttpException(404, 'No se han especificado los datos necesarios de la autoridad que desea registrar. Recargue la página e intentelo de nuevo.');// esta vacio el request
		}
	}

	public function actionEliminarAutoridad() {
		if ($this->getRequest('id') && $this->getRequest('zona_id')) {
			$id            = $this->getRequest('id');
			$zona_id       = $this->getRequest('zona_id');
			$usuario       = '';
			$usuario       = Yii::app()->getSession()->get('usuario');
			$autoridadZona = new AutoridadZonaEducativa;
			if ($autoridadZona->eliminarAutoridad($id, $zona_id)) {
				$this->renderPartial('//msgBox', array('class' => 'successDialogBox', 'message' => 'Se ha Desvinculado la Autoridad de la Zona Educativa de Forma Exitosa'), false, true);
			} else {
				throw new CHttpException(404, 'Existio un error al eliminar');// esta vacio el request
			}
		} else {

			throw new CHttpException(404, 'No se ha especificado la autoridad a eliminar. Recargue la página e intentelo de nuevo.');// esta vacio el request
		}
	}

	/* ------------------------------------------------------------------------------
	 * ....................MODIFICACION DE DATOS GENERALES...........................
	 *
	 * -----------------------------------------------------------------------------
	 */

	public function actionActualizarDatosGenerales() {


		//trae los datos correctos
		$id = $_REQUEST['id'];
		if (isset($id)) {
			$mensajeError = '';
			//$model = new ZonaEducativa;
			$model = $this->loadModel($_REQUEST['id']);
			$model->attributes     = $_REQUEST['ZonaEducativa'];
			$model->usuario_act_id = Yii::app()->user->id;
			$model->fecha_act      = date("Y-m-d H:i:s");
			$model->estatus        = "A";
			$nombre                = null;
			$estado                = null;
			$telefonoF             = null;
			$telefonoO             = null;
			$correo                = null;
			$direccion             = null;

			if (isset($_REQUEST['ZonaEducativa']['nombre'])) {
				$nombre = $_REQUEST['ZonaEducativa']['nombre'];
			}

			$model->nombre = $nombre;

			if (isset($_REQUEST['ZonaEducativa']['estado_id'])) {
				$estado = $_REQUEST['ZonaEducativa']['estado_id'];
			}

			$model->estado_id = $estado;
			if (isset($_REQUEST['ZonaEducativa']['telefono_fijo'])) {
				$telefonoF = $_REQUEST['ZonaEducativa']['telefono_fijo'];
			}

			$model->telefono_fijo = $telefonoF;
			if (isset($_REQUEST['ZonaEducativa']['$telefono_otro'])) {
				$telefonoO = $_REQUEST['ZonaEducativa']['$telefono_otro'];
			}

			$model->telefono_otro = $telefonoO;
			if (isset($_REQUEST['ZonaEducativa']['direccion_referencial'])) {
				$direccion                    = $_REQUEST['ZonaEducativa']['direccion_referencial'];
				$model->direccion_referencial = trim(strtoupper($direccion));
			}
			if ($model->save()) {
				//echo 'guardo';
				Yii::app()->user->setFlash('mensajeExitoso', "Actualización Exitosa");
				$this->renderPartial('flashMsg', array('estatus' => "success"));
				//$this->redirect('index', array('id' => base64_encode($id)));
				//$this->redirect(array('index', 'id' => base64_encode($model->id)));
				$this->registrarTraza('Actualizó la Zona Educativa ' . $model->id, 'ActualizarDatosGenerales');
				Yii::app()->end();
			} else {
				// echo 'no guardo';
				$this->renderPartial('//errorSumMsg', array('model' => $model));
				Yii::app()->end();
			}
		} else {
			// echo 'no guardo';
			$this->renderPartial('//errorSumMsg', array('model' => $model));
			Yii::app()->end();
		}
	}

	public function actionBuscarAutoridad() {

		if (Yii::app()->request->isAjaxRequest) {

			if (is_numeric($this->getQuery('usuario_id')) && is_numeric($this->getQuery('zona_id'))) {
				$usuario_id = $this->getQuery('usuario_id');
				$zona_id    = $this->getQuery('zona_id');

				$autoridad        = new AutoridadZonaEducativa();
				$autoridadPlantel = $autoridad->getAutoridadZona($zona_id, $usuario_id);
				if ($autoridadPlantel) {
					$this->renderPartial('_datosAutoridades', array('modelAutoridad' => $autoridadPlantel), false, true);
				} else {

					$this->renderPartial('//msgBox', array('class' => 'alertDialogBox', 'message' => 'No se ha podido recopilar los datos de la Autoridad, intente nuevamente.'), false, true);
				}
			} else {
				throw new CHttpException(404, 'Recurso no encontrado. Datos incompletos.');
			}
		} else {
			throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
		}
	}

	public function actionGetAutoridadZona() {
		if (Yii::app()->request->isAjaxRequest) {
			$zona_idDecoded = (int) ($this->getRequest('zona_id'));
			if (is_numeric($zona_idDecoded)) {
				$autoridadZonaEducativa                              = new AutoridadZonaEducativa();
				$cargoSelect                                         = Cargo::model()->getCargoAutoridad(Yii::app()->user->id, 4);
				$autoridades                                         = $autoridadZonaEducativa->buscarAutoridadesZona($zona_idDecoded);
				$dataProviderAutoridades                             = $this->dataProviderAutoridades($autoridades);
				$usuario                                             = Yii::app()->getSession()->get('usuario');
				Yii::app()->clientScript->scriptMap['jquery.js']     = false;
				Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
				$this->renderPartial('_formAutoridades', array('autoridadZona' => $autoridadZonaEducativa, 'cargoSelect' => $cargoSelect, 'zona_id' => $zona_idDecoded, 'usuario' => $usuario, 'dataProviderAutoridades' => $dataProviderAutoridades), false, true);
			} else {

				throw new CHttpException(403, 'No se ha encontrado el recurso solicitado. Recargue la página e intentelo de nuevo.');
			}
		} else {
			throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
		}
	}

	public function actionActualizarDatosAutoridad() {

		if (Yii::app()->request->isAjaxRequest) {

			$usuario_idDecoded = (int) base64_decode($this->getPost('usuario_id'));
			$zona_idDecoded    = (int) base64_decode($this->getPost('zona_id'));

			$cedula = $this->getPost('cedulaAutoridadZonaHidden');

			$email = $this->getPost('email');

			$emailBackup = $this->getPost('emailBackup');

			$telf_cel       = (int) $this->getPost('telf_cel');
			$telf_celBackup = (int) $this->getPost('telf_celBackup');

			$telf_fijo       = (int) $this->getPost('telf_fijo');
			$telf_fijoBackup = (int) $this->getPost('telf_fijoBackup');

			$validacionDatos = $this->validarActualizacionAutoridad($telf_fijo, $telf_cel, $usuario_idDecoded, $email);
			if ($validacionDatos !== null) {

				$model = $this->loadUserModel($usuario_idDecoded, 'contacto');

				$model->email            = $email;
				$model->telefono         = $telf_fijo;
				$model->telefono_celular = $telf_cel;
				$model->date_act         = date('Y-m-d H:i:s');
				$model->user_act_id      = Yii::app()->user->id;
				if ($model) {
					if ($model->save()) {
						$this->registerLog('ESCRITURA', self::MODULO . 'ActualizarDatosAutoridad', 'EXITOSO', 'El usuario con el id=' . Yii::app()->user->id . ''
							. ' ha cambiado los datos de una Autoridad Zona Educativa con la Cédula ' . $cedula
							. 'Email :<' . $emailBackup . '> a <' . $email . '>, Teléfono Fijo :<' . $telf_fijoBackup . '> a <' . $telf_fijo . '>'
							. ', Teléfono Celular :<' . $telf_celBackup . '> a <' . $telf_cel . '>');
						$this->renderPartial('//msgBox', array('class' => 'successDialogBox', 'message' => 'Los datos del usuario han sido actualizados exitosamente.'), false, true);
					} else {

						$this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => CHtml::errorSummary($model)), false, true);
					}
				} else {

					$this->renderPartial('//msgBox', array('class' => 'alertDialogBox', 'message' => 'La persona a la que desea actualizar los datos no se encuentra registrada. Recargue la página e intentelo de nuevo.'), false, true);
				}
			} else {
				$this->renderPartial('//msgBox', array('class' => 'errorDialogBox', 'message' => $validacionDatos), false, true);
			}
		} else {
			throw new CHttpException(403, 'No está permitido efectuar la petición de este recurso por esta vía.');
		}
	}

	public function actionAgregarAutoridad() {
		if ($this->getRequest('cedula') && $this->getRequest('cargo') && $this->getRequest('zona_id')) {

			$autoridadZona = new AutoridadZonaEducativa();
			$cargoModel    = new Cargo;
			$cedula        = $this->getRequest('cedula');
			$cargo         = $this->getRequest('cargo');
			$zona_id       = $this->getRequest('zona_id');
			$usuario_id    = Yii::app()->user->id;

			// Si no recibo una cedula con datos numéricos se paraliza el programa y se envía un mensaje de error al usuario
			if (!(is_numeric($cedula))) {
				// MENSAJE DE ERROR NO POSEE EL FORMATO CORRECTO V-99999999
				$mensaje                                         = "La Cedula de Identidad no posee el formato correcto, Ej: V-99999999 ó E-99999999";
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
				Yii::app()->end();
			}

			$autoridades = $autoridadZona->buscarAutoridadesZona($zona_id);

			// El queryAll siempre devuelve un array si no hay datos te devuelve un array vacio
			if ($autoridades == array()) {
				$resultadoValidacionCargo = $autoridadZona->validarExisteCargo($cargo, $zona_id);
				if ($resultadoValidacionCargo != $cargo) {
					$datosUsuario = $autoridadZona->buscarUsuarioId($cedula);
					if ($datosUsuario) {
						$usuarioAutoridadId              = $datosUsuario['id'];
						$existeYaEsteCargoConEsteUsuario = $autoridadZona->validarExisteCargo($cargo, $zona_id, $usuarioAutoridadId, null);
						if ($existeYaEsteCargoConEsteUsuario) {
							$autoridadZonaEducativa                 = AutoridadZonaEducativa::model()->find("cargo_id = :cargo AND zona_eductaiva_id = :zona and usuario_id = :usuario", array(':cargo' => $cargo, ':zona' => $zona_id, ':usuario' => $usuarioAutoridadId));
							$autoridadZonaEducativa->estatus        = 'A';
							$autoridadZonaEducativa->usuario_act_id = Yii::app()->user->id;
							$autoridadZonaEducativa->fecha_act      = date('Y-m-d H:i:s');
							if (!$autoridadZonaEducativa->update()) {
								$mensaje                                         = "Ha ocurrido un error.";
								Yii::app()->clientScript->scriptMap['jquery.js'] = false;
								echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
								Yii::app()->end();
							}
						} else {
							$autoridadZona->agregarAutoridad($zona_id, $cargo, $datosUsuario, $cedula);
						}
					} else {
						$mensaje                                         = "El usuario con esta cédula no existe.";
						Yii::app()->clientScript->scriptMap['jquery.js'] = false;
						echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
						Yii::app()->end();
					}
				} else {
					$mensaje                                         = "Esta función ya se encuentra asignada a otra persona. Desvincule a la persona actual de estas funciones si desea asignar a otra.";
					Yii::app()->clientScript->scriptMap['jquery.js'] = false;
					echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
					Yii::app()->end();
				}
			} else {

				/*
				 *  validamos que en la zona no haya otro usuario con ese cargo
				 */
				foreach ($autoridades as $autoridad) {

					if ($autoridad['cargo_id'] == $cargo) {
						$mensaje                                         = "Esta función ya se encuentra asignada a otra persona. Desvincule a la persona actual de estas funciones si desea asignar a otra.";
						Yii::app()->clientScript->scriptMap['jquery.js'] = false;
						echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
						Yii::app()->end();
					}
				}
				$datosUsuario = $autoridadZona->buscarUsuarioId($cedula);
				if ($datosUsuario) {
					$usuarioAutoridadId            = $datosUsuario['id'];
					$existeEsteCargoConEsteUsuario = $autoridadZona->validarExisteCargoConMismoUsuario($cargo, $zona_id, $usuarioAutoridadId, null);

					if ($existeEsteCargoConEsteUsuario) {

						$autoridadId = $existeEsteCargoConEsteUsuario;

						$autoridadZonaEducativa                 = AutoridadZonaEducativa::model()->findByPk($autoridadId);
						$autoridadZonaEducativa->estatus        = 'A';
						$autoridadZonaEducativa->usuario_act_id = Yii::app()->user->id;
						$autoridadZonaEducativa->fecha_act      = date('Y-m-d H:i:s');
						if (!$autoridadZonaEducativa->update()) {
							$mensaje                                         = "Ha ocurrido un error.";
							Yii::app()->clientScript->scriptMap['jquery.js'] = false;
							echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
							Yii::app()->end();
						}
					} else {
						$autoridadZona->agregarAutoridad($zona_id, $cargo, $datosUsuario, $cedula);
					}
				} else {
					$mensaje                                         = "El usuario con esta cédula no existe.";
					Yii::app()->clientScript->scriptMap['jquery.js'] = false;
					echo json_encode(array('statusCode' => 'mensaje', 'mensaje' => $mensaje));
					Yii::app()->end();
				}
			}
			/*
			 * Armado del provider
			 */
			$usuario = Yii::app()->getSession()->get('usuario');

			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			//$this->renderPartial('_formAutoridades', array('mensaje' => $mensaje), false, true);
			$this->renderPartial("//msgBox", array('class' => 'successDialogBox', 'message' => 'Se ha registrado el cargo de forma exitosa.'));

			//$this->renderPartial('_formAutoridades', array('autoridadZona' => $autoridadZonaEducativa, 'cargoSelect' => $cargoSelect, 'zona_id' => $zona_idDecoded, 'usuario' => $usuario, 'dataProviderAutoridades' => $dataProviderAutoridades), false, true);

			Yii::app()->end();
		} else {
			throw new CHttpException(401, 'No se han especificado los datos necesarios para efectuar esta acción. Recargue la página e intentelo de nuevo.');// esta vacio el request
		}
	}

	public function loadUserModel($usuario_idDecoded, $scenario = false) {
		$model = UserGroupsUser::model()->findByPk((int) $usuario_idDecoded);
		if ($model === null || ($model->relUserGroupsGroup->level > Yii::app()->user->level)) {
			throw new CHttpException(403, 'El recurso solicitado no se ha encontrado o puede que su perfil de usuario no posea acceso a este recurso.');
		}

		if ($scenario) {
			$model->setScenario($scenario);
		}

		return $model;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	//*------------------Columnas del Index--------------------------------------------------
	//---------------------------------------------------------------------------------------

	public function columnaAcciones($data) {
		$id = $data["id"];
		if ($data->estatus == 'A') {
			$columna = CHtml::link("", "", array("class" => "fa fa-search", "onClick" => "consultarZonaEducativa($id)", "title" => "Consultar este ZonaEducativa")) . '&nbsp;&nbsp;';
			$columna .= CHtml::link("", Yii::app()->createUrl("/ministerio/zonaEducativa/editar/id/" . base64_encode($id)), array("class" => "fa fa-pencil green", "title" => "Modificar Zona Educativa")) . '&nbsp;&nbsp;';
			//  $columna .= CHtml::link("", "", array("onClick" => "borrar($data->id)", "class" => "fa fa-trash-o red remove-data", "style" => "color:#555;", "title" => "Eliminar"));
		} else {
			//$columna .= CHtml::link("", "", array("onClick" => "reactivar($data->id)", "class" => "fa fa icon-ok red remove-data", "style" => "color:555;", "title" => "Reactivar"));
			$columna = CHtml::link("", "", array("class" => "fa fa-search", "onClick" => "consultarZonaEducativa($id)", "title" => "Consultar este ZonaEducativa")) . '&nbsp;&nbsp;';
			$columna .= CHtml::link("", "", array("onClick" => "reactivar($data->id)", "class" => "fa icon-ok green remove-data", "style" => "color:#555;", "title" => "Reactivar"));
		}

		return $columna;
	}

	public function columnaEstatus($data) {

		$estatus = '';

		if ($data['estatus'] == "A") {
			$estatus = 'Activo';
		}

		if ($data['estatus'] == "E") {
			$estatus = 'Inactivo';
		}

		return $estatus;
	}

	//--------------------------------->fin columnas
}
