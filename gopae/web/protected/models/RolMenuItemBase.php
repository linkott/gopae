<?php

/**
 * This is the model class for table "rol_menu_item".
 *
 * The followings are the available columns in table 'rol_menu_item':
 * @property integer $rol_menu_item_id
 * @property integer $rol_id
 * @property integer $menu_item_id
 * @property string $estatus
 * @property string $fe_ini
 * @property integer $usuario_ini_id
 * @property string $fe_modif
 * @property integer $usuario_act_id
 * @property string $fe_elim
 * @property integer $nivel_acceso_id
 *
 * The followings are the available model relations:
 * @property NivelAcceso $nivelAcceso
 * @property Usuario $usuarioAct
 * @property MenuItem $menuItem
 * @property Usuario $usuarioIni
 * @property Rol $rol
 */
class RolMenuItemBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sistema.rol_menu_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rol_id, menu_item_id, fe_ini', 'required'),
			array('rol_id, menu_item_id, usuario_ini_id, usuario_act_id, nivel_acceso_id', 'numerical', 'integerOnly'=>true),
			array('estatus', 'length', 'max'=>1),
			array('fe_modif, fe_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rol_menu_item_id, rol_id, menu_item_id, estatus, fe_ini, usuario_ini_id, fe_modif, usuario_act_id, fe_elim, nivel_acceso_id', 'safe', 'on'=>'search'),
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
			'nivelAcceso' => array(self::BELONGS_TO, 'NivelAcceso', 'nivel_acceso_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
			'menuItem' => array(self::BELONGS_TO, 'MenuItem', 'menu_item_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
			'rol' => array(self::BELONGS_TO, 'Rol', 'rol_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rol_menu_item_id' => 'Rol Menu Item',
			'rol_id' => 'Rol',
			'menu_item_id' => 'Menu Item',
			'estatus' => 'Estatus del Registro. A=Activo, I=Inactivo, E=Eliminado. Solo los registros activos pueden ser tomados en cuenta en el Sistema.',
			'fe_ini' => 'Fe Ini',
			'usuario_ini_id' => 'Usuario Ini',
			'fe_modif' => 'Fecha en la que se modificaron por última vez los datos del Registro.',
			'usuario_act_id' => 'Usuario Act',
			'fe_elim' => 'Fe Elim',
			'nivel_acceso_id' => 'Nivel Acceso',
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

		$criteria->compare('rol_menu_item_id',$this->rol_menu_item_id);
		$criteria->compare('rol_id',$this->rol_id);
		$criteria->compare('menu_item_id',$this->menu_item_id);
		$criteria->compare('estatus',$this->estatus,true);
		$criteria->compare('fe_ini',$this->fe_ini,true);
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('fe_modif',$this->fe_modif,true);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('fe_elim',$this->fe_elim,true);
		$criteria->compare('nivel_acceso_id',$this->nivel_acceso_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RolMenuItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
