<?php

/**
 * This is the model class for table "via".
 *
 * The followings are the available columns in table 'via':
 * @property integer $id
 * @property string $nombre
 * @property string $co_stat_data
 * @property string $co_tipo_via
 * @property integer $tipo_via_id
 * @property string $fe_carga
 * @property string $fe_modif
 * @property string $co_stat_old
 * @property string $fe_ini
 *
 * The followings are the available model relations:
 * @property SectorVia[] $sectorVias
 * @property TipoVia $tipoVia
 * @property TipoVia $coTipoVia
 */
class Via extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'via';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, nombre, co_tipo_via, fe_carga', 'required'),
			array('id, tipo_via_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>40),
			array('co_stat_data, co_stat_old', 'length', 'max'=>1),
			array('co_tipo_via', 'length', 'max'=>2),
			array('fe_modif, fe_ini', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, co_stat_data, co_tipo_via, tipo_via_id, fe_carga, fe_modif, co_stat_old, fe_ini', 'safe', 'on'=>'search'),
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
			'sectorVias' => array(self::HAS_MANY, 'SectorVia', 'via_id'),
			'tipoVia' => array(self::BELONGS_TO, 'TipoVia', 'tipo_via_id'),
			'coTipoVia' => array(self::BELONGS_TO, 'TipoVia', 'co_tipo_via'),
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
			'co_stat_data' => 'Co Stat Data',
			'co_tipo_via' => 'Co Tipo Via',
			'tipo_via_id' => 'Tipo Via',
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
		$criteria->compare('co_stat_data',$this->co_stat_data,true);
		$criteria->compare('co_tipo_via',$this->co_tipo_via,true);
		$criteria->compare('tipo_via_id',$this->tipo_via_id);
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
	 * @return Via the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
