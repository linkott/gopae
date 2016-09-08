<?php

/**
 * This is the model class for table "matricula.asignatura_estudiante".
 *
 * The followings are the available columns in table 'matricula.asignatura_estudiante':
 * @property integer $id
 * @property integer $inscripcion_id
 * @property integer $asignatura_id
 * @property string $tipo_inscripcion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property CalificacionAsignaturaEstudiante[] $calificacionAsignaturaEstudiantes
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property InscripcionEstudiante $inscripcion
 * @property Asignatura $asignatura
 */
class AsignaturaEstudiante extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'matricula.asignatura_estudiante';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('inscripcion_id, asignatura_id, tipo_inscripcion, usuario_ini_id, fecha_ini', 'required'),
            array('inscripcion_id, asignatura_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('tipo_inscripcion, estatus', 'length', 'max' => 1),
            array('fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, inscripcion_id, asignatura_id, tipo_inscripcion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'calificacionAsignaturaEstudiantes' => array(self::HAS_MANY, 'CalificacionAsignaturaEstudiante', 'asignatura_estudiante_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'inscripcion' => array(self::BELONGS_TO, 'InscripcionEstudiante', 'inscripcion_id'),
            'asignatura' => array(self::BELONGS_TO, 'Asignatura', 'asignatura_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'inscripcion_id' => 'HACE REFERENCIA A LA INSCRIPCION DEL ESTUDIANTE',
            'asignatura_id' => 'Asignatura',
            'tipo_inscripcion' => 'INDICA SI LA MATERIA INSCRITA ES REPITIENTE;INSCRIPCION REGULAR; MATERIA PENDIENTE',
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
        $criteria->compare('inscripcion_id', $this->inscripcion_id);
        $criteria->compare('asignatura_id', $this->asignatura_id);
        $criteria->compare('tipo_inscripcion', $this->tipo_inscripcion, true);
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

    public function inactivarAsignaturaEstudiante($inscripcion_id) {
        $resultado = null;
        if (is_numeric($inscripcion_id)) {
            $sql = "SELECT count(inscripcion_id) FROM matricula.asignatura_estudiante"
                    . " WHERE inscripcion_id = :inscripcion_id";
            $contabilizar = Yii::app()->db->createCommand($sql);
            $contabilizar->bindParam(":inscripcion_id", $inscripcion_id, PDO::PARAM_INT);
            $resultadoContabilizar = $contabilizar->queryScalar();
            if ($resultadoContabilizar > 0) {
                $sql = "UPDATE matricula.asignatura_estudiante"
                        . " SET estatus = 'E'"
                        . " WHERE inscripcion_id = :inscripcion_id";
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
     * @return AsignaturaEstudiante the static model class
     */
    public function obtenerAsignaturasEstudiante($id_inscripcion_estudiante) {
        /* Modificar para que traiga datos requeridos del estudiante */
        $estatus = 'A';
        $sql = "SELECT ae.id, a.nombre , ae.estatus"
                . " FROM"
                . " matricula.asignatura_estudiante ae"
                . " INNER JOIN gplantel.asignatura a on (a.id = ae.asignatura_id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (ae.inscripcion_id = ie.id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " WHERE ie.id = :id_inscripcion_estudiante"
                . " AND ie.estatus= :estatus"
                . " ORDER BY a.nombre ASC";

        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":id_inscripcion_estudiante", $id_inscripcion_estudiante, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $resultado = $buqueda->queryAll();

        return $resultado;
    }

    public function obtenerAsignaturasEstudianteGrid($id_inscripcion_estudiante, $lapsoEncoded) {
        /* Modificar para que traiga datos requeridos del estudiante */
        $estatus = 'A';
        $lapso = base64_decode($lapsoEncoded);
        $sql = "SELECT ae.id, a.nombre , ae.estatus, cae.calif_cuantitativa, cae.asistencia, cae.observacion"
                . " FROM"
                . " matricula.asignatura_estudiante ae"
                . " INNER JOIN gplantel.asignatura a on (a.id = ae.asignatura_id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (ae.inscripcion_id = ie.id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " LEFT JOIN matricula.calificacion_asignatura_estudiante cae on (ae.id = cae.asignatura_estudiante_id AND cae.lapso=:lapso )"
                . " WHERE ie.id = :id_inscripcion_estudiante"
                . " AND ie.estatus= :estatus"
                . " ORDER BY a.nombre ASC";

        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":id_inscripcion_estudiante", $id_inscripcion_estudiante, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $buqueda->bindParam(":lapso", $lapso, PDO::PARAM_STR);
        $resultado = $buqueda->queryAll();

        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 200)
        ));
    }

    public function obtenerAsignaturasEstudianteAdultosGrid($id_inscripcion_estudiante, $lapsoEncoded) {
        /* Modificar para que traiga datos requeridos del estudiante */
        $estatus = 'A';
        $lapso = base64_decode($lapsoEncoded);
        $sql = "SELECT ae.id, a.nombre , ae.estatus, cae.calif_cuantitativa, cae.asistencia, cae.observacion"
                . " FROM"
                . " matricula.asignatura_estudiante ae"
                . " INNER JOIN gplantel.asignatura a on (a.id = ae.asignatura_id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (ae.inscripcion_id = ie.id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " LEFT JOIN matricula.calificacion_asignatura_estudiante cae on (ae.id = cae.asignatura_estudiante_id AND cae.lapso=:lapso )"
                . " WHERE ie.id = :id_inscripcion_estudiante"
                . " AND ie.estatus= :estatus"
                // . " AND = :estatus"
                . " ORDER BY a.nombre ASC";

        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":id_inscripcion_estudiante", $id_inscripcion_estudiante, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $buqueda->bindParam(":lapso", $lapso, PDO::PARAM_STR);
        $resultado = $buqueda->queryAll();

        return new CArrayDataProvider($resultado, array(
            'pagination' => array(
                'pageSize' => 200)
        ));
    }

    public function obtenerCantidadAsignaturasCalificadas($id_inscripcion_estudiante, $lapsoEncoded) {
        /* Modificar para que traiga datos requeridos del estudiante */
        $estatus = 'A';
        $lapso = base64_decode($lapsoEncoded);
        $sql = "SELECT count(cae.id)"
                . " FROM"
                . " matricula.asignatura_estudiante ae"
                . " INNER JOIN gplantel.asignatura a on (a.id = ae.asignatura_id)"
                . " INNER JOIN matricula.inscripcion_estudiante ie on (ae.inscripcion_id = ie.id)"
                . " INNER JOIN matricula.estudiante e on (e.id = ie.estudiante_id)"
                . " INNER JOIN matricula.calificacion_asignatura_estudiante cae on (ae.id = cae.asignatura_estudiante_id AND cae.lapso=:lapso )"
                . " WHERE ie.id = :id_inscripcion_estudiante"
                . " AND ie.estatus= :estatus";


        $buqueda = Yii::app()->db->createCommand($sql);
        $buqueda->bindParam(":id_inscripcion_estudiante", $id_inscripcion_estudiante, PDO::PARAM_INT);
        $buqueda->bindParam(":estatus", $estatus, PDO::PARAM_STR);
        $buqueda->bindParam(":lapso", $lapso, PDO::PARAM_STR);
        $resultado = $buqueda->queryAll();

        return $resultado;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
