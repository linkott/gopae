<?php

/**
 * This is the model class for table "gplantel.grado".
 *
 * The followings are the available columns in table 'gplantel.grado':
 * @property integer $id
 * @property string $nombre
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus

 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni

 */
class Grado extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.grado';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre', 'required'),
            array('nombre', 'unique'),
            array('nombre', 'required', 'on' => 'crear', 'message' => 'El campo {attribute} no debe estar vacio'),
            array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 80, 'min' => 4),
            //array('fecha_ini, fecha_act, fecha_elim', 'length', 'max'=>6),
            array('estatus', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, usuario_ini_id, usuario_act_id, fecha_ini, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
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

    public function getDatosGrado($grado_id) {
        if (is_numeric($grado_id)) {

            $sql = "SELECT upper(nombre) as nombre FROM gplantel.grado"
                    . " WHERE id = :grado_id";

            $connection = $this->getDbConnection();

            $command = $connection->createCommand($sql);

            $command->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);

            $resultado = $command->queryScalar();


            if ($resultado !== false)
                return $resultado;
            else
                return null;
        } else
            return null;
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'usuario_ini_id' => 'Usuario Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_ini' => 'Fecha Ini',
            'fecha_act' => 'Fecha Act',
            'fecha_elim' => 'Fecha Elim',
            'estatus' => 'Estatus',
            'plan_id' => 'Plan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * Initialize the model fields with values from filter form.
     * Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        if (is_numeric($this->id)) {
            if (strlen($this->id) < 10) {
                $criteria->compare('id', $this->id);
            }
        }

        //$criteria->compare('id',$this->id);
        $criteria->addSearchCondition('nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');
        $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        $criteria->compare('usuario_act_id', $this->usuario_act_id);
        $criteria->compare('fecha_ini', $this->fecha_ini, true);
        $criteria->compare('fecha_act', $this->fecha_act, true);
        $criteria->compare('fecha_elim', $this->fecha_elim, true);
        $criteria->compare('estatus', $this->estatus);
        $sort = new CSort();
        $sort->defaultOrder = 'nombre ASC, estatus ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort
        ));
    }

    public function registroGrado($nivel_id, $grado_id, $user_id) {

        $estatus = "A";
        $nivel_id = base64_decode($nivel_id);
        if (is_numeric($nivel_id)) {
            $sql = "SELECT * from gplantel.nivel_grado n
                                    WHERE n.nivel_id = :nivel_id AND
                                    n.grado_id = :grado_id";

            $guard = Yii::app()->db->createCommand($sql);
            $guard->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);
            $guard->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
            $consulto = $guard->queryAll();
            if ($consulto == null) {
                $sql = "INSERT INTO gplantel.nivel_grado
                   (nivel_id, grado_id, usuario_ini_id, estatus)
                   VALUES (:nivel_id, :grado_id, :usuario_ini_id, :estatus)";

                $guard = Yii::app()->db->createCommand($sql);
                $guard->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);
                $guard->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
                $guard->bindParam(":usuario_ini_id", $user_id, PDO::PARAM_INT);
                $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
                $guardoGrado = $guard->execute();
                return $guardoGrado;
            } else if ($consulto != null) {
                return false;
            }
        }
    }

    public function obtenerGrado($nivel_id, $user_id) {
        $nivel_id = base64_decode($nivel_id);

        $sql = "SELECT n.nombre, ng.id,ng.nivel_id FROM
                    gplantel.nivel_grado ng
                    INNER JOIN gplantel.nivel m on ng.nivel_id=m.id 
                    INNER JOIN gplantel.grado n on n.id=ng.grado_id
                    WHERE m.id=:nivel_id order by ng.id DESC";
        $resultado = Yii::app()->db->createCommand($sql);
        $resultado->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);
        $result = $resultado->queryAll();

        return $result;
    }

    public function eliminarGrado($id) {
        $sql = "DELETE FROM gplantel.nivel_grado WHERE id=:id ";
        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":id", $id, PDO::PARAM_INT);
        $resultado = $guard->execute();
        return $resultado;
    }

    public function obtenerUltimoGradoNivel($nivel_id, $grado_id) {
        $sql = "select g.id "
                . " from gplantel.grado  g "
                . " inner join gplantel.nivel_grado ng on (ng.grado_id = g.id) "
                . " inner join gplantel.nivel n on (n.id = ng.nivel_id) "
                . " where n.id = :nivel_id  and g.id = :grado_id and g.es_final = 1";
        $busqueda = Yii::app()->db->createCommand($sql);

        $busqueda->bindParam(":nivel_id", $nivel_id, PDO::PARAM_INT);
        $busqueda->bindParam(":grado_id", $grado_id, PDO::PARAM_INT);
        $resultado = $busqueda->queryScalar();
        return $resultado;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Grado the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
