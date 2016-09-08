<?php

/**
 * This is the model class for table "administrativo.sociedad_mercantil".
 *
 * The followings are the available columns in table 'administrativo.sociedad_mercantil':
 * @property integer $id
 * @property string $nombre
 * @property string $siglas
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 * @property Empresa[] $empresas
 */
class SociedadMercantil extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'administrativo.sociedad_mercantil';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, siglas, usuario_ini_id, fecha_ini', 'required'),
			array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
                        array('nombre, ', 'unique'),
			array('nombre', 'length', 'max'=>160),
			array('siglas', 'length', 'max'=>7),
			array('estatus', 'length', 'max'=>1),
			array('estatus', 'in', 'range'=>array('A', 'I', 'E'), 'allowEmpty'=>false, 'strict'=>true,),
			array('estatus', 'default', 'value'=>'A', 'setOnEmpty'=>true, 'on'=>'insert'),
			array('usuario_ini_id', 'default', 'value'=>Yii::app()->user->id, 'on'=>'insert'),
			array('usuario_act_id', 'default', 'value'=>Yii::app()->user->id, 'on'=>'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, siglas, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
			'empresas' => array(self::HAS_MANY, 'Empresa', 'sociedad_mercantil_id'),
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
			'siglas' => 'Siglas',
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

		if(is_numeric($this->id)) $criteria->compare('id',$this->id);
		if(strlen($this->nombre)>0) $criteria->compare('nombre',$this->nombre,true);
		if(strlen($this->siglas)>0) $criteria->compare('siglas',$this->siglas,true);
		if(is_numeric($this->usuario_ini_id)) $criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		if(Utiles::isValidDate($this->fecha_ini, 'y-m-d')) $criteria->compare('fecha_ini',$this->fecha_ini);
		// if(strlen($this->fecha_ini)>0) $criteria->compare('fecha_ini',$this->fecha_ini,true);
		if(is_numeric($this->usuario_act_id)) $criteria->compare('usuario_act_id',$this->usuario_act_id);
		if(Utiles::isValidDate($this->fecha_act, 'y-m-d')) $criteria->compare('fecha_act',$this->fecha_act);
		// if(strlen($this->fecha_act)>0) $criteria->compare('fecha_act',$this->fecha_act,true);
		if(Utiles::isValidDate($this->fecha_elim, 'y-m-d')) $criteria->compare('fecha_elim',$this->fecha_elim);
		// if(strlen($this->fecha_elim)>0) $criteria->compare('fecha_elim',$this->fecha_elim,true);
		if(in_array($this->estatus, array('A', 'I', 'E'))) $criteria->compare('estatus',$this->estatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
       public function beforeInsert()
       {
           $this->fecha_ini = date('Y-m-d H:i:s');
           $this->usuario_ini_id = Yii::app()->user->id;
       }
       
       public function beforeUpdate()
       {
           $this->fecha_act = new CDbExpression('(NOW())::timestamp(0)');
           $this->usuario_act_id = Yii::app()->user->id;
       }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SociedadMercantil the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
