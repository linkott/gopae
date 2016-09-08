<?php

/**
 * This is the model class for table "nutricion.menu_nutricional_alimento".
 *
 * The followings are the available columns in table 'nutricion.menu_nutricional_alimento':
 * @property integer $id
 * @property integer $menu_nutricional_id
 * @property integer $alimentos_id
 * @property string $cantidad
 * @property string $cantidad_mediana
 * @property string $cantidad_grande
 * @property integer $alimentos_sustituto_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property MenuNutricionalSustitutos[] $menuNutricionalSustitutoses
 * @property MenuNutricional $menuNutricional
 * @property Articulo $alimentos
 */
class MenuNutricionalAlimento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nutricion.menu_nutricional_alimento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_nutricional_id, alimentos_id, cantidad, cantidad_mediana, cantidad_grande, usuario_ini_id, fecha_ini, estatus', 'required'),
			array('menu_nutricional_id, alimentos_id, alimentos_sustituto_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('estatus', 'length', 'max'=>1),
			array('fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, menu_nutricional_id, alimentos_id, cantidad, cantidad_mediana, cantidad_grande, alimentos_sustituto_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'menuNutricionalSustitutoses' => array(self::HAS_MANY, 'MenuNutricionalSustitutos', 'menu_nutricional_alimento_id'),
			'menuNutricional' => array(self::BELONGS_TO, 'MenuNutricional', 'menu_nutricional_id'),
			'alimentos' => array(self::BELONGS_TO, 'Articulo', 'alimentos_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'menu_nutricional_id' => 'Menu Nutricional',
			'alimentos_id' => 'Alimentos',
			'cantidad' => 'Cantidad',
			'cantidad_mediana' => 'Cantidad Mediana',
			'cantidad_grande' => 'Cantidad Grande',
			'alimentos_sustituto_id' => 'Alimentos Sustituto',
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
		$criteria->compare('menu_nutricional_id',$this->menu_nutricional_id);
		$criteria->compare('alimentos_id',$this->alimentos_id);
		$criteria->compare('cantidad',$this->cantidad,true);
		$criteria->compare('cantidad_mediana',$this->cantidad_mediana,true);
		$criteria->compare('cantidad_grande',$this->cantidad_grande,true);
		$criteria->compare('alimentos_sustituto_id',$this->alimentos_sustituto_id);
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
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuNutricionalAlimento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
