<?php

/**
 * This is the model class for table "gplantel.condicion_estudio".
 *
 * The followings are the available columns in table 'gplantel.condicion_estudio':
 * @property integer $id
 * @property string $nombre
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Plantel[] $plantels
 * @property Usuario $usuarioAct
 * @property Usuario $usuarioIni
 */
class CondicionEstudio extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.condicion_estudio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, usuario_ini_id, fecha_ini, estatus', 'required'),
            array('nombre', 'unique'),
            array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 25),
            array('estatus', 'length', 'max' => 1),
            array('fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'plantels' => array(self::HAS_MANY, 'Plantel', 'condicion_estudio_id'),
            'usuarioAct' => array(self::BELONGS_TO, 'UserGroupsUser', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'UserGroupsUser', 'usuario_ini_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
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
        $criteria->compare('nombre', strtoupper($this->nombre), true);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus, true);
        $sort = new CSort();
        $sort->defaultOrder = 'nombre ASC, estatus ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->db;
    }
/**
 * Función que permite visualizar aqellos usuarios que crearon alguna condición de estudio con su respectiva fecha.
 * @param int
 * @return string
 * @author Richard Massri
 */
    public function buscar($id) {
        $sql = "SELECT m.nombre, m.estatus, m.fecha_ini,m.fecha_act, m.fecha_elim, u.nombre as nombre_usuario  FROM gplantel.condicion_estudio m
        LEFT JOIN seguridad.usergroups_user u ON u.id = m.usuario_ini_id
        WHERE m.id = " . $id;
        $consulta = Yii::app()->db->createCommand($sql);
        $resultado = $consulta->queryAll();
        return $resultado;
    }
/**
 *
 * @param  int
 * @return string
 * @author Richard Massri
 */
    public function buscar2($id) {
        $sql2 = "SELECT  m.nombre, m.estatus, m.fecha_ini,m.fecha_act, m.fecha_elim, u.nombre as nombre_usuario  FROM gplantel.condicion_estudio m
        LEFT JOIN seguridad.usergroups_user u ON u.id = m.usuario_act_id
        WHERE m.id = " . $id;
        $consulta2 = Yii::app()->db->createCommand($sql2);
        $resultado2 = $consulta2->queryAll();
        return $resultado2;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CondicionEstudio the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
