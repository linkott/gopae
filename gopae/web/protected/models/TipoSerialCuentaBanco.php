<?php

/**
 * This is the model class for table "administrativo.tipo_serial_cuenta_banco".
 *
 * The followings are the available columns in table 'administrativo.tipo_serial_cuenta_banco':
 * @property integer $id
 * @property integer $banco_id
 * @property integer $tipo_serial_cuenta_id
 * @property string $serial
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property TipoSerialCuenta $tipoSerialCuenta
 * @property Banco $banco
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class TipoSerialCuentaBanco extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'administrativo.tipo_serial_cuenta_banco';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('banco_id, tipo_serial_cuenta_id, usuario_ini_id, fecha_ini', 'required'),
                    array('banco_id, tipo_serial_cuenta_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
                    array('serial', 'length', 'max'=>10),
                    array('estatus', 'length', 'max'=>1),
                    array('fecha_act, fecha_elim', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, banco_id, tipo_serial_cuenta_id, serial, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
            );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                    'tipoSerialCuenta' => array(self::BELONGS_TO, 'TipoSerialCuenta', 'tipo_serial_cuenta_id'),
                    'banco' => array(self::BELONGS_TO, 'Banco', 'banco_id'),
                    'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
                    'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'banco_id' => 'Banco',
                    'tipo_serial_cuenta_id' => 'Tipo Serial Cuenta',
                    'serial' => 'Serial',
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
    public function search()
    {
            // @todo Please modify the following code to remove attributes that should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('banco_id',$this->banco_id);
            $criteria->compare('tipo_serial_cuenta_id',$this->tipo_serial_cuenta_id);
            $criteria->compare('serial',$this->serial,true);
            $criteria->compare('usuario_ini_id',$this->usuario_ini_id);
            $criteria->compare('fecha_ini',$this->fecha_ini,true);
            $criteria->compare('usuario_act_id',$this->usuario_act_id);
            $criteria->compare('fecha_act',$this->fecha_act,true);
            $criteria->compare('fecha_elim',$this->fecha_elim,true);
            $criteria->compare('estatus',$this->estatus,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
        
    public function getTiposSerialCuentaNoVinculadas($bancoId) {
        $result = null;
        if(is_numeric($bancoId)){
            $cacheIndex = $this->getIndexCacheTipoSerialCuentaBanco($bancoId);
            if (Yii::app()->params['testing']) {
                Yii::app()->cache->delete($cacheIndex);
            }
            $result = Yii::app()->cache->get($cacheIndex);
            if (!$result) {
                $sql = "SELECT tsc.* FROM administrativo.tipo_serial_cuenta tsc
                             WHERE NOT EXISTS (
                                SELECT * FROM administrativo.tipo_serial_cuenta_banco t 
                                 WHERE tsc.id = t.tipo_serial_cuenta_id AND t.estatus = 'A' AND t.banco_id = :bancoId
                             )
                             ORDER BY tsc.nombre";
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
    
    
    public function getIndexCacheTipoSerialCuentaBanco($bancoId){
        return "TSC:$bancoId";
    }
    
    public function deleteCacheTipoSerialCuentaBanco($bancoId){
        Yii::app()->cache->delete($this->getIndexCacheTipoSerialCuentaBanco($bancoId));
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
     * @return TipoSerialCuentaBanco the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
