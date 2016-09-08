<?php

/**
 * This is the model class for table "sistema.rol".
 *
 * The followings are the available columns in table 'sistema.rol':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $estatus
 * @property string $fecha_ini
 * @property integer $usuario_ini_id
 * @property string $fecha_act
 * @property integer $usuario_act_id
 * @property string $fecha_eli
 * @property string $alias
 *
 * The followings are the available model relations:
 * @property RolMenuItem[] $rolMenuItems
 * @property Usuario $usuarioAct
 * @property Usuario $usuarioIni
 * @property RolUsuario[] $rolUsuarios
 */
class Rol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sistema.rol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion, estatus', 'required'),
			array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>40),
			array('descripcion', 'length', 'max'=>255),
			array('estatus', 'length', 'max'=>1),
			array('alias', 'length', 'max'=>100),
			array('fecha_ini, fecha_act, fecha_eli', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, estatus, fecha_ini, usuario_ini_id, fecha_act, usuario_act_id, fecha_eli, alias', 'safe', 'on'=>'search'),
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
			'rolMenuItems' => array(self::HAS_MANY, 'RolMenuItem', 'rol_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
			'rolUsuarios' => array(self::HAS_MANY, 'RolUsuario', 'rol_id'),
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
			'descripcion' => 'Descripcion',
			'estatus' => 'Estatus',
			'fecha_ini' => 'Fecha Ini',
			'usuario_ini_id' => 'Usuario Ini',
			'fecha_act' => 'Fecha Act',
			'usuario_act_id' => 'Usuario Act',
			'fecha_eli' => 'Fecha Eli',
			'alias' => 'Alias',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('fecha_act',$this->fecha_act,true);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('fecha_eli',$this->fecha_eli,true);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
