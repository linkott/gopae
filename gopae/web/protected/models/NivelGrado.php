<?php

/**
 * This is the model class for table "gplantel.nivel_grado".
 *
 * The followings are the available columns in table 'gplantel.nivel_grado':
 * @property integer $id
 * @property integer $nivel_id
 * @property integer $grado_id
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Grado $grado
 * @property Nivel $nivel
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class NivelGrado extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.nivel_grado';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nivel_id, grado_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('fecha_ini, fecha_act, fecha_elim', 'length', 'max' => 6),
            array('estatus', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nivel_id, grado_id, usuario_ini_id, usuario_act_id, fecha_ini, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'grado' => array(self::BELONGS_TO, 'Grado', 'grado_id'),
            'nivel' => array(self::BELONGS_TO, 'Nivel', 'nivel_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nivel_id' => 'Nivel',
            'grado_id' => 'Grado',
            'usuario_ini_id' => 'Usuario Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_ini' => 'Fecha Ini',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
        );
    }

    public function getGradosNivel($nivel_id) {

        $sql = "SELECT g.id, g.nombre"
                . " FROM gplantel.grado g"
                . " INNER JOIN gplantel.nivel_grado n_g ON (g.id = n_g.grado_id)"
                . " WHERE n_g.nivel_id = :nivel_id"
                . " ORDER BY g.consecutivo ASC";

        $consulta = Yii::app()->db->createCommand($sql);
        $consulta->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);


        return $resultado = $consulta->queryAll();
    }

    public function getGrados($grado_id, $nivel_id) {
        $nivel_id_casted = (int) $nivel_id;
        $grado_id_casted = (int) $grado_id;
        $sql = "SELECT g.id, g.nombre"
                . " FROM gplantel.grado g"
                . " INNER JOIN gplantel.nivel_grado n_g ON (g.id = n_g.grado_id)"
                . " WHERE "
                . " n_g.nivel_id = :nivel_id"
                . " AND g.consecutivo < ("
                . "                     SELECT consecutivo "
                . "                         FROM gplantel.grado g"
                . "                         INNER JOIN gplantel.nivel_grado n_g ON (g.id = n_g.grado_id)"
                . "                         WHERE "
                . "                         n_g.nivel_id = :nivel_id AND  n_g.grado_id = :grado_id"
                . "                      )"
                . " ORDER BY g.consecutivo ASC";

        $connection = $this->getDbConnection();
        $command = $connection->createCommand($sql);
        $command->bindParam(":nivel_id", $nivel_id_casted, PDO::PARAM_INT);
        $command->bindParam(":grado_id", $grado_id_casted, PDO::PARAM_INT);
        return $command->queryAll();
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
        $criteria->compare('nivel_id', $this->nivel_id);
        $criteria->compare('grado_id', $this->grado_id);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NivelGrado the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
