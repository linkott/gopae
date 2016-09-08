<?php

/**
 * This is the model class for table "auditoria.control_zona_educativa".
 *
 * The followings are the available columns in table 'auditoria.control_zona_educativa':
 * @property integer $id
 * @property integer $zona_educativa_id
 * @property string $actividad
 * @property string $observacion
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $usuarioAct
 * @property UsergroupsUser $usuarioIni
 */
class ControlZonaEducativa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'auditoria.control_zona_educativa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zona_educativa_id, actividad, observacion, fecha_ini', 'required'),
			array('zona_educativa_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('actividad', 'length', 'max'=>120),
			array('estatus', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, zona_educativa_id, actividad, observacion, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, estatus', 'safe', 'on'=>'search'),
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
			'usuarioAct' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_act_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'UsergroupsUser', 'usuario_ini_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'zona_educativa_id' => 'Zona Educativa',
			'actividad' => 'Descripción de la Actividad de la Que se está haciendo Control a las Zonas Educativas',
			'observacion' => 'Observación luego de efectuar el control a la Zona Educativa en la Actividad Descrita',
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

            $criteria->compare('id',$this->id);
            if(is_numeric($this->zona_educativa_id)){
                $criteria->compare('zona_educativa_id',$this->zona_educativa_id);
            }
            $criteria->compare('actividad',$this->actividad,true);
            $criteria->compare('observacion',$this->observacion,true);
            $criteria->compare('usuario_ini_id',$this->usuario_ini_id);
            $criteria->compare('fecha_ini',$this->fecha_ini,true);
            $criteria->compare('usuario_act_id',$this->usuario_act_id);
            $criteria->compare('fecha_act',$this->fecha_act,true);
            $criteria->compare('estatus',$this->estatus,true);

            $criteria->order = 'fecha_ini DESC';
            $criteria->with = array(
                "usuarioIni" => array("select" => "id, nombre, apellido, username, cedula"),
            );
            
            return $this->model()->findAll($criteria);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ControlZonaEducativa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
