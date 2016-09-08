<?php

/**
 * This is the model class for table "presupuesto.partida".
 *
 * The followings are the available columns in table 'presupuesto.partida':
 * @property integer $id
 * @property string $codigo
 * @property string $descripcion
 * @property integer $permite_partida_aux
 * @property integer $admite_transferencia
 * @property integer $permite_asientos
 * @property integer $tipo_saldo_id
 * @property integer $tipo_gasto_id
 * @property integer $tipo_partida_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property TipoSaldo $tipoSaldo
 * @property TipoGasto $tipoGasto
 * @property TipoPartida $tipoPartida
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class Partida extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'presupuesto.partida';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo, descripcion, usuario_ini_id, fecha_ini, estatus', 'required'),
			array('permite_partida_aux, admite_transferencia, permite_asientos, tipo_saldo_id, tipo_gasto_id, tipo_partida_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('codigo', 'length', 'max'=>22),
			array('descripcion', 'length', 'max'=>160),
			array('estatus', 'length', 'max'=>1),
			array('fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, codigo, descripcion, permite_partida_aux, admite_transferencia, permite_asientos, tipo_saldo_id, tipo_gasto_id, tipo_partida_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'tipoSaldo' => array(self::BELONGS_TO, 'TipoSaldo', 'tipo_saldo_id'),
			'tipoGasto' => array(self::BELONGS_TO, 'TipoGasto', 'tipo_gasto_id'),
			'tipoPartida' => array(self::BELONGS_TO, 'TipoPartida', 'tipo_partida_id'),
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
			'codigo' => 'Codigo',
			'descripcion' => 'Descripcion',
			'permite_partida_aux' => 'Permite Partida Aux',
			'admite_transferencia' => 'Admite Transferencia',
			'permite_asientos' => 'Permite Asientos',
			'tipo_saldo_id' => 'Tipo Saldo',
			'tipo_gasto_id' => 'Tipo Gasto',
			'tipo_partida_id' => 'Tipo Partida',
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
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('permite_partida_aux',$this->permite_partida_aux);
		$criteria->compare('admite_transferencia',$this->admite_transferencia);
		$criteria->compare('permite_asientos',$this->permite_asientos);
		$criteria->compare('tipo_saldo_id',$this->tipo_saldo_id);
		$criteria->compare('tipo_gasto_id',$this->tipo_gasto_id);
		$criteria->compare('tipo_partida_id',$this->tipo_partida_id);
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Partida the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
