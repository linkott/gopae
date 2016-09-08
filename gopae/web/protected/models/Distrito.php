<?php

/**
 * This is the model class for table "gplantel.distrito".
 *
 * The followings are the available columns in table 'gplantel.distrito':
 * @property integer $id
 * @property string $nombre
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $plantel_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Plantel[] $plantels
 * @property UsuarioDistrito[] $usuarioDistritos
 * @property Usuario $usuarioAct
 * @property Estado $estado
 * @property Usuario $usuarioIni
 * @property Municipio $municipio
 * @property Plantel $plantel
 */
class Distrito extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gplantel.distrito';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado_id, municipio_id, usuario_ini_id, fecha_ini', 'required'),
			array('estado_id, municipio_id, plantel_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>30),
			array('estatus', 'length', 'max'=>1),
			array('fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, estado_id, municipio_id, plantel_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'plantels' => array(self::HAS_MANY, 'Plantel', 'distrito_id'),
			'usuarioDistritos' => array(self::HAS_MANY, 'UsuarioDistrito', 'distrito_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
			'estado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
			'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
			'plantel' => array(self::BELONGS_TO, 'Plantel', 'plantel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'estado_id' => 'Estado',
			'municipio_id' => 'Municipio',
			'plantel_id' => 'Plantel',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('estado_id',$this->estado_id);
		$criteria->compare('municipio_id',$this->municipio_id);
		$criteria->compare('plantel_id',$this->plantel_id);
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
	 * @return Distrito the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
