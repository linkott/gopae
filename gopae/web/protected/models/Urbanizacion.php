<?php

/**
 * This is the model class for table "urbanizacion".
 *
 * The followings are the available columns in table 'urbanizacion':
 * @property integer $id
 * @property string $nombre
 * @property string $nombre_ant
 * @property string $co_stat_data
 * @property string $fe_carga
 * @property string $fe_modif
 * @property string $co_stat_old
 * @property string $fe_ini
 *
 * The followings are the available model relations:
 * @property SectorUrbanizacion[] $sectorUrbanizacions
 */
class Urbanizacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'urbanizacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, nombre, fe_carga', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('nombre, nombre_ant', 'length', 'max'=>30),
			array('co_stat_data, co_stat_old', 'length', 'max'=>1),
			array('fe_modif, fe_ini', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, nombre_ant, co_stat_data, fe_carga, fe_modif, co_stat_old, fe_ini', 'safe', 'on'=>'search'),
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
			'sectorUrbanizacions' => array(self::HAS_MANY, 'SectorUrbanizacion', 'urbanizacion_id'),
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
			'nombre_ant' => 'Nombre Ant',
			'co_stat_data' => 'Co Stat Data',
			'fe_carga' => 'Fe Carga',
			'fe_modif' => 'Fe Modif',
			'co_stat_old' => 'Co Stat Old',
			'fe_ini' => 'Fe Ini',
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
		$criteria->compare('nombre_ant',$this->nombre_ant,true);
		$criteria->compare('co_stat_data',$this->co_stat_data,true);
		$criteria->compare('fe_carga',$this->fe_carga,true);
		$criteria->compare('fe_modif',$this->fe_modif,true);
		$criteria->compare('co_stat_old',$this->co_stat_old,true);
		$criteria->compare('fe_ini',$this->fe_ini,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Urbanizacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
