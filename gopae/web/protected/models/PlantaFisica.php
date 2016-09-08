<?php

/**
 * This is the model class for table "gplantel.planta_fisica".
 *
 * The followings are the available columns in table 'gplantel.planta_fisica':
 * @property integer $id
 * @property string $direccion
 * @property double $latitud
 * @property double $longitud
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $parroquia_id
 * @property integer $localidad_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Plantel[] $plantels
 * @property Estado $estado
 * @property Usuario $usuarioAct
 * @property Usuario $usuarioIni
 * @property Localidad $localidad
 * @property Municipio $municipio
 * @property Parroquia $parroquia
 */
class PlantaFisica extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gplantel.planta_fisica';
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
			array('estado_id, municipio_id, parroquia_id, localidad_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('latitud, longitud', 'numerical'),
			array('estatus', 'length', 'max'=>1),
			array('direccion, fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, direccion, latitud, longitud, estado_id, municipio_id, parroquia_id, localidad_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'plantels' => array(self::HAS_MANY, 'Plantel', 'planta_fisica_id'),
			'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
			'localidad' => array(self::BELONGS_TO, 'Localidad', 'localidad_id'),
			'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
			'parroquia' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'direccion' => 'Direccion',
			'latitud' => 'Latitud',
			'longitud' => 'Longitud',
			'estado_id' => 'Estado',
			'municipio_id' => 'Municipio',
			'parroquia_id' => 'Parroquia',
			'localidad_id' => 'Localidad',
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
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('latitud',$this->latitud);
		$criteria->compare('longitud',$this->longitud);
		$criteria->compare('estado_id',$this->estado_id);
		$criteria->compare('municipio_id',$this->municipio_id);
		$criteria->compare('parroquia_id',$this->parroquia_id);
		$criteria->compare('localidad_id',$this->localidad_id);
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
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PlantaFisica the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
