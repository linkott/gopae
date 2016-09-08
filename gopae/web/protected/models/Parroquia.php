<?php

/**
 * This is the model class for table "public.parroquia".
 *
 * The followings are the available columns in table 'public.parroquia':
 * @property integer $id
 * @property string $co_prrq_asap
 * @property string $nombre
 * @property integer $municipio_id
 * @property string $co_stat_data
 * @property string $fe_carga
 * @property string $fe_modif
 * @property string $co_stat_old
 * @property string $fe_ini
 *
 * The followings are the available model relations:
 * @property Municipio $municipio
 * @property Localidad[] $localidads
 * @property Sector[] $sectors
 */
class Parroquia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'public.parroquia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, co_prrq_asap, nombre, municipio_id, fe_carga', 'required'),
			array('id, municipio_id', 'numerical', 'integerOnly'=>true),
			array('co_prrq_asap', 'length', 'max'=>2),
			array('nombre', 'length', 'max'=>65),
			array('co_stat_data, co_stat_old', 'length', 'max'=>1),
			array('fe_modif, fe_ini', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, co_prrq_asap, nombre, municipio_id, co_stat_data, fe_carga, fe_modif, co_stat_old, fe_ini', 'safe', 'on'=>'search'),
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
			'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
			'localidads' => array(self::HAS_MANY, 'Localidad', 'parroquia_id'),
			'sectors' => array(self::HAS_MANY, 'Sector', 'parroquia_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id de parroquia ',
			'co_prrq_asap' => 'Código de parroquia del sistema ASAP CANTV',
			'nombre' => 'Nombre de parroquia ',
			'municipio_id' => 'id de municipio ',
			'co_stat_data' => 'Co Stat Data',
			'fe_carga' => 'Fecha de carga ',
			'fe_modif' => 'Fecha de modificación ',
			'co_stat_old' => 'Código del status antiguo ',
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
		$criteria->compare('co_prrq_asap',$this->co_prrq_asap,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('municipio_id',$this->municipio_id);
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
	 * @return Parroquia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
