<?php

/**
 * This is the model class for table "titulo.titulo".
 *
 * The followings are the available columns in table 'titulo.titulo':
 * @property integer $id
 * @property integer $papel_moneda_id
 * @property integer $estatus_actual_id
 * @property string $observacion
 * @property integer $estudiante_id
 * @property integer $tipo_documento_id
 * @property integer $motivo_retencion_id
 * @property integer $mes_egreso
 * @property integer $ano_egreso
 * @property integer $seccion_plantel_periodo_id
 * @property integer $grado_id
 * @property integer $seccion_id
 * @property integer $plan_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 * @property string $codigo_verificacion
 * @property integer $estatus_solicitud_id
 * @property integer $plantel_id
 * @property integer $cargo_calificacion
 * @property integer $periodo_id
 *
 * The followings are the available model relations:
 * @property EstatusTitulo $estatusActual
 * @property Estudiante $estudiante
 * @property Grado $grado
 * @property MotivoRetencion $motivoRetencion
 * @property PapelMoneda $papelMoneda
 * @property Plan $plan
 * @property Plantel $plantel
 * @property Seccion $seccion
 * @property SeccionPlantelPeriodo $seccionPlantelPeriodo
 * @property TipoDocumento $tipoDocumento
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property FirmaAutoridadTitulo[] $firmaAutoridadTitulos
 */
