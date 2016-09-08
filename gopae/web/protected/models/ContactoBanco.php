<?php

/**
 * This is the model class for table "administrativo.contacto_banco".
 *
 * The followings are the available columns in table 'administrativo.contacto_banco':
 * @property integer $id
 * @property integer $banco_id
 * @property string $nombre_apellido
 * @property string $telefono_fijo
 * @property string $telefono_fax
 * @property string $telefono_celular
 * @property string $identificador
 * @property string $observaciones
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Banco $banco
 * @property UsergroupsUser $usuarioIni
 * @property UsergroupsUser $usuarioAct
 */
class ContactoBanco extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'administrativo.contacto_banco';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('banco_id, nombre_apellido, telefono_fijo, usuario_ini_id, fecha_ini, identificador', 'required'),
			array('banco_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('nombre_apellido', 'length', 'max'=>160),
                        array('correo', 'length', 'max'=>120),
                        array('correo', 'email'),
			array('telefono_fijo, telefono_fax, telefono_celular', 'length', 'max'=>20),
			array('identificador', 'length', 'max'=>40),
			array('estatus', 'length', 'max'=>1),
			array('estatus', 'in', 'range'=>array('A', 'I', 'E'), 'allowEmpty'=>false, 'strict'=>true,),
			array('usuario_ini_id', 'default', 'value'=>Yii::app()->user->id, 'on'=>'insert'),
			array('usuario_act_id', 'default', 'value'=>Yii::app()->user->id, 'on'=>'update'),
			array('observaciones', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, banco_id, nombre_apellido, telefono_fijo, telefono_fax, telefono_celular, identificador, observaciones, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus, correo', 'safe', 'on'=>'search'),
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
			'banco' => array(self::BELONGS_TO, 'Banco', 'banco_id'),
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
			'banco_id' => 'Banco',
			'nombre_apellido' => 'Nombre Completo',
			'telefono_fijo' => 'Telefono Fijo',
			'telefono_fax' => 'Telefono Fax',
			'telefono_celular' => 'Telefono Celular',
			'identificador' => 'Cargo',
			'observaciones' => 'Observaciones',
			'usuario_ini_id' => 'Usuario Ini',
			'fecha_ini' => 'Fecha Ini',
			'usuario_act_id' => 'Usuario Act',
			'fecha_act' => 'Fecha Act',
			'fecha_elim' => 'Fecha Elim',
			'estatus' => 'Estatus',
                        'correo' => 'Correo electronico',
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
		if(is_numeric($this->banco_id)) $criteria->compare('banco_id',$this->banco_id);
		if(strlen($this->nombre_apellido)>0) $criteria->compare('nombre_apellido',$this->nombre_apellido,true);
		if(strlen($this->telefono_fijo)>0) $criteria->compare('telefono_fijo',$this->telefono_fijo,true);
		if(strlen($this->telefono_fax)>0) $criteria->compare('telefono_fax',$this->telefono_fax,true);
		if(strlen($this->telefono_celular)>0) $criteria->compare('telefono_celular',$this->telefono_celular,true);
		if(strlen($this->identificador)>0) $criteria->compare('identificador',$this->identificador,true);
		if(strlen($this->observaciones)>0) $criteria->compare('observaciones',$this->observaciones,true);
                if(strlen($this->correo)>0) $criteria->compare('correo',$this->correo,true);
		if(is_numeric($this->usuario_ini_id)) $criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		if(Utiles::isValidDate($this->fecha_ini, 'y-m-d')) $criteria->compare('fecha_ini',$this->fecha_ini);
		// if(strlen($this->fecha_ini)>0) $criteria->compare('fecha_ini',$this->fecha_ini,true);
		if(is_numeric($this->usuario_act_id)) $criteria->compare('usuario_act_id',$this->usuario_act_id);
		if(Utiles::isValidDate($this->fecha_act, 'y-m-d')) $criteria->compare('fecha_act',$this->fecha_act);
		// if(strlen($this->fecha_act)>0) $criteria->compare('fecha_act',$this->fecha_act,true);
		if(Utiles::isValidDate($this->fecha_elim, 'y-m-d')) $criteria->compare('fecha_elim',$this->fecha_elim);
		// if(strlen($this->fecha_elim)>0) $criteria->compare('fecha_elim',$this->fecha_elim,true);
		if(in_array($this->estatus, array('A', 'I', 'E'))) $criteria->compare('estatus',$this->estatus,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function deleteCacheContactoBanco($bancoId){
            Yii::app()->cache->delete($this->getIndexCacheContactoBanco($bancoId));
        }
        
        public function getIndexCacheContactoBanco($bancoId){
            return "C:$bancoId";
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
                return (string) $this->nombre_apellido;
            } catch (Exception $exception) {
                return $exception->getMessage();
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactoBanco the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
