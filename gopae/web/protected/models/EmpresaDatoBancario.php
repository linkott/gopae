<?php

/**
 * This is the model class for table "administrativo.empresa_dato_bancario".
 *
 * The followings are the available columns in table 'administrativo.empresa_dato_bancario':
 * @property integer $id
 * @property integer $empresa_id
 * @property integer $banco_id
 * @property string $tipo_cuenta
 * @property string $nro_cuenta
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Banco $banco
 * @property Empresa $empresa
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 */
class EmpresaDatoBancario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'administrativo.empresa_dato_bancario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario_ini_id, fecha_ini', 'required'),
			array('empresa_id, banco_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('tipo_cuenta', 'length', 'max'=>30),
			array('nro_cuenta', 'length', 'max'=>20),
			array('estatus', 'length', 'max'=>1),
			array('fecha_act', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, empresa_id, banco_id, tipo_cuenta, nro_cuenta, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, estatus', 'safe', 'on'=>'search'),
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
			'banco' => array(self::BELONGS_TO, 'Banco', 'banco_id'),
			'empresa' => array(self::BELONGS_TO, 'Empresa', 'empresa_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'empresa_id' => 'Empresa',
			'banco_id' => 'Banco',
			'tipo_cuenta' => 'Tipo Cuenta',
			'nro_cuenta' => 'Nro Cuenta',
			'usuario_ini_id' => 'Usuario Ini',
			'fecha_ini' => 'Fecha Ini',
			'usuario_act_id' => 'Usuario Act',
			'fecha_act' => 'Fecha Act',
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
		$criteria->compare('empresa_id',$this->empresa_id);
		$criteria->compare('banco_id',$this->banco_id);
		$criteria->compare('tipo_cuenta',$this->tipo_cuenta,true);
		$criteria->compare('nro_cuenta',$this->nro_cuenta,true);
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('fecha_act',$this->fecha_act,true);
		$criteria->compare('estatus',$this->estatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmpresaDatoBancario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
