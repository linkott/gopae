<?php

/**
 * This is the model class for table "gplantel.usuario_zona_edu".
 *
 * The followings are the available columns in table 'gplantel.usuario_zona_edu':
 * @property string $id
 * @property integer $zona_educativa_id
 * @property integer $usuario_id
 * @property integer $cargo_id
 * @property string $observacion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Usuario $usuarioAct
 * @property Cargo $cargo
 * @property Usuario $usuarioIni
 * @property Usuario $usuario
 * @property ZonaEducativa $zonaEducativa
 */
class UsuarioZonaEdu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gplantel.usuario_zona_edu';
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
			array('zona_educativa_id, usuario_id, cargo_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('observacion', 'length', 'max'=>150),
			array('estatus', 'length', 'max'=>1),
			array('fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, zona_educativa_id, usuario_id, cargo_id, observacion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
			'cargo' => array(self::BELONGS_TO, 'Cargo', 'cargo_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
			'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
			'zonaEducativa' => array(self::BELONGS_TO, 'ZonaEducativa', 'zona_educativa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'zona_educativa_id' => 'Zona Educativa',
			'usuario_id' => 'Usuario',
			'cargo_id' => 'Cargo',
			'observacion' => 'Observacion',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('zona_educativa_id',$this->zona_educativa_id);
		$criteria->compare('usuario_id',$this->usuario_id);
		$criteria->compare('cargo_id',$this->cargo_id);
		$criteria->compare('observacion',$this->observacion,true);
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
	 * @return UsuarioZonaEdu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
