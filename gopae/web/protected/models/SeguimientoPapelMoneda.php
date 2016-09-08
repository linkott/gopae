<?php

/**
 * This is the model class for table "titulo.seguimiento_papel_moneda".
 *
 * The followings are the available columns in table 'titulo.seguimiento_papel_moneda':
 * @property integer $id
 * @property integer $papel_moneda_id
 * @property integer $estatus_id
 * @property string $origen_responsable
 * @property integer $cedula_responsable
 * @property string $nombre_responsable
 * @property string $apellido_responsable
 * @property integer $cargo_responsable_id
 * @property integer $plantel_asignado_id
 * @property integer $estudiante_asignado_id
 * @property string $observacion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Cargo $cargoResponsable
 * @property EstatusTitulo $estatus
 * @property Estudiante $estudianteAsignado
 * @property PapelMoneda $papelMoneda
 * @property Plantel $plantelAsignado
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class SeguimientoPapelMoneda extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'titulo.seguimiento_papel_moneda';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('origen_responsable, cedula_responsable, nombre_responsable, apellido_responsable, cargo_responsable_id', 'required', 'message' => 'El campo {attribute} no debe estar vacio'),
            array('papel_moneda_id, estatus_id, cedula_responsable, cargo_responsable_id, plantel_asignado_id, estudiante_asignado_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('origen_responsable, estatus', 'length', 'max' => 1),
            array('nombre_responsable, apellido_responsable', 'length', 'max' => 120),
            array('observacion', 'length', 'max' => 150),
            array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 6),
            // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
            array('id, papel_moneda_id, estatus_id, origen_responsable, cedula_responsable, nombre_responsable, apellido_responsable, cargo_responsable_id, plantel_asignado_id, estudiante_asignado_id, observacion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'cargoResponsable' => array(self::BELONGS_TO, 'Cargo', 'cargo_responsable_id'),
            'estatus' => array(self::BELONGS_TO, 'EstatusTitulo', 'estatus_id'),
            'estudianteAsignado' => array(self::BELONGS_TO, 'Estudiante', 'estudiante_asignado_id'),
            'papelMoneda' => array(self::BELONGS_TO, 'PapelMoneda', 'papel_moneda_id'),
            'plantelAsignado' => array(self::BELONGS_TO, 'Plantel', 'plantel_asignado_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Este el campo primary key de la tabla.',
            'papel_moneda_id' => 'Papel Moneda',
            'estatus_id' => 'Estatus en el que se encuentra el titulo.',
            'origen_responsable' => 'Origen',
            'cedula_responsable' => 'Cédula',
            'nombre_responsable' => 'Nombres',
            'apellido_responsable' => 'Apellidos',
            'cargo_responsable_id' => 'Cargo del Responsable',
            'plantel_asignado_id' => 'Plantel al que se le asigna los titulos.',
            'estudiante_asignado_id' => 'Estudiante al que se le asigna los titulos.',
            'observacion' => 'Observaciones',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('papel_moneda_id', $this->papel_moneda_id);
        $criteria->compare('estatus_id', $this->estatus_id);
        $criteria->compare('origen_responsable', $this->origen_responsable, true);
        $criteria->compare('cedula_responsable', $this->cedula_responsable);
        $criteria->compare('nombre_responsable', $this->nombre_responsable, true);
        $criteria->compare('apellido_responsable', $this->apellido_responsable, true);
        $criteria->compare('cargo_responsable_id', $this->cargo_responsable_id);
        $criteria->compare('plantel_asignado_id', $this->plantel_asignado_id);
        $criteria->compare('estudiante_asignado_id', $this->estudiante_asignado_id);
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

    public function datosPlantel($tipoBusqueda, $codigoe, $codigop) {

        $codigoe = (int) $codigoe;

        if ($tipoBusqueda != '' && $codigoe != '' && $codigoe != 0) {
            if (is_numeric($codigoe)) {

                $sql = 'SELECT p.id ,p.cod_plantel, p.cod_estadistico, d.nombre as denominacion, p.nombre, ze.nombre as zona_educativa, e.nombre as estado'
                        . ' FROM gplantel.plantel p'
                        . ' LEFT JOIN gplantel.denominacion d ON (p.denominacion_id = d.id)'
                        . ' LEFT JOIN gplantel.zona_educativa ze ON (p.zona_educativa_id = ze.id)'
                        . ' LEFT JOIN estado e ON (p.estado_id = e.id)'
                        . ' WHERE p.cod_estadistico=:cod_estadistico_id';

                $consulta = Yii::app()->db->createCommand($sql);
                $consulta->bindParam(":cod_estadistico_id", $codigoe, PDO::PARAM_INT);
                $resultado = $consulta->queryAll();

                if ($resultado == array()) {
                    return false;
                } else {
                    return $resultado;
                }
            }
        } elseif ($tipoBusqueda != '' && $codigop != '') {

            $sql = 'SELECT p.id ,p.cod_plantel, p.cod_estadistico, d.nombre as denominacion, p.nombre, ze.nombre as zona_educativa, e.nombre as estado'
                    . ' FROM gplantel.plantel p'
                    . ' LEFT JOIN gplantel.denominacion d ON (p.denominacion_id = d.id)'
                    . ' LEFT JOIN gplantel.zona_educativa ze ON (p.zona_educativa_id = ze.id)'
                    . ' LEFT JOIN estado e ON (p.estado_id = e.id)'
                    . ' WHERE p.cod_plantel=:cod_plantel_id';

            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(":cod_plantel_id", strtoupper($codigop), PDO::PARAM_STR);
            $resultado = $consulta->queryAll();

            if ($resultado == array()) {
                return false;
            } else {
                return $resultado;
            }
        }
// var_dump($resultado);
    }

    public function verificarExistenciaLote($periodo_actual_id, $plantel_id) {

        $estatus_solicitud_id = 1;
        $estatus_actual_id = 11;
        $sql = "SELECT count(estudiante_id) as cantidad_estudiante
	FROM titulo.titulo
	WHERE estatus_solicitud_id =:estatus_solicitud_id
	AND estatus_actual_id =:estatus_actual_id
	AND plantel_id=:plantel_id
	AND periodo_id=:periodo_escolar_actual_id
	AND papel_moneda_id IS NULL
        ";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":periodo_escolar_actual_id", $periodo_actual_id, PDO::PARAM_INT);
        $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $consulta->bindParam(":estatus_solicitud_id", $estatus_solicitud_id, PDO::PARAM_INT);
        $consulta->bindParam(":estatus_actual_id", $estatus_actual_id, PDO::PARAM_INT);
        $resultado = $consulta->queryScalar();

        return $resultado;

//        var_dump($resultado);
//        die();
    }

    public function serialesAsignados($plantel_id) {
        $estatus_actual_id = 1;
        $sql = "SELECT serial
	FROM titulo.papel_moneda
	WHERE estatus_actual_id <> :estatus_actual_id
	AND plantel_asignado_id=:plantel_id
                        ORDER BY serial ASC";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $consulta->bindParam(":estatus_actual_id", $estatus_actual_id, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        if ($resultado == array()) {
            return false;
        } else {
            return $resultado;
        }
    }

    public function datosFuncionario($plantel_id) {

        $sql = "SELECT *
	FROM titulo.seguimiento_papel_moneda spm
	WHERE spm.plantel_asignado_id=:plantel_id
                        ORDER BY spm.fecha_act ASC
	LIMIT 1";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        //   $consulta->bindParam(":primer_serial", $primer_serial, PDO::PARAM_STR);
        $resultado = $consulta->queryAll();
        if ($resultado == array()) {
            return false;
        } else {
            return $resultado;
        }
    }

    public function planesDelPlantel($plantel_id, $periodo_actual_id, $estatus_solicitud_id, $estatus_actual_id, $a) {


        if ($plantel_id != '' && $periodo_actual_id != null) {

//            $estatus_solicitud_id = 1; // El estatus_solicitud_id=1 es el estatus solicitado de la tabla estatus_solicitud.
//            $estatus_actual_id = 11; // El estatus_actual_id=11 es el estatus en solicitud de la tabla estatus_titulo.
//            $sql = 'SELECT DISTINCT p.nombre as nombrePlan, m.nombre as nombreMencion, count(e.id) as cantidadEstu
//                                FROM gplantel.plantel plantel
//                                INNER JOIN matricula.estudiante e ON (e.plantel_actual_id = plantel.id)
//                                INNER JOIN matricula.inscripcion_estudiante ie ON (ie.estudiante_id = e.id)
//                                INNER JOIN gplantel.seccion_plantel_periodo spp ON (spp.id = ie.seccion_plantel_periodo_id)
//                                INNER JOIN gplantel.seccion_plantel sp ON (sp.id = spp.seccion_plantel_id)
//                                INNER JOIN gplantel.plan_plantel pp ON (pp.plantel_id = plantel.id AND pp.plan_id = sp.plan_id)
//                                INNER JOIN gplantel.plan p ON (p.id = pp.plan_id)
//                                LEFT JOIN gplantel.mencion m ON (m.id = p.mencion_id)
//                                WHERE plantel.id=:plantel_id AND spp.periodo_id=:periodo_escolar_actual_id AND sp.plantel_id=:plantel_id
//                                GROUP BY p.nombre, m.nombre';
            if ($a == 'E') {
                $sql = "SELECT DISTINCT p.nombre as nombrePlan, m.nombre as nombreMencion, count(t.estudiante_id) as cantidadEstu
                            FROM titulo.titulo t
                            INNER JOIN gplantel.plan p ON (p.id = t.plan_id)
                            LEFT JOIN gplantel.mencion m ON (m.id = p.mencion_id)
                            WHERE t.periodo_id=:periodo_escolar_actual_id
                            AND t.plantel_id=:plantel_id
                            AND t.estatus_solicitud_id=:estatus_solicitud_id
                            AND t.estatus_actual_id=:estatus_actual_id
                            GROUP BY p.nombre, m.nombre";
                $consulta = Yii::app()->db->createCommand($sql);

                $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
                $consulta->bindParam(":periodo_escolar_actual_id", $periodo_actual_id, PDO::PARAM_INT);
                $consulta->bindParam(":estatus_solicitud_id", $estatus_solicitud_id, PDO::PARAM_INT);
                $consulta->bindParam(":estatus_actual_id", $estatus_actual_id, PDO::PARAM_INT);
                $resultado = $consulta->queryAll();

                if ($resultado == array()) {
                    return false;
                } else {
                    return $resultado;
                }
            } elseif ($a == 'N') {

                $sql = "SELECT DISTINCT p.nombre as nombrePlan, m.nombre as nombreMencion, count(t.estudiante_id) as cantidadEstu
                            FROM titulo.titulo t
                            INNER JOIN gplantel.plan p ON (p.id = t.plan_id)
                            LEFT JOIN gplantel.mencion m ON (m.id = p.mencion_id)
                            WHERE t.periodo_id=:periodo_escolar_actual_id
                            AND t.plantel_id=:plantel_id
                            GROUP BY p.nombre, m.nombre";
                $consulta = Yii::app()->db->createCommand($sql);
                $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
                $consulta->bindParam(":periodo_escolar_actual_id", $periodo_actual_id, PDO::PARAM_INT);
                $resultado = $consulta->queryAll();

                if ($resultado == array()) {
                    return false;
                } else {
                    return $resultado;
                }
            }
        }
    }

    public function obtenerCantidadGraduando($plantel_id, $periodo_actual_id) {

        if ($plantel_id != '' && $periodo_actual_id != null) {
            $estatus_solicitud_id = 1; // El estatus_solicitud_id=1 es el estatus solicitado de la tabla estatus_solicitud.
            $estatus_actual_id = 11; // El estatus_actual_id=11 es el estatus en solicitud de la tabla estatus_titulo.
            $sql = "SELECT DISTINCT count(t.estudiante_id) as cantidadEstu
                            FROM titulo.titulo t
                            INNER JOIN gplantel.plan p ON (p.id = t.plan_id)
                            LEFT JOIN gplantel.mencion m ON (m.id = p.mencion_id)
                            WHERE t.periodo_id=:periodo_escolar_actual_id
                            AND t.plantel_id=:plantel_id
                            AND t.estatus_solicitud_id=:estatus_solicitud_id
                            AND t.estatus_actual_id=:estatus_actual_id";

            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
            $consulta->bindParam(":periodo_escolar_actual_id", $periodo_actual_id, PDO::PARAM_INT);
            $consulta->bindParam(":estatus_solicitud_id", $estatus_solicitud_id, PDO::PARAM_INT);
            $consulta->bindParam(":estatus_actual_id", $estatus_actual_id, PDO::PARAM_INT);
            $resultado = $consulta->queryScalar();
        }

        if ($resultado == array()) {
            return false;
        } else {
            return $resultado;
        }
    }

    public function verificarSerial($primer_serial, $cantidad_estudiantes) {

        $sql = "SELECT titulo.verificar_serial(  $primer_serial, $cantidad_estudiantes)";

        $verificarSeriales = Yii::app()->db->createCommand($sql);
        $resultado = $verificarSeriales->execute();

//        if ($primer_serial != '') {
//            $sql = "SELECT pm.serial as primer_serial
//                                FROM titulo.papel_moneda pm
//                                WHERE pm.serial=:primer_serial
//                                AND pm.plantel_asignado_id IS NULL";
//
//            $consulta = Yii::app()->db->createCommand($sql);
//            $consulta->bindParam(":primer_serial", $primer_serial, PDO::PARAM_STR);
//            $resultado = $consulta->execute(); // Devuelve 0 cuando no esta disponible el serial, y 1 cuando esta disponible
//        }
//
//        if ($resultado == 0) {
//            return false;
//        } else {
//            return $resultado;
//        }
    }

    public function existenciaSerial($primer_serial) {

        if ($primer_serial != '') {
            $sql = "SELECT pm.serial as primer_serial
                                FROM titulo.papel_moneda pm
                                WHERE pm.serial=:primer_serial";

            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(":primer_serial", $primer_serial, PDO::PARAM_STR);
            $resultado = $consulta->execute(); // Devuelve 0 cuando no esta disponible el serial, y 1 cuando esta disponible
        }

        if ($resultado == 0) {
            return false;
        } else {
            return $resultado;
        }
    }

    public function atencionSolicitud($plantel_id, $origen_responsable, $cedula_responsable, $nombre_responsable, $apellido_responsable, $cargo_responsable_id, $observacion, $primer_serial, $cantidad_serial, $cargo_calificacion, $modulo, $ip, $username) {

        $plantel_id = (int) $plantel_id;
        $cedula_responsable = (int) $cedula_responsable;
        $cargo_responsable_id = (int) $cargo_responsable_id;
        $usuario_id = (int) Yii::app()->user->id;
        $cargo_calificacion = (int) $cargo_calificacion;


        $sql = "SELECT titulo.atender_solicitud(   $plantel_id, :origen_responsable, $cedula_responsable, :nombre_responsable, :apellido_responsable, $cargo_responsable_id, :observacion, $usuario_id, $primer_serial, $cantidad_serial, $cargo_calificacion, :modulo, :ip, :username)";

        $atencionSolicitud = Yii::app()->db->createCommand($sql);
        $atencionSolicitud->bindParam(":origen_responsable", $origen_responsable, PDO::PARAM_STR);
        $atencionSolicitud->bindParam(":nombre_responsable", $nombre_responsable, PDO::PARAM_STR);
        $atencionSolicitud->bindParam(":apellido_responsable", $apellido_responsable, PDO::PARAM_STR);
        $atencionSolicitud->bindParam(":observacion", $observacion, PDO::PARAM_STR);
        $atencionSolicitud->bindParam(":modulo", $modulo, PDO::PARAM_STR);
        $atencionSolicitud->bindParam(":ip", $ip, PDO::PARAM_STR);
        $atencionSolicitud->bindParam(":username", $username, PDO::PARAM_STR);

        $resultado = $atencionSolicitud->execute();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeguimientoPapelMoneda the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
