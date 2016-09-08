<?php

/**
 * This is the model class for table "administrativo.empresa".
 *
 * The followings are the available columns in table 'administrativo.empresa':
 * @property integer $id
 * @property string $rif
 * @property string $razon_social
 * @property string $siglas
 * @property string $descripcion
 * @property string $origen_maxima_autoridad
 * @property string $nombre_maxima_autoridad
 * @property string $apellido_maxima_autoridad
 * @property string $origen_autoridad_administrativa
 * @property string $nombre_autoridad_administrativa
 * @property string $apellido_autoridad_administrativa
 * @property string $origen_autoridad_planificacion
 * @property string $nombre_autoridad_planificacion
 * @property string $apellido_autoridad_planificacion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $estatus
 * @property integer $cedula_maxima_autoridad
 * @property integer $cedula_autoridad_administrativa
 * @property integer $cedula_autoridad_planificacion
 * @property integer $sector_id
 * @property integer $sociedad_mercantil_id
 *
 * The followings are the available model relations:
 * @property EmpresaDatoBancario[] $empresaDatoBancarios
 * @property SociedadMercantil $sociedadMercantil
 * @property TipoSector $sector
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 */
class Empresa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'administrativo.empresa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rif, razon_social, usuario_ini_id, fecha_ini', 'required'),
			array('usuario_ini_id, usuario_act_id, cedula_maxima_autoridad, cedula_autoridad_administrativa, cedula_autoridad_planificacion, sector_id, sociedad_mercantil_id', 'numerical', 'integerOnly'=>true),
			array('rif', 'length', 'max'=>30),
			array('razon_social', 'length', 'max'=>70),
			array('siglas', 'length', 'max'=>10),
			array('origen_maxima_autoridad, origen_autoridad_administrativa, origen_autoridad_planificacion, estatus', 'length', 'max'=>1),
			array('nombre_maxima_autoridad, apellido_maxima_autoridad, nombre_autoridad_administrativa, apellido_autoridad_administrativa, nombre_autoridad_planificacion, apellido_autoridad_planificacion', 'length', 'max'=>40),
			array('descripcion, fecha_act', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rif, razon_social, siglas, descripcion, origen_maxima_autoridad, nombre_maxima_autoridad, apellido_maxima_autoridad, origen_autoridad_administrativa, nombre_autoridad_administrativa, apellido_autoridad_administrativa, origen_autoridad_planificacion, nombre_autoridad_planificacion, apellido_autoridad_planificacion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, estatus, cedula_maxima_autoridad, cedula_autoridad_administrativa, cedula_autoridad_planificacion, sector_id, sociedad_mercantil_id', 'safe', 'on'=>'search'),
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
			'empresaDatoBancarios' => array(self::HAS_MANY, 'EmpresaDatoBancario', 'empresa_id'),
			'sociedadMercantil' => array(self::BELONGS_TO, 'SociedadMercantil', 'sociedad_mercantil_id'),
			'sector' => array(self::BELONGS_TO, 'TipoSector', 'sector_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rif' => 'Rif',
			'razon_social' => 'Razon Social',
			'siglas' => 'Siglas',
			'descripcion' => 'Descripcion',
			'origen_maxima_autoridad' => 'Origen Maxima Autoridad',
			'nombre_maxima_autoridad' => 'Nombre Maxima Autoridad',
			'apellido_maxima_autoridad' => 'Apellido Maxima Autoridad',
			'origen_autoridad_administrativa' => 'Origen Autoridad Administrativa',
			'nombre_autoridad_administrativa' => 'Nombre Autoridad Administrativa',
			'apellido_autoridad_administrativa' => 'Apellido Autoridad Administrativa',
			'origen_autoridad_planificacion' => 'Origen Autoridad Planificacion',
			'nombre_autoridad_planificacion' => 'Nombre Autoridad Planificacion',
			'apellido_autoridad_planificacion' => 'Apellido Autoridad Planificacion',
			'usuario_ini_id' => 'Usuario Ini',
			'fecha_ini' => 'Fecha Ini',
			'usuario_act_id' => 'Usuario Act',
			'fecha_act' => 'Fecha Act',
			'estatus' => 'Estatus',
			'cedula_maxima_autoridad' => 'Cedula Maxima Autoridad',
			'cedula_autoridad_administrativa' => 'Cedula Autoridad Administrativa',
			'cedula_autoridad_planificacion' => 'Cedula Autoridad Planificacion',
			'sector_id' => 'Sector',
			'sociedad_mercantil_id' => 'Sociedad Mercantil',
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
		$criteria->compare('rif',$this->rif,true);
		$criteria->compare('razon_social',$this->razon_social,true);
		$criteria->compare('siglas',$this->siglas,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('origen_maxima_autoridad',$this->origen_maxima_autoridad,true);
		$criteria->compare('nombre_maxima_autoridad',$this->nombre_maxima_autoridad,true);
		$criteria->compare('apellido_maxima_autoridad',$this->apellido_maxima_autoridad,true);
		$criteria->compare('origen_autoridad_administrativa',$this->origen_autoridad_administrativa,true);
		$criteria->compare('nombre_autoridad_administrativa',$this->nombre_autoridad_administrativa,true);
		$criteria->compare('apellido_autoridad_administrativa',$this->apellido_autoridad_administrativa,true);
		$criteria->compare('origen_autoridad_planificacion',$this->origen_autoridad_planificacion,true);
		$criteria->compare('nombre_autoridad_planificacion',$this->nombre_autoridad_planificacion,true);
		$criteria->compare('apellido_autoridad_planificacion',$this->apellido_autoridad_planificacion,true);
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('fecha_act',$this->fecha_act,true);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('cedula_maxima_autoridad',$this->cedula_maxima_autoridad);
		$criteria->compare('cedula_autoridad_administrativa',$this->cedula_autoridad_administrativa);
		$criteria->compare('cedula_autoridad_planificacion',$this->cedula_autoridad_planificacion);
		$criteria->compare('sector_id',$this->sector_id);
		$criteria->compare('sociedad_mercantil_id',$this->sociedad_mercantil_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Empresa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
