<?php

/**
 * This is the model class for table "administrativo.detalle_nota_entrega".
 *
 * The followings are the available columns in table 'administrativo.detalle_nota_entrega':
 * @property integer $id
 * @property integer $alimento_id
 * @property string $cantidad
 * @property string $precio
 * @property integer $nota_entrega_id
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
 * @property NotaEntrega $notaEntrega
 */
class DetalleNotaEntrega extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'administrativo.detalle_nota_entrega';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alimento_id, cantidad, precio, nota_entrega_id, usuario_ini_id, fecha_ini', 'required'),
			array('alimento_id, nota_entrega_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('estatus', 'length', 'max'=>1),
			array('fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, alimento_id, cantidad, precio, nota_entrega_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'notaEntrega' => array(self::BELONGS_TO, 'NotaEntrega', 'nota_entrega_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'alimento_id' => 'Alimento',
			'cantidad' => 'Cantidad',
			'precio' => 'Precio',
			'nota_entrega_id' => 'Nota Entrega',
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
		$criteria->compare('alimento_id',$this->alimento_id);
		$criteria->compare('cantidad',$this->cantidad,true);
		$criteria->compare('precio',$this->precio,true);
		$criteria->compare('nota_entrega_id',$this->nota_entrega_id);
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
	 * @return DetalleNotaEntrega the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
