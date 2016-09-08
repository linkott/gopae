<?php

/**
 * This is the model class for table "matricula.inscripcion_estudiante".
 *
 * The followings are the available columns in table 'matricula.inscripcion_estudiante':
 * @property integer $id
 * @property integer $seccion_plantel_periodo_id
 * @property integer $estudiante_id
 * @property string $resumen_evaluativo
 * @property integer $inscripcion_regular
 * @property integer $repitiente
 * @property integer $repitiente_completo
 * @property integer $materia_pendiente
 * @property integer $diferido
 * @property integer $doble_inscripcion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property AsignaturaEstudiante[] $asignaturaEstudiantes
 * @property EvaluacionGeneralEstudiante[] $evaluacionGeneralEstudiantes
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property Estudiante $estudiante
 * @property SeccionPlantelPeriodo $seccionPlantelPeriodo
 */
class InscripcionEstudiante extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'matricula.inscripcion_estudiante';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('seccion_plantel_periodo_id, estudiante_id, usuario_ini_id, fecha_ini', 'required'),
            array('seccion_plantel_periodo_id, estudiante_id, inscripcion_regular, repitiente, repitiente_completo, materia_pendiente, diferido, doble_inscripcion, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('estatus', 'length', 'max' => 1),
            array('resumen_evaluativo, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, seccion_plantel_periodo_id, estudiante_id, resumen_evaluativo, inscripcion_regular, repitiente, repitiente_completo, materia_pendiente, diferido, doble_inscripcion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'asignaturaEstudiantes' => array(self::HAS_MANY, 'AsignaturaEstudiante', 'inscripcion_id'),
            'evaluacionGeneralEstudiantes' => array(self::HAS_MANY, 'EvaluacionGeneralEstudiante', 'inscripcion_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'estudiante' => array(self::BELONGS_TO, 'Estudiante', 'estudiante_id'),
            'seccionPlantelPeriodo' => array(self::BELONGS_TO, 'SeccionPlantelPeriodo', 'seccion_plantel_periodo_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'seccion_plantel_periodo_id' => 'HACE REFERENCIA AL PERIODO ESCOLAR',
            'estudiante_id' => 'HACE REFERENCIA AL ESTUDIANTE',
            'resumen_evaluativo' => 'RESUMEN EVALUATIVO DEL ESTUDIANTE INSCRITO EN LA SECCION',
            'inscripcion_regular' => 'INDICA SI LA INSCRIPCION ES REGULAR {SI -> 1; NO -> 0}',
            'repitiente' => 'INDICA SI EL ESTUDIANTE ES REPITIENTE CON UNA O MAS MATERIAS {SI -> 1; NO -> 0}',
            'repitiente_completo' => 'INDICA SI EL ESTUDIANTE ES REPITIENTE CON TODAS LAS MATERIAS {SI -> 1; NO -> 0}',
            'materia_pendiente' => 'INDICA SI EL ESTUDIANTE TIENE UNA O DOS MATERIAS PENDIENTE DEL GRADO ANTERIOR {SI -> 1; NO -> 0}',
            'diferido' => ' {SI -> 1; NO -> 0}',
            'doble_inscripcion' => 'INDICA SI EL ESTUDIANTE ESTA CURSANDO 2 PLANES DE ESTUDIOS SIMULTANEAMENTE {SI -> 1; NO -> 0}',
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
        $criteria->compare('seccion_plantel_periodo_id', $this->seccion_plantel_periodo_id);
        $criteria->compare('estudiante_id', $this->estudiante_id);
        $criteria->compare('resumen_evaluativo', $this->resumen_evaluativo, true);
        $criteria->compare('inscripcion_regular', $this->inscripcion_regular);
        $criteria->compare('repitiente', $this->repitiente);
        $criteria->compare('repitiente_completo', $this->repitiente_completo);
        $criteria->compare('materia_pendiente', $this->materia_pendiente);
        $criteria->compare('diferido', $this->diferido);
        $criteria->compare('doble_inscripcion', $this->doble_inscripcion);
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

    public function inactivarInscripcionEstudiante($inscripcion_id) {
        $resultado = null;
        if (is_numeric($inscripcion_id)) {
            $sql = "SELECT count(id) FROM matricula.inscripcion_estudiante"
                    . " WHERE id = :inscripcion_id";
            $contabilizar = Yii::app()->db->createCommand($sql);
            $contabilizar->bindParam(":inscripcion_id", $inscripcion_id, PDO::PARAM_INT);
            $resultadoContabilizar = $contabilizar->queryScalar();
            if ($resultadoContabilizar > 0) {
                $sql = "UPDATE matricula.inscripcion_estudiante"
                        . " SET estatus = 'E'"
                        . " WHERE id = :inscripcion_id";
                $buqueda = Yii::app()->db->createCommand($sql);
                $buqueda->bindParam(":inscripcion_id", $inscripcion_id, PDO::PARAM_INT);
                $resultado = $buqueda->execute();
            } else
                return true;
        }
        return $resultado;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InscripcionEstudiante the static model class
     */
    public function InscritosPorSeccion($seccionId) {
        /* Modificar para que traiga la cedula escolar o pasaporte o cedula */
        $estatus = 'A';
        $sql = "SELECT  e.id,COALESCE(e.cedula_identidad, e.cedula_escolar ) as cedula_escolar, e.fecha_nacimiento, e.nombres || ' ' || e.apellidos as nomApe, r.cedula_identidad, ie.id as id_inscripcion, ie.materia_pendiente, p.modalidad_id as modalidad"
                . " FROM"
                . " gplantel.seccion_plantel sp"
                . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.seccion_plantel_id = sp.id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (spp.id = ie.seccion_plantel_periodo_id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " INNER JOIN gplantel.plantel p on (p.id = sp.plantel_id)"
                . " LEFT JOIN matricula.representante r on (r.id = e.representante_id)"
                . " WHERE spp.seccion_plantel_id = :seccion_plantel_id"
                . " AND ie.estatus= :estatus"
                . " ORDER BY ie.id DESC";
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":seccion_plantel_id", $seccionId, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $resultado = $buqueda->queryAll();
        //   var_dump($resultado); die();


        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 15,
            )
        ));
    }

    public function InscritosPorSeccionDocente($seccionId, $lapsoEncoded) {
        /* Modificar para que traiga la cedula escolar o pasaporte o cedula */
        $lapso = base64_decode($lapsoEncoded);
        $estatus = 'A';
        $sql = "SELECT DISTINCT e.id,COALESCE(e.cedula_identidad, e.cedula_escolar ) as cedula_escolar, e.fecha_nacimiento, e.nombres || ' ' || e.apellidos as nomApe, ie.id as id_inscripcion, ie.materia_pendiente, p.modalidad_id as modalidad, cae.calif_cuantitativa, cae.asistencia, cae.observacion"
                . " FROM"
                . " gplantel.seccion_plantel sp"
                . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.seccion_plantel_id = sp.id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (spp.id = ie.seccion_plantel_periodo_id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " INNER JOIN gplantel.plantel p on (p.id = sp.plantel_id)"
                . " INNER JOIN matricula.asignatura_estudiante ae on (ae.inscripcion_id = ie.id)"
                . " LEFT JOIN matricula.calificacion_asignatura_estudiante cae on (ae.id = cae.asignatura_estudiante_id AND cae.lapso=:lapso )"
                . " WHERE spp.seccion_plantel_id = :seccion_plantel_id"
                . " AND ie.estatus= :estatus"
                . " ORDER BY ie.id DESC";
        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":seccion_plantel_id", $seccionId, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $buqueda->bindParam(":lapso", $lapso, PDO::PARAM_STR);
        $resultado = $buqueda->queryAll();
        //   var_dump($resultado); die();


        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 999999999999999,
            )
        ));
    }

    public function buscarInscrito($id_inscripcion_estudiante) {

        /* Modificar para que traiga datos requeridos del estudiante */
        $estatus = 'A';
        $sql = "SELECT  e.id,COALESCE(e.cedula_identidad, e.cedula_escolar ) as documento, e.fecha_nacimiento, e.nombres || ' ' || e.apellidos as nomApe, r.cedula_identidad, ie.id as id_inscripcion, ie.materia_pendiente, p.modalidad_id as modalidad, p.id as plantel, sp.id as seccion, sp.grado_id"
                . " FROM"
                . " matricula.inscripcion_estudiante ie"
                . " INNER JOIN gplantel.seccion_plantel_periodo spp on (spp.id = ie.seccion_plantel_periodo_id)"
                . " INNER JOIN gplantel.seccion_plantel sp on (sp.id = spp.seccion_plantel_id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " INNER JOIN gplantel.plantel p on (p.id = sp.plantel_id)"
                . " LEFT JOIN matricula.representante r on (r.id = e.representante_id)"
                . " WHERE ie.id = :id_inscripcion_estudiante"
                . " AND ie.estatus= :estatus";

        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":id_inscripcion_estudiante", $id_inscripcion_estudiante, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $resultado = $buqueda->queryAll();

        return $resultado;

//        return new CArrayDataProvider($resultado, array(
//            'pagination' => array(
//                'pageSize' => 1,
//            )
//        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
