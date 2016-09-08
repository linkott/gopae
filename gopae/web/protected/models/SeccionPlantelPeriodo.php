<?php

/**
 * This is the model class for table "gplantel.seccion_plantel_periodo".
 *
 * The followings are the available columns in table 'gplantel.seccion_plantel_periodo':
 * @property integer $id
 * @property integer $seccion_plantel_id
 * @property integer $periodo_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property AsignaturaDocente[] $asignaturaDocentes
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 * @property SeccionPlantel $seccionPlantel
 * @property PeriodoEscolar $periodo
 */
class SeccionPlantelPeriodo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.seccion_plantel_periodo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('seccion_plantel_id, periodo_id, usuario_ini_id, fecha_ini', 'required'),
            array('seccion_plantel_id, periodo_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('estatus', 'length', 'max' => 1),
            array('fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, seccion_plantel_id, periodo_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'asignaturaDocentes' => array(self::HAS_MANY, 'AsignaturaDocente', 'seccion_plantel_periodo_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            'seccionPlantel' => array(self::BELONGS_TO, 'SeccionPlantel', 'seccion_plantel_id'),
            'periodo' => array(self::BELONGS_TO, 'PeriodoEscolar', 'periodo_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'seccion_plantel_id' => 'SECCION QUE DICTA UN PLANTEL CON ESTO TENEMOS DATOS COMO {SECCION,NIVEL,PLAN,GRADO,TURNO}',
            'periodo_id' => 'HACE REFERENCIA AL PERIODO ESCOLAR',
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
        $criteria->compare('seccion_plantel_id', $this->seccion_plantel_id);
        $criteria->compare('periodo_id', $this->periodo_id);
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

    public function obtenerSeccionPeriodoId($seccion_plantel_id, $periodo_id) {
        if (is_numeric($seccion_plantel_id) && is_numeric($periodo_id)) {
            $sql = "SELECT spp.id"
                    . " FROM "
                    . " gplantel.seccion_plantel_periodo spp"
                    . " WHERE spp.seccion_plantel_id = :seccion_plantel_id AND spp.periodo_id = :periodo_id";

            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":periodo_id", $periodo_id, PDO::PARAM_INT);
            $busqueda->bindParam(":seccion_plantel_id", $seccion_plantel_id, PDO::PARAM_INT);
            $resultadoPeriodo = $busqueda->queryScalar();
            return $resultadoPeriodo;
        } else
            return null;
    }

    public function crearSeccionPlantelPeriodo($seccion_plantel_id, $periodo_id, $estatus = 'A') {
        if (is_numeric($seccion_plantel_id) && is_numeric($periodo_id)) {

            $usuario_ini_id = $usuario_ini_id = Yii::app()->user->id;

            $sql = "INSERT INTO gplantel.seccion_plantel_periodo"
                    . "(seccion_plantel_id, periodo_id, estatus, usuario_ini_id)"
                    . " VALUES "
                    . " (:seccion_plantel_id, :periodo_id, :estatus, :usuario_ini_id)"
                    . " returning id";

            $insert = Yii::app()->db->createCommand($sql);
            $insert->bindParam(":periodo_id", $periodo_id, PDO::PARAM_INT);
            $insert->bindParam(":seccion_plantel_id", $seccion_plantel_id, PDO::PARAM_INT);
            $insert->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $insert->bindParam(":usuario_ini_id", $usuario_ini_id, PDO::PARAM_INT);
            $resultadoInsert = $insert->queryScalar();
            return $resultadoInsert;
        } else
            return null;
    }

    public function consultarSeccionPeriodoId($seccion_plantel_id, $periodo_id) {
        if (is_numeric($seccion_plantel_id) && is_numeric($periodo_id)) {
            $sql = "SELECT spp.id"
                    . " FROM "
                    . " gplantel.seccion_plantel_periodo spp"
                    . " WHERE spp.seccion_plantel_id = :seccion_plantel_id AND spp.periodo_id = :periodo_id";

            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":periodo_id", $periodo_id, PDO::PARAM_INT);
            $busqueda->bindParam(":seccion_plantel_id", $seccion_plantel_id, PDO::PARAM_INT);
            $resultadoPeriodo = $busqueda->queryScalar();
            return $resultadoPeriodo;
        } else
            return null;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeccionPlantelPeriodo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
