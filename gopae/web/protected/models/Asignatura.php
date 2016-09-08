<?php

/**
 * This is the model class for table "gplantel.asignatura".
 *
 * The followings are the available columns in table 'gplantel.asignatura':
 * @property integer $id
 * @property string $nombre
 * @property string $abreviatura

 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Grado $grado
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class Asignatura extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.asignatura';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, abreviatura', 'required', 'message' => 'El campo {attribute} no debe estar vacio'),
            array('nombre', 'unique'),
            array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 180, 'min' => 5),
            array('abreviatura', 'length', 'max' => 8, 'min' => 2),
            array('estatus', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, abreviatura, usuario_ini_id, usuario_act_id, fecha_ini, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
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
            'nombre' => 'Nombre',
            'abreviatura' => 'Abreviatura',
            'usuario_ini_id' => 'Usuario Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_ini' => 'Fecha Ini',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
        );
    }

    public function desactivar($id) {
        $usuario = Yii::app()->user->id;
        $estatus = 'E';

        $sql = "UPDATE gplantel.asignatura"
                . " SET"
                . " usuario_act_id = :usuario_act_id,"
                . " fecha_elim = :fecha_elim,"
                . " estatus = :estatus"
                . " WHERE"
                . " id = :id ";

        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":id", $id, PDO::PARAM_INT);
        $guard->bindParam(":usuario_act_id", $usuario, PDO:: PARAM_INT);
        $guard->bindParam(":fecha_elim", date('Y-m-d H:i:s'), PDO:: PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO:: PARAM_STR);
        $resulatadoGuardo = $guard->execute();
        //var_dump($resulatadoGuardo);die();
        return $resulatadoGuardo;
    }

    public function activar($id) {
        $usuario = Yii::app()->user->id;
        $estatus = 'A';
        $usuario2 = NULL;
        $fecha1 = NULL;
        $fecha2 = NULL;

        $sql = "UPDATE gplantel.asignatura"
                . " SET"
                . " usuario_ini_id = :usuario_ini_id,"
                . " usuario_act_id = :usuario_act_id,"
                . " fecha_act = :fecha_act,"
                . " fecha_elim = :fecha_elim,"
                . " estatus = :estatus"
                . " WHERE"
                . " id = :id ";

        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":id", $id, PDO::PARAM_INT);
        $guard->bindParam(":usuario_ini_id", $usuario, PDO:: PARAM_INT);
        $guard->bindParam(":usuario_act_id", $usuario2, PDO:: PARAM_INT);
        $guard->bindParam(":fecha_act", $fecha1, PDO:: PARAM_INT);
        $guard->bindParam(":fecha_elim", $fecha2, PDO:: PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO:: PARAM_STR);
        $resulatadoGuardo = $guard->execute();
        //var_dump($resulatadoGuardo);die();
        return $resulatadoGuardo;
    }

    public function registrar($nombre, $abrev) {

        $usuario = Yii::app()->user->id;
        $estatus = 'A';

        $sql = "INSERT INTO gplantel.asignatura
                (nombre, abreviatura, usuario_ini_id, estatus)
                VALUES (:nombre, :abreviatura, :usuario_ini_id, :estatus)";

        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $guard->bindParam(":abreviatura", $abrev, PDO:: PARAM_STR);
        $guard->bindParam(":usuario_ini_id", $usuario, PDO:: PARAM_INT);
        $guard->bindParam(":estatus", $estatus, PDO:: PARAM_STR);
        $resulatadoGuardo = $guard->execute();
        //var_dump($resulatadoGuardo);die();
        return $resulatadoGuardo;
    }

    public function actualizar($id, $nombre, $abrev) {

        $usuario = Yii::app()->user->id;
        $sql = "UPDATE gplantel.asignatura"
                . " SET"
                . " nombre = :nombre,"
                . " abreviatura = :abreviatura,"
                . " usuario_act_id = :usuario_act_id,"
                . " fecha_act = :fecha_act"
                . " WHERE"
                . " id = :id ";

        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":id", $id, PDO::PARAM_INT);
        $guard->bindParam(":nombre", $nombre, PDO:: PARAM_STR);
        $guard->bindParam(":abreviatura", $abrev, PDO:: PARAM_STR);
        $guard->bindParam(":usuario_act_id", $usuario, PDO:: PARAM_INT);
        $guard->bindParam(":fecha_act", date('Y-m-d H:i:s'), PDO:: PARAM_INT);
        $resulatadoGuardo = $guard->execute();
        //var_dump($resulatadoGuardo);die();
        return $resulatadoGuardo;
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
    public function view($id) {

        $model = null;
        if (is_numeric($id)) {
            $criteria = new CDbCriteria();
            $criteria->alias = "g";
            $criteria->with = array(
                "usuarioIni" => array("select" => "id, nombre, apellido, username, cedula"),
                "usuarioAct" => array("select" => "id, nombre, apellido, username, cedula"),
            );
            $criteria->addCondition("g.id = :id");
            $criteria->params = array('id' => $id);
            $model = $this->find($criteria);
        }
        return $model;
    }

    public function getAsignaturas($ids = array()) {
        $asignaturas = array();

        $sql = "SELECT id, nombre
                FROM gplantel.asignatura";
        
        if ($ids != array() AND $ids !== null) {

            $ids = implode(',', $ids);

            $sql .= " WHERE id NOT IN ($ids) ORDER BY nombre ASC";
        } else {
            $sql .= " ORDER BY nombre ASC";
        }

        $connection = $this->getDbConnection();
        $command = $connection->createCommand($sql)->queryAll();

        foreach ($command as $key => $value) {

            $asignaturas[$value['id']] = array(
                'id' => $value['id'],
                'nombre' => $value['nombre']
            );
        }

        return $asignaturas;
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->addSearchCondition('t.nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');
        $criteria->addSearchCondition('abreviatura', '%' . $this->abreviatura . '%', false, 'AND', 'ILIKE');
        //$criteria->compare('abreviatura',$this->abreviatura,true);
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
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
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Asignatura the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
