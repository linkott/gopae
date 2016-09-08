<?php

/**
 * This is the model class for table "administrativo.tipo_cuenta_banco".
 *
 * The followings are the available columns in table 'administrativo.tipo_cuenta_banco':
 * @property integer $id
 * @property integer $banco_id
 * @property integer $tipo_cuenta_id
 * @property string $identificador
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property TipoCuenta $tipoCuenta
 * @property Banco $banco
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class TipoCuentaBanco extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'administrativo.tipo_cuenta_banco';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('banco_id, tipo_cuenta_id, usuario_ini_id, fecha_ini', 'required'),
            array('banco_id, tipo_cuenta_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly' => true),
            array('identificador', 'length', 'max' => 10),
            array('estatus', 'length', 'max' => 1),
            array('banco_id, tipo_cuenta_id', 'ECompositeUniqueValidator', 'attributesToAddError' => 'tipo_cuenta_id', 'message' => 'El tipo de cuenta seleccionado ya se encuentra registrado para este banco.'),
            array('fecha_act, fecha_elim', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, banco_id, tipo_cuenta_id, identificador, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tipoCuenta' => array(self::BELONGS_TO, 'TipoCuenta', 'tipo_cuenta_id'),
            'banco' => array(self::BELONGS_TO, 'Banco', 'banco_id'),
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
            'banco_id' => 'Banco',
            'tipo_cuenta_id' => 'Tipo Cuenta',
            'identificador' => 'Identificador',
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

        if (is_numeric($this->id))
            $criteria->compare('id', $this->id);
        if (is_numeric($this->banco_id))
            $criteria->compare('banco_id', $this->banco_id);
        if (is_numeric($this->tipo_cuenta_id))
            $criteria->compare('tipo_cuenta_id', $this->tipo_cuenta_id);
        if (strlen($this->identificador) > 0)
            $criteria->compare('identificador', $this->identificador, true);
        if (is_numeric($this->usuario_ini_id))
            $criteria->compare('usuario_ini_id', $this->usuario_ini_id);
        if (Utiles::isValidDate($this->fecha_ini, 'y-m-d'))
            $criteria->compare('fecha_ini', $this->fecha_ini);
        // if(strlen($this->fecha_ini)>0) $criteria->compare('fecha_ini',$this->fecha_ini,true);
        if (is_numeric($this->usuario_act_id))
            $criteria->compare('usuario_act_id', $this->usuario_act_id);
        if (Utiles::isValidDate($this->fecha_act, 'y-m-d'))
            $criteria->compare('fecha_act', $this->fecha_act);
        // if(strlen($this->fecha_act)>0) $criteria->compare('fecha_act',$this->fecha_act,true);
        if (Utiles::isValidDate($this->fecha_elim, 'y-m-d'))
            $criteria->compare('fecha_elim', $this->fecha_elim);
        // if(strlen($this->fecha_elim)>0) $criteria->compare('fecha_elim',$this->fecha_elim,true);
        if (in_array($this->estatus, array('A', 'I', 'E')))
            $criteria->compare('estatus', $this->estatus, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTiposCuentaNoVinculadas($bancoId) {
        $result = null;
        if (is_numeric($bancoId)) {
            $cacheIndex = $this->getIndexCacheTipoCuentaBanco($bancoId);
            if (Yii::app()->params['testing']) {
                Yii::app()->cache->delete($cacheIndex);
            }
            $result = Yii::app()->cache->get($cacheIndex);
            if (!$result) {
                $sql = "SELECT tc.* FROM administrativo.tipo_cuenta tc 
                             WHERE NOT EXISTS (
                                SELECT * FROM administrativo.tipo_cuenta_banco t 
                                 WHERE tc.id = t.tipo_cuenta_id AND t.estatus = 'A' AND t.banco_id = :bancoId
                             )
                             ORDER BY tc.nombre";
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->bindParam(":bancoId", $bancoId, PDO::PARAM_INT);
                $result = $command->queryAll();
                if (count($result) > 0) {
                    Yii::app()->cache->set($cacheIndex, $result, 86400);
                }
            }
        }
        return $result;
    }
    

    
    public function getIndexCacheTipoCuentaBanco($bancoId){
        return "TC:$bancoId";
    }
    
    public function deleteCacheTipoCuentaBanco($bancoId){
        Yii::app()->cache->delete($this->getIndexCacheTipoCuentaBanco($bancoId));
    }

   

    public function beforeInsert() {
        $this->estatus = (is_null($this->estatus))?'A':$this->estatus;
        $this->fecha_ini = date('Y-m-d H:i:s');
        $this->usuario_ini_id = Yii::app()->user->id;
        $this->fecha_act = $this->fecha_ini;
        $this->usuario_act_id = Yii::app()->user->id;
    }

    public function beforeUpdate() {
        $this->fecha_act = date('Y-m-d H:i:s');
        $this->usuario_act_id = Yii::app()->user->id;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TipoCuentaBanco the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
