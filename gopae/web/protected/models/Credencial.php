<?php

/**
 * This is the model class for table "gplantel.credencial".
 *
 * The followings are the available columns in table 'gplantel.credencial':
 * @property integer $id
 * @property string $nombre
 * @property integer $usuario_ini_id

 * @property string $fecha_ini
 * @property integer $usuario_act_id

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
class Credencial extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.credencial';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre', 'required', 'message' => 'El campo {attribute} no debe estar vacio'),
            array('nombre', 'unique', 'message' => 'Este {attribute} ya ha sido registrado anteriormente'),
            array('nombre', 'length', 'max' => 80, 'min' => 4),
            array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('estatus', 'length', 'max' => 1),
            array('nombre, fecha_ini, fecha_act, fecha_elim', 'safe'),
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

    /**
     * @param array $ids arreglo unidimensional con lo(s) id(s) de la(s) credencial(es) que no quiere retornar.
     * @return array Returna un arreglo con los id y nombre de la(s) credencial(es)
     */
    public function getCredenciales($ids = array()) {
        $credenciales = array();
        $sql = "SELECT id, nombre 
                FROM gplantel.credencial
                ";
        if ($ids !== array()) {
            $ids = implode(',', $ids);
            $sql .= " WHERE id NOT IN ($ids) ORDER BY nombre ASC";
        } else {
            $sql .=" ORDER BY nombre ASC";
        }
        $connection = $this->getDbConnection();
        $command = $connection->createCommand($sql)->queryAll();

        foreach ($command as $key => $value) {
            $credenciales[$value['id']] = array(
                'id' => $value['id'],
                'nombre' => $value['nombre']
            );
        }
        return $credenciales;
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;


        if (is_numeric($this->id)) {
            if (strlen($this->id) < 10) {
                $criteria->compare('id', $this->id);
            }
        }
        //$criteria->compare('id',$this->id);
        //$criteria->compare('nombre', strtoupper($this->nombre));
        $criteria->addSearchCondition('t.nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');
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
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Credencial the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
