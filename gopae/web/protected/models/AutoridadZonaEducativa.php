<?php

/**
 * This is the model class for table "gplantel.autoridad_zona_educativa".
 *
 * The followings are the available columns in table 'gplantel.autoridad_zona_educativa':
 * @property integer $id
 * @property integer $zona_educativa_id
 * @property integer $usuario_id
 * @property integer $cargo_id
 * @property string $observacion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuario
 * @property UsergroupsUser $usuarioIni
 * @property ZonaEducativa $zonaEducativa
 */
class AutoridadZonaEducativa extends CActiveRecord {

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'gplantel.autoridad_zona_educativa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zona_educativa_id, usuario_id, cargo_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
			array('observacion', 'length', 'max' => 150),
			array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 20),
			array('estatus', 'length', 'max' => 20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, zona_educativa_id, usuario_id, cargo_id, observacion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
			'usuario' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
			'zonaEducativa' => array(self::BELONGS_TO, 'ZonaEducativa', 'zona_educativa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'                => 'ID',
			'zona_educativa_id' => 'Zona Educativa',
			'usuario_id'        => 'Usuario',
			'cargo_id'          => 'Cargo',
			'observacion'       => 'Observacion',
			'usuario_ini_id'    => 'Usuario Ini',
			'fecha_ini'         => 'Fecha Ini',
			'usuario_act_id'    => 'Usuario Act',
			'fecha_act'         => 'Fecha Act',
			'fecha_elim'        => 'Fecha Elim',
			'estatus'           => 'Estatus',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function validarUniqueEmail($email) {
		$sql = "SELECT email FROM seguridad.usergroups_user"
		. " WHERE email = :email";
		$guard = Yii::app()->db->createCommand($sql);
		$guard->bindParam(":email", $email, PDO::PARAM_STR);
		$resultado = $guard->queryScalar();
		return $resultado;
	}

	public function validarUniqueUsuario($cedula) {
		$sql = "SELECT cedula FROM seguridad.usergroups_user"
		. " WHERE cedula = :cedula";
		$guard = Yii::app()->db->createCommand($sql);
		$guard->bindParam(":cedula", $cedula, PDO::PARAM_STR);
		$resultado = $guard->queryScalar();
		return $resultado;
	}

	public function guardarUsuario($datosUsuario) {

		$resultado = "No se ha encontrado un Grupo de Usuarios para el Cargo Seleccionado. Comuniquese con el administrador del Sistema para agregar este Grupo de Usuario asociado a las funciones del Cargo Asignado.";

		$sqlBusquedaGrupo = "SELECT id FROM seguridad.usergroups_group WHERE cargo_id = :cargo_id LIMIT 1";
		$busqueda         = Yii::app()->db->createCommand($sqlBusquedaGrupo);
		$busqueda->bindParam(":cargo_id", $datosUsuario['cargo'], PDO::PARAM_INT);
		$group_id  = $busqueda->queryScalar();
		$home      = '/site';
		$status    = 2;
		$estado_id = $this->buscarEstadoZona($datosUsuario['zona_id']);
		$userIniId = Yii::app()->user->id;

		if (is_numeric($group_id) && is_numeric($estado_id)) {

			$sql = "INSERT INTO seguridad.usergroups_user
                  (nombre, apellido, cedula, email, group_id, home, status, user_ini_id, username, password, estado_id, telefono, origen, telefono_celular)
                  VALUES (:nombre, :apellido, :cedula, :email, :group_id, :home, :status, :user_ini_id, :username, :password, :estado_id, :telefono, :origen, :telefono_celular) RETURNING id";

			$guard = Yii::app()->db->createCommand($sql);
			$guard->bindParam(":nombre", $datosUsuario['nombre'], PDO::PARAM_STR);
			$guard->bindParam(":telefono", $datosUsuario['telefono'], PDO::PARAM_INT);
			$guard->bindParam(':telefono_celular', $datosUsuario['telefono_celular'], PDO::PARAM_INT);
			$guard->bindParam(":apellido", $datosUsuario['apellido'], PDO::PARAM_STR);
			$guard->bindParam(":cedula", $datosUsuario['cedula'], PDO::PARAM_INT);
			$guard->bindParam(":email", $datosUsuario['email'], PDO::PARAM_STR);
			$guard->bindParam(":group_id", $group_id, PDO::PARAM_STR);
			$guard->bindParam(":home", $home, PDO::PARAM_STR);
			$guard->bindParam(":status", $status, PDO::PARAM_INT);
			$guard->bindParam(":user_ini_id", $userIniId, PDO::PARAM_INT);
			$guard->bindParam(":username", $datosUsuario['username'], PDO::PARAM_INT);
			$guard->bindParam(":password", md5($this->generaPass()), PDO::PARAM_INT);
			$guard->bindParam(":estado_id", $estado_id, PDO::PARAM_INT);
			$guard->bindParam(":origen", $datosUsuario['origen'], PDO::PARAM_INT);
			$resultado = $guard->queryScalar();

			$autoridades[] = array(
				'cargo'      => $datosUsuario['cargo'],
				'usuario_id' => $resultado);

			$zona_id = $datosUsuario['zona_id'];

			$this->guardarEnTablaAutoridadZona($zona_id, $autoridades);

		}

		return $resultado;
	}

	public function guardarEnTablaAutoridadZona($zona_id, $autoridades) {
		$usuario_id      = Yii::app()->user->id;
		$estatus         = 'A';
		$periodo         = '1';
		$resultadoGuardo = null;

		foreach ($autoridades as $key => $value) {
			$sqlAutoridad = "INSERT INTO gplantel.autoridad_zona_educativa
                (zona_educativa_id, usuario_id, cargo_id, usuario_ini_id,usuario_act_id,fecha_act, estatus)
                VALUES ('" . $zona_id . "','" . $value['usuario_id'] . "','" . $value['cargo'] . "', '" . $usuario_id . "','" . $usuario_id . "','" . date('Y-m-d H:i:s') . "', '" . $estatus . "') returning id";
			$guard = Yii::app()->db->createCommand($sqlAutoridad);
			$guard->bindParam(":zona_id", $zona_id, PDO::PARAM_INT);
			$guard->bindParam(":usuario_id", $value['usuario_id'], PDO::PARAM_INT);
			$guard->bindParam(":cargo_id", $value['cargo'], PDO::PARAM_INT);
			$guard->bindParam(":usuario_ini_id", $usuario_id, PDO::PARAM_INT);
			$guard->bindParam(":usuario_act_id", $usuario_id, PDO::PARAM_INT);
			$guard->bindParam(":fecha_act", date('Y-m-d H:i:s'), PDO::PARAM_INT);
			// $guard -> bindParam(":fecha_elim", $this -> fecha_elim, PDO::PARAM_INT);
			$guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
			$guard->bindParam(":periodo_id", $periodo, PDO::PARAM_INT);
			$resulatadoGuardo = $guard->queryScalar();
		}

		return $resulatadoGuardo;
	}

	public function generaPass() {
		//Se define una cadena de caractares. Te recomiendo que uses esta.
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		//Obtenemos la longitud de la cadena de caracteres
		$longitudCadena = strlen($cadena);

		//Se define la variable que va a contener la contraseña
		$pass = "";
		//Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
		$longitudPass = 10;

		//Creamos la contraseña
		for ($i = 1; $i <= $longitudPass; $i++) {
			//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
			$pos = rand(0, $longitudCadena - 1);

			//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
			$pass .= substr($cadena, $pos, 1);
		}
		return $pass;
	}

	public function buscarEstadoZona($zona_id) {
		$sql = "SELECT estado_id FROM gplantel.zona_educativa"
		. " WHERE id = :zona_id";
		$busqueda = Yii::app()->db->createCommand($sql);
		$busqueda->bindParam(":zona_id", $zona_id, PDO::PARAM_INT);
		return $resultado = $busqueda->queryScalar();//queryScalar= Es para obtener un solo valor
	}

	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('zona_educativa_id', $this->zona_educativa_id);
		$criteria->compare('usuario_id', $this->usuario_id);
		$criteria->compare('cargo_id', $this->cargo_id);
		$criteria->compare('observacion', $this->observacion, true);
		$criteria->compare('usuario_ini_id', $this->usuario_ini_id);
		$criteria->compare('fecha_ini', $this->fecha_ini, true);
		$criteria->compare('usuario_act_id', $this->usuario_act_id);
		$criteria->compare('fecha_act', $this->fecha_act, true);
		$criteria->compare('fecha_elim', $this->fecha_elim, true);
		$criteria->compare('estatus', $this->estatus, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/*
	 *
	 * ------------------------------------------------------------------------->
	 */

	public function busquedaSaime($origen, $cedula) {
		$cedulaInt = $cedula;
		/* $sql = "select u_u.id, s.origen ,s.cedula, u_u.nombre, u_u.apellido "
		. " from seguridad.usergroups_user u_u "
		. " inner join auditoria.saime s on (s.origen = u_u.origen AND s.cedula = u_u.cedula)"
		. " where "
		. " u_u.cedula= :cedula AND "
		. " u_u.origen= :origen ";
		 *
		 */
		$sql = "SELECT cedula, (primer_nombre || ' ' || segundo_nombre) AS nombre, (primer_apellido || ' ' || segundo_apellido) AS apellido  "
		. " FROM auditoria.saime s"
		. " WHERE "
		. " s.cedula= :cedula AND "
		. " s.origen= :origen ";

		$buqueda = Yii::app()->db->createCommand($sql);
		$buqueda->bindParam(":cedula", $cedulaInt, PDO::PARAM_INT);
		$buqueda->bindParam(":origen", $origen, PDO::PARAM_INT);
		$resultadoCedula = $buqueda->queryRow();

		if ($resultadoCedula !== array()) {
			return $resultadoCedula;
		} else {
			return false;
		}
	}

	public function buscarAutoridad($usuario_id, $id) {
		$sql = " SELECT estatus "
		. " FROM gplantel.autoridad_zona_educativa"
		. " WHERE"
		. " usuario_id = :usuario_id AND id=:id";
		$select = Yii::app()->db->createCommand($sql);
		$select->bindParam(":id", $id, PDO::PARAM_STR);
		$select->bindParam(":usuario_id", $usuario_id, PDO::PARAM_STR);
		$resultado = $select->queryScalar();
		return ($resultado);
	}

	public function busquedaUserGroups($origen, $cedula) {
		$cedulaInt = $cedula;
		$sql       = "select id"
		. " from seguridad.usergroups_user "
		. " where "
		. " cedula= :cedula ";
		//. "AND "
		//. " origen= :origen ";

		/* $sql = "select cedula, (primer_nombre || ' ' || segundo_nombre) as nombre, (primer_apellido || ' ' || segundo_apellido)as apellido "
		. " from auditoria.saime s"
		. " where "
		. " s.cedula= :cedula AND "
		. " s.origen= :origen ";
		 *
		 */
		$buqueda = Yii::app()->db->createCommand($sql);
		$buqueda->bindParam(":cedula", $cedulaInt, PDO::PARAM_INT);
		//$buqueda->bindParam(":origen", $origen, PDO::PARAM_INT);
		$resultadoCedula = $buqueda->queryAll();

		if ($resultadoCedula !== false) {
			return $resultadoCedula;
		} else {

			return null;
		}
	}

	/**
	 * Obtiene el Id de un usuario por medio de la cédula
	 * @param integer $cedula
	 * @return type
	 */
	public function buscarUsuarioId($cedula) {
		$sql              = "SELECT id, nombre, apellido, email FROM seguridad.usergroups_user WHERE cedula=$cedula";
		$buqueda          = Yii::app()->db->createCommand($sql);
		$resultadoUsuario = $buqueda->queryRow();
		return $resultadoUsuario;
	}

	public function buscarCargo($cargo) {

		$sql            = "select nombre from gplantel.cargo where id=$cargo";
		$buqueda        = Yii::app()->db->createCommand($sql);
		$resultadoCargo = $buqueda->queryScalar();
		return $resultadoCargo;
	}

	public function validarExisteCargo($cargoId, $zonaId, $usuarioId = null, $estatus = 'A') {

		$cargo   = (int) $cargoId;
		$zona    = (int) $zonaId;
		$usuario = null;

		$sql = "SELECT cargo_id  FROM gplantel.autoridad_zona_educativa WHERE cargo_id=:cargo AND zona_educativa_id=:zona";

		if ($usuarioId !== null) {
			$usuario = (int) $usuarioId;
			$sql .= " AND usuario_id <> :usuario";
		}
		if ($estatus) {
			$sql .= " AND estatus=:estatus";
		}

		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':cargo', $cargo);
		$command->bindParam(':zona', $zona);
		if ($usuarioId !== null) {
			$command->bindParam(':usuario', $usuario);
		}
		if ($estatus) {
			$command->bindParam(':estatus', $estatus);
		}
		$resultadoCargo = $command->queryScalar();

		return $resultadoCargo;
	}

	public function validarExisteCargoConMismoUsuario($cargoId, $zonaId, $usuarioId, $estatus = 'A') {

		$cargo   = (int) $cargoId;
		$zona    = (int) $zonaId;
		$usuario = null;

		$sql = "SELECT a.id FROM gplantel.autoridad_zona_educativa a WHERE a.cargo_id=:cargo AND a.zona_educativa_id=:zona";

		if ($usuarioId !== null) {
			$usuario = (int) $usuarioId;
			$sql .= " AND a.usuario_id = :usuario";
		}
		if ($estatus) {
			$sql .= " AND a.estatus=:estatus";
		}

		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':cargo', $cargo);
		$command->bindParam(':zona', $zona);
		if ($usuarioId !== null) {
			$command->bindParam(':usuario', $usuario);
		}
		if ($estatus) {
			$command->bindParam(':estatus', $estatus);
		}
		$resultadoCargo = $command->queryScalar();

		return $resultadoCargo;
	}

	public function agregarEnAutoridadZonaEducativa($id, $cargo, $datosUsuario, $cedula) {
		//  $estatusAutoridad = $this->buscarAutoridad($datosUsuario['id'], $id);
		$autoridades[] = array(
			'cargo'      => $cargo,
			'id'         => $id,
			'usuario_id' => $datosUsuario['id'],
			'nombre'     => $datosUsuario['nombre'],
			'apellido'   => $datosUsuario['apellido'],
			'cedula'     => $cedula,
		);

		$this->guardarEnTablaAutoridadZona($id, $autoridades);// Guardo los datos en la tabla autoridad_plantel

	}

	public function buscarAutoridadesZona($zona_id, $estado_id) {
		$sql = "SELECT a.id,  a.zona_educativa_id, a.cargo_id, a.usuario_id, u_u.nombre as nombre, u_u.apellido as apellido, u_u.cedula,u_u.email, u_u.telefono telefono_fijo, u_u.telefono_celular as telefono_celular, c.nombre nombre_cargo, a.estatus"
		. " FROM gplantel.autoridad_zona_educativa a "
		. " LEFT JOIN gplantel.cargo c ON (a.cargo_id = c.id)"
		. " LEFT JOIN seguridad.usergroups_user u_u ON (u_u.id = a.usuario_id)"
		. " WHERE "
		. " a.zona_educativa_id = :zona_id AND a.estatus = 'A'"
		. " ORDER BY c.consecutivo ASC, c.nombre ASC";
		$select = Yii::app()->db->createCommand($sql);
		$select->bindParam(":zona_id", $zona_id, PDO::PARAM_INT);
		$resultado = $select->queryAll();
		return ($resultado);
	}

	public function agregarAutoridad($id, $cargo, $datosUsuario, $cedula) {
		$estatusAutoridad = $this->buscarAutoridad($datosUsuario['id'], $id);
		$autoridades[]    = array(
			'cargo'      => $cargo,
			'zona_id'    => $id,
			'usuario_id' => $datosUsuario['id'],
			'nombre'     => $datosUsuario['nombre'],
			'apellido'   => $datosUsuario['apellido'],
			'cedula'     => $cedula,
		);
		if ($estatusAutoridad == false) {
			// no existe en autoridad_plantel
			$this->guardarAutoridadZona($id, $autoridades);
		} else {
			$this->actualizarAutoridadZona($id, $autoridades);
		}
	}

	public function guardarAutoridadZona($id, $autoridades) {
		$usuario_id = Yii::app()->user->id;
		$estatus    = 'A';
		$periodo    = '1';
		foreach ($autoridades as $key => $value) {
			$sql = "INSERT INTO gplantel.autoridad_zona_educativa
                (zona_educativa_id, usuario_id, cargo_id, usuario_ini_id,usuario_act_id,fecha_act, estatus)
                VALUES (:id, :usuario_id, :cargo_id, :usuario_ini_id, :usuario_act_id,:fecha_act, :estatus) RETURNING id";
			$guard = Yii::app()->db->createCommand($sql);

			$guard->bindParam(":id", $id, PDO::PARAM_INT);
			$guard->bindParam(":usuario_id", $value['usuario_id'], PDO::PARAM_INT);
			$guard->bindParam(":cargo_id", $value['cargo'], PDO::PARAM_INT);
			$guard->bindParam(":usuario_ini_id", $usuario_id, PDO::PARAM_INT);
			$guard->bindParam(":usuario_act_id", $usuario_id, PDO::PARAM_INT);
			$guard->bindParam(":fecha_act", date('Y-m-d H:i:s'), PDO::PARAM_INT);
			// $guard -> bindParam(":fecha_elim", $this -> fecha_elim, PDO::PARAM_INT);
			$guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
			//$guard->bindParam(":periodo_id", $periodo, PDO::PARAM_INT);
			$resulatadoGuardo = $guard->execute();
			if ($resulatadoGuardo) {
				$this->actualizarAutoridadEnZona($id, $autoridades);
			}
		}
		return $resulatadoGuardo;
	}

	public function actualizarAutoridadZona($id, $autoridades) {
		$usuario = Yii::app()->user->id;
		$estatus = 'A';
		foreach ($autoridades as $key => $value) {
			$sql = "UPDATE gplantel.autoridad_zona_educativa"
			. " SET"
			. " cargo_id = :cargo_id,"
			. " usuario_act_id = :usuario_act_id,"
			. " fecha_act = :fecha_act,"
			. " estatus = :estatus"
			. " WHERE"
			. " usuario_id = :usuario_id AND plantel_id=:id";

			$guard = Yii::app()->db->createCommand($sql);
			$guard->bindParam(":id", $id, PDO::PARAM_INT);
			$guard->bindParam(":usuario_id", $value['usuario_id'], PDO::PARAM_INT);
			$guard->bindParam(":cargo_id", $value['cargo'], PDO::PARAM_INT);
			$guard->bindParam(":usuario_act_id", $usuario, PDO::PARAM_INT);
			$guard->bindParam(":fecha_act", date('Y-m-d H:i:s'), PDO::PARAM_INT);
			$guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
			$resulatadoGuardo = $guard->execute();
			if ($resulatadoGuardo) {
				$this->actualizarAutoridadEnZona($id, $autoridades);
			}
		}

		return $resulatadoGuardo;
	}

	public function actualizarAutoridadEnZona($id, $autoridad) {
		//var_dump($autoridad);

		$paso      = '1';
		$usuario   = Yii::app()->user->id;
		$fecha_act = date('Y-m-d H:i:s');

		$actualizado = true;

		if ($autoridad[0]['cargo'] == 6) {//Zonal
			$paso .= '-4';
			$sqlActualizar = "UPDATE gplantel.zona_educativa
                SET fecha_act=:fecha_act, jefe_actual_id=:jefe_actual_id, usuario_act_id=:usuario_act_id
                WHERE id=:id returning id";
			$guard = Yii::app()->db->createCommand($sqlActualizar);
			$guard->bindParam(":jefe_actual_id", $usuario, PDO::PARAM_INT);
			$guard->bindParam(":usuario_act_id", $usuario, PDO::PARAM_INT);
			$guard->bindParam(":id", $id, PDO::PARAM_STR);
			$guard->bindParam(":fecha_act", $fecha_act, PDO::PARAM_STR);

			$actualizado = $guard->execute();
		}

		$paso .= '-6';
		// var_dump($paso);

		return $actualizado;
	}

	//------->

	public function getAutoridadZonaFromEstado($id) {

		$resultado = null;

		if (is_numeric($id)) {

			$id = (int) $id;

			$sql = "  SELECT
                            z.id,
                            z.estado_id,
                            z.nombre AS zona,
                            e.nombre AS estado,
                            u.id AS user_id,
                            u.nombre,
                            u.apellido,
                            u.cedula,
                            u.telefono,
                            u.telefono_celular,
                            u.email,
                            u.twitter,
                            u.last_login,
                            u.cambio_clave,
                            u.username
                          FROM
                            gplantel.autoridad_zona_educativa a,
                            public.estado e,
                            seguridad.usergroups_user u,
                            gplantel.zona_educativa z
                          WHERE
                            a.zona_educativa_id = z.id AND
                            a.usuario_id = u.id AND
                            z.estado_id = e.id AND
                            a.estatus = 'A' AND
                            e.id = $id
                          LIMIT 1";

			$connection = Yii::app()->db;
			$command    = $connection->createCommand($sql);
			$arr        = $command->queryAll();

			// var_dump($arr);

			if (!empty($arr)) {
				$resultado = $arr[0];
			}
		}

		return $resultado;
	}

	public function eliminarAutoridad($id, $zona_id) {
		$fecha   = date('Y-m-d H:i:d');
		$usuario = Yii::app()->user->id;
		$sql     = "UPDATE gplantel.autoridad_zona_educativa"
		. " SET"
		. " estatus = 'E',"
		. " fecha_act = :fecha_act,"
		. " usuario_act_id = :usuario_act_id"
		. " WHERE"
		. " zona_educativa_id = :zona_id AND "
		. " id = :id"
		. " returning cargo_id";

		$update = Yii::app()->db->createCommand($sql);
		$update->bindParam(":zona_id", $zona_id, PDO::PARAM_STR);
		$update->bindParam(":id", $id, PDO::PARAM_STR);
		$update->bindParam(":usuario_act_id", $usuario, PDO::PARAM_STR);
		$update->bindParam(":fecha_act", $fecha, PDO::PARAM_STR);
		$resultado = $update->queryScalar();
		return $resultado;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AutoridadZonaEducativa the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function validarUsuarioEnZona($usuarioId, $zonaId) {
		$enPlantel = $this->getAutoridadZonaEnPlantel($usuarioId);
		$enZona    = $this->getAutoridadZona($zonaId, $usuarioId);

		if ($enPlantel) {
			return array('plantel', $enPlantel);
		} elseif ($enZona) {
			return array('zona', $enZona);
		} else {
			return null;
		}
	}

	public function getAutoridadZona($zona_id, $usuario_id) {

		$resultado = null;

		if (is_numeric($zona_id) && is_numeric($usuario_id)) {

			$zona_id    = (int) $zona_id;
			$usuario_id = (int) $usuario_id;

			$sql = "  SELECT
                            upper(c.nombre) as cargo,
                            c.id as cargo_id,
                            upper(u.nombre) as nombre,
                            upper(u.apellido) as apellido,
                            u.cedula,
                            u.telefono,
                            u.telefono_celular,
                            upper(u.email) as email,
                            upper(u.twitter) as twitter,
                            u.last_login,
                            u.username,
                            u.id as usuario_id,
                            a.id as zona_educativa_id,
                            z.nombre as zona_nombre,
                            z.nombre as codigo,
                            z.id as zona_id
                          FROM
                           seguridad.usergroups_user u
                           INNER JOIN gplantel.autoridad_zona_educativa a ON (u.id = a.usuario_id)
                           INNER JOIN gplantel.zona_educativa z ON (z.id = a.zona_educativa_id)
                           INNER JOIN gplantel.cargo c ON (a.cargo_id = c.id)
                          WHERE
                            u.id = :usuario_id AND a.estatus = 'A'
                          LIMIT 1";
			$connection = Yii::app()->db;
			$command    = $connection->createCommand($sql);
			//$command->bindParam(":zona_id", $zona_id, PDO:: PARAM_STR);
			$command->bindParam(":usuario_id", $usuario_id, PDO::PARAM_STR);
			$arr = $command->queryAll();

			// var_dump($arr);

			if ($arr) {
				$resultado = $arr[0];
			}
		}

		// var_dump($resultado);
		return $resultado;
	}

	public function getAutoridadZonaEnPlantel($usuario_id) {

		$resultado = null;

		if (is_numeric($usuario_id)) {

			$usuario_id = (int) $usuario_id;

			$sql = "  SELECT
                            upper(c.nombre) as cargo,
                            c.id as cargo_id,
                            upper(u.nombre) as nombre,
                            upper(u.apellido) as apellido,
                            u.cedula,
                            u.telefono,
                            u.telefono_celular,
                            upper(u.email) as email,
                            upper(u.twitter) as twitter,
                            u.last_login,
                            u.username,
                            u.id as usuario_id,
                            a.id as zona_educativa_id,
                            p.cod_plantel as codigo
                          FROM
                           seguridad.usergroups_user u
                           INNER JOIN gplantel.autoridad_plantel a ON (u.id = a.usuario_id)
                           INNER JOIN gplantel.plantel p ON (p.id = a.plantel_id)
                           INNER JOIN gplantel.cargo c ON (a.cargo_id = c.id)
                          WHERE
                            u.id = :usuario_id AND a.estatus = 'A' AND p.tipo_dependencia_id != 6
                          LIMIT 1";
			$connection = Yii::app()->db;
			$command    = $connection->createCommand($sql);
			$command->bindParam(":usuario_id", $usuario_id, PDO::PARAM_STR);
			$arr = $command->queryAll();

			// echo '<pre>'.$sql.'</pre><br/>';
			// var_dump($usuario_id);
			// var_dump($arr);

			if ($arr) {
				$resultado = $arr[0];
			}
		}

		//var_dump($resultado);
		return $resultado;
	}

	public function agregarAutoridadZona($id, $cargo, $datosUsuario, $cedula) {
		$estatusAutoridad = $this->buscarAutoridad($datosUsuario['id'], $id);
		$autoridades[]    = array(
			'cargo'      => $cargo,
			'zona_id'    => $id,
			'usuario_id' => $datosUsuario['id'],
			'nombre'     => $datosUsuario['nombre'],
			'apellido'   => $datosUsuario['apellido'],
			'cedula'     => $cedula,
		);

		if ($estatusAutoridad == false) {
			// no existe en autoridad_plantel
			$this->guardarAutoridadZona($id, $autoridades);
		} else {
			$this->actualizarAutoridadZona($id, $autoridades);
		}
	}

}
