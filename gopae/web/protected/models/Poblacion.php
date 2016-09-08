<?php

/**
 * This is the model class for table "poblacion".
 *
 * The followings are the available columns in table 'poblacion':
 * @property integer $id
 * @property string $co_pobl_asap
 * @property string $nombre
 * @property string $co_stat_data
 * @property string $fe_carga
 * @property string $fe_modif
 * @property string $co_stat_old
 * @property string $fecha_ini
 *
 * The followings are the available model relations:
 * @property Sector[] $sectors
 */
class Poblacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'poblacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, co_pobl_asap, nombre, co_stat_data, fe_carga', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('co_pobl_asap', 'length', 'max'=>3),
			array('nombre', 'length', 'max'=>65),
			array('co_stat_data, co_stat_old', 'length', 'max'=>1),
			array('fe_modif, fecha_ini', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, co_pobl_asap, nombre, co_stat_data, fe_carga, fe_modif, co_stat_old, fecha_ini', 'safe', 'on'=>'search'),
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
			'sectors' => array(self::HAS_MANY, 'Sector', 'poblacion_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'co_pobl_asap' => 'Co Pobl Asap',
			'nombre' => 'Nombre',
			'co_stat_data' => 'Co Stat Data',
			'fe_carga' => 'Fe Carga',
			'fe_modif' => 'Fe Modif',
			'co_stat_old' => 'Co Stat Old',
			'fecha_ini' => 'Fecha Ini',
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
		$criteria->compare('co_pobl_asap',$this->co_pobl_asap,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('co_stat_data',$this->co_stat_data,true);
		$criteria->compare('fe_carga',$this->fe_carga,true);
		$criteria->compare('fe_modif',$this->fe_modif,true);
		$criteria->compare('co_stat_old',$this->co_stat_old,true);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Poblacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
