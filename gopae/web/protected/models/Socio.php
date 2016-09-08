<?php

/**
 * This is the model class for table "proveduria.socio".
 *
 * The followings are the available columns in table 'proveduria.socio':
 * @property integer $id
 * @property string $rif
 * @property string $nombres
 * @property string $apellidos
 * @property integer $certificado_salud
 * @property integer $proveedor_id
 * @property string $telefono_celular
 * @property string $correo
 * @property integer $tipo_socio
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
 * @property Proveedor $proveedor
 */
class Socio extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'proveduria.socio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rif, nombres, apellidos, certificado_salud', 'required'),
                        array('rif', 'unique'),
			array('certificado_salud, proveedor_id, tipo_socio, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('rif', 'length', 'max'=>14),
			array('nombres, apellidos', 'length', 'max'=>50),
			array('telefono_celular', 'length', 'max'=>21),
			array('correo', 'length', 'max'=>150),
			array('estatus', 'length', 'max'=>1),
			array('fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rif, nombres, apellidos, certificado_salud, proveedor_id, telefono_celular, correo, tipo_socio, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'proveedor' => array(self::BELONGS_TO, 'Proveedor', 'proveedor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rif' => 'Rif',
			'nombres' => 'Nombres',
			'apellidos' => 'Apellidos',
			'certificado_salud' => 'Certificado Salud',
			'proveedor_id' => 'Proveedor',
			'telefono_celular' => 'Telefono Celular',
			'correo' => 'Correo',
			'tipo_socio' => 'Tipo Socio',
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
                $proveedor_id = base64_decode($_REQUEST['id']);
                if($proveedor_id == null) {
                    $proveedor_id = 0;
                }
//                if(isset($_REQUEST[]))
//                var_dump($proveedor_id);
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('rif',$this->rif,true);
                $criteria->addSearchCondition('t.nombres', '%' . $this->nombres . '%', false, 'AND', 'ILIKE');
//		$criteria->compare('nombres',$this->nombres,true);
		$criteria->compare('apellidos',$this->apellidos,true);
		$criteria->compare('certificado_salud',$this->certificado_salud);
		$criteria->compare('proveedor_id', $proveedor_id);
		$criteria->compare('telefono_celular',$this->telefono_celular,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('tipo_socio',$this->tipo_socio);
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

        public function eliminarSocio($id) {

            $usuario_id = Yii::app()->user->id;
            $estatus = 'E';
            $fecha = date('Y-m-d H:i:s');

            $sql = "UPDATE proveduria.socio
                        SET estatus=:estatus, fecha_elim=:fecha_elim, usuario_act_id=:usuario_act_id
                        WHERE id=:id ";
            $guard = Yii::app()->db->createCommand($sql);

            $guard->bindParam(":usuario_act_id", $usuario_id, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":fecha_elim", $fecha, PDO::PARAM_INT);
            $guard->bindParam(":id", $id, PDO::PARAM_INT);
            $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando actualiza y 0 cuando no actualiza
            // var_dump($resulatadoGuardo); die();
            return $resulatadoGuardo;
        }

        public function activarSocio($id) {

            $usuario_id = Yii::app()->user->id;
            $estatus = 'A';
            $fecha_ini = date('Y-m-d H:i:s');
            $fecha_elim = null;
            $fecha_act = null;
            $usuarioAct = null;

            $sql = "UPDATE proveduria.socio
                        SET estatus=:estatus, fecha_act=:fecha_act, usuario_ini_id=:usuario_ini_id, fecha_ini=:fecha_ini, fecha_elim=:fecha_elim, usuario_act_id=:usuario_act_id
                        WHERE id=:id ";
            $guard = Yii::app()->db->createCommand($sql);

            $guard->bindParam(":usuario_ini_id", $usuario_id, PDO::PARAM_INT);
            $guard->bindParam(":usuario_act_id", $usuarioAct, PDO::PARAM_INT);
            $guard->bindParam(":estatus", $estatus, PDO::PARAM_STR);
            $guard->bindParam(":fecha_act", $fecha_act, PDO::PARAM_INT);
            $guard->bindParam(":fecha_ini", $fecha_ini, PDO::PARAM_INT);
            $guard->bindParam(":fecha_elim", $fecha_elim, PDO::PARAM_INT);
            $guard->bindParam(":id", $id, PDO::PARAM_INT);
            $resulatadoGuardo = $guard->execute(); //devuelve 1 cuando actualiza y 0 cuando no actualiza
            // var_dump($resulatadoGuardo); die();
            return $resulatadoGuardo;
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Socio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
