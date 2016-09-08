<?php

/**
 * This is the model class for table "gplantel.modalidad".
 *
 * The followings are the available columns in table 'gplantel.modalidad':
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
 * @property Nivel[] $nivels
 * @property Usuario $usuarioAct
 * @property Usuario $usuarioIni
 */
class Modalidad extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.modalidad';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('usuario_ini_id, fecha_ini', 'required'),
            array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'required'),
            array('nombre', 'unique'),
            array('nombre', 'length', 'max' => 160),
            array('nombre', 'length', 'min' => 3),
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
            'plantels' => array(self::HAS_MANY, 'Plantel', 'modalidad_id'),
            'nivels' => array(self::HAS_MANY, 'ModalidadNivel', 'modalidad_id'),
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
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => 15,
            )
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->db;
    }

    public function dropNivel($id) {
        //$id=base64_decode($id);	

        $sql = "DELETE FROM gplantel.modalidad_nivel where id=:id ";

        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":id", $id, PDO::PARAM_INT);
        $guardoNivel = $guard->execute();
    }

    public function registroNivel($modalidad_id, $nivel_id, $user_id) {

        $estatus = "A";
        $modalidad_id = base64_decode($modalidad_id);

        $sql = "SELECT * from gplantel.modalidad_nivel m
				WHERE m.modalidad_id=:modalidad_id AND
				m.nivel_id=:nivel_id";

        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":modalidad_id", $modalidad_id, PDO::PARAM_INT);
        $guard->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);
        $consulto = $guard->queryAll();
        if ($consulto == null) {




            $sql = "INSERT INTO gplantel.modalidad_nivel
               (modalidad_id, nivel_id, usuario_ini_id, estatus)
               VALUES (:modalidad_id, :nivel_id, :usuario_ini_id, :estatus)";

            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":modalidad_id", $modalidad_id, PDO::PARAM_INT);
            $guard->bindParam(":usuario_ini_id", $user_id, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);
            $guardoNivel = $guard->execute();
        } else if ($consulto != null) {
            
        }
    }

    public function obtenerNiveles($modalidad_id, $user_id) {
        $modalidad_id = base64_decode($modalidad_id);

        $sql = "SELECT n.nombre, mn.id,mn.modalidad_id FROM gplantel.modalidad_nivel mn
        		INNER JOIN gplantel.modalidad m on mn.modalidad_id=m.id 
        		INNER JOIN gplantel.nivel n on n.id=mn.nivel_id
        		WHERE m.id=:modalidad_id AND n.estatus='A' order by mn.id DESC";


        $resultado = Yii::app()->db->createCommand($sql);
        $resultado->bindParam(":modalidad_id", $modalidad_id, PDO::PARAM_INT);
        $result = $resultado->queryAll();

        return $result;
    }

    /**
     * @param array $ids arreglo unidimensional con lo(s) id(s) de la(s) modalidad(es) que no quiere retornar.
     * @return array Returna un arreglo con los id y nombre de la(s) modalidad(es)
     */
    public function getModalidades($ids = array()) {
        $modalidades = array();
        $sql = "SELECT id, nombre 
                FROM gplantel.modalidad
                ";
        if ($ids !== array()) {
            $ids = implode(',', $ids);
            $sql .= " WHERE id NOT IN ($ids) ORDER BY nombre ASC";
        }
        $connection = $this->getDbConnection();
        $command = $connection->createCommand($sql)->queryAll();

        foreach ($command as $key => $value) {
            $modalidades[$value['id']] = array(
                'id' => $value['id'],
                'nombre' => $value['nombre']
            );
        }
        return $modalidades;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Modalidad the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
