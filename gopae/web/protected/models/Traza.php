<?php

/**
 * This is the model class for table "auditoria.traza".
 *
 * The followings are the available columns in table 'auditoria.traza':
 * @property string $id_traza
 * @property string $fecha_hora
 * @property string $ip_maquina
 * @property string $tipo_transaccion
 * @property string $modulo
 * @property string $resultado_transaccion
 * @property string $descripcion
 * @property string $username
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property UsergroupsUser $user
 */
class Traza extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'auditoria.traza';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_hora', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('ip_maquina', 'length', 'max'=>40),
			array('tipo_transaccion', 'length', 'max'=>50),
			array('modulo', 'length', 'max'=>150),
			array('resultado_transaccion', 'length', 'max'=>10),
			array('username', 'length', 'max'=>25),
			array('descripcion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_traza, fecha_hora, ip_maquina, tipo_transaccion, modulo, resultado_transaccion, descripcion, username, user_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'UsergroupsUser', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_traza' => 'Id Traza',
			'fecha_hora' => 'Fecha Hora',
			'ip_maquina' => 'Ip Maquina',
			'tipo_transaccion' => 'Tipo Transaccion',
			'modulo' => 'Modulo',
			'resultado_transaccion' => 'Resultado Transaccion',
			'descripcion' => 'Descripcion',
			'username' => 'Username',
			'user_id' => 'User',
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


		$criteria->compare('id_traza',$this->id_traza,true);
		$criteria->compare('fecha_hora',$this->fecha_hora,true);
		$criteria->compare('ip_maquina',$this->ip_maquina,true);
		$criteria->compare('tipo_transaccion',$this->tipo_transaccion,true);
		$criteria->compare('modulo',$this->modulo,true);
		$criteria->compare('resultado_transaccion',$this->resultado_transaccion,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('user_id',$this->user_id);


                  if (strlen($this->fecha_hora) > 0 && Utiles::dateCheck($this->fecha_hora)) {
            $this->fecha_traza = Utiles::transformDate($this->fecha_hora);
            $criteria->addSearchCondition("TO_CHAR(t.fecha_ini, 'YYYY-MM-DD')", $this->fecha_hora, false, 'AND', '=');
        } else {
            $this->fecha_hora='';
        }

//        var_dump($this->fecha_ini);
//        die();

        $sort = new CSort();
        $sort->defaultOrder = 'id_traza DESC, fecha_traza DESC';

                
   
        $criteria->addSearchCondition('LOWER(tipo_transaccion)', strtolower($this->tipo_transaccion), true);
        $criteria->addSearchCondition('LOWER(modulo)', strtolower($this->modulo), true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
               
    }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