class Titulo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'titulo.titulo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('estatus_actual_id, estudiante_id, tipo_documento_id, seccion_plantel_periodo_id, plan_id, usuario_ini_id, fecha_ini, estatus, estatus_solicitud_id', 'required'),
            array('papel_moneda_id, estatus_actual_id, estudiante_id, tipo_documento_id, motivo_retencion_id, mes_egreso, ano_egreso, seccion_plantel_periodo_id, grado_id, seccion_id, plan_id, usuario_ini_id, usuario_act_id, estatus_solicitud_id, plantel_id, cargo_calificacion, periodo_id', 'numerical', 'integerOnly' => true),
            array('observacion', 'length', 'max' => 150),
            array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 6),
            array('estatus', 'length', 'max' => 1),
            array('codigo_verificacion', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, papel_moneda_id, estatus_actual_id, observacion, estudiante_id, tipo_documento_id, motivo_retencion_id, mes_egreso, ano_egreso, seccion_plantel_periodo_id, grado_id, seccion_id, plan_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, codigo_verificacion, estatus_solicitud_id, plantel_id, cargo_calificacion, periodo_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'estatusActual' => array(self::BELONGS_TO, 'EstatusTitulo', 'estatus_actual_id'),
            'estudiante' => array(self::BELONGS_TO, 'Estudiante', 'estudiante_id'),
            'grado' => array(self::BELONGS_TO, 'Grado', 'grado_id'),
            'motivoRetencion' => array(self::BELONGS_TO, 'MotivoRetencion', 'motivo_retencion_id'),
            'papelMoneda' => array(self::BELONGS_TO, 'PapelMoneda', 'papel_moneda_id'),
            'plan' => array(self::BELONGS_TO, 'Plan', 'plan_id'),
            'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
            'seccion' => array(self::BELONGS_TO, 'Seccion', 'seccion_id'),
            'seccionPlantelPeriodo' => array(self::BELONGS_TO, 'SeccionPlantelPeriodo', 'seccion_plantel_periodo_id'),
            'tipoDocumento' => array(self::BELONGS_TO, 'TipoDocumento', 'tipo_documento_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'firmaAutoridadTitulos' => array(self::HAS_MANY, 'FirmaAutoridadTitulo', 'titulo_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Este el campo primary key de la tabla.',
            'papel_moneda_id' => 'Papel moneda que contiene los seriales de los titulos.',
            'estatus_actual_id' => 'Estatus en el que se encuentra la solicitud del titulo.',
            'observacion' => 'Observaciones referentes al titulo.',
            'estudiante_id' => 'Estudiantes al que se le asigna los titulos.',
            'tipo_documento_id' => 'Contiene el id del tipo de documento que se requiere ingresar un titulo, certificado, titulo de bachiller integral',
            'motivo_retencion_id' => 'Contiene el id de los motivos de retención de título',
            'mes_egreso' => 'Mes Egreso',
            'ano_egreso' => 'Ano Egreso',
            'seccion_plantel_periodo_id' => 'Contiene el id del periodo escolar actual.',
            'grado_id' => 'Contiene el id del grado del estudiante.',
            'seccion_id' => 'Contiene el id de la sección del estudiante.',
            'plan_id' => 'Contiene el id el plan al que pertenece el estudiante.',
            'usuario_ini_id' => 'Usuario Ini',
            'fecha_ini' => 'Fecha Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'codigo_verificacion' => 'Codigo Verificacion',
            'estatus_solicitud_id' => 'Estatus Solicitud',
            'plantel_id' => 'Plantel',
            'cargo_calificacion' => 'Cargo Calificacion',
            'periodo_id' => 'Contiene el periodo escolar actual.',
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
        $criteria->compare('estatus_actual_id', $this->estatus_actual_id);
        $criteria->compare('observacion', $this->observacion, true);
        $criteria->compare('estudiante_id', $this->estudiante_id);
        $criteria->compare('tipo_documento_id', $this->tipo_documento_id);
        $criteria->compare('motivo_retencion_id', $this->motivo_retencion_id);
        $criteria->compare('mes_egreso', $this->mes_egreso);
        $criteria->compare('ano_egreso', $this->ano_egreso);
        $criteria->compare('seccion_plantel_periodo_id', $this->seccion_plantel_periodo_id);
        $criteria->compare('grado_id', $this->grado_id);
        $criteria->compare('seccion_id', $this->seccion_id);
        $criteria->compare('plan_id', $this->plan_id);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $criteria->compare('codigo_verificacion', $this->codigo_verificacion, true);
        $criteria->compare('estatus_solicitud_id', $this->estatus_solicitud_id);
        $criteria->compare('plantel_id', $this->plantel_id);
        $criteria->compare('cargo_calificacion', $this->cargo_calificacion);
        $criteria->compare('periodo_id', $this->periodo_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Titulo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function solicitudTitulo($plantel_id = null) {


        $periodo_Escolar = PeriodoEscolar::model()->getPeriodoActivo();
        $periodo_Escolar_id = $periodo_Escolar['id'];



        $sql = "SELECT e.cedula_identidad, e.nombres, e.apellidos, e.id,
                    e.plantel_actual_id,g.nombre as grado,s.nombre as nombre_seccion,p.nombre as nombre_plantel,
                    ie.seccion_plantel_periodo_id,g.id as id_grado, s.id as id_seccion,pl.id as plan_id , pl.nombre as nombrePlan,spp.periodo_id
                    from matricula.estudiante e
                    inner join gplantel.grado g on g.id=e.grado_actual_id
                    inner join gplantel.plantel p on p.id=:plantel_actual_id
                    inner join matricula.inscripcion_estudiante ie on e.id=ie.estudiante_id
                    inner join gplantel.seccion_plantel_periodo spp on ie.seccion_plantel_periodo_id=spp.id
                    inner join gplantel.seccion_plantel sp on spp.seccion_plantel_id=sp.id
                    inner join gplantel.seccion s on sp.seccion_id=s.id
                    INNER JOIN gplantel.plan_plantel pp ON (pp.plantel_id = p.id AND pp.plan_id = sp.plan_id)
                    INNER JOIN gplantel.plan pl ON (pl.id = pp.plan_id)
                    where spp.periodo_id=$periodo_Escolar_id
                    and e.grado_actual_id IN (select id from gplantel.grado where es_final=1)
                    and e.id not in (select estudiante_id from titulo.titulo where periodo_id=$periodo_Escolar_id  and plantel_id =:plantel_actual_id )";
        $solicitud = Yii::app()->db->createCommand($sql);
        $solicitud->bindParam(":plantel_actual_id", $plantel_id, PDO::PARAM_INT);

        $resulSolicitud = $solicitud->queryAll();
        return $resulSolicitud;
    }

    public function registroSolicitud($idEstudiante_pg_array, $gradoIdEstudiante_pg_array, $seccionIDEstudiante_pg_array, $planIdEstudiante_pg_array, $seccionPlantelPeriodoIdEstudiante_pg_array, $estatus_pg_array, $tipoDocumentoId_pg_array, $usuarioIniId_pg_array, $periodoId_pg_array, $estatusSolicitudId_pg_array, $estatusActualId_pg_array, $plantelId_pg_array, $modulo, $ip, $username) {

        $sql = "SELECT titulo.registrar_solicitud($idEstudiante_pg_array, $gradoIdEstudiante_pg_array, $seccionIDEstudiante_pg_array, $planIdEstudiante_pg_array, $seccionPlantelPeriodoIdEstudiante_pg_array, $estatus_pg_array, $tipoDocumentoId_pg_array, $usuarioIniId_pg_array, $periodoId_pg_array, $estatusSolicitudId_pg_array, $estatusActualId_pg_array, $plantelId_pg_array, :modulo, :ip, :username)";

        $solicitud = Yii::app()->db->createCommand($sql);
        $solicitud->bindParam(":modulo", $modulo, PDO::PARAM_INT);
        $solicitud->bindParam(":ip", $ip, PDO::PARAM_INT);
        $solicitud->bindParam(":username", $username, PDO::PARAM_INT);
//        $inscripcionEstudiante->bindParam(":periodo_id", $periodo, PDO::PARAM_INT);
//        $inscripcionEstudiante->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);

        $resultado = $solicitud->execute();
    }

    public function serialesNoAsignados($plantel_id, $a) {

        $estatus_actual_id = 4; // Este estatus es "Asignado al Plantel" de la tabla estatus_titulo.
        $estatus_actual = 3; // Este estatus es "En Ministerio" de la tabla estatus_titulo.



        $sql = "SELECT DISTINCT pm.serial
                                    FROM titulo.titulo t
                                    INNER JOIN titulo.papel_moneda pm ON (pm.plantel_asignado_id = t.plantel_id AND pm.id = t.papel_moneda_id)
                                    WHERE t.estatus_actual_id BETWEEN $estatus_actual AND $estatus_actual_id
                                    AND pm.estatus_actual_id BETWEEN $estatus_actual AND $estatus_actual_id
                                    AND pm.plantel_asignado_id IS NOT NULL
                                    AND t.plantel_id = :plantel_id
                                    ORDER BY pm.serial ASC";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
//            $consulta->bindParam(":estatus_actual_id", $estatus_actual_id, PDO::PARAM_INT);
//            $consulta->bindParam(":estatus_actual", $estatus_actual, PDO::PARAM_INT);
        if ($a == 'N') {
            $resultado = $consulta->queryAll();

            if ($resultado == array()) {
                return false;
            } else {
                return $resultado;
            }
        } elseif ($a == 'S') {

            $resultado = $consulta->queryColumn();
            //  var_dump($resultado);
            if ($resultado == array()) {
                return false;
            } else {
                return $resultado;
            }
        }
    }

    public function datosDirector($plantel_id) {

        $cargo_director = 3;
        $estatus = 'A';
        $sql = "SELECT u.nombre, u.apellido, u.cedula
                            FROM gplantel.autoridad_plantel a
                            INNER JOIN seguridad.usergroups_user u ON (u.id = a.usuario_id)
                            WHERE plantel_id = :plantel_id
                            AND cargo_id = :cargo_director
                            AND estatus = :estatus ";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $consulta->bindParam(":cargo_director", $cargo_director, PDO::PARAM_INT);
        $consulta->bindParam(":estatus", $estatus, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();
        if ($resultado == array()) {
            return false;
        } else {
            return $resultado;
        }
    }

    public function liquidacionSeriales($plantel_id, $serialTotal, $observacionTotal, $liquidacionTotal, $modulo, $ip, $username, $nombre, $apellido, $cedula) {

        $plantel_id = (int) $plantel_id;
        $usuario_id = (int) Yii::app()->user->id;

        $sql = "SELECT titulo.liquidacion_seriales( $plantel_id, $serialTotal, $observacionTotal, $liquidacionTotal, $usuario_id, :modulo, :ip, :username, :nombre, :apellido, $cedula)";

        $atencionSolicitud = Yii::app()->db->createCommand($sql);
        $atencionSolicitud->bindParam(":modulo", $modulo, PDO::PARAM_STR);
        $atencionSolicitud->bindParam(":ip", $ip, PDO::PARAM_STR);
        $atencionSolicitud->bindParam(":username", $username, PDO::PARAM_STR);
        $atencionSolicitud->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $atencionSolicitud->bindParam(":apellido", $apellido, PDO::PARAM_STR);

        $resultado = $atencionSolicitud->execute();
    }

    public function mostrarLiquidacionDeSeriales($plantel_id) {

        $devueltoMinisterio = 6;
//        $hurtado = 7;
//        $extraviado = 8;
//        $inutilizado = 9;
        $anulado = 10;
        $sql = " SELECT pm.serial, est.nombre, pm.observacion
                            FROM titulo.papel_moneda pm
                            INNER JOIN titulo.estatus_titulo est ON (est.id = pm.estatus_actual_id)
                            WHERE pm.plantel_asignado_id = :plantel_id
                            AND pm.estatus_actual_id BETWEEN $devueltoMinisterio AND $anulado";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
        $resultado = $consulta->queryAll();

        if ($resultado == array()) {
            return false;
        } else {
            return $resultado;
        }
    }

    public function solicitudRealizada() {


        $estatus_actual_id = 4; // Este estatus es "Asignado al Plantel" de la tabla estatus_titulo.
        $estatus_actual = 3; // Este estatus es "En Ministerio" de la tabla estatus_titulo.



        $sql = "SELECT DISTINCT pm.serial
                                    FROM titulo.titulo t
                                    INNER JOIN titulo.papel_moneda pm ON (pm.plantel_asignado_id = t.plantel_id AND pm.id = t.papel_moneda_id)
                                    WHERE t.estatus_actual_id BETWEEN $estatus_actual AND $estatus_actual_id
                                    AND pm.estatus_actual_id BETWEEN $estatus_actual AND $estatus_actual_id
                                    AND pm.plantel_asignado_id IS NOT NULL
                                    AND t.plantel_id = :plantel_id
                                    ORDER BY pm.serial ASC";
        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":plantel_id", $plantel_id, PDO::PARAM_INT);
//            $consulta->bindParam(":estatus_actual_id", $estatus_actual_id, PDO::PARAM_INT);
//            $consulta->bindParam(":estatus_actual", $estatus_actual, PDO::PARAM_INT);
        if ($a == 'N') {
            $resultado = $consulta->queryAll();

            if ($resultado == array()) {
                return false;
            } else {
                return $resultado;
            }
        } elseif ($a == 'S') {

            $resultado = $consulta->queryColumn();
            var_dump($resultado);
            if ($resultado == array()) {
                return false;
            } else {
                return $resultado;
            }
        }
    }

    public function cadidatoAsignacionTitulo($plantel_id) {

            $sql = "SELECT DISTINCT e.id AS id_estudiante,e.nombres, e.apellidos, 
                            s.nombre as nombre_seccion, g.nombre as nombre_grado, 
                            e.cedula_identidad,pl.nombre as nombre_plan, m.nombre as nombre_mencion
                            from titulo.titulo t
                            inner join gplantel.plantel p on (p.id = t.plantel_id)
                            inner join matricula.estudiante e on (e.id = t.estudiante_id)
                            inner join  matricula.inscripcion_estudiante ie on (ie.estudiante_id = t.estudiante_id)
                            INNER JOIN gplantel.plan pl ON (pl.id = t.plan_id)
                            LEFT JOIN gplantel.mencion m on (pl.mencion_id = m.id)
                            inner join gplantel.seccion s on (s.id = t.seccion_id)
                            inner join gplantel.grado g on (g.id = t.grado_id)
                            where t.estatus_actual_id <> 5
                            and t.plantel_id =:plantel_actual_id
                            and t.estatus_actual_id = 3 or t.estatus_actual_id = 4";

        $cadidatoTitulo = Yii::app()->db->createCommand($sql);
        $cadidatoTitulo->bindParam(":plantel_actual_id", $plantel_id, PDO::PARAM_INT);
        $cadidatoAsignacionTitulo = $cadidatoTitulo->queryAll();
        
        return $cadidatoAsignacionTitulo;
    }

    public function registrarAsignacionTitulo($cedulaCandidato_pg_array, $serialesAsignarTitulo_pg_array, $plantel_id, $usuarioIniId, $modulo, $ip, $username, $nombreUsuario, $apellidoUsuario, $cedulaUsuario) {

        $sql = "SELECT titulo.registrar_asignacion_titulo($cedulaCandidato_pg_array, $serialesAsignarTitulo_pg_array, $plantel_id, '$usuarioIniId', '$modulo', '$ip', '$username', '$nombreUsuario', '$apellidoUsuario', '$cedulaUsuario')";


        $solicitud = Yii::app()->db->createCommand($sql);
//        echo $sql;
//        die();
        $resultado = $solicitud->execute();
    }

}
