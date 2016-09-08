<?php

/**
 * This is the model class for table "gplantel.fundamento_juridico".
 *
 * The followings are the available columns in table 'gplantel.fundamento_juridico':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $fecha_emision
 * @property integer $tipo_fundamento_id
 * @property integer $usuario_ini_id
 * @property integer $usuario_act_id
 * @property string $fecha_ini
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property FundamentoJuridico $tipoFundamento
 * @property FundamentoJuridico[] $fundamentoJuridicos
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class FundamentoJuridico extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gplantel.fundamento_juridico';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tipo_fundamento_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            //array('descripcion', 'length', 'max'=>160),
            array('nombre', 'length', 'max' => 160),
            array('nombre', 'required'),
            array('nombre', 'unique'),
            array('tipo_fundamento_id', 'required'),
            array('fecha_emision', 'required'),
            array('tipo_fundamento_id', 'required'),
            array('estatus', 'length', 'max' => 1),
            array('fecha_emision, fecha_ini, fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, descripcion, fecha_emision, tipo_fundamento_id, usuario_ini_id, usuario_act_id, fecha_ini, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tipoFundamento' => array(self::BELONGS_TO, 'TipoFundamento', 'tipo_fundamento_id'),
            //'fundamentoJuridicos' => array(self::HAS_MANY, 'FundamentoJuridico', 'tipo_fundamento_id'),
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
            'descripcion' => 'Descripcion',
            'fecha_emision' => 'Fecha Emision',
            'tipo_fundamento_id' => 'Tipo Fundamento',
            'usuario_ini_id' => 'Usuario Ini',
            'usuario_act_id' => 'Usuario Act',
            'fecha_ini' => 'Fecha Ini',
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

        if (strlen($this->fecha_emision) > 0) {

            $this->fecha_emision = date("d-m-Y", strtotime($this->fecha_emision));
            $criteria->compare('fecha_emision', date("Y-m-d", strtotime($this->fecha_emision)));
        } else {
            $this->fecha_emision = "";
        }


        if (is_numeric($this->tipo_fundamento_id)) {

            $criteria->compare('tipo_fundamento_id', $this->tipo_fundamento_id);
        } else {
            $this->tipo_fundamento_id = "";
        }


        $criteria->compare('id', $this->id);
        $criteria->compare('nombre', strtoupper($this->nombre), true);
        $criteria->compare('descripcion', $this->descripcion, true);
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
     * @param array $ids arreglo unidimensional con lo(s) id(s) de lo(s) fundamento(s) juridico(s) que no quiere retornar.
     * @return array Retorna un arreglo con los id y nombre de lo(s) fundamento(s) juridico(s)
     */
    public function getFundamentosJuridicos($ids = array()) {
        $fundamento_juridico = array();
        $sql = "SELECT id, nombre 
                FROM gplantel.fundamento_juridico
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
            $fundamento_juridico[$value['id']] = array(
                'id' => $value['id'],
                'nombre' => $value['nombre']
            );
        }
        return $fundamento_juridico;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FundamentoJuridico the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
