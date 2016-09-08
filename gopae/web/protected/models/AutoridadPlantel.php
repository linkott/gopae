<?php

/**
 * This is the model class for table "gplantel.autoridad_plantel".
 *
 * The followings are the available columns in table 'gplantel.autoridad_plantel':
 * @property string $id
 * @property integer $plantel_id
 * @property integer $usuario_id
 * @property integer $cargo_id
 * @property string $observacion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property integer $periodo_id
 *
 * The followings are the available model relations:
 * @property Usuario $usuarioAct
 * @property Usuario $usuarioIni
 * @property PeriodoEscolar $periodo
 * @property Plantel $plantel
 * @property Usuario $usuario
 */
class AutoridadPlantel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.autoridad_plantel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('plantel_id, usuario_id, cargo_id, usuario_ini_id, usuario_act_id, periodo_id', 'numerical', 'integerOnly' => true),
            array('observacion', 'length', 'max' => 150),
            array('estatus', 'length', 'max' => 1),
            array('fecha_ini, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
            array('id, plantel_id, usuario_id, cargo_id, observacion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, periodo_id', 'safe', 'on' => 'search'),
        );
    }

    public function busquedaSaime($origen, $cedula) {
        $cedulaInt = $cedula;
        $indice = "$origen-$cedula";
        $resultadoCedula = Yii::app()->cache->get($indice);
        
        if(!$resultadoCedula){
            $sql = "SELECT origen, cedula, (primer_nombre || ' ' || segundo_nombre) AS nombre, (primer_apellido || ' ' || segundo_apellido) AS apellido, fecha_nacimiento, sexo "
                    . " FROM auditoria.saime s"
                    . " WHERE "
                    . " s.cedula= :cedula AND "
                    . " s.origen= :origen ";

            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":cedula", $cedulaInt, PDO::PARAM_INT);
            $buqueda->bindParam(":origen", $origen, PDO::PARAM_STR);

            $resultadoCedula = $buqueda->queryRow();

            if ($resultadoCedula !== array()) {
                Yii::app()->cache->set($indice, $resultadoCedula, 0);
                return $resultadoCedula;
            } else {
                return false;
            }
        }
        else{
            return $resultadoCedula;
        }
    }

    public function busquedaUserGroups($origen, $cedula) {
        $indice = "USR:$origen-$cedula";
        $resultadoCedula = Yii::app()->cache->get($indice);
        
        if(!$resultadoCedula){
            $cedulaInt = $cedula;
            $sql = "select id"
                    . " from seguridad.usergroups_user "
                    . " where "
                    . " cedula= :cedula ";
            $buqueda = Yii::app()->db->createCommand($sql);
            $buqueda->bindParam(":cedula", $cedulaInt, PDO::PARAM_INT);
            Yii::app()->cache->set($indice, $resultadoCedula, 86400);
            //$buqueda->bindParam(":origen", $origen, PDO::PARAM_INT);
            $resultadoCedula = $buqueda->queryScalar();
        }

        if ($resultadoCedula !== false)
            return $resultadoCedula;
        else
            return null;
    }

    public function buscarUsuarioId($cedula) {
        $sql = "SELECT id, nombre, apellido, email FROM seguridad.usergroups_user WHERE cedula=$cedula";
        $buqueda = Yii::app()->db->createCommand($sql);
        $resultadoUsuario = $buqueda->queryRow(); //queryScalar= Es para obtener un solo valor
//    var_dump($resultadoUsuario); die();
        return $resultadoUsuario;
    }

    public function buscarCargo($cargo) {

        $sql = "select nombre from gplantel.cargo where id=$cargo";
        $buqueda = Yii::app()->db->createCommand($sql);
        $resultadoCargo = $buqueda->queryScalar(); //queryScalar= Es para obtener un solo valor
//var_dump($resultadoCargo); die();
        return $resultadoCargo;
    }

    public function validarExisteCargo($cargo, $plantel_id, $usuario_id = null) {

        $cargo = (int) $cargo;
        $plantel_id = (int) $plantel_id;

        $sql = "SELECT cargo_id  FROM gplantel.autoridad_plantel WHERE cargo_id=$cargo AND plantel_id=$plantel_id AND estatus='A'";
        if ($usuario_id !== null) {
            $sql.=" AND usuario_id <> $usuario_id";
        }
        $buqueda = Yii::app()->db->createCommand($sql);
        $resultadoCargo = $buqueda->queryScalar(); //queryScalar= Es para obtener un solo valor
//var_dump($resultadoCargo); die();
        return $resultadoCargo;
    }

    public function agregarEnAutoridadPlantel($plantel_id, $cargo, $datosUsuario, $cedula) {
        //  $estatusAutoridad = $this->buscarAutoridad($datosUsuario['id'], $plantel_id);
        $autoridades [] = array(
            'cargo' => $cargo,
            'plantel_id' => $plantel_id,
            'usuario_id' => $datosUsuario['id'],
            'nombre' => $datosUsuario['nombre'],
            'apellido' => $datosUsuario['apellido'],
            'cedula' => $cedula
        );
        // if ($estatusAutoridad == false) {
// no existe en autoridad_plantel
        $this->guardarEnTablaAutoridadPlantel($plantel_id, $autoridades); // Guardo los datos en la tabla autoridad_plantel
        // }
    }

    public function guardarEnTablaAutoridadPlantel($plantel_id, $autoridades) {
        $usuario_id = Yii::app()->user->id;
        $estatus = 'A';
        $periodo = '1';
        $cacheIndex = 'AUTR:'.$plantel_id;

        Yii::app()->cache->delete($cacheIndex);
        
        foreach ($autoridades as $key => $value) {
            $sql = "INSERT INTO gplantel.autoridad_plantel
                (plantel_id, usuario_id, cargo_id, usuario_ini_id,usuario_act_id,fecha_act, estatus, periodo_id)
                VALUES (:plantel_id,:usuario_id, :cargo_id, :usuario_ini_id, :usuario_act_id,:fecha_act, :estatus, :periodo_id) returning id";
            $guard = Yii::app()->db->createCommand($sql);

            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guard->bindParam(":usuario_id", $value['usuario_id'], PDO::PARAM_INT);
            $guard->bindParam(":cargo_id", $value['cargo'], PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario_id, PDO::PARAM_INT);
            $guard->bindParam(":usuario_act_id", $usuario_id, PDO::PARAM_INT);
            $guard->bindParam(":fecha_act", date('Y-m-d H:i:s'), PDO::PARAM_INT);
// $guard -> bindParam(":fecha_elim", $this -> fecha_elim, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":periodo_id", $periodo, PDO::PARAM_INT);
            $resulatadoGuardo = $guard->execute();
            if ($resulatadoGuardo) {
                $this->actualizarAutoridadEnPlantel($plantel_id, $autoridades);
            }
        }
        return $resulatadoGuardo;
    }

    public function agregarAutoridad($plantel_id, $cargo, $datosUsuario, $cedula, $presento_documento_identidad) {
        $estatusAutoridad = $this->buscarAutoridad($datosUsuario['id'], $plantel_id);
        $autoridades [] = array(
            'cargo' => $cargo,
            'plantel_id' => $plantel_id,
            'usuario_id' => $datosUsuario['id'],
            'nombre' => $datosUsuario['nombre'],
            'apellido' => $datosUsuario['apellido'],
            'cedula' => $cedula
        );
        $this->actualizarPresentoDocumentoDeIdentidad($cedula, $presento_documento_identidad);
        if ($estatusAutoridad == false) {
            // no existe en autoridad_plantel
            $this->guardarAutoridadPlantel($plantel_id, $autoridades);
        } else {
            $this->actualizarAutoridadPlantel($plantel_id, $autoridades);
        }
    }

    public function guardarAutoridadPlantel($plantel_id, $autoridades) {
        $usuario_id = Yii::app()->user->id;
        $estatus = 'A';
        $periodo = '1';
        foreach ($autoridades as $key => $value) {
            $sql = "INSERT INTO gplantel.autoridad_plantel
                (plantel_id, usuario_id, cargo_id, usuario_ini_id,usuario_act_id,fecha_act, estatus, periodo_id)
                VALUES (:plantel_id,:usuario_id, :cargo_id, :usuario_ini_id, :usuario_act_id,:fecha_act, :estatus, :periodo_id) returning id";
            $guard = Yii::app()->db->createCommand($sql);

            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guard->bindParam(":usuario_id", $value['usuario_id'], PDO::PARAM_INT);
            $guard->bindParam(":cargo_id", $value['cargo'], PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $usuario_id, PDO::PARAM_INT);
            $guard->bindParam(":usuario_act_id", $usuario_id, PDO::PARAM_INT);
            $guard->bindParam(":fecha_act", date('Y-m-d H:i:s'), PDO::PARAM_INT);
// $guard -> bindParam(":fecha_elim", $this -> fecha_elim, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":periodo_id", $periodo, PDO::PARAM_INT);
            $resulatadoGuardo = $guard->execute();
            if ($resulatadoGuardo) {
                $this->actualizarAutoridadEnPlantel($plantel_id, $autoridades);
            }
        }
        return $resulatadoGuardo;
    }

    public function actualizarAutoridadPlantel($plantel_id, $autoridades) {
        $usuario = Yii::app()->user->id;
        $estatus = 'A';
        foreach ($autoridades as $key => $value) {
            $sql = "UPDATE gplantel.autoridad_plantel"
                    . " SET"
                    . " cargo_id = :cargo_id,"
                    . " usuario_act_id = :usuario_act_id,"
                    . " fecha_act = :fecha_act,"
                    . " estatus = :estatus"
                    . " WHERE"
                    . " usuario_id = :usuario_id AND plantel_id=:plantel_id";

            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $guard->bindParam(":usuario_id", $value['usuario_id'], PDO::PARAM_INT);
            $guard->bindParam(":cargo_id", $value['cargo'], PDO::PARAM_INT);
            $guard->bindParam(":usuario_act_id", $usuario, PDO:: PARAM_INT);
            $guard->bindParam(":fecha_act", date('Y-m-d H:i:s'), PDO:: PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO:: PARAM_STR);
            $resulatadoGuardo = $guard->execute();
            if ($resulatadoGuardo) {
                $this->actualizarAutoridadEnPlantel($plantel_id, $autoridades);
            }
        }

        return $resulatadoGuardo;
    }

    public function actualizarPresentoDocumentoDeIdentidad($cedula, $presento_documento_identidad){
        $sql = "UPDATE seguridad.usergroups_user"
            . " SET"
            . " presento_documento_identidad = :presento_documento_identidad "
            . " WHERE"
            . " cedula = :cedula";
        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":cedula", $cedula, PDO::PARAM_INT);
        $guard->bindParam(":presento_documento_identidad", $presento_documento_identidad, PDO::PARAM_INT);
        $resulatadoGuardo = $guard->execute();
        return $resulatadoGuardo;
    }

    public function actualizarAutoridadEnPlantel($plantel_id, $autoridad) {
        $usuario = Yii::app()->user->id;
        $fecha_act = date('Y-m-d H:i:s');
        $actualizado = true;
        for ($x = 0; $x < sizeof($autoridad); $x++) {

            if ($autoridad[$x]['cargo'] == 3 || $autoridad [$x]['cargo'] == 2 || $autoridad [$x]['cargo'] == 5 || $autoridad [$x]['cargo'] == 27) {

                $cargo_id = $autoridad[$x]['cargo'];
                $cargo_id = (int) $cargo_id;
                $usuario_id = $autoridad[$x]['usuario_id'];
                $usuario_id = (int) $usuario_id;

                if ($autoridad[$x]['cargo'] == 3) { //director
                    $sqlActualizar = "UPDATE gplantel.plantel
                SET fecha_act=:fecha_act,director_actual_id=:director_actual_id, usuario_act_id=:usuario_act_id
                WHERE id=:plantel_id returning id";
                    $guard = Yii::app()->db->createCommand($sqlActualizar);
                    $guard->bindParam(":director_actual_id", $usuario_id, PDO:: PARAM_INT);
                }

                if ($autoridad[$x]['cargo'] == 2) { //coordinador
                    $sqlActualizar = "UPDATE gplantel.plantel
                SET fecha_act=:fecha_act,coordinador_actual_id=:coordinador_actual_id, usuario_act_id=:usuario_act_id
                WHERE id=:plantel_id returning id";
                    $guard = Yii::app()->db->createCommand($sqlActualizar);
                    $guard->bindParam(":coordinador_actual_id", $usuario_id, PDO:: PARAM_INT);
                }

                if ($autoridad[$x]['cargo'] == 5) { //sub-director
                    $sqlActualizar = "UPDATE gplantel.plantel
                SET fecha_act=:fecha_act,subdirector_actual_id=:subdirector_actual_id, usuario_act_id=:usuario_act_id
                WHERE id=:plantel_id returning id";
                    $guard = Yii::app()->db->createCommand($sqlActualizar);
                    $guard->bindParam(":subdirector_actual_id", $usuario_id, PDO:: PARAM_INT);
                }
                
                if ($autoridad[$x]['cargo'] == 27) { //enlace-CNAE
                    $sqlActualizar = "UPDATE gplantel.plantel
                SET fecha_act=:fecha_act, enlace_pae_actual_id=:enlace_pae_actual_id, usuario_act_id=:usuario_act_id
                WHERE id=:plantel_id returning id";
                    $guard = Yii::app()->db->createCommand($sqlActualizar);
                    $guard->bindParam(":enlace_pae_actual_id", $usuario_id, PDO:: PARAM_INT);
                }
                
                $guard->bindParam(":usuario_act_id", $usuario, PDO:: PARAM_INT);
                $guard->bindParam(":plantel_id", $plantel_id, PDO:: PARAM_STR);
                $guard->bindParam(":fecha_act", $fecha_act, PDO:: PARAM_STR);

                // $actualizado = $guard->execute();
            }
        }

        return $actualizado;
    }

    public function eliminarAutoridadEnPlantel($plantel_id, $cargo) {
        
        // $cacheIndex = 'AUTR:'.$plantel_id;
        // Yii::app()->cache->delete($cacheIndex);
        
        $usuario = Yii::app()->user->id;
        $actualizado = true;
        if ($cargo == 3 || $cargo == 2 || $cargo == 5) {
            $fecha_act = date('Y-m-d H:i:s');
            $valor = null;

            if ($cargo == 3) { //director
                $sqlActualizar = "UPDATE gplantel.plantel
                SET fecha_act=:fecha_act,director_actual_id=:director_actual_id, usuario_act_id=:usuario_act_id
                WHERE id=:plantel_id returning id";
                $guard = Yii::app()->db->createCommand($sqlActualizar);
                $guard->bindParam(":director_actual_id", $valor, PDO:: PARAM_INT);
            }

            if ($cargo == 2) { //coordinador
                $sqlActualizar = "UPDATE gplantel.plantel
                SET fecha_act=:fecha_act,coordinador_actual_id=:coordinador_actual_id, usuario_act_id=:usuario_act_id
                WHERE id=:plantel_id returning id";
                $guard = Yii::app()->db->createCommand($sqlActualizar);
                $guard->bindParam(":coordinador_actual_id", $valor, PDO:: PARAM_INT);
            }

            if ($cargo == 5) { //sub-director
                $sqlActualizar = "UPDATE gplantel.plantel
                SET fecha_act=:fecha_act,subdirector_actual_id=:subdirector_actual_id, usuario_act_id=:usuario_act_id
                WHERE id=:plantel_id returning id";
                $guard = Yii::app()->db->createCommand($sqlActualizar);
                $guard->bindParam(":subdirector_actual_id", $valor, PDO:: PARAM_INT);
            }
            $guard->bindParam(":usuario_act_id", $usuario, PDO:: PARAM_INT);
            $guard->bindParam(":plantel_id", $plantel_id, PDO:: PARAM_STR);
            $guard->bindParam(":fecha_act", $fecha_act, PDO:: PARAM_STR);

            // $actualizado = $guard->execute();
        }

        return $actualizado;
    }

    public function registrosPlantel() {
        $sql = "SELECT * 
                FROM gplantel.autoridad_plantel";
        $registros = Yii::app()->db->createCommand($sql);
        $resultadoR = $registros->queryAll();
//var_dump($rBuscar); die();
        return $resultadoR;
    }

    public function guardarUsuario($datosUsuario) {
        $sql = "INSERT INTO seguridad.usergroups_user
              (nombre, apellido, cedula, email,group_id, home, status, user_ini_id, username, password, estado_id, telefono, origen, telefono_celular, presento_documento_identidad)
              VALUES (:nombre, :apellido, :cedula, :email,:group_id, :home, :status, :user_ini_id, :username, :password, :estado_id, :telefono, :origen, :telefono_celular, :presento_documento_identidad) returning id";
        $home = '/index';
        $status = '2';
        $group_id = 29;
        $id = Yii::app()->user->id;
        $estado_id = $this->buscarEstadoPlantel($datosUsuario['plantel_id']);
        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":nombre", $datosUsuario['nombre'], PDO:: PARAM_STR);
        $guard->bindParam(":telefono", $datosUsuario['telefono'], PDO:: PARAM_INT);
        $guard->bindParam(":telefono_celular", $datosUsuario['telefono_celular'], PDO:: PARAM_INT);
        $guard->bindParam(":apellido", $datosUsuario['apellido'], PDO:: PARAM_STR);
        $guard->bindParam(":cedula", $datosUsuario['cedula'], PDO:: PARAM_INT);
        $guard->bindParam(":email", $datosUsuario['email'], PDO:: PARAM_STR);
        $guard->bindParam(":group_id", $group_id, PDO:: PARAM_STR);
        $guard->bindParam(":home", $home, PDO:: PARAM_STR);
        $guard->bindParam(":status", $status, PDO:: PARAM_INT);
        $guard->bindParam(":user_ini_id", $id, PDO:: PARAM_INT);
        $guard->bindParam(":username", $datosUsuario['username'], PDO:: PARAM_INT);
        $guard->bindParam(":password", md5($this->generaPass()), PDO:: PARAM_INT);
        $guard->bindParam(":estado_id", $estado_id, PDO:: PARAM_INT);
        $guard->bindParam(":origen", $datosUsuario['origen'], PDO:: PARAM_INT);
        $guard->bindParam(":presento_documento_identidad", $datosUsuario['presento_documento_identidad'], PDO::PARAM_STR);

        $resultado = $guard->queryScalar(); //queryScalar= Es para obtener un solo valor
        $autoridades[] = array(
            'cargo' => $datosUsuario['cargo'],
            'usuario_id' => $resultado);
        $plantel_id = $datosUsuario['plantel_id'];
        $this->guardarEnTablaAutoridadPlantel($plantel_id, $autoridades);
        return $resultado;
    }

    public function buscarEstadoPlantel($plantel_id) {
        $sql = "SELECT estado_id FROM gplantel.plantel"
                . " WHERE id = :plantel_id";
        $busqueda = Yii::app()->db->createCommand($sql);
        $busqueda->bindParam(":plantel_id", $plantel_id, PDO:: PARAM_INT);
        return $resultado = $busqueda->queryScalar(); //queryScalar= Es para obtener un solo valor
    }

    public function validarUsuarioEnPlantel($usuario_id, $plantel_id) {

        $sql = "SELECT id  FROM gplantel.autoridad_plantel WHERE usuario_id=$usuario_id AND plantel_id=$plantel_id  ";
        $buqueda = Yii::app()->db->createCommand($sql);
        $resultadoUsuario = $buqueda->queryScalar(); //queryScalar= Es para obtener un solo valor
        //   var_dump($resultadoUsuario); die();
        return $resultadoUsuario;
    }

    public function validarUniqueUsuario($cedula) {
        $sql = "SELECT cedula FROM seguridad.usergroups_user"
                . " WHERE cedula = :cedula";
        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":cedula", $cedula, PDO:: PARAM_STR);
        $resultado = $guard->queryScalar();
        return $resultado;
    }

    public function validarUniqueEmail($email, $usuario_id = null) {
        $sql = "SELECT email FROM seguridad.usergroups_user"
                . " WHERE email = :email";
        if ($usuario_id !== null) {
            $sql .=" AND id <> :usuario_id";
        }
        $guard = Yii::app()->db->createCommand($sql);
        if ($usuario_id !== null) {
            $guard->bindParam(":usuario_id", $usuario_id, PDO:: PARAM_INT);
        }
        $guard->bindParam(":email", $email, PDO:: PARAM_STR);
        $resultado = $guard->queryScalar();
        return $resultado;
    }

    public function buscarAutoridadesPlantel($plantel_id) {
        $resultado = null;
        $sql = '';
        $cacheIndex = 'AUTR:'.$plantel_id;

        Yii::app()->cache->delete($cacheIndex);

        $resultado = Yii::app()->cache->get($cacheIndex);
        
        if(!$resultado){

            if (is_numeric($plantel_id)) {
        
                $sql = "SELECT a.id, "
                        . "a.usuario_id, "
                        . "upper(u_u.nombre) AS nombre, "
                        . "upper(u_u.apellido) AS apellido, "
                        . "u_u.cedula,"
                        . "u_u.email, "
                        . "u_u.telefono AS telefono_fijo, "
                        . "u_u.telefono_celular AS telefono_celular, "
                        . "u_u.presento_documento_identidad, "
                        . "u_u.foto,"
                        . "a.cargo_id, "
                        . "c.nombre AS nombre_cargo"
                        . " FROM gplantel.autoridad_plantel a "
                        . " INNER JOIN gplantel.cargo c ON (a.cargo_id = c.id)"
                        . " INNER JOIN seguridad.usergroups_user u_u ON (u_u.id = a.usuario_id)"
                        . " WHERE "
                        . " a.plantel_id = :plantel_id AND a.estatus = 'A'"
                        . " ORDER BY c.nombre ASC ";
                $select = Yii::app()->db->createCommand($sql);
                $select->bindParam(":plantel_id", $plantel_id, PDO:: PARAM_STR);
                $resultado = $select->queryAll();
        
                if($resultado){
                    Yii::app()->cache->set($cacheIndex, $resultado, 86400);
                }

                if ($resultado == array())
                    $resultado = null;
            }

        }

        return $resultado;
    }

    public function buscarAutoridad($usuario_id, $plantel_id = null) {

        $resultado = Yii::app()->cache->get("usr{$usuario_id}plantel{$plantel_id}");
        
        if(!$resultado){
        
            if(is_numeric($usuario_id)){
                $sql = ' SELECT estatus '
                        . ' FROM gplantel.autoridad_plantel'
                        . ' WHERE'
                        . ' usuario_id = :usuario_id';
                if(is_numeric($plantel_id)){
                    $sql .= ' AND plantel_id=:plantel_id';
                }
                $sql .= ' ORDER BY plantel_id LIMIT 1';

                $select = Yii::app()->db->createCommand($sql);
                $select->bindParam(":usuario_id", $usuario_id, PDO:: PARAM_INT);
                if(is_numeric($plantel_id)){
                    $select->bindParam(":plantel_id", $plantel_id, PDO:: PARAM_INT);
                }
                $resultado = $select->queryScalar();
                Yii::app()->cache->set("usr{$usuario_id}plantel{$plantel_id}", $resultado, 86400);
            }
        
        }
        
        return ($resultado);
    }
    
    /**
     * Busca el ID del Plantel en el que un usuario es autoridad según el ID del usuario
     * 
     * @param integer $usuario_id
     * @return array
     */
    public function buscarPlantelAutoridadByUser($usuario_id) {
        $sql = " SELECT plantel_id "
                . " FROM gplantel.autoridad_plantel"
                . " WHERE"
                . " usuario_id = :usuario_id";
        $select = Yii::app()->db->createCommand($sql);
        $select->bindParam(":usuario_id", $usuario_id, PDO:: PARAM_STR);
        $resultado = $select->queryAll();
        return $resultado;
    }

    public function eliminarAutoridad($id, $plantel_id) {
        
        $cacheIndex = 'AUTR:'.$plantel_id;
        Yii::app()->cache->delete($cacheIndex);
        
        $fecha = date('Y-m-d H:i:d');
        $usuario = Yii::app()->user->id;
        $sql = "UPDATE gplantel.autoridad_plantel"
                . " SET"
                . " estatus = 'E',"
                . " fecha_act = :fecha_act,"
                . " usuario_act_id = :usuario_act_id"
                . " WHERE"
                . " plantel_id = :plantel_id AND id = :id"
                . " returning cargo_id";
        $update = Yii::app()->db->createCommand($sql);
        $update->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $update->bindParam(":id", $id, PDO::PARAM_INT);
        $update->bindParam(":usuario_act_id", $usuario, PDO::PARAM_STR);
        $update->bindParam(":fecha_act", $fecha, PDO::PARAM_STR);
        $resultado = $update->queryScalar();
        if ($resultado !== false) {
            $this->eliminarAutoridadEnPlantel($plantel_id, $resultado);
        }
        return $resultado;
    }

    /* ESTA FUNCION TE PERMITE BUSCAS (CONSULTAR) LAS AUTORIDADES DE UN PLANTEL EN ESPECIFICO */

    public function datosAutoridades($plantel_id) {

        /*
          TRAEME TODOS LOS NOMBRE DE LOS CARGOS, Y LOS NOMBRES DE LAS AUTORIDADES (DIRECTOR, COORDINADOR, SECRETARIA, ETC)
          DONDE
          EL PLANTEL_ID = AUTORIDADES_PLANTEL_ID
          AUTORIDADES_ID_CARGO = CARGO_ID
         */

        $sql = "SELECT

        DISTINCT
        c.nombre cargo,
        u.nombre,
        u.apellido,
        u.cedula,
        u.email,
        u.telefono,
        u.presento_documento_identidad
        FROM gplantel.autoridad_plantel a
        LEFT JOIN gplantel.cargo c ON c.id = a.cargo_id
        LEFT JOIN gplantel.plantel p ON p.id = a.plantel_id
        LEFT JOIN seguridad.usergroups_user u ON u.id = a.usuario_id

        WHERE p.id = " . $plantel_id . " AND a.estatus = 'A'";

        $con = Yii::app()->db->createCommand($sql);
        $con->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);

        return $resultado = $con->queryAll();
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

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
            'periodo' => array(self::BELONGS_TO, 'PeriodoEscolar', 'periodo_id'),
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
            'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'plantel_id' => 'Plantel',
            'usuario_id' => 'Usuario',
            'cargo_id' => 'Cargo',
            'observacion' => 'Observacion',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'periodo_id' => 'Periodo',
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
    public function search() {
// @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('plantel_id', $this->plantel_id);
        $criteria->compare('usuario_id', $this->usuario_id);
        $criteria->compare('cargo_id', $this->cargo_id);
        $criteria->compare('observacion', $this->observacion, true);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('periodo_id', $this->periodo_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getAutoridadPlantel($plantel_id, $usuario_id) {

        $resultado = null;

        if (is_numeric($plantel_id) && is_numeric($usuario_id)) {

            $plantel_id = (int) $plantel_id;
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
                            p.id as plantel_id,
                            u.presento_documento_identidad
                          FROM
                           seguridad.usergroups_user u
                           INNER JOIN gplantel.autoridad_plantel a on (u.id = a.usuario_id)
                           INNER JOIN gplantel.plantel p on (a.plantel_id = p.id)
                           INNER JOIN gplantel.cargo c on (a.cargo_id = c.id)
                          WHERE
                          u.id = :usuario_id AND p.id = :plantel_id
                          LIMIT 1";

            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->bindParam(":plantel_id", $plantel_id, PDO:: PARAM_STR);
            $command->bindParam(":usuario_id", $usuario_id, PDO:: PARAM_STR);
            $arr = $command->queryAll();

//                var_dump($arr);
//                die();

            if (!empty($arr)) {
                $resultado = $arr[0];
            }
        }

        return $resultado;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AutoridadPlantel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
