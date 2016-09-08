<?php

/**
 * This is the model class for table "gplantel.zona_educativa".
 *
 * The followings are the available columns in table 'gplantel.zona_educativa':
 * @property integer $id
 * @property string $nombre
 * @property integer $estado_id
 * @property integer $municipio_id
 * @property integer $parroquia_id
 * @property string $direccion_referencial
 * @property string $telefono_fijo
 * @property string $telefono_otro
 * @property string $correo
 * @property integer $jefe_actual_id
 * @property integer $usuario_ini_id
 * @property string $fecha_ini
 * @property integer $usuario_act_id
 * @property string $fecha_act
 * @property string $fecha_elim
 * @property string $estatus
 *
 * The followings are the available model relations:
 * @property Usuario $usuarioAct
 * @property Usuario $estado
 * @property Usuario $usuarioIni
 * @property Usuario $jefeActual
 * @property Municipio $municipio
 * @property Parroquia $parroquia
 * @property UsuarioZonaEdu[] $usuarioZonaEdus
 * @property Plantel[] $plantels
 */
class ZonaEducativa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gplantel.zona_educativa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, estado_id, direccion_referencial, telefono_fijo, jefe_actual_id, usuario_ini_id, fecha_ini', 'required'),
                        array('nombre, estado_id','unique', 'message' => 'El Estado seleccionado ya ha sido utilizado.'),
			array('estado_id, municipio_id, parroquia_id, jefe_actual_id, usuario_ini_id, usuario_act_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>60),
			array('telefono_fijo, telefono_otro', 'length', 'max'=>30, 'min'=>30),
			array('correo', 'length', 'max'=>100, 'min'=>30),
			array('estatus', 'length', 'max'=>20),
			array('fecha_act, fecha_elim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, estado_id, municipio_id, parroquia_id, direccion_referencial, telefono_fijo, telefono_otro, correo, jefe_actual_id, usuario_ini_id, fecha_ini, usuario_act_id, fecha_act, fecha_elim, estatus', 'safe', 'on'=>'search'),
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
			'Zestado' => array(self::BELONGS_TO, 'Estado', 'estado_id'),
			'usuarioIni' => array(self::BELONGS_TO, 'Usuario', 'usuario_ini_id'),
			'jefeActual' => array(self::BELONGS_TO, 'Usuario', 'jefe_actual_id'),
			'municipio' => array(self::BELONGS_TO, 'Municipio', 'municipio_id'),
			'parroquia' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_id'),
			'usuarioZonaEdus' => array(self::HAS_MANY, 'UsuarioZonaEdu', 'zona_educativa_id'),
			'plantels' => array(self::HAS_MANY, 'Plantel', 'zona_educativa_id'),
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
			'estado_id' => 'Estado',
			'municipio_id' => 'Municipio',
			'parroquia_id' => 'Parroquia',
			'direccion_referencial' => 'Dirección Referencial',
			'telefono_fijo' => 'Teléfono Fijo',
			'telefono_otro' => 'Teléfono Adicional',
			'correo' => 'Correo',
			'jefe_actual_id' => 'Jefe Actual',
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
        
        
        /*
         * Funcion para mostrar los datos detallados de la zona educativa seleccionada
         */
        public function detallesZona($id)
	{
        $usuario = Yii::app()->user->id;
      

        $sql = "select usuario_id, u.email, u.telefono, u.telefono_celular, z.nombre as z_nombre, u.nombre, u.apellido, e.nombre as estado_nombre from gplantel.zona_educativa z inner join gplantel.autoridad_zona_educativa a on z.id=a.zona_educativa_id inner join estado e on z.estado_id=e.id inner join seguridad.usergroups_user u on a.usuario_id=u.id where z.id=:id ";

        $guard = Yii::app()->db->createCommand($sql);
        $guard->bindParam(":id", $id, PDO::PARAM_INT);
       
        $resultadoGuardo = $guard->queryAll();
       // var_dump($resultadoGuardo);die();
        return $resultadoGuardo;
            
        }
        
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
                $criteria->addSearchCondition('t.nombre', '%' . $this->nombre . '%', false, 'AND', 'ILIKE');
		//$criteria->compare('nombre',$this->nombre);
                
		$criteria->compare('estado_id',$this->estado_id);
//                    if (is_numeric($this->estado_id)) {
//                        if (strlen($this->estado_id) < 10) {
//                        $criteria->compare('t.estado_id', $this->estado_id);
//                        }   
//                    }
		$criteria->compare('municipio_id',$this->municipio_id);
		$criteria->compare('parroquia_id',$this->parroquia_id);
		$criteria->compare('direccion_referencial',$this->direccion_referencial,true);
		$criteria->compare('telefono_fijo',$this->telefono_fijo,true);
		$criteria->compare('telefono_otro',$this->telefono_otro,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('jefe_actual_id',$this->jefe_actual_id);
		$criteria->compare('usuario_ini_id',$this->usuario_ini_id);
		$criteria->compare('fecha_ini',$this->fecha_ini,true);
		$criteria->compare('usuario_act_id',$this->usuario_act_id);
		$criteria->compare('fecha_act',$this->fecha_act,true);
		$criteria->compare('fecha_elim',$this->fecha_elim,true);
		$criteria->compare('estatus',$this->estatus,true);
                  $sort = new CSort();

                $sort->defaultOrder = 'nombre ASC';

                return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => $sort
                ));
	}
        
        
        public function getZonasEducativasActivas(){
            $sql = "SELECT z.id, z.nombre, z.estado_id, z.estatus FROM gplantel.zona_educativa z WHERE z.estatus = 'A'";
            $commandBusqueda = $this->getDbConnection()->createCommand($sql);
            $result = $commandBusqueda->queryAll(); // Devuelve 1 si encuentra el registro, sino no lo encuentra devuelve 0
            return $result;
        }
        
	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ZonaEducativa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         *
         * @param type $usuarioId
         * @param type $zonaId
         * @param type $seguro
         * @return null|array
         */
        public function validarAutoridad($usuarioId, $zonaId, $seguro = true) {
            $resultado = AutoridadZonaEducativa::model()->validarUsuarioEnZona($usuarioId, $zonaId);
            //var_dump($resultado); die();
            return $resultado;
        }
}
