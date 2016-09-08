<?php

/**
 * This is the model class for table "gestion_humana.estructura_organizativa".
 *
 * The followings are the available columns in table 'gestion_humana.estructura_organizativa':
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property string $siglas
 * @property string $descripcion
 * @property integer $estructura_padre_id
 * @property integer $autoridad_actual_id
 * @property integer $empleados_necesarios
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property TalentoHumano[] $talentoHumanos
 * @property TalentoHumano $autoridadActual
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 * @property EstructuraOrganizativa $estructuraPadre
 * @property EstructuraOrganizativa[] $estructuraOrganizativas
 * @property CargoNominal[] $cargoNominals
 */
class EstructuraOrganizativa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gestion_humana.estructura_organizativa';
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
			array('estructura_padre_id, autoridad_actual_id, empleados_necesarios, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('codigo, siglas', 'length', 'max'=>10),
			array('nombre', 'length', 'max'=>75),
			array('estatus', 'length', 'max'=>1),
			array('estatus', 'in', 'range'=>array('A', 'I', 'E'), 'allowEmpty'=>false, 'strict'=>true,),
			array('usuario_ini_id', 'default', 'value'=>Yii::app()->user->id, 'on'=>'insert'),
			array('usuario_act_id', 'default', 'value'=>Yii::app()->user->id, 'on'=>'update'),
			array('descripcion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, codigo, nombre, siglas, descripcion, estructura_padre_id, autoridad_actual_id, empleados_necesarios, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, estatus', 'safe', 'on'=>'search'),
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
			'talentoHumanos' => array(self::HAS_MANY, 'TalentoHumano', 'estructura_organizativa_actual_id'),
			'autoridadActual' => array(self::BELONGS_TO, 'TalentoHumano', 'autoridad_actual_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
			'estructuraPadre' => array(self::BELONGS_TO, 'EstructuraOrganizativa', 'estructura_padre_id'),
			'estructuraOrganizativas' => array(self::HAS_MANY, 'EstructuraOrganizativa', 'estructura_padre_id'),
			'cargoNominals' => array(self::HAS_MANY, 'CargoNominal', 'estructura_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codigo' => 'Codigo',
			'nombre' => 'Nombre',
			'siglas' => 'Siglas',
			'descripcion' => 'Descripcion',
			'estructura_padre_id' => 'Estructura Padre',
			'autoridad_actual_id' => 'Autoridad Actual',
			'empleados_necesarios' => 'Empleados Necesarios',
			'usuario_ini_id' => 'Usuario Ini',
			'fecha_ini' => 'Fecha Ini',
			'usuario_act_id' => 'Usuario Act',
			'fecha_act' => 'Fecha Act',
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
		if(strlen($this->codigo)>0) $criteria->compare('codigo',$this->codigo,true);
		if(strlen($this->nombre)>0) $criteria->compare('nombre',$this->nombre,true);
		if(strlen($this->siglas)>0) $criteria->compare('siglas',$this->siglas,true);
		if(strlen($this->descripcion)>0) $criteria->compare('descripcion',$this->descripcion,true);
		if(is_numeric($this->estructura_padre_id)) $criteria->compare('estructura_padre_id',$this->estructura_padre_id);
		if(is_numeric($this->autoridad_actual_id)) $criteria->compare('autoridad_actual_id',$this->autoridad_actual_id);
		if(is_numeric($this->empleados_necesarios)) $criteria->compare('empleados_necesarios',$this->empleados_necesarios);
		if(is_numeric($this->usuario_ini_id)) $criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		if(Utiles::isValidDate($this->fecha_ini, 'y-m-d')) $criteria->compare('fecha_ini',$this->fecha_ini);
		// if(strlen($this->fecha_ini)>0) $criteria->compare('fecha_ini',$this->fecha_ini,true);
		if(is_numeric($this->usuario_act_id)) $criteria->compare('usuario_act_id',$this->usuario_act_id);
		if(Utiles::isValidDate($this->fecha_act, 'y-m-d')) $criteria->compare('fecha_act',$this->fecha_act);
		// if(strlen($this->fecha_act)>0) $criteria->compare('fecha_act',$this->fecha_act,true);
		if(in_array($this->estatus, array('A', 'I', 'E'))) $criteria->compare('estatus',$this->estatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        
        public function beforeInsert()
	{
            $this->fecha_ini = date('Y-m-d H:i:s');
            $this->usuario_ini_id = Yii::app()->user->id;
            $this->fecha_act = date('Y-m-d H:i:s');
            $this->usuario_act_id = Yii::app()->user->id;
	}
        
        public function beforeUpdate()
	{
            $this->fecha_act = date('Y-m-d H:i:s');
            $this->usuario_act_id = Yii::app()->user->id;
	}
        
        public function beforeDelete(){
            $this->fecha_act = date('Y-m-d H:i:s');
            $this->usuario_act_id = Yii::app()->user->id;
            // $this->fecha_eli = $this->fecha_act;
            $this->estatus = 'I';
        }
        
        public function beforeActivate(){
            $this->fecha_act = date('Y-m-d H:i:s');
            $this->usuario_act_id = Yii::app()->user->id;
            $this->estatus = 'A';
        }
        
        public function __toString() {
            try {
                return (string) $this->id;
            } catch (Exception $exception) {
                return $exception->getMessage();
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EstructuraOrganizativa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
