<?php

/**
 * This is the model class for table "sistema.log_usuario".
 *
 * The followings are the available columns in table 'sistema.log_usuario':
 * @property string $id
 * @property string $tipo
 * @property string $controlador
 * @property string $accion
 * @property string $descripcion
 * @property string $direccion_ip
 * @property string $fecha_ini
 * @property integer $usuario_ini_id
 * @property string $fecha_act
 * @property integer $usuario_act_id
 * @property string $fecha_eli
 * @property string $direccion_ip_proxy
 *
 * The followings are the available model relations:
 * @property Usuario $usuarioAct
 * @property Usuario $usuarioIni
 */
class LogUsuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sistema.log_usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo, controlador, accion, descripcion, direccion_ip, fecha_ini, usuario_ini_id, fecha_act', 'required'),
			array('usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('tipo', 'length', 'max'=>10),
			array('controlador, accion', 'length', 'max'=>150),
			array('descripcion', 'length', 'max'=>255),
			array('direccion_ip', 'length', 'max'=>25),
			array('direccion_ip_proxy', 'length', 'max'=>40),
			array('fecha_eli', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tipo, controlador, accion, descripcion, direccion_ip, fecha_ini, usuario_ini_id, fecha_act, usuario_act_id, fecha_eli, direccion_ip_proxy', 'safe', 'on'=>'search'),
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
			'usuarioAct' => array(self::BELONGS_TO, 'Usuario', 'usuario_act_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipo' => 'Tipo de Log. ERROR, ALERTA, EXCEPCION, INFO',
			'controlador' => 'Nombre del controlador',
			'accion' => 'Accion del Log. Acción del Controlador',
			'descripcion' => 'Descripción breve del Log',
			'direccion_ip' => 'Dirección IP del Usuario',
			'fecha_ini' => 'Fecha en la que se Registró el Log Por Primera Vez',
			'usuario_ini_id' => 'Primer id del usuario que Registró los datos del Log',
			'fecha_act' => 'Fecha en la que se Actualizo el Log Por Última Vez',
			'usuario_act_id' => 'Último id del usuario que modifico los datos del Log',
			'fecha_eli' => 'Fecha Eli',
			'direccion_ip_proxy' => 'Dirección IP de Proxy',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('controlador',$this->controlador,true);
		$criteria->compare('accion',$this->accion,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('direccion_ip',$this->direccion_ip,true);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('fecha_act',$this->fecha_act,true);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('fecha_eli',$this->fecha_eli,true);
		$criteria->compare('direccion_ip_proxy',$this->direccion_ip_proxy,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogUsuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
