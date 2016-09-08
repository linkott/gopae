<?php
/**
 * This is the model class for table "estado".
 *
 * The followings are the available columns in table 'estado':
 * @property integer $id
 * @property string $co_edo_asap
 * @property string $nombre
 * @property string $capital
 * @property string $co_stat_data
 * @property string $fecha_carga
 * @property string $fecha_modif
 * @property string $co_stat_old
 * @property string $fecha_ini
 * @property integer $region_id
 *
 * The followings are the available model relations:
 * @property Usuario[] $usuarios
 * @property Region $region
 */
class Estado extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'public.estado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, co_edo_asap, nombre, fecha_carga, region_id', 'required'),
			array('id, region_id', 'numerical', 'integerOnly'=>true),
			array('co_edo_asap', 'length', 'max'=>2),
			array('nombre, capital', 'length', 'max'=>65),
			array('co_stat_data, co_stat_old', 'length', 'max'=>1),
			array('fecha_modif, fecha_ini', 'safe'),
			array('id, co_edo_asap, nombre, capital, co_stat_data, fecha_carga, fecha_modif, co_stat_old, fecha_ini, region_id', 'safe', 'on'=>'search'),
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
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'id'),
			'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id del Estado en Catastro',
			'co_edo_asap' => 'Codigo del Estado ASAP. Dato tomado de la bd de Catastro',
			'nombre' => 'Nombre del estado. Dato de la bd de Catastro',
			'capital' => 'Nombre de la capital del estado. Dato de la bd de Catastro',
			'co_stat_data' => 'Co Stat Data',
			'fecha_carga' => 'Fecha de carga',
			'fecha_modif' => 'Fecha de modificación',
			'co_stat_old' => 'Co Stat Old',
			'fecha_ini' => 'Fecha de carga. Dato de la bd de Catastro',
			'region_id' => 'Region',
                        'imagen' => 'Imagen',
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
		$criteria->compare('co_edo_asap',$this->co_edo_asap,true);
                $criteria->addSearchCondition('t.nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');
		//$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('capital',$this->capital,true);
		$criteria->compare('co_stat_data',$this->co_stat_data,true);
		$criteria->compare('fecha_carga',$this->fecha_carga,true);
		$criteria->compare('fecha_modif',$this->fecha_modif,true);
		$criteria->compare('co_stat_old',$this->co_stat_old,true);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('region_id',$this->region_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
     * return the group array list
     * @return Array
     */
    public static function estadosList() {
        $arrayData = array();
        $criteria = new CDbCriteria;
        $criteria->order = 'nombre ASC, capital ASC';
        $criteria->addCondition("co_stat_data = 'A'");
        $result = self::model()->findAll($criteria);
        foreach ($result as $r) {
            $arrayData[$r->id] = $r->nombre;
        }
        return $arrayData;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Estado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
