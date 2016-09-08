<?php

/**
 * This is the model class for table "proveduria.zona_proveedor".
 *
 * The followings are the available columns in table 'proveduria.zona_proveedor':
 * @property integer $id
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $poblacion_id
 * @property integer $parroquia_id
 * @property integer $proveedor_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 * @property Poblacion $poblacion
 * @property Parroquia $parroquia
 * @property Municipio $municipio
 * @property Estado $estado
 * @property Proveedor $proveedor
 */
class ZonaProveedor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'proveduria.zona_proveedor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario_ini_id, fecha_ini, estatus', 'required'),
			array('estado_id, municipio_id, poblacion_id, parroquia_id, proveedor_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('estatus', 'length', 'max'=>1),
			array('fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, estado_id, municipio_id, poblacion_id, parroquia_id, proveedor_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
			'poblacion' => array(self::BELONGS_TO, 'Poblacion', 'poblacion_id'),
			'parroquia' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_id'),
			'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
			'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
			'proveedor' => array(self::BELONGS_TO, 'Proveedor', 'proveedor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'estado_id' => 'Estado',
			'municipio_id' => 'Municipio',
			'poblacion_id' => 'Poblacion',
			'parroquia_id' => 'Parroquia',
			'proveedor_id' => 'Proveedor',
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
		$criteria->compare('estado_id',$this->estado_id);
		$criteria->compare('municipio_id',$this->municipio_id);
		$criteria->compare('poblacion_id',$this->poblacion_id);
		$criteria->compare('parroquia_id',$this->parroquia_id);
		$criteria->compare('proveedor_id',$this->proveedor_id);
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
	 * @return ZonaProveedor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
