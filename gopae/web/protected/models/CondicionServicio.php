<?php

/**
 * This is the model class for table "gplantel.condicion_servicio".
 *
 * The followings are the available columns in table 'gplantel.condicion_servicio':
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
 * @property Usuario $usuarioAct
 * @property Usuario $usuarioIni
 */
class CondicionServicio extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.condicion_servicio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre', 'required'),
            array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 70),
            array('estatus', 'length', 'max' => 1),
            array('fecha_act, fecha_elim', 'safe'),
            array('nombre', 'filter', 'filter' => 'trim'),
            array('nombre', 'unique'),
            array('nombre', 'match', 'pattern' => '/^[a-záéóóúàèìòùäëïöüñ\s]+$/i', 'message' => 'Se ha encontrado Caracteres inválido intentelo nuevamente.'),
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
            'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
            'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
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
      // $criteria->compare('nombre', $this->nombre, true);
        if (!is_numeric($this->nombre)) {
            $criteria->addSearchCondition('nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');
        }
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
           if ($this->estatus === 'A' || $this->estatus === 'E') {
            $criteria->compare('estatus', $this->estatus);
        }
        $sort = new CSort();
        $sort->defaultOrder = 'nombre ASC, estatus ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort
        ));
    }

    public function getCondServ() {
        $condServ = array();
        $sql = "SELECT id, nombre
                    FROM gplantel.condicion_servicio";
        $connection = $this->getDbConnection();
        $command = $connection->createCommand($sql)->queryAll();

        foreach ($command as $key => $value) {
            $condServ[$value['id']] = array(
                'id' => $value['id'],
                'nombre' => $value['nombre']
            );
        }
        return $condServ;
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->db;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CondicionServicio the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function datosUsuarioAuditoria($usuarioId) {
        if (is_numeric($usuarioId)) {
            $sql = "SELECT nombre, apellido, username FROM seguridad.usergroups_user
                            WHERE seguridad.usergroups_user.id = :usuario";
            $consulta = Yii::app()->db->createCommand($sql);
            $consulta->bindParam(":usuario", $usuarioId, PDO::PARAM_INT);
            $resultado = $consulta->queryAll();

            return $resultado[0];
        } else {
            return 0;
        }
    }

}
